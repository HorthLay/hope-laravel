{{--
    resources/views/admin/partials/nav-messages-item.blade.php
    ──────────────────────────────────────────────────────────
    Drop-in replacement for the Team Support nav link.
    Include in admin.layouts.app where the nav link currently is.

    Requires:
      • Alpine.js (already in admin layout)
      • Route: admin.messages.unread  →  returns { count: N }
      • Route: admin.messages.index
--}}

<div
    x-data="adminMsgBadge()"
    x-init="init()"
    class="relative"
    style="display:inline-flex;width:100%"
>
    {{-- Nav link --}}
    <a
        href="{{ route('admin.messages.index') }}"
        class="nav-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"
        style="flex:1"
    >
        <i class="fas fa-comments"></i>
        <span class="font-medium">Team Support</span>

        {{-- Inline badge (sits inside the nav row, right-aligned) --}}
        <span
            x-show="count > 0"
            x-text="count > 99 ? '99+' : count"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100"
            class="ml-auto min-w-[18px] h-[18px] px-1
                   bg-red-500 text-white
                   text-[9px] font-black leading-none
                   rounded-full flex items-center justify-center
                   pointer-events-none"
            style="display:none"
        ></span>
    </a>
</div>

{{-- ── Toast container (rendered once, reused for all toasts) ── --}}
@once
<div id="adm-notif-container"
     style="position:fixed;top:80px;right:20px;z-index:9999;
            display:flex;flex-direction:column;gap:10px;
            width:320px;max-width:calc(100vw - 32px);
            pointer-events:none">
</div>

<style>
.adm-notif-toast {
    pointer-events: all;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    border-left: 4px solid #ef4444;
    padding: 13px 13px 16px;
    box-shadow: 0 12px 40px rgba(0,0,0,.18);
    position: relative;
    overflow: hidden;
    cursor: pointer;
    /* start off-screen */
    transform: translateX(110%);
    opacity: 0;
    transition: transform .38s cubic-bezier(.34,1.56,.64,1),
                opacity   .28s ease;
}
.adm-notif-toast.adm-toast-in  { transform: translateX(0); opacity: 1; }
.adm-notif-toast.adm-toast-out {
    transform: translateX(110%); opacity: 0;
    transition: transform .3s ease, opacity .22s ease;
}
/* shimmer sweep */
.adm-notif-toast::after {
    content:'';
    position:absolute;inset:0;
    background:linear-gradient(90deg,transparent,rgba(239,68,68,.07),transparent);
    transform:translateX(-100%);
    animation:admToastShimmer .6s .35s ease forwards;
    pointer-events:none;
}
@keyframes admToastShimmer { to { transform:translateX(100%); } }

/* avatar */
.adm-toast-avatar {
    width:40px;height:40px;border-radius:11px;flex-shrink:0;
    background:linear-gradient(135deg,#f97316,#ea580c);
    color:#fff;font-size:15px;font-weight:900;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 3px 10px rgba(249,115,22,.35);
}
/* body */
.adm-toast-body  { flex:1;min-width:0; }
.adm-toast-head  { display:flex;align-items:center;gap:7px;margin-bottom:3px; }
.adm-toast-name  {
    font-size:13px;font-weight:800;color:#111827;
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:155px;
}
.adm-toast-new   {
    font-size:9px;font-weight:900;padding:2px 6px;
    border-radius:999px;background:#ef4444;color:#fff;
    white-space:nowrap;flex-shrink:0;
}
.adm-toast-sub   {
    font-size:10px;font-weight:700;color:#9ca3af;
    display:flex;align-items:center;gap:4px;margin-bottom:3px;
}
.adm-toast-preview {
    font-size:12px;color:#6b7280;font-weight:500;line-height:1.5;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
/* close */
.adm-toast-close {
    background:none;border:none;cursor:pointer;
    color:#9ca3af;font-size:12px;padding:3px 5px;
    line-height:1;border-radius:6px;transition:all .15s;flex-shrink:0;
}
.adm-toast-close:hover { background:#fee2e2;color:#ef4444; }
/* progress bar */
.adm-toast-bar {
    position:absolute;bottom:0;left:0;
    height:3px;background:linear-gradient(90deg,#ef4444,#f97316);
    border-radius:0 0 12px 0;
    animation:admToastShrink 6s linear forwards;
    transform-origin:left;
}
@keyframes admToastShrink { from{width:100%} to{width:0%} }
</style>

<script>
if (typeof adminMsgBadge === 'undefined') {

    /* ─────────────────────────────────────────────────────────────
       WEB AUDIO  —  two-note ascending "ping"  (E5 → A5)
    ───────────────────────────────────────────────────────────── */
    function playAdminNotifSound() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            [
                { freq: 659.25, start: 0,    dur: 0.20 },
                { freq: 880.00, start: 0.14, dur: 0.30 },
            ].forEach(({ freq, start, dur }) => {
                const osc  = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination);
                osc.type = 'sine'; osc.frequency.value = freq;
                const t = ctx.currentTime + start;
                gain.gain.setValueAtTime(0, t);
                gain.gain.linearRampToValueAtTime(0.22, t + 0.012);
                gain.gain.exponentialRampToValueAtTime(0.001, t + dur);
                osc.start(t); osc.stop(t + dur + 0.01);
            });
        } catch (_) {}
    }

    /* ─────────────────────────────────────────────────────────────
       TOAST
    ───────────────────────────────────────────────────────────── */
    function showAdminMsgToast(sponsorName, sponsorInit, preview, newCount) {
        const container = document.getElementById('adm-notif-container');
        if (!container) return;

        const id    = 'adm-t-' + Date.now();
        const toast = document.createElement('div');
        toast.id    = id;
        toast.className = 'adm-notif-toast';

        toast.innerHTML = `
            <div class="adm-toast-avatar">${_admEsc(sponsorInit)}</div>
            <div class="adm-toast-body">
                <div class="adm-toast-head">
                    <span class="adm-toast-name">${_admEsc(sponsorName)}</span>
                    <span class="adm-toast-new">${newCount > 1 ? newCount + ' new' : 'New'}</span>
                </div>
                <div class="adm-toast-sub">
                    <i class="fas fa-headset" style="font-size:9px"></i> Support message
                </div>
                <div class="adm-toast-preview">${_admEsc(preview)}</div>
            </div>
            <button class="adm-toast-close" title="Dismiss">
                <i class="fas fa-times"></i>
            </button>
            <div class="adm-toast-bar"></div>`;

        /* Click body → go to messages */
        toast.addEventListener('click', (e) => {
            if (e.target.closest('.adm-toast-close')) return;
            window.location.href = '{{ route("admin.messages.index") }}';
        });

        /* Close button */
        toast.querySelector('.adm-toast-close').addEventListener('click', (e) => {
            e.stopPropagation();
            _admDismissToast(id);
        });

        container.appendChild(toast);

        /* Slide in */
        requestAnimationFrame(() => requestAnimationFrame(() => {
            toast.classList.add('adm-toast-in');
        }));

        /* Auto-dismiss after 6 s */
        const timer = setTimeout(() => _admDismissToast(id), 6000);
        toast._timer = timer;
    }

    function _admDismissToast(id) {
        const el = document.getElementById(id);
        if (!el) return;
        clearTimeout(el._timer);
        el.classList.remove('adm-toast-in');
        el.classList.add('adm-toast-out');
        setTimeout(() => el.remove(), 340);
    }

    function _admEsc(str) {
        const d = document.createElement('div');
        d.textContent = String(str ?? '');
        return d.innerHTML;
    }

    /* ─────────────────────────────────────────────────────────────
       TAB TITLE FLASH
    ───────────────────────────────────────────────────────────── */
    function flashTabTitle(count) {
        const orig  = document.title.replace(/^\(\d+\)\s*/, '');
        let   flip  = true;
        const timer = setInterval(() => {
            document.title = flip ? `(${count}) New message!` : orig;
            flip = !flip;
        }, 700);
        setTimeout(() => {
            clearInterval(timer);
            document.title = count > 0 ? `(${count}) ${orig}` : orig;
        }, 5000);
    }

    /* ─────────────────────────────────────────────────────────────
       ALPINE COMPONENT
    ───────────────────────────────────────────────────────────── */
    window.adminMsgBadge = function () {
        return {
            count:     0,
            prevCount: null,   // null = first fetch → no sound/toast yet
            _timer:    null,

            init() {
                this.fetchCount();
                this._timer = setInterval(() => this.fetchCount(), 5000);

                /* Resume AudioContext on first click (browser autoplay policy) */
                document.addEventListener('click', () => {
                    try {
                        const ctx = new (window.AudioContext || window.webkitAudioContext)();
                        if (ctx.state === 'suspended') ctx.resume();
                    } catch (_) {}
                }, { once: true });
            },

            async fetchCount() {
                try {
                    const res  = await fetch('{{ route("admin.messages.unread") }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (!res.ok) return;
                    const data = await res.json();

                    const n          = data.count         ?? 0;
                    const sponsorName = data.sponsor_name ?? 'Sponsor';
                    const sponsorInit = data.sponsor_init ?? '?';
                    const preview     = data.preview      ?? '';

                    /* Act only when count genuinely increases (skip first load) */
                    if (this.prevCount !== null && n > this.prevCount) {
                        const delta = n - this.prevCount;
                        playAdminNotifSound();
                        showAdminMsgToast(sponsorName, sponsorInit, preview, delta);
                        flashTabTitle(n);
                    }

                    this.prevCount = n;
                    this.count     = n;
                } catch (_) { /* network error — silently skip */ }
            }
        };
    };
}
</script>
@endonce