<?php

namespace App\Livewire;

use App\Models\SponsorMessageThread;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class MessagesChat extends Component
{
    use WithFileUploads;

    public string $newMessage = '';
    public $attachment = null;

    public int    $threadId    = 0;
    public array  $messages    = [];
    public int    $unreadCount = 0;
    public string $subject     = 'Support';

    /** Pre-built quick-reply suggestions shown above the input. */
    public array $quickReplies = [
        ['icon' => 'fa-key',            'label' => 'Change password',       'text' => 'I would like to change my account password. Can you please help me with this?'],
        ['icon' => 'fa-child-reaching', 'label' => "Child not found",       'text' => "I cannot find my sponsored child's profile. Could you help me locate their account?"],
        ['icon' => 'fa-heart',          'label' => 'Sponsor another',       'text' => 'I am interested in sponsoring another child or family. How can I proceed?'],
        ['icon' => 'fa-stethoscope',    'label' => 'Child wellbeing',       'text' => 'I would like an update on how my sponsored child is doing. Are they well?'],
    ];

    /* ── Lifecycle ─────────────────────────────────────────────── */

    public function mount(): void
    {
        $sponsor = Auth::guard('sponsor')->user();

        $thread = SponsorMessageThread::firstOrCreate(
            ['sponsor_id' => $sponsor->id, 'entity_type' => 'general', 'entity_id' => null],
            ['subject' => 'Support']
        );

        $this->threadId = $thread->id;
        $this->subject  = $thread->subject ?? 'Support';

        $this->loadMessages();
        $this->markRead();
    }

    /* ── Public actions ─────────────────────────────────────────── */

    /** Called every 4 s by wire:poll — refresh messages silently. */
    public function poll(): void
    {
        $prevCount = count($this->messages);
        $this->loadMessages();

        if ($this->unreadCount > 0) {
            $this->markRead();
        }

        if (count($this->messages) !== $prevCount) {
            $this->dispatch('new-messages');
        }
    }

    /** Populate the textarea from a quick-reply chip. */
    public function useQuickReply(int $index): void
    {
        $this->newMessage = $this->quickReplies[$index]['text'] ?? '';
        $this->dispatch('focus-input');
    }

    public function sendMessage(): void
    {
        $this->validate([
            'newMessage' => 'required_without:attachment|nullable|string|max:4000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,webp,gif',
        ]);

        if (!$this->newMessage && !$this->attachment) {
            return;
        }

        $thread = SponsorMessageThread::findOrFail($this->threadId);

        /* ── Attachment handling ──────────────────────────────── */
        $attachPath = null;
        $attachName = null;
        $attachSize = null;
        $isImage    = false;

        if ($this->attachment) {
            $this->ensureChatDir();

            $ext      = strtolower($this->attachment->getClientOriginalExtension());
            $isImage  = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            $tempPath = $this->attachment->getRealPath();

            if ($isImage) {
                $filename  = 'img_' . uniqid() . '.webp';
                $destPath  = public_path('images/chat/' . $filename);
                $converted = $this->convertToWebp($tempPath, $destPath);

                // Fallback: copy as-is if GD unavailable
                if (!$converted) {
                    copy($tempPath, $destPath);
                }

                $attachPath = 'images/chat/' . $filename;
                $attachName = $filename;
                $attachSize = $this->formatFileSize(filesize($destPath));
            } else {
                $filename   = 'file_' . uniqid() . '.' . $ext;
                $destPath   = public_path('images/chat/' . $filename);
                copy($tempPath, $destPath);

                $attachPath = 'images/chat/' . $filename;
                $attachName = $this->attachment->getClientOriginalName();
                $attachSize = $this->formatFileSize(filesize($destPath));
            }
        }

        /* ── Link preview ─────────────────────────────────────── */
        $linkPreview = null;
        if ($this->newMessage) {
            preg_match('/https?:\/\/[^\s\'"<>]+/', $this->newMessage, $m);
            if (!empty($m[0])) {
                $linkPreview = $this->fetchLinkPreview($m[0]);
            }
        }

        $thread->messages()->create([
            'sender'          => 'sponsor',
            'body'            => $this->newMessage,
            'attachment_path' => $attachPath,
            'attachment_name' => $attachName,
            'attachment_size' => $attachSize,
            'is_image'        => $isImage,
            'link_preview'    => $linkPreview ? json_encode($linkPreview) : null,
            'read_at'         => now(),
        ]);

        $thread->touch();

        $this->newMessage = '';
        $this->attachment = null;

        $this->loadMessages();
        $this->dispatch('scroll-bottom');
    }

    public function markRead(): void
    {
        SponsorMessageThread::findOrFail($this->threadId)
            ->messages()
            ->where('sender', '!=', 'sponsor')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->unreadCount = 0;
    }

    /* ── Render ─────────────────────────────────────────────────── */

    public function render()
    {
        return view('livewire.messages-chat');
    }

    /* ── Private helpers ────────────────────────────────────────── */

    private function loadMessages(): void
    {
        $rows = SponsorMessageThread::findOrFail($this->threadId)
            ->messages()
            ->orderBy('created_at', 'asc')
            ->get();

        $this->messages = $rows->map(fn ($msg) => [
            'id'              => $msg->id,
            'sender'          => $msg->sender,
            'body'            => $msg->body,
            'created_at'      => $msg->created_at?->toISOString(),
            'read_at'         => $msg->read_at?->toISOString(),
            'attachment_url'  => $msg->attachment_path ? asset($msg->attachment_path) : null,
            'attachment_name' => $msg->attachment_name,
            'attachment_size' => $msg->attachment_size,
            'is_image'        => (bool) ($msg->is_image ?? false),
            'link_preview'    => $msg->link_preview
                ? (is_string($msg->link_preview)
                    ? json_decode($msg->link_preview, true)
                    : $msg->link_preview)
                : null,
        ])->values()->toArray();

        $this->unreadCount = $rows
            ->where('sender', '!=', 'sponsor')
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Convert any supported image to WebP via PHP GD.
     */
    private function convertToWebp(string $srcPath, string $destPath): bool
    {
        if (!function_exists('imagewebp')) {
            return false;
        }

        $info = @getimagesize($srcPath);
        if (!$info) return false;

        $image = match ($info['mime']) {
            'image/jpeg' => @imagecreatefromjpeg($srcPath),
            'image/png'  => @imagecreatefrompng($srcPath),
            'image/gif'  => @imagecreatefromgif($srcPath),
            'image/webp' => @imagecreatefromwebp($srcPath),
            default      => false,
        };

        if (!$image) return false;

        if ($info['mime'] === 'image/png') {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        $ok = imagewebp($image, $destPath, 82);
        imagedestroy($image);
        return $ok;
    }

    /**
     * Fetch Open Graph metadata for a URL.
     */
    private function fetchLinkPreview(string $url): ?array
    {
        try {
            $ctx  = stream_context_create(['http' => [
                'timeout'         => 4,
                'user_agent'      => 'Mozilla/5.0 (compatible; LinkPreviewBot/1.0)',
                'follow_location' => true,
            ]]);
            $html = @file_get_contents($url, false, $ctx);
            if (!$html) return null;

            // Parse og: meta tag — supports both attribute orders
            $og = function (string $prop) use ($html): ?string {
                foreach ([
                    '/<meta[^>]+property=["\']og:' . $prop . '["\'][^>]+content=["\']([^"\']+)["\'][^>]*>/i',
                    '/<meta[^>]+content=["\']([^"\']+)["\'][^>]+property=["\']og:' . $prop . '["\'][^>]*>/i',
                ] as $pattern) {
                    if (preg_match($pattern, $html, $m)) {
                        return trim(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5));
                    }
                }
                return null;
            };

            $title = $og('title');
            if (!$title) {
                preg_match('/<title[^>]*>([^<]+)<\/title>/i', $html, $t);
                $title = isset($t[1]) ? trim(html_entity_decode($t[1], ENT_QUOTES | ENT_HTML5)) : null;
            }

            $host = parse_url($url, PHP_URL_HOST) ?? $url;

            return [
                'url'         => $url,
                'host'        => preg_replace('/^www\./', '', $host),
                'title'       => $title ? mb_substr($title, 0, 120) : $host,
                'description' => $og('description') ? mb_substr($og('description'), 0, 200) : null,
                'image'       => $og('image'),
            ];
        } catch (\Throwable) {
            return null;
        }
    }

    /** Ensure public/images/chat directory exists. */
    private function ensureChatDir(): void
    {
        $dir = public_path('images/chat');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1_048_576) return round($bytes / 1_048_576, 1) . ' MB';
        if ($bytes >= 1_024)     return round($bytes / 1_024) . ' KB';
        return $bytes . ' B';
    }
}