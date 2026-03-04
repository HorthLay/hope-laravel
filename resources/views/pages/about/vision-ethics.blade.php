{{-- resources/views/pages/about/vision-ethics.blade.php --}}
@extends('layouts.app')

@section('title', 'Our Vision & Code of Ethics')
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
            <span>Our Association</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Vision & Ethics</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-eye text-xs"></i> Our Beliefs
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">Our Vision &<br><span class='text-gradient'>Code of Ethics</span></h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">Guided by strong values, committed to the highest standards of child safety and integrity.</p>
    </div>
</section>

<div class="wave-divider" style="background:#f9fafb"><svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#ffffff"/></svg></div>
<section class="section bg-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center mb-20 reveal">
            <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-quote-left text-orange-400 text-3xl"></i>
            </div>
            <p class="text-2xl md:text-3xl font-light text-gray-700 leading-relaxed italic mb-6">
                "Because we believe that the most vulnerable children are also those whose wings, once unfolded, can reach the highest peaks. All it takes is to believe in them to see them soar."
            </p>
            <div class="flex items-center justify-center gap-3">
                <div class="h-px w-12 bg-orange-300"></div>
                <p class="text-sm font-black text-orange-500 uppercase tracking-wider">Association Des Ailes Pour Grandir</p>
                <div class="h-px w-12 bg-orange-300"></div>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-12 mb-20 items-center">
            <div class="reveal-left">
                <div class="pill bg-orange-100 text-orange-600 mb-4"><i class="fas fa-eye text-xs"></i> Our Vision</div>
                <h2 class="text-3xl font-black text-gray-900 mb-5">A World Where Every Child<br><span class="text-gradient">Can Take Flight</span></h2>
                <p class="text-gray-600 leading-relaxed mb-4">We envision a world where no child grows up in fear, deprivation, or abandonment — where every child, regardless of origin, has the opportunity to develop fully and shape their own future.</p>
                <p class="text-gray-600 leading-relaxed">We aim to be a bridge between those who want to help and those who need it most — connecting compassion with action, and turning hope into concrete, measurable impact.</p>
            </div>
            <div class="reveal-right">
                <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-3xl p-8 border border-orange-100">
                    <h3 class="font-black text-gray-800 text-lg mb-6">Our Three Pillars</h3>
                    <div class="space-y-5">
                        @foreach([['fas fa-shield-alt','orange','Protection','Every child deserves safety from violence, exploitation, and neglect.'],['fas fa-graduation-cap','blue','Education','Knowledge is the most powerful tool we can give a child for life.'],['fas fa-seedling','green','Empowerment','We build confidence so children can shape their own path.']] as $p)
                        <div class="flex items-start gap-4">
                            <div class="icon-badge w-12 h-12 bg-{{ $p[1] }}-100 flex-shrink-0"><i class="{{ $p[0] }} text-{{ $p[1] }}-500 text-lg"></i></div>
                            <div><h4 class="font-black text-gray-800 mb-1">{{ $p[2] }}</h4><p class="text-sm text-gray-500 leading-relaxed">{{ $p[3] }}</p></div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mb-10 reveal">
            <div class="pill bg-orange-100 text-orange-600 mx-auto mb-3"><i class="fas fa-balance-scale text-xs"></i> Code of Ethics</div>
            <h2 class="text-3xl font-black text-gray-900">The Principles That Guide Our Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-16">
            @foreach([
                ['fas fa-heart','orange','Compassion Without Judgment','We approach every situation with empathy, treating every child and family with dignity.'],
                ['fas fa-shield-check','red','Child Safety First','Every staff member follows ChildSafe standards. Protection is non-negotiable.'],
                ['fas fa-file-alt','blue','Transparency & Accountability','Rigorous financial reporting and open communication with all our donors and partners.'],
                ['fas fa-handshake','green','Respect for Local Culture',"Our programs are built with communities — adapted to local realities, values, and needs."],
                ['fas fa-balance-scale','purple','Non-Discrimination','We serve all vulnerable children equally, without distinction of religion or ethnicity.'],
                ['fas fa-recycle','amber','Sustainable Impact','We design programs for long-term change, building local capacity for independence.'],
            ] as $i => $e)
            <div class="section-card p-6 flex items-start gap-4 reveal stagger-{{ ($i%3)+1 }}">
                <div class="icon-badge w-12 h-12 bg-{{ $e[1] }}-100 flex-shrink-0"><i class="{{ $e[0] }} text-{{ $e[1] }}-500 text-lg"></i></div>
                <div><h3 class="font-black text-gray-800 mb-1">{{ $e[2] }}</h3><p class="text-sm text-gray-500 leading-relaxed">{{ $e[3] }}</p></div>
            </div>
            @endforeach
        </div>
        <div class="bg-gradient-to-br from-gray-900 to-[#1a2e3b] rounded-3xl p-8 md:p-12 text-white overflow-hidden relative reveal">
            <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                <div class="icon-badge w-20 h-20 bg-orange-500 flex-shrink-0 shadow-xl shadow-orange-500/30" style="border-radius:20px">
                    <i class="fas fa-shield-check text-white text-3xl"></i>
                </div>
                <div>
                    <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-3"><i class="fas fa-certificate text-xs"></i> Certified Member</div>
                    <h3 class="text-2xl font-black mb-3">ChildSafe Network Member</h3>
                    <p class="text-white/80 leading-relaxed">As a member of the ChildSafe network, our association applies international standards to protect children and prevent all forms of abuse. Our entire field team has completed the associated training, enabling us to act effectively every day to ensure a safe environment for all children under our care.</p>
                </div>
            </div>
        </div>
    </div>
</section>
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
