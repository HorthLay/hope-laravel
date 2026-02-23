{{-- resources/views/sponsor/no-child.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Parrain | Association Des Ailes Pour Grandir</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

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

        @keyframes floatUp {
            0%   { opacity:0; transform:translateY(30px) scale(.96); }
            100% { opacity:1; transform:translateY(0) scale(1); }
        }
        @keyframes pulse-ring {
            0%   { transform:scale(1);   opacity:.6; }
            70%  { transform:scale(1.6); opacity:0; }
            100% { transform:scale(1.6); opacity:0; }
        }
        .animate-card  { animation: floatUp .55s cubic-bezier(.34,1.36,.64,1) both; }
        .pulse-ring {
            position:absolute; inset:0; border-radius:9999px;
            border:3px solid #f97316;
            animation: pulse-ring 2s ease-out infinite;
        }

        /* ── Language dropdown ── */
        .lang-pill {
            display:inline-flex; align-items:center; gap:7px;
            padding:6px 13px 6px 9px; border-radius:999px;
            border:2px solid #e5e7eb; background:#fff;
            cursor:pointer; font-size:12px; font-weight:800; color:#374151;
            transition:all .18s; white-space:nowrap;
            box-shadow:0 2px 8px rgba(0,0,0,.07);
        }
        .lang-pill:hover { border-color:#f97316; color:#f97316; box-shadow:0 4px 16px rgba(249,115,22,.15); }

        #nc-translate-panel {
            position:absolute; top:calc(100% + 8px); left:50%;
            transform:translateX(-50%) translateY(-6px);
            width:210px; background:#fff; border-radius:14px;
            box-shadow:0 16px 48px rgba(0,0,0,.18); border:1px solid #f0f0f0;
            padding:10px; opacity:0; visibility:hidden;
            transition:all .22s cubic-bezier(.34,1.56,.64,1); z-index:9999;
        }
        #nc-translate-panel.open { opacity:1; visibility:visible; transform:translateX(-50%) translateY(0); }

        .lang-opt {
            display:flex; align-items:center; gap:9px;
            width:100%; padding:9px 10px; border-radius:9px;
            border:2px solid transparent; background:transparent;
            cursor:pointer; transition:all .15s; text-align:left;
            font-size:12px; font-weight:600; color:#374151;
        }
        .lang-opt:hover  { background:#fff7ed; border-color:#fed7aa; }
        .lang-opt.active { background:linear-gradient(135deg,#fff7ed,#ffedd5); border-color:#f97316; color:#c2410c; }
        .lang-opt .flag  { width:22px; height:15px; object-fit:cover; border-radius:2px; box-shadow:0 1px 4px rgba(0,0,0,.15); flex-shrink:0; }
        .lang-opt .chk   { margin-left:auto; color:#f97316; font-size:10px; }
    </style>
</head>
<body class="min-h-screen flex flex-col" style="background: linear-gradient(135deg,#fff7ed 0%,#ffedd5 40%,#fed7aa 100%);">

{{-- Hidden Google Translate widget --}}
<div id="google_translate_element" style="display:none;position:absolute"></div>

{{-- ── Top bar: logo + lang ── --}}
<header class="w-full px-6 py-4 flex items-center justify-between max-w-5xl mx-auto w-full">
    <a href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo"
             style="height:56px;width:auto;filter:drop-shadow(0 2px 8px rgba(0,0,0,.2));">
    </a>

    {{-- Language dropdown --}}
    <div class="relative" id="nc-translate-wrapper">
        <button class="lang-pill" onclick="ncTogglePanel()">
            <img src="https://flagcdn.com/w40/fr.png" id="nc-flag" class="w-5 h-3.5 rounded object-cover shadow-sm" alt="FR">
            <span id="nc-lang-label" class="font-black">Français</span>
            <i class="fas fa-chevron-down text-[9px] text-gray-400" id="nc-caret"></i>
        </button>
        <div id="nc-translate-panel">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-1 mb-2">
                <i class="fas fa-globe mr-1 text-orange-400"></i> Language
            </p>
            <button class="lang-opt active" id="nc-btn-fr" onclick="ncSwitchLang('fr')">
                <img src="https://flagcdn.com/w40/fr.png" class="flag" alt="FR">
                <div><div class="font-bold">Français</div><div class="text-[10px] text-gray-400 font-normal">French</div></div>
                <i class="fas fa-check chk" id="nc-check-fr"></i>
            </button>
            <button class="lang-opt" id="nc-btn-en" onclick="ncSwitchLang('en')">
                <img src="https://flagcdn.com/w40/us.png" class="flag" alt="EN">
                <div><div class="font-bold">English</div><div class="text-[10px] text-gray-400 font-normal">Original</div></div>
                <i class="fas fa-check chk hidden" id="nc-check-en"></i>
            </button>
            <button class="lang-opt" id="nc-btn-km" onclick="ncSwitchLang('km')">
                <img src="https://flagcdn.com/w40/kh.png" class="flag" alt="KH">
                <div><div class="font-bold">ខ្មែរ</div><div class="text-[10px] text-gray-400 font-normal">Cambodian</div></div>
                <i class="fas fa-check chk hidden" id="nc-check-km"></i>
            </button>
        </div>
    </div>
</header>

{{-- ── Main content ── --}}
<main class="flex-1 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md animate-card">

        {{-- Card --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-orange-100">

            {{-- Orange top band --}}
            <div class="bg-gradient-to-r from-orange-500 to-orange-400 px-8 pt-10 pb-16 text-center relative">
                {{-- Decorative circles --}}
                <div class="absolute top-4 left-4 w-16 h-16 rounded-full bg-white/10"></div>
                <div class="absolute top-10 right-6 w-8 h-8 rounded-full bg-white/10"></div>
                <div class="absolute bottom-6 left-10 w-5 h-5 rounded-full bg-white/15"></div>

                <h1 class="text-2xl md:text-3xl font-black text-white mb-1 relative z-10">
                    <span data-fr="Bienvenue," data-en="Welcome," data-km="សូមស្វាគមន៍,">Bienvenue,</span>
                    {{ $sponsor->first_name }}&nbsp;!
                </h1>
                <p class="text-white/80 text-sm font-medium relative z-10"
                   data-fr="Espace Parrain" data-en="Sponsor Portal" data-km="តំបន់ឧបត្ថម្ភ">
                    Espace Parrain
                </p>
            </div>

            {{-- Icon bubble (overlaps the band) --}}
            <div class="flex justify-center -mt-10 mb-6 relative z-10">
                <div class="relative">
                    <div class="pulse-ring"></div>
                    <div class="w-20 h-20 rounded-full bg-white shadow-xl border-4 border-orange-100 flex items-center justify-center relative z-10">
                        <i class="fas fa-child text-orange-400 text-3xl"></i>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-8 pb-8 text-center">
                <h2 class="text-lg font-black text-gray-800 mb-3"
                    data-fr="Compte activé, parrainage en attente"
                    data-en="Account active, sponsorship pending"
                    data-km="គណនីដំណើរការ កំពុងរង់ចាំការឧបត្ថម្ភ">
                    Compte activé, parrainage en attente
                </h2>
                <p class="text-gray-500 text-sm leading-relaxed mb-8"
                   data-fr="Votre compte est actif, mais aucun filleul ne vous a encore été assigné. Contactez-nous pour finaliser votre parrainage."
                   data-en="Your account is active, but no child has been assigned to you yet. Please contact us to complete your sponsorship."
                   data-km="គណនីរបស់អ្នកដំណើរការ ប៉ុន្តែមិនទាន់មានកុមារណាម្នាក់ត្រូវបានកំណត់ទៅអ្នកនៅឡើយ។ សូមទាក់ទងយើងដើម្បីបញ្ចប់ការឧបត្ថម្ភ។">
                    Votre compte est actif, mais aucun filleul ne vous a encore été assigné. Contactez-nous pour finaliser votre parrainage.
                </p>

                {{-- Contact button --}}
                <a href="mailto:parrains@ailespourgrandir.org"
                   class="flex items-center justify-center gap-2 w-full py-3.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold text-sm uppercase tracking-wide rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 mb-3">
                    <i class="fas fa-envelope text-sm"></i>
                    <span data-fr="Contacter l'équipe" data-en="Contact our team" data-km="ទាក់ទងក្រុមការងាររបស់យើង">Contacter l'équipe</span>
                </a>

                {{-- Back to site --}}
                <a href="{{ route('home') }}"
                   class="flex items-center justify-center gap-2 w-full py-3 bg-orange-50 hover:bg-orange-100 text-orange-600 font-bold text-sm rounded-xl transition mb-6 border-2 border-orange-100 hover:border-orange-200">
                    <i class="fas fa-home text-xs"></i>
                    <span data-fr="Retour au site" data-en="Back to site" data-km="ត្រលប់ទៅគេហទំព័រ">Retour au site</span>
                </a>

                {{-- Divider --}}
                <div class="border-t border-gray-100 pt-5">
                    <form method="POST" action="{{ route('sponsor.logout') }}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-red-500 font-bold transition">
                            <i class="fas fa-sign-out-alt"></i>
                            <span data-fr="Se déconnecter" data-en="Logout" data-km="ចាកចេញ">Se déconnecter</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Footer note --}}
        <p class="text-center text-xs text-orange-700/60 font-medium mt-6">
            © {{ date('Y') }} Association Des Ailes Pour Grandir
        </p>

    </div>
</main>

{{-- ══ Language controller ══ --}}
<script>
const NC_LANGS = {
    fr: { label:'Français', flag:'https://flagcdn.com/w40/fr.png' },
    en: { label:'English',  flag:'https://flagcdn.com/w40/us.png' },
    km: { label:'ខ្មែរ',     flag:'https://flagcdn.com/w40/kh.png' }
};
let ncCurrentLang = localStorage.getItem('gt_lang') || 'fr';

function ncTriggerTranslate(targetLang) {
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

function ncUpdateUI(lang) {
    const cfg = NC_LANGS[lang] || NC_LANGS.fr;
    const flagEl  = document.getElementById('nc-flag');
    const labelEl = document.getElementById('nc-lang-label');
    if (flagEl)  { flagEl.src = cfg.flag; flagEl.alt = lang.toUpperCase(); }
    if (labelEl) labelEl.textContent = cfg.label;
    ['fr','en','km'].forEach(l => {
        document.getElementById('nc-btn-' + l)?.classList.toggle('active', l === lang);
        const chk = document.getElementById('nc-check-' + l);
        if (chk) chk.classList.toggle('hidden', l !== lang);
    });
    document.querySelectorAll('[data-' + lang + ']').forEach(el => {
        const val = el.getAttribute('data-' + lang);
        if (val) el.textContent = val;
    });
    document.body.style.fontFamily = lang === 'km'
        ? "'Hanuman','Battambang','Content','Montserrat',sans-serif"
        : "'Montserrat',sans-serif";
    ncCurrentLang = lang;
    localStorage.setItem('gt_lang', lang);
}

async function ncSwitchLang(lang) {
    if (lang === ncCurrentLang) { ncClosePanel(); return; }
    ncUpdateUI(lang);
    await ncTriggerTranslate(lang);
    ncClosePanel();
}

function ncTogglePanel() {
    const panel = document.getElementById('nc-translate-panel');
    const caret = document.getElementById('nc-caret');
    const open  = panel.classList.toggle('open');
    if (caret) caret.style.transform = open ? 'rotate(180deg)' : '';
}
function ncClosePanel() {
    const p = document.getElementById('nc-translate-panel');
    const c = document.getElementById('nc-caret');
    if (p) p.classList.remove('open');
    if (c) c.style.transform = '';
}
document.addEventListener('click', e => {
    const w = document.getElementById('nc-translate-wrapper');
    if (w && !w.contains(e.target)) ncClosePanel();
});

document.addEventListener('DOMContentLoaded', () => {
    const cookie = document.cookie.split(';').find(c => c.trim().startsWith('googtrans='));
    const stored = localStorage.getItem('gt_lang');
    if (cookie) {
        const parts = cookie.split('/');
        const cl = parts[parts.length - 1].trim();
        if (cl && NC_LANGS[cl]) { ncCurrentLang = cl; localStorage.setItem('gt_lang', cl); }
    } else if (!stored) {
        const pair = '/en/fr';
        document.cookie = 'googtrans=' + pair + '; path=/';
        document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname;
        localStorage.setItem('gt_lang', 'fr');
        location.reload();
        return;
    }
    ncUpdateUI(ncCurrentLang);
});
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>
</body>
</html>