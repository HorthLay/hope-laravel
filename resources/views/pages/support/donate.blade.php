{{-- resources/views/pages/support/donate.blade.php --}}
@extends('layouts.app')
@section('title', 'Make a Donation')

@section('content')
<style>
/* ══════════════════════════════════════════
   KEYFRAMES
══════════════════════════════════════════ */
@keyframes fadeUp     { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeIn     { from{opacity:0} to{opacity:1} }
@keyframes pulse-soft { 0%,100%{transform:scale(1)} 50%{transform:scale(1.06)} }
@keyframes float      { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
@keyframes shimmer    { from{background-position:-200% 0} to{background-position:200% 0} }
@keyframes cardIn     { from{opacity:0;transform:translateY(32px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }
@keyframes slideUp    { from{opacity:0;transform:translateY(40px)} to{opacity:1;transform:translateY(0)} }
@keyframes popIn      { 0%{opacity:0;transform:scale(.85)} 70%{transform:scale(1.03)} 100%{opacity:1;transform:scale(1)} }
@keyframes heartBeat  { 0%,100%{transform:scale(1)} 25%{transform:scale(1.15)} 40%{transform:scale(1)} 60%{transform:scale(1.1)} }
@keyframes orb1       { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(40px,-30px) scale(1.1)} }
@keyframes orb2       { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(-30px,20px) scale(.9)} }
@keyframes orb3       { 0%,100%{transform:translate(0,0)} 50%{transform:translate(20px,25px)} }
@keyframes dotPulse   { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.6);opacity:.4} }
@keyframes borderFlow { 0%{border-color:rgba(249,115,22,.3)} 50%{border-color:rgba(249,115,22,.8)} 100%{border-color:rgba(249,115,22,.3)} }

/* ── Reveal scroll animations ── */
.reveal       {opacity:0;transform:translateY(28px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal-left  {opacity:0;transform:translateX(-36px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal-right {opacity:0;transform:translateX(36px); transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal-scale {opacity:0;transform:scale(.93);       transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal.visible,.reveal-left.visible,.reveal-right.visible,.reveal-scale.visible{opacity:1;transform:none}
.stagger-1{transition-delay:.06s}.stagger-2{transition-delay:.13s}.stagger-3{transition-delay:.20s}
.stagger-4{transition-delay:.27s}.stagger-5{transition-delay:.34s}.stagger-6{transition-delay:.41s}

/* ══════════════════════════════════════════
   HERO
══════════════════════════════════════════ */
.page-hero{position:relative;overflow:hidden;background:#0a1628;min-height:420px;display:flex;align-items:center;}
.page-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;filter:brightness(.35) saturate(1.2);transition:transform 10s ease;transform-origin:center;}
.page-hero:hover .page-hero-bg{transform:scale(1.06);}
.page-hero-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,22,40,.9) 0%,rgba(10,22,40,.5) 50%,rgba(249,115,22,.12) 100%);}

/* Animated orbs */
.hero-orb{position:absolute;border-radius:50%;filter:blur(60px);pointer-events:none;}
.hero-orb-1{width:400px;height:400px;background:rgba(249,115,22,.12);top:-100px;right:-80px;animation:orb1 8s ease-in-out infinite;}
.hero-orb-2{width:300px;height:300px;background:rgba(245,158,11,.08);bottom:-60px;left:10%;animation:orb2 10s ease-in-out infinite;}
.hero-orb-3{width:200px;height:200px;background:rgba(249,115,22,.06);top:40%;left:30%;animation:orb3 12s ease-in-out infinite;}

.page-hero-content{position:relative;z-index:2;padding:88px 20px 80px;max-width:1280px;margin:0 auto;width:100%;}

.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:20px;}
.breadcrumb a{color:rgba(255,255,255,.5);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:rgba(249,115,22,.9);}
.breadcrumb span{color:rgba(255,255,255,.85);}
.breadcrumb i{color:rgba(255,255,255,.25);}

/* ── Shared pills ── */
.pill{display:inline-flex;align-items:center;gap:6px;padding:6px 16px;border-radius:999px;font-size:11px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;}
.wave-divider{line-height:0;overflow:hidden;}.wave-divider svg{display:block;}

/* ── Stats row ── */
.hero-stats{display:flex;gap:32px;flex-wrap:wrap;margin-top:40px;}
.hero-stat-num{font-size:1.75rem;font-weight:900;color:#fff;line-height:1;letter-spacing:-.02em;}
.hero-stat-label{font-size:11px;font-weight:700;color:rgba(255,255,255,.45);text-transform:uppercase;letter-spacing:.08em;margin-top:3px;}
.hero-stat-divider{width:1px;background:rgba(255,255,255,.1);align-self:stretch;flex-shrink:0;}

/* ══════════════════════════════════════════
   SECTION HEADER
══════════════════════════════════════════ */
.section-pill{
    display:inline-flex;align-items:center;gap:7px;
    padding:7px 18px;border-radius:999px;
    background:linear-gradient(135deg,rgba(249,115,22,.12),rgba(245,158,11,.08));
    border:1px solid rgba(249,115,22,.2);
    font-size:11px;font-weight:800;letter-spacing:.07em;text-transform:uppercase;
    color:#ea580c;margin-bottom:14px;
}
.section-pill .dot{width:6px;height:6px;border-radius:50%;background:#f97316;animation:dotPulse 1.8s ease-in-out infinite;}

/* ══════════════════════════════════════════
   PROJECT CARDS
══════════════════════════════════════════ */
.proj-card{
    background:#fff;border-radius:22px;overflow:hidden;
    border:1px solid rgba(241,245,249,.8);
    box-shadow:0 4px 24px rgba(0,0,0,.07),0 1px 3px rgba(0,0,0,.05);
    transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s;
    cursor:pointer;
    opacity:0;transform:translateY(32px) scale(.97);
    will-change:transform;
}
.proj-card.card-visible{animation:cardIn .65s cubic-bezier(.16,1,.3,1) both;opacity:1;transform:none;}
.proj-card:hover{transform:translateY(-7px) scale(1.01);box-shadow:0 20px 56px rgba(0,0,0,.14),0 4px 12px rgba(0,0,0,.06);}

/* Image zone */
.proj-img-wrap{position:relative;height:260px;overflow:hidden;}
.proj-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .7s cubic-bezier(.16,1,.3,1);}
.proj-card:hover .proj-img-wrap img{transform:scale(1.08);}
.proj-img-overlay{
    position:absolute;inset:0;
    background:linear-gradient(to top,rgba(10,20,30,.82) 0%,rgba(10,20,30,.2) 55%,transparent 100%);
    display:flex;flex-direction:column;justify-content:flex-end;padding:16px 18px;
}

/* Shimmer loading skeleton */
.proj-img-wrap::before{
    content:'';position:absolute;inset:0;z-index:1;
    background:linear-gradient(90deg,transparent 0%,rgba(255,255,255,.06) 50%,transparent 100%);
    background-size:200% 100%;
    animation:shimmer 2s infinite;
    pointer-events:none;
    opacity:0;transition:opacity .3s;
}
.proj-card:hover .proj-img-wrap::before{opacity:1;}

.proj-badge{
    display:inline-flex;align-items:center;gap:4px;
    background:rgba(249,115,22,.95);color:#fff;
    font-size:9px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;
    padding:4px 10px;border-radius:999px;margin-bottom:7px;width:fit-content;
    box-shadow:0 2px 8px rgba(249,115,22,.4);
}
.proj-img-title{color:#fff;font-size:.92rem;font-weight:900;line-height:1.3;margin:0;text-shadow:0 1px 8px rgba(0,0,0,.4);}

/* Body */
.proj-body{padding:18px 20px 20px;}
.proj-tags{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:11px;}
.proj-tag{
    display:inline-flex;align-items:center;gap:3px;
    background:#f8fafc;border:1px solid #e8edf2;
    color:#64748b;font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;
    transition:background .15s,border-color .15s;
}
.proj-tag:hover{background:#fff7ed;border-color:#fed7aa;color:#c2410c;}
.proj-desc{color:#64748b;font-size:.82rem;line-height:1.65;margin-bottom:14px;}

/* Buttons */
.proj-actions{display:flex;gap:7px;}
.proj-btn-donate{
    flex:1;display:flex;align-items:center;justify-content:center;gap:7px;
    padding:12px 14px;
    background:linear-gradient(135deg,#f97316,#f59e0b);
    color:#fff;font-size:.78rem;font-weight:900;letter-spacing:.05em;text-transform:uppercase;
    border-radius:12px;border:none;cursor:pointer;
    box-shadow:0 4px 16px rgba(249,115,22,.35);
    transition:transform .2s,box-shadow .2s,filter .2s;
    position:relative;overflow:hidden;
}
.proj-btn-donate::after{
    content:'';position:absolute;inset:0;
    background:linear-gradient(135deg,transparent 0%,rgba(255,255,255,.15) 50%,transparent 100%);
    transform:translateX(-100%);transition:transform .4s;
}
.proj-btn-donate:hover::after{transform:translateX(100%);}
.proj-btn-donate:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(249,115,22,.48);filter:brightness(1.05);}

.proj-btn-card{
    flex:0 0 auto;display:flex;align-items:center;justify-content:center;
    width:44px;
    background:linear-gradient(135deg,#1e293b,#0f172a);
    color:rgba(255,255,255,.75);font-size:.85rem;
    border-radius:12px;border:none;cursor:pointer;
    box-shadow:0 4px 14px rgba(15,23,42,.22);
    transition:transform .2s,box-shadow .2s,color .2s;
}
.proj-btn-card:hover{transform:translateY(-2px);box-shadow:0 7px 20px rgba(15,23,42,.35);color:#fb923c;}

/* ══════════════════════════════════════════
   WAYS TO GIVE
══════════════════════════════════════════ */
.ways-card{
    border-radius:22px;overflow:hidden;
    transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s;
    position:relative;
}
.ways-card:hover{transform:translateY(-5px);}
.ways-card-light{background:#fff;border:2px solid #fed7aa;box-shadow:0 4px 24px rgba(249,115,22,.08);}
.ways-card-light:hover{box-shadow:0 16px 48px rgba(249,115,22,.15);}
.ways-card-dark{background:linear-gradient(145deg,#0f1f2e,#1a2f42);border:1px solid rgba(255,255,255,.06);box-shadow:0 4px 24px rgba(0,0,0,.2);}
.ways-card-dark:hover{box-shadow:0 16px 48px rgba(0,0,0,.35);}
.ways-icon{width:52px;height:52px;border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;}

/* ══════════════════════════════════════════
   GENERAL DONATE BOX
══════════════════════════════════════════ */
.donate-cta-box{
    position:relative;overflow:hidden;
    background:linear-gradient(145deg,#fff7ed,#fffbeb,#fff7ed);
    border:2px solid #fed7aa;border-radius:28px;padding:56px 32px;text-align:center;
}
.donate-cta-box::before{
    content:'';position:absolute;inset:-50%;
    background:conic-gradient(from 0deg,transparent 0%,rgba(249,115,22,.04) 25%,transparent 50%,rgba(245,158,11,.04) 75%,transparent 100%);
    animation:orb1 12s linear infinite;
    border-radius:50%;
}

/* ── Main CTA button ── */
.donate-btn{
    display:inline-flex;align-items:center;justify-content:center;gap:10px;
    padding:18px 44px;
    background:linear-gradient(135deg,#f97316,#f59e0b);
    color:#fff;font-size:1rem;font-weight:900;letter-spacing:.04em;text-transform:uppercase;
    border-radius:16px;border:none;cursor:pointer;
    box-shadow:0 8px 32px rgba(249,115,22,.45);
    transition:transform .25s,box-shadow .25s,filter .25s;
    position:relative;overflow:hidden;
}
.donate-btn::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,transparent,rgba(255,255,255,.18),transparent);transform:translateX(-100%);transition:transform .5s;}
.donate-btn:hover::after{transform:translateX(100%);}
.donate-btn:hover{transform:translateY(-3px) scale(1.02);box-shadow:0 16px 44px rgba(249,115,22,.55);filter:brightness(1.06);color:#fff;}
.donate-btn:active{transform:translateY(0) scale(.99);}

.helloasso-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:999px;background:#f1f5f9;font-size:11px;font-weight:700;color:#64748b;border:1px solid #e2e8f0;}
.secure-row{display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;font-size:12px;font-weight:600;color:#94a3b8;}
.secure-row span{display:flex;align-items:center;gap:5px;}

/* ══════════════════════════════════════════
   MODAL
══════════════════════════════════════════ */
.proj-modal-bg{
    position:fixed;inset:0;z-index:2147483647;display:none;
    align-items:center;justify-content:center;
    backdrop-filter:blur(16px) brightness(.38) saturate(1.2);
    padding:16px;
}
.proj-modal-bg.open{display:flex;animation:fadeIn .25s ease both;}
.proj-modal{
    background:#fff;border-radius:24px;overflow:hidden;
    width:100%;max-width:880px;max-height:92vh;
    display:flex;flex-direction:column;
    box-shadow:0 40px 100px rgba(0,0,0,.45),0 0 0 1px rgba(255,255,255,.06);
    animation:popIn .38s cubic-bezier(.16,1,.3,1) both;
}

/* Header */
.proj-modal-head{flex-shrink:0;position:relative;height:150px;overflow:hidden;}
.proj-modal-head-img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform 8s ease;}
.proj-modal-bg.open .proj-modal-head-img{transform:scale(1.04);}
.proj-modal-head-overlay{
    position:absolute;inset:0;
    background:linear-gradient(135deg,rgba(10,20,30,.88) 0%,rgba(10,20,30,.45) 55%,rgba(249,115,22,.08) 100%);
    display:flex;flex-direction:column;justify-content:flex-end;padding:16px 22px;
}
.proj-modal-title{color:#fff;font-size:1rem;font-weight:900;line-height:1.3;padding-right:52px;text-shadow:0 1px 8px rgba(0,0,0,.5);}
.proj-modal-close{
    position:absolute;top:12px;right:12px;z-index:10;
    width:38px;height:38px;background:rgba(255,255,255,.12);backdrop-filter:blur(8px);
    border:1px solid rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;
    cursor:pointer;transition:background .18s,transform .18s;
}
.proj-modal-close:hover{background:rgba(255,255,255,.25);transform:scale(1.1);}

/* Tabs */
.modal-tabs{
    display:flex;flex-shrink:0;
    background:#f8fafc;border-bottom:1.5px solid #f1f5f9;
    padding:0 20px;overflow-x:auto;-webkit-overflow-scrolling:touch;
}
.modal-tab{
    display:flex;align-items:center;gap:6px;
    padding:12px 16px;font-size:12px;font-weight:800;
    color:#94a3b8;border:none;background:transparent;cursor:pointer;
    border-bottom:2.5px solid transparent;margin-bottom:-1.5px;
    transition:color .18s,border-color .18s;white-space:nowrap;flex-shrink:0;
}
.modal-tab:hover{color:#f97316;}
.modal-tab.active{color:#f97316;border-bottom-color:#f97316;}
.modal-pane{display:none;flex:1;flex-direction:column;min-height:0;overflow:hidden;}
.modal-pane.active{display:flex;animation:fadeIn .22s ease both;}

/* Donate pane */
.proj-modal-iframe{flex:1;border:none;width:100%;min-height:480px;}

/* Vignette pane */
.vignette-pane{
    flex:1;overflow-y:auto;display:flex;flex-direction:column;
    align-items:center;padding:28px 20px 24px;gap:18px;
    background:linear-gradient(180deg,#f0f4f8 0%,#e8edf5 100%);
}
.vignette-label{
    font-size:12px;color:#64748b;text-align:center;max-width:340px;line-height:1.65;
}
.vignette-label strong{color:#1e293b;}
.vignette-card-wrap{
    background:#fff;border-radius:18px;
    box-shadow:0 12px 40px rgba(0,0,0,.14),0 2px 8px rgba(0,0,0,.06);
    overflow:hidden;width:350px;max-width:100%;
    animation:slideUp .45s cubic-bezier(.16,1,.3,1) both;animation-delay:.1s;
}
.vignette-card-wrap iframe{display:block;}

/* Modal footer */
.proj-modal-foot{
    padding:10px 18px;background:#f8fafc;border-top:1px solid #f1f5f9;
    display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;flex-shrink:0;
}
.proj-modal-foot span{font-size:11px;color:#94a3b8;font-weight:700;display:flex;align-items:center;gap:4px;}

/* ══════════════════════════════════════════
   INLINE WIDGET — always visible, auto-height
══════════════════════════════════════════ */
.proj-widget-wrap{
    border-top:1px solid #f1f5f9;
    background:#f8fafc;
    overflow:hidden;
}
.proj-widget-bar{
    display:flex;align-items:center;justify-content:space-between;
    padding:9px 16px;
    background:linear-gradient(135deg,#1e293b,#0f172a);
}
.proj-widget-label{
    display:flex;align-items:center;gap:6px;
    font-size:10px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;
    color:rgba(255,255,255,.6);
}
.proj-widget-label i{color:#f97316;}
.proj-widget-ha{
    font-size:10px;font-weight:700;color:rgba(255,255,255,.3);
    display:flex;align-items:center;gap:4px;
}
.proj-widget-iframe{
    display:block;
    width:100%;
    border:none;
    /* No fixed height — grows with content via JS */
    height:550px;
    min-height:300px;
    opacity:0;
    transition:opacity .4s ease;
}
.proj-widget-iframe.loaded{opacity:1;}

/* Card: no hover lift since it embeds a form */
.proj-card{cursor:default !important;}
.proj-card:hover{transform:none !important;box-shadow:0 4px 24px rgba(0,0,0,.07),0 1px 3px rgba(0,0,0,.05) !important;}

/* Campaign card button stays, but no donate button row needed */
.proj-card-btn{
    display:inline-flex;align-items:center;gap:6px;
    padding:7px 14px;border-radius:10px;
    background:linear-gradient(135deg,#1e293b,#0f172a);
    color:rgba(255,255,255,.7);font-size:11px;font-weight:700;
    border:none;cursor:pointer;
    box-shadow:0 3px 12px rgba(15,23,42,.2);
    transition:transform .18s,color .18s,box-shadow .18s;
}
.proj-card-btn:hover{transform:translateY(-1px);color:#fb923c;box-shadow:0 6px 18px rgba(15,23,42,.3);}

/* ══════════════════════════════════════════
   MOBILE RESPONSIVE  ≤640px
══════════════════════════════════════════ */
@media(max-width:640px){
    /* Hero */
    .page-hero{min-height:320px;}
    .page-hero-content{padding:60px 16px 52px;}
    .hero-stats{gap:20px;margin-top:28px;}
    .hero-stat-num{font-size:1.4rem;}
    .hero-orb-1,.hero-orb-2,.hero-orb-3{display:none;}

    /* Section titles */
    .project-section-title{font-size:1.5rem !important;}
    .project-section-sub{font-size:.875rem !important;margin-bottom:24px !important;}

    /* Grid: single column */
    .proj-img-wrap{height:185px;}
    .proj-body{padding:14px 15px 16px;}
    .proj-btn-donate{font-size:.75rem;padding:11px 10px;}
    .proj-btn-card{width:40px;}

    /* Modal: bottom sheet */
    .proj-modal-bg{align-items:flex-end;padding:0;}
    .proj-modal{
        max-height:92vh;border-radius:22px 22px 0 0;
        width:100%;max-width:100%;
    }
    .proj-modal-head{height:120px;}
    .proj-modal-title{font-size:.9rem;}
    .proj-modal-iframe{min-height:400px;}
    .modal-tab{padding:10px 13px;font-size:11px;}
    .proj-modal-foot{gap:10px;padding:8px 14px;}
    .proj-modal-foot span{font-size:10px;}

    /* Vignette full-width */
    .vignette-pane{padding:20px 12px 16px;gap:14px;}
    .vignette-card-wrap{width:100%;}
    .vignette-card-wrap iframe{width:100% !important;}

    /* Card widget mobile height */
    .proj-widget-iframe{height:480px;min-height:300px;}
    .proj-img-wrap{height:220px;}
    .donate-btn{padding:16px 28px;font-size:.9rem;width:100%;max-width:280px;}

    /* Ways to give */
    .ways-icon{width:44px;height:44px;border-radius:14px;}

    /* Bottom banner */
    .cta-banner-inner{flex-direction:column;text-align:center;}
    .cta-banner-inner .cta-btns{width:100%;}
    .cta-banner-inner .cta-btns a,
    .cta-banner-inner .cta-btns button{width:100%;justify-content:center;}
}

@media(max-width:380px){
    .proj-desc{display:none;}
    .hero-stats{display:none;}
}
</style>

{{-- ══ HERO ══ --}}
<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="page-hero-overlay"></div>
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>
    <div class="page-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Support Us</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Make a Donation</span>
        </nav>

        <div class="section-pill mb-5" style="animation:fadeUp .6s ease both;border-color:rgba(249,115,22,.3);">
            <span class="dot"></span> Give Today
        </div>

        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white leading-tight mb-4 max-w-2xl"
            style="animation:fadeUp .8s ease both;letter-spacing:-.02em;">
            Every Gift<br>
            <span style="background:linear-gradient(90deg,#f97316,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Changes a Life</span>
        </h1>

        <p class="text-base md:text-lg text-white/70 font-medium max-w-lg leading-relaxed"
           style="animation:fadeUp .8s .15s ease both">
            Individuals and companies — every contribution makes a real difference for children in Cambodia.
        </p>

        <div class="hero-stats" style="animation:fadeUp .8s .28s ease both">
            <div>
                <div class="hero-stat-num">{{ number_format($donationProjects->count()) }}</div>
                <div class="hero-stat-label">Active Projects</div>
            </div>
            <div class="hero-stat-divider"></div>
            <div>
                <div class="hero-stat-num">100%</div>
                <div class="hero-stat-label">To the Field</div>
            </div>
            <div class="hero-stat-divider"></div>
            <div>
                <div class="hero-stat-num">🇰🇭</div>
                <div class="hero-stat-label">Cambodia</div>
            </div>
        </div>
    </div>
</section>

<div class="wave-divider" style="background:linear-gradient(180deg,#f0f4f8,#e8edf2)">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,40 C480,70 960,10 1440,40 L1440,0 L0,0 Z" fill="#0a1628"/>
    </svg>
</div>

{{-- ══ FUNDRAISING PROJECTS ══ --}}
<section class="py-16 md:py-28" style="background:linear-gradient(180deg,#f0f4f8 0%,#e8edf2 100%);">
    <div class="max-w-6xl mx-auto px-4">

        <div class="text-center mb-12 reveal">
            <div class="section-pill mx-auto mb-4">
                <span class="dot"></span> Active Campaigns
            </div>
            <h2 class="project-section-title text-2xl md:text-4xl font-black" style="color:#1e3a4a;margin-bottom:8px;">
                Support a Specific Project
            </h2>
            <p class="project-section-sub text-gray-500 max-w-md mx-auto">
                Tap any card to open the donation form — secure, fast, and transparent.
            </p>
        </div>

        {{-- PROJECT GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16" id="projectGrid">

            @forelse($donationProjects as $project)
            @php
                $imgUrl     = $project->image ? asset($project->image) : asset('images/children/image-1.jpg');
                $badgeStyle = match($project->badge_color ?? 'orange') {
                    'green' => 'background:linear-gradient(135deg,rgba(34,197,94,.95),rgba(22,163,74,.95))',
                    'blue'  => 'background:linear-gradient(135deg,rgba(59,130,246,.95),rgba(37,99,235,.95))',
                    'gray'  => 'background:linear-gradient(135deg,rgba(100,116,139,.95),rgba(71,85,105,.95))',
                    default => 'background:linear-gradient(135deg,rgba(249,115,22,.95),rgba(234,88,12,.95))',
                };
                $lang  = app()->getLocale();
                $title = $project->{"title_{$lang}"}       ?? $project->title_fr       ?? $project->title_en;
                $desc  = $project->{"description_{$lang}"} ?? $project->description_fr ?? $project->description_en;
            @endphp

            <div class="proj-card"
                 data-title="{{ e($title) }}"
                 data-vignette="{{ e($project->helloasso_vignette_url ?? '') }}"
                 data-img="{{ $imgUrl }}">

                {{-- Image --}}
                <div class="proj-img-wrap">
                    <img src="{{ $imgUrl }}" alt="{{ e($title) }}" loading="lazy">
                    <div class="proj-img-overlay">
                        <span class="proj-badge" style="{{ $badgeStyle }}">
                            <i class="fas fa-fire text-[9px]"></i> {{ $project->badge_label ?? 'Active' }}
                        </span>
                        <h3 class="proj-img-title">{{ Str::limit($title, 55) }}</h3>
                    </div>
                </div>

                {{-- Info --}}
                <div class="proj-body">
                    @if($project->tags)
                    <div class="proj-tags">
                        @foreach(array_slice($project->tags, 0, 3) as $tag)
                        <span class="proj-tag">
                            <i class="fas fa-tag text-orange-400 text-[8px]"></i> {{ $tag }}
                        </span>
                        @endforeach
                    </div>
                    @endif

                    @if($desc)
                    <p class="proj-desc">{{ Str::limit($desc, 100) }}</p>
                    @endif

                    {{-- Campaign Card button (only when vignette set) --}}
                    @if(!empty($project->helloasso_vignette_url))
                    <button class="proj-card-btn"
                            onclick="openProjModalTab(this.closest('.proj-card'))"
                            title="View campaign card">
                        <i class="fas fa-id-card"></i> Campaign Card
                    </button>
                    @endif
                </div>

                {{-- Always-visible widget --}}
                @if(!empty($project->helloasso_widget_url))
                <div class="proj-widget-wrap">
                    <div class="proj-widget-bar">
                        <div class="proj-widget-label">
                            <i class="fas fa-hand-holding-heart"></i> Donation Form
                        </div>
                        <div class="proj-widget-ha">
                            <i class="fas fa-external-link-alt text-[9px]"></i> HelloAsso
                        </div>
                    </div>
                    <iframe class="proj-widget-iframe"
                            src="{{ e($project->helloasso_widget_url) }}"
                            allowtransparency="true"
                            loading="lazy"
                            onload="this.classList.add('loaded')">
                    </iframe>
                </div>
                @endif

            </div>

            @empty
            <div class="col-span-3 text-center py-20 text-gray-400">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-heart text-3xl text-orange-300"></i>
                </div>
                <p class="font-semibold">No active projects yet.</p>
            </div>
            @endforelse

        </div>

        {{-- Ways to Give --}}
        <div class="reveal stagger-3">
            <div class="text-center mb-8">
                <div class="section-pill mx-auto mb-4"><span class="dot"></span> Ways to Give</div>
                <h3 class="text-2xl md:text-3xl font-black text-gray-900">Choose How You Give</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="ways-card ways-card-light p-8">
                    <div class="ways-icon bg-orange-100">
                        <i class="fas fa-user text-orange-500 text-xl"></i>
                    </div>
                    <div class="pill bg-orange-100 text-orange-600 mb-3 text-[10px]">
                        <i class="fas fa-heart text-[9px]"></i> Individual
                    </div>
                    <h3 class="text-lg font-black text-gray-900 mb-2">Individual Donation</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-5">
                        Every euro goes directly to the field to support vulnerable children and families in Cambodia.
                    </p>
                    <div class="space-y-2.5">
                        @foreach(['One-time donation', 'Monthly recurring', 'Donation in memoriam', 'Birthday fundraiser'] as $type)
                        <div class="flex items-center gap-2.5 text-sm text-gray-600">
                            <span class="w-5 h-5 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-orange-500 text-[9px]"></i>
                            </span>
                            {{ $type }}
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="ways-card ways-card-dark p-8">
                    <div class="ways-icon bg-white/10">
                        <i class="fas fa-building text-orange-400 text-xl"></i>
                    </div>
                    <div class="pill bg-orange-500/20 text-orange-300 mb-3 text-[10px]">
                        <i class="fas fa-city text-[9px]"></i> Corporate
                    </div>
                    <h3 class="text-lg font-black text-white mb-2">Corporate Donation</h3>
                    <p class="text-white/60 text-sm leading-relaxed mb-5">
                        Tailored partnership packages with visibility, impact reports, and employee engagement.
                    </p>
                    <div class="space-y-2.5">
                        @foreach(['Single or recurring gift', 'Skills-based sponsorship', 'Employee matching', 'Named project funding'] as $type)
                        <div class="flex items-center gap-2.5 text-sm text-white/75">
                            <span class="w-5 h-5 bg-white/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-orange-400 text-[9px]"></i>
                            </span>
                            {{ $type }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ══ CAMPAIGN CARD MODAL (vignette popup) ══ --}}
<div id="projModalBg" class="proj-modal-bg" onclick="closeProjModal(event)">
    <div class="proj-modal" id="projModal" style="max-width:440px;">

        {{-- Header with project image --}}
        <div class="proj-modal-head">
            <img src="" id="projModalImg" class="proj-modal-head-img" alt="">
            <div class="proj-modal-head-overlay">
                <div class="proj-badge mb-1.5" style="width:fit-content;">
                    <i class="fas fa-id-card text-[9px]"></i> Campaign Card
                </div>
                <div class="proj-modal-title" id="projModalTitle"></div>
            </div>
            <button class="proj-modal-close" onclick="closeProjModalDirect()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                    <line x1="6" y1="6" x2="18" y2="18" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="18" y1="6" x2="6" y2="18" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </button>
        </div>

        {{-- Vignette iframe —  350×450 centered --}}
        <div style="flex:1;overflow-y:auto;display:flex;flex-direction:column;align-items:center;padding:24px 16px;gap:14px;background:linear-gradient(180deg,#f0f4f8,#e8edf5);">
            <p style="font-size:12px;color:#64748b;text-align:center;max-width:320px;line-height:1.65;margin:0;">
                This <strong style="color:#1e293b;">live campaign card</strong> updates automatically with your HelloAsso fundraiser progress.
            </p>
            <div class="vignette-card-wrap">
                <iframe id="projVignetteIframe"
                        src="" allowtransparency="true"
                        style="width:350px;height:450px;border:none;display:block;opacity:0;transition:opacity .4s;"
                        onload="this.style.opacity=1">
                </iframe>
            </div>
        </div>

        <div class="proj-modal-foot">
            <span><i class="fas fa-lock" style="color:#22c55e;"></i> Secure</span>
            <span><i class="fas fa-receipt" style="color:#f97316;"></i> Receipt</span>
            <span><i class="fas fa-shield-alt" style="color:#3b82f6;"></i> SSL Encrypted</span>
            <span><i class="fas fa-external-link-alt"></i> HelloAsso</span>
        </div>
    </div>
</div>

<script>
/* ── Open Campaign Card popup ── */
function openProjModalTab(card) {
    var vigUrl = card.getAttribute('data-vignette') || '';
    if (!vigUrl) return;

    document.getElementById('projModalTitle').textContent = card.getAttribute('data-title');
    document.getElementById('projModalImg').src           = card.getAttribute('data-img');

    var vi = document.getElementById('projVignetteIframe');
    vi.style.opacity = '0';
    if (vi.src !== vigUrl) vi.src = vigUrl;

    document.getElementById('projModalBg').classList.add('open');
    document.body.style.overflow = 'hidden';
    document.body.style.overscrollBehaviorY = 'none';
}

function closeProjModalDirect() {
    document.getElementById('projModalBg').classList.remove('open');
    document.getElementById('projVignetteIframe').src = '';
    document.body.style.overflow = '';
    document.body.style.overscrollBehaviorY = '';
}
function closeProjModal(e) {
    if (e.target === document.getElementById('projModalBg')) closeProjModalDirect();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeProjModalDirect(); });

/* Staggered card entrance */
(function(){
    var cards = document.querySelectorAll('.proj-card');
    var obs   = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var delay = Array.from(cards).indexOf(entry.target) * 120;
                setTimeout(function(){ entry.target.classList.add('card-visible'); }, delay);
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.05 });
    cards.forEach(c => obs.observe(c));
})();

/* Scroll reveal */
(function(){
    var els = document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale');
    var obs = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); }
        });
    }, { threshold:.08, rootMargin:'0px 0px -50px 0px' });
    els.forEach(el => obs.observe(el));
})();

/* ── Auto-resize widget iframes from HelloAsso postMessage ── */
window.addEventListener('message', function(e) {
    if (!e.data) return;

    /* HelloAsso sends { type: 'resize', height: N } or just { height: N } */
    var h = null;
    if (typeof e.data === 'object') {
        h = e.data.height || e.data.newHeight || null;
    }
    if (typeof e.data === 'string') {
        try { var parsed = JSON.parse(e.data); h = parsed.height || parsed.newHeight; } catch(ex){}
    }

    if (h && h > 100) {
        /* Find which iframe sent this message by matching origin */
        document.querySelectorAll('.proj-widget-iframe').forEach(function(iframe) {
            try {
                if (iframe.contentWindow === e.source) {
                    iframe.style.height = Math.ceil(h) + 'px';
                }
            } catch(ex) {}
        });

        /* Fallback: resize ALL widget iframes to the received height
           (safe because HelloAsso widgets all show same amount of content) */
        document.querySelectorAll('.proj-widget-iframe').forEach(function(iframe) {
            if (!iframe.dataset.manualHeight) {
                iframe.style.height = Math.ceil(h) + 'px';
            }
        });
    }
});
</script>

{{-- ══ GENERAL DONATION CTA ══ --}}
<section class="bg-white py-16 md:py-24">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <div class="donate-cta-box reveal">
            <div class="relative z-10">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg shadow-orange-100"
                     style="animation:heartBeat 2.5s ease infinite;">
                    <i class="fas fa-heart text-orange-500 text-2xl"></i>
                </div>
                <div class="section-pill mx-auto mb-4 text-orange-600" style="font-size:11px;">
                    <span class="dot"></span> General Fund
                </div>
                <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-3">Make a General Donation</h2>
                <p class="text-gray-500 text-base mb-8 max-w-xs mx-auto leading-relaxed">
                    Support where the need is greatest — funds go to the most urgent programs.
                </p>
                <div class="flex justify-center mb-6">
                    <button id="openHaDonate1" class="donate-btn">
                        <i class="fas fa-hand-holding-heart"></i> Donate Now
                    </button>
                </div>
                <div class="secure-row mb-4">
                    <span><i class="fas fa-lock text-green-500"></i> Secure</span>
                    <span><i class="fas fa-shield-alt text-blue-500"></i> SSL</span>
                    <span><i class="fas fa-receipt text-orange-400"></i> Receipt</span>
                </div>
                <span class="helloasso-badge">
                    <i class="fas fa-external-link-alt text-[10px]"></i> Powered by HelloAsso
                </span>
            </div>
        </div>
    </div>
</section>

{{-- ══ BOTTOM CTA BANNER ══ --}}
<section class="bg-white pb-16 md:pb-24">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-br from-orange-500 via-orange-500 to-amber-400 rounded-2xl md:rounded-3xl p-8 md:p-14 relative overflow-hidden reveal">
            {{-- Decorative orbs inside banner --}}
            <div class="absolute inset-0 opacity-15" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/3 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-black/10 rounded-full translate-y-1/2 -translate-x-1/4 blur-2xl"></div>

            <div class="relative z-10 cta-banner-inner flex flex-col lg:flex-row items-center justify-between gap-6">
                <div class="text-white text-center lg:text-left">
                    <h2 class="text-2xl md:text-4xl font-black mb-2 leading-tight">Make a Difference Today</h2>
                    <p class="text-white/80 text-base md:text-lg max-w-lg">Your support funds programs that change children's lives.</p>
                </div>
                <div class="cta-btns flex flex-col sm:flex-row gap-3 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}"
                       class="inline-flex items-center justify-center gap-2.5 px-7 py-4 bg-white text-orange-600 font-black rounded-xl hover:bg-orange-50 transition shadow-xl text-sm">
                        <i class="fas fa-heart"></i> Sponsor a Child
                    </a>
                    <button id="openHaDonate2"
                            class="inline-flex items-center justify-center gap-2.5 px-7 py-4 bg-white/15 border-2 border-white/40 text-white font-black rounded-xl hover:bg-white/25 transition text-sm">
                        <i class="fas fa-hand-holding-heart"></i> Make a Donation
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ HELLOASSO GENERAL MODAL ══ --}}
<div id="haWidgetModalDonate"
     style="position:fixed;inset:0;display:none;align-items:center;justify-content:center;backdrop-filter:blur(16px) brightness(0.45) saturate(1.2);z-index:2147483647;padding:16px;">
    <button id="closeHaDonateBtn"
            style="position:absolute;top:.75rem;right:1.25rem;z-index:2147483648;background:#EFEFF4;border:none;border-radius:50%;width:44px;height:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 12px rgba(0,0,0,.12);transition:background .18s;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <line x1="6" y1="6" x2="18" y2="18" stroke="#333" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="18" y1="6" x2="6" y2="18" stroke="#333" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
    </button>
    <div style="position:relative;width:100%;max-width:950px;height:100%;max-height:90vh;overflow:hidden;border-radius:16px;box-shadow:0 40px 100px rgba(0,0,0,.4);">
        <iframe id="haWidget"
                src="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1/widget?view=overlay"
                style="width:100%;height:100%;border:none;">
        </iframe>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal    = document.getElementById('haWidgetModalDonate');
    const closeBtn = document.getElementById('closeHaDonateBtn');

    function openModal() {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.body.style.overscrollBehaviorY = 'none';
    }
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        document.body.style.overscrollBehaviorY = '';
    }

    document.getElementById('openHaDonate1')?.addEventListener('click', openModal);
    document.getElementById('openHaDonate2')?.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    closeBtn.addEventListener('mouseenter', () => closeBtn.style.background = '#E0E0E8');
    closeBtn.addEventListener('mouseleave', () => closeBtn.style.background = '#EFEFF4');
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
});
</script>

@endsection