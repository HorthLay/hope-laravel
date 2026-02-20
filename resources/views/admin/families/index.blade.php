{{-- resources/views/admin/families/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Families')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div><h1 class="page-title">Families</h1><p class="page-subtitle">Manage sponsored family profiles</p></div>
    <a href="{{ route('admin.families.create') }}" class="action-btn"><i class="fas fa-plus"></i><span>Add Family</span></a>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card text-center py-4"><p class="text-2xl font-black text-gray-800">{{ $stats['total'] }}</p><p class="text-xs text-gray-500 mt-1">Total Families</p></div>
    <div class="card text-center py-4"><p class="text-2xl font-black text-green-600">{{ $stats['active'] }}</p><p class="text-xs text-gray-500 mt-1">Active</p></div>
    <div class="card text-center py-4"><p class="text-2xl font-black text-red-400">{{ $stats['inactive'] }}</p><p class="text-xs text-gray-500 mt-1">Inactive</p></div>
    <div class="card text-center py-4"><p class="text-2xl font-black text-orange-500">{{ $stats['sponsored'] }}</p><p class="text-xs text-gray-500 mt-1">Sponsored</p></div>
</div>

<div class="card mb-6">
    <form method="GET" action="{{ route('admin.families.index') }}" class="flex flex-wrap gap-3">
        <div class="relative flex-1 min-w-[200px]">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, code, country..."
                   class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none text-sm">
        </div>
        <select name="is_active" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none text-sm">
            <option value="">All Status</option>
            <option value="1" {{ request('is_active')==='1'?'selected':'' }}>Active</option>
            <option value="0" {{ request('is_active')==='0'?'selected':'' }}>Inactive</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 text-sm font-semibold transition"><i class="fas fa-filter mr-1"></i>Filter</button>
        @if(request()->hasAny(['search','is_active']))
        <a href="{{ route('admin.families.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 text-sm transition"><i class="fas fa-times mr-1"></i>Clear</a>
        @endif
    </form>
</div>

@if($families->isEmpty())
<div class="card text-center py-16">
    <i class="fas fa-home text-4xl text-gray-200 mb-3 block"></i>
    <p class="text-gray-500 font-medium">No families found.</p>
    <a href="{{ route('admin.families.create') }}" class="mt-3 inline-block text-orange-500 hover:underline text-sm">Add the first family →</a>
</div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($families as $family)
    <div class="card overflow-hidden hover:shadow-md transition group p-0">
        {{-- Photo --}}
        <div class="h-44 bg-orange-50 overflow-hidden flex items-center justify-center relative">
            @if($family->profile_photo)
                <img src="{{ $family->profile_photo_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            @else
                <i class="fas fa-home text-5xl text-orange-200"></i>
            @endif
            <span class="absolute top-3 right-3 px-2 py-0.5 text-xs font-bold rounded-full shadow {{ $family->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-500' }}">
                {{ $family->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="p-5">
            <h3 class="font-black text-gray-800 text-lg leading-tight mb-0.5">{{ $family->name }}</h3>
            <p class="text-xs text-gray-400 mb-3">
                @if($family->country)<i class="fas fa-map-marker-alt text-orange-300 mr-1"></i>{{ $family->country }} · @endif
                <span class="font-mono">{{ $family->code }}</span>
            </p>
            <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                <span class="flex items-center gap-1"><i class="fas fa-user-tie text-blue-400"></i>{{ $family->sponsors->count() }} sponsors</span>
                <span class="flex items-center gap-1"><i class="fas fa-images text-pink-400"></i>{{ $family->media->count() }} media</span>
                <span class="flex items-center gap-1"><i class="fas fa-file text-yellow-400"></i>{{ $family->documents->count() }} docs</span>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.families.show', $family) }}" class="flex-1 text-center py-2 bg-gray-50 hover:bg-orange-50 text-gray-600 hover:text-orange-600 rounded-lg text-xs font-bold transition"><i class="fas fa-eye mr-1"></i>View</a>
                <a href="{{ route('admin.families.edit', $family) }}" class="flex-1 text-center py-2 bg-gray-50 hover:bg-orange-50 text-gray-600 hover:text-orange-600 rounded-lg text-xs font-bold transition"><i class="fas fa-edit mr-1"></i>Edit</a>
                <form action="{{ route('admin.families.destroy', $family) }}" method="POST" onsubmit="return confirm('Delete {{ addslashes($family->name) }}?')">
                    @csrf @method('DELETE')
                    <button class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg text-xs font-bold transition"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@if($families->hasPages())<div class="mt-6">{{ $families->links() }}</div>@endif
@endif

@endsection