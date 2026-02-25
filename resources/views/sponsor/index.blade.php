{{-- resources/views/sponsor/index.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sponsor a Child or Family | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
     <meta name="description" content="{{ $settings['meta_description'] ?? $settings['site_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '' }}">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <meta name="description" content="Sponsor a child or family and change lives forever.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .card { transition: transform .25s, box-shadow .25s; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.10); }
        .story-modal, .modal-overlay { transition: opacity .2s; }
        /* Tab underline animation */
        .tab-btn { position: relative; }
        .tab-btn::after {
            content: ''; position: absolute; bottom: -2px; left: 0; right: 0;
            height: 3px; border-radius: 99px;
            background: #f4b630; transform: scaleX(0);
            transition: transform .25s ease;
        }
        .tab-btn.active::after { transform: scaleX(1); }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }
        /* Modal uses style.display only — no Tailwind hidden conflict */
        #story-modal { display: none; }
    </style>
</head>
<body class="bg-gray-50">

@include('layouts.header')

{{-- ── HERO ── --}}
<div class="bg-gradient-to-br from-[#f4b630] to-[#e0a500] text-white py-14 md:py-20">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <div class="inline-flex items-center gap-2 bg-white/20 rounded-full px-4 py-1.5 text-sm font-bold mb-4">
            <i class="fas fa-heart text-white"></i> Make a Difference Today
        </div>

        <h1 class="text-3xl md:text-5xl font-black mb-4 leading-tight">
            Change a Life Forever
        </h1>

        <p class="text-white/90 text-lg max-w-xl mx-auto mb-8">
            For just $1 a day, give a child — or an entire family — access to education, nutritious meals, healthcare, and hope.
        </p>

        <div class="flex flex-wrap justify-center gap-3">
            @foreach(['fa-graduation-cap' => 'Education', 'fa-utensils' => 'Nutrition', 'fa-heartbeat' => 'Healthcare', 'fa-home' => 'Safe Home'] as $icon => $label)
            <div class="flex items-center gap-2 bg-white/15 rounded-xl px-4 py-2.5 text-sm font-bold">
                <i class="fas {{ $icon }}"></i> {{ $label }}
            </div>
            @endforeach
        </div>
    </div>
</div>
{{-- ── TABS ── --}}
<div class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
    <div class="max-w-5xl mx-auto px-4">
        <div class="flex items-center gap-0">
            <button id="tab-children" onclick="switchTab('children')"
                    class="tab-btn flex items-center gap-2 px-6 py-4 font-black text-sm transition border-b-2 border-transparent">
                <i class="fas fa-child"></i>
                Children
                <span class="bg-orange-100 text-orange-600 text-[10px] font-black px-2 py-0.5 rounded-full ml-1">
                    {{ $childStats['total'] }}
                </span>
            </button>
            <button id="tab-families" onclick="switchTab('families')"
                    class="tab-btn flex items-center gap-2 px-6 py-4 font-black text-sm transition border-b-2 border-transparent">
                <i class="fas fa-users"></i>
                Families
                <span class="bg-gray-100 text-gray-500 text-[10px] font-black px-2 py-0.5 rounded-full ml-1" id="fam-badge">
                    {{ $familyStats['total'] }}
                </span>
            </button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     TAB: CHILDREN
══════════════════════════════════════ --}}
<div id="panel-children" class="tab-panel">

    {{-- Stats bar --}}
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 py-4 flex flex-wrap justify-center gap-8 text-center">
            <div>
                <p class="text-2xl font-black text-orange-600">{{ $childStats['total'] }}</p>
                <p class="text-xs text-gray-500 font-medium">Children</p>
            </div>
            <div class="border-l border-gray-200 pl-8">
                <p class="text-2xl font-black text-green-600">{{ $childStats['sponsored'] }}</p>
                <p class="text-xs text-gray-500 font-medium">Sponsored</p>
            </div>
            <div class="border-l border-gray-200 pl-8">
                <p class="text-2xl font-black text-blue-600">{{ $childStats['waiting'] }}</p>
                <p class="text-xs text-gray-500 font-medium">Waiting</p>
            </div>
            <div class="border-l border-gray-200 pl-8">
                <p class="text-2xl font-black text-purple-600">{{ $childStats['countries'] }}</p>
                <p class="text-xs text-gray-500 font-medium">Countries</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="max-w-5xl mx-auto px-4 mt-8">
        <form method="GET" action="{{ route('sponsor.children') }}"
              class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 flex flex-wrap gap-3 items-center">
            <input type="hidden" name="tab" value="children">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by name..."
                       class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-400 outline-none text-sm">
            </div>
            @if($childCountries->isNotEmpty())
            <select name="country" class="px-3 py-2.5 border border-gray-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-orange-400 outline-none min-w-[140px]">
                <option value="">All Countries</option>
                @foreach($childCountries as $c)
                <option value="{{ $c }}" {{ request('country') === $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
            @endif
            <button type="submit" class="px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-xl transition">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            @if(request()->hasAny(['search','country','gender']))
            <a href="{{ route('sponsor.children') }}" class="px-4 py-2.5 border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 text-sm">
                <i class="fas fa-times mr-1"></i> Clear
            </a>
            @endif
        </form>
    </div>

    {{-- Children Grid --}}
    <div class="max-w-5xl mx-auto px-4 py-8">
        @if($children->isEmpty())
        <div class="text-center py-20">
            <i class="fas fa-child text-5xl text-gray-200 block mb-4"></i>
            <p class="text-gray-400 font-medium text-lg">No children found.</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($children as $child)
            @php $encId = \Illuminate\Support\Facades\Crypt::encryptString((string)$child->id); @endphp
            <div class="card bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
                {{-- Photo --}}
                <div class="relative overflow-hidden" style="height:220px">
                    <img src="{{ $child->profile_photo ? asset($child->profile_photo) : asset('images/child-placeholder.jpg') }}"
                         alt="{{ $child->first_name }}" class="w-full h-full object-cover object-top">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-4 flex flex-wrap items-center gap-2">
                        @if(!empty($child->age) || !empty($child->date_of_birth))
                        <span class="flex items-center gap-1 bg-black/60 text-white text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">
                            <i class="fas fa-birthday-cake text-orange-300 text-[10px]"></i>
                            {{ $child->age ?? \Carbon\Carbon::parse($child->date_of_birth)->age }} yrs
                        </span>
                        @endif
                        @if(!empty($child->country))
                        <span class="flex items-center gap-1 bg-black/60 text-white text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">
                            <i class="fas fa-map-marker-alt text-orange-300 text-[10px]"></i>
                            {{ $child->country }}
                        </span>
                        @endif
                        @if($child->has_family)
                        <span class="flex items-center gap-1 bg-green-600 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                            <i class="fas fa-home text-[10px]"></i>
                            Has Family
                        </span>
                        @else
                        <span class="flex items-center gap-1 bg-red-600 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                            <i class="fas fa-home text-[10px]"></i>
                            No Family
                        </span>
                        @endif
                    </div>
                    @if(!empty($child->gender))
                    <div class="absolute top-3 right-3 w-8 h-8 rounded-full flex items-center justify-center shadow
                        {{ strtolower($child->gender)==='female' ? 'bg-pink-500':'bg-blue-500' }}">
                        <i class="fas {{ strtolower($child->gender)==='female' ? 'fa-venus':'fa-mars' }} text-white text-xs"></i>
                    </div>
                    @endif
                </div>
                {{-- Info --}}
                <div class="p-5 flex flex-col flex-1">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h2 class="font-black text-gray-800 text-lg leading-tight">
                                {{ $child->first_name }} {{ $child->last_name ?? '' }}
                            </h2>
                            @if(!empty($child->code))
                            <p class="font-mono text-[10px] text-gray-400 mt-0.5">{{ $child->code }}</p>
                            @endif
                        </div>
                        @if(!empty($child->grade))
                        <span class="flex-shrink-0 px-2 py-1 bg-purple-50 text-purple-600 text-[10px] font-black rounded-lg border border-purple-100">
                            <i class="fas fa-graduation-cap mr-1 text-[8px]"></i>{{ $child->grade }}
                        </span>
                        @endif
                    </div>
                    @if(!empty($child->story))
                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 flex-1 mb-4">
                        {{ Str::limit(strip_tags($child->story), 100) }}
                    </p>
                    @else
                    <div class="flex-1 mb-4"></div>
                    @endif
                    <div class="grid grid-cols-2 gap-2 mt-auto">
                        <button type="button"
                                onclick="openStory(
                                    '{{ addslashes($child->first_name . ' ' . ($child->last_name ?? '')) }}',
                                    '{{ $child->profile_photo ? asset($child->profile_photo) : asset('images/child-placeholder.jpg') }}',
                                    '{{ addslashes(strip_tags($child->story ?? 'No story available yet.')) }}',
                                    '{{ $child->age ?? \Carbon\Carbon::parse($child->date_of_birth ?? now())->age }}',
                                    '{{ $child->country ?? '' }}',
                                    {{ $child->has_family ? 'true' : 'false' }},
                                    '{{ route('children.show', $encId) }}'
                                )"
                                class="flex items-center justify-center gap-1.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition">
                            <i class="fas fa-book-open text-gray-500"></i> My Story
                        </button>
                        <a href="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1"
                           target="_blank" rel="noopener"
                           class="flex items-center justify-center gap-1.5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs rounded-xl transition shadow-sm">
                            <i class="fas fa-heart text-xs"></i> {{ $child->first_name }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($children->hasPages())
        <div class="mt-10 flex justify-center">{{ $children->withQueryString()->links() }}</div>
        @endif
        @endif
    </div>
</div>
{{-- /panel-children --}}


{{-- ══════════════════════════════════════
     TAB: FAMILIES
══════════════════════════════════════ --}}
<div id="panel-families" class="tab-panel">

    {{-- Stats bar --}}
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 py-4 flex flex-wrap justify-center gap-8 text-center">
            <div>
                <p class="text-2xl font-black text-amber-600">{{ $familyStats['total'] }}</p>
                <p class="text-xs text-gray-500 font-medium">Families</p>
            </div>
            <div class="border-l border-gray-200 pl-8">
                <p class="text-2xl font-black text-green-600">{{ $familyStats['sponsored'] }}</p>
                <p class="text-xs text-gray-500 font-medium">Sponsored</p>
            </div>
            <div class="border-l border-gray-200 pl-8">
                <p class="text-2xl font-black text-blue-600">{{ $familyStats['waiting'] }}</p>
                <p class="text-xs text-gray-500 font-medium">Waiting</p>
            </div>
            <div class="border-l border-gray-200 pl-8">
                <p class="text-2xl font-black text-purple-600">{{ $familyStats['members'] }}</p>
                <p class="text-xs text-gray-500 font-medium">Total Members</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="max-w-5xl mx-auto px-4 mt-8">
        <form method="GET" action="{{ route('sponsor.children') }}"
              class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 flex flex-wrap gap-3 items-center">
            <input type="hidden" name="tab" value="families">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search family name..."
                       class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-400 outline-none text-sm">
            </div>
            @if($familyCountries->isNotEmpty())
            <select name="country" class="px-3 py-2.5 border border-gray-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-amber-400 outline-none min-w-[140px]">
                <option value="">All Countries</option>
                @foreach($familyCountries as $c)
                <option value="{{ $c }}" {{ request('country') === $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
            @endif
            <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm rounded-xl transition">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            @if(request()->hasAny(['search','country']))
            <a href="{{ route('sponsor.children') }}?tab=families" class="px-4 py-2.5 border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 text-sm">
                <i class="fas fa-times mr-1"></i> Clear
            </a>
            @endif
        </form>
    </div>

    {{-- Families Grid --}}
    <div class="max-w-5xl mx-auto px-4 py-8">
        @if($families->isEmpty())
        <div class="text-center py-20">
            <i class="fas fa-users text-5xl text-gray-200 block mb-4"></i>
            <p class="text-gray-400 font-medium text-lg">No families found.</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($families as $family)
            @php $fEncId = \Illuminate\Support\Facades\Crypt::encryptString((string)$family->id); @endphp
            <div class="card bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
                {{-- Photo --}}
                <div class="relative overflow-hidden" style="height:200px">
                    @if(!empty($family->profile_photo))
                    <img src="{{ asset($family->profile_photo) }}" alt="{{ $family->name }}"
                         class="w-full h-full object-cover object-top">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center">
                        <i class="fas fa-users text-5xl text-amber-300"></i>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                    {{-- Members count badge --}}
                    <div class="absolute bottom-3 left-4 flex items-center gap-2">
                        <span class="flex items-center gap-1 bg-black/60 text-white text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">
                            <i class="fas fa-users text-amber-300 text-[10px]"></i>
                            {{ $family->members_count }} members
                        </span>
                        @if(!empty($family->country))
                        <span class="flex items-center gap-1 bg-black/60 text-white text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">
                            <i class="fas fa-map-marker-alt text-amber-300 text-[10px]"></i>
                            {{ $family->country }}
                        </span>
                        @endif
                    </div>

                    {{-- Sponsored badge --}}
                    @if($family->sponsors_count ?? $family->relationLoaded('sponsors'))
                    <div class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-black px-2 py-1 rounded-full shadow">
                        <i class="fas fa-check-circle mr-1 text-[9px]"></i>Sponsored
                    </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-5 flex flex-col flex-1">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h2 class="font-black text-gray-800 text-lg leading-tight">
                                {{ $family->name ?? 'Family #'.$family->id }}
                            </h2>
                            @if(!empty($family->code))
                            <p class="font-mono text-[10px] text-gray-400 mt-0.5">{{ $family->code }}</p>
                            @endif
                        </div>
                        @if(!empty($family->income_level))
                        <span class="flex-shrink-0 px-2 py-1 bg-amber-50 text-amber-600 text-[10px] font-black rounded-lg border border-amber-100">
                            {{ $family->income_level }}
                        </span>
                        @endif
                    </div>

                    @if(!empty($family->location) || !empty($family->province))
                    <p class="text-xs text-gray-400 flex items-center gap-1 mb-2">
                        <i class="fas fa-map-marker-alt text-amber-400 text-[10px]"></i>
                        {{ $family->location ?? $family->province }}
                    </p>
                    @endif

                    @if(!empty($family->story))
                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 flex-1 mb-4">
                        {{ Str::limit(strip_tags($family->story), 100) }}
                    </p>
                    @else
                    <div class="flex-1 mb-4"></div>
                    @endif

                    <div class="grid grid-cols-2 gap-2 mt-auto">
                        <a href="{{ route('families.show', $fEncId) }}"
                           class="flex items-center justify-center gap-1.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition">
                            <i class="fas fa-eye text-gray-500"></i> View Family
                        </a>
                        <a href="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1"
                           target="_blank" rel="noopener"
                           class="flex items-center justify-center gap-1.5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl transition shadow-sm">
                            <i class="fas fa-hands-helping text-xs"></i> {{ $family->name }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($families->hasPages())
        <div class="mt-10 flex justify-center">{{ $families->withQueryString()->links() }}</div>
        @endif
        @endif
    </div>
</div>
{{-- /panel-families --}}


{{-- ── STORY MODAL (children) ── --}}
{{-- NOTE: No Tailwind 'hidden' class here — visibility controlled via style.display only --}}
<div id="story-modal"
     class="story-modal fixed inset-0 bg-black/70 z-[9999] items-center justify-center p-4"
     onclick="if(event.target===this) closeStory()">
    <div class="bg-white rounded-3xl overflow-hidden shadow-2xl w-full max-w-md relative">
        <button onclick="closeStory()"
                class="absolute top-4 right-4 z-10 w-9 h-9 flex items-center justify-center bg-black/10 hover:bg-black/20 text-white rounded-full transition">
            <i class="fas fa-times text-sm"></i>
        </button>
        <div class="relative h-56 bg-gray-200 overflow-hidden">
            <img id="modal-photo" src="" alt="" class="w-full h-full object-cover object-top">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute bottom-4 left-5 right-12">
                <h2 id="modal-name" class="text-2xl font-black text-white leading-tight"></h2>
                <div class="flex items-center gap-3 mt-1" id="modal-meta"></div>
            </div>
            {{-- FIX: removed the unused #modal-has-family div that overlapped #modal-meta --}}
        </div>
        <div class="p-6">
            <div class="flex items-center gap-2 mb-3">
                <i class="fas fa-book-open text-orange-400"></i>
                <h3 class="font-black text-gray-800">My Story</h3>
            </div>
            <p id="modal-story" class="text-sm text-gray-600 leading-relaxed mb-6 max-h-40 overflow-y-auto"></p>
            <div class="grid grid-cols-2 gap-3">
                <a id="modal-detail-link" href="#"
                   class="flex items-center justify-center gap-2 py-3 border-2 border-gray-200 hover:border-orange-300 text-gray-700 font-bold text-sm rounded-xl transition">
                    <i class="fas fa-eye text-gray-400"></i> Full Detail
                </a>
                <a id="modal-sponsor-link"
                   href="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1"
                   target="_blank" rel="noopener"
                   class="flex items-center justify-center gap-2 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-xl transition shadow-sm">
                    <i class="fas fa-heart"></i> Sponsor Now
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── BOTTOM CTA ── --}}
<section class="bg-gradient-to-br from-orange-500 to-orange-600 py-14 mt-4">
    <div class="max-w-3xl mx-auto px-4 text-center text-white">
        <i class="fas fa-hands-helping text-5xl mb-4 opacity-80 block"></i>
        <h2 class="text-2xl md:text-3xl font-black mb-3">Every Life Deserves a Chance</h2>
        <p class="text-white/90 text-base mb-8 max-w-lg mx-auto">
            Sponsor a child or an entire family — your support covers education, meals, healthcare, and hope.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <div class="bg-white/15 rounded-2xl px-6 py-4 text-center">
                <p class="text-3xl font-black">$30</p>
                <p class="text-sm text-white/80">child / month</p>
            </div>
            <div class="bg-white/15 rounded-2xl px-6 py-4 text-center">
                <p class="text-3xl font-black">$1</p>
                <p class="text-sm text-white/80">per day</p>
            </div>
            <div class="bg-white/15 rounded-2xl px-6 py-4 text-center">
                <p class="text-3xl font-black">∞</p>
                <p class="text-sm text-white/80">impact</p>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')
@include('layouts.navigation')

<script>
// ── Tab switching ─────────────────────────────────────────────────
const TABS = ['children', 'families'];

function switchTab(name) {
    TABS.forEach(t => {
        const btn   = document.getElementById('tab-' + t);
        const panel = document.getElementById('panel-' + t);
        const isActive = t === name;

        panel.classList.toggle('active', isActive);
        btn.classList.toggle('active', isActive);

        btn.classList.remove('text-orange-500', 'text-amber-500', 'text-gray-400');
        if (isActive) {
            btn.classList.add(t === 'children' ? 'text-orange-500' : 'text-amber-500');
        } else {
            btn.classList.add('text-gray-400');
        }
    });

    // Persist tab in URL without full reload
    const url = new URL(window.location);
    url.searchParams.set('tab', name);
    window.history.replaceState({}, '', url);
}

// Restore tab from URL on load
const urlTab = new URLSearchParams(window.location.search).get('tab') || 'children';
switchTab(urlTab);

// ── Story modal ───────────────────────────────────────────────────
const SPONSOR_URL = 'https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1';

// FIX: added hasFamily as 6th param, detailUrl moved to 7th
function openStory(name, photo, story, age, country, hasFamily, detailUrl) {
    document.getElementById('modal-name').textContent  = name;
    document.getElementById('modal-photo').src         = photo;
    document.getElementById('modal-story').textContent = story;

    let meta = '';
    if (age)     meta += `<span class="flex items-center gap-1 text-white/90 text-xs font-bold"><i class="fas fa-birthday-cake text-orange-300 text-[10px]"></i>${age} yrs</span>`;
    if (country) meta += `<span class="flex items-center gap-1 text-white/90 text-xs font-bold"><i class="fas fa-map-marker-alt text-orange-300 text-[10px]"></i>${country}</span>`;
    // FIX: hasFamily is now a real boolean — always show the badge in both true/false cases
    meta += `<span class="flex items-center gap-1 text-white/90 text-xs font-bold">
        <i class="fas fa-home ${hasFamily ? 'text-green-300' : 'text-red-300'} text-[10px]"></i>
        ${hasFamily ? 'Has Family' : 'No Family'}
    </span>`;
    document.getElementById('modal-meta').innerHTML = meta;

    document.getElementById('modal-detail-link').href = detailUrl;

    // Always use the fixed sponsor URL
    const sponsorLink = document.getElementById('modal-sponsor-link');
    sponsorLink.href      = SPONSOR_URL;
    sponsorLink.innerHTML = `<i class="fas fa-heart"></i> Sponsor ${name.split(' ')[0]}`;

    // Control visibility via style.display only (no Tailwind 'hidden' conflict)
    document.getElementById('story-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeStory() {
    document.getElementById('story-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeStory(); });

// ── Mobile nav ───────────────────────────────────────────────────
const mobileMenu = document.getElementById('mobile-menu');
const overlay    = document.getElementById('mobile-menu-overlay');
const openMenu   = () => { mobileMenu?.classList.add('active'); overlay?.classList.add('active'); document.body.style.overflow='hidden'; };
const closeMenu  = () => { mobileMenu?.classList.remove('active'); overlay?.classList.remove('active'); document.body.style.overflow=''; };
document.getElementById('mobile-menu-btn')?.addEventListener('click', openMenu);
document.getElementById('menu-nav-item')?.addEventListener('click', e => { e.preventDefault(); openMenu(); });
document.getElementById('close-menu')?.addEventListener('click', closeMenu);
overlay?.addEventListener('click', closeMenu);
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function () {
        if (this.id !== 'menu-nav-item') {
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            this.classList.add('active');
        }
    });
});
</script>
</body>
</html>