{{-- resources/views/pages/about/presentation.blade.php --}}
@extends('layouts.app')

@section('title', 'À propos de nous')

{{-- ═══════ PAGE HERO ═══════ --}}

{{-- ═══════ MAIN CONTENT ═══════ --}}
@section('content')
<style>
@keyframes fadeUp     { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
@keyframes pulse-soft { 0%,100%{transform:scale(1)} 50%{transform:scale(1.04)} }
.reveal       {opacity:0;transform:translateY(28px); transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-left  {opacity:0;transform:translateX(-36px);transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-right {opacity:0;transform:translateX(36px); transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-scale {opacity:0;transform:scale(.93);       transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal.visible,.reveal-left.visible,.reveal-right.visible,.reveal-scale.visible{opacity:1;transform:none}
.stagger-1{transition-delay:.05s}.stagger-2{transition-delay:.12s}.stagger-3{transition-delay:.19s}
.stagger-4{transition-delay:.26s}.stagger-5{transition-delay:.33s}.stagger-6{transition-delay:.40s}
.page-hero{position:relative;overflow:hidden;background:#1a1a1a;min-height:380px}
.page-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;filter:brightness(.45) saturate(1.1);transition:transform 8s ease}
.page-hero:hover .page-hero-bg{transform:scale(1.04)}
.page-hero-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,.65) 0%,rgba(0,0,0,.2) 60%,transparent 100%)}
.page-hero-content{position:relative;z-index:2;padding:80px 40px 72px;max-width:1280px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:18px}
.breadcrumb a:hover{color:#fff}
.breadcrumb span{color:rgba(255,255,255,.9)}
.section-card{background:#fff;border-radius:20px;border:1px solid #f1f5f9;transition:transform .28s cubic-bezier(.16,1,.3,1),box-shadow .28s;overflow:hidden}
.section-card:hover{transform:translateY(-5px);box-shadow:0 20px 48px rgba(0,0,0,.10)}
.icon-badge{display:inline-flex;align-items:center;justify-content:center;border-radius:16px;flex-shrink:0}
.pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:999px;font-size:11px;font-weight:800;letter-spacing:.06em;text-transform:uppercase}
.wave-divider{line-height:0;overflow:hidden}.wave-divider svg{display:block}
.text-gradient{background:linear-gradient(135deg,#f97316 0%,#f59e0b 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.stat-card{background:linear-gradient(135deg,#fff 0%,#fff7ed 100%);border:1px solid #fed7aa;border-radius:20px;padding:24px;text-align:center}
.stat-number-sm{font-size:2.2rem;font-weight:900;line-height:1;background:linear-gradient(135deg,#ea580c,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.faq-body{max-height:0;transition:max-height .35s ease}
.faq-item.open .faq-body{max-height:600px}
.faq-item.open .faq-chevron{transform:rotate(180deg)}
.faq-chevron{transition:transform .3s ease}
@media(max-width:640px){.page-hero-content{padding:60px 20px 56px}}

/* --- GLOBAL STYLE OVERRIDE --- */
body{font-family: 'Montserrat', sans-serif;}
h1,h2,h3,h4,h5,h6,.hero-h1,.section-title,.stat-number-sm,.stat-num,.stat-label,.pill,.breadcrumb{font-family: 'Montserrat', sans-serif;}
.page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{
    position:relative!important;min-height:clamp(480px,65vh,700px)!important;height:auto!important;
    display:flex!important;align-items:flex-end!important;overflow:hidden!important;
    background:#0d1a0a url('{{ asset("images/pages/our-team.jpg") }}') center 45%/cover no-repeat!important;
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
    background-image:url('{{ asset("images/pages/our-team.jpg") }}')!important;
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
<script>
(function(){
const o=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('visible');o.unobserve(x.target)}})},{threshold:.08,rootMargin:'0px 0px -50px 0px'});
document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale').forEach(el=>o.observe(el));
document.querySelectorAll('.faq-toggle').forEach(b=>{b.addEventListener('click',()=>{const i=b.closest('.faq-item');const w=i.classList.contains('open');document.querySelectorAll('.faq-item.open').forEach(x=>x.classList.remove('open'));if(!w)i.classList.add('open')})});
})();
</script>
<section class="page-hero" style="min-height:420px">
    <div class="page-hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}" data-en="Home" data-fr="Accueil" data-km="ទំព័រដើម">Accueil</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span data-en="Our Association" data-fr="Notre Association" data-km="សមាគមរបស់យើង">Notre Association</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span data-en="About Us" data-fr="À propos de nous" data-km="អំពីយើង">À propos de nous</span>
        </nav>
        <div class="inline-flex items-center gap-2 pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-dove text-xs"></i> <span data-en="Who we are" data-fr="Qui sommes-nous" data-km="យើងជានរណា">Qui sommes-nous</span>
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both"
            data-en="Changing lives,<br><span class='text-gradient'>one child at a time</span>"
            data-fr="Changer des vies,<br><span class='text-gradient'>un enfant à la fois</span>"
            data-km="ផ្លាស់ប្តូរជីវិត,<br><span class='text-gradient'>កុមារម្នាក់ម្តងៗ</span>">
            Changer des vies,<br><span class="text-gradient">un enfant à la fois</span>
        </h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both"
           data-en="Des Ailes pour Grandir - <em>“Giving wings to grow”</em> - giving vulnerable children in Cambodia the chance to rise."
           data-fr="Des Ailes pour Grandir - <em>« Donner des ailes pour grandir »</em> - offrir aux enfants vulnérables du Cambodge la chance de s'élever."
           data-km="Des Ailes pour Grandir - <em>“ផ្តល់ស្លាបដើម្បីរីកចម្រើន”</em> - ផ្តល់ឱកាសឱ្យកុមារងាយរងគ្រោះនៅកម្ពុជាបានលូតលាស់ឡើង។">
            Des Ailes pour Grandir - <em>« Donner des ailes pour grandir »</em> - offrir aux enfants vulnérables du Cambodge la chance de s'élever.
        </p>
    </div>
</section>

{{-- ── Citation d'ouverture ── --}}
<section class="section bg-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center reveal">
            <div class="relative inline-block mb-8">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-quote-left text-orange-400 text-3xl"></i>
                </div>
            </div>
            <p class="text-xl md:text-2xl lg:text-3xl font-light text-gray-700 leading-relaxed italic mb-6"
               data-en="“At Des Ailes pour Grandir, we believe no child should grow up in fear, deprivation, or abandonment. Every child deserves to be protected, supported, and guided so they can build their future with confidence.”"
               data-fr="« Chez Des Ailes pour Grandir, nous croyons qu'aucun enfant ne devrait grandir dans la peur, le dénuement ou l'abandon. Chaque enfant mérite d'être protégé, soutenu et accompagné afin de construire son avenir avec confiance. »"
               data-km="“នៅ Des Ailes pour Grandir យើងជឿថាកុមារមិនគួរលូតលាស់ក្នុងភាពភ័យខ្លាច ភាពខ្វះខាត ឬការបោះបង់ឡើយ។ កុមារគ្រប់រូបសមនឹងទទួលបានការការពារ ការគាំទ្រ និងការណែនាំ ដើម្បីកសាងអនាគតដោយទំនុកចិត្ត។”">
                « Chez Des Ailes pour Grandir, nous croyons qu'aucun enfant ne devrait grandir dans la peur, le dénuement ou l'abandon.
                Chaque enfant mérite d'être protégé, soutenu et accompagné afin de construire son avenir avec confiance. »
            </p>
            <div class="flex items-center justify-center gap-3">
                <div class="h-px w-12 bg-orange-300"></div>
                <p class="text-sm font-black text-orange-500 uppercase tracking-wider" data-en="Our Mission" data-fr="Notre Mission" data-km="បេសកកម្មរបស់យើង">Notre Mission</p>
                <div class="h-px w-12 bg-orange-300"></div>
            </div>
        </div>
    </div>
</section>

<div class="wave-divider bg-gray-50">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="white"/>
    </svg>
</div>

{{-- ── Barre de statistiques ── --}}
<section class="stats-section py-14">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([
                ['icon'=>'fas fa-child',         'value'=>'95 000', 'label'=>'Enfants aidés/an',         'label_en'=>'Children helped/year',      'label_km'=>'កុមារដែលបានជួយ/ឆ្នាំ',       'color'=>'orange'],
                ['icon'=>'fas fa-percentage',    'value'=>'84',     'label'=>'% reversés aux programmes','label_en'=>'% returned to programs',    'label_km'=>'% ផ្តល់ទៅកម្មវិធី',           'color'=>'yellow'],
                ['icon'=>'fas fa-globe',         'value'=>'7',      'label'=>'Pays',                     'label_en'=>'Countries',                 'label_km'=>'ប្រទេស',                      'color'=>'blue'],
                ['icon'=>'fas fa-calendar-check','value'=>'65+',    'label'=>"Ans d'impact",             'label_en'=>'Years of impact',           'label_km'=>'ឆ្នាំនៃផលប៉ះពាល់',            'color'=>'green'],
            ] as $i => $st)
            <div class="text-center reveal stagger-{{ $i+1 }}">
                <div class="stat-number">{{ $st['value'] }}</div>
                <p class="text-base md:text-lg font-medium" data-en="{{ $st['label_en'] }}" data-fr="{{ $st['label'] }}" data-km="{{ $st['label_km'] }}">{{ $st['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="wave-divider bg-white">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,5 1080,55 1440,30 L1440,50 L0,50 Z" fill="white"/>
    </svg>
</div>

{{-- ── Qui sommes-nous ── --}}
<section class="section bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 md:gap-16 items-center mb-16">
            <div class="reveal-left">
                <div class="pill bg-orange-100 text-orange-600 mb-5">
                    <i class="fas fa-map-marker-alt text-xs"></i> <span data-en="Cambodia, Southeast Asia" data-fr="Cambodge, Asie du Sud-Est" data-km="កម្ពុជា អាស៊ីអាគ្នេយ៍">Cambodge, Asie du Sud-Est</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-5 leading-tight"
                    data-en="We act where<br><span class='text-gradient'>it matters most</span>"
                    data-fr="Nous agissons là<br><span class='text-gradient'>où c'est essentiel</span>"
                    data-km="យើងធ្វើសកម្មភាពនៅកន្លែង<br><span class='text-gradient'>ដែលសំខាន់បំផុត</span>">
                    Nous agissons là<br><span class="text-gradient">où c'est essentiel</span>
                </h2>
                <p class="text-base text-gray-600 leading-relaxed mb-4"
                   data-en="Our association works in Cambodia with orphaned and vulnerable children, bringing concrete and lasting support to those who need it most. Our mission is simple: create a stable, caring environment full of opportunity so every child can thrive."
                   data-fr="Notre association œuvre au Cambodge auprès des enfants orphelins et vulnérables, apportant un soutien concret et durable à ceux qui en ont le plus besoin. Notre mission est simple : créer un environnement stable, bienveillant et porteur d'opportunités afin que chaque enfant puisse s'épanouir pleinement."
                   data-km="សមាគមរបស់យើងធ្វើការនៅកម្ពុជាជាមួយកុមារកំព្រា និងកុមារងាយរងគ្រោះ ដោយផ្តល់ការគាំទ្រជាក់ស្តែង និងយូរអង្វែងដល់អ្នកដែលត្រូវការបំផុត។ បេសកកម្មរបស់យើងគឺសាមញ្ញ៖ បង្កើតបរិយាកាសមានស្ថិរភាព មានការយកចិត្តទុកដាក់ និងមានឱកាស ដើម្បីឱ្យកុមារគ្រប់រូបអាចរីកចម្រើនពេញលេញ។">
                    Notre association œuvre au Cambodge auprès des enfants orphelins et vulnérables, apportant un soutien concret et durable à ceux qui en ont le plus besoin.
                    Notre mission est simple : créer un environnement stable, bienveillant et porteur d'opportunités afin que chaque enfant puisse s'épanouir pleinement.
                </p>
                <p class="text-base text-gray-600 leading-relaxed mb-6"
                   data-en="We chose a holistic approach that goes beyond the child alone and considers their whole environment - from the family home to the wider community."
                   data-fr="Nous avons choisi une approche holistique qui dépasse le seul enfant et prend en compte l'ensemble de son environnement - du foyer familial à la communauté élargie."
                   data-km="យើងបានជ្រើសរើសវិធីសាស្ត្រសរុប ដែលលើសពីកុមារម្នាក់ឯង ហើយគិតដល់បរិយាកាសទាំងមូលរបស់គាត់ - ពីគ្រួសាររហូតដល់សហគមន៍ទូលំទូលាយ។">
                    Nous avons choisi une approche holistique qui dépasse le seul enfant et prend en compte l'ensemble de son environnement - du foyer familial à la communauté élargie.
                </p>
                <a href="{{ route('sponsor.children') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-black rounded-xl transition shadow-lg shadow-orange-200">
                    <i class="fas fa-heart"></i> <span data-en="Sponsor a child" data-fr="Parrainer un enfant" data-km="ឧបត្ថម្ភកុមារ">Parrainer un enfant</span>
                </a>
            </div>
            <div class="reveal-right">
                <div class="relative">
                    <div class="absolute -top-4 -right-4 w-full h-full bg-orange-100 rounded-3xl"></div>
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl aspect-[4/3] bg-orange-50 flex items-center justify-center">
                        @if(file_exists(public_path('images/cambodia.jpg')))
                            <img src="{{ asset('images/cambodia.jpg') }}" class="w-full h-full object-cover" alt="Cambodge">
                        @else
                            <div class="text-center p-12">
                                <i class="fas fa-globe-asia text-orange-200 text-8xl mb-4 block"></i>
                                <p class="text-orange-400 font-bold" data-en="Fieldwork in Cambodia" data-fr="Terrain au Cambodge" data-km="ការងារនៅកម្ពុជា">Terrain au Cambodge</p>
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-6 -left-6 w-28 h-28 bg-white rounded-2xl shadow-xl flex flex-col items-center justify-center text-center p-3">
                        <p class="text-3xl font-black text-orange-500">1958</p>
                        <p class="text-xs font-bold text-gray-500 mt-0.5" data-en="Founded in" data-fr="Fondée en" data-km="បង្កើតនៅឆ្នាំ">Fondée en</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Les trois pôles ── --}}
        <div class="reveal mb-4">
            <div class="pill bg-orange-100 text-orange-600 mb-3"><i class="fas fa-layer-group text-xs"></i> <span data-en="Our 3 Pillars" data-fr="Nos 3 Pôles" data-km="សសរស្តម្ភ ៣ របស់យើង">Nos 3 Pôles</span></div>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-2" data-en="A holistic approach" data-fr="Une approche holistique" data-km="វិធីសាស្ត្រសរុប">Une approche holistique</h2>
            <div class="w-20 h-1 bg-orange-500 rounded-full mb-10"></div>
        </div>
        <div class="grid md:grid-cols-3 gap-6 md:gap-8">
            @foreach([
                [
                    'icon'=>'fas fa-child', 'color'=>'orange',
                    'gradient'=>'from-orange-50 to-amber-50', 'border'=>'border-orange-200',
                    'num'=>'01', 'title'=>'Pôle Enfance',
                    'title_en'=>'Childhood',
                    'title_km'=>'កុមារភាព',
                    'objective'=>"Soutenir le bien-être, la sécurité et le développement des enfants vulnérables et orphelins.",
                    'objective_en'=>"Support the well-being, safety, and development of vulnerable and orphaned children.",
                    'objective_km'=>"គាំទ្រសុខុមាលភាព សុវត្ថិភាព និងការអភិវឌ្ឍរបស់កុមារងាយរងគ្រោះ និងកុមារកំព្រា។",
                    'actions'=>[
                        ['fr'=>"Protection de l'enfance", 'en'=>'Child protection', 'km'=>'ការការពារកុមារ'],
                        ['fr'=>'Santé et nutrition', 'en'=>'Health and nutrition', 'km'=>'សុខភាព និងអាហារូបត្ថម្ភ'],
                        ['fr'=>'Éducation', 'en'=>'Education', 'km'=>'ការអប់រំ'],
                        ['fr'=>'Développement personnel', 'en'=>'Personal development', 'km'=>'ការអភិវឌ្ឍផ្ទាល់ខ្លួន'],
                        ['fr'=>"Soutien aux foyers d'accueil", 'en'=>'Support for care homes', 'km'=>'ការគាំទ្រផ្ទះថែទាំ'],
                    ],
                    'route'=>'childhood.protection',
                ],
                [
                    'icon'=>'fas fa-home', 'color'=>'blue',
                    'gradient'=>'from-blue-50 to-indigo-50', 'border'=>'border-blue-200',
                    'num'=>'02', 'title'=>'Pôle Famille',
                    'title_en'=>'Family',
                    'title_km'=>'គ្រួសារ',
                    'objective'=>"Accompagner les familles dans leurs besoins essentiels, leur autonomie et leur stabilité.",
                    'objective_en'=>"Support families with essential needs, autonomy, and stability.",
                    'objective_km'=>"គាំទ្រគ្រួសារក្នុងតម្រូវការចាំបាច់ ស្វ័យភាព និងស្ថិរភាព។",
                    'actions'=>[
                        ['fr'=>'Logement et stabilité familiale', 'en'=>'Housing and family stability', 'km'=>'លំនៅដ្ឋាន និងស្ថិរភាពគ្រួសារ'],
                        ['fr'=>'Formation et emploi', 'en'=>'Training and employment', 'km'=>'ការបណ្តុះបណ្តាល និងការងារ'],
                        ['fr'=>'Soutien financier', 'en'=>'Financial support', 'km'=>'ការគាំទ្រហិរញ្ញវត្ថុ'],
                        ['fr'=>'Santé et bien-être familial', 'en'=>'Family health and well-being', 'km'=>'សុខភាព និងសុខុមាលភាពគ្រួសារ'],
                    ],
                    'route'=>'families.housing',
                ],
                [
                    'icon'=>'fas fa-city', 'color'=>'green',
                    'gradient'=>'from-green-50 to-emerald-50', 'border'=>'border-green-200',
                    'num'=>'03', 'title'=>'Pôle Communauté',
                    'title_en'=>'Community',
                    'title_km'=>'សហគមន៍',
                    'objective'=>"Développer et renforcer les infrastructures communautaires pour améliorer la qualité de vie des habitants.",
                    'objective_en'=>"Develop and strengthen community infrastructure to improve residents' quality of life.",
                    'objective_km'=>"អភិវឌ្ឍ និងពង្រឹងហេដ្ឋារចនាសម្ព័ន្ធសហគមន៍ ដើម្បីលើកកម្ពស់គុណភាពជីវិតរបស់ប្រជាពលរដ្ឋ។",
                    'actions'=>[
                        ['fr'=>'Construction & Rénovation', 'en'=>'Construction & Renovation', 'km'=>'សាងសង់ និងជួសជុល'],
                        ['fr'=>'Eau, assainissement & services de base', 'en'=>'Water, sanitation & basic services', 'km'=>'ទឹក អនាម័យ និងសេវាមូលដ្ឋាន'],
                    ],
                    'route'=>'community.infrastructure',
                ],
            ] as $i => $dept)
            <div class="section-card bg-gradient-to-br {{ $dept['gradient'] }} border {{ $dept['border'] }} reveal stagger-{{ $i+1 }}">
                <div class="p-8">
                    <div class="flex items-start justify-between mb-5">
                        <div class="icon-badge w-14 h-14 bg-{{ $dept['color'] }}-500 text-white shadow-lg shadow-{{ $dept['color'] }}-200">
                            <i class="{{ $dept['icon'] }} text-xl"></i>
                        </div>
                        <span class="text-5xl font-black text-{{ $dept['color'] }}-100">{{ $dept['num'] }}</span>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 mb-2" data-en="{{ $dept['title_en'] }}" data-fr="{{ $dept['title'] }}" data-km="{{ $dept['title_km'] }}">{{ $dept['title'] }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-5" data-en="{{ $dept['objective_en'] }}" data-fr="{{ $dept['objective'] }}" data-km="{{ $dept['objective_km'] }}">{{ $dept['objective'] }}</p>
                    <ul class="space-y-2 mb-6">
                        @foreach($dept['actions'] as $action)
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-{{ $dept['color'] }}-400 text-xs flex-shrink-0"></i> <span data-en="{{ $action['en'] }}" data-fr="{{ $action['fr'] }}" data-km="{{ $action['km'] }}">{{ $action['fr'] }}</span>
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route($dept['route']) }}"
                       class="inline-flex items-center gap-2 text-sm font-black text-{{ $dept['color'] }}-600 hover:gap-3 transition-all">
                        <span data-en="Discover" data-fr="Découvrir" data-km="ស្វែងយល់">Découvrir</span> <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="wave-divider bg-gray-50">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="white"/>
    </svg>
</div>

{{-- ── Valeurs ── --}}
<section class="section bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <div class="pill bg-orange-100 text-orange-600 mx-auto mb-4"><i class="fas fa-star text-xs"></i> <span data-en="Our Values" data-fr="Nos Valeurs" data-km="តម្លៃរបស់យើង">Nos Valeurs</span></div>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900" data-en="What guides every decision we make" data-fr="Ce qui guide chacune de nos décisions" data-km="អ្វីដែលណែនាំរាល់ការសម្រេចចិត្តរបស់យើង">Ce qui guide chacune de nos décisions</h2>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach([
                ['fas fa-heart',         'orange', 'Compassion & Courage',        'Compassion & Courage',          'ក្តីមេត្តា និងភាពក្លាហាន'],
                ['fas fa-handshake',     'blue',   'Confiance & Respect',         'Trust & Respect',               'ទំនុកចិត្ត និងការគោរព'],
                ['fas fa-search',        'green',  'Transparence & Intégrité',    'Transparency & Integrity',      'តម្លាភាព និងសុចរិតភាព'],
                ['fas fa-hands-helping', 'purple', 'Engagement & Coopération',    'Commitment & Cooperation',      'ការប្តេជ្ញាចិត្ត និងកិច្ចសហការ'],
                ['fas fa-star',          'yellow', 'Espoir & Autonomisation',     'Hope & Empowerment',            'ក្តីសង្ឃឹម និងការផ្តល់អំណាច'],
            ] as $i => $val)
            <div class="section-card p-6 text-center group reveal stagger-{{ $i+1 }}">
                <div class="icon-badge w-14 h-14 bg-{{ $val[1] }}-100 group-hover:bg-{{ $val[1] }}-500 mx-auto mb-4 transition">
                    <i class="{{ $val[0] }} text-{{ $val[1] }}-500 group-hover:text-white text-xl transition"></i>
                </div>
                <p class="text-xs font-black text-gray-700 uppercase tracking-wide" data-en="{{ $val[3] }}" data-fr="{{ $val[2] }}" data-km="{{ $val[4] }}">{{ $val[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA ── --}}
<section class="section bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-orange-500 via-orange-500 to-amber-500 rounded-3xl p-10 md:p-16 relative overflow-hidden reveal">
            <div class="absolute inset-0 opacity-10" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;background-position:center;"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="text-white text-center lg:text-left">
                    <p class="pill bg-white/20 border border-white/30 text-white mb-4 inline-flex">
                        <i class="fas fa-dove text-xs"></i> <span data-en="Take action" data-fr="Passez à l'action" data-km="ចូលរួមសកម្មភាព">Passez à l'action</span>
                    </p>
                    <h2 class="text-3xl md:text-4xl font-black mb-3" data-en="Join our mission" data-fr="Rejoignez notre mission" data-km="ចូលរួមបេសកកម្មរបស់យើង">Rejoignez notre mission</h2>
                    <p class="text-white/85 text-lg max-w-xl" data-en="Every feather of hope we add to their wings helps them rise a little higher each day." data-fr="Chaque plume d'espoir que nous ajoutons à leurs ailes les aide à s'élever un peu plus haut chaque jour." data-km="រាល់ស្លាបនៃក្តីសង្ឃឹមដែលយើងបន្ថែមឱ្យពួកគេ ជួយឱ្យពួកគេហោះឡើងខ្ពស់បន្តិចរាល់ថ្ងៃ។">Chaque plume d'espoir que nous ajoutons à leurs ailes les aide à s'élever un peu plus haut chaque jour.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-white text-orange-600 font-black rounded-xl hover:bg-orange-50 transition text-center justify-center shadow-lg">
                        <i class="fas fa-child"></i> <span data-en="Sponsor a child" data-fr="Parrainer un enfant" data-km="ឧបត្ថម្ភកុមារ">Parrainer un enfant</span>
                    </a>
                    <a href="{{ route('about.team') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 border-2 border-white/50 text-white font-black rounded-xl hover:bg-white/10 transition text-center justify-center">
                        <i class="fas fa-users"></i> <span data-en="Meet our team" data-fr="Rencontrer notre équipe" data-km="ជួបក្រុមការងាររបស់យើង">Rencontrer notre équipe</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
