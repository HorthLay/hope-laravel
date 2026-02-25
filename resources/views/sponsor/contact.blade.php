<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($settings['site_name'] ?? 'Hope & Impact') }} | Contact Us</title>
    <meta name="description" content="{{ $settings['meta_description'] ?? $settings['site_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '' }}">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; margin: 0; background: #f9fafb; }
        body.km { font-family: 'Hanuman', sans-serif; }

        /* ── Header ───────────────────────────────── */
        .site-header {
            background: #fff; border-bottom: 1px solid #e5e7eb;
            position: sticky; top: 0; z-index: 50;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
        }
        .header-inner {
            max-width: 1100px; margin: 0 auto;
            padding: 10px 16px;
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
        }
        .logo-mark { display: flex; align-items: center; gap: 10px; text-decoration: none; flex-shrink: 0; }
        .logo-img  { height: 44px; width: auto; object-fit: contain; }

        .lang-row { display: flex; gap: 5px; }
        .lang-btn {
            padding: 5px 10px; border-radius: 8px;
            border: 2px solid #e5e7eb; font-size: 11px; font-weight: 700;
            cursor: pointer; transition: all .2s; background: white;
            display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;
        }
        .lang-btn:hover  { border-color: #f97316; background: #fff7ed; }
        .lang-btn.active { border-color: #f97316; background: linear-gradient(135deg,#fff7ed,#ffedd5); color: #c2410c; }
        .lang-btn img    { width: 16px; height: 11px; border-radius: 2px; }

        @media (max-width: 480px) {
            .lang-row     { display: none; }
            .lang-compact { display: flex !important; }
        }
        .lang-compact { display: none; gap: 5px; }
        .lang-compact button {
            width: 30px; height: 30px; border-radius: 50%;
            border: 2px solid #e5e7eb; background: white;
            cursor: pointer; padding: 0; overflow: hidden; transition: border-color .2s;
        }
        .lang-compact button img    { width: 100%; height: 100%; object-fit: cover; display: block; }
        .lang-compact button.active { border-color: #f97316; }

        .login-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 14px; background: #f97316; color: #fff;
            font-size: 11px; font-weight: 800; border-radius: 10px;
            text-decoration: none; transition: background .2s; white-space: nowrap; flex-shrink: 0;
        }
        .login-btn:hover { background: #ea580c; color: #fff; }

        /* ── Hero ─────────────────────────────────── */
        .hero { text-align: center; padding: 28px 20px 20px; max-width: 580px; margin: 0 auto; }
        .hero-icon {
            width: 52px; height: 52px; background: #fff7ed; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px; box-shadow: 0 4px 16px rgba(249,115,22,.2);
        }
        .hero h1 { font-size: clamp(20px, 5vw, 32px); font-weight: 900; color: #1f2937; margin: 0 0 10px; }
        .hero p  { font-size: clamp(13px, 3vw, 15px); color: #6b7280; margin: 0; line-height: 1.65; }

        /* ── Page wrapper ─────────────────────────── */
        .page-wrapper { max-width: 1100px; margin: 0 auto; padding: 0 16px 40px; }

        /* ── Desktop: 2-col grid ──────────────────── */
        .content-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .desktop-contact-col { display: flex; flex-direction: column; gap: 20px; }
        @media (max-width: 767px) {
            .content-grid { grid-template-columns: 1fr; }
            .desktop-contact-col { display: none !important; }
        }

        /* ── Cards ────────────────────────────────── */
        .card { background: #fff; border-radius: 18px; box-shadow: 0 4px 20px rgba(0,0,0,.07); padding: 22px; }
        .card-title { font-size: 17px; font-weight: 900; color: #1f2937; margin: 0 0 6px; }
        .card-sub   { font-size: 12px; color: #6b7280; margin: 0 0 20px; line-height: 1.6; }

        /* ── How-to steps ─────────────────────────── */
        .step { display: flex; align-items: flex-start; gap: 12px; }
        .step + .step { margin-top: 16px; }
        .step-icon {
            width: 34px; height: 34px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 1px; font-size: 13px;
        }
        .step h3 { font-size: 13px; font-weight: 800; color: #1f2937; margin: 0 0 3px; }
        .step p  { font-size: 11px; color: #6b7280; margin: 0; line-height: 1.5; }

        /* ── Contact buttons (shared desktop + modal) */
        .contact-list { display: flex; flex-direction: column; gap: 9px; }
        .section-label {
            font-size: 11px; font-weight: 800; text-transform: uppercase;
            letter-spacing: .07em; color: #9ca3af; margin: 0 0 12px;
        }
        .contact-btn {
            display: flex; align-items: center; gap: 13px;
            padding: 13px 14px; border-radius: 14px; text-decoration: none;
            background: #f9fafb; border: 1.5px solid #f3f4f6;
            transition: all .18s; min-height: 62px;
        }
        .contact-btn:hover, .contact-btn:active {
            transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.10);
        }
        .btn-icon {
            width: 42px; height: 42px; border-radius: 11px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 20px;
        }
        .btn-body   { flex: 1; min-width: 0; }
        .btn-title  { font-size: 13px; font-weight: 800; color: #1f2937; }
        .btn-sub    { font-size: 11px; color: #9ca3af; margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .btn-arrow  { color: #d1d5db; font-size: 11px; flex-shrink: 0; }

        .contact-btn.email:hover     { background: #fff7ed; border-color: #fed7aa; }
        .contact-btn.whatsapp:hover  { background: #f0fdf4; border-color: #bbf7d0; }
        .contact-btn.telegram:hover  { background: #f0f9ff; border-color: #bae6fd; }
        .contact-btn.facebook:hover  { background: #eff6ff; border-color: #bfdbfe; }
        .contact-btn.instagram:hover { background: #fdf2f8; border-color: #f5d0fe; }
        .contact-btn.youtube:hover   { background: #fef2f2; border-color: #fecaca; }
        .contact-btn.linkedin:hover  { background: #eff6ff; border-color: #bfdbfe; }

        /* ── Why card ─────────────────────────────── */
        .why-card {
            background: linear-gradient(135deg,#f97316,#ea580c);
            border-radius: 18px; padding: 22px; color: #fff;
            box-shadow: 0 8px 28px rgba(249,115,22,.32);
        }
        .why-card h3 { font-size: 17px; font-weight: 900; margin: 0 0 14px; }
        .why-item { display: flex; align-items: flex-start; gap: 9px; font-size: 13px; }
        .why-item + .why-item { margin-top: 9px; }
        .why-item i { margin-top: 2px; flex-shrink: 0; }

        /* ── Mobile "Contact Us" big trigger button ── */
        .mobile-contact-trigger {
            display: none;
            align-items: center; justify-content: center; gap: 10px;
            width: 100%; padding: 18px;
            background: linear-gradient(135deg,#f97316,#ea580c);
            color: #fff; border: none; border-radius: 16px;
            font-family: inherit; font-size: 15px; font-weight: 900;
            cursor: pointer; box-shadow: 0 8px 24px rgba(249,115,22,.40);
            transition: transform .15s, box-shadow .15s;
            text-align: center;
        }
        .mobile-contact-trigger:active { transform: scale(.97); box-shadow: 0 4px 12px rgba(249,115,22,.30); }
        .mobile-contact-trigger i { font-size: 18px; }
        @media (max-width: 767px) { .mobile-contact-trigger { display: flex; } }

        /* ── Bottom sheet modal ───────────────────── */
        .modal-overlay {
            display: none; position: fixed; inset: 0; z-index: 500;
            background: rgba(0,0,0,.45); backdrop-filter: blur(4px);
            align-items: flex-end; justify-content: center;
        }
        .modal-overlay.open { display: flex; }

        .modal-sheet {
            background: #fff; width: 100%; max-width: 520px;
            border-radius: 24px 24px 0 0;
            max-height: 90dvh; overflow-y: auto;
            transform: translateY(110%);
            transition: transform .35s cubic-bezier(.4,0,.2,1);
            padding-bottom: env(safe-area-inset-bottom, 16px);
        }
        .modal-overlay.open .modal-sheet { transform: translateY(0); }

        .modal-handle {
            width: 40px; height: 4px; background: #e5e7eb;
            border-radius: 2px; margin: 14px auto 0;
        }
        .modal-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 20px 12px;
            border-bottom: 1px solid #f3f4f6;
            position: sticky; top: 0; background: #fff; z-index: 1;
        }
        .modal-title { font-size: 16px; font-weight: 900; color: #1f2937; }
        .modal-close {
            width: 32px; height: 32px; border-radius: 50%;
            border: none; background: #f3f4f6; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: #6b7280; font-size: 13px; transition: background .2s;
        }
        .modal-close:hover { background: #e5e7eb; }
        .modal-body { padding: 18px 20px 28px; }

        /* ── Bottom nav padding ───────────────────── */
        @media (max-width: 1023px) { body { padding-bottom: 72px; } }
    </style>
</head>
<body>

@php
    $emailUrl     = !empty($settings['contact_email'])  ? 'https://mail.google.com/mail/?view=cm&to=' . $settings['contact_email'] : null;
    $whatsappUrl  = !empty($settings['whatsapp_url'])   ? 'https://wa.me/' . $settings['whatsapp_url']  : null;
    $telegramUrl  = !empty($settings['telegram_url'])   ? 'https://t.me/' . $settings['telegram_url']   : null;
    $facebookUrl  = $settings['facebook_url']  ?? null ?: null;
    $instagramUrl = $settings['instagram_url'] ?? null ?: null;
    $youtubeUrl   = $settings['youtube_url']   ?? null ?: null;
    $linkedinUrl  = $settings['linkedin_url']  ?? null ?: null;
    $logoPath     = !empty($settings['logo']) ? asset($settings['logo']) : asset('images/logo.png');
    $siteName     = $settings['site_name'] ?? 'Association Des Ailes Pour Grandir';
@endphp

{{-- ── Header ─────────────────────────────────────── --}}
<header class="site-header">
    <div class="header-inner">
        <a href="{{ route('home') }}" class="logo-mark">
            <img src="{{ $logoPath }}" alt="{{ $siteName }}" class="logo-img">
        </a>
        <div style="display:flex;align-items:center;gap:8px;flex:1;justify-content:flex-end;">
            <div class="lang-row">
                <button class="lang-btn active" data-lang="fr" onclick="switchLang('fr')"><img src="https://flagcdn.com/w40/fr.png" alt="">FR</button>
                <button class="lang-btn"        data-lang="en" onclick="switchLang('en')"><img src="https://flagcdn.com/w40/us.png" alt="">EN</button>
                <button class="lang-btn"        data-lang="km" onclick="switchLang('km')"><img src="https://flagcdn.com/w40/kh.png" alt="">ខ្មែរ</button>
            </div>
            <div class="lang-compact">
                <button data-lang="fr" onclick="switchLang('fr')" class="active"><img src="https://flagcdn.com/w40/fr.png" alt="FR"></button>
                <button data-lang="en" onclick="switchLang('en')"><img src="https://flagcdn.com/w40/us.png" alt="EN"></button>
                <button data-lang="km" onclick="switchLang('km')"><img src="https://flagcdn.com/w40/kh.png" alt="KM"></button>
            </div>
            <a href="{{ route('sponsor.login') }}" class="login-btn">
                <i class="fas fa-sign-in-alt"></i>
                <span data-fr="Connexion" data-en="Login" data-km="ចូល">Connexion</span>
            </a>
        </div>
    </div>
</header>

{{-- ── Hero ─────────────────────────────────────────── --}}
<div class="hero">
    <div class="hero-icon">
        <i class="fas fa-user-plus" style="color:#f97316;font-size:22px;"></i>
    </div>
    <h1 data-fr="Créer un Compte Parrain" data-en="Create a Sponsor Account" data-km="បង្កើតគណនីអ្នកឧបត្ថម្ភ">Créer un Compte Parrain</h1>
    <p  data-fr="Contactez-nous directement pour créer votre compte parrain et commencer à changer la vie d'un enfant."
        data-en="Contact us directly to create your sponsor account and start changing a child's life."
        data-km="ទាក់ទងយើងដោយផ្ទាល់ដើម្បីបង្កើតគណនីអ្នកឧបត្ថម្ភ ហើយចប់ផ្តើមការផ្លាស់ប្តូរជីវិតកុមារ។">Contactez-nous directement pour créer votre compte parrain et commencer à changer la vie d'un enfant.</p>
</div>

{{-- ── Mobile: big "Contact Us" button ─────────────── --}}
<div class="page-wrapper" style="padding-bottom:0;">
    <button class="mobile-contact-trigger" onclick="openModal()">
        <i class="fas fa-paper-plane"></i>
        <span data-fr="Nous Contacter" data-en="Contact Us" data-km="ទាក់ទងយើង">Nous Contacter</span>
        <i class="fas fa-chevron-up" style="font-size:12px;margin-left:auto;opacity:.7;"></i>
    </button>
</div>

{{-- ── Content grid ─────────────────────────────────── --}}
<div class="page-wrapper" style="padding-top:20px;">
    <div class="content-grid">

        {{-- Left: How to ──────────────────────────────── --}}
        <div style="display:flex;flex-direction:column;gap:20px;">
            <div class="card">
                <h2 class="card-title"
                    data-fr="Comment créer un compte ?"
                    data-en="How to create an account?"
                    data-km="តើអ្នកអាចបង្កើតគណនីដូចម្តេច ?">Comment créer un compte ?</h2>
                <p class="card-sub"
                   data-fr="Contactez-nous via l'une des méthodes ci-dessous. Notre équipe vous guidera."
                   data-en="Contact us via one of the methods below. Our team will guide you."
                   data-km="ទាក់ទងយើងតាមវិធីណាមួយ ក្រុមយើងនឹងណែនាំអ្នក។">Contactez-nous via l'une des méthodes ci-dessous. Notre équipe vous guidera.</p>

                @if($emailUrl)
                <div class="step">
                    <div class="step-icon" style="background:#fff7ed;"><i class="fas fa-envelope" style="color:#f97316;"></i></div>
                    <div>
                        <h3 data-fr="Envoyez-nous un e-mail" data-en="Send us an email" data-km="ផ្ញើអ៊ីមែល">Envoyez-nous un e-mail</h3>
                        <p data-fr="Nom, e-mail et numéro de téléphone." data-en="Name, email and phone number." data-km="ឈ្មោះ, អ៊ីមែល, លេខទូរស័ព្ទ។">Nom, e-mail et numéro de téléphone.</p>
                    </div>
                </div>
                @endif

                @if($whatsappUrl)
                <div class="step">
                    <div class="step-icon" style="background:#f0fdf4;"><i class="fab fa-whatsapp" style="color:#22c55e;"></i></div>
                    <div>
                        <h3 data-fr="Contactez-nous sur WhatsApp" data-en="Contact us on WhatsApp" data-km="ទាក់ទងតាម WhatsApp">Contactez-nous sur WhatsApp</h3>
                        <p data-fr="Assistance immédiate via WhatsApp." data-en="Immediate assistance via WhatsApp." data-km="ជំនួយភ្លាមៗតាម WhatsApp។">Assistance immédiate via WhatsApp.</p>
                    </div>
                </div>
                @endif

                @if($telegramUrl)
                <div class="step">
                    <div class="step-icon" style="background:#f0f9ff;"><i class="fab fa-telegram" style="color:#0ea5e9;"></i></div>
                    <div>
                        <h3 data-fr="Message sur Telegram" data-en="Message on Telegram" data-km="សារតាម Telegram">Message sur Telegram</h3>
                        <p data-fr="Créez votre compte via Telegram." data-en="Create your account via Telegram." data-km="បង្កើតគណនីតាម Telegram។">Créez votre compte via Telegram.</p>
                    </div>
                </div>
                @endif

                @if($facebookUrl)
                <div class="step">
                    <div class="step-icon" style="background:#eff6ff;"><i class="fab fa-facebook" style="color:#2563eb;"></i></div>
                    <div>
                        <h3 data-fr="Contactez-nous sur Facebook" data-en="Contact us on Facebook" data-km="ទាក់ទងតាម Facebook">Contactez-nous sur Facebook</h3>
                        <p data-fr="Via notre page Facebook officielle." data-en="Via our official Facebook page." data-km="តាមទំព័រ Facebook ផ្លូវការ។">Via notre page Facebook officielle.</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Why sponsor — desktop left col --}}
            <div class="why-card" style="display:none;" id="why-desktop">
                <h3 data-fr="Pourquoi Devenir Parrain ?" data-en="Why Become a Sponsor?" data-km="ហេតុអ្វីត្រូវក្លាយជាអ្នកឧបត្ថម្ភ?">Pourquoi Devenir Parrain ?</h3>
                <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="Changez directement la vie d'un enfant" data-en="Directly change a child's life" data-km="ផ្លាស់ប្តូរជីវិតកុមារដោយផ្ទាល់">Changez directement la vie d'un enfant</span></div>
                <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="Recevez des nouvelles régulières" data-en="Receive regular updates" data-km="ទទួលព័ត៌មានទៀងទាត់">Recevez des nouvelles régulières</span></div>
                <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="84% des fonds vont aux programmes" data-en="84% of funds go to programs" data-km="៨៤% នៃមូលនិធិទៅកម្មវិធី">84% des fonds vont aux programmes</span></div>
                <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="Suivez la scolarité de votre filleul·e" data-en="Track your child's education" data-km="តាមដានការអប់រំរបស់កូនអ្នក">Suivez la scolarité de votre filleul·e</span></div>
            </div>
        </div>

        {{-- Right: contact list + why — desktop only ─── --}}
        <div class="desktop-contact-col">
            <div class="card">
                <p class="section-label" data-fr="Nous Contacter Directement" data-en="Contact Us Directly" data-km="ទាក់ទងយើងដោយផ្ទាល់">Nous Contacter Directement</p>
                <div class="contact-list">
                    @include('sponsor.partials.contact-links')
                </div>
            </div>
            <div class="why-card">
                <h3 data-fr="Pourquoi Devenir Parrain ?" data-en="Why Become a Sponsor?" data-km="ហេតុអ្វីត្រូវក្លាយជាអ្នកឧបត្ថម្ភ?">Pourquoi Devenir Parrain ?</h3>
                <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="Changez directement la vie d'un enfant" data-en="Directly change a child's life" data-km="ផ្លាស់ប្តូរជីវិតកុមារដោយផ្ទាល់">Changez directement la vie d'un enfant</span></div>
                <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="Recevez des nouvelles régulières" data-en="Receive regular updates" data-km="ទទួលព័ត៌មានទៀងទាត់">Recevez des nouvelles régulières</span></div>
                <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="84% des fonds vont aux programmes" data-en="84% of funds go to programs" data-km="៨៤% នៃមូលនិធិទៅកម្មវិធី">84% des fonds vont aux programmes</span></div>
                <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="Suivez la scolarité de votre filleul·e" data-en="Track your child's education" data-km="តាមដានការអប់រំរបស់កូនអ្នក">Suivez la scolarité de votre filleul·e</span></div>
            </div>
        </div>

    </div>{{-- end content-grid --}}

    {{-- Mobile: Why sponsor below the how-to card --}}
    <div class="why-card" id="why-mobile" style="margin-top:20px;">
        <h3 data-fr="Pourquoi Devenir Parrain ?" data-en="Why Become a Sponsor?" data-km="ហេតុអ្វីត្រូវក្លាយជាអ្នកឧបត្ថម្ភ?">Pourquoi Devenir Parrain ?</h3>
        <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="Changez directement la vie d'un enfant" data-en="Directly change a child's life" data-km="ផ្លាស់ប្តូរជីវិតកុមារដោយផ្ទាល់">Changez directement la vie d'un enfant</span></div>
        <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="Recevez des nouvelles régulières" data-en="Receive regular updates" data-km="ទទួលព័ត៌មានទៀងទាត់">Recevez des nouvelles régulières</span></div>
        <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="84% des fonds vont aux programmes" data-en="84% of funds go to programs" data-km="៨៤% នៃមូលនិធិទៅកម្មវិធី">84% des fonds vont aux programmes</span></div>
        <div class="why-item"><i class="fas fa-check-circle"></i><span data-fr="Suivez la scolarité de votre filleul·e" data-en="Track your child's education" data-km="តាមដានការអប់រំរបស់កូនអ្នក">Suivez la scolarité de votre filleul·e</span></div>
    </div>
</div>

{{-- ════════════════════════════════
     MOBILE BOTTOM SHEET MODAL
════════════════════════════════ --}}
<div class="modal-overlay" id="contact-modal" onclick="handleOverlayClick(event)">
    <div class="modal-sheet" id="modal-sheet">
        <div class="modal-handle"></div>
        <div class="modal-header">
            <span class="modal-title" data-fr="Nous Contacter" data-en="Contact Us" data-km="ទាក់ទងយើង">Nous Contacter</span>
            <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="contact-list">

                @if($emailUrl)
                <a href="{{ $emailUrl }}" target="_blank" class="contact-btn email">
                    <div class="btn-icon" style="background:#fff7ed;"><i class="fas fa-envelope" style="color:#f97316;"></i></div>
                    <div class="btn-body">
                        <div class="btn-title" data-fr="E-mail" data-en="Email" data-km="អ៊ីមែល">E-mail</div>
                        <div class="btn-sub">{{ $settings['contact_email'] }}</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($whatsappUrl)
                <a href="{{ $whatsappUrl }}" target="_blank" class="contact-btn whatsapp">
                    <div class="btn-icon" style="background:#f0fdf4;"><i class="fab fa-whatsapp" style="color:#22c55e;font-size:21px;"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">WhatsApp</div>
                        <div class="btn-sub" data-fr="Chat instantané" data-en="Instant chat" data-km="ជជែកភ្លាមៗ">Chat instantané</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($telegramUrl)
                <a href="{{ $telegramUrl }}" target="_blank" class="contact-btn telegram">
                    <div class="btn-icon" style="background:#f0f9ff;"><i class="fab fa-telegram" style="color:#0ea5e9;font-size:21px;"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">Telegram</div>
                        <div class="btn-sub">&#64;{{ $settings['telegram_url'] }}</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($facebookUrl)
                <a href="{{ $facebookUrl }}" target="_blank" class="contact-btn facebook">
                    <div class="btn-icon" style="background:#eff6ff;"><i class="fab fa-facebook" style="color:#2563eb;font-size:21px;"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">Facebook</div>
                        <div class="btn-sub" data-fr="Page officielle" data-en="Official page" data-km="ទំព័រផ្លូវការ">Page officielle</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($instagramUrl)
                <a href="{{ $instagramUrl }}" target="_blank" class="contact-btn instagram">
                    <div class="btn-icon" style="background:#fdf2f8;"><i class="fab fa-instagram" style="color:#ec4899;font-size:21px;"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">Instagram</div>
                        <div class="btn-sub">{{ $settings['instagram_url'] }}</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($youtubeUrl)
                <a href="{{ $youtubeUrl }}" target="_blank" class="contact-btn youtube">
                    <div class="btn-icon" style="background:#fef2f2;"><i class="fab fa-youtube" style="color:#dc2626;font-size:21px;"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">YouTube</div>
                        <div class="btn-sub">{{ $settings['youtube_url'] }}</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($linkedinUrl)
                <a href="{{ $linkedinUrl }}" target="_blank" class="contact-btn linkedin">
                    <div class="btn-icon" style="background:#eff6ff;"><i class="fab fa-linkedin" style="color:#1d4ed8;font-size:21px;"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">LinkedIn</div>
                        <div class="btn-sub">{{ $settings['linkedin_url'] }}</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if(!$emailUrl && !$whatsappUrl && !$telegramUrl && !$facebookUrl && !$instagramUrl && !$youtubeUrl && !$linkedinUrl)
                <div style="padding:20px;text-align:center;color:#9ca3af;font-size:12px;background:#f9fafb;border-radius:12px;">
                    <i class="fas fa-info-circle" style="margin-right:6px;"></i>No contact links configured yet.
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

<script>
/* ── Language ─────────────────────────────────────────── */
let currentLang = localStorage.getItem('sponsor_lang') || 'fr';

function switchLang(lang) {
    currentLang = lang;
    localStorage.setItem('sponsor_lang', lang);
    document.querySelectorAll('.lang-btn, .lang-compact button').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.lang === lang);
    });
    document.querySelectorAll('[data-' + lang + ']').forEach(el => {
        const text = el.getAttribute('data-' + lang);
        if (!text) return;
        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = text;
        else el.textContent = text;
    });
    document.body.classList.toggle('km', lang === 'km');
}

/* ── Why card visibility ──────────────────────────────── */
function updateWhyVisibility() {
    const isMobile = window.innerWidth < 768;
    document.getElementById('why-desktop').style.display = isMobile ? 'none' : 'block';
    document.getElementById('why-mobile').style.display  = isMobile ? 'block' : 'none';
}

/* ── Bottom sheet modal ───────────────────────────────── */
function openModal() {
    const overlay = document.getElementById('contact-modal');
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    const overlay = document.getElementById('contact-modal');
    overlay.classList.remove('open');
    document.body.style.overflow = '';
}
function handleOverlayClick(e) {
    if (e.target === document.getElementById('contact-modal')) closeModal();
}
// Close on ESC
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// Touch swipe down to close
let touchStartY = 0;
document.getElementById('modal-sheet').addEventListener('touchstart', e => {
    touchStartY = e.touches[0].clientY;
}, { passive: true });
document.getElementById('modal-sheet').addEventListener('touchmove', e => {
    const delta = e.touches[0].clientY - touchStartY;
    if (delta > 80) closeModal();
}, { passive: true });

/* ── Init ─────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    switchLang(currentLang);
    updateWhyVisibility();
});
window.addEventListener('resize', updateWhyVisibility);
</script>
</body>
</html>