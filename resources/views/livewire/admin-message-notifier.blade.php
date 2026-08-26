{{-- resources/views/livewire/admin-message-notifier.blade.php --}}
{{--
    Invisible Livewire component — polls every 8 s, fires 'show-toast'
    browser events when new sponsor messages arrive.

    Single root <div> — Livewire requirement.
    Include in admin layout: @livewire('admin-message-notifier')
--}}
<div
    wire:poll.30s="poll"
    data-unread="{{ $totalUnread }}"
    id="adm-notifier"
    style="display:none"
    aria-hidden="true"
></div>

@script
<script>
/* ═══════════════════════════════════════════════════════════════
   ADMIN MESSAGE NOTIFIER
   Listens for 'show-toast' dispatched by AdminMessageNotifier::poll()
   and drives: toast popup · notification sound · sidebar badge · tab title
═══════════════════════════════════════════════════════════════ */

/* ── 1. Set sidebar badge on first paint from server-rendered count ── */
(function () {
    const n = parseInt(document.getElementById('adm-notifier')?.dataset?.unread ?? '0', 10);
    _admBadgeSet(n);
})();

/* ── 2. Listen for new-message events dispatched from the PHP component ── */
Livewire.on('show-toast', (payload) => {
    /* Livewire 3 wraps array dispatches as the first element */
    const d = Array.isArray(payload) ? payload[0] : payload;
    _admPlaySound();
    _admShowToast(d);
    _admFlashTab(d.count ?? 1);
    _admBadgeSet(null, d.count ?? 1); // increment
});

/* ═══ SOUND — two-note ascending ping  E5 → A5 ═══════════════ */
function _admPlaySound() {
    try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        [
            { freq: 659.25, t: 0,    dur: 0.20 },
            { freq: 880.00, t: 0.14, dur: 0.30 },
        ].forEach(({ freq, t, dur }) => {
            const osc  = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain); gain.connect(ctx.destination);
            osc.type = 'sine'; osc.frequency.value = freq;
            const at = ctx.currentTime + t;
            gain.gain.setValueAtTime(0, at);
            gain.gain.linearRampToValueAtTime(0.22, at + 0.012);
            gain.gain.exponentialRampToValueAtTime(0.001, at + dur);
            osc.start(at); osc.stop(at + dur + 0.01);
        });
    } catch (_) {}
}

/* ═══ TOAST ═══════════════════════════════════════════════════ */
function _admShowToast(d) {
    /* Ensure container exists */
    let container = document.getElementById('adm-toast-wrap');
    if (!container) {
        container = document.createElement('div');
        container.id = 'adm-toast-wrap';
        Object.assign(container.style, {
            position: 'fixed', top: '80px', right: '20px', zIndex: '9999',
            display: 'flex', flexDirection: 'column', gap: '10px',
            width: '320px', maxWidth: 'calc(100vw - 32px)',
            pointerEvents: 'none',
        });
        document.body.appendChild(container);
    }

    const id    = 'admt-' + Date.now();
    const toast = document.createElement('div');
    toast.id    = id;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');

    /* Inline styles so the view needs no extra stylesheet */
    Object.assign(toast.style, {
        pointerEvents:   'all',
        display:         'flex',
        alignItems:      'flex-start',
        gap:             '12px',
        background:      '#fff',
        borderRadius:    '16px',
        border:          '1px solid #e5e7eb',
        borderLeft:      '4px solid #f97316',
        padding:         '13px 13px 16px',
        boxShadow:       '0 12px 40px rgba(0,0,0,.18)',
        position:        'relative',
        overflow:        'hidden',
        cursor:          'pointer',
        transform:       'translateX(115%)',
        opacity:         '0',
        transition:      'transform .38s cubic-bezier(.34,1.56,.64,1), opacity .28s ease',
    });

    const newLabel = (d.count ?? 1) > 1 ? `${d.count} new` : 'New';

    toast.innerHTML = `
        <div style="
            width:42px;height:42px;border-radius:12px;flex-shrink:0;
            background:linear-gradient(135deg,#f97316,#ea580c);
            color:#fff;font-size:16px;font-weight:900;
            display:flex;align-items:center;justify-content:center;
            box-shadow:0 3px 10px rgba(249,115,22,.35)">
            ${_admEsc(d.sponsorInit ?? '?')}
        </div>
        <div style="flex:1;min-width:0">
            <div style="display:flex;align-items:center;gap:7px;margin-bottom:3px">
                <span style="
                    font-size:13px;font-weight:800;color:#111827;
                    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:155px">
                    ${_admEsc(d.sponsorName ?? 'Sponsor')}
                </span>
                <span style="
                    font-size:9px;font-weight:900;padding:2px 7px;
                    border-radius:999px;background:#f97316;color:#fff;
                    white-space:nowrap;flex-shrink:0">
                    ${_admEsc(newLabel)}
                </span>
            </div>
            <div style="
                font-size:10px;font-weight:700;color:#9ca3af;
                display:flex;align-items:center;gap:4px;margin-bottom:4px">
                <i class="fas fa-headset" style="font-size:9px"></i>
                Support message
            </div>
            <div style="
                font-size:12px;color:#6b7280;font-weight:500;line-height:1.5;
                display:-webkit-box;-webkit-line-clamp:2;
                -webkit-box-orient:vertical;overflow:hidden">
                ${_admEsc(d.preview ?? '')}
            </div>
        </div>
        <button id="${id}-close" style="
            background:none;border:none;cursor:pointer;color:#9ca3af;
            font-size:12px;padding:3px 5px;line-height:1;
            border-radius:6px;flex-shrink:0;transition:all .15s"
            title="Dismiss" aria-label="Dismiss">
            <i class="fas fa-times"></i>
        </button>
        <div style="
            position:absolute;bottom:0;left:0;
            height:3px;background:linear-gradient(90deg,#f97316,#ea580c);
            border-radius:0 0 12px 0;
            animation:admToastShrink 6s linear forwards;
            transform-origin:left"></div>`;

    /* Shimmer sweep pseudo-element via inline keyframe */
    if (!document.getElementById('adm-toast-kf')) {
        const kf = document.createElement('style');
        kf.id = 'adm-toast-kf';
        kf.textContent = `
            @keyframes admToastShrink { from{width:100%} to{width:0%} }
        `;
        document.head.appendChild(kf);
    }

    /* Click anywhere → go to messages page */
    toast.addEventListener('click', (e) => {
        if (e.target.closest(`#${id}-close`)) return;
        window.location.href = @js(route('admin.messages.index'));
    });

    /* Close button */
    toast.addEventListener('click', (e) => {
        if (!e.target.closest(`#${id}-close`)) return;
        e.stopPropagation();
        _admDismissToast(id);
    });

    /* Hover style on close button */
    toast.querySelector(`#${id}-close`).addEventListener('mouseenter', function () {
        this.style.background = '#fee2e2'; this.style.color = '#ef4444';
    });
    toast.querySelector(`#${id}-close`).addEventListener('mouseleave', function () {
        this.style.background = 'none'; this.style.color = '#9ca3af';
    });

    container.appendChild(toast);

    /* Animate in */
    requestAnimationFrame(() => requestAnimationFrame(() => {
        toast.style.transform = 'translateX(0)';
        toast.style.opacity   = '1';
    }));

    /* Auto-dismiss after 6 s */
    toast._timer = setTimeout(() => _admDismissToast(id), 6000);
}

function _admDismissToast(id) {
    const el = document.getElementById(id);
    if (!el) return;
    clearTimeout(el._timer);
    el.style.transition = 'transform .3s ease, opacity .22s ease';
    el.style.transform  = 'translateX(115%)';
    el.style.opacity    = '0';
    setTimeout(() => el.remove(), 340);
}

/* ═══ BROWSER TAB TITLE FLASH ═════════════════════════════════ */
function _admFlashTab(delta) {
    const base  = document.title.replace(/^\(\d+\)\s*/, '');
    let   flip  = true;
    const timer = setInterval(() => {
        document.title = flip ? `(${delta}) New message!` : base;
        flip = !flip;
    }, 700);
    setTimeout(() => {
        clearInterval(timer);
        const cur = parseInt(
            document.querySelector('.adm-nav-msg-badge')?.dataset?.count ?? '0', 10
        );
        document.title = cur > 0 ? `(${cur}) ${base}` : base;
    }, 5000);
}

/* ═══ SIDEBAR BADGE ═══════════════════════════════════════════ */
/**
 * @param {number|null} absolute  – set to exact count (pass null to skip)
 * @param {number}      delta     – increment (used when absolute is null)
 */
function _admBadgeSet(absolute, delta = 0) {
    document.querySelectorAll('.adm-nav-msg-badge').forEach(el => {
        const cur = absolute !== null
            ? absolute
            : (parseInt(el.dataset.count ?? '0', 10) + delta);

        el.dataset.count = String(Math.max(0, cur));

        if (cur > 0) {
            el.textContent   = cur > 99 ? '99+' : String(cur);
            el.style.display = 'inline-flex';
            /* Pop animation */
            el.animate(
                [{ transform:'scale(0)', opacity:'0' },
                 { transform:'scale(1.2)' },
                 { transform:'scale(1)',  opacity:'1' }],
                { duration: 350, easing: 'cubic-bezier(.34,1.56,.64,1)', fill: 'forwards' }
            );
        } else {
            el.style.display = 'none';
        }
    });
}

/* ═══ UTILITY ══════════════════════════════════════════════════ */
function _admEsc(str) {
    const d = document.createElement('div');
    d.textContent = String(str ?? '');
    return d.innerHTML;
}

/* Resume AudioContext on first user interaction */
document.addEventListener('click', () => {
    try {
        const c = new (window.AudioContext || window.webkitAudioContext)();
        if (c.state === 'suspended') c.resume();
    } catch (_) {}
}, { once: true });
</script>
@endscript