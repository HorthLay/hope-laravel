{{-- resources/views/pages/sponsorship/faq.blade.php --}}
@extends('layouts.app')

@section('title', 'Sponsorship FAQ | Association Des Ailes Pour Grandir')
@section('content')
<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
.reveal       {opacity:0;transform:translateY(28px); transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-left  {opacity:0;transform:translateX(-36px);transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal.visible,.reveal-left.visible{opacity:1;transform:none}
.stagger-1{transition-delay:.05s}.stagger-2{transition-delay:.12s}.stagger-3{transition-delay:.19s}
.pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:999px;font-size:11px;font-weight:800;letter-spacing:.06em;text-transform:uppercase}
.wave-divider{line-height:0;overflow:hidden}.wave-divider svg{display:block}
.text-gradient{background:linear-gradient(135deg,#f97316 0%,#f59e0b 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.icon-badge{display:inline-flex;align-items:center;justify-content:center;border-radius:16px;flex-shrink:0}

/* --- GLOBAL STYLE OVERRIDE --- */
body{font-family:'Montserrat',sans-serif;}
h1,h2,h3,h4,h5,h6,.pill{font-family:'Montserrat',sans-serif;}
.page-hero{
    position:relative!important;min-height:clamp(480px,65vh,700px)!important;height:auto!important;
    display:flex!important;align-items:flex-end!important;overflow:hidden!important;
    background:#0d1a0a url('{{ asset("images/image-background.jpg") }}') center 45%/cover no-repeat!important;
    isolation:isolate!important;border-radius:0!important;
}
.page-hero::after{
    content:''!important;position:absolute!important;inset:0!important;z-index:1!important;
    background:linear-gradient(0deg,rgba(0,0,0,.80) 0%,rgba(0,0,0,.50) 38%,rgba(0,0,0,.18) 70%,rgba(0,0,0,.05) 100%)!important;
    pointer-events:none!important;
}
.page-hero-bg{
    position:absolute!important;inset:0!important;z-index:0!important;
    width:100%!important;height:100%!important;
    background-image:url('{{ asset("images/image-background.jpg") }}')!important;
    background-size:cover!important;background-position:center 45%!important;
    filter:none!important;transform:none!important;opacity:1!important;
}
.page-hero-overlay{display:none!important;}
.page-hero-content{
    position:relative!important;z-index:2!important;
    max-width:1100px!important;width:100%!important;
    margin:0 auto!important;padding:0 40px 60px!important;
    display:block!important;text-align:left!important;
}
.page-hero .breadcrumb,.page-hero .pill{display:none!important;}
.page-hero h1{
    font-family:'Montserrat',sans-serif;
    font-size:clamp(2.4rem,4.5vw,3.8rem)!important;font-weight:900!important;
    line-height:1.0!important;letter-spacing:-.02em!important;color:#fff!important;
    max-width:720px!important;margin:0 0 18px!important;
    text-shadow:0 2px 8px rgba(0,0,0,.8),0 4px 20px rgba(0,0,0,.6)!important;
    animation:fadeUp .65s .08s ease both!important;
}
.page-hero h1 span,.text-gradient{
    background:none!important;color:#fff!important;-webkit-text-fill-color:#fff!important;
}
.page-hero p{
    font-family:'Montserrat',sans-serif;font-size:clamp(.95rem,1.4vw,1.15rem)!important;
    font-weight:500!important;color:rgba(255,255,255,.92)!important;line-height:1.65!important;
    max-width:640px!important;margin:0 0 28px!important;
    text-shadow:0 1px 6px rgba(0,0,0,.7)!important;
}
@media(max-width:768px){
    .page-hero{min-height:clamp(420px,75vw,560px)!important;}
    .page-hero-content{padding:0 20px 40px!important;}
    .page-hero h1{font-size:clamp(2rem,7vw,3rem)!important;}
}
@media(max-width:480px){
    .page-hero{min-height:clamp(380px,85vw,480px)!important;}
    .page-hero-content{padding:0 16px 36px!important;}
    .page-hero h1{font-size:clamp(1.75rem,9vw,2.4rem)!important;}
}
</style>

<section class="page-hero">
    <div class="page-hero-bg"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right"></i>
            <span>Sponsor</span>
            <i class="fas fa-chevron-right"></i>
            <span>FAQ</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-question-circle text-xs"></i> Questions &amp; Answers
        </div>
        <h1 style="animation:fadeUp .9s ease both">Sponsorship<br><span class="text-gradient">FAQ</span></h1>
        <p style="animation:fadeUp .9s .15s ease both">All your questions about sponsoring a child or family — clearly answered.</p>
    </div>
</section>

<div class="wave-divider" style="background:#f9fafb">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#f9fafb"/>
    </svg>
</div>

<section class="section bg-gray-50 py-16 md:py-24 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-orange-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[400px] h-[400px] bg-amber-200/20 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 relative z-10">
        @livewire('faq-accordion', [
            'theme' => 'orange',
            'categories' => [
                ['key' => 'financial',  'label' => 'Financial & Tax'],
                ['key' => 'engagement', 'label' => 'Engagement & Updates'],
                ['key' => 'general',    'label' => 'General Information'],
            ],
            'items' => [
                [
                    'category' => 'financial',
                    'question' => 'How much does it cost to sponsor a child or family?',
                    'answer'   => 'Sponsorship amounts vary depending on the program and specific needs of the child or family. We offer flexible monthly contributions so everyone can make a difference, regardless of budget. Contact us for the current suggested amounts.',
                ],
                [
                    'category' => 'financial',
                    'question' => 'Is my donation tax deductible?',
                    'answer'   => 'Yes. As a registered French association, your donations are eligible for tax deductions in France. We provide an official receipt after each contribution. For IFI taxpayers, specific rules may apply — see our tax benefits page for details.',
                ],
                [
                    'category' => 'financial',
                    'question' => 'How do I know my money is used correctly?',
                    'answer'   => 'We publish annual impact reports with detailed financial breakdowns. 100% of sponsorship funds go directly to the child or family\'s programs. Our accounts are independently audited.',
                ],
                [
                    'category' => 'engagement',
                    'question' => 'Can I communicate directly with the child or family I sponsor?',
                    'answer'   => 'Yes! You will receive regular updates, photos, and messages from your sponsored child or family. In some cases, direct correspondence is possible through our field team.',
                ],
                [
                    'category' => 'engagement',
                    'question' => 'Can a company sponsor a child or family?',
                    'answer'   => 'Absolutely! Corporate sponsorship is a great way to engage your team and strengthen your CSR policy. We offer tailored corporate packages — visit our "Sponsor as a Company" page or contact us.',
                ],
                [
                    'category' => 'engagement',
                    'question' => 'Can I sponsor more than one child or family?',
                    'answer'   => 'Yes, you can sponsor multiple children and/or families. Each sponsorship is independent, and you will receive separate updates for each.',
                ],
                [
                    'category' => 'general',
                    'question' => 'What happens to my sponsorship if I need to stop?',
                    'answer'   => 'We completely understand that circumstances change. Simply notify us and we will arrange a smooth transition. Your child or family will continue to receive support while we find a new sponsor.',
                ],
                [
                    'category' => 'general',
                    'question' => 'How long does a sponsorship last?',
                    'answer'   => 'Sponsorships are open-ended — you continue as long as you wish. We recommend committing to at least one year to allow meaningful relationships and measurable impact to develop.',
                ],
            ],
        ])

        {{-- CTA --}}
        <div class="mt-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-3xl p-8 md:p-10 text-center shadow-xl shadow-orange-500/20 relative overflow-hidden reveal">
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-black opacity-10 rounded-full blur-2xl"></div>
            <div class="relative z-10">
                <div class="icon-badge w-16 h-16 bg-white/20 backdrop-blur-sm mx-auto mb-6 rounded-2xl shadow-inner border border-white/30">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-black text-white mb-3">Still Have Questions?</h3>
                <p class="text-white/90 mb-8 max-w-lg mx-auto text-lg">Our dedicated team is here to guide you through the sponsorship process. Reach out and we'll respond within 24 hours.</p>
                <a href="{{ route('home') }}#contact" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-orange-600 hover:bg-gray-50 hover:scale-105 font-black rounded-xl transition-all shadow-lg shadow-black/10">
                    <i class="fas fa-envelope"></i> Contact Support Team
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var obs = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -60px 0px' });
    document.querySelectorAll('.reveal,.reveal-left').forEach(function(el) { obs.observe(el); });
});
</script>
@endpush
@endsection
