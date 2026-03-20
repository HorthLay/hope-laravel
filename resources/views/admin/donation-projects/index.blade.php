{{-- resources/views/admin/donation-projects/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Donation Projects')

@section('content')
<div class="p-6 max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Donation Projects</h1>
            <p class="text-sm text-gray-500 mt-1">Manage fundraising campaigns shown on the donate page.</p>
        </div>
        <a href="{{ route('admin.donation-projects.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition text-sm">
            <i class="fas fa-plus"></i> New Project
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-semibold">
        <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 font-bold text-gray-500 uppercase text-xs tracking-wider w-8">#</th>
                    <th class="text-left px-5 py-3 font-bold text-gray-500 uppercase text-xs tracking-wider">Project</th>
                    <th class="text-left px-5 py-3 font-bold text-gray-500 uppercase text-xs tracking-wider hidden md:table-cell">HelloAsso URL</th>
                    <th class="text-left px-5 py-3 font-bold text-gray-500 uppercase text-xs tracking-wider">Status</th>
                    <th class="text-left px-5 py-3 font-bold text-gray-500 uppercase text-xs tracking-wider">Order</th>
                    <th class="px-5 py-3 w-32"></th>
                </tr>
            </thead>
            <tbody id="sortableBody">
                @forelse($projects as $project)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition" data-id="{{ $project->id }}">
                    <td class="px-5 py-4 text-gray-400 cursor-grab">
                        <i class="fas fa-grip-vertical"></i>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            @if($project->image)
                            {{-- Direct public path — asset() only, no storage/ prefix --}}
                            <img src="{{ asset($project->image) }}"
                                 class="w-12 h-12 rounded-xl object-cover flex-shrink-0 border border-gray-100">
                            @else
                            <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-image text-orange-400"></i>
                            </div>
                            @endif
                            <div>
                                <div class="font-bold text-gray-900 leading-tight">{{ $project->title_en }}</div>
                                @if($project->title_fr)
                                <div class="text-xs text-gray-400 mt-0.5">FR: {{ Str::limit($project->title_fr, 50) }}</div>
                                @endif
                                @if($project->tags)
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($project->tags as $tag)
                                    <span class="text-[10px] bg-orange-50 text-orange-600 border border-orange-100 rounded-full px-2 py-0.5 font-semibold">{{ $tag }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        @if($project->helloasso_widget_url)
                        <a href="{{ $project->helloasso_widget_url }}" target="_blank"
                           class="text-blue-500 hover:text-blue-700 text-xs font-semibold truncate block max-w-xs">
                            {{ Str::limit($project->helloasso_widget_url, 55) }}
                            <i class="fas fa-external-link-alt ml-1 text-[9px]"></i>
                        </a>
                        @else
                        <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @if($project->is_active)
                        <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Active
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-500 text-xs font-bold px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> Hidden
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-gray-500 font-bold text-center">{{ $project->sort_order }}</td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.donation-projects.edit', $project) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 font-bold rounded-lg text-xs transition">
                                <i class="fas fa-edit text-[10px]"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.donation-projects.destroy', $project) }}"
                                  onsubmit="return confirm('Delete this project?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-500 font-bold rounded-lg text-xs transition">
                                    <i class="fas fa-trash text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                        <i class="fas fa-hand-holding-heart text-4xl mb-3 block text-gray-200"></i>
                        No projects yet. <a href="{{ route('admin.donation-projects.create') }}" class="text-orange-500 font-bold hover:underline">Create your first one.</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <p class="text-xs text-gray-400 mt-3"><i class="fas fa-info-circle mr-1"></i> Drag rows to reorder how projects appear on the donate page.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
var el = document.getElementById('sortableBody');
if (el) {
    Sortable.create(el, {
        animation: 150,
        handle: 'td:first-child',
        onEnd: function() {
            var ids = Array.from(el.querySelectorAll('tr[data-id]')).map(r => r.dataset.id);
            fetch('{{ route("admin.donation-projects.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order: ids })
            });
        }
    });
}
</script>
@endsection