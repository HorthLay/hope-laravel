{{-- resources/views/pages/about/presentation.blade.php --}}
@extends('layouts.app')

@section('title', 'About Us')

{{-- ═══════ PAGE HERO ═══════ --}}

{{-- ═══════ MAIN CONTENT ═══════ --}}
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
<section class="page-hero" style="min-height:420px">
    <div class="page-hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Our Association</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>About Us</span>
        </nav>
        <div class="inline-flex items-center gap-2 pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-dove text-xs"></i> Who We Are
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">
            Changing Lives,<br><span class="text-gradient">One Child at a Time</span>
        </h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">
            Des Ailes pour Grandir — <em>"Wings to Grow"</em> — giving vulnerable children in Cambodia the chance to soar.
        </p>
    </div>
</section>

{{-- ── Opening quote ── --}}
<section class="section bg-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center reveal">
            <div class="relative inline-block mb-8">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-quote-left text-orange-400 text-3xl"></i>
                </div>
            </div>
            <p class="text-xl md:text-2xl lg:text-3xl font-light text-gray-700 leading-relaxed italic mb-6">
                "At Des Ailes pour Grandir, we believe that no child should grow up in fear, deprivation, or abandonment.
                Every child deserves to be protected, supported, and nurtured so they can build their future with confidence."
            </p>
            <div class="flex items-center justify-center gap-3">
                <div class="h-px w-12 bg-orange-300"></div>
                <p class="text-sm font-black text-orange-500 uppercase tracking-wider">Our Mission</p>
                <div class="h-px w-12 bg-orange-300"></div>
            </div>
        </div>
    </div>
</section>

<div class="wave-divider bg-gray-50">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="white"/>
    </svg>
</div>

{{-- ── Stats bar ── --}}
<section class="stats-section py-14">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([
                ['icon'=>'fas fa-child',         'value'=>'95,000', 'label'=>'Children Helped/Year', 'color'=>'orange'],
                ['icon'=>'fas fa-percentage',     'value'=>'84',     'label'=>'% Goes to Programs',   'color'=>'yellow'],
                ['icon'=>'fas fa-globe',          'value'=>'7',      'label'=>'Countries',            'color'=>'blue'],
                ['icon'=>'fas fa-calendar-check', 'value'=>'65+',    'label'=>'Years of Impact',      'color'=>'green'],
            ] as $i => $st)
            <div class="text-center reveal stagger-{{ $i+1 }}">
                <div class="stat-number">{{ $st['value'] }}</div>
                <p class="text-base md:text-lg font-medium">{{ $st['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="wave-divider bg-white">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,5 1080,55 1440,30 L1440,50 L0,50 Z" fill="white"/>
    </svg>
</div>

{{-- ── Who we are ── --}}
<section class="section bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 md:gap-16 items-center mb-16">
            <div class="reveal-left">
                <div class="pill bg-orange-100 text-orange-600 mb-5">
                    <i class="fas fa-map-marker-alt text-xs"></i> Cambodia, Southeast Asia
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-5 leading-tight">
                    We Work Where<br><span class="text-gradient">It Matters Most</span>
                </h2>
                <p class="text-base text-gray-600 leading-relaxed mb-4">
                    Our association works in Cambodia with orphaned and vulnerable children, providing concrete and lasting support to those who need it most.
                    Our mission is simple: to create a stable, caring, and opportunity-filled environment so that every child can thrive fully.
                </p>
                <p class="text-base text-gray-600 leading-relaxed mb-6">
                    We have chosen a holistic approach that goes beyond the child alone and considers their entire environment — from the family home to the broader community.
                </p>
                <a href="{{ route('sponsor.children') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-black rounded-xl transition shadow-lg shadow-orange-200">
                    <i class="fas fa-heart"></i> Sponsor a Child Today
                </a>
            </div>
            <div class="reveal-right">
                <div class="relative">
                    <div class="absolute -top-4 -right-4 w-full h-full bg-orange-100 rounded-3xl"></div>
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl aspect-[4/3] bg-orange-50 flex items-center justify-center">
                        @if(file_exists(public_path('images/about-cambodia.jpg')))
                            <img src="{{ asset('images/about-cambodia.jpg') }}" class="w-full h-full object-cover" alt="Cambodia">
                        @else
                            <div class="text-center p-12">
                                <i class="fas fa-globe-asia text-orange-200 text-8xl mb-4 block"></i>
                                <p class="text-orange-400 font-bold">Cambodia Field Work</p>
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-6 -left-6 w-28 h-28 bg-white rounded-2xl shadow-xl flex flex-col items-center justify-center text-center p-3">
                        <p class="text-3xl font-black text-orange-500">1958</p>
                        <p class="text-xs font-bold text-gray-500 mt-0.5">Founded</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Three departments ── --}}
        <div class="reveal mb-4">
            <div class="pill bg-orange-100 text-orange-600 mb-3"><i class="fas fa-layer-group text-xs"></i> Our 3 Departments</div>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-2">A Holistic Approach</h2>
            <div class="w-20 h-1 bg-orange-500 rounded-full mb-10"></div>
        </div>
        <div class="grid md:grid-cols-3 gap-6 md:gap-8">
            @foreach([
                [
                    'icon'=>'fas fa-child', 'color'=>'orange',
                    'gradient'=>'from-orange-50 to-amber-50', 'border'=>'border-orange-200',
                    'num'=>'01', 'title'=>'Childhood Department',
                    'objective'=>'Support the well-being, safety, and development of vulnerable and orphaned children.',
                    'actions'=>['Child Protection','Health and Nutrition','Education','Personal Development',"Support for Children\'s Homes"],
                    'route'=>'childhood.protection',
                ],
                [
                    'icon'=>'fas fa-home', 'color'=>'blue',
                    'gradient'=>'from-blue-50 to-indigo-50', 'border'=>'border-blue-200',
                    'num'=>'02', 'title'=>'Family Department',
                    'objective'=>'Support families in their essential needs, autonomy, and stability.',
                    'actions'=>['Housing and Family Stability','Training and Employment','Financial Support','Family Health and Well-being'],
                    'route'=>'families.housing',
                ],
                [
                    'icon'=>'fas fa-city', 'color'=>'green',
                    'gradient'=>'from-green-50 to-emerald-50', 'border'=>'border-green-200',
                    'num'=>'03', 'title'=>'Community Department',
                    'objective'=>'Develop and strengthen community infrastructure to improve the quality of life of residents.',
                    'actions'=>['Construction & Renovation','Water, Sanitation & Basic Services'],
                    'route'=>'community.infrastructure',
                ],
            ] as $i => $dept)
            <div class="section-card bg-gradient-to-br {{ $dept['gradient'] }} border {{ $dept['border'] }} reveal stagger-{{ $i+1 }}">
                <div class="p-8">
                    <div class="flex items-start justify-between mb-5">
                        <div class="icon-badge w-14 h-14 bg-{{ $dept['color'] }}-500 text-white shadow-lg shadow-{{ $dept['color'] }}-200">
                            <i class="{{ $dept['icon'] }} text-xl"></i>
                        </div>
                        <span class="text-5xl font-black text-{{ $dept['color'] }}-100">{{ $dept['num'] }}</span>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 mb-2">{{ $dept['title'] }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-5">{{ $dept['objective'] }}</p>
                    <ul class="space-y-2 mb-6">
                        @foreach($dept['actions'] as $action)
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-{{ $dept['color'] }}-400 text-xs flex-shrink-0"></i> {{ $action }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route($dept['route']) }}"
                       class="inline-flex items-center gap-2 text-sm font-black text-{{ $dept['color'] }}-600 hover:gap-3 transition-all">
                        Discover <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="wave-divider bg-gray-50">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="white"/>
    </svg>
</div>

{{-- ── Values ── --}}
<section class="section bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <div class="pill bg-orange-100 text-orange-600 mx-auto mb-4"><i class="fas fa-star text-xs"></i> Our Values</div>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900">What Guides Every Decision</h2>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach([
                ['fas fa-heart',         'orange', 'Compassion & Courage'],
                ['fas fa-handshake',     'blue',   'Trust & Respect'],
                ['fas fa-search',        'green',  'Transparency & Integrity'],
                ['fas fa-hands-helping', 'purple', 'Commitment & Cooperation'],
                ['fas fa-star',          'yellow', 'Hope & Empowerment'],
            ] as $i => $val)
            <div class="section-card p-6 text-center group reveal stagger-{{ $i+1 }}">
                <div class="icon-badge w-14 h-14 bg-{{ $val[1] }}-100 group-hover:bg-{{ $val[1] }}-500 mx-auto mb-4 transition">
                    <i class="{{ $val[0] }} text-{{ $val[1] }}-500 group-hover:text-white text-xl transition"></i>
                </div>
                <p class="text-xs font-black text-gray-700 uppercase tracking-wide">{{ $val[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA ── --}}
<section class="section bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-orange-500 via-orange-500 to-amber-500 rounded-3xl p-10 md:p-16 relative overflow-hidden reveal">
            <div class="absolute inset-0 opacity-10" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;background-position:center;"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="text-white text-center lg:text-left">
                    <p class="pill bg-white/20 border border-white/30 text-white mb-4 inline-flex">
                        <i class="fas fa-dove text-xs"></i> Take Action
                    </p>
                    <h2 class="text-3xl md:text-4xl font-black mb-3">Join Our Mission</h2>
                    <p class="text-white/85 text-lg max-w-xl">Every feather of hope we add to their wings helps them rise a little higher each day.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-white text-orange-600 font-black rounded-xl hover:bg-orange-50 transition text-center justify-center shadow-lg">
                        <i class="fas fa-child"></i> Sponsor a Child
                    </a>
                    <a href="{{ route('about.team') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 border-2 border-white/50 text-white font-black rounded-xl hover:bg-white/10 transition text-center justify-center">
                        <i class="fas fa-users"></i> Meet Our Team
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
