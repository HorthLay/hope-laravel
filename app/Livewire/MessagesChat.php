<?php

namespace App\Livewire;

use App\Models\SponsorMessageThread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class MessagesChat extends Component
{
    use WithFileUploads;

    public string $newMessage = '';
    public $attachment        = null;

    public int    $threadId      = 0;
    public array  $messages      = [];
    public int    $unreadCount   = 0;
    public string $subject       = 'Support';

    /* ── Spam-feedback properties (read by Blade) ─────────────── */
    public string $spamError     = '';
    public int    $rateRemaining = 5;
    public int    $cooldownLeft  = 0;

    public array $quickReplies = [
        ['icon' => 'fa-key',            'label' => 'Change password',  'text' => 'I would like to change my account password. Can you please help me with this?'],
        ['icon' => 'fa-child-reaching', 'label' => "Child not found",  'text' => "I cannot find my sponsored child's profile. Could you help me locate their account?"],
        ['icon' => 'fa-heart',          'label' => 'Sponsor another',  'text' => 'I am interested in sponsoring another child or family. How can I proceed?'],
        ['icon' => 'fa-stethoscope',    'label' => 'Child wellbeing',  'text' => 'I would like an update on how my sponsored child is doing. Are they well?'],
    ];

    /* ── Rate-limit config ──────────────────────────────────────── */
    private const RATE_WINDOW_SECONDS  = 60;
    private const MAX_MESSAGES_PER_MIN = 5;
    private const MAX_IMAGES_PER_MIN   = 3;
    private const MAX_FILES_PER_MIN    = 3;
    private const MIN_INTERVAL_SECONDS = 3;
    private const DUPLICATE_WINDOW_SEC = 120;
    private const MAX_DUPLICATES       = 2;

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
        $this->refreshRateInfo();
        $this->refreshCooldown();
    }

    /* ── Public actions ─────────────────────────────────────────── */

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

        $this->refreshRateInfo();
        $this->refreshCooldown();
    }

    public function useQuickReply(int $index): void
    {
        $this->newMessage = $this->quickReplies[$index]['text'] ?? '';
        $this->dispatch('focus-input');
    }

    public function sendMessage(): void
    {
        $this->spamError = '';

        $this->validate([
            'newMessage' => 'required_without:attachment|nullable|string|max:4000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,webp,gif',
        ]);

        if (!$this->newMessage && !$this->attachment) {
            return;
        }

        /* ── Spam guard ─────────────────────────────────────────── */
        $spamReason = $this->checkSpam();
        if ($spamReason) {
            $this->spamError = $spamReason;
            $this->refreshRateInfo();
            $this->refreshCooldown();

            /*
             * Dispatch WITH the current values as event payload.
             * Alpine catches this via x-on:spam-blocked.window and
             * uses $event.detail — no $wire property reads needed in JS.
             */
            $this->dispatch('spam-blocked',
                spamError:     $this->spamError,
                cooldownLeft:  $this->cooldownLeft,
                rateRemaining: $this->rateRemaining,
            );

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
                if (!$this->convertToWebp($tempPath, $destPath)) {
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

        $this->recordSend(hasAttachment: (bool) $this->attachment, isImage: $isImage);

        if ($this->newMessage) {
            $this->recordMessageText($this->newMessage);
        }

        $thread->touch();

        $this->newMessage = '';
        $this->attachment = null;

        $this->loadMessages();
        $this->refreshRateInfo();
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

    /* ── Anti-spam helpers ──────────────────────────────────────── */

    private function checkSpam(): ?string
    {
        $sponsorId = Auth::guard('sponsor')->id();
        $now       = now()->timestamp;

        // 1. Minimum send interval
        $lastSent = (int) Cache::get("chat_last_sent:{$sponsorId}", 0);
        $elapsed  = $now - $lastSent;
        if ($elapsed < self::MIN_INTERVAL_SECONDS) {
            $wait = self::MIN_INTERVAL_SECONDS - $elapsed;
            return "Please wait {$wait} second(s) before sending another message.";
        }

        // 2. Total message rate (sliding window)
        $msgTimes = $this->getWindowTimestamps("chat_msg_rate:{$sponsorId}", $now);
        if (count($msgTimes) >= self::MAX_MESSAGES_PER_MIN) {
            return 'You are sending messages too quickly. Please wait a moment before trying again.';
        }

        // 3. Attachment-specific rate limits
        if ($this->attachment) {
            $ext     = strtolower($this->attachment->getClientOriginalExtension());
            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);

            if ($isImage) {
                $imgTimes = $this->getWindowTimestamps("chat_img_rate:{$sponsorId}", $now);
                if (count($imgTimes) >= self::MAX_IMAGES_PER_MIN) {
                    return 'You have uploaded too many images recently. Please wait a minute before sending more.';
                }
            } else {
                $fileTimes = $this->getWindowTimestamps("chat_file_rate:{$sponsorId}", $now);
                if (count($fileTimes) >= self::MAX_FILES_PER_MIN) {
                    return 'You have uploaded too many files recently. Please wait a minute before sending more.';
                }
            }
        }

        // 4. Duplicate / repeated message
        if ($this->newMessage) {
            $hash     = md5(mb_strtolower(trim($this->newMessage)));
            $dupCount = (int) Cache::get("chat_dup:{$sponsorId}:{$hash}", 0);
            if ($dupCount >= self::MAX_DUPLICATES) {
                return 'You have already sent this message multiple times. Please write something different.';
            }
        }

        return null;
    }

    private function recordSend(bool $hasAttachment, bool $isImage): void
    {
        $sponsorId = Auth::guard('sponsor')->id();
        $now       = now()->timestamp;
        $ttl       = self::RATE_WINDOW_SECONDS + 5;

        Cache::put("chat_last_sent:{$sponsorId}", $now, $ttl);
        $this->pushTimestamp("chat_msg_rate:{$sponsorId}", $now, $ttl);

        if ($hasAttachment) {
            $key = $isImage ? "chat_img_rate:{$sponsorId}" : "chat_file_rate:{$sponsorId}";
            $this->pushTimestamp($key, $now, $ttl);
        }
    }

    private function recordMessageText(string $text): void
    {
        $sponsorId = Auth::guard('sponsor')->id();
        $hash      = md5(mb_strtolower(trim($text)));
        $key       = "chat_dup:{$sponsorId}:{$hash}";
        Cache::put($key, (int) Cache::get($key, 0) + 1, self::DUPLICATE_WINDOW_SEC);
    }

    private function refreshRateInfo(): void
    {
        $sponsorId = Auth::guard('sponsor')->id();
        $now       = now()->timestamp;
        $times     = $this->getWindowTimestamps("chat_msg_rate:{$sponsorId}", $now);
        $this->rateRemaining = max(0, self::MAX_MESSAGES_PER_MIN - count($times));
    }

    private function refreshCooldown(): void
    {
        $sponsorId = Auth::guard('sponsor')->id();
        $now       = now()->timestamp;
        $lastSent  = (int) Cache::get("chat_last_sent:{$sponsorId}", 0);
        $elapsed   = $now - $lastSent;

        $this->cooldownLeft = $elapsed < self::MIN_INTERVAL_SECONDS
            ? self::MIN_INTERVAL_SECONDS - $elapsed
            : 0;
    }

    /* ── Sliding-window cache helpers ───────────────────────────── */

    private function getWindowTimestamps(string $key, int $now): array
    {
        $times = Cache::get($key, []);
        return array_values(array_filter($times, fn ($t) => $t > $now - self::RATE_WINDOW_SECONDS));
    }

    private function pushTimestamp(string $key, int $now, int $ttl): void
    {
        $times   = $this->getWindowTimestamps($key, $now);
        $times[] = $now;
        Cache::put($key, array_values($times), $ttl);
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

    private function convertToWebp(string $srcPath, string $destPath): bool
    {
        if (!function_exists('imagewebp')) return false;
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

    private function fetchLinkPreview(string $url): ?array
    {
        try {
            $ctx  = stream_context_create(['http' => [
                'timeout' => 4, 'user_agent' => 'Mozilla/5.0', 'follow_location' => true,
            ]]);
            $html = @file_get_contents($url, false, $ctx);
            if (!$html) return null;

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

    private function ensureChatDir(): void
    {
        $dir = public_path('images/chat');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
    }

    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1_048_576) return round($bytes / 1_048_576, 1) . ' MB';
        if ($bytes >= 1_024)     return round($bytes / 1_024) . ' KB';
        return $bytes . ' B';
    }
}