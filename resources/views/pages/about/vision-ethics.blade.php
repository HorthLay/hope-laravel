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
                <p class="text-gray-600 leading-relaxed mb-4">We envision a world where no child grows up in fear, deprivation, or abandonment - where every child, regardless of origin, has the opportunity to develop fully and shape their own future.</p>
                <p class="text-gray-600 leading-relaxed">We aim to be a bridge between those who want to help and those who need it most - connecting compassion with action, and turning hope into concrete, measurable impact.</p>
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
                ['fas fa-shield-alt','red','Child Safety First','Every staff member follows ChildSafe standards. Protection is non-negotiable.'],
                ['fas fa-file-alt','blue','Transparency & Accountability','Rigorous financial reporting and open communication with all our donors and partners.'],
                ['fas fa-handshake','green','Respect for Local Culture',"Our programs are built with communities - adapted to local realities, values, and needs."],
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
