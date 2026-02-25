{{-- resources/views/sponsor/families-show.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $family->name ?? 'Family' }} | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
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
        body { font-family: 'Montserrat', sans-serif; }
        .fade-in { animation: fadeIn .5s ease; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .photo-hero { position: relative; height: 360px; overflow: hidden; }
        @media(max-width:640px) { .photo-hero { height: 240px; } }
        .sticky-cta { position: sticky; top: 16px; }
        .member-card { transition: box-shadow .2s, transform .2s; }
        .member-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.10); }
    </style>
</head>
<body class="bg-gray-50">

@include('layouts.header')

{{-- ── BREADCRUMB ── --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ route('home') }}" class="hover:text-amber-500 transition">Home</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <a href="{{ route('sponsor.children') }}?tab=families" class="hover:text-amber-500 transition">Sponsor a Family</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-gray-700 font-semibold">{{ $family->name ?? 'Family' }}</span>
    </div>
</div>

@php $fEncId = \Illuminate\Support\Facades\Crypt::encryptString((string)$family->id); @endphp

<div class="max-w-6xl mx-auto px-4 py-8 fade-in">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ══ LEFT ══ --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- PHOTO HERO --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
                <div class="photo-hero">
                    @if(!empty($family->profile_photo))
                        <img src="{{ asset($family->profile_photo) }}" alt="{{ $family->name }}"
                             class="w-full h-full object-cover object-top">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-amber-100 via-orange-50 to-yellow-100 flex items-center justify-center">
                            <i class="fas fa-users text-8xl text-amber-200"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                    {{-- Status badge --}}
                    <div class="absolute top-4 right-4">
                        @if($family->is_sponsored)
                        <span class="flex items-center gap-1.5 bg-green-500 text-white text-xs font-black px-3 py-1.5 rounded-full shadow">
                            <i class="fas fa-check-circle text-[10px]"></i> Sponsored
                        </span>
                        @else
                        <span class="flex items-center gap-1.5 bg-orange-500 text-white text-xs font-black px-3 py-1.5 rounded-full shadow">
                            <i class="fas fa-clock text-[10px]"></i> Waiting
                        </span>
                        @endif
                    </div>

                    {{-- Name overlay --}}
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h1 class="text-3xl md:text-4xl font-black text-white leading-tight mb-2">
                            {{ $family->name ?? 'The Family' }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-2">
                            @if(!empty($family->code))
                            <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full font-mono">
                                {{ $family->code }}
                            </span>
                            @endif
                            @if(!empty($family->country))
                            <span class="flex items-center gap-1.5 bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full">
                                <i class="fas fa-map-marker-alt text-amber-300 text-[10px]"></i>
                                {{ $family->country }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Quick stats --}}
                <div class="grid grid-cols-2 divide-x divide-gray-100 border-t border-gray-100">
                    <div class="py-4 text-center">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Members</p>
                        <p class="font-black text-gray-800 text-lg">{{ $family->members_count ?? $family->members->count() }}</p>
                    </div>
                    <div class="py-4 text-center">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Status</p>
                        @if($family->is_sponsored)
                        <span class="inline-flex items-center gap-1 text-green-600 font-black text-sm">
                            <i class="fas fa-check-circle text-xs"></i> Sponsored
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 text-amber-500 font-black text-sm">
                            <i class="fas fa-clock text-xs"></i> Waiting
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- FAMILY STORY --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 flex items-center justify-center">
                        <i class="fas fa-book-open text-amber-500"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-gray-800">Our Story</h2>
                        <p class="text-xs text-gray-400">About {{ $family->name ?? 'the family' }}</p>
                    </div>
                </div>
                <div class="text-gray-600 leading-relaxed text-sm">
                    @if(!empty($family->story))
                        {!! nl2br(e($family->story)) !!}
                    @else
                        <p class="text-gray-400 italic">This family's story will be shared soon. Your support can help write a brighter chapter for every member.</p>
                    @endif
                </div>
            </div>

            {{-- FAMILY MEMBERS --}}
            @if($family->members && $family->members->count())
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-users text-blue-500"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-gray-800">Family Members</h2>
                        <p class="text-xs text-gray-400">{{ $family->members->count() }} people in this household</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($family->members as $member)
                    <div class="member-card bg-gray-50 rounded-2xl p-4 flex items-center gap-3 border border-gray-100">
                        {{-- Avatar --}}
                        @if(!empty($member->profile_photo))
                        <img src="{{ asset($member->profile_photo) }}" alt="{{ $member->name }}"
                             class="w-14 h-14 rounded-xl object-cover flex-shrink-0 border border-gray-200">
                        @else
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0
                            {{ strtolower($member->gender ?? '') === 'female' ? 'bg-pink-100' : 'bg-blue-100' }}">
                            <i class="fas fa-user {{ strtolower($member->gender ?? '') === 'female' ? 'text-pink-400' : 'text-blue-400' }} text-lg"></i>
                        </div>
                        @endif

                        {{-- Info --}}
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="font-black text-gray-800 text-sm">{{ $member->name }}</p>
                                @if(!empty($member->gender))
                                <span class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0
                                    {{ strtolower($member->gender) === 'female' ? 'bg-pink-100' : 'bg-blue-100' }}">
                                    <i class="fas {{ strtolower($member->gender) === 'female' ? 'fa-venus text-pink-400' : 'fa-mars text-blue-400' }} text-[9px]"></i>
                                </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 mt-1 flex-wrap">
                                @if(!empty($member->relationship))
                                <span class="text-[10px] bg-amber-50 text-amber-600 font-bold px-2 py-0.5 rounded-full border border-amber-100">
                                    {{ $member->relationship }}
                                </span>
                                @endif
                                @if(!empty($member->age))
                                <span class="text-[10px] text-gray-400 font-medium">{{ $member->age }} yrs</span>
                                @endif
                            </div>
                            @if(!empty($member->occupation))
                            <p class="text-[10px] text-gray-400 mt-1 flex items-center gap-1 truncate">
                                <i class="fas fa-briefcase text-[8px]"></i> {{ $member->occupation }}
                            </p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
        {{-- /LEFT --}}

        {{-- ══ RIGHT SIDEBAR ══ --}}
        <div class="w-full lg:w-80 flex-shrink-0">
            <div class="sticky-cta space-y-4">

                {{-- SPONSOR CARD --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                    <div class="text-center mb-4">
                        <span class="inline-flex items-center gap-2 bg-amber-50 text-amber-600 text-xs font-black px-3 py-1.5 rounded-full border border-amber-100 mb-3">
                            <i class="fas fa-home animate-pulse"></i> Family Sponsorship
                        </span>
                        <h3 class="text-xl font-black text-gray-800">Sponsor {{ $family->name ?? 'This Family' }}</h3>
                        <p class="text-sm text-gray-400 mt-1">Support the entire household</p>
                    </div>

                    <div class="bg-amber-50 rounded-2xl p-4 mb-4 text-center border border-amber-100">
                        <p class="text-4xl font-black text-amber-500">$50</p>
                        <p class="text-xs text-gray-500 font-medium">per month · whole family</p>
                    </div>

                    <ul class="space-y-2.5 mb-5">
                        @foreach(['Food & nutrition for all members','Education support','Healthcare & medical access','Economic empowerment','Regular visits & reports'] as $b)
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-500 text-[9px]"></i>
                            </div>
                            {{ $b }}
                        </li>
                        @endforeach
                    </ul>

                    <a href="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1"
                       class="block w-full py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-black text-center rounded-2xl transition shadow-md shadow-amber-200 text-base">
                        <i class="fas fa-hands-helping mr-2"></i> Sponsor {{ $family->name ?? 'This Family' }}
                    </a>
                    <p class="text-center text-[10px] text-gray-400 mt-3">
                        <i class="fas fa-lock mr-1"></i> Secure & safe donation process
                    </p>
                </div>

                {{-- BACK --}}
                <a href="{{ route('sponsor.children') }}?tab=families"
                   class="flex items-center justify-center gap-2 py-3 bg-white hover:bg-gray-50 border border-gray-200 text-gray-600 font-bold text-sm rounded-2xl transition w-full">
                    <i class="fas fa-arrow-left text-xs"></i> Back to All Families
                </a>

            </div>
        </div>

    </div>
</div>

{{-- BOTTOM CTA --}}
<section class="bg-gradient-to-br from-amber-500 to-orange-500 py-14 mt-8">
    <div class="max-w-3xl mx-auto px-4 text-center text-white">
        <h2 class="text-2xl md:text-3xl font-black mb-3">Help {{ $family->name ?? 'This Family' }} Thrive</h2>
        <p class="text-white/90 text-base mb-6 max-w-lg mx-auto">
            Your monthly support provides food, education, healthcare, and dignity for every member.
        </p>
        <a href=""
           class="inline-flex items-center gap-3 px-8 py-4 bg-white text-amber-600 hover:bg-amber-50 font-black text-base rounded-2xl transition shadow-lg">
            <i class="fas fa-home text-amber-500"></i>
            Sponsor {{ $family->name ?? 'This Family' }} — $50/month
        </a>
    </div>
</section>

@include('layouts.footer')
@include('layouts.navigation')

<script>
const mobileMenu = document.getElementById('mobile-menu');
const overlay    = document.getElementById('mobile-menu-overlay');
const openMenu   = () => { mobileMenu?.classList.add('active'); overlay?.classList.add('active'); document.body.style.overflow='hidden'; };
const closeMenu  = () => { mobileMenu?.classList.remove('active'); overlay?.classList.remove('active'); document.body.style.overflow=''; };
document.getElementById('mobile-menu-btn')?.addEventListener('click', openMenu);
document.getElementById('menu-nav-item')?.addEventListener('click', e => { e.preventDefault(); openMenu(); });
document.getElementById('close-menu')?.addEventListener('click', closeMenu);
overlay?.addEventListener('click', closeMenu);
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function() {
        if (this.id !== 'menu-nav-item') {
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            this.classList.add('active');
        }
    });
});
</script>
</body>
</html>