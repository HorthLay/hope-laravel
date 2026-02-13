{{-- resources/views/admin/categories/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Category Details')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div class="flex-1">
            <h1 class="page-title">Category Details</h1>
            <p class="page-subtitle">View category information and articles</p>
        </div>
        <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn">
            <i class="fas fa-edit"></i>
            <span>Edit Category</span>
        </a>
    </div>
</div>

<!-- Category Overview -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Category Info -->
    <div class="lg:col-span-1">
        <div class="card text-center">
            <!-- Icon -->
            <div class="w-24 h-24 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background-color: {{ $category->color }}20;">
                <i class="{{ $category->icon }} text-5xl" style="color: {{ $category->color }};"></i>
            </div>

            <!-- Name & Badge -->
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $category->name }}</h2>
            <div class="flex justify-center mb-4">
                <span class="px-3 py-1 text-sm font-semibold rounded-full" style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                    <i class="{{ $category->icon }} mr-1"></i>
                    {{ $category->slug }}
                </span>
            </div>

            <!-- Description -->
            @if($category->description)
                <p class="text-gray-600 text-sm mb-6">{{ $category->description }}</p>
            @else
                <p class="text-gray-400 text-sm italic mb-6">No description provided</p>
            @endif

            <!-- Details -->
            <div class="pt-6 border-t border-gray-200">
                <div class="space-y-3 text-left">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $category->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $category->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Icon</span>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $category->icon }}</code>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Color</span>
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded border border-gray-300" style="background-color: {{ $category->color }};"></div>
                            <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $category->color }}</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats & Articles -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Statistics -->
        <div class="card">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-bar text-orange-500"></i>
                Statistics
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-newspaper text-white text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-blue-600 mb-1">{{ $stats['total_articles'] }}</p>
                    <p class="text-sm text-gray-600">Total Articles</p>
                </div>

                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-green-600 mb-1">{{ $stats['published_articles'] }}</p>
                    <p class="text-sm text-gray-600">Published</p>
                </div>

                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-file-alt text-white text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-yellow-600 mb-1">{{ $stats['draft_articles'] }}</p>
                    <p class="text-sm text-gray-600">Drafts</p>
                </div>

                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-eye text-white text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-purple-600 mb-1">{{ App\Helpers\NumberHelper::formatNumber($stats['total_views']) }}</p>
                    <p class="text-sm text-gray-600">Total Views</p>
                </div>
            </div>
        </div>

        <!-- Recent Articles -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-newspaper text-orange-500"></i>
                    Articles in This Category
                </h3>
                @if($category->articles()->count() > 0)
                    <a href="{{ route('admin.articles.index') }}?category={{ $category->id }}" class="text-orange-500 hover:text-orange-600 font-semibold text-sm">
                        View All →
                    </a>
                @endif
            </div>

            <div class="space-y-3">
                @forelse($category->articles as $article)
                    <a href="{{ route('admin.articles.edit', $article) }}" class="flex items-center gap-4 p-4 hover:bg-gray-50 rounded-lg transition">
                        @if($article->image)
                            <img src="{{ $article->image->thumbnail_url }}" class="w-16 h-16 rounded-lg object-cover">
                        @else
                            <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-800 truncate">{{ $article->title }}</h4>
                            <p class="text-sm text-gray-500">
                                By {{ $article->admin->name }} • {{ $article->created_at->format('M d, Y') }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-700">{{ App\Helpers\NumberHelper::formatNumber($article->views_count) }}</p>
                                <p class="text-xs text-gray-500">views</p>
                            </div>

                            @if($article->status === 'published')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Published</span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Draft</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-newspaper text-gray-300 text-3xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-700 mb-2">No Articles Yet</h4>
                        <p class="text-gray-500 mb-6">This category doesn't have any articles yet.</p>
                        <a href="{{ route('admin.articles.create') }}" class="action-btn">
                            <i class="fas fa-plus mr-2"></i>
                            Create Article
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex items-center gap-4">
    <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn">
        <i class="fas fa-edit mr-2"></i>
        Edit Category
    </a>

    <form action="{{ route('admin.categories.destroy', $category) }}" 
          method="POST" 
          class="inline"
          onsubmit="return confirm('Are you sure you want to delete this category?\n\nThis action cannot be undone.')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold"
                {{ $category->articles()->count() > 0 ? 'disabled' : '' }}>
            <i class="fas fa-trash mr-2"></i>
            Delete Category
        </button>
    </form>

    @if($category->articles()->count() > 0)
        <p class="text-sm text-gray-500">
            <i class="fas fa-info-circle mr-1"></i>
            Cannot delete category with articles
        </p>
    @endif
</div>

@endsection