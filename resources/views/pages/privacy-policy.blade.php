{{-- resources/views/pages/legal/privacy.blade.php --}}
@extends('layouts.app')
@section('title', 'Privacy Policy')

@section('content')

<style>
:root{--gold:#fbbf24;--gold-d:#d97706;--ember:#f97316;--sky:#04091f;--navy:#0c1445;--ink:#1c1033;--muted:#64748b;--cream:#fffbf0;}

@keyframes fadeUp{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulse {0%,100%{box-shadow:0 0 0 0 rgba(251,191,36,.35)}70%{box-shadow:0 0 0 10px rgba(251,191,36,0)}}
@keyframes ray   {0%,100%{opacity:.2;transform:scaleY(1)}50%{opacity:.52;transform:scaleY(1.08)}}
@keyframes orb   {0%,100%{transform:translate(0,0)}50%{transform:translate(22px,-16px)}}

.reveal{opacity:0;transform:translateY(24px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal.in{opacity:1;transform:none}
.d1{transition-delay:.06s}.d2{transition-delay:.12s}.d3{transition-delay:.18s}

.page-hero{position:relative;overflow:hidden;min-height:420px;display:flex;align-items:center;background:radial-gradient(ellipse at 50% 120%,#1a0a3d 0%,#0c1445 45%,#04091f 100%);}
#starCanvas{position:absolute;inset:0;z-index:0;pointer-events:none;}
.dawn-glow{position:absolute;bottom:-60px;left:50%;transform:translateX(-50%);width:800px;height:320px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.15) 0%,rgba(249,115,22,.07) 40%,transparent 70%);z-index:1;pointer-events:none;animation:orb 8s ease-in-out infinite;}
.rays-wrap{position:absolute;bottom:0;left:50%;transform:translateX(-50%);z-index:1;width:100%;pointer-events:none;}
.ray{position:absolute;bottom:0;width:2px;border-radius:999px;background:linear-gradient(to top,rgba(251,191,36,.35),transparent);transform-origin:bottom center;animation:ray 3s ease-in-out infinite;}
.hero-inner{position:relative;z-index:2;padding:80px 20px 72px;max-width:1280px;margin:0 auto;width:100%;}

.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(251,191,36,.4);margin-bottom:22px;}
.breadcrumb a{color:rgba(251,191,36,.4);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:rgba(251,191,36,.85);}
.breadcrumb span{color:rgba(251,191,36,.7);}

.hero-pill{display:inline-flex;align-items:center;gap:8px;padding:7px 18px;border-radius:999px;background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.2);font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);margin-bottom:18px;animation:fadeUp .6s ease both;}
.hero-dot{width:6px;height:6px;border-radius:50%;background:var(--gold);animation:pulse 2s ease-in-out infinite;}

.hero-h1{font-family: 'Montserrat', sans-serif;font-size:clamp(2.4rem,5vw,4rem);font-weight:700;color:#fff;line-height:1.06;letter-spacing:-.02em;margin-bottom:14px;animation:fadeUp .8s ease both;}
.hero-h1 em{font-style:italic;background:linear-gradient(90deg,#fde68a,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.hero-sub{font-family: 'Montserrat', sans-serif;font-size:.95rem;color:rgba(255,255,255,.44);line-height:1.75;max-width:520px;animation:fadeUp .8s .16s ease both;}

.wave-div{line-height:0;overflow:hidden;} .wave-div svg{display:block;}
.legal-wrap{max-width:860px;margin:0 auto;padding:0 20px;}

.toc{background:var(--cream);border:1.5px solid rgba(251,191,36,.2);border-radius:20px;padding:28px 32px;margin-bottom:48px;}
.toc-title{font-family: 'Montserrat', sans-serif;font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:16px;display:flex;align-items:center;gap:8px;}
.toc-title i{color:var(--gold-d);font-size:14px;}
.toc-list{list-style:none;display:grid;grid-template-columns:1fr 1fr;gap:6px 24px;}
.toc-list li a{font-family: 'Montserrat', sans-serif;font-size:.85rem;font-weight:600;color:var(--muted);text-decoration:none;display:flex;align-items:center;gap:6px;padding:4px 0;border-bottom:1px solid transparent;transition:color .18s,border-color .18s;}
.toc-list li a:hover{color:var(--gold-d);border-color:rgba(217,119,6,.3);}
.toc-list li a::before{content:attr(data-num);font-size:10px;font-weight:800;color:var(--gold);opacity:.7;min-width:16px;}

.legal-section{margin-bottom:52px;scroll-margin-top:24px;}
.section-header{display:flex;align-items:center;gap:14px;margin-bottom:18px;}
.section-num{width:40px;height:40px;border-radius:12px;flex-shrink:0;background:linear-gradient(135deg,#fbbf24,#f97316);color:#fff;font-family: 'Montserrat', sans-serif;font-size:1.1rem;font-weight:700;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(251,191,36,.35);}
.section-title{font-family: 'Montserrat', sans-serif;font-size:1.5rem;font-weight:700;color:var(--ink);letter-spacing:-.01em;}

.section-body{font-family: 'Montserrat', sans-serif;font-size:.9rem;color:#374151;line-height:1.82;}
.section-body p{margin-bottom:14px;}
.section-body p:last-child{margin-bottom:0;}
.section-body ul{list-style:none;margin-bottom:14px;}
.section-body ul li{padding:7px 0 7px 22px;position:relative;border-bottom:1px solid #f9fafb;font-size:.875rem;color:#4b5563;}
.section-body ul li:last-child{border-bottom:none;}
.section-body ul li::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:6px;height:6px;border-radius:50%;background:linear-gradient(135deg,#fbbf24,#f97316);}
.section-body strong{color:var(--ink);font-weight:700;}
.section-body a{color:var(--gold-d);text-decoration:none;border-bottom:1px solid rgba(217,119,6,.3);transition:border-color .18s;}
.section-body a:hover{border-color:var(--gold-d);}

.data-table{width:100%;border-collapse:collapse;margin:16px 0;font-family: 'Montserrat', sans-serif;font-size:.85rem;}
.data-table th{background:linear-gradient(135deg,#1c1033,#0c1445);color:rgba(255,255,255,.8);padding:12px 16px;text-align:left;font-weight:700;font-size:.8rem;letter-spacing:.07em;text-transform:uppercase;}
.data-table th:first-child{border-radius:10px 0 0 0;}
.data-table th:last-child{border-radius:0 10px 0 0;}
.data-table td{padding:11px 16px;border-bottom:1px solid #f1f5f9;color:#374151;vertical-align:top;}
.data-table tr:last-child td{border-bottom:none;}
.data-table tr:hover td{background:#fffbf0;}

.highlight-box{background:linear-gradient(135deg,#fffbf0,#fef3c7);borderoleft:4px solid var(--gold);border-radius:0 14px 14px 0;padding:18px 22px;margin:18px 0;font-family: 'Montserrat', sans-serif;font-size:.875rem;color:var(--ink);line-height:1.7;}
.highlight-box i{color:var(--gold-d);margin-right:6px;}

.sec-divider{border:none;border-top:1px solid #f1f5f9;margin:48px 0;}
.last-updated{display:inline-flex;align-items:center;gap:6px;font-family: 'Montserrat', sans-serif;font-size:11px;font-weight:700;color:var(--muted);background:#f8fafc;padding:6px 14px;border-radius:999px;border:1px solid #e2e8f0;margin-bottom:40px;}

.rights-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin:16px 0;}
.right-item{background:#fff;border:1px solid #f1f5f9;border-radius:14px;padding:16px;display:flex;align-items:flex-start;gap:12px;transition:border-color .2s,box-shadow .2s;}
.right-item:hover{border-color:rgba(251,191,36,.3);box-shadow:0 4px 16px rgba(0,0,0,.06);}
.right-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:14px;}
.right-title{font-family: 'Montserrat', sans-serif;font-size:.85rem;font-weight:700;color:var(--ink);margin-bottom:3px;}
.right-desc{font-family: 'Montserrat', sans-serif;font-size:.78rem;color:var(--muted);line-height:1.55;}

.cta-legal{background:linear-gradient(135deg,#04091f 0%,#0c1445 55%,#1a0a3d 100%);border-radius:24px;padding:48px 40px;position:relative;overflow:hidden;text-align:center;margin-top:56px;}
.cta-legal::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.05;}
.cta-glow{position:absolute;bottom:-60px;left:50%;transform:translateX(-50%);width:600px;height:240px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.12),transparent 70%);pointer-events:none;}

@media(max-width:640px){
    .page-hero{min-height:320px;} .hero-inner{padding:56px 16px 52px;}
    .toc-list{grid-template-columns:1fr;}
    .rights-grid{grid-template-columns:1fr;}
    .data-table{font-size:.78rem;} .data-table th,.data-table td{padding:9px 12px;}
    .cta-legal{padding:36px 20px;border-radius:18px;}
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

{{-- ══ HERO ══ --}}
<section class="page-hero">
    <canvas id="starCanvas"></canvas>
    <div class="dawn-glow"></div>
    <div class="rays-wrap" id="raysWrap"></div>
    <div class="hero-inner">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <span>Privacy Policy</span>
        </nav>
        <div class="hero-pill"><div class="hero-dot"></div> Legal</div>
        <h1 class="hero-h1">Privacy <em>Policy</em></h1>
        <p class="hero-sub">We are committed to protecting your personal data. This policy explains what we collect, why we collect it, and how we use it.</p>
    </div>
</section>

<div class="wave-div" style="background:var(--cream);">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,32 C480,56 960,8 1440,32 L1440,0 L0,0 Z" fill="#04091f"/>
    </svg>
</div>

{{-- ══ CONTENT ══ --}}

{{-- Extract contact email once, safely --}}
@php $contactEmail = $settings['contact_email'] ?? ''; @endphp

<div style="background:var(--cream);padding:64px 0 96px;">
    <div class="legal-wrap">

        <div class="last-updated reveal">
            <i class="fas fa-clock" style="color:var(--gold-d);"></i>
            Last updated: January 1, 2025
        </div>

        {{-- TOC --}}
        <div class="toc reveal">
            <div class="toc-title"><i class="fas fa-lock"></i> Table of Contents</div>
            <ul class="toc-list">
                <li><a href="#p1" data-num="01">Who We Are</a></li>
                <li><a href="#p2" data-num="02">Data We Collect</a></li>
                <li><a href="#p3" data-num="03">How We Use Your Data</a></li>
                <li><a href="#p4" data-num="04">Legal Basis for Processing</a></li>
                <li><a href="#p5" data-num="05">Data Sharing</a></li>
                <li><a href="#p6" data-num="06">Cookies & Tracking</a></li>
                <li><a href="#p7" data-num="07">Data Retention</a></li>
                <li><a href="#p8" data-num="08">Your Rights</a></li>
                <li><a href="#p9" data-num="09">Children's Privacy</a></li>
                <li><a href="#p10" data-num="10">International Transfers</a></li>
                <li><a href="#p11" data-num="11">Security</a></li>
                <li><a href="#p12" data-num="12">Contact & DPO</a></li>
            </ul>
        </div>

        <div class="highlight-box reveal">
            <i class="fas fa-info-circle"></i>
            This Privacy Policy complies with the <strong>General Data Protection Regulation (GDPR)</strong> (EU 2016/679) and applicable French data protection law (Loi Informatique et Libertes).
        </div>

        @php
        $sections = [
            ['id'=>'p1','num'=>'01','title'=>'Who We Are','body'=>'
                <p><strong>Des Ailes pour Grandir</strong> (also known as Hope &amp; Impact) is a French non-profit association operating in Cambodia. We are the data controller responsible for your personal information collected through this website.</p>
                <ul>
                    <li><strong>Organization:</strong> Des Ailes pour Grandir</li>
                    <li><strong>Email:</strong> <a href="mailto:' . e($contactEmail) . '">' . e($contactEmail) . '</a></li>
                    <li><strong>Website:</strong> <a href="https://www.desailespourgrandir.org">www.desailespourgrandir.org</a></li>
                    <li><strong>Jurisdiction:</strong> France (RGPD / GDPR applicable)</li>
                </ul>
            '],
            ['id'=>'p2','num'=>'02','title'=>'Data We Collect','body'=>'
                <p>We collect the following categories of personal data:</p>
                <table class="data-table">
                    <thead>
                        <tr><th>Category</th><th>Examples</th><th>Source</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>Identity data</strong></td><td>First name, last name</td><td>You provide directly</td></tr>
                        <tr><td><strong>Contact data</strong></td><td>Email address, phone, country</td><td>You provide directly</td></tr>
                        <tr><td><strong>Financial data</strong></td><td>Donation amount, payment method type</td><td>HelloAsso (payment processor)</td></tr>
                        <tr><td><strong>Sponsorship data</strong></td><td>Sponsored child/family ID, duration</td><td>You provide directly</td></tr>
                        <tr><td><strong>Technical data</strong></td><td>IP address, browser type, device</td><td>Automatically collected</td></tr>
                        <tr><td><strong>Usage data</strong></td><td>Pages visited, clicks, session duration</td><td>Automatically collected</td></tr>
                    </tbody>
                </table>
                <p>We do <strong>not</strong> collect sensitive personal data such as racial origin, health data, or political opinions.</p>
            '],
            ['id'=>'p3','num'=>'03','title'=>'How We Use Your Data','body'=>'
                <p>We use your personal data for the following purposes:</p>
                <ul>
                    <li>Processing donations and issuing tax receipts</li>
                    <li>Managing child and family sponsorship relationships</li>
                    <li>Sending newsletters, program updates, and impact reports (with consent)</li>
                    <li>Responding to enquiries and providing customer support</li>
                    <li>Improving our website, services, and programs</li>
                    <li>Complying with legal and regulatory obligations</li>
                    <li>Detecting and preventing fraud or abuse</li>
                </ul>
                <div class="highlight-box"><i class="fas fa-heart"></i> We never sell, rent, or trade your personal data to third parties for marketing purposes.</div>
            '],
            ['id'=>'p4','num'=>'04','title'=>'Legal Basis for Processing','body'=>'
                <p>Under GDPR, we process your personal data on the following legal bases:</p>
                <ul>
                    <li><strong>Contract performance</strong> - to process your donation or manage your sponsorship</li>
                    <li><strong>Legitimate interests</strong> - to improve our website and detect fraud</li>
                    <li><strong>Consent</strong> - for marketing communications and newsletters (you may withdraw at any time)</li>
                    <li><strong>Legal obligation</strong> - to comply with French accounting, tax, and charity law</li>
                </ul>
            '],
            ['id'=>'p5','num'=>'05','title'=>'Data Sharing','body'=>'
                <p>We share your data only in the following limited circumstances:</p>
                <ul>
                    <li><strong>HelloAsso</strong> - our payment processor, to handle donations securely</li>
                    <li><strong>Email service providers</strong> - to send transactional and newsletter emails</li>
                    <li><strong>Local partners in Cambodia</strong> - solely to manage sponsorship programs (anonymized where possible)</li>
                    <li><strong>Legal authorities</strong> - when required by law or to protect our rights</li>
                </ul>
                <p>All third-party service providers are bound by data processing agreements and must comply with GDPR.</p>
            '],
            ['id'=>'p6','num'=>'06','title'=>'Cookies &amp; Tracking','body'=>'
                <p>Our website uses cookies to improve your browsing experience. Cookie categories:</p>
                <ul>
                    <li><strong>Strictly necessary cookies</strong> - required for the site to function (session, CSRF token)</li>
                    <li><strong>Analytics cookies</strong> - help us understand how visitors use our site (anonymized)</li>
                    <li><strong>Preference cookies</strong> - remember your language choice (FR/EN/KM)</li>
                </ul>
                <p>You can control cookies through your browser settings. Disabling certain cookies may affect site functionality. We do not use third-party advertising cookies.</p>
                <div class="highlight-box"><i class="fas fa-cookie-bite"></i> A cookie consent banner is displayed on first visit. Your preference is stored for 12 months.</div>
            '],
            ['id'=>'p7','num'=>'07','title'=>'Data Retention','body'=>'
                <p>We retain your personal data only as long as necessary:</p>
                <table class="data-table">
                    <thead><tr><th>Data Type</th><th>Retention Period</th></tr></thead>
                    <tbody>
                        <tr><td>Donor / sponsor accounts</td><td>Duration of relationship + 5 years</td></tr>
                        <tr><td>Donation records</td><td>10 years (French accounting law)</td></tr>
                        <tr><td>Marketing consents</td><td>3 years from last interaction</td></tr>
                        <tr><td>Website logs</td><td>12 months</td></tr>
                        <tr><td>Support tickets</td><td>2 years</td></tr>
                    </tbody>
                </table>
                <p>After these periods, your data is securely deleted or anonymized.</p>
            '],
            ['id'=>'p8','num'=>'08','title'=>'Your Rights','body'=>'
                <p>Under GDPR, you have the following rights regarding your personal data:</p>
            '],
            ['id'=>'p9','num'=>'09','title'=>"Children's Privacy",'body'=>'
                <p>We are deeply committed to protecting children\'s privacy, in line with our <strong>ChildSafe</strong> membership and international child safeguarding standards.</p>
                <ul>
                    <li>We do not collect personal data directly from children</li>
                    <li>Photos and information about sponsored children are shared only with express parental/guardian consent</li>
                    <li>Child profiles use pseudonyms and encoded IDs in public-facing URLs</li>
                    <li>Direct contact between donors and children is not facilitated without our mediation</li>
                    <li>All staff and volunteers handling child data receive safeguarding training</li>
                </ul>
                <div class="highlight-box"><i class="fas fa-child"></i> If you believe a child\'s data has been misused, please contact us immediately at <a href="mailto:' . e($contactEmail) . '">' . e($contactEmail) . '</a></div>
            '],
            ['id'=>'p10','num'=>'10','title'=>'International Data Transfers','body'=>'
                <p>As we operate in Cambodia, some personal data may be transferred outside the European Economic Area (EEA). When this occurs, we ensure appropriate safeguards are in place, including:</p>
                <ul>
                    <li>Standard Contractual Clauses (SCCs) approved by the European Commission</li>
                    <li>Data minimization - only necessary data is shared with field teams</li>
                    <li>Encryption in transit and at rest</li>
                </ul>
            '],
            ['id'=>'p11','num'=>'11','title'=>'Security','body'=>'
                <p>We implement appropriate technical and organizational measures to protect your personal data, including:</p>
                <ul>
                    <li>SSL/TLS encryption for all data in transit</li>
                    <li>Encrypted route IDs (no plain user IDs in URLs)</li>
                    <li>Access controls limiting data to authorized staff only</li>
                    <li>Regular security reviews of our systems</li>
                    <li>Secure password hashing (bcrypt)</li>
                </ul>
                <p>In the event of a data breach that is likely to affect your rights, we will notify you and the relevant supervisory authority (CNIL) within 72 hours.</p>
            '],
            ['id'=>'p12','num'=>'12','title'=>'Contact &amp; DPO','body'=>'
                <p>For any privacy-related requests or questions, please contact us:</p>
                <ul>
                    <li><strong>Association:</strong> Des Ailes pour Grandir</li>
                    <li><strong>Email:</strong> <a href="mailto:' . e($contactEmail) . '">' . e($contactEmail) . '</a></li>
                    <li><strong>Subject line:</strong> "Privacy Request - [Your Name]"</li>
                </ul>
                <p>You also have the right to lodge a complaint with the French supervisory authority:</p>
                <ul>
                    <li><strong>CNIL</strong> (Commission Nationale de l\'Informatique et des Libertes)</li>
                    <li><a href="https://www.cnil.fr" target="_blank" rel="noopener">www.cnil.fr</a></li>
                    <li>3 Place de Fontenoy, TSA 80715, 75334 Paris Cedex 07</li>
                </ul>
            '],
        ];
        @endphp

        @foreach($sections as $i => $s)
        <div class="legal-section reveal d{{ ($i%3)+1 }}" id="{{ $s['id'] }}">
            <div class="section-header">
                <div class="section-num">{{ $s['num'] }}</div>
                <h2 class="section-title">{{ $s['title'] }}</h2>
            </div>
            <div class="section-body">
                {!! $s['body'] !!}

                @if($s['id'] === 'p8')
                <div class="rights-grid">
                    @foreach([
                        ['fas fa-eye','#fff7ed','#f97316','Right to Access','Request a copy of the personal data we hold about you.'],
                        ['fas fa-edit','#eff6ff','#3b82f6','Right to Rectification','Ask us to correct inaccurate or incomplete data.'],
                        ['fas fa-trash-alt','#fef2f2','#ef4444','Right to Erasure','Request deletion of your data ("right to be forgotten").'],
                        ['fas fa-pause-circle','#f0fdf4','#16a34a','Right to Restriction','Ask us to limit how we process your data.'],
                        ['fas fa-download','#faf5ff','#a855f7','Right to Portability','Receive your data in a structured, machine-readable format.'],
                        ['fas fa-ban','#fff1f2','#f43f5e','Right to Object','Object to processing based on legitimate interests.'],
                    ] as [$ico,$bg,$clr,$title,$desc])
                    <div class="right-item">
                        <div class="right-icon" style="background:{{ $bg }};"><i class="{{ $ico }}" style="color:{{ $clr }};"></i></div>
                        <div>
                            <div class="right-title">{{ $title }}</div>
                            <div class="right-desc">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p style="margin-top:14px;">To exercise any of these rights, email us at <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>. We will respond within <strong>30 days</strong>.</p>
                @endif
            </div>
        </div>
        @if(!$loop->last)<hr class="sec-divider">@endif
        @endforeach

        {{-- CTA --}}
        <div class="cta-legal reveal">
            <div class="cta-glow"></div>
            <div class="relative z-10">
                <p style="font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(251,191,36,.5);margin-bottom:12px;">
                    <i class="fas fa-shield-alt mr-1"></i> Your data is safe with us
                </p>
                <h3 style="font-family: 'Montserrat', sans-serif;font-size:1.8rem;font-weight:700;color:#fff;margin-bottom:10px;">Questions about your Privacy?</h3>
                <p style="font-family: 'Montserrat', sans-serif;color:rgba(255,255,255,.45);font-size:.875rem;max-width:400px;margin:0 auto 24px;line-height:1.75;">Exercise your GDPR rights or ask us anything about how we handle your data.</p>
                <a href="mailto:{{ $contactEmail }}"
                   style="display:inline-flex;align-items:center;gap:9px;padding:14px 30px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#1c1033;font-family: 'Montserrat', sans-serif;font-size:.875rem;font-weight:800;border-radius:12px;text-decoration:none;box-shadow:0 8px 24px rgba(251,191,36,.35);transition:transform .2s,box-shadow .2s;"
                   onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 36px rgba(251,191,36,.48)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='0 8px 24px rgba(251,191,36,.35)'">
                    <i class="fas fa-envelope"></i> Contact our Team
                </a>
                <div style="margin-top:16px;">
                    <a href="{{ route('terms') }}" style="font-family: 'Montserrat', sans-serif;font-size:12px;font-weight:600;color:rgba(251,191,36,.5);text-decoration:none;border-bottom:1px solid rgba(251,191,36,.2);padding-bottom:1px;transition:color .18s,border-color .18s;"
                       onmouseover="this.style.color='rgba(251,191,36,.8)';this.style.borderColor='rgba(251,191,36,.5)'"
                       onmouseout="this.style.color='rgba(251,191,36,.5)';this.style.borderColor='rgba(251,191,36,.2)'">
                        View our Terms of Service →
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
(function(){
    var c=document.getElementById('starCanvas'),ctx=c.getContext('2d'),W,H,stars=[];
    function resize(){W=c.width=window.innerWidth;H=c.height=window.innerHeight;}
    window.addEventListener('resize',resize);resize();
    for(var i=0;i<140;i++) stars.push({x:Math.random()*100,y:Math.random()*100,r:Math.random()*1.2+.2,s:Math.random()*2+1,p:Math.random()*Math.PI*2,warm:Math.random()<.18});
    var t=0;
    function draw(){
        ctx.clearRect(0,0,W,H);
        stars.forEach(function(p){
            var a=.12+.88*(Math.sin(t*p.s*.02+p.p)+1)*.5;
            ctx.beginPath();ctx.arc(p.x/100*W,p.y/100*H,p.r,0,Math.PI*2);
            ctx.fillStyle=p.warm?'rgba(251,191,36,'+a*.85+')':'rgba(255,255,255,'+a*.6+')';ctx.fill();
        });
        t++;requestAnimationFrame(draw);
    }
    draw();
    var w=document.getElementById('raysWrap');
    for(var i=0;i<10;i++){var r=document.createElement('div');r.className='ray';var angle=(i/9)*60-30,h=150+Math.random()*160,op=.06+Math.random()*.13,delay=Math.random()*3;r.style.cssText='left:calc(50% + '+angle+'px);height:'+h+'px;opacity:'+op+';animation-delay:'+delay+'s;animation-duration:'+(2.4+Math.random()*2)+'s;transform:rotate('+angle*.55+'deg)';w.appendChild(r);}
    var o=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('in');o.unobserve(e.target);}});},{threshold:.07});
    document.querySelectorAll('.reveal').forEach(function(el){o.observe(el);});
})();
</script>
@endsection