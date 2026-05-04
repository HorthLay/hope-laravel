<?php

namespace App\Livewire;

use App\Models\SponsorMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MessageNotifier extends Component
{
    /** Last known unread count — persisted between polls by Livewire serialization */
    public int $unreadCount = 0;

    public function mount(): void
    {
        $this->unreadCount = $this->fetchCount();
    }

    /**
     * Called every 5 s by wire:poll.
     * Fires a browser event only when the count has grown since last check.
     */
    public function checkMessages(): void
    {
        $fresh = $this->fetchCount();

        if ($fresh > $this->unreadCount) {
            // Livewire 3: dispatch() sends a browser-level JS event
            $this->dispatch('sponsor-new-message',
                count: $fresh,
                delta: $fresh - $this->unreadCount,
            );
        }

        $this->unreadCount = $fresh;
    }

    public function render()
    {
        return view('livewire.message-notifier');
    }

    /* ── helpers ── */

    private function fetchCount(): int
    {
        $sponsor = Auth::guard('sponsor')->user();
        if (!$sponsor) return 0;

        return SponsorMessage::whereHas(
            'thread',
            fn ($q) => $q->where('sponsor_id', $sponsor->id)
        )
            ->where('sender', 'admin')
            ->whereNull('read_at')
            ->count();
    }
}