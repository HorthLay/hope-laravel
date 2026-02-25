{{-- resources/views/layouts/header.blade.php --}}
<div id="google_translate_element" style="display:none;position:absolute"></div>

{{-- Load settings once for the entire header --}}
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
/* ── Reset Google toolbar ──────────────────────────────────────── */
body { top: 0 !important; }
.goog-te-banner-frame,.goog-te-balloon-frame,#goog-gt-tt,.goog-te-spinner-pos,.skiptranslate { display:none !important; }
iframe.goog-te-banner-frame { display:none !important; }

/* ══ HEADER ARCHITECTURE ══════════════════════════════════════════
   Desktop (≥1024px): util-bar + logo-banner + main-nav
   Mobile  (<1024px):  mobile-topbar + mobile-nav-bar
══════════════════════════════════════════════════════════════════ */

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
    position: relative;
    overflow: hidden;
    min-height: 160px;
    background-image: url("{{ asset('images/image.jpg') }}");
    background-size: cover;
    background-position: center 40%;
    background-repeat: no-repeat;
    background-color: #1a2e3b;
}
#logo-banner::before {
    content: '';
    position: absolute; inset: 0;
    background:
        linear-gradient(to right,  rgba(10,25,35,.55) 0%, rgba(10,25,35,.30) 30%, rgba(10,25,35,.10) 55%, rgba(10,25,35,.05) 100%),
        linear-gradient(to bottom, rgba(10,25,35,.25) 0%, rgba(10,25,35,.00) 30%, rgba(10,25,35,.00) 70%, rgba(10,25,35,.40) 100%);
    z-index: 0;
}
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
.logo-mark {
    display: flex; align-items: center; gap: 16px;
    text-decoration: none;
}
.logo-img {
    height: 160px; width: auto; display: block;
    filter: brightness(1.18) saturate(1.25)
            drop-shadow(0 0 18px rgba(249,115,22,.65))
            drop-shadow(0 4px 22px rgba(0,0,0,.70));
    transition: filter .25s, transform .25s;
}
.logo-mark:hover .logo-img {
    filter: brightness(1.28) saturate(1.35)
            drop-shadow(0 0 28px rgba(249,115,22,.85))
            drop-shadow(0 6px 28px rgba(0,0,0,.65));
    transform: translateY(-3px) scale(1.03);
}
.banner-cta-group { display: flex; align-items: center; gap: 12px; }
.subscribe-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 20px;
    background: #2ecc71; color: #fff;
    font-size: 12px; font-weight: 800;
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
.nav-inner { max-width: 1280px; margin: 0 auto; display: flex; align-items: stretch; }
.nav-links  { display: flex; align-items: stretch; flex: 1; }
.nav-item-link {
    display: flex; align-items: center;
    padding: 0 20px; height: 52px;
    font-size: 12px; font-weight: 800;
    text-transform: uppercase; letter-spacing: .07em;
    color: #1e3a4a; text-decoration: none;
    border-bottom: 3px solid transparent; margin-bottom: -3px;
    transition: color .18s, border-color .18s, background .18s;
    white-space: nowrap;
}
.nav-item-link:hover { color: #f97316; border-bottom-color: #f97316; background: #fff7ed; }
.nav-item-link.active-nav { color: #f97316; border-bottom-color: #f97316; }
.nav-ctas { display: flex; align-items: stretch; flex-shrink: 0; }
.nav-cta-sponsor {
    display: flex; align-items: center; gap: 8px;
    padding: 0 22px; height: 52px;
    background: #f5c518; color: #1a1a1a;
    font-size: 12px; font-weight: 900;
    text-transform: uppercase; letter-spacing: .06em;
    text-decoration: none; transition: background .2s; white-space: nowrap;
}
.nav-cta-sponsor:hover { background: #e6b800; color: #1a1a1a; }
.nav-cta-donate {
    display: flex; align-items: center; gap: 8px;
    padding: 0 22px; height: 52px;
    background: #2ecc71; color: #fff;
    font-size: 12px; font-weight: 900;
    text-transform: uppercase; letter-spacing: .06em;
    text-decoration: none; transition: background .2s; white-space: nowrap;
}
.nav-cta-donate:hover { background: #27ae60; color: #fff; }

/* ── Language switcher ───────────────────────────────────────── */
.lang-pill-util {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px 3px 6px;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,.2);
    background: rgba(255,255,255,.07);
    cursor: pointer;
    font-size: 11px; font-weight: 700;
    color: rgba(255,255,255,.8);
    transition: all .18s; white-space: nowrap;
}
.lang-pill-util:hover { border-color: rgba(255,255,255,.5); color: #fff; background: rgba(255,255,255,.12); }
#translate-panel {
    position: absolute; top: calc(100% + 6px); left: 0;
    width: 210px; background: #fff; border-radius: 12px;
    box-shadow: 0 12px 40px rgba(0,0,0,.18); border: 1px solid #f0f0f0;
    padding: 10px; opacity: 0; visibility: hidden;
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

/* ── Mobile header ───────────────────────────────────────────── */
#mobile-topbar {
    background: #1e3a4a;
    display: flex; align-items: center; justify-content: space-between;
    padding: 8px 16px;
    position: sticky; top: 0; z-index: 1000;
    box-shadow: 0 2px 12px rgba(0,0,0,.25);
}
#mobile-nav-bar {
    background: #fff;
    border-bottom: 3px solid #e5e7eb;
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    overflow-x: auto;
    gap: 4px;
}
.mobile-menu-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:1090; }
.mobile-menu-overlay.active { display:block; }
.mobile-menu {
    position: fixed; top: 0; right: -100%;
    width: min(340px, 90vw); height: 100dvh;
    background: #fff; z-index: 1100;
    transition: right .32s cubic-bezier(.4,0,.2,1);
    overflow-y: auto;
}
.mobile-menu.active { right: 0; }
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
    padding: 13px 16px; color: #1e3a4a;
    font-size: 13px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .04em;
    text-decoration: none; border-bottom: 1px solid #f3f4f6;
    transition: background .15s, color .15s;
}
.mobile-menu-link:hover { background: #fff7ed; color: #f97316; }

/* ── Responsive visibility ───────────────────────────────────── */
@media (max-width: 1023px) {
    #util-bar, #logo-banner, #main-nav { display: none; }
}
@media (min-width: 1024px) {
    #mobile-topbar, #mobile-nav-bar { display: none; }
}
</style>

{{-- ════════════════════════════════════════════════════
     DESKTOP HEADER (≥1024px)
════════════════════════════════════════════════════ --}}
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
                    <button onclick="autoDetectAndTranslate()" id="auto-translate-btn"
                            class="w-full flex items-center justify-center gap-2 py-2 rounded-lg bg-orange-50 hover:bg-orange-100 text-orange-600 text-xs font-bold transition border border-orange-200">
                        <i class="fas fa-magic text-[10px]"></i> Auto Translate
                    </button>
                </div>
            </div>
        </div>

        {{-- Right: social icons + contact --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}#contact" class="util-link">
                <i class="fas fa-phone-alt text-[10px]"></i>
                <span data-en="Contact" data-km="ទំនាក់ទំនង" data-fr="Contact">Contact</span>
            </a>
            <span class="text-white/20">|</span>

            @if($fbUrl)
            <a href="{{ $fbUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-facebook-f text-[11px]"></i></a>
            @endif
            @if($igUrl)
            <a href="{{ $igUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-instagram text-[11px]"></i></a>
            @endif
            @if($ytUrl)
            <a href="{{ $ytUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-youtube text-[11px]"></i></a>
            @endif
            @if($tgUrl)
            <a href="{{ $tgUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-telegram text-[11px]"></i></a>
            @endif
            @if($waUrl)
            <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-whatsapp text-[11px]"></i></a>
            @endif
            @if($liUrl)
            <a href="{{ $liUrl }}" target="_blank" rel="noopener" class="util-link"><i class="fab fa-linkedin-in text-[11px]"></i></a>
            @endif

            <span class="text-white/20">|</span>
            <span id="mobile-lang-badge" class="text-[11px] font-bold text-orange-400">FR</span>
        </div>
    </div>
</div>

{{-- Logo banner --}}
<div id="logo-banner">
    <div class="banner-inner">
        <a href="{{ route('home') }}" class="logo-mark">
            <img src="{{ $logoPath }}"
                 alt="{{ $siteName }}"
                 class="logo-img">
        </a>
        <div class="banner-cta-group">
            <a href="{{ route('sponsor.children') }}" class="subscribe-btn">
                <i class="fas fa-heart text-sm"></i>
                <span>Sponsor For Children</span>
            </a>
        </div>
    </div>
</div>

{{-- Sticky nav bar --}}
<div id="main-nav">
    <div class="nav-inner">
        <nav class="nav-links">
            <a href="{{ route('sponsor.children') }}"  class="nav-item-link" data-en="Sponsor a Child"    data-km="ឧបត្ថម្ភកុមារ"    data-fr="Parrainer un enfant">Sponsor a Child</a>
            <a href="{{ route('home') }}#our-work" class="nav-item-link" data-en="What We Do"         data-km="អ្វីដែលយើងធ្វើ"   data-fr="Ce que nous faisons">What We Do</a>
            <a href="{{ route('learn-more') }}"    class="nav-item-link" data-en="Who We Are"         data-km="អំពីយើង"           data-fr="Qui sommes-nous">Who We Are</a>
            <a href="{{ route('home') }}#news"     class="nav-item-link" data-en="News &amp; Updates" data-km="ព័ត៌មាន"           data-fr="Actualités">News &amp; Updates</a>
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

{{-- ════════════════════════════════════════════════════
     MOBILE HEADER (<1024px)
════════════════════════════════════════════════════ --}}

<div id="mobile-topbar">
    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
        <img src="{{ $logoPath }}"
             alt="{{ $siteName }}"
             style="height:60px;width:auto;filter:brightness(1.15) saturate(1.2) drop-shadow(0 2px 8px rgba(0,0,0,.55));">
    </a>
    <div class="flex items-center gap-2">
        <a href="{{ route('sponsor.children') }}"
           class="flex items-center gap-1.5 px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 text-[11px] font-black uppercase rounded-lg transition">
            <i class="fas fa-child text-xs"></i>
            <span>Sponsor</span>
        </a>
        <button id="mobile-menu-btn"
                class="text-white/80 hover:text-white p-2 rounded-lg hover:bg-white/10 transition">
            <i class="fas fa-bars text-lg"></i>
        </button>
    </div>
</div>

<div id="mobile-nav-bar">
    @auth('sponsor')
        <a href="{{ route('sponsor.dashboard') }}" class="flex items-center gap-1.5 py-3 text-xs font-black uppercase tracking-wide whitespace-nowrap flex-shrink-0" style="color:#f5c518">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('home') }}#news" class="py-3 text-xs font-black uppercase tracking-wide text-gray-700 hover:text-orange-500 transition whitespace-nowrap flex-shrink-0">News</a>
        <form method="POST" action="{{ route('sponsor.logout') }}" style="display:inline;margin:0;flex-shrink:0;">
            @csrf
            <button type="submit" class="my-1.5 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-[11px] font-black uppercase rounded-md transition" style="border:none;cursor:pointer;">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </button>
        </form>
    @else
        <a href="{{ route('home') }}#news"     class="py-3 text-xs font-black uppercase tracking-wide text-gray-700 hover:text-orange-500 transition whitespace-nowrap flex-shrink-0">News</a>
        <a href="{{ route('learn-more') }}"    class="py-3 text-xs font-black uppercase tracking-wide text-gray-700 hover:text-orange-500 transition whitespace-nowrap flex-shrink-0">About</a>
        <a href="{{ route('home') }}#our-work" class="py-3 text-xs font-black uppercase tracking-wide text-gray-700 hover:text-orange-500 transition whitespace-nowrap flex-shrink-0">What We Do</a>
        <a href="{{ route('sponsor.login') }}"
           class="my-1.5 px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-[11px] font-black uppercase rounded-md transition flex-shrink-0">
            <i class="fas fa-heart mr-1"></i> Donate
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
            <a href="{{ route('home') }}">
                <img src="{{ $logoPath }}"
                     alt="{{ $siteName }}"
                     style="height:60px;width:auto;filter:brightness(1.1) saturate(1.2) drop-shadow(0 2px 8px rgba(0,0,0,.35));">
            </a>
            <button id="close-menu" class="text-gray-400 hover:text-gray-700 w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
                <i class="fas fa-times"></i>
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
            <button onclick="autoDetectAndTranslate()" id="auto-translate-btn-mobile"
                    class="mt-3 w-full flex items-center justify-center gap-2 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold transition">
                <i class="fas fa-magic text-xs"></i>
                <span data-en="Auto Translate" data-km="បកប្រែស្វ័យប្រវត្តិ" data-fr="Traduction auto">Auto Translate</span>
            </button>
        </div>

        {{-- Social icons in drawer --}}
        @if($fbUrl || $igUrl || $ytUrl || $tgUrl || $waUrl || $liUrl)
        <div class="flex gap-2 mb-4">
            @if($fbUrl)
            <a href="{{ $fbUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm">
                <i class="fab fa-facebook-f"></i>
            </a>
            @endif
            @if($igUrl)
            <a href="{{ $igUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm">
                <i class="fab fa-instagram"></i>
            </a>
            @endif
            @if($ytUrl)
            <a href="{{ $ytUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm">
                <i class="fab fa-youtube"></i>
            </a>
            @endif
            @if($tgUrl)
            <a href="{{ $tgUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm">
                <i class="fab fa-telegram"></i>
            </a>
            @endif
            @if($waUrl)
            <a href="{{ $waUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm">
                <i class="fab fa-whatsapp"></i>
            </a>
            @endif
            @if($liUrl)
            <a href="{{ $liUrl }}" target="_blank" class="w-9 h-9 bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-600 rounded-full flex items-center justify-center transition text-sm">
                <i class="fab fa-linkedin-in"></i>
            </a>
            @endif
        </div>
        @endif

        {{-- Nav links --}}
        <nav class="mb-4">
            <a href="{{ route('sponsor.children') }}"  class="mobile-menu-link"><i class="fas fa-child w-5 text-orange-400"></i><span data-en="Sponsor a Child" data-km="ឧបត្ថម្ភកុមារ" data-fr="Parrainer un enfant">Sponsor a Child</span></a>
            <a href="{{ route('home') }}#our-work" class="mobile-menu-link"><i class="fas fa-hands-helping w-5 text-orange-400"></i><span data-en="What We Do" data-km="អ្វីដែលយើងធ្វើ" data-fr="Ce que nous faisons">What We Do</span></a>
            <a href="{{ route('learn-more') }}"    class="mobile-menu-link"><i class="fas fa-users w-5 text-orange-400"></i><span data-en="Who We Are" data-km="អំពីយើង" data-fr="Qui sommes-nous">Who We Are</span></a>
            <a href="{{ route('home') }}#news"     class="mobile-menu-link"><i class="fas fa-newspaper w-5 text-orange-400"></i><span data-en="News &amp; Updates" data-km="ព័ត៌មាន" data-fr="Actualités">News &amp; Updates</span></a>
        </nav>

        {{-- CTA buttons --}}
        <div class="space-y-2.5">
            @auth('sponsor')
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
                <a href="{{ route('sponsor.children') }}"
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

{{-- ═══════════════════════════════════════════════════
     GOOGLE TRANSLATE + LANGUAGE CONTROLLER
═══════════════════════════════════════════════════ --}}
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

// ── Mobile drawer ──
document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
    document.getElementById('mobile-menu')?.classList.add('active');
    document.getElementById('mobile-menu-overlay')?.classList.add('active');
    document.body.style.overflow = 'hidden';
});
document.getElementById('close-menu')?.addEventListener('click', () => {
    document.getElementById('mobile-menu')?.classList.remove('active');
    document.getElementById('mobile-menu-overlay')?.classList.remove('active');
    document.body.style.overflow = '';
});
document.getElementById('mobile-menu-overlay')?.addEventListener('click', () => {
    document.getElementById('mobile-menu')?.classList.remove('active');
    document.getElementById('mobile-menu-overlay')?.classList.remove('active');
    document.body.style.overflow = '';
});
document.querySelectorAll('.mobile-menu-link').forEach(l => {
    l.addEventListener('click', () => {
        document.getElementById('mobile-menu')?.classList.remove('active');
        document.getElementById('mobile-menu-overlay')?.classList.remove('active');
        document.body.style.overflow = '';
    });
});
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>