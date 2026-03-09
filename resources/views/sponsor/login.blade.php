{{-- resources/views/sponsor/login.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
    <meta name="description" content="{{ $settings['meta_description'] ?? $settings['site_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '' }}">
    @if(!empty($settings['favicon']))<link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">@endif
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

        @keyframes slideUp   { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        @keyframes scaleIn   { from{opacity:0;transform:scale(.93) translateY(-8px)} to{opacity:1;transform:scale(1) translateY(0)} }
        @keyframes sheetUp   { from{transform:translateY(110%)} to{transform:translateY(0)} }
        .animate-slide-up    { animation: slideUp .5s ease-out; }

        /* ── Language pill ── */
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
            transition:all .22s cubic-bezier(.34,1.56,.64,1); z-index:9999;
        }
        #login-translate-panel.open { opacity:1; visibility:visible; transform:translateX(-50%) translateY(0); }
        .lang-opt {
            display:flex; align-items:center; gap:9px; width:100%; padding:9px 10px; border-radius:9px;
            border:2px solid transparent; background:transparent; cursor:pointer;
            transition:all .15s; text-align:left; font-size:12px; font-weight:600; color:#374151;
        }
        .lang-opt:hover { background:#fff7ed; border-color:#fed7aa; }
        .lang-opt.active { background:linear-gradient(135deg,#fff7ed,#ffedd5); border-color:#f4b630; color:#ea580c; }
        .lang-opt .flag { width:22px; height:15px; object-fit:cover; border-radius:2px; box-shadow:0 1px 4px rgba(0,0,0,.15); flex-shrink:0; }
        .lang-opt .chk  { margin-left:auto; color:#f4b630; font-size:10px; }

        /* ══════════════════════════════════════════
           FORGOT MODAL — shared overlay
        ══════════════════════════════════════════ */
        .forgot-overlay {
            position:fixed; inset:0; z-index:10000;
            background:rgba(0,0,0,.5); backdrop-filter:blur(6px);
            opacity:0; visibility:hidden;
            transition:opacity .25s ease, visibility .25s ease;
        }
        .forgot-overlay.open { opacity:1; visibility:visible; }

        /* ── MOBILE: bottom sheet (≤767px) ── */
        .forgot-mobile-sheet {
            position:absolute; bottom:0; left:0; right:0;
            background:#fff; border-radius:28px 28px 0 0;
            max-height:92dvh; overflow-y:auto;
            transform:translateY(110%);
            transition:transform .32s cubic-bezier(.4,0,.2,1);
            padding-bottom:env(safe-area-inset-bottom, 20px);
            box-shadow:0 -8px 48px rgba(0,0,0,.2);
            display:none;
        }
        .forgot-handle {
            width:40px; height:4px; background:#e5e7eb;
            border-radius:2px; margin:14px auto 0;
        }

        /* ── DESKTOP: centered dialog (≥768px) ── */
        .forgot-desktop-dialog {
            position:absolute; top:50%; left:50%;
            transform:translate(-50%,-50%) scale(.93);
            width:520px; max-width:calc(100vw - 32px);
            background:#fff; border-radius:24px;
            max-height:90vh; overflow-y:auto;
            opacity:0;
            transition:opacity .22s ease, transform .22s cubic-bezier(.34,1.1,.64,1);
            box-shadow:0 32px 80px rgba(0,0,0,.28), 0 0 0 1px rgba(0,0,0,.06);
            display:none;
        }
        .forgot-desktop-dialog.dialog-ready {
            opacity:1; transform:translate(-50%,-50%) scale(1);
        }

        /* ── Responsive show/hide ── */
        @media (max-width: 767px) {
            .forgot-mobile-sheet { display:block; }
            .forgot-desktop-dialog { display:none !important; }
        }
        @media (min-width: 768px) {
            .forgot-mobile-sheet { display:none !important; }
            .forgot-desktop-dialog { display:block; }
        }

        /* ── Open states ── */
        .forgot-overlay.open .forgot-mobile-sheet { transform:translateY(0); }
        .forgot-overlay.open .forgot-desktop-dialog { opacity:1; transform:translate(-50%,-50%) scale(1); }

        /* ── Desktop decorative sidebar strip ── */
        .dialog-sidebar {
            width:200px; flex-shrink:0;
            background:linear-gradient(160deg,#f97316 0%,#ea580c 60%,#c2410c 100%);
            border-radius:24px 0 0 24px;
            padding:32px 20px;
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            gap:16px; color:#fff; text-align:center;
        }
        .dialog-sidebar .sidebar-icon {
            width:64px; height:64px; border-radius:20px;
            background:rgba(255,255,255,.18); border:2px solid rgba(255,255,255,.3);
            display:flex; align-items:center; justify-content:center;
            font-size:26px;
        }
        .dialog-sidebar .sidebar-title {
            font-size:15px; font-weight:900; line-height:1.3; letter-spacing:-.01em;
        }
        .dialog-sidebar .sidebar-sub {
            font-size:11px; color:rgba(255,255,255,.75); line-height:1.5;
        }
        .dialog-sidebar .sidebar-badge {
            display:inline-flex; align-items:center; gap:5px;
            background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.3);
            border-radius:99px; padding:4px 10px;
            font-size:10px; font-weight:700;
        }

        /* ── Contact rows (shared) ── */
        .contact-row {
            display:flex; align-items:center; gap:13px;
            padding:12px 14px; border-radius:14px;
            text-decoration:none; border:1.5px solid #f0f0f0;
            background:#fafafa; transition:all .18s; cursor:pointer;
        }
        .contact-row:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.09); }
        .contact-row .cr-icon {
            width:42px; height:42px; border-radius:12px; flex-shrink:0;
            display:flex; align-items:center; justify-content:center; font-size:19px;
        }
        .contact-row .cr-body { flex:1; min-width:0; }
        .contact-row .cr-title { font-size:13px; font-weight:800; color:#1f2937; }
        .contact-row .cr-sub   { font-size:11px; color:#9ca3af; margin-top:2px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .contact-row .cr-arrow { color:#d1d5db; font-size:11px; flex-shrink:0; transition:color .15s; }
        .contact-row:hover .cr-arrow { color:#f97316; }
        .contact-row.cr-email:hover     { background:#fff7ed; border-color:#fed7aa; }
        .contact-row.cr-whatsapp:hover  { background:#f0fdf4; border-color:#bbf7d0; }
        .contact-row.cr-telegram:hover  { background:#f0f9ff; border-color:#bae6fd; }
        .contact-row.cr-facebook:hover  { background:#eff6ff; border-color:#bfdbfe; }
        .contact-row.cr-instagram:hover { background:#fdf2f8; border-color:#f5d0fe; }
        .contact-row.cr-phone:hover     { background:#f0fdf4; border-color:#bbf7d0; }
    </style>
</head>
<body>

<div id="google_translate_element" style="display:none;position:absolute"></div>

<div class="bg-gradient-to-br from-orange-50 via-orange-50 to-orange-100 min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md animate-slide-up">

    {{-- Language dropdown --}}
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
                    <div><div class="font-bold">Français</div><div class="text-[10px] font-normal text-gray-400">French</div></div>
                    <i class="fas fa-check chk" id="login-check-fr"></i>
                </button>
                <button class="lang-opt" id="login-btn-en" onclick="loginSwitchLang('en')">
                    <img src="https://flagcdn.com/w40/us.png" class="flag" alt="EN">
                    <div><div class="font-bold">English</div><div class="text-[10px] font-normal text-gray-400">Original</div></div>
                    <i class="fas fa-check chk hidden" id="login-check-en"></i>
                </button>
                <button class="lang-opt" id="login-btn-km" onclick="loginSwitchLang('km')">
                    <img src="https://flagcdn.com/w40/kh.png" class="flag" alt="KH">
                    <div><div class="font-bold">ខ្មែរ</div><div class="text-[10px] font-normal text-gray-400">Cambodian</div></div>
                    <i class="fas fa-check chk hidden" id="login-check-km"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
            @if(!empty($settings['logo']))
            <img src="{{ asset($settings['logo']) }}" alt="{{ $settings['site_name'] ?? '' }}" style="height:100px;width:auto;object-fit:contain;">
            @else
            <img src="{{ asset('images/logo.png') }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" style="height:100px;width:auto;object-fit:contain;">
            @endif
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
            <div class="flex items-center gap-2"><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-lg">
            <div class="flex items-center gap-2"><i class="fas fa-exclamation-circle"></i><span>{{ session('error') }}</span></div>
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
                       placeholder="Entrez votre nom d'utilisateur" required autofocus>
                @error('username')<p class="mt-2 text-xs text-red-600 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i><span>{{ $message }}</span></p>@enderror
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
                       placeholder="Entrez votre mot de passe" required>
                @error('password')<p class="mt-2 text-xs text-red-600 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i><span>{{ $message }}</span></p>@enderror
            </div>

            <div class="mb-6 flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600 font-medium"
                           data-fr="Se souvenir de moi" data-en="Remember me" data-km="ចងចាំខ្ញុំ">Se souvenir de moi</label>
                </div>
                <button type="button" onclick="openForgotModal()"
                        class="text-xs text-orange-500 hover:text-orange-600 font-semibold transition hover:underline underline-offset-2"
                        data-fr="Mot de passe oublié ?" data-en="Forgot password?" data-km="ភ្លេចពាក្យសម្ងាត់?">
                    Mot de passe oublié ?
                </button>
            </div>

            <button type="submit"
                    class="w-full py-3.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold text-sm uppercase tracking-wide rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-sign-in-alt mr-2"></i>
                <span data-fr="Se connecter" data-en="Log In" data-km="ចូល">Se connecter</span>
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="flex items-center justify-center gap-6 text-xs text-gray-500 flex-wrap">
                <div class="flex items-center gap-1"><i class="fas fa-shield-alt text-green-500"></i><span data-fr="Connexion sécurisée" data-en="Secure login" data-km="ការចូលមានសុវត្ថិភាព">Connexion sécurisée</span></div>
                <div class="flex items-center gap-1"><i class="fas fa-lock text-orange-500"></i><span data-fr="Données protégées" data-en="Protected data" data-km="ទិន្នន័យត្រូវបានការពារ">Données protégées</span></div>
            </div>
            <p class="text-center text-xs text-gray-500 mt-4">
                <span data-fr="Identifiants perdus ?" data-en="Lost credentials?" data-km="បាត់ព័ត៌មានចូល?">Identifiants perdus ?</span>
                <button type="button" onclick="openForgotModal()" class="text-orange-500 hover:underline font-semibold ml-1"
                        data-fr="Contactez-nous" data-en="Contact us" data-km="ទាក់ទងយើង">Contactez-nous</button>
            </p>
        </div>
    </div>

    {{-- New Sponsor CTA --}}
    <div class="mt-6 bg-white rounded-xl shadow-lg p-6 border-2 border-orange-200">
        <div class="text-center">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-heart text-orange-500 text-xl"></i>
            </div>
            <h3 class="font-black text-gray-800 mb-2" data-fr="Pas encore parrain ?" data-en="Not a sponsor yet?" data-km="មិនទាន់ជាអ្នកឧបត្ថម្ភ?">Pas encore parrain ?</h3>
            <p class="text-sm text-gray-600 mb-4" data-fr="Rejoignez-nous pour changer la vie d'un enfant" data-en="Join us to change a child's life" data-km="ចូលរួមជាមួយយើងដើម្បីផ្លាស់ប្តូរជីវិតកុមារ">Rejoignez-nous pour changer la vie d'un enfant</p>
            <a href="{{ route('sponsor.contact') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg transition shadow-md hover:shadow-lg">
                <i class="fas fa-envelope"></i>
                <span data-fr="Devenir parrain" data-en="Become a sponsor" data-km="ក្លាយជាអ្នកឧបត្ថម្ភ">Devenir parrain</span>
            </a>
        </div>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800 font-semibold transition">
            <i class="fas fa-arrow-left"></i>
            <span data-fr="Retour au site principal" data-en="Back to main site" data-km="ត្រលប់ទៅគេហទំព័រ">Retour au site principal</span>
        </a>
    </div>

    <div class="mt-8 text-center text-xs text-gray-400">
        <p>© {{ date('Y') }} {{ $settings['site_name'] ?? 'Association Des Ailes Pour Grandir' }}</p>
        <p class="mt-1" data-fr="Tous droits réservés" data-en="All rights reserved" data-km="រក្សាសិទ្ធិគ្រប់យ៉ាង">Tous droits réservés</p>
    </div>

</div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     FORGOT PASSWORD MODAL
     • Mobile  (≤767px) : bottom sheet slides up from bottom
     • Desktop (≥768px) : centered dialog with orange sidebar
═══════════════════════════════════════════════════════════ --}}

@php
    $fp_email     = $settings['contact_email']  ?? null;
    $fp_whatsapp  = $settings['whatsapp_url']   ?? null;
    $fp_telegram  = $settings['telegram_url']   ?? null;
    $fp_facebook  = $settings['facebook_url']   ?? null;
    $fp_instagram = $settings['instagram_url']  ?? null;
    $fp_phone     = $settings['contact_phone']  ?? null;
    $fp_any       = $fp_email || $fp_whatsapp || $fp_telegram || $fp_facebook || $fp_instagram || $fp_phone;
@endphp

<div class="forgot-overlay" id="forgot-overlay" onclick="handleForgotOverlay(event)">

    {{-- ── MOBILE: bottom sheet ── --}}
    <div class="forgot-mobile-sheet" id="forgot-mobile-sheet">
        <div class="forgot-handle"></div>
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 sticky top-0 bg-white z-10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-orange-100 flex items-center justify-center">
                    <i class="fas fa-lock text-orange-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-black text-gray-900" data-fr="Mot de passe oublié ?" data-en="Forgot your password?" data-km="ភ្លេចពាក្យសម្ងាត់?">Mot de passe oublié ?</p>
                    <p class="text-[11px] text-gray-400" data-fr="Contactez notre équipe" data-en="Contact our team" data-km="ទាក់ទងក្រុមការងាររបស់យើង">Contactez notre équipe</p>
                </div>
            </div>
            <button onclick="closeForgotModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 text-sm transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        {{-- Body --}}
        <div class="px-5 pt-5 pb-8">
            <div class="flex items-start gap-3 bg-orange-50 border border-orange-100 rounded-2xl p-4 mb-4">
                <i class="fas fa-info-circle text-orange-400 mt-0.5 flex-shrink-0 text-sm"></i>
                <p class="text-xs text-orange-700 leading-relaxed font-medium"
                   data-fr="Contactez notre équipe pour réinitialiser votre mot de passe. Nous répondons rapidement."
                   data-en="Contact our team to reset your password. We respond quickly."
                   data-km="ទាក់ទងក្រុមការងាររបស់យើងដើម្បីកំណត់ពាក្យសម្ងាត់ឡើងវិញ។">
                    Contactez notre équipe pour réinitialiser votre mot de passe. Nous répondons rapidement.
                </p>
            </div>
            <div style="display:flex;flex-direction:column;gap:9px;">
                @include('sponsor._forgot_contacts')
            </div>
            <button onclick="closeForgotModal()"
                    class="mt-5 w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition"
                    data-fr="Fermer" data-en="Close" data-km="បិទ">Fermer</button>
        </div>
    </div>

    {{-- ── DESKTOP: centered dialog ── --}}
    <div class="forgot-desktop-dialog" id="forgot-desktop-dialog">
        <div style="display:flex;min-height:0">

            {{-- Orange sidebar --}}
            <div class="dialog-sidebar">
                <div class="sidebar-icon"><i class="fas fa-lock"></i></div>
                <div>
                    <div class="sidebar-title" data-fr="Mot de passe oublié ?" data-en="Forgot password?" data-km="ភ្លេចពាក្យសម្ងាត់?">Mot de passe oublié ?</div>
                    <div class="sidebar-sub mt-2" data-fr="Notre équipe est là pour vous aider à récupérer l'accès à votre compte." data-en="Our team is here to help you recover access to your account." data-km="ក្រុមការងាររបស់យើងនៅទីនេះដើម្បីជួយអ្នក។">
                        Notre équipe est là pour vous aider à récupérer l'accès à votre compte.
                    </div>
                </div>
                <div class="sidebar-badge"><i class="fas fa-bolt text-yellow-300 text-[9px]"></i> <span data-fr="Réponse rapide" data-en="Quick response" data-km="ការឆ្លើយតបរហ័ស">Réponse rapide</span></div>
                <div class="sidebar-badge"><i class="fas fa-shield-alt text-green-300 text-[9px]"></i> <span data-fr="100% sécurisé" data-en="100% secure" data-km="100% សុវត្ថិភាព">100% sécurisé</span></div>
            </div>

            {{-- Right content --}}
            <div style="flex:1;min-width:0;padding:28px 28px 24px">
                {{-- Dialog header --}}
                <div class="flex items-start justify-between mb-5">
                    <div>
                        <h3 class="text-xl font-black text-gray-900 mb-1"
                            data-fr="Récupérer votre accès" data-en="Recover your access" data-km="ទទួលការចូលប្រើប្រាស់របស់អ្នកឡើងវិញ">Récupérer votre accès</h3>
                        <p class="text-xs text-gray-400"
                           data-fr="Choisissez le canal qui vous convient le mieux" data-en="Choose the channel that suits you best" data-km="ជ្រើសរើសช่องทางដែលលំហានសម្រួលអ្នកបំផុត">
                            Choisissez le canal qui vous convient le mieux
                        </p>
                    </div>
                    <button onclick="closeForgotModal()"
                            class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 text-sm transition flex-shrink-0 ml-4">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Contacts --}}
                <div style="display:flex;flex-direction:column;gap:9px;">
                    @include('sponsor._forgot_contacts')
                </div>

                <button onclick="closeForgotModal()"
                        class="mt-5 w-full py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-sm rounded-xl transition"
                        data-fr="Annuler" data-en="Cancel" data-km="បោះបង់">Annuler</button>
            </div>
        </div>
    </div>

</div>

{{-- Language + modal scripts --}}
<script>
// ── Forgot modal ─────────────────────────────────────────
function openForgotModal() {
    document.getElementById('forgot-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeForgotModal() {
    document.getElementById('forgot-overlay').classList.remove('open');
    document.body.style.overflow = '';
}
function handleForgotOverlay(e) {
    if (e.target === document.getElementById('forgot-overlay')) closeForgotModal();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeForgotModal(); });

// Swipe down to close (mobile sheet)
(function(){
    let ty = 0;
    const sheet = document.getElementById('forgot-mobile-sheet');
    if (!sheet) return;
    sheet.addEventListener('touchstart', e => { ty = e.touches[0].clientY; }, { passive: true });
    sheet.addEventListener('touchmove', e => { if (e.touches[0].clientY - ty > 80) closeForgotModal(); }, { passive: true });
})();

// ── Language controller ───────────────────────────────────
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
    const flagEl = document.getElementById('login-flag'), labelEl = document.getElementById('login-lang-label');
    if (flagEl)  { flagEl.src = cfg.flag; flagEl.alt = lang.toUpperCase(); }
    if (labelEl) labelEl.textContent = cfg.label;
    ['fr','en','km'].forEach(l => {
        document.getElementById('login-btn-' + l)?.classList.toggle('active', l === lang);
        const chk = document.getElementById('login-check-' + l);
        if (chk) chk.classList.toggle('hidden', l !== lang);
    });
    document.querySelectorAll('[data-' + lang + ']').forEach(el => {
        const val = el.getAttribute('data-' + lang);
        if (!val) return;
        if (el.tagName === 'INPUT') el.placeholder = val; else el.textContent = val;
    });
    document.querySelectorAll('[data-placeholder-' + lang + ']').forEach(el => {
        el.placeholder = el.getAttribute('data-placeholder-' + lang);
    });
    document.body.style.fontFamily = lang === 'km'
        ? "'Hanuman','Battambang','Content','Montserrat',sans-serif"
        : "'Montserrat',sans-serif";
    loginCurrentLang = lang;
    localStorage.setItem('gt_lang', lang);
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

document.addEventListener('DOMContentLoaded', () => {
    const cookie = document.cookie.split(';').find(c => c.trim().startsWith('googtrans='));
    const stored = localStorage.getItem('gt_lang');
    if (cookie) {
        const parts = cookie.split('/');
        const cl = parts[parts.length - 1].trim();
        if (cl && LOGIN_LANGS[cl]) { loginCurrentLang = cl; localStorage.setItem('gt_lang', cl); }
    } else if (!stored) {
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