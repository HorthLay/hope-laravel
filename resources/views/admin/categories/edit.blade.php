{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="page-title">Edit Category</h1>
            <p class="page-subtitle">Update category details</p>
        </div>
    </div>
</div>

<!-- Current Category Info -->
<div class="max-w-3xl mb-6">
    <div class="card bg-gradient-to-br from-orange-50 to-orange-100 border-orange-200">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl flex items-center justify-center" style="background-color: {{ $category->color }}20;">
                <i class="{{ $category->icon }} text-3xl" style="color: {{ $category->color }};"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-lg">{{ $category->name }}</h3>
                <p class="text-sm text-gray-600">{{ $category->articles()->count() }} articles in this category</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="px-2 py-1 text-xs font-semibold rounded" style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                        <i class="{{ $category->icon }} mr-1"></i>
                        {{ $category->slug }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
<div class="max-w-3xl">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="card">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-info-circle text-orange-500"></i>
                Basic Information
            </h2>

            <div class="space-y-5">
                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name"
                           name="name" 
                           value="{{ old('name', $category->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('name') border-red-500 @enderror"
                           placeholder="e.g., Education, Health, Community"
                           required
                           onkeyup="generateSlug()">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                        Slug
                        <span class="text-xs text-gray-500 font-normal">(Auto-generated from name)</span>
                    </label>
                    <input type="text" 
                           id="slug"
                           name="slug" 
                           value="{{ old('slug', $category->slug) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('slug') border-red-500 @enderror"
                           placeholder="education-health-community">
                    <p class="mt-2 text-xs text-gray-500">Used in URL: /category/{{ $category->slug }}</p>
                    @error('slug')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description"
                              name="description" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('description') border-red-500 @enderror"
                              placeholder="Brief description of this category...">{{ old('description', $category->description) }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">Maximum 500 characters</p>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Appearance -->
        <div class="card">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-palette text-orange-500"></i>
                Appearance
            </h2>

            <div class="space-y-5">
                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">
                        Icon
                    </label>
                    <div class="flex gap-4">
                        <input type="text" 
                               id="icon"
                               name="icon" 
                               value="{{ old('icon', $category->icon) }}"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('icon') border-red-500 @enderror"
                               placeholder="fas fa-folder"
                               onkeyup="updateIconPreview()">
                        <div id="icon-preview" class="w-14 h-14 border-2 border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                            <i class="{{ $category->icon }} text-2xl text-gray-600"></i>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Use Font Awesome icons. 
                        <a href="https://fontawesome.com/icons" target="_blank" class="text-orange-500 hover:text-orange-600">Browse icons →</a>
                    </p>
                    @error('icon')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">
                        Color
                    </label>
                    <div class="flex gap-4">
                        <input type="color" 
                               id="color"
                               name="color" 
                               value="{{ old('color', $category->color) }}"
                               class="w-14 h-14 border-2 border-gray-300 rounded-lg cursor-pointer"
                               onchange="updateColorPreview()">
                        <input type="text" 
                               id="color-hex"
                               value="{{ old('color', $category->color) }}"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="#f97316"
                               readonly>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">This color will be used for the category badge and icon</p>
                    @error('color')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview -->
                <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm font-semibold text-gray-700 mb-4">Preview:</p>
                    <div id="category-preview" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium" style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                        <i class="{{ $category->icon }} mr-2"></i>
                        <span id="preview-name">{{ $category->name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Statistics -->
        <div class="card bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-line text-orange-500"></i>
                Category Statistics
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Total Articles</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $category->articles()->count() }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Published</p>
                    <p class="text-2xl font-bold text-green-600">{{ $category->articles()->where('status', 'published')->count() }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Drafts</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $category->articles()->where('status', 'draft')->count() }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Created</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $category->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('admin.categories.index') }}" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>

            <button type="submit" 
                    class="action-btn">
                <i class="fas fa-save mr-2"></i>
                Update Category
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function generateSlug() {
    const name = document.getElementById('name').value;
    const slug = name.toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    document.getElementById('slug').value = slug;
    updatePreview();
}

function updateIconPreview() {
    const icon = document.getElementById('icon').value;
    const preview = document.getElementById('icon-preview').querySelector('i');
    preview.className = icon + ' text-2xl text-gray-600';
    updatePreview();
}

function updateColorPreview() {
    const color = document.getElementById('color').value;
    document.getElementById('color-hex').value = color;
    updatePreview();
}

function updatePreview() {
    const name = document.getElementById('name').value || 'Category Name';
    const icon = document.getElementById('icon').value || 'fas fa-folder';
    const color = document.getElementById('color').value || '#f97316';
    
    const preview = document.getElementById('category-preview');
    preview.style.backgroundColor = color + '20';
    preview.style.color = color;
    preview.querySelector('i').className = icon + ' mr-2';
    preview.querySelector('#preview-name').textContent = name;
}

// Initialize preview
document.addEventListener('DOMContentLoaded', function() {
    updatePreview();
});
</script>
@endpush

@endsection