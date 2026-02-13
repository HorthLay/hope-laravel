@extends('admin.layouts.app')

@section('title', 'Add Category')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="page-title">Add New Category</h1>
            <p class="page-subtitle">Create a new category for your articles</p>
        </div>
    </div>
</div>

<!-- Form -->
<div class="max-w-3xl">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
        @csrf

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
                           value="{{ old('name') }}"
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
                           value="{{ old('slug') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('slug') border-red-500 @enderror"
                           placeholder="education-health-community">
                    <p class="mt-2 text-xs text-gray-500">Used in URL: /category/your-slug</p>
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
                              placeholder="Brief description of this category...">{{ old('description') }}</textarea>
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
                               value="{{ old('icon', 'fas fa-folder') }}"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('icon') border-red-500 @enderror"
                               placeholder="fas fa-folder"
                               onkeyup="updateIconPreview()">
                        <div id="icon-preview" class="w-14 h-14 border-2 border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                            <i class="fas fa-folder text-2xl text-gray-600"></i>
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
                               value="{{ old('color', '#f97316') }}"
                               class="w-14 h-14 border-2 border-gray-300 rounded-lg cursor-pointer"
                               onchange="updateColorPreview()">
                        <input type="text" 
                               id="color-hex"
                               value="{{ old('color', '#f97316') }}"
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
                    <div id="category-preview" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium" style="background-color: #f9731620; color: #f97316;">
                        <i class="fas fa-folder mr-2"></i>
                        <span id="preview-name">Category Name</span>
                    </div>
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
                Create Category
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