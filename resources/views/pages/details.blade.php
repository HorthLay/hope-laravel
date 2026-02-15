{{-- resources/views/pages/details.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Donate Now | Hope & Impact</title>
    <meta name="description" content="Make a one-time donation to support children in need. Every dollar makes a difference.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')

    <style>
        /* ── Animations ── */
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        @keyframes pulse-ring { 0%{transform:scale(1);opacity:.6} 100%{transform:scale(1.5);opacity:0} }
        @keyframes slide-up { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fade-in { from{opacity:0} to{opacity:1} }
        @keyframes shimmer { 0%{background-position:200% center} 100%{background-position:-200% center} }
        @keyframes bounce-in { 0%{transform:scale(.3);opacity:0} 50%{transform:scale(1.1)} 70%{transform:scale(.9)} 100%{transform:scale(1);opacity:1} }

        .float    { animation: float 3s ease-in-out infinite; }
        .slide-up { animation: slide-up .7s ease forwards; }
        .fade-in  { animation: fade-in .5s ease forwards; }

        /* ── Gradient text ── */
        .gradient-text {
            background: linear-gradient(135deg, #f97316, #ea580c, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .shimmer-text {
            background: linear-gradient(90deg, #f97316 0%, #fbbf24 30%, #f97316 60%, #ea580c 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        /* ── Hero ── */
        .donate-hero {
            background: linear-gradient(135deg, #1c0a00 0%, #431407 40%, #7c2d12 70%, #1c0a00 100%);
            position: relative;
            overflow: hidden;
        }
        .donate-hero::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(249,115,22,.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(234,88,12,.12) 0%, transparent 40%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f97316' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* ── Donation amount button ── */
        .amount-btn {
            background: #fff;
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1rem 1.5rem;
            font-weight: 700;
            transition: all .25s ease;
            cursor: pointer;
            position: relative;
        }
        .amount-btn:hover {
            border-color: #f97316;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249,115,22,.2);
        }
        .amount-btn.active {
            background: linear-gradient(135deg, #f97316, #ea580c);
            border-color: #f97316;
            color: white;
            box-shadow: 0 8px 24px rgba(249,115,22,.35);
        }
        .amount-btn.active::after {
            content: '✓';
            position: absolute;
            top: -8px;
            right: -8px;
            width: 24px;
            height: 24px;
            background: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: white;
            font-weight: 900;
        }

        /* ── Custom amount input ── */
        .custom-amount-input {
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1rem 1.5rem;
            font-weight: 700;
            font-size: 1.125rem;
            width: 100%;
            transition: all .25s ease;
        }
        .custom-amount-input:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249,115,22,.1);
        }

        /* ── Pulse ring ── */
        .pulse-ring::before, .pulse-ring::after {
            content: '';
            position: absolute; inset: -6px;
            border-radius: 50%;
            border: 2px solid #f97316;
            animation: pulse-ring 2s ease-out infinite;
        }
        .pulse-ring::after { animation-delay: 1s; }

        /* ── Contact card ── */
        .contact-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 16px rgba(0,0,0,.06);
            transition: all .25s ease;
        }
        .contact-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,.12);
        }

        /* ── Scroll animate ── */
        .reveal { opacity:0; transform:translateY(24px); transition:all .6s ease; }
        .reveal.show { opacity:1; transform:none; }
    </style>
</head>
<body class="bg-gray-50">

@include('layouts.header')

@php
    // ═══════════════════════════════════════════════════════════════════════
    // EVERY.ORG CONFIGURATION
    // ═══════════════════════════════════════════════════════════════════════
    
    // Set this to TRUE for testing, FALSE for production
    $isTestMode = true; // Change to false when you have your real nonprofit slug
    
    // Your nonprofit slug or EIN
    // For testing: Use 'givedirectly' or any existing nonprofit
    // For production: Replace with your actual nonprofit slug
    $everyOrgNonprofitId = $settings['everyorg_nonprofit_id'] ?? 'givedirectly';
    
    // Build the donation URL based on mode
    if ($isTestMode) {
        // TESTING MODE - Uses staging environment with test cards
        $everyOrgUrl = "https://staging.every.org/{$everyOrgNonprofitId}#donate";
        // Test Cards that work:
        // - Card: 4242 4242 4242 4242
        // - Exp: 04/42 (or any future date)
        // - CVC: 242 (or any 3 digits)
        // - Zip: 42424 (or any 5 digits)
    } else {
        // PRODUCTION MODE - Real donations
        $everyOrgUrl = "https://www.every.org/{$everyOrgNonprofitId}#donate";
    }
@endphp


{{-- ══════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════ --}}
<section class="donate-hero min-h-[65vh] flex items-center py-20 md:py-28">
    <div class="relative z-10 max-w-7xl mx-auto px-4 text-center text-white">

        {{-- Floating hearts decoration --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            @foreach([['top-10','left-8','text-2xl','delay-0'],['top-20','right-12','text-lg','delay-700'],['bottom-16','left-20','text-xl','delay-300'],['bottom-8','right-8','text-3xl','delay-1000']] as $h)
            <i class="fas fa-heart absolute opacity-10 float {{ $h[2] }} {{ $h[3] }}"
               style="top:{{ $loop->index * 22 + 5 }}%;{{ $loop->index % 2 === 0 ? 'left' : 'right' }}:{{ $loop->index * 15 + 5 }}%;animation-delay:{{ $loop->index * 0.4 }}s"></i>
            @endforeach
        </div>

        <div class="inline-flex items-center gap-2 bg-orange-500/20 border border-orange-500/30 text-orange-300 text-xs font-bold px-4 py-2 rounded-full mb-6 backdrop-blur-sm">
            <i class="fas fa-heart text-orange-400"></i>
            Make an Impact Today
        </div>

        <h1 class="text-4xl sm:text-5xl md:text-7xl mb-6 leading-tight" style="font-weight:900">
            <span class="shimmer-text">Donate</span> to Change Lives
        </h1>
        <p class="text-base md:text-xl text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">
            Every donation helps provide education, meals, and hope to children in Southeast Asia.
            Choose your amount and make a difference today.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button onclick="document.getElementById('donate-section').scrollIntoView({behavior: 'smooth', block: 'start'})"
                    class="group relative inline-flex items-center gap-3 px-8 py-4 bg-orange-500 hover:bg-orange-400 text-white font-black text-base rounded-2xl transition-all shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:scale-105">
                <div class="relative w-6 h-6 pulse-ring">
                    <i class="fas fa-heart text-white relative z-10"></i>
                </div>
                Donate Now
                <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </button>
        </div>

        {{-- Quick trust stats --}}
        <div class="mt-16 grid grid-cols-3 gap-4 max-w-lg mx-auto">
            @foreach([['95,000+','Children Helped'],['66','Years of Service'],['84%','Goes to Programs']] as $s)
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3">
                <div class="text-xl md:text-2xl font-black text-orange-300">{{ $s[0] }}</div>
                <div class="text-xs text-white/70 font-medium">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     DONATION SECTION
══════════════════════════════════════════════════════ --}}
<section id="donate-section" class="py-16 md:py-24 bg-white">
    <div class="max-w-4xl mx-auto px-4">

        <div class="text-center mb-14 reveal">
            <span class="inline-block bg-orange-100 text-orange-600 text-xs font-bold px-4 py-2 rounded-full mb-4">MAKE A DONATION</span>
            <h2 class="text-3xl md:text-4xl text-gray-900 mb-3" style="font-weight:900">Choose Your Donation Amount</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Select a suggested amount or enter your own. Every dollar makes a direct impact.</p>
        </div>

        {{-- Suggested Amounts (Visual Only - Just for Display) --}}
        <div class="reveal mb-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border-2 border-gray-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-black text-gray-900 mb-1">$25</div>
                    <div class="text-xs text-gray-500">School supplies for 3 kids</div>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-black text-gray-900 mb-1">$50</div>
                    <div class="text-xs text-gray-500">One month of meals</div>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-black text-gray-900 mb-1">$100</div>
                    <div class="text-xs text-gray-500">School fees for one child</div>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-black text-gray-900 mb-1">$250</div>
                    <div class="text-xs text-gray-500">Healthcare & education</div>
                </div>
            </div>

            {{-- Every.org Direct Donate Link --}}
            <div class="reveal bg-gradient-to-br from-orange-50 via-white to-red-50 rounded-3xl shadow-xl p-8 md:p-12 border-2 border-orange-500/20 text-center">
                <div class="max-w-md mx-auto">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-orange-100 mb-6">
                        <i class="fas fa-heart text-orange-500 text-3xl"></i>
                    </div>
                    
                    <h3 class="text-2xl md:text-3xl font-black text-gray-900 mb-3">
                        Ready to Make a Difference?
                    </h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Click below to make your donation through our secure partner, Every.org. Choose any amount you wish.
                    </p>

                    {{-- Simple Donate Button - Direct to Every.org --}}
                    <a href="{{ $everyOrgUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="group inline-flex items-center justify-center gap-3 px-10 py-5 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-400 hover:to-red-400 text-white font-black text-lg rounded-2xl transition-all shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:scale-105 mb-6">
                        <i class="fas fa-heart text-xl"></i>
                        {{ $isTestMode ? 'Test Donate' : 'Donate Now' }}
                        <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                    </a>

                    @if($isTestMode)
                    <div class="mb-4 px-4 py-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                        <p class="text-xs font-bold text-yellow-800 mb-2">🧪 TEST MODE ACTIVE</p>
                        <p class="text-xs text-yellow-700">
                            Use test card: <code class="bg-yellow-100 px-2 py-1 rounded">4242 4242 4242 4242</code><br>
                            Exp: 04/42 • CVC: 242 • Zip: 42424
                        </p>
                    </div>
                    @endif

                    <p class="text-sm text-gray-500 mb-4">
                        You'll be redirected to Every.org's {{ $isTestMode ? 'test' : 'secure' }} donation page
                    </p>

                    {{-- Benefits --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
                        <div class="flex items-start gap-3 bg-white rounded-xl p-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                                <i class="fas fa-shield-check text-green-500"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900 mb-1">100% Secure</div>
                                <div class="text-xs text-gray-500">Bank-level encryption</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-white rounded-xl p-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                <i class="fas fa-receipt text-blue-500"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900 mb-1">Tax Receipt</div>
                                <div class="text-xs text-gray-500">Instant via email</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-white rounded-xl p-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center">
                                <i class="fas fa-heart text-orange-500"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900 mb-1">Direct Impact</div>
                                <div class="text-xs text-gray-500">95% to programs</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Trust Badges --}}
            <div class="mt-8 flex flex-wrap items-center justify-center gap-6 text-sm text-gray-500">
                <div class="flex items-center gap-2">
                    <i class="fas fa-lock text-green-500"></i>
                    <span>Secure Donation</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-shield-alt text-blue-500"></i>
                    <span>Tax Deductible</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-heart text-red-500"></i>
                    <span>100% to Programs</span>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     HOW YOUR DONATION HELPS
══════════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <span class="inline-block bg-orange-100 text-orange-600 text-xs font-bold px-4 py-2 rounded-full mb-4">YOUR IMPACT</span>
            <h2 class="text-3xl md:text-4xl text-gray-900 mb-3" style="font-weight:900">Where Your Donation Goes</h2>
            <p class="text-gray-500 max-w-lg mx-auto">See exactly how your contribution changes lives.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['fas fa-book','Education','School fees, uniforms, supplies, and textbooks for children who wouldn\'t otherwise have access to quality education.','blue'],
                ['fas fa-utensils','Nutrition','Daily nutritious meals and snacks to ensure children have the energy to learn and grow healthy and strong.','green'],
                ['fas fa-heartbeat','Healthcare','Medical check-ups, vaccinations, and emergency healthcare to keep our children healthy and safe.','red'],
            ] as $i => $impact)
            <div class="reveal bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all" style="transition-delay:{{ $i * 0.1 }}s">
                <div class="w-14 h-14 rounded-2xl bg-{{ $impact[3] }}-50 flex items-center justify-center mb-4">
                    <i class="{{ $impact[0] }} text-{{ $impact[3] }}-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">{{ $impact[1] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $impact[2] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Impact Stats --}}
        <div class="mt-12 reveal bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl p-8 md:p-10 text-white">
            <div class="text-center mb-6">
                <h3 class="text-2xl md:text-3xl font-black mb-2">Your Impact in Numbers</h3>
                <p class="text-white/80">See what our donors have made possible</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach([
                    ['12,450','Meals Provided','This Year'],
                    ['385','Children in School','Currently'],
                    ['1,200+','Health Check-ups','This Year'],
                    ['95%','Direct Impact','Of Every Dollar']
                ] as $stat)
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-black mb-1">{{ $stat[0] }}</div>
                    <div class="text-sm font-bold mb-1">{{ $stat[1] }}</div>
                    <div class="text-xs text-white/70">{{ $stat[2] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     FEATURED ARTICLES (from controller)
══════════════════════════════════════════════════════ --}}
@if($featuredArticles->isNotEmpty())
<section class="py-14 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8 reveal">
            <div>
                <h2 class="text-2xl md:text-3xl text-gray-900 mb-1" style="font-weight:900">Impact Stories</h2>
                <div class="h-1 w-12 rounded-full bg-orange-500"></div>
            </div>
            <a href="{{ route('home') }}#news"
               class="text-sm font-bold text-orange-500 hover:text-orange-600 flex items-center gap-1 hover:gap-2 transition-all">
                All Stories <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            @foreach($featuredArticles as $i => $article)
            <a href="{{ route('articles.show', $article->encrypted_slug) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all hover:-translate-y-1 reveal"
               style="transition-delay:{{ $i*0.1 }}s">
                @if($article->image)
                    <div class="overflow-hidden">
                        <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
                             class="w-full h-44 object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                @else
                    <div class="w-full h-44 flex items-center justify-center"
                         style="background:{{ $article->category->color ?? '#f97316' }}12">
                        <i class="{{ $article->category->icon ?? 'fas fa-star' }} text-5xl opacity-20"
                           style="color:{{ $article->category->color ?? '#f97316' }}"></i>
                    </div>
                @endif
                <div class="p-4">
                    <h3 class="text-sm font-bold text-gray-800 line-clamp-2 group-hover:text-orange-500 transition leading-snug">
                        {{ $article->title }}
                    </h3>
                    @if($article->excerpt)
                        <p class="text-xs text-gray-500 mt-1.5 line-clamp-2">{{ Str::limit(strip_tags($article->excerpt), 80) }}</p>
                    @endif
                    <div class="flex items-center gap-1 mt-3 text-orange-500 text-xs font-bold">
                        Read Story <i class="fas fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('layouts.footer')
@include('layouts.navigation')

{{-- ══════════════════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════════════════ --}}
<script>
// ── Scroll reveal ───────────────────────────────────────────────────────
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(el => {
        if (el.isIntersecting) { el.target.classList.add('show'); revealObserver.unobserve(el.target); }
    });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// ── Mobile menu ─────────────────────────────────────────────────────────
const mobileMenu = document.getElementById('mobile-menu'), mobileOverlay = document.getElementById('mobile-menu-overlay');
const openMenu  = () => { mobileMenu?.classList.add('active'); mobileOverlay?.classList.add('active'); document.body.style.overflow='hidden'; };
const closeMenu = () => { mobileMenu?.classList.remove('active'); mobileOverlay?.classList.remove('active'); document.body.style.overflow=''; };
document.getElementById('mobile-menu-btn')?.addEventListener('click', openMenu);
document.getElementById('menu-nav-item')?.addEventListener('click', e => { e.preventDefault(); openMenu(); });
document.getElementById('close-menu')?.addEventListener('click', closeMenu);
mobileOverlay?.addEventListener('click', closeMenu);
document.querySelectorAll('.mobile-menu-link').forEach(l => l.addEventListener('click', closeMenu));

// ── Bottom nav active ───────────────────────────────────────────────────
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function() {
        if (this.id !== 'menu-nav-item') {
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            this.classList.add('active');
        }
    });
});

// ── Smooth scroll ────────────────────────────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', function(e) {
        e.preventDefault();
        const t = document.querySelector(this.getAttribute('href'));
        if (t) window.scrollTo({ top: t.offsetTop - 80, behavior: 'smooth' });
    });
});
</script>

</body>
</html>