{{-- resources/views/pages/sponsorship/faq.blade.php --}}
@extends('layouts.app')

@section('title', 'Sponsorship FAQ')
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
            <span>Sponsor</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>FAQ</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-question-circle text-xs"></i> Questions & Answers
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">Sponsorship<br><span class='text-gradient'>FAQ</span></h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">All your questions about sponsoring a child or family - clearly answered.</p>
    </div>
</section>

<div class="wave-divider" style="background:#f9fafb"><svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#ffffff"/></svg></div>
<section class="section bg-white py-16 md:py-20">
    <div class="max-w-4xl mx-auto px-4">
        <div class="mb-14">
                <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-3 reveal stagger-1">
                    <button class="faq-toggle w-full flex items-center justify-between px-6 py-5 text-left hover:bg-orange-50 transition" type="button">
                        <span class="font-black text-gray-800 pr-4">How much does it cost to sponsor a child or family?</span>
                        <i class="fas fa-chevron-down text-orange-500 faq-chevron flex-shrink-0"></i>
                    </button>
                    <div class="faq-body px-6 pb-0">
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">Sponsorship amounts vary depending on the program and specific needs of the child or family. We offer flexible monthly contributions so everyone can make a difference, regardless of budget. Contact us for the current suggested amounts.</p>
                    </div>
                </div>
                <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-3 reveal stagger-2">
                    <button class="faq-toggle w-full flex items-center justify-between px-6 py-5 text-left hover:bg-orange-50 transition" type="button">
                        <span class="font-black text-gray-800 pr-4">Is my donation tax deductible?</span>
                        <i class="fas fa-chevron-down text-orange-500 faq-chevron flex-shrink-0"></i>
                    </button>
                    <div class="faq-body px-6 pb-0">
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">Yes. As a registered French association, your donations are eligible for tax deductions in France. We provide an official receipt after each contribution. For IFI taxpayers, specific rules may apply - see our tax benefits page for details.</p>
                    </div>
                </div>
                <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-3 reveal stagger-3">
                    <button class="faq-toggle w-full flex items-center justify-between px-6 py-5 text-left hover:bg-orange-50 transition" type="button">
                        <span class="font-black text-gray-800 pr-4">Can I communicate directly with the child or family I sponsor?</span>
                        <i class="fas fa-chevron-down text-orange-500 faq-chevron flex-shrink-0"></i>
                    </button>
                    <div class="faq-body px-6 pb-0">
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">Yes! You will receive regular updates, photos, and messages from your sponsored child or family. In some cases, direct correspondence is possible through our field team.</p>
                    </div>
                </div>
                <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-3 reveal stagger-1">
                    <button class="faq-toggle w-full flex items-center justify-between px-6 py-5 text-left hover:bg-orange-50 transition" type="button">
                        <span class="font-black text-gray-800 pr-4">What happens to my sponsorship if I need to stop?</span>
                        <i class="fas fa-chevron-down text-orange-500 faq-chevron flex-shrink-0"></i>
                    </button>
                    <div class="faq-body px-6 pb-0">
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">We completely understand that circumstances change. Simply notify us and we will arrange a smooth transition. Your child or family will continue to receive support while we find a new sponsor.</p>
                    </div>
                </div>
                <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-3 reveal stagger-2">
                    <button class="faq-toggle w-full flex items-center justify-between px-6 py-5 text-left hover:bg-orange-50 transition" type="button">
                        <span class="font-black text-gray-800 pr-4">How do I know my money is used correctly?</span>
                        <i class="fas fa-chevron-down text-orange-500 faq-chevron flex-shrink-0"></i>
                    </button>
                    <div class="faq-body px-6 pb-0">
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">We publish annual impact reports with detailed financial breakdowns. 100% of sponsorship funds go directly to the child or family's programs. Our accounts are independently audited.</p>
                    </div>
                </div>
                <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-3 reveal stagger-3">
                    <button class="faq-toggle w-full flex items-center justify-between px-6 py-5 text-left hover:bg-orange-50 transition" type="button">
                        <span class="font-black text-gray-800 pr-4">Can a company sponsor a child or family?</span>
                        <i class="fas fa-chevron-down text-orange-500 faq-chevron flex-shrink-0"></i>
                    </button>
                    <div class="faq-body px-6 pb-0">
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">Absolutely! Corporate sponsorship is a great way to engage your team and strengthen your CSR policy. We offer tailored corporate packages - visit our 'Sponsor as a Company' page or contact us.</p>
                    </div>
                </div>
                <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-3 reveal stagger-1">
                    <button class="faq-toggle w-full flex items-center justify-between px-6 py-5 text-left hover:bg-orange-50 transition" type="button">
                        <span class="font-black text-gray-800 pr-4">Can I sponsor more than one child or family?</span>
                        <i class="fas fa-chevron-down text-orange-500 faq-chevron flex-shrink-0"></i>
                    </button>
                    <div class="faq-body px-6 pb-0">
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">Yes, you can sponsor multiple children and/or families. Each sponsorship is independent, and you will receive separate updates for each.</p>
                    </div>
                </div>
                <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-3 reveal stagger-2">
                    <button class="faq-toggle w-full flex items-center justify-between px-6 py-5 text-left hover:bg-orange-50 transition" type="button">
                        <span class="font-black text-gray-800 pr-4">How long does a sponsorship last?</span>
                        <i class="fas fa-chevron-down text-orange-500 faq-chevron flex-shrink-0"></i>
                    </button>
                    <div class="faq-body px-6 pb-0">
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">Sponsorships are open-ended - you continue as long as you wish. We recommend committing to at least one year to allow meaningful relationships and measurable impact to develop.</p>
                    </div>
                </div>
        </div>
        <div class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-100 rounded-3xl p-8 md:p-10 text-center reveal">
            <div class="icon-badge w-16 h-16 bg-orange-100 mx-auto mb-5"><i class="fas fa-comment-dots text-orange-500 text-2xl"></i></div>
            <h3 class="text-xl font-black text-gray-800 mb-3">Still Have Questions?</h3>
            <p class="text-gray-500 mb-6">Our team is here to help. Reach out and we'll respond within 24 hours.</p>
            <a href="{{ route('home') }}#contact" class="inline-flex items-center gap-3 px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-black rounded-xl transition shadow-lg shadow-orange-200"><i class="fas fa-envelope"></i> Contact Us</a>
        </div>
    </div>
</section>
@endsection
