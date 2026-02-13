{{-- resources/views/admin/analytics/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')
<!-- Page Header -->
<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="page-title">Analytics</h1>
        <p class="page-subtitle">Track your site's performance and statistics</p>
    </div>

    <!-- Date Range Filter -->
    <form action="{{ route('admin.analytics.index') }}" method="GET" class="flex items-center gap-2">
        <select name="range" 
                onchange="this.form.submit()"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            <option value="7" {{ $dateRange == 7 ? 'selected' : '' }}>Last 7 Days</option>
            <option value="30" {{ $dateRange == 30 ? 'selected' : '' }}>Last 30 Days</option>
            <option value="90" {{ $dateRange == 90 ? 'selected' : '' }}>Last 90 Days</option>
            <option value="365" {{ $dateRange == 365 ? 'selected' : '' }}>Last Year</option>
        </select>
    </form>
</div>

<!-- Overview Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Articles -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-newspaper text-blue-500 text-xl"></i>
            </div>
            @if($stats['articles_growth'] > 0)
                <span class="text-green-600 text-sm font-semibold">
                    <i class="fas fa-arrow-up mr-1"></i>{{ $stats['articles_growth'] }}%
                </span>
            @elseif($stats['articles_growth'] < 0)
                <span class="text-red-600 text-sm font-semibold">
                    <i class="fas fa-arrow-down mr-1"></i>{{ abs($stats['articles_growth']) }}%
                </span>
            @endif
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_articles']) }}</h3>
        <p class="text-gray-600 text-sm">Total Articles</p>
    </div>

    <!-- Total Views -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-eye text-green-500 text-xl"></i>
            </div>
            @if($stats['views_growth'] > 0)
                <span class="text-green-600 text-sm font-semibold">
                    <i class="fas fa-arrow-up mr-1"></i>{{ $stats['views_growth'] }}%
                </span>
            @elseif($stats['views_growth'] < 0)
                <span class="text-red-600 text-sm font-semibold">
                    <i class="fas fa-arrow-down mr-1"></i>{{ abs($stats['views_growth']) }}%
                </span>
            @endif
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_views']) }}</h3>
        <p class="text-gray-600 text-sm">Total Views</p>
    </div>

    <!-- Site Visits -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-purple-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_visits']) }}</h3>
        <p class="text-gray-600 text-sm">Site Visits</p>
    </div>

    <!-- Categories -->
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

<!-- Data Tables -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Top Articles -->
    <div class="card">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-fire text-orange-500"></i>
            Top Articles
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

    <!-- Top Countries -->
    <div class="card">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-globe text-orange-500"></i>
            Top Countries
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

<!-- Browser Stats & Top Authors -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Traffic by Browser -->
    <div class="card">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-window-maximize text-orange-500"></i>
            Traffic by Browser
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
                                 style="width: {{ ($browser->count / $trafficByBrowser->sum('count')) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">No browser data available</p>
            @endforelse
        </div>
    </div>

    <!-- Top Authors -->
    <div class="card">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-user-edit text-orange-500"></i>
            Most Active Authors
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