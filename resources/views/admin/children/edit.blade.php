{{-- resources/views/admin/children/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit — '.$child->first_name)

@section('content')
<div class="min-h-screen bg-gray-50 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.children.show', $child) }}"
               class="w-9 h-9 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:text-orange-500 hover:border-orange-300 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-gray-800">Edit Child</h1>
                <div class="flex items-center gap-2 mt-0.5">
                    <span class="font-mono text-xs font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded">
                        {{ $child->code }}
                    </span>
                    <span class="text-sm text-gray-500">{{ $child->first_name }}</span>
                </div>
            </div>
        </div>

        {{-- Delete button --}}
        <button type="button"
                onclick="confirmDelete({{ $child->id }}, '{{ addslashes($child->first_name) }}')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-500 font-bold rounded-xl text-sm border border-red-100 transition">
            <i class="fas fa-trash-alt text-xs"></i> Delete
        </button>
    </div>

    {{-- Validation errors --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
        <p class="text-sm font-bold text-red-600 mb-1.5 flex items-center gap-1.5">
            <i class="fas fa-exclamation-circle"></i> Please fix the following errors:
        </p>
        <ul class="list-disc list-inside text-sm text-red-500 space-y-0.5">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST"
          action="{{ route('admin.children.update', $child) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.children.partials.form', ['child' => $child])
    </form>
</div>

{{-- Delete modal --}}
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

<form id="delete-form-{{ $child->id }}" method="POST"
      action="{{ route('admin.children.destroy', $child) }}" style="display:none">
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