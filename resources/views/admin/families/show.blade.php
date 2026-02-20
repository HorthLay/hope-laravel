{{-- resources/views/admin/families/show.blade.php --}}
@extends('admin.layouts.app')
@section('title', $family->name)
@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.families.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-arrow-left text-gray-600"></i>
    </a>
    <div class="flex-1"><h1 class="page-title">{{ $family->name }}</h1><p class="page-subtitle">Family Profile</p></div>
    <a href="{{ route('admin.families.edit', $family) }}" class="action-btn"><i class="fas fa-edit"></i><span>Edit</span></a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT sidebar --}}
    <div class="space-y-5">
        <div class="card overflow-hidden p-0">
            <div class="h-56 bg-orange-50 flex items-center justify-center overflow-hidden">
                @if($family->profile_photo)
                    <img src="{{ $family->profile_photo_url }}" class="w-full h-full object-cover">
                @else
                    <i class="fas fa-home text-6xl text-orange-200"></i>
                @endif
            </div>
            <div class="p-5 text-center">
                <h2 class="text-xl font-black text-gray-800">{{ $family->name }}</h2>
                <p class="font-mono text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded inline-block mt-1">{{ $family->code }}</p>
                <div class="flex justify-center gap-2 mt-2 flex-wrap">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $family->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-500' }}">
                        {{ $family->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    @if($family->country)
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-600">
                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $family->country }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-3 text-sm flex items-center gap-2"><i class="fas fa-chart-bar text-orange-500"></i> Overview</h3>
            <div class="space-y-2">
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-user-tie text-blue-400 w-4"></i>Sponsors</span>
                    <span class="text-sm font-bold text-gray-800">{{ $family->sponsors->count() }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-images text-pink-400 w-4"></i>Photos</span>
                    <span class="text-sm font-bold text-gray-800">{{ $family->media->where('type','photo')->count() }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-video text-purple-400 w-4"></i>Videos</span>
                    <span class="text-sm font-bold text-gray-800">{{ $family->media->where('type','video')->count() }}</span>
                </div>
                <div class="flex justify-between py-1.5">
                    <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-file text-yellow-400 w-4"></i>Documents</span>
                    <span class="text-sm font-bold text-gray-800">{{ $family->documents->count() }}</span>
                </div>
            </div>
        </div>

        {{-- Sponsors --}}
        <div class="card">
            <p class="text-xs font-black text-gray-500 uppercase tracking-wide mb-3 flex items-center gap-1.5">
                <i class="fas fa-user-tie text-blue-400"></i> Sponsors
                @if($family->sponsors->isNotEmpty())
                <span class="ml-auto px-2 py-0.5 bg-blue-100 text-blue-600 rounded-full text-[10px] font-black">{{ $family->sponsors->count() }}</span>
                @endif
            </p>
            @if($family->sponsors->isNotEmpty())
            <div class="space-y-2">
                @foreach($family->sponsors as $sponsor)
                <div class="flex items-center gap-3 p-2.5 bg-blue-50 rounded-xl border border-blue-100 hover:border-blue-300 transition group">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center font-black text-blue-600 text-sm flex-shrink-0">
                        {{ strtoupper(substr($sponsor->first_name,0,1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 text-sm truncate">{{ $sponsor->full_name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $sponsor->email }}</p>
                    </div>
                    <a href="{{ route('admin.sponsors.show', $sponsor) }}" class="w-7 h-7 flex items-center justify-center bg-blue-100 hover:bg-blue-200 text-blue-500 rounded-full transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-400 text-center py-3">No sponsors assigned.</p>
            @endif
        </div>

        {{-- Actions --}}
        <div class="card space-y-2">
            <a href="{{ route('admin.families.edit', $family) }}" class="flex items-center gap-3 w-full px-4 py-2.5 bg-orange-50 hover:bg-orange-100 text-orange-600 font-semibold rounded-xl transition text-sm">
                <i class="fas fa-edit w-4 text-center"></i> Edit Family
            </a>
            <form action="{{ route('admin.families.destroy', $family) }}" method="POST" onsubmit="return confirm('Delete {{ addslashes($family->name) }}?')">
                @csrf @method('DELETE')
                <button class="flex items-center gap-3 w-full px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition text-sm">
                    <i class="fas fa-trash w-4 text-center"></i> Delete Family
                </button>
            </form>
        </div>
    </div>

    {{-- RIGHT main --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Story --}}
        @if($family->story)
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-book-open text-purple-400"></i> Story</h3>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $family->story }}</p>
        </div>
        @endif

        {{-- Photo gallery --}}
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-images text-pink-400"></i> Media Gallery
                @if($family->media->isNotEmpty())
                <span class="ml-1 px-2 py-0.5 bg-pink-100 text-pink-600 rounded-full text-xs font-black">{{ $family->media->count() }}</span>
                @endif
            </h3>
            @if($family->media->isNotEmpty())
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                @foreach($family->media->take(8) as $m)
                <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                    <img src="{{ $m->file_url }}" alt="{{ $m->caption }}" class="w-full h-full object-cover hover:scale-110 transition duration-300">
                </div>
                @endforeach
                @if($family->media->count() > 8)
                <div class="aspect-square rounded-xl bg-gray-100 flex items-center justify-center">
                    <p class="text-xs font-bold text-gray-500 text-center">+{{ $family->media->count()-8 }}<br>more</p>
                </div>
                @endif
            </div>
            @else
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <i class="fas fa-images text-2xl text-gray-200 mb-2 block"></i>
                <p class="text-sm text-gray-400">No media yet.</p>
            </div>
            @endif
        </div>

        {{-- Documents --}}
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-folder text-yellow-400"></i> Documents
                @if($family->documents->isNotEmpty())
                <span class="ml-1 px-2 py-0.5 bg-yellow-100 text-yellow-600 rounded-full text-xs font-black">{{ $family->documents->count() }}</span>
                @endif
            </h3>
            @forelse($family->documents as $doc)
            <a href="{{ asset($doc->file_path) }}" target="_blank"
               class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-orange-200 hover:bg-orange-50 transition mb-2 last:mb-0 group">
                <div class="w-9 h-9 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-file-pdf text-yellow-500 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-700 truncate group-hover:text-orange-600">{{ $doc->title }}</p>
                    @if($doc->document_date)<p class="text-xs text-gray-400">{{ $doc->document_date->format('d M Y') }}</p>@endif
                </div>
                <i class="fas fa-download text-xs text-gray-400 group-hover:text-orange-400"></i>
            </a>
            @empty
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <i class="fas fa-folder-open text-2xl text-gray-200 mb-2 block"></i>
                <p class="text-sm text-gray-400">No documents yet.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection