{{-- resources/views/pages/support/foundations-philanthropy.blade.php --}}
@extends('layouts.app')
@section('title', 'Family Foundations & Philanthropy')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Montserrat:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
:root{
    --gold:#fbbf24;--gold-d:#d97706;--ember:#f97316;--ember-d:#ea580c;
    --sky:#04091f;--navy:#0c1445;--ink:#1c1033;--muted:#64748b;
    --cream:#fffbf0;--sand:#fef3c7;
}

@keyframes fadeUp  {from{opacity:0;transform:translateY(36px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn  {from{opacity:0}to{opacity:1}}
@keyframes pulse   {0%,100%{box-shadow:0 0 0 0 rgba(251,191,36,.4)}70%{box-shadow:0 0 0 12px rgba(251,191,36,0)}}
@keyframes ray     {0%,100%{opacity:.22;transform:scaleY(1)}50%{opacity:.58;transform:scaleY(1.1)}}
@keyframes orb     {0%,100%{transform:translate(0,0)}50%{transform:translate(24px,-18px)}}
@keyframes shimmer {from{left:-100%}to{left:200%}}

.reveal{opacity:0;transform:translateY(28px);transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
.reveal.visible{opacity:1;transform:none}
.d1{transition-delay:.07s}.d2{transition-delay:.16s}.d3{transition-delay:.25s}.d4{transition-delay:.34s}

/* â•â• HERO â•â• */
.page-hero{position:relative;overflow:hidden;min-height:100vh;display:flex;align-items:center;background:radial-gradient(ellipse at 50% 110%,#1a0a3d 0%,#0c1445 45%,#04091f 100%);}
#starCanvas{position:absolute;inset:0;z-index:0;pointer-events:none;}
.dawn-glow{position:absolute;bottom:-80px;left:50%;transform:translateX(-50%);width:1000px;height:420px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.18) 0%,rgba(249,115,22,.08) 40%,transparent 70%);z-index:1;pointer-events:none;animation:orb 8s ease-in-out infinite;}
.rays-wrap{position:absolute;bottom:0;left:50%;transform:translateX(-50%);z-index:1;width:100%;pointer-events:none;}
.ray{position:absolute;bottom:0;width:2px;border-radius:999px;background:linear-gradient(to top,rgba(251,191,36,.38),transparent);transform-origin:bottom center;animation:ray 3s ease-in-out infinite;}

.photo-strip{position:absolute;bottom:0;left:0;right:0;z-index:2;height:240px;display:flex;mask-image:linear-gradient(to top,rgba(0,0,0,.7) 0%,rgba(0,0,0,.2) 60%,transparent 100%);-webkit-mask-image:linear-gradient(to top,rgba(0,0,0,.7) 0%,rgba(0,0,0,.2) 60%,transparent 100%);}
.ps-img{flex:1;overflow:hidden;position:relative;}
.ps-img img{width:100%;height:100%;object-fit:cover;filter:saturate(.6) brightness(.5);transition:filter .5s;}
.ps-img:hover img{filter:saturate(1) brightness(.72);}
.ps-img::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(251,191,36,.12),transparent 60%);}

.page-hero-content{position:relative;z-index:3;padding:110px 20px 310px;max-width:1280px;margin:0 auto;width:100%;display:flex;flex-direction:column;align-items:center;text-align:center;}

.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;justify-content:center;font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(251,191,36,.4);margin-bottom:28px;}
.breadcrumb a{color:rgba(251,191,36,.4);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:rgba(251,191,36,.9);}
.breadcrumb span{color:rgba(251,191,36,.7);}

.hero-pill{display:inline-flex;align-items:center;gap:8px;padding:8px 22px;border-radius:999px;background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.22);font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gold);margin-bottom:28px;animation:fadeUp .6s ease both;}
.hero-pill-dot{width:7px;height:7px;border-radius:50%;background:var(--gold);animation:pulse 2s ease-in-out infinite;}

.hero-h1{font-family:'Cormorant Garamond',serif;font-size:clamp(2.6rem,7vw,6rem);font-weight:700;color:#fff;line-height:.96;letter-spacing:-.02em;margin-bottom:24px;animation:fadeUp .8s ease both;}
.hero-h1 .glow{display:inline-block;background:linear-gradient(135deg,#fde68a 0%,#fbbf24 40%,#f97316 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 36px rgba(251,191,36,.45));}

.hero-sub{font-family:'Outfit',sans-serif;font-size:1.05rem;color:rgba(255,255,255,.48);line-height:1.82;max-width:540px;margin:0 auto 40px;animation:fadeUp .8s .18s ease both;}

.hero-btns{display:flex;gap:14px;flex-wrap:wrap;justify-content:center;animation:fadeUp .8s .32s ease both;}
.btn-gold{display:inline-flex;align-items:center;gap:9px;padding:16px 34px;border-radius:14px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#1c1033;font-family:'Outfit',sans-serif;font-size:.9rem;font-weight:800;text-decoration:none;box-shadow:0 8px 28px rgba(251,191,36,.38);transition:transform .22s,box-shadow .22s;}
.btn-gold:hover{transform:translateY(-3px);box-shadow:0 16px 44px rgba(251,191,36,.52);color:#1c1033;}
.btn-ghost{display:inline-flex;align-items:center;gap:9px;padding:16px 34px;border-radius:14px;background:rgba(255,255,255,.05);border:1.5px solid rgba(251,191,36,.28);color:rgba(255,255,255,.72);font-family:'Outfit',sans-serif;font-size:.9rem;font-weight:700;text-decoration:none;transition:background .2s,border-color .2s;}
.btn-ghost:hover{background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.6);color:#fff;}

.wave-divider{line-height:0;overflow:hidden;}
.wave-divider svg{display:block;}

/* â•â• SECTION LABEL â•â• */
.sec-label{display:inline-flex;align-items:center;gap:8px;font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gold-d);}
.sec-line{width:28px;height:2px;background:linear-gradient(90deg,var(--gold),var(--ember));border-radius:2px;}

/* â•â• WHY US — large editorial card â•â• */
.why-card{
    background:linear-gradient(135deg,var(--sky) 0%,var(--navy) 60%,#1a0a3d 100%);
    border-radius:28px;padding:64px 56px;
    position:relative;overflow:hidden;
    border:1px solid rgba(251,191,36,.1);
}
.why-card::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.05;}
.why-orb{position:absolute;border-radius:50%;filter:blur(70px);pointer-events:none;}
.why-orb-a{width:350px;height:350px;background:rgba(251,191,36,.07);top:-80px;right:-60px;animation:orb 9s ease-in-out infinite;}
.why-orb-b{width:220px;height:220px;background:rgba(249,115,22,.05);bottom:-50px;left:8%;animation:orb 12s ease-in-out infinite reverse;}

/* â•â• BENEFIT CARDS â•â• */
.benefits-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;}
.benefit-card{
    background:#fff;border-radius:22px;padding:32px 28px;
    border:1.5px solid #f1f5f9;
    box-shadow:0 4px 20px rgba(0,0,0,.05);
    display:flex;align-items:flex-start;gap:18px;
    position:relative;overflow:hidden;
    transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s,border-color .35s;
}
.benefit-card:hover{transform:translateY(-5px);box-shadow:0 20px 48px rgba(0,0,0,.1);}
.benefit-card::before{content:'';position:absolute;top:0;bottom:0;left:-100%;width:60%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.4),transparent);pointer-events:none;}
.benefit-card:hover::before{animation:shimmer .75s ease both;}

.benefit-icon{
    width:52px;height:52px;border-radius:16px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;font-size:20px;
    transition:transform .25s;
}
.benefit-card:hover .benefit-icon{transform:rotate(-6deg) scale(1.1);}
.benefit-title{font-family:'Cormorant Garamond',serif;font-size:1.15rem;font-weight:700;color:var(--ink);margin-bottom:6px;letter-spacing:-.01em;}
.benefit-desc{font-family:'Outfit',sans-serif;font-size:.875rem;color:var(--muted);line-height:1.75;}

/* â•â• GIVING LEVELS â•â• */
.levels-bg{
    background:var(--cream);
    padding:80px 20px;
    border-top:1px solid rgba(251,191,36,.1);
    border-bottom:1px solid rgba(251,191,36,.1);
}
.level-card{
    background:#fff;border-radius:22px;padding:36px 28px;text-align:center;
    border:2px solid #f1f5f9;
    box-shadow:0 4px 20px rgba(0,0,0,.05);
    position:relative;overflow:hidden;
    transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s,border-color .35s;
    display:flex;flex-direction:column;
}
.level-card:hover{transform:translateY(-7px);box-shadow:0 24px 56px rgba(0,0,0,.1);}
.level-card.featured{
    border-color:rgba(251,191,36,.4);
    background:linear-gradient(135deg,#fffbf0,#fff);
    box-shadow:0 8px 32px rgba(251,191,36,.15);
}
.level-card.featured:hover{box-shadow:0 24px 60px rgba(251,191,36,.25);}
.level-badge{
    position:absolute;top:14px;right:14px;
    font-family:'Outfit',sans-serif;font-size:9px;font-weight:800;
    letter-spacing:.1em;text-transform:uppercase;
    background:linear-gradient(135deg,#fbbf24,#f97316);color:#fff;
    padding:4px 12px;border-radius:999px;
    box-shadow:0 2px 8px rgba(251,191,36,.4);
}
.level-icon{
    width:64px;height:64px;border-radius:20px;
    display:flex;align-items:center;justify-content:center;font-size:26px;
    margin:0 auto 20px;
    transition:transform .25s;
}
.level-card:hover .level-icon{transform:scale(1.1) rotate(-4deg);}
.level-name{font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:700;color:var(--ink);margin-bottom:8px;letter-spacing:-.01em;}
.level-range{font-family:'Outfit',sans-serif;font-size:.85rem;font-weight:700;color:var(--gold-d);margin-bottom:16px;}
.level-desc{font-family:'Outfit',sans-serif;font-size:.85rem;color:var(--muted);line-height:1.72;flex:1;margin-bottom:20px;}
.level-perks{display:flex;flex-direction:column;gap:7px;text-align:left;}
.level-perk{display:flex;align-items:center;gap:8px;font-family:'Outfit',sans-serif;font-size:.82rem;color:var(--ink);}
.level-perk i{font-size:9px;flex-shrink:0;}

/* â•â• CONTACT CTA â•â• */
.contact-card{
    background:linear-gradient(135deg,var(--sky) 0%,var(--navy) 55%,#1a0a3d 100%);
    border-radius:28px;padding:64px 56px;text-align:center;
    position:relative;overflow:hidden;border:1px solid rgba(251,191,36,.1);
}
.contact-card::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.06;}
.contact-glow{position:absolute;bottom:-60px;left:50%;transform:translateX(-50%);width:600px;height:280px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.12) 0%,transparent 70%);pointer-events:none;}

/* â•â• CTA BANNER â•â• */
.cta-wrap{background:white;padding:80px 20px;}
.cta-in{max-width:1100px;margin:0 auto;background:linear-gradient(135deg,var(--sky) 0%,var(--navy) 55%,#1a0a3d 100%);border-radius:32px;padding:72px 56px;position:relative;overflow:hidden;}
.cta-in::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.06;}
.cta-glow{position:absolute;bottom:-80px;left:50%;transform:translateX(-50%);width:700px;height:300px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.13) 0%,rgba(249,115,22,.06) 45%,transparent 70%);pointer-events:none;}

/* Responsive */
@media(max-width:900px){
    .benefits-grid{grid-template-columns:1fr;}
    .why-card{padding:44px 28px;}
}
@media(max-width:640px){
    .page-hero{min-height:auto;}
    .page-hero-content{padding:72px 16px 290px;}
    .photo-strip{height:200px;}
    .why-card{padding:36px 20px;}
    .levels-grid{grid-template-columns:1fr !important;}
    .cta-in{padding:48px 20px;border-radius:22px;}
    .contact-card{padding:44px 20px;border-radius:22px;}
}

/* Donate page global header/font match */
body{font-family:'Outfit',sans-serif!important;}
body [style*="font-family"]{font-family:'Outfit',sans-serif!important;}
h1[style*="font-family"],h2[style*="font-family"],h3[style*="font-family"],h4[style*="font-family"],h5[style*="font-family"],h6[style*="font-family"]{font-family:'Montserrat',sans-serif!important;}
h1,h2,h3,h4,h5,h6,
.hero-h1,.section-title,.section-pill,.breadcrumb,.pill,.hero-pill,
.hero-eyebrow,.hero-meta,.hero-sub,.hero-ref-btn,.hero-btn,.hero-cta,
.btn-gold,.btn-ghost,.stat-number-sm,.stat-num,.stat-label{
    font-family:'Montserrat',sans-serif!important;
}
.page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{
    position:relative!important;
    min-height:370px!important;
    height:370px!important;
    display:flex!important;
    align-items:center!important;
    overflow:hidden!important;
    background:#1a1109 url('{{ asset('images/image-background.jpg') }}') center 45%/cover no-repeat!important;
    isolation:isolate!important;
    border-radius:0!important;
}
.page-hero::after,.legal-hero::after,.edu-hero::after,.ch-hero::after,.pd-hero::after,.cp-hero::after,.hero::after{
    content:''!important;
    position:absolute!important;inset:0!important;z-index:1!important;
    background:
        linear-gradient(90deg,rgba(0,0,0,.34) 0%,rgba(0,0,0,.30) 34%,rgba(0,0,0,.18) 68%,rgba(0,0,0,.10) 100%),
        linear-gradient(180deg,rgba(0,0,0,.16) 0%,rgba(0,0,0,.08) 48%,rgba(0,0,0,.18) 100%)!important;
    pointer-events:none!important;
}
.page-hero-bg,.hero-bg,.cp-hero-bg,.hero-bg-img{
    position:absolute!important;inset:0!important;z-index:0!important;
    display:block!important;
    width:100%!important;height:100%!important;
    object-fit:cover!important;object-position:center 45%!important;
    background-image:url('{{ asset('images/image-background.jpg') }}')!important;
    background-size:cover!important;background-position:center 45%!important;
    filter:none!important;transform:none!important;transition:none!important;
    opacity:1!important;
}
.page-hero:hover .page-hero-bg,.edu-hero:hover .hero-bg,.ch-hero:hover .hero-bg,.pd-hero:hover .hero-bg,.cp-hero:hover .cp-hero-bg,.hero:hover .hero-bg{
    transform:none!important;
}
.page-hero-overlay,.hero-grad,.cp-hero-gradient,.hero-shape,.hero-ring,.hero-img-strip,.hero-collage,.hero-stats,.hero-orb,#legalCanvas,.l-glow{
    display:none!important;
}
.page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{
    position:relative!important;z-index:2!important;
    max-width:1020px!important;width:100%!important;
    margin:0 auto!important;
    padding:68px 28px 56px!important;
    display:block!important;
    text-align:left!important;
}
.page-hero .breadcrumb,.legal-hero .breadcrumb,.edu-hero .breadcrumb,.ch-hero .breadcrumb,.pd-hero .breadcrumb,.cp-hero .breadcrumb,.hero .breadcrumb,
.page-hero .pill,.page-hero .hero-pill,.legal-hero .hero-pill,.edu-hero .hero-eyebrow,.ch-hero .hero-eyebrow,.pd-hero .hero-eyebrow,.cp-hero .hero-eyebrow,.hero .hero-eyebrow{
    display:none!important;
}
.page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{
    font-family:'Montserrat',sans-serif!important;
    font-size:clamp(2.7rem,4vw,3.55rem)!important;
    font-weight:900!important;
    line-height:.96!important;
    letter-spacing:-.015em!important;
    color:#fff!important;
    max-width:650px!important;
    margin:0 0 22px!important;
    text-align:left!important;
    text-shadow:0 2px 2px rgba(0,0,0,.75),0 4px 10px rgba(0,0,0,.62)!important;
    animation:fadeUp .6s .08s ease both!important;
}
.page-hero h1 span,.page-hero h1 em,.legal-hero h1 span,.legal-hero h1 em,.edu-hero h1 span,.edu-hero h1 em,
.ch-hero h1 span,.ch-hero h1 em,.pd-hero h1 span,.pd-hero h1 em,.cp-hero h1 span,.cp-hero h1 em,.hero h1 span,.hero h1 em,
.text-gradient,.glow{
    background:none!important;
    color:#fff!important;
    -webkit-text-fill-color:#fff!important;
    filter:none!important;
}
.page-hero p,.legal-hero p,.edu-hero p,.ch-hero p,.pd-hero p,.cp-hero p,.hero p,.hero-sub,.hero-meta{
    font-family:'Montserrat',sans-serif!important;
    font-size:clamp(1rem,1.25vw,1.18rem)!important;
    font-weight:700!important;
    color:#fff!important;
    line-height:1.55!important;
    max-width:665px!important;
    margin:0!important;
    text-align:left!important;
    text-shadow:0 2px 2px rgba(0,0,0,.78),0 4px 10px rgba(0,0,0,.58)!important;
}
@media(max-width:1024px){
    .page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{height:340px!important;min-height:340px!important;}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{max-width:860px!important;padding:56px 28px 46px!important;}
}
@media(max-width:768px){
    .page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{height:360px!important;min-height:360px!important;}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{padding:56px 24px 44px!important;}
    .page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{font-size:clamp(2.2rem,8vw,3rem)!important;max-width:560px!important;}
    .page-hero-bg,.hero-bg,.cp-hero-bg,.hero-bg-img{background-position:58% 50%!important;object-position:58% 50%!important;}
}
@media(max-width:480px){
    .page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{height:390px!important;min-height:390px!important;}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{padding:48px 20px 40px!important;}
    .page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{font-size:clamp(1.95rem,10vw,2.5rem)!important;line-height:1!important;margin-bottom:16px!important;}
    .page-hero p,.legal-hero p,.edu-hero p,.ch-hero p,.pd-hero p,.cp-hero p,.hero p,.hero-sub,.hero-meta{font-size:.95rem!important;line-height:1.55!important;}
}</style>

{{-- â•â• HERO â•â• --}}
<section class="page-hero">
    <canvas id="starCanvas"></canvas>
    <div class="dawn-glow"></div>
    <div class="rays-wrap" id="raysWrap"></div>
    <div class="photo-strip">
        @foreach(range(1,8) as $n)
        <div class="ps-img">
            <img src="{{ asset('images/children/image-'.$n.'.jpg') }}" alt="Child {{ $n }}" loading="lazy">
        </div>
        @endforeach
    </div>
    <div class="page-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <span>Support Us</span>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <span>Family Foundations</span>
        </nav>
        <div class="hero-pill">
            <div class="hero-pill-dot"></div> Philanthropy
        </div>
        <h1 class="hero-h1">
            Give with<br>
            <span class="glow">Purpose</span><br>
            & Legacy
        </h1>
        <p class="hero-sub">
            Strategic, values-driven giving that creates a lasting legacy for children in Cambodia — traceable, transparent, and deeply human.
        </p>
        <div class="hero-btns">
            <a href="#contact" class="btn-gold">
                <i class="fas fa-envelope"></i> Begin a Conversation
            </a>
            <a href="{{ route('support.donate') }}" class="btn-ghost">
                <i class="fas fa-hand-holding-heart"></i> Make a Donation
            </a>
        </div>
    </div>
</section>

<div class="wave-divider" style="background:var(--cream);">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,40 C480,68 960,10 1440,40 L1440,0 L0,0 Z" fill="#04091f"/>
    </svg>
</div>

{{-- â•â• WHY US â•â• --}}
<section style="background:var(--cream);padding:96px 0;">
    <div class="max-w-5xl mx-auto px-4">

        {{-- Header --}}
        <div class="text-center mb-14 reveal">
            <div class="sec-label justify-center mb-4">
                <div class="sec-line"></div> Why Choose Us <div class="sec-line"></div>
            </div>
            <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,4.5vw,3.2rem);font-weight:700;color:var(--ink);letter-spacing:-.02em;line-height:1.08;margin-bottom:14px;">
                Giving That <em style="font-style:italic;background:linear-gradient(135deg,#d97706,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Endures</em>
            </h2>
            <p style="font-family:'Outfit',sans-serif;font-size:.95rem;color:var(--muted);max-width:520px;margin:0 auto;line-height:1.78;">
                Family foundations and philanthropists seek impact that is traceable, values-aligned, and enduring. Our programs in Cambodia deliver all three.
            </p>
        </div>

        {{-- Why card --}}
        <div class="why-card reveal mb-12">
            <div class="why-orb why-orb-a"></div>
            <div class="why-orb why-orb-b"></div>
            <div class="relative z-10">
                <div class="sec-label mb-5" style="color:rgba(251,191,36,.6);">
                    <div class="sec-line"></div> Our Commitment
                </div>
                <p style="font-family:'Outfit',sans-serif;font-size:1rem;color:rgba(255,255,255,.62);line-height:1.85;margin-bottom:16px;max-width:760px;">
                    Whether you wish to fund a specific program, name a project, or build a multi-year partnership, we create a giving arrangement that reflects your family's values and vision — with <strong style="color:#fbbf24;">rigorous reporting</strong> and a deeply human approach.
                </p>
                <p style="font-family:'Outfit',sans-serif;font-size:1rem;color:rgba(255,255,255,.62);line-height:1.85;max-width:760px;">
                    Our field team provides direct access to on-the-ground impact, and every euro you contribute is tracked, reported, and transformed into measurable change for children in Cambodia.
                </p>
            </div>
        </div>

        {{-- Benefit cards --}}
        <div class="benefits-grid reveal">
            @foreach([
                ['fas fa-eye',          '#eff6ff','#3b82f6', 'Full Transparency',   'Dedicated impact reports, financial breakdowns, and direct access to our field team at any time.'],
                ['fas fa-tag',          '#fff7ed','#f97316', 'Named Projects',      'Name a school, well, or scholarship fund after your family — a living legacy children will carry forward.'],
                ['fas fa-handshake',    '#f0fdf4','#16a34a', 'Multi-Year Giving',   'Predictable, structured giving allows us to plan, scale, and deepen programs for greater long-term impact.'],
                ['fas fa-certificate',  '#faf5ff','#a855f7', 'Full Fiscal Benefit', 'All contributions are eligible for the maximum applicable tax deductions available in France.'],
            ] as $b)
            <div class="benefit-card d{{ $loop->index + 1 }}">
                <div class="benefit-icon" style="background:{{ $b[1] }};">
                    <i class="{{ $b[0] }}" style="color:{{ $b[2] }};"></i>
                </div>
                <div>
                    <div class="benefit-title">{{ $b[3] }}</div>
                    <div class="benefit-desc">{{ $b[4] }}</div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- â•â• GIVING LEVELS â•â• --}}
<section class="levels-bg reveal">
    <div class="max-w-6xl mx-auto px-4">

        <div class="text-center mb-14">
            <div class="sec-label justify-center mb-4">
                <div class="sec-line"></div> Giving Levels <div class="sec-line"></div>
            </div>
            <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:700;color:var(--ink);letter-spacing:-.02em;line-height:1.08;">
                Choose Your <em style="font-style:italic;color:var(--gold-d);">Level of Impact</em>
            </h2>
        </div>

        <div class="levels-grid grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                [
                    'icon'   => 'fas fa-seedling',
                    'bg'     => '#f0fdf4','ic' => '#16a34a',
                    'name'   => 'Patron',
                    'range'  => 'â‚¬5,000 – â‚¬19,999 / year',
                    'desc'   => 'Support a targeted program with meaningful annual funding and receive detailed impact updates.',
                    'perks'  => ['Annual impact report','Named in our annual report','Direct contact with field team'],
                    'feat'   => false,
                ],
                [
                    'icon'   => 'fas fa-star',
                    'bg'     => '#fff7ed','ic' => '#f97316',
                    'name'   => 'Benefactor',
                    'range'  => 'â‚¬20,000 – â‚¬99,999 / year',
                    'desc'   => 'Name a project or scholarship. Your family\'s values become a visible, lasting part of our mission.',
                    'perks'  => ['Named project or scholarship','Field visit invitation','Bi-annual reporting','Tax documentation'],
                    'feat'   => true,
                ],
                [
                    'icon'   => 'fas fa-crown',
                    'bg'     => '#fdf4ff','ic' => '#a855f7',
                    'name'   => 'Legacy Partner',
                    'range'  => 'â‚¬100,000+ / year',
                    'desc'   => 'Build a multi-year partnership with a dedicated program that carries your family\'s legacy for generations.',
                    'perks'  => ['Multi-year custom program','Dedicated liaison officer','Quarterly field reports','Foundation plaque & recognition'],
                    'feat'   => false,
                ],
            ] as $lvl)
            <div class="level-card {{ $lvl['feat'] ? 'featured' : '' }}">
                @if($lvl['feat'])
                <div class="level-badge">Most Popular</div>
                @endif
                <div class="level-icon" style="background:{{ $lvl['bg'] }};">
                    <i class="{{ $lvl['icon'] }}" style="color:{{ $lvl['ic'] }};"></i>
                </div>
                <div class="level-name">{{ $lvl['name'] }}</div>
                <div class="level-range">{{ $lvl['range'] }}</div>
                <div class="level-desc">{{ $lvl['desc'] }}</div>
                <div class="level-perks">
                    @foreach($lvl['perks'] as $perk)
                    <div class="level-perk">
                        <i class="fas fa-check-circle" style="color:{{ $lvl['ic'] }};"></i>
                        {{ $perk }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- â•â• CONTACT CTA â•â• --}}
<section style="background:var(--cream);padding:80px 20px;" id="contact">
    <div class="max-w-3xl mx-auto">
        <div class="contact-card reveal">
            <div class="contact-glow"></div>
            <div class="relative z-10">
                <div class="sec-label justify-center mb-5" style="color:rgba(251,191,36,.5);">
                    <div class="sec-line"></div> Get in Touch <div class="sec-line"></div>
                </div>
                <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;color:#fff;line-height:1.08;letter-spacing:-.02em;margin-bottom:14px;">
                    Begin a <em style="font-style:italic;background:linear-gradient(90deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Conversation</em>
                </h2>
                <p style="font-family:'Outfit',sans-serif;color:rgba(255,255,255,.5);font-size:.95rem;max-width:440px;margin:0 auto 36px;line-height:1.78;">
                    We welcome all exploratory conversations — confidential, with no obligation. Let's discover how your generosity can best serve children in Cambodia.
                </p>
                <a href="{{ route('home') }}#contact"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:12px;padding:18px 44px;border-radius:16px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#1c1033;font-family:'Outfit',sans-serif;font-size:.95rem;font-weight:800;text-decoration:none;box-shadow:0 10px 36px rgba(251,191,36,.4);transition:transform .22s,box-shadow .22s;position:relative;overflow:hidden;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 18px 48px rgba(251,191,36,.52)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='0 10px 36px rgba(251,191,36,.4)'">
                    <i class="fas fa-envelope"></i> Contact Our Foundation Team
                </a>
                <p style="font-family:'Outfit',sans-serif;font-size:11px;color:rgba(255,255,255,.25);margin-top:16px;letter-spacing:.06em;">
                    <i class="fas fa-lock mr-1"></i> Fully confidential · No obligation
                </p>
            </div>
        </div>
    </div>
</section>

{{-- â•â• BOTTOM CTA â•â• --}}
<div class="cta-wrap reveal">
    <div class="cta-in">
        <div class="cta-glow"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
            <div class="text-white text-center lg:text-left">
                <p style="font-family:'Outfit',sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(251,191,36,.5);margin-bottom:12px;">
                    <i class="fas fa-star mr-1"></i> Make an Impact
                </p>
                <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;color:#fff;line-height:1.08;letter-spacing:-.02em;margin-bottom:12px;">
                    Make a Difference<br>
                    <em style="font-style:italic;background:linear-gradient(90deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Today</em>
                </h2>
                <p style="font-family:'Outfit',sans-serif;color:rgba(255,255,255,.5);font-size:.9rem;max-width:400px;line-height:1.78;">
                    Your support funds programs that create measurable, lasting change for children in Cambodia.
                </p>
            </div>
            <div class="flex flex-col gap-4 flex-shrink-0">
                <a href="{{ route('sponsor.children') }}"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 36px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#1c1033;font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:800;border-radius:16px;text-decoration:none;box-shadow:0 10px 32px rgba(251,191,36,.3);transition:transform .22s,box-shadow .22s;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 18px 44px rgba(251,191,36,.45)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='0 10px 32px rgba(251,191,36,.3)'">
                    <i class="fas fa-heart"></i> Sponsor a Child
                </a>
                <a href="{{ route('support.donate') }}"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 36px;background:rgba(251,191,36,.08);border:1.5px solid rgba(251,191,36,.28);color:rgba(255,255,255,.8);font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:700;border-radius:16px;text-decoration:none;transition:background .2s,border-color .2s;"
                   onmouseover="this.style.background='rgba(251,191,36,.15)';this.style.borderColor='rgba(251,191,36,.55)'"
                   onmouseout="this.style.background='rgba(251,191,36,.08)';this.style.borderColor='rgba(251,191,36,.28)'">
                    <i class="fas fa-hand-holding-heart"></i> Make a Donation
                </a>
            </div>
        </div>
    </div>
</div>

<script>
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
        stars.forEach(function(p){var a=.15+.85*(Math.sin(t*p.s*.02+p.p)+1)*.5;ctx.beginPath();ctx.arc(p.x/100*W,p.y/100*H,p.r,0,Math.PI*2);ctx.fillStyle=p.warm?'rgba(251,191,36,'+a*.9+')':'rgba(255,255,255,'+a*.65+')';ctx.fill();if(p.r>1){var g=ctx.createRadialGradient(p.x/100*W,p.y/100*H,0,p.x/100*W,p.y/100*H,p.r*3);g.addColorStop(0,p.warm?'rgba(251,191,36,'+(a*.22)+')':'rgba(255,255,255,'+(a*.1)+')');g.addColorStop(1,'transparent');ctx.beginPath();ctx.arc(p.x/100*W,p.y/100*H,p.r*3,0,Math.PI*2);ctx.fillStyle=g;ctx.fill();}});
        shots=shots.filter(function(s){s.life-=s.decay;s.x+=s.vx;s.y+=s.vy;if(s.life<=0)return false;var g=ctx.createLinearGradient(s.x,s.y,s.x-s.vx*8,s.y-s.vy*8);g.addColorStop(0,'rgba(251,191,36,'+s.life*.9+')');g.addColorStop(.4,'rgba(255,220,100,'+s.life*.4+')');g.addColorStop(1,'transparent');ctx.beginPath();ctx.moveTo(s.x,s.y);ctx.lineTo(s.x-s.vx*(s.len/10),s.y-s.vy*(s.len/10));ctx.strokeStyle=g;ctx.lineWidth=s.life*2.5;ctx.lineCap='round';ctx.stroke();return true;});
        t++;requestAnimationFrame(draw);
    }
    draw();
})();
(function(){
    var w=document.getElementById('raysWrap');
    for(var i=0;i<14;i++){var r=document.createElement('div');r.className='ray';var angle=(i/13)*70-35,h=180+Math.random()*200,op=.07+Math.random()*.15,delay=Math.random()*3;r.style.cssText='left:calc(50% + '+angle+'px);height:'+h+'px;opacity:'+op+';animation-delay:'+delay+'s;animation-duration:'+(2.4+Math.random()*2)+'s;transform:rotate('+angle*.6+'deg);background:linear-gradient(to top,rgba(251,191,36,.42),transparent)';w.appendChild(r);}
})();
(function(){
    var o=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('visible');o.unobserve(e.target);}});},{threshold:.07,rootMargin:'0px 0px -40px 0px'});
    document.querySelectorAll('.reveal').forEach(function(el){o.observe(el);});
})();
</script>
@endsection