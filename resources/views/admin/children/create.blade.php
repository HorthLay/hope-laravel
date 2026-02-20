{{-- resources/views/admin/children/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Add New Child')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.children.index') }}"
           class="w-9 h-9 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:text-orange-500 hover:border-orange-300 transition shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-gray-800">Add New Child</h1>
            <p class="text-sm text-gray-500 mt-0.5">Register a new sponsored child</p>
        </div>
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
          action="{{ route('admin.children.store') }}"
          enctype="multipart/form-data">
        @csrf
        @include('admin.children.partials.form')
    </form>

</div>
@endsection