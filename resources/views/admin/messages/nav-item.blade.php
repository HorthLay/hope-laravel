{{--
    resources/views/admin/partials/nav-messages-item.blade.php
    ──────────────────────────────────────────────────────────
    Drop-in replacement for the Team Support nav link.
    Include in admin.layouts.app where the nav link currently is.

    Requires:
      • Alpine.js (already in admin layout)
      • Route: admin.messages.unread  →  MessageAdminController@unreadCount
      • Route: admin.messages.index
--}}

<div
    x-data="adminMsgBadge()"
    x-init="init()"
    class="relative"
    style="display:inline-flex"
>
    {{-- Nav link (unchanged styling) --}}
    <a
        href="{{ route('admin.messages.index') }}"
        class="nav-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"
    >
        <i class="fas fa-comments"></i>
        <span class="font-medium">Team Support</span>
    </a>

    {{-- Badge dot --}}
    <span
        x-show="count > 0"
        x-text="count > 9 ? '9+' : count"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        class="absolute -top-1.5 -right-1.5
               min-w-[18px] h-[18px] px-1
               bg-red-500 text-white
               text-[9px] font-black leading-none
               rounded-full flex items-center justify-center
               ring-2 ring-white
               pointer-events-none"
        style="display:none"
    ></span>
</div>

{{--
    Global Alpine component + notification sound.
    Defined once here so it works on ALL admin pages (not just /messages).
--}}
<script>
if (typeof adminMsgBadge === 'undefined') {
    /* ── Web Audio notification sound ── */
    function playAdminNotifSound() {
        try {
            const ctx  = new (window.AudioContext || window.webkitAudioContext)();

            // Two-note ascending "ping"  (E5 → A5)
            const notes = [
                { freq: 659.25, start: 0,    dur: 0.18 },
                { freq: 880.00, start: 0.13, dur: 0.26 },
            ];

            notes.forEach(({ freq, start, dur }) => {
                const osc  = ctx.createOscillator();
                const gain = ctx.createGain();

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.type = 'sine';
                osc.frequency.value = freq;

                const t0 = ctx.currentTime + start;
                gain.gain.setValueAtTime(0, t0);
                gain.gain.linearRampToValueAtTime(0.22, t0 + 0.01);
                gain.gain.exponentialRampToValueAtTime(0.001, t0 + dur);

                osc.start(t0);
                osc.stop(t0 + dur + 0.01);
            });
        } catch (e) { /* AudioContext blocked or unavailable */ }
    }

    /* ── Alpine component ── */
    window.adminMsgBadge = function () {
        return {
            count:     0,
            prevCount: null,   // null = first fetch, no sound yet
            _timer:    null,

            init() {
                this.fetchCount();
                this._timer = setInterval(() => this.fetchCount(), 5000);
                // Resume AudioContext on first user interaction (browser autoplay policy)
                document.addEventListener('click', () => {
                    try {
                        const ctx = new (window.AudioContext || window.webkitAudioContext)();
                        if (ctx.state === 'suspended') ctx.resume();
                    } catch (e) {}
                }, { once: true });
            },

            async fetchCount() {
                try {
                    const res  = await fetch('{{ route("admin.messages.unread") }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await res.json();
                    const n    = data.count ?? 0;

                    // Play sound only when count genuinely increases (skip first load)
                    if (this.prevCount !== null && n > this.prevCount) {
                        playAdminNotifSound();

                        // Also flash the browser tab title briefly
                        const orig = document.title;
                        let flashing = true;
                        const flashInterval = setInterval(() => {
                            document.title = flashing
                                ? `(${n}) New message!`
                                : orig;
                            flashing = !flashing;
                        }, 700);
                        setTimeout(() => {
                            clearInterval(flashInterval);
                            document.title = orig;
                        }, 5000);
                    }

                    this.prevCount = n;
                    this.count     = n;
                } catch (e) { /* network error — silently skip */ }
            }
        };
    };
}
</script>