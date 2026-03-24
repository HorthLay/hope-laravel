{{-- resources/views/pages/support/donate.blade.php --}}
@extends('layouts.app')
@section('title', 'Make a Donation')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600;1,700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
:root{
    --gold:#fbbf24;--gold-d:#d97706;--ember:#f97316;--ember-d:#ea580c;
    --sky:#04091f;--navy:#0c1445;--ink:#1c1033;--muted:#64748b;
    --cream:#fffbf0;--sand:#fef3c7;
}

/* ── Keyframes ── */
@keyframes fadeUp   {from{opacity:0;transform:translateY(36px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn   {from{opacity:0}to{opacity:1}}
@keyframes pulse    {0%,100%{box-shadow:0 0 0 0 rgba(251,191,36,.4)}70%{box-shadow:0 0 0 12px rgba(251,191,36,0)}}
@keyframes ray      {0%,100%{opacity:.25;transform:scaleY(1)}50%{opacity:.6;transform:scaleY(1.1)}}
@keyframes orb      {0%,100%{transform:translate(0,0)}50%{transform:translate(24px,-18px)}}
@keyframes cardIn   {from{opacity:0;transform:translateY(28px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes shimmer  {from{background-position:-200% 0}to{background-position:200% 0}}
@keyframes dotPulse {0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.6);opacity:.35}}
@keyframes heartBeat{0%,100%{transform:scale(1)}25%{transform:scale(1.15)}40%{transform:scale(1)}60%{transform:scale(1.1)}}
@keyframes popIn    {0%{opacity:0;transform:scale(.85)}70%{transform:scale(1.03)}100%{opacity:1;transform:scale(1)}}
@keyframes float    {0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
@keyframes borderAnim{0%,100%{border-color:rgba(251,191,36,.3)}50%{border-color:rgba(251,191,36,.8)}}

/* Reveal */
.reveal       {opacity:0;transform:translateY(28px);transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
.reveal.visible{opacity:1;transform:none}
.reveal-scale {opacity:0;transform:scale(.93);transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
.reveal-scale.visible{opacity:1;transform:none}
.stagger-1{transition-delay:.06s}.stagger-2{transition-delay:.13s}.stagger-3{transition-delay:.20s}
.stagger-4{transition-delay:.27s}.stagger-5{transition-delay:.34s}

/* ══════════════════════════
   HERO — night sky + dawn
══════════════════════════ */
.page-hero{
    position:relative;overflow:hidden;
    min-height:100vh;display:flex;align-items:center;
    background:radial-gradient(ellipse at 50% 110%,#1a0a3d 0%,#0c1445 45%,#04091f 100%);
}
#starCanvas{position:absolute;inset:0;z-index:0;pointer-events:none;}
.dawn-glow{
    position:absolute;bottom:-80px;left:50%;transform:translateX(-50%);
    width:1000px;height:420px;border-radius:50%;
    background:radial-gradient(ellipse,rgba(251,191,36,.2) 0%,rgba(249,115,22,.1) 40%,transparent 70%);
    z-index:1;pointer-events:none;animation:orb 8s ease-in-out infinite;
}
.rays-wrap{position:absolute;bottom:0;left:50%;transform:translateX(-50%);z-index:1;width:100%;pointer-events:none;}
.ray{
    position:absolute;bottom:0;width:2px;border-radius:999px;
    background:linear-gradient(to top,rgba(251,191,36,.38),transparent);
    transform-origin:bottom center;animation:ray 3s ease-in-out infinite;
}

/* Photo mosaic strip at bottom */
.photo-strip{
    position:absolute;bottom:0;left:0;right:0;z-index:2;height:280px;
    display:flex;
    mask-image:linear-gradient(to top,rgba(0,0,0,.75) 0%,rgba(0,0,0,.25) 60%,transparent 100%);
    -webkit-mask-image:linear-gradient(to top,rgba(0,0,0,.75) 0%,rgba(0,0,0,.25) 60%,transparent 100%);
}
.ps-img{flex:1;overflow:hidden;position:relative;}
.ps-img img{width:100%;height:100%;object-fit:cover;filter:saturate(.65) brightness(.55);transition:filter .5s;}
.ps-img:hover img{filter:saturate(1) brightness(.75);}
.ps-img::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(251,191,36,.14),transparent 60%);}

.page-hero-content{
    position:relative;z-index:3;
    padding:110px 20px 340px;
    max-width:1280px;margin:0 auto;width:100%;
    display:flex;flex-direction:column;align-items:center;text-align:center;
}

.breadcrumb{
    display:flex;align-items:center;gap:8px;flex-wrap:wrap;justify-content:center;
    font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
    color:rgba(251,191,36,.4);margin-bottom:28px;
}
.breadcrumb a{color:rgba(251,191,36,.4);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:rgba(251,191,36,.9);}
.breadcrumb span{color:rgba(251,191,36,.7);}
.breadcrumb i{color:rgba(251,191,36,.2);}

.hero-pill{
    display:inline-flex;align-items:center;gap:8px;
    padding:8px 22px;border-radius:999px;
    background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.22);
    font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;
    letter-spacing:.14em;text-transform:uppercase;color:var(--gold);
    margin-bottom:28px;animation:fadeUp .6s ease both;
}
.hero-pill-dot{width:7px;height:7px;border-radius:50%;background:var(--gold);animation:pulse 2s ease-in-out infinite;}

.hero-h1{
    font-family:'Cormorant Garamond',serif;
    font-size:clamp(3rem,8vw,7rem);font-weight:700;
    color:#fff;line-height:.96;letter-spacing:-.02em;
    margin-bottom:24px;animation:fadeUp .8s ease both;
}
.hero-h1 .glow{
    display:inline-block;
    background:linear-gradient(135deg,#fde68a 0%,#fbbf24 40%,#f97316 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    filter:drop-shadow(0 0 36px rgba(251,191,36,.45));
}
.hero-sub{
    font-family:'Outfit',sans-serif;font-size:1.05rem;color:rgba(255,255,255,.48);
    line-height:1.82;max-width:540px;margin:0 auto 40px;
    animation:fadeUp .8s .18s ease both;
}

/* Hero buttons */
.hero-btns{display:flex;gap:14px;flex-wrap:wrap;justify-content:center;animation:fadeUp .8s .32s ease both;margin-bottom:52px;}
.btn-gold{
    display:inline-flex;align-items:center;gap:9px;
    padding:16px 34px;border-radius:14px;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    color:#1c1033;font-family:'Outfit',sans-serif;font-size:.9rem;font-weight:800;
    text-decoration:none;
    box-shadow:0 8px 28px rgba(251,191,36,.38);
    transition:transform .22s,box-shadow .22s;
}
.btn-gold:hover{transform:translateY(-3px);box-shadow:0 16px 44px rgba(251,191,36,.52);color:#1c1033;}
.btn-ghost{
    display:inline-flex;align-items:center;gap:9px;
    padding:16px 34px;border-radius:14px;
    background:rgba(255,255,255,.05);border:1.5px solid rgba(251,191,36,.28);
    color:rgba(255,255,255,.72);font-family:'Outfit',sans-serif;font-size:.9rem;font-weight:700;
    text-decoration:none;transition:background .2s,border-color .2s;
}
.btn-ghost:hover{background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.6);color:#fff;}

/* Hero stats */
.hero-stats{display:flex;gap:40px;flex-wrap:wrap;justify-content:center;animation:fadeUp .8s .46s ease both;}
.hero-stat-n{font-family:'Cormorant Garamond',serif;font-size:2.4rem;font-weight:700;color:#fbbf24;line-height:1;letter-spacing:-.02em;}
.hero-stat-l{font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;color:rgba(255,255,255,.33);text-transform:uppercase;letter-spacing:.1em;margin-top:3px;}
.hero-stat-div{width:1px;background:rgba(251,191,36,.12);align-self:stretch;}

/* ══════════════════════════
   WAVE
══════════════════════════ */
.wave-divider{line-height:0;overflow:hidden;}
.wave-divider svg{display:block;}

/* ══════════════════════════
   SECTION PILL
══════════════════════════ */
.section-pill{
    display:inline-flex;align-items:center;gap:7px;
    padding:7px 18px;border-radius:999px;
    background:linear-gradient(135deg,rgba(249,115,22,.12),rgba(245,158,11,.08));
    border:1px solid rgba(249,115,22,.2);
    font-family:'Outfit',sans-serif;font-size:11px;font-weight:800;letter-spacing:.07em;text-transform:uppercase;
    color:#ea580c;margin-bottom:14px;
}
.section-pill .dot{width:6px;height:6px;border-radius:50%;background:#f97316;animation:dotPulse 1.8s ease-in-out infinite;}

/* ══════════════════════════
   PROJECT CARDS
══════════════════════════ */
.proj-card{
    background:#fff;border-radius:22px;overflow:hidden;
    border:1px solid rgba(241,245,249,.8);
    box-shadow:0 4px 24px rgba(0,0,0,.07);
    cursor:default;
    opacity:0;transform:translateY(32px) scale(.97);will-change:transform;
}
.proj-card.card-visible{animation:cardIn .65s cubic-bezier(.16,1,.3,1) both;opacity:1;transform:none;}
.proj-card:hover{transform:none !important;box-shadow:0 4px 24px rgba(0,0,0,.07) !important;}

.proj-img-wrap{position:relative;height:260px;overflow:hidden;}
.proj-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .7s cubic-bezier(.16,1,.3,1);}
.proj-img-overlay{
    position:absolute;inset:0;
    background:linear-gradient(to top,rgba(10,20,30,.82) 0%,rgba(10,20,30,.2) 55%,transparent 100%);
    display:flex;flex-direction:column;justify-content:flex-end;padding:16px 18px;
}
.proj-badge{
    display:inline-flex;align-items:center;gap:4px;
    background:rgba(249,115,22,.95);color:#fff;
    font-family:'Outfit',sans-serif;font-size:9px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;
    padding:4px 10px;border-radius:999px;margin-bottom:7px;width:fit-content;
    box-shadow:0 2px 8px rgba(249,115,22,.4);
}
.proj-img-title{color:#fff;font-family:'Outfit',sans-serif;font-size:.92rem;font-weight:800;line-height:1.3;margin:0;text-shadow:0 1px 8px rgba(0,0,0,.4);}
.proj-body{padding:18px 20px 20px;}
.proj-tags{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:11px;}
.proj-tag{
    display:inline-flex;align-items:center;gap:3px;
    background:#f8fafc;border:1px solid #e8edf2;
    color:#64748b;font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;
    padding:3px 9px;border-radius:999px;transition:background .15s,border-color .15s;
}
.proj-tag:hover{background:#fff7ed;border-color:#fed7aa;color:#c2410c;}
.proj-desc{color:#64748b;font-family:'Outfit',sans-serif;font-size:.82rem;line-height:1.65;margin-bottom:14px;}

/* Campaign card button */
.proj-card-btn{
    display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:10px;
    background:linear-gradient(135deg,#1e293b,#0f172a);
    color:rgba(255,255,255,.7);font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;
    border:none;cursor:pointer;box-shadow:0 3px 12px rgba(15,23,42,.2);
    transition:transform .18s,color .18s,box-shadow .18s;
}
.proj-card-btn:hover{transform:translateY(-1px);color:#fbbf24;box-shadow:0 6px 18px rgba(15,23,42,.3);}

/* Inline widget */
.proj-widget-wrap{border-top:1px solid #f1f5f9;background:#f8fafc;overflow:hidden;}
.proj-widget-bar{
    display:flex;align-items:center;justify-content:space-between;
    padding:9px 16px;background:linear-gradient(135deg,#1e293b,#0f172a);
}
.proj-widget-label{
    display:flex;align-items:center;gap:6px;
    font-family:'Outfit',sans-serif;font-size:10px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;
    color:rgba(255,255,255,.6);
}
.proj-widget-label i{color:#fbbf24;}
.proj-widget-ha{font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;color:rgba(255,255,255,.3);display:flex;align-items:center;gap:4px;}
.proj-widget-iframe{
    display:block;width:100%;border:none;height:550px;min-height:300px;
    opacity:0;transition:opacity .4s ease;
}
.proj-widget-iframe.loaded{opacity:1;}

/* ══════════════════════════
   WAYS TO GIVE
══════════════════════════ */
.ways-card{border-radius:22px;overflow:hidden;transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s;position:relative;}
.ways-card:hover{transform:translateY(-5px);}
.ways-card-light{background:#fff;border:2px solid #fed7aa;box-shadow:0 4px 24px rgba(249,115,22,.08);}
.ways-card-light:hover{box-shadow:0 16px 48px rgba(249,115,22,.15);}
.ways-card-dark{background:linear-gradient(145deg,#0c1445,#1a0a3d);border:1px solid rgba(251,191,36,.1);box-shadow:0 4px 24px rgba(0,0,0,.2);}
.ways-card-dark:hover{box-shadow:0 16px 48px rgba(0,0,0,.35);}
.ways-icon{width:52px;height:52px;border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;}

/* ══════════════════════════
   GENERAL DONATE BOX
══════════════════════════ */
.donate-cta-box{
    position:relative;overflow:hidden;
    background:linear-gradient(145deg,var(--sand),var(--cream),var(--sand));
    border:2px solid rgba(251,191,36,.3);border-radius:28px;padding:56px 32px;text-align:center;
    animation:borderAnim 4s ease-in-out infinite;
}
.donate-cta-box::before{
    content:'';position:absolute;inset:-50%;
    background:conic-gradient(from 0deg,transparent,rgba(251,191,36,.05) 25%,transparent 50%,rgba(249,115,22,.04) 75%,transparent);
    animation:float 14s linear infinite;border-radius:50%;
}
.donate-btn{
    display:inline-flex;align-items:center;justify-content:center;gap:10px;
    padding:18px 44px;border-radius:16px;border:none;cursor:pointer;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    color:#fff;font-family:'Outfit',sans-serif;font-size:1rem;font-weight:900;
    letter-spacing:.04em;text-transform:uppercase;
    box-shadow:0 8px 32px rgba(251,191,36,.4);
    position:relative;overflow:hidden;
    transition:transform .25s,box-shadow .25s;
}
.donate-btn::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,transparent,rgba(255,255,255,.18),transparent);transform:translateX(-100%);transition:transform .5s;}
.donate-btn:hover::after{transform:translateX(100%);}
.donate-btn:hover{transform:translateY(-3px) scale(1.02);box-shadow:0 16px 44px rgba(251,191,36,.52);color:#fff;}
.helloasso-badge{
    display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:999px;
    background:#f1f5f9;font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;color:#64748b;
    border:1px solid #e2e8f0;
}
.secure-row{display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;font-family:'Outfit',sans-serif;font-size:12px;font-weight:600;color:#94a3b8;}
.secure-row span{display:flex;align-items:center;gap:5px;}

/* ══════════════════════════
   MODAL
══════════════════════════ */
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

/* Responsive */
@media(max-width:640px){
    .page-hero{min-height:auto;}
    .page-hero-content{padding:72px 16px 290px;}
    .photo-strip{height:210px;}
    .hero-stats{gap:20px;}
    .proj-img-wrap{height:200px;}
    .proj-modal-bg{align-items:flex-end;padding:0;}
    .proj-modal{max-height:92vh;border-radius:22px 22px 0 0;width:100%;max-width:100%;}
    .proj-widget-iframe{height:480px;}
}
@media(max-width:380px){.hero-stats{display:none;}}
</style>

{{-- ══ HERO ══ --}}
<section class="page-hero">
    <canvas id="starCanvas"></canvas>
    <div class="dawn-glow"></div>
    <div class="rays-wrap" id="raysWrap"></div>

    <div class="photo-strip">
        @foreach(range(5 ,15) as $n)
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
            <span>Make a Donation</span>
        </nav>

        <div class="hero-pill">
            <div class="hero-pill-dot"></div> Give Today
        </div>

        <h1 class="hero-h1">
            Every Gift<br>
            <span class="glow">Changes a Life</span>
        </h1>

        <p class="hero-sub">
            Individuals and companies — every contribution makes a real, lasting difference for children in Cambodia.
        </p>

        <div class="hero-btns">
            <a href="#projectGrid" class="btn-gold">
                <i class="fas fa-hand-holding-heart"></i> Donate Now
            </a>
            <a href="{{ route('sponsor.children') }}" class="btn-ghost">
                <i class="fas fa-heart"></i> Sponsor a Child
            </a>
        </div>

        <div class="hero-stats">
            @foreach([
                [number_format($donationProjects->count()),'Active Projects'],
                ['100%','To the Field'],
                ['95K+','Children Helped'],
                ['🇰🇭','Cambodia']
            ] as [$n,$l])
            <div class="h-stat">
                <div class="hero-stat-n">{{ $n }}</div>
                <div class="hero-stat-l">{{ $l }}</div>
            </div>
            @if(!$loop->last)<div class="hero-stat-div"></div>@endif
            @endforeach
        </div>
    </div>
</section>

<div class="wave-divider" style="background:linear-gradient(180deg,#f0f4f8,#e8edf2);">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,40 C480,68 960,10 1440,40 L1440,0 L0,0 Z" fill="#04091f"/>
    </svg>
</div>

{{-- ══ PROJECTS ══ --}}
<section class="py-16 md:py-28" style="background:linear-gradient(180deg,#f0f4f8,#e8edf2);">
    <div class="max-w-6xl mx-auto px-4">

        <div class="text-center mb-12 reveal">
            <div class="section-pill mx-auto mb-4"><span class="dot"></span> Active Campaigns</div>
            <h2 class="text-2xl md:text-4xl font-black" style="font-family:'Cormorant Garamond',serif;color:#1e3a4a;margin-bottom:8px;letter-spacing:-.02em;">
                Support a Specific Project
            </h2>
            <p class="text-gray-500 max-w-md mx-auto" style="font-family:'Outfit',sans-serif;font-size:.9rem;">
                Each card contains a live donation form — secure, fast, and transparent.
            </p>
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
            <div class="proj-card"
                 data-title="{{ e($title) }}"
                 data-vignette="{{ e($project->helloasso_vignette_url ?? '') }}"
                 data-img="{{ $imgUrl }}">
                <div class="proj-img-wrap">
                    <img src="{{ $imgUrl }}" alt="{{ e($title) }}" loading="lazy">
                    <div class="proj-img-overlay">
                        <span class="proj-badge" style="{{ $badgeStyle }}">
                            <i class="fas fa-fire text-[9px]"></i> {{ $project->badge_label ?? 'Active' }}
                        </span>
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

        {{-- Ways to Give --}}
        <div class="reveal stagger-3">
            <div class="text-center mb-8">
                <div class="section-pill mx-auto mb-4"><span class="dot"></span> Ways to Give</div>
                <h3 class="text-2xl md:text-3xl font-black" style="font-family:'Cormorant Garamond',serif;color:#1c1033;letter-spacing:-.02em;">Choose How You Give</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="ways-card ways-card-light p-8">
                    <div class="ways-icon bg-orange-100"><i class="fas fa-user text-orange-500 text-xl"></i></div>
                    <div class="section-pill mb-3" style="font-size:10px;background:rgba(249,115,22,.08);border-color:rgba(249,115,22,.15);">
                        <i class="fas fa-heart text-orange-400 text-[9px]"></i> Individual
                    </div>
                    <h3 class="text-lg font-black text-gray-900 mb-2" style="font-family:'Outfit',sans-serif;">Individual Donation</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-5" style="font-family:'Outfit',sans-serif;">Every euro goes directly to the field to support vulnerable children and families in Cambodia.</p>
                    <div class="space-y-2.5">
                        @foreach(['One-time donation','Monthly recurring','Donation in memoriam','Birthday fundraiser'] as $t)
                        <div class="flex items-center gap-2.5 text-sm text-gray-600" style="font-family:'Outfit',sans-serif;">
                            <span class="w-5 h-5 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-orange-500 text-[9px]"></i>
                            </span>{{ $t }}
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="ways-card ways-card-dark p-8">
                    <div class="ways-icon" style="background:rgba(251,191,36,.08);"><i class="fas fa-building text-yellow-400 text-xl"></i></div>
                    <div class="section-pill mb-3" style="font-size:10px;background:rgba(251,191,36,.08);border-color:rgba(251,191,36,.2);color:#d97706;">
                        <i class="fas fa-city text-[9px]"></i> Corporate
                    </div>
                    <h3 class="text-lg font-black text-white mb-2" style="font-family:'Outfit',sans-serif;">Corporate Donation</h3>
                    <p class="text-white/55 text-sm leading-relaxed mb-5" style="font-family:'Outfit',sans-serif;">Tailored partnership packages with visibility, impact reports, and employee engagement.</p>
                    <div class="space-y-2.5">
                        @foreach(['Single or recurring gift','Skills-based sponsorship','Employee matching','Named project funding'] as $t)
                        <div class="flex items-center gap-2.5 text-sm text-white/70" style="font-family:'Outfit',sans-serif;">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0" style="background:rgba(251,191,36,.1);">
                                <i class="fas fa-check text-[9px]" style="color:#fbbf24;"></i>
                            </span>{{ $t }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ CAMPAIGN CARD MODAL ══ --}}
<div id="projModalBg" class="proj-modal-bg" onclick="closeProjModal(event)">
    <div class="proj-modal" id="projModal">
        <div class="proj-modal-head">
            <img src="" id="projModalImg" class="proj-modal-head-img" alt="">
            <div class="proj-modal-head-overlay">
                <div class="proj-badge mb-1.5" style="width:fit-content;background:linear-gradient(135deg,rgba(251,191,36,.9),rgba(249,115,22,.9));">
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
        <div style="flex:1;overflow-y:auto;display:flex;flex-direction:column;align-items:center;padding:24px 16px;gap:14px;background:linear-gradient(180deg,#f0f4f8,#e8edf5);">
            <p style="font-family:'Outfit',sans-serif;font-size:12px;color:#64748b;text-align:center;max-width:320px;line-height:1.65;margin:0;">
                This <strong style="color:#1e293b;">live campaign card</strong> updates automatically with your HelloAsso fundraiser progress.
            </p>
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

{{-- ══ GENERAL DONATION CTA ══ --}}
<section class="bg-white py-16 md:py-24">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <div class="donate-cta-box reveal">
            <div class="relative z-10">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg" style="shadow-color:rgba(251,191,36,.2);animation:heartBeat 2.5s ease infinite;box-shadow:0 8px 24px rgba(251,191,36,.2);">
                    <i class="fas fa-heart text-2xl" style="color:#f97316;"></i>
                </div>
                <div class="section-pill mx-auto mb-4" style="font-size:11px;"><span class="dot"></span> General Fund</div>
                <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-3" style="font-family:'Cormorant Garamond',serif;letter-spacing:-.02em;">Make a General Donation</h2>
                <p class="text-gray-500 text-base mb-8 max-w-xs mx-auto leading-relaxed" style="font-family:'Outfit',sans-serif;">Support where the need is greatest — funds go to the most urgent programs.</p>
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
                <span class="helloasso-badge"><i class="fas fa-external-link-alt text-[10px]"></i> Powered by HelloAsso</span>
            </div>
        </div>
    </div>
</section>

{{-- ══ BOTTOM CTA ══ --}}
<section class="bg-white pb-16 md:pb-24">
    <div class="max-w-7xl mx-auto px-4">
        <div class="rounded-2xl md:rounded-3xl p-8 md:p-14 relative overflow-hidden reveal"
             style="background:linear-gradient(135deg,#04091f 0%,#0c1445 55%,#1a0a3d 100%);">
            <div class="absolute inset-0" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.07;"></div>
            <div class="absolute bottom:-80px left:50%;transform:translateX(-50%);width:700px;height:300px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.12) 0%,rgba(249,115,22,.06) 45%,transparent 70%);pointer-events:none;"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-6">
                <div class="text-white text-center lg:text-left">
                    <p style="font-family:'Outfit',sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(251,191,36,.5);margin-bottom:10px;">
                        <i class="fas fa-star mr-1"></i> Make an Impact
                    </p>
                    <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;color:#fff;line-height:1.08;letter-spacing:-.02em;margin-bottom:10px;">
                        Make a Difference <em style="font-style:italic;background:linear-gradient(90deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Today</em>
                    </h2>
                    <p style="font-family:'Outfit',sans-serif;color:rgba(255,255,255,.5);font-size:.9rem;max-width:420px;line-height:1.78;">Your support funds programs that change children's lives in Cambodia.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}"
                       style="display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:16px 28px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#1c1033;font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:800;border-radius:14px;text-decoration:none;box-shadow:0 8px 28px rgba(251,191,36,.3);transition:transform .2s,box-shadow .2s;"
                       onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 16px 40px rgba(251,191,36,.45)'"
                       onmouseout="this.style.transform='';this.style.boxShadow='0 8px 28px rgba(251,191,36,.3)'">
                        <i class="fas fa-heart"></i> Sponsor a Child
                    </a>
                    <button id="openHaDonate2"
                            style="display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:16px 28px;background:rgba(251,191,36,.08);border:1.5px solid rgba(251,191,36,.28);color:rgba(255,255,255,.8);font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:700;border-radius:14px;cursor:pointer;transition:background .2s,border-color .2s;"
                            onmouseover="this.style.background='rgba(251,191,36,.15)';this.style.borderColor='rgba(251,191,36,.55)'"
                            onmouseout="this.style.background='rgba(251,191,36,.08)';this.style.borderColor='rgba(251,191,36,.28)'">
                        <i class="fas fa-hand-holding-heart"></i> Make a Donation
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ HELLOASSO MODAL ══ --}}
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
/* ═══════════ STARS ═══════════ */
(function(){
    var c=document.getElementById('starCanvas'),ctx=c.getContext('2d'),W,H,stars=[],shots=[];
    function resize(){W=c.width=window.innerWidth;H=c.height=window.innerHeight;}
    window.addEventListener('resize',resize);resize();
    for(var i=0;i<200;i++) stars.push({x:Math.random()*100,y:Math.random()*100,r:Math.random()*1.3+.2,s:Math.random()*2+1,p:Math.random()*Math.PI*2,warm:Math.random()<.18});
    function spawnShot(){shots.push({x:Math.random()*W*.6+W*.1,y:Math.random()*H*.4,vx:(Math.random()*3+4)*(Math.random()<.5?1:-1),vy:Math.random()*2+1,life:1,decay:Math.random()*.015+.01,len:Math.random()*80+40});}
    setInterval(spawnShot,2400);setTimeout(spawnShot,500);
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
            var g=ctx.createLinearGradient(s.x,s.y,s.x-s.vx*8,s.y-s.vy*8);
            g.addColorStop(0,'rgba(251,191,36,'+s.life*.9+')');g.addColorStop(.4,'rgba(255,220,100,'+s.life*.4+')');g.addColorStop(1,'transparent');
            ctx.beginPath();ctx.moveTo(s.x,s.y);ctx.lineTo(s.x-s.vx*(s.len/10),s.y-s.vy*(s.len/10));
            ctx.strokeStyle=g;ctx.lineWidth=s.life*2.5;ctx.lineCap='round';ctx.stroke();return true;
        });
        t++;requestAnimationFrame(draw);
    }
    draw();
})();

/* ═══════════ RAYS ═══════════ */
(function(){
    var wrap=document.getElementById('raysWrap');
    for(var i=0;i<14;i++){
        var r=document.createElement('div');r.className='ray';
        var angle=(i/13)*70-35,h=180+Math.random()*200,op=.07+Math.random()*.16,delay=Math.random()*3;
        r.style.cssText='left:calc(50% + '+angle+'px);height:'+h+'px;opacity:'+op+';animation-delay:'+delay+'s;animation-duration:'+(2.4+Math.random()*2)+'s;transform:rotate('+angle*.6+'deg);background:linear-gradient(to top,rgba(251,191,36,0.42),transparent)';
        wrap.appendChild(r);
    }
})();

/* ═══════════ MODAL ═══════════ */
function openProjModalTab(card){
    var vigUrl=card.getAttribute('data-vignette')||'';if(!vigUrl)return;
    document.getElementById('projModalTitle').textContent=card.getAttribute('data-title');
    document.getElementById('projModalImg').src=card.getAttribute('data-img');
    var vi=document.getElementById('projVignetteIframe');vi.style.opacity='0';if(vi.src!==vigUrl)vi.src=vigUrl;
    document.getElementById('projModalBg').classList.add('open');document.body.style.overflow='hidden';
}
function closeProjModalDirect(){document.getElementById('projModalBg').classList.remove('open');document.getElementById('projVignetteIframe').src='';document.body.style.overflow='';}
function closeProjModal(e){if(e.target===document.getElementById('projModalBg'))closeProjModalDirect();}
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeProjModalDirect();});

/* ═══════════ CARD ENTRANCE ═══════════ */
(function(){
    var cards=document.querySelectorAll('.proj-card');
    var obs=new IntersectionObserver(function(entries){
        entries.forEach(function(entry){if(entry.isIntersecting){var delay=Array.from(cards).indexOf(entry.target)*110;setTimeout(function(){entry.target.classList.add('card-visible');},delay);obs.unobserve(entry.target);}});
    },{threshold:.05});
    cards.forEach(function(c){obs.observe(c);});
})();

/* ═══════════ SCROLL REVEAL ═══════════ */
(function(){
    var els=document.querySelectorAll('.reveal,.reveal-scale');
    var obs=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('visible');obs.unobserve(e.target);}});},{threshold:.08,rootMargin:'0px 0px -50px 0px'});
    els.forEach(function(el){obs.observe(el);});
})();

/* ═══════════ IFRAME AUTORESIZE ═══════════ */
window.addEventListener('message',function(e){
    if(!e.data)return;var h=null;
    if(typeof e.data==='object')h=e.data.height||e.data.newHeight||null;
    if(typeof e.data==='string'){try{var p=JSON.parse(e.data);h=p.height||p.newHeight;}catch(x){}}
    if(h&&h>100){document.querySelectorAll('.proj-widget-iframe').forEach(function(iframe){if(!iframe.dataset.manualHeight)iframe.style.height=Math.ceil(h)+'px';});}
});

/* ═══════════ HELLOASSO MODAL ═══════════ */
document.addEventListener('DOMContentLoaded',function(){
    var modal=document.getElementById('haWidgetModalDonate');
    var closeBtn=document.getElementById('closeHaDonateBtn');
    function openModal(){modal.style.display='flex';document.body.style.overflow='hidden';}
    function closeModal(){modal.style.display='none';document.body.style.overflow='';}
    document.getElementById('openHaDonate1')?.addEventListener('click',openModal);
    document.getElementById('openHaDonate2')?.addEventListener('click',openModal);
    closeBtn.addEventListener('click',closeModal);
    closeBtn.addEventListener('mouseenter',function(){closeBtn.style.background='#E0E0E8';});
    closeBtn.addEventListener('mouseleave',function(){closeBtn.style.background='#EFEFF4';});
    modal.addEventListener('click',function(e){if(e.target===modal)closeModal();});
});
</script>
@endsection