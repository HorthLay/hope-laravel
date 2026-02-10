@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
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

<!-- Primary Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Site Visits -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-in" style="animation-delay: 0.1s">
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
            <p class="text-xs text-gray-500">
                <i class="fas fa-user-check text-blue-500 mr-1"></i>
                {{ $uniqueVisitorsFormatted }} unique visitors
            </p>
        </div>
    </div>

    <!-- Total Articles -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-in" style="animation-delay: 0.2s">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fas fa-newspaper text-orange-500 text-xl"></i>
            </div>
            <span class="text-green-500 text-sm font-semibold">+12%</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ number_format($totalArticles) }}</h3>
        <p class="text-gray-600 text-sm">Total Articles</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                {{ $publishedArticles }} published
            </p>
        </div>
    </div>

    <!-- Total Views -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-in" style="animation-delay: 0.3s">
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
            <p class="text-xs text-gray-500">
                <i class="fas fa-calendar text-green-500 mr-1"></i>
                {{ $viewsThisMonthFormatted }} this month
            </p>
        </div>
    </div>

    <!-- Media Library -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slide-in" style="animation-delay: 0.4s">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-images text-purple-500 text-xl"></i>
            </div>
            <span class="text-purple-500 text-sm font-semibold">{{ $totalStorageFormatted }}</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $totalImagesFormatted }}</h3>
        <p class="text-gray-600 text-sm">Media Files</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                <i class="fas fa-upload text-purple-500 mr-1"></i>
                +{{ $imagesThisMonthFormatted }} this month
            </p>
        </div>
    </div>
</div>

<!-- Site Traffic Analytics -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Visits by Device -->
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
                            $percentage = $totalSiteVisits > 0 ? ($device->count / $totalSiteVisits) * 100 : 0;
                            $color = $device->device_type === 'desktop' ? 'bg-blue-500' : ($device->device_type === 'mobile' ? 'bg-green-500' : 'bg-purple-500');
                        @endphp
                        <div class="{{ $color }} h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
            
            @if(count($visitsByDevice) == 0)
                <p class="text-center text-gray-400 py-4 text-sm">No device data yet</p>
            @endif
        </div>
    </div>

    <!-- Today's Stats -->
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

    <!-- This Week Stats -->
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

<!-- Traffic Trend Chart -->
<div class="card mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-800">Last 7 Days Traffic</h2>
        <div class="flex items-center gap-2 text-sm">
            <span class="flex items-center gap-1">
                <span class="w-3 h-3 bg-blue-500 rounded"></span>
                Site Visits
            </span>
        </div>
    </div>
    <div class="h-64 flex items-end justify-between gap-2">
        @foreach($visitsTrend as $day)
            <div class="flex-1 flex flex-col items-center gap-2 group">
                <div class="relative w-full">
                    @php
                        $maxVisits = $visitsTrend->max('count');
                        $height = $maxVisits > 0 ? ($day->count / $maxVisits) * 100 : 0;
                    @endphp
                    <div class="w-full bg-blue-500 rounded-t hover:bg-blue-600 transition-all cursor-pointer" 
                         style="height: {{ max($height, 5) }}%"
                         title="{{ number_format($day->count) }} visits">
                    </div>
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                        {{ number_format($day->count) }} visits
                    </div>
                </div>
                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($day->date)->format('D') }}</span>
            </div>
        @endforeach
    </div>
</div>

<!-- Top Pages & Recent Articles -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Top Pages -->
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

    <!-- Recent Articles -->
    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">Recent Articles</h2>
            <a href="{{ route('admin.articles.index') }}" class="text-orange-500 hover:text-orange-600 font-semibold text-sm flex items-center gap-1">
                View All 
                <i class="fas fa-arrow-right text-xs"></i>
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
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-eye mr-1"></i>
                            {{ App\Helpers\NumberHelper::formatNumber($article->views_count) }} views
                        </p>
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

<!-- Mobile Action Button -->
<a href="{{ route('admin.articles.create') }}" class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform z-50">
    <i class="fas fa-plus text-xl"></i>
</a>
@endsection