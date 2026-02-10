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
        <i class="fas fa-plus"></i>
        <span>Create Article</span>
    </a>
</div>

<!-- Filters -->
<div class="card mb-6">
    <form action="{{ route('admin.articles.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <!-- Search -->
        <div class="flex-1">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search articles..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            </div>
        </div>

        <!-- Status Filter -->
        <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            <option value="">All Status</option>
            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
        </select>

        <!-- Category Filter -->
        <select name="category" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            <option value="">All Categories</option>
            @foreach($categories ?? [] as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <!-- Filter Button -->
        <button type="submit" class="px-6 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition font-medium">
            <i class="fas fa-filter mr-2"></i>
            Filter
        </button>
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
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Views</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Date</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($articles ?? [] as $article)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($article->image)
                                    <img src="{{ $article->image->thumbnail_url }}" 
                                         alt="{{ $article->title }}" 
                                         class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-gray-800 truncate">{{ $article->title }}</h4>
                                    <p class="text-sm text-gray-500">By {{ $article->admin->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            @if($article->category)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" 
                                      style="background-color: {{ $article->category->color }}20; color: {{ $article->category->color }};">
                                    <i class="{{ $article->category->icon }} mr-1.5"></i>
                                    {{ $article->category->name }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm">No category</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 hidden lg:table-cell">
                            <div class="flex items-center gap-2 text-gray-600">
                                <i class="fas fa-eye text-sm"></i>
                                <span class="font-medium">{{ number_format($article->views_count) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($article->status === 'published')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Published</span>
                            @elseif($article->status === 'draft')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Draft</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">Archived</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 hidden lg:table-cell">
                            <div class="text-sm text-gray-600">
                                {{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.articles.edit', $article) }}" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this article?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" 
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-newspaper text-gray-300 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">No articles found</h3>
                            <p class="text-gray-500 mb-6">Get started by creating your first article</p>
                            <a href="{{ route('admin.articles.create') }}" class="action-btn">
                                <i class="fas fa-plus"></i>
                                <span>Create Article</span>
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($articles) && $articles->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $articles->links() }}
        </div>
    @endif
</div>

<!-- Mobile Action Button -->
<a href="{{ route('admin.articles.create') }}" class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform z-50">
    <i class="fas fa-plus text-xl"></i>
</a>
@endsection