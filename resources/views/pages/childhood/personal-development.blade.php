{{-- resources/views/pages/childhood/personal-development.blade.php --}}
@extends('layouts.app')
@section('title', 'Personal Development')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{
    --or:#f97316;--or-d:#ea580c;--amber:#f59e0b;
    --navy:#06101f;--ink:#0f1c2e;--muted:#64748b;
    --cream:#fefdf9;--sand:#f5f0e8;
}

@keyframes fadeUp {from{opacity:0;transform:translateY(36px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn {from{opacity:0}to{opacity:1}}
@keyframes driftL {0%,100%{transform:translateX(0) translateY(0)}50%{transform:translateX(-18px) translateY(-12px)}}
@keyframes driftR {0%,100%{transform:translateX(0) translateY(0)}50%{transform:translateX(18px) translateY(12px)}}
@keyframes pulse  {0%,100%{opacity:1}50%{opacity:.4}}
@keyframes shimmer{from{background-position:-200% 0}to{background-position:200% 0}}
@keyframes floatUp{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}

.reveal{opacity:0;transform:translateY(30px);transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
.reveal.in{opacity:1;transform:none}
.d1{transition-delay:.08s}.d2{transition-delay:.17s}.d3{transition-delay:.26s}.d4{transition-delay:.35s}

/* ── Hero ── */
.pd-hero{position:relative;overflow:hidden;background:var(--navy);min-height:100vh;display:flex;align-items:center;}
.hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;filter:brightness(.2) saturate(1.5);}
.hero-grad{position:absolute;inset:0;background:linear-gradient(135deg,rgba(6,16,31,.98) 0%,rgba(6,16,31,.65) 55%,rgba(249,115,22,.12) 100%);}

/* Decorative rings */
.ring{position:absolute;border-radius:50%;border:1.5px solid rgba(249,115,22,.12);pointer-events:none;}
.ring-1{width:600px;height:600px;top:-150px;right:-150px;animation:driftR 13s ease-in-out infinite;}
.ring-2{width:380px;height:380px;bottom:5%;left:-80px;animation:driftL 10s ease-in-out infinite;border-color:rgba(249,115,22,.07);}
.ring-3{width:200px;height:200px;top:30%;right:20%;background:radial-gradient(circle,rgba(249,115,22,.07),transparent 70%);border:none;animation:floatUp 8s ease-in-out infinite;}

/* Floating trait tags */
.float-tag{
    position:absolute;z-index:3;
    font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;
    padding:8px 16px;border-radius:999px;
    background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.14);
    color:rgba(255,255,255,.6);backdrop-filter:blur(8px);
    white-space:nowrap;pointer-events:none;
}
.ft-1{top:18%;right:8%;animation:floatUp 7s ease-in-out infinite;}
.ft-2{top:38%;right:4%;animation:floatUp 9s 1s ease-in-out infinite;}
.ft-3{bottom:22%;right:12%;animation:floatUp 8s 2s ease-in-out infinite;}

.hero-inner{position:relative;z-index:2;padding:120px 20px 100px;max-width:1280px;margin:0 auto;width:100%;display:grid;grid-template-columns:1fr 440px;gap:72px;align-items:center;}

.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.32);margin-bottom:28px;}
.breadcrumb a{color:rgba(255,255,255,.32);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:rgba(249,115,22,.8);}
.breadcrumb span{color:rgba(255,255,255,.6);}

.hero-eyebrow{display:inline-flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--or);margin-bottom:22px;}
.eyebrow-line{width:32px;height:2px;background:var(--or);border-radius:2px;}

.hero-h1{font-family:'Fraunces',serif;font-size:clamp(2.8rem,5.5vw,4.8rem);font-weight:900;line-height:1.02;color:#fff;letter-spacing:-.03em;margin-bottom:22px;}
.hero-h1 em{font-style:italic;background:linear-gradient(90deg,#f97316,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}

.hero-sub{font-family:'Plus Jakarta Sans',sans-serif;font-size:.975rem;color:rgba(255,255,255,.52);line-height:1.82;max-width:460px;margin-bottom:38px;}

.hero-btn{display:inline-flex;align-items:center;gap:11px;font-family:'Plus Jakarta Sans',sans-serif;font-size:.875rem;font-weight:700;padding:16px 32px;border-radius:14px;background:linear-gradient(135deg,var(--or),var(--or-d));color:#fff;text-decoration:none;box-shadow:0 8px 32px rgba(249,115,22,.4);transition:transform .22s,box-shadow .22s;}
.hero-btn:hover{transform:translateY(-3px);box-shadow:0 16px 44px rgba(249,115,22,.55);color:#fff;}
.hero-btn .arrow{transition:transform .2s;}
.hero-btn:hover .arrow{transform:translateX(4px);}

/* Right panel — trait wheel */
.trait-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.trait-card{
    background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);
    border-radius:20px;padding:22px 20px;
    backdrop-filter:blur(10px);
    transition:background .25s,border-color .25s,transform .25s;
}
.trait-card:hover{background:rgba(249,115,22,.1);border-color:rgba(249,115,22,.3);transform:translateY(-3px);}
.trait-icon{width:42px;height:42px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:17px;margin-bottom:12px;}
.trait-name{font-family:'Fraunces',serif;font-size:1rem;font-weight:700;color:#fff;margin-bottom:5px;}
.trait-desc{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;color:rgba(255,255,255,.38);line-height:1.55;}

/* ── Section tag ── */
.sec-tag{display:inline-flex;align-items:center;gap:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;padding:6px 16px;border-radius:999px;background:rgba(249,115,22,.1);border:1px solid rgba(249,115,22,.2);color:var(--or-d);}
.dot-p{width:6px;height:6px;border-radius:50%;background:var(--or);animation:pulse 1.8s ease-in-out infinite;}

/* ── Cards — horizontal timeline style ── */
.timeline-wrap{position:relative;padding-left:48px;}
.timeline-wrap::before{content:'';position:absolute;left:17px;top:0;bottom:0;width:2px;background:linear-gradient(to bottom,var(--or),rgba(249,115,22,.1));}

.tl-card{
    position:relative;margin-bottom:28px;
    background:#fff;border-radius:22px;overflow:hidden;
    border:1px solid #f1f5f9;
    box-shadow:0 4px 24px rgba(0,0,0,.06);
    display:grid;grid-template-columns:340px 1fr;
    transition:transform .38s cubic-bezier(.16,1,.3,1),box-shadow .38s;
}
.tl-card:hover{transform:translateX(6px);box-shadow:0 16px 48px rgba(0,0,0,.11);}
.tl-card:last-child{margin-bottom:0;}

/* Timeline node */
.tl-node{
    position:absolute;left:-40px;top:32px;
    width:26px;height:26px;border-radius:50%;
    background:linear-gradient(135deg,var(--or),var(--or-d));
    border:3px solid var(--cream);
    box-shadow:0 0 0 4px rgba(249,115,22,.2);
    z-index:1;
    display:flex;align-items:center;justify-content:center;
    font-family:'Fraunces',serif;font-size:10px;font-weight:900;color:#fff;
    transition:transform .25s,box-shadow .25s;
}
.tl-card:hover .tl-node{transform:scale(1.2);box-shadow:0 0 0 6px rgba(249,115,22,.25);}

/* Image */
.tl-img{position:relative;overflow:hidden;}
.tl-img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .7s cubic-bezier(.16,1,.3,1);}
.tl-card:hover .tl-img img{transform:scale(1.07);}
.tl-img::after{content:'';position:absolute;inset:0;background:linear-gradient(to right,transparent 60%,rgba(255,255,255,.08) 100%);pointer-events:none;}

/* Text */
.tl-body{padding:36px 40px;display:flex;flex-direction:column;justify-content:center;}
.tl-cat{display:inline-flex;align-items:center;gap:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:9.5px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;padding:4px 12px;border-radius:999px;width:fit-content;margin-bottom:12px;}
.tl-title{font-family:'Fraunces',serif;font-size:1.45rem;font-weight:900;color:var(--ink);line-height:1.2;margin-bottom:12px;transition:color .2s;}
.tl-card:hover .tl-title{color:var(--or-d);}
.tl-desc{font-family:'Plus Jakarta Sans',sans-serif;font-size:.875rem;color:var(--muted);line-height:1.78;margin-bottom:20px;}
.tl-link{display:inline-flex;align-items:center;gap:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;letter-spacing:.07em;text-transform:uppercase;text-decoration:none;padding-bottom:1.5px;border-bottom:1.5px solid transparent;transition:border-color .22s,gap .22s;}
.tl-link:hover{gap:11px;}

/* ── Values band ── */
.values-band{background:linear-gradient(135deg,#0f1c2e,#1a2f42);padding:72px 20px;}
.val-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:rgba(255,255,255,.06);border-radius:20px;overflow:hidden;}
.val-item{background:#0f1c2e;padding:36px 24px;text-align:center;transition:background .22s;}
.val-item:hover{background:#162234;}
.val-icon{width:56px;height:56px;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:22px;margin:0 auto 14px;}
.val-num{font-family:'Fraunces',serif;font-size:2rem;font-weight:900;background:linear-gradient(135deg,#f97316,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;margin-bottom:4px;}
.val-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.09em;}

/* ── Quote strip ── */
.quote-strip{position:relative;overflow:hidden;background:var(--ink);padding:80px 20px;}
.qs-bg{position:absolute;inset:0;background:linear-gradient(135deg,rgba(249,115,22,.09) 0%,transparent 60%);}
.qs-decor{position:absolute;right:-40px;top:50%;transform:translateY(-50%);font-family:'Fraunces',serif;font-size:26rem;font-weight:900;color:rgba(255,255,255,.022);line-height:1;pointer-events:none;user-select:none;}
.qs-text{font-family:'Fraunces',serif;font-style:italic;font-size:clamp(1.35rem,3vw,2rem);font-weight:700;color:#fff;line-height:1.48;max-width:740px;position:relative;z-index:1;}
.qs-text span{color:var(--or);}
.qs-src{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.1em;margin-top:18px;position:relative;z-index:1;}

/* ── CTA ── */
.cta-outer{background:var(--cream);padding:80px 20px;}
.cta-inner{max-width:1100px;margin:0 auto;background:linear-gradient(135deg,#ea580c,#f97316 55%,#f59e0b);border-radius:32px;padding:72px 56px;position:relative;overflow:hidden;}
.cta-inner::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.06;}
.cta-orb{position:absolute;border-radius:50%;filter:blur(60px);pointer-events:none;}
.cta-o1{width:360px;height:360px;background:rgba(255,255,255,.1);top:-100px;right:-80px;}
.cta-o2{width:240px;height:240px;background:rgba(0,0,0,.1);bottom:-60px;left:5%;}

@media(max-width:1024px){
    .hero-inner{grid-template-columns:1fr;gap:48px;}
    .trait-grid{grid-template-columns:repeat(2,1fr);}
    .ft-1,.ft-2,.ft-3{display:none;}
}
@media(max-width:900px){
    .tl-card{grid-template-columns:1fr;}
    .tl-img{height:220px;}
    .tl-body{padding:28px 24px;}
    .timeline-wrap{padding-left:36px;}
    .tl-node{left:-30px;}
    .val-grid{grid-template-columns:repeat(2,1fr);}
}
@media(max-width:640px){
    .pd-hero{min-height:auto;}
    .hero-inner{padding:80px 16px 64px;}
    .ring-1,.ring-2,.ring-3{display:none;}
    .tl-card{border-radius:16px;}
    .tl-title{font-size:1.2rem;}
    .qs-decor{display:none;}
    .cta-inner{padding:48px 24px;border-radius:22px;}
}
</style>

{{-- ══ HERO ══ --}}
<section class="pd-hero">
    <div class="hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="hero-grad"></div>
    <div class="ring ring-1"></div>
    <div class="ring ring-2"></div>
    <div class="ring ring-3"></div>
    <div class="float-tag ft-1"><i class="fas fa-fist-raised mr-2 text-orange-400"></i> Self-Confidence</div>
    <div class="float-tag ft-2"><i class="fas fa-brain mr-2 text-blue-400"></i> Emotional Skills</div>
    <div class="float-tag ft-3"><i class="fas fa-paint-brush mr-2 text-green-400"></i> Creativity</div>

    <div class="hero-inner">
        {{-- Left --}}
        <div>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <span>Our Actions</span>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <span>Childhood</span>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <span>Personal Development</span>
            </nav>
            <div class="hero-eyebrow" style="animation:fadeUp .6s ease both;">
                <div class="eyebrow-line"></div> Child Growth
            </div>
            <h1 class="hero-h1" style="animation:fadeUp .75s ease both;">
                Growing<br>
                <em>Beyond</em><br>
                Limits
            </h1>
            <p class="hero-sub" style="animation:fadeUp .75s .16s ease both;">
                Nurturing confidence, creativity, and resilience — giving every child in Cambodia the tools to shape their own story.
            </p>
            <a href="{{ route('sponsor.children') }}" class="hero-btn" style="animation:fadeUp .75s .3s ease both;">
                <i class="fas fa-seedling"></i>
                Sponsor a Child
                <i class="fas fa-arrow-right text-sm arrow"></i>
            </a>
        </div>

        {{-- Right — trait grid ── --}}
        <div class="trait-grid" style="animation:fadeIn .9s .42s ease both;">
            @foreach([
                ['fas fa-fist-raised','bg-orange-900/30','#f97316','Self-Confidence','Believing in your own power to act'],
                ['fas fa-brain','bg-blue-900/30','#60a5fa','Emotional Skills','Managing feelings and relationships'],
                ['fas fa-paint-brush','bg-green-900/30','#4ade80','Creativity','Expressing identity through art and play'],
                ['fas fa-road','bg-purple-900/30','#c084fc','Resilience','Bouncing back stronger every time'],
            ] as [$ico,$bg,$clr,$name,$d])
            <div class="trait-card">
                <div class="trait-icon" style="background:{{ $bg }};">
                    <i class="{{ $ico }}" style="color:{{ $clr }};"></i>
                </div>
                <div class="trait-name">{{ $name }}</div>
                <div class="trait-desc">{{ $d }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ TIMELINE CARDS ══ --}}
<section style="background:var(--cream);padding:80px 0 96px;">
    <div class="max-w-6xl mx-auto px-4">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16 reveal">
            <div>
                <div class="sec-tag mb-4"><span class="dot-p"></span> Personal Development</div>
                <h2 style="font-family:'Fraunces',serif;font-size:clamp(2rem,4.5vw,3rem);font-weight:900;color:var(--ink);line-height:1.1;letter-spacing:-.02em;">
                    Four Paths to<br>
                    <span style="background:linear-gradient(90deg,#f97316,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Personal Growth</span>
                </h2>
            </div>
            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:.9rem;color:var(--muted);max-width:360px;line-height:1.78;flex-shrink:0;">
                Every child has unique potential. We create spaces where confidence, emotion, creativity, and resilience can flourish together.
            </p>
        </div>

        @php
        $cards = [
            [
                'img'   => 'images/children/image-1.jpg',
                'icon'  => 'fas fa-fist-raised',
                'color' => '#fff7ed','ic' => '#f97316',
                'cat'   => 'Self-Confidence',
                'title' => 'Building Self-Confidence',
                'desc'  => 'Self-confidence is key to enabling children to believe in their abilities and face life\'s challenges. Des Ailes pour Grandir offers psychosocial activities and workshops that help each child feel valued, recognized, and capable of taking action for their future.',
            ],
            [
                'img'   => 'images/children/image-9.jpg',
                'icon'  => 'fas fa-brain',
                'color' => '#eff6ff','ic' => '#3b82f6',
                'cat'   => 'Emotional Intelligence',
                'title' => 'Social and Emotional Skills',
                'desc'  => 'Well-being involves managing emotions and interacting positively with others. Our programs develop empathy, communication, and cooperation, giving children tools to handle conflicts, express themselves confidently, and build healthy relationships.',
            ],
            [
                'img'   => 'images/children/image-10.jpg',
                'icon'  => 'fas fa-paint-brush',
                'color' => '#f0fdf4','ic' => '#22c55e',
                'cat'   => 'Creative Expression',
                'title' => 'Creativity and Personal Expression',
                'desc'  => 'Artistic and creative expression is a powerful way for children to discover their identity and unlock their potential. Des Ailes pour Grandir organizes artistic, cultural, and sports workshops that foster imagination and confidence in unique talents.',
            ],
            [
                'img'   => 'images/children/image-11.jpg',
                'icon'  => 'fas fa-road',
                'color' => '#faf5ff','ic' => '#a855f7',
                'cat'   => 'Resilience',
                'title' => 'Resilience and Preparing for the Future',
                'desc'  => 'Supporting a child means giving them the means to overcome obstacles and envision a secure future. We encourage resilience and perseverance through activities that strengthen motivation and the capacity to build a fulfilling personal path.',
            ],
        ];
        @endphp

        <div class="timeline-wrap">
            @foreach($cards as $i => $c)
            <div class="tl-card reveal d{{ $i+1 }}">
                <div class="tl-node">{{ $i+1 }}</div>
                <div class="tl-img">
                    <img src="{{ asset($c['img']) }}" alt="{{ $c['title'] }}" loading="lazy">
                </div>
                <div class="tl-body">
                    <div class="tl-cat" style="background:{{ $c['color'] }};color:{{ $c['ic'] }};border:1px solid {{ $c['ic'] }}25;">
                        <i class="{{ $c['icon'] }}" style="font-size:9px;"></i> {{ $c['cat'] }}
                    </div>
                    <h3 class="tl-title">{{ $c['title'] }}</h3>
                    <p class="tl-desc">{{ $c['desc'] }}</p>
                    <a href="{{ route('sponsor.children') }}" class="tl-link"
                       style="color:{{ $c['ic'] }};border-color:{{ $c['ic'] }}40;">
                        Learn more <i class="fas fa-arrow-right" style="font-size:9px;"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ VALUES BAND ══ --}}
<section class="values-band reveal">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <div class="sec-tag mx-auto mb-4" style="background:rgba(249,115,22,.08);border-color:rgba(249,115,22,.18);display:inline-flex;">
                <span class="dot-p"></span> By the Numbers
            </div>
            <h2 style="font-family:'Fraunces',serif;font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:900;color:#fff;letter-spacing:-.02em;">
                Our Impact on Children
            </h2>
        </div>
        <div class="val-grid">
            @foreach([
                ['fas fa-fist-raised','bg-orange-900/40','#f97316','4','Programs'],
                ['fas fa-child','bg-blue-900/40','#60a5fa','95K+','Children/Year'],
                ['fas fa-heart','bg-green-900/40','#4ade80','84%','To the Field'],
                ['fas fa-star','bg-purple-900/40','#c084fc','1958','Since'],
            ] as [$ico,$bg,$clr,$num,$lbl])
            <div class="val-item">
                <div class="val-icon" style="background:{{ $bg }};">
                    <i class="{{ $ico }}" style="color:{{ $clr }};"></i>
                </div>
                <div class="val-num">{{ $num }}</div>
                <div class="val-label">{{ $lbl }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ QUOTE STRIP ══ --}}
<section class="quote-strip reveal">
    <div class="qs-bg"></div>
    <div class="qs-decor">"</div>
    <div class="max-w-5xl mx-auto px-4 text-center">
        <div style="font-size:2.4rem;color:var(--or);line-height:1;margin-bottom:14px;font-family:'Fraunces',serif;">"</div>
        <p class="qs-text mx-auto">
            A child who believes in themselves can <span>change the world</span> — our mission is to make every child believe they can.
        </p>
        <div class="qs-src mx-auto">— Des Ailes pour Grandir · Cambodia</div>
    </div>
</section>

{{-- ══ CTA ══ --}}
<div class="cta-outer reveal">
    <div class="cta-inner">
        <div class="cta-orb cta-o1"></div>
        <div class="cta-orb cta-o2"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
            <div class="text-white text-center lg:text-left">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:12px;">
                    <i class="fas fa-seedling mr-1"></i> Support Development
                </p>
                <h2 style="font-family:'Fraunces',serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;color:#fff;line-height:1.1;letter-spacing:-.02em;margin-bottom:12px;">
                    Make a Difference<br><em style="font-style:italic;">Today</em>
                </h2>
                <p style="font-family:'Plus Jakarta Sans',sans-serif;color:rgba(255,255,255,.68);font-size:.9rem;max-width:380px;line-height:1.75;">
                    Your support helps build confidence, creativity, and resilience in children who need it most.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                <a href="{{ route('sponsor.children') }}"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 36px;background:#fff;color:#ea580c;font-family:'Plus Jakarta Sans',sans-serif;font-size:.875rem;font-weight:800;border-radius:16px;text-decoration:none;box-shadow:0 10px 32px rgba(0,0,0,.18);transition:transform .22s,box-shadow .22s;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 18px 44px rgba(0,0,0,.25)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='0 10px 32px rgba(0,0,0,.18)'">
                    <i class="fas fa-heart"></i> Sponsor a Child
                </a>
                <a href="{{ route('support.donate') }}"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 36px;background:rgba(255,255,255,.12);border:2px solid rgba(255,255,255,.3);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:.875rem;font-weight:800;border-radius:16px;text-decoration:none;transition:background .2s,border-color .2s;"
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
        entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('in'); o.unobserve(e.target); }});
    },{threshold:.07,rootMargin:'0px 0px -40px 0px'});
    document.querySelectorAll('.reveal').forEach(function(el){ o.observe(el); });
})();
</script>
@endsection