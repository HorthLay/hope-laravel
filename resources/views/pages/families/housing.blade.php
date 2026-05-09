{{-- resources/views/pages/families/housing.blade.php --}}
@extends('layouts.app')
@section('title', 'Housing & Family Stability')

@section('content')

<style>
/* ══ DESIGN: Night sky → dawn gradient - particle stars, golden light rays, warm hope ══ */
:root{
    --gold:#fbbf24; --gold-d:#d97706; --ember:#f97316;
    --dawn:#fde68a; --sky:#0c1445; --deep:#04091f;
    --ink:#1c1033; --muted:#6b7280; --cream:#fffbf0;
}

*{box-sizing:border-box;margin:0;padding:0;}

@keyframes fadeUp    {from{opacity:0;transform:translateY(40px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn    {from{opacity:0}to{opacity:1}}
@keyframes twinkle   {0%,100%{opacity:.2;transform:scale(1)}50%{opacity:1;transform:scale(1.4)}}
@keyframes float     {0%,100%{transform:translateY(0)}50%{transform:translateY(-14px)}}
@keyframes ray       {0%,100%{opacity:.3;transform:scaleY(1)}50%{opacity:.7;transform:scaleY(1.12)}}
@keyframes shimmer   {from{left:-100%}to{left:200%}}
@keyframes dawnRise  {from{opacity:0;transform:translateY(60px) scale(.95)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes orb       {0%,100%{transform:translate(0,0)}50%{transform:translate(20px,-16px)}}
@keyframes childFloat{0%,100%{transform:translateY(0) rotate(-1deg)}50%{transform:translateY(-12px) rotate(1deg)}}
@keyframes starDrift {0%{transform:translateX(0) translateY(0);opacity:0}20%{opacity:1}80%{opacity:1}100%{transform:translateX(var(--dx)) translateY(var(--dy));opacity:0}}
@keyframes pulse     {0%,100%{box-shadow:0 0 0 0 rgba(251,191,36,.4)}70%{box-shadow:0 0 0 14px rgba(251,191,36,0)}}
@keyframes lineDraw  {from{width:0}to{width:100%}}
@keyframes slideCard {from{opacity:0;transform:translateX(-30px)}to{opacity:1;transform:translateX(0)}}

/* Reveal system */
.reveal{opacity:0;transform:translateY(32px);transition:opacity .8s cubic-bezier(.16,1,.3,1),transform .8s cubic-bezier(.16,1,.3,1)}
.reveal.in{opacity:1;transform:none}
.d1{transition-delay:.08s}.d2{transition-delay:.18s}.d3{transition-delay:.28s}.d4{transition-delay:.38s}

/* ══════════════════════
   HERO - night sky
══════════════════════ */
.hero{
    position:relative;overflow:hidden;
    min-height:100vh;display:flex;align-items:center;
    background:radial-gradient(ellipse at 50% 110%, #1a0a3d 0%, #0c1445 45%, #04091f 100%);
}

/* Particle canvas behind everything */
#starCanvas{position:absolute;inset:0;z-index:0;pointer-events:none;}

/* Dawn glow at bottom */
.dawn-glow{
    position:absolute;bottom:-60px;left:50%;transform:translateX(-50%);
    width:900px;height:400px;border-radius:50%;
    background:radial-gradient(ellipse,rgba(251,191,36,.22) 0%,rgba(249,115,22,.12) 40%,transparent 70%);
    pointer-events:none;z-index:1;
    animation:orb 7s ease-in-out infinite;
}

/* Light rays */
.rays{position:absolute;bottom:0;left:50%;transform:translateX(-50%);z-index:1;width:100%;pointer-events:none;}
.ray{
    position:absolute;bottom:0;
    width:2px;border-radius:999px;
    background:linear-gradient(to top,rgba(251,191,36,.35),transparent);
    transform-origin:bottom center;
    animation:ray 3s ease-in-out infinite;
}

/* Photo strip - horizontal scroll of children images */
.photo-strip{
    position:absolute;bottom:0;left:0;right:0;z-index:2;
    height:260px;
    display:flex;gap:0;
    mask-image:linear-gradient(to top,rgba(0,0,0,.7) 0%,rgba(0,0,0,.3) 60%,transparent 100%);
    -webkit-mask-image:linear-gradient(to top,rgba(0,0,0,.7) 0%,rgba(0,0,0,.3) 60%,transparent 100%);
}
.photo-strip-img{
    flex:1;overflow:hidden;position:relative;
}
.photo-strip-img img{
    width:100%;height:100%;object-fit:cover;
    transition:transform .8s cubic-bezier(.16,1,.3,1);
    filter:saturate(.7) brightness(.6);
}
.photo-strip-img:hover img{transform:scale(1.06);filter:saturate(1) brightness(.8);}
/* Warm overlay on each strip image */
.photo-strip-img::after{
    content:'';position:absolute;inset:0;
    background:linear-gradient(to top,rgba(251,191,36,.18),transparent 60%);
    pointer-events:none;
}

/* Hero inner */
.hero-inner{
    position:relative;z-index:3;
    width:100%;max-width:1280px;margin:0 auto;
    padding:120px 20px 340px;
    display:flex;flex-direction:column;align-items:center;text-align:center;
}

.breadcrumb{
    display:flex;align-items:center;gap:8px;flex-wrap:wrap;justify-content:center;
    font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
    color:rgba(251,191,36,.4);margin-bottom:32px;
    font-family: 'Montserrat', sans-serif;
}
.breadcrumb a{color:rgba(251,191,36,.4);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:rgba(251,191,36,.9);}
.breadcrumb span{color:rgba(251,191,36,.7);}

/* Pill */
.h-pill{
    display:inline-flex;align-items:center;gap:8px;
    padding:8px 20px;border-radius:999px;
    background:rgba(251,191,36,.08);
    border:1px solid rgba(251,191,36,.25);
    font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:700;
    letter-spacing:.14em;text-transform:uppercase;color:var(--gold);
    margin-bottom:28px;
    animation:fadeUp .6s ease both;
}
.h-pill-dot{
    width:7px;height:7px;border-radius:50%;
    background:var(--gold);
    animation:pulse 2s ease-in-out infinite;
}

/* Heading */
.h-heading{
    font-family: 'Montserrat', sans-serif;
    font-size:clamp(3rem,8vw,6.5rem);
    font-weight:700;line-height:1;
    color:#fff;
    letter-spacing:-.02em;
    margin-bottom:24px;
    animation:fadeUp .8s ease both;
}
.h-heading .glow-word{
    display:inline-block;
    background:linear-gradient(135deg,#fde68a 0%,#fbbf24 40%,#f97316 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    filter:drop-shadow(0 0 32px rgba(251,191,36,.5));
}

.h-sub{
    font-family: 'Montserrat', sans-serif;font-size:1.05rem;color:rgba(255,255,255,.5);
    line-height:1.8;max-width:540px;margin:0 auto 40px;
    animation:fadeUp .8s .18s ease both;
}

/* CTA buttons */
.h-btns{
    display:flex;gap:14px;flex-wrap:wrap;justify-content:center;
    animation:fadeUp .8s .32s ease both;
}
.btn-primary{
    display:inline-flex;align-items:center;gap:10px;
    padding:16px 34px;border-radius:14px;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    color:#1c1033;font-family: 'Montserrat', sans-serif;font-size:.9rem;font-weight:800;
    text-decoration:none;
    box-shadow:0 8px 32px rgba(251,191,36,.4),0 0 0 0 rgba(251,191,36,.3);
    transition:transform .22s,box-shadow .22s;
    animation:pulse 3s ease-in-out infinite;
}
.btn-primary:hover{transform:translateY(-3px);box-shadow:0 16px 44px rgba(251,191,36,.55);color:#1c1033;}
.btn-outline{
    display:inline-flex;align-items:center;gap:10px;
    padding:16px 34px;border-radius:14px;
    background:rgba(255,255,255,.05);
    border:1.5px solid rgba(251,191,36,.3);
    color:rgba(255,255,255,.75);
    font-family: 'Montserrat', sans-serif;font-size:.9rem;font-weight:700;
    text-decoration:none;transition:background .2s,border-color .2s;
}
.btn-outline:hover{background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.6);color:#fff;}

/* Stats row */
.h-stats{
    display:flex;gap:40px;flex-wrap:wrap;justify-content:center;
    margin-top:56px;
    animation:fadeUp .8s .46s ease both;
}
.h-stat{}
.h-stat-n{
    font-family: 'Montserrat', sans-serif;font-size:2.4rem;font-weight:700;
    color:#fbbf24;line-height:1;letter-spacing:-.02em;
}
.h-stat-l{
    font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:700;
    color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.1em;margin-top:3px;
}
.h-stat-div{width:1px;background:rgba(251,191,36,.12);align-self:stretch;}

/* ══════════════════════
   WAVE
══════════════════════ */
.wave-dark{line-height:0;overflow:hidden;background:var(--cream);}
.wave-dark svg{display:block;}

/* ══════════════════════
   PROGRAM CARDS
   Light cream bg, warm card style
══════════════════════ */
.section-bg{background:var(--cream);padding:96px 0;}

/* Section label */
.sec-label{
    display:inline-flex;align-items:center;gap:8px;
    font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;
    color:var(--gold-d);
}
.sec-label-line{width:28px;height:2px;background:linear-gradient(90deg,var(--gold),var(--ember));border-radius:2px;}

.sec-heading{
    font-family: 'Montserrat', sans-serif;
    font-size:clamp(2.2rem,5vw,3.6rem);
    font-weight:700;color:var(--ink);line-height:1.08;letter-spacing:-.02em;
}
.sec-heading em{
    font-style:italic;
    background:linear-gradient(135deg,#d97706,#f97316);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}

/* ── Card layout: large horizontal ── */
.prog-card{
    position:relative;
    background:#fff;
    border-radius:28px;
    overflow:hidden;
    display:grid;
    grid-template-columns:420px 1fr;
    border:1px solid rgba(251,191,36,.12);
    box-shadow:0 4px 32px rgba(0,0,0,.06),0 1px 4px rgba(0,0,0,.04);
    transition:transform .4s cubic-bezier(.16,1,.3,1),box-shadow .4s;
}
.prog-card:hover{
    transform:translateY(-6px);
    box-shadow:0 24px 64px rgba(0,0,0,.1),0 4px 16px rgba(251,191,36,.08);
}
.prog-card.rev{grid-template-columns:1fr 420px;direction:rtl;}
.prog-card.rev>*{direction:ltr;}

/* Image side */
.prog-img{position:relative;overflow:hidden;min-height:360px;}
.prog-img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .8s cubic-bezier(.16,1,.3,1);}
.prog-card:hover .prog-img img{transform:scale(1.07);}
.prog-img-overlay{
    position:absolute;inset:0;
    background:linear-gradient(to bottom,transparent 35%,rgba(4,9,31,.65) 100%);
}

/* Golden number badge */
.prog-num{
    position:absolute;top:22px;left:22px;z-index:2;
    width:50px;height:50px;border-radius:16px;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    color:#fff;font-family: 'Montserrat', sans-serif;font-size:1.5rem;font-weight:700;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 4px 20px rgba(251,191,36,.5);
    transition:transform .25s,box-shadow .25s;
}
.prog-card:hover .prog-num{transform:rotate(-6deg) scale(1.1);box-shadow:0 8px 28px rgba(251,191,36,.6);}
.prog-card.rev .prog-num{left:auto;right:22px;}

/* Shimmer sweep on hover */
.prog-img::before{
    content:'';position:absolute;top:0;bottom:0;left:-100%;z-index:3;
    width:60%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.06),transparent);
    transition:none;pointer-events:none;
}
.prog-card:hover .prog-img::before{animation:shimmer .9s ease both;}

/* Image label at bottom */
.prog-img-label{
    position:absolute;bottom:0;left:0;right:0;z-index:2;
    padding:12px 20px 16px;
    display:flex;align-items:center;gap:8px;
}
.prog-img-tag{
    font-family: 'Montserrat', sans-serif;font-size:9px;font-weight:700;
    letter-spacing:.1em;text-transform:uppercase;
    background:rgba(251,191,36,.15);border:1px solid rgba(251,191,36,.3);
    color:rgba(255,255,255,.75);padding:4px 11px;border-radius:999px;
    backdrop-filter:blur(8px);
}

/* Text side */
.prog-body{
    padding:52px 52px 48px;
    display:flex;flex-direction:column;justify-content:center;
    position:relative;overflow:hidden;
}
/* Decorative radial in corner */
.prog-body::before{
    content:'';position:absolute;
    width:260px;height:260px;border-radius:50%;
    background:radial-gradient(circle,rgba(251,191,36,.06),transparent 70%);
    top:-60px;right:-60px;pointer-events:none;
}

.prog-cat{
    display:inline-flex;align-items:center;gap:6px;
    font-family: 'Montserrat', sans-serif;font-size:9.5px;font-weight:700;
    letter-spacing:.12em;text-transform:uppercase;
    padding:5px 14px;border-radius:999px;width:fit-content;
    margin-bottom:16px;
}
.prog-title{
    font-family: 'Montserrat', sans-serif;
    font-size:1.75rem;font-weight:700;color:var(--ink);
    line-height:1.2;margin-bottom:16px;
    transition:color .2s;
}
.prog-card:hover .prog-title{color:var(--gold-d);}

/* Animated underline on title */
.prog-title-text{
    position:relative;display:inline;
    padding-bottom:3px;
}
.prog-title-text::after{
    content:'';position:absolute;bottom:0;left:0;
    height:2px;width:0;
    background:linear-gradient(90deg,var(--gold),var(--ember));
    border-radius:999px;
    transition:width .45s cubic-bezier(.16,1,.3,1);
}
.prog-card:hover .prog-title-text::after{width:100%;}

.prog-desc{
    font-family: 'Montserrat', sans-serif;font-size:.9rem;color:var(--muted);
    line-height:1.82;margin-bottom:28px;
}

/* Icon feature row */
.prog-feature{
    display:flex;align-items:center;gap:10px;
    font-family: 'Montserrat', sans-serif;font-size:.82rem;font-weight:600;
    color:var(--gold-d);margin-bottom:10px;
}
.prog-feature-icon{
    width:30px;height:30px;border-radius:10px;
    display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;
}

.prog-link{
    display:inline-flex;align-items:center;gap:8px;
    font-family: 'Montserrat', sans-serif;font-size:11px;font-weight:800;
    letter-spacing:.07em;text-transform:uppercase;
    color:var(--gold-d);text-decoration:none;
    margin-top:4px;
    padding-bottom:1.5px;border-bottom:1.5px solid transparent;
    transition:border-color .25s,gap .22s;
}
.prog-link:hover{border-color:var(--gold-d);gap:13px;}

/* ══════════════════════
   IMPACT BAND
══════════════════════ */
.impact-band{
    background:linear-gradient(135deg,#04091f 0%,#0c1445 50%,#1a0a3d 100%);
    padding:80px 20px;position:relative;overflow:hidden;
}
.impact-band::before{
    content:'';position:absolute;inset:0;
    background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fbbf24' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity:.5;pointer-events:none;
}
.impact-orb{
    position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none;
    animation:orb 9s ease-in-out infinite;
}
.impact-orb-a{width:400px;height:400px;background:rgba(251,191,36,.07);top:-100px;right:-80px;}
.impact-orb-b{width:280px;height:280px;background:rgba(249,115,22,.05);bottom:-60px;left:10%;animation-delay:2s;}

.impact-grid{
    display:grid;grid-template-columns:repeat(4,1fr);
    gap:1px;background:rgba(251,191,36,.08);
    border-radius:20px;overflow:hidden;
    position:relative;z-index:1;
}
.impact-cell{
    background:#04091f;padding:40px 24px;text-align:center;
    transition:background .25s;
}
.impact-cell:hover{background:#0c1445;}
.impact-icon{
    width:56px;height:56px;border-radius:18px;
    display:flex;align-items:center;justify-content:center;font-size:22px;
    margin:0 auto 16px;
}
.impact-n{
    font-family: 'Montserrat', sans-serif;font-size:2.4rem;font-weight:700;
    background:linear-gradient(135deg,#fde68a,#fbbf24);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    line-height:1;margin-bottom:5px;
}
.impact-l{font-family: 'Montserrat', sans-serif;font-size:11px;font-weight:700;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.09em;}

/* ══════════════════════
   QUOTE STRIP
══════════════════════ */
.q-strip{
    position:relative;overflow:hidden;
    background:linear-gradient(135deg,#fffbf0,#fef3c7,#fffbf0);
    padding:80px 20px;
    border-top:1px solid rgba(251,191,36,.15);
    border-bottom:1px solid rgba(251,191,36,.15);
}
.q-strip::before{
    content:'"';
    position:absolute;right:-20px;top:50%;transform:translateY(-50%);
    font-family: 'Montserrat', sans-serif;font-size:24rem;font-weight:700;
    color:rgba(251,191,36,.06);line-height:1;pointer-events:none;user-select:none;
}
.q-text{
    font-family: 'Montserrat', sans-serif;font-style:italic;
    font-size:clamp(1.5rem,3.5vw,2.4rem);font-weight:600;
    color:var(--ink);line-height:1.42;max-width:800px;
    position:relative;z-index:1;
}
.q-text span{color:var(--gold-d);}
.q-src{
    font-family: 'Montserrat', sans-serif;font-size:11px;font-weight:700;
    color:var(--muted);text-transform:uppercase;letter-spacing:.1em;
    margin-top:20px;position:relative;z-index:1;
}

/* ══════════════════════
   CTA
══════════════════════ */
.cta-wrap{
    background:linear-gradient(135deg,#04091f 0%,#0c1445 55%,#1a0a3d 100%);
    padding:80px 20px;position:relative;overflow:hidden;
}
.cta-glow{
    position:absolute;bottom:-80px;left:50%;transform:translateX(-50%);
    width:800px;height:350px;border-radius:50%;
    background:radial-gradient(ellipse,rgba(251,191,36,.14) 0%,rgba(249,115,22,.08) 45%,transparent 70%);
    pointer-events:none;
}
.cta-box{
    max-width:1100px;margin:0 auto;
    display:flex;flex-col:column;lg:flex-row;items:center;justify:space-between;gap:40px;
    position:relative;z-index:1;
    flex-direction:column;
    text-align:center;
}
@media(min-width:1024px){
    .cta-box{flex-direction:row;text-align:left;}
}

/* Responsive */
@media(max-width:960px){
    .prog-card{grid-template-columns:1fr;}
    .prog-card.rev{grid-template-columns:1fr;direction:ltr;}
    .prog-img{min-height:260px;}
    .prog-body{padding:36px 28px;}
    .prog-title{font-size:1.45rem;}
    .prog-card.rev .prog-num{left:22px;right:auto;}
    .impact-grid{grid-template-columns:repeat(2,1fr);}
}
@media(max-width:640px){
    .hero-inner{padding:80px 16px 300px;}
    .photo-strip{height:200px;}
    .prog-card{border-radius:20px;}
    .prog-title{font-size:1.3rem;}
    .prog-body{padding:28px 20px;}
    .h-stats{gap:20px;}
    .impact-grid{grid-template-columns:repeat(2,1fr);}
    .q-strip::before{display:none;}
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

{{-- ══════════════════════════════════
     HERO - night sky with particles
══════════════════════════════════ --}}
<section class="hero">
    <canvas id="starCanvas"></canvas>

    {{-- Dawn glow --}}
    <div class="dawn-glow"></div>

    {{-- Light rays from horizon --}}
    <div class="rays" id="raysContainer"></div>

    {{-- Photo strip at bottom --}}
    <div class="photo-strip">
        @foreach(range(1,8) as $n)
        <div class="photo-strip-img">
            <img src="{{ asset('images/children/image-'.$n.'.jpg') }}" alt="Child {{ $n }}" loading="lazy">
        </div>
        @endforeach
    </div>

    <div class="hero-inner">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <span>Our Actions</span>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <span>Families</span>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <span>Housing & Stability</span>
        </nav>

        <div class="h-pill">
            <div class="h-pill-dot"></div> Family Homes
        </div>

        <h1 class="h-heading">
            Every Child<br>Deserves a<br>
            <span class="glow-word">Home</span>
        </h1>

        <p class="h-sub">
            A safe roof is not a privilege - it is the foundation upon which a child's entire future is built. We build, restore, and protect.
        </p>

        <div class="h-btns">
            <a href="{{ route('sponsor.children') }}" class="btn-primary">
                <i class="fas fa-house-user"></i> Sponsor a Family
            </a>
            <a href="{{ route('support.donate') }}" class="btn-outline">
                <i class="fas fa-hand-holding-heart"></i> Donate
            </a>
        </div>

        <div class="h-stats">
            @foreach([['4','Programs'],['100%','Field Impact'],['🏠','Cambodia'],['1958','Since']] as [$n,$l])
            <div class="h-stat">
                <div class="h-stat-n">{{ $n }}</div>
                <div class="h-stat-l">{{ $l }}</div>
            </div>
            @if(!$loop->last)<div class="h-stat-div"></div>@endif
            @endforeach
        </div>
    </div>
</section>

{{-- Wave --}}
<div class="wave-dark">
    <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,50 C360,80 1080,20 1440,50 L1440,0 L0,0 Z" fill="#04091f"/>
    </svg>
</div>

{{-- ══ PROGRAMS ══ --}}
<section class="section-bg">
    <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16 reveal">
            <div>
                <div class="sec-label mb-4">
                    <div class="sec-label-line"></div> Housing & Stability
                </div>
                <h2 class="sec-heading">
                    Four Pillars<br>of <em>Family Stability</em>
                </h2>
            </div>
            <p style="font-family: 'Montserrat', sans-serif;font-size:.9rem;color:var(--muted);max-width:360px;line-height:1.8;flex-shrink:0;">
                Through housing support, safety, and family care, we give every child in Cambodia a solid foundation from which to grow and dream.
            </p>
        </div>

        @php
        $programs = [
            [
                'img'   => 'images/children/image-14.jpg',
                'num'   => '01',
                'cat'   => 'Reconstruction','catBg' => '#fff7ed','catClr' => '#d97706',
                'tag'   => 'Building & Repair',
                'icon'  => 'fas fa-tools',
                'title' => 'Housing Reconstruction & Renovation',
                'desc'  => 'Safe and suitable housing is essential for the well-being of children and their families. We support the renovation and reconstruction of homes, providing durable shelter that protects families from environmental risks and improves their quality of life.',
                'feats' => [['fas fa-hammer','Durable construction materials'],['fas fa-home','Family-safe design'],['fas fa-leaf','Environmental resilience']],
            ],
            [
                'img'   => 'images/children/image-16.jpg',
                'num'   => '02',
                'cat'   => 'Stability','catBg' => '#eff6ff','catClr' => '#3b82f6',
                'tag'   => 'Secure Shelter',
                'icon'  => 'fas fa-home',
                'title' => 'Access to Stable Housing',
                'desc'  => 'Residential stability is a fundamental pillar for children to grow up securely. We help families find safe and lasting housing, reducing risks of frequent moves, instability, and social vulnerability.',
                'feats' => [['fas fa-shield-check','Long-term security'],['fas fa-users','Community integration'],['fas fa-map-marker-alt','Stable location']],
            ],
            [
                'img'   => 'images/children/image-13.jpg',
                'num'   => '03',
                'cat'   => 'Safety','catBg' => '#f0fdf4','catClr' => '#16a34a',
                'tag'   => 'Prevention',
                'icon'  => 'fas fa-shield-alt',
                'title' => 'Prevention & Safety',
                'desc'  => 'Housing is not just about walls - it involves safety, hygiene, and a nurturing environment. We implement prevention actions and raise families\' awareness of best practices to ensure healthy and protective conditions for children.',
                'feats' => [['fas fa-hands-wash','Hygiene programs'],['fas fa-exclamation-triangle','Risk prevention'],['fas fa-heartbeat','Health monitoring']],
            ],
            [
                'img'   => 'images/children/image-15.jpg',
                'num'   => '04',
                'cat'   => 'Well-being','catBg' => '#fdf4ff','catClr' => '#9333ea',
                'tag'   => 'Family Care',
                'icon'  => 'fas fa-heart',
                'title' => 'Strengthening Family Well-being',
                'desc'  => 'At the heart of our actions is comprehensive family support. We create stable and protective homes where children grow safely and parents feel supported and guided in their parental role.',
                'feats' => [['fas fa-child','Child-focused care'],['fas fa-graduation-cap','Parental guidance'],['fas fa-smile','Emotional well-being']],
            ],
        ];
        @endphp

        <div class="space-y-8 md:space-y-10">
            @foreach($programs as $i => $p)
            <div class="prog-card {{ $i%2===1 ? 'rev' : '' }} reveal d{{ ($i%4)+1 }}">

                <div class="prog-img">
                    <img src="{{ asset($p['img']) }}" alt="{{ $p['title'] }}" loading="lazy">
                    <div class="prog-img-overlay"></div>
                    <div class="prog-num">{{ $p['num'] }}</div>
                    <div class="prog-img-label">
                        <span class="prog-img-tag">{{ $p['tag'] }}</span>
                    </div>
                </div>

                <div class="prog-body">
                    <div class="prog-cat"
                         style="background:{{ $p['catBg'] }};color:{{ $p['catClr'] }};border:1px solid {{ $p['catClr'] }}25;">
                        <i class="{{ $p['icon'] }}" style="font-size:9px;"></i>
                        {{ $p['cat'] }}
                    </div>

                    <h3 class="prog-title">
                        <span class="prog-title-text">{{ $p['title'] }}</span>
                    </h3>

                    <p class="prog-desc">{{ $p['desc'] }}</p>

                    <div style="margin-bottom:24px;">
                        @foreach($p['feats'] as $feat)
                        <div class="prog-feature">
                            <div class="prog-feature-icon" style="background:{{ $p['catBg'] }};">
                                <i class="{{ $feat[0] }}" style="color:{{ $p['catClr'] }};"></i>
                            </div>
                            {{ $feat[1] }}
                        </div>
                        @endforeach
                    </div>

                    <a href="{{ route('support.donate') }}" class="prog-link">
                        Learn more <i class="fas fa-arrow-right" style="font-size:9px;"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ IMPACT NUMBERS ══ --}}
<section class="impact-band reveal">
    <div class="impact-orb impact-orb-a"></div>
    <div class="impact-orb impact-orb-b"></div>
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <div class="sec-label justify-center mb-4" style="color:rgba(251,191,36,.6);">
                <div class="sec-label-line"></div> By the Numbers <div class="sec-label-line"></div>
            </div>
            <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:700;color:#fff;letter-spacing:-.02em;">
                Our Impact on Families
            </h2>
        </div>
        <div class="impact-grid">
            @foreach([
                ['fas fa-tools','rgba(251,191,36,.08)','#fbbf24','4','Programs'],
                ['fas fa-home','rgba(59,130,246,.08)','#60a5fa','95K+','Families Reached'],
                ['fas fa-heart','rgba(34,197,94,.08)','#4ade80','84%','Funds to Field'],
                ['fas fa-star','rgba(168,85,247,.08)','#c084fc','1958','Serving Since'],
            ] as [$ico,$ibg,$iclr,$n,$l])
            <div class="impact-cell">
                <div class="impact-icon" style="background:{{ $ibg }};">
                    <i class="{{ $ico }}" style="color:{{ $iclr }};"></i>
                </div>
                <div class="impact-n">{{ $n }}</div>
                <div class="impact-l">{{ $l }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ QUOTE ══ --}}
<section class="q-strip reveal">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <div style="font-size:3rem;color:var(--gold-d);line-height:1;margin-bottom:16px;font-family: 'Montserrat', sans-serif;">"</div>
        <p class="q-text mx-auto">
            A safe home is not a luxury - it is the <span>light</span> that gives every child the courage to dream beyond their walls.
        </p>
        <div class="q-src mx-auto">€ Des Ailes pour Grandir - Cambodia</div>
    </div>
</section>

{{-- ══ CTA ══ --}}
<section class="cta-wrap">
    <div class="cta-glow"></div>
    <div class="cta-box reveal">
        <div class="text-white" style="text-align:inherit;">
            <p style="font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(251,191,36,.5);margin-bottom:12px;">
                <i class="fas fa-house-user mr-1"></i> Make an Impact
            </p>
            <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(2rem,4.5vw,3.4rem);font-weight:700;color:#fff;line-height:1.08;letter-spacing:-.02em;margin-bottom:14px;">
                Help a Family<br>Find <em style="font-style:italic;background:linear-gradient(90deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Their Home</em>
            </h2>
            <p style="font-family: 'Montserrat', sans-serif;color:rgba(255,255,255,.5);font-size:.9rem;max-width:420px;line-height:1.78;">
                Your support funds housing reconstruction, safety programs, and daily care for vulnerable families across Cambodia.
            </p>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;flex-shrink:0;">
            <a href="{{ route('sponsor.children') }}"
               style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 38px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#1c1033;font-family: 'Montserrat', sans-serif;font-size:.9rem;font-weight:800;border-radius:16px;text-decoration:none;box-shadow:0 10px 32px rgba(251,191,36,.3);transition:transform .22s,box-shadow .22s;"
               onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 20px 48px rgba(251,191,36,.45)'"
               onmouseout="this.style.transform='';this.style.boxShadow='0 10px 32px rgba(251,191,36,.3)'">
                <i class="fas fa-heart"></i> Sponsor a Family
            </a>
            <a href="{{ route('support.donate') }}"
               style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 38px;background:rgba(251,191,36,.08);border:1.5px solid rgba(251,191,36,.3);color:rgba(255,255,255,.8);font-family: 'Montserrat', sans-serif;font-size:.9rem;font-weight:700;border-radius:16px;text-decoration:none;transition:background .2s,border-color .2s;"
               onmouseover="this.style.background='rgba(251,191,36,.15)';this.style.borderColor='rgba(251,191,36,.6)'"
               onmouseout="this.style.background='rgba(251,191,36,.08)';this.style.borderColor='rgba(251,191,36,.3)'">
                <i class="fas fa-hand-holding-heart"></i> Make a Donation
            </a>
        </div>
    </div>
</section>

<script>
/* ═══════════════════════════════
   PARTICLE STAR CANVAS
═══════════════════════════════ */
(function(){
    var canvas = document.getElementById('starCanvas');
    var ctx    = canvas.getContext('2d');
    var W, H, particles = [], shooting = [];

    function resize(){
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    /* ── Static stars ── */
    for(var i=0;i<220;i++){
        particles.push({
            x: Math.random()*100,
            y: Math.random()*100,
            r: Math.random()*1.4+.2,
            a: Math.random(),
            s: Math.random()*2+1,   /* twinkle speed */
            p: Math.random()*Math.PI*2, /* phase */
            warm: Math.random() < .15  /* warm gold tint */
        });
    }

    /* ── Shoot a new star ── */
    function spawnShooting(){
        shooting.push({
            x: Math.random()*W*.6 + W*.1,
            y: Math.random()*H*.4,
            vx: (Math.random()*3+4) * (Math.random()<.5?1:-1),
            vy: Math.random()*2+1,
            life: 1, decay: Math.random()*.015+.01,
            len: Math.random()*80+40
        });
    }
    setInterval(spawnShooting, 2200);
    setTimeout(spawnShooting, 400);

    var t = 0;
    function draw(){
        ctx.clearRect(0,0,W,H);

        /* Static stars */
        particles.forEach(function(p){
            var alpha = .15 + .85*(Math.sin(t*p.s*.02 + p.p)+1)*.5;
            ctx.beginPath();
            ctx.arc(p.x/100*W, p.y/100*H, p.r, 0, Math.PI*2);
            if(p.warm){
                ctx.fillStyle = 'rgba(251,191,36,'+alpha*.9+')';
            } else {
                ctx.fillStyle = 'rgba(255,255,255,'+alpha*.7+')';
            }
            ctx.fill();

            /* Tiny glow on bigger stars */
            if(p.r > 1){
                ctx.beginPath();
                ctx.arc(p.x/100*W, p.y/100*H, p.r*3, 0, Math.PI*2);
                var grd = ctx.createRadialGradient(p.x/100*W,p.y/100*H,0,p.x/100*W,p.y/100*H,p.r*3);
                grd.addColorStop(0, p.warm ? 'rgba(251,191,36,'+(alpha*.25)+')' : 'rgba(255,255,255,'+(alpha*.12)+')');
                grd.addColorStop(1, 'transparent');
                ctx.fillStyle = grd;
                ctx.fill();
            }
        });

        /* Shooting stars */
        shooting = shooting.filter(function(s){
            s.life -= s.decay;
            s.x += s.vx;
            s.y += s.vy;
            if(s.life <= 0) return false;

            var grad = ctx.createLinearGradient(s.x, s.y, s.x - s.vx*8, s.y - s.vy*8);
            grad.addColorStop(0, 'rgba(251,191,36,'+s.life*.9+')');
            grad.addColorStop(.4,'rgba(255,220,100,'+s.life*.4+')');
            grad.addColorStop(1, 'transparent');

            ctx.beginPath();
            ctx.moveTo(s.x, s.y);
            ctx.lineTo(s.x - s.vx*(s.len/10), s.y - s.vy*(s.len/10));
            ctx.strokeStyle = grad;
            ctx.lineWidth = s.life * 2.5;
            ctx.lineCap = 'round';
            ctx.stroke();
            return true;
        });

        t++;
        requestAnimationFrame(draw);
    }
    draw();
})();

/* ═══════════════════════════════
   LIGHT RAYS
═══════════════════════════════ */
(function(){
    var container = document.getElementById('raysContainer');
    var count = 12;
    for(var i=0;i<count;i++){
        var ray = document.createElement('div');
        ray.className = 'ray';
        var angle  = (i/(count-1)) * 60 - 30;
        var height = 200 + Math.random()*180;
        var op     = .08 + Math.random()*.15;
        var delay  = Math.random()*3;
        ray.style.cssText = [
            'left:calc(50% + '+angle+'px)',
            'height:'+height+'px',
            'opacity:'+op,
            'animation-delay:'+delay+'s',
            'animation-duration:'+(2.5+Math.random()*2)+'s',
            'transform:rotate('+angle*.6+'deg)',
            'background:linear-gradient(to top,rgba(251,191,36,0.45),transparent)'
        ].join(';');
        container.appendChild(ray);
    }
})();

/* ═══════════════════════════════
   SCROLL REVEAL
═══════════════════════════════ */
(function(){
    var o = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){ e.target.classList.add('in'); o.unobserve(e.target); }
        });
    },{threshold:.06,rootMargin:'0px 0px -40px 0px'});
    document.querySelectorAll('.reveal').forEach(function(el){ o.observe(el); });
})();
</script>
@endsection