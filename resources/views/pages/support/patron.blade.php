{-- resources/views/pages/support/patron.blade.php --}
@extends('layouts.app')

@section('title', 'Become a Patron')

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
</style>
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
            <span>Support Us</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Become a Patron</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-award text-xs"></i> Patronage
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">Become a Patron</h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">Strategic philanthropy with lasting impact — a meaningful alliance between your organization and our mission.</p>
    </div>
</section>

<div class="wave-divider" style="background:#f9fafb"><svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#ffffff"/></svg></div>
<section class="section bg-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16 items-center">
        <div>
            <span class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-black uppercase tracking-wider rounded-full mb-4">Patronage</span>
            <h2 class="text-2xl font-black text-gray-900 mb-5">A Partnership Beyond Donation</h2>
            <p class="text-gray-600 leading-relaxed mb-4">Becoming a patron of Des Ailes pour Grandir is a strategic commitment — a meaningful alliance between your company or foundation and our mission to protect and empower vulnerable children.</p>
            <p class="text-gray-600 leading-relaxed mb-6">Patrons receive tailored recognition, direct communication on impact, and an exclusive relationship with our field teams.</p>
            <div class="space-y-3">
                @foreach([
                    ['fas fa-star',         'Priority visibility on our website, reports, and campaigns'],
                    ['fas fa-user-tie',      'Named contact and quarterly impact briefings'],
                    ['fas fa-film',          'Exclusive access to field videos and photo reports'],
                    ['fas fa-certificate',   '60-75% tax deduction depending on your profile'],
                ] as $b)
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <i class="{{ $b[0] }} text-orange-500 text-sm w-5"></i>
                    <span class="text-sm text-gray-700">{{ $b[1] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="space-y-4">
            @foreach([
                ['bronze',  'Bronze Patron',  'bg-orange-100 border-orange-200 text-orange-700', '€1,000 – €4,999 / year', 'Logo on website, annual report mention, tax receipt.'],
                ['silver',  'Silver Patron',  'bg-gray-100 border-gray-300 text-gray-700', '€5,000 – €14,999 / year', 'All Bronze benefits + featured partner post, quarterly updates.'],
                ['gold',    'Gold Patron',    'bg-yellow-100 border-yellow-300 text-yellow-700', '€15,000+ / year', 'All Silver benefits + named project, field visit invitation, press release.'],
            ] as $tier)
            <div class="bg-white rounded-2xl border-2 {{ $tier[2] }} p-6 ">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-black text-gray-800">{{ $tier[1] }}</h3>
                    <span class="text-xs font-black {{ $tier[2] }} px-2 py-1 rounded-full">{{ $tier[3] }}</span>
                </div>
                <p class="text-sm text-gray-500">{{ $tier[4] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-[#1a2e3b] rounded-3xl p-10 text-white text-center">
        <h2 class="text-2xl font-black mb-3">Discuss a Custom Partnership</h2>
        <p class="text-white/70 mb-6">Every patron relationship is unique. Contact us to discuss a package tailored to your goals and capacity.</p>
        <a href="{{ route('home') }}#contact" class="inline-flex items-center gap-2 px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-black rounded-xl transition">
            <i class="fas fa-envelope text-sm"></i> Get in Touch
        </a>
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
                    <h2 class="text-3xl md:text-4xl font-black mb-3">Make a Difference Today</h2>
                    <p class="text-white/85 text-lg max-w-xl">Your support funds programs like this one.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-orange-600 font-black rounded-xl hover:bg-orange-50 transition shadow-lg justify-center">
                        <i class="fas fa-heart"></i> Sponsor a Child
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
