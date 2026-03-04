{{-- {-- resources/views/pages/families/health-wellbeing.blade.php --} --}}
@extends('layouts.app')

@section('title', 'Family Health & Well-being')
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
            <span>Our Actions</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Families</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Family Health & Well-being</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-heartbeat text-xs"></i> Family Health
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">Family Health & Well-being</h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">Healthy families raise healthy, thriving children — holistic care for the whole household.</p>
    </div>
</section>

<div class="wave-divider" style="background:#f9fafb"><svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#ffffff"/></svg></div>
<section class="section bg-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="reveal mb-10">
            <div class="pill bg-amber-100 text-amber-700 mb-3"><i class="fas fa-home text-xs"></i> Family Department</div>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-2">Family Health & Well-being</h2>
            <div class="w-20 h-1 bg-amber-500 rounded-full"></div>
        </div>
        <div class="space-y-5">
            <div class="section-card p-7 reveal stagger-1"><div class="flex items-start gap-5"><div class="icon-badge w-14 h-14 bg-orange-100 flex-shrink-0"><i class="fas fa-medkit text-orange-500 text-xl"></i></div><h3 class="text-xl font-black text-gray-900 mb-3">Family Health and Well-being</h3></div><div><p class="text-gray-600 leading-relaxed">The health and well-being of every family member are essential for creating a stable, protective home that supports children's development. In many Cambodian families, access to healthcare, health information, and psychological support remains limited. Des Ailes pour Grandir facilitates access to medical and preventive care, such as consultations, vaccinations, and monitoring of common illnesses, while educating families on proper hygiene, healthy nutrition, and disease prevention. At the same time, we provide emotional and psychosocial support to parents and children to strengthen resilience, balance, and family stability.</p></div></div>
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
                        <i class="fas fa-heart"></i> Sponsor a Family
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
