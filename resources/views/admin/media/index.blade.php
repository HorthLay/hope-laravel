{{-- resources/views/admin/media/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Media Library')

@section('content')
<!-- Page Header -->
<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="page-title">Media Library</h1>
        <p class="page-subtitle">Manage your images and files</p>
    </div>

    <button onclick="document.getElementById('upload-modal').classList.remove('hidden')" class="action-btn">
        <i class="fas fa-upload"></i>
        <span>Upload Images</span>
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Images -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-images text-blue-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_images']) }}</h3>
        <p class="text-gray-600 text-sm">Total Images</p>
    </div>

    <!-- Total Storage -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-hdd text-purple-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ App\Helpers\NumberHelper::formatBytes($stats['total_size']) }}</h3>
        <p class="text-gray-600 text-sm">Total Storage</p>
    </div>

    <!-- This Month -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar text-green-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ number_format($stats['images_this_month']) }}</h3>
        <p class="text-gray-600 text-sm">Uploaded This Month</p>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <form action="{{ route('admin.media.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <!-- Search -->
        <div class="flex-1">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search images..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            </div>
        </div>

        <!-- Type Filter -->
        <select name="type" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            <option value="">All Types</option>
            <option value="image/jpeg" {{ request('type') == 'image/jpeg' ? 'selected' : '' }}>JPEG</option>
            <option value="image/png" {{ request('type') == 'image/png' ? 'selected' : '' }}>PNG</option>
            <option value="image/gif" {{ request('type') == 'image/gif' ? 'selected' : '' }}>GIF</option>
            <option value="image/webp" {{ request('type') == 'image/webp' ? 'selected' : '' }}>WebP</option>
        </select>

        <!-- Sort -->
        <select name="sort" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First</option>
            <option value="file_size" {{ request('sort') == 'file_size' ? 'selected' : '' }}>Size</option>
            <option value="file_name" {{ request('sort') == 'file_name' ? 'selected' : '' }}>Name</option>
        </select>

        <!-- Filter Button -->
        <button type="submit" class="px-6 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition font-medium">
            <i class="fas fa-filter mr-2"></i>
            Filter
        </button>

        @if(request()->hasAny(['search', 'type', 'sort']))
            <a href="{{ route('admin.media.index') }}" 
               class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                <i class="fas fa-times mr-2"></i>
                Clear
            </a>
        @endif
    </form>
</div>

<!-- Images Grid -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-8">
    @forelse($images as $image)
        <div class="card p-0 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <!-- Image -->
            <div class="relative aspect-square bg-gray-100">
                <img src="{{ $image->thumbnail_url }}" 
                     alt="{{ $image->alt_text ?? $image->file_name }}" 
                     class="w-full h-full object-cover cursor-pointer"
                     onclick="openImageModal({{ $image->id }})">
                
                <!-- Overlay on Hover -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <div class="flex items-center gap-2">
                        <button onclick="openImageModal({{ $image->id }})" 
                                class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition"
                                title="View">
                            <i class="fas fa-eye text-gray-700"></i>
                        </button>
                        <button onclick="copyImageUrl('{{ $image->url }}')" 
                                class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition"
                                title="Copy URL">
                            <i class="fas fa-copy text-gray-700"></i>
                        </button>
                        <form action="{{ route('admin.media.destroy', $image) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this image?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-red-50 transition"
                                    title="Delete">
                                <i class="fas fa-trash text-red-600"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="p-3">
                <p class="text-xs font-medium text-gray-800 truncate" title="{{ $image->file_name }}">
                    {{ $image->file_name }}
                </p>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-xs text-gray-500">{{ $image->file_size_formatted }}</span>
                    <span class="text-xs text-gray-400">{{ $image->created_at->format('M d') }}</span>
                </div>
            </div>
        </div>

        <!-- Image Detail Modal -->
        <div id="image-modal-{{ $image->id }}" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeImageModal({{ $image->id }})">
            <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-auto" onclick="event.stopPropagation()">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="font-bold text-gray-800">Image Details</h3>
                    <button onclick="closeImageModal({{ $image->id }})" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                    <!-- Image Preview -->
                    <div>
                        <img src="{{ $image->url }}" alt="{{ $image->alt_text }}" class="w-full rounded-lg">
                    </div>

                    <!-- Image Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">File Name</label>
                            <p class="text-gray-600 break-all">{{ $image->file_name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">File URL</label>
                            <div class="flex gap-2">
                                <input type="text" 
                                       id="url-{{ $image->id }}"
                                       value="{{ $image->url }}" 
                                       readonly
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <button onclick="copyImageUrl('{{ $image->url }}')" 
                                        class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Size</label>
                                <p class="text-gray-600">{{ $image->file_size_formatted }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Type</label>
                                <p class="text-gray-600">{{ strtoupper(pathinfo($image->file_name, PATHINFO_EXTENSION)) }}</p>
                            </div>
                        </div>

                        @if($image->width && $image->height)
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Dimensions</label>
                                <p class="text-gray-600">{{ $image->width }} × {{ $image->height }} px</p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Uploaded</label>
                            <p class="text-gray-600">{{ $image->created_at->format('M d, Y H:i') }}</p>
                        </div>

                        <!-- Actions -->
                        <div class="pt-4 border-t space-y-2">
                            <a href="{{ $image->url }}" 
                               target="_blank"
                               class="block w-full px-4 py-2 bg-blue-500 text-white text-center rounded-lg hover:bg-blue-600 transition">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Open in New Tab
                            </a>
                            
                            <form action="{{ route('admin.media.destroy', $image) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this image?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete Image
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="card text-center py-16">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-images text-gray-300 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No images found</h3>
                <p class="text-gray-500 mb-6">Upload your first image to get started</p>
                <button onclick="document.getElementById('upload-modal').classList.remove('hidden')" class="action-btn">
                    <i class="fas fa-upload"></i>
                    <span>Upload Images</span>
                </button>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($images->hasPages())
    <div class="flex justify-center">
        {{ $images->links() }}
    </div>
@endif

<!-- Upload Modal -->
<div id="upload-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full">
        <div class="flex items-center justify-between p-6 border-b">
            <h3 class="text-xl font-bold text-gray-800">Upload Images</h3>
            <button onclick="document.getElementById('upload-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center hover:border-orange-500 transition">
                <input type="file" 
                       name="images[]" 
                       id="image-upload"
                       multiple
                       accept="image/*"
                       class="hidden"
                       onchange="previewImages(event)">
                
                <label for="image-upload" class="cursor-pointer">
                    <i class="fas fa-cloud-upload-alt text-6xl text-gray-400 mb-4"></i>
                    <p class="text-lg text-gray-600 mb-2">Click to upload images</p>
                    <p class="text-sm text-gray-400">JPG, PNG, GIF, WebP (Max 5MB each)</p>
                </label>
            </div>

            <!-- Preview Area -->
            <div id="preview-container" class="hidden mt-6 grid grid-cols-4 gap-4"></div>

            <div class="flex items-center justify-end gap-4 mt-6">
                <button type="button" 
                        onclick="document.getElementById('upload-modal').classList.add('hidden')"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="action-btn">
                    <i class="fas fa-upload mr-2"></i>
                    Upload Images
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openImageModal(id) {
    document.getElementById('image-modal-' + id).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal(id) {
    document.getElementById('image-modal-' + id).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function copyImageUrl(url) {
    navigator.clipboard.writeText(url).then(function() {
        alert('URL copied to clipboard!');
    });
}

function previewImages(event) {
    const files = event.target.files;
    const container = document.getElementById('preview-container');
    container.innerHTML = '';
    
    if (files.length > 0) {
        container.classList.remove('hidden');
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-square bg-gray-100 rounded-lg overflow-hidden';
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                container.appendChild(div);
            }
            
            reader.readAsDataURL(file);
        }
    } else {
        container.classList.add('hidden');
    }
}
</script>
@endpush

@endsection