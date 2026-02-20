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

            {{-- Updates --}}
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
                </div>
                @forelse($child->updates->take(5) as $update)
                <div class="flex gap-3 pb-3 mb-3 border-b border-gray-50 last:border-0 last:mb-0 last:pb-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-file-alt text-green-500 text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-500">
                            {{ isset($update->report_date) ? \Carbon\Carbon::parse($update->report_date)->format('d M Y') : $update->created_at->format('d M Y') }}
                        </p>
                        <p class="text-sm text-gray-700 leading-relaxed mt-0.5 line-clamp-2">
                            {{ $update->content ?? $update->description ?? '—' }}
                        </p>
                    </div>
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

            {{-- Media gallery --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-black text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-images text-pink-400"></i> Media Gallery
                    @if($child->media->count())
                        <span class="text-xs font-bold bg-pink-100 text-pink-600 px-2 py-0.5 rounded-full">{{ $child->media->count() }}</span>
                    @endif
                </h3>
                @if($child->media->count())
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                    @foreach($child->media->take(8) as $m)
                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                        @if(isset($m->file_path) || isset($m->path))
                            <img src="{{ asset($m->file_path ?? $m->path) }}" alt="Media"
                                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-gray-300 text-xl"></i>
                            </div>
                        @endif
                    </div>
                    @endforeach
                    @if($child->media->count() > 8)
                    <div class="aspect-square rounded-xl bg-gray-100 flex items-center justify-center">
                        <p class="text-xs font-bold text-gray-500">+{{ $child->media->count() - 8 }}<br>more</p>
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

            {{-- Documents --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-black text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-folder text-yellow-400"></i> Documents
                    @if($child->documents->count())
                        <span class="text-xs font-bold bg-yellow-100 text-yellow-600 px-2 py-0.5 rounded-full">{{ $child->documents->count() }}</span>
                    @endif
                </h3>
                @forelse($child->documents as $doc)
                <a href="{{ asset($doc->file_path ?? $doc->path ?? '') }}" target="_blank"
                   class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-orange-200 hover:bg-orange-50 transition mb-2 last:mb-0 group">
                    <div class="w-9 h-9 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-file-pdf text-yellow-500 text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-700 truncate group-hover:text-orange-600">{{ $doc->title ?? $doc->name ?? 'Document' }}</p>
                        @if(isset($doc->document_date))
                            <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($doc->document_date)->format('d M Y') }}</p>
                        @endif
                    </div>
                    <i class="fas fa-download text-xs text-gray-400 group-hover:text-orange-400"></i>
                </a>
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

{{-- Delete Modal --}}
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

<script>
let pendingDeleteId = null;
function confirmDelete(id, name) {
    pendingDeleteId = id;
    document.getElementById('delete-child-name').textContent = name;
    document.getElementById('delete-modal').style.display = 'flex';
}
function closeDeleteModal() {
    document.getElementById('delete-modal').style.display = 'none';
    pendingDeleteId = null;
}
document.getElementById('confirm-delete-btn').addEventListener('click', () => {
    if (pendingDeleteId) document.getElementById('delete-form-' + pendingDeleteId).submit();
});
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endsection