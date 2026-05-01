{{-- resources/views/pages/childhood/childrens-homes.blade.php --}}
@extends('layouts.app')
@section('title', "Children's Homes")

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{
    --or:#f97316;--or-d:#ea580c;--amber:#f59e0b;
    --navy:#06101f;--ink:#0f1c2e;--muted:#64748b;
    --cream:#fefdf9;
}

@keyframes fadeUp  {from{opacity:0;transform:translateY(36px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn  {from{opacity:0}to{opacity:1}}
@keyframes driftL  {0%,100%{transform:translate(0,0)}50%{transform:translate(-20px,-14px)}}
@keyframes driftR  {0%,100%{transform:translate(0,0)}50%{transform:translate(20px,14px)}}
@keyframes floatUp {0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
@keyframes pulse   {0%,100%{opacity:1}50%{opacity:.4}}
@keyframes shimmer {from{background-position:-200% 0}to{background-position:200% 0}}

.reveal{opacity:0;transform:translateY(30px);transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
.reveal.in{opacity:1;transform:none}
.d1{transition-delay:.07s}.d2{transition-delay:.15s}.d3{transition-delay:.23s}.d4{transition-delay:.31s}

/* ══════════════════════════════
   HERO
══════════════════════════════ */
.ch-hero{position:relative;overflow:hidden;background:var(--navy);min-height:100vh;display:flex;align-items:center;}
.hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;filter:brightness(.2) saturate(1.4);}
.hero-grad{position:absolute;inset:0;background:linear-gradient(135deg,rgba(6,16,31,.97) 0%,rgba(6,16,31,.62) 55%,rgba(249,115,22,.14) 100%);}
.hero-ring{position:absolute;border-radius:50%;border:1.5px solid rgba(249,115,22,.1);pointer-events:none;}
.ring-a{width:580px;height:580px;top:-140px;right:-120px;animation:driftR 12s ease-in-out infinite;}
.ring-b{width:340px;height:340px;bottom:8%;left:-70px;border-color:rgba(249,115,22,.06);animation:driftL 10s ease-in-out infinite;}
.ring-c{width:180px;height:180px;top:35%;right:22%;background:radial-gradient(circle,rgba(249,115,22,.07),transparent 70%);border:none;animation:floatUp 8s ease-in-out infinite;}

/* Floating tags — desktop only */
.float-tag{position:absolute;z-index:3;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;padding:8px 16px;border-radius:999px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.55);backdrop-filter:blur(8px);white-space:nowrap;pointer-events:none;}
.ft1{top:20%;right:7%;animation:floatUp 7s ease-in-out infinite;}
.ft2{top:42%;right:3%;animation:floatUp 9s 1.2s ease-in-out infinite;}
.ft3{bottom:24%;right:11%;animation:floatUp 8s 2.5s ease-in-out infinite;}

/* Hero inner: 2-col desktop, 1-col mobile */
.hero-inner{
    position:relative;z-index:2;
    padding:120px 20px 100px;
    max-width:1280px;margin:0 auto;width:100%;
    display:grid;grid-template-columns:1fr 460px;gap:64px;align-items:center;
}

.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.32);margin-bottom:28px;}
.breadcrumb a{color:rgba(255,255,255,.32);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:rgba(249,115,22,.8);}
.breadcrumb span{color:rgba(255,255,255,.62);}

.hero-eyebrow{display:inline-flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--or);margin-bottom:22px;}
.eyebrow-line{width:32px;height:2px;background:var(--or);border-radius:2px;}

.hero-h1{font-family:'Fraunces',serif;font-size:clamp(2.2rem,5.5vw,4.8rem);font-weight:900;line-height:1.02;color:#fff;letter-spacing:-.03em;margin-bottom:22px;}
.hero-h1 em{font-style:italic;background:linear-gradient(90deg,#f97316,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}

.hero-sub{font-family:'Plus Jakarta Sans',sans-serif;font-size:.975rem;color:rgba(255,255,255,.5);line-height:1.82;max-width:460px;margin-bottom:38px;}

.hero-btn{display:inline-flex;align-items:center;gap:11px;font-family:'Plus Jakarta Sans',sans-serif;font-size:.875rem;font-weight:700;padding:16px 32px;border-radius:14px;background:linear-gradient(135deg,var(--or),var(--or-d));color:#fff;text-decoration:none;box-shadow:0 8px 32px rgba(249,115,22,.4);transition:transform .22s,box-shadow .22s;}
.hero-btn:hover{transform:translateY(-3px);box-shadow:0 16px 44px rgba(249,115,22,.55);color:#fff;}
.hero-btn .arr{transition:transform .2s;}
.hero-btn:hover .arr{transform:translateX(4px);}

/* Hero image collage */
.hero-collage{display:grid;grid-template-columns:1fr 1fr;grid-template-rows:1fr 1fr;gap:12px;height:480px;}
.col-img{position:relative;overflow:hidden;border-radius:18px;box-shadow:0 12px 36px rgba(0,0,0,.35);}
.col-img:nth-child(1){grid-row:span 2;border-radius:22px;}
.col-img img{width:100%;height:100%;object-fit:cover;object-position:center 20%;display:block;transition:transform .7s cubic-bezier(.16,1,.3,1);}
.col-img:hover img{transform:scale(1.07);}
.col-img-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,transparent 55%,rgba(6,16,31,.55) 100%);}
.col-badge{position:absolute;bottom:12px;left:12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:9px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.7);background:rgba(6,16,31,.6);border:1px solid rgba(255,255,255,.12);padding:5px 11px;border-radius:999px;backdrop-filter:blur(6px);}

/* ══════════════════════════════
   SECTION TAG
══════════════════════════════ */
.sec-tag{display:inline-flex;align-items:center;gap:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;padding:6px 16px;border-radius:999px;background:rgba(249,115,22,.1);border:1px solid rgba(249,115,22,.2);color:var(--or-d);}
.dot-p{width:6px;height:6px;border-radius:50%;background:var(--or);animation:pulse 1.8s ease-in-out infinite;flex-shrink:0;}

/* ══════════════════════════════
   SUPPORT CARDS
══════════════════════════════ */
.support-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;}
.sup-card{background:#fff;border-radius:22px;overflow:hidden;border:1px solid #f1f5f9;box-shadow:0 4px 24px rgba(0,0,0,.06);display:flex;flex-direction:column;transition:transform .38s cubic-bezier(.16,1,.3,1),box-shadow .38s;}
.sup-card:hover{transform:translateY(-6px);box-shadow:0 24px 56px rgba(0,0,0,.12);}
.sup-img{position:relative;overflow:hidden;flex-shrink:0;}
.sup-img img{width:100%;height:100%;object-fit:cover;object-position:center 20%;transition:transform .7s cubic-bezier(.16,1,.3,1);display:block;}
.sup-card:hover .sup-img img{transform:scale(1.07);}
.sup-img::after{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,transparent 50%,rgba(6,16,31,.5) 100%);pointer-events:none;}
.sup-num{position:absolute;top:16px;left:16px;z-index:2;width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,var(--or),var(--or-d));color:#fff;font-family:'Fraunces',serif;font-size:16px;font-weight:900;display:flex;align-items:center;justify-content:center;box-shadow:0 3px 14px rgba(249,115,22,.5);transition:transform .25s;}
.sup-card:hover .sup-num{transform:rotate(-8deg) scale(1.12);}
.sup-body{padding:22px 22px 26px;flex:1;display:flex;flex-direction:column;}
.sup-cat{display:inline-flex;align-items:center;gap:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:9.5px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;padding:4px 11px;border-radius:999px;width:fit-content;margin-bottom:10px;}
.sup-title{font-family:'Fraunces',serif;font-size:1.2rem;font-weight:900;color:var(--ink);line-height:1.22;margin-bottom:8px;transition:color .2s;}
.sup-card:hover .sup-title{color:var(--or-d);}
.sup-desc{font-family:'Plus Jakarta Sans',sans-serif;font-size:.84rem;color:var(--muted);line-height:1.75;flex:1;}

/* ══════════════════════════════
   LOCATION / FAMILY CARDS
══════════════════════════════ */
.loc-card{
    position:relative;border-radius:24px;overflow:hidden;
    background:#fff;border:1px solid #f1f5f9;
    box-shadow:0 6px 28px rgba(0,0,0,.07);
    transition:transform .38s cubic-bezier(.16,1,.3,1),box-shadow .38s;
    display:flex;flex-direction:column;
}
.loc-card:hover{transform:translateY(-7px);box-shadow:0 28px 64px rgba(0,0,0,.13);}
.loc-img{position:relative;overflow:hidden;flex-shrink:0;}
.loc-img img{width:100%;height:100%;object-fit:cover;object-position:center 20%;display:block;transition:transform .7s cubic-bezier(.16,1,.3,1);}
.loc-card:hover .loc-img img{transform:scale(1.08);}
.loc-img-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,transparent 40%,rgba(6,16,31,.7) 100%);}
.loc-city{position:absolute;bottom:0;left:0;right:0;padding:16px 20px;}
.loc-city-tag{font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:4px;}
.loc-city-name{font-family:'Fraunces',serif;font-size:1.45rem;font-weight:900;color:#fff;line-height:1;}
.loc-icon{
    position:absolute;top:14px;right:14px;
    width:38px;height:38px;border-radius:12px;
    background:linear-gradient(135deg,var(--or),var(--or-d));
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:15px;
    box-shadow:0 4px 14px rgba(249,115,22,.45);
    transition:transform .25s;
}
.loc-card:hover .loc-icon{transform:scale(1.15) rotate(-5deg);}
.loc-body{padding:20px 22px 24px;flex:1;display:flex;flex-direction:column;}
.loc-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--or);margin-bottom:8px;}
.loc-desc{font-family:'Plus Jakarta Sans',sans-serif;font-size:.85rem;color:var(--muted);line-height:1.75;flex:1;margin-bottom:18px;}
.loc-btn{
    display:inline-flex;align-items:center;gap:8px;
    font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;letter-spacing:.07em;text-transform:uppercase;
    padding:11px 20px;border-radius:12px;border:none;cursor:pointer;text-decoration:none;
    background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;
    box-shadow:0 4px 16px rgba(34,197,94,.3);
    transition:transform .2s,box-shadow .2s;
    width:fit-content;
}
.loc-btn:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(34,197,94,.45);color:#fff;}

/* ══════════════════════════════
   QUOTE BAND
══════════════════════════════ */
.quote-band{position:relative;overflow:hidden;background:var(--ink);padding:72px 20px;}
.qb-bg{position:absolute;inset:0;background:linear-gradient(135deg,rgba(249,115,22,.09) 0%,transparent 60%);}
.qb-decor{position:absolute;right:-40px;top:50%;transform:translateY(-50%);font-family:'Fraunces',serif;font-size:26rem;font-weight:900;color:rgba(255,255,255,.022);line-height:1;pointer-events:none;user-select:none;}
.q-text{font-family:'Fraunces',serif;font-style:italic;font-size:clamp(1.15rem,2.8vw,2rem);font-weight:700;color:#fff;line-height:1.48;max-width:740px;position:relative;z-index:1;}
.q-text span{color:var(--or);}
.q-src{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.1em;margin-top:18px;position:relative;z-index:1;}

/* ══════════════════════════════
   CTA
══════════════════════════════ */
.cta-outer{background:var(--cream);padding:64px 16px;}
.cta-inner{max-width:1100px;margin:0 auto;background:linear-gradient(135deg,#ea580c,#f97316 55%,#f59e0b);border-radius:28px;padding:56px 40px;position:relative;overflow:hidden;}
.cta-inner::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.06;}
.cta-orb{position:absolute;border-radius:50%;filter:blur(60px);pointer-events:none;}
.cta-o1{width:360px;height:360px;background:rgba(255,255,255,.1);top:-100px;right:-80px;}
.cta-o2{width:240px;height:240px;background:rgba(0,0,0,.1);bottom:-60px;left:5%;}

/* ══════════════════════════════
   MEMBER STRIP
══════════════════════════════ */
.member-strip{display:flex;flex-wrap:wrap;gap:8px;padding:12px 14px;background:#f8fafc;border-top:1px solid #f1f5f9;}
.member-chip{display:flex;align-items:center;gap:7px;background:#fff;border:1px solid #e8edf2;border-radius:12px;padding:6px 10px 6px 6px;transition:border-color .18s,transform .18s,box-shadow .18s;flex:1;min-width:120px;max-width:calc(50% - 4px);}
.member-chip:hover{border-color:rgba(249,115,22,.3);transform:translateY(-1px);box-shadow:0 4px 12px rgba(0,0,0,.07);}
.member-avatar{width:30px;height:30px;border-radius:10px;object-fit:cover;flex-shrink:0;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:13px;overflow:hidden;}
.member-avatar img{width:100%;height:100%;object-fit:cover;display:block;}
.member-info{min-width:0;flex:1;}
.member-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.2;}
.member-role{font-family:'Plus Jakarta Sans',sans-serif;font-size:9.5px;font-weight:600;color:var(--muted);text-transform:capitalize;line-height:1.3;}
.member-more{display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,rgba(249,115,22,.1),rgba(245,158,11,.08));border:1px solid rgba(249,115,22,.2);border-radius:12px;padding:6px 10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:800;color:var(--or);white-space:nowrap;}
.member-strip-head{display:flex;align-items:center;justify-content:space-between;padding:10px 14px 0;}
.member-strip-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:9.5px;font-weight:800;letter-spacing:.09em;text-transform:uppercase;color:var(--muted);}
.member-count-badge{font-family:'Plus Jakarta Sans',sans-serif;font-size:9px;font-weight:800;background:#f1f5f9;color:var(--muted);padding:2px 8px;border-radius:999px;}

/* ══════════════════════════════
   RESPONSIVE — TABLET  ≤ 900px
══════════════════════════════ */
@media(max-width:900px){
    .hero-inner{
        grid-template-columns:1fr;
        gap:40px;
        padding:100px 20px 64px;
    }
    .hero-collage{height:320px;}
    .float-tag{display:none;}
    .ring-a,.ring-b,.ring-c{display:none;}
    .qb-decor{display:none;}
}

/* ══════════════════════════════
   RESPONSIVE — MOBILE  ≤ 640px
══════════════════════════════ */
@media(max-width:640px){

    /* Hero */
    .ch-hero{min-height:auto;}
    .hero-inner{padding:80px 16px 48px;gap:28px;}
    .breadcrumb{font-size:9px;gap:5px;margin-bottom:18px;}
    .hero-sub{font-size:.875rem;margin-bottom:28px;}
    .hero-btn{padding:13px 22px;font-size:.82rem;width:100%;justify-content:center;}

    /* Collage: horizontal 3-col strip on mobile */
    .hero-collage{
        grid-template-columns:1fr 1fr 1fr;
        grid-template-rows:1fr;
        height:180px;
        gap:8px;
    }
    .col-img:nth-child(1){grid-row:span 1;}
    .col-badge{display:none;}

    /* Support section */
    .support-section-pad{padding:56px 0 64px !important;}
    .support-grid{grid-template-columns:1fr;gap:16px;}
    .sup-img{height:200px;}
    .sup-body{padding:16px 16px 20px;}
    .sup-title{font-size:1.05rem;}
    .sup-desc{font-size:.82rem;}

    /* Stats bar: 2×2 on mobile */
    .stats-bar{grid-template-columns:repeat(2,1fr) !important;}

    /* Families section */
    .families-section-pad{padding:52px 0 64px !important;}
    .loc-img{height:200px !important;}
    .loc-body{padding:14px 16px 18px;}
    .loc-city-name{font-size:1.2rem;}
    .loc-btn{width:100%;justify-content:center;padding:12px 16px;}
    .loc-desc{font-size:.82rem;margin-bottom:14px;}

    /* Member chips: full width on very small */
    .member-chip{min-width:100%;max-width:100%;}
    .member-strip{padding:10px 12px;gap:6px;}

    /* Search bar */
    .search-bar-wrap{flex-direction:column !important;}
    .search-bar-wrap input,.search-bar-wrap select{width:100% !important;}
    .search-bar-wrap button,.search-bar-wrap a{width:100%;justify-content:center;}

    /* Quote */
    .quote-band{padding:52px 16px;}
    .q-text{font-size:1.1rem;}

    /* CTA */
    .cta-outer{padding:40px 12px;}
    .cta-inner{padding:36px 20px;border-radius:22px;}
    .cta-inner .cta-btn-wrap{flex-direction:column !important;}
    .cta-inner .cta-btn-wrap a{width:100%;justify-content:center;}

    /* Section header stacks */
    .section-header-row{flex-direction:column !important;align-items:flex-start !important;gap:12px !important;}
    .section-header-row p{max-width:100% !important;}
}

/* ══════════════════════════════
   RESPONSIVE — XS  ≤ 380px
══════════════════════════════ */
@media(max-width:380px){
    .hero-collage{height:140px;}
    .hero-btn{font-size:.78rem;padding:12px 18px;}
    .sup-img{height:170px;}
    .loc-img{height:180px !important;}
}
</style>

{{-- ══ HERO ══ --}}
<section class="ch-hero">
    <div class="hero-bg" style="background-image:url('{{ asset('images/children/image-5.jpg') }}')"></div>
    <div class="hero-grad"></div>
    <div class="hero-ring ring-a"></div>
    <div class="hero-ring ring-b"></div>
    <div class="hero-ring ring-c"></div>
    <div class="float-tag ft1"><i class="fas fa-home mr-2 text-orange-400"></i> Safe Haven</div>
    <div class="float-tag ft2"><i class="fas fa-hands-helping mr-2 text-blue-400"></i> Staff Training</div>
    <div class="float-tag ft3"><i class="fas fa-heart mr-2 text-pink-400"></i> Child Well-being</div>

    <div class="hero-inner">
        {{-- Left --}}
        <div>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}"
                   data-fr="Accueil" data-en="Home" data-km="ទំព័រដើម">Home</a>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <span data-fr="Nos Actions" data-en="Our Actions" data-km="សកម្មភាពរបស់យើង">Our Actions</span>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <span data-fr="Enfance" data-en="Childhood" data-km="កុមារភាព">Childhood</span>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <span data-fr="Maisons d'Enfants" data-en="Children's Homes" data-km="មណ្ឌលកុមារ">Children's Homes</span>
            </nav>

            <div class="hero-eyebrow" style="animation:fadeUp .6s ease both;">
                <div class="eyebrow-line"></div>
                <span data-fr="Maisons d'Enfants" data-en="Children's Homes" data-km="មណ្ឌលកុមារ">Children's Homes</span>
            </div>

            <h1 class="hero-h1" style="animation:fadeUp .75s ease both;">
                <span data-fr="Chaque Enfant" data-en="Every Child" data-km="កុមារ​ម្នាក់ៗ">Every Child</span><br>
                <em data-fr="Mérite un Foyer" data-en="Deserves a Home" data-km="គួរតែ​មាន​ផ្ទះ">Deserves a Home</em>
            </h1>

            <p class="hero-sub" style="animation:fadeUp .75s .16s ease both;"
               data-fr="Renforcer les institutions qui offrent chaque jour un refuge sûr aux enfants vulnérables du Cambodge."
               data-en="Strengthening the institutions that give vulnerable children in Cambodia a safe haven every single day."
               data-km="ពង្រឹងស្ថាប័នដែលផ្តល់ជម្រកសុវត្ថិភាពដល់កុមារងាយរងគ្រោះនៅកម្ពុជារៀងរាល់ថ្ងៃ។">
                Strengthening the institutions that give vulnerable children in Cambodia a safe haven every single day.
            </p>

            <a href="{{ route('sponsor.children') }}" class="hero-btn" style="animation:fadeUp .75s .3s ease both;">
                <i class="fas fa-heart"></i>
                <span data-fr="Parrainer un Enfant" data-en="Sponsor a Child" data-km="ឧបត្ថម្ភកុមារ">Sponsor a Child</span>
                <i class="fas fa-arrow-right text-sm arr"></i>
            </a>
        </div>

        {{-- Right: image collage --}}
        <div class="hero-collage" style="animation:fadeIn .9s .42s ease both;">
            <div class="col-img">
                <img src="{{ asset('images/children/image-7.jpg') }}" alt="Children's home" loading="lazy">
                <div class="col-img-overlay"></div>
                <div class="col-badge">
                    <span data-fr="Kampong Cham" data-en="Kampong Cham" data-km="កំពង់ចាម">Kampong Cham</span>
                </div>
            </div>
            <div class="col-img">
                <img src="{{ asset('images/children/image-9.jpg') }}" alt="Child care" loading="lazy">
                <div class="col-img-overlay"></div>
                <div class="col-badge">
                    <span data-fr="Soins quotidiens" data-en="Daily Care" data-km="ការថែទាំប្រចាំថ្ងៃ">Daily Care</span>
                </div>
            </div>
            <div class="col-img">
                <img src="{{ asset('images/children/image-11.jpg') }}" alt="Kampot home" loading="lazy">
                <div class="col-img-overlay"></div>
                <div class="col-badge">Kampot</div>
            </div>
        </div>
    </div>
</section>

{{-- ══ SUPPORT SECTION ══ --}}
<section class="support-section-pad" style="background:var(--cream);padding:80px 0 96px;">
    <div class="max-w-7xl mx-auto px-4">

        <div class="section-header-row reveal" style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:40px;">
            <div>
                <div class="sec-tag mb-4"><span class="dot-p"></span>
                    <span data-fr="Notre Soutien" data-en="Our Support" data-km="ការគាំទ្ររបស់យើង">Our Support</span>
                </div>
                <h2 style="font-family:'Fraunces',serif;font-size:clamp(1.7rem,4.5vw,3rem);font-weight:900;color:var(--ink);line-height:1.1;letter-spacing:-.02em;">
                    <span data-fr="Comment nous soutenons les" data-en="How We Support" data-km="របៀបដែលយើងគាំទ្រ">How We Support</span><br>
                    <span style="background:linear-gradient(90deg,#f97316,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;"
                          data-fr="Maisons d'Enfants" data-en="Children's Homes" data-km="មណ្ឌលកុមារ">Children's Homes</span>
                </h2>
            </div>
            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:.9rem;color:var(--muted);max-width:360px;line-height:1.78;flex-shrink:0;"
               data-fr="Quatre piliers d'action pour renforcer les maisons d'enfants et améliorer la vie de chaque enfant au quotidien."
               data-en="Four pillars of action to strengthen children's homes and improve each child's daily life."
               data-km="សសរស្ដម្ភសកម្មភាពបួនដើម្បីពង្រឹងមណ្ឌលកុមារ និងលើកកម្ពស់ជីវិតប្រចាំថ្ងៃ។">
                Four pillars of action to strengthen children's homes and improve each child's daily life.
            </p>
        </div>

        @php
        $supports = [
            [
                'img'   => 'images/children/image-1.jpg',
                'icon'  => 'fas fa-hands-helping',
                'color' => '#fff7ed','ic' => '#f97316',
                'cat_fr'=> 'Soutien Structurel','cat_en'=> 'Structural Support','cat_km'=> 'ការគាំទ្រផ្នែករចនាសម្ព័ន្ធ',
                'title_fr'=>'Soutien aux Structures','title_en'=>'Supporting the Structures','title_km'=>'ការគាំទ្រដល់ស្ថាប័ន',
                'desc_en' => "Children's homes and orphanages play a central role in protecting and supporting vulnerable children. Des Ailes pour Grandir supports these institutions by working closely with their staff, providing guidance, monitoring, and operational assistance to strengthen their capacity to meet children's needs.",
                'desc_fr' => "Les Maisons d'Enfants et les orphelinats jouent un rôle central dans la protection et l'accompagnement des enfants vulnérables. Des Ailes pour Grandir soutient ces institutions en travaillant étroitement avec leur personnel, en apportant conseils, suivi et assistance opérationnelle.",
                'desc_km' => "មណ្ឌលកុមារ និងផ្ទះកុមារអនាថាដើរតួនាទីសំខាន់ក្នុងការការពារ និងជួយដល់កុមារងាយរងគ្រោះ។",
            ],
            [
                'img'   => 'images/children/image-2.jpg',
                'icon'  => 'fas fa-chalkboard-teacher',
                'color' => '#eff6ff','ic' => '#3b82f6',
                'cat_fr'=> 'Formation','cat_en'=> 'Training','cat_km'=> 'ការបណ្តុះបណ្តាល',
                'title_fr'=>'Formation du Personnel','title_en'=>'Staff Training','title_km'=>'ការបណ្តុះបណ្តាលបុគ្គលិក',
                'desc_en' => "The quality of care is essential for children's well-being and development. We fund and organize training for staff to improve their skills in education, child protection, health, and psychosocial support.",
                'desc_fr' => "La qualité de la prise en charge est essentielle au bien-être et au développement des enfants. Nous finançons et organisons des formations pour le personnel afin d'améliorer leurs compétences en matière d'éducation, de protection de l'enfance et de santé.",
                'desc_km' => "គុណភាពនៃការថែទាំគឺមានសារៈសំខាន់សម្រាប់សុខុមាលភាព និងការអភិវឌ្ឍន៍របស់កុមារ។",
            ],
            [
                'img'   => 'images/children/image-3.jpg',
                'icon'  => 'fas fa-boxes',
                'color' => '#f0fdf4','ic' => '#22c55e',
                'cat_fr'=> 'Ressources','cat_en'=> 'Resources','cat_km'=> 'ធនធាន',
                'title_fr'=>'Fourniture de Matériel','title_en'=>'Materials & Resources','title_km'=>'ការផ្តល់សម្ភារៈ',
                'desc_en' => "A well-equipped and suitable environment is crucial for children's development. Des Ailes pour Grandir provides educational materials, sanitation equipment, and essential resources, ensuring a safe, stimulating, and comfortable setting for children.",
                'desc_fr' => "Un environnement bien équipé et adapté est crucial pour le développement des enfants. Des Ailes pour Grandir fournit du matériel pédagogique, des équipements sanitaires et des ressources essentielles.",
                'desc_km' => "បរិស្ថានដែលបំពាក់ល្អ គឺមានសារៈសំខាន់សម្រាប់ការអភិវឌ្ឍន៍របស់កុមារ។",
            ],
            [
                'img'   => 'images/children/image-4.jpg',
                'icon'  => 'fas fa-heart',
                'color' => '#faf5ff','ic' => '#a855f7',
                'cat_fr'=> 'Bien-être','cat_en'=> 'Well-being','cat_km'=> 'សុខុមាលភាព',
                'title_fr'=>'Bien-être des Enfants','title_en'=>"Children's Well-being",'title_km'=>'ការលើកកម្ពស់សុខុមាលភាពកុមារ',
                'desc_en' => "Beyond material and educational support, our work with children's homes aims to create a protective, warm, and caring environment where each child can grow safely, develop skills, and thrive fully.",
                'desc_fr' => "Au-delà du soutien matériel et éducatif, notre travail avec les Maisons d'Enfants vise à créer un environnement protecteur, chaleureux et bienveillant où chaque enfant peut grandir en sécurité et s'épanouir.",
                'desc_km' => "លើសពីការគាំទ្រផ្នែកសម្ភារៈ និងការអប់រំ ការងាររបស់យើងជាមួយមណ្ឌលកុមារ មានគោលបំណងបង្កើតបរិស្ថានការពារ ក្តៅក្រហាយ។",
            ],
        ];
        @endphp

        <div class="support-grid">
            @foreach($supports as $i => $s)
            <div class="sup-card reveal d{{ $i+1 }}">
                <div class="sup-img" style="height:280px;">
                    <img src="{{ asset($s['img']) }}" alt="{{ $s['title_en'] }}" loading="lazy">
                    <div class="sup-num">{{ $i+1 }}</div>
                </div>
                <div class="sup-body">
                    <div class="sup-cat" style="background:{{ $s['color'] }};color:{{ $s['ic'] }};border:1px solid {{ $s['ic'] }}25;">
                        <i class="{{ $s['icon'] }}" style="font-size:9px;"></i>
                        <span data-fr="{{ $s['cat_fr'] }}" data-en="{{ $s['cat_en'] }}" data-km="{{ $s['cat_km'] }}">{{ $s['cat_en'] }}</span>
                    </div>
                    <h3 class="sup-title"
                        data-fr="{{ $s['title_fr'] }}" data-en="{{ $s['title_en'] }}" data-km="{{ $s['title_km'] }}">{{ $s['title_en'] }}</h3>
                    <p class="sup-desc"
                       data-fr="{{ $s['desc_fr'] }}" data-en="{{ $s['desc_en'] }}" data-km="{{ $s['desc_km'] }}">{{ $s['desc_en'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ FAMILIES SECTION ══ --}}


{{-- ══ QUOTE ══ --}}
<section class="quote-band reveal">
    <div class="qb-bg"></div>
    <div class="qb-decor">"</div>
    <div class="max-w-5xl mx-auto px-4 text-center">
        <div style="font-size:2.4rem;color:var(--or);line-height:1;margin-bottom:14px;font-family:'Fraunces',serif;">"</div>
        <p class="q-text mx-auto"
           data-fr="Un foyer sûr n'est pas un luxe — c'est le <span>fondement de tout</span> ce qu'un enfant peut devenir."
           data-en="A safe home is not a luxury — it is the <span>foundation</span> of everything a child can become."
           data-km="ផ្ទះដែលមានសុវត្ថិភាព មិនមែនជាភាពប្រណីតទេ — វាជា<span>មូលដ្ឋានគ្រឹះ</span>នៃអ្វីៗគ្រប់យ៉ាងដែលកុមារម្នាក់ចង់ក្លាយជា។">
            A safe home is not a luxury — it is the <span>foundation</span> of everything a child can become.
        </p>
        <div class="q-src">— Des Ailes pour Grandir · Cambodia</div>
    </div>
</section>

{{-- ══ CTA ══ --}}
<div class="cta-outer reveal">
    <div class="cta-inner">
        <div class="cta-orb cta-o1"></div>
        <div class="cta-orb cta-o2"></div>
        <div class="relative z-10" style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:32px;">
            <div class="text-white" style="flex:1;min-width:240px;">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:12px;">
                    <i class="fas fa-home mr-1"></i>
                    <span data-fr="Soutenir les Foyers" data-en="Support the Homes" data-km="គាំទ្រមណ្ឌល">Support the Homes</span>
                </p>
                <h2 style="font-family:'Fraunces',serif;font-size:clamp(1.8rem,4vw,3rem);font-weight:900;color:#fff;line-height:1.1;letter-spacing:-.02em;margin-bottom:12px;"
                    data-fr="Agissez Aujourd'hui" data-en="Make a Difference Today" data-km="ធ្វើសកម្មភាពថ្ងៃនេះ">
                    Make a Difference<br><em style="font-style:italic;">Today</em>
                </h2>
                <p style="font-family:'Plus Jakarta Sans',sans-serif;color:rgba(255,255,255,.68);font-size:.9rem;max-width:380px;line-height:1.75;"
                   data-fr="Votre soutien finance des programmes comme celui-ci." data-en="Your support funds programs like this one." data-km="ការគាំទ្ររបស់អ្នកផ្តល់ហិរញ្ញប្បទានដល់កម្មវិធីដូចនេះ។">
                    Your support funds safe homes, staff training, and daily care for vulnerable children.
                </p>
            </div>
            <div class="cta-btn-wrap" style="display:flex;flex-wrap:wrap;gap:12px;flex-shrink:0;width:100%;max-width:420px;">
                <a href="{{ route('sponsor.children') }}"
                   style="flex:1;display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:16px 28px;background:#fff;color:#ea580c;font-family:'Plus Jakarta Sans',sans-serif;font-size:.875rem;font-weight:800;border-radius:16px;text-decoration:none;box-shadow:0 10px 32px rgba(0,0,0,.18);transition:transform .22s,box-shadow .22s;white-space:nowrap;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 18px 44px rgba(0,0,0,.25)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='0 10px 32px rgba(0,0,0,.18)'">
                    <i class="fas fa-heart"></i>
                    <span data-fr="Parrainer un Enfant" data-en="Sponsor a Child" data-km="ឧបត្ថម្ភកុមារ">Sponsor a Child</span>
                </a>
                <a href="{{ route('support.donate') }}"
                   style="flex:1;display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:16px 28px;background:rgba(255,255,255,.12);border:2px solid rgba(255,255,255,.3);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:.875rem;font-weight:800;border-radius:16px;text-decoration:none;transition:background .2s,border-color .2s;white-space:nowrap;"
                   onmouseover="this.style.background='rgba(255,255,255,.22)';this.style.borderColor='rgba(255,255,255,.6)'"
                   onmouseout="this.style.background='rgba(255,255,255,.12)';this.style.borderColor='rgba(255,255,255,.3)'">
                    <i class="fas fa-hand-holding-heart"></i>
                    <span data-fr="Faire un Don" data-en="Make a Donation" data-km="ធ្វើការបរិច្ចាគ">Make a Donation</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    /* Scroll reveal */
    var o = new IntersectionObserver(function(entries){
        entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('in'); o.unobserve(e.target); }});
    },{threshold:.07,rootMargin:'0px 0px -40px 0px'});
    document.querySelectorAll('.reveal').forEach(function(el){ o.observe(el); });

    /* Family grid responsive columns via JS (fallback for browsers without CSS grid subgrid) */
    function setFamilyGrid(){
        var g = document.getElementById('family-grid');
        if(!g) return;
        var w = window.innerWidth;
        if(w >= 1024)      g.style.gridTemplateColumns = 'repeat(3,1fr)';
        else if(w >= 640)  g.style.gridTemplateColumns = 'repeat(2,1fr)';
        else               g.style.gridTemplateColumns = 'repeat(1,1fr)';
    }
    setFamilyGrid();
    window.addEventListener('resize', setFamilyGrid);

    /* Stats bar 2×2 on mobile */
    function setStatsBar(){
        var s = document.querySelector('.stats-bar');
        if(!s) return;
        s.style.gridTemplateColumns = window.innerWidth < 640 ? 'repeat(2,1fr)' : 'repeat(4,1fr)';
    }
    setStatsBar();
    window.addEventListener('resize', setStatsBar);

    /* Language switcher */
    var lang = (typeof localStorage !== 'undefined' && localStorage.getItem('gt_lang')) || 'en';
    window.applyPageLang = function(l){
        document.querySelectorAll('[data-fr],[data-en],[data-km]').forEach(function(el){
            var val = el.getAttribute('data-' + l);
            if(val !== null) el.innerHTML = val;
        });
    };
    window.applyPageLang(lang);
})();
</script>
@endsection