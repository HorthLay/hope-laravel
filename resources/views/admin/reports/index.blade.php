@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')
<!-- Page Header -->
<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="page-title">Reports & Analytics</h1>
        <p class="page-subtitle">Track performance and engagement metrics</p>
    </div>

    <div class="flex items-center gap-3">
        <select class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            <option>Last 7 days</option>
            <option>Last 30 days</option>
            <option>Last 3 months</option>
            <option>Last 12 months</option>
        </select>
        <button class="action-btn">
            <i class="fas fa-download"></i>
            <span class="hidden md:inline">Export</span>
        </button>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Views -->
    <div class="card hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-eye text-blue-500 text-xl"></i>
            </div>
            <span class="text-green-500 text-sm font-semibold">+25%</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ number_format($totalViews ?? 0) }}</h3>
        <p class="text-gray-600 text-sm">Total Page Views</p>
        <div class="mt-3 flex items-center text-xs text-gray-500">
            <i class="fas fa-arrow-up text-green-500 mr-1"></i>
            vs last period
        </div>
    </div>

    <!-- Articles Published -->
    <div class="card hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fas fa-newspaper text-orange-500 text-xl"></i>
            </div>
            <span class="text-green-500 text-sm font-semibold">+12%</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $publishedArticles ?? 0 }}</h3>
        <p class="text-gray-600 text-sm">Published Articles</p>
        <div class="mt-3 flex items-center text-xs text-gray-500">
            <i class="fas fa-arrow-up text-green-500 mr-1"></i>
            {{ $newArticles ?? 0 }} new this month
        </div>
    </div>

    <!-- Avg. Reading Time -->
    <div class="card hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-purple-500 text-xl"></i>
            </div>
            <span class="text-blue-500 text-sm font-semibold">~3 min</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $avgReadingTime ?? '2:45' }}</h3>
        <p class="text-gray-600 text-sm">Avg. Reading Time</p>
        <div class="mt-3 flex items-center text-xs text-gray-500">
            <i class="fas fa-minus text-gray-400 mr-1"></i>
            stable
        </div>
    </div>

    <!-- Engagement Rate -->
    <div class="card hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-chart-line text-green-500 text-xl"></i>
            </div>
            <span class="text-green-500 text-sm font-semibold">+8%</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $engagementRate ?? '68' }}%</h3>
        <p class="text-gray-600 text-sm">Engagement Rate</p>
        <div class="mt-3 flex items-center text-xs text-gray-500">
            <i class="fas fa-arrow-up text-green-500 mr-1"></i>
            improving
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Views Chart -->
    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">Page Views Trend</h2>
            <div class="flex items-center gap-2 text-sm">
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 bg-orange-500 rounded"></span>
                    This Period
                </span>
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 bg-gray-300 rounded"></span>
                    Previous
                </span>
            </div>
        </div>
        <div class="h-64 flex items-end justify-between gap-2">
            @for($i = 0; $i < 7; $i++)
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-orange-200 rounded-t" style="height: {{ rand(40, 100) }}%"></div>
                    <span class="text-xs text-gray-500">{{ ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'][$i] }}</span>
                </div>
            @endfor
        </div>
    </div>

    <!-- Top Categories -->
    <div class="card">
        <h2 class="text-lg font-bold text-gray-800 mb-6">Top Categories</h2>
        <div class="space-y-4">
            @foreach($topCategories ?? [] as $category)
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <i class="{{ $category->icon }} text-sm" style="color: {{ $category->color }}"></i>
                            <span class="font-medium text-gray-700">{{ $category->name }}</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">{{ $category->articles_count ?? 0 }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full rounded-full" 
                             style="background-color: {{ $category->color }}; width: {{ ($category->articles_count ?? 0) * 10 }}%"></div>
                    </div>
                </div>
            @endforeach
            
            @if(empty($topCategories) || count($topCategories) == 0)
                <div class="text-center py-8">
                    <i class="fas fa-chart-pie text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No data available</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Top Performing Articles -->
<div class="card">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-800">Top Performing Articles</h2>
        <a href="{{ route('admin.articles.index') }}" class="text-orange-500 hover:text-orange-600 font-semibold text-sm flex items-center gap-1">
            View All
            <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Article</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase hidden md:table-cell">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Views</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase hidden lg:table-cell">Published</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Trend</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($topArticles ?? [] as $article)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($article->image)
                                    <img src="{{ $article->image->thumbnail_url }}" 
                                         class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-sm"></i>
                                    </div>
                                @endif
                                <span class="font-medium text-gray-800">{{ Str::limit($article->title, 40) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            @if($article->category)
                                <span class="text-sm text-gray-600">{{ $article->category->name }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-800">{{ number_format($article->views_count) }}</span>
                        </td>
                        <td class="px-6 py-4 hidden lg:table-cell">
                            <span class="text-sm text-gray-600">{{ $article->published_at?->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center text-green-600 text-sm font-semibold">
                                <i class="fas fa-arrow-up mr-1"></i>
                                {{ rand(5, 30) }}%
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-chart-bar text-gray-300 text-2xl"></i>
                            </div>
                            <p class="text-gray-500">No articles data available</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection