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
            <span>Sponsor</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>FAQ</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-question-circle text-xs"></i> Questions & Answers
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">Sponsorship<br><span class='text-gradient'>FAQ</span></h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">All your questions about sponsoring a child or family — clearly answered.</p>
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
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">Yes. As a registered French association, your donations are eligible for tax deductions in France. We provide an official receipt after each contribution. For IFI taxpayers, specific rules may apply — see our tax benefits page for details.</p>
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
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">Absolutely! Corporate sponsorship is a great way to engage your team and strengthen your CSR policy. We offer tailored corporate packages — visit our 'Sponsor as a Company' page or contact us.</p>
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
                        <p class="text-gray-600 leading-relaxed text-sm pb-5">Sponsorships are open-ended — you continue as long as you wish. We recommend committing to at least one year to allow meaningful relationships and measurable impact to develop.</p>
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
