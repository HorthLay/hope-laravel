{{-- resources/views/sponsor/login.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Login  | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
     <meta name="description" content="{{ $settings['meta_description'] ?? $settings['site_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '' }}">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    {{-- Google Translate init --}}
    <script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,km,fr',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false, multilanguagePage: true
        }, 'google_translate_element');
    }
    </script>

    <style>
        body { font-family: 'Montserrat', sans-serif; top: 0 !important; }

        /* ── Hide Google toolbar ── */
        .goog-te-banner-frame,.goog-te-balloon-frame,#goog-gt-tt,.goog-te-spinner-pos,.skiptranslate { display:none !important; }
        iframe.goog-te-banner-frame { display:none !important; }

        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slide-up { animation: slideUp 0.5s ease-out; }

        /* ── Language dropdown ── */
        .lang-pill {
            display:inline-flex; align-items:center; gap:7px;
            padding:7px 14px 7px 10px; border-radius:999px;
            border:2px solid #e5e7eb; background:#fff;
            cursor:pointer; font-size:12px; font-weight:800; color:#374151;
            transition:all .18s; white-space:nowrap;
            box-shadow:0 2px 8px rgba(0,0,0,.07);
        }
        .lang-pill:hover { border-color:#f4b630; color:#f4b630; box-shadow:0 4px 16px rgba(249,115,22,.15); }

        #login-translate-panel {
            position:absolute; top:calc(100% + 8px); left:50%; transform:translateX(-50%) translateY(-6px);
            width:210px; background:#fff; border-radius:14px;
            box-shadow:0 16px 48px rgba(0,0,0,.18); border:1px solid #f0f0f0;
            padding:10px; opacity:0; visibility:hidden;
            transition:all .22s cubic-bezier(.34,1.56,.64,1);
            z-index:9999;
        }
        #login-translate-panel.open { opacity:1; visibility:visible; transform:translateX(-50%) translateY(0); }

        .lang-opt {
            display:flex; align-items:center; gap:9px;
            width:100%; padding:9px 10px; border-radius:9px;
            border:2px solid transparent; background:transparent;
            cursor:pointer; transition:all .15s; text-align:left;
            font-size:12px; font-weight:600; color:#374151;
        }
        .lang-opt:hover { background:#fff7ed; border-color:#fed7aa; }
        .lang-opt.active { background:linear-gradient(135deg,#fff7ed,#ffedd5); border-color:#f4b630; color:#f4b630; }
        .lang-opt .flag { width:22px; height:15px; object-fit:cover; border-radius:2px; box-shadow:0 1px 4px rgba(0,0,0,.15); flex-shrink:0; }
        .lang-opt .chk  { margin-left:auto; color:#f4b630; font-size:10px; }

        @keyframes gt-spin { to { transform:rotate(360deg); } }
        .gt-spin { display:inline-block; animation:gt-spin .7s linear infinite; }
    </style>
</head>
<body>

{{-- Hidden Google Translate widget --}}
<div id="google_translate_element" style="display:none;position:absolute"></div>

<div class="bg-gradient-to-br from-orange-50 via-orange-50 to-orange-100 min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md animate-slide-up">

    {{-- ── Language dropdown (centered) ── --}}
    <div class="flex justify-center mb-6">
        <div class="relative" id="login-translate-wrapper">
            <button class="lang-pill" onclick="loginTogglePanel()" id="login-translate-toggle">
                <img src="https://flagcdn.com/w40/fr.png" id="login-flag" class="w-5 h-3.5 rounded object-cover shadow-sm" alt="FR">
                <span id="login-lang-label" class="font-black text-sm">Français</span>
                <i class="fas fa-chevron-down text-[9px] text-gray-400" id="login-caret"></i>
            </button>

            <div id="login-translate-panel">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-1 mb-2">
                    <i class="fas fa-globe mr-1 text-orange-400"></i> Language
                </p>
                <button class="lang-opt active" id="login-btn-fr" onclick="loginSwitchLang('fr')">
                    <img src="https://flagcdn.com/w40/fr.png" class="flag" alt="FR">
                    <div>
                        <div class="font-bold">Français</div>
                        <div class="text-[10px] font-normal text-gray-400">French</div>
                    </div>
                    <i class="fas fa-check chk" id="login-check-fr"></i>
                </button>
                <button class="lang-opt" id="login-btn-en" onclick="loginSwitchLang('en')">
                    <img src="https://flagcdn.com/w40/us.png" class="flag" alt="EN">
                    <div>
                        <div class="font-bold">English</div>
                        <div class="text-[10px] font-normal text-gray-400">Original</div>
                    </div>
                    <i class="fas fa-check chk hidden" id="login-check-en"></i>
                </button>
                <button class="lang-opt" id="login-btn-km" onclick="loginSwitchLang('km')">
                    <img src="https://flagcdn.com/w40/kh.png" class="flag" alt="KH">
                    <div>
                        <div class="font-bold">ខ្មែរ</div>
                        <div class="text-[10px] font-normal text-gray-400">Cambodian</div>
                    </div>
                    <i class="fas fa-check chk hidden" id="login-check-km"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Association Des Ailes Pour Grandir Logo"
                 style="height:100px;width:auto;object-fit:contain;">
        </a>
        <p class="text-xs font-bold text-gray-500 mt-3 uppercase tracking-wider">
            <i class="fas fa-hand-holding-heart text-orange-500 mr-1"></i>
            <span data-fr="Espace Parrain" data-en="Sponsor Portal" data-km="តំបន់ឧបត្ថម្ភ">Espace Parrain</span>
        </p>
    </div>

    {{-- Login card --}}
    <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">

        <div class="text-center mb-6">
            <h2 class="text-2xl font-black text-gray-800 mb-2"
                data-fr="Bienvenue" data-en="Welcome" data-km="សូមស្វាគមន៍">Bienvenue</h2>
            <p class="text-sm text-gray-600"
               data-fr="Connectez-vous pour accéder au profil de votre filleul·e"
               data-en="Log in to access your sponsored child's profile"
               data-km="ចូលដើម្បីចូលប្រើប្រវត្តិរូបកុមារឧបត្ថម្ភរបស់អ្នក">
                Connectez-vous pour accéder au profil de votre filleul·e
            </p>
        </div>

        @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-lg">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-lg">
            <div class="flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('sponsor.login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-user text-orange-500 mr-1 text-xs"></i>
                    <span data-fr="Nom d'utilisateur" data-en="Username" data-km="ឈ្មោះអ្នកប្រើប្រាស់">Nom d'utilisateur</span>
                </label>
                <input type="text" name="username" value="{{ old('username') }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition @error('username') border-red-300 bg-red-50 @enderror"
                       data-placeholder-fr="Entrez votre nom d'utilisateur"
                       data-placeholder-en="Enter your username"
                       data-placeholder-km="បញ្ចូលឈ្មោះអ្នកប្រើប្រាស់"
                       placeholder="Entrez votre nom d'utilisateur"
                       required autofocus>
                @error('username')
                <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $message }}</span>
                </p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-lock text-orange-500 mr-1 text-xs"></i>
                    <span data-fr="Mot de passe" data-en="Password" data-km="ពាក្យសម្ងាត់">Mot de passe</span>
                </label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition @error('password') border-red-300 bg-red-50 @enderror"
                       data-placeholder-fr="Entrez votre mot de passe"
                       data-placeholder-en="Enter your password"
                       data-placeholder-km="បញ្ចូលពាក្យសម្ងាត់"
                       placeholder="Entrez votre mot de passe"
                       required>
                @error('password')
                <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $message }}</span>
                </p>
                @enderror
            </div>

            <div class="mb-6 flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600 font-medium"
                           data-fr="Se souvenir de moi" data-en="Remember me" data-km="ចងចាំខ្ញុំ">
                        Se souvenir de moi
                    </label>
                </div>
                <a href="mailto:parrains@ailespourgrandir.org"
                   class="text-xs text-orange-500 hover:text-orange-600 font-semibold transition"
                   data-fr="Mot de passe oublié ?" data-en="Forgot password?" data-km="ភ្លេចពាក្យសម្ងាត់?">
                    Mot de passe oublié ?
                </a>
            </div>

            <button type="submit"
                    class="w-full py-3.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold text-sm uppercase tracking-wide rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-sign-in-alt mr-2"></i>
                <span data-fr="Se connecter" data-en="Log In" data-km="ចូល">Se connecter</span>
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="flex items-center justify-center gap-6 text-xs text-gray-500 flex-wrap">
                <div class="flex items-center gap-1">
                    <i class="fas fa-shield-alt text-green-500"></i>
                    <span data-fr="Connexion sécurisée" data-en="Secure login" data-km="ការចូលមានសុវត្ថិភាព">Connexion sécurisée</span>
                </div>
                <div class="flex items-center gap-1">
                    <i class="fas fa-lock text-orange-500"></i>
                    <span data-fr="Données protégées" data-en="Protected data" data-km="ទិន្នន័យត្រូវបានការពារ">Données protégées</span>
                </div>
            </div>
            <p class="text-center text-xs text-gray-500 mt-4">
                <span data-fr="Identifiants perdus ?" data-en="Lost credentials?" data-km="បាត់ព័ត៌មានចូល?">Identifiants perdus ?</span>
                <a href="mailto:parrains@ailespourgrandir.org"
                   class="text-orange-500 hover:underline font-semibold"
                   data-fr="Contactez-nous" data-en="Contact us" data-km="ទាក់ទងយើង">Contactez-nous</a>
            </p>
        </div>
    </div>

    {{-- New Sponsor CTA --}}
    <div class="mt-6 bg-white rounded-xl shadow-lg p-6 border-2 border-orange-200">
        <div class="text-center">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-heart text-orange-500 text-xl"></i>
            </div>
            <h3 class="font-black text-gray-800 mb-2"
                data-fr="Pas encore parrain ?" data-en="Not a sponsor yet?" data-km="មិនទាន់ជាអ្នកឧបត្ថម្ភ?">
                Pas encore parrain ?
            </h3>
            <p class="text-sm text-gray-600 mb-4"
               data-fr="Rejoignez-nous pour changer la vie d'un enfant"
               data-en="Join us to change a child's life"
               data-km="ចូលរួមជាមួយយើងដើម្បីផ្លាស់ប្តូរជីវិតកុមារ">
                Rejoignez-nous pour changer la vie d'un enfant
            </p>
            <a href="{{ route('sponsor.contact') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg transition shadow-md hover:shadow-lg">
                <i class="fas fa-envelope"></i>
                <span data-fr="Devenir parrain" data-en="Become a sponsor" data-km="ក្លាយជាអ្នកឧបត្ថម្ភ">Devenir parrain</span>
            </a>
        </div>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800 font-semibold transition">
            <i class="fas fa-arrow-left"></i>
            <span data-fr="Retour au site principal" data-en="Back to main site" data-km="ត្រលប់ទៅគេហទំព័រ">Retour au site principal</span>
        </a>
    </div>

    <div class="mt-8 text-center text-xs text-gray-400">
        <p>© {{ date('Y') }} Association Des Ailes Pour Grandir</p>
        <p class="mt-1" data-fr="Tous droits réservés" data-en="All rights reserved" data-km="រក្សាសិទ្ធិគ្រប់យ៉ាង">Tous droits réservés</p>
    </div>

</div>
</div>

{{-- ══ Language controller (same engine as header/dashboard) ══ --}}
<script>
const LOGIN_LANGS = {
    fr: { label:'Français', flag:'https://flagcdn.com/w40/fr.png' },
    en: { label:'English',  flag:'https://flagcdn.com/w40/us.png' },
    km: { label:'ខ្មែរ',     flag:'https://flagcdn.com/w40/kh.png' }
};
let loginCurrentLang = localStorage.getItem('gt_lang') || 'fr';

function loginTriggerTranslate(targetLang) {
    return new Promise(resolve => {
        const exp = 'expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = 'googtrans=; ' + exp;
        document.cookie = 'googtrans=; ' + exp + ' domain=' + location.hostname + ';';
        document.cookie = 'googtrans=; ' + exp + ' domain=.' + location.hostname + ';';
        if (targetLang === 'en') { resolve(); setTimeout(() => location.reload(), 80); return; }
        const pair = '/en/' + targetLang;
        document.cookie = 'googtrans=' + pair + '; path=/';
        document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname;
        const trySelect = tries => {
            const sel = document.querySelector('select.goog-te-combo');
            if (sel) { sel.value = targetLang; sel.dispatchEvent(new Event('change')); resolve(); }
            else if (tries > 0) setTimeout(() => trySelect(tries - 1), 200);
            else { resolve(); setTimeout(() => location.reload(), 80); }
        };
        trySelect(8);
    });
}

function loginUpdateUI(lang) {
    const cfg = LOGIN_LANGS[lang] || LOGIN_LANGS.fr;

    // Pill button
    const flagEl  = document.getElementById('login-flag');
    const labelEl = document.getElementById('login-lang-label');
    if (flagEl)  { flagEl.src = cfg.flag; flagEl.alt = lang.toUpperCase(); }
    if (labelEl) labelEl.textContent = cfg.label;

    // Dropdown option states
    ['fr','en','km'].forEach(l => {
        document.getElementById('login-btn-' + l)?.classList.toggle('active', l === lang);
        const chk = document.getElementById('login-check-' + l);
        if (chk) chk.classList.toggle('hidden', l !== lang);
    });

    // data-{lang} manual translations (instant, no network)
    document.querySelectorAll('[data-' + lang + ']').forEach(el => {
        const val = el.getAttribute('data-' + lang);
        if (!val) return;
        if (el.tagName === 'INPUT') el.placeholder = val;
        else el.textContent = val;
    });

    // data-placeholder-{lang} for inputs
    document.querySelectorAll('[data-placeholder-' + lang + ']').forEach(el => {
        el.placeholder = el.getAttribute('data-placeholder-' + lang);
    });

    // Font for Khmer
    document.body.style.fontFamily = lang === 'km'
        ? "'Hanuman','Battambang','Content','Montserrat',sans-serif"
        : "'Montserrat',sans-serif";

    loginCurrentLang = lang;
    localStorage.setItem('gt_lang', lang); // shared key with header & dashboard
}

async function loginSwitchLang(lang) {
    if (lang === loginCurrentLang) { loginClosePanel(); return; }
    loginUpdateUI(lang);
    await loginTriggerTranslate(lang);
    loginClosePanel();
}

function loginTogglePanel() {
    const panel = document.getElementById('login-translate-panel');
    const caret = document.getElementById('login-caret');
    const open  = panel.classList.toggle('open');
    if (caret) caret.style.transform = open ? 'rotate(180deg)' : '';
}
function loginClosePanel() {
    const p = document.getElementById('login-translate-panel');
    const c = document.getElementById('login-caret');
    if (p) p.classList.remove('open');
    if (c) c.style.transform = '';
}
document.addEventListener('click', e => {
    const w = document.getElementById('login-translate-wrapper');
    if (w && !w.contains(e.target)) loginClosePanel();
});

// Init on load
document.addEventListener('DOMContentLoaded', () => {
    const cookie = document.cookie.split(';').find(c => c.trim().startsWith('googtrans='));
    const stored = localStorage.getItem('gt_lang');

    if (cookie) {
        const parts = cookie.split('/');
        const cl = parts[parts.length - 1].trim();
        if (cl && LOGIN_LANGS[cl]) { loginCurrentLang = cl; localStorage.setItem('gt_lang', cl); }
    } else if (!stored) {
        // First visit → set French cookie + reload
        const pair = '/en/fr';
        document.cookie = 'googtrans=' + pair + '; path=/';
        document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname;
        localStorage.setItem('gt_lang', 'fr');
        location.reload();
        return;
    }
    loginUpdateUI(loginCurrentLang);
});
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>
</body>
</html>