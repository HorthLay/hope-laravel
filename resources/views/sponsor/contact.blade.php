{{-- resources/views/sponsor/contact.blade.php --}}
@extends('layouts.app')

@section('title', 'Create a Sponsor Account')

@section('content')

@php
    $headerSettings = (function() {
        $file = storage_path('app/settings.json');
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    })();
    $emailUrl     = !empty($headerSettings['contact_email'])  ? 'https://mail.google.com/mail/?view=cm&to=' . $headerSettings['contact_email'] : null;
    $whatsappUrl  = !empty($headerSettings['whatsapp_url'])   ? 'https://wa.me/' . $headerSettings['whatsapp_url']  : null;
    $telegramUrl  = !empty($headerSettings['telegram_url'])   ? 'https://t.me/' . $headerSettings['telegram_url']   : null;
    $facebookUrl  = $headerSettings['facebook_url']  ?? null ?: null;
    $instagramUrl = $headerSettings['instagram_url'] ?? null ?: null;
    $youtubeUrl   = $headerSettings['youtube_url']   ?? null ?: null;
    $linkedinUrl  = $headerSettings['linkedin_url']  ?? null ?: null;
@endphp

<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=DM+Sans:wght@300;400;500;600;700;800&family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,700;0,9..144,900;1,9..144,300;1,9..144,700&display=swap" rel="stylesheet"/>

<style>
/* ══════════════════════════════════════════════
   DESIGN TOKENS
══════════════════════════════════════════════ */
:root {
    --orange:     #f4b630;
    --orange-dk:  #8a5f00;
    --orange-lt:  #fed7aa;
    --ink:        #0f0e0d;
    --ink-soft:   #2c2a28;
    --mist:       #f5f3ef;
    --white:      #ffffff;
    --hero-bg:    #f4b630;
    --hero-bg-2:  #d99a12;
    --hero-text:  #ffffff;
    --hero-muted: rgba(255,255,255,.82);
    --hero-line:  rgba(255,255,255,.28);
    --ff-display: 'Montserrat', sans-serif;
    --ff-body:    'Montserrat', sans-serif;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--ff-body); }

/* ══════════════════════════════════════════════
   ANIMATIONS & REVEAL
══════════════════════════════════════════════ */
@keyframes fadeUp     { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeLeft   { from{opacity:0;transform:translateX(24px)} to{opacity:1;transform:translateX(0)} }
@keyframes scaleIn    { from{opacity:0;transform:scale(.94)} to{opacity:1;transform:scale(1)} }
@keyframes bounceY    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(6px)} }

.reveal       {opacity:0;transform:translateY(28px); transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-left  {opacity:0;transform:translateX(-36px);transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-right {opacity:0;transform:translateX(36px); transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal.visible,.reveal-left.visible,.reveal-right.visible{opacity:1;transform:none}
.stagger-1{transition-delay:.05s}.stagger-2{transition-delay:.12s}.stagger-3{transition-delay:.19s}
.stagger-4{transition-delay:.26s}.stagger-5{transition-delay:.33s}

/* ══════════════════════════════════════════════
   HERO
══════════════════════════════════════════════ */
.hero {
    position: relative;
    min-height: clamp(380px, 52vh, 500px);
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #11100f;
    font-family: var(--ff-body);
    isolation: isolate;
}
.hero::after {
    content: '';
    position: absolute;
    inset: 0;
    z-index: 1;
    background:
        linear-gradient(90deg, rgba(0,0,0,.22) 0%, rgba(0,0,0,.36) 38%, rgba(0,0,0,.24) 66%, rgba(0,0,0,.10) 100%),
        linear-gradient(180deg, rgba(0,0,0,.04) 0%, rgba(0,0,0,.08) 48%, rgba(0,0,0,.26) 100%);
    pointer-events: none;
}

/* ── Photo panel (left) ── */
.hero-photo {
    position: absolute;
    inset: 0;
    z-index: 0;
    overflow: hidden;
}
.hero-photo-img {
    position: absolute;
    inset: 0;
    background-image: url('{{ asset('images/image-background.jpg') }}');
    background-size: cover;
    background-position: center 48%;
    transform: none;
    transition: none;
    filter: none;
}
.hero:hover .hero-photo-img { transform: none; }

.hero-photo::after {
    display: none;
}

.hero-photo::before {
    display: none;
}

.hero-photo-thumbs {
    display: none;
}
.hero-thumb {
    width: 80px;
    height: 60px;
    border-radius: 10px;
    background-size: cover;
    background-position: center;
    border: 2.5px solid rgba(255,255,255,.2);
    box-shadow: 0 4px 16px rgba(0,0,0,.4);
    transition: transform .3s, border-color .3s;
}
.hero-thumb:hover { transform: scale(1.07); border-color: var(--orange); }

/* ── Content panel (right) ── */
.hero-content {
    position: relative;
    background: transparent;
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 100%;
    max-width: 980px;
    margin: 0 auto;
    padding: 76px 36px 58px;
    z-index: 2;
}

.hero-content::before {
    display: none;
}

.hero-breadcrumb {
    display: none;
    align-items: center;
    gap: 8px;
    font-size: 10.5px;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: rgba(255,255,255,.70);
    margin-bottom: 20px;
    animation: fadeUp .6s ease both;
}
.hero-breadcrumb a { color: rgba(255,255,255,.70); text-decoration: none; transition: color .2s; }
.hero-breadcrumb a:hover { color: var(--hero-text); }
.hero-breadcrumb i { font-size: 7px; }

.hero-eyebrow {
    display: none;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    border-radius: 999px;
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.28);
    color: #fff7ed;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    margin-bottom: 18px;
    width: fit-content;
    animation: fadeUp .7s .05s ease both;
}
.hero-eyebrow-dot {
    width: 6px; height: 6px;
    background: #fff7ed;
    border-radius: 50%;
    animation: pulse-dot 2s ease-in-out infinite;
}
@keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }

.hero-h1 {
    font-family: 'Montserrat', sans-serif;
    font-size: clamp(2.15rem, 3.8vw, 3.1rem);
    font-weight: 800;
    line-height: .98;
    letter-spacing: .01em;
    color: var(--hero-text);
    max-width: 620px;
    margin: 0 0 18px;
    text-shadow:
        0 2px 5px rgba(0,0,0,.50),
        0 8px 22px rgba(0,0,0,.36);
    animation: fadeUp .8s .1s ease both;
}
.hero-h1 em {
    font-style: normal;
    font-weight: 800;
    color: #fff;
}

.hero-h1-accent {
    display: none;
}

.hero-body {
    font-size: clamp(.92rem, 1.25vw, 1.05rem);
    line-height: 1.65;
    color: #fff;
    font-weight: 600;
    max-width: 610px;
    margin: 0 0 22px;
    text-shadow:
        0 1px 3px rgba(0,0,0,.72),
        0 5px 14px rgba(0,0,0,.48);
    animation: fadeUp .85s .2s ease both;
}
.hero-body strong { color: var(--hero-text); font-weight: 800; }

/* ── CTA buttons ── */
.hero-ctas {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    animation: fadeUp .9s .25s ease both;
}
.hero-btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 42px;
    padding: 0 20px;
    border-radius: 3px;
    background: #ffc400;
    color: #243644;
    font-family: 'Montserrat', sans-serif;
    font-size: 1.02rem;
    font-weight: 800;
    text-decoration: none;
    letter-spacing: .045em;
    text-transform: uppercase;
    box-shadow: 0 2px 10px rgba(0,0,0,.26);
    transition: background .18s, transform .18s;
    cursor: pointer;
    border: none;
}
.hero-btn-primary:hover {
    background: #ffd226;
    color: #243644;
    transform: translateY(-1px);
    box-shadow: 0 2px 10px rgba(0,0,0,.26);
}

/* ── Contact scroll button ── */
.hero-btn-contact {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    min-height: 42px;
    padding: 0 18px;
    border-radius: 3px;
    border: 1px solid rgba(255,255,255,.45);
    background: rgba(255,255,255,.08);
    color: #fff;
    font-family: 'Montserrat', sans-serif;
    font-size: 1.02rem;
    font-weight: 800;
    letter-spacing: .045em;
    text-transform: uppercase;
    text-decoration: none;
    cursor: pointer;
    transition: border-color .25s, color .25s, background .25s;
}
.hero-btn-contact:hover {
    border-color: rgba(255,255,255,.65);
    color: #fff;
    background: rgba(255,255,255,.12);
}
.hero-btn-contact i { font-size: 11px; }

/* ── Stats bar ── */
.hero-stats {
    display: none;
    align-items: stretch;
    gap: 0;
    margin-top: 34px;
    border-top: 1px solid var(--hero-line);
    padding-top: 24px;
    animation: fadeUp 1s .35s ease both;
}
.hero-stat {
    flex: 1;
    padding: 0 24px 0 0;
    position: relative;
}
.hero-stat + .hero-stat {
    padding-left: 24px;
    border-left: 1px solid var(--hero-line);
}
.hero-stat-num {
    font-family: var(--ff-display);
    font-size: clamp(1.8rem, 2.8vw, 2.5rem);
    font-weight: 900;
    color: var(--hero-text);
    line-height: 1;
    margin-bottom: 4px;
}
.hero-stat-num span { color: #ffedd5; }
.hero-stat-label {
    font-size: 11px;
    color: rgba(255,255,255,.76);
    font-weight: 500;
    letter-spacing: .03em;
    line-height: 1.5;
}

/* ── Floating trust badge ── */
.hero-trust {
    display: none;
    position: absolute;
    bottom: 28px;
    left: 36px;
    z-index: 10;
    background: rgba(15,14,13,.75);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 16px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    max-width: 240px;
    animation: scaleIn 1s .5s ease both;
}
.hero-trust-icon {
    width: 38px;
    height: 38px;
    background: linear-gradient(135deg, var(--orange), #8a5f00);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 16px;
    color: #fff;
}
.hero-trust-text strong {
    display: block;
    font-size: 13px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 2px;
}
.hero-trust-text span {
    font-size: 11px;
    color: rgba(255,255,255,.45);
    line-height: 1.4;
}

/* ── Vertical label ── */
.hero-vertical-label {
    display: none;
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%) rotate(-90deg);
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: rgba(255,255,255,.25);
    z-index: 5;
    white-space: nowrap;
}

/* ── Scroll-down chevron (bottom of hero content) ── */
.hero-scroll-hint {
    position: absolute;
    bottom: 22px;
    right: 64px;
    display: none;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    opacity: .35;
    transition: opacity .2s;
    animation: fadeUp 1.2s .6s ease both;
    border: none;
    background: none;
    color: #fff7ed;
    z-index: 5;
}
.hero-scroll-hint:hover { opacity: .8; }
.hero-scroll-hint span {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: rgba(255,255,255,.72);
}
.hero-scroll-hint i {
    font-size: 14px;
    animation: bounceY 1.6s ease-in-out infinite;
}

/* ══════════════════════════════════════════════
   WAVE DIVIDER
══════════════════════════════════════════════ */
.wave-divider { line-height: 0; overflow: hidden; }
.wave-divider svg { display: block; }

/* ══════════════════════════════════════════════
   HELLOASSO IFRAME SECTION
══════════════════════════════════════════════ */
.ha-section {
    background: #f5f3ef;
    border-top: 1px solid #ede9e3;
    padding: 72px 0 80px;
}
.ha-section-inner {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 24px;
}
.ha-section-header {
    text-align: center;
    margin-bottom: 40px;
}
.ha-section-header .ha-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 6px 18px;
    border-radius: 999px;
    background: rgba(244,182,48,.10);
    border: 1px solid rgba(244,182,48,.25);
    color: #d99a12;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .07em;
    text-transform: uppercase;
    margin-bottom: 18px;
}
.ha-section-header h2 {
    font-family: var(--ff-display);
    font-size: clamp(1.7rem, 3vw, 2.4rem);
    font-weight: 900;
    color: var(--ink);
    margin: 0 0 12px;
    line-height: 1.15;
}
.ha-section-header p {
    font-size: 14.5px;
    color: #6b7280;
    max-width: 480px;
    margin: 0 auto;
    line-height: 1.75;
}
.ha-frame-wrap {
    background: var(--white);
    border-radius: 28px;
    border: 1px solid #e8e4de;
    box-shadow: 0 12px 56px rgba(0,0,0,.08), 0 2px 8px rgba(0,0,0,.04);
    overflow: hidden;
    position: relative;
}
.ha-frame-wrap::before {
    content: '';
    display: block;
    height: 5px;
    background: linear-gradient(90deg, #f4b630 0%, #d99a12 50%, #f8c75a 100%);
}
.ha-frame-loader {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 16px;
    background: var(--white);
    z-index: 2;
    transition: opacity .5s ease, visibility .5s ease;
}
.ha-frame-loader.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}
.ha-spinner {
    width: 40px;
    height: 40px;
    border: 3px solid #fed7aa;
    border-top-color: #f4b630;
    border-radius: 50%;
    animation: spin .75s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.ha-frame-loader p {
    font-size: 12px;
    color: #9ca3af;
    font-weight: 600;
    letter-spacing: .02em;
}
#haWidget {
    display: block;
    width: 100%;
    border: none;
    min-height: 750px;
}

/* ══════════════════════════════════════════════
   CONTACT SECTION
══════════════════════════════════════════════ */
.contact-section {
    background: #ffffff;
    padding: 72px 0 80px;
    border-top: 1px solid #f1f5f9;
}
.contact-section-inner {
    max-width: 1080px;
    margin: 0 auto;
    padding: 0 24px;
}
.contact-section-header {
    text-align: center;
    margin-bottom: 48px;
}
.contact-section-header .cs-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 6px 18px;
    border-radius: 999px;
    background: rgba(244,182,48,.08);
    border: 1px solid rgba(244,182,48,.2);
    color: #d99a12;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .07em;
    text-transform: uppercase;
    margin-bottom: 16px;
}
.contact-section-header h2 {
    font-family: var(--ff-display);
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 900;
    color: var(--ink);
    margin: 0 0 10px;
    line-height: 1.15;
}
.contact-section-header p {
    font-size: 14px;
    color: #6b7280;
    max-width: 440px;
    margin: 0 auto;
    line-height: 1.75;
}

.contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }

/* ── Cards ── */
.info-card { background:#fff; border-radius:20px; border:1px solid #f1f5f9; box-shadow:0 4px 20px rgba(0,0,0,.06); padding:28px; }
.card-title { font-size:18px; font-weight:900; color:#1f2937; margin:0 0 6px; font-family:var(--ff-body); }
.card-sub   { font-size:13px; color:#6b7280; margin:0 0 22px; line-height:1.65; }
.section-label { font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:.07em; color:#9ca3af; margin:0 0 14px; }

/* ── Steps ── */
.step { display:flex; align-items:flex-start; gap:13px; }
.step+.step { margin-top:18px; }
.step-icon { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; font-size:14px; }
.step h3 { font-size:13px; font-weight:800; color:#1f2937; margin:0 0 3px; }
.step p  { font-size:11px; color:#6b7280; margin:0; line-height:1.5; }

/* ── Contact buttons ── */
.contact-list { display:flex; flex-direction:column; gap:10px; }
.contact-btn {
    display:flex; align-items:center; gap:13px;
    padding:14px 16px; border-radius:14px; text-decoration:none;
    background:#f9fafb; border:1.5px solid #f3f4f6;
    transition:all .18s; min-height:64px;
}
.contact-btn:hover,.contact-btn:active { transform:translateY(-2px); box-shadow:0 8px 20px rgba(0,0,0,.10); }
.btn-icon  { width:44px; height:44px; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:21px; }
.btn-body  { flex:1; min-width:0; }
.btn-title { font-size:13px; font-weight:800; color:#1f2937; }
.btn-sub   { font-size:11px; color:#9ca3af; margin-top:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.btn-arrow { color:#d1d5db; font-size:11px; flex-shrink:0; }
.contact-btn.email:hover     { background:#fff7ed; border-color:#fed7aa; }
.contact-btn.whatsapp:hover  { background:#f0fdf4; border-color:#bbf7d0; }
.contact-btn.telegram:hover  { background:#f0f9ff; border-color:#bae6fd; }
.contact-btn.facebook:hover  { background:#eff6ff; border-color:#bfdbfe; }
.contact-btn.instagram:hover { background:#fdf2f8; border-color:#f5d0fe; }
.contact-btn.youtube:hover   { background:#fef2f2; border-color:#fecaca; }
.contact-btn.linkedin:hover  { background:#eff6ff; border-color:#bfdbfe; }

/* ── Why card ── */
.why-card { background:linear-gradient(135deg,#f4b630,#d99a12); border-radius:20px; padding:24px; color:#fff; box-shadow:0 8px 28px rgba(244,182,48,.30); }
.why-card h3 { font-size:17px; font-weight:900; margin:0 0 16px; }
.why-item { display:flex; align-items:flex-start; gap:9px; font-size:13px; }
.why-item+.why-item { margin-top:10px; }
.why-item i { margin-top:2px; flex-shrink:0; }

/* ── Mobile trigger button ── */
.mobile-contact-trigger {
    display:none; align-items:center; justify-content:center; gap:10px;
    width:100%; padding:18px;
    background:linear-gradient(135deg,#f4b630,#d99a12);
    color:#fff; border:none; border-radius:16px;
    font-family:var(--ff-body); font-size:15px; font-weight:900;
    cursor:pointer; box-shadow:0 8px 24px rgba(244,182,48,.38);
    transition:transform .15s, box-shadow .15s;
}
.mobile-contact-trigger:active { transform:scale(.97); }
.mobile-contact-trigger i { font-size:18px; }

/* ══════════════════════════════════════════════
   BOTTOM SHEET MODAL
══════════════════════════════════════════════ */
.modal-overlay {
    display:none; position:fixed; inset:0; z-index:1200;
    background:rgba(0,0,0,.45); backdrop-filter:blur(4px);
    align-items:flex-end; justify-content:center;
}
.modal-overlay.open { display:flex; }
.modal-sheet {
    background:#fff; width:100%; max-width:520px;
    border-radius:24px 24px 0 0;
    max-height:90dvh; overflow-y:auto;
    transform:translateY(110%);
    transition:transform .35s cubic-bezier(.4,0,.2,1);
    padding-bottom:env(safe-area-inset-bottom,16px);
}
.modal-overlay.open .modal-sheet { transform:translateY(0); }
.modal-handle { width:40px; height:4px; background:#e5e7eb; border-radius:2px; margin:14px auto 0; }
.modal-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 20px 12px; border-bottom:1px solid #f3f4f6;
    position:sticky; top:0; background:#fff; z-index:1;
}
.modal-title { font-size:16px; font-weight:900; color:#1f2937; }
.modal-close {
    width:32px; height:32px; border-radius:50%;
    border:none; background:#f3f4f6; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    color:#6b7280; font-size:13px; transition:background .2s;
}
.modal-close:hover { background:#e5e7eb; }
.modal-body { padding:18px 20px 28px; }

/* ══════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════ */
@media (max-width: 900px) {
    .hero { min-height: clamp(420px, 68vh, 540px); }
    .hero-photo { position: absolute; inset: 0; height: auto; min-height: 0; max-height: none; }
    .hero-photo-img { background-position: 58% 48%; }
    .hero-photo::before { display: none; }
    .hero-photo-thumbs { display: none; }
    .hero-vertical-label { display: none; }
    .hero-trust { display: none; }
    .hero-content { padding: 64px 24px 46px; }
}
@media (max-width: 767px) {
    .contact-grid { grid-template-columns: 1fr; }
    .desktop-contact-col { display: none !important; }
    .mobile-contact-trigger { display: flex !important; }
    #why-mobile { display: block !important; }
    #why-desktop { display: none !important; }
    .ha-section { padding: 48px 0 56px; }
    .ha-frame-wrap { border-radius: 18px; }
    #haWidget { min-height: 680px; }
}
@media (min-width: 768px) {
    .mobile-contact-trigger { display: none !important; }
    #why-mobile { display: none !important; }
    #why-desktop { display: block !important; }
}
@media (max-width: 480px) {
    .hero { min-height: clamp(460px, 80vh, 560px); }
    .hero-photo { position: absolute; inset: 0; height: auto; min-height: 0; max-height: none; }
    .hero-content { padding: 54px 20px; }
    .hero-h1 { font-size: clamp(1.9rem, 10vw, 2.45rem); line-height: 1; }
    .hero-body { font-size: .92rem; }
    .hero-stats { flex-direction: column; gap: 20px; }
    .hero-stat { border-left: none !important; padding-left: 0 !important; border-top: 1px solid var(--hero-line); padding-top: 20px; }
    .hero-stat:first-child { border-top: none; padding-top: 0; }
    .hero-ctas { flex-direction: column; align-items: stretch; }
    .hero-btn-primary, .hero-btn-contact { justify-content: center; }
}
</style>

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section class="hero">

    {{-- Left: photo --}}
    <div class="hero-photo">
        <div class="hero-photo-img"></div>
        <span class="hero-vertical-label">Des Ailes Pour Grandir &nbsp;·&nbsp; Cambodia</span>
        <div class="hero-photo-thumbs">
            <div class="hero-thumb" style="background-image:url('{{ asset('images/children/image-2.jpg') }}')"></div>
            <div class="hero-thumb" style="background-image:url('{{ asset('images/children/image-3.jpg') }}')"></div>
        </div>
        <div class="hero-trust">
            <div class="hero-trust-icon"><i class="fas fa-shield-alt"></i></div>
            <div class="hero-trust-text">
                <strong>Secure &amp; Transparent</strong>
                <span>Registered French nonprofit</span>
            </div>
        </div>
    </div>

    {{-- Right: content --}}
    <div class="hero-content">

        <nav class="hero-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right"></i>
            <span style="color:rgba(255,255,255,.78)">Sponsor</span>
            <i class="fas fa-chevron-right"></i>
            <span style="color:rgba(255,255,255,.9)">Create Account</span>
        </nav>

        <div class="hero-eyebrow">
            <span class="hero-eyebrow-dot"></span>
            Become a Sponsor
        </div>

        <h1 class="hero-h1">
            Give a Child<br>
            <em>Wings to Grow</em>
        </h1>

        <p class="hero-h1-accent">One decision. A lifetime of impact.</p>

        <p class="hero-body">
            Your sponsorship provides <strong>education, nutrition, and healthcare</strong>
            to children who need it most. For just €1 a day, you can walk alongside
            a child as they grow — and receive their story every step of the way.
        </p>

        <div class="hero-ctas">
            {{-- Primary: scroll to HelloAsso form --}}
            <a href="#registration" class="hero-btn-primary" onclick="smoothScroll(event,'registration')">
                <i class="fas fa-heart" style="font-size:12px"></i>
                Register to Become a Sponsor
            </a>

            {{-- Secondary: scroll to contact section --}}
            <a href="#contact" class="hero-btn-contact" onclick="smoothScroll(event,'contact')">
                <i class="fas fa-paper-plane"></i>
                Contact Us
            </a>
        </div>

        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-num" data-count="247">0<span>+</span></div>
                <div class="hero-stat-label">Children<br>sponsored</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num" data-count="84"><span></span>0<span>%</span></div>
                <div class="hero-stat-label">Funds reach<br>programs directly</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num" data-count="12">0<span>+</span></div>
                <div class="hero-stat-label">Years of<br>impact</div>
            </div>
        </div>

        {{-- Scroll-down hint --}}
        <button class="hero-scroll-hint" onclick="smoothScroll(event,'registration')" aria-label="Scroll down">
            <span>Scroll</span>
            <i class="fas fa-chevron-down"></i>
        </button>

    </div>
</section>

<div class="wave-divider" style="background:#f5f3ef">
    <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,24 C480,52 960,0 1440,24 L1440,0 L0,0 Z" fill="#d99a12"/>
    </svg>
</div>

{{-- ══════════════════════════════════════════
     HELLOASSO REGISTRATION SECTION
══════════════════════════════════════════ --}}
<section class="ha-section" id="registration">
    <div class="ha-section-inner">
        <div class="ha-section-header reveal">
            <div class="ha-pill">
                <i class="fas fa-heart" style="font-size:9px"></i>
                Online Registration
            </div>
            <h2>Register directly online</h2>
            <p>Complete your sponsor registration securely in just a few minutes via our HelloAsso partner platform.</p>
        </div>

        <div class="ha-frame-wrap reveal stagger-1">
            <div class="ha-frame-loader" id="ha-loader">
                <div class="ha-spinner"></div>
                <p>Loading registration form…</p>
            </div>
            <iframe
                id="haWidget"
                allowtransparency="true"
                scrolling="auto"
                src="https://www.helloasso.com/associations/des-ailes-pour-grandir/adhesions/devenir-parraine-marraine-ou-etoiledefamille/widget"
                style="width:100%;border:none;min-height:750px;display:block;"
                onload="haWidgetLoaded(this)"
            ></iframe>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4" style="line-height:1.7;font-family:var(--ff-body)">
            <i class="fas fa-lock mr-1 text-green-400"></i>
            Secure payment powered by <strong>HelloAsso</strong> &mdash; a French nonprofit platform. Your data is protected.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════
     CONTACT SECTION  ← anchor target
══════════════════════════════════════════ --}}
<section class="contact-section" id="contact">
    <div class="contact-section-inner">

        {{-- Section header --}}
        <div class="contact-section-header reveal">
            <div class="cs-pill">
                <i class="fas fa-paper-plane" style="font-size:9px"></i>
                Get in Touch
            </div>
            <h2>Prefer to contact us directly?</h2>
            <p>Our team is here to help you create your account and answer any questions.</p>
        </div>

        {{-- Mobile trigger --}}
        <div class="mb-6 reveal stagger-1">
            <button class="mobile-contact-trigger" onclick="openContactModal()">
                <i class="fas fa-paper-plane"></i>
                <span>Contact Us</span>
                <i class="fas fa-chevron-up" style="font-size:12px;margin-left:auto;opacity:.7;"></i>
            </button>
        </div>

        <div class="contact-grid">

            {{-- LEFT: How to + Why (mobile) --}}
            <div style="display:flex;flex-direction:column;gap:20px;">
                <div class="info-card reveal">
                    <h2 class="card-title">How to create an account?</h2>
                    <p class="card-sub">Contact us via one of the methods below. Our team will guide you through the process and create your account.</p>

                    @if($emailUrl)
                    <div class="step">
                        <div class="step-icon" style="background:#fff7ed"><i class="fas fa-envelope" style="color:#f4b630"></i></div>
                        <div><h3>Send us an email</h3><p>Include your name, email and phone number.</p></div>
                    </div>
                    @endif
                    @if($whatsappUrl)
                    <div class="step">
                        <div class="step-icon" style="background:#f0fdf4"><i class="fab fa-whatsapp" style="color:#22c55e"></i></div>
                        <div><h3>Contact us on WhatsApp</h3><p>Immediate assistance via WhatsApp.</p></div>
                    </div>
                    @endif
                    @if($telegramUrl)
                    <div class="step">
                        <div class="step-icon" style="background:#f0f9ff"><i class="fab fa-telegram" style="color:#0ea5e9"></i></div>
                        <div><h3>Message on Telegram</h3><p>Create your account via Telegram.</p></div>
                    </div>
                    @endif
                    @if($facebookUrl)
                    <div class="step">
                        <div class="step-icon" style="background:#eff6ff"><i class="fab fa-facebook" style="color:#2563eb"></i></div>
                        <div><h3>Contact us on Facebook</h3><p>Via our official Facebook page.</p></div>
                    </div>
                    @endif
                    @if(!$emailUrl && !$whatsappUrl && !$telegramUrl && !$facebookUrl)
                    <div class="step">
                        <div class="step-icon" style="background:#f3f4f6"><i class="fas fa-headset" style="color:#9ca3af"></i></div>
                        <div><h3>Reach out to our team</h3><p>We will get back to you within 24 hours.</p></div>
                    </div>
                    @endif
                </div>

                <div class="why-card reveal stagger-2" id="why-mobile">
                    <h3>Why Become a Sponsor?</h3>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Directly change a child's life</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Receive regular updates & photos</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>84% of funds go directly to programs</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Track your child's education journey</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>For just €1 a day — make a lasting impact</span></div>
                </div>
            </div>

            {{-- RIGHT: Contact list + Why (desktop) --}}
            <div class="desktop-contact-col" style="display:flex;flex-direction:column;gap:20px;">
                <div class="info-card reveal stagger-1">
                    <p class="section-label">Contact Us Directly</p>
                    <div class="contact-list">
                        @if($emailUrl)
                        <a href="{{ $emailUrl }}" target="_blank" class="contact-btn email">
                            <div class="btn-icon" style="background:#fff7ed"><i class="fas fa-envelope" style="color:#f4b630"></i></div>
                            <div class="btn-body"><div class="btn-title">Email</div><div class="btn-sub">{{ $headerSettings['contact_email'] ?? 'Send us a message' }}</div></div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif
                        @if($whatsappUrl)
                        <a href="{{ $whatsappUrl }}" target="_blank" class="contact-btn whatsapp">
                            <div class="btn-icon" style="background:#f0fdf4"><i class="fab fa-whatsapp" style="color:#22c55e"></i></div>
                            <div class="btn-body"><div class="btn-title">WhatsApp</div><div class="btn-sub">Instant chat</div></div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif
                        @if($telegramUrl)
                        <a href="{{ $telegramUrl }}" target="_blank" class="contact-btn telegram">
                            <div class="btn-icon" style="background:#f0f9ff"><i class="fab fa-telegram" style="color:#0ea5e9"></i></div>
                            <div class="btn-body"><div class="btn-title">Telegram</div><div class="btn-sub">{{ $headerSettings['telegram_url'] ?? '' }}</div></div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif
                        @if($facebookUrl)
                        <a href="{{ $facebookUrl }}" target="_blank" class="contact-btn facebook">
                            <div class="btn-icon" style="background:#eff6ff"><i class="fab fa-facebook" style="color:#2563eb"></i></div>
                            <div class="btn-body"><div class="btn-title">Facebook</div><div class="btn-sub">Official page</div></div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif
                        @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" class="contact-btn instagram">
                            <div class="btn-icon" style="background:#fdf2f8"><i class="fab fa-instagram" style="color:#ec4899"></i></div>
                            <div class="btn-body"><div class="btn-title">Instagram</div><div class="btn-sub">{{ $headerSettings['instagram_url'] ?? '' }}</div></div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif
                        @if($youtubeUrl)
                        <a href="{{ $youtubeUrl }}" target="_blank" class="contact-btn youtube">
                            <div class="btn-icon" style="background:#fef2f2"><i class="fab fa-youtube" style="color:#dc2626"></i></div>
                            <div class="btn-body"><div class="btn-title">YouTube</div><div class="btn-sub">Watch our stories</div></div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif
                        @if($linkedinUrl)
                        <a href="{{ $linkedinUrl }}" target="_blank" class="contact-btn linkedin">
                            <div class="btn-icon" style="background:#eff6ff"><i class="fab fa-linkedin" style="color:#1d4ed8"></i></div>
                            <div class="btn-body"><div class="btn-title">LinkedIn</div><div class="btn-sub">{{ $headerSettings['linkedin_url'] ?? '' }}</div></div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif
                        @if(!$emailUrl && !$whatsappUrl && !$telegramUrl && !$facebookUrl && !$instagramUrl && !$youtubeUrl && !$linkedinUrl)
                        <div style="padding:20px;text-align:center;color:#9ca3af;font-size:12px;background:#f9fafb;border-radius:12px;">
                            <i class="fas fa-info-circle" style="margin-right:6px"></i>No contact links configured yet.
                        </div>
                        @endif
                    </div>
                </div>

                <div class="why-card reveal stagger-2" id="why-desktop">
                    <h3>Why Become a Sponsor?</h3>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Directly change a child's life</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Receive regular updates & photos</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>84% of funds go directly to programs</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Track your child's education journey</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>For just €1 a day — make a lasting impact</span></div>
                </div>
            </div>

        </div>{{-- /contact-grid --}}

        <div class="mt-10 text-center reveal">
            <p class="text-sm text-gray-400" style="font-family:var(--ff-body)">
                Already have an account?
                <a href="{{ route('sponsor.login') }}" class="text-orange-500 font-bold hover:underline ml-1">
                    <i class="fas fa-sign-in-alt mr-1"></i>Log in here
                </a>
            </p>
        </div>

    </div>
</section>

{{-- MOBILE BOTTOM SHEET MODAL --}}
<div class="modal-overlay" id="contact-modal" onclick="handleOverlayClick(event)">
    <div class="modal-sheet" id="modal-sheet">
        <div class="modal-handle"></div>
        <div class="modal-header">
            <span class="modal-title">Contact Us</span>
            <button class="modal-close" onclick="closeContactModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="contact-list">
                @if($emailUrl)
                <a href="{{ $emailUrl }}" target="_blank" class="contact-btn email">
                    <div class="btn-icon" style="background:#fff7ed"><i class="fas fa-envelope" style="color:#f4b630"></i></div>
                    <div class="btn-body"><div class="btn-title">Email</div><div class="btn-sub">{{ $headerSettings['contact_email'] ?? 'Send us a message' }}</div></div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif
                @if($whatsappUrl)
                <a href="{{ $whatsappUrl }}" target="_blank" class="contact-btn whatsapp">
                    <div class="btn-icon" style="background:#f0fdf4"><i class="fab fa-whatsapp" style="color:#22c55e"></i></div>
                    <div class="btn-body"><div class="btn-title">WhatsApp</div><div class="btn-sub">Instant chat</div></div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif
                @if($telegramUrl)
                <a href="{{ $telegramUrl }}" target="_blank" class="contact-btn telegram">
                    <div class="btn-icon" style="background:#f0f9ff"><i class="fab fa-telegram" style="color:#0ea5e9"></i></div>
                    <div class="btn-body"><div class="btn-title">Telegram</div><div class="btn-sub">{{ $headerSettings['telegram_url'] ?? '' }}</div></div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif
                @if($facebookUrl)
                <a href="{{ $facebookUrl }}" target="_blank" class="contact-btn facebook">
                    <div class="btn-icon" style="background:#eff6ff"><i class="fab fa-facebook" style="color:#2563eb"></i></div>
                    <div class="btn-body"><div class="btn-title">Facebook</div><div class="btn-sub">Official page</div></div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif
                @if($instagramUrl)
                <a href="{{ $instagramUrl }}" target="_blank" class="contact-btn instagram">
                    <div class="btn-icon" style="background:#fdf2f8"><i class="fab fa-instagram" style="color:#ec4899"></i></div>
                    <div class="btn-body"><div class="btn-title">Instagram</div><div class="btn-sub">{{ $headerSettings['instagram_url'] ?? '' }}</div></div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif
                @if($youtubeUrl)
                <a href="{{ $youtubeUrl }}" target="_blank" class="contact-btn youtube">
                    <div class="btn-icon" style="background:#fef2f2"><i class="fab fa-youtube" style="color:#dc2626"></i></div>
                    <div class="btn-body"><div class="btn-title">YouTube</div><div class="btn-sub">Watch our stories</div></div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif
                @if($linkedinUrl)
                <a href="{{ $linkedinUrl }}" target="_blank" class="contact-btn linkedin">
                    <div class="btn-icon" style="background:#eff6ff"><i class="fab fa-linkedin" style="color:#1d4ed8"></i></div>
                    <div class="btn-body"><div class="btn-title">LinkedIn</div><div class="btn-sub">{{ $headerSettings['linkedin_url'] ?? '' }}</div></div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif
                @if(!$emailUrl && !$whatsappUrl && !$telegramUrl && !$facebookUrl && !$instagramUrl && !$youtubeUrl && !$linkedinUrl)
                <div style="padding:20px;text-align:center;color:#9ca3af;font-size:12px;background:#f9fafb;border-radius:12px;">
                    <i class="fas fa-info-circle" style="margin-right:6px"></i>No contact links configured yet.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// ── Smooth scroll utility ─────────────────────────────────
function smoothScroll(e, targetId) {
    e.preventDefault();
    const el = document.getElementById(targetId);
    if (!el) return;
    const navH = document.querySelector('header, nav, .navbar')?.offsetHeight || 0;
    const top  = el.getBoundingClientRect().top + window.scrollY - navH - 24;
    window.scrollTo({ top, behavior: 'smooth' });
}

// Also handle any bare <a href="#contact"> or <a href="#registration">
// clicks that don't go through onclick (e.g. from other parts of the page)
document.addEventListener('click', function(e) {
    const a = e.target.closest('a[href^="#"]');
    if (!a) return;
    const id = a.getAttribute('href').slice(1);
    const el = document.getElementById(id);
    if (!el) return;
    e.preventDefault();
    const navH = document.querySelector('header, nav, .navbar')?.offsetHeight || 0;
    const top  = el.getBoundingClientRect().top + window.scrollY - navH - 24;
    window.scrollTo({ top, behavior: 'smooth' });
});

// ── Scroll reveal ─────────────────────────────────────────
(function(){
    const o = new IntersectionObserver(e => {
        e.forEach(x => { if(x.isIntersecting){ x.target.classList.add('visible'); o.unobserve(x.target); } });
    }, { threshold:.08, rootMargin:'0px 0px -50px 0px' });
    document.querySelectorAll('.reveal,.reveal-left,.reveal-right').forEach(el => o.observe(el));
})();

// ── Animated stat counters ────────────────────────────────
(function(){
    const counters = document.querySelectorAll('.hero-stat-num[data-count]');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el     = entry.target;
            const target = +el.dataset.count;
            const prefix = el.querySelector('span:first-child')?.textContent || '';
            const suffix = el.querySelector('span:last-child')?.textContent  || '';
            const dur    = 1800;
            const start  = performance.now();
            (function tick(now) {
                const t    = Math.min((now - start) / dur, 1);
                const ease = 1 - Math.pow(1 - t, 3);
                const val  = Math.round(ease * target);
                el.innerHTML = `${prefix}${val}<span>${suffix}</span>`;
                if (t < 1) requestAnimationFrame(tick);
            })(start);
            observer.unobserve(el);
        });
    }, { threshold: .5 });
    counters.forEach(c => observer.observe(c));
})();

// ── HelloAsso iframe ──────────────────────────────────────
function haWidgetLoaded(iframe) {
    document.getElementById('ha-loader').classList.add('hidden');
    window.addEventListener('message', function(e) {
        const dataHeight = e.data && e.data.height;
        if (dataHeight && dataHeight > parseFloat(iframe.style.minHeight || 0)) {
            iframe.style.minHeight = dataHeight + 'px';
        }
    });
}

// ── Bottom sheet modal ────────────────────────────────────
function openContactModal() {
    document.getElementById('contact-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeContactModal() {
    document.getElementById('contact-modal').classList.remove('open');
    document.body.style.overflow = '';
}
function handleOverlayClick(e) {
    if (e.target === document.getElementById('contact-modal')) closeContactModal();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeContactModal(); });

let touchStartY = 0;
document.getElementById('modal-sheet').addEventListener('touchstart', e => {
    touchStartY = e.touches[0].clientY;
}, { passive: true });
document.getElementById('modal-sheet').addEventListener('touchmove', e => {
    if (e.touches[0].clientY - touchStartY > 80) closeContactModal();
}, { passive: true });
</script>

@endsection
