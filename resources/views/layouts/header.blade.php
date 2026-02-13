{{-- resources/views/layouts/header.blade.php --}}

{{-- ══════════════════════════════════════════════════════════════════
     GOOGLE TRANSLATE — hidden widget + custom 3-language switcher
     Supports: English (en) · Khmer (km) · French (fr)
══════════════════════════════════════════════════════════════════ --}}
{{-- Hidden GT container (required by the API) --}}
<div id="google_translate_element" style="display:none;position:absolute"></div>

<style>
/* ── Hide Google's injected banner/toolbar ─────────────────────── */
body { top: 0 !important; }
.goog-te-banner-frame,
.goog-te-balloon-frame,
#goog-gt-tt,
.goog-te-spinner-pos { display: none !important; }
.skiptranslate { display: none !important; }
iframe.goog-te-banner-frame { display: none !important; }

/* ── Language switcher pill ─────────────────────────────────────── */
.lang-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px 5px 8px;
    border-radius: 999px;
    border: 2px solid #e5e7eb;
    background: #fff;
    cursor: pointer;
    transition: all .2s ease;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    white-space: nowrap;
}
.lang-pill:hover { border-color: #f97316; color: #f97316; }
.lang-pill.translating {
    border-color: #f97316;
    background: #fff7ed;
    color: #f97316;
}

/* ── Translate dropdown panel ───────────────────────────────────── */
#translate-panel {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 230px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 12px 48px rgba(0,0,0,.14);
    border: 1px solid #f0f0f0;
    padding: 12px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all .25s cubic-bezier(.34,1.56,.64,1);
    z-index: 999;
}
#translate-panel.open {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
.lang-option-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 9px 12px;
    border-radius: 10px;
    border: 2px solid transparent;
    background: transparent;
    cursor: pointer;
    transition: all .18s ease;
    text-align: left;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}
.lang-option-btn:hover { background: #fff7ed; border-color: #fed7aa; }
.lang-option-btn.active {
    background: linear-gradient(135deg, #fff7ed, #ffedd5);
    border-color: #f97316;
    color: #c2410c;
}
.lang-option-btn .flag { width: 26px; height: 18px; object-fit: cover; border-radius: 3px; box-shadow: 0 1px 4px rgba(0,0,0,.15); flex-shrink: 0; }
.lang-option-btn .check { margin-left: auto; color: #f97316; font-size: 11px; }

/* Auto-translate spinner */
@keyframes spin { to { transform: rotate(360deg); } }
.gt-spin { display: inline-block; animation: spin .7s linear infinite; }

/* Mobile lang panel */
#translate-panel-mobile {
    background: #f9fafb;
    border-radius: 14px;
    padding: 12px;
    margin-bottom: 16px;
}
.mobile-lang-btn {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 10px 6px;
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    background: #fff;
    cursor: pointer;
    transition: all .2s ease;
    font-size: 11px;
    font-weight: 700;
    color: #374151;
}
.mobile-lang-btn:hover { border-color: #f97316; background: #fff7ed; }
.mobile-lang-btn.active {
    border-color: #f97316;
    background: linear-gradient(135deg, #fff7ed, #ffedd5);
    color: #c2410c;
    box-shadow: 0 4px 12px rgba(249,115,22,.25);
}
.mobile-lang-btn img { width: 32px; height: 22px; object-fit: cover; border-radius: 3px; box-shadow: 0 1px 4px rgba(0,0,0,.15); }
</style>

<header class="main-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16 md:h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-heart text-white text-xl md:text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800"
                        data-en="Hope & Impact" data-km="សង្ឃឹម និងផលប៉ះពាល់" data-fr="Espoir & Impact">
                        Hope & Impact
                    </h1>
                    <p class="text-xs md:text-sm text-gray-500"
                       data-en="Changing Lives Together" data-km="ផ្លាស់ប្តូរជីវិតជាមួយគ្នា" data-fr="Changer des vies ensemble">
                        Changing Lives Together
                    </p>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden lg:flex items-center gap-8">
                <a href="{{ route('home') }}"       class="nav-link text-gray-700 hover:text-orange-500 font-medium transition" data-en="Home"     data-km="ទំព័រដើម"         data-fr="Accueil">Home</a>
                <a href="{{ route('home') }}#sponsor" class="nav-link text-gray-700 hover:text-orange-500 font-medium transition" data-en="Sponsor"  data-km="ឧបត្ថម្ភ"          data-fr="Parrainer">Sponsor</a>
                <a href="{{ route('home') }}#our-work" class="nav-link text-gray-700 hover:text-orange-500 font-medium transition" data-en="Our Work" data-km="ការងាររបស់យើង"    data-fr="Nos Actions">Our Work</a>
                <a href="{{ route('learn-more') }}"  class="nav-link text-gray-700 hover:text-orange-500 font-medium transition" data-en="About"    data-km="អំពីយើង"           data-fr="À propos">About</a>
                <a href="{{ route('home') }}#news"  class="nav-link text-gray-700 hover:text-orange-500 font-medium transition" data-en="News"      data-km="ព័ត៌មាន"           data-fr="Actualités">News</a>
            </nav>

            {{-- Desktop Actions --}}
            <div class="hidden md:flex items-center gap-3">

                {{-- ── Language Switcher (Desktop) ── --}}
                <div class="relative" id="translate-wrapper">

                    {{-- Pill button --}}
                    <button id="translate-toggle"
                            onclick="toggleTranslatePanel()"
                            class="lang-pill"
                            title="Change language / Changer de langue / ប្តូរភាសា">
                        <span id="active-flag-img">
                            <img src="https://flagcdn.com/w40/us.png" class="w-5 h-3.5 rounded object-cover" alt="EN" id="desktop-flag">
                        </span>
                        <span id="desktop-lang-label">EN</span>
                        <i class="fas fa-chevron-down text-[9px] text-gray-400" id="translate-caret"></i>
                    </button>

                    {{-- Dropdown panel --}}
                    <div id="translate-panel">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-2 mb-2">
                            <i class="fas fa-globe mr-1 text-orange-400"></i> Select Language
                        </p>

                        <button class="lang-option-btn active" id="btn-en" onclick="switchLanguage('en')">
                            <img src="https://flagcdn.com/w40/us.png"  class="flag" alt="EN">
                            <div>
                                <div>English</div>
                                <div class="text-[10px] font-normal text-gray-400">Original</div>
                            </div>
                            <i class="fas fa-check check" id="check-en"></i>
                        </button>

                        <button class="lang-option-btn" id="btn-km" onclick="switchLanguage('km')">
                            <img src="https://flagcdn.com/w40/kh.png" class="flag" alt="KM">
                            <div>
                                <div>ខ្មែរ (Khmer)</div>
                                <div class="text-[10px] font-normal text-gray-400">Cambodian</div>
                            </div>
                            <i class="fas fa-check check hidden" id="check-km"></i>
                        </button>

                        <button class="lang-option-btn" id="btn-fr" onclick="switchLanguage('fr')">
                            <img src="https://flagcdn.com/w40/fr.png" class="flag" alt="FR">
                            <div>
                                <div>Français</div>
                                <div class="text-[10px] font-normal text-gray-400">French</div>
                            </div>
                            <i class="fas fa-check check hidden" id="check-fr"></i>
                        </button>

                        {{-- Auto-translate bar --}}
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            <button onclick="autoDetectAndTranslate()"
                                    class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg bg-orange-50 hover:bg-orange-100 text-orange-600 text-xs font-bold transition border border-orange-200"
                                    id="auto-translate-btn">
                                <i class="fas fa-magic text-[11px]"></i>
                                Auto Translate
                            </button>
                        </div>
                    </div>
                </div>{{-- /translate-wrapper --}}

                <a href="{{ route('detail') }}" class="btn-primary"
                   data-en="Donate Now" data-km="បរិច្ចាគឥឡូវ" data-fr="Donner maintenant">
                    Donate Now
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button id="mobile-menu-btn" class="md:hidden hamburger">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

{{-- Mobile Menu Overlay + Drawer --}}
<div id="mobile-menu-overlay" class="mobile-menu-overlay"></div>

<div id="mobile-menu" class="mobile-menu">
    <div class="p-6">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-heart text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800" data-en="Hope & Impact" data-km="សង្ឃឹម និងផលប៉ះពាល់" data-fr="Espoir & Impact">Hope & Impact</h2>
                    <p class="text-xs text-gray-500" data-en="Menu" data-km="ម៉ឺនុយ" data-fr="Menu">Menu</p>
                </div>
            </div>
            <button id="close-menu" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        {{-- Nav links --}}
        <nav class="flex flex-col gap-2 mb-6">
            <a href="{{ route('home') }}"         class="mobile-menu-link p-4 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg font-medium transition flex items-center">
                <i class="fas fa-home w-6 mr-3"></i><span data-en="Home"           data-km="ទំព័រដើម"           data-fr="Accueil">Home</span>
            </a>
            <a href="{{ route('home') }}#sponsor" class="mobile-menu-link p-4 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg font-medium transition flex items-center">
                <i class="fas fa-child w-6 mr-3"></i><span data-en="Sponsor a Child" data-km="ឧបត្ថម្ភកុមារ"       data-fr="Parrainer un enfant">Sponsor a Child</span>
            </a>
            <a href="{{ route('home') }}#our-work" class="mobile-menu-link p-4 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg font-medium transition flex items-center">
                <i class="fas fa-hands-helping w-6 mr-3"></i><span data-en="What We Do" data-km="អ្វីដែលយើងធ្វើ"   data-fr="Ce que nous faisons">What We Do</span>
            </a>
            <a href="{{ route('learn-more') }}"   class="mobile-menu-link p-4 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg font-medium transition flex items-center">
                <i class="fas fa-users w-6 mr-3"></i><span data-en="About Us"       data-km="អំពីយើង"             data-fr="À propos">About Us</span>
            </a>
            <a href="{{ route('home') }}#news"    class="mobile-menu-link p-4 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg font-medium transition flex items-center">
                <i class="fas fa-newspaper w-6 mr-3"></i><span data-en="News & Stories" data-km="ព័ត៌មាន និងរឿងរ៉ាវ" data-fr="Actualités">News & Stories</span>
            </a>
        </nav>

        {{-- ── Mobile Language Switcher ── --}}
        <div id="translate-panel-mobile">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold text-gray-500 flex items-center gap-2">
                    <i class="fas fa-globe text-orange-500"></i>
                    <span data-en="Language" data-km="ភាសា" data-fr="Langue">Language</span>
                </p>
                <span id="mobile-lang-badge" class="text-xs font-bold text-orange-600 bg-orange-100 px-2 py-0.5 rounded-full">EN</span>
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
            {{-- Auto translate --}}
            <button onclick="autoDetectAndTranslate()"
                    class="mt-3 w-full flex items-center justify-center gap-2 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold transition"
                    id="auto-translate-btn-mobile">
                <i class="fas fa-magic"></i>
                <span data-en="Auto Translate" data-km="បកប្រែស្វ័យប្រវត្តិ" data-fr="Traduction automatique">Auto Translate</span>
            </button>
        </div>

        {{-- Action buttons --}}
        <div class="space-y-3">
            <a href="{{ route('detail') }}" class="btn-primary w-full text-center block"
               data-en="Donate Now" data-km="បរិច្ចាគឥឡូវ" data-fr="Donner maintenant">Donate Now</a>
            <a href="{{ route('home') }}#volunteer"
               class="block w-full text-center py-3 px-6 border-2 border-orange-500 text-orange-500 rounded-full font-semibold hover:bg-orange-50 transition"
               data-en="Volunteer" data-km="ស្ម័គ្រចិត្ត" data-fr="Bénévole">Volunteer</a>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
            <p class="text-xs text-gray-400"
               data-en="© 2026 Hope & Impact. All rights reserved."
               data-km="© ២០២៦ សង្ឃឹម និងផលប៉ះពាល់។ រក្សាសិទ្ធិគ្រប់យ៉ាង។"
               data-fr="© 2026 Espoir & Impact. Tous droits réservés.">
                © 2026 Hope & Impact. All rights reserved.
            </p>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════
     GOOGLE TRANSLATE SCRIPT + CUSTOM CONTROLLER
══════════════════════════════════════════════════════════════════ --}}
<script>
// ── 1. Bootstrap Google Translate (hidden) ─────────────────────────────────
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,km,fr',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false,
        multilanguagePage: true
    }, 'google_translate_element');
}

// ── 2. Core translate trigger (cookie + reload — works on localhost too) ──────
function triggerGoogleTranslate(targetLang) {
    return new Promise((resolve) => {
        // Clear any existing googtrans cookies first
        const expiry = 'expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = 'googtrans=; ' + expiry;
        document.cookie = 'googtrans=; ' + expiry + ' domain=' + location.hostname + ';';
        document.cookie = 'googtrans=; ' + expiry + ' domain=.' + location.hostname + ';';

        if (targetLang === 'en') {
            // English = original — just reload without any cookie
            resolve(true);
            setTimeout(() => location.reload(), 80);
            return;
        }

        // Set googtrans cookie that Google Translate Element reads on load
        const pair = '/en/' + targetLang;
        const cookieBase = 'googtrans=' + pair + '; path=/';
        document.cookie = cookieBase;
        document.cookie = cookieBase + '; domain=' + location.hostname;

        // First try: fire the hidden GT select element without reloading
        const trySelect = (tries) => {
            const sel = document.querySelector('select.goog-te-combo');
            if (sel) {
                sel.value = targetLang;
                sel.dispatchEvent(new Event('change'));
                resolve(true);
            } else if (tries > 0) {
                setTimeout(() => trySelect(tries - 1), 200);
            } else {
                // GT widget not ready — cookie is set, reload will trigger translation
                resolve(true);
                setTimeout(() => location.reload(), 80);
            }
        };
        trySelect(8); // try ~1.6 seconds before reload fallback
    });
}

// ── 3. Language config ─────────────────────────────────────────────────────
const LANGS = {
    en: { label: 'EN', flag: 'https://flagcdn.com/w40/us.png',  name: 'English'     },
    km: { label: 'KM', flag: 'https://flagcdn.com/w40/kh.png', name: 'ខ្មែរ'        },
    fr: { label: 'FR', flag: 'https://flagcdn.com/w40/fr.png', name: 'Français'     }
};

let currentLang = localStorage.getItem('gt_lang') || 'fr';

// ── 4. Update UI chrome (flags, badges, active states) ────────────────────
function updateLangUI(lang) {
    const cfg = LANGS[lang] || LANGS.en;

    // Desktop pill
    const flagEl = document.getElementById('desktop-flag');
    const labelEl = document.getElementById('desktop-lang-label');
    if (flagEl)  { flagEl.src = cfg.flag; flagEl.alt = cfg.label; }
    if (labelEl) labelEl.textContent = cfg.label;

    // Mobile badge
    const badge = document.getElementById('mobile-lang-badge');
    if (badge) badge.textContent = cfg.label;

    // Desktop option btns
    ['en','km','fr'].forEach(l => {
        const btn   = document.getElementById('btn-' + l);
        const check = document.getElementById('check-' + l);
        if (btn)   btn.classList.toggle('active', l === lang);
        if (check) check.classList.toggle('hidden', l !== lang);

        const mBtn = document.getElementById('mobile-btn-' + l);
        if (mBtn) mBtn.classList.toggle('active', l === lang);
    });

    // Swap [data-en/km/fr] text nodes
    document.querySelectorAll('[data-' + lang + ']').forEach(el => {
        const val = el.getAttribute('data-' + lang);
        if (val) el.textContent = val;
    });

    // Font swap for Khmer
    document.body.style.fontFamily = lang === 'km'
        ? "'Hanuman','Battambang','Content',sans-serif"
        : "'Montserrat',sans-serif";

    currentLang = lang;
    localStorage.setItem('gt_lang', lang);
}

// ── 5. Public switchLanguage() ─────────────────────────────────────────────
async function switchLanguage(lang) {
    if (lang === currentLang) { closeTranslatePanel(); return; }

    // Show loading state
    const pill = document.getElementById('translate-toggle');
    if (pill) { pill.classList.add('translating'); pill.innerHTML = '<i class="fas fa-circle-notch gt-spin text-orange-500"></i><span>Translating…</span>'; }

    updateLangUI(lang);
    await triggerGoogleTranslate(lang);

    // Restore pill
    if (pill) {
        pill.classList.remove('translating');
        const cfg = LANGS[lang];
        pill.innerHTML = `<img src="${cfg.flag}" class="w-5 h-3.5 rounded object-cover" alt="${cfg.label}"> <span>${cfg.label}</span> <i class="fas fa-chevron-down text-[9px] text-gray-400"></i>`;
    }

    closeTranslatePanel();
}

// ── 6. Auto translate — cycles EN→KM→FR→EN ────────────────────────────────
function autoDetectAndTranslate() {
    const order = ['en', 'km', 'fr'];
    const next  = order[(order.indexOf(currentLang) + 1) % order.length];

    const btn  = document.getElementById('auto-translate-btn');
    const btnM = document.getElementById('auto-translate-btn-mobile');
    const spin = '<i class="fas fa-circle-notch gt-spin mr-1"></i>';
    if (btn)  btn.innerHTML  = spin + 'Translating…';
    if (btnM) btnM.innerHTML = spin + 'Translating…';

    switchLanguage(next).then(() => {
        const label = LANGS[next]?.name || next.toUpperCase();
        if (btn)  btn.innerHTML  = '<i class="fas fa-magic text-[11px]"></i> Auto Translate';
        if (btnM) btnM.innerHTML = '<i class="fas fa-magic"></i> ' + label;
    });
}

// ── 7. Panel open/close ────────────────────────────────────────────────────
function toggleTranslatePanel() {
    const panel  = document.getElementById('translate-panel');
    const caret  = document.getElementById('translate-caret');
    const isOpen = panel.classList.toggle('open');
    if (caret) caret.style.transform = isOpen ? 'rotate(180deg)' : '';
}
function closeTranslatePanel() {
    const panel = document.getElementById('translate-panel');
    const caret = document.getElementById('translate-caret');
    if (panel) panel.classList.remove('open');
    if (caret) caret.style.transform = '';
}

// ── 8. Close panel on outside click ───────────────────────────────────────
document.addEventListener('click', (e) => {
    const wrapper = document.getElementById('translate-wrapper');
    if (wrapper && !wrapper.contains(e.target)) closeTranslatePanel();
});

// ── 9. Restore last language on page load ─────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    // Check if Google already translated (cookie present)
    const cookie = document.cookie.split(';').find(c => c.trim().startsWith('googtrans='));
    const stored = localStorage.getItem('gt_lang');

    if (cookie) {
        // Respect whatever Google already set
        const parts = cookie.split('/');
        const cookieLang = parts[parts.length - 1].trim();
        if (cookieLang && LANGS[cookieLang]) {
            currentLang = cookieLang;
            localStorage.setItem('gt_lang', cookieLang);
        }
    } else if (!stored) {
        // First ever visit — default to French, set cookie & reload
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

{{-- Load Google Translate API --}}
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>