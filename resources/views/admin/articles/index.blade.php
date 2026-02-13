@extends('admin.layouts.app')
@section('title', 'Articles')
@section('content')

<!-- Page Header -->
<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="page-title">Articles</h1>
        <p class="page-subtitle">Manage all your articles and posts</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="action-btn">
        <i class="fas fa-plus"></i><span>Create Article</span>
    </a>
</div>

{{-- ════════════════════════════════════════════════════════
     STATS STRIP  (same design as public site)
════════════════════════════════════════════════════════ --}}
<div class="rounded-2xl mb-6 overflow-hidden"
     style="background:linear-gradient(135deg,#1f2937 0%,#111827 100%);">
    <div class="px-6 py-8">
        <p class="text-xs font-bold text-orange-400 uppercase tracking-widest mb-4">
            <i class="fas fa-chart-bar mr-2"></i>Article Stats Overview
        </p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @php
                $totalArticles   = $articles->total() ?? 0;
                $publishedCount  = \App\Models\Article::where('status','published')->count();
                $draftCount      = \App\Models\Article::where('status','draft')->count();
                $totalViews      = \App\Models\Article::sum('views_count');
            @endphp
            <div class="text-center group">
                <div class="text-3xl md:text-4xl font-black text-white mb-1 counter-admin"
                     data-target="{{ $totalArticles }}">{{ $totalArticles }}</div>
                <p class="text-xs text-gray-400 font-medium">Total Articles</p>
            </div>
            <div class="text-center group">
                <div class="text-3xl md:text-4xl font-black text-green-400 mb-1 counter-admin"
                     data-target="{{ $publishedCount }}">{{ $publishedCount }}</div>
                <p class="text-xs text-gray-400 font-medium">Published</p>
            </div>
            <div class="text-center group">
                <div class="text-3xl md:text-4xl font-black text-yellow-400 mb-1 counter-admin"
                     data-target="{{ $draftCount }}">{{ $draftCount }}</div>
                <p class="text-xs text-gray-400 font-medium">Drafts</p>
            </div>
            <div class="text-center group">
                <div class="text-3xl md:text-4xl font-black text-orange-400 mb-1 counter-admin"
                     data-target="{{ $totalViews }}">{{ number_format($totalViews) }}</div>
                <p class="text-xs text-gray-400 font-medium">Total Views</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <form action="{{ route('admin.articles.index') }}" method="GET"
          class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search articles..."
                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
        </div>
        <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            <option value="">All Status</option>
            <option value="published" {{ request('status')=='published'?'selected':'' }}>Published</option>
            <option value="draft"     {{ request('status')=='draft'?'selected':'' }}>Draft</option>
            <option value="archived"  {{ request('status')=='archived'?'selected':'' }}>Archived</option>
        </select>
        <select name="category" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            <option value="">All Categories</option>
            @foreach($categories ?? [] as $category)
                <option value="{{ $category->id }}" {{ request('category')==$category->id?'selected':'' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="px-6 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition font-medium">
            <i class="fas fa-filter mr-2"></i>Filter
        </button>
        @if(request()->hasAny(['search','status','category']))
            <a href="{{ route('admin.articles.index') }}"
               class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                <i class="fas fa-times mr-2"></i>Clear
            </a>
        @endif
    </form>
</div>

<!-- Articles Table -->
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Article</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Category</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Tags</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Views</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Date</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($articles ?? [] as $article)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Article -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($article->image)
                                    <img src="{{ asset($article->image->file_path) }}"
                                         alt="{{ $article->title }}"
                                         class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                @elseif($article->featured_image)
                                    <img src="{{ asset( $article->featured_image) }}"
                                         alt="{{ $article->title }}"
                                         class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0"
                                         style="background-color:{{ $article->category->color ?? '#f97316' }}15;">
                                        <i class="{{ $article->category->icon ?? 'fas fa-newspaper' }} text-xl"
                                           style="color:{{ $article->category->color ?? '#f97316' }};opacity:.4"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-gray-800 truncate max-w-[200px] lg:max-w-xs">
                                        {{ $article->title }}
                                    </h4>
                                    <p class="text-xs text-gray-500">By {{ $article->admin?->name ?? '—' }}</p>
                                </div>
                            </div>
                        </td>
                        <!-- Category -->
                        <td class="px-6 py-4 hidden md:table-cell">
                            @if($article->category)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold"
                                      style="background-color:{{ $article->category->color }}20;color:{{ $article->category->color }};">
                                    @if($article->category->icon)<i class="{{ $article->category->icon }} text-xs"></i>@endif
                                    {{ $article->category->name }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <!-- Tags -->
                        <td class="px-6 py-4 hidden md:table-cell">
                            @if($article->relationLoaded('tags') && $article->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-1">
                                    @foreach($article->tags->take(3) as $tag)
                                        <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                    @if($article->tags->count() > 3)
                                        <span class="text-xs text-gray-400 font-medium">+{{ $article->tags->count()-3 }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">No tags</span>
                            @endif
                        </td>
                        <!-- Views -->
                        <td class="px-6 py-4 hidden lg:table-cell">
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <i class="fas fa-eye text-xs text-gray-400"></i>
                                <span class="font-medium text-sm">{{ number_format($article->views_count) }}</span>
                            </div>
                        </td>
                        <!-- Status -->
                        <td class="px-6 py-4">
                            @if($article->status==='published')
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Published</span>
                            @elseif($article->status==='draft')
                                <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Draft</span>
                            @else
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">Archived</span>
                            @endif
                        </td>
                        <!-- Date -->
                        <td class="px-6 py-4 hidden lg:table-cell text-sm text-gray-500">
                            {{ ($article->published_at ?? $article->created_at)?->format('M d, Y') }}
                        </td>
                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.articles.show', $article) }}"
                                   class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="View">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('admin.articles.edit', $article) }}"
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                      class="inline" onsubmit="return confirm('Delete this article?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-newspaper text-gray-300 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">No articles found</h3>
                            <p class="text-gray-500 mb-6">
                                @if(request()->hasAny(['search','status','category']))
                                    No articles match your filters. Try adjusting your search.
                                @else
                                    Get started by creating your first article.
                                @endif
                            </p>
                            @if(request()->hasAny(['search','status','category']))
                                <a href="{{ route('admin.articles.index') }}" class="action-btn">
                                    <i class="fas fa-times mr-2"></i>Clear Filters
                                </a>
                            @else
                                <a href="{{ route('admin.articles.create') }}" class="action-btn">
                                    <i class="fas fa-plus"></i><span>Create Article</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($articles) && $articles->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $articles->links() }}
        </div>
    @endif
</div>

<!-- Mobile FAB -->
<a href="{{ route('admin.articles.create') }}"
   class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform z-50">
    <i class="fas fa-plus text-xl"></i>
</a>

@push('scripts')
<script>
// Animated counters for the stats strip
document.querySelectorAll('.counter-admin').forEach(el => {
    const target = +el.getAttribute('data-target');
    if (target === 0) return;
    const step = Math.max(1, Math.ceil(target / 80));
    let cur = 0;
    const tick = () => {
        cur = Math.min(cur + step, target);
        el.textContent = cur.toLocaleString();
        if (cur < target) requestAnimationFrame(tick);
    };
    // Trigger when visible
    const obs = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) { tick(); obs.disconnect(); }
    }, { threshold: 0.5 });
    obs.observe(el);
});
</script>
@endpush
@endsection