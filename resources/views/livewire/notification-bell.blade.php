{{-- resources/views/livewire/notification-bell.blade.php --}}
{{-- SINGLE root <div> — Livewire requires exactly one root element.         --}}
{{-- All CSS lives in sponsor/layouts/header.blade.php <style> block.        --}}

@php $totalUnread = $unreadUpdates + $unreadDocs; @endphp

<div
    wire:poll.30000ms="poll"
    x-data="{ open: false, tab: 'updates' }"
    @close-notif.window="open = false"
    @toggle-notif.window="open = !open"
    @click.outside="open = false"
    style="position:relative"
    id="notif-wrapper"
>

    {{-- ── Bell button ── --}}
    <button class="notif-btn" @click="open = !open" aria-label="Notifications">
        <i class="far fa-bell"></i>
        @if($totalUnread > 0)
        <span class="notif-badge">{{ $totalUnread > 9 ? '9+' : $totalUnread }}</span>
        @endif
    </button>

    {{-- ── Dropdown panel ── --}}
    <div class="notif-panel" :class="{ 'open': open }">

        {{-- Header --}}
        <div class="notif-header">
            <div class="notif-title-row">
                <span style="font-size:14px;font-weight:700;font-family:'Lora',serif;color:var(--dark)">
                    Notifications
                </span>
                <button
                    wire:click="markAllRead"
                    wire:loading.attr="disabled"
                    wire:target="markAllRead"
                    style="font-size:11px;color:var(--orange);font-weight:700;background:none;border:none;
                           cursor:pointer;font-family:inherit;padding:0;
                           display:inline-flex;align-items:center;gap:5px"
                >
                    <span wire:loading.remove wire:target="markAllRead">
                        <i class="fas fa-check-double" style="font-size:10px"></i> Mark all read
                    </span>
                    <span wire:loading wire:target="markAllRead">
                        <i class="fas fa-spinner fa-spin" style="font-size:10px"></i> Marking…
                    </span>
                </button>
            </div>

            {{-- Tabs — Alpine-only, no server roundtrip --}}
            <div class="notif-tabs">
                <button class="ntab" :class="{ active: tab === 'updates' }" @click="tab = 'updates'">
                    <i class="fas fa-bell" style="font-size:10px"></i>
                    Updates
                    <span class="ntab-count">{{ count($updates) }}</span>
                    @if($unreadUpdates > 0)
                        <span class="ntab-unread-pill">{{ $unreadUpdates }}</span>
                    @endif
                </button>
                <button class="ntab" :class="{ active: tab === 'docs' }" @click="tab = 'docs'">
                    <i class="far fa-folder" style="font-size:10px"></i>
                    Documents
                    <span class="ntab-count">{{ count($docs) }}</span>
                    @if($unreadDocs > 0)
                        <span class="ntab-unread-pill">{{ $unreadDocs }}</span>
                    @endif
                </button>
            </div>
        </div>

        {{-- Body --}}
        <div class="notif-body">

            {{-- ── Updates pane ── --}}
            <div x-show="tab === 'updates'" x-cloak>
                @forelse($updates as $upd)
                <div
                    class="nitem {{ !$upd['is_read'] ? 'unread' : '' }}"
                    wire:click="markItemRead('{{ $upd['notif_type'] }}', {{ $upd['id'] }})"
                    wire:key="upd-{{ $upd['id'] }}"
                    style="cursor:pointer"
                >
                    <div class="nitem-icon {{ $upd['entity'] }}">
                        <i class="fas {{ $upd['entity'] === 'family' ? 'fa-home' : 'fa-child' }}"></i>
                    </div>
                    <div class="nitem-content">
                        <div class="nitem-meta">
                            <span class="type-badge badge-{{ $upd['upd_type'] }}">{{ $upd['upd_type'] }}</span>
                            <span class="nitem-entity">{{ $upd['name'] }}</span>
                            <span class="nitem-date">· {{ $upd['date'] }}</span>
                        </div>
                        @if($upd['title'])
                            <div class="nitem-title">{{ $upd['title'] }}</div>
                        @endif
                        <div class="nitem-text">{{ $upd['content'] }}</div>
                    </div>
                    @if(!$upd['is_read'])
                        <div class="nitem-dot" title="Unread"></div>
                    @else
                        <div style="width:7px;flex-shrink:0"></div>
                    @endif
                </div>
                @empty
                <div style="text-align:center;padding:32px 16px;color:var(--muted);font-size:13px">
                    <i class="far fa-bell-slash" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4"></i>
                    No updates yet.
                </div>
                @endforelse
            </div>

            {{-- ── Documents pane ── --}}
            <div x-show="tab === 'docs'" x-cloak>
                @forelse($docs as $doc)
                <div
                    class="nitem {{ !$doc['is_read'] ? 'unread' : '' }}"
                    wire:click="markItemRead('{{ $doc['notif_type'] }}', {{ $doc['id'] }})"
                    wire:key="doc-{{ $doc['id'] }}"
                    style="align-items:center;cursor:pointer"
                >
                    <div class="nitem-icon doc"><i class="fas fa-file-pdf"></i></div>
                    <div class="nitem-content">
                        <div class="nitem-title">{{ $doc['title'] }}</div>
                        <div style="font-size:11px;color:var(--muted);font-weight:600;margin-top:2px">
                            PDF · {{ $doc['name'] }} · {{ $doc['date'] }}
                        </div>
                    </div>
                    <a href="{{ $doc['dl_url'] }}" class="nitem-dl" download
                       onclick="event.stopPropagation()" title="Download">
                        <i class="fas fa-download"></i>
                    </a>
                    @if(!$doc['is_read'])
                        <div class="nitem-dot" title="Unread"></div>
                    @endif
                </div>
                @empty
                <div style="text-align:center;padding:32px 16px;color:var(--muted);font-size:13px">
                    <i class="far fa-folder-open" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4"></i>
                    No documents yet.
                </div>
                @endforelse
            </div>

        </div>

        {{-- Footer --}}
        <div class="notif-footer">
            <a href="{{ route('sponsor.dashboard') }}">
                View all on dashboard <i class="fas fa-chevron-right" style="font-size:9px"></i>
            </a>
        </div>

    </div>{{-- /notif-panel --}}

    @script
    <script>
    /* ─────────────────────────────────────────────────────────
       NOTIFICATION BELL  ·  sound + toast when new items arrive
    ───────────────────────────────────────────────────────── */

    Livewire.on('sponsor-new-notification', ({ count, delta }) => {
        _notifBellSound();
        _notifBellToast(delta ?? 1);
    });

    /* Two-note soft chime: E5 + G5 (different from message chime A5+C#6) */
    function _notifBellSound() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            [659, 784].forEach((freq, i) => {
                const osc  = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination);
                osc.type = 'sine'; osc.frequency.value = freq;
                const t = ctx.currentTime + i * 0.13;
                gain.gain.setValueAtTime(0, t);
                gain.gain.linearRampToValueAtTime(0.16, t + 0.022);
                gain.gain.exponentialRampToValueAtTime(0.001, t + 0.48);
                osc.start(t); osc.stop(t + 0.5);
            });
        } catch (_) {}
    }

    /* Blue-accented toast — opens the panel when tapped */
    function _notifBellToast(delta) {
        document.getElementById('notif-bell-toast')?.remove();

        const toast = document.createElement('div');
        toast.id = 'notif-bell-toast';
        toast.innerHTML = `
            <div style="display:flex;align-items:center;gap:11px">
                <div style="width:38px;height:38px;border-radius:11px;
                            background:linear-gradient(135deg,#3b82f6,#1d4ed8);
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;
                            box-shadow:0 4px 12px rgba(59,130,246,.35)">
                    <i class="fas fa-bell" style="color:#fff;font-size:13px"></i>
                </div>
                <div style="flex:1;min-width:0">
                    <div style="font-size:13px;font-weight:800;color:#111827">New notification</div>
                    <div style="font-size:11px;color:#6b7280;margin-top:2px;font-weight:600">
                        ${delta} new item${delta > 1 ? 's' : ''} — tap to view
                    </div>
                </div>
                <button
                    onclick="event.stopPropagation();document.getElementById('notif-bell-toast').remove()"
                    style="background:none;border:none;cursor:pointer;color:#9ca3af;
                           font-size:13px;padding:4px;line-height:1;flex-shrink:0;transition:color .15s"
                    onmouseover="this.style.color='#ef4444'"
                    onmouseout="this.style.color='#9ca3af'">
                    <i class="fas fa-times"></i>
                </button>
            </div>`;

        Object.assign(toast.style, {
            position:'fixed', top:'84px', right:'18px', zIndex:'9998',
            background:'#fff', border:'1px solid #e5e7eb', borderLeft:'4px solid #3b82f6',
            borderRadius:'14px', padding:'13px 16px',
            minWidth:'280px', maxWidth:'340px',
            boxShadow:'0 16px 48px rgba(0,0,0,.16)',
            transform:'translateX(115%)',
            transition:'transform .38s cubic-bezier(.34,1.56,.64,1)',
            cursor:'pointer', fontFamily:"'Plus Jakarta Sans',sans-serif",
        });

        toast.onclick = (e) => {
            if (e.target.closest('button')) return;
            window.dispatchEvent(new CustomEvent('toggle-notif'));
            toast.remove();
        };

        document.body.appendChild(toast);
        requestAnimationFrame(() => requestAnimationFrame(() => {
            toast.style.transform = 'translateX(0)';
        }));
        setTimeout(() => {
            const t = document.getElementById('notif-bell-toast');
            if (!t) return;
            t.style.transform = 'translateX(115%)';
            setTimeout(() => t.remove(), 400);
        }, 5000);
    }

    /* ── Legacy shims so page-level JS keeps working ── */
    window.toggleNotif    = () => window.dispatchEvent(new CustomEvent('toggle-notif'));
    window.closeNotif     = () => window.dispatchEvent(new CustomEvent('close-notif'));
    window.switchNotifTab = () => { /* now Alpine-driven */ };
    window.markAllRead    = () => { /* now wire:click-driven */ };
    </script>
    @endscript

</div>{{-- single root element end --}}