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

{{-- Flash messages --}}
@if(session('success'))
<div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-5 text-sm font-medium">
    <i class="fas fa-check-circle text-green-500 flex-shrink-0"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-sm font-medium">
    <i class="fas fa-exclamation-circle text-red-500 flex-shrink-0"></i> {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-sm">
    <p class="font-bold flex items-center gap-2 mb-1">
        <i class="fas fa-exclamation-triangle text-red-500"></i> Please fix the following:
    </p>
    <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── LEFT sidebar ── --}}
    <div class="space-y-5">

        {{-- Photo card --}}
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
            <h3 class="font-bold text-gray-800 mb-3 text-sm flex items-center gap-2">
                <i class="fas fa-chart-bar text-orange-500"></i> Overview
            </h3>
            <div class="space-y-2">
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-users text-orange-400 w-4"></i>Members</span>
                    <span class="text-sm font-bold text-gray-800">{{ $family->members->count() }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-user-tie text-blue-400 w-4"></i>Sponsors</span>
                    <span class="text-sm font-bold text-gray-800">{{ $family->sponsors->count() }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-clipboard-list text-green-400 w-4"></i>Updates</span>
                    <span class="text-sm font-bold text-gray-800">{{ $family->updates->count() }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-newspaper text-purple-400 w-4"></i>Articles</span>
                    <span class="text-sm font-bold text-gray-800">{{ $family->articles->count() }}</span>
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

    {{-- ── RIGHT main ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Story --}}
        @if($family->story)
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                <i class="fas fa-book-open text-purple-400"></i> Story
            </h3>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $family->story }}</p>
        </div>
        @endif

        {{-- ── MEMBERS ── --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-users text-orange-500"></i> Members
                    @if($family->members->isNotEmpty())
                    <span class="ml-1 px-2 py-0.5 bg-orange-100 text-orange-600 rounded-full text-xs font-black">
                        {{ $family->members->count() }}
                    </span>
                    @endif
                </h3>
                <a href="{{ route('admin.family-members.create', ['family_id' => $family->id]) }}"
                   class="flex items-center gap-1.5 px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold rounded-lg transition shadow-sm">
                    <i class="fas fa-plus"></i> Add Member
                </a>
            </div>

            @if($family->members->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($family->members as $member)
                <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-orange-200 hover:bg-orange-50 transition group">
                    @if($member->profile_photo)
                    <img src="{{ asset($member->profile_photo) }}"
                         class="w-12 h-12 rounded-full object-cover flex-shrink-0 border-2 border-gray-200">
                    @else
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <span class="font-black text-white text-lg">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                    </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 text-sm truncate">{{ $member->name }}</p>
                        <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                            <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-full">{{ $member->relationship }}</span>
                            @if(!$member->is_active)
                            <span class="px-2 py-0.5 bg-red-50 text-red-500 text-[10px] font-bold rounded-full">Inactive</span>
                            @endif
                        </div>
                        @if($member->phone)
                        <p class="text-xs text-gray-400 mt-0.5 truncate"><i class="fas fa-phone text-gray-300 mr-1"></i>{{ $member->phone }}</p>
                        @endif
                    </div>
                    <div class="flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('admin.family-members.show', $member) }}"
                           class="w-7 h-7 flex items-center justify-center bg-blue-100 hover:bg-blue-200 text-blue-500 rounded-full" title="View">
                            <i class="fas fa-eye text-[10px]"></i>
                        </a>
                        <a href="{{ route('admin.family-members.edit', $member) }}"
                           class="w-7 h-7 flex items-center justify-center bg-orange-100 hover:bg-orange-200 text-orange-500 rounded-full" title="Edit">
                            <i class="fas fa-edit text-[10px]"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <i class="fas fa-users text-3xl text-gray-200 mb-2 block"></i>
                <p class="text-sm text-gray-400">No members in this family yet.</p>
                <a href="{{ route('admin.family-members.create', ['family_id' => $family->id]) }}"
                   class="mt-2 inline-block text-orange-500 text-sm hover:underline font-semibold">Add the first member →</a>
            </div>
            @endif
        </div>

        {{-- ── UPDATES ── --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-green-400"></i> Updates
                    @if($family->updates->count())
                    <span class="ml-1 px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-black">
                        {{ $family->updates->count() }}
                    </span>
                    @endif
                </h3>
                <button type="button" onclick="openModal('modal-add-update')"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg transition shadow-sm">
                    <i class="fas fa-plus"></i> Add Update
                </button>
            </div>

            @forelse($family->updates->sortByDesc('report_date')->take(5) as $update)
            <div class="flex gap-3 pb-3 mb-3 border-b border-gray-50 last:border-0 last:mb-0 last:pb-0 group">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                    <i class="fas fa-file-alt text-green-500 text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    @if(!empty($update->title))
                    <p class="text-sm font-bold text-gray-700 leading-tight">{{ $update->title }}</p>
                    @endif
                    <p class="text-xs font-bold text-gray-400 mt-0.5">
                        {{ isset($update->report_date) ? \Carbon\Carbon::parse($update->report_date)->format('d M Y') : $update->created_at->format('d M Y') }}
                        @if($update->type) · <span class="capitalize">{{ $update->type }}</span> @endif
                    </p>
                    <p class="text-sm text-gray-600 leading-relaxed mt-1 line-clamp-2">{{ $update->content ?? '—' }}</p>
                </div>
                <form method="POST"
                      action="{{ route('admin.families.updates.destroy', [$family, $update]) }}"
                      onsubmit="return confirm('Delete this update?')"
                      class="opacity-0 group-hover:opacity-100 transition flex-shrink-0">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-7 h-7 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-400 hover:text-red-600 rounded-full transition mt-0.5"
                            title="Delete update">
                        <i class="fas fa-trash-alt text-[10px]"></i>
                    </button>
                </form>
            </div>
            @empty
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <i class="fas fa-clipboard text-2xl text-gray-200 mb-2 block"></i>
                <p class="text-sm text-gray-400">No updates yet.</p>
            </div>
            @endforelse

            @if($family->updates->count() > 5)
            <p class="text-xs text-center text-gray-400 mt-2">+ {{ $family->updates->count() - 5 }} more updates</p>
            @endif
        </div>

        {{-- ── LINKED ARTICLES ── --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-newspaper text-purple-500"></i> Linked Articles
                    @if($family->articles->isNotEmpty())
                    <span class="ml-1 px-2 py-0.5 bg-purple-100 text-purple-600 rounded-full text-xs font-black">{{ $family->articles->count() }}</span>
                    @endif
                </h3>
                <a href="{{ route('admin.articles.create') }}"
                   class="flex items-center gap-1.5 px-3 py-1.5 bg-purple-500 hover:bg-purple-600 text-white text-xs font-bold rounded-lg transition shadow-sm">
                    <i class="fas fa-plus"></i> New Article
                </a>
            </div>

            @if($family->articles->isNotEmpty())
            <div class="space-y-2">
                @foreach($family->articles as $article)
                <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50 transition group">
                    @if(!empty($article->cover_image))
                    <img src="{{ asset($article->cover_image) }}"
                         class="w-14 h-14 rounded-xl object-cover flex-shrink-0 border border-gray-200">
                    @else
                    <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-newspaper text-purple-400 text-xl"></i>
                    </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 text-sm truncate group-hover:text-purple-700 transition">{{ $article->title }}</p>
                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                            @if(!empty($article->published_at))
                            <span class="text-xs text-gray-400">
                                <i class="fas fa-calendar text-gray-300 mr-1"></i>
                                {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}
                            </span>
                            @endif
                            @if(!empty($article->status))
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full
                                {{ $article->status === 'published' ? 'bg-green-100 text-green-700'
                                 : ($article->status === 'draft' ? 'bg-yellow-100 text-yellow-600'
                                 : 'bg-gray-100 text-gray-500') }}">
                                {{ ucfirst($article->status) }}
                            </span>
                            @endif
                        </div>
                        @if(!empty($article->excerpt))
                        <p class="text-xs text-gray-400 mt-1 line-clamp-1">{{ $article->excerpt }}</p>
                        @endif
                    </div>
                    <a href="{{ route('admin.articles.show', $article) }}"
                       class="w-8 h-8 flex items-center justify-center bg-purple-100 hover:bg-purple-200 text-purple-600 rounded-full transition opacity-0 group-hover:opacity-100 flex-shrink-0">
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <i class="fas fa-newspaper text-3xl text-gray-200 mb-2 block"></i>
                <p class="text-sm text-gray-400">No articles linked to this family yet.</p>
                <p class="text-xs text-gray-400 mt-1">Link this family when editing an article.</p>
            </div>
            @endif
        </div>

        {{-- ── MEDIA GALLERY ── --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-images text-pink-400"></i> Media Gallery
                    @if($family->media->isNotEmpty())
                    <span class="ml-1 px-2 py-0.5 bg-pink-100 text-pink-600 rounded-full text-xs font-black">{{ $family->media->count() }}</span>
                    @endif
                </h3>
                <button type="button" onclick="openModal('modal-add-media')"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold rounded-lg transition shadow-sm">
                    <i class="fas fa-upload"></i> Upload Media
                </button>
            </div>

            @if($family->media->isNotEmpty())
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                @foreach($family->media->take(8) as $m)
                <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 relative group cursor-pointer"
                     onclick="openPreview('{{ asset($m->file_path) }}', '{{ $m->type }}', '{{ addslashes($m->caption ?? '') }}')">
                    @if($m->type === 'video')
                        <video src="{{ asset($m->file_path) }}"
                               class="w-full h-full object-cover pointer-events-none"
                               muted playsinline
                               onmouseover="this.play()" onmouseout="this.pause();this.currentTime=0">
                        </video>
                        <div class="absolute top-1.5 left-1.5 bg-black/60 text-white rounded-md px-1.5 py-0.5 text-[9px] font-bold flex items-center gap-1 pointer-events-none">
                            <i class="fas fa-play text-[7px]"></i> VIDEO
                        </div>
                    @else
                        <img src="{{ asset($m->file_path) }}" alt="{{ $m->caption }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300 pointer-events-none">
                    @endif
                    {{-- hover overlay: preview icon + delete --}}
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <span class="w-8 h-8 bg-white/20 hover:bg-white/40 text-white rounded-full flex items-center justify-center transition"
                              title="Preview">
                            <i class="fas fa-expand text-xs"></i>
                        </span>
                        <form method="POST"
                              action="{{ route('admin.families.media.destroy', [$family, $m]) }}"
                              onsubmit="return confirm('Delete this media?')"
                              onclick="event.stopPropagation()">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center transition shadow"
                                    title="Delete">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </form>
                    </div>
                    @if($m->caption)
                    <p class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[9px] px-1.5 py-1 truncate pointer-events-none">{{ $m->caption }}</p>
                    @endif
                </div>
                @endforeach
                @if($family->media->count() > 8)
                <div class="aspect-square rounded-xl bg-gray-100 flex items-center justify-center">
                    <p class="text-xs font-bold text-gray-500 text-center">+{{ $family->media->count() - 8 }}<br>more</p>
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

        {{-- ── DOCUMENTS ── --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-folder text-yellow-400"></i> Documents
                    @if($family->documents->isNotEmpty())
                    <span class="ml-1 px-2 py-0.5 bg-yellow-100 text-yellow-600 rounded-full text-xs font-black">{{ $family->documents->count() }}</span>
                    @endif
                </h3>
                <button type="button" onclick="openModal('modal-add-document')"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold rounded-lg transition shadow-sm">
                    <i class="fas fa-upload"></i> Upload Document
                </button>
            </div>

            @forelse($family->documents as $doc)
            <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-orange-200 hover:bg-orange-50 transition mb-2 last:mb-0 group">
                <div class="w-9 h-9 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-file-pdf text-yellow-500 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{ asset($doc->file_path) }}" target="_blank"
                       class="text-sm font-bold text-gray-700 truncate group-hover:text-orange-600 block hover:underline">
                        {{ $doc->title }}
                    </a>
                    @if($doc->document_date)
                    <p class="text-xs text-gray-400">{{ $doc->document_date->format('d M Y') }}</p>
                    @endif
                    @if($doc->type)
                    <p class="text-[10px] font-bold text-gray-400 uppercase">{{ $doc->type }}</p>
                    @endif
                </div>
                <a href="{{ asset($doc->file_path) }}" target="_blank"
                   class="w-8 h-8 flex items-center justify-center bg-orange-100 hover:bg-orange-200 text-orange-500 rounded-full transition flex-shrink-0">
                    <i class="fas fa-download text-xs"></i>
                </a>
                <form method="POST"
                      action="{{ route('admin.families.documents.destroy', [$family, $doc]) }}"
                      onsubmit="return confirm('Delete this document?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-400 hover:text-red-600 rounded-full transition flex-shrink-0 opacity-0 group-hover:opacity-100"
                            title="Delete">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                </form>
            </div>
            @empty
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <i class="fas fa-folder-open text-2xl text-gray-200 mb-2 block"></i>
                <p class="text-sm text-gray-400">No documents yet.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════════════ --}}
{{-- MODALS                                         --}}
{{-- ══════════════════════════════════════════════ --}}

{{-- ── Modal: Add Update ── --}}
<div id="modal-add-update" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center p-4" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-black text-gray-800 flex items-center gap-2">
                <i class="fas fa-clipboard-list text-green-400"></i> Add Update
            </h3>
            <button type="button" onclick="closeModal('modal-add-update')"
                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.families.updates.store', $family) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Title <span class="text-gray-300 font-normal">(optional)</span></label>
                <input type="text" name="title" placeholder="e.g. Monthly Visit Report"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Type <span class="text-gray-300 font-normal">(optional)</span></label>
                <select name="type" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-transparent bg-white">
                    <option value="">— Select type —</option>
                    <option value="health">Health</option>
                    <option value="education">Education</option>
                    <option value="general">General</option>
                    <option value="financial">Financial</option>
                    <option value="visit">Visit</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Report Date <span class="text-gray-300 font-normal">(optional)</span></label>
                <input type="date" name="report_date"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Content <span class="text-red-400">*</span></label>
                <textarea name="content" rows="4" required placeholder="Write the update content here..."
                          class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-transparent resize-none"></textarea>
            </div>
            <div class="flex gap-3 pt-1">
                <button type="button" onclick="closeModal('modal-add-update')"
                        class="flex-1 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-green-500 hover:bg-green-600 text-white font-bold text-sm transition shadow-sm">
                    <i class="fas fa-check mr-1.5"></i> Save Update
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal: Upload Media ── --}}
<div id="modal-add-media" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center p-4" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-black text-gray-800 flex items-center gap-2">
                <i class="fas fa-images text-pink-400"></i> Upload Media
            </h3>
            <button type="button" onclick="closeModal('modal-add-media')"
                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.families.media.store', $family) }}"
              enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">
                    File <span class="text-red-400">*</span>
                    <span class="text-gray-300 font-normal ml-1">jpg, png, gif, webp, mp4, mov — max 20 MB</span>
                </label>
                <label for="family-media-input"
                       class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-pink-200 bg-pink-50 rounded-xl cursor-pointer hover:bg-pink-100 hover:border-pink-300 transition">
                    <i class="fas fa-cloud-upload-alt text-pink-300 text-2xl mb-1"></i>
                    <span class="text-xs text-pink-400 font-semibold" id="family-media-label">Click to choose file</span>
                </label>
                <input type="file" id="family-media-input" name="file"
                       accept="image/*,video/mp4,video/quicktime" required class="hidden"
                       onchange="document.getElementById('family-media-label').textContent = this.files[0]?.name || 'Click to choose file'">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Caption <span class="text-gray-300 font-normal">(optional)</span></label>
                <input type="text" name="caption" placeholder="Short description..."
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Date Taken <span class="text-gray-300 font-normal">(optional)</span></label>
                <input type="date" name="taken_date"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent">
            </div>
            <div class="flex gap-3 pt-1">
                <button type="button" onclick="closeModal('modal-add-media')"
                        class="flex-1 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm transition shadow-sm">
                    <i class="fas fa-upload mr-1.5"></i> Upload
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal: Upload Document ── --}}
<div id="modal-add-document" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center p-4" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-black text-gray-800 flex items-center gap-2">
                <i class="fas fa-folder text-yellow-400"></i> Upload Document
            </h3>
            <button type="button" onclick="closeModal('modal-add-document')"
                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.families.documents.store', $family) }}"
              enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">
                    File <span class="text-red-400">*</span>
                    <span class="text-gray-300 font-normal ml-1">pdf, doc, docx, xls, xlsx, jpg, png — max 10 MB</span>
                </label>
                <label for="family-doc-input"
                       class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-yellow-200 bg-yellow-50 rounded-xl cursor-pointer hover:bg-yellow-100 hover:border-yellow-300 transition">
                    <i class="fas fa-file-upload text-yellow-300 text-2xl mb-1"></i>
                    <span class="text-xs text-yellow-500 font-semibold" id="family-doc-label">Click to choose file</span>
                </label>
                <input type="file" id="family-doc-input" name="file"
                       accept=".pdf,.doc,.docx,.xls,.xlsx,image/*" required class="hidden"
                       onchange="document.getElementById('family-doc-label').textContent = this.files[0]?.name || 'Click to choose file'">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" required placeholder="e.g. Family Agreement"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Type <span class="text-gray-300 font-normal">(optional)</span></label>
                <select name="type" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent bg-white">
                    <option value="">— Select type —</option>
                    <option value="id">Identification</option>
                    <option value="medical">Medical</option>
                    <option value="legal">Legal</option>
                    <option value="financial">Financial</option>
                    <option value="agreement">Agreement</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Document Date <span class="text-gray-300 font-normal">(optional)</span></label>
                <input type="date" name="document_date"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent">
            </div>
            <div class="flex gap-3 pt-1">
                <button type="button" onclick="closeModal('modal-add-document')"
                        class="flex-1 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-white font-bold text-sm transition shadow-sm">
                    <i class="fas fa-upload mr-1.5"></i> Upload
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── Lightbox Preview Modal ── --}}
<div id="modal-preview"
     class="fixed inset-0 bg-black/90 backdrop-blur-sm z-[60] items-center justify-center p-4"
     style="display:none;"
     onclick="closePreview()">

    {{-- Close button --}}
    <button onclick="closePreview()"
            class="absolute top-4 right-4 w-10 h-10 bg-white/10 hover:bg-white/25 text-white rounded-full flex items-center justify-center transition z-10">
        <i class="fas fa-times"></i>
    </button>

    {{-- Caption --}}
    <p id="preview-caption"
       class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/80 text-sm font-medium bg-black/40 px-4 py-1.5 rounded-full max-w-xs text-center truncate z-10"></p>

    {{-- Content --}}
    <div onclick="event.stopPropagation()" class="max-w-4xl max-h-[85vh] flex items-center justify-center">
        <img id="preview-img" src="" alt=""
             class="max-w-full max-h-[85vh] rounded-xl shadow-2xl object-contain"
             style="display:none;">
        <video id="preview-video" src="" controls autoplay
               class="max-w-full max-h-[85vh] rounded-xl shadow-2xl"
               style="display:none;">
        </video>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = '';
}
document.querySelectorAll('[id^="modal-"]:not(#modal-preview)').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

// ── Lightbox ──
function openPreview(src, type, caption) {
    const modal   = document.getElementById('modal-preview');
    const img     = document.getElementById('preview-img');
    const video   = document.getElementById('preview-video');
    const capEl   = document.getElementById('preview-caption');

    if (type === 'video') {
        video.src = src;
        video.style.display = 'block';
        img.style.display   = 'none';
        img.src = '';
    } else {
        img.src = src;
        img.style.display   = 'block';
        video.style.display = 'none';
        video.pause();
        video.src = '';
    }

    capEl.textContent    = caption || '';
    capEl.style.display  = caption ? 'block' : 'none';
    modal.style.display  = 'flex';
    document.body.style.overflow = 'hidden';
}

function closePreview() {
    const modal = document.getElementById('modal-preview');
    const video = document.getElementById('preview-video');
    video.pause();
    video.src = '';
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

// Close preview on Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closePreview();
        ['modal-add-update','modal-add-media','modal-add-document'].forEach(closeModal);
    }
});
</script>

@endsection