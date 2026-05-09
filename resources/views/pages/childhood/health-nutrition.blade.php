{{-- resources/views/pages/childhood/health-nutrition.blade.php --}}
@extends('layouts.app')
@section('title', 'Health & Nutrition')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Montserrat:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
:root {
    --orange: #f97316;
    --orange-d: #ea580c;
    --navy: #0f172a;
    --ink: #1e293b;
}

@keyframes fadeUp  { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
@keyframes floatY  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
@keyframes orb     { 0%,100%{transform:translate(0,0)} 50%{transform:translate(30px,-20px)} }

.reveal       { opacity:0;transform:translateY(28px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1) }
.reveal-left  { opacity:0;transform:translateX(-36px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1) }
.reveal-right { opacity:0;transform:translateX(36px); transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1) }
.reveal-scale { opacity:0;transform:scale(.93);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1) }
.reveal.visible,.reveal-left.visible,.reveal-right.visible,.reveal-scale.visible { opacity:1;transform:none }
.stagger-1{transition-delay:.06s}.stagger-2{transition-delay:.13s}
.stagger-3{transition-delay:.20s}.stagger-4{transition-delay:.27s}

/* Hero */
.page-hero { position:relative;overflow:hidden;background:var(--navy);min-height:480px;display:flex;align-items:center; }
.page-hero-bg { position:absolute;inset:0;background-size:cover;background-position:center;filter:brightness(.3) saturate(1.2);transition:transform 10s ease; }
.page-hero:hover .page-hero-bg { transform:scale(1.06); }
.page-hero-overlay { position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,22,40,.95) 0%,rgba(15,23,42,.6) 50%,rgba(249,115,22,.08) 100%); }
.hero-orb { position:absolute;border-radius:50%;filter:blur(70px);pointer-events:none; }
.hero-orb-1 { width:500px;height:500px;background:rgba(249,115,22,.1);top:-120px;right:-100px;animation:orb 9s ease-in-out infinite; }
.hero-orb-2 { width:300px;height:300px;background:rgba(234,88,12,.07);bottom:-60px;left:5%;animation:orb 11s ease-in-out infinite reverse; }
.page-hero-content { position:relative;z-index:2;padding:96px 20px 88px;max-width:1280px;margin:0 auto;width:100%; }

.breadcrumb { display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.45);margin-bottom:22px; }
.breadcrumb a { color:rgba(255,255,255,.45);text-decoration:none;transition:color .2s; }
.breadcrumb a:hover { color:rgba(249,115,22,.9); }
.breadcrumb span { color:rgba(255,255,255,.8); }
.breadcrumb i { color:rgba(255,255,255,.2); }

.hero-pill { display:inline-flex;align-items:center;gap:7px;padding:7px 18px;border-radius:999px;background:rgba(249,115,22,.15);border:1px solid rgba(249,115,22,.35);font-size:11px;font-weight:800;letter-spacing:.07em;text-transform:uppercase;color:#fb923c;margin-bottom:20px;animation:fadeUp .6s ease both; }

/* Section pill */
.section-pill { display:inline-flex;align-items:center;gap:7px;padding:6px 16px;border-radius:999px;background:linear-gradient(135deg,rgba(249,115,22,.1),rgba(245,158,11,.06));border:1px solid rgba(249,115,22,.18);font-size:11px;font-weight:800;letter-spacing:.07em;text-transform:uppercase;color:#ea580c;margin-bottom:14px;font-family:'DM Sans',sans-serif; }
.dot-live { width:6px;height:6px;border-radius:50%;background:var(--orange);display:inline-block;animation:floatY 1.8s ease-in-out infinite; }

.wave-divider { line-height:0;overflow:hidden; }
.wave-divider svg { display:block; }

/* Alternating rows */
.prot-row { display:grid;grid-template-columns:1fr 1fr;gap:0;border-radius:24px;overflow:hidden;box-shadow:0 8px 40px rgba(0,0,0,.08),0 2px 8px rgba(0,0,0,.04);border:1px solid #f1f5f9;transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s; }
.prot-row:hover { transform:translateY(-5px);box-shadow:0 24px 60px rgba(0,0,0,.13); }
.prot-row.img-left  { direction:ltr; }
.prot-row.img-right { direction:rtl; }
.prot-row.img-right > * { direction:ltr; }

.prot-img-pane { position:relative;overflow:hidden;min-height:320px; }
.prot-img-pane img { width:100%;height:100%;object-fit:cover;transition:transform .7s cubic-bezier(.16,1,.3,1);display:block; }
.prot-row:hover .prot-img-pane img { transform:scale(1.07); }
.prot-img-overlay { position:absolute;inset:0;background:linear-gradient(to bottom,transparent 40%,rgba(10,20,30,.55) 100%);pointer-events:none; }

.prot-num { position:absolute;top:20px;left:20px;width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,var(--orange),var(--orange-d));color:#fff;font-size:17px;font-weight:900;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(249,115,22,.45);font-family:'DM Sans',sans-serif;z-index:2; }
.prot-row.img-right .prot-num { left:auto;right:20px; }

.prot-text-pane { background:#fff;padding:48px 44px;display:flex;flex-direction:column;justify-content:center; }
.prot-icon { width:52px;height:52px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:18px;flex-shrink:0; }
.prot-title { font-family:'Playfair Display',serif;font-size:1.55rem;font-weight:900;color:var(--ink);line-height:1.25;margin-bottom:14px; }
.prot-desc { font-family:'DM Sans',sans-serif;font-size:.9rem;color:#64748b;line-height:1.78;margin-bottom:24px; }
.prot-tag { display:inline-flex;align-items:center;gap:5px;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:5px 12px;border-radius:999px;background:#fff7ed;border:1px solid #fed7aa33;color:var(--orange-d);width:fit-content; }

/* CTA */
.cta-banner { background:linear-gradient(135deg,#ea580c 0%,#f97316 50%,#f59e0b 100%);border-radius:28px;padding:64px 48px;position:relative;overflow:hidden; }
.cta-banner::before { content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.08; }
.cta-orb { position:absolute;border-radius:50%;filter:blur(50px);pointer-events:none; }
.cta-orb-1 { width:300px;height:300px;background:rgba(255,255,255,.1);top:-80px;right:-60px; }
.cta-orb-2 { width:200px;height:200px;background:rgba(0,0,0,.08);bottom:-40px;left:10%; }

@media(max-width:900px) {
    .prot-row { grid-template-columns:1fr; }
    .prot-row.img-right { direction:ltr; }
    .prot-img-pane { min-height:240px; }
    .prot-text-pane { padding:32px 28px; }
    .prot-title { font-size:1.3rem; }
    .prot-row.img-right .prot-num { left:20px;right:auto; }
}
@media(max-width:640px) {
    .page-hero { min-height:360px; }
    .page-hero-content { padding:68px 16px 60px; }
    .prot-img-pane { min-height:200px; }
    .prot-text-pane { padding:24px 20px; }
    .prot-title { font-size:1.2rem; }
    .cta-banner { padding:44px 20px;border-radius:20px; }
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
    <div class="page-hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="page-hero-overlay"></div>
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="page-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Our Actions</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Childhood</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Health & Nutrition</span>
        </nav>
        <div class="hero-pill">
            <i class="fas fa-heartbeat text-xs"></i> Childhood Health
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-5 max-w-2xl"
            style="font-family:'Playfair Display',serif;animation:fadeUp .8s ease both;letter-spacing:-.02em;">
            Health &<br>
            <span style="background:linear-gradient(90deg,#f97316,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Nutrition</span>
        </h1>
        <p class="text-lg text-white/70 font-medium max-w-lg leading-relaxed"
           style="font-family:'DM Sans',sans-serif;animation:fadeUp .8s .18s ease both">
            Building healthy bodies and minds — because a well-nourished child is a child who can learn and dream.
        </p>
        <div class="flex gap-8 flex-wrap mt-10" style="animation:fadeUp .8s .32s ease both">
            @foreach([['4','Key Programs'],['95K+','Children/Year'],['84%','Funds to Field']] as [$n,$l])
            <div>
                <div style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:900;color:#fff;line-height:1;letter-spacing:-.02em;">{{ $n }}</div>
                <div style="font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.09em;margin-top:3px;">{{ $l }}</div>
            </div>
            @if(!$loop->last)
            <div style="width:1px;background:rgba(255,255,255,.1);align-self:stretch;"></div>
            @endif
            @endforeach
        </div>
    </div>
</section>

<div class="wave-divider" style="background:#f8fafc">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,40 C480,68 960,12 1440,40 L1440,0 L0,0 Z" fill="#0f172a"/>
    </svg>
</div>

{{-- â•â• CARDS â•â• --}}
<section class="py-16 md:py-20" style="background:#f8fafc;">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-14 reveal">
            <div class="section-pill mx-auto mb-4"><span class="dot-live"></span> Health & Nutrition</div>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;color:var(--ink);margin-bottom:12px;">
                Four Pillars of Child Health
            </h2>
            <p style="font-family:'DM Sans',sans-serif;font-size:.95rem;color:#64748b;max-width:520px;margin:0 auto;line-height:1.75;">
                A healthy child is a child who can learn. Through care, nutrition, hygiene, and well-being, we give every child in Cambodia the foundation to thrive.
            </p>
        </div>

        @php
        $cards = [
            [
                'img'   => 'images/children/image-1.jpg',
                'icon'  => 'fas fa-stethoscope',
                'color' => '#fff7ed', 'ic' => '#f97316',
                'tag'   => 'Primary Care',
                'title' => 'Access to Basic Healthcare',
                'desc'  => 'In Cambodia, access to healthcare remains limited for many children and families, especially in rural or disadvantaged areas. Des Ailes pour Grandir supports access to primary care by funding medical consultations, assisting families, and ensuring regular follow-up to prevent and treat common illnesses.',
            ],
            [
                'img'   => 'images/children/image-2.jpg',
                'icon'  => 'fas fa-apple-alt',
                'color' => '#eff6ff', 'ic' => '#3b82f6',
                'tag'   => 'Food Security',
                'title' => 'Nutrition and Food',
                'desc'  => 'Malnutrition still affects a significant number of Cambodian children, impacting their growth, cognitive development, and long-term health. We provide balanced meals and tailored nutritional support while raising families\' awareness of the importance of a healthy diet.',
            ],
            [
                'img'   => 'images/children/image-3.jpg',
                'icon'  => 'fas fa-hands-wash',
                'color' => '#f0fdf4', 'ic' => '#22c55e',
                'tag'   => 'Prevention',
                'title' => 'Hygiene and Prevention',
                'desc'  => 'Diseases related to unsafe drinking water, poor sanitation, or inadequate hygiene are common. Des Ailes pour Grandir works to improve hygiene by supporting awareness programs and encouraging preventive practices within families and care centers.',
            ],
            [
                'img'   => 'images/children/image-4.jpg',
                'icon'  => 'fas fa-smile',
                'color' => '#faf5ff', 'ic' => '#a855f7',
                'tag'   => 'Holistic Wellbeing',
                'title' => 'Overall Well-being',
                'desc'  => 'Health is not limited to the body: emotional and psychological well-being is essential. Our programs include holistic support, offering educational, recreational, and psychosocial activities to strengthen children\'s resilience and confidence.',
            ],
        ];
        @endphp

        <div class="space-y-6 md:space-y-8">
            @foreach($cards as $i => $c)
            <div class="prot-row {{ $i % 2 === 0 ? 'img-left' : 'img-right' }} reveal stagger-{{ $i + 1 }}">
                <div class="prot-img-pane">
                    <img src="{{ asset($c['img']) }}" alt="{{ $c['title'] }}" loading="lazy">
                    <div class="prot-img-overlay"></div>
                    <div class="prot-num">{{ $i + 1 }}</div>
                </div>
                <div class="prot-text-pane">
                    <div class="prot-icon" style="background:{{ $c['color'] }};">
                        <i class="{{ $c['icon'] }}" style="color:{{ $c['ic'] }};"></i>
                    </div>
                    <div class="prot-tag" style="background:{{ $c['color'] }};border-color:{{ $c['ic'] }}33;color:{{ $c['ic'] }};">
                        <i class="fas fa-circle text-[5px]"></i> {{ $c['tag'] }}
                    </div>
                    <h3 class="prot-title" style="margin-top:12px;">{{ $c['title'] }}</h3>
                    <p class="prot-desc">{{ $c['desc'] }}</p>
                    <a href="{{ route('sponsor.children') }}"
                       style="display:inline-flex;align-items:center;gap:7px;font-family:'DM Sans',sans-serif;font-size:12px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:var(--orange);text-decoration:none;transition:gap .2s;"
                       onmouseover="this.style.gap='11px'" onmouseout="this.style.gap='7px'">
                        Learn more <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- â•â• CTA â•â• --}}
<section class="py-16 md:py-20" style="background:#f8fafc;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="cta-banner reveal">
            <div class="cta-orb cta-orb-1"></div>
            <div class="cta-orb cta-orb-2"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="text-white text-center lg:text-left">
                    <div style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:10px;">
                        <i class="fas fa-heart mr-1"></i> Take Action
                    </div>
                    <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.8rem,4vw,2.6rem);font-weight:900;color:#fff;margin-bottom:10px;line-height:1.2;">
                        Make a Difference Today
                    </h2>
                    <p style="font-family:'DM Sans',sans-serif;color:rgba(255,255,255,.8);font-size:.95rem;max-width:420px;line-height:1.7;">
                        Your support funds health, nutrition, and wellness programs for children in Cambodia.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}"
                       style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:16px 32px;background:#fff;color:#ea580c;font-family:'DM Sans',sans-serif;font-size:.875rem;font-weight:800;border-radius:14px;text-decoration:none;box-shadow:0 8px 28px rgba(0,0,0,.15);transition:transform .2s,box-shadow .2s;"
                       onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 36px rgba(0,0,0,.2)'"
                       onmouseout="this.style.transform='';this.style.boxShadow='0 8px 28px rgba(0,0,0,.15)'">
                        <i class="fas fa-heart"></i> Sponsor a Child
                    </a>
                    <a href="{{ route('support.donate') }}"
                       style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:16px 32px;background:rgba(255,255,255,.12);border:2px solid rgba(255,255,255,.35);color:#fff;font-family:'DM Sans',sans-serif;font-size:.875rem;font-weight:800;border-radius:14px;text-decoration:none;transition:background .2s,border-color .2s;"
                       onmouseover="this.style.background='rgba(255,255,255,.22)';this.style.borderColor='rgba(255,255,255,.6)'"
                       onmouseout="this.style.background='rgba(255,255,255,.12)';this.style.borderColor='rgba(255,255,255,.35)'">
                        <i class="fas fa-hand-holding-heart"></i> Make a Donation
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function(){
    var o = new IntersectionObserver(function(entries) {
        entries.forEach(function(x) {
            if (x.isIntersecting) { x.target.classList.add('visible'); o.unobserve(x.target); }
        });
    }, { threshold:.08, rootMargin:'0px 0px -50px 0px' });
    document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale').forEach(function(el){ o.observe(el); });
})();
</script>
@endsection