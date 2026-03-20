{{-- resources/views/sponsor/families-show.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $family->name ?? 'Family' }} | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
    <meta name="description" content="{{ $settings['meta_description'] ?? $settings['site_description'] ?? '' }}">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
    <style>
    :root{--or:#f97316;--or-d:#ea580c;--amber:#f59e0b;--navy:#06101f;--ink:#0f1c2e;--muted:#64748b;}

    body{font-family:'Plus Jakarta Sans',sans-serif;background:#f8fafc;}
    @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    .fade-in{animation:fadeUp .5s ease both;}

    /* ── Photo hero ── */
    .photo-hero{position:relative;height:380px;overflow:hidden;}
    @media(max-width:640px){.photo-hero{height:260px;}}

    /* ── Sticky sidebar ── */
    .sticky-cta{position:sticky;top:16px;}

    /* ══════════════════════════════
       MEMBER CARDS
    ══════════════════════════════ */
    .members-grid{
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
        gap:14px;
    }

    .member-card{
        background:#fff;
        border-radius:20px;
        border:1.5px solid #f1f5f9;
        overflow:hidden;
        box-shadow:0 2px 12px rgba(0,0,0,.05);
        transition:transform .28s cubic-bezier(.16,1,.3,1),box-shadow .28s,border-color .28s;
        display:flex;flex-direction:column;
    }
    .member-card:hover{
        transform:translateY(-4px);
        box-shadow:0 14px 36px rgba(0,0,0,.11);
        border-color:rgba(249,115,22,.25);
    }

    /* Photo zone */
    .mc-photo{
        position:relative;
        height:160px;overflow:hidden;flex-shrink:0;
    }
    .mc-photo img{
        width:100%;height:100%;object-fit:cover;
        transition:transform .6s cubic-bezier(.16,1,.3,1);
        display:block;
    }
    .member-card:hover .mc-photo img{transform:scale(1.07);}
    .mc-photo-overlay{
        position:absolute;inset:0;
        background:linear-gradient(to bottom,transparent 45%,rgba(6,16,31,.6) 100%);
    }
    /* Gender icon top-right */
    .mc-gender{
        position:absolute;top:10px;right:10px;z-index:2;
        width:28px;height:28px;border-radius:999px;
        display:flex;align-items:center;justify-content:center;
        font-size:11px;backdrop-filter:blur(6px);
    }
    /* Relationship badge on photo */
    .mc-rel-badge{
        position:absolute;bottom:10px;left:10px;z-index:2;
        font-family:'Plus Jakarta Sans',sans-serif;
        font-size:9px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;
        background:linear-gradient(135deg,var(--or),var(--or-d));color:#fff;
        padding:3px 10px;border-radius:999px;
        box-shadow:0 2px 8px rgba(249,115,22,.4);
    }
    /* Placeholder avatar */
    .mc-placeholder{
        width:100%;height:100%;
        display:flex;flex-direction:column;align-items:center;justify-content:center;
        gap:8px;
    }
    .mc-placeholder-icon{
        width:60px;height:60px;border-radius:50%;
        display:flex;align-items:center;justify-content:center;font-size:24px;
    }

    /* Body */
    .mc-body{padding:14px 16px 16px;flex:1;display:flex;flex-direction:column;}
    .mc-name{
        font-family:'Fraunces',serif;font-weight:900;
        font-size:1rem;color:var(--ink);line-height:1.2;
        margin-bottom:8px;
        white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
    }
    .mc-details{display:flex;flex-direction:column;gap:5px;flex:1;}
    .mc-detail-row{
        display:flex;align-items:center;gap:6px;
        font-size:11px;color:var(--muted);
    }
    .mc-detail-row i{
        width:14px;text-align:center;color:#cbd5e1;font-size:9px;flex-shrink:0;
    }
    /* Active pill */
    .mc-active{
        display:inline-flex;align-items:center;gap:4px;margin-top:10px;
        font-size:9.5px;font-weight:700;padding:3px 9px;border-radius:999px;width:fit-content;
    }
    .mc-active.on{background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;}
    .mc-active.off{background:#fef2f2;color:#dc2626;border:1px solid #fecaca;}

    /* ── Mobile: 2-col on small screens ── */
    @media(max-width:640px){
        .members-grid{grid-template-columns:repeat(2,1fr);gap:10px;}
        .mc-photo{height:130px;}
        .mc-body{padding:11px 12px 13px;}
        .mc-name{font-size:.9rem;}
    }
    @media(max-width:360px){
        .members-grid{grid-template-columns:1fr;}
    }
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
                        <h1 style="font-family:'Fraunces',serif;" class="text-3xl md:text-4xl font-black text-white leading-tight mb-2">
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
                        <p class="font-black text-gray-800 text-lg" style="font-family:'Fraunces',serif;">
                            {{ $family->members_count ?? $family->members->count() }}
                        </p>
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
                        <h2 style="font-family:'Fraunces',serif;" class="text-xl font-black text-gray-800">Our Story</h2>
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

            {{-- ══ FAMILY MEMBERS — card grid ══ --}}
            @if($family->members && $family->members->count())
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

                {{-- Section header --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-users text-blue-500"></i>
                        </div>
                        <div>
                            <h2 style="font-family:'Fraunces',serif;" class="text-xl font-black text-gray-800">Family Members</h2>
                            <p class="text-xs text-gray-400">{{ $family->members->count() }} people in this household</p>
                        </div>
                    </div>
                    {{-- Count badge --}}
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center"
                         style="background:linear-gradient(135deg,#f97316,#f59e0b);">
                        <span style="font-family:'Fraunces',serif;font-size:1.1rem;font-weight:900;color:#fff;">
                            {{ $family->members->count() }}
                        </span>
                    </div>
                </div>

                {{-- Cards --}}
                <div class="members-grid">
                    @foreach($family->members as $member)
                    @php
                        $isFemale = strtolower($member->gender ?? '') === 'female';
                        $isActive = $member->is_active ?? true;
                        $genderBg  = $isFemale ? '#fce7f3' : '#eff6ff';
                        $genderClr = $isFemale ? '#ec4899' : '#3b82f6';
                        $genderIco = $isFemale ? 'fa-venus' : 'fa-mars';
                        $placeholderBg  = $isFemale ? '#fdf2f8' : '#eff6ff';
                        $placeholderClr = $isFemale ? '#f9a8d4' : '#93c5fd';
                    @endphp
                    <div class="member-card">

                        {{-- Photo zone --}}
                        <div class="mc-photo" style="{{ !$member->profile_photo ? 'background:'.$placeholderBg.';' : '' }}">
                            @if(!empty($member->profile_photo))
                                <img src="{{ asset($member->profile_photo) }}" alt="{{ $member->name }}" loading="lazy">
                                <div class="mc-photo-overlay"></div>
                            @else
                                <div class="mc-placeholder">
                                    <div class="mc-placeholder-icon" style="background:{{ $placeholderClr }}30;">
                                        <i class="fas fa-user" style="color:{{ $placeholderClr }};"></i>
                                    </div>
                                    <span style="font-size:10px;font-weight:700;color:{{ $placeholderClr }};opacity:.7;">No Photo</span>
                                </div>
                            @endif

                            {{-- Gender badge --}}
                            @if(!empty($member->gender))
                            <div class="mc-gender" style="background:{{ $genderBg }}cc;">
                                <i class="fas {{ $genderIco }}" style="color:{{ $genderClr }};"></i>
                            </div>
                            @endif

                            {{-- Relationship badge --}}
                            @if(!empty($member->relationship))
                            <div class="mc-rel-badge">{{ $member->relationship }}</div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="mc-body">
                            <div class="mc-name">{{ $member->name }}</div>

                            <div class="mc-details">
                                @if(!empty($member->phone))
                                <div class="mc-detail-row">
                                    <i class="fas fa-phone"></i>
                                    <span>{{ $member->phone }}</span>
                                </div>
                                @endif

                                @if(!empty($member->email))
                                <div class="mc-detail-row">
                                    <i class="fas fa-envelope"></i>
                                    <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $member->email }}</span>
                                </div>
                                @endif

                                @if(empty($member->phone) && empty($member->email))
                                <div class="mc-detail-row" style="font-style:italic;opacity:.5;">
                                    <i class="fas fa-info-circle"></i>
                                    <span>No contact info</span>
                                </div>
                                @endif
                            </div>

                            {{-- Active status --}}
                            <div class="mc-active {{ $isActive ? 'on' : 'off' }}">
                                <i class="fas {{ $isActive ? 'fa-circle-check' : 'fa-circle-xmark' }}" style="font-size:8px;"></i>
                                {{ $isActive ? 'Active' : 'Inactive' }}
                            </div>
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
                        <h3 style="font-family:'Fraunces',serif;" class="text-xl font-black text-gray-800">Sponsor {{ $family->name ?? 'This Family' }}</h3>
                        <p class="text-sm text-gray-400 mt-1">Support the entire household</p>
                    </div>

                    <div class="bg-amber-50 rounded-2xl p-4 mb-4 text-center border border-amber-100">
                        <p style="font-family:'Fraunces',serif;" class="text-4xl font-black text-amber-500">$50</p>
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

                    <a href="#"
                       class="block w-full py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-black text-center rounded-2xl transition shadow-md shadow-amber-200 text-base">
                        <i class="fas fa-hands-helping mr-2"></i> Sponsor This Family
                    </a>
                    <p class="text-center text-[10px] text-gray-400 mt-3">
                        <i class="fas fa-lock mr-1"></i> Secure & safe donation process
                    </p>
                </div>

                {{-- Members quick list --}}
                @if($family->members && $family->members->count())
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-black text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-users text-amber-400 text-xs"></i> Household
                        <span class="ml-auto text-xs font-bold text-gray-400">{{ $family->members->count() }} people</span>
                    </h3>
                    <div class="space-y-2">
                        @foreach($family->members->take(5) as $m)
                        <div class="flex items-center gap-3">
                            @if(!empty($m->profile_photo))
                            <img src="{{ asset($m->profile_photo) }}" alt="{{ $m->name }}"
                                 class="w-8 h-8 rounded-full object-cover flex-shrink-0 border border-gray-100">
                            @else
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                                {{ strtolower($m->gender ?? '') === 'female' ? 'bg-pink-100' : 'bg-blue-100' }}">
                                <i class="fas fa-user text-[9px] {{ strtolower($m->gender ?? '') === 'female' ? 'text-pink-400' : 'text-blue-400' }}"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-gray-700 truncate">{{ $m->name }}</p>
                                @if(!empty($m->relationship))
                                <p class="text-[10px] text-gray-400">{{ $m->relationship }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @if($family->members->count() > 5)
                        <p class="text-[10px] text-gray-400 font-bold text-center pt-1">
                            +{{ $family->members->count() - 5 }} more members
                        </p>
                        @endif
                    </div>
                </div>
                @endif

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
<section class="py-14 mt-8" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
    <div class="max-w-3xl mx-auto px-4 text-center text-white">
        <h2 style="font-family:'Fraunces',serif;" class="text-2xl md:text-3xl font-black mb-3">
            Help {{ $family->name ?? 'This Family' }} Thrive
        </h2>
        <p class="text-white/90 text-base mb-6 max-w-lg mx-auto">
            Your monthly support provides food, education, healthcare, and dignity for every member.
        </p>
        <a href="#"
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