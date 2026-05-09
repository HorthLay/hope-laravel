{{-- resources/views/pages/support/foundations-philanthropy.blade.php --}}
@extends('layouts.app')
@section('title', 'Family Foundations & Philanthropy')

@section('content')

<style>
:root{
    --gold:#fbbf24;--gold-d:#d97706;--ember:#f97316;--ember-d:#ea580c;
    --sky:#04091f;--navy:#0c1445;--ink:#1c1033;--muted:#64748b;
    --cream:#fffbf0;--sand:#fef3c7;
}

@keyframes fadeUp  {from{opacity:0;transform:translateY(36px)}to{opacity:1;transform:translateY(0)}}
@keyframes shimmer {from{left:-100%}to{left:200%}}
@keyframes orb     {0%,100%{transform:translate(0,0)}50%{transform:translate(24px,-18px)}}

.reveal{opacity:0;transform:translateY(28px);transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
.reveal.visible{opacity:1;transform:none}
.d1{transition-delay:.07s}.d2{transition-delay:.16s}.d3{transition-delay:.25s}.d4{transition-delay:.34s}

body{font-family: 'Montserrat', sans-serif;}

/* ══ HERO (picture-style) ══ */
.page-hero{
    position:relative;overflow:hidden;
    min-height:clamp(480px,68vh,720px);
    display:flex;align-items:flex-end;
    background:#0d1a0a url('{{ asset("images/image-background.jpg") }}') center 45%/cover no-repeat;
    isolation:isolate;
    padding-bottom:64px;
}
.page-hero::after{
    content:'';position:absolute;inset:0;z-index:1;
    background:linear-gradient(0deg,rgba(0,0,0,.80) 0%,rgba(0,0,0,.50) 38%,rgba(0,0,0,.18) 70%,rgba(0,0,0,.05) 100%);
    pointer-events:none;
}
.page-hero-content{
    position:relative;z-index:2;
    max-width:1100px;width:100%;
    margin:0 auto;
    padding:0 40px 60px;
    text-align:left;
}
.page-hero h1.hero-h1{
    font-family: 'Montserrat', sans-serif;
    font-style:italic;font-weight:900;
    font-size:clamp(2rem,5vw,4rem);
    line-height:1.05;letter-spacing:-.01em;
    color:#fff;margin:0 0 20px;
    text-shadow:0 2px 12px rgba(0,0,0,.75),0 4px 20px rgba(0,0,0,.55);
    animation:fadeUp .65s .08s ease both;
}
.page-hero p.hero-sub{
    font-family: 'Montserrat', sans-serif;
    font-size:clamp(.95rem,1.2vw,1.1rem);
    font-weight:500;color:rgba(255,255,255,.95);
    line-height:1.55;max-width:640px;
    margin:0 0 26px;
    text-shadow:0 1px 6px rgba(0,0,0,.7);
    animation:fadeUp .65s .18s ease both;
}
.page-hero p.hero-sub em{font-style:italic;font-weight:600;}
.page-hero p.hero-sub strong{font-weight:700;color:#fff;}

.btn-donate-now{
    display:inline-flex;align-items:center;gap:10px;
    padding:13px 30px;
    background:#f59e0b;color:#fff;
    font-family: 'Montserrat', sans-serif;
    font-size:13px;font-weight:800;
    letter-spacing:.08em;text-transform:uppercase;
    border-radius:6px;text-decoration:none;
    border:2px solid transparent;
    box-shadow:0 4px 14px rgba(245,158,11,.4);
    transition:background .2s,transform .2s,box-shadow .2s;
    animation:fadeUp .65s .28s ease both;
}
.btn-donate-now:hover{
    background:#d97706;color:#fff;
    transform:translateY(-2px);
    box-shadow:0 8px 22px rgba(245,158,11,.55);
}

.hero-orange-strip{
    position:absolute;left:0;right:0;bottom:0;
    height:64px;background:#f97316;z-index:5;
}

/* ══ SECTION LABEL ══ */
.sec-label{display:inline-flex;align-items:center;gap:8px;font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gold-d);}
.sec-line{width:28px;height:2px;background:linear-gradient(90deg,var(--gold),var(--ember));border-radius:2px;}

/* ══ WHY US ══ */
.why-card{
    background:linear-gradient(135deg,var(--sky) 0%,var(--navy) 60%,#1a0a3d 100%);
    border-radius:28px;padding:64px 56px;
    position:relative;overflow:hidden;
    border:1px solid rgba(251,191,36,.1);
}
.why-card::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.05;}
.why-orb{position:absolute;border-radius:50%;filter:blur(70px);pointer-events:none;}
.why-orb-a{width:350px;height:350px;background:rgba(251,191,36,.07);top:-80px;right:-60px;animation:orb 9s ease-in-out infinite;}
.why-orb-b{width:220px;height:220px;background:rgba(249,115,22,.05);bottom:-50px;left:8%;animation:orb 12s ease-in-out infinite reverse;}

/* ══ BENEFIT CARDS ══ */
.benefits-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;}
.benefit-card{
    background:#fff;border-radius:22px;padding:32px 28px;
    border:1.5px solid #f1f5f9;
    box-shadow:0 4px 20px rgba(0,0,0,.05);
    display:flex;align-items:flex-start;gap:18px;
    position:relative;overflow:hidden;
    transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s,border-color .35s;
}
.benefit-card:hover{transform:translateY(-5px);box-shadow:0 20px 48px rgba(0,0,0,.1);}
.benefit-card::before{content:'';position:absolute;top:0;bottom:0;left:-100%;width:60%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.4),transparent);pointer-events:none;}
.benefit-card:hover::before{animation:shimmer .75s ease both;}

.benefit-icon{
    width:52px;height:52px;border-radius:16px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;font-size:20px;
    transition:transform .25s;
}
.benefit-card:hover .benefit-icon{transform:rotate(-6deg) scale(1.1);}
.benefit-title{font-family: 'Montserrat', sans-serif;font-size:1.15rem;font-weight:700;color:var(--ink);margin-bottom:6px;letter-spacing:-.01em;}
.benefit-desc{font-family: 'Montserrat', sans-serif;font-size:.875rem;color:var(--muted);line-height:1.75;}

/* ══ GIVING LEVELS ══ */
.levels-bg{
    background:var(--cream);
    padding:80px 20px;
    border-top:1px solid rgba(251,191,36,.1);
    border-bottom:1px solid rgba(251,191,36,.1);
}
.level-card{
    background:#fff;border-radius:22px;padding:36px 28px;text-align:center;
    border:2px solid #f1f5f9;
    box-shadow:0 4px 20px rgba(0,0,0,.05);
    position:relative;overflow:hidden;
    transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s,border-color .35s;
    display:flex;flex-direction:column;
}
.level-card:hover{transform:translateY(-7px);box-shadow:0 24px 56px rgba(0,0,0,.1);}
.level-card.featured{
    border-color:rgba(251,191,36,.4);
    background:linear-gradient(135deg,#fffbf0,#fff);
    box-shadow:0 8px 32px rgba(251,191,36,.15);
}
.level-card.featured:hover{box-shadow:0 24px 60px rgba(251,191,36,.25);}
.level-badge{
    position:absolute;top:14px;right:14px;
    font-family: 'Montserrat', sans-serif;font-size:9px;font-weight:800;
    letter-spacing:.1em;text-transform:uppercase;
    background:linear-gradient(135deg,#fbbf24,#f97316);color:#fff;
    padding:4px 12px;border-radius:999px;
    box-shadow:0 2px 8px rgba(251,191,36,.4);
}
.level-icon{
    width:64px;height:64px;border-radius:20px;
    display:flex;align-items:center;justify-content:center;font-size:26px;
    margin:0 auto 20px;
    transition:transform .25s;
}
.level-card:hover .level-icon{transform:scale(1.1) rotate(-4deg);}
.level-name{font-family: 'Montserrat', sans-serif;font-size:1.4rem;font-weight:700;color:var(--ink);margin-bottom:8px;letter-spacing:-.01em;}
.level-range{font-family: 'Montserrat', sans-serif;font-size:.85rem;font-weight:700;color:var(--gold-d);margin-bottom:16px;}
.level-desc{font-family: 'Montserrat', sans-serif;font-size:.85rem;color:var(--muted);line-height:1.72;flex:1;margin-bottom:20px;}
.level-perks{display:flex;flex-direction:column;gap:7px;text-align:left;}
.level-perk{display:flex;align-items:center;gap:8px;font-family: 'Montserrat', sans-serif;font-size:.82rem;color:var(--ink);}
.level-perk i{font-size:9px;flex-shrink:0;}

/* ══ CONTACT CTA ══ */
.contact-card{
    background:linear-gradient(135deg,var(--sky) 0%,var(--navy) 55%,#1a0a3d 100%);
    border-radius:28px;padding:64px 56px;text-align:center;
    position:relative;overflow:hidden;border:1px solid rgba(251,191,36,.1);
}
.contact-card::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.06;}
.contact-glow{position:absolute;bottom:-60px;left:50%;transform:translateX(-50%);width:600px;height:280px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.12) 0%,transparent 70%);pointer-events:none;}

/* ══ CTA BANNER ══ */
.cta-wrap{background:white;padding:80px 20px;}
.cta-in{max-width:1100px;margin:0 auto;background:linear-gradient(135deg,var(--sky) 0%,var(--navy) 55%,#1a0a3d 100%);border-radius:32px;padding:72px 56px;position:relative;overflow:hidden;}
.cta-in::before{content:'';position:absolute;inset:0;background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;opacity:.06;}
.cta-glow{position:absolute;bottom:-80px;left:50%;transform:translateX(-50%);width:700px;height:300px;border-radius:50%;background:radial-gradient(ellipse,rgba(251,191,36,.13) 0%,rgba(249,115,22,.06) 45%,transparent 70%);pointer-events:none;}

/* Responsive */
@media(max-width:900px){
    .benefits-grid{grid-template-columns:1fr;}
    .why-card{padding:44px 28px;}
}
@media(max-width:768px){
    .page-hero{min-height:clamp(420px,75vw,560px);padding-bottom:48px;}
    .page-hero-content{padding:0 22px 36px;}
    .hero-orange-strip{height:48px;}
    .btn-donate-now{padding:12px 24px;font-size:12px;}
}
@media(max-width:640px){
    .why-card{padding:36px 20px;}
    .levels-grid{grid-template-columns:1fr !important;}
    .cta-in{padding:48px 20px;border-radius:22px;}
    .contact-card{padding:44px 20px;border-radius:22px;}
}
@media(max-width:480px){
    .page-hero{min-height:clamp(380px,85vw,480px);padding-bottom:42px;}
    .page-hero-content{padding:0 18px 30px;}
    .hero-orange-strip{height:42px;}
}
</style>

{{-- ══ HERO ══ --}}
<section class="page-hero">
    <div class="page-hero-content">
        <h1 class="hero-h1">
            Every Gift Counts,<br>
            Change a Life Today
        </h1>
        <p class="hero-sub">
            <strong><em>Des Ailes pour Grandir</em></strong> &mdash; <em>"Wings to Grow"</em> &mdash; gives vulnerable children in Cambodia the chance to soar. Your gift goes <strong>100% to the field</strong>.
        </p>
        <a href="{{ route('support.donate') }}" class="btn-donate-now">
            <i class="fas fa-hand-holding-heart"></i> Donate Now
        </a>
    </div>
    <div class="hero-orange-strip"></div>
</section>

{{-- ══ WHY US ══ --}}
<section style="background:var(--cream);padding:96px 0;">
    <div class="max-w-5xl mx-auto px-4">

        {{-- Header --}}
        <div class="text-center mb-14 reveal">
            <div class="sec-label justify-center mb-4">
                <div class="sec-line"></div> Why Choose Us <div class="sec-line"></div>
            </div>
            <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(2rem,4.5vw,3.2rem);font-weight:700;color:var(--ink);letter-spacing:-.02em;line-height:1.08;margin-bottom:14px;">
                Giving That <em style="font-style:italic;background:linear-gradient(135deg,#d97706,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Endures</em>
            </h2>
            <p style="font-family: 'Montserrat', sans-serif;font-size:.95rem;color:var(--muted);max-width:520px;margin:0 auto;line-height:1.78;">
                Family foundations and philanthropists seek impact that is traceable, values-aligned, and enduring. Our programs in Cambodia deliver all three.
            </p>
        </div>

        {{-- Why card --}}
        <div class="why-card reveal mb-12">
            <div class="why-orb why-orb-a"></div>
            <div class="why-orb why-orb-b"></div>
            <div class="relative z-10">
                <div class="sec-label mb-5" style="color:rgba(251,191,36,.6);">
                    <div class="sec-line"></div> Our Commitment
                </div>
                <p style="font-family: 'Montserrat', sans-serif;font-size:1rem;color:rgba(255,255,255,.62);line-height:1.85;margin-bottom:16px;max-width:760px;">
                    Whether you wish to fund a specific program, name a project, or build a multi-year partnership, we create a giving arrangement that reflects your family's values and vision - with <strong style="color:#fbbf24;">rigorous reporting</strong> and a deeply human approach.
                </p>
                <p style="font-family: 'Montserrat', sans-serif;font-size:1rem;color:rgba(255,255,255,.62);line-height:1.85;max-width:760px;">
                    Our field team provides direct access to on-the-ground impact, and every euro you contribute is tracked, reported, and transformed into measurable change for children in Cambodia.
                </p>
            </div>
        </div>

        {{-- Benefit cards --}}
        <div class="benefits-grid reveal">
            @foreach([
                ['fas fa-eye',          '#eff6ff','#3b82f6', 'Full Transparency',   'Dedicated impact reports, financial breakdowns, and direct access to our field team at any time.'],
                ['fas fa-tag',          '#fff7ed','#f97316', 'Named Projects',      'Name a school, well, or scholarship fund after your family - a living legacy children will carry forward.'],
                ['fas fa-handshake',    '#f0fdf4','#16a34a', 'Multi-Year Giving',   'Predictable, structured giving allows us to plan, scale, and deepen programs for greater long-term impact.'],
                ['fas fa-certificate',  '#faf5ff','#a855f7', 'Full Fiscal Benefit', 'All contributions are eligible for the maximum applicable tax deductions available in France.'],
            ] as $b)
            <div class="benefit-card d{{ $loop->index + 1 }}">
                <div class="benefit-icon" style="background:{{ $b[1] }};">
                    <i class="{{ $b[0] }}" style="color:{{ $b[2] }};"></i>
                </div>
                <div>
                    <div class="benefit-title">{{ $b[3] }}</div>
                    <div class="benefit-desc">{{ $b[4] }}</div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══ GIVING LEVELS ══ --}}
<section class="levels-bg reveal">
    <div class="max-w-6xl mx-auto px-4">

        <div class="text-center mb-14">
            <div class="sec-label justify-center mb-4">
                <div class="sec-line"></div> Giving Levels <div class="sec-line"></div>
            </div>
            <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:700;color:var(--ink);letter-spacing:-.02em;line-height:1.08;">
                Choose Your <em style="font-style:italic;color:var(--gold-d);">Level of Impact</em>
            </h2>
        </div>

        <div class="levels-grid grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                [
                    'icon'   => 'fas fa-seedling',
                    'bg'     => '#f0fdf4','ic' => '#16a34a',
                    'name'   => 'Patron',
                    'range'  => '€5,000 - €19,999 / year',
                    'desc'   => 'Support a targeted program with meaningful annual funding and receive detailed impact updates.',
                    'perks'  => ['Annual impact report','Named in our annual report','Direct contact with field team'],
                    'feat'   => false,
                ],
                [
                    'icon'   => 'fas fa-star',
                    'bg'     => '#fff7ed','ic' => '#f97316',
                    'name'   => 'Benefactor',
                    'range'  => '€20,000 - €99,999 / year',
                    'desc'   => 'Name a project or scholarship. Your family\'s values become a visible, lasting part of our mission.',
                    'perks'  => ['Named project or scholarship','Field visit invitation','Bi-annual reporting','Tax documentation'],
                    'feat'   => true,
                ],
                [
                    'icon'   => 'fas fa-crown',
                    'bg'     => '#fdf4ff','ic' => '#a855f7',
                    'name'   => 'Legacy Partner',
                    'range'  => '€100,000+ / year',
                    'desc'   => 'Build a multi-year partnership with a dedicated program that carries your family\'s legacy for generations.',
                    'perks'  => ['Multi-year custom program','Dedicated liaison officer','Quarterly field reports','Foundation plaque & recognition'],
                    'feat'   => false,
                ],
            ] as $lvl)
            <div class="level-card {{ $lvl['feat'] ? 'featured' : '' }}">
                @if($lvl['feat'])
                <div class="level-badge">Most Popular</div>
                @endif
                <div class="level-icon" style="background:{{ $lvl['bg'] }};">
                    <i class="{{ $lvl['icon'] }}" style="color:{{ $lvl['ic'] }};"></i>
                </div>
                <div class="level-name">{{ $lvl['name'] }}</div>
                <div class="level-range">{{ $lvl['range'] }}</div>
                <div class="level-desc">{{ $lvl['desc'] }}</div>
                <div class="level-perks">
                    @foreach($lvl['perks'] as $perk)
                    <div class="level-perk">
                        <i class="fas fa-check-circle" style="color:{{ $lvl['ic'] }};"></i>
                        {{ $perk }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══ CONTACT CTA ══ --}}
<section style="background:var(--cream);padding:80px 20px;" id="contact">
    <div class="max-w-3xl mx-auto">
        <div class="contact-card reveal">
            <div class="contact-glow"></div>
            <div class="relative z-10">
                <div class="sec-label justify-center mb-5" style="color:rgba(251,191,36,.5);">
                    <div class="sec-line"></div> Get in Touch <div class="sec-line"></div>
                </div>
                <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;color:#fff;line-height:1.08;letter-spacing:-.02em;margin-bottom:14px;">
                    Begin a <em style="font-style:italic;background:linear-gradient(90deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Conversation</em>
                </h2>
                <p style="font-family: 'Montserrat', sans-serif;color:rgba(255,255,255,.5);font-size:.95rem;max-width:440px;margin:0 auto 36px;line-height:1.78;">
                    We welcome all exploratory conversations - confidential, with no obligation. Let's discover how your generosity can best serve children in Cambodia.
                </p>
                <a href="{{ route('home') }}#contact"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:12px;padding:18px 44px;border-radius:16px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#1c1033;font-family: 'Montserrat', sans-serif;font-size:.95rem;font-weight:800;text-decoration:none;box-shadow:0 10px 36px rgba(251,191,36,.4);transition:transform .22s,box-shadow .22s;position:relative;overflow:hidden;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 18px 48px rgba(251,191,36,.52)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='0 10px 36px rgba(251,191,36,.4)'">
                    <i class="fas fa-envelope"></i> Contact Our Foundation Team
                </a>
                <p style="font-family: 'Montserrat', sans-serif;font-size:11px;color:rgba(255,255,255,.25);margin-top:16px;letter-spacing:.06em;">
                    <i class="fas fa-lock mr-1"></i> Fully confidential - No obligation
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ══ BOTTOM CTA ══ --}}
<div class="cta-wrap reveal">
    <div class="cta-in">
        <div class="cta-glow"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
            <div class="text-white text-center lg:text-left">
                <p style="font-family: 'Montserrat', sans-serif;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(251,191,36,.5);margin-bottom:12px;">
                    <i class="fas fa-star mr-1"></i> Make an Impact
                </p>
                <h2 style="font-family: 'Montserrat', sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;color:#fff;line-height:1.08;letter-spacing:-.02em;margin-bottom:12px;">
                    Make a Difference<br>
                    <em style="font-style:italic;background:linear-gradient(90deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Today</em>
                </h2>
                <p style="font-family: 'Montserrat', sans-serif;color:rgba(255,255,255,.5);font-size:.9rem;max-width:400px;line-height:1.78;">
                    Your support funds programs that create measurable, lasting change for children in Cambodia.
                </p>
            </div>
            <div class="flex flex-col gap-4 flex-shrink-0">
                <a href="{{ route('sponsor.children') }}"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 36px;background:linear-gradient(135deg,#fbbf24,#f97316);color:#1c1033;font-family: 'Montserrat', sans-serif;font-size:.875rem;font-weight:800;border-radius:16px;text-decoration:none;box-shadow:0 10px 32px rgba(251,191,36,.3);transition:transform .22s,box-shadow .22s;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 18px 44px rgba(251,191,36,.45)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='0 10px 32px rgba(251,191,36,.3)'">
                    <i class="fas fa-heart"></i> Sponsor a Child
                </a>
                <a href="{{ route('support.donate') }}"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:18px 36px;background:rgba(251,191,36,.08);border:1.5px solid rgba(251,191,36,.28);color:rgba(255,255,255,.8);font-family: 'Montserrat', sans-serif;font-size:.875rem;font-weight:700;border-radius:16px;text-decoration:none;transition:background .2s,border-color .2s;"
                   onmouseover="this.style.background='rgba(251,191,36,.15)';this.style.borderColor='rgba(251,191,36,.55)'"
                   onmouseout="this.style.background='rgba(251,191,36,.08)';this.style.borderColor='rgba(251,191,36,.28)'">
                    <i class="fas fa-hand-holding-heart"></i> Make a Donation
                </a>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    var o=new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){e.target.classList.add('visible');o.unobserve(e.target);}
        });
    },{threshold:.07,rootMargin:'0px 0px -40px 0px'});
    document.querySelectorAll('.reveal').forEach(function(el){o.observe(el);});
})();
</script>
@endsection