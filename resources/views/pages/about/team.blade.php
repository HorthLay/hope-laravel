{{-- resources/views/pages/about/team.blade.php --}}
@extends('layouts.app')

@section('title', 'Our Team')

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
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <a href="{{ route('about.presentation') }}">Our Association</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Our Team</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-users text-xs"></i> The People Behind the Mission
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">
            Governance <span class="text-gradient">&amp; Our Team</span>
        </h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">
            From the streets of Phnom Penh to Paris — a team united by one belief: every child deserves a chance.
        </p>
    </div>
</section>

{{-- ── Governance ── --}}
<section class="section bg-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <div class="pill bg-orange-100 text-orange-600 mx-auto mb-4"><i class="fas fa-crown text-xs"></i> Leadership</div>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-2">Association Governance</h2>
            <div class="w-20 h-1 bg-orange-500 rounded-full mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
            @foreach([
                [
                    'photo'=>'photo_julien.jpg', 'flag'=>'🇰🇭',
                    'name'=>'Julien', 'role'=>'Founder & President',
                    'color'=>'orange', 'icon'=>'fas fa-star',
                    'desc'=>'Based in Cambodia, Julien designs, oversees, and leads field actions in collaboration with local stakeholders. The heart and driving force of Des Ailes pour Grandir.',
                    'quote'=>'Every child we help is a small victory for humanity.',
                ],
                [
                    'photo'=>'photo_fanny.jpg', 'flag'=>'🇫🇷',
                    'name'=>'Fanny', 'role'=>'Treasurer',
                    'color'=>'blue', 'icon'=>'fas fa-chart-bar',
                    'desc'=>"Fanny ensures the association's accounts are accurately maintained, guaranteeing rigorous financial management and full transparency for our donors.",
                    'quote'=>'Every euro must reach the children who need it most.',
                ],
                [
                    'photo'=>'photo_mickaela.jpg', 'flag'=>'🇫🇷',
                    'name'=>'Mickaëla', 'role'=>'Events Manager',
                    'color'=>'green', 'icon'=>'fas fa-calendar-star',
                    'desc'=>"Mickaëla plans, organizes, and coordinates the association's fundraising events — the essential engine that keeps our programs running.",
                    'quote'=>'Great events build the bridges that change lives.',
                ],
            ] as $i => $person)
            <div class="section-card overflow-visible reveal stagger-{{ $i+1 }}">
                <div class="relative h-56 bg-gradient-to-br from-{{ $person['color'] }}-100 to-{{ $person['color'] }}-200 overflow-hidden rounded-t-[20px]">
                    @if(file_exists(public_path('images/team/'.$person['photo'])))
                        <img src="{{ asset('images/team/'.$person['photo']) }}" alt="{{ $person['name'] }}"
                             class="w-full h-full object-cover object-top transition-transform duration-700 hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="w-24 h-24 rounded-full bg-{{ $person['color'] }}-300 flex items-center justify-center">
                                <i class="fas fa-user text-{{ $person['color'] }}-600 text-4xl"></i>
                            </div>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 icon-badge w-10 h-10 bg-{{ $person['color'] }}-500 text-white shadow-lg">
                        <i class="{{ $person['icon'] }} text-sm"></i>
                    </div>
                    <div class="absolute top-4 left-4 text-2xl">{{ $person['flag'] }}</div>
                </div>
                <div class="p-7">
                    <h3 class="text-xl font-black text-gray-900">{{ $person['name'] }}</h3>
                    <p class="text-sm font-black text-{{ $person['color'] }}-500 mb-3 uppercase tracking-wide">{{ $person['role'] }}</p>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">{{ $person['desc'] }}</p>
                    <div class="border-l-4 border-{{ $person['color'] }}-300 pl-4">
                        <p class="text-xs text-gray-500 italic">"{{ $person['quote'] }}"</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Field & Volunteer Teams ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Cambodia ── --}}
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-3xl p-8 border border-orange-100 reveal-left">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center text-2xl shadow-lg shadow-orange-200">🇰🇭</div>
                    <div>
                        <h3 class="font-black text-gray-900 text-lg">In Cambodia</h3>
                        <p class="text-xs text-gray-500 font-medium">Our ground team</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-orange-500 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-gray-900 text-base mb-1">Vandy</h4>
                        <p class="text-xs font-black text-orange-500 uppercase tracking-wide mb-2">Field Coordinator</p>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            A committed Cambodian who works daily on the ground to protect children and support the association's initiatives with passion and dedication.
                        </p>
                        <div class="mt-3 flex gap-2">
                            <span class="pill bg-orange-100 text-orange-600 text-[10px]"><i class="fas fa-map-marker-alt text-[8px]"></i> Phnom Penh</span>
                            <span class="pill bg-green-100 text-green-600 text-[10px]"><i class="fas fa-circle text-[6px]"></i> Active</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- France ── --}}
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-8 border border-blue-100 reveal-right">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center text-2xl shadow-lg shadow-blue-200">🇫🇷</div>
                    <div>
                        <h3 class="font-black text-gray-900 text-lg">In France</h3>
                        <p class="text-xs text-gray-500 font-medium">Our volunteer network</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center mb-4">
                        <i class="fas fa-users text-blue-500 text-2xl"></i>
                    </div>
                    <h4 class="font-black text-gray-900 text-base mb-2">Our Dedicated Volunteers</h4>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">
                        A team of passionate volunteers across France who bring the association's projects to life — organizing events, raising awareness, and ensuring every initiative succeeds.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="pill bg-blue-100 text-blue-600 text-[10px]"><i class="fas fa-calendar text-[8px]"></i> Event Support</span>
                        <span class="pill bg-purple-100 text-purple-600 text-[10px]"><i class="fas fa-bullhorn text-[8px]"></i> Awareness</span>
                        <span class="pill bg-green-100 text-green-600 text-[10px]"><i class="fas fa-handshake text-[8px]"></i> Fundraising</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Join CTA ── --}}
<section class="section bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-3xl p-10 md:p-14 text-white text-center reveal">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-heart text-white text-3xl" style="animation:pulse-soft 2s ease infinite"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-black mb-3">Want to Join the Team?</h2>
            <p class="text-white/85 text-lg mb-8 max-w-xl mx-auto">Whether in Cambodia or France, every pair of hands makes a difference. We welcome volunteers, partners, and anyone who shares our vision.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}#contact"
                   class="inline-flex items-center gap-3 px-8 py-4 bg-white text-orange-600 font-black rounded-xl hover:bg-orange-50 transition shadow-lg">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
                <a href="{{ route('support.event') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 border-2 border-white/50 text-white font-black rounded-xl hover:bg-white/10 transition">
                    <i class="fas fa-calendar-star"></i> Organize an Event
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
