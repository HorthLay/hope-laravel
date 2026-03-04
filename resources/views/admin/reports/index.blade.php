{{-- resources/views/admin/reports/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')

{{-- ── Page Header ──────────────────────────────────────────── --}}
<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="page-title">Reports</h1>
        <p class="page-subtitle">Site performance, sponsorship and engagement overview</p>
    </div>
    <div class="flex items-center gap-3">
        <form method="GET" action="{{ route('admin.reports.index') }}">
            <select name="range" onchange="this.form.submit()"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none transition text-sm">
                <option value="7"   {{ $range == 7   ? 'selected' : '' }}>Last 7 Days</option>
                <option value="30"  {{ $range == 30  ? 'selected' : '' }}>Last 30 Days</option>
                <option value="90"  {{ $range == 90  ? 'selected' : '' }}>Last 90 Days</option>
                <option value="365" {{ $range == 365 ? 'selected' : '' }}>Last Year</option>
            </select>
        </form>
        <a href="{{ route('admin.reports.export', ['range' => $range]) }}" class="action-btn">
            <i class="fas fa-download"></i>
            <span>Export CSV</span>
        </a>
    </div>
</div>

{{-- ── Primary Overview Stats ───────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-eye text-blue-500 text-lg"></i>
            </div>
            <span class="text-xs font-semibold {{ $visitsGrowth >= 0 ? 'text-green-600' : 'text-red-500' }}">
                <i class="fas fa-arrow-{{ $visitsGrowth >= 0 ? 'up' : 'down' }} mr-0.5"></i>{{ abs($visitsGrowth) }}%
            </span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalViews) }}</h3>
        <p class="text-gray-500 text-sm mt-1">Total Views</p>
    </div>

    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-purple-500 text-lg"></i>
            </div>
            <span class="text-xs font-semibold {{ $visitsGrowth >= 0 ? 'text-green-600' : 'text-red-500' }}">
                <i class="fas fa-arrow-{{ $visitsGrowth >= 0 ? 'up' : 'down' }} mr-0.5"></i>{{ abs($visitsGrowth) }}%
            </span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalVisits) }}</h3>
        <p class="text-gray-500 text-sm mt-1">Site Visits</p>
    </div>

    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fas fa-newspaper text-orange-500 text-lg"></i>
            </div>
            <span class="text-xs font-semibold {{ $articlesGrowth >= 0 ? 'text-green-600' : 'text-red-500' }}">
                <i class="fas fa-arrow-{{ $articlesGrowth >= 0 ? 'up' : 'down' }} mr-0.5"></i>{{ abs($articlesGrowth) }}%
            </span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($publishedArticles) }}</h3>
        <p class="text-gray-500 text-sm mt-1">Published</p>
    </div>

    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-pencil-alt text-yellow-500 text-lg"></i>
            </div>
            <span class="text-xs font-semibold text-gray-400"><i class="fas fa-minus mr-0.5"></i>drafts</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($draftArticles) }}</h3>
        <p class="text-gray-500 text-sm mt-1">Drafts</p>
    </div>
</div>

<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="card text-center hover:shadow-lg transition-all">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-folder text-green-500"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800">{{ $totalCategories }}</h3>
        <p class="text-gray-500 text-sm">Categories</p>
    </div>
    <div class="card text-center hover:shadow-lg transition-all">
        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-users-cog text-blue-500"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800">{{ $totalAdmins }}</h3>
        <p class="text-gray-500 text-sm">Admins</p>
    </div>
    <div class="card text-center hover:shadow-lg transition-all">
        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-plus text-orange-500"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800">{{ $newArticles }}</h3>
        <p class="text-gray-500 text-sm">New ({{ $range }}d)</p>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SPONSORSHIP REPORT
══════════════════════════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-black text-gray-800 flex items-center gap-2">
        <i class="fas fa-heart text-orange-500"></i> Sponsorship Report
    </h2>
    <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full font-medium">Last {{ $range }} days</span>
</div>

{{-- Combined headline numbers --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-4 text-white">
        <p class="text-3xl font-black">{{ number_format($totalBeneficiaries) }}</p>
        <p class="text-xs font-medium opacity-90 mt-0.5">Total Beneficiaries</p>
        <p class="text-[10px] opacity-70 mt-1">Children + Family Members</p>
    </div>
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-4 text-white">
        <p class="text-3xl font-black">{{ number_format($totalSponsored) }}</p>
        <p class="text-xs font-medium opacity-90 mt-0.5">Sponsored</p>
        <p class="text-[10px] opacity-70 mt-1">Children + Families with sponsor</p>
    </div>
    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-4 text-white">
        <p class="text-3xl font-black">{{ number_format($totalUnsponsored) }}</p>
        <p class="text-xs font-medium opacity-90 mt-0.5">Still Waiting</p>
        <p class="text-[10px] opacity-70 mt-1">Urgently need a sponsor</p>
    </div>
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-4 text-white">
        @php $overallPct = ($activeChildren + $activeFamilies) > 0 ? round(($sponsoredChildren + $sponsoredFamilies) / ($activeChildren + $activeFamilies) * 100) : 0; @endphp
        <p class="text-3xl font-black">{{ $overallPct }}%</p>
        <p class="text-xs font-medium opacity-90 mt-0.5">Overall Rate</p>
        <p class="text-[10px] opacity-70 mt-1">Combined sponsorship %</p>
    </div>
</div>

{{-- Children + Families detail side by side --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- ── CHILDREN ─────────────────────────────────────────── --}}
    <div class="card border border-orange-100">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-child text-orange-500"></i>
                </div>
                <div>
                    <h3 class="font-black text-gray-800">Children</h3>
                    <p class="text-xs text-gray-400">Individual sponsorship program</p>
                </div>
            </div>
            <a href="{{ route('admin.children.index') }}"
               class="text-xs font-bold text-orange-500 hover:text-orange-600 flex items-center gap-1">
                Manage <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        {{-- Stats strip --}}
        <div class="grid grid-cols-4 gap-2 mb-5">
            <div class="text-center p-2.5 bg-gray-50 rounded-xl">
                <p class="text-lg font-black text-gray-800">{{ number_format($totalChildren) }}</p>
                <p class="text-[10px] text-gray-400">Total</p>
            </div>
            <div class="text-center p-2.5 bg-orange-50 rounded-xl">
                <p class="text-lg font-black text-orange-600">{{ number_format($activeChildren) }}</p>
                <p class="text-[10px] text-gray-400">Active</p>
            </div>
            <div class="text-center p-2.5 bg-green-50 rounded-xl">
                <p class="text-lg font-black text-green-600">{{ number_format($sponsoredChildren) }}</p>
                <p class="text-[10px] text-gray-400">Sponsored</p>
            </div>
            <div class="text-center p-2.5 bg-red-50 rounded-xl">
                <p class="text-lg font-black text-red-500">{{ number_format($unsponsoredChildren) }}</p>
                <p class="text-[10px] text-gray-400">Waiting</p>
            </div>
        </div>

        {{-- Progress --}}
        <div class="mb-5">
            <div class="flex justify-between items-center mb-1.5">
                <span class="text-xs text-gray-500">Sponsorship rate</span>
                <span class="text-xs font-black {{ $childPct >= 80 ? 'text-green-600' : ($childPct >= 50 ? 'text-orange-600' : 'text-red-500') }}">{{ $childPct }}%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full {{ $childPct >= 80 ? 'bg-green-500' : ($childPct >= 50 ? 'bg-orange-500' : 'bg-red-500') }}"
                     style="width:{{ $childPct }}%"></div>
            </div>
        </div>

        {{-- Country breakdown --}}
        @if($childrenByCountry->isNotEmpty())
        <div>
            <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-2">
                Top Countries <span class="text-gray-300 font-normal">({{ $childrenCountries }} total)</span>
            </p>
            @php $maxCC = max($childrenByCountry->max('count'), 1); @endphp
            <div class="space-y-2">
                @foreach($childrenByCountry as $cc)
                <div>
                    <div class="flex justify-between text-xs mb-0.5">
                        <span class="font-medium text-gray-700 flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-orange-300 text-[9px]"></i>{{ $cc->country }}
                        </span>
                        <span class="font-bold text-gray-600">{{ $cc->count }}</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-orange-400 rounded-full" style="width:{{ round($cc->count/$maxCC*100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($newChildrenPeriod > 0)
        <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-gray-400 flex items-center gap-1.5">
            <i class="fas fa-plus-circle text-green-500"></i>
            {{ $newChildrenPeriod }} new child{{ $newChildrenPeriod > 1 ? 'ren' : '' }} in last {{ $range }} days
        </div>
        @endif
    </div>

    {{-- ── FAMILIES ──────────────────────────────────────────── --}}
    <div class="card border border-amber-100">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-home text-amber-600"></i>
                </div>
                <div>
                    <h3 class="font-black text-gray-800">Families</h3>
                    <p class="text-xs text-gray-400">Household sponsorship program</p>
                </div>
            </div>
            <a href="{{ route('admin.families.index') }}"
               class="text-xs font-bold text-amber-600 hover:text-amber-700 flex items-center gap-1">
                Manage <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        {{-- Stats strip --}}
        <div class="grid grid-cols-4 gap-2 mb-5">
            <div class="text-center p-2.5 bg-gray-50 rounded-xl">
                <p class="text-lg font-black text-gray-800">{{ number_format($totalFamilies) }}</p>
                <p class="text-[10px] text-gray-400">Total</p>
            </div>
            <div class="text-center p-2.5 bg-amber-50 rounded-xl">
                <p class="text-lg font-black text-amber-600">{{ number_format($activeFamilies) }}</p>
                <p class="text-[10px] text-gray-400">Active</p>
            </div>
            <div class="text-center p-2.5 bg-green-50 rounded-xl">
                <p class="text-lg font-black text-green-600">{{ number_format($sponsoredFamilies) }}</p>
                <p class="text-[10px] text-gray-400">Sponsored</p>
            </div>
            <div class="text-center p-2.5 bg-red-50 rounded-xl">
                <p class="text-lg font-black text-red-500">{{ number_format($unsponsoredFamilies) }}</p>
                <p class="text-[10px] text-gray-400">Waiting</p>
            </div>
        </div>

        {{-- Progress --}}
        <div class="mb-5">
            <div class="flex justify-between items-center mb-1.5">
                <span class="text-xs text-gray-500">Sponsorship rate</span>
                <span class="text-xs font-black {{ $familyPct >= 80 ? 'text-green-600' : ($familyPct >= 50 ? 'text-amber-600' : 'text-red-500') }}">{{ $familyPct }}%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full {{ $familyPct >= 80 ? 'bg-green-500' : ($familyPct >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                     style="width:{{ $familyPct }}%"></div>
            </div>
        </div>

        {{-- Members + avg --}}
        <div class="grid grid-cols-2 gap-3 mb-5">
            <div class="bg-purple-50 rounded-xl p-3 text-center">
                <i class="fas fa-users text-purple-400 mb-1 block"></i>
                <p class="text-xl font-black text-purple-600">{{ number_format($totalFamilyMembers) }}</p>
                <p class="text-[10px] text-gray-400">Total Members</p>
            </div>
            <div class="bg-indigo-50 rounded-xl p-3 text-center">
                <i class="fas fa-calculator text-indigo-400 mb-1 block"></i>
                <p class="text-xl font-black text-indigo-600">{{ $avgMembersPerFamily }}</p>
                <p class="text-[10px] text-gray-400">Avg per Family</p>
            </div>
        </div>

        {{-- Country breakdown --}}
        @if($familiesByCountry->isNotEmpty())
        <div>
            <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-2">Top Countries</p>
            @php $maxFC = max($familiesByCountry->max('count'), 1); @endphp
            <div class="space-y-2">
                @foreach($familiesByCountry as $fc)
                <div>
                    <div class="flex justify-between text-xs mb-0.5">
                        <span class="font-medium text-gray-700 flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-amber-300 text-[9px]"></i>{{ $fc->country }}
                        </span>
                        <span class="font-bold text-gray-600">{{ $fc->count }}</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-400 rounded-full" style="width:{{ round($fc->count/$maxFC*100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($newFamiliesPeriod > 0)
        <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-gray-400 flex items-center gap-1.5">
            <i class="fas fa-plus-circle text-green-500"></i>
            {{ $newFamiliesPeriod }} new {{ $newFamiliesPeriod > 1 ? 'families' : 'family' }} in last {{ $range }} days
        </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SPONSOR REPORT
══════════════════════════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-black text-gray-800 flex items-center gap-2">
        <i class="fas fa-user-tie text-indigo-500"></i> Sponsors
    </h2>
    <a href="{{ route('admin.sponsors.index') }}"
       class="text-xs font-bold text-indigo-500 hover:text-indigo-600 flex items-center gap-1">
        Manage <i class="fas fa-arrow-right text-[10px]"></i>
    </a>
</div>

{{-- Sponsor headline strip --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 text-center">
        <p class="text-3xl font-black text-indigo-600">{{ number_format($totalSponsors) }}</p>
        <p class="text-xs text-gray-500 font-medium mt-0.5">Total Sponsors</p>
    </div>
    <div class="bg-green-50 border border-green-100 rounded-2xl p-4 text-center">
        <p class="text-3xl font-black text-green-600">{{ number_format($activeSponsors) }}</p>
        <p class="text-xs text-gray-500 font-medium mt-0.5">Active</p>
    </div>
    <div class="bg-orange-50 border border-orange-100 rounded-2xl p-4 text-center">
        <p class="text-3xl font-black text-orange-600">{{ number_format($newSponsorsPeriod) }}</p>
        <p class="text-xs text-gray-500 font-medium mt-0.5">New ({{ $range }}d)</p>
        @if($sponsorsGrowth != 0)
        <p class="text-[10px] font-bold mt-1 {{ $sponsorsGrowth > 0 ? 'text-green-500' : 'text-red-400' }}">
            <i class="fas fa-arrow-{{ $sponsorsGrowth > 0 ? 'up' : 'down' }}"></i> {{ abs($sponsorsGrowth) }}%
        </p>
        @endif
    </div>
    <div class="bg-red-50 border border-red-100 rounded-2xl p-4 text-center">
        <p class="text-3xl font-black text-red-400">{{ number_format($inactiveSponsors) }}</p>
        <p class="text-xs text-gray-500 font-medium mt-0.5">Inactive</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- Sponsorship type breakdown --}}
    <div class="card border border-indigo-100">
        <h3 class="font-black text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-chart-pie text-indigo-400"></i> What Sponsors Support
        </h3>

        @php
            $maxSp = max($sponsorsWithChildren, $sponsorsWithFamilies, $sponsorsWithBoth, 1);
        @endphp

        <div class="space-y-4 mb-6">
            {{-- Children only --}}
            @php $childOnly = $sponsorsWithChildren - $sponsorsWithBoth; @endphp
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-child text-orange-400 w-4"></i> Children only
                    </span>
                    <span class="font-black text-gray-800">{{ number_format($childOnly) }}</span>
                </div>
                <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-orange-400 rounded-full"
                         style="width:{{ $totalSponsors > 0 ? round($childOnly/$totalSponsors*100) : 0 }}%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">{{ $totalSponsors > 0 ? round($childOnly/$totalSponsors*100) : 0 }}% of sponsors</p>
            </div>

            {{-- Families only --}}
            @php $familyOnly = $sponsorsWithFamilies - $sponsorsWithBoth; @endphp
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-home text-amber-500 w-4"></i> Families only
                    </span>
                    <span class="font-black text-gray-800">{{ number_format($familyOnly) }}</span>
                </div>
                <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-amber-400 rounded-full"
                         style="width:{{ $totalSponsors > 0 ? round($familyOnly/$totalSponsors*100) : 0 }}%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">{{ $totalSponsors > 0 ? round($familyOnly/$totalSponsors*100) : 0 }}% of sponsors</p>
            </div>

            {{-- Both --}}
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-heart text-pink-500 w-4"></i> Both (children + families)
                    </span>
                    <span class="font-black text-gray-800">{{ number_format($sponsorsWithBoth) }}</span>
                </div>
                <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-pink-400 rounded-full"
                         style="width:{{ $totalSponsors > 0 ? round($sponsorsWithBoth/$totalSponsors*100) : 0 }}%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">{{ $totalSponsors > 0 ? round($sponsorsWithBoth/$totalSponsors*100) : 0 }}% of sponsors</p>
            </div>

            {{-- Not sponsoring anyone --}}
            @php $noSponsorship = $totalSponsors - $sponsorsWithAny; @endphp
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-user-slash text-gray-400 w-4"></i> No active sponsorship
                    </span>
                    <span class="font-black text-gray-800">{{ number_format($noSponsorship) }}</span>
                </div>
                <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gray-300 rounded-full"
                         style="width:{{ $totalSponsors > 0 ? round($noSponsorship/$totalSponsors*100) : 0 }}%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">{{ $totalSponsors > 0 ? round($noSponsorship/$totalSponsors*100) : 0 }}% of sponsors</p>
            </div>
        </div>

        {{-- Totals summary --}}
        <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-100">
            <div class="bg-orange-50 rounded-xl p-3 text-center">
                <p class="text-xl font-black text-orange-600">{{ number_format($sponsorsWithChildren) }}</p>
                <p class="text-[10px] text-gray-500">Sponsoring Children</p>
            </div>
            <div class="bg-amber-50 rounded-xl p-3 text-center">
                <p class="text-xl font-black text-amber-600">{{ number_format($sponsorsWithFamilies) }}</p>
                <p class="text-[10px] text-gray-500">Sponsoring Families</p>
            </div>
        </div>
    </div>

    {{-- Top sponsors + recent sponsors --}}
    <div class="card border border-indigo-100">
        <h3 class="font-black text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-trophy text-yellow-500"></i> Most Active Sponsors
        </h3>
        <div class="space-y-2 mb-6">
            @forelse($topSponsors as $i => $sp)
            <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-gray-50 transition">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 font-black text-sm
                    {{ $i === 0 ? 'bg-yellow-400 text-white' : ($i === 1 ? 'bg-gray-300 text-white' : ($i === 2 ? 'bg-orange-300 text-white' : 'bg-gray-100 text-gray-500')) }}">
                    {{ $i + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-800 truncate">{{ $sp->full_name }}</p>
                    <p class="text-[10px] text-gray-400 truncate">{{ $sp->email }}</p>
                </div>
                <div class="flex items-center gap-1.5 flex-shrink-0">
                    @if($sp->children_count > 0)
                    <span class="flex items-center gap-0.5 px-1.5 py-0.5 bg-orange-100 text-orange-600 rounded-full text-[10px] font-black">
                        <i class="fas fa-child text-[8px]"></i> {{ $sp->children_count }}
                    </span>
                    @endif
                    @if($sp->families_count > 0)
                    <span class="flex items-center gap-0.5 px-1.5 py-0.5 bg-amber-100 text-amber-700 rounded-full text-[10px] font-black">
                        <i class="fas fa-home text-[8px]"></i> {{ $sp->families_count }}
                    </span>
                    @endif
                    <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $sp->is_active ? 'bg-green-400' : 'bg-gray-300' }}" title="{{ $sp->is_active ? 'Active' : 'Inactive' }}"></span>
                </div>
            </div>
            @empty
            <div class="text-center py-6">
                <i class="fas fa-user-tie text-3xl text-gray-200 block mb-2"></i>
                <p class="text-xs text-gray-400">No sponsors yet</p>
            </div>
            @endforelse
        </div>

        <div class="pt-4 border-t border-gray-100">
            <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-2">Recently Joined</p>
            <div class="space-y-1.5">
                @foreach($recentSponsors as $sp)
                <div class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-gray-50 transition">
                    <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-black text-indigo-600">{{ strtoupper(substr($sp->first_name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-gray-800 truncate">{{ $sp->full_name }}</p>
                        <p class="text-[10px] text-gray-400">{{ $sp->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $sp->is_active ? 'bg-green-400' : 'bg-gray-300' }}"></span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ── Article Status + Device Traffic ─────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-layer-group text-orange-500"></i> Article Status
        </h2>
        @php $total = max(($articlesByStatus['published'] ?? 0) + ($articlesByStatus['draft'] ?? 0) + ($articlesByStatus['archived'] ?? 0), 1); @endphp
        <div class="space-y-4">
            @foreach([
                ['key'=>'published','label'=>'Published','color'=>'bg-green-500'],
                ['key'=>'draft',    'label'=>'Draft',     'color'=>'bg-yellow-400'],
                ['key'=>'archived', 'label'=>'Archived',  'color'=>'bg-gray-400'],
            ] as $s)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 {{ $s['color'] }} rounded-full inline-block"></span>{{ $s['label'] }}
                    </span>
                    <span class="font-bold text-gray-800">{{ $articlesByStatus[$s['key']] ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="{{ $s['color'] }} h-2.5 rounded-full transition-all duration-700"
                         style="width:{{ round((($articlesByStatus[$s['key']] ?? 0) / $total) * 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ round((($articlesByStatus[$s['key']] ?? 0) / $total) * 100) }}% of total</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-mobile-alt text-orange-500"></i> Traffic by Device
        </h2>
        <div class="space-y-4">
            @foreach([
                ['key'=>'desktop','label'=>'Desktop','icon'=>'fa-desktop',    'color'=>'bg-blue-500'],
                ['key'=>'mobile', 'label'=>'Mobile', 'icon'=>'fa-mobile-alt', 'color'=>'bg-orange-500'],
                ['key'=>'tablet', 'label'=>'Tablet', 'icon'=>'fa-tablet-alt', 'color'=>'bg-purple-500'],
            ] as $d)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas {{ $d['icon'] }} w-4 {{ str_replace('bg-','text-',$d['color']) }}"></i>{{ $d['label'] }}
                    </span>
                    <span class="font-bold text-gray-800">{{ number_format($deviceStats[$d['key']]) }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="{{ $d['color'] }} h-2.5 rounded-full"
                         style="width:{{ round(($deviceStats[$d['key']] / $totalDevices) * 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ round(($deviceStats[$d['key']] / $totalDevices) * 100) }}%</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ── Browser Stats + Top Countries ───────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-window-maximize text-orange-500"></i> Traffic by Browser
        </h2>
        <div class="space-y-3">
            @forelse($browserStats as $browser)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700">{{ $browser->browser }}</span>
                    <span class="font-bold text-gray-800">{{ number_format($browser->count) }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-orange-400 h-2.5 rounded-full"
                         style="width:{{ round(($browser->count / $totalBrowsers) * 100) }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-400 py-8 text-sm">No browser data yet</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-globe text-orange-500"></i> Top Countries
        </h2>
        <div class="space-y-3">
            @forelse($topCountries as $i => $country)
            <div class="flex items-center gap-3">
                <span class="w-6 h-6 rounded-full bg-gray-100 text-gray-500 text-xs font-bold flex items-center justify-center flex-shrink-0">
                    {{ $i + 1 }}
                </span>
                <div class="flex-1">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-semibold text-gray-700">{{ $country->country }}</span>
                        <span class="font-bold text-gray-800">{{ number_format($country->count) }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-blue-400 h-2 rounded-full"
                             style="width:{{ round(($country->count / $totalCountries) * 100) }}%"></div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-400 py-8 text-sm">No country data yet</p>
            @endforelse
        </div>
    </div>
</div>

{{-- ── Top Categories + Top Authors ─────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-folder text-orange-500"></i> Articles by Category
        </h2>
        @php $maxCat = max($topCategories->max('articles_count'), 1); @endphp
        <div class="space-y-3">
            @forelse($topCategories as $category)
            <div>
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <i class="{{ $category->icon ?? 'fas fa-circle' }} text-xs"
                           style="color:{{ $category->color ?? '#f97316' }}"></i>
                        {{ $category->name }}
                    </span>
                    <span class="font-bold text-gray-800">{{ $category->articles_count }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="h-2 rounded-full"
                         style="width:{{ round(($category->articles_count / $maxCat) * 100) }}%;background-color:{{ $category->color ?? '#f97316' }}"></div>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-400 py-8 text-sm">No categories yet</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-user-edit text-orange-500"></i> Most Active Authors
        </h2>
        <div class="space-y-3">
            @forelse($topAuthors as $i => $author)
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold flex-shrink-0">
                    {{ strtoupper(substr($author->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 text-sm truncate">{{ $author->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $author->role }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="font-bold text-gray-800">{{ $author->articles_count }}</p>
                    <p class="text-xs text-gray-400">articles</p>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-400 py-8 text-sm">No authors yet</p>
            @endforelse
        </div>
    </div>
</div>

{{-- ── Top Performing Articles Table ───────────────────────── --}}
<div class="card mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-fire text-orange-500"></i> Top Performing Articles
        </h2>
        <a href="{{ route('admin.articles.index') }}"
           class="text-sm text-orange-500 hover:text-orange-600 font-semibold flex items-center gap-1">
            View All <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Article</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Views</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Published</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($topArticles as $i => $article)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3">
                        <span class="w-7 h-7 rounded-full {{ $i < 3 ? 'bg-orange-100 text-orange-600' : 'bg-gray-100 text-gray-500' }} text-xs font-bold flex items-center justify-center">
                            {{ $i + 1 }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($article->image)
                                <img src="{{ asset($article->image->thumbnail_path ?? $article->image->file_path) }}"
                                     class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-image text-gray-300 text-sm"></i>
                                </div>
                            @endif
                            <span class="font-medium text-gray-800 text-sm line-clamp-1">{{ $article->title }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 hidden md:table-cell">
                        @if($article->category)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium"
                                  style="background-color:{{ $article->category->color ?? '#f97316' }}20;color:{{ $article->category->color ?? '#f97316' }}">
                                <i class="{{ $article->category->icon ?? 'fas fa-circle' }} text-xs"></i>
                                {{ $article->category->name }}
                            </span>
                        @else
                            <span class="text-gray-400 text-sm">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="font-bold text-gray-800">{{ number_format($article->views_count) }}</span>
                    </td>
                    <td class="px-4 py-3 hidden lg:table-cell">
                        <span class="text-sm text-gray-500">{{ $article->published_at?->format('M d, Y') ?? '—' }}</span>
                    </td>
                    <td class="px-4 py-3 hidden lg:table-cell">
                        @php $colors = ['published'=>'green','draft'=>'yellow','archived'=>'gray']; $c = $colors[$article->status] ?? 'gray'; @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $c }}-100 text-{{ $c }}-700">
                            {{ ucfirst($article->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center">
                        <i class="fas fa-newspaper text-gray-200 text-4xl mb-3 block"></i>
                        <p class="text-gray-400">No articles yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection