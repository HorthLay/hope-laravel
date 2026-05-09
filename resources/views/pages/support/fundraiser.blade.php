{{-- resources/views/pages/support/fundraiser.blade.php --}}
@extends('layouts.app')
@section('title', 'Start a Solidarity Fundraiser')

@section('content')

<style>
:root{
    --gold:#fbbf24;--gold-d:#d97706;--ember:#f97316;--ember-d:#ea580c;
    --sky:#04091f;--navy:#0c1445;--ink:#1c1033;--muted:#64748b;
    --cream:#fffbf0;--sand:#fef3c7;--green:#16a34a;--green-l:#dcfce7;
}

@keyframes fadeUp  {from{opacity:0;transform:translateY(36px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn  {from{opacity:0}to{opacity:1}}
@keyframes pulse   {0%,100%{box-shadow:0 0 0 0 rgba(251,191,36,.4)}70%{box-shadow:0 0 0 12px rgba(251,191,36,0)}}
@keyframes ray     {0%,100%{opacity:.22;transform:scaleY(1)}50%{opacity:.58;transform:scaleY(1.1)}}
@keyframes orb     {0%,100%{transform:translate(0,0)}50%{transform:translate(24px,-18px)}}
@keyframes float   {0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
@keyframes stepPop {from{opacity:0;transform:translateY(20px) scale(.96)}to{opacity:1;transform:none}}
@keyframes shimmer {from{left:-100%}to{left:200%}}
@keyframes cardIn  {from{opacity:0;transform:translateY(24px) scale(.97)}to{opacity:1;transform:none}}

.reveal{opacity:0;transform:translateY(28px);transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
.reveal.visible{opacity:1;transform:none}
.d1{transition-delay:.07s}.d2{transition-delay:.15s}.d3{transition-delay:.23s}
.d4{transition-delay:.31s}.d5{transition-delay:.39s}.d6{transition-delay:.47s}

/* ══ HERO ══ */
.page-hero{
    position:relative;overflow:hidden;
    min-height:100vh;display:flex;align-items:center;
    background:radial-gradient(ellipse at 50% 110%,#1a0a3d 0%,#0c1445 45%,#04091f 100%);
}
#starCanvas{position:absolute;inset:0;z-index:0;pointer-events:none;}
.dawn-glow{position:absolute;bottom:-80px;left:50%;transform:translateX(-50%);width:1000px;height:420px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.18) 0%,rgba(249,115,22,.08) 40%,transparent 70%);z-index:1;pointer-events:none;animation:orb 8s ease-in-out infinite;}
.rays-wrap{position:absolute;bottom:0;left:50%;transform:translateX(-50%);z-index:1;width:100%;pointer-events:none;}
.ray{position:absolute;bottom:0;width:2px;border-radius:999px;background:linear-gradient(to top,rgba(251,191,36,.38),transparent);transform-origin:bottom center;animation:ray 3s ease-in-out infinite;}

/* Photo strip */
.photo-strip{position:absolute;bottom:0;left:0;right:0;z-index:2;height:240px;display:flex;mask-image:linear-gradient(to top,rgba(0,0,0,.7) 0%,rgba(0,0,0,.2) 60%,transparent 100%);-webkit-mask-image:linear-gradient(to top,rgba(0,0,0,.7) 0%,rgba(0,0,0,.2) 60%,transparent 100%);}
.ps-img{flex:1;overflow:hidden;position:relative;}
.ps-img img{width:100%;height:100%;object-fit:cover;filter:saturate(.6) brightness(.5);transition:filter .5s;}
.ps-img:hover img{filter:saturate(1) brightness(.72);}
.ps-img::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(251,191,36,.12),transparent 60%);}

.page-hero-content{position:relative;z-index:3;padding:110px 20px 310px;max-width:1280px;margin:0 auto;width:100%;display:flex;flex-direction:column;align-items:center;text-align:center;}

.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;justify-content:center;font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(251,191,36,.4);margin-bottom:28px;}
.breadcrumb a{color:rgba(251,191,36,.4);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:rgba(251,191,36,.9);}
.breadcrumb span{color:rgba(251,191,36,.7);}

.hero-pill{display:inline-flex;align-items:center;gap:8px;padding:8px 22px;border-radius:999px;background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.22);font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gold);margin-bottom:28px;animation:fadeUp .6s ease both;}
.hero-pill-dot{width:7px;height:7px;border-radius:50%;background:var(--gold);animation:pulse 2s ease-in-out infinite;}

.hero-h1{font-family: 'Montserrat', sans-serif;font-size:clamp(2.8rem,7.5vw,6.5rem);font-weight:700;color:#fff;line-height:.96;letter-spacing:-.02em;margin-bottom:24px;animation:fadeUp .8s ease both;}
.hero-h1 .glow{display:inline-block;background:linear-gradient(135deg,#fde68a 0%,#fbbf24 40%,#f97316 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 36px rgba(251,191,36,.45));}

.hero-sub{font-family: 'Montserrat', sans-serif;font-size:1.05rem;color:rgba(255,255,255,.48);line-height:1.82;max-width:540px;margin:0 auto 40px;animation:fadeUp .8s .18s ease both;}

.hero-btns{display:flex;gap:14px;flex-wrap:wrap;justify-content:center;animation:fadeUp .8s .32s ease both;}
.btn-gold{display:inline-flex;align-items:center;gap:9px;padding:16px 34px;border-radius:14px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#1c1033;font-family: 'Montserrat', sans-serif;font-size:.9rem;font-weight:800;text-decoration:none;box-shadow:0 8px 28px rgba(251,191,36,.38);transition:transform .22s,box-shadow .22s;}
.btn-gold:hover{transform:translateY(-3px);box-shadow:0 16px 44px rgba(251,191,36,.52);color:#1c1033;}
.btn-ghost{display:inline-flex;align-items:center;gap:9px;padding:16px 34px;border-radius:14px;background:rgba(255,255,255,.05);border:1.5px solid rgba(251,191,36,.28);color:rgba(255,255,255,.72);font-family: 'Montserrat', sans-serif;font-size:.9rem;font-weight:700;text-decoration:none;transition:background .2s,border-color .2s;}
.btn-ghost:hover{background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.6);color:#fff;}

.wave-divider{line-height:0;overflow:hidden;}
.wave-divider svg{display:block;}

/* ══ SECTION LABEL ══ */
.sec-label{display:inline-flex;align-items:center;gap:8px;font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gold-d);}
.sec-line{width:28px;height:2px;background:linear-gradient(90deg,var(--gold),var(--ember));border-radius:2px;}

/* ══ TYPE CARDS ══ */
.types-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
.type-card{
    background:#fff;border-radius:22px;padding:28px 24px;
    border:1.5px solid #f1f5f9;
    box-shadow:0 4px 20px rgba(0,0,0,.05);
    position:relative;overflow:hidden;
    transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s,border-color .35s;
    text-align:center;
    animation:cardIn .6s ease both;
}
.type-card:hover{transform:translateY(-6px);box-shadow:0 20px 48px rgba(0,0,0,.1);}
/* Shimmer on hover */
.type-card::before{content:'';position:absolute;top:0;bottom:0;left:-100%;width:60%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.4),transparent);transition:none;pointer-events:none;}
.type-card:hover::before{animation:shimmer .75s ease both;}

.type-icon{
    width:60px;height:60px;border-radius:18px;
    display:flex;align-items:center;justify-content:center;font-size:24px;
    margin:0 auto 16px;
    transition:transform .25s;
}
.type-card:hover .type-icon{transform:scale(1.12) rotate(-5deg);}
.type-title{font-family: 'Montserrat', sans-serif;font-size:1.15rem;font-weight:700;color:var(--ink);margin-bottom:8px;letter-spacing:-.01em;}
.type-desc{font-family: 'Montserrat', sans-serif;font-size:.825rem;color:var(--muted);line-height:1.7;}

/* ══ HOW IT WORKS ══ */
.steps-bg{
    background:linear-gradient(135deg,var(--sky) 0%,var(--navy) 55%,#1a0a3d 100%);
    padding:80px 20px;position:relative;overflow:hidden;
}
.steps-bg::before{
    content:'';position:absolute;inset:0;
    background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23fbbf24' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity:.5;pointer-events:none;
}
.steps-orb{position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none;}
.orb-a{width:400px;height:400px;background:rgba(251,191,36,.07);top:-100px;right:-80px;animation:orb 9s ease-in-out infinite;}
.orb-b{width:280px;height:280px;background:rgba(249,115,22,.05);bottom:-60px;left:10%;animation:orb 12s ease-in-out infinite reverse;}

.steps-connector{position:absolute;top:50px;left:calc(50% - 30px);right:calc(50% - 30px + 180px);height:2px;background:linear-gradient(90deg,rgba(251,191,36,.3),rgba(249,115,22,.3));display:none;}
@media(min-width:768px){.steps-connector{display:block;}}

.step-card{
    background:rgba(255,255,255,.04);
    border:1px solid rgba(251,191,36,.1);
    border-radius:24px;padding:36px 28px;text-align:center;
    position:relative;
    transition:background .25s,border-color .25s,transform .35s;
}
.step-card:hover{background:rgba(251,191,36,.07);border-color:rgba(251,191,36,.3);transform:translateY(-4px);}

.step-num{
    width:56px;height:56px;border-radius:18px;margin:0 auto 16px;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    color:#fff;font-family: 'Montserrat', sans-serif;font-size:1.6rem;font-weight:700;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 4px 20px rgba(251,191,36,.4);
    transition:transform .25s,box-shadow .25s;
}
.step-card:hover .step-num{transform:rotate(-6deg) scale(1.1);box-shadow:0 8px 28px rgba(251,191,36,.55);}

.step-icon{font-size:18px;margin-bottom:12px;display:block;}
.step-title{font-family: 'Montserrat', sans-serif;font-size:1.2rem;font-weight:700;color:#fff;margin-bottom:10px;letter-spacing:-.01em;}
.step-desc{font-family: 'Montserrat', sans-serif;font-size:.85rem;color:rgba(255,255,255,.45);line-height:1.75;}

/* ══ CTA LAUNCH BUTTON ══ */
.launch-btn{
    display:inline-flex;align-items:center;gap:12px;
    padding:20px 48px;border-radius:16px;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    color:#fff;font-family: 'Montserrat', sans-serif;font-size:1.05rem;font-weight:800;
    text-decoration:none;letter-spacing:.02em;
    box-shadow:0 10px 36px rgba(251,191,36,.4);
    transition:transform .25s,box-shadow .25s;
    position:relative;overflow:hidden;
}
.launch-btn::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,transparent,rgba(255,255,255,.18),transparent);transform:translateX(-100%);transition:transform .5s;}
.launch-btn:hover::after{transform:translateX(100%);}
.launch-btn:hover{transform:translateY(-3px) scale(1.02);box-shadow:0 18px 48px rgba(251,191,36,.52);color:#fff;}

/* ══ IMPACT BAND ══ */
.impact-band{background:var(--cream);padding:72px 20px;border-top:1px solid rgba(251,191,36,.12);border-bottom:1px solid rgba(251,191,36,.12);}
.impact-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:rgba(251,191,36,.1);border-radius:20px;overflow:hidden;}
.impact-cell{background:var(--cream);padding:40px 24px;text-align:center;transition:background .22s;}
.impact-cell:hover{background:var(--sand);}
.impact-n{font-family: 'Montserrat', sans-serif;font-size:2.8rem;font-weight:700;background:linear-gradient(135deg,#d97706,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;margin-bottom:6px;}
.impact-l{font-family: 'Montserrat', sans-serif;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.09em;}

/* ══ CTA BANNER ══ */
.cta-wrap{background:white;padding:80px 20px;}
.cta-in{max-width:1100px;margin:0 auto;background:linear-gradient(135deg,#04091f 0%,#0c1445 55%,#1a0a3d 100%);border-radius:32px;padding:72px 56px;position:relative;overflow:hidden;}
.cta-in::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.06;}
.cta-glow{position:absolute;bottom:-80px;left:50%;transform:translateX(-50%);width:700px;height:300px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.13) 0%,rgba(249,115,22,.06) 45%,transparent 70%);pointer-events:none;}

/* Responsive */
@media(max-width:900px){
    .types-grid{grid-template-columns:repeat(2,1fr);}
    .impact-grid{grid-template-columns:repeat(2,1fr);}
    .cta-in{padding:48px 28px;border-radius:22px;}
}
@media(max-width:640px){
    .page-hero{min-height:auto;}
    .page-hero-content{padding:72px 16px 290px;}
    .photo-strip{height:200px;}
    .types-grid{grid-template-columns:1fr;}
    .impact-grid{grid-template-columns:repeat(2,1fr);}
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
<section class="page-hero">
    <canvas id="starCanvas"></canvas>
    <div class="dawn-glow"></div>
    <div class="rays-wrap" id="raysWrap"></div>

    {{-- <div class="photo-strip">
        @foreach(range(1,8) as $n)
        <div class="ps-img">
            <img src="{{ asset('images/children/image-'.$n.'.jpg') }}" alt="Child {{ $n }}" loading="lazy">
        </div>
        @endforeach
    </div> --}}

    <div class="page-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <span>Support Us</span>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <span>Fundraiser</span>
        </nav>
        <div class="hero-pill">
            <div class="hero-pill-dot"></div> Fundraise for Us
        </div>
        <h1 class="hero-h1">
            Start a<br>
            <span class="glow">Solidarity</span><br>
            Fundraiser
        </h1>
        <p class="hero-sub">
            Turn your birthday, marathon, or milestone into an act of generosity for children in Cambodia. Every moment can spark change.
        </p>
        <div class="hero-btns">
            <a href="#launch" class="btn-gold">
                <i class="fas fa-rocket"></i> Launch My Fundraiser
            </a>
            <a href="{{ route('support.donate') }}" class="btn-ghost">
                <i class="fas fa-hand-holding-heart"></i> Donate Instead
            </a>
        </div>
    </div>
</section>

<div class="wave-divider" style="background:#fffbf0;">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,40 C480,68 960,10 1440,40 L1440,0 L0,0 Z" fill="#04091f"/>
    </svg>
</div>

{{-- ══ FUNDRAISER TYPES ══ --}}
<section style="background:var(--cream);padding:96px 0;">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-14 reveal">
            <div class="sec-label justify-center mb-4">
                <div class="sec-line"></div> Choose Your Way <div class="sec-line"></div>
            </div>
            <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(2rem,4.5vw,3.2rem);font-weight:700;color:var(--ink);letter-spacing:-.02em;line-height:1.08;margin-bottom:14px;">
                Anyone Can <em style="font-style:italic;background:linear-gradient(135deg,#d97706,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Fundraise</em>
            </h2>
            <p style="font-family: 'Montserrat', sans-serif;font-size:.95rem;color:var(--muted);max-width:540px;margin:0 auto;line-height:1.78;">
                A birthday, a race, a wedding - your moment can create a lasting future for children in Cambodia.
            </p>
        </div>

        @php
        $types = [
            ['fas fa-birthday-cake','#fdf2f8','#ec4899',  'Birthday Fundraiser', "Instead of gifts, ask friends and family to donate to a child's future."],
            ['fas fa-running',       '#f0fdf4','#16a34a',  'Sports Challenge',    'Run a marathon, cycle, or swim - collect pledges for every km or lap.'],
            ['fas fa-star',          '#fff7ed','#f97316',  'Life Milestone',      'Wedding, graduation, promotion - celebrate by giving others a reason to smile.'],
            ['fas fa-users',         '#eff6ff','#3b82f6',  'Team Challenge',      'Rally your colleagues, sports club, or community around a shared cause.'],
            ['fas fa-store',         '#faf5ff','#a855f7',  'Sale or Event',       'Dedicate proceeds from a sale, bake-off, or concert to our programs.'],
            ['fas fa-heart',         '#fff1f2','#ef4444',  'Memorial Tribute',    "Honor someone's memory by collecting donations in their name."],
        ];
        @endphp

        <div class="types-grid">
            @foreach($types as $i => $t)
            <div class="type-card reveal d{{ ($i%6)+1 }}">
                <div class="type-icon" style="background:{{ $t[1] }};">
                    <i class="{{ $t[0] }}" style="color:{{ $t[2] }};"></i>
                </div>
                <h3 class="type-title">{{ $t[3] }}</h3>
                <p class="type-desc">{{ $t[4] }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══ HOW IT WORKS ══ --}}
<section class="steps-bg reveal">
    <div class="steps-orb orb-a"></div>
    <div class="steps-orb orb-b"></div>

    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-14">
            <div class="sec-label justify-center mb-4" style="color:rgba(251,191,36,.6);">
                <div class="sec-line"></div> How It Works <div class="sec-line"></div>
            </div>
            <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:700;color:#fff;letter-spacing:-.02em;">
                Three Steps to <em style="font-style:italic;background:linear-gradient(90deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Impact</em>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            @foreach([
                ['fas fa-envelope','1','Contact Us','Reach out to our team to tell us about your project and get your personalized fundraising toolkit.'],
                ['fas fa-share-alt','2','Share Your Page',"We'll provide a unique page link, visuals, and tips to maximize your reach and inspire donors."],
                ['fas fa-hand-holding-usd','3','Collect & Impact',"Donations go directly to Des Ailes pour Grandir. You'll receive a full impact report to share."],
            ] as $step)
            <div class="step-card">
                <div class="step-num">{{ $step[1] }}</div>
                <i class="{{ $step[0] }} step-icon" style="color:rgba(251,191,36,.5);"></i>
                <h3 class="step-title">{{ $step[2] }}</h3>
                <p class="step-desc">{{ $step[3] }}</p>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-14" id="launch">
            <a href="{{ route('home') }}#contact" class="launch-btn">
                <i class="fas fa-rocket"></i> Launch My Fundraiser
            </a>
            <p style="font-family: 'Montserrat', sans-serif;font-size:11px;color:rgba(255,255,255,.28);margin-top:14px;letter-spacing:.06em;">
                <i class="fas fa-lock mr-1"></i> Secure - 100% goes to the field - Receipt provided
            </p>
        </div>
    </div>
</section>

{{-- ══ IMPACT NUMBERS ══ --}}
<section class="impact-band reveal">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(1.8rem,3.5vw,2.6rem);font-weight:700;color:var(--ink);letter-spacing:-.02em;">
                Your Fundraiser <em style="font-style:italic;color:var(--gold-d);">Joins</em> This Impact
            </h2>
        </div>
        <div class="impact-grid">
            @foreach([
                ['95K+','Children Helped'],
                ['84%','Funds to Field'],
                ['1958','Serving Since'],
            ] as [$n,$l])
            <div class="impact-cell">
                <div class="impact-n">{{ $n }}</div>
                <div class="impact-l">{{ $l }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ CTA BANNER ══ --}}
<div class="cta-wrap reveal">
    <div class="cta-in">
        <div class="cta-glow"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
            <div class="text-white text-center lg:text-left">
                <p style="font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(251,191,36,.5);margin-bottom:12px;">
                    <i class="fas fa-bullhorn mr-1"></i> Start Today
                </p>
                <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;color:#fff;line-height:1.08;letter-spacing:-.02em;margin-bottom:12px;">
                    Make a Difference<br>
                    <em style="font-style:italic;background:linear-gradient(90deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Today</em>
                </h2>
                <p style="font-family: 'Montserrat', sans-serif;color:rgba(255,255,255,.5);font-size:.9rem;max-width:380px;line-height:1.78;">
                    Whether you donate or fundraise - every action you take puts food, education, and hope into a child's hands.
                </p>
            </div>
            <div class="flex flex-col gap-4 flex-shrink-0">
                <a href="{{ route('sponsor.children') }}"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 36px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#1c1033;font-family: 'Montserrat', sans-serif;font-size:.875rem;font-weight:800;border-radius:16px;text-decoration:none;box-shadow:0 10px 32px rgba(251,191,36,.3);transition:transform .22s,box-shadow .22s;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 18px 44px rgba(251,191,36,.45)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='0 10px 32px rgba(251,191,36,.3)'">
                    <i class="fas fa-heart"></i> Sponsor a Child
                </a>
                <a href="{{ route('support.donate') }}"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 36px;background:rgba(251,191,36,.08);border:1.5px solid rgba(251,191,36,.28);color:rgba(255,255,255,.8);font-family: 'Montserrat', sans-serif;font-size:.875rem;font-weight:700;border-radius:16px;text-decoration:none;transition:background .2s,border-color .2s;"
                   onmouseover="this.style.background='rgba(251,191,36,.15)';this.style.borderColor='rgba(251,191,36,.55)'"
                   onmouseout="this.style.background='rgba(251,191,36,.08)';this.style.borderColor='rgba(251,191,36,.28)'">
                    <i class="fas fa-hand-holding-heart"></i> Make a Donation
                </a>
            </div>
        </div>
    </div>
</div>

<script>
/* Stars */
(function(){
    var c=document.getElementById('starCanvas'),ctx=c.getContext('2d'),W,H,stars=[],shots=[];
    function resize(){W=c.width=window.innerWidth;H=c.height=window.innerHeight;}
    window.addEventListener('resize',resize);resize();
    for(var i=0;i<200;i++) stars.push({x:Math.random()*100,y:Math.random()*100,r:Math.random()*1.3+.2,s:Math.random()*2+1,p:Math.random()*Math.PI*2,warm:Math.random()<.18});
    function spawn(){shots.push({x:Math.random()*W*.6+W*.1,y:Math.random()*H*.4,vx:(Math.random()*3+4)*(Math.random()<.5?1:-1),vy:Math.random()*2+1,life:1,decay:Math.random()*.015+.01,len:Math.random()*80+40});}
    setInterval(spawn,2400);setTimeout(spawn,500);
    var t=0;
    function draw(){
        ctx.clearRect(0,0,W,H);
        stars.forEach(function(p){
            var a=.15+.85*(Math.sin(t*p.s*.02+p.p)+1)*.5;
            ctx.beginPath();ctx.arc(p.x/100*W,p.y/100*H,p.r,0,Math.PI*2);
            ctx.fillStyle=p.warm?'rgba(251,191,36,'+a*.9+')':'rgba(255,255,255,'+a*.65+')';ctx.fill();
            if(p.r>1){var g=ctx.createRadialGradient(p.x/100*W,p.y/100*H,0,p.x/100*W,p.y/100*H,p.r*3);g.addColorStop(0,p.warm?'rgba(251,191,36,'+(a*.22)+')':'rgba(255,255,255,'+(a*.1)+')');g.addColorStop(1,'transparent');ctx.beginPath();ctx.arc(p.x/100*W,p.y/100*H,p.r*3,0,Math.PI*2);ctx.fillStyle=g;ctx.fill();}
        });
        shots=shots.filter(function(s){
            s.life-=s.decay;s.x+=s.vx;s.y+=s.vy;if(s.life<=0)return false;
            var g=ctx.createLinearGradient(s.x,s.y,s.x-s.vx*8,s.y-s.vy*8);g.addColorStop(0,'rgba(251,191,36,'+s.life*.9+')');g.addColorStop(.4,'rgba(255,220,100,'+s.life*.4+')');g.addColorStop(1,'transparent');
            ctx.beginPath();ctx.moveTo(s.x,s.y);ctx.lineTo(s.x-s.vx*(s.len/10),s.y-s.vy*(s.len/10));ctx.strokeStyle=g;ctx.lineWidth=s.life*2.5;ctx.lineCap='round';ctx.stroke();return true;
        });
        t++;requestAnimationFrame(draw);
    }
    draw();
})();

/* Rays */
(function(){
    var w=document.getElementById('raysWrap');
    for(var i=0;i<14;i++){
        var r=document.createElement('div');r.className='ray';
        var angle=(i/13)*70-35,h=180+Math.random()*200,op=.07+Math.random()*.15,delay=Math.random()*3;
        r.style.cssText='left:calc(50% + '+angle+'px);height:'+h+'px;opacity:'+op+';animation-delay:'+delay+'s;animation-duration:'+(2.4+Math.random()*2)+'s;transform:rotate('+angle*.6+'deg);background:linear-gradient(to top,rgba(251,191,36,.42),transparent)';
        w.appendChild(r);
    }
})();

/* Reveal */
(function(){
    var o=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('visible');o.unobserve(e.target);}});},{threshold:.07,rootMargin:'0px 0px -40px 0px'});
    document.querySelectorAll('.reveal').forEach(function(el){o.observe(el);});
})();
</script>
@endsection