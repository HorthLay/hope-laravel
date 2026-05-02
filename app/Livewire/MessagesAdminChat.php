<?php

namespace App\Livewire;

use App\Models\SponsorMessage;
use App\Models\SponsorMessageThread;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class MessagesAdminChat extends Component
{
    use WithFileUploads;

    /* ── State ─────────────────────────────────────────── */
    public array  $threads         = [];
    public int    $selectedId      = 0;
    public array  $messages        = [];
    public string $newMessage      = '';
    public        $attachment      = null;
    public string $search          = '';

    // Edit
    public int    $editingId  = 0;
    public string $editBody   = '';

    // Delete confirmation
    public int    $deleteConfirmId = 0;

    // Selected thread header info
    public string $activeSponsorName  = '';
    public string $activeSponsorEmail = '';
    public string $activeSponsorInit  = '';
    public string $activeSubject      = '';

    // Toast: tracks previous total unread so we only toast on NEW arrivals
    private int $prevTotalUnread = -1;

    /* ── Lifecycle ─────────────────────────────────────── */

    public function mount(): void
    {
        $this->loadThreads();
        // Capture baseline so first poll doesn't toast existing unread messages
        $this->prevTotalUnread = array_sum(array_column($this->threads, 'unread_count'));
    }

    /* ── Polling ─────────────────────────────────────────*/

    public function poll(): void
    {
        // Snapshot totals BEFORE reload
        $snapshot = [];
        foreach ($this->threads as $t) {
            $snapshot[$t['id']] = $t['unread_count'];
        }
        $prevTotal = array_sum($snapshot);

        $this->loadThreads();

        $newTotal = array_sum(array_column($this->threads, 'unread_count'));

        // Toast every thread that gained new unread messages
        if ($newTotal > $prevTotal) {
            foreach ($this->threads as $thread) {
                $was = $snapshot[$thread['id']] ?? 0;
                if ($thread['unread_count'] > $was) {
                    $this->dispatch('show-toast', [
                        'sponsorName' => $thread['sponsor_name'],
                        'sponsorInit' => $thread['sponsor_init'],
                        'threadId'    => $thread['id'],
                        'preview'     => $thread['last_message'],
                    ]);
                    break; // one toast at a time
                }
            }
        }

        // Refresh active thread messages
        if ($this->selectedId) {
            $prev = count($this->messages);
            $this->loadMessages($this->selectedId);
            if (count($this->messages) !== $prev) {
                $this->dispatch('new-messages');
            }
        }
    }

    /* ── Thread selection ─────────────────────────────── */

    public function selectThread(int $id): void
    {
        $this->selectedId = $id;
        $this->cancelEdit();
        $this->deleteConfirmId = 0;

        $thread = SponsorMessageThread::with('sponsor')->findOrFail($id);
        $this->activeSponsorName  = $thread->sponsor?->full_name ?? 'Unknown Sponsor';
        $this->activeSponsorEmail = $thread->sponsor?->email ?? '';
        $this->activeSponsorInit  = strtoupper(substr($thread->sponsor?->first_name ?? '?', 0, 1));
        $this->activeSubject      = $thread->subject ?? 'Support';

        $this->loadMessages($id);
        $this->markAdminReadAll($id);
        $this->dispatch('scroll-bottom');
    }

    /* ── Send message ─────────────────────────────────── */

    public function sendMessage(): void
    {
        $this->validate([
            'newMessage' => 'required_without:attachment|nullable|string|max:4000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,webp,gif',
        ]);

        if (!$this->newMessage && !$this->attachment) return;

        $thread = SponsorMessageThread::findOrFail($this->selectedId);

        $attachPath = null;
        $attachName = null;
        $attachSize = null;
        $isImage    = false;

        if ($this->attachment) {
            $this->ensureChatDir();
            $ext     = strtolower($this->attachment->getClientOriginalExtension());
            $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
            $temp    = $this->attachment->getRealPath();

            if ($isImage) {
                $filename   = 'img_' . uniqid() . '.webp';
                $dest       = public_path('images/chat/' . $filename);
                if (!$this->convertToWebp($temp, $dest)) copy($temp, $dest);
                $attachPath = 'images/chat/' . $filename;
                $attachName = $filename;
                $attachSize = $this->formatSize(filesize($dest));
            } else {
                $filename   = 'file_' . uniqid() . '.' . $ext;
                $dest       = public_path('images/chat/' . $filename);
                copy($temp, $dest);
                $attachPath = 'images/chat/' . $filename;
                $attachName = $this->attachment->getClientOriginalName();
                $attachSize = $this->formatSize(filesize($dest));
            }
        }

        $linkPreview = null;
        if ($this->newMessage) {
            preg_match('/https?:\/\/[^\s\'"<>]+/', $this->newMessage, $m);
            if (!empty($m[0])) $linkPreview = $this->fetchLinkPreview($m[0]);
        }

        $thread->messages()->create([
            'sender'          => 'admin',
            'body'            => $this->newMessage,
            'attachment_path' => $attachPath,
            'attachment_name' => $attachName,
            'attachment_size' => $attachSize,
            'is_image'        => $isImage,
            'link_preview'    => $linkPreview ? json_encode($linkPreview) : null,
            'admin_read_at'   => now(),
        ]);

        $thread->touch();
        $this->newMessage = '';
        $this->attachment = null;

        $this->loadThreads();
        $this->loadMessages($this->selectedId);
        $this->dispatch('scroll-bottom');
    }

    /* ── Edit ─────────────────────────────────────────── */

    public function startEdit(int $id): void
    {
        $msg = SponsorMessage::find($id);
        if (!$msg || $msg->sender !== 'admin') return;
        $this->editingId = $id;
        $this->editBody  = $msg->body ?? '';
        $this->dispatch('focus-edit');
    }

    public function saveEdit(): void
    {
        $this->validate(['editBody' => 'required|string|max:4000']);
        $msg = SponsorMessage::find($this->editingId);
        if (!$msg || $msg->sender !== 'admin') return;
        $msg->update(['body' => trim($this->editBody), 'is_edited' => true]);
        $this->cancelEdit();
        $this->loadMessages($this->selectedId);
    }

    public function cancelEdit(): void
    {
        $this->editingId = 0;
        $this->editBody  = '';
    }

    /* ── Delete ───────────────────────────────────────── */

    public function confirmDelete(int $id): void { $this->deleteConfirmId = $id; }
    public function cancelDelete(): void         { $this->deleteConfirmId = 0;  }

    public function deleteMessage(): void
    {
        $msg = SponsorMessage::find($this->deleteConfirmId);
        if ($msg) {
            if ($msg->attachment_path && file_exists(public_path($msg->attachment_path))) {
                @unlink(public_path($msg->attachment_path));
            }
            $msg->delete();
        }
        $this->deleteConfirmId = 0;
        $this->loadThreads();
        $this->loadMessages($this->selectedId);
    }

    /* ── Toggle sponsor message read / unread ─────────── */

    /**
     * If admin has already read a sponsor message, they can mark it back as unread
     * (set admin_read_at = null) so it shows as needing follow-up.
     * If it's currently unread, this marks it as read.
     */
    public function toggleMessageRead(int $id): void
    {
        $msg = SponsorMessage::where('id', $id)
            ->where('sender', 'sponsor')
            ->firstOrFail();

        $msg->update([
            'admin_read_at' => $msg->admin_read_at ? null : now(),
        ]);

        $this->loadMessages($this->selectedId);
        $this->loadThreads(); // Refresh sidebar unread counts
    }

    /* ── Mark all as read ─────────────────────────────── */

    public function markAdminReadAll(int $threadId): void
    {
        SponsorMessageThread::findOrFail($threadId)
            ->messages()
            ->where('sender', 'sponsor')
            ->whereNull('admin_read_at')
            ->update(['admin_read_at' => now()]);

        $this->loadThreads();
        $this->loadMessages($threadId);
    }

    /* ── Search ───────────────────────────────────────── */

    public function updatedSearch(): void { $this->loadThreads(); }

    /* ── Render ───────────────────────────────────────── */

    public function render()
    {
        return view('livewire.messages-admin-chat');
    }

    /* ── Private helpers ──────────────────────────────── */

    private function loadThreads(): void
    {
        $this->threads = SponsorMessageThread::with(['sponsor'])
            ->withCount([
                'messages as unread_count' => fn ($q) => $q
                    ->where('sender', 'sponsor')
                    ->whereNull('admin_read_at'),
            ])
            ->latest('updated_at')
            ->get()
            ->map(function ($thread) {
                $sponsorName = $thread->sponsor?->full_name ?? 'Unknown';

                if ($this->search && !str_contains(
                    strtolower($sponsorName . ' ' . ($thread->subject ?? '')),
                    strtolower($this->search)
                )) {
                    return null;
                }

                $last = SponsorMessage::where('thread_id', $thread->id)
                    ->orderByDesc('created_at')
                    ->first();

                return [
                    'id'            => $thread->id,
                    'sponsor_name'  => $sponsorName,
                    'sponsor_init'  => strtoupper(substr($thread->sponsor?->first_name ?? '?', 0, 1)),
                    'sponsor_email' => $thread->sponsor?->email ?? '',
                    'subject'       => $thread->subject ?? 'Support',
                    'last_message'  => $last
                        ? Str::limit($last->body ?? ($last->attachment_name ?? 'Attachment'), 52)
                        : 'No messages yet',
                    'last_sender'   => $last?->sender,
                    'last_date'     => $last
                        ? $last->created_at?->diffForHumans()
                        : $thread->created_at?->diffForHumans(),
                    'unread_count'  => $thread->unread_count,
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }

    private function loadMessages(int $threadId): void
    {
        $this->messages = SponsorMessage::where('thread_id', $threadId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn ($msg) => [
                'id'              => $msg->id,
                'sender'          => $msg->sender,
                'body'            => $msg->body,
                'created_at'      => $msg->created_at?->toISOString(),
                'is_edited'       => (bool) ($msg->is_edited ?? false),
                'is_image'        => (bool) ($msg->is_image ?? false),
                'admin_read_at'   => $msg->admin_read_at?->toISOString(), // null = unread by admin
                'attachment_url'  => $msg->attachment_path ? asset($msg->attachment_path) : null,
                'attachment_name' => $msg->attachment_name,
                'attachment_size' => $msg->attachment_size,
                'link_preview'    => $msg->link_preview
                    ? (is_string($msg->link_preview)
                        ? json_decode($msg->link_preview, true)
                        : $msg->link_preview)
                    : null,
            ])
            ->values()
            ->toArray();
    }

    private function convertToWebp(string $src, string $dest): bool
    {
        if (!function_exists('imagewebp')) return false;
        $info = @getimagesize($src); if (!$info) return false;
        $image = match ($info['mime']) {
            'image/jpeg' => @imagecreatefromjpeg($src), 'image/png'  => @imagecreatefrompng($src),
            'image/gif'  => @imagecreatefromgif($src),  'image/webp' => @imagecreatefromwebp($src),
            default => false,
        };
        if (!$image) return false;
        if ($info['mime'] === 'image/png') { imagepalettetotruecolor($image); imagealphablending($image, true); imagesavealpha($image, true); }
        $ok = imagewebp($image, $dest, 82); imagedestroy($image); return $ok;
    }

    private function fetchLinkPreview(string $url): ?array
    {
        try {
            $ctx  = stream_context_create(['http' => ['timeout' => 4, 'user_agent' => 'Mozilla/5.0', 'follow_location' => true]]);
            $html = @file_get_contents($url, false, $ctx); if (!$html) return null;
            $og = function (string $prop) use ($html): ?string {
                foreach (['/<meta[^>]+property=["\']og:'.$prop.'["\'][^>]+content=["\']([^"\']+)["\'][^>]*>/i', '/<meta[^>]+content=["\']([^"\']+)["\'][^>]+property=["\']og:'.$prop.'["\'][^>]*>/i'] as $pat) {
                    if (preg_match($pat, $html, $m)) return trim(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5));
                } return null;
            };
            $title = $og('title');
            if (!$title) { preg_match('/<title[^>]*>([^<]+)<\/title>/i', $html, $t); $title = isset($t[1]) ? trim(html_entity_decode($t[1], ENT_QUOTES | ENT_HTML5)) : null; }
            $host = parse_url($url, PHP_URL_HOST) ?? $url;
            return ['url' => $url, 'host' => preg_replace('/^www\./', '', $host), 'title' => $title ? mb_substr($title, 0, 120) : $host, 'description' => $og('description') ? mb_substr($og('description'), 0, 200) : null, 'image' => $og('image')];
        } catch (\Throwable) { return null; }
    }

    private function ensureChatDir(): void
    {
        $dir = public_path('images/chat');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
    }

    private function formatSize(int $bytes): string
    {
        if ($bytes >= 1_048_576) return round($bytes / 1_048_576, 1) . ' MB';
        if ($bytes >= 1_024)     return round($bytes / 1_024) . ' KB';
        return $bytes . ' B';
    }
}