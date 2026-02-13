{{-- resources/views/admin/reports/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')

<!-- Page Header -->
<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="page-title">Reports</h1>
        <p class="page-subtitle">Site performance and engagement overview</p>
    </div>
    <div class="flex items-center gap-3">
        <form method="GET" action="{{ route('admin.reports.index') }}">
            <select name="range" onchange="this.form.submit()"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none transition">
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

<!-- Overview Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Total Views -->
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

    <!-- Site Visits -->
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

    <!-- Published Articles -->
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

    <!-- Draft Articles -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-pencil-alt text-yellow-500 text-lg"></i>
            </div>
            <span class="text-xs font-semibold text-gray-400">
                <i class="fas fa-minus mr-0.5"></i>drafts
            </span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($draftArticles) }}</h3>
        <p class="text-gray-500 text-sm mt-1">Drafts</p>
    </div>
</div>

<!-- Second Stats Row -->
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

<!-- Article Status + Device Traffic -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Article Status Breakdown -->
    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-layer-group text-orange-500"></i>
            Article Status
        </h2>
        @php
            $total = max(($articlesByStatus['published'] ?? 0) + ($articlesByStatus['draft'] ?? 0) + ($articlesByStatus['archived'] ?? 0), 1);
        @endphp
        <div class="space-y-4">
            <!-- Published -->
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full inline-block"></span>Published
                    </span>
                    <span class="font-bold text-gray-800">{{ $articlesByStatus['published'] ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-green-500 h-2.5 rounded-full transition-all duration-700"
                         style="width: {{ round((($articlesByStatus['published'] ?? 0) / $total) * 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ round((($articlesByStatus['published'] ?? 0) / $total) * 100) }}% of total</p>
            </div>
            <!-- Draft -->
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-yellow-400 rounded-full inline-block"></span>Draft
                    </span>
                    <span class="font-bold text-gray-800">{{ $articlesByStatus['draft'] ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-yellow-400 h-2.5 rounded-full transition-all duration-700"
                         style="width: {{ round((($articlesByStatus['draft'] ?? 0) / $total) * 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ round((($articlesByStatus['draft'] ?? 0) / $total) * 100) }}% of total</p>
            </div>
            <!-- Archived -->
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-gray-400 rounded-full inline-block"></span>Archived
                    </span>
                    <span class="font-bold text-gray-800">{{ $articlesByStatus['archived'] ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-gray-400 h-2.5 rounded-full transition-all duration-700"
                         style="width: {{ round((($articlesByStatus['archived'] ?? 0) / $total) * 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ round((($articlesByStatus['archived'] ?? 0) / $total) * 100) }}% of total</p>
            </div>
        </div>
    </div>

    <!-- Traffic by Device -->
    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-mobile-alt text-orange-500"></i>
            Traffic by Device
        </h2>
        <div class="space-y-4">
            <!-- Desktop -->
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-desktop text-blue-500 w-4"></i>Desktop
                    </span>
                    <span class="font-bold text-gray-800">{{ number_format($deviceStats['desktop']) }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-blue-500 h-2.5 rounded-full"
                         style="width: {{ round(($deviceStats['desktop'] / $totalDevices) * 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ round(($deviceStats['desktop'] / $totalDevices) * 100) }}%</p>
            </div>
            <!-- Mobile -->
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-mobile-alt text-orange-500 w-4"></i>Mobile
                    </span>
                    <span class="font-bold text-gray-800">{{ number_format($deviceStats['mobile']) }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-orange-500 h-2.5 rounded-full"
                         style="width: {{ round(($deviceStats['mobile'] / $totalDevices) * 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ round(($deviceStats['mobile'] / $totalDevices) * 100) }}%</p>
            </div>
            <!-- Tablet -->
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fas fa-tablet-alt text-purple-500 w-4"></i>Tablet
                    </span>
                    <span class="font-bold text-gray-800">{{ number_format($deviceStats['tablet']) }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5">
                    <div class="bg-purple-500 h-2.5 rounded-full"
                         style="width: {{ round(($deviceStats['tablet'] / $totalDevices) * 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ round(($deviceStats['tablet'] / $totalDevices) * 100) }}%</p>
            </div>
        </div>
    </div>
</div>

<!-- Browser Stats + Top Countries -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Browser Stats -->
    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-window-maximize text-orange-500"></i>
            Traffic by Browser
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
                             style="width: {{ round(($browser->count / $totalBrowsers) * 100) }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 py-8 text-sm">No browser data yet</p>
            @endforelse
        </div>
    </div>

    <!-- Top Countries -->
    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-globe text-orange-500"></i>
            Top Countries
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
                                 style="width: {{ round(($country->count / $totalCountries) * 100) }}%"></div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 py-8 text-sm">No country data yet</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Top Categories + Top Authors -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Top Categories -->
    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-folder text-orange-500"></i>
            Articles by Category
        </h2>
        @php $maxCat = max($topCategories->max('articles_count'), 1); @endphp
        <div class="space-y-3">
            @forelse($topCategories as $category)
                <div>
                    <div class="flex items-center justify-between text-sm mb-1">
                        <span class="font-semibold text-gray-700 flex items-center gap-2">
                            <i class="{{ $category->icon ?? 'fas fa-circle' }} text-xs"
                               style="color: {{ $category->color ?? '#f97316' }}"></i>
                            {{ $category->name }}
                        </span>
                        <span class="font-bold text-gray-800">{{ $category->articles_count }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="h-2 rounded-full"
                             style="width: {{ round(($category->articles_count / $maxCat) * 100) }}%; background-color: {{ $category->color ?? '#f97316' }}"></div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 py-8 text-sm">No categories yet</p>
            @endforelse
        </div>
    </div>

    <!-- Top Authors -->
    <div class="card">
        <h2 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-user-edit text-orange-500"></i>
            Most Active Authors
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

<!-- Top Performing Articles Table -->
<div class="card mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-fire text-orange-500"></i>
            Top Performing Articles
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
                                      style="background-color: {{ $article->category->color ?? '#f97316' }}20; color: {{ $article->category->color ?? '#f97316' }}">
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
                            <span class="text-sm text-gray-500">
                                {{ $article->published_at?->format('M d, Y') ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 hidden lg:table-cell">
                            @php
                                $colors = ['published' => 'green', 'draft' => 'yellow', 'archived' => 'gray'];
                                $color  = $colors[$article->status] ?? 'gray';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-700">
                                {{ ucfirst($article->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <i class="fas fa-newspaper text-gray-200 text-4xl mb-3"></i>
                            <p class="text-gray-400">No articles yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection