{{-- resources/views/pages/legal/terms.blade.php --}}
@extends('layouts.app')
@section('title', 'Terms of Service')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600;1,700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{--gold:#fbbf24;--gold-d:#d97706;--ember:#f97316;--sky:#04091f;--navy:#0c1445;--ink:#1c1033;--muted:#64748b;--cream:#fffbf0;--sand:#fef3c7;}

@keyframes fadeUp{from{opacity:0;transform:translateY(32px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulse {0%,100%{box-shadow:0 0 0 0 rgba(251,191,36,.4)}70%{box-shadow:0 0 0 10px rgba(251,191,36,0)}}
@keyframes ray   {0%,100%{opacity:.2;transform:scaleY(1)}50%{opacity:.5;transform:scaleY(1.08)}}
@keyframes orb   {0%,100%{transform:translate(0,0)}50%{transform:translate(22px,-16px)}}

.reveal{opacity:0;transform:translateY(24px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal.in{opacity:1;transform:none}
.d1{transition-delay:.06s}.d2{transition-delay:.13s}.d3{transition-delay:.20s}

.legal-hero{position:relative;overflow:hidden;min-height:340px;display:flex;align-items:center;background:radial-gradient(ellipse at 50% 120%,#1a0a3d 0%,#0c1445 45%,#04091f 100%);}
#legalCanvas{position:absolute;inset:0;z-index:0;pointer-events:none;}
.l-glow{position:absolute;bottom:-60px;left:50%;transform:translateX(-50%);width:800px;height:320px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.15) 0%,rgba(249,115,22,.07) 40%,transparent 70%);z-index:1;pointer-events:none;animation:orb 8s ease-in-out infinite;}
.rays-w{position:absolute;bottom:0;left:50%;transform:translateX(-50%);z-index:1;width:100%;pointer-events:none;}
.ray{position:absolute;bottom:0;width:2px;border-radius:999px;background:linear-gradient(to top,rgba(251,191,36,.35),transparent);transform-origin:bottom center;animation:ray 3s ease-in-out infinite;}
.legal-hero-content{position:relative;z-index:2;padding:72px 20px 60px;max-width:900px;margin:0 auto;width:100%;text-align:center;}

.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;justify-content:center;font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(251,191,36,.4);margin-bottom:20px;}
.breadcrumb a{color:rgba(251,191,36,.4);text-decoration:none;transition:color .2s;}
.breadcrumb a:hover{color:rgba(251,191,36,.9);}
.breadcrumb span{color:rgba(251,191,36,.7);}

.hero-pill{display:inline-flex;align-items:center;gap:8px;padding:7px 20px;border-radius:999px;background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.22);font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gold);margin-bottom:20px;animation:fadeUp .6s ease both;}
.hero-pill-dot{width:6px;height:6px;border-radius:50%;background:var(--gold);animation:pulse 2s ease-in-out infinite;}

.hero-h1{font-family:'Cormorant Garamond',serif;font-size:clamp(2.4rem,6vw,4.2rem);font-weight:700;color:#fff;line-height:1.02;letter-spacing:-.02em;margin-bottom:14px;animation:fadeUp .8s ease both;}
.hero-h1 .glow{background:linear-gradient(135deg,#fde68a,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 28px rgba(251,191,36,.4));}
.hero-meta{font-family:'Outfit',sans-serif;font-size:.875rem;color:rgba(255,255,255,.38);animation:fadeUp .8s .2s ease both;}

.legal-wrap{background:var(--cream);padding:64px 20px 96px;}
.legal-inner{max-width:860px;margin:0 auto;}

.legal-layout{display:grid;grid-template-columns:220px 1fr;gap:52px;align-items:start;}
.toc{position:sticky;top:28px;}
.toc-title{font-family:'Outfit',sans-serif;font-size:10px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:12px;}
.toc-list{list-style:none;padding:0;margin:0;}
.toc-list li{margin-bottom:2px;}
.toc-list a{
    display:block;font-family:'Outfit',sans-serif;font-size:12px;font-weight:600;color:var(--muted);
    text-decoration:none;padding:6px 10px;border-radius:8px;border-left:2px solid transparent;
    transition:color .18s,background .18s,border-color .18s;
}
.toc-list a:hover{color:var(--gold-d);background:var(--sand);border-color:var(--gold);}

.legal-article h2{
    font-family:'Cormorant Garamond',serif;font-size:1.65rem;font-weight:700;color:var(--ink);
    letter-spacing:-.01em;margin-top:48px;margin-bottom:14px;padding-top:8px;
    border-top:1px solid rgba(251,191,36,.15);
    display:flex;align-items:center;gap:10px;
}
.legal-article h2:first-of-type{margin-top:0;border-top:none;}
.legal-article h2 .sec-num{
    font-family:'Outfit',sans-serif;font-size:.75rem;font-weight:800;
    background:linear-gradient(135deg,var(--gold),var(--ember));
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    letter-spacing:.05em;flex-shrink:0;
}
.legal-article p{font-family:'Outfit',sans-serif;font-size:.9rem;color:var(--muted);line-height:1.85;margin-bottom:14px;}
.legal-article ul{margin:0 0 16px 0;padding-left:20px;}
.legal-article ul li{font-family:'Outfit',sans-serif;font-size:.9rem;color:var(--muted);line-height:1.78;margin-bottom:6px;list-style:none;padding-left:12px;position:relative;}
.legal-article ul li::before{content:'›';position:absolute;left:-2px;color:var(--gold-d);font-weight:700;}
.legal-article a{color:var(--gold-d);text-decoration:none;border-bottom:1px solid rgba(217,119,6,.3);transition:border-color .18s;}
.legal-article a:hover{border-color:var(--gold-d);}
.legal-article strong{color:var(--ink);font-weight:700;}

.info-box{
    background:var(--sand);border:1px solid rgba(251,191,36,.25);border-radius:16px;
    padding:18px 22px;margin-bottom:20px;
    display:flex;align-items:flex-start;gap:12px;
}
.info-box i{color:var(--gold-d);margin-top:2px;flex-shrink:0;font-size:14px;}
.info-box p{margin:0;font-size:.86rem;}

.contact-card{
    background:linear-gradient(135deg,var(--sky),var(--navy));
    border-radius:20px;padding:32px;margin-top:48px;
    border:1px solid rgba(251,191,36,.1);text-align:center;
}
.contact-card h3{font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:700;color:#fff;margin-bottom:8px;}
.contact-card p{font-family:'Outfit',sans-serif;font-size:.875rem;color:rgba(255,255,255,.45);margin-bottom:18px;}
.contact-card a{
    display:inline-flex;align-items:center;gap:8px;
    padding:12px 28px;border-radius:12px;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    color:#1c1033;font-family:'Outfit',sans-serif;font-size:.85rem;font-weight:800;
    text-decoration:none;box-shadow:0 6px 20px rgba(251,191,36,.3);transition:transform .2s,box-shadow .2s;
}
.contact-card a:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(251,191,36,.45);color:#1c1033;border-bottom:none;}

@media(max-width:860px){.legal-layout{grid-template-columns:1fr;}.toc{display:none;}}
@media(max-width:640px){.legal-hero{min-height:260px;}.legal-hero-content{padding:52px 16px 44px;}.legal-wrap{padding:40px 16px 64px;}.legal-article h2{font-size:1.35rem;}}
</style>

{{-- Hero --}}
<section class="legal-hero">
    <canvas id="legalCanvas"></canvas>
    <div class="l-glow"></div>
    <div class="rays-w" id="lRays"></div>
    <div class="legal-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <span>Terms of Service</span>
        </nav>
        <div class="hero-pill"><div class="hero-pill-dot"></div> Legal</div>
        <h1 class="hero-h1">Terms of <span class="glow">Service</span></h1>
        <p class="hero-meta">Last updated: {{ date('F d, Y') }} &nbsp;·&nbsp; Des Ailes pour Grandir / Hope &amp; Impact</p>
    </div>
</section>

<div style="line-height:0;overflow:hidden;background:var(--cream);">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,32 C360,54 1080,10 1440,32 L1440,0 L0,0 Z" fill="#04091f"/>
    </svg>
</div>

{{-- Extract contact email once, safely --}}
@php $contactEmail = $settings['contact_email'] ?? ''; @endphp

{{-- Content --}}
<div class="legal-wrap">
    <div class="legal-inner">
        <div class="legal-layout">

            {{-- TOC --}}
            <nav class="toc reveal d1">
                <div class="toc-title">Contents</div>
                <ul class="toc-list">
                    <li><a href="#acceptance">1. Acceptance</a></li>
                    <li><a href="#services">2. Services</a></li>
                    <li><a href="#donations">3. Donations</a></li>
                    <li><a href="#sponsorship">4. Sponsorship</a></li>
                    <li><a href="#accounts">5. User Accounts</a></li>
                    <li><a href="#content">6. Content</a></li>
                    <li><a href="#prohibited">7. Prohibited Use</a></li>
                    <li><a href="#ip">8. Intellectual Property</a></li>
                    <li><a href="#privacy">9. Privacy</a></li>
                    <li><a href="#disclaimer">10. Disclaimer</a></li>
                    <li><a href="#limitation">11. Limitation of Liability</a></li>
                    <li><a href="#changes">12. Changes</a></li>
                    <li><a href="#contact">13. Contact</a></li>
                </ul>
            </nav>

            {{-- Article --}}
            <article class="legal-article reveal d2">

                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    <p>Please read these Terms of Service carefully before using our website or services. By accessing or using our platform, you agree to be bound by these terms.</p>
                </div>

                <h2 id="acceptance"><span class="sec-num">01</span> Acceptance of Terms</h2>
                <p>By accessing and using the <strong>Hope &amp; Impact / Des Ailes pour Grandir</strong> website and services (the "Platform"), you accept and agree to be bound by these Terms of Service and our <a href="{{ route('privacy') }}">Privacy Policy</a>. If you do not agree to these terms, please do not use our Platform.</p>
                <p>These terms apply to all visitors, donors, sponsors, and any other users of the Platform.</p>

                <h2 id="services"><span class="sec-num">02</span> Description of Services</h2>
                <p>Des Ailes pour Grandir is a non-profit association (loi 1901) working to protect and support vulnerable children and families in Cambodia. Through our Platform, we provide:</p>
                <ul>
                    <li>Child and family sponsorship programs</li>
                    <li>Donation campaigns for specific projects in Cambodia</li>
                    <li>Information about our actions, programs, and field impact</li>
                    <li>Solidarity fundraising tools for individuals and organizations</li>
                    <li>Impact reports and communications for sponsors and donors</li>
                </ul>

                <h2 id="donations"><span class="sec-num">03</span> Donations &amp; Payments</h2>
                <p>All donations are processed securely through <strong>HelloAsso</strong>, our certified payment partner. By making a donation, you agree to HelloAsso's terms and conditions in addition to these terms.</p>
                <ul>
                    <li>All donations are final and non-refundable unless required by applicable law</li>
                    <li>Tax receipts are issued in accordance with French tax law (eligible for a 66% tax deduction)</li>
                    <li>Funds are allocated to the programs and projects described at the time of donation</li>
                    <li>84% of all funds raised go directly to field programs in Cambodia</li>
                    <li>Des Ailes pour Grandir reserves the right to redirect funds to where the need is greatest if a specific project is fully funded</li>
                </ul>

                <h2 id="sponsorship"><span class="sec-num">04</span> Child &amp; Family Sponsorship</h2>
                <p>Sponsoring a child or family through our Platform creates a relationship of support — not a personal or legal relationship between the sponsor and the beneficiary.</p>
                <ul>
                    <li>Sponsors receive regular updates and reports about their sponsored child or family</li>
                    <li>Direct contact with beneficiaries is not permitted to protect their safety and privacy</li>
                    <li>Sponsorship may be cancelled by either party with reasonable notice</li>
                    <li>All beneficiary photos and information are published with appropriate consent and child-safe standards</li>
                    <li>We follow ChildSafe international standards in all communications about children</li>
                </ul>

                <h2 id="accounts"><span class="sec-num">05</span> User Accounts</h2>
                <p>If you create a sponsor account on our Platform, you are responsible for:</p>
                <ul>
                    <li>Maintaining the confidentiality of your login credentials</li>
                    <li>All activity that occurs under your account</li>
                    <li>Ensuring all account information is accurate and up to date</li>
                </ul>
                <p>We reserve the right to suspend or terminate accounts that violate these terms or engage in fraudulent activity.</p>

                <h2 id="content"><span class="sec-num">06</span> User Content</h2>
                <p>If you submit content to our Platform (fundraiser descriptions, messages, etc.), you grant Des Ailes pour Grandir a non-exclusive, royalty-free license to use, display, and distribute that content in connection with our services.</p>
                <p>You confirm that any content you submit is accurate, lawful, and does not infringe on any third-party rights.</p>

                <h2 id="prohibited"><span class="sec-num">07</span> Prohibited Use</h2>
                <p>You agree not to use our Platform to:</p>
                <ul>
                    <li>Impersonate any person or organization</li>
                    <li>Submit false or misleading information</li>
                    <li>Attempt to gain unauthorized access to any part of the Platform</li>
                    <li>Use automated tools to scrape, harvest, or copy content</li>
                    <li>Engage in any activity that could harm children or violate ChildSafe principles</li>
                    <li>Violate any applicable local, national, or international law</li>
                </ul>

                <h2 id="ip"><span class="sec-num">08</span> Intellectual Property</h2>
                <p>All content on this Platform — including text, images, videos, logos, and design — is the property of <strong>Des Ailes pour Grandir</strong> or its content providers and is protected by applicable intellectual property laws.</p>
                <p>You may not reproduce, distribute, or create derivative works without our prior written permission, except for personal, non-commercial use with appropriate attribution.</p>

                <h2 id="privacy"><span class="sec-num">09</span> Privacy</h2>
                <p>Your use of this Platform is also governed by our <a href="{{ route('privacy') }}">Privacy Policy</a>, which is incorporated into these Terms by reference. We are committed to protecting your personal data in accordance with the <strong>GDPR</strong> (General Data Protection Regulation) and French data protection law.</p>

                <h2 id="disclaimer"><span class="sec-num">10</span> Disclaimer of Warranties</h2>
                <p>Our Platform is provided on an "as is" and "as available" basis. We make no warranties, expressed or implied, regarding the availability, reliability, or accuracy of our services. We are not liable for any interruption or errors in the Platform.</p>

                <h2 id="limitation"><span class="sec-num">11</span> Limitation of Liability</h2>
                <p>To the fullest extent permitted by law, Des Ailes pour Grandir shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of the Platform. Our total liability for any claim shall not exceed the amount you donated in the 12 months preceding the claim.</p>

                <h2 id="changes"><span class="sec-num">12</span> Changes to These Terms</h2>
                <p>We reserve the right to update these Terms of Service at any time. Changes will be posted on this page with an updated date. Continued use of the Platform after changes constitutes acceptance of the new terms.</p>
                <p>We will notify registered sponsors of material changes via email.</p>

                <h2 id="contact"><span class="sec-num">13</span> Contact &amp; Governing Law</h2>
                <p>These Terms are governed by French law. Any disputes shall be subject to the exclusive jurisdiction of French courts.</p>
                @if($contactEmail)
                <p>For any questions about these Terms, please contact us at <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>.</p>
                @endif

                <div class="contact-card">
                    <h3>Questions about our Terms?</h3>
                    <p>Our team is happy to answer any questions you may have about these Terms of Service.</p>
                    <a href="{{ route('home') }}#contact">
                        <i class="fas fa-envelope"></i> Contact Us
                    </a>
                </div>

            </article>
        </div>
    </div>
</div>

<script>
(function(){
    var c=document.getElementById('legalCanvas'),ctx=c.getContext('2d'),W,H,stars=[];
    function resize(){W=c.width=window.innerWidth;H=c.height=c.closest('section').offsetHeight||340;}
    window.addEventListener('resize',resize);resize();
    for(var i=0;i<120;i++) stars.push({x:Math.random()*100,y:Math.random()*100,r:Math.random()*1.2+.2,s:Math.random()*2+1,p:Math.random()*Math.PI*2,warm:Math.random()<.15});
    var t=0;
    function draw(){ctx.clearRect(0,0,W,H);stars.forEach(function(p){var a=.15+.85*(Math.sin(t*p.s*.02+p.p)+1)*.5;ctx.beginPath();ctx.arc(p.x/100*W,p.y/100*H,p.r,0,Math.PI*2);ctx.fillStyle=p.warm?'rgba(251,191,36,'+a*.8+')':'rgba(255,255,255,'+a*.6+')';ctx.fill();});t++;requestAnimationFrame(draw);}
    draw();
    var rw=document.getElementById('lRays');
    for(var i=0;i<10;i++){var r=document.createElement('div');r.className='ray';var angle=(i/9)*60-30,h=100+Math.random()*120,op=.06+Math.random()*.12,delay=Math.random()*3;r.style.cssText='left:calc(50%+'+angle+'px);height:'+h+'px;opacity:'+op+';animation-delay:'+delay+'s;animation-duration:'+(2.5+Math.random()*2)+'s;transform:rotate('+angle*.5+'deg)';rw.appendChild(r);}
    var o=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('in');o.unobserve(e.target);}});},{threshold:.07});
    document.querySelectorAll('.reveal').forEach(function(el){o.observe(el);});
    document.querySelectorAll('.toc-list a').forEach(function(a){a.addEventListener('click',function(e){e.preventDefault();var target=document.querySelector(a.getAttribute('href'));if(target){window.scrollTo({top:target.getBoundingClientRect().top+window.scrollY-80,behavior:'smooth'});}});});
})();
</script>
@endsection