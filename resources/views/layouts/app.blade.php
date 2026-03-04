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
