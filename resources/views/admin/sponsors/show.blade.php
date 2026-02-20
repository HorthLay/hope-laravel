{{-- resources/views/admin/sponsors/show.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Sponsor Details')
@section('content')

<div class="page-header">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.sponsors.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div class="flex-1">
            <h1 class="page-title">Sponsor Details</h1>
            <p class="page-subtitle">{{ $sponsor->full_name }}</p>
        </div>
        <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="action-btn">
            <i class="fas fa-edit"></i><span>Edit</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ══ MAIN ══ --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Profile card --}}
        <div class="card">
            <div class="flex items-center gap-5 mb-6 pb-6 border-b border-gray-100">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center flex-shrink-0 shadow-md">
                    <span class="text-white font-black text-2xl">{{ strtoupper(substr($sponsor->first_name,0,1)) }}</span>
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-800">{{ $sponsor->full_name }}</h2>
                    <p class="text-sm text-gray-500">{{ $sponsor->username }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $sponsor->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            <i class="fas fa-circle text-[8px] mr-1"></i>{{ $sponsor->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Email</p>
                    <p class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-envelope text-orange-400"></i> {{ $sponsor->email }}
                    </p>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Username</p>
                    <p class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-at text-orange-400"></i> {{ $sponsor->username }}
                    </p>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Joined</p>
                    <p class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-calendar text-orange-400"></i> {{ $sponsor->created_at->format('M d, Y') }}
                    </p>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Last Login</p>
                    <p class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-clock text-orange-400"></i>
                        {{ $sponsor->last_login_at ? $sponsor->last_login_at->format('M d, Y H:i') : 'Never' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Sponsored Children --}}
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-child text-orange-500"></i> Sponsored Children
                <span class="ml-1 px-2 py-0.5 bg-orange-100 text-orange-600 rounded-full text-xs font-black">{{ $sponsor->children->count() }}</span>
            </h3>
            @if($sponsor->children->isEmpty())
            <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <i class="fas fa-child text-3xl text-gray-200 mb-2 block"></i>
                <p class="text-sm text-gray-400">No children assigned yet.</p>
                <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="mt-2 inline-block text-orange-500 text-sm hover:underline font-semibold">Assign children →</a>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($sponsor->children as $child)
                <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-xl border border-purple-100 hover:border-purple-300 transition">
                    <img src="{{ asset($child->profile_photo) }}"
                         class="w-12 h-12 rounded-full object-cover flex-shrink-0 border-2 border-purple-200"
                         onerror="this.src='{{ asset('images/child-placeholder.jpg') }}'">
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 text-sm truncate">{{ $child->first_name }}</p>
                        <p class="text-xs text-gray-500">{{ $child->code }}</p>
                        <p class="text-xs text-gray-400">Age {{ $child->age }} · {{ $child->country }}</p>
                    </div>
                    <a href="{{ route('admin.children.show', $child) }}"
                       class="w-7 h-7 flex items-center justify-center bg-purple-100 hover:bg-purple-200 text-purple-600 rounded-full transition flex-shrink-0"
                       title="View child">
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Sponsored Families --}}
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-users text-purple-500"></i> Sponsored Families
                <span class="ml-1 px-2 py-0.5 bg-purple-100 text-purple-600 rounded-full text-xs font-black">{{ $sponsor->families->count() }}</span>
            </h3>
            @if($sponsor->families->isEmpty())
            <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <i class="fas fa-users text-3xl text-gray-200 mb-2 block"></i>
                <p class="text-sm text-gray-400">No families assigned yet.</p>
                <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="mt-2 inline-block text-purple-500 text-sm hover:underline font-semibold">Assign families →</a>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($sponsor->families as $family)
                <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-xl border border-purple-100 hover:border-purple-300 transition">
                    <img src="{{ asset($family->profile_photo) }}"
                         class="w-12 h-12 rounded-full object-cover flex-shrink-0 border-2 border-purple-200"
                         onerror="this.src='{{ asset('images/family-placeholder.jpg') }}'">
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 text-sm truncate">{{ $family->name }}</p>
                        <p class="text-xs text-gray-500">{{ $family->code }}</p>
                        <p class="text-xs text-gray-400">{{ $family->country }}</p>
                    </div>
                    <a href="{{ route('admin.families.show', $family) }}"
                       class="w-7 h-7 flex items-center justify-center bg-purple-100 hover:bg-purple-200 text-purple-600 rounded-full transition flex-shrink-0"
                       title="View family">
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                    </div>
                    @endforeach
                    </div>
            @endif
        </div>

    </div>

    {{-- ══ SIDEBAR ══ --}}
    <div class="lg:col-span-1 space-y-6">

        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4">Actions</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.sponsors.edit', $sponsor) }}"
                   class="flex items-center gap-3 w-full px-4 py-2.5 bg-orange-50 hover:bg-orange-100 text-orange-600 font-semibold rounded-xl transition text-sm">
                    <i class="fas fa-edit w-4 text-center"></i> Edit Sponsor
                </a>
                <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST"
                      onsubmit="return confirm('Delete {{ addslashes($sponsor->full_name) }}? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <button class="flex items-center gap-3 w-full px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition text-sm">
                        <i class="fas fa-trash w-4 text-center"></i> Delete Sponsor
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-orange-500"></i> Account Info
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Status</span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $sponsor->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $sponsor->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Children</span>
                    <span class="text-sm font-bold text-purple-600">{{ $sponsor->children->count() }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Created</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $sponsor->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between py-1.5">
                    <span class="text-sm text-gray-500">Updated</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $sponsor->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection