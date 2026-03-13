{{-- resources/views/sponsor/no-child.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hope & Impact') | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
    <meta name="description" content="@yield('meta_description', $settings['meta_description'] ?? '')">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en', includedLanguages: 'en,km,fr',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false, multilanguagePage: true
        }, 'google_translate_element');
    }
    </script>

    <style>
        body { font-family: 'Montserrat', sans-serif; top: 0 !important; }
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
        .animate-card { animation: floatUp .55s cubic-bezier(.34,1.36,.64,1) both; }
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

        /* ── Contact rows ── */
        .contact-row {
            display:flex; align-items:center; gap:12px;
            padding:11px 14px; border-radius:14px;
            text-decoration:none; border:1.5px solid #f0f0f0;
            background:#fafafa; transition:all .18s; cursor:pointer;
            margin-bottom:8px;
        }
        .contact-row:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.09); }
        .contact-row:last-child { margin-bottom:0; }
        .contact-row .cr-icon {
            width:38px; height:38px; border-radius:10px; flex-shrink:0;
            display:flex; align-items:center; justify-content:center; font-size:17px;
        }
        .contact-row .cr-body { flex:1; min-width:0; }
        .contact-row .cr-title { font-size:12px; font-weight:800; color:#1f2937; }
        .contact-row .cr-sub   { font-size:11px; color:#9ca3af; margin-top:1px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .contact-row .cr-arrow { color:#d1d5db; font-size:10px; flex-shrink:0; transition:color .15s; }
        .contact-row:hover .cr-arrow { color:#f97316; }
        .contact-row.cr-email:hover     { background:#fff7ed; border-color:#fed7aa; }
        .contact-row.cr-whatsapp:hover  { background:#f0fdf4; border-color:#bbf7d0; }
        .contact-row.cr-telegram:hover  { background:#f0f9ff; border-color:#bae6fd; }
        .contact-row.cr-facebook:hover  { background:#eff6ff; border-color:#bfdbfe; }
        .contact-row.cr-instagram:hover { background:#fdf2f8; border-color:#f5d0fe; }
        .contact-row.cr-phone:hover     { background:#f0fdf4; border-color:#bbf7d0; }
    </style>
</head>
<body class="min-h-screen flex flex-col" style="background:linear-gradient(135deg,#fff7ed 0%,#ffedd5 40%,#fed7aa 100%);">

<div id="google_translate_element" style="display:none;position:absolute"></div>

{{-- ── Top bar ── --}}
<header class="w-full px-6 py-4 flex items-center justify-between max-w-5xl mx-auto">
    <a href="{{ route('home') }}">
        @if(!empty($settings['logo']))
            <img src="{{ asset($settings['logo']) }}" alt="{{ $settings['site_name'] ?? 'Logo' }}"
                 style="height:56px;width:auto;filter:drop-shadow(0 2px 8px rgba(0,0,0,.2));">
        @else
            <img src="{{ asset('images/logo.png') }}" alt="Logo"
                 style="height:56px;width:auto;filter:drop-shadow(0 2px 8px rgba(0,0,0,.2));">
        @endif
    </a>

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

{{-- ── Main ── --}}
<main class="flex-1 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md animate-card">

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-orange-100">

            {{-- Orange top band --}}
            <div class="bg-gradient-to-r from-orange-500 to-orange-400 px-8 pt-10 pb-16 text-center relative">
                <div class="absolute top-4 left-4 w-16 h-16 rounded-full bg-white/10"></div>
                <div class="absolute top-10 right-6 w-8 h-8 rounded-full bg-white/10"></div>
                <div class="absolute bottom-6 left-10 w-5 h-5 rounded-full bg-white/15"></div>
                <h1 class="text-2xl md:text-3xl font-black text-white mb-1 relative z-10">
                    <span data-fr="Bienvenue," data-en="Welcome," data-km="សូមស្វាគមន៍,">Bienvenue,</span>
                    {{ $sponsor->first_name }}&nbsp;!
                </h1>
                <p class="text-white/80 text-sm font-medium relative z-10"
                   data-fr="Espace Parrain" data-en="Sponsor Portal" data-km="តំបន់ឧបត្ថម្ភ">Espace Parrain</p>
            </div>

            {{-- Icon bubble --}}
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
                <p class="text-gray-500 text-sm leading-relaxed mb-6"
                   data-fr="Votre compte est actif, mais aucun filleul ne vous a encore été assigné. Contactez-nous pour finaliser votre parrainage."
                   data-en="Your account is active, but no child has been assigned to you yet. Please contact us to complete your sponsorship."
                   data-km="គណនីរបស់អ្នកដំណើរការ ប៉ុន្តែមិនទាន់មានកុមារណាម្នាក់ត្រូវបានកំណត់ទៅអ្នកនៅឡើយ។ សូមទាក់ទងយើងដើម្បីបញ្ចប់ការឧបត្ថម្ភ។">
                    Votre compte est actif, mais aucun filleul ne vous a encore été assigné. Contactez-nous pour finaliser votre parrainage.
                </p>

                {{-- ══ CONTACT CHANNELS FROM SETTINGS ══ --}}
                @php
                    $s_email     = $settings['contact_email']  ?? null;
                    $s_whatsapp  = $settings['whatsapp_url']   ?? null;
                    $s_telegram  = $settings['telegram_url']   ?? null;
                    $s_facebook  = $settings['facebook_url']   ?? null;
                    $s_instagram = $settings['instagram_url']  ?? null;
                    $s_phone     = $settings['contact_phone']  ?? null;
                    $s_any       = $s_email || $s_whatsapp || $s_telegram || $s_facebook || $s_instagram || $s_phone;
                @endphp

                @if($s_any)
                <div class="mb-6 text-left">
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-wider mb-3 text-center"
                       data-fr="Contactez-nous via" data-en="Reach us via" data-km="ទាក់ទងយើងតាម">
                        Contactez-nous via
                    </p>

                    @if($s_email)
                    <a href="https://mail.google.com/mail/?view=cm&to={{ $s_email }}&subject={{ urlencode('Parrainage — ' . ($sponsor->first_name ?? '') . ' ' . ($sponsor->last_name ?? '')) }}"
                       target="_blank" class="contact-row cr-email">
                        <div class="cr-icon" style="background:#fff7ed"><i class="fas fa-envelope" style="color:#f97316"></i></div>
                        <div class="cr-body">
                            <div class="cr-title" data-fr="Envoyer un email" data-en="Send an email" data-km="ផ្ញើអ៊ីមែល">Envoyer un email</div>
                            <div class="cr-sub">{{ $s_email }}</div>
                        </div>
                        <i class="fas fa-external-link-alt cr-arrow"></i>
                    </a>
                    @endif

                    @if($s_whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $s_whatsapp) }}?text={{ urlencode('Bonjour, je suis ' . ($sponsor->first_name ?? '') . ' ' . ($sponsor->last_name ?? '') . '. Je souhaite finaliser mon parrainage.') }}"
                       target="_blank" class="contact-row cr-whatsapp">
                        <div class="cr-icon" style="background:#f0fdf4"><i class="fab fa-whatsapp" style="color:#22c55e;font-size:19px"></i></div>
                        <div class="cr-body">
                            <div class="cr-title">WhatsApp</div>
                            <div class="cr-sub" data-fr="Message instantané" data-en="Instant message" data-km="សារភ្លាមៗ">Message instantané</div>
                        </div>
                        <i class="fas fa-external-link-alt cr-arrow"></i>
                    </a>
                    @endif

                    @if($s_telegram)
                    <a href="https://t.me/{{ ltrim($s_telegram, '@') }}" target="_blank" class="contact-row cr-telegram">
                        <div class="cr-icon" style="background:#f0f9ff"><i class="fab fa-telegram" style="color:#0ea5e9;font-size:19px"></i></div>
                        <div class="cr-body">
                            <div class="cr-title">Telegram</div>
                            <div class="cr-sub">{{ $s_telegram }}</div>
                        </div>
                        <i class="fas fa-external-link-alt cr-arrow"></i>
                    </a>
                    @endif

                    @if($s_facebook)
                    <a href="{{ $s_facebook }}" target="_blank" class="contact-row cr-facebook">
                        <div class="cr-icon" style="background:#eff6ff"><i class="fab fa-facebook-messenger" style="color:#2563eb;font-size:19px"></i></div>
                        <div class="cr-body">
                            <div class="cr-title">Facebook Messenger</div>
                            <div class="cr-sub" data-fr="Écrivez-nous sur Facebook" data-en="Message us on Facebook" data-km="ផ្ញើសារតាម Facebook">Écrivez-nous sur Facebook</div>
                        </div>
                        <i class="fas fa-external-link-alt cr-arrow"></i>
                    </a>
                    @endif

                    @if($s_instagram)
                    <a href="{{ $s_instagram }}" target="_blank" class="contact-row cr-instagram">
                        <div class="cr-icon" style="background:#fdf2f8"><i class="fab fa-instagram" style="color:#ec4899;font-size:19px"></i></div>
                        <div class="cr-body">
                            <div class="cr-title">Instagram</div>
                            <div class="cr-sub" data-fr="Envoyez un DM" data-en="Send a DM" data-km="ផ្ញើ DM">Envoyez un DM</div>
                        </div>
                        <i class="fas fa-external-link-alt cr-arrow"></i>
                    </a>
                    @endif

                    @if($s_phone)
                    <a href="tel:{{ preg_replace('/\s+/', '', $s_phone) }}" class="contact-row cr-phone">
                        <div class="cr-icon" style="background:#f0fdf4"><i class="fas fa-phone" style="color:#16a34a"></i></div>
                        <div class="cr-body">
                            <div class="cr-title" data-fr="Appeler" data-en="Call us" data-km="ហៅទូរស័ព្ទ">Appeler</div>
                            <div class="cr-sub">{{ $s_phone }}</div>
                        </div>
                        <i class="fas fa-phone-alt cr-arrow" style="color:#16a34a"></i>
                    </a>
                    @endif
                </div>
                @else
                {{-- Fallback if nothing configured in settings --}}
                <div class="mb-6 bg-orange-50 border border-orange-100 rounded-2xl p-4 text-sm text-orange-700 font-medium">
                    <i class="fas fa-info-circle mr-2 text-orange-400"></i>
                    <span data-fr="Aucun contact configuré pour le moment."
                          data-en="No contact configured yet."
                          data-km="មិនមានទំនាក់ទំនងដែលបានកំណត់ទេ។">
                        Aucun contact configuré pour le moment.
                    </span>
                </div>
                @endif

                {{-- Back to site --}}
                <a href="{{ route('home') }}"
                   class="flex items-center justify-center gap-2 w-full py-3 bg-orange-50 hover:bg-orange-100 text-orange-600 font-bold text-sm rounded-xl transition mb-6 border-2 border-orange-100 hover:border-orange-200">
                    <i class="fas fa-home text-xs"></i>
                    <span data-fr="Retour au site" data-en="Back to site" data-km="ត្រលប់ទៅគេហទំព័រ">Retour au site</span>
                </a>

                {{-- Logout --}}
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

        <p class="text-center text-xs text-orange-700/60 font-medium mt-6">
            © {{ date('Y') }} {{ $settings['site_name'] ?? 'Association Des Ailes Pour Grandir' }}
        </p>
    </div>
</main>

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