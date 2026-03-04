{{-- resources/views/admin/analytics/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')

{{-- ── Page Header ──────────────────────────────────────────── --}}
<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="page-title">Analytics</h1>
        <p class="page-subtitle">Track your site's performance and statistics</p>
    </div>
    <form action="{{ route('admin.analytics.index') }}" method="GET" class="flex items-center gap-2">
        <select name="range" onchange="this.form.submit()"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none transition text-sm">
            <option value="7"   {{ $dateRange == 7   ? 'selected' : '' }}>Last 7 Days</option>
            <option value="30"  {{ $dateRange == 30  ? 'selected' : '' }}>Last 30 Days</option>
            <option value="90"  {{ $dateRange == 90  ? 'selected' : '' }}>Last 90 Days</option>
            <option value="365" {{ $dateRange == 365 ? 'selected' : '' }}>Last Year</option>
        </select>
    </form>
</div>

{{-- ── Overview Stats ───────────────────────────────────────── --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-newspaper text-blue-500 text-xl"></i>
            </div>
            @if($stats['articles_growth'] > 0)
                <span class="text-green-600 text-sm font-semibold"><i class="fas fa-arrow-up mr-1"></i>{{ $stats['articles_growth'] }}%</span>
            @elseif($stats['articles_growth'] < 0)
                <span class="text-red-600 text-sm font-semibold"><i class="fas fa-arrow-down mr-1"></i>{{ abs($stats['articles_growth']) }}%</span>
            @endif
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_articles']) }}</h3>
        <p class="text-gray-600 text-sm">Total Articles</p>
    </div>

    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-eye text-green-500 text-xl"></i>
            </div>
            @if($stats['views_growth'] > 0)
                <span class="text-green-600 text-sm font-semibold"><i class="fas fa-arrow-up mr-1"></i>{{ $stats['views_growth'] }}%</span>
            @elseif($stats['views_growth'] < 0)
                <span class="text-red-600 text-sm font-semibold"><i class="fas fa-arrow-down mr-1"></i>{{ abs($stats['views_growth']) }}%</span>
            @endif
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_views']) }}</h3>
        <p class="text-gray-600 text-sm">Total Views</p>
    </div>

    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-purple-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_visits']) }}</h3>
        <p class="text-gray-600 text-sm">Site Visits</p>
    </div>

    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fas fa-folder text-orange-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_categories']) }}</h3>
        <p class="text-gray-600 text-sm">Categories</p>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SPONSORSHIP ANALYTICS
══════════════════════════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-black text-gray-800 flex items-center gap-2">
        <i class="fas fa-heart text-orange-500"></i> Sponsorship Analytics
    </h2>
    <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full font-medium">Last {{ $dateRange }} days</span>
</div>

{{-- Combined headline --}}
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
    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-4 text-white">
        <p class="text-3xl font-black">{{ $overallPct }}%</p>
        <p class="text-xs font-medium opacity-90 mt-0.5">Overall Rate</p>
        <p class="text-[10px] opacity-70 mt-1">Combined sponsorship %</p>
    </div>
</div>

{{-- Children + Families + Sponsors row --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- ── Children ─────────────────────────────────────────── --}}
    <div class="card border border-orange-100">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-child text-orange-500"></i>
                </div>
                <div>
                    <h3 class="font-black text-gray-800 text-sm">Children</h3>
                    <p class="text-[10px] text-gray-400">Individual sponsorship</p>
                </div>
            </div>
            @if($childrenGrowth != 0)
            <span class="text-xs font-bold {{ $childrenGrowth > 0 ? 'text-green-500' : 'text-red-400' }}">
                <i class="fas fa-arrow-{{ $childrenGrowth > 0 ? 'up' : 'down' }}"></i> {{ abs($childrenGrowth) }}%
            </span>
            @endif
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-2 mb-4">
            <div class="bg-orange-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-orange-600">{{ number_format($activeChildren) }}</p>
                <p class="text-[10px] text-gray-400">Active</p>
            </div>
            <div class="bg-green-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-green-600">{{ number_format($sponsoredChildren) }}</p>
                <p class="text-[10px] text-gray-400">Sponsored</p>
            </div>
            <div class="bg-red-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-red-500">{{ number_format($unsponsoredChildren) }}</p>
                <p class="text-[10px] text-gray-400">Waiting</p>
            </div>
            <div class="bg-blue-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-blue-600">{{ number_format($newChildrenPeriod) }}</p>
                <p class="text-[10px] text-gray-400">New ({{ $dateRange }}d)</p>
            </div>
        </div>

        {{-- Progress --}}
        <div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs text-gray-500">Sponsorship rate</span>
                <span class="text-xs font-black {{ $childPct >= 80 ? 'text-green-600' : ($childPct >= 50 ? 'text-orange-600' : 'text-red-500') }}">{{ $childPct }}%</span>
            </div>
            <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full {{ $childPct >= 80 ? 'bg-green-500' : ($childPct >= 50 ? 'bg-orange-500' : 'bg-red-500') }}"
                     style="width:{{ $childPct }}%"></div>
            </div>
        </div>

        <a href="{{ route('admin.children.index') }}"
           class="mt-4 flex items-center justify-center gap-1.5 w-full py-2 bg-orange-50 hover:bg-orange-100 text-orange-600 text-xs font-bold rounded-xl transition">
            <i class="fas fa-list text-[10px]"></i> View All Children
        </a>
    </div>

    {{-- ── Families ──────────────────────────────────────────── --}}
    <div class="card border border-amber-100">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-home text-amber-600"></i>
                </div>
                <div>
                    <h3 class="font-black text-gray-800 text-sm">Families</h3>
                    <p class="text-[10px] text-gray-400">Household sponsorship</p>
                </div>
            </div>
            @if($familiesGrowth != 0)
            <span class="text-xs font-bold {{ $familiesGrowth > 0 ? 'text-green-500' : 'text-red-400' }}">
                <i class="fas fa-arrow-{{ $familiesGrowth > 0 ? 'up' : 'down' }}"></i> {{ abs($familiesGrowth) }}%
            </span>
            @endif
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-2 mb-4">
            <div class="bg-amber-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-amber-600">{{ number_format($activeFamilies) }}</p>
                <p class="text-[10px] text-gray-400">Active</p>
            </div>
            <div class="bg-green-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-green-600">{{ number_format($sponsoredFamilies) }}</p>
                <p class="text-[10px] text-gray-400">Sponsored</p>
            </div>
            <div class="bg-red-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-red-500">{{ number_format($unsponsoredFamilies) }}</p>
                <p class="text-[10px] text-gray-400">Waiting</p>
            </div>
            <div class="bg-purple-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-purple-600">{{ number_format($totalFamilyMembers) }}</p>
                <p class="text-[10px] text-gray-400">Members</p>
            </div>
        </div>

        {{-- Progress --}}
        <div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs text-gray-500">Sponsorship rate</span>
                <span class="text-xs font-black {{ $familyPct >= 80 ? 'text-green-600' : ($familyPct >= 50 ? 'text-amber-600' : 'text-red-500') }}">{{ $familyPct }}%</span>
            </div>
            <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full {{ $familyPct >= 80 ? 'bg-green-500' : ($familyPct >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                     style="width:{{ $familyPct }}%"></div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1">Avg {{ $avgMembersPerFamily }} members / family</p>
        </div>

        <a href="{{ route('admin.families.index') }}"
           class="mt-4 flex items-center justify-center gap-1.5 w-full py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-xl transition">
            <i class="fas fa-list text-[10px]"></i> View All Families
        </a>
    </div>

    {{-- ── Sponsors ──────────────────────────────────────────── --}}
    <div class="card border border-indigo-100">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-tie text-indigo-500"></i>
                </div>
                <div>
                    <h3 class="font-black text-gray-800 text-sm">Sponsors</h3>
                    <p class="text-[10px] text-gray-400">Registered donors</p>
                </div>
            </div>
            @if($sponsorsGrowth != 0)
            <span class="text-xs font-bold {{ $sponsorsGrowth > 0 ? 'text-green-500' : 'text-red-400' }}">
                <i class="fas fa-arrow-{{ $sponsorsGrowth > 0 ? 'up' : 'down' }}"></i> {{ abs($sponsorsGrowth) }}%
            </span>
            @endif
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-2 mb-4">
            <div class="bg-indigo-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-indigo-600">{{ number_format($totalSponsors) }}</p>
                <p class="text-[10px] text-gray-400">Total</p>
            </div>
            <div class="bg-green-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-green-600">{{ number_format($activeSponsors) }}</p>
                <p class="text-[10px] text-gray-400">Active</p>
            </div>
            <div class="bg-orange-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-orange-600">{{ number_format($newSponsorsPeriod) }}</p>
                <p class="text-[10px] text-gray-400">New ({{ $dateRange }}d)</p>
            </div>
            <div class="bg-red-50 rounded-xl p-2.5 text-center">
                <p class="text-xl font-black text-red-400">{{ number_format($inactiveSponsors) }}</p>
                <p class="text-[10px] text-gray-400">Inactive</p>
            </div>
        </div>

        {{-- What they sponsor --}}
        <div class="space-y-1.5">
            @php
                $childOnly  = $sponsorsWithChildren - $sponsorsWithBoth;
                $familyOnly = $sponsorsWithFamilies  - $sponsorsWithBoth;
                $tS         = max($totalSponsors, 1);
            @endphp
            @foreach([
                ['label'=>'Children only',  'val'=>$childOnly,        'color'=>'bg-orange-400'],
                ['label'=>'Families only',  'val'=>$familyOnly,       'color'=>'bg-amber-400'],
                ['label'=>'Both',           'val'=>$sponsorsWithBoth, 'color'=>'bg-pink-400'],
                ['label'=>'No sponsorship', 'val'=>$totalSponsors - $sponsorsWithAny, 'color'=>'bg-gray-300'],
            ] as $row)
            <div>
                <div class="flex justify-between text-xs mb-0.5">
                    <span class="text-gray-600">{{ $row['label'] }}</span>
                    <span class="font-bold text-gray-700">{{ number_format($row['val']) }}</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="{{ $row['color'] }} h-full rounded-full" style="width:{{ round($row['val']/$tS*100) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        <a href="{{ route('admin.sponsors.index') }}"
           class="mt-4 flex items-center justify-center gap-1.5 w-full py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-xs font-bold rounded-xl transition">
            <i class="fas fa-list text-[10px]"></i> View All Sponsors
        </a>
    </div>
</div>

{{-- Top sponsors table --}}
<div class="card mb-8">
    <div class="flex items-center justify-between mb-5">
        <h3 class="font-black text-gray-800 flex items-center gap-2">
            <i class="fas fa-trophy text-yellow-500"></i> Most Active Sponsors
        </h3>
        <a href="{{ route('admin.sponsors.index') }}"
           class="text-xs font-bold text-indigo-500 hover:text-indigo-600 flex items-center gap-1">
            View All <i class="fas fa-arrow-right text-[10px]"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Sponsor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Children</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Families</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($topSponsors as $i => $sp)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3">
                        <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-black
                            {{ $i === 0 ? 'bg-yellow-400 text-white' : ($i === 1 ? 'bg-gray-300 text-white' : ($i === 2 ? 'bg-orange-300 text-white' : 'bg-gray-100 text-gray-500')) }}">
                            {{ $i + 1 }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-black text-indigo-600">{{ strtoupper(substr($sp->first_name, 0, 1)) }}</span>
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">{{ $sp->full_name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 hidden md:table-cell">
                        <span class="text-sm text-gray-500">{{ $sp->email }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-orange-100 text-orange-600 rounded-full text-xs font-black">
                            <i class="fas fa-child text-[9px]"></i> {{ $sp->children_count }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full text-xs font-black">
                            <i class="fas fa-home text-[9px]"></i> {{ $sp->families_count }}
                        </span>
                    </td>
                    <td class="px-4 py-3 hidden lg:table-cell">
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $sp->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $sp->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                            {{ $sp->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center">
                        <i class="fas fa-user-tie text-3xl text-gray-200 block mb-2"></i>
                        <p class="text-sm text-gray-400">No sponsors yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Data Tables: Top Articles + Top Countries ────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-fire text-orange-500"></i> Top Articles
        </h3>
        <div class="space-y-4">
            @forelse($topArticles as $article)
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                @if($article->image)
                    <img src="{{ $article->image->thumbnail_url }}" class="w-12 h-12 rounded-lg object-cover">
                @else
                    <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-gray-400"></i>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-gray-800 truncate">{{ $article->title }}</h4>
                    <p class="text-sm text-gray-500">{{ $article->category->name ?? 'Uncategorized' }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-800">{{ number_format($article->views_count) }}</p>
                    <p class="text-xs text-gray-500">views</p>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500 py-8">No articles yet</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-globe text-orange-500"></i> Top Countries
        </h3>
        <div class="space-y-4">
            @forelse($topCountries as $country)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-blue-500"></i>
                    </div>
                    <span class="font-semibold text-gray-800">{{ $country->country }}</span>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-800">{{ number_format($country->count) }}</p>
                    <p class="text-xs text-gray-500">visits</p>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500 py-8">No geographic data available</p>
            @endforelse
        </div>
    </div>
</div>

{{-- ── Browser Stats & Top Authors ──────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-window-maximize text-orange-500"></i> Traffic by Browser
        </h3>
        <div class="space-y-3">
            @forelse($trafficByBrowser as $browser)
            <div class="flex items-center gap-3">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-semibold text-gray-700">{{ $browser->browser }}</span>
                        <span class="text-sm text-gray-600">{{ number_format($browser->count) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full"
                             style="width:{{ ($browser->count / $trafficByBrowser->sum('count')) * 100 }}%"></div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500 py-8">No browser data available</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-user-edit text-orange-500"></i> Most Active Authors
        </h3>
        <div class="space-y-4">
            @forelse($topAuthors as $author)
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-lg">
                    {{ substr($author->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">{{ $author->name }}</h4>
                    <p class="text-sm text-gray-500">{{ $author->email }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-800">{{ $author->articles_count }}</p>
                    <p class="text-xs text-gray-500">articles</p>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500 py-8">No author data available</p>
            @endforelse
        </div>
    </div>
</div>

@endsection