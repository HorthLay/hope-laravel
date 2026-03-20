{{-- resources/views/pages/childhood/protection.blade.php --}}
@extends('layouts.app')
@section('title', 'Child Protection')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --orange:  #f97316;
    --amber:   #f59e0b;
    --navy:    #0f172a;
    --ink:     #1e293b;
    --muted:   #64748b;
    --cream:   #fffbf5;
    --border:  #f1f0ec;
}

/* ── Resets & base ── */
*, *::before, *::after { box-sizing: border-box; }

/* ── Animations ── */
@keyframes fadeUp    { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeLeft  { from{opacity:0;transform:translateX(-28px)} to{opacity:1;transform:translateX(0)} }
@keyframes fadeRight { from{opacity:0;transform:translateX(28px)} to{opacity:1;transform:translateX(0)} }
@keyframes scaleIn   { from{opacity:0;transform:scale(.93)} to{opacity:1;transform:scale(1)} }
@keyframes lineGrow  { from{width:0} to{width:100%} }
@keyframes float     { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
@keyframes orb       { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(30px,-20px) scale(1.08)} }
@keyframes counterUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

.reveal       {opacity:0;transform:translateY(28px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal-left  {opacity:0;transform:translateX(-36px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal-right {opacity:0;transform:translateX(36px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal-scale {opacity:0;transform:scale(.93);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal.visible,.reveal-left.visible,.reveal-right.visible,.reveal-scale.visible{opacity:1;transform:none}
.d1{transition-delay:.06s}.d2{transition-delay:.14s}.d3{transition-delay:.22s}
.d4{transition-delay:.30s}.d5{transition-delay:.38s}.d6{transition-delay:.46s}

/* ════════════════════
   HERO
════════════════════ */
.cp-hero {
    position: relative;
    min-height: 520px;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
    background: var(--navy);
}
.cp-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center top;
    filter: brightness(.38) saturate(1.2);
    transition: transform 10s ease;
}
.cp-hero:hover .cp-hero-bg { transform: scale(1.05); }
.cp-hero-gradient {
    position: absolute; inset: 0;
    background: linear-gradient(
        160deg,
        rgba(10,18,32,.95) 0%,
        rgba(10,18,32,.7) 45%,
        rgba(249,115,22,.12) 100%
    );
}
/* Floating orbs */
.cp-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(70px);
    pointer-events: none;
}
.cp-orb-1 { width:500px;height:500px;background:rgba(249,115,22,.09);top:-100px;right:-80px;animation:orb 9s ease-in-out infinite; }
.cp-orb-2 { width:320px;height:320px;background:rgba(245,158,11,.07);bottom:-60px;left:5%;animation:orb 12s ease-in-out infinite reverse; }

.cp-hero-inner {
    position: relative; z-index: 2;
    max-width: 1280px; margin: 0 auto;
    padding: 100px 40px 80px;
    width: 100%;
}
.breadcrumb {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    font-size: 11px; font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
    color: rgba(255,255,255,.45); margin-bottom: 24px;
    font-family: 'DM Sans', sans-serif;
}
.breadcrumb a { color: inherit; text-decoration: none; transition: color .2s; }
.breadcrumb a:hover { color: rgba(249,115,22,.9); }
.breadcrumb i { color: rgba(255,255,255,.2); }

.hero-eyebrow {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 6px 16px; border-radius: 999px;
    background: rgba(249,115,22,.18);
    border: 1px solid rgba(249,115,22,.35);
    font-size: 11px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase;
    color: #fb923c; margin-bottom: 20px;
    font-family: 'DM Sans', sans-serif;
    animation: fadeUp .6s ease both;
}
.hero-eyebrow .dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #f97316; animation: float 1.8s ease-in-out infinite;
}

.cp-hero h1 {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(2.4rem, 5vw, 4.2rem);
    font-weight: 900; color: #fff; line-height: 1.1;
    letter-spacing: -.02em; margin-bottom: 18px;
    animation: fadeUp .8s ease both;
}
.cp-hero h1 em {
    font-style: normal;
    background: linear-gradient(90deg, #f97316, #f59e0b);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
.cp-hero p {
    font-family: 'DM Sans', sans-serif;
    font-size: 1.1rem; color: rgba(255,255,255,.65);
    max-width: 520px; line-height: 1.75;
    animation: fadeUp .8s .15s ease both;
}

/* Hero image strip */
.hero-img-strip {
    position: absolute; bottom: 0; right: 0;
    width: 45%; height: 100%;
    display: grid; grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    gap: 3px; opacity: .35;
    mask-image: linear-gradient(to left, black 40%, transparent 100%);
    -webkit-mask-image: linear-gradient(to left, black 40%, transparent 100%);
}
.hero-img-strip img {
    width: 100%; height: 100%; object-fit: cover;
    filter: grayscale(.3) saturate(1.1);
}

/* ════════════════════
   WAVE
════════════════════ */
.wave { line-height: 0; overflow: hidden; }
.wave svg { display: block; }

/* ════════════════════
   STATS BAND
════════════════════ */
.stats-band {
    background: var(--navy);
    padding: 36px 0;
}
.stats-inner {
    max-width: 1100px; margin: 0 auto;
    padding: 0 32px;
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 0;
}
.stat-item {
    text-align: center;
    padding: 8px 20px;
    border-right: 1px solid rgba(255,255,255,.08);
    font-family: 'DM Sans', sans-serif;
}
.stat-item:last-child { border-right: none; }
.stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem; font-weight: 900;
    background: linear-gradient(135deg, #f97316, #f59e0b);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1; margin-bottom: 6px;
}
.stat-label {
    font-size: 11px; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: rgba(255,255,255,.4);
}

/* ════════════════════
   ISSUES SECTION
════════════════════ */
.issues-section {
    background: var(--cream);
    padding: 96px 0 80px;
}
.section-tag {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 6px 16px; border-radius: 999px;
    background: linear-gradient(135deg, rgba(249,115,22,.1), rgba(245,158,11,.07));
    border: 1px solid rgba(249,115,22,.2);
    font-size: 11px; font-weight: 800; letter-spacing: .07em; text-transform: uppercase;
    color: #ea580c; margin-bottom: 16px;
    font-family: 'DM Sans', sans-serif;
}

/* Alternating image-text rows */
.issue-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    border-radius: 24px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 32px rgba(0,0,0,.07), 0 1px 4px rgba(0,0,0,.04);
    margin-bottom: 28px;
    transition: box-shadow .3s, transform .3s cubic-bezier(.16,1,.3,1);
}
.issue-row:hover {
    box-shadow: 0 16px 56px rgba(0,0,0,.12);
    transform: translateY(-4px);
}
.issue-row.reverse { direction: rtl; }
.issue-row.reverse > * { direction: ltr; }

.issue-img {
    position: relative;
    min-height: 320px;
    overflow: hidden;
}
.issue-img img {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .8s cubic-bezier(.16,1,.3,1);
}
.issue-row:hover .issue-img img { transform: scale(1.06); }
.issue-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(10,18,32,.55) 0%, transparent 70%);
}
.issue-img-num {
    position: absolute; top: 20px; left: 20px;
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem; font-weight: 900;
    color: rgba(255,255,255,.2);
    line-height: 1; user-select: none;
}
.issue-img-badge {
    position: absolute; bottom: 18px; left: 18px;
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(10,18,32,.75);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 999px; padding: 6px 14px;
    font-family: 'DM Sans', sans-serif;
    font-size: 10px; font-weight: 800; letter-spacing: .08em;
    text-transform: uppercase; color: rgba(255,255,255,.85);
}
.issue-img-badge i { color: var(--orange); }

.issue-content {
    padding: 44px 48px;
    display: flex; flex-direction: column; justify-content: center;
}
.issue-icon {
    width: 52px; height: 52px; border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; margin-bottom: 20px; flex-shrink: 0;
}
.issue-content h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.55rem; font-weight: 800;
    color: var(--ink); line-height: 1.25; margin-bottom: 14px;
}
.issue-content p {
    font-family: 'DM Sans', sans-serif;
    font-size: .95rem; color: var(--muted);
    line-height: 1.8; margin-bottom: 20px;
}
.issue-link {
    display: inline-flex; align-items: center; gap: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    color: var(--orange); text-decoration: none;
    transition: gap .2s;
}
.issue-link:hover { gap: 12px; }

/* ════════════════════
   PHOTO MOSAIC
════════════════════ */
.mosaic-section {
    background: #fff;
    padding: 80px 0;
}
.mosaic-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: 240px 240px;
    gap: 8px;
    border-radius: 24px;
    overflow: hidden;
}
.mosaic-cell {
    position: relative;
    overflow: hidden;
}
.mosaic-cell img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .7s cubic-bezier(.16,1,.3,1), filter .4s;
    filter: saturate(.9);
}
.mosaic-cell:hover img { transform: scale(1.08); filter: saturate(1.1); }
.mosaic-cell.span2 { grid-column: span 2; }
.mosaic-cell.span-row { grid-row: span 2; }

.mosaic-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(10,18,32,.6) 0%, transparent 55%);
    display: flex; align-items: flex-end; padding: 16px;
    opacity: 0; transition: opacity .3s;
}
.mosaic-cell:hover .mosaic-overlay { opacity: 1; }
.mosaic-overlay span {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px; font-weight: 800; letter-spacing: .07em;
    text-transform: uppercase; color: rgba(255,255,255,.85);
}

/* ════════════════════
   CHILDSAFE BANNER
════════════════════ */
.childsafe-banner {
    background: linear-gradient(135deg, #0f172a 0%, #1e2d42 60%, rgba(249,115,22,.15) 100%);
    border-radius: 28px;
    padding: 56px 64px;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 40px;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.childsafe-banner::before {
    content: 'ChildSafe';
    position: absolute;
    right: -20px; top: 50%;
    transform: translateY(-50%);
    font-family: 'Playfair Display', serif;
    font-size: 9rem; font-weight: 900;
    color: rgba(255,255,255,.025);
    white-space: nowrap;
    pointer-events: none;
    letter-spacing: -.04em;
}
.childsafe-banner h3 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem; font-weight: 900;
    color: #fff; margin-bottom: 12px; line-height: 1.2;
}
.childsafe-banner p {
    font-family: 'DM Sans', sans-serif;
    color: rgba(255,255,255,.6); font-size: .95rem; line-height: 1.75;
    max-width: 560px;
}
.cs-badge {
    display: flex; align-items: center; gap: 10px;
    background: rgba(249,115,22,.18);
    border: 1px solid rgba(249,115,22,.35);
    border-radius: 16px; padding: 14px 22px;
    flex-shrink: 0;
}
.cs-badge i { font-size: 2rem; color: #f97316; }
.cs-badge-text { font-family: 'DM Sans', sans-serif; }
.cs-badge-label { font-size: 9px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: rgba(255,255,255,.45); margin-bottom: 2px; }
.cs-badge-name { font-size: 15px; font-weight: 800; color: #fff; }

/* ════════════════════
   CTA BANNER
════════════════════ */
.cta-banner {
    background: linear-gradient(135deg, #f97316, #f59e0b);
    border-radius: 28px;
    padding: 56px 64px;
    position: relative; overflow: hidden;
}
.cta-banner::before {
    content: '';
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.cta-banner-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; justify-content: space-between;
    gap: 32px; flex-wrap: wrap;
}
.cta-btns { display: flex; gap: 12px; flex-wrap: wrap; }
.btn-white {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 28px; background: #fff;
    color: #ea580c; font-family: 'DM Sans', sans-serif;
    font-weight: 800; font-size: 14px;
    border-radius: 14px; text-decoration: none;
    box-shadow: 0 4px 20px rgba(0,0,0,.15);
    transition: transform .2s, box-shadow .2s;
}
.btn-white:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,.2); }
.btn-outline-white {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 28px;
    color: #fff; font-family: 'DM Sans', sans-serif;
    font-weight: 800; font-size: 14px;
    border: 2px solid rgba(255,255,255,.6);
    border-radius: 14px; text-decoration: none;
    transition: background .2s, border-color .2s;
}
.btn-outline-white:hover { background: rgba(255,255,255,.15); border-color: #fff; }

/* ════════════════════
   RESPONSIVE
════════════════════ */
@media (max-width: 900px) {
    .issue-row, .issue-row.reverse {
        grid-template-columns: 1fr;
        direction: ltr;
    }
    .issue-img { min-height: 240px; }
    .issue-content { padding: 32px 28px; }
    .mosaic-grid { grid-template-columns: 1fr 1fr; grid-template-rows: 180px 180px 180px; }
    .mosaic-cell.span2 { grid-column: span 1; }
    .childsafe-banner { grid-template-columns: 1fr; padding: 40px 28px; }
    .childsafe-banner::before { display: none; }
    .stats-inner { grid-template-columns: repeat(2,1fr); }
    .cta-banner { padding: 40px 28px; }
    .cta-banner-inner { flex-direction: column; text-align: center; }
    .cta-btns { justify-content: center; }
}
@media (max-width: 640px) {
    .cp-hero-inner { padding: 80px 20px 60px; }
    .hero-img-strip { display: none; }
    .stats-inner { grid-template-columns: 1fr 1fr; gap: 0; }
    .stat-num { font-size: 1.8rem; }
    .issues-section { padding: 60px 0 48px; }
    .mosaic-grid { grid-template-columns: 1fr 1fr; grid-template-rows: 150px 150px 150px 150px; }
    .mosaic-cell.span-row { grid-row: span 1; }
}
</style>

{{-- ══════════════════════
     HERO
══════════════════════ --}}
<section class="cp-hero">
    <div class="cp-hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="cp-hero-gradient"></div>
    <div class="cp-orb cp-orb-1"></div>
    <div class="cp-orb cp-orb-2"></div>

    {{-- Right image strip --}}
    <div class="hero-img-strip">
        <img src="{{ asset('images/children/image-1.jpg') }}" alt="">
        <img src="{{ asset('images/children/image-2.jpg') }}" alt="">
        <img src="{{ asset('images/children/image-3.jpg') }}" alt="">
        <img src="{{ asset('images/children/image-4.jpg') }}" alt="">
    </div>

    <div class="cp-hero-inner">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Our Actions</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Childhood</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Child Protection</span>
        </nav>
        <div class="hero-eyebrow">
            <span class="dot"></span>
            <i class="fas fa-shield-alt"></i> Child Safety
        </div>
        <h1>Protecting Every<br><em>Child's Future</em></h1>
        <p>Safeguarding every child's right to safety, dignity, and a future free from exploitation — in Cambodia and beyond.</p>
    </div>
</section>

{{-- ══════════════════════
     STATS BAND
══════════════════════ --}}
<div class="stats-band">
    <div class="stats-inner">
        @foreach([
            ['1000+', 'Local Volunteers'],
            ['95K+',  'Children Helped'],
            ['84%',   'Funds to Programs'],
            ['66',    'Years of Experience'],
        ] as $s)
        <div class="stat-item reveal">
            <div class="stat-num">{{ $s[0] }}</div>
            <div class="stat-label">{{ $s[1] }}</div>
        </div>
        @endforeach
    </div>
</div>

<div class="wave" style="background:var(--cream)">
    <svg viewBox="0 0 1440 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,20 C480,42 960,0 1440,20 L1440,0 L0,0 Z" fill="#0f172a"/>
    </svg>
</div>

{{-- ══════════════════════
     ISSUES — image rows
══════════════════════ --}}
<section class="issues-section">
    <div class="max-w-6xl mx-auto px-4">

        <div class="reveal mb-14 text-center">
            <div class="section-tag mx-auto mb-3" style="display:inline-flex;">
                <i class="fas fa-circle-dot text-xs"></i> Key Issues We Address
            </div>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.9rem,3.5vw,3rem);font-weight:900;color:var(--ink);line-height:1.15;margin-bottom:12px;">
                Six Pillars of<br><span style="color:var(--orange);">Child Protection</span>
            </h2>
            <p style="font-family:'DM Sans',sans-serif;color:var(--muted);max-width:520px;margin:0 auto;line-height:1.75;">
                Every action we take is built on these foundations — because every child deserves safety, education, and dignity.
            </p>
        </div>

        @php
        $issues = [
            [
                'img'     => 'images/children/image-1.jpg',
                'num'     => '01',
                'badge'   => 'Child Labor',
                'icon'    => 'fas fa-hammer',
                'color'   => '#fff7ed',
                'iconClr' => '#f97316',
                'title'   => 'Ending Child Labor',
                'body'    => 'In Cambodia, many children are forced to work to help their families, often in dangerous and strenuous conditions. Des Ailes pour Grandir actively fights against child labor by raising community awareness, supporting families, and protecting the most vulnerable children.',
                'reverse' => false,
            ],
            [
                'img'     => 'images/children/image-2.jpg',
                'num'     => '02',
                'badge'   => 'Education',
                'icon'    => 'fas fa-book-open',
                'color'   => '#eff6ff',
                'iconClr' => '#3b82f6',
                'title'   => 'Access to Schooling',
                'body'    => 'Many vulnerable children do not have access to education, limiting their opportunities. Des Ailes pour Grandir supports schooling and educational follow-up, assisting children and strengthening local structures to enable them to learn and develop fully.',
                'reverse' => true,
            ],
            [
                'img'     => 'images/children/image-3.jpg',
                'num'     => '03',
                'badge'   => 'Safety',
                'icon'    => 'fas fa-hand-holding-heart',
                'color'   => '#f0fdf4',
                'iconClr' => '#22c55e',
                'title'   => 'Violence & Abuse Prevention',
                'body'    => 'Children may suffer physical, psychological, or sexual violence. Through ChildSafe training, our field team implements concrete prevention actions, raises awareness in communities, and intervenes quickly to protect children and provide appropriate support.',
                'reverse' => false,
            ],
            [
                'img'     => 'images/children/image-4.jpg',
                'num'     => '04',
                'badge'   => 'Trafficking',
                'icon'    => 'fas fa-ban',
                'color'   => '#fdf4ff',
                'iconClr' => '#a855f7',
                'title'   => 'Fighting Trafficking & Exploitation',
                'body'    => 'Cambodia faces child trafficking and exploitation for forced labor or sexual purposes. Des Ailes pour Grandir collaborates with local partners, including M\'Lop Tapang, to prevent these situations and reintegrate children into a safe environment.',
                'reverse' => true,
            ],
            [
                'img'     => 'images/children/image-5.jpg',
                'num'     => '05',
                'badge'   => 'Rights',
                'icon'    => 'fas fa-balance-scale',
                'color'   => '#fffbeb',
                'iconClr' => '#f59e0b',
                'title'   => 'Upholding Children\'s Rights',
                'body'    => 'All our actions are guided by the Convention on the Rights of the Child (CRC, 1989), which guarantees the right to education, protection, health, and well-being. Each project aims to defend these rights and create an environment where children can grow and build their future.',
                'reverse' => false,
            ],
            [
                'img'     => 'images/children/image-6.jpg',
                'num'     => '06',
                'badge'   => 'ChildSafe',
                'icon'    => 'fas fa-shield-check',
                'color'   => '#fff1f2',
                'iconClr' => '#ef4444',
                'title'   => 'ChildSafe: Prevention & Safety',
                'body'    => 'As a member of the ChildSafe network, our association applies international standards to protect children and prevent all forms of abuse. Our field team has completed the associated training, enabling us to act effectively every day.',
                'reverse' => true,
            ],
        ];
        @endphp

        @foreach($issues as $i => $issue)
        <div class="issue-row {{ $issue['reverse'] ? 'reverse' : '' }} reveal d{{ min($i+1,6) }}">
            <div class="issue-img">
                <img src="{{ asset($issue['img']) }}" alt="{{ $issue['title'] }}" loading="lazy">
                <div class="issue-img-overlay"></div>
                <div class="issue-img-num">{{ $issue['num'] }}</div>
                <div class="issue-img-badge">
                    <i class="{{ $issue['icon'] }}"></i>
                    {{ $issue['badge'] }}
                </div>
            </div>
            <div class="issue-content">
                <div class="issue-icon" style="background:{{ $issue['color'] }};">
                    <i class="{{ $issue['icon'] }}" style="color:{{ $issue['iconClr'] }};font-size:1.25rem;"></i>
                </div>
                <h3>{{ $issue['title'] }}</h3>
                <p>{{ $issue['body'] }}</p>
                <a href="{{ route('support.donate') }}" class="issue-link">
                    Support this cause <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
        @endforeach

    </div>
</section>

{{-- ══════════════════════
     PHOTO MOSAIC
══════════════════════ --}}
<section class="mosaic-section">
    <div class="max-w-6xl mx-auto px-4">

        <div class="reveal mb-10 text-center">
            <div class="section-tag mx-auto mb-3" style="display:inline-flex;">
                <i class="fas fa-images text-xs"></i> Life on the Ground
            </div>
            <h2 style="font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:900;color:var(--ink);">
                Children We Serve
            </h2>
        </div>

        <div class="mosaic-grid reveal">
            <div class="mosaic-cell span-row">
                <img src="{{ asset('images/children/image-7.jpg') }}" alt="Child in Cambodia" loading="lazy">
                <div class="mosaic-overlay"><span>Cambodia</span></div>
            </div>
            <div class="mosaic-cell span2">
                <img src="{{ asset('images/children/image-1.jpg') }}" alt="" loading="lazy">
                <div class="mosaic-overlay"><span>Education</span></div>
            </div>
            <div class="mosaic-cell">
                <img src="{{ asset('images/children/image-5.jpg') }}" alt="" loading="lazy">
                <div class="mosaic-overlay"><span>Safety</span></div>
            </div>
            <div class="mosaic-cell">
                <img src="{{ asset('images/children/image-3.jpg') }}" alt="" loading="lazy">
                <div class="mosaic-overlay"><span>Hope</span></div>
            </div>
            <div class="mosaic-cell span2">
                <img src="{{ asset('images/children/image-8.jpg') }}" alt="" loading="lazy">
                <div class="mosaic-overlay"><span>Community</span></div>
            </div>
            <div class="mosaic-cell">
                <img src="{{ asset('images/children/image-6.jpg') }}" alt="" loading="lazy">
                <div class="mosaic-overlay"><span>Growth</span></div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════
     CHILDSAFE BANNER
══════════════════════ --}}
<section class="bg-white py-16 md:py-20">
    <div class="max-w-6xl mx-auto px-4">
        <div class="childsafe-banner reveal">
            <div>
                <div class="section-tag mb-4" style="background:rgba(249,115,22,.12);border-color:rgba(249,115,22,.25);">
                    <i class="fas fa-certificate text-xs"></i> Certified Member
                </div>
                <h3>Proud Member of the<br>ChildSafe Network</h3>
                <p>As a certified ChildSafe member, we apply international standards to protect children from abuse in all our programs. Every team member has received specialized training to recognize and respond to risks effectively.</p>
            </div>
            <div class="cs-badge">
                <i class="fas fa-shield-check"></i>
                <div class="cs-badge-text">
                    <div class="cs-badge-label">Certified by</div>
                    <div class="cs-badge-name">ChildSafe</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════
     CTA BANNER
══════════════════════ --}}
<section class="bg-white pb-16 md:pb-24">
    <div class="max-w-6xl mx-auto px-4">
        <div class="cta-banner reveal">
            <div class="cta-banner-inner">
                <div>
                    <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.8rem,3vw,2.8rem);font-weight:900;color:#fff;line-height:1.15;margin-bottom:10px;">
                        Make a Difference Today
                    </h2>
                    <p style="font-family:'DM Sans',sans-serif;color:rgba(255,255,255,.8);font-size:1rem;max-width:460px;line-height:1.7;">
                        Your support funds programs like child protection, education, and community care across Cambodia.
                    </p>
                </div>
                <div class="cta-btns">
                    <a href="{{ route('sponsor.children') }}" class="btn-white">
                        <i class="fas fa-heart"></i> Sponsor a Child
                    </a>
                    <a href="{{ route('support.donate') }}" class="btn-outline-white">
                        <i class="fas fa-hand-holding-heart"></i> Donate Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function(){
    /* Scroll reveal */
    const o = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); o.unobserve(e.target); }
        });
    }, { threshold: .08, rootMargin: '0px 0px -50px 0px' });
    document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale')
            .forEach(el => o.observe(el));
})();
</script>

@endsection