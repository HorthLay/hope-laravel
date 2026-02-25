{{-- resources/views/admin/children/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', $child->first_name)

@section('content')
<div class="min-h-screen bg-gray-50 p-6">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.children.index') }}"
               class="w-9 h-9 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:text-orange-500 hover:border-orange-300 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-gray-800">{{ $child->first_name }}</h1>
                <div class="flex items-center gap-2 mt-0.5">
                    <span class="font-mono text-xs font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded">
                        {{ $child->code }}
                    </span>
                    @if($child->is_active)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            <i class="fas fa-circle text-[6px]"></i> Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                            <i class="fas fa-circle text-[6px]"></i> Inactive
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.children.edit', $child) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl text-sm shadow-sm transition">
                <i class="fas fa-pen text-xs"></i> Edit
            </a>
            <button type="button"
                    onclick="confirmDelete({{ $child->id }}, '{{ addslashes($child->first_name) }}')"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-500 font-bold rounded-xl text-sm border border-red-100 transition">
                <i class="fas fa-trash-alt text-xs"></i> Delete
            </button>
        </div>
    </div>

    {{-- Flash --}}
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

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- ══ LEFT column ══ --}}
        <div class="space-y-5">

            {{-- Profile photo --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="aspect-square bg-orange-50 flex items-center justify-center">
                    @if($child->profile_photo)
                        <img src="{{ asset($child->profile_photo) }}"
                             alt="{{ $child->first_name }}"
                             class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-child text-orange-200 text-7xl"></i>
                    @endif
                </div>
                <div class="p-4 text-center border-t border-gray-50">
                    <p class="text-xl font-black text-gray-800">{{ $child->first_name }}</p>
                    @if($child->birth_year)
                        <p class="text-sm text-gray-500">{{ $child->age }} years old · b. {{ $child->birth_year }}</p>
                    @endif
                </div>
            </div>

            {{-- Quick info --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
                @foreach([
                    ['icon'=>'fas fa-map-marker-alt', 'color'=>'orange', 'label'=>'Country', 'value'=>$child->country ?? '—'],
                    ['icon'=>'fas fa-barcode',         'color'=>'gray',   'label'=>'Code',    'value'=>$child->code ?? '—'],
                    ['icon'=>'fas fa-home',            'color'=>'green',  'label'=>'Has Family', 'value'=>$child->has_family ? 'Yes' : 'No'],
                    ['icon'=>'fas fa-calendar',        'color'=>'blue',   'label'=>'Added',   'value'=>$child->created_at->format('d M Y')],
                ] as $row)
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-{{ $row['color'] }}-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="{{ $row['icon'] }} text-{{ $row['color'] }}-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">{{ $row['label'] }}</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $row['value'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ══ SPONSORS (many-to-many) ══ --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs font-black text-gray-500 uppercase tracking-wide mb-3 flex items-center gap-1.5">
                    <i class="fas fa-user-tie text-blue-400"></i> Sponsors
                    @if($child->sponsors->isNotEmpty())
                        <span class="ml-auto px-2 py-0.5 bg-blue-100 text-blue-600 rounded-full text-[10px] font-black">
                            {{ $child->sponsors->count() }}
                        </span>
                    @endif
                </p>

                @if($child->sponsors->isNotEmpty())
                <div class="space-y-2">
                    @foreach($child->sponsors as $sponsor)
                    <div class="flex items-center gap-3 p-2.5 bg-blue-50 rounded-xl border border-blue-100 hover:border-blue-300 transition group">
                        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 font-black text-blue-600 text-sm">
                            {{ strtoupper(substr($sponsor->first_name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-800 text-sm truncate leading-tight">{{ $sponsor->full_name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $sponsor->email }}</p>
                        </div>
                        <a href="{{ route('admin.sponsors.show', $sponsor) }}"
                           class="w-7 h-7 flex items-center justify-center bg-blue-100 hover:bg-blue-200 text-blue-500 rounded-full transition flex-shrink-0 opacity-0 group-hover:opacity-100"
                           title="View sponsor">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-user-slash text-gray-200 text-2xl mb-2 block"></i>
                    <p class="text-sm text-gray-400">No sponsors assigned</p>
                </div>
                @endif
            </div>

            {{-- Linked articles --}}
            @if($child->articles->isNotEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs font-black text-gray-500 uppercase tracking-wide mb-3 flex items-center gap-1.5">
                    <i class="fas fa-newspaper text-purple-400"></i> Linked Articles
                    <span class="ml-auto px-2 py-0.5 bg-purple-100 text-purple-600 rounded-full text-[10px] font-black">{{ $child->articles->count() }}</span>
                </p>
                <div class="space-y-2">
                    @foreach($child->articles as $article)
                    <a href="{{ route('admin.articles.show', $article) }}"
                       class="block p-2.5 rounded-xl bg-purple-50 border border-purple-100 hover:border-purple-300 transition group">
                        <p class="text-sm font-bold text-gray-800 group-hover:text-purple-600 line-clamp-2 leading-snug">{{ $article->title }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $article->published_at?->format('d M Y') }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>{{-- /left --}}

        {{-- ══ RIGHT column ══ --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Story --}}
            @if($child->story)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-black text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-book-open text-purple-400"></i> Story
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $child->story }}</p>
            </div>
            @endif

            {{-- ══ UPDATES ══ --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-black text-gray-700 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-green-400"></i> Updates
                        @if($child->updates->count())
                            <span class="text-xs font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                {{ $child->updates->count() }}
                            </span>
                        @endif
                    </h3>
                    {{-- ADD UPDATE BUTTON --}}
                    <button type="button" onclick="openModal('modal-add-update')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg text-xs transition shadow-sm">
                        <i class="fas fa-plus text-[10px]"></i> Add Update
                    </button>
                </div>

                @forelse($child->updates->sortByDesc('report_date')->take(5) as $update)
                <div class="flex gap-3 pb-3 mb-3 border-b border-gray-50 last:border-0 last:mb-0 last:pb-0 group">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-file-alt text-green-500 text-xs"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        @if(!empty($update->title))
                            <p class="text-sm font-bold text-gray-700 leading-tight">{{ $update->title }}</p>
                        @endif
                        <p class="text-xs font-bold text-gray-400 mt-0.5">
                            {{ isset($update->report_date) ? \Carbon\Carbon::parse($update->report_date)->format('d M Y') : $update->created_at->format('d M Y') }}
                            @if($update->type)
                                · <span class="capitalize">{{ $update->type }}</span>
                            @endif
                        </p>
                        <p class="text-sm text-gray-600 leading-relaxed mt-1 line-clamp-2">
                            {{ $update->content ?? '—' }}
                        </p>
                    </div>
                    {{-- DELETE UPDATE --}}
                    <form method="POST"
                          action="{{ route('admin.children.updates.destroy', [$child, $update]) }}"
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
                <div class="text-center py-6">
                    <i class="fas fa-clipboard text-gray-200 text-2xl mb-2 block"></i>
                    <p class="text-sm text-gray-400">No updates yet.</p>
                </div>
                @endforelse

                @if($child->updates->count() > 5)
                <p class="text-xs text-center text-gray-400 mt-2">+ {{ $child->updates->count() - 5 }} more updates</p>
                @endif
            </div>

            {{-- ══ MEDIA GALLERY ══ --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-black text-gray-700 flex items-center gap-2">
                        <i class="fas fa-images text-pink-400"></i> Media Gallery
                        @if($child->media->count())
                            <span class="text-xs font-bold bg-pink-100 text-pink-600 px-2 py-0.5 rounded-full">{{ $child->media->count() }}</span>
                        @endif
                    </h3>
                    {{-- ADD MEDIA BUTTON --}}
                    <button type="button" onclick="openModal('modal-add-media')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-pink-500 hover:bg-pink-600 text-white font-bold rounded-lg text-xs transition shadow-sm">
                        <i class="fas fa-upload text-[10px]"></i> Upload Media
                    </button>
                </div>

                @if($child->media->count())
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                    @foreach($child->media->take(8) as $m)
                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 relative group cursor-pointer"
                         onclick="openPreview('{{ asset($m->file_path ?? $m->path) }}', '{{ $m->type ?? 'image' }}', '{{ addslashes($m->caption ?? '') }}')">
                        @if($m->type === 'video')
                            <video src="{{ asset($m->file_path ?? $m->path) }}"
                                   class="w-full h-full object-cover pointer-events-none"
                                   muted playsinline
                                   onmouseover="this.play()" onmouseout="this.pause();this.currentTime=0">
                            </video>
                            <div class="absolute top-1.5 left-1.5 bg-black/60 text-white rounded-md px-1.5 py-0.5 text-[9px] font-bold flex items-center gap-1 pointer-events-none">
                                <i class="fas fa-play text-[7px]"></i> VIDEO
                            </div>
                        @elseif(isset($m->file_path) || isset($m->path))
                            <img src="{{ asset($m->file_path ?? $m->path) }}" alt="{{ $m->caption ?? 'Media' }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 pointer-events-none">
                        @else
                            <div class="w-full h-full flex items-center justify-center pointer-events-none">
                                <i class="fas fa-image text-gray-300 text-xl"></i>
                            </div>
                        @endif
                        {{-- Hover overlay: preview + delete --}}
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                            <span class="w-8 h-8 bg-white/20 hover:bg-white/40 text-white rounded-full flex items-center justify-center transition"
                                  title="Preview">
                                <i class="fas fa-expand text-xs"></i>
                            </span>
                            <form method="POST"
                                  action="{{ route('admin.children.media.destroy', [$child, $m]) }}"
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
                    @if($child->media->count() > 8)
                    <div class="aspect-square rounded-xl bg-gray-100 flex items-center justify-center">
                        <p class="text-xs font-bold text-gray-500 text-center">+{{ $child->media->count() - 8 }}<br>more</p>
                    </div>
                    @endif
                </div>
                @else
                <div class="text-center py-6">
                    <i class="fas fa-images text-gray-200 text-2xl mb-2 block"></i>
                    <p class="text-sm text-gray-400">No media uploaded yet.</p>
                </div>
                @endif
            </div>

            {{-- ══ DOCUMENTS ══ --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-black text-gray-700 flex items-center gap-2">
                        <i class="fas fa-folder text-yellow-400"></i> Documents
                        @if($child->documents->count())
                            <span class="text-xs font-bold bg-yellow-100 text-yellow-600 px-2 py-0.5 rounded-full">{{ $child->documents->count() }}</span>
                        @endif
                    </h3>
                    {{-- ADD DOCUMENT BUTTON --}}
                    <button type="button" onclick="openModal('modal-add-document')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg text-xs transition shadow-sm">
                        <i class="fas fa-upload text-[10px]"></i> Upload Document
                    </button>
                </div>

                @forelse($child->documents as $doc)
                <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-orange-200 hover:bg-orange-50 transition mb-2 last:mb-0 group">
                    <div class="w-9 h-9 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-file-pdf text-yellow-500 text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                    <a href="{{ asset($doc->file_path ?? $doc->path ?? '') }}" target="_blank"
                       class="text-sm font-bold text-gray-700 truncate group-hover:text-orange-600 block hover:underline">
                            {{ $doc->title ?? $doc->name ?? 'Document' }}
                        </a>
                        @if(isset($doc->document_date))
                            <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($doc->document_date)->format('d M Y') }}</p>
                        @endif
                        @if($doc->type)
                            <p class="text-[10px] font-bold text-gray-400 uppercase">{{ $doc->type }}</p>
                        @endif
                    </div>
                    <a href="{{ asset($doc->file_path ?? $doc->path ?? '') }}" target="_blank"
                       class="w-8 h-8 flex items-center justify-center bg-orange-100 hover:bg-orange-200 text-orange-500 rounded-full transition flex-shrink-0">
                        <i class="fas fa-download text-xs"></i>
                    </a>
                    {{-- DELETE DOCUMENT --}}
                    <form method="POST"
                          action="{{ route('admin.children.documents.destroy', [$child, $doc]) }}"
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
                <div class="text-center py-6">
                    <i class="fas fa-folder-open text-gray-200 text-2xl mb-2 block"></i>
                    <p class="text-sm text-gray-400">No documents uploaded yet.</p>
                </div>
                @endforelse
            </div>

        </div>{{-- /right --}}
    </div>{{-- /grid --}}
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
        <form method="POST" action="{{ route('admin.children.updates.store', $child) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Title <span class="text-gray-300 font-normal">(optional)</span></label>
                <input type="text" name="title" placeholder="e.g. School Progress Report"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Type <span class="text-gray-300 font-normal">(optional)</span></label>
                <select name="type" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-transparent bg-white">
                    <option value="">— Select type —</option>
                    <option value="health">Health</option>
                    <option value="education">Education</option>
                    <option value="study">Study</option>
                    <option value="general">General</option>
                    <option value="financial">Financial</option>
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
        <form method="POST" action="{{ route('admin.children.media.store', $child) }}"
              enctype="multipart/form-data" class="space-y-4">
            @csrf
            {{-- Drop zone --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">
                    File <span class="text-red-400">*</span>
                    <span class="text-gray-300 font-normal ml-1">jpg, png, gif, webp, mp4, mov — max 20 MB</span>
                </label>
                <label for="media-file-input"
                       class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-pink-200 bg-pink-50 rounded-xl cursor-pointer hover:bg-pink-100 hover:border-pink-300 transition">
                    <i class="fas fa-cloud-upload-alt text-pink-300 text-2xl mb-1"></i>
                    <span class="text-xs text-pink-400 font-semibold" id="media-file-label">Click to choose file</span>
                </label>
                <input type="file" id="media-file-input" name="file"
                       accept="image/*,video/mp4,video/quicktime" required
                       class="hidden"
                       onchange="document.getElementById('media-file-label').textContent = this.files[0]?.name || 'Click to choose file'">
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
        <form method="POST" action="{{ route('admin.children.documents.store', $child) }}"
              enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">
                    File <span class="text-red-400">*</span>
                    <span class="text-gray-300 font-normal ml-1">pdf, doc, docx, xls, xlsx, jpg, png — max 10 MB</span>
                </label>
                <label for="doc-file-input"
                       class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-yellow-200 bg-yellow-50 rounded-xl cursor-pointer hover:bg-yellow-100 hover:border-yellow-300 transition">
                    <i class="fas fa-file-upload text-yellow-300 text-2xl mb-1"></i>
                    <span class="text-xs text-yellow-500 font-semibold" id="doc-file-label">Click to choose file</span>
                </label>
                <input type="file" id="doc-file-input" name="file"
                       accept=".pdf,.doc,.docx,.xls,.xlsx,image/*" required
                       class="hidden"
                       onchange="document.getElementById('doc-file-label').textContent = this.files[0]?.name || 'Click to choose file'">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" required placeholder="e.g. Birth Certificate"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Type <span class="text-gray-300 font-normal">(optional)</span></label>
                <select name="type" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent bg-white">
                    <option value="">— Select type —</option>
                    <option value="id">Identification</option>
                    <option value="medical">Medical</option>
                    <option value="education">Education</option>
                    <option value="legal">Legal</option>
                    <option value="financial">Financial</option>
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

{{-- ── Delete Child Modal ── --}}
<div id="delete-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center p-4" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-trash-alt text-red-500 text-2xl"></i>
        </div>
        <h3 class="text-lg font-black text-gray-800 mb-1">Delete Child?</h3>
        <p class="text-sm text-gray-500 mb-1">You are about to delete:</p>
        <p class="font-bold text-orange-500 text-base mb-4" id="delete-child-name">—</p>
        <p class="text-xs text-gray-400 mb-6">This cannot be undone. Are you sure?</p>
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()"
                    class="flex-1 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50 transition">
                Cancel
            </button>
            <button type="button" id="confirm-delete-btn"
                    class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold text-sm transition">
                <i class="fas fa-trash-alt mr-1"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<form id="delete-form-{{ $child->id }}" method="POST" action="{{ route('admin.children.destroy', $child) }}" style="display:none">
    @csrf @method('DELETE')
</form>

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
       class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/80 text-sm font-medium bg-black/40 px-4 py-1.5 rounded-full max-w-xs text-center truncate z-10"
       style="display:none;"></p>

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
// ── Generic modal helpers ──
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = '';
}

// Close modal on backdrop click (exclude lightbox which has its own handler)
document.querySelectorAll('[id^="modal-"]:not(#modal-preview)').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

// ── Lightbox ──
function openPreview(src, type, caption) {
    const modal  = document.getElementById('modal-preview');
    const img    = document.getElementById('preview-img');
    const video  = document.getElementById('preview-video');
    const capEl  = document.getElementById('preview-caption');

    if (type === 'video') {
        video.src           = src;
        video.style.display = 'block';
        img.style.display   = 'none';
        img.src             = '';
    } else {
        img.src             = src;
        img.style.display   = 'block';
        video.style.display = 'none';
        video.pause();
        video.src = '';
    }

    if (caption) {
        capEl.textContent    = caption;
        capEl.style.display  = 'block';
    } else {
        capEl.style.display  = 'none';
    }

    modal.style.display          = 'flex';
    document.body.style.overflow = 'hidden';
}

function closePreview() {
    const modal = document.getElementById('modal-preview');
    const video = document.getElementById('preview-video');
    video.pause();
    video.src           = '';
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

// ── Delete child modal ──
let pendingDeleteId = null;
function confirmDelete(id, name) {
    pendingDeleteId = id;
    document.getElementById('delete-child-name').textContent = name;
    document.getElementById('delete-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
    document.getElementById('delete-modal').style.display = 'none';
    document.body.style.overflow = '';
    pendingDeleteId = null;
}
document.getElementById('confirm-delete-btn').addEventListener('click', () => {
    if (pendingDeleteId) document.getElementById('delete-form-' + pendingDeleteId).submit();
});
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});

// ── Escape key closes everything ──
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closePreview();
        ['modal-add-update','modal-add-media','modal-add-document'].forEach(closeModal);
        closeDeleteModal();
    }
});

// ── Re-open modal on validation error ──
@if($errors->any())
    @php
        $referer = request()->headers->get('referer', '');
        $openModal = '';
        if (str_contains($referer, 'updates')) $openModal = 'modal-add-update';
        elseif (str_contains($referer, 'media')) $openModal = 'modal-add-media';
        elseif (str_contains($referer, 'documents')) $openModal = 'modal-add-document';
    @endphp
    @if($openModal)
        document.addEventListener('DOMContentLoaded', () => openModal('{{ $openModal }}'));
    @endif
@endif
</script>
@endsection