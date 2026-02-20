{{-- resources/views/admin/sponsors/edit.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Edit Sponsor')
@section('content')

<div class="page-header">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.sponsors.show', $sponsor) }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div class="flex-1">
            <h1 class="page-title">Edit Sponsor</h1>
            <p class="page-subtitle">{{ $sponsor->full_name }}</p>
        </div>
        <a href="{{ route('admin.sponsors.show', $sponsor) }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-sm">
            <i class="fas fa-eye mr-1"></i> View
        </a>
    </div>
</div>

<div class="mb-6">
    <div class="card" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);border-color:#fed7aa">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center flex-shrink-0 shadow">
                <span class="text-white font-black text-xl">{{ strtoupper(substr($sponsor->first_name,0,1)) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-gray-800">{{ $sponsor->full_name }}</h3>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class="text-xs text-gray-500">{{ $sponsor->username }}</span>
                    <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $sponsor->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">{{ $sponsor->is_active ? 'Active' : 'Inactive' }}</span>
                    @if($sponsor->children->isNotEmpty())
                    <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-purple-100 text-purple-600"><i class="fas fa-child text-xs mr-1"></i>{{ $sponsor->children->count() }} {{ Str::plural('child', $sponsor->children->count()) }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.sponsors.update', $sponsor) }}" method="POST" id="sponsor-form">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-user text-orange-500"></i> Personal Info</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name', $sponsor->first_name) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('first_name') border-red-500 @enderror">
                        @error('first_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name', $sponsor->last_name) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('last_name') border-red-500 @enderror">
                        @error('last_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-lock text-orange-500"></i> Account Credentials</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $sponsor->email) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('email') border-red-500 @enderror">
                        @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Username <span class="text-red-500">*</span></label>
                        <div class="relative"><span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm select-none">@</span>
                        <input type="text" name="username" value="{{ old('username', $sponsor->username) }}" required class="w-full pl-7 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('username') border-red-500 @enderror"></div>
                        @error('username')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                        <p class="text-xs font-bold text-yellow-700 mb-3 flex items-center gap-1.5"><i class="fas fa-key"></i> Change Password <span class="font-normal text-yellow-600">(leave blank to keep current)</span></p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                                <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('password') border-red-500 @enderror" placeholder="Min 8 characters">
                                @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Repeat password">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-1 space-y-6">
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-cog text-orange-500"></i> Settings</h3>
                <div class="flex items-center justify-between py-2">
                    <div><p class="text-sm font-semibold text-gray-700">Active Account</p><p class="text-xs text-gray-400">Sponsor can log in</p></div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $sponsor->is_active) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                    </label>
                </div>
            </div>
            @include('admin.sponsors.partials._children_picker', [
                'selectedChildIds' => old('children', $sponsor->children->pluck('id')->toArray())
            ])
            @include('admin.sponsors.partials._family_picker', [
                'selectedFamilyIds' => old('families', $sponsor->families->pluck('id')->toArray())
            ])
            <div class="card space-y-3">
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition shadow-sm">
                    <i class="fas fa-save"></i> Update Sponsor
                </button>
                <a href="{{ route('admin.sponsors.show', $sponsor) }}" class="block w-full px-4 py-3 border border-gray-200 text-gray-500 text-center rounded-xl hover:bg-gray-50 text-sm font-medium">Cancel</a>
                <button type="button"
                        onclick="document.getElementById('delete-sponsor-form').submit()"
                        onmousedown="return confirm('Delete {{ addslashes($sponsor->full_name) }}? This cannot be undone.')"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition border border-red-200 text-sm">
                    <i class="fas fa-trash"></i> Delete Sponsor
                </button>
            </div>
        </div>
    </div>
</form>

{{-- Delete form OUTSIDE the update form --}}
<form id="delete-sponsor-form" action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>
@push('styles')
<style>#sponsor-child-dropdown::-webkit-scrollbar{width:4px}#sponsor-child-dropdown::-webkit-scrollbar-thumb{background:#e5e7eb;border-radius:4px}</style>
@endpush
@endsection