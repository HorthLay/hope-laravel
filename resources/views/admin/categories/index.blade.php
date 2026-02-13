@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<!-- Page Header -->
<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="page-title">Categories</h1>
        <p class="page-subtitle">Organize your articles with categories</p>
    </div>

    <a href="{{ route('admin.categories.create') }}" class="action-btn">
        <i class="fas fa-plus"></i>
        <span>Add Category</span>
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Categories -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fas fa-folder text-orange-500 text-xl"></i>
            </div>
            <span class="text-orange-500 text-sm font-semibold">Total</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $totalCategories }}</h3>
        <p class="text-gray-600 text-sm">Total Categories</p>
    </div>

    <!-- Active Categories -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
            <span class="text-green-500 text-sm font-semibold">Active</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $activeCategories }}</h3>
        <p class="text-gray-600 text-sm">With Articles</p>
    </div>

    <!-- Empty Categories -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-folder-open text-gray-500 text-xl"></i>
            </div>
            <span class="text-gray-500 text-sm font-semibold">Empty</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $emptyCategories }}</h3>
        <p class="text-gray-600 text-sm">No Articles</p>
    </div>

    <!-- Total Articles -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-newspaper text-blue-500 text-xl"></i>
            </div>
            <span class="text-blue-500 text-sm font-semibold">Articles</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $totalArticles }}</h3>
        <p class="text-gray-600 text-sm">Total Articles</p>
    </div>
</div>

<!-- Search -->
<div class="card mb-6">
    <form action="{{ route('admin.categories.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search categories..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            </div>
        </div>

        <button type="submit" class="px-6 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition font-medium">
            <i class="fas fa-search mr-2"></i>
            Search
        </button>

        @if(request('search'))
            <a href="{{ route('admin.categories.index') }}" 
               class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                <i class="fas fa-times mr-2"></i>
                Clear
            </a>
        @endif
    </form>
</div>

<!-- Categories Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
    @forelse($categories as $category)
        <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
            <!-- Category Icon & Color -->
            <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110" 
                     style="background-color: {{ $category->color }}20;">
                    <i class="{{ $category->icon }} text-2xl" style="color: {{ $category->color }};"></i>
                </div>
                
                <!-- Action Dropdown -->
                <div class="relative">
                    <button class="text-gray-400 hover:text-gray-600 p-2" onclick="toggleDropdown(event, 'dropdown-{{ $category->id }}')">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div id="dropdown-{{ $category->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-edit mr-2 text-blue-500"></i>Edit
                        </a>
                        <a href="{{ route('admin.categories.show', $category) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-eye mr-2 text-green-500"></i>View Details
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-trash mr-2"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Category Info -->
            <h3 class="font-bold text-gray-800 text-lg mb-2 truncate">{{ $category->name }}</h3>
            
            @if($category->description)
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $category->description }}</p>
            @else
                <p class="text-gray-400 text-sm italic mb-4">No description</p>
            @endif

            <!-- Stats -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-newspaper text-gray-400 text-sm"></i>
                    <span class="text-sm font-semibold text-gray-700">{{ $category->articles_count }} articles</span>
                </div>
                
                <a href="{{ route('admin.categories.edit', $category) }}" 
                   class="text-orange-500 hover:text-orange-600 text-sm font-semibold flex items-center gap-1">
                    Edit <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="card text-center py-16">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-folder text-gray-300 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No categories found</h3>
                <p class="text-gray-500 mb-6">
                    @if(request('search'))
                        No categories match your search. Try adjusting your filters.
                    @else
                        Get started by creating your first category
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('admin.categories.index') }}" class="action-btn">
                        <i class="fas fa-times mr-2"></i>
                        Clear Search
                    </a>
                @else
                    <a href="{{ route('admin.categories.create') }}" class="action-btn">
                        <i class="fas fa-plus"></i>
                        <span>Add Category</span>
                    </a>
                @endif
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($categories->hasPages())
    <div class="flex justify-center">
        {{ $categories->links() }}
    </div>
@endif

<!-- Mobile Action Button -->
<a href="{{ route('admin.categories.create') }}" class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform z-50">
    <i class="fas fa-plus text-xl"></i>
</a>

@push('scripts')
<script>
function toggleDropdown(event, id) {
    event.stopPropagation();
    const dropdown = document.getElementById(id);
    const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
    
    // Close all other dropdowns
    allDropdowns.forEach(d => {
        if (d.id !== id) {
            d.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[id^="dropdown-"]') && !event.target.closest('button')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
            d.classList.add('hidden');
        });
    }
});
</script>
@endpush

@endsection