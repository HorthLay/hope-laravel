{{-- resources/views/layouts/header.blade.php --}}
{{-- Design: Children of the Mekong style — top util bar + logo banner + nav bar --}}

{{-- Hidden GT widget (required by Google Translate API) --}}
<div id="google_translate_element" style="display:none;position:absolute"></div>

<style>
/* ── Reset Google toolbar ──────────────────────────────────────── */
body { top: 0 !important; }
.goog-te-banner-frame,.goog-te-balloon-frame,#goog-gt-tt,.goog-te-spinner-pos,.skiptranslate { display:none !important; }
iframe.goog-te-banner-frame { display:none !important; }

/* ══ HEADER ARCHITECTURE ══════════════════════════════════════════
   1. #util-bar     — thin top strip (flag lang, social, contact)
   2. #logo-banner  — big logo area + background image
   3. #main-nav     — full-width white nav bar + sponsor/donate CTAs
════════════════════════════════════════════════════════════════ */

/* ── 1. Utility bar ──────────────────────────────────────────── */
#util-bar {
    background: #1a2e3b;
    border-bottom: 1px solid rgba(255,255,255,.08);
    height: 38px;
    display: flex;
    align-items: center;
}
.util-bar-inner {
    max-width: 1280px; margin: 0 auto; padding: 0 24px;
    width: 100%;
    display: flex; align-items: center; justify-content: space-between;
}
.util-link {
    color: rgba(255,255,255,.7);
    font-size: 11px; font-weight: 600;
    text-transform: uppercase; letter-spacing: .06em;
    text-decoration: none;
    transition: color .18s;
    display: flex; align-items: center; gap: 5px;
}
.util-link:hover { color: #fff; }

/* ── 2. Logo banner ──────────────────────────────────────────── */
#logo-banner {
    padding: 0;
    position: relative;
    overflow: hidden;
    min-height: 160px;
    background-image: url("{{ asset('images/image.jpg') }}");
    background-size: cover;
    background-position: center 40%;
    background-repeat: no-repeat;
    background-color: #1a2e3b;
}

/*
 * ✅ UPDATED OVERLAY — much lighter so the full background photo is visible.
 * Only a gentle bottom-fade keeps the nav edge clean.
 */
#logo-banner::before {
    content: '';
    position: absolute; inset: 0;
    background:
        linear-gradient(
            to right,
            rgba(10, 25, 35, 0.55) 0%,   /* was 0.92 — now much lighter */
            rgba(10, 25, 35, 0.30) 30%,
            rgba(10, 25, 35, 0.10) 55%,
            rgba(10, 25, 35, 0.05) 100%
        ),
        linear-gradient(
            to bottom,
            rgba(10, 25, 35, 0.25) 0%,
            rgba(10, 25, 35, 0.00) 30%,
            rgba(10, 25, 35, 0.00) 70%,
            rgba(10, 25, 35, 0.40) 100%
        );
    z-index: 0;
}

/*
 * ✅ LOGO GLOW — stronger warm-orange halo so logo always pops
 */
#logo-banner::after {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 14% 55%, rgba(249,115,22,.45) 0%, transparent 38%);
    z-index: 0;
    pointer-events: none;
}

.banner-inner {
    max-width: 1280px; margin: 0 auto; padding: 0 24px;
    min-height: 160px;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; z-index: 2;
}

/* Logo mark wrapper */
.logo-mark {
    display: flex; align-items: center; gap: 16px;
    text-decoration: none;
}

/* Logo text — matches the "Association DES AILES POUR GRANDIR" identity */
.logo-text-block {
    display: flex; flex-direction: column; gap: 1px;
    line-height: 1;
}
.logo-assoc {
    font-size: 15px;
    font-weight: 400;
    font-style: normal;
    letter-spacing: .06em;
    color: #ffffff;
    text-shadow: 0 1px 8px rgba(0,0,0,0.75);
    font-family: 'Georgia','Times New Roman',serif;
}
.logo-main-title {
    font-size: 26px;
    font-weight: 900;
    font-style: italic;
    letter-spacing: .02em;
    line-height: 1.08;
    color: #ffffff;
    text-shadow:
        0 2px 14px rgba(0,0,0,0.85),
        0 0 28px rgba(249,115,22,0.45);
    font-family: 'Georgia','Times New Roman',serif;
}

/*
 * ✅ LOGO IMAGE — larger, brighter, stronger shadow for full visibility
 */
.logo-img {
    height: 160px;           /* ↑ was 100px */
    width: auto;
    display: block;
    /* Brightness boost + vivid drop-shadow so it reads on any background */
    filter:
        brightness(1.18)
        saturate(1.25)
        drop-shadow(0 0 18px rgba(249,115,22,0.65))
        drop-shadow(0 4px 22px rgba(0,0,0,0.70))
        drop-shadow(0 1px 5px rgba(0,0,0,0.50));
    transition: filter .25s, transform .25s;
}
.logo-mark:hover .logo-img {
    filter:
        brightness(1.28)
        saturate(1.35)
        drop-shadow(0 0 28px rgba(249,115,22,0.85))
        drop-shadow(0 6px 28px rgba(0,0,0,0.65))
        drop-shadow(0 2px 7px rgba(0,0,0,0.45));
    transform: translateY(-3px) scale(1.03);
}

/*
 * ✅ ORG NAME TEXT — displayed beside logo so it's always readable
 */
.logo-text-block {
    display: flex; flex-direction: column; gap: 2px;
}
.logo-title {
    font-size: 22px;
    font-weight: 900;
    letter-spacing: .02em;
    line-height: 1.15;
    color: #ffffff;
    text-shadow:
        0 2px 12px rgba(0,0,0,0.80),
        0 0 30px rgba(249,115,22,0.50);
}
.logo-title span { color: #f97316; }
.logo-subtitle {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: rgba(255,255,255,.72);
    text-shadow: 0 1px 8px rgba(0,0,0,0.70);
}

/* Newsletter / subscribe CTA in banner */
.banner-cta-group { display: flex; align-items: center; gap: 12px; }
.subscribe-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 20px;
    background: #2ecc71;
    color: #fff; font-size: 12px; font-weight: 800;
    text-transform: uppercase; letter-spacing: .08em;
    border-radius: 6px; text-decoration: none;
    transition: background .2s, transform .15s;
    box-shadow: 0 4px 14px rgba(46,204,113,.35);
}
.subscribe-btn:hover { background: #27ae60; transform: translateY(-1px); color: #fff; }

/* ── 3. Main nav bar ─────────────────────────────────────────── */
#main-nav {
    background: #fff;
    border-bottom: 3px solid #e5e7eb;
    position: sticky; top: 0; z-index: 1000;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.nav-inner {
    max-width: 1280px; margin: 0 auto;
    display: flex; align-items: stretch;
}
.nav-links {
    display: flex; align-items: stretch; flex: 1;
}
.nav-item-link {
    display: flex; align-items: center;
    padding: 0 20px; height: 52px;
    font-size: 12px; font-weight: 800;
    text-transform: uppercase; letter-spacing: .07em;
    color: #1e3a4a; text-decoration: none;
    border-bottom: 3px solid transparent;
    margin-bottom: -3px;
    transition: color .18s, border-color .18s, background .18s;
    white-space: nowrap;
}
.nav-item-link:hover {
    color: #f97316;
    border-bottom-color: #f97316;
    background: #fff7ed;
}
.nav-item-link.active-nav {
    color: #f97316;
    border-bottom-color: #f97316;
}

/* CTA buttons in nav */
.nav-ctas { display: flex; align-items: stretch; flex-shrink: 0; }
.nav-cta-sponsor {
    display: flex; align-items: center; gap: 8px;
    padding: 0 22px; height: 52px;
    background: #f5c518;
    color: #1a1a1a; font-size: 12px; font-weight: 900;
    text-transform: uppercase; letter-spacing: .06em;
    text-decoration: none;
    transition: background .2s;
    white-space: nowrap;
}
.nav-cta-sponsor:hover { background: #e6b800; color: #1a1a1a; }

.nav-cta-donate {
    display: flex; align-items: center; gap: 8px;
    padding: 0 22px; height: 52px;
    background: #2ecc71;
    color: #fff; font-size: 12px; font-weight: 900;
    text-transform: uppercase; letter-spacing: .06em;
    text-decoration: none;
    transition: background .2s;
    white-space: nowrap;
}
.nav-cta-donate:hover { background: #27ae60; color: #fff; }

/* ── Language switcher (in util bar) ─────────────────────────── */
.lang-pill-util {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px 3px 6px;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,.2);
    background: rgba(255,255,255,.07);
    cursor: pointer;
    font-size: 11px; font-weight: 700;
    color: rgba(255,255,255,.8);
    transition: all .18s;
    white-space: nowrap;
}
.lang-pill-util:hover { border-color: rgba(255,255,255,.5); color: #fff; background: rgba(255,255,255,.12); }
#translate-panel {
    position: absolute; top: calc(100% + 6px); left: 0;
    width: 210px;
    background: #fff; border-radius: 12px;
    box-shadow: 0 12px 40px rgba(0,0,0,.18);
    border: 1px solid #f0f0f0;
    padding: 10px;
    opacity: 0; visibility: hidden;
    transform: translateY(-6px);
    transition: all .22s cubic-bezier(.34,1.56,.64,1);
    z-index: 9999;
}
#translate-panel.open { opacity:1; visibility:visible; transform:translateY(0); }
.lang-option-btn {
    display: flex; align-items: center; gap: 9px;
    width: 100%; padding: 8px 10px;
    border-radius: 8px; border: 2px solid transparent;
    background: transparent; cursor: pointer;
    transition: all .15s; text-align: left;
    font-size: 12px; font-weight: 600; color: #374151;
}
.lang-option-btn:hover { background: #fff7ed; border-color: #fed7aa; }
.lang-option-btn.active { background: linear-gradient(135deg,#fff7ed,#ffedd5); border-color: #f97316; color: #c2410c; }
.lang-option-btn .flag { width: 24px; height: 16px; object-fit: cover; border-radius: 2px; box-shadow: 0 1px 4px rgba(0,0,0,.15); flex-shrink:0; }
.lang-option-btn .check { margin-left: auto; color: #f97316; font-size: 10px; }

@keyframes spin { to { transform: rotate(360deg); } }
.gt-spin { display:inline-block; animation: spin .7s linear infinite; }

/* ── Mobile nav ──────────────────────────────────────────────── */
#mobile-topbar {
    background: #1e3a4a;
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 16px;
}
#mobile-nav-bar {
    background: #fff;
    border-bottom: 3px solid #e5e7eb;
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    position: sticky; top: 0; z-index: 1000;
}

/* Mobile menu drawer */
.mobile-menu-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:1090; }
.mobile-menu-overlay.active { display:block; }
.mobile-menu {
    position: fixed; top: 0; right: -100%; width: min(340px, 90vw);
    height: 100dvh; background: #fff;
    z-index: 1100; transition: right .32s cubic-bezier(.4,0,.2,1);
    overflow-y: auto;
}
.mobile-menu.active { right: 0; }

/* Mobile lang panel */
#translate-panel-mobile { background: #f9fafb; border-radius: 12px; padding: 12px; margin-bottom: 14px; }
.mobile-lang-btn {
    flex: 1; display: flex; flex-direction: column; align-items: center; gap: 5px;
    padding: 9px 4px; border-radius: 8px; border: 2px solid #e5e7eb;
    background: #fff; cursor: pointer; transition: all .18s;
    font-size: 10px; font-weight: 700; color: #374151;
}
.mobile-lang-btn:hover { border-color: #f97316; background: #fff7ed; }
.mobile-lang-btn.active {
    border-color: #f97316; background: linear-gradient(135deg,#fff7ed,#ffedd5);
    color: #c2410c; box-shadow: 0 4px 12px rgba(249,115,22,.2);
}
.mobile-lang-btn img { width: 30px; height: 20px; object-fit: cover; border-radius: 2px; box-shadow: 0 1px 4px rgba(0,0,0,.15); }
.mobile-menu-link {
    display: flex; align-items: center; gap: 12px;
    padding: 13px 16px; color: #1e3a4a; font-size: 13px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .04em;
    text-decoration: none; border-bottom: 1px solid #f3f4f6;
    transition: background .15s, color .15s;
}
.mobile-menu-link:hover { background: #fff7ed; color: #f97316; }

@media (max-width: 1023px) {
    #util-bar, #logo-banner, #main-nav { display: none; }
}
@media (min-width: 1024px) {
    #mobile-topbar, #mobile-nav-bar { display: none; }
}
</style>

{{-- ════════════════════════════════════════════════════
     DESKTOP HEADER (≥ lg / 1024px)
════════════════════════════════════════════════════ --}}

{{-- 1. Utility bar --}}
<div id="util-bar">
    <div class="util-bar-inner">

        {{-- Left: language switcher --}}
        <div class="relative" id="translate-wrapper">
            <button class="lang-pill-util" onclick="toggleTranslatePanel()" id="translate-toggle">
                <img src="https://flagcdn.com/w40/us.png" id="desktop-flag" class="w-5 h-3.5 rounded object-cover" alt="EN">
                <span id="desktop-lang-label">EN</span>
                <i class="fas fa-chevron-down text-[9px] opacity-60" id="translate-caret"></i>
            </button>
            <div id="translate-panel">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-1 mb-2">
                    <i class="fas fa-globe mr-1 text-orange-400"></i> Language
                </p>
                <button class="lang-option-btn active" id="btn-en" onclick="switchLanguage('en')">
                    <img src="https://flagcdn.com/w40/us.png" class="flag" alt="EN">
                    <div><div>English</div><div class="text-[10px] font-normal text-gray-400">Original</div></div>
                    <i class="fas fa-check check" id="check-en"></i>
                </button>
                <button class="lang-option-btn" id="btn-km" onclick="switchLanguage('km')">
                    <img src="https://flagcdn.com/w40/kh.png" class="flag" alt="KM">
                    <div><div>ខ្មែរ (Khmer)</div><div class="text-[10px] font-normal text-gray-400">Cambodian</div></div>
                    <i class="fas fa-check check hidden" id="check-km"></i>
                </button>
                <button class="lang-option-btn" id="btn-fr" onclick="switchLanguage('fr')">
                    <img src="https://flagcdn.com/w40/fr.png" class="flag" alt="FR">
                    <div><div>Français</div><div class="text-[10px] font-normal text-gray-400">French</div></div>
                    <i class="fas fa-check check hidden" id="check-fr"></i>
                </button>
                <div class="mt-2 pt-2 border-t border-gray-100">
                    <button onclick="autoDetectAndTranslate()"
                            class="w-full flex items-center justify-center gap-2 py-2 rounded-lg bg-orange-50 hover:bg-orange-100 text-orange-600 text-xs font-bold transition border border-orange-200"
                            id="auto-translate-btn">
                        <i class="fas fa-magic text-[10px]"></i> Auto Translate
                    </button>
                </div>
            </div>
        </div>

        {{-- Right: social + contact links --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}#contact" class="util-link">
                <i class="fas fa-phone-alt text-[10px]"></i>
                <span data-en="Contact" data-km="ទំនាក់ទំនង" data-fr="Contact">Contact</span>
            </a>
            <span class="text-white/20">|</span>
            <a href="https://facebook.com" target="_blank" class="util-link"><i class="fab fa-facebook-f text-[11px]"></i></a>
            <a href="https://instagram.com" target="_blank" class="util-link"><i class="fab fa-instagram text-[11px]"></i></a>
            <a href="https://youtube.com" target="_blank" class="util-link"><i class="fab fa-youtube text-[11px]"></i></a>
            <span class="text-white/20">|</span>
            <span id="mobile-lang-badge" class="text-[11px] font-bold text-orange-400">FR</span>
        </div>
    </div>
</div>

{{-- 2. Logo banner --}}
<div id="logo-banner">
    <div class="banner-inner">

        {{-- Logo + text --}}
        <a href="{{ route('home') }}" class="logo-mark">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Association Des Ailes Pour Grandir Logo"
                 class="logo-img">
           
        </a>

        <div class="banner-cta-group">
            <a href="#newsletter" class="subscribe-btn">
                <i class="fas fa-heart text-sm"></i>
                <span>
                    Donate For Children
                </span>
            </a>
        </div>
    </div>
</div>

{{-- 3. Sticky nav bar --}}
<div id="main-nav">
    <div class="nav-inner">
        <nav class="nav-links">
            <a href="{{ route('home') }}#sponsor"  class="nav-item-link" data-en="Sponsor a Child"  data-km="ឧបត្ថម្ភកុមារ"    data-fr="Parrainer un enfant">Sponsor a Child</a>
            <a href="{{ route('home') }}#our-work" class="nav-item-link" data-en="What We Do"       data-km="អ្វីដែលយើងធ្វើ"   data-fr="Ce que nous faisons">What We Do</a>
            <a href="{{ route('learn-more') }}"    class="nav-item-link" data-en="Who We Are"       data-km="អំពីយើង"           data-fr="Qui sommes-nous">Who We Are</a>
            <a href="{{ route('home') }}#news"     class="nav-item-link" data-en="News &amp; Events" data-km="ព័ត៌មាន"          data-fr="Actualités">News &amp; Events</a>
        </nav>
        <div class="nav-ctas">
            @auth('sponsor')
                {{-- Logged in sponsor --}}
                <a href="{{ route('sponsor.dashboard') }}" class="nav-cta-sponsor">
                    <i class="fas fa-tachometer-alt text-base"></i>
                    <span data-en="Dashboard" data-km="ផ្ទាំងគ្រប់គ្រង" data-fr="Tableau de bord">Dashboard</span>
                </a>
                <form method="POST" action="{{ route('sponsor.logout') }}" style="display:inline;margin:0;">
                    @csrf
                    <button type="submit" class="nav-cta-donate" style="border:none;cursor:pointer;">
                        <i class="fas fa-sign-out-alt text-base"></i>
                        <span data-en="Logout" data-km="ចាកចេញ" data-fr="Déconnexion">Logout</span>
                    </button>
                </form>
            @else
                {{-- Guest user --}}
                <a href="{{ route('sponsor.contact') }}" class="nav-cta-sponsor">
                    <i class="fas fa-child text-base"></i>
                    <span data-en="Sponsor a Child" data-km="ឧបត្ថម្ភកុមារ" data-fr="Parrainer">Sponsor a Child</span>
                </a>
                <a href="{{ route('sponsor.login') }}" class="nav-cta-donate">
                    <i class="fas fa-heart text-base"></i>
                    <span data-en="Donate" data-km="ចូល" data-fr="Donation">Donate</span>
                </a>
            @endauth
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════
     MOBILE HEADER (< lg / 1024px)
════════════════════════════════════════════════════ --}}

{{-- Mobile top bar --}}
<div id="mobile-topbar">
    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
        <img src="{{ asset('images/logo.png') }}"
             alt="Association Des Ailes Pour Grandir Logo"
             style="height:70px;width:auto;filter:brightness(1.15) saturate(1.2) drop-shadow(0 2px 8px rgba(0,0,0,0.55));">
        
    </a>
    <button id="mobile-menu-btn" class="text-white/80 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition">
        <i class="fas fa-bars text-lg"></i>
    </button>
</div>

{{-- Mobile sticky nav bar --}}
<div id="mobile-nav-bar">
    @auth('sponsor')
        {{-- Logged in sponsor --}}
        <a href="{{ route('sponsor.dashboard') }}" class="flex items-center gap-1.5 py-3 text-xs font-black uppercase tracking-wide" style="color:#f5c518">
            <i class="fas fa-tachometer-alt"></i>
            <span data-en="Dashboard" data-km="ផ្ទាំង" data-fr="Tableau">Dashboard</span>
        </a>
        <a href="{{ route('home') }}#news" class="py-3 text-xs font-black uppercase tracking-wide text-gray-700 hover:text-orange-500 transition">
            <span data-en="News" data-km="ព័ត៌មាន" data-fr="Actualités">News</span>
        </a>
        <form method="POST" action="{{ route('sponsor.logout') }}" style="display:inline;margin:0;">
            @csrf
            <button type="submit" class="my-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-black uppercase tracking-wide rounded-md transition" style="border:none;cursor:pointer;">
                <i class="fas fa-sign-out-alt mr-1"></i>
                <span data-en="Logout" data-km="ចាកចេញ" data-fr="Déconnexion">Logout</span>
            </button>
        </form>
    @else
        {{-- Guest user --}}
        <a href="{{ route('sponsor.contact') }}" class="flex items-center gap-1.5 py-3 text-xs font-black uppercase tracking-wide" style="color:#f5c518">
            <i class="fas fa-child"></i>
            <span data-en="Sponsor" data-km="ឧបត្ថម្ភ" data-fr="Parrainer">Sponsor</span>
        </a>
        <a href="{{ route('home') }}#news" class="py-3 text-xs font-black uppercase tracking-wide text-gray-700 hover:text-orange-500 transition">
            <span data-en="News" data-km="ព័ត៌មាន" data-fr="Actualités">News</span>
        </a>
        <a href="{{ route('learn-more') }}" class="py-3 text-xs font-black uppercase tracking-wide text-gray-700 hover:text-orange-500 transition">
            <span data-en="About" data-km="អំពី" data-fr="À propos">About</span>
        </a>
        <a href="{{ route('sponsor.login') }}"
           class="my-1 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-black uppercase tracking-wide rounded-md transition">
            <i class="fas fa-heart mr-1"></i>
            <span data-en="Donate" data-km="ចូល" data-fr="Donation">Donate</span>
        </a>
    @endauth
</div>

{{-- Mobile drawer overlay --}}
<div id="mobile-menu-overlay" class="mobile-menu-overlay"></div>

{{-- Mobile drawer --}}
<div id="mobile-menu" class="mobile-menu">
    <div class="p-5">
        {{-- Drawer header --}}
        <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Association Des Ailes Pour Grandir Logo"
                     style="height:70px;width:auto;filter:brightness(1.1) saturate(1.2) drop-shadow(0 2px 8px rgba(0,0,0,0.35));">
             
            </div>
            <button id="close-menu" class="text-gray-400 hover:text-gray-700 w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Mobile language --}}
        <div id="translate-panel-mobile">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[10px] font-bold text-gray-500 flex items-center gap-1.5 uppercase tracking-wide">
                    <i class="fas fa-globe text-orange-500 text-xs"></i>
                    <span data-en="Language" data-km="ភាសា" data-fr="Langue">Language</span>
                </p>
            </div>
            <div class="flex gap-2">
                <button class="mobile-lang-btn active" id="mobile-btn-en" onclick="switchLanguage('en')">
                    <img src="https://flagcdn.com/w80/us.png" alt="EN">
                    <span>English</span>
                </button>
                <button class="mobile-lang-btn" id="mobile-btn-km" onclick="switchLanguage('km')">
                    <img src="https://flagcdn.com/w80/kh.png" alt="KM">
                    <span>ខ្មែរ</span>
                </button>
                <button class="mobile-lang-btn" id="mobile-btn-fr" onclick="switchLanguage('fr')">
                    <img src="https://flagcdn.com/w80/fr.png" alt="FR">
                    <span>Français</span>
                </button>
            </div>
            <button onclick="autoDetectAndTranslate()"
                    class="mt-3 w-full flex items-center justify-center gap-2 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold transition"
                    id="auto-translate-btn-mobile">
                <i class="fas fa-magic text-xs"></i>
                <span data-en="Auto Translate" data-km="បកប្រែស្វ័យប្រវត្តិ" data-fr="Traduction auto">Auto Translate</span>
            </button>
        </div>

        {{-- Nav links --}}
        <nav class="mb-4">
            <a href="{{ route('home') }}#sponsor"     class="mobile-menu-link"><i class="fas fa-child w-5 text-orange-400"></i><span data-en="Sponsor a Child"  data-km="ឧបត្ថម្ភកុមារ"  data-fr="Parrainer un enfant">Sponsor a Child</span></a>
            <a href="{{ route('home') }}#our-work"    class="mobile-menu-link"><i class="fas fa-hands-helping w-5 text-orange-400"></i><span data-en="What We Do" data-km="អ្វីដែលយើងធ្វើ" data-fr="Ce que nous faisons">Who am i</span></a>
            <a href="{{ route('learn-more') }}"       class="mobile-menu-link"><i class="fas fa-users w-5 text-orange-400"></i><span data-en="Who We Are"        data-km="អំពីយើង"          data-fr="Qui sommes-nous">My Story</span></a>
            <a href="{{ route('home') }}#news"        class="mobile-menu-link"><i class="fas fa-newspaper w-5 text-orange-400"></i><span data-en="News & Events"   data-km="ព័ត៌មាន"          data-fr="Actualités">My studies</span></a>
        </nav>

        {{-- CTA buttons --}}
        <div class="space-y-2.5">
            @auth('sponsor')
                {{-- Logged in sponsor --}}
                <a href="{{ route('sponsor.dashboard') }}"
                   class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-black text-sm uppercase tracking-wide transition"
                   style="background:#f5c518;color:#1a1a1a">
                    <i class="fas fa-tachometer-alt"></i>
                    <span data-en="Dashboard" data-km="ផ្ទាំងគ្រប់គ្រង" data-fr="Tableau de bord">Dashboard</span>
                </a>
                <form method="POST" action="{{ route('sponsor.logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit"
                            class="flex items-center justify-center gap-2 w-full py-3.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-black text-sm uppercase tracking-wide transition"
                            style="border:none;cursor:pointer;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span data-en="Logout" data-km="ចាកចេញ" data-fr="Déconnexion">Logout</span>
                    </button>
                </form>
            @else
                {{-- Guest user --}}
                <a href="{{ route('sponsor.contact') }}"
                   class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-black text-sm uppercase tracking-wide transition"
                   style="background:#f5c518;color:#1a1a1a">
                    <i class="fas fa-child"></i>
                    <span data-en="Sponsor a Child" data-km="ឧបត្ថម្ភកុមារ" data-fr="Parrainer">Sponsor a Child</span>
                </a>
                <a href="{{ route('sponsor.login') }}"
                   class="flex items-center justify-center gap-2 w-full py-3.5 bg-green-500 hover:bg-green-600 text-white rounded-xl font-black text-sm uppercase tracking-wide transition">
                    <i class="fas fa-heart"></i>
                    <span data-en="Donate" data-km="ចូល" data-fr="Donation">Donate</span>
                </a>
            @endauth
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     GOOGLE TRANSLATE SCRIPT + LANGUAGE CONTROLLER
═══════════════════════════════════════════════════════════ --}}
<script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage:'en', includedLanguages:'en,km,fr',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false, multilanguagePage: true
    }, 'google_translate_element');
}

function triggerGoogleTranslate(targetLang) {
    return new Promise(resolve => {
        const expiry = 'expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = 'googtrans=; ' + expiry;
        document.cookie = 'googtrans=; ' + expiry + ' domain=' + location.hostname + ';';
        document.cookie = 'googtrans=; ' + expiry + ' domain=.' + location.hostname + ';';
        if (targetLang === 'en') { resolve(true); setTimeout(() => location.reload(), 80); return; }
        const pair = '/en/' + targetLang;
        document.cookie = 'googtrans=' + pair + '; path=/';
        document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname;
        const trySelect = tries => {
            const sel = document.querySelector('select.goog-te-combo');
            if (sel) { sel.value = targetLang; sel.dispatchEvent(new Event('change')); resolve(true); }
            else if (tries > 0) setTimeout(() => trySelect(tries - 1), 200);
            else { resolve(true); setTimeout(() => location.reload(), 80); }
        };
        trySelect(8);
    });
}

const LANGS = {
    en: { label:'EN', flag:'https://flagcdn.com/w40/us.png', name:'English' },
    km: { label:'KM', flag:'https://flagcdn.com/w40/kh.png', name:'ខ្មែរ' },
    fr: { label:'FR', flag:'https://flagcdn.com/w40/fr.png', name:'Français' }
};
let currentLang = localStorage.getItem('gt_lang') || 'fr';

function updateLangUI(lang) {
    const cfg = LANGS[lang] || LANGS.en;
    const flagEl  = document.getElementById('desktop-flag');
    const labelEl = document.getElementById('desktop-lang-label');
    const badge   = document.getElementById('mobile-lang-badge');
    if (flagEl)  { flagEl.src = cfg.flag; flagEl.alt = cfg.label; }
    if (labelEl) labelEl.textContent = cfg.label;
    if (badge)   badge.textContent = cfg.label;
    ['en','km','fr'].forEach(l => {
        document.getElementById('btn-' + l)?.classList.toggle('active', l === lang);
        const c = document.getElementById('check-' + l);
        if (c) c.classList.toggle('hidden', l !== lang);
        document.getElementById('mobile-btn-' + l)?.classList.toggle('active', l === lang);
    });
    document.querySelectorAll('[data-' + lang + ']').forEach(el => {
        const v = el.getAttribute('data-' + lang);
        if (v) el.innerHTML = v;
    });
    document.body.style.fontFamily = lang === 'km'
        ? "'Hanuman','Battambang','Content',sans-serif"
        : "'Montserrat',sans-serif";
    currentLang = lang;
    localStorage.setItem('gt_lang', lang);
}

async function switchLanguage(lang) {
    if (lang === currentLang) { closeTranslatePanel(); return; }
    updateLangUI(lang);
    await triggerGoogleTranslate(lang);
    closeTranslatePanel();
}

function autoDetectAndTranslate() {
    const order = ['en','km','fr'];
    const next  = order[(order.indexOf(currentLang) + 1) % order.length];
    const btn   = document.getElementById('auto-translate-btn');
    const btnM  = document.getElementById('auto-translate-btn-mobile');
    const spin  = '<i class="fas fa-circle-notch gt-spin mr-1"></i>';
    if (btn)  btn.innerHTML  = spin + 'Translating…';
    if (btnM) btnM.innerHTML = spin + 'Translating…';
    switchLanguage(next).then(() => {
        if (btn)  btn.innerHTML  = '<i class="fas fa-magic text-[10px]"></i> Auto Translate';
        if (btnM) btnM.innerHTML = '<i class="fas fa-magic text-xs"></i> ' + (LANGS[next]?.name || next.toUpperCase());
    });
}

function toggleTranslatePanel() {
    const panel = document.getElementById('translate-panel');
    const caret = document.getElementById('translate-caret');
    const open  = panel.classList.toggle('open');
    if (caret) caret.style.transform = open ? 'rotate(180deg)' : '';
}
function closeTranslatePanel() {
    const panel = document.getElementById('translate-panel');
    const caret = document.getElementById('translate-caret');
    if (panel) panel.classList.remove('open');
    if (caret) caret.style.transform = '';
}

document.addEventListener('click', e => {
    const w = document.getElementById('translate-wrapper');
    if (w && !w.contains(e.target)) closeTranslatePanel();
});

document.addEventListener('DOMContentLoaded', () => {
    const cookie = document.cookie.split(';').find(c => c.trim().startsWith('googtrans='));
    const stored = localStorage.getItem('gt_lang');
    if (cookie) {
        const parts = cookie.split('/');
        const cl = parts[parts.length - 1].trim();
        if (cl && LANGS[cl]) { currentLang = cl; localStorage.setItem('gt_lang', cl); }
    } else if (!stored) {
        const pair = '/en/fr';
        document.cookie = 'googtrans=' + pair + '; path=/';
        document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname;
        localStorage.setItem('gt_lang', 'fr');
        location.reload();
        return;
    }
    updateLangUI(currentLang);
});

// Mobile menu toggle
document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
    document.getElementById('mobile-menu')?.classList.add('active');
    document.getElementById('mobile-menu-overlay')?.classList.add('active');
});

document.getElementById('close-menu')?.addEventListener('click', () => {
    document.getElementById('mobile-menu')?.classList.remove('active');
    document.getElementById('mobile-menu-overlay')?.classList.remove('active');
});

document.getElementById('mobile-menu-overlay')?.addEventListener('click', () => {
    document.getElementById('mobile-menu')?.classList.remove('active');
    document.getElementById('mobile-menu-overlay')?.classList.remove('active');
});
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>