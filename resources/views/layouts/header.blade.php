{{-- resources/views/layouts/header.blade.php --}}
<div id="google_translate_element" style="display:none;position:absolute"></div>

@php
    $headerSettings = (function() {
        $file = storage_path('app/settings.json');
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    })();
    $siteName    = $headerSettings['site_name']    ?? 'Association Des Ailes Pour Grandir';
    $logoPath    = !empty($headerSettings['logo'])    ? asset($headerSettings['logo'])    : asset('images/logo.png');
    $faviconPath = !empty($headerSettings['favicon']) ? asset($headerSettings['favicon']) : null;
    $fbUrl       = $headerSettings['facebook_url']  ?? null;
    $igUrl       = $headerSettings['instagram_url'] ?? null;
    $ytUrl       = $headerSettings['youtube_url']   ?? null;
    $tgUrl       = !empty($headerSettings['telegram_url'])  ? 'https://t.me/' . $headerSettings['telegram_url']   : null;
    $waUrl       = !empty($headerSettings['whatsapp_url'])  ? 'https://wa.me/' . $headerSettings['whatsapp_url']  : null;
    $liUrl       = $headerSettings['linkedin_url']  ?? null;
@endphp

<style>
/* ── Reset Google toolbar ─────────────────────── */
body { top: 0 !important; }
.goog-te-banner-frame,.goog-te-balloon-frame,#goog-gt-tt,.goog-te-spinner-pos,.skiptranslate { display:none !important; }

/* ══════════════════════════════════════════════
   1. UTILITY BAR
══════════════════════════════════════════════ */
#util-bar {
    background: #1a2e3b;
    border-bottom: 1px solid rgba(255,255,255,.08);
    height: 38px; display: flex; align-items: center;
}
.util-bar-inner {
    max-width: 1280px; margin: 0 auto; padding: 0 24px;
    width: 100%; display: flex; align-items: center; justify-content: space-between;
}
.util-link {
    color: rgba(255,255,255,.7); font-size: 11px; font-weight: 600;
    text-transform: uppercase; letter-spacing: .06em;
    text-decoration: none; transition: color .18s;
    display: flex; align-items: center; gap: 5px;
}
.util-link:hover { color: #fff; }

/* ══════════════════════════════════════════════
   2. LOGO BANNER
══════════════════════════════════════════════ */
#logo-banner {
    position: relative; overflow: hidden; min-height: 160px;
    background-image: url("{{ asset('images/image.jpg') }}");
    background-size: cover; background-position: center 40%;
    background-color: #1a2e3b;
}
#logo-banner::before {
    content:''; position:absolute; inset:0; z-index:0;
    background:
        linear-gradient(to right, rgba(10,25,35,.55) 0%, rgba(10,25,35,.30) 30%, rgba(10,25,35,.10) 55%, transparent 100%),
        linear-gradient(to bottom, rgba(10,25,35,.25) 0%, transparent 30%, transparent 70%, rgba(10,25,35,.40) 100%);
}
#logo-banner::after {
    content:''; position:absolute; inset:0; z-index:0; pointer-events:none;
    background: radial-gradient(ellipse at 14% 55%, rgba(249,115,22,.45) 0%, transparent 38%);
}
.banner-inner {
    max-width: 1280px; margin: 0 auto; padding: 0 24px;
    min-height: 160px; display: flex; align-items: center; justify-content: space-between;
    position: relative; z-index: 2;
}
.logo-img {
    height: 160px; width: auto; display: block;
    filter: brightness(1.18) saturate(1.25) drop-shadow(0 0 18px rgba(249,115,22,.65)) drop-shadow(0 4px 22px rgba(0,0,0,.70));
    transition: filter .25s, transform .25s;
}
.logo-mark:hover .logo-img {
    filter: brightness(1.28) saturate(1.35) drop-shadow(0 0 28px rgba(249,115,22,.85)) drop-shadow(0 6px 28px rgba(0,0,0,.65));
    transform: translateY(-3px) scale(1.03);
}
.subscribe-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 20px; background: #2ecc71; color: #fff;
    font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em;
    border-radius: 6px; text-decoration: none;
    transition: background .2s, transform .15s;
    box-shadow: 0 4px 14px rgba(46,204,113,.35);
}
.subscribe-btn:hover { background: #27ae60; transform: translateY(-1px); color: #fff; }

/* ══════════════════════════════════════════════
   3. MAIN NAV — with mega dropdown
══════════════════════════════════════════════ */
#main-nav {
    background: #fff;
    border-bottom: 3px solid #e5e7eb;
    position: sticky; top: 0; z-index: 1000;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.nav-inner {
    max-width: 1280px; margin: 0 auto;
    display: flex; align-items: stretch;
    width: 100%;
}
.nav-links {
    display: flex; align-items: stretch;
    justify-content: flex-start;
    flex: 0 0 auto;
    gap: 0;
}

/* ── Base nav item wrapper ── */
.nav-item {
    position: relative;
    display: flex; align-items: stretch;
    flex: 0 0 auto;
}
.nav-item-link {
    display: flex; align-items: center; gap: 5px;
    padding: 0 18px; height: 52px;
    font-size: 12px; font-weight: 800;
    text-transform: uppercase; letter-spacing: .06em;
    color: #1e3a4a; text-decoration: none;
    border-bottom: 3px solid transparent; margin-bottom: -3px;
    transition: color .18s, border-color .18s, background .18s;
    white-space: nowrap; cursor: pointer;
    flex: 0 0 auto;
}
.nav-item-link:hover,
.nav-item:hover .nav-item-link { color: #f97316; border-bottom-color: #f97316; background: #fff7ed; }
.nav-item-link.active-nav { color: #f97316; border-bottom-color: #f97316; }
.nav-item-link .nav-caret {
    font-size: 8px; opacity: .5;
    transition: transform .22s ease, opacity .18s;
}
.nav-item:hover .nav-caret { transform: rotate(180deg); opacity: 1; }
.nav-sep {
    display: flex; align-items: center;
    padding: 12px 0;
    flex-shrink: 0;
}
.nav-sep::after {
    content: '';
    display: block; width: 1px; height: 20px;
    background: #e5e7eb;
}

/* ── Mega dropdown panel ── */
.mega-drop {
    position: absolute; top: 100%; left: 0;
    min-width: 680px;
    background: #fff;
    border-top: 3px solid #f97316;
    border-radius: 0 0 16px 16px;
    box-shadow: 0 24px 60px rgba(0,0,0,.14);
    padding: 28px 32px 24px;
    opacity: 0; visibility: hidden;
    transform: translateY(-8px);
    transition: opacity .22s ease, transform .22s ease, visibility .22s;
    z-index: 2000;
    display: flex; gap: 32px;
}
/* Right-align dropdowns that would overflow */
.mega-drop.drop-right { left: auto; right: 0; }

.nav-item:hover .mega-drop { opacity: 1; visibility: visible; transform: translateY(0); }

/* ── Dropdown column ── */
.drop-col { min-width: 160px; flex: 1; }
.drop-col-title {
    font-size: 10px; font-weight: 900;
    text-transform: uppercase; letter-spacing: .1em;
    color: #9ca3af; margin-bottom: 12px; padding-bottom: 8px;
    border-bottom: 2px solid #f3f4f6;
}
.drop-link {
    display: flex; align-items: center; gap: 9px;
    padding: 8px 10px; margin: 1px -10px;
    border-radius: 8px;
    font-size: 12.5px; font-weight: 600; color: #374151;
    text-decoration: none;
    transition: background .15s, color .15s, padding-left .15s;
    border-bottom: 1px dashed #f3f4f6;
}
.drop-link:last-child { border-bottom: none; }
.drop-link:hover {
    background: #fff7ed; color: #ea580c;
    padding-left: 16px;
}
.drop-link i { width: 14px; text-align: center; color: #f97316; font-size: 11px; flex-shrink:0; }

/* ── Small single-col dropdown ── */
.mini-drop {
    position: absolute; top: 100%; left: 0;
    min-width: 240px;
    background: #fff;
    border-top: 3px solid #f97316;
    border-radius: 0 0 14px 14px;
    box-shadow: 0 20px 50px rgba(0,0,0,.12);
    padding: 12px 10px;
    opacity: 0; visibility: hidden;
    transform: translateY(-8px);
    transition: opacity .22s ease, transform .22s ease, visibility .22s;
    z-index: 2000;
}
.nav-item:hover .mini-drop { opacity: 1; visibility: visible; transform: translateY(0); }

/* ── CTA buttons — always at far right ── */
.nav-ctas {
    display: flex; align-items: stretch;
    flex-shrink: 0;
    margin-left: auto;
    border-left: 1px solid #e5e7eb;
}
.nav-cta-sponsor {
    display: flex; align-items: center; gap: 8px;
    padding: 0 22px; height: 52px; background: #f5c518; color: #1a1a1a;
    font-size: 12px; font-weight: 900; text-transform: uppercase; letter-spacing: .06em;
    text-decoration: none; transition: background .2s; white-space: nowrap;
}
.nav-cta-sponsor:hover { background: #e6b800; color: #1a1a1a; }
.nav-cta-donate {
    display: flex; align-items: center; gap: 8px;
    padding: 0 22px; height: 52px; background: #2ecc71; color: #fff;
    font-size: 12px; font-weight: 900; text-transform: uppercase; letter-spacing: .06em;
    text-decoration: none; transition: background .2s; white-space: nowrap;
}
.nav-cta-donate:hover { background: #27ae60; color: #fff; }

/* ══════════════════════════════════════════════
   4. LANGUAGE SWITCHER (desktop)
══════════════════════════════════════════════ */
.lang-pill-util {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px 3px 6px; border-radius: 999px;
    border: 1px solid rgba(255,255,255,.2);
    background: rgba(255,255,255,.07);
    cursor: pointer; font-size: 11px; font-weight: 700;
    color: rgba(255,255,255,.8); transition: all .18s; white-space: nowrap;
}
.lang-pill-util:hover { border-color: rgba(255,255,255,.5); color: #fff; background: rgba(255,255,255,.12); }
#translate-panel {
    position: absolute; top: calc(100% + 6px); left: 0;
    width: 210px; background: #fff; border-radius: 12px;
    box-shadow: 0 12px 40px rgba(0,0,0,.18); border: 1px solid #f0f0f0;
    padding: 10px; opacity: 0; visibility: hidden;
    transform: translateY(-6px);
    transition: all .22s cubic-bezier(.34,1.56,.64,1); z-index: 9999;
}
#translate-panel.open { opacity:1; visibility:visible; transform:translateY(0); }
.lang-option-btn {
    display: flex; align-items: center; gap: 9px;
    width: 100%; padding: 8px 10px; border-radius: 8px;
    border: 2px solid transparent; background: transparent;
    cursor: pointer; transition: all .15s; text-align: left;
    font-size: 12px; font-weight: 600; color: #374151;
}
.lang-option-btn:hover { background: #fff7ed; border-color: #fed7aa; }
.lang-option-btn.active { background: linear-gradient(135deg,#fff7ed,#ffedd5); border-color: #f97316; color: #c2410c; }
.lang-option-btn .flag { width: 24px; height: 16px; object-fit: cover; border-radius: 2px; box-shadow: 0 1px 4px rgba(0,0,0,.15); flex-shrink:0; }
.lang-option-btn .check { margin-left: auto; color: #f97316; font-size: 10px; }
@keyframes spin { to { transform: rotate(360deg); } }
.gt-spin { display:inline-block; animation: spin .7s linear infinite; }

/* ══════════════════════════════════════════════
   5. MOBILE HEADER
══════════════════════════════════════════════ */
#mobile-topbar {
    background: #1e3a4a;
    display: flex; align-items: center; justify-content: space-between;
    padding: 8px 16px; position: sticky; top: 0; z-index: 1000;
    box-shadow: 0 2px 12px rgba(0,0,0,.25);
}
#mobile-nav-bar {
    background: #fff; border-bottom: 3px solid #e5e7eb;
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06);
    overflow-x: auto; gap: 4px;
}
/* Mobile drawer */
.mobile-menu-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:1090; }
.mobile-menu-overlay.active { display:block; }
.mobile-menu {
    position: fixed; top: 0; right: -100%;
    width: min(360px, 92vw); height: 100dvh;
    background: #fff; z-index: 1100;
    transition: right .32s cubic-bezier(.4,0,.2,1);
    overflow-y: auto; -webkit-overflow-scrolling: touch;
}
.mobile-menu.active { right: 0; }

/* Mobile nav items with accordion */
.mob-nav-item { border-bottom: 1px solid #f3f4f6; }
.mob-nav-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px;
    font-size: 13px; font-weight: 800;
    text-transform: uppercase; letter-spacing: .05em;
    color: #1e3a4a; text-decoration: none; cursor: pointer;
    transition: background .15s, color .15s;
    -webkit-tap-highlight-color: transparent;
}
.mob-nav-header:hover, .mob-nav-header.mob-active { background: #fff7ed; color: #f97316; }
.mob-nav-icon { color: #f97316; width: 18px; text-align: center; font-size: 13px; flex-shrink:0; }
.mob-nav-title { flex: 1; }
.mob-caret {
    font-size: 10px; color: #9ca3af;
    transition: transform .25s ease;
    flex-shrink:0;
}
.mob-nav-item.open .mob-caret { transform: rotate(180deg); }

/* Accordion body */
.mob-nav-body {
    max-height: 0; overflow: hidden;
    transition: max-height .32s cubic-bezier(.4,0,.2,1);
    background: #fafafa;
}
.mob-nav-item.open .mob-nav-body { max-height: 800px; }

.mob-drop-section { padding: 6px 0 6px 16px; }
.mob-drop-title {
    font-size: 9px; font-weight: 900; letter-spacing: .12em;
    text-transform: uppercase; color: #9ca3af;
    padding: 8px 16px 4px;
}
.mob-drop-link {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 16px; font-size: 13px; font-weight: 600; color: #374151;
    text-decoration: none; transition: background .12s, color .12s;
    border-bottom: 1px dashed #f0f0f0;
    -webkit-tap-highlight-color: transparent;
}
.mob-drop-link:last-child { border-bottom: none; }
.mob-drop-link:hover, .mob-drop-link:active { background: #fff7ed; color: #ea580c; }
.mob-drop-link i { width: 16px; text-align: center; color: #f97316; font-size: 11px; flex-shrink:0; }

/* Mobile language */
#translate-panel-mobile { background: #f9fafb; border-radius: 12px; padding: 12px; margin-bottom: 14px; }
.mobile-lang-btn {
    flex: 1; display: flex; flex-direction: column; align-items: center; gap: 5px;
    padding: 9px 4px; border-radius: 8px; border: 2px solid #e5e7eb;
    background: #fff; cursor: pointer; transition: all .18s;
    font-size: 10px; font-weight: 700; color: #374151;
    -webkit-tap-highlight-color: transparent;
}
.mobile-lang-btn:hover { border-color: #f97316; background: #fff7ed; }
.mobile-lang-btn.active { border-color: #f97316; background: linear-gradient(135deg,#fff7ed,#ffedd5); color: #c2410c; box-shadow: 0 4px 12px rgba(249,115,22,.2); }
.mobile-lang-btn img { width: 30px; height: 20px; object-fit: cover; border-radius: 2px; }

/* ── Responsive visibility ── */
@media (max-width: 1023px) { #util-bar, #logo-banner, #main-nav { display: none; } }
@media (min-width: 1024px) { #mobile-topbar, #mobile-nav-bar { display: none; } }
</style>

{{-- ═══════════════════════════════════════════
     DESKTOP HEADER (≥1024px)
═══════════════════════════════════════════ --}}
<div id="util-bar">
    <div class="util-bar-inner">
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
                    <button onclick="autoDetectAndTranslate()" id="auto-translate-btn"
                            class="w-full flex items-center justify-center gap-2 py-2 rounded-lg bg-orange-50 hover:bg-orange-100 text-orange-600 text-xs font-bold transition border border-orange-200">
                        <i class="fas fa-magic text-[10px]"></i> Auto Translate
                    </button>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}#contact" class="util-link">
                <i class="fas fa-phone-alt text-[10px]"></i>
                <span data-en="Contact" data-km="ទំនាក់ទំនង" data-fr="Contact">Contact</span>
            </a>
            <span class="text-white/20">|</span>
            @if($fbUrl)<a href="{{ $fbUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-facebook-f text-[11px]"></i></a>@endif
            @if($igUrl)<a href="{{ $igUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-instagram text-[11px]"></i></a>@endif
            @if($ytUrl)<a href="{{ $ytUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-youtube text-[11px]"></i></a>@endif
            @if($tgUrl)<a href="{{ $tgUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-telegram text-[11px]"></i></a>@endif
            @if($waUrl)<a href="{{ $waUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-whatsapp text-[11px]"></i></a>@endif
            @if($liUrl)<a href="{{ $liUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-linkedin-in text-[11px]"></i></a>@endif
            <span class="text-white/20">|</span>
            <span id="mobile-lang-badge" class="text-[11px] font-bold text-orange-400">FR</span>
        </div>
    </div>
</div>

<div id="logo-banner">
    <div class="banner-inner">
        <a href="{{ route('home') }}" class="logo-mark flex items-center gap-4 text-decoration-none">
            <img src="{{ $logoPath }}" alt="{{ $siteName }}" class="logo-img">
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('sponsor.children') }}" class="subscribe-btn">
                <i class="fas fa-heart text-sm"></i>
                <span>Sponsor For Children</span>
            </a>
        </div>
    </div>
</div>

{{-- ══ STICKY NAV with Mega Dropdowns ══ --}}
<div id="main-nav">
    <div class="nav-inner">
        <nav class="nav-links">

            {{-- ① WHAT WE DO — 3-column mega dropdown --}}
            <div class="nav-item">
                <span class="nav-item-link">
                    <span data-en="What We Do" data-km="អ្វីដែលយើងធ្វើ" data-fr="Ce que nous faisons">What We Do</span>
                    <i class="fas fa-chevron-down nav-caret"></i>
                </span>
                <div class="mega-drop">
                    <div class="drop-col">
                        <div class="drop-col-title"><i class="fas fa-child mr-1 text-orange-400"></i> Childhood</div>
                        <a href="{{ route('childhood.protection') }}"      class="drop-link"><i class="fas fa-shield-alt"></i> Child Protection</a>
                        <a href="{{ route('childhood.health') }}"          class="drop-link"><i class="fas fa-heartbeat"></i> Health & Nutrition</a>
                        <a href="{{ route('childhood.education') }}"       class="drop-link"><i class="fas fa-graduation-cap"></i> Education</a>
                        <a href="{{ route('childhood.development') }}"     class="drop-link"><i class="fas fa-seedling"></i> Personal Development</a>
                        <a href="{{ route('childhood.homes') }}"           class="drop-link"><i class="fas fa-home"></i> Children's Homes</a>
                    </div>
                    <div class="drop-col">
                        <div class="drop-col-title"><i class="fas fa-home mr-1 text-orange-400"></i> Families</div>
                        <a href="{{ route('families.housing') }}"          class="drop-link"><i class="fas fa-house-user"></i> Housing Stability</a>
                        <a href="{{ route('families.training') }}"         class="drop-link"><i class="fas fa-briefcase"></i> Training & Employment</a>
                        <a href="{{ route('families.financial') }}"        class="drop-link"><i class="fas fa-coins"></i> Financial Support</a>
                        <a href="{{ route('families.health') }}"           class="drop-link"><i class="fas fa-stethoscope"></i> Family Health</a>
                    </div>
                    <div class="drop-col">
                        <div class="drop-col-title"><i class="fas fa-city mr-1 text-orange-400"></i> Community</div>
                        <a href="{{ route('community.infrastructure') }}"  class="drop-link"><i class="fas fa-hard-hat"></i> Infrastructure</a>
                        <a href="{{ route('community.water') }}"           class="drop-link"><i class="fas fa-tint"></i> Water & Sanitation</a>
                    </div>
                </div>
            </div>

            {{-- ② WHO WE ARE — 2-column mega dropdown --}}
            <div class="nav-item">
                <span class="nav-item-link">
                    <span data-en="Who We Are" data-km="អំពីយើង" data-fr="Qui sommes-nous">Who We Are</span>
                    <i class="fas fa-chevron-down nav-caret"></i>
                </span>
                <div class="mega-drop">
                    <div class="drop-col">
                        <div class="drop-col-title"><i class="fas fa-info-circle mr-1 text-orange-400"></i> Our Association</div>
                        <a href="{{ route('about.presentation') }}"        class="drop-link"><i class="fas fa-dove"></i> About Us</a>
                        <a href="{{ route('about.vision') }}"              class="drop-link"><i class="fas fa-eye"></i> Vision & Ethics</a>
                        <a href="{{ route('about.team') }}"                class="drop-link"><i class="fas fa-users"></i> Our Team</a>
                        <a href="{{ route('about.partners') }}"            class="drop-link"><i class="fas fa-handshake"></i> Partners</a>
                    </div>
                    <div class="drop-col">
                        <div class="drop-col-title"><i class="fas fa-heart mr-1 text-orange-400"></i> Sponsorship</div>
                        <a href="{{ route('sponsor.child.file') }}"        class="drop-link"><i class="fas fa-child"></i> Child Sponsorship</a>
                        <a href="{{ route('sponsor.child.stories') }}"     class="drop-link"><i class="fas fa-book-open"></i> Child Stories</a>
                        <a href="{{ route('sponsor.family.file') }}"       class="drop-link"><i class="fas fa-home"></i> Family Sponsorship</a>
                        <a href="{{ route('sponsor.family.stories') }}"    class="drop-link"><i class="fas fa-star"></i> Family Stories</a>
                        <a href="{{ route('sponsor.faq') }}"               class="drop-link"><i class="fas fa-question-circle"></i> FAQ</a>
                    </div>
                </div>
            </div>

            {{-- ③ SUPPORT US — right-anchored to prevent overflow --}}
            <div class="nav-item">
                <span class="nav-item-link">
                    <span data-en="Support Us" data-km="គាំទ្រយើង" data-fr="Nous soutenir">Support Us</span>
                    <i class="fas fa-chevron-down nav-caret"></i>
                </span>
                {{-- drop-right anchors to right edge of nav item, never clips --}}
                <div class="mega-drop drop-right">
                    <div class="drop-col">
                        <div class="drop-col-title"><i class="fas fa-hand-holding-heart mr-1 text-orange-400"></i> Give</div>
                        <a href="{{ route('support.donate') }}"            class="drop-link"><i class="fas fa-credit-card"></i> Make a Donation</a>
                        <a href="{{ route('support.bequests') }}"          class="drop-link"><i class="fas fa-scroll"></i> Bequests</a>
                    </div>
                    <div class="drop-col">
                        <div class="drop-col-title"><i class="fas fa-star mr-1 text-orange-400"></i> Get Involved</div>
                        <a href="{{ route('support.fundraiser') }}"        class="drop-link"><i class="fas fa-bullhorn"></i> Start a Fundraiser</a>
                        <a href="{{ route('support.event') }}"             class="drop-link"><i class="fas fa-calendar-star"></i> Solidarity Event</a>
                        <a href="{{ route('support.patron') }}"            class="drop-link"><i class="fas fa-award"></i> Become a Patron</a>
                        <a href="{{ route('support.foundations') }}"       class="drop-link"><i class="fas fa-building"></i> Foundations</a>
                        <a href="{{ route('support.corporate') }}"         class="drop-link"><i class="fas fa-city"></i> Corporate Partners</a>
                        <a href="{{ route('support.projects') }}"          class="drop-link"><i class="fas fa-project-diagram"></i> Ongoing Projects</a>
                    </div>
                </div>
            </div>

        </nav>
        <div class="nav-ctas">
            @auth('sponsor')
                <a href="{{ route('sponsor.dashboard') }}" class="nav-cta-sponsor">
                    <i class="fas fa-tachometer-alt text-base"></i>
                    <span data-en="Dashboard" data-km="ផ្ទាំងគ្រប់គ្រង" data-fr="Tableau de bord">Dashboard</span>
                </a>
                <form method="POST" action="{{ route('sponsor.logout') }}" style="display:inline;margin:0;">
                    @csrf
                    <button type="submit" class="nav-cta-donate" style="border:none;cursor:pointer;height:52px;">
                        <i class="fas fa-sign-out-alt text-base"></i>
                        <span data-en="Logout" data-km="ចាកចេញ" data-fr="Déconnexion">Logout</span>
                    </button>
                </form>
            @else
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

{{-- ═══════════════════════════════════════════
     MOBILE HEADER (<1024px)
═══════════════════════════════════════════ --}}
<div id="mobile-topbar">
    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
        <img src="{{ $logoPath }}" alt="{{ $siteName }}"
             style="height:52px;width:auto;filter:brightness(1.15) saturate(1.2) drop-shadow(0 2px 8px rgba(0,0,0,.55));">
    </a>
    <div class="flex items-center gap-2">
        <a href="{{ route('sponsor.children') }}"
           class="flex items-center gap-1.5 px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 text-[11px] font-black uppercase rounded-lg transition">
            <i class="fas fa-child text-xs"></i> Sponsor
        </a>
        <button id="mobile-menu-btn"
                class="text-white/80 hover:text-white p-2 rounded-lg hover:bg-white/10 transition">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
</div>

<div id="mobile-nav-bar">
    @auth('sponsor')
        <a href="{{ route('sponsor.dashboard') }}" class="flex items-center gap-1.5 py-3 text-xs font-black uppercase tracking-wide whitespace-nowrap flex-shrink-0" style="color:#f5c518">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('home') }}#news" class="py-3 text-xs font-black uppercase tracking-wide text-gray-700 hover:text-orange-500 whitespace-nowrap flex-shrink-0">News</a>
        <form method="POST" action="{{ route('sponsor.logout') }}" style="display:inline;margin:0;flex-shrink:0;">
            @csrf
            <button type="submit" class="my-1.5 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-[11px] font-black uppercase rounded-md transition" style="border:none;cursor:pointer;">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </button>
        </form>
    @else
        <a href="{{ route('home') }}#news"     class="py-3 text-xs font-black uppercase tracking-wide text-gray-700 hover:text-orange-500 whitespace-nowrap flex-shrink-0">News</a>
        <a href="{{ route('home') }}#our-work" class="py-3 text-xs font-black uppercase tracking-wide text-gray-700 hover:text-orange-500 whitespace-nowrap flex-shrink-0">What We Do</a>
        <a href="{{ route('sponsor.login') }}"
           class="my-1.5 px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-[11px] font-black uppercase rounded-md transition flex-shrink-0">
            <i class="fas fa-heart mr-1"></i> Donate
        </a>
    @endauth
</div>

{{-- Mobile overlay --}}
<div id="mobile-menu-overlay" class="mobile-menu-overlay"></div>

{{-- ══ MOBILE DRAWER with accordion menus ══ --}}
<div id="mobile-menu" class="mobile-menu">
    <div class="p-5">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
            <a href="{{ route('home') }}">
                <img src="{{ $logoPath }}" alt="{{ $siteName }}"
                     style="height:52px;width:auto;filter:brightness(1.1) saturate(1.2) drop-shadow(0 2px 8px rgba(0,0,0,.35));">
            </a>
            <button id="close-menu" class="text-gray-400 hover:text-gray-700 w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        {{-- Language panel --}}
        <div id="translate-panel-mobile">
            <p class="text-[10px] font-bold text-gray-500 flex items-center gap-1.5 uppercase tracking-wide mb-3">
                <i class="fas fa-globe text-orange-500 text-xs"></i>
                <span data-en="Language" data-km="ភាសា" data-fr="Langue">Language</span>
            </p>
            <div class="flex gap-2">
                <button class="mobile-lang-btn active" id="mobile-btn-en" onclick="switchLanguage('en')">
                    <img src="https://flagcdn.com/w80/us.png" alt="EN"><span>English</span>
                </button>
                <button class="mobile-lang-btn" id="mobile-btn-km" onclick="switchLanguage('km')">
                    <img src="https://flagcdn.com/w80/kh.png" alt="KM"><span>ខ្មែរ</span>
                </button>
                <button class="mobile-lang-btn" id="mobile-btn-fr" onclick="switchLanguage('fr')">
                    <img src="https://flagcdn.com/w80/fr.png" alt="FR"><span>Français</span>
                </button>
            </div>
            <button onclick="autoDetectAndTranslate()" id="auto-translate-btn-mobile"
                    class="mt-3 w-full flex items-center justify-center gap-2 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold transition">
                <i class="fas fa-magic text-xs"></i>
                <span data-en="Auto Translate" data-km="បកប្រែស្វ័យប្រវត្តិ" data-fr="Traduction auto">Auto Translate</span>
            </button>
        </div>

        {{-- Social icons --}}
        @if($fbUrl || $igUrl || $ytUrl || $tgUrl || $waUrl || $liUrl)
        <div class="flex gap-2 mb-4">
            @if($fbUrl)<a href="{{ $fbUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm"><i class="fab fa-facebook-f"></i></a>@endif
            @if($igUrl)<a href="{{ $igUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm"><i class="fab fa-instagram"></i></a>@endif
            @if($ytUrl)<a href="{{ $ytUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm"><i class="fab fa-youtube"></i></a>@endif
            @if($tgUrl)<a href="{{ $tgUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm"><i class="fab fa-telegram"></i></a>@endif
            @if($waUrl)<a href="{{ $waUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm"><i class="fab fa-whatsapp"></i></a>@endif
            @if($liUrl)<a href="{{ $liUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm"><i class="fab fa-linkedin-in"></i></a>@endif
        </div>
        @endif

        {{-- ══ Accordion nav — 3 items only ══ --}}
        <nav>
            {{-- ① What We Do --}}
            <div class="mob-nav-item" id="mob-whatwedo">
                <div class="mob-nav-header" onclick="toggleMobMenu('mob-whatwedo')">
                    <i class="fas fa-hands-helping mob-nav-icon"></i>
                    <span class="mob-nav-title" data-en="What We Do" data-km="អ្វីដែលយើងធ្វើ" data-fr="Ce que nous faisons">What We Do</span>
                    <i class="fas fa-chevron-down mob-caret"></i>
                </div>
                <div class="mob-nav-body">
                    <div class="mob-drop-title"><i class="fas fa-child mr-1 text-orange-400"></i> Childhood</div>
                    <a href="{{ route('childhood.protection') }}"  class="mob-drop-link mobile-menu-link"><i class="fas fa-shield-alt"></i> Child Protection</a>
                    <a href="{{ route('childhood.health') }}"      class="mob-drop-link mobile-menu-link"><i class="fas fa-heartbeat"></i> Health & Nutrition</a>
                    <a href="{{ route('childhood.education') }}"   class="mob-drop-link mobile-menu-link"><i class="fas fa-graduation-cap"></i> Education</a>
                    <a href="{{ route('childhood.development') }}" class="mob-drop-link mobile-menu-link"><i class="fas fa-seedling"></i> Personal Development</a>
                    <a href="{{ route('childhood.homes') }}"       class="mob-drop-link mobile-menu-link"><i class="fas fa-home"></i> Children's Homes</a>
                    <div class="mob-drop-title mt-2"><i class="fas fa-home mr-1 text-orange-400"></i> Families</div>
                    <a href="{{ route('families.housing') }}"      class="mob-drop-link mobile-menu-link"><i class="fas fa-house-user"></i> Housing Stability</a>
                    <a href="{{ route('families.training') }}"     class="mob-drop-link mobile-menu-link"><i class="fas fa-briefcase"></i> Training & Employment</a>
                    <a href="{{ route('families.financial') }}"    class="mob-drop-link mobile-menu-link"><i class="fas fa-coins"></i> Financial Support</a>
                    <a href="{{ route('families.health') }}"       class="mob-drop-link mobile-menu-link"><i class="fas fa-stethoscope"></i> Family Health</a>
                    <div class="mob-drop-title mt-2"><i class="fas fa-city mr-1 text-orange-400"></i> Community</div>
                    <a href="{{ route('community.infrastructure') }}" class="mob-drop-link mobile-menu-link"><i class="fas fa-hard-hat"></i> Infrastructure</a>
                    <a href="{{ route('community.water') }}"          class="mob-drop-link mobile-menu-link"><i class="fas fa-tint"></i> Water & Sanitation</a>
                    <div class="pb-2"></div>
                </div>
            </div>

            {{-- ② Who We Are --}}
            <div class="mob-nav-item" id="mob-whoweare">
                <div class="mob-nav-header" onclick="toggleMobMenu('mob-whoweare')">
                    <i class="fas fa-users mob-nav-icon"></i>
                    <span class="mob-nav-title" data-en="Who We Are" data-km="អំពីយើង" data-fr="Qui sommes-nous">Who We Are</span>
                    <i class="fas fa-chevron-down mob-caret"></i>
                </div>
                <div class="mob-nav-body">
                    <div class="mob-drop-title"><i class="fas fa-info-circle mr-1 text-orange-400"></i> Our Association</div>
                    <a href="{{ route('about.presentation') }}"  class="mob-drop-link mobile-menu-link"><i class="fas fa-dove"></i> About Us</a>
                    <a href="{{ route('about.vision') }}"        class="mob-drop-link mobile-menu-link"><i class="fas fa-eye"></i> Vision & Ethics</a>
                    <a href="{{ route('about.team') }}"          class="mob-drop-link mobile-menu-link"><i class="fas fa-users"></i> Our Team</a>
                    <a href="{{ route('about.partners') }}"      class="mob-drop-link mobile-menu-link"><i class="fas fa-handshake"></i> Partners</a>
                    <div class="mob-drop-title mt-2"><i class="fas fa-heart mr-1 text-orange-400"></i> Sponsorship</div>
                    <a href="{{ route('sponsor.child.file') }}"     class="mob-drop-link mobile-menu-link"><i class="fas fa-child"></i> Child Sponsorship</a>
                    <a href="{{ route('sponsor.child.stories') }}"  class="mob-drop-link mobile-menu-link"><i class="fas fa-book-open"></i> Child Stories</a>
                    <a href="{{ route('sponsor.family.file') }}"    class="mob-drop-link mobile-menu-link"><i class="fas fa-home"></i> Family Sponsorship</a>
                    <a href="{{ route('sponsor.family.stories') }}" class="mob-drop-link mobile-menu-link"><i class="fas fa-star"></i> Family Stories</a>
                    <a href="{{ route('sponsor.faq') }}"            class="mob-drop-link mobile-menu-link"><i class="fas fa-question-circle"></i> FAQ</a>
                    <div class="pb-2"></div>
                </div>
            </div>

            {{-- ③ Support Us --}}
            <div class="mob-nav-item" id="mob-support">
                <div class="mob-nav-header" onclick="toggleMobMenu('mob-support')">
                    <i class="fas fa-hand-holding-heart mob-nav-icon"></i>
                    <span class="mob-nav-title" data-en="Support Us" data-km="គាំទ្រយើង" data-fr="Nous soutenir">Support Us</span>
                    <i class="fas fa-chevron-down mob-caret"></i>
                </div>
                <div class="mob-nav-body">
                    <div class="mob-drop-title"><i class="fas fa-hand-holding-heart mr-1 text-orange-400"></i> Give</div>
                    <a href="{{ route('support.donate') }}"      class="mob-drop-link mobile-menu-link"><i class="fas fa-credit-card"></i> Make a Donation</a>
                    <a href="{{ route('support.bequests') }}"    class="mob-drop-link mobile-menu-link"><i class="fas fa-scroll"></i> Bequests</a>
                    <div class="mob-drop-title mt-2"><i class="fas fa-star mr-1 text-orange-400"></i> Get Involved</div>
                    <a href="{{ route('support.fundraiser') }}"  class="mob-drop-link mobile-menu-link"><i class="fas fa-bullhorn"></i> Start a Fundraiser</a>
                    <a href="{{ route('support.event') }}"       class="mob-drop-link mobile-menu-link"><i class="fas fa-calendar-star"></i> Solidarity Event</a>
                    <a href="{{ route('support.patron') }}"      class="mob-drop-link mobile-menu-link"><i class="fas fa-award"></i> Become a Patron</a>
                    <a href="{{ route('support.foundations') }}" class="mob-drop-link mobile-menu-link"><i class="fas fa-building"></i> Foundations</a>
                    <a href="{{ route('support.corporate') }}"   class="mob-drop-link mobile-menu-link"><i class="fas fa-city"></i> Corporate Partners</a>
                    <a href="{{ route('support.projects') }}"    class="mob-drop-link mobile-menu-link"><i class="fas fa-project-diagram"></i> Ongoing Projects</a>
                    <div class="pb-2"></div>
                </div>
            </div>
        </nav>

        {{-- CTA buttons --}}
        <div class="space-y-2.5 mt-5">
            @auth('sponsor')
                <a href="{{ route('sponsor.dashboard') }}"
                   class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-black text-sm uppercase tracking-wide"
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
                <a href="{{ route('sponsor.children') }}"
                   class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-black text-sm uppercase tracking-wide"
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

{{-- ═══════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════ --}}
<script>
// ── Mobile accordion ──────────────────────────────────────────────────
function toggleMobMenu(id) {
    const item = document.getElementById(id);
    if (!item) return;
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.mob-nav-item.open').forEach(el => el.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
}

function openMobileMenu() {
    document.getElementById('mobile-menu')?.classList.add('active');
    document.getElementById('mobile-menu-overlay')?.classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeMobileMenu() {
    document.getElementById('mobile-menu')?.classList.remove('active');
    document.getElementById('mobile-menu-overlay')?.classList.remove('active');
    document.body.style.overflow = '';
}
document.getElementById('mobile-menu-btn')?.addEventListener('click', openMobileMenu);
document.getElementById('close-menu')?.addEventListener('click', closeMobileMenu);
document.getElementById('mobile-menu-overlay')?.addEventListener('click', closeMobileMenu);
document.querySelectorAll('.mobile-menu-link').forEach(l => l.addEventListener('click', closeMobileMenu));

// ── Google Translate ─────────────────────────────────────────────────
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
    const p = document.getElementById('translate-panel');
    const c = document.getElementById('translate-caret');
    if (p) p.classList.remove('open');
    if (c) c.style.transform = '';
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
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>