{{-- resources/views/admin/children/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Children Management')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-gray-800 flex items-center gap-2">
                <div class="w-9 h-9 bg-orange-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-child text-white text-sm"></i>
                </div>
                Children Management
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">Manage all sponsored children</p>
        </div>
        <a href="{{ route('admin.children.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-sm transition text-sm">
            <i class="fas fa-plus"></i> Add New Child
        </a>
    </div>

    {{-- ── Flash ── --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-5 text-sm font-medium">
        <i class="fas fa-check-circle text-green-500 flex-shrink-0"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['label'=>'Total',     'count'=>$stats['total'],     'icon'=>'fas fa-users',       'bg'=>'blue-100',   'fg'=>'blue-500'],
            ['label'=>'Active',    'count'=>$stats['active'],    'icon'=>'fas fa-check-circle', 'bg'=>'green-100',  'fg'=>'green-500'],
            ['label'=>'Inactive',  'count'=>$stats['inactive'],  'icon'=>'fas fa-pause-circle', 'bg'=>'gray-100',   'fg'=>'gray-400'],
            ['label'=>'Sponsored', 'count'=>$stats['sponsored'], 'icon'=>'fas fa-heart',        'bg'=>'orange-100', 'fg'=>'orange-500'],
        ] as $s)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-3">
            <div class="w-11 h-11 bg-{{ $s['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="{{ $s['icon'] }} text-{{ $s['fg'] }} text-lg"></i>
            </div>
            <div>
                <p class="text-2xl font-black text-gray-800">{{ $s['count'] }}</p>
                <p class="text-xs text-gray-500 font-medium">{{ $s['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Filters ── --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-5">
        <form method="GET" action="{{ route('admin.children.index') }}"
              class="flex flex-wrap items-end gap-3">

            {{-- Search --}}
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-bold text-gray-600 mb-1">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Name, code, country…"
                           class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-orange-400">
                </div>
            </div>

            {{-- Status --}}
            <div class="min-w-[140px]">
                <label class="block text-xs font-bold text-gray-600 mb-1">Status</label>
                <select name="is_active" class="w-full py-2 px-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-orange-400">
                    <option value="">All Status</option>
                    <option value="1" {{ request('is_active')==='1' ? 'selected':'' }}>Active</option>
                    <option value="0" {{ request('is_active')==='0' ? 'selected':'' }}>Inactive</option>
                </select>
            </div>

            {{-- Country --}}
            @if($countries->isNotEmpty())
            <div class="min-w-[140px]">
                <label class="block text-xs font-bold text-gray-600 mb-1">Country</label>
                <select name="country" class="w-full py-2 px-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-orange-400">
                    <option value="">All Countries</option>
                    @foreach($countries as $c)
                        <option value="{{ $c }}" {{ request('country')===$c ? 'selected':'' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <button type="submit"
                    class="px-5 py-2 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-lg text-sm transition">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            @if(request()->hasAny(['search','is_active','country']))
            <a href="{{ route('admin.children.index') }}"
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-lg text-sm transition">
                <i class="fas fa-times mr-1"></i> Clear
            </a>
            @endif
        </form>
    </div>

    {{-- ── Table ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($children->isEmpty())
        <div class="py-20 text-center">
            <div class="w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-child text-orange-300 text-2xl"></i>
            </div>
            <p class="text-gray-400 font-medium text-sm">No children found.</p>
            <a href="{{ route('admin.children.create') }}"
               class="mt-3 inline-flex items-center gap-1 text-sm font-bold text-orange-500 hover:underline">
                <i class="fas fa-plus text-xs"></i> Add first child
            </a>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs font-black text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3 text-left w-0">#</th>
                        <th class="px-4 py-3 text-left">Child</th>
                        <th class="px-4 py-3 text-left">Code</th>
                        <th class="px-4 py-3 text-left">Has Family</th>
                        <th class="px-4 py-3 text-left">Age</th>
                        <th class="px-4 py-3 text-left">Country</th>
                        <th class="px-4 py-3 text-left">Sponsor</th>
                        <th class="px-4 py-3 text-center">Active</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($children as $i => $child)
                    <tr class="hover:bg-orange-50/30 transition group">

                        {{-- Row number --}}
                        <td class="px-4 py-3 text-xs text-gray-400 font-medium">
                            {{ $children->firstItem() + $i }}
                        </td>

                        {{-- Photo + Name --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl overflow-hidden bg-orange-100 flex-shrink-0">
                                    @if($child->profile_photo)
                                        <img src="{{ asset( $child->profile_photo) }}"
                                             alt="{{ $child->first_name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-child text-orange-300 text-sm"></i>
                                        </div>
                                    @endif
                                </div>
                                <p class="font-bold text-gray-800">{{ $child->first_name }}</p>
                            </div>
                        </td>

                        {{-- Code --}}
                        <td class="px-4 py-3">
                            <span class="font-mono text-xs font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded">
                                {{ $child->code ?? '—' }}
                            </span>
                        </td>

                        {{-- Has Family --}}
                        <td>
                            @if($child->has_family)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    <i class="fas fa-home text-green-400 text-[6px]"></i> With Family
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                    <i class="fas fa-home text-gray-400 text-[6px]"></i> No Family
                                </span>
                            @endif
                        </td>

                        {{-- Age --}}
                        <td class="px-4 py-3">
                            @if($child->birth_year)
                                <p class="font-bold text-gray-700">{{ $child->age }} yrs</p>
                                <p class="text-xs text-gray-400">b. {{ $child->birth_year }}</p>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        {{-- Country --}}
                        <td class="px-4 py-3 text-gray-600">
                            {{ $child->country ?? '—' }}
                        </td>

                        {{-- Sponsor --}}
                        <td class="px-4 py-3">
                            @if($child->sponsor)
                                <span class="text-xs font-bold text-green-600 flex items-center gap-1">
                                    <i class="fas fa-check-circle text-green-400 text-[10px]"></i>
                                    {{ $child->sponsor->name ?? 'Assigned' }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 italic">No sponsor</span>
                            @endif
                        </td>

                        {{-- Active toggle --}}
                        <td class="px-4 py-3 text-center">
                            @if($child->is_active)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    <i class="fas fa-circle text-[6px]"></i> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                    <i class="fas fa-circle text-[6px]"></i> Inactive
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1.5 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('admin.children.show', $child) }}"
                                   class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-500 flex items-center justify-center transition"
                                   title="View">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.children.edit', $child) }}"
                                   class="w-7 h-7 rounded-lg bg-orange-50 hover:bg-orange-100 text-orange-500 flex items-center justify-center transition"
                                   title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <button type="button"
                                        onclick="confirmDelete({{ $child->id }}, '{{ addslashes($child->first_name) }}')"
                                        class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 flex items-center justify-center transition"
                                        title="Delete">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>

                            <form id="delete-form-{{ $child->id }}"
                                  method="POST"
                                  action="{{ route('admin.children.destroy', $child) }}"
                                  style="display:none;">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($children->hasPages())
        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>Showing {{ $children->firstItem() }}–{{ $children->lastItem() }} of {{ $children->total() }}</span>
            {{ $children->links() }}
        </div>
        @endif
        @endif
    </div>
</div>

{{-- ── Delete Confirmation Modal ── --}}
<div id="delete-modal"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center p-4"
     style="display:none;">
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

<script>
let pendingDeleteId = null;
function confirmDelete(id, name) {
    pendingDeleteId = id;
    document.getElementById('delete-child-name').textContent = name;
    const m = document.getElementById('delete-modal');
    m.style.display = 'flex';
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