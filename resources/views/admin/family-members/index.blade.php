{{-- resources/views/admin/family-members/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Family Members')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="page-title">Family Members</h1>
        <p class="page-subtitle">Manage all family member profiles</p>
    </div>
    <a href="{{ route('admin.family-members.create') }}" class="action-btn">
        <i class="fas fa-plus"></i><span>Add Member</span>
    </a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card text-center py-4"><p class="text-2xl font-black text-gray-800">{{ $stats['total'] }}</p><p class="text-xs text-gray-500 mt-1">Total Members</p></div>
    <div class="card text-center py-4"><p class="text-2xl font-black text-green-600">{{ $stats['active'] }}</p><p class="text-xs text-gray-500 mt-1">Active</p></div>
    <div class="card text-center py-4"><p class="text-2xl font-black text-red-400">{{ $stats['inactive'] }}</p><p class="text-xs text-gray-500 mt-1">Inactive</p></div>
    <div class="card text-center py-4"><p class="text-2xl font-black text-orange-500">{{ $stats['families'] }}</p><p class="text-xs text-gray-500 mt-1">Families</p></div>
</div>

{{-- Filters --}}
<div class="card mb-6">
    <form method="GET" action="{{ route('admin.family-members.index') }}" class="flex flex-wrap gap-3">
        <div class="relative flex-1 min-w-[200px]">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone..."
                   class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none text-sm">
        </div>
        <select name="family_id" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none text-sm min-w-[160px]">
            <option value="">All Families</option>
            @foreach($families as $fam)
            <option value="{{ $fam->id }}" {{ request('family_id') == $fam->id ? 'selected' : '' }}>{{ $fam->name }}</option>
            @endforeach
        </select>
        <select name="relationship" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none text-sm">
            <option value="">All Roles</option>
            @foreach(['Father','Mother','Son','Daughter','Guardian','Grandfather','Grandmother','Uncle','Aunt','Brother','Sister','Other'] as $rel)
            <option value="{{ $rel }}" {{ request('relationship') === $rel ? 'selected' : '' }}>{{ $rel }}</option>
            @endforeach
        </select>
        <select name="is_active" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none text-sm">
            <option value="">All Status</option>
            <option value="1" {{ request('is_active')==='1'?'selected':'' }}>Active</option>
            <option value="0" {{ request('is_active')==='0'?'selected':'' }}>Inactive</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 text-sm font-semibold transition">
            <i class="fas fa-filter mr-1"></i>Filter
        </button>
        @if(request()->hasAny(['search','family_id','relationship','is_active']))
        <a href="{{ route('admin.family-members.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 text-sm transition">
            <i class="fas fa-times mr-1"></i>Clear
        </a>
        @endif
    </form>
</div>

{{-- Table --}}
@if($members->isEmpty())
<div class="card text-center py-16">
    <i class="fas fa-users text-4xl text-gray-200 mb-3 block"></i>
    <p class="text-gray-500 font-medium">No family members found.</p>
    <a href="{{ route('admin.family-members.create') }}" class="mt-3 inline-block text-orange-500 hover:underline text-sm">Add the first member →</a>
</div>
@else
<div class="card p-0 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600">Member</th>
                <th class="text-left px-4 py-3.5 font-semibold text-gray-600">Relationship</th>
                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 hidden md:table-cell">Family</th>
                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 hidden lg:table-cell">Contact</th>
                <th class="text-left px-4 py-3.5 font-semibold text-gray-600">Status</th>
                <th class="text-right px-5 py-3.5 font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($members as $member)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        @if($member->profile_photo)
                        <img src="{{ asset($member->profile_photo) }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0 border border-gray-200">
                        @else
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center flex-shrink-0 text-white font-black text-sm">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <p class="font-bold text-gray-800">{{ $member->name }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3.5">
                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full">{{ $member->relationship }}</span>
                </td>
                <td class="px-4 py-3.5 hidden md:table-cell">
                    @if($member->family)
                    <a href="{{ route('admin.families.show', $member->family_id) }}" class="flex items-center gap-2 group">
                        <span class="w-6 h-6 bg-orange-100 rounded-md flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-home text-orange-500 text-[10px]"></i>
                        </span>
                        <span class="text-gray-700 group-hover:text-orange-600 font-medium truncate max-w-[140px]">{{ $member->family->name }}</span>
                    </a>
                    @else
                    <span class="text-gray-400 text-xs">—</span>
                    @endif
                </td>
                <td class="px-4 py-3.5 hidden lg:table-cell">
                    <div class="space-y-0.5">
                        @if($member->phone)
                        <p class="text-gray-600 text-xs flex items-center gap-1.5"><i class="fas fa-phone text-gray-300 w-3"></i>{{ $member->phone }}</p>
                        @endif
                        @if($member->email)
                        <p class="text-gray-600 text-xs flex items-center gap-1.5"><i class="fas fa-envelope text-gray-300 w-3"></i>{{ $member->email }}</p>
                        @endif
                        @if(!$member->phone && !$member->email)
                        <span class="text-gray-400 text-xs">No contact</span>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-3.5">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $member->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-500' }}">
                        {{ $member->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.family-members.show', $member) }}"
                           class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-blue-100 text-gray-500 hover:text-blue-600 rounded-lg transition" title="View">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                        <a href="{{ route('admin.family-members.edit', $member) }}"
                           class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-orange-100 text-gray-500 hover:text-orange-600 rounded-lg transition" title="Edit">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <form action="{{ route('admin.family-members.destroy', $member) }}" method="POST"
                              onsubmit="return confirm('Delete {{ addslashes($member->name) }}?')">
                            @csrf @method('DELETE')
                            <button class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-600 rounded-lg transition" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if($members->hasPages())
<div class="mt-4">{{ $members->links() }}</div>
@endif
@endif

@endsection