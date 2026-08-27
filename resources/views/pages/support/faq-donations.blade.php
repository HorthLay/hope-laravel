{{-- resources/views/pages/support/faq-donations.blade.php --}}
@extends('layouts.app')

@section('title', 'Donations FAQ | Association Des Ailes Pour Grandir')
@section('content')
<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
.reveal{opacity:0;transform:translateY(28px);transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal.visible{opacity:1;transform:none}
.pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:999px;font-size:11px;font-weight:800;letter-spacing:.06em;text-transform:uppercase}
.wave-divider{line-height:0;overflow:hidden}.wave-divider svg{display:block}
.text-gradient-blue{background:linear-gradient(135deg,#3b82f6 0%,#06b6d4 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
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
.page-hero h1 span,.text-gradient-blue{
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
            <span>Support Us</span>
            <i class="fas fa-chevron-right"></i>
            <span>Donations FAQ</span>
        </nav>
        <div class="pill bg-blue-500/20 border border-blue-400/30 text-blue-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-question-circle text-xs"></i> Donations Help
        </div>
        <h1 style="animation:fadeUp .9s ease both">Donations<br><span class="text-gradient-blue">FAQ</span></h1>
        <p style="animation:fadeUp .9s .15s ease both">All your questions about donating to Des Ailes pour Grandir — clearly answered.</p>
    </div>
</section>

<div class="wave-divider" style="background:#f9fafb">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#f9fafb"/>
    </svg>
</div>

<section class="section bg-gray-50 py-16 md:py-24 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-blue-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[400px] h-[400px] bg-cyan-200/20 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 relative z-10">
        @livewire('faq-accordion', [
            'theme' => 'blue',
            'categories' => [
                ['key' => 'tax',    'label' => 'Tax & Receipts'],
                ['key' => 'giving', 'label' => 'Ways of Giving'],
                ['key' => 'impact', 'label' => 'Impact & Transparency'],
            ],
            'items' => [
                [
                    'category' => 'tax',
                    'question' => 'Is my donation fully tax deductible?',
                    'answer'   => 'Yes. As a French association of general interest, donations to Des Ailes pour Grandir are eligible for tax reductions. Individuals receive a 66% reduction (up to 20% of taxable income). Companies receive a 60% reduction (up to 0.5% of turnover). IFI taxpayers receive a 75% reduction (up to €50,000).',
                ],
                [
                    'category' => 'tax',
                    'question' => 'How do I receive my tax receipt?',
                    'answer'   => 'A fiscal receipt is automatically generated and sent by email after each donation. It includes all the information needed for your tax declaration in France.',
                ],
                [
                    'category' => 'impact',
                    'question' => 'What percentage of my donation goes to the field?',
                    'answer'   => 'We aim for maximum impact: the vast majority of every euro donated goes directly to our programs in Cambodia. Our administrative and communication costs are minimized and published in our annual report.',
                ],
                [
                    'category' => 'giving',
                    'question' => 'Can I make a recurring monthly donation?',
                    'answer'   => 'Yes! Monthly giving is especially valuable as it provides predictable funding for ongoing programs. You can set up or cancel a recurring donation at any time.',
                ],
                [
                    'category' => 'giving',
                    'question' => 'Can I donate anonymously?',
                    'answer'   => 'Yes. You can choose to make an anonymous donation. Note that an anonymous donation cannot receive a tax receipt, as your personal information is required to issue a valid fiscal document.',
                ],
                [
                    'category' => 'giving',
                    'question' => 'What happens if I want to stop my monthly donation?',
                    'answer'   => 'You can cancel at any time by contacting us or through your online account. We\'ll process your request promptly with no questions asked.',
                ],
                [
                    'category' => 'impact',
                    'question' => 'Can I dedicate my donation to a specific project?',
                    'answer'   => 'Yes. When donating, you can specify a preferred area or project such as education, health, or water. We do our best to allocate accordingly, though we reserve the right to redirect funds where the need is greatest.',
                ],
            ],
        ])

        {{-- CTA --}}
        <div class="mt-12 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-3xl p-8 md:p-10 text-center shadow-xl shadow-blue-500/20 relative overflow-hidden reveal">
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-black opacity-10 rounded-full blur-2xl"></div>
            <div class="relative z-10">
                <div class="icon-badge w-16 h-16 bg-white/20 backdrop-blur-sm mx-auto mb-6 rounded-2xl shadow-inner border border-white/30">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-black text-white mb-3">Still Have Questions?</h3>
                <p class="text-white/90 mb-8 max-w-lg mx-auto text-lg">Our team is ready to assist you. We respond within 24 hours on business days.</p>
                <a href="{{ route('home') }}#contact" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-blue-600 hover:bg-gray-50 hover:scale-105 font-black rounded-xl transition-all shadow-lg shadow-black/10">
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
    document.querySelectorAll('.reveal').forEach(function(el) { obs.observe(el); });
});
</script>
@endpush
@endsection
