{{-- resources/views/pages/support/donate.blade.php --}}
@extends('layouts.app')
@section('title', 'Make a Donation')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
/* ══════════════════════════════════════════════════════════════
   GLOBAL RESETS + TOKENS
   ══════════════════════════════════════════════════════════════ */
*{box-sizing:border-box;}

:root{
    --orange:#f97316;
    --orange-d:#ea580c;
    --orange-light:#fed7aa;
    --gold:#fbbf24;
    --dark:#0d0b09;
    --dark-2:#161210;
    --dark-warm:#1a1109;
    --ink:#fff;
    --muted:rgba(255,255,255,.52);
    --border:rgba(249,115,22,.22);
}

@keyframes fadeUp{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes cardIn{from{opacity:0;transform:translateY(24px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes dotPulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.7);opacity:.3}}
@keyframes heartBeat{0%,100%{transform:scale(1)}25%{transform:scale(1.14)}40%{transform:scale(1)}60%{transform:scale(1.08)}}
@keyframes popIn{0%{opacity:0;transform:scale(.87)}70%{transform:scale(1.03)}100%{opacity:1;transform:scale(1)}}
@keyframes borderAnim{0%,100%{border-color:rgba(249,115,22,.28)}50%{border-color:rgba(249,115,22,.75)}}
@keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}

.reveal{opacity:0;transform:translateY(22px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal.visible{opacity:1;transform:none}
.stagger-1{transition-delay:.07s}.stagger-2{transition-delay:.14s}.stagger-3{transition-delay:.21s}

/* ══════════════════════════════════════════════════════════════
   HERO — reference-style photo text area
   ══════════════════════════════════════════════════════════════ */
.page-hero{
    position:relative;
    min-height:clamp(380px,52vh,500px);
    display:flex;align-items:center;
    overflow:hidden;
    background:#1a1109;
    isolation:isolate;
}
.page-hero::after{
    content:'';
    position:absolute;inset:0;z-index:1;
    background:
        linear-gradient(90deg,rgba(0,0,0,.22) 0%,rgba(0,0,0,.36) 38%,rgba(0,0,0,.24) 66%,rgba(0,0,0,.10) 100%),
        linear-gradient(180deg,rgba(0,0,0,.04) 0%,rgba(0,0,0,.08) 48%,rgba(0,0,0,.26) 100%);
    pointer-events:none;
}
.hero-bg-img{
    position:absolute;inset:0;z-index:0;
    width:100%;height:100%;
    object-fit:cover;
    object-position:center 48%;
}

.page-hero-content{
    position:relative;z-index:2;
    max-width:980px;margin:0 auto;width:100%;
    padding:76px 36px 58px;
}

/* breadcrumb — strong shadow for legibility on bright photo */
.breadcrumb{
    display:none;align-items:center;gap:8px;flex-wrap:wrap;
    font-family:'Montserrat', sans-serif;
    font-size:10.5px;font-weight:700;
    letter-spacing:.12em;text-transform:uppercase;
    color:#fff;margin-bottom:30px;
    text-shadow:0 1px 8px rgba(0,0,0,.7),0 2px 4px rgba(0,0,0,.5);
}
.breadcrumb a{color:#fff;text-decoration:none;transition:color .18s;opacity:.92;}
.breadcrumb a:hover,.breadcrumb .active{opacity:1;}
.breadcrumb i{font-size:7px;opacity:.7;}

/* ── REFERENCE-STYLE TITLE ────────────────────────────────────
   condensed, white, bold, with soft shadow only
   ─────────────────────────────────────────────────────────── */
.hero-h1{
    font-family:'Montserrat', sans-serif;
    font-size:clamp(2.15rem,3.8vw,3.1rem);
    font-weight:800;
    line-height:.98;
    letter-spacing:.01em;
    color:#fff;
    max-width:620px;
    margin:0 0 18px;
    text-shadow:
        0 2px 5px rgba(0,0,0,.50),
        0 8px 22px rgba(0,0,0,.36);
    animation:fadeUp .6s .08s ease both;
}
.hero-h1 .line-white,
.hero-h1 .line-orange{display:inline;color:#fff;}

/* sub — clean white paragraph, like the reference */
.hero-sub{
    font-family:'Montserrat', sans-serif;
    font-size:clamp(.92rem,1.25vw,1.05rem);font-weight:600;
    color:#fff;line-height:1.65;
    max-width:610px;margin:0 0 22px;
    text-shadow:
        0 1px 3px rgba(0,0,0,.72),
        0 5px 14px rgba(0,0,0,.48);
    animation:fadeUp .6s .14s ease both;
}
.hero-sub strong{color:#fff;font-weight:700;}
.hero-sub em{font-style:italic;color:#fff;}
.hero-ref-btn{
    display:inline-flex;align-items:center;justify-content:center;gap:8px;
    min-height:42px;padding:0 20px;border:0;border-radius:3px;
    background:#ffc400;color:#243644;text-decoration:none;
    font-family:'Montserrat', sans-serif;
    font-size:1.02rem;font-weight:800;letter-spacing:.045em;text-transform:uppercase;
    box-shadow:0 2px 10px rgba(0,0,0,.26);
    transition:background .18s,transform .18s;
    animation:fadeUp .6s .20s ease both;
}
.hero-ref-btn:hover{background:#ffd226;color:#243644;transform:translateY(-1px);}
.hero-ref-btn i{font-size:.9rem;}

/* stats band — keep orange */
.hero-stats-band{
    position:relative;
    background:#ea580c;
    padding:36px 20px 54px;
    overflow:hidden;
}
.hero-stats{
    max-width:1040px;margin:0 auto;
    display:flex;align-items:center;justify-content:center;
    animation:fadeUp .6s .28s ease both;
}
.h-stat{flex:1;text-align:center;padding:0 34px;}
.hero-stat-n{
    font-family:'Montserrat', sans-serif;font-size:clamp(2rem,3vw,2.7rem);font-weight:900;
    color:#fff;line-height:1;letter-spacing:-.02em;
}
.hero-stat-l{
    font-family:'Montserrat', sans-serif;font-size:10px;font-weight:800;
    color:rgba(255,255,255,.74);text-transform:uppercase;letter-spacing:.1em;margin-top:7px;
}
.hero-stat-div{width:1px;background:rgba(255,255,255,.24);align-self:stretch;}

/* responsive */
@media(max-width:768px){
    .page-hero{min-height:clamp(420px,68vh,540px);}
    .page-hero-content{padding:64px 24px 46px;}
    .hero-h1{font-size:clamp(2rem,8vw,2.8rem);}
    .hero-bg-img{object-position:58% 48%;}
    .hero-stats{display:grid;grid-template-columns:repeat(2,1fr);gap:28px 0;}
    .hero-stat-div{display:none;}
}
@media(max-width:480px){
    .page-hero{min-height:clamp(460px,80vh,560px);}
    .page-hero-content{padding:54px 20px;}
    .hero-h1{font-size:clamp(1.9rem,10vw,2.45rem);line-height:1;}
    .hero-sub{font-size:.92rem;}
    .breadcrumb{font-size:9.5px;}
    .hero-stats{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));}
    .h-stat{padding:0 8px;}
}

/* wave */
.wave-divider{line-height:0;overflow:hidden;}
.wave-divider svg{display:block;}

/* ══════════════════════════════════════════════════════════════
   SECTION DECOR
   ══════════════════════════════════════════════════════════════ */
.section-pill{
    display:inline-flex;align-items:center;gap:7px;padding:6px 16px;border-radius:999px;
    background:rgba(249,115,22,.10);border:1px solid rgba(249,115,22,.20);
    font-family:'Montserrat',sans-serif;font-size:10.5px;font-weight:800;
    letter-spacing:.07em;text-transform:uppercase;color:var(--orange-d);margin-bottom:12px;
}
.section-pill .dot{width:6px;height:6px;border-radius:50%;background:var(--orange);animation:dotPulse 1.8s ease-in-out infinite;}

/* ══════════════════════════════════════════════════════════════
   PROJECT CARDS
   ══════════════════════════════════════════════════════════════ */
.proj-card{background:#fff;border-radius:20px;overflow:hidden;border:1px solid #f0f4f8;box-shadow:0 4px 20px rgba(0,0,0,.07);cursor:default;opacity:0;transform:translateY(28px) scale(.97);will-change:transform;}
.proj-card.card-visible{animation:cardIn .6s cubic-bezier(.16,1,.3,1) both;opacity:1;transform:none;}
.proj-card:hover{transform:none !important;box-shadow:0 4px 20px rgba(0,0,0,.07) !important;}
.proj-img-wrap{position:relative;height:240px;overflow:hidden;}
.proj-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .65s cubic-bezier(.16,1,.3,1);}
.proj-img-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(13,11,9,.85) 0%,rgba(13,11,9,.18) 55%,transparent 100%);display:flex;flex-direction:column;justify-content:flex-end;padding:14px 16px;}
.proj-badge{display:inline-flex;align-items:center;gap:4px;background:var(--orange);color:#fff;font-family:'Montserrat', sans-serif;font-size:9px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;padding:4px 9px;border-radius:999px;margin-bottom:6px;width:fit-content;box-shadow:0 2px 8px rgba(249,115,22,.4);}
.proj-img-title{color:#fff;font-family:'Montserrat', sans-serif;font-size:.9rem;font-weight:800;line-height:1.3;margin:0;text-shadow:0 1px 6px rgba(0,0,0,.5);}
.proj-body{padding:16px 18px 18px;}
.proj-tags{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:10px;}
.proj-tag{display:inline-flex;align-items:center;gap:3px;background:#f8fafc;border:1px solid #e8edf2;color:#64748b;font-family:'Montserrat', sans-serif;font-size:10px;font-weight:700;padding:3px 9px;border-radius:999px;}
.proj-tag:hover{background:#fff7ed;border-color:var(--orange-light);color:var(--orange-d);}
.proj-desc{color:#64748b;font-family:'Montserrat', sans-serif;font-size:.82rem;line-height:1.65;margin-bottom:12px;}
.proj-card-btn{display:inline-flex;align-items:center;gap:6px;padding:7px 13px;border-radius:9px;background:linear-gradient(135deg,#1a1109,#2a1a06);color:rgba(255,255,255,.7);font-family:'Montserrat', sans-serif;font-size:11px;font-weight:700;border:none;cursor:pointer;box-shadow:0 3px 10px rgba(13,11,9,.25);transition:transform .16s,color .16s;}
.proj-card-btn:hover{transform:translateY(-1px);color:var(--gold);}
.proj-widget-wrap{border-top:1px solid #f0f4f8;background:#f8fafc;overflow:hidden;}
.proj-widget-bar{display:flex;align-items:center;justify-content:space-between;padding:9px 16px;background:linear-gradient(135deg,#2a1a06,#1a1109);}
.proj-widget-label{display:flex;align-items:center;gap:6px;font-family:'Montserrat', sans-serif;font-size:10px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.62);}
.proj-widget-label i{color:var(--gold);}
.proj-widget-ha{font-family:'Montserrat', sans-serif;font-size:10px;font-weight:700;color:rgba(255,255,255,.32);display:flex;align-items:center;gap:4px;}
.proj-widget-iframe{display:block;width:100%;border:none;height:550px;min-height:300px;opacity:0;transition:opacity .4s ease;}
.proj-widget-iframe.loaded{opacity:1;}

/* ══════════════════════════════════════════════════════════════
   FISCAL CALCULATOR
   ══════════════════════════════════════════════════════════════ */
.calc-wrap{background:#fff;border-radius:26px;overflow:hidden;box-shadow:0 8px 44px rgba(0,0,0,.08);border:1px solid rgba(249,115,22,.10);}
.calc-type-card{cursor:pointer;padding:13px 11px;border-radius:14px;border:1.5px solid #e8edf2;transition:border-color .18s,background .18s,box-shadow .18s;background:#fff;}
.calc-type-card:hover{border-color:rgba(249,115,22,.45);}
.calc-type-card.active{border-color:var(--gold);background:linear-gradient(135deg,rgba(251,191,36,.06),rgba(249,115,22,.04));box-shadow:0 4px 16px rgba(249,115,22,.14);}
.calc-type-card .ctc-title{font-family:'Montserrat', sans-serif;font-size:.82rem;font-weight:800;color:#1a1109;margin-bottom:3px;}
.calc-type-card .ctc-rate{font-family:'Montserrat', sans-serif;font-size:1.35rem;font-weight:900;color:var(--orange);line-height:1;margin-bottom:3px;}
.calc-type-card .ctc-desc{font-family:'Montserrat', sans-serif;font-size:.67rem;font-weight:600;color:#94a3b8;line-height:1.5;}
.calc-type-card.active .ctc-title{color:var(--orange-d);}
.calc-amt-btn{padding:10px 4px;border-radius:11px;border:1.5px solid #e8edf2;background:#fff;font-family:'Montserrat', sans-serif;font-size:.82rem;font-weight:800;color:#64748b;cursor:pointer;transition:all .16s;text-align:center;}
.calc-amt-btn:hover{border-color:rgba(249,115,22,.45);color:var(--orange-d);}
.calc-amt-btn.active{background:linear-gradient(135deg,var(--gold),var(--orange));border-color:transparent;color:#fff;box-shadow:0 4px 12px rgba(249,115,22,.38);}
.calc-result-panel{background:linear-gradient(145deg,#1a1109 0%,#241508 55%,#2c1c08 100%);border-radius:20px;padding:32px 26px;position:relative;overflow:hidden;}
.calc-result-panel::before{content:'';position:absolute;bottom:-50px;left:50%;transform:translateX(-50%);width:320px;height:200px;border-radius:50%;background:radial-gradient(ellipse,rgba(249,115,22,.18) 0%,rgba(251,191,36,.08) 45%,transparent 70%);pointer-events:none;}
.calc-result-big{font-family:'Montserrat', sans-serif;font-size:clamp(2.8rem,6vw,4.2rem);font-weight:900;color:var(--orange);line-height:1;letter-spacing:-.02em;}
.calc-info-box{background:linear-gradient(135deg,rgba(249,115,22,.06),rgba(245,158,11,.04));border:1px solid rgba(249,115,22,.16);border-radius:14px;padding:16px 18px;}
input[type=number].calc-input::-webkit-inner-spin-button,
input[type=number].calc-input::-webkit-outer-spin-button{-webkit-appearance:none;margin:0;}
input[type=number].calc-input{-moz-appearance:textfield;}

/* ══════════════════════════════════════════════════════════════
   WAYS TO GIVE
   ══════════════════════════════════════════════════════════════ */
.ways-card{border-radius:20px;overflow:hidden;transition:transform .3s cubic-bezier(.16,1,.3,1),box-shadow .3s;}
.ways-card:hover{transform:translateY(-4px);}
.ways-card-light{background:#fff;border:1.5px solid var(--orange-light);box-shadow:0 4px 20px rgba(249,115,22,.07);}
.ways-card-light:hover{box-shadow:0 14px 40px rgba(249,115,22,.14);}
.ways-card-dark{background:linear-gradient(145deg,#1a1109,#241508);border:1px solid rgba(249,115,22,.14);box-shadow:0 4px 20px rgba(13,11,9,.3);}
.ways-card-dark:hover{box-shadow:0 14px 40px rgba(13,11,9,.45);}
.ways-icon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;}

/* ══════════════════════════════════════════════════════════════
   GENERAL DONATE CTA
   ══════════════════════════════════════════════════════════════ */
.donate-cta-box{
    position:relative;overflow:hidden;
    background:linear-gradient(145deg,#fff8f0,#fffbf5,#fff8f0);
    border:1.5px solid rgba(249,115,22,.22);
    border-radius:26px;padding:52px 28px;text-align:center;
    animation:borderAnim 4s ease-in-out infinite;
}
.donate-btn{
    display:inline-flex;align-items:center;justify-content:center;gap:9px;
    padding:16px 40px;border-radius:12px;border:none;cursor:pointer;
    background:var(--orange);color:#fff;
    font-family:'Outfit',sans-serif;font-size:.95rem;font-weight:900;
    letter-spacing:.04em;text-transform:uppercase;
    box-shadow:0 6px 24px rgba(249,115,22,.36);
    transition:background .2s,transform .2s,box-shadow .2s;
}
.donate-btn:hover{background:var(--orange-d);transform:translateY(-2px) scale(1.02);box-shadow:0 12px 36px rgba(249,115,22,.48);color:#fff;}
.helloasso-badge{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:999px;background:#f1f5f9;font-family:'Montserrat', sans-serif;font-size:11px;font-weight:700;color:#64748b;border:1px solid #e2e8f0;}
.secure-row{display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap;font-family:'Montserrat', sans-serif;font-size:12px;font-weight:600;color:#94a3b8;}
.secure-row span{display:flex;align-items:center;gap:4px;}

/* ══════════════════════════════════════════════════════════════
   PROJECT MODAL
   ══════════════════════════════════════════════════════════════ */
.proj-modal-bg{position:fixed;inset:0;z-index:2147483647;display:none;align-items:center;justify-content:center;backdrop-filter:blur(14px) brightness(.35) saturate(1.2);padding:16px;}
.proj-modal-bg.open{display:flex;animation:fadeIn .22s ease both;}
.proj-modal{background:#fff;border-radius:22px;overflow:hidden;width:100%;max-width:440px;max-height:92vh;display:flex;flex-direction:column;box-shadow:0 36px 90px rgba(0,0,0,.42);animation:popIn .35s cubic-bezier(.16,1,.3,1) both;}
.proj-modal-head{flex-shrink:0;position:relative;height:145px;overflow:hidden;}
.proj-modal-head-img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;}
.proj-modal-head-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(13,11,9,.88) 0%,rgba(13,11,9,.42) 55%,rgba(249,115,22,.06) 100%);display:flex;flex-direction:column;justify-content:flex-end;padding:14px 20px;}
.proj-modal-title{color:#fff;font-family:'Montserrat', sans-serif;font-size:.95rem;font-weight:800;line-height:1.3;padding-right:46px;}
.proj-modal-close{position:absolute;top:11px;right:11px;z-index:10;width:36px;height:36px;background:rgba(255,255,255,.12);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.14);border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .16s;}
.proj-modal-close:hover{background:rgba(255,255,255,.24);}
.proj-modal-foot{padding:10px 16px;background:#f8fafc;border-top:1px solid #f0f4f8;display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap;flex-shrink:0;}
.proj-modal-foot span{font-family:'Montserrat', sans-serif;font-size:11px;color:#94a3b8;font-weight:700;display:flex;align-items:center;gap:4px;}

@media(max-width:640px){
    .proj-img-wrap{height:200px;}
    .proj-modal-bg{align-items:flex-end;padding:0;}
    .proj-modal{max-height:92vh;border-radius:20px 20px 0 0;width:100%;max-width:100%;}
    .proj-widget-iframe{height:460px;}
}
</style>

{{-- ══════════════════════════════════════════════════════════════
     HERO — Bright photo with reference-style white text
     ══════════════════════════════════════════════════════════════ --}}
<section class="page-hero">
    <img src="{{ asset('images/image-background.jpg') }}" alt="" class="hero-bg-img" loading="eager" fetchpriority="high">

    <div class="page-hero-content">

        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right"></i>
            <span>Support Us</span>
            <i class="fas fa-chevron-right"></i>
            <span class="active">Make a Donation</span>
        </nav>

        <h1 class="hero-h1">
            <span class="line-white">Every Gift Counts,</span>
            <span class="line-orange">Change a Life Today</span>
        </h1>

        <p class="hero-sub">
            <strong>Des Ailes pour Grandir</strong> — <em>"Wings to Grow"</em> — gives vulnerable children in Cambodia the chance to soar. Your gift goes <strong>100% to the field</strong>.
        </p>

        <a href="#projectGrid" class="hero-ref-btn">
            <i class="fas fa-hand-holding-heart"></i>
            Donate Now
        </a>
    </div>
</section>

<section class="hero-stats-band">
    <div class="hero-stats">
        @foreach([
            [number_format($donationProjects->count()), 'Active Projects'],
            ['100%', 'To the Field'],
            ['95K+', 'Children Helped'],
            ['cambodia', 'Cambodia']
        ] as [$n, $l])

        <div class="h-stat">
            <div class="hero-stat-n">
                @if($n === 'cambodia')
                    <img src="{{ asset('images/cambodia.svg') }}"
                        alt="Cambodia"
                        class="w-7 h-7 inline-block object-contain">
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
</section>

{{-- Wave divider --}}
<div class="wave-divider" style="background:linear-gradient(180deg,#fdf6ec,#fef3e2);">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,35 C480,58 960,8 1440,35 L1440,0 L0,0 Z" fill="#ea580c"/>
    </svg>
</div>

{{-- ══════════════════════════════════════════════════════════════
     ACTIVE CAMPAIGNS / PROJECT GRID
     ══════════════════════════════════════════════════════════════ --}}
<section class="py-16 md:py-28" style="background:linear-gradient(180deg,#fdf6ec,#fef3e2);">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <div class="section-pill mx-auto mb-4"><span class="dot"></span> Active Campaigns</div>
            <h2 class="text-2xl md:text-4xl font-black" style="font-family:'Montserrat', sans-serif;color:#1a1109;margin-bottom:8px;letter-spacing:-.02em;">Support a Specific Project</h2>
            <p class="text-gray-500 max-w-md mx-auto" style="font-family:'Montserrat', sans-serif;font-size:.9rem;">Each card contains a live donation form — secure, fast, and transparent.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16" id="projectGrid">
            @forelse($donationProjects as $project)
            @php
                $imgUrl = $project->image ? asset($project->image) : asset('images/children/image-1.jpg');
                $badgeStyle = match($project->badge_color ?? 'orange'){
                    'green' => 'background:linear-gradient(135deg,rgba(34,197,94,.95),rgba(22,163,74,.95))',
                    'gray'  => 'background:linear-gradient(135deg,rgba(100,116,139,.95),rgba(71,85,105,.95))',
                    default => 'background:#f97316',
                };
                $lang  = app()->getLocale();
                $title = $project->{"title_{$lang}"} ?? $project->title_fr ?? $project->title_en;
                $desc  = $project->{"description_{$lang}"} ?? $project->description_fr ?? $project->description_en;
            @endphp
            <div class="proj-card"
                 data-title="{{ e($title) }}"
                 data-vignette="{{ e($project->helloasso_vignette_url ?? '') }}"
                 data-img="{{ $imgUrl }}">
                <div class="proj-img-wrap">
                    <img src="{{ $imgUrl }}" alt="{{ e($title) }}" loading="lazy">
                    <div class="proj-img-overlay">
                        <span class="proj-badge" style="{{ $badgeStyle }}">
                            <i class="fas fa-fire" style="font-size:8px;"></i>
                            {{ $project->badge_label ?? 'Active' }}
                        </span>
                        <h3 class="proj-img-title">{{ Str::limit($title, 55) }}</h3>
                    </div>
                </div>
                <div class="proj-body">
                    @if($project->tags)
                    <div class="proj-tags">
                        @foreach(array_slice($project->tags, 0, 3) as $tag)
                        <span class="proj-tag">
                            <i class="fas fa-tag" style="color:#f97316;font-size:8px;"></i> {{ $tag }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                    @if($desc)<p class="proj-desc">{{ Str::limit($desc, 100) }}</p>@endif
                    @if(!empty($project->helloasso_vignette_url))
                    <button class="proj-card-btn" onclick="openProjModalTab(this.closest('.proj-card'))">
                        <i class="fas fa-id-card"></i> Campaign Card
                    </button>
                    @endif
                </div>
                @if(!empty($project->helloasso_widget_url))
                <div class="proj-widget-wrap">
                    <div class="proj-widget-bar">
                        <div class="proj-widget-label"><i class="fas fa-hand-holding-heart"></i> Donation Form</div>
                        <div class="proj-widget-ha"><i class="fas fa-external-link-alt" style="font-size:9px;"></i> HelloAsso</div>
                    </div>
                    <iframe class="proj-widget-iframe"
                            src="{{ e($project->helloasso_widget_url) }}"
                            allowtransparency="true"
                            loading="lazy"
                            onload="this.classList.add('loaded')"></iframe>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-3 text-center py-20 text-gray-400">
                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background:rgba(249,115,22,.10);">
                    <i class="fas fa-hand-holding-heart text-3xl" style="color:rgba(249,115,22,.4);"></i>
                </div>
                <p class="font-semibold" style="font-family:'Montserrat', sans-serif;">No active projects yet.</p>
            </div>
            @endforelse
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             FISCAL CALCULATOR
             ══════════════════════════════════════════════════════════════ --}}
        <div class="reveal mb-16" id="fiscalCalc">
            <div class="text-center mb-8">
                <div class="section-pill mx-auto mb-4"><span class="dot"></span> Tax Benefit Simulator</div>
                <h3 class="text-2xl md:text-3xl font-black" style="font-family:'Outfit',sans-serif;color:#1a1109;letter-spacing:-.02em;">How Much Does Your Gift Really Cost?</h3>
                <p class="text-gray-400 mt-2 max-w-sm mx-auto" style="font-family:'Outfit',sans-serif;font-size:.87rem;">Calculate your real donation cost after French tax deductions — in real time.</p>
            </div>

            <div class="calc-wrap">
                <div class="grid md:grid-cols-2">
                    <div class="p-8 md:p-10 space-y-7">
                        <div>
                            <p class="font-semibold mb-3" style="font-family:'Montserrat', sans-serif;font-size:.8rem;letter-spacing:.07em;text-transform:uppercase;color:#1a1109;">Your Tax Situation</p>
                            <div class="grid grid-cols-3 gap-3" id="calc-type-cards">
                                <div onclick="calcSetType('ir')" id="calc-card-ir" class="calc-type-card active">
                                    <div class="ctc-rate">66%</div>
                                    <div class="ctc-title">Individual</div>
                                    <div class="ctc-desc">Income tax • Cap 20% taxable income</div>
                                </div>
                                <div onclick="calcSetType('ifi')" id="calc-card-ifi" class="calc-type-card">
                                    <div class="ctc-rate">75%</div>
                                    <div class="ctc-title">IFI</div>
                                    <div class="ctc-desc">Wealth tax • Max €50,000/year</div>
                                </div>
                                <div onclick="calcSetType('is')" id="calc-card-is" class="calc-type-card">
                                    <div class="ctc-rate">60%</div>
                                    <div class="ctc-title">Company</div>
                                    <div class="ctc-desc">Corporate deduction • 0.5% revenue</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="font-semibold mb-3" style="font-family:'Montserrat', sans-serif;font-size:.8rem;letter-spacing:.07em;text-transform:uppercase;color:#1a1109;">Donation Amount</p>
                            <div class="grid grid-cols-4 gap-3 mb-4" id="calc-amt-btns">
                                <button onclick="calcSetAmount(20)"  data-amount="20"  class="calc-amt-btn">€20</button>
                                <button onclick="calcSetAmount(50)"  data-amount="50"  class="calc-amt-btn">€50</button>
                                <button onclick="calcSetAmount(100)" data-amount="100" class="calc-amt-btn">€100</button>
                                <button onclick="calcSetAmount(250)" data-amount="250" class="calc-amt-btn">€250</button>
                            </div>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold" style="font-family:'Montserrat', sans-serif;font-size:1rem;color:var(--orange);">€</span>
                                <input id="calc-input" type="number" min="1" placeholder="Custom amount"
                                       oninput="calcOnInput(this.value)"
                                       class="calc-input w-full pl-9 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none placeholder-slate-300"
                                       style="font-family:'Montserrat',sans-serif;font-weight:700;color:#1a1109;">
                            </div>
                            <p class="text-xs text-slate-400 mt-2" style="font-family:'Montserrat', sans-serif;">
                                Selected: <span id="calc-selected" class="font-bold" style="color:var(--orange-d);">€0</span>
                            </p>
                        </div>

                        <div class="calc-info-box">
                            <p class="font-bold mb-2 flex items-center gap-2" style="font-family:'Montserrat', sans-serif;font-size:.82rem;color:var(--orange-d);">
                                <i class="fas fa-lightbulb" style="color:var(--gold);"></i> French Tax Deductions on Donations
                            </p>
                            <ul class="space-y-1" style="font-family:'Montserrat', sans-serif;font-size:.78rem;color:#92400e;">
                                <li class="flex items-center gap-2"><i class="fas fa-check" style="color:var(--gold);font-size:9px;"></i> 66% for individual taxpayers</li>
                                <li class="flex items-center gap-2"><i class="fas fa-check" style="color:var(--gold);font-size:9px;"></i> 75% for IFI (subject to conditions)</li>
                                <li class="flex items-center gap-2"><i class="fas fa-check" style="color:var(--gold);font-size:9px;"></i> 60% for companies</li>
                            </ul>
                            <p class="mt-2.5 flex items-start gap-2" style="font-family:'Montserrat', sans-serif;font-size:.75rem;color:#78716c;">
                                <i class="fas fa-file-alt mt-0.5 flex-shrink-0" style="color:var(--gold);"></i>
                                An official <strong>tax receipt</strong> is sent automatically after your donation.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col justify-center p-8 md:p-10" style="background:linear-gradient(145deg,#fdf6ec,#fef3e2);border-left:1px solid rgba(249,115,22,.12);">
                        <div class="calc-result-panel mb-6">
                            <div class="relative z-10">
                                <p class="mb-1" style="font-family:'Montserrat', sans-serif;font-weight:700;color:rgba(255,255,255,.42);text-transform:uppercase;letter-spacing:.1em;font-size:9.5px;">
                                    <i class="fas fa-hand-holding-heart mr-1" style="color:rgba(249,115,22,.55);"></i> Your gift actually costs
                                </p>
                                <div id="calc-result-cout" class="calc-result-big mb-5">€0.00</div>
                                <div class="space-y-2" style="font-family:'Outfit',sans-serif;font-size:.78rem;color:rgba(255,255,255,.48);">
                                    <div class="flex justify-between items-center border-b pb-2" style="border-color:rgba(255,255,255,.08);">
                                        <span><i class="fas fa-coins mr-1.5" style="color:rgba(249,115,22,.55);"></i> Total donation</span>
                                        <span class="font-bold" style="color:rgba(255,255,255,.8);"><span id="calc-res-don">€0</span></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span><i class="fas fa-piggy-bank mr-1.5" style="color:rgba(249,115,22,.55);"></i> Tax reduction</span>
                                        <span class="font-bold" style="color:var(--gold);">− <span id="calc-res-reduction">€0.00</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-5 border shadow-sm" style="border-color:rgba(249,115,22,.12);">
                            <p class="font-semibold mb-1" style="font-family:'Outfit',sans-serif;font-size:.9rem;color:#1a1109;">👉 In practice</p>
                            <p class="text-sm mb-4" style="font-family:'Outfit',sans-serif;line-height:1.65;color:#64748b;">
                                A gift of <strong id="calc-cta-don" style="color:#1a1109;">€0</strong> only costs you
                                <strong id="calc-cta-cout" style="color:var(--orange-d);">€0.00</strong> after tax deduction.
                            </p>
                            <button onclick="document.getElementById('openHaDonate1').click()" class="donate-btn w-full justify-center text-sm py-3">
                                <i class="fas fa-hand-holding-heart"></i> Donate Now
                            </button>
                            <p class="text-center mt-3" style="font-family:'Outfit',sans-serif;font-size:9.5px;color:#94a3b8;">
                                <i class="fas fa-receipt mr-1" style="color:var(--orange);opacity:.6;"></i> Official tax receipt sent automatically
                            </p>
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
                <h3 class="text-2xl md:text-3xl font-black" style="font-family:'Montserrat',sans-serif;color:#1a1109;letter-spacing:-.02em;">Choose How You Give</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="ways-card ways-card-light p-8">
                    <div class="ways-icon bg-orange-100"><i class="fas fa-user" style="color:var(--orange);font-size:1.2rem;"></i></div>
                    <div class="section-pill mb-3" style="font-size:10px;background:rgba(249,115,22,.08);border-color:rgba(249,115,22,.16);">
                        <i class="fas fa-heart" style="color:var(--orange);font-size:9px;"></i> Individual
                    </div>
                    <h3 class="text-lg font-black mb-2" style="font-family:'Montserrat',sans-serif;color:#1a1109;">Individual Donation</h3>
                    <p class="text-sm leading-relaxed mb-5" style="font-family:'Montserrat',sans-serif;color:#64748b;">Every euro goes directly to the field to support vulnerable children and families in Cambodia.</p>
                    <div class="space-y-2.5">
                        @foreach(['One-time donation','Monthly recurring','Donation in memoriam','Birthday fundraiser'] as $t)
                        <div class="flex items-center gap-2.5 text-sm" style="font-family:'Montserrat',sans-serif;color:#4b5563;">
                            <span class="w-5 h-5 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check" style="color:var(--orange);font-size:8px;"></i>
                            </span>{{ $t }}
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="ways-card ways-card-dark p-8">
                    <div class="ways-icon" style="background:rgba(249,115,22,.12);">
                        <i class="fas fa-building" style="color:var(--gold);font-size:1.2rem;"></i>
                    </div>
                    <div class="section-pill mb-3" style="font-size:10px;background:rgba(251,191,36,.08);border-color:rgba(251,191,36,.2);color:var(--gold);">
                        <i class="fas fa-city" style="font-size:9px;"></i> Corporate
                    </div>
                    <h3 class="text-lg font-black text-white mb-2" style="font-family:'Montserrat',sans-serif;">Corporate Donation</h3>
                    <p class="text-sm leading-relaxed mb-5" style="font-family:'Montserrat',sans-serif;color:rgba(255,255,255,.55);">Tailored partnership packages with visibility, impact reports, and employee engagement.</p>
                    <div class="space-y-2.5">
                        @foreach(['Single or recurring gift','Skills-based sponsorship','Employee matching','Named project funding'] as $t)
                        <div class="flex items-center gap-2.5 text-sm" style="font-family:'Montserrat',sans-serif;color:rgba(255,255,255,.7);display:flex;align-items:center;">
                            <span style="width:20px;height:20px;border-radius:50%;background:rgba(249,115,22,.14);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-check" style="color:var(--gold);font-size:8px;"></i>
                            </span>&nbsp;{{ $t }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     PROJECT MODAL
     ══════════════════════════════════════════════════════════════ --}}
<div id="projModalBg" class="proj-modal-bg" onclick="closeProjModal(event)">
    <div class="proj-modal" id="projModal">
        <div class="proj-modal-head">
            <img src="" id="projModalImg" class="proj-modal-head-img" alt="">
            <div class="proj-modal-head-overlay">
                <div class="proj-badge mb-1.5" style="width:fit-content;">
                    <i class="fas fa-id-card" style="font-size:8px;"></i> Campaign Card
                </div>
                <div class="proj-modal-title" id="projModalTitle"></div>
            </div>
            <button class="proj-modal-close" onclick="closeProjModalDirect()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none">
                    <line x1="6" y1="6" x2="18" y2="18" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="18" y1="6" x2="6" y2="18" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
        <div style="flex:1;overflow-y:auto;display:flex;flex-direction:column;align-items:center;padding:22px 14px;gap:12px;background:linear-gradient(180deg,#fdf6ec,#fef3e2);">
            <p style="font-family:'Outfit',sans-serif;font-size:12px;color:#64748b;text-align:center;max-width:300px;line-height:1.65;margin:0;">
                This <strong style="color:#1a1109;">live campaign card</strong> updates automatically with your HelloAsso fundraiser progress.
            </p>
            <div style="background:#fff;border-radius:16px;box-shadow:0 10px 36px rgba(0,0,0,.13);overflow:hidden;width:340px;max-width:100%;">
                <iframe id="projVignetteIframe" src="" allowtransparency="true"
                        style="width:340px;height:440px;border:none;display:block;opacity:0;transition:opacity .4s;"
                        onload="this.style.opacity=1"></iframe>
            </div>
        </div>
        <div class="proj-modal-foot">
            <span><i class="fas fa-lock" style="color:#22c55e;"></i> Secure</span>
            <span><i class="fas fa-receipt" style="color:var(--orange);"></i> Receipt</span>
            <span><i class="fas fa-shield-alt" style="color:#94a3b8;"></i> SSL</span>
            <span><i class="fas fa-external-link-alt"></i> HelloAsso</span>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     GENERAL DONATE CTA
     ══════════════════════════════════════════════════════════════ --}}
<section class="py-16 md:py-24" style="background:#fef9f0;">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <div class="donate-cta-box reveal">
            <div class="relative z-10">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-5"
                     style="animation:heartBeat 2.5s ease infinite;box-shadow:0 6px 20px rgba(249,115,22,.18);">
                    <i class="fas fa-heart text-2xl" style="color:var(--orange);"></i>
                </div>
                <div class="section-pill mx-auto mb-4" style="font-size:11px;"><span class="dot"></span> General Fund</div>
                <h2 class="text-2xl md:text-3xl font-black mb-3" style="font-family:'Outfit',sans-serif;color:#1a1109;letter-spacing:-.02em;">Make a General Donation</h2>
                <p class="text-gray-500 text-base mb-8 max-w-xs mx-auto leading-relaxed" style="font-family:'Outfit',sans-serif;">Support where the need is greatest — funds go to the most urgent programs.</p>
                <div class="flex justify-center mb-6">
                    <button id="openHaDonate1" class="donate-btn">
                        <i class="fas fa-hand-holding-heart"></i> Donate Now
                    </button>
                </div>
                <div class="secure-row mb-4">
                    <span><i class="fas fa-lock" style="color:#22c55e;"></i> Secure</span>
                    <span><i class="fas fa-shield-alt" style="color:#94a3b8;"></i> SSL</span>
                    <span><i class="fas fa-receipt" style="color:var(--orange);"></i> Receipt</span>
                </div>
                <span class="helloasso-badge"><i class="fas fa-external-link-alt" style="font-size:9px;"></i> Powered by HelloAsso</span>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     BOTTOM CTA BANNER
     ══════════════════════════════════════════════════════════════ --}}
<section style="background:#fef9f0;padding-bottom:4rem;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="rounded-2xl md:rounded-3xl p-8 md:p-14 relative overflow-hidden reveal"
             style="background:linear-gradient(135deg,#1a1109 0%,#241508 55%,#2c1c08 100%);">
            <div class="absolute inset-0" style="background-image:url('{{ asset('images/background.jpg') }}');background-size:cover;opacity:.06;"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-6">
                <div class="text-white text-center lg:text-left">
                    <p style="font-family:'Montserrat',sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(249,115,22,.55);margin-bottom:10px;">
                        <i class="fas fa-star mr-1"></i> Make an Impact
                    </p>
                    <h2 style="font-family:'Montserrat',sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;color:#fff;line-height:1.06;letter-spacing:-.02em;margin-bottom:10px;">
                        Make a Difference <span style="color:var(--orange);">Today</span>
                    </h2>
                    <p style="font-family:'Montserrat',sans-serif;color:rgba(255,255,255,.48);font-size:.9rem;max-width:420px;line-height:1.78;">Your support funds programs that change children's lives in Cambodia.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}"
                       style="display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:15px 26px;background:var(--orange);color:#fff;font-family:'Montserrat',sans-serif;font-size:.875rem;font-weight:800;border-radius:12px;text-decoration:none;box-shadow:0 6px 22px rgba(249,115,22,.28);transition:background .18s,transform .18s;"
                       onmouseover="this.style.background='#ea580c';this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.background='#f97316';this.style.transform=''">
                        <i class="fas fa-heart"></i> Sponsor a Child
                    </a>
                    <button id="openHaDonate2"
                            style="display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:15px 26px;background:rgba(249,115,22,.08);border:1.5px solid rgba(249,115,22,.28);color:rgba(255,255,255,.82);font-family:'Montserrat',sans-serif;font-size:.875rem;font-weight:700;border-radius:12px;cursor:pointer;transition:background .18s,border-color .18s;"
                            onmouseover="this.style.background='rgba(249,115,22,.16)';this.style.borderColor='rgba(249,115,22,.55)'"
                            onmouseout="this.style.background='rgba(249,115,22,.08)';this.style.borderColor='rgba(249,115,22,.28)'">
                        <i class="fas fa-hand-holding-heart"></i> Make a Donation
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     HELLOASSO WIDGET MODAL
     ══════════════════════════════════════════════════════════════ --}}
<div id="haWidgetModalDonate"
     style="position:fixed;inset:0;display:none;align-items:center;justify-content:center;backdrop-filter:blur(14px) brightness(0.4) saturate(1.1);z-index:2147483647;padding:16px;">
    <button id="closeHaDonateBtn"
            style="position:absolute;top:.75rem;right:1.25rem;z-index:2147483648;background:#EFEFF4;border:none;border-radius:50%;width:44px;height:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 10px rgba(0,0,0,.12);transition:background .16s;">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
            <line x1="6" y1="6" x2="18" y2="18" stroke="#333" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="18" y1="6" x2="6" y2="18" stroke="#333" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
    </button>
    <div style="position:relative;width:100%;max-width:950px;height:100%;max-height:90vh;overflow:hidden;border-radius:14px;box-shadow:0 36px 90px rgba(0,0,0,.4);">
        <iframe id="haWidget"
                src="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1/widget?view=overlay"
                style="width:100%;height:100%;border:none;"></iframe>
    </div>
</div>

<script>
/* ═══ PROJECT MODAL ═══ */
function openProjModalTab(card){
    var vigUrl=card.getAttribute('data-vignette')||'';
    if(!vigUrl)return;
    document.getElementById('projModalTitle').textContent=card.getAttribute('data-title');
    document.getElementById('projModalImg').src=card.getAttribute('data-img');
    var vi=document.getElementById('projVignetteIframe');
    vi.style.opacity='0';
    if(vi.src!==vigUrl)vi.src=vigUrl;
    document.getElementById('projModalBg').classList.add('open');
    document.body.style.overflow='hidden';
}
function closeProjModalDirect(){
    document.getElementById('projModalBg').classList.remove('open');
    document.getElementById('projVignetteIframe').src='';
    document.body.style.overflow='';
}
function closeProjModal(e){
    if(e.target===document.getElementById('projModalBg'))closeProjModalDirect();
}
document.addEventListener('keydown',function(e){
    if(e.key==='Escape'){closeProjModalDirect();if(window.closeHaDonate)closeHaDonate();}
});

/* ═══ CARD REVEAL ═══ */
(function(){
    var cards=document.querySelectorAll('.proj-card');
    var obs=new IntersectionObserver(function(entries){
        entries.forEach(function(entry){
            if(entry.isIntersecting){
                var delay=Array.from(cards).indexOf(entry.target)*100;
                setTimeout(function(){entry.target.classList.add('card-visible');},delay);
                obs.unobserve(entry.target);
            }
        });
    },{threshold:.05});
    cards.forEach(function(c){obs.observe(c);});
})();

/* ═══ REVEAL ON SCROLL ═══ */
(function(){
    var els=document.querySelectorAll('.reveal');
    var obs=new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){e.target.classList.add('visible');obs.unobserve(e.target);}
        });
    },{threshold:.08,rootMargin:'0px 0px -40px 0px'});
    els.forEach(function(el){obs.observe(el);});
})();

/* ═══ HELLOASSO IFRAME AUTO-RESIZE ═══ */
window.addEventListener('message',function(e){
    if(!e.data)return;
    var h=null;
    if(typeof e.data==='object')h=e.data.height||e.data.newHeight||null;
    if(typeof e.data==='string'){try{var p=JSON.parse(e.data);h=p.height||p.newHeight;}catch(x){}}
    if(h&&h>100){
        document.querySelectorAll('.proj-widget-iframe').forEach(function(iframe){
            if(!iframe.dataset.manualHeight)iframe.style.height=Math.ceil(h)+'px';
        });
    }
});

/* ═══ HELLOASSO WIDGET MODAL ═══ */
document.addEventListener('DOMContentLoaded',function(){
    var modal=document.getElementById('haWidgetModalDonate');
    var closeBtn=document.getElementById('closeHaDonateBtn');
    function openModal(){modal.style.display='flex';document.body.style.overflow='hidden';}
    function closeModal(){modal.style.display='none';document.body.style.overflow='';}
    window.closeHaDonate=closeModal;
    var btn1=document.getElementById('openHaDonate1');
    var btn2=document.getElementById('openHaDonate2');
    if(btn1)btn1.addEventListener('click',openModal);
    if(btn2)btn2.addEventListener('click',openModal);
    closeBtn.addEventListener('click',closeModal);
    closeBtn.addEventListener('mouseenter',function(){closeBtn.style.background='#E0E0E8';});
    closeBtn.addEventListener('mouseleave',function(){closeBtn.style.background='#EFEFF4';});
    modal.addEventListener('click',function(e){if(e.target===modal)closeModal();});
});

/* ═══ FISCAL CALCULATOR ═══ */
(function(){
    var currentType='ir',currentAmount=0;
    var rates={ir:0.66,ifi:0.75,is:0.60};
    window.calcSetType=function(type){
        currentType=type;
        ['ir','ifi','is'].forEach(function(t){
            var card=document.getElementById('calc-card-'+t);
            if(t===type)card.classList.add('active');
            else card.classList.remove('active');
        });
        calcUpdate();
    };
    window.calcSetAmount=function(amount){
        currentAmount=amount;
        document.getElementById('calc-input').value=amount;
        calcHighlightBtn(amount);
        calcUpdate();
    };
    window.calcOnInput=function(val){
        var parsed=parseFloat(val);
        currentAmount=isNaN(parsed)?0:parsed;
        calcHighlightBtn(currentAmount);
        calcUpdate();
    };
    function calcHighlightBtn(amount){
        document.querySelectorAll('#calc-amt-btns .calc-amt-btn').forEach(function(btn){
            if(parseInt(btn.dataset.amount)===amount)btn.classList.add('active');
            else btn.classList.remove('active');
        });
    }
    function calcUpdate(){
        var taux=rates[currentType]||0.66;
        var reduction=currentAmount*taux;
        var cout=currentAmount-reduction;
        document.getElementById('calc-result-cout').textContent='€'+cout.toFixed(2);
        document.getElementById('calc-res-don').textContent='€'+currentAmount;
        document.getElementById('calc-res-reduction').textContent='€'+reduction.toFixed(2);
        document.getElementById('calc-selected').textContent='€'+currentAmount;
        document.getElementById('calc-cta-don').textContent='€'+currentAmount;
        document.getElementById('calc-cta-cout').textContent='€'+cout.toFixed(2);
    }
    calcUpdate();
})();
</script>
@endsection
