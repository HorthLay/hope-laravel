{{-- resources/views/admin/sponsors/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Sponsors')
@section('content')

<div class="page-header">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="page-title">Sponsors</h1>
            <p class="page-subtitle">Manage sponsor accounts</p>
        </div>
        <a href="{{ route('admin.sponsors.create') }}" class="action-btn">
            <i class="fas fa-plus"></i><span>Add Sponsor</span>
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card text-center py-4">
        <p class="text-2xl font-black text-gray-800">{{ $stats['total'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Total Sponsors</p>
    </div>
    <div class="card text-center py-4">
        <p class="text-2xl font-black text-green-600">{{ $stats['active'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Active</p>
    </div>
    <div class="card text-center py-4">
        <p class="text-2xl font-black text-red-400">{{ $stats['inactive'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Inactive</p>
    </div>
    <div class="card text-center py-4">
        <p class="text-2xl font-black text-orange-500">{{ $stats['with_children'] }}</p>
        <p class="text-xs text-gray-500 mt-1">With Children</p>
    </div>
</div>

{{-- Filters --}}
<div class="card mb-6">
    <form method="GET" action="{{ route('admin.sponsors.index') }}" class="flex flex-wrap gap-3">
        <div class="relative flex-1 min-w-[200px]">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search name, email, username..."
                   class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none text-sm">
        </div>
        <select name="is_active" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none text-sm">
            <option value="">All Status</option>
            <option value="1" {{ request('is_active')==='1'?'selected':'' }}>Active</option>
            <option value="0" {{ request('is_active')==='0'?'selected':'' }}>Inactive</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 text-sm font-semibold transition">
            <i class="fas fa-filter mr-1"></i> Filter
        </button>
        @if(request()->hasAny(['search','is_active']))
        <a href="{{ route('admin.sponsors.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 text-sm transition">
            <i class="fas fa-times mr-1"></i> Clear
        </a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card p-0 overflow-hidden">
    @if($sponsors->isEmpty())
    <div class="text-center py-16">
        <i class="fas fa-users text-4xl text-gray-200 mb-3 block"></i>
        <p class="text-gray-500 font-medium">No sponsors found.</p>
        <a href="{{ route('admin.sponsors.create') }}" class="mt-3 inline-block text-orange-500 hover:underline text-sm">Add the first sponsor →</a>
    </div>
    @else
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">Sponsor</th>
                <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide hidden md:table-cell">Username</th>
                <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Children</th>
                <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide hidden md:table-cell">Status</th>
                <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Last Login</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($sponsors as $sponsor)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0">
                            <span class="text-orange-600 font-bold text-sm">{{ strtoupper(substr($sponsor->first_name,0,1)) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 leading-tight">{{ $sponsor->full_name }}</p>
                            <p class="text-xs text-gray-400">{{ $sponsor->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3.5 hidden md:table-cell text-gray-600">{{ $sponsor->username }}</td>
                <td class="px-5 py-3.5 hidden lg:table-cell">
                    @if($sponsor->children->isNotEmpty())
                        <div class="flex flex-wrap gap-1">
                            @foreach($sponsor->children->take(3) as $child)
                            <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">{{ $child->first_name }}</span>
                            @endforeach
                            @if($sponsor->children->count() > 3)
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs">+{{ $sponsor->children->count() - 3 }}</span>
                            @endif
                        </div>
                    @else
                        <span class="text-gray-300 text-xs">—</span>
                    @endif
                </td>
                <td class="px-5 py-3.5 hidden md:table-cell">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $sponsor->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $sponsor->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-5 py-3.5 hidden lg:table-cell text-xs text-gray-400">
                    {{ $sponsor->last_login_at ? $sponsor->last_login_at->diffForHumans() : 'Never' }}
                </td>
                <td class="px-5 py-3.5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.sponsors.show', $sponsor) }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 transition" title="View">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                        <a href="{{ route('admin.sponsors.edit', $sponsor) }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg bg-orange-50 text-orange-500 hover:bg-orange-100 transition" title="Edit">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST"
                              onsubmit="return confirm('Delete {{ addslashes($sponsor->full_name) }}?')">
                            @csrf @method('DELETE')
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($sponsors->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $sponsors->links() }}</div>
    @endif
    @endif
</div>

@endsection