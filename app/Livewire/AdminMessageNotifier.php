<?php

namespace App\Livewire;

use App\Models\SponsorMessage;
use App\Models\SponsorMessageThread;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminMessageNotifier extends Component
{
    /**
     * Snapshot of per-thread unread counts from the previous poll.
     * Stored as [ thread_id => unread_count ] so we can detect
     * exactly which thread received new messages.
     */
    public array $snapshot = [];

    /** Total unread across all threads — shown in the sidebar badge. */
    public int $totalUnread = 0;

    /* ── Lifecycle ─────────────────────────────────────────────── */

    public function mount(): void
    {
        $this->snapshot    = $this->buildSnapshot();
        $this->totalUnread = array_sum($this->snapshot);
    }

    /* ── Polling (every 8 s — lighter than the chat component) ─── */

    public function poll(): void
    {
        $fresh      = $this->buildSnapshot();
        $freshTotal = array_sum($fresh);

        // Detect threads that gained NEW unread messages
        if ($freshTotal > $this->totalUnread) {
            foreach ($fresh as $threadId => $count) {
                $was = $this->snapshot[$threadId] ?? 0;
                if ($count > $was) {
                    $thread = SponsorMessageThread::with('sponsor')->find($threadId);
                    if (!$thread) continue;

                    $last = SponsorMessage::where('thread_id', $threadId)
                        ->where('sender', 'sponsor')
                        ->whereNull('admin_read_at')
                        ->orderByDesc('created_at')
                        ->first();

                    $this->dispatch('show-toast', [
                        'sponsorName' => $thread->sponsor?->full_name ?? 'Sponsor',
                        'sponsorInit' => strtoupper(substr($thread->sponsor?->first_name ?? '?', 0, 1)),
                        'threadId'    => $threadId,
                        'preview'     => Str::limit($last?->body ?? ($last?->attachment_name ?? 'New attachment'), 72),
                        'count'       => $count - $was,
                    ]);

                    break; // one toast per poll cycle
                }
            }
        }

        $this->snapshot    = $fresh;
        $this->totalUnread = $freshTotal;
    }

    /* ── Render ─────────────────────────────────────────────────── */

    public function render()
    {
        return view('livewire.admin-message-notifier');
    }

    /* ── Private helpers ─────────────────────────────────────────── */

    private function buildSnapshot(): array
    {
        return SponsorMessageThread::withCount([
            'messages as unread_count' => fn ($q) => $q
                ->where('sender', 'sponsor')
                ->whereNull('admin_read_at'),
        ])
        ->get()
        ->mapWithKeys(fn ($t) => [$t->id => $t->unread_count])
        ->toArray();
    }
}