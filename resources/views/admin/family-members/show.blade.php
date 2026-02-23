{{-- resources/views/admin/family-members/show.blade.php --}}
@extends('admin.layouts.app')
@section('title', $member->name)
@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.family-members.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-arrow-left text-gray-600"></i>
    </a>
    <div class="flex-1"><h1 class="page-title">{{ $member->name }}</h1><p class="page-subtitle">Family Member Profile</p></div>
    <a href="{{ route('admin.family-members.edit', $member) }}" class="action-btn"><i class="fas fa-edit"></i><span>Edit</span></a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-5">
        {{-- Profile card --}}
        <div class="card text-center">
            <div class="flex justify-center mb-4">
                @if($member->profile_photo)
                <img src="{{ asset($member->profile_photo) }}" class="w-28 h-28 rounded-2xl object-cover border-4 border-orange-100 shadow">
                @else
                <div class="w-28 h-28 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center shadow">
                    <span class="text-4xl font-black text-white">{{ strtoupper(substr($member->name,0,1)) }}</span>
                </div>
                @endif
            </div>
            <h2 class="text-xl font-black text-gray-800">{{ $member->name }}</h2>
            <span class="inline-block mt-1.5 px-3 py-1 bg-blue-50 text-blue-700 text-sm font-bold rounded-full">
                {{ $member->relationship }}
            </span>
            <div class="flex justify-center mt-2">
                <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $member->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-500' }}">
                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        {{-- Contact --}}
        <div class="card space-y-3">
            <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2"><i class="fas fa-address-card text-orange-400"></i> Contact Info</h3>
            @if($member->phone)
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-phone text-green-500 text-xs"></i>
                </div>
                <div><p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Phone</p><p class="text-sm font-semibold text-gray-700">{{ $member->phone }}</p></div>
            </div>
            @endif
            @if($member->email)
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-envelope text-blue-500 text-xs"></i>
                </div>
                <div><p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Email</p><p class="text-sm font-semibold text-gray-700 break-all">{{ $member->email }}</p></div>
            </div>
            @endif
            @if(!$member->phone && !$member->email)
            <p class="text-sm text-gray-400 text-center py-2">No contact info.</p>
            @endif
        </div>

        {{-- Actions --}}
        <div class="card space-y-2">
            <a href="{{ route('admin.family-members.edit', $member) }}" class="flex items-center gap-3 w-full px-4 py-2.5 bg-orange-50 hover:bg-orange-100 text-orange-600 font-semibold rounded-xl transition text-sm">
                <i class="fas fa-edit w-4 text-center"></i> Edit Member
            </a>
            @if($member->family)
            <a href="{{ route('admin.families.show', $member->family_id) }}" class="flex items-center gap-3 w-full px-4 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-600 font-semibold rounded-xl transition text-sm">
                <i class="fas fa-home w-4 text-center text-orange-400"></i> View Family
            </a>
            @endif
            <form action="{{ route('admin.family-members.destroy', $member) }}" method="POST" onsubmit="return confirm('Delete {{ addslashes($member->name) }}?')">
                @csrf @method('DELETE')
                <button class="flex items-center gap-3 w-full px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition text-sm">
                    <i class="fas fa-trash w-4 text-center"></i> Delete Member
                </button>
            </form>
        </div>
    </div>

    {{-- Right --}}
    <div class="lg:col-span-2">
        @if($member->family)
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-home text-orange-500"></i> Family
            </h3>
            <a href="{{ route('admin.families.show', $member->family) }}" class="flex items-center gap-4 p-4 bg-orange-50 rounded-2xl border border-orange-200 hover:border-orange-400 transition group">
                @if($member->family->profile_photo)
                <img src="{{ $member->family->profile_photo_url }}" class="w-16 h-16 rounded-xl object-cover flex-shrink-0 border-2 border-orange-200">
                @else
                <div class="w-16 h-16 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-home text-orange-400 text-xl"></i>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="font-black text-gray-800 text-lg">{{ $member->family->name }}</p>
                    <p class="text-sm text-gray-500 mt-0.5">
                        <span class="font-mono text-xs">{{ $member->family->code }}</span>
                        @if($member->family->country) · {{ $member->family->country }} @endif
                    </p>
                    <span class="inline-block mt-1 px-2 py-0.5 text-xs font-bold rounded-full {{ $member->family->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-500' }}">
                        {{ $member->family->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <i class="fas fa-arrow-right text-orange-400 group-hover:translate-x-1 transition-transform"></i>
            </a>

            {{-- Other members in same family --}}
            @php $siblings = $member->family->members->where('id', '!=', $member->id); @endphp
            @if($siblings->isNotEmpty())
            <div class="mt-5">
                <p class="text-xs font-black text-gray-500 uppercase tracking-wide mb-3">Other Members in This Family</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($siblings as $sibling)
                    <a href="{{ route('admin.family-members.show', $sibling) }}" class="flex items-center gap-2.5 p-2.5 rounded-xl border border-gray-100 hover:border-orange-200 hover:bg-orange-50 transition group">
                        @if($sibling->profile_photo)
                        <img src="{{ asset($sibling->profile_photo) }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0 border border-gray-200">
                        @else
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-black text-white">{{ strtoupper(substr($sibling->name,0,1)) }}</span>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800 truncate group-hover:text-orange-600">{{ $sibling->name }}</p>
                            <p class="text-xs text-gray-400">{{ $sibling->relationship }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

@endsection