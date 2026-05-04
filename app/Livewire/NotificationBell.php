<?php

namespace App\Livewire;

use App\Models\SponsorNotificationRead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class NotificationBell extends Component
{
    public array  $updates       = [];
    public array  $docs          = [];
    public int    $unreadUpdates = 0;
    public int    $unreadDocs    = 0;

    /** Persisted between polls so we detect genuinely new arrivals */
    public int $prevUnread = 0;

    /* ── Lifecycle ─────────────────────────────────────────── */

    public function mount(): void
    {
        $this->loadData();
        $this->prevUnread = $this->unreadUpdates + $this->unreadDocs;
    }

    /* ── Polling (every 30 s) ─────────────────────────────── */

    public function poll(): void
    {
        $before = $this->unreadUpdates + $this->unreadDocs;
        $this->loadData();
        $after  = $this->unreadUpdates + $this->unreadDocs;

        if ($after > $before) {
            $this->dispatch('sponsor-new-notification',
                count: $after,
                delta: $after - $before,
            );
        }
    }

    /* ── Actions ──────────────────────────────────────────── */

    public function markAllRead(): void
    {
        $sponsor = Auth::guard('sponsor')->user();
        if (!$sponsor) return;

        foreach ($this->updates as $u) {
            SponsorNotificationRead::firstOrCreate([
                'sponsor_id'      => $sponsor->id,
                'notifiable_type' => $u['notif_type'],
                'notifiable_id'   => $u['id'],
            ]);
        }
        foreach ($this->docs as $d) {
            SponsorNotificationRead::firstOrCreate([
                'sponsor_id'      => $sponsor->id,
                'notifiable_type' => $d['notif_type'],
                'notifiable_id'   => $d['id'],
            ]);
        }

        $this->loadData();
    }

    public function markItemRead(string $type, int $id): void
    {
        $sponsor = Auth::guard('sponsor')->user();
        if (!$sponsor) return;

        SponsorNotificationRead::firstOrCreate([
            'sponsor_id'      => $sponsor->id,
            'notifiable_type' => $type,
            'notifiable_id'   => $id,
        ]);

        $this->loadData();
    }

    /* ── Render ───────────────────────────────────────────── */

    public function render()
    {
        return view('livewire.notification-bell');
    }

    /* ── Private helpers ──────────────────────────────────── */

    private function loadData(): void
    {
        $sponsor = Auth::guard('sponsor')->user();
        if (!$sponsor) {
            $this->updates = $this->docs = [];
            $this->unreadUpdates = $this->unreadDocs = 0;
            return;
        }

        // Build lookup: "notif_type:id" => true  for already-read items
        $readSet = SponsorNotificationRead::where('sponsor_id', $sponsor->id)
            ->get()
            ->mapWithKeys(fn ($r) => ["{$r->notifiable_type}:{$r->notifiable_id}" => true])
            ->all();

        $updates = collect();
        $docs    = collect();

        // ── Children ──────────────────────────────────────
        $children = $sponsor->children()->with(['updates', 'documents'])->get();

        foreach ($children as $child) {
            foreach ($child->updates as $u) {
                $updates->push([
                    'id'         => $u->id,
                    'notif_type' => 'child_update',
                    'entity'     => 'child',
                    'name'       => $child->first_name,
                    'upd_type'   => $u->type ?? 'general',
                    'title'      => $u->title ?? '',
                    'content'    => $u->content,
                    'date'       => Carbon::parse($u->report_date ?? $u->created_at)->format('M d, Y'),
                    'sort'       => Carbon::parse($u->report_date ?? $u->created_at)->timestamp,
                    'is_read'    => isset($readSet["child_update:{$u->id}"]),
                ]);
            }
            foreach ($child->documents as $d) {
                $docs->push([
                    'id'         => $d->id,
                    'notif_type' => 'child_document',
                    'entity'     => 'child',
                    'name'       => $child->first_name,
                    'title'      => $d->title,
                    'date'       => ($d->document_date
                        ? Carbon::parse($d->document_date)
                        : $d->created_at)->format('M Y'),
                    'sort'       => ($d->document_date
                        ? Carbon::parse($d->document_date)
                        : $d->created_at)->timestamp,
                    'is_read'    => isset($readSet["child_document:{$d->id}"]),
                    'dl_url'     => route('sponsor.download', ['type' => 'document', 'id' => $d->id]),
                ]);
            }
        }

        // ── Families ──────────────────────────────────────
        $families = $sponsor->families()->with(['updates', 'documents'])->get();

        foreach ($families as $family) {
            foreach ($family->updates as $u) {
                $updates->push([
                    'id'         => $u->id,
                    'notif_type' => 'family_update',
                    'entity'     => 'family',
                    'name'       => Str::words($family->name, 1, ''),
                    'upd_type'   => $u->type ?? 'general',
                    'title'      => $u->title ?? '',
                    'content'    => $u->content,
                    'date'       => Carbon::parse($u->report_date ?? $u->created_at)->format('M d, Y'),
                    'sort'       => Carbon::parse($u->report_date ?? $u->created_at)->timestamp,
                    'is_read'    => isset($readSet["family_update:{$u->id}"]),
                ]);
            }
            foreach ($family->documents as $d) {
                $docs->push([
                    'id'         => $d->id,
                    'notif_type' => 'family_document',
                    'entity'     => 'family',
                    'name'       => Str::words($family->name, 1, ''),
                    'title'      => $d->title,
                    'date'       => ($d->document_date
                        ? Carbon::parse($d->document_date)
                        : $d->created_at)->format('M Y'),
                    'sort'       => ($d->document_date
                        ? Carbon::parse($d->document_date)
                        : $d->created_at)->timestamp,
                    'is_read'    => isset($readSet["family_document:{$d->id}"]),
                    'dl_url'     => route('sponsor.download', ['type' => 'family_document', 'id' => $d->id]),
                ]);
            }
        }

        $this->updates       = $updates->sortByDesc('sort')->take(8)->values()->toArray();
        $this->docs          = $docs->sortByDesc('sort')->take(6)->values()->toArray();
        $this->unreadUpdates = collect($this->updates)->where('is_read', false)->count();
        $this->unreadDocs    = collect($this->docs)->where('is_read', false)->count();
    }
}