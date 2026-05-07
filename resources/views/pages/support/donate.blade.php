{{-- resources/views/pages/support/donate.blade.php --}}
@extends('layouts.app')
@section('title', 'Make a Donation')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600;1,700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
:root{
    /* Brand palette — navy + orange/gold (matches logo + site identity) */
    --brand-navy-0:#070d1a;
    --brand-navy-1:#0f172a;
    --brand-navy-2:#162041;
    --brand-navy-3:#1e2d5a;
    --brand-orange:#f97316;
    --brand-orange-d:#ea580c;
    --brand-gold:#fbbf24;
    --brand-amber:#f59e0b;
    --warm-cream:#fef3c7;
    --warm-peach:#fed7aa;
    --warm-light:#fde68a;
    --gold:#fbbf24;--gold-d:#d97706;--ember:#f97316;--ember-d:#ea580c;
    --ink:#1c1033;--muted:#64748b;--cream:#fffbf0;--sand:#fef3c7;
}

@keyframes fadeUp     {from{opacity:0;transform:translateY(36px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn     {from{opacity:0}to{opacity:1}}
@keyframes pulseGold  {0%,100%{box-shadow:0 0 0 0 rgba(251,191,36,.5)}70%{box-shadow:0 0 0 12px rgba(251,191,36,0)}}
@keyframes auroraDrift{0%,100%{transform:translateX(0) scaleY(1);opacity:.6}50%{transform:translateX(40px) scaleY(1.1);opacity:.9}}
@keyframes orbFloat   {0%,100%{transform:translate(0,0) scale(1)}33%{transform:translate(28px,-22px) scale(1.05)}66%{transform:translate(-22px,18px) scale(.95)}}
@keyframes floatGentle{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
@keyframes horizonGlow{0%,100%{opacity:.7;transform:scaleX(1)}50%{opacity:1;transform:scaleX(1.05)}}
@keyframes wingFloat  {0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-8px) rotate(2deg)}}
@keyframes shimmerLine{0%{background-position:-200% 0}100%{background-position:200% 0}}
@keyframes cardIn     {from{opacity:0;transform:translateY(28px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes dotPulse   {0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.6);opacity:.35}}
@keyframes heartBeat  {0%,100%{transform:scale(1)}25%{transform:scale(1.15)}40%{transform:scale(1)}60%{transform:scale(1.1)}}
@keyframes popIn      {0%{opacity:0;transform:scale(.85)}70%{transform:scale(1.03)}100%{opacity:1;transform:scale(1)}}
@keyframes float      {0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
@keyframes borderAnim {0%,100%{border-color:rgba(251,191,36,.3)}50%{border-color:rgba(251,191,36,.8)}}

.reveal{opacity:0;transform:translateY(28px);transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
.reveal.visible{opacity:1;transform:none}
.stagger-1{transition-delay:.06s}.stagger-2{transition-delay:.13s}.stagger-3{transition-delay:.20s}

/* ══════════════════════════════════════════════════════════════
   HERO — warm mahogany → ember-gold (site-matched palette)
   ══════════════════════════════════════════════════════════════ */
.page-hero{
    position:relative;overflow:hidden;
    min-height:clamp(560px,72vh,820px);
    display:flex;align-items:center;
    background:
        radial-gradient(ellipse 80% 55% at 72% 0%,rgba(249,115,22,.32) 0%,transparent 55%),
        radial-gradient(ellipse 60% 45% at 15% 100%,rgba(245,158,11,.20) 0%,transparent 55%),
        linear-gradient(155deg,#1a0c04 0%,#2d1508 22%,#3d1e0a 44%,#512510 62%,#3a1a06 80%,#1e0d03 100%);
}
.hero-mesh{
    position:absolute;inset:0;z-index:1;pointer-events:none;
    background:
        radial-gradient(ellipse 800px 560px at 80% 15%,rgba(251,191,36,.22) 0%,transparent 58%),
        radial-gradient(ellipse 600px 480px at 20% 85%,rgba(249,115,22,.18) 0%,transparent 58%),
        radial-gradient(ellipse 480px 380px at 50% 50%,rgba(245,158,11,.10) 0%,transparent 65%);
}
.hero-grid-overlay{
    position:absolute;inset:0;z-index:1;pointer-events:none;
    background-image:
        linear-gradient(rgba(251,191,36,.05) 1px,transparent 1px),
        linear-gradient(90deg,rgba(251,191,36,.05) 1px,transparent 1px);
    background-size:64px 64px;
    mask-image:radial-gradient(ellipse 80% 60% at 50% 50%,#000 30%,transparent 80%);
    -webkit-mask-image:radial-gradient(ellipse 80% 60% at 50% 50%,#000 30%,transparent 80%);
}
.hero-aurora{
    position:absolute;top:0;left:-10%;right:-10%;height:400px;z-index:1;
    background:linear-gradient(180deg,rgba(249,115,22,.28) 0%,rgba(251,191,36,.16) 35%,rgba(245,158,11,.06) 70%,transparent 100%);
    filter:blur(55px);animation:auroraDrift 14s ease-in-out infinite;pointer-events:none;
}
.hero-horizon{
    position:absolute;bottom:-50px;left:0;right:0;height:220px;z-index:1;
    background:radial-gradient(ellipse 70% 100% at 50% 100%,rgba(249,115,22,.28) 0%,rgba(251,191,36,.12) 40%,transparent 70%);
    filter:blur(20px);pointer-events:none;animation:horizonGlow 6s ease-in-out infinite;transform-origin:center bottom;
}
.float-orb{position:absolute;border-radius:50%;filter:blur(60px);z-index:1;pointer-events:none;animation:orbFloat 9s ease-in-out infinite;}
.orb-1{width:360px;height:360px;top:4%;right:2%;background:rgba(249,115,22,.30);}
.orb-2{width:300px;height:300px;bottom:8%;left:2%;background:rgba(251,191,36,.22);animation-delay:-3s;}
.orb-3{width:220px;height:220px;top:46%;left:34%;background:rgba(234,88,12,.16);animation-delay:-5s;}
#constellationCanvas{position:absolute;inset:0;z-index:2;pointer-events:none;}
.hero-vignette{position:absolute;inset:0;z-index:3;pointer-events:none;background:radial-gradient(ellipse 100% 80% at 50% 50%,transparent 48%,rgba(26,12,4,.55) 100%);}

/* Wing/feather decorative glyphs — "Des Ailes" identity */
.hero-wing{position:absolute;z-index:2;pointer-events:none;color:rgba(249,115,22,.10);animation:wingFloat 8s ease-in-out infinite;}
.hero-wing-l{top:14%;left:2%;font-size:240px;transform:rotate(-15deg);}
.hero-wing-r{bottom:10%;right:2%;font-size:200px;transform:rotate(15deg) scaleX(-1);animation-delay:-3s;}

.page-hero-content{position:relative;z-index:5;padding:60px 24px 56px;max-width:1280px;margin:0 auto;width:100%;}
.hero-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:60px;align-items:center;}
.hero-left{position:relative;}

.breadcrumb{
    display:inline-flex;align-items:center;gap:8px;flex-wrap:wrap;
    font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
    color:rgba(254,215,170,.5);margin-bottom:22px;
}
.breadcrumb a{color:rgba(254,215,170,.5);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:#fde68a;}
.breadcrumb span{color:rgba(254,215,170,.85);}
.breadcrumb i{color:rgba(254,215,170,.25);}

/* ── ORGANIZATION IDENTITY LOCKUP ── */
.org-lockup{
    display:inline-flex;align-items:center;gap:14px;
    padding:10px 18px 10px 12px;border-radius:14px;
    background:linear-gradient(135deg,rgba(15,23,42,.55),rgba(30,45,90,.35));
    border:1px solid rgba(251,191,36,.28);
    backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);
    margin-bottom:22px;
    box-shadow:0 8px 28px rgba(7,13,26,.4),inset 0 0 0 1px rgba(255,255,255,.04);
    animation:fadeUp .7s ease both;
}
.org-lockup-emblem{
    width:38px;height:38px;flex-shrink:0;border-radius:11px;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 4px 14px rgba(249,115,22,.4),inset 0 0 0 1px rgba(255,255,255,.18);
    color:#0f172a;font-size:18px;
}
.org-lockup-text{display:flex;flex-direction:column;line-height:1;}
.org-lockup-pre{
    font-family:'Outfit',sans-serif;font-size:9px;font-weight:600;
    letter-spacing:.18em;text-transform:uppercase;color:rgba(254,215,170,.55);margin-bottom:4px;
}
.org-lockup-name{
    font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:700;
    font-size:18px;line-height:1.05;letter-spacing:-.005em;
    background:linear-gradient(135deg,#fef3c7,#fde68a 50%,#fbbf24);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}

.hero-pill{
    display:inline-flex;align-items:center;gap:9px;padding:8px 20px;border-radius:999px;
    background:rgba(249,115,22,.12);border:1px solid rgba(249,115,22,.32);
    backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
    font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#fde68a;
    margin-bottom:22px;animation:fadeUp .6s ease both;
}
.hero-pill-dot{width:7px;height:7px;border-radius:50%;background:#fbbf24;box-shadow:0 0 12px rgba(251,191,36,.85);animation:pulseGold 2s ease-in-out infinite;}

.hero-h1{
    font-family:'Cormorant Garamond',serif;
    font-size:clamp(2.2rem,5.6vw,5.4rem);font-weight:700;
    color:#fff;line-height:1;letter-spacing:-.025em;margin-bottom:18px;
    animation:fadeUp .8s .1s ease both;
}
.hero-h1 .glow-cream{
    display:inline-block;
    background:linear-gradient(135deg,#fef3c7 0%,#fde68a 45%,#fbbf24 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    filter:drop-shadow(0 0 32px rgba(251,191,36,.42));
}
.hero-h1 .glow-ember{
    display:inline-block;
    background:linear-gradient(135deg,#fde68a 0%,#fbbf24 35%,#f97316 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    filter:drop-shadow(0 0 32px rgba(249,115,22,.5));
}

.hero-accent-line{
    width:80px;height:3px;border-radius:2px;margin-bottom:20px;
    background:linear-gradient(90deg,transparent,#fbbf24 30%,#f97316 70%,transparent);
    background-size:200% 100%;
    animation:shimmerLine 3s linear infinite,fadeUp .8s .15s ease both;
}

.hero-sub{
    font-family:'Outfit',sans-serif;font-size:1.02rem;color:rgba(254,243,199,.68);line-height:1.78;
    max-width:500px;margin-bottom:32px;animation:fadeUp .8s .2s ease both;
}
.hero-sub strong{color:#fde68a;font-weight:600;}

.hero-btns{display:flex;gap:12px;flex-wrap:wrap;animation:fadeUp .8s .3s ease both;margin-bottom:36px;}
.btn-gold{
    display:inline-flex;align-items:center;gap:9px;padding:15px 30px;border-radius:14px;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    color:#0f172a;font-family:'Outfit',sans-serif;font-size:.88rem;font-weight:800;text-decoration:none;
    box-shadow:0 8px 28px rgba(251,191,36,.42),inset 0 0 0 1px rgba(255,255,255,.14);
    transition:transform .22s,box-shadow .22s;white-space:nowrap;
}
.btn-gold:hover{transform:translateY(-3px);box-shadow:0 16px 44px rgba(251,191,36,.6);color:#0f172a;}
.btn-ghost{
    display:inline-flex;align-items:center;gap:9px;padding:15px 30px;border-radius:14px;
    background:rgba(251,191,36,.08);border:1.5px solid rgba(251,191,36,.32);
    color:rgba(254,243,199,.85);font-family:'Outfit',sans-serif;font-size:.88rem;font-weight:700;text-decoration:none;
    backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
    transition:background .22s,border-color .22s,transform .22s,color .22s;white-space:nowrap;
}
.btn-ghost:hover{background:rgba(251,191,36,.16);border-color:rgba(251,191,36,.7);color:#fff;transform:translateY(-2px);}

.hero-stats{
    display:inline-flex;gap:0;flex-wrap:wrap;padding:16px 4px;
    background:rgba(15,23,42,.6);border:1px solid rgba(251,191,36,.22);border-radius:18px;
    backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
    animation:fadeUp .8s .4s ease both;box-shadow:0 12px 36px rgba(7,13,26,.5);
}
.h-stat{padding:0 22px;}
.hero-stat-n{
    font-family:'Cormorant Garamond',serif;font-size:1.75rem;font-weight:700;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    line-height:1;letter-spacing:-.02em;
}
.hero-stat-l{font-family:'Outfit',sans-serif;font-size:9.5px;font-weight:700;color:rgba(254,215,170,.55);text-transform:uppercase;letter-spacing:.1em;margin-top:5px;}
.hero-stat-div{width:1px;background:rgba(251,191,36,.18);align-self:stretch;}

.hero-right{position:relative;height:500px;}
.ph{
    position:absolute;border-radius:24px;overflow:hidden;
    box-shadow:0 20px 60px rgba(7,13,26,.6),0 0 0 1px rgba(251,191,36,.28),0 0 80px rgba(251,191,36,.06);
    transition:transform .5s cubic-bezier(.16,1,.3,1),box-shadow .5s;
}
.ph img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .8s cubic-bezier(.16,1,.3,1);}
.ph::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(251,191,36,.06) 0%,transparent 50%,rgba(249,115,22,.08) 100%);pointer-events:none;}
.ph:hover{transform:scale(1.04);box-shadow:0 28px 70px rgba(7,13,26,.7),0 0 0 1px rgba(251,191,36,.5),0 0 100px rgba(251,191,36,.12);}
.ph:hover img{transform:scale(1.08);}
.ph-1{top:0;left:8%;width:48%;height:42%;animation:floatGentle 6s ease-in-out infinite;}
.ph-2{top:10%;right:0;width:42%;height:36%;animation:floatGentle 7s ease-in-out infinite -2s;}
.ph-3{bottom:8%;left:0;width:42%;height:38%;animation:floatGentle 8s ease-in-out infinite -4s;}
.ph-4{bottom:0;right:6%;width:46%;height:42%;animation:floatGentle 6.5s ease-in-out infinite -1s;}

.impact-card{
    position:absolute;z-index:10;display:flex;align-items:center;gap:12px;
    padding:13px 18px;border-radius:16px;
    background:rgba(15,23,42,.88);border:1px solid rgba(251,191,36,.35);
    backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
    box-shadow:0 12px 40px rgba(7,13,26,.6),0 0 30px rgba(251,191,36,.08);
}
.impact-icon{
    width:38px;height:38px;border-radius:11px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    color:#0f172a;font-size:1rem;box-shadow:inset 0 0 0 1px rgba(255,255,255,.18);
}
.impact-icon.ember{background:linear-gradient(135deg,#fed7aa,#f97316);}
.impact-icon.amber{background:linear-gradient(135deg,#fde68a,#f59e0b);}
.impact-num{font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:700;color:#fff;line-height:1;}
.impact-lbl{font-family:'Outfit',sans-serif;font-size:9.5px;font-weight:700;color:rgba(254,215,170,.6);text-transform:uppercase;letter-spacing:.1em;margin-top:4px;}
.impact-card-1{top:34%;left:-5%;animation:floatGentle 5s ease-in-out infinite -2s;}
.impact-card-2{bottom:26%;right:-8%;animation:floatGentle 6s ease-in-out infinite -1s;}

.wave-divider{line-height:0;overflow:hidden;}
.wave-divider svg{display:block;}

/* ── HERO RESPONSIVE ── */
@media(max-width:1100px){
    .hero-grid{gap:44px;}
    .hero-right{height:460px;}
    .hero-wing-l,.hero-wing-r{font-size:160px;opacity:.6;}
}
@media(max-width:980px){
    .page-hero{min-height:auto;}
    .page-hero-content{padding:54px 22px 50px;}
    .hero-grid{grid-template-columns:1fr;gap:44px;}
    .hero-right{height:420px;max-width:560px;margin:0 auto;}
    .hero-wing-l{top:8%;font-size:140px;}
    .hero-wing-r{bottom:6%;font-size:130px;}
}
@media(max-width:680px){
    .page-hero-content{padding:42px 18px 40px;}
    .hero-grid{gap:36px;}
    .breadcrumb{font-size:9px;margin-bottom:18px;}
    .org-lockup{padding:8px 14px 8px 8px;gap:11px;margin-bottom:18px;}
    .org-lockup-emblem{width:34px;height:34px;font-size:15px;}
    .org-lockup-name{font-size:15px;}
    .org-lockup-pre{font-size:8px;letter-spacing:.16em;}
    .hero-pill{padding:7px 16px;font-size:9.5px;}
    .hero-h1{margin-bottom:14px;}
    .hero-accent-line{width:60px;height:2.5px;margin-bottom:16px;}
    .hero-sub{font-size:.95rem;line-height:1.7;margin-bottom:26px;}
    .hero-btns{gap:10px;margin-bottom:28px;width:100%;}
    .hero-btns .btn-gold,.hero-btns .btn-ghost{flex:1 1 calc(50% - 5px);justify-content:center;padding:14px 18px;font-size:.82rem;}
    .hero-stats{width:100%;justify-content:space-around;padding:14px 0;}
    .h-stat{padding:0 10px;flex:1;text-align:center;min-width:0;}
    .hero-stat-n{font-size:1.35rem;}
    .hero-stat-l{font-size:8.5px;letter-spacing:.06em;}
    .hero-right{height:auto;max-width:100%;display:grid;grid-template-columns:1fr 1fr;gap:12px;position:relative;}
    .ph{position:relative !important;top:auto !important;left:auto !important;right:auto !important;bottom:auto !important;width:100% !important;height:auto !important;aspect-ratio:1/1;border-radius:18px;animation:none !important;}
    .impact-card-1,.impact-card-2{display:none;}
    .hero-wing-l,.hero-wing-r{display:none;}
    .float-orb{filter:blur(40px);}
    .orb-1{width:220px;height:220px;}
    .orb-2{width:180px;height:180px;}
    .orb-3{display:none;}
}
@media(max-width:420px){
    .page-hero-content{padding:36px 16px 36px;}
    .hero-grid{gap:30px;}
    .breadcrumb{display:none;}
    .hero-h1{font-size:2.1rem;}
    .org-lockup-name{font-size:14px;}
    .hero-stats{padding:12px 0;border-radius:14px;}
    .hero-stat-div{display:none;}
    .h-stat{padding:6px 8px;}
    .hero-stat-n{font-size:1.2rem;}
    .hero-stat-l{font-size:8px;}
    .hero-right{gap:10px;}
    .ph{border-radius:14px;}
    .hero-btns .btn-gold,.hero-btns .btn-ghost{flex:1 1 100%;}
}
@media(prefers-reduced-motion:reduce){
    .float-orb,.hero-aurora,.hero-horizon,.ph,.hero-wing,.hero-accent-line,.impact-card{animation:none !important;}
}

/* ══════════════════════════════════════════════════════════════
   SECTION DECOR — pills, headings
   ══════════════════════════════════════════════════════════════ */
.section-pill{
    display:inline-flex;align-items:center;gap:7px;padding:7px 18px;border-radius:999px;
    background:linear-gradient(135deg,rgba(249,115,22,.12),rgba(245,158,11,.08));
    border:1px solid rgba(249,115,22,.2);
    font-family:'Outfit',sans-serif;font-size:11px;font-weight:800;letter-spacing:.07em;text-transform:uppercase;color:#ea580c;margin-bottom:14px;
}
.section-pill .dot{width:6px;height:6px;border-radius:50%;background:#f97316;animation:dotPulse 1.8s ease-in-out infinite;}

/* ══════════════════════════════════════════════════════════════
   PROJECT CARDS
   ══════════════════════════════════════════════════════════════ */
.proj-card{background:#fff;border-radius:22px;overflow:hidden;border:1px solid rgba(241,245,249,.8);box-shadow:0 4px 24px rgba(0,0,0,.07);cursor:default;opacity:0;transform:translateY(32px) scale(.97);will-change:transform;}
.proj-card.card-visible{animation:cardIn .65s cubic-bezier(.16,1,.3,1) both;opacity:1;transform:none;}
.proj-card:hover{transform:none !important;box-shadow:0 4px 24px rgba(0,0,0,.07) !important;}
.proj-img-wrap{position:relative;height:260px;overflow:hidden;}
.proj-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .7s cubic-bezier(.16,1,.3,1);}
.proj-img-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(10,20,30,.82) 0%,rgba(10,20,30,.2) 55%,transparent 100%);display:flex;flex-direction:column;justify-content:flex-end;padding:16px 18px;}
.proj-badge{display:inline-flex;align-items:center;gap:4px;background:rgba(249,115,22,.95);color:#fff;font-family:'Outfit',sans-serif;font-size:9px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;padding:4px 10px;border-radius:999px;margin-bottom:7px;width:fit-content;box-shadow:0 2px 8px rgba(249,115,22,.4);}
.proj-img-title{color:#fff;font-family:'Outfit',sans-serif;font-size:.92rem;font-weight:800;line-height:1.3;margin:0;text-shadow:0 1px 8px rgba(0,0,0,.4);}
.proj-body{padding:18px 20px 20px;}
.proj-tags{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:11px;}
.proj-tag{display:inline-flex;align-items:center;gap:3px;background:#f8fafc;border:1px solid #e8edf2;color:#64748b;font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;transition:background .15s,border-color .15s;}
.proj-tag:hover{background:#fff7ed;border-color:#fed7aa;color:#c2410c;}
.proj-desc{color:#64748b;font-family:'Outfit',sans-serif;font-size:.82rem;line-height:1.65;margin-bottom:14px;}
.proj-card-btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:10px;background:linear-gradient(135deg,#1e293b,#0f172a);color:rgba(255,255,255,.7);font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;border:none;cursor:pointer;box-shadow:0 3px 12px rgba(15,23,42,.2);transition:transform .18s,color .18s,box-shadow .18s;}
.proj-card-btn:hover{transform:translateY(-1px);color:#fbbf24;box-shadow:0 6px 18px rgba(15,23,42,.3);}
.proj-widget-wrap{border-top:1px solid #f1f5f9;background:#f8fafc;overflow:hidden;}
.proj-widget-bar{display:flex;align-items:center;justify-content:space-between;padding:9px 16px;background:linear-gradient(135deg,#1e293b,#0f172a);}
.proj-widget-label{display:flex;align-items:center;gap:6px;font-family:'Outfit',sans-serif;font-size:10px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.6);}
.proj-widget-label i{color:#fbbf24;}
.proj-widget-ha{font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;color:rgba(255,255,255,.3);display:flex;align-items:center;gap:4px;}
.proj-widget-iframe{display:block;width:100%;border:none;height:550px;min-height:300px;opacity:0;transition:opacity .4s ease;}
.proj-widget-iframe.loaded{opacity:1;}

/* ══════════════════════════════════════════════════════════════
   FISCAL CALCULATOR
   ══════════════════════════════════════════════════════════════ */
.calc-wrap{background:#fff;border-radius:28px;overflow:hidden;box-shadow:0 8px 48px rgba(0,0,0,.09),0 1px 0 rgba(251,191,36,.15);border:1px solid rgba(251,191,36,.12);}
.calc-type-card{cursor:pointer;padding:14px 12px;border-radius:16px;border:1.5px solid #e8edf2;transition:border-color .2s,background .2s,box-shadow .2s;background:#fff;}
.calc-type-card:hover{border-color:rgba(251,191,36,.5);}
.calc-type-card.active{border-color:#fbbf24;background:linear-gradient(135deg,rgba(251,191,36,.06),rgba(249,115,22,.04));box-shadow:0 4px 18px rgba(251,191,36,.15);}
.calc-type-card .ctc-title{font-family:'Outfit',sans-serif;font-size:.82rem;font-weight:800;color:#1e293b;margin-bottom:4px;}
.calc-type-card .ctc-rate{font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:700;background:linear-gradient(135deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;margin-bottom:3px;}
.calc-type-card .ctc-desc{font-family:'Outfit',sans-serif;font-size:.68rem;font-weight:600;color:#94a3b8;line-height:1.5;}
.calc-type-card.active .ctc-title{color:#92400e;}
.calc-amt-btn{padding:10px 4px;border-radius:12px;border:1.5px solid #e8edf2;background:#fff;font-family:'Outfit',sans-serif;font-size:.82rem;font-weight:800;color:#64748b;cursor:pointer;transition:all .18s;text-align:center;}
.calc-amt-btn:hover{border-color:rgba(251,191,36,.5);color:#92400e;}
.calc-amt-btn.active{background:linear-gradient(135deg,#fbbf24,#f97316);border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(251,191,36,.4);}
.calc-result-panel{background:linear-gradient(145deg,#0f172a 0%,#162041 55%,#1e2d5a 100%);border-radius:22px;padding:36px 28px;position:relative;overflow:hidden;}
.calc-result-panel::before{content:'';position:absolute;bottom:-60px;left:50%;transform:translateX(-50%);width:360px;height:240px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.20) 0%,rgba(249,115,22,.10) 45%,transparent 70%);pointer-events:none;}
.calc-result-big{font-family:'Cormorant Garamond',serif;font-size:clamp(3rem,6vw,4.5rem);font-weight:700;background:linear-gradient(135deg,#fde68a,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;letter-spacing:-.02em;}
.calc-info-box{background:linear-gradient(135deg,rgba(251,191,36,.06),rgba(249,115,22,.04));border:1px solid rgba(251,191,36,.18);border-radius:16px;padding:18px 20px;}
input[type=number].calc-input::-webkit-inner-spin-button,input[type=number].calc-input::-webkit-outer-spin-button{-webkit-appearance:none;margin:0;}
input[type=number].calc-input{-moz-appearance:textfield;}

/* ══════════════════════════════════════════════════════════════
   WAYS TO GIVE
   ══════════════════════════════════════════════════════════════ */
.ways-card{border-radius:22px;overflow:hidden;transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s;position:relative;}
.ways-card:hover{transform:translateY(-5px);}
.ways-card-light{background:#fff;border:2px solid #fed7aa;box-shadow:0 4px 24px rgba(249,115,22,.08);}
.ways-card-light:hover{box-shadow:0 16px 48px rgba(249,115,22,.15);}
.ways-card-dark{background:linear-gradient(145deg,#0f172a,#162041);border:1px solid rgba(251,191,36,.12);box-shadow:0 4px 24px rgba(7,13,26,.3);}
.ways-card-dark:hover{box-shadow:0 16px 48px rgba(7,13,26,.45);}
.ways-icon{width:52px;height:52px;border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;}

/* ══════════════════════════════════════════════════════════════
   DONATE CTA BOX + MODALS
   ══════════════════════════════════════════════════════════════ */
.donate-cta-box{position:relative;overflow:hidden;background:linear-gradient(145deg,var(--sand),var(--cream),var(--sand));border:2px solid rgba(251,191,36,.3);border-radius:28px;padding:56px 32px;text-align:center;animation:borderAnim 4s ease-in-out infinite;}
.donate-cta-box::before{content:'';position:absolute;inset:-50%;background:conic-gradient(from 0deg,transparent,rgba(251,191,36,.05) 25%,transparent 50%,rgba(249,115,22,.04) 75%,transparent);animation:float 14s linear infinite;border-radius:50%;}
.donate-btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 44px;border-radius:16px;border:none;cursor:pointer;background:linear-gradient(135deg,#fbbf24,#f97316);color:#fff;font-family:'Outfit',sans-serif;font-size:1rem;font-weight:900;letter-spacing:.04em;text-transform:uppercase;box-shadow:0 8px 32px rgba(251,191,36,.4);position:relative;overflow:hidden;transition:transform .25s,box-shadow .25s;}
.donate-btn::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,transparent,rgba(255,255,255,.18),transparent);transform:translateX(-100%);transition:transform .5s;}
.donate-btn:hover::after{transform:translateX(100%);}
.donate-btn:hover{transform:translateY(-3px) scale(1.02);box-shadow:0 16px 44px rgba(251,191,36,.52);color:#fff;}
.helloasso-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:999px;background:#f1f5f9;font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;color:#64748b;border:1px solid #e2e8f0;}
.secure-row{display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;font-family:'Outfit',sans-serif;font-size:12px;font-weight:600;color:#94a3b8;}
.secure-row span{display:flex;align-items:center;gap:5px;}

.proj-modal-bg{position:fixed;inset:0;z-index:2147483647;display:none;align-items:center;justify-content:center;backdrop-filter:blur(16px) brightness(.38) saturate(1.2);padding:16px;}
.proj-modal-bg.open{display:flex;animation:fadeIn .25s ease both;}
.proj-modal{background:#fff;border-radius:24px;overflow:hidden;width:100%;max-width:440px;max-height:92vh;display:flex;flex-direction:column;box-shadow:0 40px 100px rgba(0,0,0,.45);animation:popIn .38s cubic-bezier(.16,1,.3,1) both;}
.proj-modal-head{flex-shrink:0;position:relative;height:150px;overflow:hidden;}
.proj-modal-head-img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform 8s ease;}
.proj-modal-bg.open .proj-modal-head-img{transform:scale(1.04);}
.proj-modal-head-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,20,30,.88) 0%,rgba(10,20,30,.45) 55%,rgba(251,191,36,.08) 100%);display:flex;flex-direction:column;justify-content:flex-end;padding:16px 22px;}
.proj-modal-title{color:#fff;font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;line-height:1.3;padding-right:52px;}
.proj-modal-close{position:absolute;top:12px;right:12px;z-index:10;width:38px;height:38px;background:rgba(255,255,255,.12);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .18s,transform .18s;}
.proj-modal-close:hover{background:rgba(255,255,255,.25);transform:scale(1.1);}
.proj-modal-foot{padding:10px 18px;background:#f8fafc;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;flex-shrink:0;}
.proj-modal-foot span{font-family:'Outfit',sans-serif;font-size:11px;color:#94a3b8;font-weight:700;display:flex;align-items:center;gap:4px;}

@media(max-width:640px){
    .proj-img-wrap{height:200px;}
    .proj-modal-bg{align-items:flex-end;padding:0;}
    .proj-modal{max-height:92vh;border-radius:22px 22px 0 0;width:100%;max-width:100%;}
    .proj-widget-iframe{height:480px;}
    .calc-type-card .ctc-rate{font-size:1.1rem;}
}
</style>

{{-- ══════════════════════════════════════════════════════════════
     HERO — Brand-identity navy → dawn-orange
     ══════════════════════════════════════════════════════════════ --}}
<section class="page-hero">
    <div class="hero-mesh"></div>
    <div class="hero-grid-overlay"></div>
    <div class="hero-aurora"></div>
    <div class="float-orb orb-1"></div>
    <div class="float-orb orb-2"></div>
    <div class="float-orb orb-3"></div>

    {{-- Decorative wing glyphs — "Des Ailes" = wings --}}
    <i class="fas fa-feather-alt hero-wing hero-wing-l" aria-hidden="true"></i>
    <i class="fas fa-feather-alt hero-wing hero-wing-r" aria-hidden="true"></i>

    <canvas id="constellationCanvas"></canvas>
    <div class="hero-horizon"></div>
    <div class="hero-vignette"></div>

    <div class="page-hero-content">
        <div class="hero-grid">
            <div class="hero-left">

                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                    <span>Support Us</span>
                    <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                    <span>Make a Donation</span>
                </nav>

                {{-- ── ORGANIZATION IDENTITY LOCKUP ── --}}
                <div class="org-lockup">
                    <div class="org-lockup-emblem" aria-hidden="true">
                        <i class="fas fa-dove"></i>
                    </div>
                    <div class="org-lockup-text">
                        <div class="org-lockup-pre">Association · Cambodia</div>
                        <div class="org-lockup-name">Des Ailes pour Grandir</div>
                    </div>
                </div>

                <div class="hero-pill"><div class="hero-pill-dot"></div> Give Today</div>

                <h1 class="hero-h1">
                    <span class="glow-cream">Every Gift</span><br>
                    <span class="glow-ember">Changes a Life</span>
                </h1>

                <div class="hero-accent-line" aria-hidden="true"></div>

                <p class="hero-sub">
                    Since 1958, <strong>Des Ailes pour Grandir</strong> has stood beside vulnerable children in Cambodia. Whether you give once or every month, your gift goes <strong>100% to the field</strong> — funding shelter, education, healthcare, and protection.
                </p>

                <div class="hero-btns">
                    <a href="#projectGrid" class="btn-gold"><i class="fas fa-hand-holding-heart"></i> Donate Now</a>
                    <a href="{{ route('sponsor.children') }}" class="btn-ghost"><i class="fas fa-heart"></i> Sponsor a Child</a>
                </div>

              <div class="hero-stats">
                @foreach([
                    [number_format($donationProjects->count()), 'Active Projects'],
                    ['100%', 'To the Field'],
                    ['95K+', 'Children Helped'],
                    ['cambodia', 'Cambodia'] // change flag to keyword
                ] as [$n, $l])

                <div class="h-stat">
                    <div class="hero-stat-n">
                        @if($n === 'cambodia')
                            <img src="{{ asset('images/cambodia.svg') }}" 
                                alt="Cambodia" 
                                class="w-6 h-6 inline-block">
                        @else
                            {{ $n }}
                        @endif
                    </div>
                    <div class="hero-stat-l">{{ $l }}</div>
                </div>

                @if(!$loop->last)
                    <div class="hero-stat-div"></div>
                @endif

                @endforeach
            </div>

            </div>

            <div class="hero-right">
                <div class="ph ph-1"><img src="{{ asset('images/children/image-5.jpg') }}"  alt="" loading="lazy"></div>
                <div class="ph ph-2"><img src="{{ asset('images/children/image-8.jpg') }}"  alt="" loading="lazy"></div>
                <div class="ph ph-3"><img src="{{ asset('images/children/image-11.jpg') }}" alt="" loading="lazy"></div>
                <div class="ph ph-4"><img src="{{ asset('images/children/image-14.jpg') }}" alt="" loading="lazy"></div>

                <div class="impact-card impact-card-1">
                    <div class="impact-icon ember"><i class="fas fa-heart"></i></div>
                    <div>
                        <div class="impact-num">95K+</div>
                        <div class="impact-lbl">Children Helped</div>
                    </div>
                </div>
                <div class="impact-card impact-card-2">
                    <div class="impact-icon amber"><i class="fas fa-shield-alt"></i></div>
                    <div>
                        <div class="impact-num">100%</div>
                        <div class="impact-lbl">To the Field</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Wave: bottom of hero blending into warm cream section --}}
<div class="wave-divider" style="background:linear-gradient(180deg,#fdf6ec,#fef3e2);">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,40 C480,68 960,10 1440,40 L1440,0 L0,0 Z" fill="#1e0d03"/>
    </svg>
</div>

{{-- ══════════════════════════════════════════════════════════════
     ACTIVE CAMPAIGNS / PROJECT GRID
     ══════════════════════════════════════════════════════════════ --}}
<section class="py-16 md:py-28" style="background:linear-gradient(180deg,#fdf6ec,#fef3e2);">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <div class="section-pill mx-auto mb-4"><span class="dot"></span> Active Campaigns</div>
            <h2 class="text-2xl md:text-4xl font-black" style="font-family:'Cormorant Garamond',serif;color:#1c0e06;margin-bottom:8px;letter-spacing:-.02em;">Support a Specific Project</h2>
            <p class="text-gray-500 max-w-md mx-auto" style="font-family:'Outfit',sans-serif;font-size:.9rem;">Each card contains a live donation form — secure, fast, and transparent.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16" id="projectGrid">
            @forelse($donationProjects as $project)
            @php
                $imgUrl = $project->image ? asset($project->image) : asset('images/children/image-1.jpg');
                $badgeStyle = match($project->badge_color ?? 'orange'){
                    'green'=>'background:linear-gradient(135deg,rgba(34,197,94,.95),rgba(22,163,74,.95))',
                    'blue' =>'background:linear-gradient(135deg,rgba(59,130,246,.95),rgba(37,99,235,.95))',
                    'gray' =>'background:linear-gradient(135deg,rgba(100,116,139,.95),rgba(71,85,105,.95))',
                    default=>'background:linear-gradient(135deg,rgba(249,115,22,.95),rgba(234,88,12,.95))',
                };
                $lang  = app()->getLocale();
                $title = $project->{"title_{$lang}"} ?? $project->title_fr ?? $project->title_en;
                $desc  = $project->{"description_{$lang}"} ?? $project->description_fr ?? $project->description_en;
            @endphp
            <div class="proj-card" data-title="{{ e($title) }}" data-vignette="{{ e($project->helloasso_vignette_url ?? '') }}" data-img="{{ $imgUrl }}">
                <div class="proj-img-wrap">
                    <img src="{{ $imgUrl }}" alt="{{ e($title) }}" loading="lazy">
                    <div class="proj-img-overlay">
                        <span class="proj-badge" style="{{ $badgeStyle }}"><i class="fas fa-fire text-[9px]"></i> {{ $project->badge_label ?? 'Active' }}</span>
                        <h3 class="proj-img-title">{{ Str::limit($title,55) }}</h3>
                    </div>
                </div>
                <div class="proj-body">
                    @if($project->tags)
                    <div class="proj-tags">
                        @foreach(array_slice($project->tags,0,3) as $tag)
                        <span class="proj-tag"><i class="fas fa-tag text-orange-400 text-[8px]"></i> {{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                    @if($desc)<p class="proj-desc">{{ Str::limit($desc,100) }}</p>@endif
                    @if(!empty($project->helloasso_vignette_url))
                    <button class="proj-card-btn" onclick="openProjModalTab(this.closest('.proj-card'))" title="View campaign card">
                        <i class="fas fa-id-card"></i> Campaign Card
                    </button>
                    @endif
                </div>
                @if(!empty($project->helloasso_widget_url))
                <div class="proj-widget-wrap">
                    <div class="proj-widget-bar">
                        <div class="proj-widget-label"><i class="fas fa-hand-holding-heart"></i> Donation Form</div>
                        <div class="proj-widget-ha"><i class="fas fa-external-link-alt text-[9px]"></i> HelloAsso</div>
                    </div>
                    <iframe class="proj-widget-iframe" src="{{ e($project->helloasso_widget_url) }}" allowtransparency="true" loading="lazy" onload="this.classList.add('loaded')"></iframe>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-3 text-center py-20 text-gray-400">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-heart text-3xl text-orange-300"></i>
                </div>
                <p class="font-semibold" style="font-family:'Outfit',sans-serif;">No active projects yet.</p>
            </div>
            @endforelse
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             FISCAL CALCULATOR
             ══════════════════════════════════════════════════════════════ --}}
        <div class="reveal mb-16" id="fiscalCalc">
            <div class="text-center mb-8">
                <div class="section-pill mx-auto mb-4"><span class="dot"></span> Tax Benefit Simulator</div>
                <h3 class="text-2xl md:text-3xl font-black" style="font-family:'Cormorant Garamond',serif;color:#1c0e06;letter-spacing:-.02em;">How Much Does Your Gift Really Cost?</h3>
                <p class="text-gray-400 mt-2 max-w-sm mx-auto" style="font-family:'Outfit',sans-serif;font-size:.87rem;">Calculate your real donation cost after French tax deductions — in real time.</p>
            </div>

            <div class="calc-wrap">
                <div class="grid md:grid-cols-2">
                    <div class="p-8 md:p-10 space-y-7">
                        <div>
                            <p class="font-semibold text-slate-700 mb-3" style="font-family:'Outfit',sans-serif;font-size:.82rem;letter-spacing:.06em;text-transform:uppercase;">Your Tax Situation</p>
                            <div class="grid grid-cols-3 gap-3" id="calc-type-cards">
                                <div onclick="calcSetType('ir')" id="calc-card-ir" class="calc-type-card active">
                                    <div class="ctc-rate">66%</div>
                                    <div class="ctc-title">Individual</div>
                                    <div class="ctc-desc">Income tax reduction • Capped at 20% of taxable income</div>
                                </div>
                                <div onclick="calcSetType('ifi')" id="calc-card-ifi" class="calc-type-card">
                                    <div class="ctc-rate">75%</div>
                                    <div class="ctc-title">IFI</div>
                                    <div class="ctc-desc">Wealth tax reduction • Max €50,000/year</div>
                                </div>
                                <div onclick="calcSetType('is')" id="calc-card-is" class="calc-type-card">
                                    <div class="ctc-rate">60%</div>
                                    <div class="ctc-title">Company</div>
                                    <div class="ctc-desc">Corporate tax deduction • 0.5% revenue or €20K cap</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-700 mb-3" style="font-family:'Outfit',sans-serif;font-size:.82rem;letter-spacing:.06em;text-transform:uppercase;">Donation Amount</p>
                            <div class="grid grid-cols-4 gap-3 mb-4" id="calc-amt-btns">
                                <button onclick="calcSetAmount(20)"  data-amount="20"  class="calc-amt-btn">€20</button>
                                <button onclick="calcSetAmount(50)"  data-amount="50"  class="calc-amt-btn">€50</button>
                                <button onclick="calcSetAmount(100)" data-amount="100" class="calc-amt-btn">€100</button>
                                <button onclick="calcSetAmount(250)" data-amount="250" class="calc-amt-btn">€250</button>
                            </div>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-amber-500 font-bold" style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;">€</span>
                                <input id="calc-input" type="number" min="1" placeholder="Custom amount" oninput="calcOnInput(this.value)" class="calc-input w-full pl-9 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent placeholder-slate-300" style="font-family:'Outfit',sans-serif;font-weight:700;color:#1e293b;">
                            </div>
                            <p class="text-xs text-slate-400 mt-2" style="font-family:'Outfit',sans-serif;">Selected: <span id="calc-selected" class="font-bold" style="color:#d97706;">€0</span></p>
                        </div>

                        <div class="calc-info-box">
                            <p class="font-bold text-amber-800 mb-2 flex items-center gap-2" style="font-family:'Outfit',sans-serif;font-size:.82rem;"><i class="fas fa-lightbulb text-amber-400"></i> French Tax Deductions on Donations</p>
                            <ul class="space-y-1" style="font-family:'Outfit',sans-serif;font-size:.78rem;color:#92400e;">
                                <li class="flex items-center gap-2"><i class="fas fa-check text-amber-400 text-[10px]"></i> 66% for individual taxpayers</li>
                                <li class="flex items-center gap-2"><i class="fas fa-check text-amber-400 text-[10px]"></i> 75% for IFI (subject to conditions)</li>
                                <li class="flex items-center gap-2"><i class="fas fa-check text-amber-400 text-[10px]"></i> 60% for companies</li>
                            </ul>
                            <p class="mt-2.5 flex items-start gap-2" style="font-family:'Outfit',sans-serif;font-size:.75rem;color:#78716c;"><i class="fas fa-file-alt text-amber-400 mt-0.5 flex-shrink-0"></i> An official <strong>tax receipt</strong> is sent automatically after your donation.</p>
                        </div>
                    </div>

                    <div class="flex flex-col justify-center p-8 md:p-10" style="background:linear-gradient(145deg,#fdf6ec,#fef3e2);border-left:1px solid rgba(251,191,36,.15);">
                        <div class="calc-result-panel mb-6">
                            <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-[22px]">
                                <div style="position:absolute;top:14%;left:12%;width:2px;height:2px;background:rgba(251,191,36,.6);border-radius:50%;"></div>
                                <div style="position:absolute;top:22%;left:75%;width:1.5px;height:1.5px;background:rgba(254,215,170,.5);border-radius:50%;"></div>
                                <div style="position:absolute;top:65%;left:88%;width:2px;height:2px;background:rgba(251,191,36,.4);border-radius:50%;"></div>
                                <div style="position:absolute;top:80%;left:20%;width:1px;height:1px;background:rgba(254,215,170,.3);border-radius:50%;"></div>
                            </div>
                            <div class="relative z-10">
                                <p class="text-sm mb-1" style="font-family:'Outfit',sans-serif;font-weight:700;color:rgba(255,255,255,.45);text-transform:uppercase;letter-spacing:.1em;font-size:10px;"><i class="fas fa-hand-holding-heart mr-1" style="color:rgba(251,191,36,.5);"></i> Your gift actually costs</p>
                                <div id="calc-result-cout" class="calc-result-big mb-6">€0.00</div>
                                <div class="space-y-2" style="font-family:'Outfit',sans-serif;font-size:.8rem;color:rgba(255,255,255,.5);">
                                    <div class="flex justify-between items-center border-b border-white/10 pb-2">
                                        <span><i class="fas fa-coins mr-1.5" style="color:rgba(251,191,36,.5);"></i> Total donation</span>
                                        <span class="font-bold text-white/80"><span id="calc-res-don">€0</span></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span><i class="fas fa-piggy-bank mr-1.5" style="color:rgba(251,191,36,.5);"></i> Tax reduction</span>
                                        <span class="font-bold" style="color:#fbbf24;">− <span id="calc-res-reduction">€0.00</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-5 border border-amber-100 shadow-sm">
                            <p class="font-semibold text-slate-800 mb-1" style="font-family:'Outfit',sans-serif;font-size:.9rem;">👉 In practice</p>
                            <p class="text-slate-500 text-sm mb-4" style="font-family:'Outfit',sans-serif;line-height:1.65;">A gift of <strong id="calc-cta-don" class="text-slate-800">€0</strong> only costs you <strong id="calc-cta-cout" style="color:#d97706;">€0.00</strong> after tax deduction.</p>
                            <button onclick="document.getElementById('openHaDonate1').click()" class="donate-btn w-full justify-center text-sm py-3"><i class="fas fa-hand-holding-heart"></i> Donate Now</button>
                            <p class="text-center mt-3" style="font-family:'Outfit',sans-serif;font-size:10px;color:#94a3b8;"><i class="fas fa-receipt mr-1 text-orange-300"></i> Official tax receipt sent automatically</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             WAYS TO GIVE
             ══════════════════════════════════════════════════════════════ --}}
        <div class="reveal stagger-3">
            <div class="text-center mb-8">
                <div class="section-pill mx-auto mb-4"><span class="dot"></span> Ways to Give</div>
                <h3 class="text-2xl md:text-3xl font-black" style="font-family:'Cormorant Garamond',serif;color:#1c0e06;letter-spacing:-.02em;">Choose How You Give</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="ways-card ways-card-light p-8">
                    <div class="ways-icon bg-orange-100"><i class="fas fa-user text-orange-500 text-xl"></i></div>
                    <div class="section-pill mb-3" style="font-size:10px;background:rgba(249,115,22,.08);border-color:rgba(249,115,22,.15);"><i class="fas fa-heart text-orange-400 text-[9px]"></i> Individual</div>
                    <h3 class="text-lg font-black text-gray-900 mb-2" style="font-family:'Outfit',sans-serif;">Individual Donation</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-5" style="font-family:'Outfit',sans-serif;">Every euro goes directly to the field to support vulnerable children and families in Cambodia.</p>
                    <div class="space-y-2.5">
                        @foreach(['One-time donation','Monthly recurring','Donation in memoriam','Birthday fundraiser'] as $t)
                        <div class="flex items-center gap-2.5 text-sm text-gray-600" style="font-family:'Outfit',sans-serif;">
                            <span class="w-5 h-5 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0"><i class="fas fa-check text-orange-500 text-[9px]"></i></span>{{ $t }}
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="ways-card ways-card-dark p-8">
                    <div class="ways-icon" style="background:rgba(251,191,36,.1);"><i class="fas fa-building text-yellow-400 text-xl"></i></div>
                    <div class="section-pill mb-3" style="font-size:10px;background:rgba(251,191,36,.08);border-color:rgba(251,191,36,.2);color:#d97706;"><i class="fas fa-city text-[9px]"></i> Corporate</div>
                    <h3 class="text-lg font-black text-white mb-2" style="font-family:'Outfit',sans-serif;">Corporate Donation</h3>
                    <p class="text-white/55 text-sm leading-relaxed mb-5" style="font-family:'Outfit',sans-serif;">Tailored partnership packages with visibility, impact reports, and employee engagement.</p>
                    <div class="space-y-2.5">
                        @foreach(['Single or recurring gift','Skills-based sponsorship','Employee matching','Named project funding'] as $t)
                        <div class="flex items-center gap-2.5 text-sm text-white/70" style="font-family:'Outfit',sans-serif;">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0" style="background:rgba(251,191,36,.1);"><i class="fas fa-check text-[9px]" style="color:#fbbf24;"></i></span>{{ $t }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     PROJECT MODAL (Campaign Card Vignette)
     ══════════════════════════════════════════════════════════════ --}}
<div id="projModalBg" class="proj-modal-bg" onclick="closeProjModal(event)">
    <div class="proj-modal" id="projModal">
        <div class="proj-modal-head">
            <img src="" id="projModalImg" class="proj-modal-head-img" alt="">
            <div class="proj-modal-head-overlay">
                <div class="proj-badge mb-1.5" style="width:fit-content;background:linear-gradient(135deg,rgba(251,191,36,.9),rgba(249,115,22,.9));"><i class="fas fa-id-card text-[9px]"></i> Campaign Card</div>
                <div class="proj-modal-title" id="projModalTitle"></div>
            </div>
            <button class="proj-modal-close" onclick="closeProjModalDirect()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                    <line x1="6" y1="6" x2="18" y2="18" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="18" y1="6" x2="6" y2="18" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
        <div style="flex:1;overflow-y:auto;display:flex;flex-direction:column;align-items:center;padding:24px 16px;gap:14px;background:linear-gradient(180deg,#fdf6ec,#fef3e2);">
            <p style="font-family:'Outfit',sans-serif;font-size:12px;color:#64748b;text-align:center;max-width:320px;line-height:1.65;margin:0;">This <strong style="color:#1e293b;">live campaign card</strong> updates automatically with your HelloAsso fundraiser progress.</p>
            <div style="background:#fff;border-radius:18px;box-shadow:0 12px 40px rgba(0,0,0,.14);overflow:hidden;width:350px;max-width:100%;">
                <iframe id="projVignetteIframe" src="" allowtransparency="true" style="width:350px;height:450px;border:none;display:block;opacity:0;transition:opacity .4s;" onload="this.style.opacity=1"></iframe>
            </div>
        </div>
        <div class="proj-modal-foot">
            <span><i class="fas fa-lock" style="color:#22c55e;"></i> Secure</span>
            <span><i class="fas fa-receipt" style="color:#f97316;"></i> Receipt</span>
            <span><i class="fas fa-shield-alt" style="color:#3b82f6;"></i> SSL</span>
            <span><i class="fas fa-external-link-alt"></i> HelloAsso</span>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     GENERAL DONATION CTA
     ══════════════════════════════════════════════════════════════ --}}
<section class="py-16 md:py-24" style="background:#fef9f0;">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <div class="donate-cta-box reveal">
            <div class="relative z-10">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg" style="animation:heartBeat 2.5s ease infinite;box-shadow:0 8px 24px rgba(251,191,36,.2);">
                    <i class="fas fa-heart text-2xl" style="color:#f97316;"></i>
                </div>
                <div class="section-pill mx-auto mb-4" style="font-size:11px;"><span class="dot"></span> General Fund</div>
                <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-3" style="font-family:'Cormorant Garamond',serif;letter-spacing:-.02em;">Make a General Donation</h2>
                <p class="text-gray-500 text-base mb-8 max-w-xs mx-auto leading-relaxed" style="font-family:'Outfit',sans-serif;">Support where the need is greatest — funds go to the most urgent programs.</p>
                <div class="flex justify-center mb-6">
                    <button id="openHaDonate1" class="donate-btn"><i class="fas fa-hand-holding-heart"></i> Donate Now</button>
                </div>
                <div class="secure-row mb-4">
                    <span><i class="fas fa-lock text-green-500"></i> Secure</span>
                    <span><i class="fas fa-shield-alt text-blue-500"></i> SSL</span>
                    <span><i class="fas fa-receipt text-orange-400"></i> Receipt</span>
                </div>
                <span class="helloasso-badge"><i class="fas fa-external-link-alt text-[10px]"></i> Powered by HelloAsso</span>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     BOTTOM CTA BANNER
     ══════════════════════════════════════════════════════════════ --}}
<section style="background:#fef9f0;padding-bottom:4rem;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="rounded-2xl md:rounded-3xl p-8 md:p-14 relative overflow-hidden reveal" style="background:linear-gradient(135deg,#0f172a 0%,#162041 55%,#1e2d5a 100%);">
            <div class="absolute inset-0" style="background-image:url('{{ asset('images/cambodia.svg') }}');background-size:cover;opacity:.07;"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-6">
                <div class="text-white text-center lg:text-left">
                    <p style="font-family:'Outfit',sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(251,191,36,.55);margin-bottom:10px;"><i class="fas fa-star mr-1"></i> Make an Impact</p>
                    <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;color:#fff;line-height:1.08;letter-spacing:-.02em;margin-bottom:10px;">Make a Difference <em style="font-style:italic;background:linear-gradient(90deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Today</em></h2>
                    <p style="font-family:'Outfit',sans-serif;color:rgba(255,255,255,.5);font-size:.9rem;max-width:420px;line-height:1.78;">Your support funds programs that change children's lives in Cambodia.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}" style="display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:16px 28px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#0f172a;font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:800;border-radius:14px;text-decoration:none;box-shadow:0 8px 28px rgba(251,191,36,.3);transition:transform .2s,box-shadow .2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 16px 40px rgba(251,191,36,.45)'" onmouseout="this.style.transform='';this.style.boxShadow='0 8px 28px rgba(251,191,36,.3)'"><i class="fas fa-heart"></i> Sponsor a Child</a>
                    <button id="openHaDonate2" style="display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:16px 28px;background:rgba(251,191,36,.08);border:1.5px solid rgba(251,191,36,.32);color:rgba(255,255,255,.85);font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:700;border-radius:14px;cursor:pointer;transition:background .2s,border-color .2s;" onmouseover="this.style.background='rgba(251,191,36,.16)';this.style.borderColor='rgba(251,191,36,.6)'" onmouseout="this.style.background='rgba(251,191,36,.08)';this.style.borderColor='rgba(251,191,36,.32)'"><i class="fas fa-hand-holding-heart"></i> Make a Donation</button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     HELLOASSO WIDGET MODAL
     ══════════════════════════════════════════════════════════════ --}}
<div id="haWidgetModalDonate" style="position:fixed;inset:0;display:none;align-items:center;justify-content:center;backdrop-filter:blur(16px) brightness(0.45) saturate(1.2);z-index:2147483647;padding:16px;">
    <button id="closeHaDonateBtn" style="position:absolute;top:.75rem;right:1.25rem;z-index:2147483648;background:#EFEFF4;border:none;border-radius:50%;width:44px;height:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 12px rgba(0,0,0,.12);transition:background .18s;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <line x1="6" y1="6" x2="18" y2="18" stroke="#333" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="18" y1="6" x2="6" y2="18" stroke="#333" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
    </button>
    <div style="position:relative;width:100%;max-width:950px;height:100%;max-height:90vh;overflow:hidden;border-radius:16px;box-shadow:0 40px 100px rgba(0,0,0,.4);">
        <iframe id="haWidget" src="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1/widget?view=overlay" style="width:100%;height:100%;border:none;"></iframe>
    </div>
</div>

<script>
/* ═══ CONSTELLATION + RISING EMBERS (warm ember-gold over mahogany) ═══ */
(function(){
    var c = document.getElementById('constellationCanvas');
    if(!c) return;
    var ctx = c.getContext('2d'), W = 0, H = 0, particles = [], embers = [];

    function resize(){
        var hero = c.parentElement;
        W = c.width  = hero.offsetWidth;
        H = c.height = hero.offsetHeight;
    }
    window.addEventListener('resize', resize);
    setTimeout(resize, 50);

    var count = Math.min(70, Math.floor(window.innerWidth / 22));
    for (var i = 0; i < count; i++){
        particles.push({
            x: Math.random() * window.innerWidth,
            y: Math.random() * window.innerHeight,
            vx: (Math.random() - .5) * .28,
            vy: (Math.random() - .5) * .28,
            r: Math.random() * 1.6 + .5,
            /* warm amber vs ember-orange — no cold tones */
            warm: Math.random() < .5
        });
    }

    function spawnEmber(){
        embers.push({
            x: Math.random() * (W || window.innerWidth),
            y: (H || window.innerHeight) + 10,
            vy: -(Math.random() * .7 + .35),
            vx: (Math.random() - .5) * .28,
            r: Math.random() * 2.2 + 1,
            life: 1,
            decay: .0016 + Math.random() * .002,
            wobble: Math.random() * Math.PI * 2,
            wobbleSpeed: .014 + Math.random() * .022
        });
    }
    setInterval(spawnEmber, 680);
    for (var k = 0; k < 8; k++) spawnEmber();

    function draw(){
        ctx.clearRect(0, 0, W, H);

        particles.forEach(function(p){
            p.x += p.vx; p.y += p.vy;
            if (p.x < 0 || p.x > W) p.vx *= -1;
            if (p.y < 0 || p.y > H) p.vy *= -1;
        });

        for (var i = 0; i < particles.length; i++){
            for (var j = i + 1; j < particles.length; j++){
                var dx = particles[i].x - particles[j].x;
                var dy = particles[i].y - particles[j].y;
                var dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 140){
                    var op = (1 - dist / 140) * .20;
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    /* warm orange connector lines */
                    ctx.strokeStyle = 'rgba(249,115,22,' + op + ')';
                    ctx.lineWidth = .7;
                    ctx.stroke();
                }
            }
        }

        particles.forEach(function(p){
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            /* amber vs peach — all warm, zero blue */
            ctx.fillStyle = p.warm ? 'rgba(251,191,36,.90)' : 'rgba(254,180,120,.85)';
            ctx.fill();

            var g = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.r * 4);
            g.addColorStop(0, p.warm ? 'rgba(251,191,36,.32)' : 'rgba(249,115,22,.28)');
            g.addColorStop(1, 'transparent');
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r * 4, 0, Math.PI * 2);
            ctx.fillStyle = g;
            ctx.fill();
        });

        embers = embers.filter(function(e){
            e.y += e.vy;
            e.wobble += e.wobbleSpeed;
            e.x += e.vx + Math.sin(e.wobble) * .35;
            e.life -= e.decay;
            if (e.life <= 0 || e.y < -20) return false;

            var glow = ctx.createRadialGradient(e.x, e.y, 0, e.x, e.y, e.r * 7);
            glow.addColorStop(0, 'rgba(249,115,22,' + (e.life * .65) + ')');
            glow.addColorStop(.4, 'rgba(251,191,36,' + (e.life * .30) + ')');
            glow.addColorStop(1, 'transparent');
            ctx.beginPath();
            ctx.arc(e.x, e.y, e.r * 7, 0, Math.PI * 2);
            ctx.fillStyle = glow;
            ctx.fill();

            ctx.beginPath();
            ctx.arc(e.x, e.y, e.r, 0, Math.PI * 2);
            /* ember core — warm peach/gold */
            ctx.fillStyle = 'rgba(255,210,150,' + e.life + ')';
            ctx.fill();

            return true;
        });

        requestAnimationFrame(draw);
    }
    draw();
})();

/* ═══ PROJECT MODAL ═══ */
function openProjModalTab(card){
    var vigUrl=card.getAttribute('data-vignette')||'';if(!vigUrl)return;
    document.getElementById('projModalTitle').textContent=card.getAttribute('data-title');
    document.getElementById('projModalImg').src=card.getAttribute('data-img');
    var vi=document.getElementById('projVignetteIframe');vi.style.opacity='0';if(vi.src!==vigUrl)vi.src=vigUrl;
    document.getElementById('projModalBg').classList.add('open');document.body.style.overflow='hidden';
}
function closeProjModalDirect(){document.getElementById('projModalBg').classList.remove('open');document.getElementById('projVignetteIframe').src='';document.body.style.overflow='';}
function closeProjModal(e){if(e.target===document.getElementById('projModalBg'))closeProjModalDirect();}
document.addEventListener('keydown',function(e){if(e.key==='Escape'){closeProjModalDirect();closeHaDonate();}});

/* ═══ CARD REVEAL ═══ */
(function(){
    var cards=document.querySelectorAll('.proj-card');
    var obs=new IntersectionObserver(function(entries){entries.forEach(function(entry){if(entry.isIntersecting){var delay=Array.from(cards).indexOf(entry.target)*110;setTimeout(function(){entry.target.classList.add('card-visible');},delay);obs.unobserve(entry.target);}});},{threshold:.05});
    cards.forEach(function(c){obs.observe(c);});
})();

/* ═══ REVEAL ON SCROLL ═══ */
(function(){
    var els=document.querySelectorAll('.reveal');
    var obs=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('visible');obs.unobserve(e.target);}});},{threshold:.08,rootMargin:'0px 0px -50px 0px'});
    els.forEach(function(el){obs.observe(el);});
})();

/* ═══ HELLOASSO IFRAME AUTO-RESIZE ═══ */
window.addEventListener('message',function(e){
    if(!e.data)return;var h=null;
    if(typeof e.data==='object')h=e.data.height||e.data.newHeight||null;
    if(typeof e.data==='string'){try{var p=JSON.parse(e.data);h=p.height||p.newHeight;}catch(x){}}
    if(h&&h>100){document.querySelectorAll('.proj-widget-iframe').forEach(function(iframe){if(!iframe.dataset.manualHeight)iframe.style.height=Math.ceil(h)+'px';});}
});

/* ═══ HELLOASSO WIDGET MODAL ═══ */
document.addEventListener('DOMContentLoaded',function(){
    var modal=document.getElementById('haWidgetModalDonate');
    var closeBtn=document.getElementById('closeHaDonateBtn');
    function openModal(){modal.style.display='flex';document.body.style.overflow='hidden';}
    function closeModal(){modal.style.display='none';document.body.style.overflow='';}
    window.closeHaDonate=closeModal;
    document.getElementById('openHaDonate1')?.addEventListener('click',openModal);
    document.getElementById('openHaDonate2')?.addEventListener('click',openModal);
    closeBtn.addEventListener('click',closeModal);
    closeBtn.addEventListener('mouseenter',function(){closeBtn.style.background='#E0E0E8';});
    closeBtn.addEventListener('mouseleave',function(){closeBtn.style.background='#EFEFF4';});
    modal.addEventListener('click',function(e){if(e.target===modal)closeModal();});
});

/* ═══ FISCAL CALCULATOR ═══ */
(function(){
    var currentType='ir',currentAmount=0;
    var rates={ir:0.66,ifi:0.75,is:0.60};
    window.calcSetType=function(type){currentType=type;['ir','ifi','is'].forEach(function(t){var card=document.getElementById('calc-card-'+t);if(t===type)card.classList.add('active');else card.classList.remove('active');});calcUpdate();};
    window.calcSetAmount=function(amount){currentAmount=amount;document.getElementById('calc-input').value=amount;calcHighlightBtn(amount);calcUpdate();};
    window.calcOnInput=function(val){var parsed=parseFloat(val);currentAmount=isNaN(parsed)?0:parsed;calcHighlightBtn(currentAmount);calcUpdate();};
    function calcHighlightBtn(amount){document.querySelectorAll('#calc-amt-btns .calc-amt-btn').forEach(function(btn){if(parseInt(btn.dataset.amount)===amount)btn.classList.add('active');else btn.classList.remove('active');});}
    function calcUpdate(){var taux=rates[currentType]||0.66,reduction=currentAmount*taux,cout=currentAmount-reduction;document.getElementById('calc-result-cout').textContent='€'+cout.toFixed(2);document.getElementById('calc-res-don').textContent='€'+currentAmount;document.getElementById('calc-res-reduction').textContent='€'+reduction.toFixed(2);document.getElementById('calc-selected').textContent='€'+currentAmount;document.getElementById('calc-cta-don').textContent='€'+currentAmount;document.getElementById('calc-cta-cout').textContent='€'+cout.toFixed(2);}
    calcUpdate();
})();
</script>
@endsection