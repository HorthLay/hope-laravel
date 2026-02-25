{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ ($settings['site_name'] ?? 'Hope & Impact') }} | {{ ($settings['site_tagline'] ?? 'Changing Children\'s Lives') }}</title>
    <meta name="description" content="{{ $settings['meta_description'] ?? $settings['site_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '' }}">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
    <style>
        /* ── Base animations ──────────────────────────────────────── */
        @keyframes fadeUp    { from { opacity:0; transform:translateY(32px); } to { opacity:1; transform:translateY(0); } }
        @keyframes pulse-soft{ 0%,100%{transform:scale(1);} 50%{transform:scale(1.04);} }
        @keyframes bounce-down{ 0%,100%{transform:translateY(0);} 50%{transform:translateY(6px);} }

        /* ── Scroll-triggered reveal ──────────────────────────────── */
        .reveal       { opacity:0; transform:translateY(28px);   transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1); }
        .reveal-left  { opacity:0; transform:translateX(-36px);  transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1); }
        .reveal-right { opacity:0; transform:translateX(36px);   transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1); }
        .reveal-scale { opacity:0; transform:scale(.93);         transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1); }
        .reveal.visible,.reveal-left.visible,.reveal-right.visible,.reveal-scale.visible { opacity:1; transform:none; }

        /* ── Stagger delays ───────────────────────────────────────── */
        .stagger-1{transition-delay:.05s} .stagger-2{transition-delay:.12s} .stagger-3{transition-delay:.19s}
        .stagger-4{transition-delay:.26s} .stagger-5{transition-delay:.33s} .stagger-6{transition-delay:.40s}

        /* ── Child / Family cards ─────────────────────────────────── */
        .child-card  { transition:transform .28s cubic-bezier(.16,1,.3,1),box-shadow .28s; }
        .child-card:hover  { transform:translateY(-6px); box-shadow:0 24px 48px rgba(0,0,0,.13); }
        .family-card { transition:transform .28s cubic-bezier(.16,1,.3,1),box-shadow .28s; }
        .family-card:hover { transform:translateY(-4px); box-shadow:0 16px 40px rgba(0,0,0,.12); }
        .child-card:hover .heart-pulse { animation:pulse-soft .6s ease infinite; }
        .urgency-badge { animation:pulse-soft 2s ease infinite; }

        /* ── Filter buttons ───────────────────────────────────────── */
        .news-cat-btn,.top-tag-btn { transition:all .18s ease; }
        .news-cat-btn.active-cat-btn,.top-tag-btn.active-tag-btn {
            background:#f97316!important; color:#fff!important;
            border-color:#f97316!important; box-shadow:0 2px 10px rgba(249,115,22,.35);
        }
        .news-card,.top-card { transition:opacity .2s ease; }
        .wave-divider { line-height:0; overflow:hidden; }
        .wave-divider svg { display:block; }

        /* ══════════════════════════════════════════════════════════
           HERO  —  fixed for mobile portrait photos
        ══════════════════════════════════════════════════════════ */
        #hero-section {
            position: relative;
            width: 100%;
            height: 62vh;
            min-height: 380px;
            max-height: 560px;
            overflow: hidden;
            background: #111;
        }
        #hero-video {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center center;
            z-index: 0;
        }
        #hero-fallback {
            position: absolute;
            inset: 0;
            width: 100%; height: 100%;
            object-fit: contain;          /* show full child, not cropped */
            object-position: center top;
            background: #111;
            display: none;
        }
        #hero-overlay {
            position: absolute; inset: 0;
            background:
                linear-gradient(to top,   rgba(0,0,0,.75) 0%, rgba(0,0,0,.10) 40%, transparent 70%),
                linear-gradient(to right, rgba(0,0,0,.30) 0%, transparent 55%);
            z-index: 1;
        }
        #hero-content {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            z-index: 2;
            padding: 0 40px 52px;
            max-width: 640px;
        }
        #hero-content h1 {
            font-size: clamp(1.7rem, 4vw, 3.25rem);
            font-weight: 900; color: #fff;
            line-height: 1.12; margin-bottom: 10px;
            text-shadow: 0 2px 12px rgba(0,0,0,.4);
            animation: fadeUp .9s ease both;
        }
        #hero-content p {
            font-size: clamp(.9rem, 1.5vw, 1.2rem);
            font-weight: 700; color: rgba(255,255,255,.92);
            margin-bottom: 22px;
            text-shadow: 0 1px 6px rgba(0,0,0,.4);
            animation: fadeUp .9s .15s ease both;
        }
        #hero-content a { animation: fadeUp .9s .3s ease both; }
        .hero-sponsor-btn {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 13px 26px;
            background: #f4b630; color: #1a1a1a;
            font-size: 12px; font-weight: 900;
            text-transform: uppercase; letter-spacing: .08em;
            border-radius: 4px; text-decoration: none;
            transition: background .18s, transform .15s;
            box-shadow: 0 4px 16px rgba(0,0,0,.25);
        }
        .hero-sponsor-btn:hover { background: #e6b800; transform: translateY(-2px); color: #1a1a1a; }
        #hero-scroll {
            position: absolute; bottom: 18px; right: 28px; z-index: 2;
            display: flex; flex-direction: column; align-items: center; gap: 5px;
            color: rgba(255,255,255,.55); font-size: 10px; font-weight: 600;
            letter-spacing: .05em; text-transform: uppercase; transition: opacity .3s;
        }
        #hero-scroll i { animation: bounce-down 1.6s ease-in-out infinite; }

        /* ── Mobile hero: full viewport, cover fit, top-biased ─────── */
        @media (max-width: 640px) {
            #hero-section {
                height: 100svh;
                max-height: 100svh;
                min-height: 480px;
            }
            #hero-fallback {
                object-fit: cover;           /* fill the tall mobile frame */
                object-position: center 15%; /* show face + upper body */
            }
            #hero-video { object-position: center 15%; }
            #hero-content { padding: 0 20px 44px; max-width: 100%; }
            #hero-scroll  { display: none; }
        }
    </style>
</head>
<body>

@include('layouts.loading')
@include('layouts.header')

{{-- ═══════ HERO ═══════ --}}
<section id="hero-section">
    <video id="hero-video" autoplay muted loop playsinline preload="auto"
           poster="{{ asset('images/cambodia-bg.jpg') }}">
        <source src="{{ asset('project/videos/video.mp4') }}" type="video/mp4">
    </video>
    <img id="hero-fallback" src="{{ asset('images/cambodia-bg.jpg') }}" alt="Children in Cambodia">
    <div id="hero-overlay"></div>
    <div id="hero-content">
        <h1>Sponsor a child today</h1>
        <p>And change a life with the gift of education</p>
        <a href="{{ route('sponsor.children') }}" class="hero-sponsor-btn">
            <i class="fas fa-child"></i> Sponsor a Child Now
        </a>
    </div>
    <div id="hero-scroll"><i class="fas fa-chevron-down"></i><span>Scroll</span></div>
</section>
<script>
(function(){
    const vid=document.getElementById('hero-video'),img=document.getElementById('hero-fallback');
    if(!vid)return;
    vid.addEventListener('error',()=>{vid.style.display='none';if(img)img.style.display='block';});
    window.addEventListener('scroll',()=>{const h=document.getElementById('hero-scroll');if(h)h.style.opacity=window.scrollY>60?'0':'1';},{passive:true});
})();
</script>

{{-- ═══════ STATS ═══════ --}}
<section class="stats-section">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 reveal">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Impact Since 1958</h2>
            <p class="text-lg opacity-90">Transparency and efficiency in action</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            <div class="text-center reveal stagger-1">
                <div class="stat-number counter" data-target="{{ $stats['total_children'] ?? 0 }}">0</div>
                <p class="text-base md:text-lg font-medium">Children in Program</p>
            </div>
            <div class="text-center reveal stagger-2">
                <div class="stat-number counter" data-target="84">0</div>
                <p class="text-base md:text-lg font-medium">% To Programs</p>
            </div>
            <div class="text-center reveal stagger-3">
                <div class="stat-number counter" data-target="{{ $stats['total_countries'] ?? 0 }}">0</div>
                <p class="text-base md:text-lg font-medium">Countries</p>
            </div>
            <div class="text-center reveal stagger-4">
                <div class="stat-number counter" data-target="{{ $stats['total_articles'] ?? 0 }}">0</div>
                <p class="text-base md:text-lg font-medium">Articles Published</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════ CATEGORY NAV BAR ═══════ --}}
@if($categories->isNotEmpty())
<section class="bg-white border-b border-gray-100 py-3 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-2 overflow-x-auto scrollbar-hide">
            <a href="{{ route('home') }}" class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-bold bg-orange-500 text-white hover:bg-orange-600 transition">All</a>
            @foreach($categories as $cat)
            <a href="{{ route('category.articles', $cat->encrypted_slug) }}"
               class="flex-shrink-0 flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold border-2 transition whitespace-nowrap"
               style="border-color:{{ $cat->color ?? '#f97316' }};color:{{ $cat->color ?? '#f97316' }};"
               onmouseover="this.style.backgroundColor=this.style.borderColor;this.style.color='#fff';"
               onmouseout="this.style.backgroundColor='';this.style.color=this.style.borderColor;">
                @if($cat->icon)<i class="{{ $cat->icon }} text-xs"></i>@endif
                {{ $cat->name }}
                @if($cat->articles_count)<span class="opacity-60">({{ $cat->articles_count }})</span>@endif
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════
     CHILDREN WAITING FOR A SPONSOR
═══════════════════════════════════════════════════════ --}}
@if(isset($unsponsoredChildren) && $unsponsoredChildren->isNotEmpty())
<section class="py-16 md:py-20 bg-gradient-to-br from-orange-50 via-white to-amber-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-72 h-72 bg-orange-100 rounded-full opacity-40 blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-amber-100 rounded-full opacity-40 blur-3xl translate-y-1/2 -translate-x-1/3 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 relative">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">
            <div class="reveal">
                <div class="inline-flex items-center gap-2 bg-orange-100 text-orange-600 text-xs font-black px-4 py-1.5 rounded-full mb-3 border border-orange-200">
                    <span class="urgency-badge inline-block w-2 h-2 rounded-full bg-orange-500"></span>
                    Needs Your Help
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight">
                    Children <span class="text-orange-500">Waiting</span><br>for a Sponsor
                </h2>
                <p class="text-gray-500 mt-2 text-sm max-w-md">Each of these children has no sponsor yet. $30/month changes everything — education, meals, healthcare, hope.</p>
            </div>
            <div class="reveal flex items-center gap-3 flex-shrink-0">
                <div class="text-right hidden md:block">
                    <p class="text-2xl font-black text-orange-500">{{ $unsponsoredChildren->count() }}+</p>
                    <p class="text-xs text-gray-400 font-medium">waiting now</p>
                </div>
                <a href="{{ route('sponsor.children') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-black text-sm rounded-2xl transition shadow-lg shadow-orange-200">
                    <i class="fas fa-child"></i> See All Children <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($unsponsoredChildren as $i => $child)
            @php $cEncId = \Illuminate\Support\Facades\Crypt::encryptString((string)$child->id); @endphp
            <div class="child-card bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col reveal stagger-{{ min($i+1,6) }}">
                <div class="relative overflow-hidden" style="height:160px">
                    <img src="{{ $child->profile_photo ? asset($child->profile_photo) : asset('images/child-placeholder.jpg') }}"
                         alt="{{ $child->first_name }}"
                         class="w-full h-full object-cover object-top">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    @if(!empty($child->gender))
                    <div class="absolute top-2 right-2 w-6 h-6 rounded-full flex items-center justify-center shadow
                        {{ strtolower($child->gender)==='female'?'bg-pink-500':'bg-blue-500' }}">
                        <i class="fas {{ strtolower($child->gender)==='female'?'fa-venus':'fa-mars' }} text-white text-[9px]"></i>
                    </div>
                    @endif
                    <div class="absolute top-2 left-2">
                        <span class="bg-red-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full">No Sponsor</span>
                    </div>
                    <div class="absolute bottom-2 left-2">
                        @if(!empty($child->age) || !empty($child->date_of_birth))
                        <span class="text-white text-[10px] font-bold flex items-center gap-1">
                            <i class="fas fa-birthday-cake text-orange-300 text-[8px]"></i>
                            {{ $child->age ?? \Carbon\Carbon::parse($child->date_of_birth)->age }} yrs
                        </span>
                        @endif
                    </div>
                    <div class="absolute bottom-2 left-2" style="bottom:28px;">
                        @if($child->has_family)
                        <span class="text-white text-[10px] font-bold flex items-center gap-1">
                            <i class="fas fa-home text-green-300 text-[8px]"></i>
                            Has Family
                        </span>
                        @else
                        <span class="text-white text-[10px] font-bold flex items-center gap-1">
                            <i class="fas fa-home text-gray-400 text-[8px]"></i>
                            No Family
                        </span>
                        @endif

                    </div>
                </div>
                <div class="p-3 flex flex-col flex-1">
                    <p class="font-black text-gray-800 text-sm leading-tight truncate">{{ $child->first_name }} {{ $child->last_name ?? '' }}</p>
                    @if(!empty($child->country))
                    <p class="text-[10px] text-gray-400 mt-0.5 flex items-center gap-1 truncate">
                        <i class="fas fa-map-marker-alt text-orange-300 text-[8px]"></i> {{ $child->country }}
                    </p>
                    @endif
                    <div class="mt-auto pt-2 grid grid-cols-2 gap-1">
                        <a href="{{ route('children.show', $cEncId) }}"
                           class="flex items-center justify-center py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-[10px] font-bold rounded-lg transition">
                            <i class="fas fa-eye text-[8px] mr-1"></i> Story
                        </a>
                        <a href="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1"
                           class="flex items-center justify-center py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-[10px] font-bold rounded-lg transition">
                            <i class="fas fa-heart heart-pulse text-[8px] mr-1"></i> Sponsor
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10 text-center reveal">
            <div class="inline-block bg-white rounded-3xl border border-orange-100 shadow-sm px-8 py-6">
                <p class="text-gray-700 font-bold mb-1">Ready to make a difference?</p>
                <p class="text-gray-400 text-sm mb-4">For just <span class="text-orange-500 font-black">$1 a day</span> you give a child education, meals & hope.</p>
                <a href="{{ route('sponsor.children') }}"
                   class="inline-flex items-center gap-3 px-8 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-black rounded-2xl transition shadow-md shadow-orange-200">
                    <i class="fas fa-heart"></i> Sponsor a Child Now — $30/month
                </a>
            </div>
        </div>
    </div>
</section>
<div class="wave-divider bg-white">
    <svg viewBox="0 0 1440 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,20 C360,40 1080,0 1440,20 L1440,0 L0,0 Z" fill="#fff7ed"/>
    </svg>
</div>
@endif

{{-- ═══════════════════════════════════════════════════════
     FAMILIES WITHOUT A SPONSOR
═══════════════════════════════════════════════════════ --}}
@if(isset($unsponsoredFamilies) && $unsponsoredFamilies->isNotEmpty())
<section class="py-16 md:py-20 bg-white relative overflow-hidden">
    <div class="absolute top-1/2 right-0 w-80 h-80 bg-amber-50 rounded-full opacity-60 blur-3xl translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 relative">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">
            <div class="reveal">
                <div class="inline-flex items-center gap-2 bg-amber-100 text-amber-700 text-xs font-black px-4 py-1.5 rounded-full mb-3 border border-amber-200">
                    <i class="fas fa-home text-[10px]"></i> Family Support
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight">
                    Families <span class="text-amber-500">Without</span><br>a Sponsor
                </h2>
                <p class="text-gray-500 mt-2 text-sm max-w-md">Support an entire household — parents, children, grandparents — with a single monthly gift.</p>
            </div>
            <a href="{{ route('sponsor.children') }}?tab=families"
               class="reveal inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-black text-sm rounded-2xl transition shadow-lg shadow-amber-200 flex-shrink-0 self-start md:self-auto">
                <i class="fas fa-users"></i> See All Families <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($unsponsoredFamilies as $i => $family)
            @php $fEncId = \Illuminate\Support\Facades\Crypt::encryptString((string)$family->id); @endphp
            <div class="family-card bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col reveal stagger-{{ min($i+1,4) }}">
                <div class="relative overflow-hidden" style="height:180px">
                    @if(!empty($family->profile_photo))
                    <img src="{{ asset($family->profile_photo) }}" alt="{{ $family->name }}"
                         class="w-full h-full object-cover object-top">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center">
                        <i class="fas fa-users text-5xl text-amber-300"></i>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute top-3 left-3">
                        <span class="bg-amber-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full">No Sponsor</span>
                    </div>
                    <div class="absolute bottom-3 left-3 flex items-center gap-1.5 flex-wrap">
                        <span class="flex items-center gap-1 bg-black/60 text-white text-[10px] font-bold px-2 py-1 rounded-full backdrop-blur-sm">
                            <i class="fas fa-users text-amber-300 text-[8px]"></i> {{ $family->members_count ?? '?' }} members
                        </span>
                        @if(!empty($family->country))
                        <span class="flex items-center gap-1 bg-black/60 text-white text-[10px] font-bold px-2 py-1 rounded-full backdrop-blur-sm">
                            <i class="fas fa-map-marker-alt text-amber-300 text-[8px]"></i> {{ $family->country }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-black text-gray-800 text-sm leading-tight mb-1">{{ $family->name ?? 'Family #'.$family->id }}</h3>
                    @if(!empty($family->story))
                    <p class="text-[11px] text-gray-500 leading-relaxed line-clamp-2 flex-1 mb-3">{{ Str::limit(strip_tags($family->story), 80) }}</p>
                    @else
                    <div class="flex-1 mb-3"></div>
                    @endif
                    <div class="grid grid-cols-2 gap-2 mt-auto">
                        <a href="{{ route('families.show', $fEncId) }}"
                           class="flex items-center justify-center gap-1 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-[10px] font-bold rounded-xl transition">
                            <i class="fas fa-eye text-[9px]"></i> View
                        </a>
                        <a href="{{ route('sponsor.family', $fEncId) }}"
                           class="flex items-center justify-center gap-1 py-2 bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-bold rounded-xl transition">
                            <i class="fas fa-hands-helping text-[9px]"></i> Sponsor
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════ WHY CHOOSE US ═══════ --}}
<section class="section bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-8 md:mb-12 reveal">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Why Choose Us</h2>
            <p class="text-base md:text-lg text-gray-600 max-w-3xl mx-auto">Trusted by thousands of donors worldwide for our transparency and commitment</p>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach([
                ['icon'=>'fas fa-shield-alt','bg'=>'orange','label'=>'100% Transparent','desc'=>'Full accountability on how your donations are used'],
                ['icon'=>'fas fa-certificate','bg'=>'blue','label'=>'Certified NGO','desc'=>'Internationally recognized and accredited organization'],
                ['icon'=>'fas fa-hand-holding-heart','bg'=>'green','label'=>'Direct Impact','desc'=>'Your support directly reaches children in need'],
                ['icon'=>'fas fa-users','bg'=>'purple','label'=>'Strong Network','desc'=>'1000+ local volunteers ensuring quality programs'],
            ] as $i => $h)
            <div class="bg-white rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all reveal text-center stagger-{{ $i+1 }}">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-{{ $h['bg'] }}-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <i class="{{ $h['icon'] }} text-{{ $h['bg'] }}-600 text-xl md:text-3xl"></i>
                </div>
                <h3 class="text-sm md:text-lg font-bold text-gray-800 mb-2">{{ $h['label'] }}</h3>
                <p class="text-xs md:text-sm text-gray-600">{{ $h['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 mt-4 md:mt-6">
            @foreach([
                ['bg'=>'orange','icon'=>'fas fa-envelope','label'=>'Monthly Updates','desc'=>'Receive letters and photos from your sponsored child'],
                ['bg'=>'blue','icon'=>'fas fa-globe','label'=>'Global Reach','desc'=>'Operating in 7 countries across Southeast Asia'],
                ['bg'=>'green','icon'=>'fas fa-heart','label'=>'Long-term Support','desc'=>"Follow children's progress throughout their education",'span'=>true],
            ] as $i => $e)
            <div class="bg-gradient-to-br from-{{ $e['bg'] }}-50 to-{{ $e['bg'] }}-100 rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all reveal {{ isset($e['span'])?'col-span-2 md:col-span-1':'' }} stagger-{{ $i+1 }}">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-{{ $e['bg'] }}-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="{{ $e['icon'] }} text-white text-sm md:text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm md:text-base font-bold text-gray-800 mb-1">{{ $e['label'] }}</h4>
                        <p class="text-xs md:text-sm text-gray-600">{{ $e['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ OUR WORK ═══════ --}}
<section id="our-work" class="section bg-white py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 md:mb-12 reveal">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">What We Do</h2>
            <div class="w-20 h-1 bg-orange-500 rounded-full green-line"></div>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            @foreach([
                ['img'=>'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600','overlay'=>'1958','title'=>'66 years of experience','desc'=>"Since 1958, we've been transforming children's lives through a network of over 1,000 local volunteers."],
                ['img'=>'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=600','overlay'=>'MISSION','title'=>'Education and Support','desc'=>'We educate and train young people to improve their living conditions and build themselves intellectually.'],
                ['img'=>'https://images.unsplash.com/photo-1544027993-37dbfe43562a?w=600','overlay'=>'84%','title'=>'Impact of Donations','desc'=>'84% of funds raised go directly to our education programs. Over 95,000 children benefit from our work every year.'],
                ['img'=>'https://images.unsplash.com/photo-1497486751825-1233686d5d80?w=600','overlay'=>'IDEAS','title'=>'IDEAS Label 2024','desc'=>"We've been awarded the IDEAS label for good governance, transparency, and monitoring the effectiveness of our actions."],
            ] as $i => $card)
            <div class="card reveal bg-white rounded-xl shadow-lg overflow-hidden stagger-{{ $i+1 }}">
                <div class="relative">
                    <img src="{{ $card['img'] }}" alt="{{ $card['title'] }}" class="w-full h-64 object-cover">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                        <h3 class="text-5xl md:text-6xl font-black text-white text-center px-2">{{ $card['overlay'] }}</h3>
                    </div>
                </div>
                <div class="p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-3">{{ $card['title'] }}</h4>
                    <p class="text-sm text-gray-600 mb-6">{{ $card['desc'] }}</p>
                    <a href="{{ route('learn-more') }}" class="inline-block px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold text-sm rounded transition">LEARN MORE</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ LATEST NEWS ═══════ --}}
<section id="news" class="section bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-3 reveal">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">News And Updates</h2>
            <div class="green-line"></div>
        </div>
        @if($categories->isNotEmpty())
        <div class="flex flex-wrap items-center gap-2 mb-7 reveal" id="news-cat-filters">
            <button type="button" onclick="filterNewsCat('all', this)"
                    class="news-cat-btn active-cat-btn px-3 py-1.5 rounded-full text-xs font-bold bg-orange-500 text-white">
                <i class="fas fa-border-all text-[10px] mr-0.5"></i> All
            </button>
            @foreach($categories as $cat)
            <button type="button" onclick="filterNewsCat({{ $cat->id }}, this)"
                    class="news-cat-btn px-3 py-1.5 rounded-full text-xs font-bold border-2 whitespace-nowrap"
                    data-cat-id="{{ $cat->id }}"
                    style="border-color:{{ $cat->color ?? '#f97316' }};color:{{ $cat->color ?? '#f97316' }};">
                @if($cat->icon)<i class="{{ $cat->icon }} text-xs mr-0.5"></i>@endif
                {{ $cat->name }}
                @if($cat->articles_count)<span class="opacity-60">({{ $cat->articles_count }})</span>@endif
            </button>
            @endforeach
        </div>
        @endif
        @if($articles->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5" id="news-grid">
            <div class="md:col-span-2 lg:row-span-2 reveal news-card" data-cat-id="{{ $articles->first()->category_id }}">
                @include('articles.styles.home.featured', ['article' => $articles->first()])
            </div>
            @foreach($articles->skip(1) as $article)
            @php $st = in_array($article->style, ['overlay','card','magazine','featured','minimal']) ? $article->style : 'overlay'; @endphp
            <div class="reveal news-card stagger-{{ ($loop->index % 3)+1 }}" data-cat-id="{{ $article->category_id }}">
                @include('articles.styles.home.' . $st, ['article' => $article])
            </div>
            @endforeach
        </div>
        <div id="news-no-results" class="hidden py-12 text-center">
            <i class="fas fa-folder-open text-3xl text-orange-200 block mb-3"></i>
            <p class="text-gray-500 text-sm font-medium">No articles in this category yet.</p>
            <button type="button" onclick="filterNewsCat('all', document.querySelector('.news-cat-btn'))"
                    class="mt-3 text-xs font-bold text-orange-500 hover:underline">Show all</button>
        </div>
        @if($categories->isNotEmpty())
        <div class="text-center mt-8 reveal">
            <a href="{{ route('category.articles', $categories->first()->encrypted_slug) }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-full transition shadow-md">
                <i class="fas fa-newspaper"></i> View All Articles <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @endif
        @endif
    </div>
</section>

{{-- ═══════ PER-CATEGORY SECTIONS ═══════ --}}
@foreach($categories->take(3) as $cat)
@if(isset($categoryArticles[$cat->id]) && $categoryArticles[$cat->id]->isNotEmpty())
<section class="section {{ $loop->even ? 'bg-white' : 'bg-gray-50' }}">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-7 reveal">
            <div>
                <div class="flex items-center gap-3 mb-1.5">
                    @if($cat->icon)
                    <div class="w-9 h-9 rounded-full flex items-center justify-center" style="background:{{ $cat->color ?? '#f97316' }}22">
                        <i class="{{ $cat->icon }}" style="color:{{ $cat->color ?? '#f97316' }}"></i>
                    </div>
                    @endif
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $cat->name }}</h2>
                </div>
                <div class="h-1 w-14 rounded-full" style="background:{{ $cat->color ?? '#f97316' }}"></div>
            </div>
            <a href="{{ route('category.articles', $cat->encrypted_slug) }}"
               class="flex-shrink-0 text-sm font-semibold flex items-center gap-1 hover:gap-2 transition-all"
               style="color:{{ $cat->color ?? '#f97316' }}">
                See All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
            @foreach($categoryArticles[$cat->id] as $article)
            @php $st = in_array($article->style, ['overlay','card','magazine','featured','minimal']) ? $article->style : 'card'; @endphp
            <div class="reveal stagger-{{ $loop->index+1 }}">
                @include('articles.styles.home.' . $st, ['article' => $article])
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endforeach

{{-- ═══════ TOP ARTICLES ═══════ --}}
@if($articles->isNotEmpty())
@php $topTags = $articles->sortByDesc('views_count')->take(6)->flatMap(fn($a) => $a->tags ?? collect())->unique('id')->values(); @endphp
<section class="section bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="mb-3 reveal">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Most Read Stories</h2>
            <div class="green-line"></div>
        </div>
        @if($topTags->isNotEmpty())
        <div class="flex flex-wrap items-center gap-2 mb-7 reveal" id="top-tag-filters">
            <button type="button" onclick="filterTopTag('all', this)"
                    class="top-tag-btn active-tag-btn px-3 py-1.5 rounded-full text-xs font-bold bg-orange-500 text-white">
                <i class="fas fa-border-all text-[10px] mr-0.5"></i> All
            </button>
            @foreach($topTags as $tag)
            <button type="button" onclick="filterTopTag({{ $tag->id }}, this)"
                    class="top-tag-btn px-3 py-1.5 rounded-full text-xs font-bold border"
                    data-tag-id="{{ $tag->id }}" style="{{ $tag->badge_style }};border-color:currentColor;">
                {{ $tag->name }}
            </button>
            @endforeach
        </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="top-grid">
            @foreach($articles->sortByDesc('views_count')->take(6) as $i => $article)
            <div class="top-card flex gap-3 p-3 bg-gray-50 rounded-xl hover:shadow-md transition group reveal stagger-{{ ($i % 3)+1 }}"
                 data-tag-ids="{{ $article->tags->pluck('id')->join(',') }}">
                <div class="flex-shrink-0 w-9 h-9 rounded-full flex items-center justify-center font-black text-base
                    {{ $i===0?'bg-orange-500 text-white':($i===1?'bg-orange-200 text-orange-700':'bg-gray-200 text-gray-600') }}">
                    {{ $i + 1 }}
                </div>
                <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                    @if($article->image)
                    <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    @else
                    <div class="w-full h-full flex items-center justify-center" style="background:{{ $article->category->color ?? '#f97316' }}15">
                        <i class="{{ $article->category->icon ?? 'fas fa-newspaper' }} text-xl opacity-30" style="color:{{ $article->category->color ?? '#f97316' }}"></i>
                    </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    @if($article->category)
                    <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                       class="text-[10px] font-semibold hover:underline block" style="color:{{ $article->category->color ?? '#f97316' }}">
                        {{ $article->category->name }}
                    </a>
                    @endif
                    <h4 class="text-xs font-bold text-gray-800 line-clamp-2 mt-0.5 group-hover:text-orange-500 transition">
                        <a href="{{ route('articles.show', $article->encrypted_slug) }}">{{ $article->title }}</a>
                    </h4>
                    <p class="text-[10px] text-gray-500 mt-1"><i class="fas fa-eye mr-0.5"></i>{{ number_format($article->views_count) }} views</p>
                </div>
            </div>
            @endforeach
        </div>
        <div id="top-no-results" class="hidden py-12 text-center">
            <i class="fas fa-tag text-2xl text-orange-200 block mb-3"></i>
            <p class="text-gray-500 text-sm">No articles found for this tag.</p>
        </div>
    </div>
</section>
@endif

{{-- ═══════ SUCCESS STORY ═══════ --}}
@if(isset($successStory) && $successStory)
<section class="section bg-gradient-to-br from-orange-50 to-orange-100">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
            <div class="img-hover rounded-2xl overflow-hidden shadow-xl reveal-left">
                @if($successStory->image)
                <img src="{{ $successStory->image->url }}" alt="{{ $successStory->title }}" class="w-full h-64 md:h-full object-cover">
                @else
                <div class="w-full h-64 md:h-96 flex items-center justify-center bg-orange-100">
                    <i class="fas fa-star text-8xl text-orange-200"></i>
                </div>
                @endif
            </div>
            <div class="reveal-right">
                <span class="inline-block bg-orange-500 text-white text-xs font-semibold px-4 py-2 rounded-full mb-4">SUCCESS STORY</span>
                @if($successStory->category)
                <a href="{{ route('category.articles', $successStory->category->encrypted_slug) }}"
                   class="block text-sm font-semibold mb-2 hover:underline" style="color:{{ $successStory->category->color ?? '#f97316' }}">
                    @if($successStory->category->icon)<i class="{{ $successStory->category->icon }} mr-1"></i>@endif {{ $successStory->category->name }}
                </a>
                @endif
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4">{{ $successStory->title }}</h2>
                <p class="text-base md:text-lg text-gray-700 mb-6 leading-relaxed">
                    {{ Str::limit(strip_tags($successStory->excerpt ?? $successStory->content ?? ''), 220) }}
                </p>
                <a href="{{ route('articles.show', $successStory->encrypted_slug) }}" class="btn-primary">Read Full Story</a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ═══════ VIDEOS ═══════ --}}
@if(isset($videoArticles) && $videoArticles->isNotEmpty())
<section id="videos" class="section bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 md:mb-10 reveal">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Watch Our Impact Stories</h2>
            <div class="green-line"></div>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($videoArticles as $article)
            <div class="group reveal stagger-{{ $loop->index+1 }}">
                <div class="relative overflow-hidden rounded-xl shadow-lg mb-4 aspect-video">
                    <iframe class="w-full h-full" src="{{ $article->embed_url }}" title="{{ $article->title }}"
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <h4 class="font-bold text-gray-800 mb-1 group-hover:text-orange-500 transition leading-snug">
                    <a href="{{ route('articles.show', $article->encrypted_slug) }}">{{ $article->title }}</a>
                </h4>
                @if($article->excerpt)
                <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit(strip_tags($article->excerpt), 100) }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════ SPONSOR CTA ═══════ --}}
@php $topArticle = $articles->sortByDesc('views_count')->first(); @endphp
<section class="section bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 reveal">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Sponsor a Child Today and Change a Life!</h2>
            <div class="green-line"></div>
        </div>
        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
            <div class="reveal-left">
                <p class="text-base md:text-lg text-gray-700 mb-4 leading-relaxed">
                    Access to school can be a real challenge for poor children in Southeast Asia.
                    <span class="font-bold text-gray-900">Sponsoring a child is a simple and efficient way to help a child go to school.</span>
                </p>
                <p class="text-base md:text-lg text-gray-700 mb-6 leading-relaxed">
                    With your financial support, we will help <span class="font-bold text-gray-900">your sponsored child continue his/her education</span> without fear of dropping out.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('sponsor.children') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded transition shadow-md">
                        <i class="fas fa-child text-2xl"></i> SPONSOR A CHILD TODAY!
                    </a>
                    @if($topArticle)
                    <a href="{{ route('articles.show', $topArticle->encrypted_slug) }}"
                       class="inline-flex items-center gap-2 px-6 py-4 border-2 border-orange-400 text-orange-600 hover:bg-orange-50 font-bold rounded transition">
                        <i class="fas fa-book-open"></i> Read Top Story
                    </a>
                    @endif
                </div>
            </div>
            @if($topArticle)
            <div class="reveal-right">
                <a href="{{ route('articles.show', $topArticle->encrypted_slug) }}"
                   class="group relative block rounded-2xl overflow-hidden shadow-2xl">
                    @if($topArticle->image)
                    <img src="{{ $topArticle->image->url }}" alt="{{ $topArticle->title }}"
                         class="w-full h-72 md:h-80 object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                    <div class="w-full h-72 md:h-80 flex items-center justify-center bg-orange-50">
                        <i class="fas fa-newspaper text-8xl text-orange-200"></i>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-orange-500 text-white text-xs font-black px-3 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-fire text-[10px]"></i> #1 Most Read
                        </span>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <h3 class="text-base md:text-xl font-black text-white mb-2 line-clamp-2 group-hover:text-orange-300 transition">{{ $topArticle->title }}</h3>
                        <span class="inline-flex items-center gap-1 text-white text-xs font-bold group-hover:text-orange-300 transition">
                            Read Story <i class="fas fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                        </span>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>


@include('layouts.footer')
@include('layouts.navigation')
@include('layouts.ads')

<script>
// ── Loader + popup ──────────────────────────────────────────────────────
window.addEventListener('load',()=>{
    setTimeout(()=>{
        document.getElementById('loader')?.classList.add('hidden');
        setTimeout(()=>document.getElementById('popup-modal')?.classList.add('active'),3000);
    },1000);
});
const popup=document.getElementById('popup-modal');
document.getElementById('close-popup')?.addEventListener('click',()=>popup?.classList.remove('active'));
document.getElementById('remind-later')?.addEventListener('click',()=>popup?.classList.remove('active'));
popup?.addEventListener('click',(e)=>{if(e.target===popup)popup.classList.remove('active');});

// ── Mobile nav ──────────────────────────────────────────────────────────
const mobileMenu=document.getElementById('mobile-menu'),mobileMenuOverlay=document.getElementById('mobile-menu-overlay');
const openMenu=()=>{mobileMenu?.classList.add('active');mobileMenuOverlay?.classList.add('active');document.body.style.overflow='hidden';};
const closeMenu=()=>{mobileMenu?.classList.remove('active');mobileMenuOverlay?.classList.remove('active');document.body.style.overflow='';};
document.getElementById('mobile-menu-btn')?.addEventListener('click',openMenu);
document.getElementById('menu-nav-item')?.addEventListener('click',(e)=>{e.preventDefault();openMenu();});
document.getElementById('close-menu')?.addEventListener('click',closeMenu);
mobileMenuOverlay?.addEventListener('click',closeMenu);
document.querySelectorAll('.mobile-menu-link').forEach(l=>l.addEventListener('click',closeMenu));
document.querySelectorAll('.nav-item').forEach(item=>{
    item.addEventListener('click',function(){
        if(this.id!=='menu-nav-item'){
            document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active'));
            this.classList.add('active');
        }
    });
});
document.querySelectorAll('a[href^="#"]').forEach(a=>{
    a.addEventListener('click',function(e){
        e.preventDefault();
        const t=document.querySelector(this.getAttribute('href'));
        if(t)window.scrollTo({top:t.offsetTop-(window.innerWidth<768?70:80),behavior:'smooth'});
    });
});

// ── Scroll-reveal (IntersectionObserver) ───────────────────────────────
const revealObs=new IntersectionObserver((entries)=>{
    entries.forEach(e=>{
        if(e.isIntersecting){ e.target.classList.add('visible'); revealObs.unobserve(e.target); }
    });
},{threshold:0.08,rootMargin:'0px 0px -50px 0px'});
document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale,.scroll-animate').forEach(el=>{
    if(!el.classList.contains('reveal')&&!el.classList.contains('reveal-left')&&
       !el.classList.contains('reveal-right')&&!el.classList.contains('reveal-scale')){
        el.classList.add('reveal');
    }
    revealObs.observe(el);
});

// ── Counter animation ───────────────────────────────────────────────────
document.querySelectorAll('.counter').forEach(el=>{
    const obs=new IntersectionObserver((entries)=>{
        entries.forEach(entry=>{
            if(!entry.isIntersecting)return;
            const target=+el.getAttribute('data-target'),step=Math.max(1,Math.ceil(target/200));
            let cur=0;
            const tick=()=>{cur=Math.min(cur+step,target);el.innerText=cur.toLocaleString();if(cur<target)setTimeout(tick,5);};
            tick(); obs.unobserve(el);
        });
    },{threshold:0.5});
    obs.observe(el);
});

// ── Progress bars ───────────────────────────────────────────────────────
document.querySelectorAll('.progress-fill').forEach(el=>{
    const obs=new IntersectionObserver((entries)=>{
        entries.forEach(entry=>{
            if(!entry.isIntersecting)return;
            setTimeout(()=>entry.target.style.width=entry.target.getAttribute('data-progress')+'%',200);
            obs.unobserve(entry.target);
        });
    },{threshold:0.5});
    obs.observe(el);
});

// ── Category filter — Latest News ───────────────────────────────────────
function filterNewsCat(catId, btn) {
    document.querySelectorAll('.news-cat-btn').forEach(b=>{
        b.classList.remove('active-cat-btn');
        b.style.backgroundColor='';
        b.style.color=b.dataset.catId?(b.style.borderColor||'#f97316'):'';
        b.classList.add('opacity-60');
    });
    btn.classList.add('active-cat-btn'); btn.style.backgroundColor='#f97316'; btn.style.color='#fff';
    btn.classList.remove('opacity-60');
    const cards=document.querySelectorAll('.news-card');
    let shown=0;
    const hero=document.querySelector('#news-grid .news-card:first-child');
    cards.forEach(card=>{
        const match=catId==='all'||card.dataset.catId==catId;
        card.style.display=match?'':'none';
        if(match)shown++;
    });
    if(hero){hero.classList.toggle('md:col-span-2',catId==='all');hero.classList.toggle('lg:row-span-2',catId==='all');}
    document.getElementById('news-no-results').classList.toggle('hidden',shown>0);
    document.getElementById('news-grid')?.classList.toggle('hidden',shown===0);
}

// ── Tag filter — Most Read ──────────────────────────────────────────────
function filterTopTag(tagId, btn) {
    document.querySelectorAll('.top-tag-btn').forEach(b=>{b.classList.remove('active-tag-btn');b.classList.add('opacity-60');});
    btn.classList.add('active-tag-btn'); btn.classList.remove('opacity-60');
    const cards=document.querySelectorAll('.top-card');
    let shown=0;
    cards.forEach(card=>{
        const ids=card.dataset.tagIds?card.dataset.tagIds.split(',').map(Number):[];
        const match=tagId==='all'||ids.includes(Number(tagId));
        card.style.display=match?'':'none';
        if(match)shown++;
    });
    document.getElementById('top-no-results').classList.toggle('hidden',shown>0);
    document.getElementById('top-grid')?.classList.toggle('hidden',shown===0);
}
</script>
</body>
</html>