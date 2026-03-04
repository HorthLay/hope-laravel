@extends('layouts.app')

@section('title', 'Start a Solidarity Fundraiser')

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
            <span>Fundraiser</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-bullhorn text-xs"></i> Fundraise for Us
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">Start a Solidarity Fundraiser</h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">Turn your birthday, marathon, or milestone into an act of generosity for children in Cambodia.</p>
    </div>
</section>

<div class="wave-divider" style="background:#f9fafb"><svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#ffffff"/></svg></div>
<section class="section bg-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 py-16">
    <div class="text-center max-w-2xl mx-auto mb-14">
        <p class="text-gray-500 leading-relaxed">Anyone can launch a fundraiser for Des Ailes pour Grandir. Whether it's a birthday, a sporting challenge, or a memorial — your moment can create lasting impact for children in Cambodia.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
        @foreach([
            ['fas fa-birthday-cake', 'pink',   'Birthday Fundraiser', "Instead of gifts, ask friends and family to donate to a child's future."],
            ['fas fa-running',       'green',  'Sports Challenge',    'Run a marathon, cycle, or swim — collect pledges for every km or lap.'],
            ['fas fa-star',          'orange', 'Life Milestone',      'Wedding, graduation, promotion — celebrate by giving others a reason to smile.'],
            ['fas fa-users',         'blue',   'Team Challenge',      'Rally your colleagues, sports club, or community around a shared cause.'],
            ['fas fa-store',         'purple', 'Sale or Event',       'Dedicate proceeds from a sale, bake-off, or concert to our programs.'],
            ['fas fa-heart',         'red',    'Memorial Tribute',    "Honor someone's memory by collecting donations in their name."],
        ] as $type)
        <div class="text-center p-7 section-card hover:shadow-md hover:border-{{ $type[1] }}-200 transition group">
            <div class="w-14 h-14 bg-{{ $type[1] }}-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-{{ $type[1] }}-500 transition">
                <i class="{{ $type[0] }} text-{{ $type[1] }}-500 group-hover:text-white text-xl transition"></i>
            </div>
            <h3 class="font-black text-gray-800 mb-2">{{ $type[2] }}</h3>
            <p class="text-xs text-gray-500 leading-relaxed">{{ $type[3] }}</p>
        </div>
        @endforeach
    </div>

    {{-- How to start --}}
    <div class="bg-green-50 border border-green-100 rounded-3xl p-10 mb-16">
        <h2 class="text-xl font-black text-gray-800 mb-6 text-center">How to Launch Your Fundraiser</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['fas fa-envelope', '1', 'Contact Us', 'Reach out to our team to tell us about your project and get your personalized fundraising toolkit.'],
                ['fas fa-share-alt', '2', 'Share', 'We\'ll provide you with a unique page link, visuals, and communication tips to maximize your reach.'],
                ['fas fa-hand-holding-usd', '3', 'Collect & Impact', 'Donations go directly to Des Ailes pour Grandir. You\'ll receive a full impact report to share with your donors.'],
            ] as $step)
            <div class="text-center p-6 bg-white rounded-2xl shadow-sm">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3 text-white font-black">{{ $step[1] }}</div>
                <i class="{{ $step[0] }} text-green-400 text-sm mb-2 block"></i>
                <h3 class="font-black text-gray-800 mb-2 text-sm">{{ $step[2] }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $step[3] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('home') }}#contact" class="inline-flex items-center gap-2 px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-black rounded-xl transition text-lg shadow-lg">
            <i class="fas fa-rocket"></i> Launch My Fundraiser
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
