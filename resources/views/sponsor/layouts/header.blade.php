{{-- resources/views/sponsor/layouts/header.blade.php --}}

{{-- ── All shared sponsor styles live here so every page gets them ── --}}
<style>
/* ── Message badge (driven by MessageNotifier) ── */
.msg-notif-badge {
    display: none; align-items: center; justify-content: center;
    min-width: 17px; height: 17px; padding: 0 5px;
    background: #f97316; color: #fff;
    font-size: 9px; font-weight: 900; border-radius: 999px; line-height: 1;
    margin-left: 3px;
    animation: msgBadgePop .3s cubic-bezier(.34,1.56,.64,1) both;
}
.mob-msg-badge-wrap { position: relative; display: inline-flex; }
.mob-msg-badge-wrap .msg-notif-badge {
    position: absolute; top: -5px; right: -7px;
    min-width: 15px; height: 15px; font-size: 8px; padding: 0 4px;
    border: 2px solid rgba(255,255,255,.97); margin-left: 0;
}
@keyframes msgBadgePop {
    from { transform: scale(0); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}

/* ── Notification bell button ── */
.notif-btn {
    position: relative; width: 38px; height: 38px;
    background: #fff; border: 1px solid var(--border); border-radius: 11px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    color: var(--muted); font-size: 15px; transition: all .18s; font-family: inherit;
}
.notif-btn:hover { border-color: var(--orange); color: var(--orange); }
.notif-badge {
    position: absolute; top: -5px; right: -5px;
    width: 18px; height: 18px; background: var(--orange);
    border-radius: 50%; color: #fff; font-size: 9px; font-weight: 900;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid #fcfbfa; line-height: 1;
    animation: msgBadgePop .3s cubic-bezier(.34,1.56,.64,1) both;
}

/* ── Notification panel ── */
.notif-panel {
    position: absolute; top: calc(100% + 10px); right: 0;
    width: 340px; background: #fff; border-radius: 18px;
    border: 1px solid var(--border); box-shadow: 0 20px 60px rgba(0,0,0,.13);
    opacity: 0; visibility: hidden; transform: translateY(-8px) scale(.97);
    transition: all .22s cubic-bezier(.34,1.3,.64,1); z-index: 999; overflow: hidden;
}
.notif-panel.open { opacity: 1; visibility: visible; transform: none; }
.notif-header { padding: 14px 16px 0; border-bottom: 1px solid var(--border); }
.notif-title-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
.notif-tabs { display: flex; }
.ntab {
    flex: 1; padding: 8px 10px; font-size: 12px; font-weight: 700;
    border: none; background: none; cursor: pointer; font-family: inherit;
    color: var(--muted); border-bottom: 2px solid transparent;
    transition: color .18s, border-color .18s;
    display: flex; align-items: center; justify-content: center; gap: 5px;
}
.ntab.active { color: var(--orange); border-bottom-color: var(--orange); }
.ntab-count {
    background: #f1f5f9; color: var(--muted);
    border-radius: 999px; padding: 1px 7px; font-size: 10px; font-weight: 800;
}
.ntab.active .ntab-count { background: var(--brand-lt); color: var(--orange); }

/* Unread count pill inside each tab label */
.ntab-unread-pill {
    display: inline-flex; align-items: center; justify-content: center;
    background: #f97316; color: #fff; border-radius: 999px;
    font-size: 8px; font-weight: 900; padding: 1px 5px; margin-left: 2px; line-height: 1;
    animation: ntabPop .3s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes ntabPop { from{transform:scale(0);opacity:0} to{transform:scale(1);opacity:1} }

.notif-body {
    max-height: 320px; overflow-y: auto;
    scrollbar-width: thin; scrollbar-color: #e5e7eb transparent;
}
.notif-body::-webkit-scrollbar { width: 3px; }
.notif-body::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 3px; }

/* ── Notification items ── */
.nitem {
    padding: 12px 16px; display: flex; gap: 11px; align-items: flex-start;
    border-bottom: 1px solid var(--border); transition: background .15s;
    border-left: 3px solid transparent; /* reserve space so layout doesn't shift */
}
.nitem:last-child { border-bottom: none; }
.nitem:hover { background: #fafaf8; }
.nitem.unread { background: #fffbf6; border-left-color: #f97316; }

.nitem-icon {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 14px;
}
.nitem-icon.child  { background: var(--brand-lt); color: var(--brand); }
.nitem-icon.family { background: #dbeafe; color: #1e40af; }
.nitem-icon.doc    { background: #fee2e2; color: #ef4444; }
.nitem-content { flex: 1; min-width: 0; }
.nitem-meta  { display: flex; align-items: center; gap: 5px; margin-bottom: 3px; flex-wrap: wrap; }
.nitem-entity{ font-size: 11px; color: var(--muted); font-weight: 600; }
.nitem-date  { font-size: 11px; color: var(--muted); }
.nitem-title {
    font-size: 13px; font-weight: 700; color: var(--dark); margin-bottom: 2px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.nitem-text  {
    font-size: 12px; color: var(--muted); line-height: 1.55;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.nitem-dot   {
    width: 7px; height: 7px; background: var(--orange);
    border-radius: 50%; flex-shrink: 0; margin-top: 5px;
}
.nitem-dl {
    width: 28px; height: 28px; border-radius: 7px; flex-shrink: 0;
    background: #f3f2ee; color: var(--muted); border: none;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none; transition: all .18s; font-size: 11px; cursor: pointer;
}
.nitem-dl:hover { background: var(--orange); color: #fff; transform: scale(1.08); }

.notif-footer { padding: 11px 16px; border-top: 1px solid var(--border); text-align: center; }
.notif-footer a {
    font-size: 12px; color: var(--orange); font-weight: 700;
    text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
}
.notif-footer a:hover { color: #d97000; }

/* ── Type badges (shared across notifications + updates timeline) ── */
.type-badge {
    display: inline-flex; align-items: center;
    font-size: 10px; font-weight: 800; padding: 2px 8px;
    border-radius: 999px; margin-right: 4px; text-transform: capitalize;
}
.badge-health    { background:#fef3c7;color:#f97316; }
.badge-education { background:#dbeafe;color:#1e40af; }
.badge-study     { background:#e0e7ff;color:#3730a3; }
.badge-financial { background:#fef9c3;color:#854d0e; }
.badge-general   { background:#f1f5f9;color:#475569; }
.badge-visit     { background:#fce7f3;color:#9d174d; }

/* Alpine: hide before init */
[x-cloak] { display: none !important; }

@media (max-width:640px) {
    .notif-panel { width: calc(100vw - 28px); right: -14px; }
}
</style>

<header class="site-header">
    <div class="header-inner">

        {{-- Logo --}}
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" class="hdr-logo"
                 alt="{{ $settings['site_name'] ?? 'Logo' }}">
        </a>

        {{-- Desktop nav --}}
        <nav class="hdr-nav">
            <a href="{{ route('sponsor.dashboard') }}"
               class="hdr-nav-link {{ request()->routeIs('sponsor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-user-friends" style="font-size:12px"></i> My Child
            </a>

            {{-- Messages — badge updated in real-time by MessageNotifier --}}
            <a href="{{ route('sponsor.messages.home') }}"
               class="hdr-nav-link {{ request()->routeIs('sponsor.messages.home', 'sponsor.messages.*') ? 'active' : '' }}"
               style="position:relative">
                <i class="far fa-envelope" style="font-size:12px"></i>
                Messages
                <span class="msg-notif-badge" aria-label="unread messages"></span>
            </a>

            <a href="{{ route('sponsor.sponsorship') }}"
               class="hdr-nav-link {{ request()->routeIs('sponsor.sponsorship') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-heart" style="font-size:12px"></i> Sponsorship
            </a>
            <a href="{{ route('sponsor.news') }}"
               class="hdr-nav-link {{ request()->routeIs('sponsor.news') ? 'active' : '' }}">
                <i class="far fa-newspaper" style="font-size:12px"></i> News
            </a>
        </nav>

        <div class="hdr-right">

            {{-- ── Language switcher ── --}}
            <div style="position:relative" id="dash-translate-wrapper">
                <div id="google_translate_element" style="display:none;position:absolute"></div>
                <button class="lang-pill" onclick="dashTogglePanel()" id="dash-translate-toggle">
                    <img src="https://flagcdn.com/w40/fr.png" id="dash-flag"
                         style="width:20px;height:13px;border-radius:2px;object-fit:cover" alt="">
                    <span id="dash-lang-label">FR</span>
                    <i class="fas fa-chevron-down"
                       style="font-size:8px;color:#9ca3af;transition:transform .2s"
                       id="dash-caret"></i>
                </button>
                <div id="dash-translate-panel">
                    <p style="font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;
                              letter-spacing:.08em;padding:4px 4px 8px;
                              display:flex;align-items:center;gap:6px">
                        <i class="fas fa-globe" style="color:var(--orange)"></i> Language
                    </p>
                    <button class="lang-opt" id="dash-btn-en" onclick="dashSwitchLang('en')">
                        <img src="https://flagcdn.com/w40/us.png" class="flag" alt="">
                        <div><div style="font-weight:700">English</div>
                             <div style="font-size:10px;color:#9ca3af">Original</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-en"></i>
                    </button>
                    <button class="lang-opt" id="dash-btn-fr" onclick="dashSwitchLang('fr')">
                        <img src="https://flagcdn.com/w40/fr.png" class="flag" alt="">
                        <div><div style="font-weight:700">Français</div>
                             <div style="font-size:10px;color:#9ca3af">French</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-fr"></i>
                    </button>
                    <button class="lang-opt" id="dash-btn-km" onclick="dashSwitchLang('km')">
                        <img src="https://flagcdn.com/w40/kh.png" class="flag" alt="">
                        <div><div style="font-weight:700">ខ្មែរ</div>
                             <div style="font-size:10px;color:#9ca3af">Cambodian</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-km"></i>
                    </button>
                </div>
            </div>

            {{-- ── Notification bell — Livewire + Alpine (single root <div>) ── --}}
            @livewire('notification-bell')

            {{-- Sponsor chip --}}
            <div class="sponsor-chip hidden md:flex">
                <div class="s-avatar">{{ strtoupper(substr($sponsor->first_name, 0, 1)) }}</div>
                <div>
                    <div class="s-name">{{ $sponsor->full_name }}</div>
                    <div class="s-email">{{ $sponsor->email }}</div>
                </div>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('sponsor.logout') }}">
                @csrf
                <button class="logout-btn">
                    <i class="fas fa-sign-out-alt" style="font-size:11px"></i>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>

        </div>
    </div>
</header>

{{-- Hidden component: polls unread admin messages every 5 s, updates .msg-notif-badge --}}
@livewire('message-notifier')