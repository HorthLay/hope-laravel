{{-- resources/views/pages/support/donate.blade.php --}}
@extends('layouts.app')

@section('title', 'Make a Donation')

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
.pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:999px;font-size:11px;font-weight:800;letter-spacing:.06em;text-transform:uppercase}
.wave-divider{line-height:0;overflow:hidden}.wave-divider svg{display:block}
.donate-btn{
    display:inline-flex;align-items:center;justify-content:center;gap:12px;
    padding:20px 52px;background:linear-gradient(135deg,#f97316,#f59e0b);
    color:#fff;font-size:1.15rem;font-weight:900;letter-spacing:.04em;text-transform:uppercase;
    border-radius:16px;text-decoration:none;
    box-shadow:0 8px 32px rgba(249,115,22,.45);
    transition:transform .2s,box-shadow .2s,filter .2s;
    border:none;cursor:pointer;
}
.donate-btn:hover{transform:translateY(-3px) scale(1.03);box-shadow:0 14px 40px rgba(249,115,22,.55);filter:brightness(1.06);color:#fff;}
.donate-btn:active{transform:translateY(0) scale(.99);}
.helloasso-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:999px;background:#f1f5f9;font-size:11px;font-weight:700;color:#64748b;border:1px solid #e2e8f0;}
.secure-row{display:flex;align-items:center;justify-content:center;gap:20px;flex-wrap:wrap;font-size:12px;font-weight:600;color:#94a3b8;}
.secure-row span{display:flex;align-items:center;gap:5px;}
@media(max-width:640px){.page-hero-content{padding:60px 20px 56px}.donate-btn{padding:16px 32px;font-size:1rem;}}
</style>
<script>
(function(){
    const o=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('visible');o.unobserve(x.target)}})},{threshold:.08,rootMargin:'0px 0px -50px 0px'});
    document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale').forEach(el=>o.observe(el));
})();
</script>

{{-- HERO --}}
<section class="page-hero" style="min-height:380px">
    <div class="page-hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white/90">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Support Us</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Make a Donation</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-hand-holding-heart text-xs"></i> Give Today
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">Make a Donation</h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">Individuals and companies — every contribution makes a real difference for children in Cambodia.</p>
    </div>
</section>

<div class="wave-divider" style="background:#f9fafb"><svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#ffffff"/></svg></div>

{{-- MAIN DONATION SECTION --}}
<section class="bg-white py-20 md:py-28">
    <div class="max-w-3xl mx-auto px-4 text-center">

        {{-- Donation type cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16 reveal">
            <div class="bg-white rounded-3xl shadow-sm border-2 border-orange-200 p-8 text-left hover:shadow-xl transition">
                <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fas fa-user text-orange-500 text-xl"></i>
                </div>
                <h3 class="text-lg font-black text-gray-900 mb-3">Individual Donation</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-4">Every euro donated goes directly to the field to support vulnerable children and families in Cambodia.</p>
                <div class="space-y-2">
                    @foreach(['One-time donation', 'Monthly recurring donation', 'Donation in memoriam', 'Birthday or event fundraiser'] as $type)
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-check text-orange-500 text-xs"></i> {{ $type }}
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-[#1a2e3b] rounded-3xl p-8 text-left hover:shadow-xl transition">
                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fas fa-building text-orange-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-black text-white mb-3">Corporate Donation</h3>
                <p class="text-white/70 text-sm leading-relaxed mb-4">We offer tailored partnership packages with visibility, impact reports, and employee engagement opportunities.</p>
                <div class="space-y-2">
                    @foreach(['Single or recurring corporate donation', 'Skills-based sponsorship', 'Employee matching programs', 'Named project funding'] as $type)
                    <div class="flex items-center gap-2 text-sm text-white/80">
                        <i class="fas fa-check text-orange-400 text-xs"></i> {{ $type }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Central CTA --}}
        <div class="reveal stagger-2">
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 border-2 border-orange-100 rounded-3xl p-12 md:p-16">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6" style="animation:pulse-soft 2.5s ease infinite">
                    <i class="fas fa-heart text-orange-500 text-3xl"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-3">Ready to Give?</h2>
                <p class="text-gray-500 text-lg mb-10 max-w-sm mx-auto leading-relaxed">Your generosity directly changes the lives of children in Cambodia.</p>

                <a href="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1"
                   target="_blank" rel="noopener"
                   class="donate-btn">
                    <i class="fas fa-hand-holding-heart text-xl"></i>
                    Donate Now
                </a>

                <div class="mt-8 secure-row">
                    <span><i class="fas fa-lock text-green-500"></i> Secure payment</span>
                    <span><i class="fas fa-shield-alt text-blue-500"></i> SSL encrypted</span>
                    <span><i class="fas fa-receipt text-orange-400"></i> Receipt provided</span>
                </div>

                <div class="mt-6 flex justify-center">
                    <span class="helloasso-badge">
                        <i class="fas fa-external-link-alt text-[10px]"></i>
                        Powered by HelloAsso
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA BANNER --}}
<section class="section bg-white pb-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-orange-500 via-orange-500 to-amber-500 rounded-3xl p-10 md:p-14 relative overflow-hidden reveal">
            <div class="absolute inset-0 opacity-10" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="text-white text-center lg:text-left">
                    <h2 class="text-3xl md:text-4xl font-black mb-3">Make a Difference Today</h2>
                    <p class="text-white/85 text-lg max-w-xl">Your support funds programs that change children's lives.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-orange-600 font-black rounded-xl hover:bg-orange-50 transition shadow-lg justify-center">
                        <i class="fas fa-heart"></i> Sponsor a Child
                    </a>
                    <a href="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-3 px-8 py-4 border-2 border-white/50 text-white font-black rounded-xl hover:bg-white/10 transition justify-center">
                        <i class="fas fa-hand-holding-heart"></i> Make a Donation
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection