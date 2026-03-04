@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ── Page Header ─────────────────────────────────────────── --}}
<div class="page-header flex items-center justify-between">
    <div>
        <h1 class="page-title">Welcome back, {{ Auth::guard('admin')->user()->name }}! 👋</h1>
        <p class="page-subtitle">Here's what's happening with your charity today.</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="action-btn hidden lg:flex">
        <i class="fas fa-plus"></i>
        <span>Create Article</span>
    </a>
</div>

{{-- ── Primary Stats ────────────────────────────────────────── --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-in" style="animation-delay:.1s">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-blue-500 text-xl"></i>
            </div>
            @if($siteVisitsGrowth > 0)
                <span class="text-green-500 text-sm font-semibold">+{{ $siteVisitsGrowth }}%</span>
            @else
                <span class="text-gray-500 text-sm font-semibold">{{ $siteVisitsGrowth }}%</span>
            @endif
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $totalSiteVisitsFormatted }}</h3>
        <p class="text-gray-600 text-sm">Total Site Visits</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500"><i class="fas fa-user-check text-blue-500 mr-1"></i>{{ $uniqueVisitorsFormatted }} unique visitors</p>
        </div>
    </div>

    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-in" style="animation-delay:.2s">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fas fa-newspaper text-orange-500 text-xl"></i>
            </div>
            <span class="text-green-500 text-sm font-semibold">+12%</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ number_format($totalArticles) }}</h3>
        <p class="text-gray-600 text-sm">Total Articles</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500"><i class="fas fa-check-circle text-green-500 mr-1"></i>{{ $publishedArticles }} published</p>
        </div>
    </div>

    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-in" style="animation-delay:.3s">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-eye text-green-500 text-xl"></i>
            </div>
            @if($viewsGrowth > 0)
                <span class="text-green-500 text-sm font-semibold">+{{ $viewsGrowth }}%</span>
            @else
                <span class="text-gray-500 text-sm font-semibold">{{ $viewsGrowth }}%</span>
            @endif
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $totalViewsFormatted }}</h3>
        <p class="text-gray-600 text-sm">Article Views</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500"><i class="fas fa-calendar text-green-500 mr-1"></i>{{ $viewsThisMonthFormatted }} this month</p>
        </div>
    </div>

    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-in" style="animation-delay:.4s">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-images text-purple-500 text-xl"></i>
            </div>
            <span class="text-purple-500 text-sm font-semibold">{{ $totalStorageFormatted }}</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $totalImagesFormatted }}</h3>
        <p class="text-gray-600 text-sm">Media Files</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500"><i class="fas fa-upload text-purple-500 mr-1"></i>+{{ $imagesThisMonthFormatted }} this month</p>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SPONSORSHIP OVERVIEW
══════════════════════════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg font-black text-gray-800 flex items-center gap-2">
            <i class="fas fa-heart text-orange-500"></i> Sponsorship Overview
        </h2>
        <p class="text-xs text-gray-400 mt-0.5">Live counts from your database</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.children.index') }}"
           class="flex items-center gap-1.5 px-3 py-1.5 bg-orange-50 hover:bg-orange-100 text-orange-600 text-xs font-bold rounded-lg transition border border-orange-200">
            <i class="fas fa-child text-[10px]"></i> All Children
        </a>
        <a href="{{ route('admin.families.index') }}"
           class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-lg transition border border-amber-200">
            <i class="fas fa-home text-[10px]"></i> All Families
        </a>
    </div>
</div>

{{-- Quick sponsor summary strip --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
    @php
        $childPct  = $activeChildren  > 0 ? round($sponsoredChildren  / $activeChildren  * 100) : 0;
        $familyPct = $activeFamilies  > 0 ? round($sponsoredFamilies  / $activeFamilies  * 100) : 0;
    @endphp
    <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 text-center">
        <p class="text-2xl font-black text-orange-600">{{ number_format($activeChildren) }}</p>
        <p class="text-xs text-gray-500 font-medium mt-0.5">Active Children</p>
    </div>
    <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center">
        <p class="text-2xl font-black text-red-500">{{ number_format($unsponsoredChildren) }}</p>
        <p class="text-xs text-gray-500 font-medium mt-0.5">Children Waiting</p>
    </div>
    <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-center">
        <p class="text-2xl font-black text-amber-600">{{ number_format($activeFamilies) }}</p>
        <p class="text-xs text-gray-500 font-medium mt-0.5">Active Families</p>
    </div>
    <div class="bg-rose-50 border border-rose-100 rounded-xl p-4 text-center">
        <p class="text-2xl font-black text-rose-500">{{ number_format($unsponsoredFamilies) }}</p>
        <p class="text-xs text-gray-500 font-medium mt-0.5">Families Waiting</p>
    </div>
</div>

{{-- Detailed children + families side-by-side --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    {{-- ── CHILDREN ──────────────────────────────────────────── --}}
    <div class="card border border-orange-100">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-child text-orange-500 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-black text-gray-800">Children Program</h3>
                    <p class="text-xs text-gray-400">Individual child sponsorship</p>
                </div>
            </div>
            <a href="{{ route('admin.children.create') }}"
               class="flex items-center gap-1 px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold rounded-lg transition">
                <i class="fas fa-plus text-[10px]"></i> Add
            </a>
        </div>

        {{-- Progress bar --}}
        <div class="mb-5">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs text-gray-500 font-medium">Sponsorship rate</span>
                <span class="text-xs font-black px-2 py-0.5 rounded-full
                    {{ $childPct >= 80 ? 'bg-green-100 text-green-700' : ($childPct >= 50 ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-600') }}">
                    {{ $childPct }}%
                </span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-700
                    {{ $childPct >= 80 ? 'bg-green-500' : ($childPct >= 50 ? 'bg-orange-500' : 'bg-red-500') }}"
                     style="width:{{ $childPct }}%"></div>
            </div>
            <div class="flex justify-between mt-1.5">
                <span class="text-[10px] text-gray-400">{{ number_format($sponsoredChildren) }} sponsored</span>
                <span class="text-[10px] text-gray-400">{{ number_format($activeChildren) }} total</span>
            </div>
        </div>

        {{-- Stat boxes --}}
        <div class="grid grid-cols-3 gap-2 mb-4">
            <div class="bg-green-50 rounded-xl p-3 text-center">
                <p class="text-lg font-black text-green-600">{{ number_format($sponsoredChildren) }}</p>
                <p class="text-[10px] text-gray-500">Sponsored</p>
            </div>
            <div class="bg-red-50 rounded-xl p-3 text-center">
                <p class="text-lg font-black text-red-500">{{ number_format($unsponsoredChildren) }}</p>
                <p class="text-[10px] text-gray-500">Waiting</p>
            </div>
            <div class="bg-blue-50 rounded-xl p-3 text-center">
                <p class="text-lg font-black text-blue-600">{{ number_format($childrenCountries) }}</p>
                <p class="text-[10px] text-gray-500">Countries</p>
            </div>
        </div>

        {{-- Recent 6 children --}}
        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-2">Recently Added</p>
        <div class="space-y-1.5">
            @forelse($recentChildren as $child)
            <div class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-gray-50 transition group">
                <div class="w-9 h-9 rounded-full overflow-hidden flex-shrink-0 border-2 border-orange-100 bg-orange-50">
                    @if($child->profile_photo)
                        <img src="{{ asset($child->profile_photo) }}" class="w-full h-full object-cover object-top">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-child text-orange-300 text-sm"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-800 truncate leading-tight">
                        {{ $child->first_name }} {{ $child->last_name ?? '' }}
                    </p>
                    <p class="text-[10px] text-gray-400 leading-tight flex items-center gap-1.5">
                        @if($child->country)<span><i class="fas fa-map-marker-alt text-[8px]"></i> {{ $child->country }}</span>@endif
                        @if($child->gender)
                        <span class="{{ strtolower($child->gender)==='female'?'text-pink-400':'text-blue-400' }}">
                            <i class="fas {{ strtolower($child->gender)==='female'?'fa-venus':'fa-mars' }} text-[8px]"></i>
                            {{ ucfirst($child->gender) }}
                        </span>
                        @endif
                    </p>
                </div>
                @if($child->sponsors->count() > 0)
                    <span class="flex-shrink-0 px-1.5 py-0.5 bg-green-100 text-green-700 rounded-full text-[9px] font-black">Sponsored</span>
                @else
                    <span class="flex-shrink-0 px-1.5 py-0.5 bg-red-100 text-red-500 rounded-full text-[9px] font-black">Waiting</span>
                @endif
                <a href="{{ route('admin.children.edit', $child->id) }}"
                   class="flex-shrink-0 w-7 h-7 bg-gray-100 hover:bg-orange-100 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                    <i class="fas fa-pen text-[9px] text-gray-400 hover:text-orange-500"></i>
                </a>
            </div>
            @empty
            <div class="text-center py-6">
                <i class="fas fa-child text-3xl text-gray-200 mb-2 block"></i>
                <p class="text-xs text-gray-400">No children added yet</p>
                <a href="{{ route('admin.children.create') }}" class="mt-1 text-xs font-bold text-orange-500 hover:underline inline-flex items-center gap-1">
                    <i class="fas fa-plus text-[10px]"></i> Add first child
                </a>
            </div>
            @endforelse
        </div>

        @if($newChildrenThisMonth > 0)
        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-1.5 text-xs text-gray-400">
            <i class="fas fa-plus-circle text-green-500 text-xs"></i>
            {{ $newChildrenThisMonth }} new child{{ $newChildrenThisMonth > 1 ? 'ren' : '' }} added this month
        </div>
        @endif

        <div class="mt-3">
            <a href="{{ route('admin.children.index') }}"
               class="flex items-center justify-center gap-2 w-full py-2.5 bg-orange-50 hover:bg-orange-100 text-orange-600 text-xs font-black rounded-xl transition border border-orange-100">
                <i class="fas fa-list text-[10px]"></i> View All {{ number_format($totalChildren) }} Children
            </a>
        </div>
    </div>

    {{-- ── FAMILIES ───────────────────────────────────────────── --}}
    <div class="card border border-amber-100">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-home text-amber-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-black text-gray-800">Family Program</h3>
                    <p class="text-xs text-gray-400">Household sponsorship</p>
                </div>
            </div>
            <a href="{{ route('admin.families.create') }}"
               class="flex items-center gap-1 px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition">
                <i class="fas fa-plus text-[10px]"></i> Add
            </a>
        </div>

        {{-- Progress bar --}}
        <div class="mb-5">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs text-gray-500 font-medium">Sponsorship rate</span>
                <span class="text-xs font-black px-2 py-0.5 rounded-full
                    {{ $familyPct >= 80 ? 'bg-green-100 text-green-700' : ($familyPct >= 50 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-600') }}">
                    {{ $familyPct }}%
                </span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-700
                    {{ $familyPct >= 80 ? 'bg-green-500' : ($familyPct >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                     style="width:{{ $familyPct }}%"></div>
            </div>
            <div class="flex justify-between mt-1.5">
                <span class="text-[10px] text-gray-400">{{ number_format($sponsoredFamilies) }} sponsored</span>
                <span class="text-[10px] text-gray-400">{{ number_format($activeFamilies) }} total</span>
            </div>
        </div>

        {{-- Stat boxes --}}
        <div class="grid grid-cols-3 gap-2 mb-4">
            <div class="bg-green-50 rounded-xl p-3 text-center">
                <p class="text-lg font-black text-green-600">{{ number_format($sponsoredFamilies) }}</p>
                <p class="text-[10px] text-gray-500">Sponsored</p>
            </div>
            <div class="bg-red-50 rounded-xl p-3 text-center">
                <p class="text-lg font-black text-red-500">{{ number_format($unsponsoredFamilies) }}</p>
                <p class="text-[10px] text-gray-500">Waiting</p>
            </div>
            <div class="bg-purple-50 rounded-xl p-3 text-center">
                <p class="text-lg font-black text-purple-600">{{ number_format($totalFamilyMembers) }}</p>
                <p class="text-[10px] text-gray-500">Members</p>
            </div>
        </div>

        {{-- Recent 6 families --}}
        <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-2">Recently Added</p>
        <div class="space-y-1.5">
            @forelse($recentFamilies as $family)
            <div class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-gray-50 transition group">
                <div class="w-9 h-9 rounded-xl overflow-hidden flex-shrink-0 border-2 border-amber-100 bg-amber-50 flex items-center justify-center">
                    @if($family->profile_photo)
                        <img src="{{ asset($family->profile_photo) }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-home text-amber-400 text-sm"></i>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-800 truncate leading-tight">
                        {{ $family->name ?? 'Family #'.$family->id }}
                    </p>
                    <p class="text-[10px] text-gray-400 leading-tight flex items-center gap-1.5">
                        @if($family->country)<span><i class="fas fa-map-marker-alt text-[8px]"></i> {{ $family->country }}</span>@endif
                        <span><i class="fas fa-users text-[8px]"></i> {{ $family->members_count ?? 0 }} members</span>
                    </p>
                </div>
                @if($family->sponsors->count() > 0)
                    <span class="flex-shrink-0 px-1.5 py-0.5 bg-green-100 text-green-700 rounded-full text-[9px] font-black">Sponsored</span>
                @else
                    <span class="flex-shrink-0 px-1.5 py-0.5 bg-red-100 text-red-500 rounded-full text-[9px] font-black">Waiting</span>
                @endif
                <a href="{{ route('admin.families.edit', $family->id) }}"
                   class="flex-shrink-0 w-7 h-7 bg-gray-100 hover:bg-amber-100 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                    <i class="fas fa-pen text-[9px] text-gray-400 hover:text-amber-500"></i>
                </a>
            </div>
            @empty
            <div class="text-center py-6">
                <i class="fas fa-home text-3xl text-gray-200 mb-2 block"></i>
                <p class="text-xs text-gray-400">No families added yet</p>
                <a href="{{ route('admin.families.create') }}" class="mt-1 text-xs font-bold text-amber-600 hover:underline inline-flex items-center gap-1">
                    <i class="fas fa-plus text-[10px]"></i> Add first family
                </a>
            </div>
            @endforelse
        </div>

        @if($newFamiliesThisMonth > 0)
        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-1.5 text-xs text-gray-400">
            <i class="fas fa-plus-circle text-green-500 text-xs"></i>
            {{ $newFamiliesThisMonth }} new {{ $newFamiliesThisMonth > 1 ? 'families' : 'family' }} added this month
        </div>
        @endif

        <div class="mt-3">
            <a href="{{ route('admin.families.index') }}"
               class="flex items-center justify-center gap-2 w-full py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-black rounded-xl transition border border-amber-100">
                <i class="fas fa-list text-[10px]"></i> View All {{ number_format($totalFamilies) }} Families
            </a>
        </div>
    </div>
</div>

{{-- ── Site Traffic Analytics ────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-700">Visits by Device</h3>
            <i class="fas fa-desktop text-blue-400"></i>
        </div>
        <div class="space-y-3">
            @foreach($visitsByDevice as $device)
            <div>
                <div class="flex items-center justify-between mb-1">
                    <div class="flex items-center gap-2">
                        @if($device->device_type === 'desktop')
                            <i class="fas fa-desktop text-blue-500"></i>
                        @elseif($device->device_type === 'mobile')
                            <i class="fas fa-mobile-alt text-green-500"></i>
                        @else
                            <i class="fas fa-tablet-alt text-purple-500"></i>
                        @endif
                        <span class="text-sm font-medium text-gray-700 capitalize">{{ $device->device_type }}</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-800">{{ number_format($device->count) }}</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                    @php
                        $pct   = $totalSiteVisits > 0 ? ($device->count / $totalSiteVisits) * 100 : 0;
                        $color = $device->device_type === 'desktop' ? 'bg-blue-500' : ($device->device_type === 'mobile' ? 'bg-green-500' : 'bg-purple-500');
                    @endphp
                    <div class="{{ $color }} h-full rounded-full transition-all duration-500" style="width:{{ $pct }}%"></div>
                </div>
            </div>
            @endforeach
            @if(count($visitsByDevice) == 0)
                <p class="text-center text-gray-400 py-4 text-sm">No device data yet</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-700">Today's Activity</h3>
            <i class="fas fa-calendar-day text-orange-400"></i>
        </div>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Site Visits</span>
                <span class="text-lg font-bold text-blue-600">{{ $visitsTodayFormatted }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Unique Visitors</span>
                <span class="text-lg font-bold text-green-600">{{ $uniqueVisitorsTodayFormatted }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Article Views</span>
                <span class="text-lg font-bold text-purple-600">{{ App\Helpers\NumberHelper::formatNumber($viewsToday ?? 0) }}</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-700">This Week</h3>
            <i class="fas fa-calendar-week text-green-400"></i>
        </div>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Total Visits</span>
                <span class="text-lg font-bold text-blue-600">{{ $visitsThisWeekFormatted }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">New Articles</span>
                <span class="text-lg font-bold text-orange-600">{{ $articlesThisWeek }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">New Media</span>
                <span class="text-lg font-bold text-purple-600">{{ $imagesThisMonth }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ── Geographic Analytics ──────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-globe text-blue-500"></i> Top Countries
            </h2>
            <span class="text-xs text-gray-500">Last 30 days</span>
        </div>
        <div class="space-y-3">
            @forelse($topCountries as $country)
            <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-flag text-blue-600 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800">{{ $country->country ?? 'Unknown' }}</p>
                    <p class="text-xs text-gray-500">{{ App\Helpers\NumberHelper::formatNumber($country->count) }} visits</p>
                </div>
                @php $pct = $totalSiteVisits > 0 ? round(($country->count / $totalSiteVisits) * 100, 1) : 0; @endphp
                <span class="text-sm font-bold text-blue-600">{{ $pct }}%</span>
            </div>
            @empty
            <div class="text-center py-8">
                <i class="fas fa-globe text-3xl text-gray-200 block mb-2"></i>
                <p class="text-sm text-gray-400">No country data yet</p>
            </div>
            @endforelse
        </div>
        @if($topCountries->count() > 0)
        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
            <span class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-map-marked-alt text-gray-400 text-sm"></i>
                {{ $uniqueCountries }} countries reached
            </span>
            <span class="text-xs text-gray-500">All time</span>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-city text-green-500"></i> Top Cities
            </h2>
            <span class="text-xs text-gray-500">Last 30 days</span>
        </div>
        <div class="space-y-3">
            @forelse($topCities as $city)
            <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-map-marker-alt text-green-600 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800">{{ $city->city ?? 'Unknown' }}</p>
                    <p class="text-xs text-gray-500">{{ $city->country ?? 'Unknown' }} • {{ App\Helpers\NumberHelper::formatNumber($city->count) }} visits</p>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <i class="fas fa-city text-3xl text-gray-200 block mb-2"></i>
                <p class="text-sm text-gray-400">No city data yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── Traffic Trend ─────────────────────────────────────────── --}}
<div class="card mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-800">Last 7 Days Traffic</h2>
        <div class="flex items-center gap-2 text-sm">
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-500 rounded"></span> Site Visits</span>
        </div>
    </div>
    <div class="h-64 flex items-end justify-between gap-2">
        @foreach($visitsTrend as $day)
        <div class="flex-1 flex flex-col items-center gap-2 group">
            <div class="relative w-full">
                @php
                    $maxV = $visitsTrend->max('count');
                    $h    = $maxV > 0 ? ($day->count / $maxV) * 100 : 0;
                @endphp
                <div class="w-full bg-blue-500 rounded-t hover:bg-blue-600 transition-all cursor-pointer"
                     style="height:{{ max($h, 5) }}%" title="{{ number_format($day->count) }} visits"></div>
                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                    {{ number_format($day->count) }} visits
                </div>
            </div>
            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($day->date)->format('D') }}</span>
        </div>
        @endforeach
    </div>
</div>

{{-- ── Top Pages + Recent Articles ──────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">Top Pages</h2>
            <i class="fas fa-fire text-orange-500"></i>
        </div>
        <div class="space-y-3">
            @forelse($topPages as $page)
            <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-link text-blue-500 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ Str::limit($page->page_url, 40) }}</p>
                    <p class="text-xs text-gray-500">{{ App\Helpers\NumberHelper::formatNumber($page->visits) }} visits</p>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-400 py-8 text-sm">No page data yet</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">Recent Articles</h2>
            <a href="{{ route('admin.articles.index') }}" class="text-orange-500 hover:text-orange-600 font-semibold text-sm flex items-center gap-1">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="space-y-3">
            @forelse($recentArticles->take(5) as $article)
            <a href="{{ route('admin.articles.edit', $article) }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                @if($article->image)
                    <img src="{{ $article->image->thumbnail_url }}" class="w-12 h-12 rounded-lg object-cover">
                @else
                    <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-gray-400"></i>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $article->title }}</p>
                    <p class="text-xs text-gray-500"><i class="fas fa-eye mr-1"></i>{{ App\Helpers\NumberHelper::formatNumber($article->views_count) }} views</p>
                </div>
                @if($article->status === 'published')
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Live</span>
                @else
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold">Draft</span>
                @endif
            </a>
            @empty
            <p class="text-center text-gray-400 py-8 text-sm">No articles yet</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Mobile FAB --}}
<a href="{{ route('admin.articles.create') }}"
   class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform z-50">
    <i class="fas fa-plus text-xl"></i>
</a>

@endsection