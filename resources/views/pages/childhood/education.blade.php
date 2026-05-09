{{-- resources/views/pages/childhood/education.blade.php --}}
@extends('layouts.app')
@section('title', 'Education')

@section('content')

<style>
:root{
    --or:#f97316; --or-d:#ea580c; --amber:#f59e0b;
    --navy:#06101f; --ink:#0f1c2e; --muted:#64748b;
    --cream:#fefdf9; --sand:#f5f0e8;
}

/* ── Keyframes ── */
@keyframes fadeUp  {from{opacity:0;transform:translateY(36px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn  {from{opacity:0}to{opacity:1}}
@keyframes scaleIn {from{opacity:0;transform:scale(.9)}to{opacity:1;transform:scale(1)}}
@keyframes driftL  {0%,100%{transform:translateX(0) translateY(0)}50%{transform:translateX(-18px) translateY(-12px)}}
@keyframes driftR  {0%,100%{transform:translateX(0) translateY(0)}50%{transform:translateX(18px) translateY(12px)}}
@keyframes lineGrow{from{width:0}to{width:100%}}
@keyframes numberUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
@keyframes spin    {to{transform:rotate(360deg)}}
@keyframes pulse   {0%,100%{opacity:1}50%{opacity:.4}}

/* ── Reveal ── */
.reveal{opacity:0;transform:translateY(30px);transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
.reveal.in{opacity:1;transform:none}
.d1{transition-delay:.08s}.d2{transition-delay:.16s}.d3{transition-delay:.24s}.d4{transition-delay:.32s}

/* ════════════════════════
   HERO - magazine style
════════════════════════ */
.edu-hero{
    position:relative;overflow:hidden;
    background:var(--navy);
    min-height:100vh;display:flex;align-items:center;
}
.hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;filter:brightness(.22) saturate(1.4);}
.hero-grad{
    position:absolute;inset:0;
    background:
        linear-gradient(to right,rgba(6,16,31,.98) 0%,rgba(6,16,31,.7) 55%,rgba(6,16,31,.1) 100%),
        linear-gradient(to top,rgba(6,16,31,.8) 0%,transparent 50%);
}
/* Floating accent shapes */
.hero-shape{position:absolute;pointer-events:none;}
.shape-circle{
    width:520px;height:520px;border-radius:50%;
    border:1.5px solid rgba(249,115,22,.15);
    top:-80px;right:-100px;
    animation:driftR 12s ease-in-out infinite;
}
.shape-circle-sm{
    width:280px;height:280px;border-radius:50%;
    background:radial-gradient(circle,rgba(249,115,22,.08),transparent 70%);
    bottom:10%;right:15%;
    animation:driftL 9s ease-in-out infinite;
}
.shape-dot-grid{
    bottom:60px;right:60px;
    display:grid;grid-template-columns:repeat(6,1fr);gap:10px;
    opacity:.18;
}
.shape-dot-grid span{width:4px;height:4px;border-radius:50%;background:#f97316;display:block;}

.hero-inner{position:relative;z-index:2;padding:120px 20px 100px;max-width:1280px;margin:0 auto;width:100%;display:grid;grid-template-columns:1fr 480px;gap:64px;align-items:center;}

.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.35);margin-bottom:28px;}
.breadcrumb a{color:rgba(255,255,255,.35);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:rgba(249,115,22,.8);}
.breadcrumb span{color:rgba(255,255,255,.65);}

.hero-eyebrow{
    display:inline-flex;align-items:center;gap:8px;
    font-family: 'Montserrat', sans-serif;
    font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;
    color:var(--or);margin-bottom:24px;
}
.hero-eyebrow-line{width:32px;height:2px;background:var(--or);border-radius:999px;}

.hero-h1{
    font-family: 'Montserrat', sans-serif;
    font-size:clamp(3rem,6vw,5.2rem);
    font-weight:900;line-height:1.02;
    color:#fff;
    letter-spacing:-.03em;
    margin-bottom:24px;
}
.hero-h1 em{
    font-style:italic;
    background:linear-gradient(90deg,#f97316,#f59e0b);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}

.hero-sub{
    font-family: 'Montserrat', sans-serif;
    font-size:.975rem;color:rgba(255,255,255,.55);
    line-height:1.82;max-width:480px;margin-bottom:40px;
}

.hero-cta{
    display:inline-flex;align-items:center;gap:12px;
    font-family: 'Montserrat', sans-serif;font-size:.875rem;font-weight:700;
    padding:16px 32px;border-radius:14px;
    background:linear-gradient(135deg,var(--or),var(--or-d));
    color:#fff;text-decoration:none;
    box-shadow:0 8px 32px rgba(249,115,22,.4);
    transition:transform .2s,box-shadow .2s;
}
.hero-cta:hover{transform:translateY(-3px);box-shadow:0 16px 44px rgba(249,115,22,.55);color:#fff;}
.hero-cta-arrow{transition:transform .2s;}
.hero-cta:hover .hero-cta-arrow{transform:translateX(4px);}

/* Stats column on hero */
.hero-stats{display:flex;flex-direction:column;gap:24px;}
.hero-stat-card{
    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.08);
    border-radius:18px;padding:24px 28px;
    backdrop-filter:blur(8px);
    transition:background .25s,border-color .25s;
}
.hero-stat-card:hover{background:rgba(249,115,22,.08);border-color:rgba(249,115,22,.25);}
.stat-big{
    font-family: 'Montserrat', sans-serif;font-size:2.8rem;font-weight:900;
    background:linear-gradient(90deg,#f97316,#f59e0b);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    line-height:1;margin-bottom:4px;
}
.stat-label{font-family: 'Montserrat', sans-serif;font-size:11px;font-weight:700;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.09em;}
.stat-desc{font-family: 'Montserrat', sans-serif;font-size:12px;color:rgba(255,255,255,.25);margin-top:6px;line-height:1.5;}

/* ════════════════════════
   PROGRAM MASONRY
════════════════════════ */
.section-tag{
    display:inline-flex;align-items:center;gap:7px;
    font-family: 'Montserrat', sans-serif;
    font-size:10px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;
    padding:6px 16px;border-radius:999px;
    background:rgba(249,115,22,.1);border:1px solid rgba(249,115,22,.2);
    color:var(--or-d);
}
.dot-pulse{width:6px;height:6px;border-radius:50%;background:var(--or);animation:pulse 1.8s ease-in-out infinite;}

.masonry-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    grid-template-rows:auto;
    gap:20px;
}
/* Card 1 - tall left */
.m-card:nth-child(1){grid-row:span 2;}
/* Card 4 - wide bottom right */
.m-card:nth-child(4){grid-column:2;}

.m-card{
    position:relative;border-radius:24px;overflow:hidden;
    background:#fff;
    box-shadow:0 4px 24px rgba(0,0,0,.07);
    border:1px solid #f1f5f9;
    transition:transform .38s cubic-bezier(.16,1,.3,1),box-shadow .38s;
    display:flex;flex-direction:column;
    height:100%;
}
.m-card:hover{transform:translateY(-6px);box-shadow:0 24px 56px rgba(0,0,0,.13);}

/* Image inside card */
.m-img{position:relative;overflow:hidden;flex-shrink:0;}
.m-card:nth-child(1) .m-img{height:460px;}
.m-card:nth-child(2) .m-img,
.m-card:nth-child(3) .m-img{height:300px;}
.m-card:nth-child(4) .m-img{height:280px;}

.m-img img{width:100%;height:100%;object-fit:cover;transition:transform .7s cubic-bezier(.16,1,.3,1);display:block;}
.m-card:hover .m-img img{transform:scale(1.07);}
.m-img-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,transparent 50%,rgba(6,16,31,.55) 100%);}

/* Number pill on image */
.m-num{
    position:absolute;top:16px;left:16px;z-index:2;
    font-family: 'Montserrat', sans-serif;font-size:1.1rem;font-weight:900;
    color:#fff;background:linear-gradient(135deg,var(--or),var(--or-d));
    width:40px;height:40px;border-radius:12px;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 3px 14px rgba(249,115,22,.5);
    transition:transform .25s;
}
.m-card:hover .m-num{transform:rotate(-8deg) scale(1.1);}

/* Card body */
.m-body{padding:24px 26px 28px;}
.m-cat{
    display:inline-flex;align-items:center;gap:5px;
    font-family: 'Montserrat', sans-serif;
    font-size:9.5px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;
    padding:4px 11px;border-radius:999px;
    width:fit-content;margin-bottom:10px;
}
.m-title{
    font-family: 'Montserrat', sans-serif;
    font-weight:900;color:var(--ink);
    line-height:1.2;margin-bottom:10px;
    transition:color .2s;
}
.m-card:nth-child(1) .m-title{font-size:1.45rem;}
.m-card:nth-child(2) .m-title,
.m-card:nth-child(3) .m-title{font-size:1.15rem;}
.m-card:nth-child(4) .m-title{font-size:1.15rem;}
.m-card:hover .m-title{color:var(--or-d);}

.m-desc{
    font-family: 'Montserrat', sans-serif;
    font-size:.84rem;color:var(--muted);
    line-height:1.78;
    margin-bottom:18px;
}
.m-link{
    display:inline-flex;align-items:center;gap:7px;
    font-family: 'Montserrat', sans-serif;
    font-size:11px;font-weight:800;letter-spacing:.07em;text-transform:uppercase;
    color:var(--or);text-decoration:none;
    width:fit-content;
    padding-bottom:1px;
    border-bottom:1.5px solid transparent;
    transition:border-color .22s,gap .22s;
}
.m-link:hover{border-color:var(--or);gap:11px;}

/* ════════════════════════
   QUOTE BAND
════════════════════════ */
.quote-band{
    position:relative;overflow:hidden;
    background:var(--ink);
    padding:80px 20px;
}
.quote-band-bg{position:absolute;inset:0;background:linear-gradient(135deg,rgba(249,115,22,.08) 0%,transparent 60%);}
.quote-band-decor{
    position:absolute;right:-60px;top:50%;transform:translateY(-50%);
    font-family: 'Montserrat', sans-serif;font-size:28rem;font-weight:900;
    color:rgba(255,255,255,.025);line-height:1;user-select:none;pointer-events:none;
}
.quote-text{
    font-family: 'Montserrat', sans-serif;font-style:italic;
    font-size:clamp(1.4rem,3vw,2.2rem);font-weight:700;
    color:#fff;line-height:1.45;max-width:760px;
    position:relative;z-index:1;
}
.quote-text span{color:var(--or);}
.quote-source{
    font-family: 'Montserrat', sans-serif;
    font-size:12px;font-weight:700;color:rgba(255,255,255,.4);
    text-transform:uppercase;letter-spacing:.1em;
    margin-top:20px;position:relative;z-index:1;
}

/* ════════════════════════
   CTA
════════════════════════ */
.cta-wrap{
    background:var(--cream);padding:80px 20px;
}
.cta-inner{
    max-width:1100px;margin:0 auto;
    background:linear-gradient(135deg,#ea580c,#f97316 55%,#f59e0b);
    border-radius:32px;padding:72px 56px;
    position:relative;overflow:hidden;
}
.cta-inner::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.06;}
.cta-orb{position:absolute;border-radius:50%;filter:blur(60px);pointer-events:none;}
.cta-orb-a{width:360px;height:360px;background:rgba(255,255,255,.1);top:-100px;right:-80px;}
.cta-orb-b{width:240px;height:240px;background:rgba(0,0,0,.1);bottom:-60px;left:5%;}

/* ════════════════════════
   RESPONSIVE
════════════════════════ */
@media(max-width:1024px){
    .hero-inner{grid-template-columns:1fr;gap:48px;}
    .hero-stats{flex-direction:row;flex-wrap:wrap;}
    .hero-stat-card{flex:1;min-width:140px;}
}
@media(max-width:768px){
    .edu-hero{min-height:auto;}
    .hero-inner{padding:80px 16px 64px;}
    .shape-circle,.shape-circle-sm,.shape-dot-grid{display:none;}

    /* Single column masonry on mobile */
    .masonry-grid{grid-template-columns:1fr;gap:16px;}
    .m-card:nth-child(1){grid-row:span 1;}
    .m-card:nth-child(4){grid-column:1;}

    /* Taller images so photos show well */
    .m-card:nth-child(1) .m-img{height:300px;}
    .m-card:nth-child(2) .m-img,
    .m-card:nth-child(3) .m-img,
    .m-card:nth-child(4) .m-img{height:260px;}

    /* Remove height stretching - body sizes to content */
    .m-card{height:auto !important;}
    .m-body{padding:20px 22px 24px;flex:0 0 auto;}
    .m-desc{margin-bottom:14px;}

    .quote-band-decor{display:none;}
    .cta-inner{padding:48px 24px;border-radius:22px;}
}
@media(max-width:480px){
    .hero-stats{flex-direction:column;}
    .cta-inner{padding:40px 18px;}
}

/* --- GLOBAL STYLE OVERRIDE --- */
body{font-family: 'Montserrat', sans-serif;}
h1,h2,h3,h4,h5,h6,.hero-h1,.section-title,.stat-number-sm,.stat-num,.stat-label,.pill,.breadcrumb{font-family: 'Montserrat', sans-serif;}
.page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{
    position:relative!important;min-height:clamp(480px,65vh,700px)!important;height:auto!important;
    display:flex!important;align-items:flex-end!important;overflow:hidden!important;
    background:#0d1a0a url('{{ asset("images/image-background.jpg") }}') center 45%/cover no-repeat!important;
    isolation:isolate!important;border-radius:0!important;
}
.page-hero::after,.legal-hero::after,.edu-hero::after,.ch-hero::after,.pd-hero::after,.cp-hero::after,.hero::after{
    content:''!important;position:absolute!important;inset:0!important;z-index:1!important;
    background:linear-gradient(0deg,rgba(0,0,0,.80) 0%,rgba(0,0,0,.50) 38%,rgba(0,0,0,.18) 70%,rgba(0,0,0,.05) 100%)!important;
    pointer-events:none!important;
}
.page-hero-bg,.hero-bg,.cp-hero-bg,.hero-bg-img{
    position:absolute!important;inset:0!important;z-index:0!important;
    width:100%!important;height:100%!important;
    object-fit:cover!important;object-position:center 45%!important;
    background-image:url('{{ asset("images/image-background.jpg") }}')!important;
    background-size:cover!important;background-position:center 45%!important;
    filter:none!important;transform:none!important;transition:none!important;opacity:1!important;
}
.page-hero:hover .page-hero-bg,.edu-hero:hover .hero-bg,.ch-hero:hover .hero-bg,.pd-hero:hover .hero-bg,.cp-hero:hover .cp-hero-bg,.hero:hover .hero-bg{transform:none!important;}
.page-hero-overlay,.hero-grad,.cp-hero-gradient,.hero-shape,.hero-ring,.hero-img-strip,.hero-collage,.hero-stats,.hero-orb,#legalCanvas,.l-glow,.cp-orb,.shape-circle,.shape-circle-sm,.shape-dot-grid{display:none!important;}
.page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{
    position:relative!important;z-index:2!important;
    max-width:1100px!important;width:100%!important;
    margin:0 auto!important;padding:0 40px 60px!important;
    display:block!important;text-align:left!important;
}
.page-hero .breadcrumb,.legal-hero .breadcrumb,.edu-hero .breadcrumb,.ch-hero .breadcrumb,.pd-hero .breadcrumb,.cp-hero .breadcrumb,.hero .breadcrumb,
.page-hero .pill,.page-hero .hero-pill,.legal-hero .hero-pill,.edu-hero .hero-eyebrow,.ch-hero .hero-eyebrow,.pd-hero .hero-eyebrow,.cp-hero .hero-eyebrow,.hero .hero-eyebrow,.hero-eyebrow{display:none!important;}
.page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{
    font-family: 'Montserrat', sans-serif;
    font-size:clamp(2.4rem,4.5vw,3.8rem)!important;font-weight:900!important;
    line-height:1.0!important;letter-spacing:-.02em!important;color:#fff!important;
    max-width:720px!important;margin:0 0 18px!important;text-align:left!important;
    text-shadow:0 2px 8px rgba(0,0,0,.8),0 4px 20px rgba(0,0,0,.6)!important;
    animation:fadeUp .65s .08s ease both!important;
}
.page-hero h1 span,.page-hero h1 em,.legal-hero h1 span,.legal-hero h1 em,.edu-hero h1 span,.edu-hero h1 em,.ch-hero h1 span,.ch-hero h1 em,.pd-hero h1 span,.pd-hero h1 em,.cp-hero h1 span,.cp-hero h1 em,.hero h1 span,.hero h1 em,.hero-h1 span,.hero-h1 em,.text-gradient,.glow{
    background:none!important;color:#fff!important;-webkit-text-fill-color:#fff!important;filter:none!important;
}
.page-hero p,.legal-hero p,.edu-hero p,.ch-hero p,.pd-hero p,.cp-hero p,.hero p,.hero-sub,.hero-meta{
    font-family: 'Montserrat', sans-serif;font-size:clamp(.95rem,1.4vw,1.15rem)!important;
    font-weight:500!important;color:rgba(255,255,255,.92)!important;line-height:1.65!important;
    max-width:640px!important;margin:0 0 28px!important;text-align:left!important;
    text-shadow:0 1px 6px rgba(0,0,0,.7)!important;
}
/* Hero CTA Buttons */
.hero-cta-wrap{display:flex!important;flex-wrap:wrap!important;gap:14px!important;align-items:center!important;}
.hero-cta-btn{
    display:inline-flex!important;align-items:center!important;gap:10px!important;
    padding:13px 28px!important;background:#0ea5e9!important;color:#fff!important;
    font-family: 'Montserrat', sans-serif;font-size:12.5px!important;
    font-weight:800!important;letter-spacing:.07em!important;text-transform:uppercase!important;
    border-radius:6px!important;text-decoration:none!important;
    transition:background .2s,transform .18s!important;border:2px solid transparent!important;
    box-shadow:0 4px 14px rgba(14,165,233,.35)!important;
}
.hero-cta-btn:hover{background:#0284c7!important;transform:translateY(-2px)!important;color:#fff!important;}
.hero-cta-btn.outline{background:transparent!important;border:2px solid rgba(255,255,255,.75)!important;box-shadow:none!important;color:#fff!important;}
.hero-cta-btn.outline:hover{background:rgba(255,255,255,.15)!important;border-color:#fff!important;}
/* Mobile */
@media(max-width:1024px){
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{max-width:900px!important;padding:0 28px 50px!important;}
}
@media(max-width:768px){
    .page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{min-height:clamp(420px,75vw,560px)!important;}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{padding:0 20px 40px!important;}
    .page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{font-size:clamp(2rem,7vw,3rem)!important;}
    .page-hero-bg,.hero-bg,.cp-hero-bg,.hero-bg-img{background-position:55% 45%!important;object-position:55% 45%!important;}
    .hero-cta-wrap{flex-direction:column!important;gap:10px!important;}
    .hero-cta-btn{width:100%!important;justify-content:center!important;padding:14px 20px!important;}
}
@media(max-width:480px){
    .page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{min-height:clamp(380px,85vw,480px)!important;}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{padding:0 16px 36px!important;}
    .page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{font-size:clamp(1.75rem,9vw,2.4rem)!important;margin-bottom:14px!important;}
    .page-hero p,.legal-hero p,.edu-hero p,.ch-hero p,.pd-hero p,.cp-hero p,.hero p,.hero-sub,.hero-meta{font-size:.9rem!important;margin-bottom:22px!important;}
    .hero-cta-btn{font-size:11.5px!important;padding:12px 18px!important;}
}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{padding:48px 20px 40px!important;}
    .page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{font-size:clamp(1.95rem,10vw,2.5rem)!important;line-height:1!important;margin-bottom:16px!important;}
    .page-hero p,.legal-hero p,.edu-hero p,.ch-hero p,.pd-hero p,.cp-hero p,.hero p,.hero-sub,.hero-meta{font-size:.95rem!important;line-height:1.55!important;}
}</style>

{{-- ══ HERO ══ --}}
<section class="edu-hero">
    <div class="hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="hero-grad"></div>

    {{-- Shapes --}}
    <div class="hero-shape shape-circle"></div>
    <div class="hero-shape shape-circle-sm"></div>
    <div class="hero-shape shape-dot-grid">
        @for($i=0;$i<24;$i++)<span></span>@endfor
    </div>

    <div class="hero-inner">
        {{-- Left: text --}}
        <div>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <span>Our Actions</span>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <span>Childhood</span>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <span>Education</span>
            </nav>

            <div class="hero-eyebrow" style="animation:fadeUp .6s ease both;">
                <div class="hero-eyebrow-line"></div>
                Children's Education
            </div>

            <h1 class="hero-h1" style="animation:fadeUp .75s ease both;">
                Education<br>
                <em>Changes</em><br>
                Everything
            </h1>

            <p class="hero-sub" style="animation:fadeUp .75s .15s ease both;">
                Opening doors to knowledge, opportunity, and a brighter future - one classroom at a time, for every vulnerable child in Cambodia.
            </p>

            <a href="{{ route('sponsor.children') }}" class="hero-cta" style="animation:fadeUp .75s .28s ease both;">
                <i class="fas fa-graduation-cap"></i>
                Sponsor a Child
                <i class="fas fa-arrow-right text-sm hero-cta-arrow"></i>
            </a>
        </div>

        {{-- Right: stat cards --}}
        <div class="hero-stats" style="animation:fadeIn .9s .4s ease both;">
            <div class="hero-stat-card">
                <div class="stat-big">4</div>
                <div class="stat-label">Education Programs</div>
                <div class="stat-desc">School access, tutoring, civic education & personal growth</div>
            </div>
            <div class="hero-stat-card">
                <div class="stat-big">95K+</div>
                <div class="stat-label">Children Reached</div>
                <div class="stat-desc">Benefiting from our education initiatives every year</div>
            </div>
            <div class="hero-stat-card">
                <div class="stat-big">84%</div>
                <div class="stat-label">Funds to the Field</div>
                <div class="stat-desc">Of every euro goes directly to education programs</div>
            </div>
        </div>
    </div>
</section>

{{-- ══ PROGRAMS MASONRY ══ --}}
<section style="background:var(--cream);padding:80px 0 96px;">
    <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14 reveal">
            <div>
                <div class="section-tag mb-4"><span class="dot-pulse"></span> Education</div>
                <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(2rem,4.5vw,3rem);font-weight:900;color:var(--ink);line-height:1.1;letter-spacing:-.02em;">
                    Four Pillars of<br>
                    <span style="background:linear-gradient(90deg,#f97316,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Education</span>
                </h2>
            </div>
            <p style="font-family: 'Montserrat', sans-serif;font-size:.9rem;color:var(--muted);max-width:380px;line-height:1.78;flex-shrink:0;">
                Education is the most powerful tool to change a child's future. We make it accessible, inclusive, and transformative.
            </p>
        </div>

        @php
        $cards = [
            [
                'img'   => 'images/children/image-1.jpg',
                'icon'  => 'fas fa-school',
                'color' => '#fff7ed','ic' => '#f97316',
                'cat'   => 'Access',
                'title' => 'Access to School',
                'desc'  => 'In Cambodia, many vulnerable children do not have access to regular schooling due to poverty, distance, or lack of resources. Des Ailes pour Grandir supports schooling by assisting children and their families so they can attend school and benefit from a stable, continuous learning experience.',
            ],
            [
                'img'   => 'images/children/image-2.jpg',
                'icon'  => 'fas fa-book-open',
                'color' => '#eff6ff','ic' => '#3b82f6',
                'cat'   => 'Academic Support',
                'title' => 'Academic Support & Learning Development',
                'desc'  => 'Even when enrolled in school, some children need additional support to progress. We provide tutoring and educational activities tailored to their needs to build confidence and promote academic success.',
            ],
            [
                'img'   => 'images/children/image-3.jpg',
                'icon'  => 'fas fa-globe',
                'color' => '#f0fdf4','ic' => '#22c55e',
                'cat'   => 'Inclusive Education',
                'title' => 'Inclusive Education & Awareness',
                'desc'  => 'Education goes beyond academic subjects. Des Ailes pour Grandir promotes an inclusive approach incorporating respect for children\'s rights, awareness of protection, hygiene, and citizenship.',
            ],
            [
                'img'   => 'images/children/image-4.jpg',
                'icon'  => 'fas fa-star',
                'color' => '#faf5ff','ic' => '#a855f7',
                'cat'   => 'Personal Growth',
                'title' => 'Personal Development',
                'desc'  => 'Learning also means growing in confidence and autonomy. Our programs include psychosocial and creative activities that stimulate curiosity, strengthen self-esteem, and develop social and emotional skills.',
            ],
        ];
        @endphp

        <div class="masonry-grid">
            @foreach($cards as $i => $c)
            <div class="m-card reveal d{{ $i+1 }}">
                <div class="m-img">
                    <img src="{{ asset($c['img']) }}" alt="{{ $c['title'] }}" loading="lazy">
                    <div class="m-img-overlay"></div>
                    <div class="m-num">{{ $i + 1 }}</div>
                </div>
                <div class="m-body">
                    <div class="m-cat" style="background:{{ $c['color'] }};color:{{ $c['ic'] }};border:1px solid {{ $c['ic'] }}25;">
                        <i class="{{ $c['icon'] }}" style="font-size:9px;"></i> {{ $c['cat'] }}
                    </div>
                    <h3 class="m-title">{{ $c['title'] }}</h3>
                    <p class="m-desc">{{ $c['desc'] }}</p>
                    <a href="{{ route('sponsor.children') }}" class="m-link" style="color:{{ $c['ic'] }};border-color:{{ $c['ic'] }}40;">
                        Learn more <i class="fas fa-arrow-right" style="font-size:9px;"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ QUOTE BAND ══ --}}
<section class="quote-band reveal">
    <div class="quote-band-bg"></div>
    <div class="quote-band-decor">"</div>
    <div class="max-w-5xl mx-auto px-4 text-center">
        <div style="font-size:2.5rem;color:var(--or);line-height:1;margin-bottom:16px;font-family: 'Montserrat', sans-serif;">"</div>
        <p class="quote-text mx-auto">
            Education is the most powerful weapon you can use to <span>change the world</span> - and in Cambodia, we wield it every single day.
        </p>
        <div class="quote-source mx-auto mt-6">€ Des Ailes pour Grandir - Cambodia</div>
    </div>
</section>

{{-- ══ CTA ══ --}}
<div class="cta-wrap reveal">
    <div class="cta-inner">
        <div class="cta-orb cta-orb-a"></div>
        <div class="cta-orb cta-orb-b"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
            <div class="text-white text-center lg:text-left">
                <p style="font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:12px;">
                    <i class="fas fa-graduation-cap mr-1"></i> Support Education
                </p>
                <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;color:#fff;line-height:1.1;letter-spacing:-.02em;margin-bottom:12px;">
                    Make a Difference<br><em style="font-style:italic;">Today</em>
                </h2>
                <p style="font-family: 'Montserrat', sans-serif;color:rgba(255,255,255,.7);font-size:.9rem;max-width:380px;line-height:1.75;">
                    Your support funds school access, academic tutoring, and development opportunities for children in Cambodia.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                <a href="{{ route('sponsor.children') }}"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 36px;background:#fff;color:#ea580c;font-family: 'Montserrat', sans-serif;font-size:.875rem;font-weight:800;border-radius:16px;text-decoration:none;box-shadow:0 10px 32px rgba(0,0,0,.18);transition:transform .22s,box-shadow .22s;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 18px 44px rgba(0,0,0,.25)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='0 10px 32px rgba(0,0,0,.18)'">
                    <i class="fas fa-heart"></i> Sponsor a Child
                </a>
                <a href="{{ route('support.donate') }}"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 36px;background:rgba(255,255,255,.12);border:2px solid rgba(255,255,255,.3);color:#fff;font-family: 'Montserrat', sans-serif;font-size:.875rem;font-weight:800;border-radius:16px;text-decoration:none;transition:background .2s,border-color .2s;"
                   onmouseover="this.style.background='rgba(255,255,255,.22)';this.style.borderColor='rgba(255,255,255,.6)'"
                   onmouseout="this.style.background='rgba(255,255,255,.12)';this.style.borderColor='rgba(255,255,255,.3)'">
                    <i class="fas fa-hand-holding-heart"></i> Make a Donation
                </a>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    var o = new IntersectionObserver(function(entries){
        entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('in'); o.unobserve(e.target); } });
    },{threshold:.07,rootMargin:'0px 0px -40px 0px'});
    document.querySelectorAll('.reveal').forEach(function(el){ o.observe(el); });
})();
</script>
@endsection