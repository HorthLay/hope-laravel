{{-- resources/views/layouts/page.blade.php --}}
{{-- Shared layout for all static pages — matches home.blade.php design system --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Hope & Impact') | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
    <meta name="description" content="@yield('meta_description', $settings['meta_description'] ?? '')">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
    <style>
        /* ── Base animations ─────────────────────────────────────────── */
        @keyframes fadeUp     { from { opacity:0; transform:translateY(32px); } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeDown   { from { opacity:0; transform:translateY(-20px);} to { opacity:1; transform:translateY(0); } }
        @keyframes pulse-soft { 0%,100%{transform:scale(1);} 50%{transform:scale(1.04);} }
        @keyframes float      { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-8px);} }
        @keyframes shimmer    { 0%{background-position:-200% center} 100%{background-position:200% center} }

        /* ── Scroll-triggered reveal ─────────────────────────────────── */
        .reveal       { opacity:0; transform:translateY(28px);  transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1); }
        .reveal-left  { opacity:0; transform:translateX(-36px); transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1); }
        .reveal-right { opacity:0; transform:translateX(36px);  transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1); }
        .reveal-scale { opacity:0; transform:scale(.93);        transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1); }
        .reveal.visible,.reveal-left.visible,.reveal-right.visible,.reveal-scale.visible { opacity:1; transform:none; }

        /* ── Stagger delays ──────────────────────────────────────────── */
        .stagger-1{transition-delay:.05s}.stagger-2{transition-delay:.12s}.stagger-3{transition-delay:.19s}
        .stagger-4{transition-delay:.26s}.stagger-5{transition-delay:.33s}.stagger-6{transition-delay:.40s}

        /* ── Page hero ──────────────────────────────────────────────── */
        .page-hero {
            position: relative;
            overflow: hidden;
            background: #1a1a1a;
        }
        .page-hero-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            filter: brightness(.45) saturate(1.1);
            transition: transform 8s ease;
        }
        .page-hero:hover .page-hero-bg { transform: scale(1.04); }
        .page-hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(0,0,0,.65) 0%, rgba(0,0,0,.2) 60%, transparent 100%);
        }
        .page-hero-content {
            position: relative; z-index: 2;
            padding: 80px 40px 72px;
            max-width: 1280px; margin: 0 auto;
        }

        /* ── Breadcrumb ──────────────────────────────────────────────── */
        .breadcrumb { display:flex; align-items:center; gap:8px; flex-wrap:wrap;
            font-size:11px; font-weight:700; letter-spacing:.08em;
            text-transform:uppercase; color:rgba(255,255,255,.6); margin-bottom:18px; }
        .breadcrumb a:hover { color:#fff; }
        .breadcrumb span { color:rgba(255,255,255,.9); }

        /* ── Section-card ────────────────────────────────────────────── */
        .section-card {
            background:#fff; border-radius:20px;
            border:1px solid #f1f5f9;
            transition:transform .28s cubic-bezier(.16,1,.3,1), box-shadow .28s;
            overflow:hidden;
        }
        .section-card:hover { transform:translateY(-5px); box-shadow:0 20px 48px rgba(0,0,0,.10); }

        /* ── Icon badge ──────────────────────────────────────────────── */
        .icon-badge {
            display:inline-flex; align-items:center; justify-content:center;
            border-radius:16px; flex-shrink:0;
        }

        /* ── Pill label ──────────────────────────────────────────────── */
        .pill { display:inline-flex; align-items:center; gap:6px;
            padding:5px 14px; border-radius:999px;
            font-size:11px; font-weight:800; letter-spacing:.06em; text-transform:uppercase; }

        /* ── Section dividers ────────────────────────────────────────── */
        .wave-divider { line-height:0; overflow:hidden; }
        .wave-divider svg { display:block; }

        /* ── Orange gradient text ────────────────────────────────────── */
        .text-gradient {
            background: linear-gradient(135deg, #f97316 0%, #f59e0b 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Stat card ──────────────────────────────────────────────── */
        .stat-card {
            background: linear-gradient(135deg, #fff 0%, #fff7ed 100%);
            border: 1px solid #fed7aa;
            border-radius: 20px; padding: 24px; text-align: center;
        }
        .stat-number-sm {
            font-size: 2.2rem; font-weight: 900; line-height:1;
            background: linear-gradient(135deg,#ea580c,#f59e0b);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            background-clip:text;
        }

        /* ── FAQ accordion ──────────────────────────────────────────── */
        .faq-item { overflow:hidden; }
        .faq-body { max-height:0; transition:max-height .35s ease, padding .2s; }
        .faq-item.open .faq-body { max-height:500px; }
        .faq-item.open .faq-chevron { transform:rotate(180deg); }
        .faq-chevron { transition:transform .3s ease; }

        /* ── Step connector ─────────────────────────────────────────── */
        .step-connector { position:absolute; top:28px; left:calc(50% + 24px); right:calc(-50% + 24px);
            height:2px; background:linear-gradient(to right,#fed7aa,#fdba74); z-index:0; }

        /* ── Mobile ─────────────────────────────────────────────────── */
        @media (max-width:640px) {
            .page-hero-content { padding:60px 20px 56px; }
            .step-connector { display:none; }
        }
    </style>
    @stack('styles')
</head>
<body>
@if(!empty($settings['maintenance_mode']) && $settings['maintenance_mode'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; position: relative;
        }
        .bg-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(80px); }
        .bg-orb-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(249,115,22,.18) 0%, transparent 70%);
            top: -150px; right: -100px;
            animation: orbFloat 8s ease-in-out infinite;
        }
        .bg-orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(251,191,36,.1) 0%, transparent 70%);
            bottom: -120px; left: -80px;
            animation: orbFloat 10s ease-in-out infinite reverse;
        }
        .bg-orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(59,130,246,.1) 0%, transparent 70%);
            top: 40%; left: 50%;
            animation: orbFloat3 12s ease-in-out infinite 2s;
        }
        @keyframes orbFloat      { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-30px) scale(1.05)} }
        @keyframes orbFloat3     { 0%,100%{transform:translate(-50%,-50%) scale(1)} 50%{transform:translate(-50%,-55%) scale(1.05)} }
        .bg-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
            background-size: 48px 48px; pointer-events: none;
        }
        .maint-card {
            position: relative; z-index: 10;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.1);
            backdrop-filter: blur(24px);
            border-radius: 32px; padding: 52px 44px 48px;
            max-width: 520px; width: calc(100% - 32px);
            text-align: center;
            box-shadow: 0 32px 96px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.1);
            animation: cardIn .7s cubic-bezier(.34,1.1,.64,1) both;
        }
        @keyframes cardIn { from{opacity:0;transform:translateY(32px) scale(.96)} to{opacity:1;transform:none} }
        .gear-wrap {
            width: 88px; height: 88px; border-radius: 24px; margin: 0 auto 28px;
            background: linear-gradient(135deg, rgba(249,115,22,.25), rgba(234,88,12,.15));
            border: 1px solid rgba(249,115,22,.3);
            display: flex; align-items: center; justify-content: center; position: relative;
        }
        .gear-wrap::before {
            content: ''; position: absolute; inset: -6px; border-radius: 28px;
            border: 1px dashed rgba(249,115,22,.25);
            animation: gearSpin 12s linear infinite;
        }
        @keyframes gearSpin { to{transform:rotate(360deg)} }
        .gear-icon { font-size: 36px; color: #f97316; animation: gearSpin 6s linear infinite; }
        .maint-label {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(249,115,22,.15); border: 1px solid rgba(249,115,22,.3);
            color: #fb923c; font-size: 11px; font-weight: 800; letter-spacing: .1em;
            text-transform: uppercase; padding: 5px 14px; border-radius: 99px; margin-bottom: 20px;
            animation: pulseLbl 2s ease-in-out infinite;
        }
        @keyframes pulseLbl { 0%,100%{opacity:1} 50%{opacity:.65} }
        .maint-label .dot { width: 7px; height: 7px; border-radius: 50%; background: #f97316; animation: pulseLbl 1.4s ease-in-out infinite; }
        h1 { font-family: 'Instrument Serif', serif; font-size: clamp(26px,6vw,38px); color: #fff; line-height: 1.2; margin-bottom: 14px; }
        h1 em { color: #fb923c; font-style: italic; }
        .maint-desc { font-size: 15px; color: rgba(255,255,255,.5); line-height: 1.7; margin-bottom: 32px; font-weight: 500; }
        .maint-features { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-bottom: 32px; }
        .maint-feat {
            display: flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px; padding: 8px 14px;
            font-size: 12px; font-weight: 700; color: rgba(255,255,255,.7);
        }
        .maint-feat i { font-size: 11px; color: #f97316; }
        .maint-divider { height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,.1), transparent); margin-bottom: 28px; }
        .maint-contact { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .maint-contact a {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 18px; border-radius: 12px; text-decoration: none;
            font-size: 13px; font-weight: 700; transition: all .2s; border: 1px solid;
        }
        .maint-contact a.primary {
            background: linear-gradient(135deg,#f97316,#ea580c); border-color: transparent; color: #fff;
            box-shadow: 0 4px 20px rgba(249,115,22,.35);
        }
        .maint-contact a.primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(249,115,22,.45); }
        .maint-contact a.secondary { background: rgba(255,255,255,.05); border-color: rgba(255,255,255,.12); color: rgba(255,255,255,.7); }
        .maint-contact a.secondary:hover { background: rgba(255,255,255,.1); color: #fff; }
        .maint-logo { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 32px; }
        .maint-logo img { height: 52px; width: auto; filter: brightness(1.1); }
        .maint-logo-name { font-size: 15px; font-weight: 900; color: #fff; text-align: left; }
        .maint-logo-tag  { font-size: 11px; color: rgba(255,255,255,.4); font-weight: 600; text-align: left; }
        .maint-footer { margin-top: 36px; font-size: 11px; color: rgba(255,255,255,.25); font-weight: 600; }
        @media (max-width: 480px) {
            .maint-card { padding: 36px 24px 32px; border-radius: 24px; }
            .gear-wrap { width: 72px; height: 72px; border-radius: 20px; }
            .gear-icon { font-size: 28px; }
            .maint-feat { font-size: 11px; padding: 7px 11px; }
            .maint-contact a { padding: 9px 14px; font-size: 12px; }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
    <div class="maint-card">
        @if(!empty($settings['logo']))
        <div class="maint-logo">
            <img src="{{ asset($settings['logo']) }}" alt="{{ $settings['site_name'] ?? '' }}">
            <div>
                <div class="maint-logo-name">{{ $settings['site_name'] ?? 'Hope & Impact' }}</div>
                <div class="maint-logo-tag">{{ $settings['site_tagline'] ?? '' }}</div>
            </div>
        </div>
        @else
        <div style="font-size:15px;font-weight:900;color:#fff;margin-bottom:28px;opacity:.7">{{ $settings['site_name'] ?? 'Hope & Impact' }}</div>
        @endif
        <div class="maint-label"><span class="dot"></span> Under Maintenance</div>
        <div class="gear-wrap"><i class="fas fa-cog gear-icon"></i></div>
        <h1>We'll be <em>back soon!</em></h1>
        <p class="maint-desc">Our website is currently undergoing scheduled maintenance and improvements. We apologize for the inconvenience and appreciate your patience.</p>
        <div class="maint-features">
            <div class="maint-feat"><i class="fas fa-wrench"></i> Updates in progress</div>
            <div class="maint-feat"><i class="fas fa-shield-alt"></i> Securing systems</div>
            <div class="maint-feat"><i class="fas fa-rocket"></i> Performance boost</div>
        </div>
        <div class="maint-divider"></div>
        <p style="font-size:13px;color:rgba(255,255,255,.45);margin-bottom:16px;font-weight:600">Need urgent assistance?</p>
        <div class="maint-contact">
            @php
                $mEmail    = $settings['contact_email'] ?? null;
                $mWhatsapp = $settings['whatsapp_url']  ?? null;
                $mFacebook = $settings['facebook_url']  ?? null;
            @endphp
            @if($mEmail)
            <a href="https://mail.google.com/mail/?view=cm&to={{ $mEmail }}" target="_blank" class="primary">
                <i class="fas fa-envelope"></i> Email Us
            </a>
            @endif
            @if($mWhatsapp)
            <a href="https://wa.me/{{ $mWhatsapp }}" target="_blank" class="secondary">
                <i class="fab fa-whatsapp" style="color:#22c55e"></i> WhatsApp
            </a>
            @endif
            @if($mFacebook)
            <a href="{{ $mFacebook }}" target="_blank" class="secondary">
                <i class="fab fa-facebook" style="color:#60a5fa"></i> Facebook
            </a>
            @endif
            @if(!$mEmail && !$mWhatsapp && !$mFacebook)
            <span style="font-size:12px;color:rgba(255,255,255,.35)">Contact information coming soon.</span>
            @endif
        </div>
        <p class="maint-footer">&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Hope & Impact' }} &middot; All rights reserved</p>
    </div>
</body>
</html>
<?php exit; ?>
@endif
@include('layouts.loading')
@include('layouts.header')

{{-- ════ PAGE HERO ════ --}}
@yield('hero')

{{-- ════ MAIN CONTENT ════ --}}
@yield('content')

@include('layouts.footer')
@include('layouts.navigation')
@include('layouts.ads')

<script>
// ── Loader ──────────────────────────────────────────────────────────────
window.addEventListener('load',()=>{
    setTimeout(()=>{ document.getElementById('loader')?.classList.add('hidden'); },800);
});

// ── Mobile nav ───────────────────────────────────────────────────────────
const mobileMenu=document.getElementById('mobile-menu'),mobileMenuOverlay=document.getElementById('mobile-menu-overlay');
const openMenu=()=>{mobileMenu?.classList.add('active');mobileMenuOverlay?.classList.add('active');document.body.style.overflow='hidden';};
const closeMenu=()=>{mobileMenu?.classList.remove('active');mobileMenuOverlay?.classList.remove('active');document.body.style.overflow='';};
document.getElementById('mobile-menu-btn')?.addEventListener('click',openMenu);
document.getElementById('menu-nav-item')?.addEventListener('click',(e)=>{e.preventDefault();openMenu();});
document.getElementById('close-menu')?.addEventListener('click',closeMenu);
mobileMenuOverlay?.addEventListener('click',closeMenu);
document.querySelectorAll('.mobile-menu-link').forEach(l=>l.addEventListener('click',closeMenu));

// ── Scroll-reveal (IntersectionObserver) ────────────────────────────────
const revealObs=new IntersectionObserver((entries)=>{
    entries.forEach(e=>{ if(e.isIntersecting){e.target.classList.add('visible');revealObs.unobserve(e.target);} });
},{threshold:0.08,rootMargin:'0px 0px -50px 0px'});
document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale').forEach(el=>revealObs.observe(el));

// ── FAQ accordion ────────────────────────────────────────────────────────
document.querySelectorAll('.faq-toggle').forEach(btn=>{
    btn.addEventListener('click',()=>{
        const item=btn.closest('.faq-item');
        const wasOpen=item.classList.contains('open');
        document.querySelectorAll('.faq-item.open').forEach(i=>i.classList.remove('open'));
        if(!wasOpen) item.classList.add('open');
    });
});

// ── Counter animation ─────────────────────────────────────────────────────
document.querySelectorAll('.counter-sm').forEach(el=>{
    const obs=new IntersectionObserver((entries)=>{
        entries.forEach(entry=>{
            if(!entry.isIntersecting)return;
            const target=+el.getAttribute('data-target'),step=Math.max(1,Math.ceil(target/120));
            let cur=0;
            const tick=()=>{cur=Math.min(cur+step,target);el.innerText=cur.toLocaleString();if(cur<target)setTimeout(tick,8);};
            tick();obs.unobserve(el);
        });
    },{threshold:.5});
    obs.observe(el);
});
</script>
@stack('scripts')
</body>
</html>
