{{-- resources/views/livewire/message-notifier.blade.php --}}
{{-- Invisible component. Polls every 5 s, fires JS events when new admin messages arrive. --}}

<div
    wire:poll.5000ms="checkMessages"
    data-unread="{{ $unreadCount }}"
    style="display:none"
    aria-hidden="true"
></div>

@script
<script>
/* ─────────────────────────────────────────────────────────
   SPONSOR MESSAGE NOTIFIER
   Listens for the Livewire browser event dispatched by
   MessageNotifier::checkMessages() when unread count grows.
───────────────────────────────────────────────────────── */

// ── 1. Set initial badge on first page load ──────────────
(function initBadge() {
    const el = document.querySelector('[data-unread]');
    const n  = parseInt(el?.dataset?.unread || '0', 10);
    if (n > 0) _msgUpdateBadges(n);
})();

// ── 2. Listen for new-message events from Livewire ───────
Livewire.on('sponsor-new-message', ({ count, delta }) => {
    _msgPlaySound();
    _msgShowToast(delta ?? 1);
    _msgUpdateBadges(count ?? 0);
});

/* ── Sound: two-note chime via Web Audio API ── */
function _msgPlaySound() {
    try {
        const ctx   = new (window.AudioContext || window.webkitAudioContext)();
        const notes = [880, 1108]; // A5 + C#6
        notes.forEach((freq, i) => {
            const osc  = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.type            = 'sine';
            osc.frequency.value = freq;
            const t = ctx.currentTime + i * 0.16;
            gain.gain.setValueAtTime(0, t);
            gain.gain.linearRampToValueAtTime(0.22, t + 0.025);
            gain.gain.exponentialRampToValueAtTime(0.001, t + 0.55);
            osc.start(t);
            osc.stop(t + 0.6);
        });
    } catch (_) { /* AudioContext blocked or unavailable */ }
}

/* ── Toast: slides in from top-right ── */
function _msgShowToast(delta) {
    const OLD = document.getElementById('msg-notif-toast');
    if (OLD) OLD.remove();

    const toast = document.createElement('div');
    toast.id = 'msg-notif-toast';
    toast.innerHTML = `
        <div style="display:flex;align-items:center;gap:11px">
            <div style="width:38px;height:38px;border-radius:11px;background:linear-gradient(135deg,#f97316,#ea580c);
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;
                        box-shadow:0 4px 12px rgba(249,115,22,.35)">
                <i class="fas fa-headset" style="color:#fff;font-size:14px"></i>
            </div>
            <div style="flex:1;min-width:0">
                <div style="font-size:13px;font-weight:800;color:#111827;line-height:1.3">
                    New message from support
                </div>
                <div style="font-size:11px;color:#6b7280;margin-top:2px;font-weight:600">
                    ${delta} new message${delta > 1 ? 's' : ''} — tap to view
                </div>
            </div>
            <button
                onclick="event.stopPropagation();document.getElementById('msg-notif-toast').remove()"
                style="background:none;border:none;cursor:pointer;color:#9ca3af;font-size:13px;
                       padding:4px;line-height:1;flex-shrink:0;transition:color .15s"
                onmouseover="this.style.color='#ef4444'"
                onmouseout="this.style.color='#9ca3af'"
            ><i class="fas fa-times"></i></button>
        </div>`;

    Object.assign(toast.style, {
        position:    'fixed',
        top:         '84px',
        right:       '18px',
        zIndex:      '9999',
        background:  '#fff',
        border:      '1px solid #e5e7eb',
        borderLeft:  '4px solid #f97316',
        borderRadius:'14px',
        padding:     '13px 16px',
        minWidth:    '280px',
        maxWidth:    '340px',
        boxShadow:   '0 16px 48px rgba(0,0,0,.16)',
        transform:   'translateX(115%)',
        transition:  'transform .38s cubic-bezier(.34,1.56,.64,1)',
        cursor:      'pointer',
        fontFamily:  "'Plus Jakarta Sans',sans-serif",
    });

    toast.onclick = (e) => {
        if (e.target.closest('button')) return;
        window.location.href = @js(route('sponsor.messages.home'));
    };

    document.body.appendChild(toast);
    // Two rAF calls to ensure the element is in the DOM before animating
    requestAnimationFrame(() => requestAnimationFrame(() => {
        toast.style.transform = 'translateX(0)';
    }));

    // Auto-dismiss after 5 s
    setTimeout(() => {
        if (!document.getElementById('msg-notif-toast')) return;
        toast.style.transform = 'translateX(115%)';
        setTimeout(() => toast.remove(), 400);
    }, 5000);
}

/* ── Badge: updates all .msg-notif-badge elements ── */
function _msgUpdateBadges(count) {
    document.querySelectorAll('.msg-notif-badge').forEach(el => {
        if (count > 0) {
            el.textContent   = count > 99 ? '99+' : String(count);
            el.style.display = 'flex';
        } else {
            el.style.display = 'none';
        }
    });

    // Update browser tab title
    const base = document.title.replace(/^\(\d+\)\s*/, '');
    document.title = count > 0 ? `(${count}) ${base}` : base;
}
</script>
@endscript