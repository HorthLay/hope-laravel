{{-- resources/views/pages/sponsorship/child-file.blade.php --}}
@extends('layouts.app')

@section('title', 'Child Sponsorship — How It Works')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Montserrat:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
<script>
(function(){
const o=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('visible');o.unobserve(x.target)}})},{threshold:.08,rootMargin:'0px 0px -50px 0px'});
document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale').forEach(el=>o.observe(el));
document.querySelectorAll('.faq-toggle').forEach(b=>{b.addEventListener('click',()=>{const i=b.closest('.faq-item');const w=i.classList.contains('open');document.querySelectorAll('.faq-item.open').forEach(x=>x.classList.remove('open'));if(!w)i.classList.add('open')})});
})();
</script>
<section class="page-hero" style="min-height:380px">
    <div class="page-hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white/90">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Sponsor</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Child Sponsorship</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>How It Works</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-child text-xs"></i> Sponsor a Child
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">Child Sponsorship<br><span class='text-gradient'>How It Works</span></h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">Everything you need to know about sponsoring a child in Cambodia.</p>
    </div>
</section>

<div class="wave-divider" style="background:#f9fafb"><svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#ffffff"/></svg></div>
<section class="section bg-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-14 reveal">
            <div class="pill bg-orange-100 text-orange-600 mx-auto mb-4"><i class="fas fa-list-ol text-xs"></i> 4 Simple Steps</div>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900">Sponsor a Child in 4 Simple Steps</h2>
        </div>
        <div class="relative grid grid-cols-1 md:grid-cols-4 gap-6 mb-20">
            @foreach([['fas fa-search','1','Choose a Child','Browse profiles of children waiting for a sponsor and choose the one who touches your heart.'],['fas fa-user-plus','2','Create Account','Register as a sponsor in just a few minutes. Your data is secure and confidential.'],['fas fa-credit-card','3','Set Up Your Giving','Choose your monthly sponsorship amount. Every contribution makes a real difference.'],['fas fa-envelope-open-heart','4','Stay Connected','Receive regular updates, photos, and messages from your sponsored child.']] as $i => $step)
            <div class="text-center p-6 section-card reveal stagger-{{ $i+1 }}">
                <div class="w-14 h-14 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white font-black text-xl shadow-lg shadow-orange-200">{{ $step[1] }}</div>
                <h3 class="font-black text-gray-800 mb-2 text-sm">{{ $step[2] }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $step[3] }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid md:grid-cols-2 gap-8 mb-16">
            <div class="reveal-left">
                <div class="pill bg-orange-100 text-orange-600 mb-4"><i class="fas fa-list text-xs"></i> What Your Sponsorship Funds</div>
                <h2 class="text-2xl font-black text-gray-900 mb-6">Your Monthly Support Covers</h2>
                <div class="space-y-3">
                    @foreach(['School fees, supplies, and uniforms','Nutritious daily meals','Regular medical check-ups and healthcare','Safe living conditions and shelter','Educational tutoring and development activities','Psychosocial support and recreational activities'] as $item)
                    <div class="flex items-center gap-3 p-3 bg-orange-50 rounded-xl"><div class="icon-badge w-8 h-8 bg-orange-100"><i class="fas fa-check-circle text-orange-500 text-sm"></i></div><span class="text-sm font-semibold text-gray-700">{{ $item }}</span></div>
                    @endforeach
                </div>
            </div>
            <div class="bg-gradient-to-br from-gray-900 to-[#1a2e3b] rounded-3xl p-8 text-white reveal-right">
                <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5"><i class="fas fa-gift text-xs"></i> What You Receive</div>
                <div class="space-y-4">
                    @foreach([['fas fa-id-card',"A detailed sponsorship file with your child's profile"],['fas fa-camera',"Regular photos showing your child's growth"],['fas fa-envelope','Letters and messages from your sponsored child'],['fas fa-chart-line','Annual progress report on how your support is used'],['fas fa-certificate','Official tax receipt for your contributions']] as $r)
                    <div class="flex items-center gap-3"><div class="icon-badge w-8 h-8 bg-white/10"><i class="{{ $r[0] }} text-orange-400 text-sm"></i></div><span class="text-sm text-white/85">{{ $r[1] }}</span></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<div class="wave-divider" style="background:#ffffff"><svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,30 C360,5 1080,55 1440,30 L1440,50 L0,50 Z" fill="#ffffff"/></svg></div>
<section class="section bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-orange-500 via-orange-500 to-amber-500 rounded-3xl p-10 md:p-14 relative overflow-hidden reveal">
            <div class="absolute inset-0 opacity-10" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="text-white text-center lg:text-left">
                    <h2 class="text-3xl md:text-4xl font-black mb-3">Ready to Change a Life?</h2>
                    <p class="text-white/85 text-lg max-w-xl">Find your child and start your sponsorship today.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-orange-600 font-black rounded-xl hover:bg-orange-50 transition shadow-lg justify-center">
                        <i class="fas fa-heart"></i> Find a Child
                    </a>
                    <a href="{{ route('support.donate') }}" class="inline-flex items-center gap-3 px-8 py-4 border-2 border-white/50 text-white font-black rounded-xl hover:bg-white/10 transition justify-center">
                        <i class="fas fa-hand-holding-heart"></i> Make a Donation
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
