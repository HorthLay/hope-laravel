{{-- resources/views/admin/admins/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Admin')

@section('content')
@php
    $currentAdmin = Auth::guard('admin')->user();
    $isSuperAdmin = $currentAdmin->role === 'super_admin';
    $isEditingSelf = $admin->id === $currentAdmin->id;
@endphp

<!-- Page Header -->
<div class="page-header">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.admins.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="page-title">{{ $isEditingSelf ? 'Edit My Profile' : 'Edit Admin' }}</h1>
            <p class="page-subtitle">{{ $isEditingSelf ? 'Update your account details' : 'Update administrator account details' }}</p>
        </div>
    </div>
</div>

<!-- Permission Warning -->
@if(!$isSuperAdmin && !$isEditingSelf)
    <div class="max-w-3xl mb-6">
        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg flex items-start gap-3">
            <i class="fas fa-exclamation-triangle text-xl mt-0.5"></i>
            <div>
                <h3 class="font-semibold mb-1">Access Denied</h3>
                <p class="text-sm">Only Super Admins can edit other administrator accounts.</p>
            </div>
        </div>
    </div>
@endif

<!-- Form -->
<div class="max-w-3xl">
    <form action="{{ route('admin.admins.update', $admin) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Account Info Card -->
        <div class="card bg-gradient-to-br from-orange-50 to-orange-100 border-orange-200">
            <div class="flex items-center gap-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&size=80&background=f97316&color=fff" 
                     alt="{{ $admin->name }}" 
                     class="w-16 h-16 rounded-full shadow-lg">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">
                        {{ $admin->name }}
                        @if($isEditingSelf)
                            <span class="text-sm text-orange-600 font-normal">(You)</span>
                        @endif
                    </h3>
                    <p class="text-sm text-gray-600">{{ $admin->email }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        @if($admin->role === 'super_admin')
                            <span class="px-2 py-1 bg-purple-500 text-white rounded text-xs font-semibold">
                                <i class="fas fa-crown mr-1"></i>Super Admin
                            </span>
                        @elseif($admin->role === 'admin')
                            <span class="px-2 py-1 bg-blue-500 text-white rounded text-xs font-semibold">
                                <i class="fas fa-user-shield mr-1"></i>Admin
                            </span>
                        @else
                            <span class="px-2 py-1 bg-green-500 text-white rounded text-xs font-semibold">
                                <i class="fas fa-user-edit mr-1"></i>Editor
                            </span>
                        @endif

                        @if($admin->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">
                                <i class="fas fa-check-circle mr-1"></i>Active
                            </span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-semibold">
                                <i class="fas fa-times-circle mr-1"></i>Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="card">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-user text-orange-500"></i>
                Personal Information
            </h2>

            <div class="space-y-5">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name"
                           name="name" 
                           value="{{ old('name', $admin->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('name') border-red-500 @enderror"
                           {{ (!$isSuperAdmin && !$isEditingSelf) ? 'disabled' : '' }}
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email"
                           name="email" 
                           value="{{ old('email', $admin->email) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('email') border-red-500 @enderror"
                           {{ (!$isSuperAdmin && !$isEditingSelf) ? 'disabled' : '' }}
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Change Password (Optional) -->
        <div class="card">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-lock text-orange-500"></i>
                Change Password
                <span class="ml-auto text-xs font-normal text-gray-500">(Optional)</span>
            </h2>

            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg mb-5">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                    <p class="text-sm text-blue-700">Leave password fields empty to keep the current password</p>
                </div>
            </div>

            <div class="space-y-5">
                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        New Password
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password"
                               name="password" 
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('password') border-red-500 @enderror"
                               placeholder="••••••••"
                               {{ (!$isSuperAdmin && !$isEditingSelf) ? 'disabled' : '' }}>
                        <button type="button" 
                                onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                {{ (!$isSuperAdmin && !$isEditingSelf) ? 'disabled' : '' }}>
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Minimum 8 characters</p>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirm New Password
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password_confirmation"
                               name="password_confirmation" 
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="••••••••"
                               {{ (!$isSuperAdmin && !$isEditingSelf) ? 'disabled' : '' }}>
                        <button type="button" 
                                onclick="togglePassword('password_confirmation')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                {{ (!$isSuperAdmin && !$isEditingSelf) ? 'disabled' : '' }}>
                            <i class="fas fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role & Permissions - Only Super Admin can change -->
        <div class="card {{ (!$isSuperAdmin) ? 'opacity-75' : '' }}">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-shield-alt text-orange-500"></i>
                Role & Permissions
                @if(!$isSuperAdmin)
                    <span class="ml-auto text-xs font-normal text-red-600 flex items-center gap-1">
                        <i class="fas fa-lock"></i>
                        Super Admin Only
                    </span>
                @endif
            </h2>

            @if(!$isSuperAdmin)
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg mb-5">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-yellow-600 mt-0.5"></i>
                        <p class="text-sm text-yellow-800">Only Super Admins can change user roles and account status.</p>
                    </div>
                </div>
            @endif

            <div class="space-y-5">
                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                        @if(!$isSuperAdmin)
                            <span class="text-xs text-gray-500">(Read-only)</span>
                        @endif
                    </label>
                    <select id="role"
                            name="role" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('role') border-red-500 @enderror {{ (!$isSuperAdmin) ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            {{ (!$isSuperAdmin) ? 'disabled' : '' }}
                            required>
                        <option value="super_admin" {{ old('role', $admin->role) == 'super_admin' ? 'selected' : '' }}>
                            👑 Super Admin - Full System Access
                        </option>
                        <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>
                            🛡️ Admin - Manage Content & Users
                        </option>
                        <option value="editor" {{ old('role', $admin->role) == 'editor' ? 'selected' : '' }}>
                            ✏️ Editor - Manage Content Only
                        </option>
                    </select>
                    
                    {{-- Hidden field to preserve role if not super admin --}}
                    @if(!$isSuperAdmin)
                        <input type="hidden" name="role" value="{{ $admin->role }}">
                    @endif
                    
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center gap-3 {{ (!$isSuperAdmin) ? 'cursor-not-allowed' : 'cursor-pointer' }}">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $admin->is_active) ? 'checked' : '' }}
                               {{ (!$isSuperAdmin) ? 'disabled' : '' }}
                               class="w-5 h-5 text-orange-500 border-gray-300 rounded focus:ring-orange-500 {{ (!$isSuperAdmin) ? 'cursor-not-allowed' : '' }}">
                        <div>
                            <span class="text-sm font-semibold text-gray-700">
                                Active Account
                                @if(!$isSuperAdmin)
                                    <span class="text-xs text-gray-500">(Read-only)</span>
                                @endif
                            </span>
                            <p class="text-xs text-gray-500">User can login and access the admin panel</p>
                        </div>
                    </label>
                    
                    {{-- Hidden field to preserve status if not super admin --}}
                    @if(!$isSuperAdmin && $admin->is_active)
                        <input type="hidden" name="is_active" value="1">
                    @endif
                </div>
            </div>
        </div>

        <!-- Account Statistics -->
        <div class="card bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-line text-orange-500"></i>
                Account Statistics
            </h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Member Since</p>
                    <p class="font-semibold text-gray-800">{{ $admin->created_at->format('M d, Y') }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Last Login</p>
                    <p class="font-semibold text-gray-800">
                        {{ $admin->last_login_at ? $admin->last_login_at->diffForHumans() : 'Never' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Total Articles</p>
                    <p class="font-semibold text-gray-800">{{ $admin->articles()->count() ?? 0 }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Account Status</p>
                    <p class="font-semibold {{ $admin->is_active ? 'text-green-600' : 'text-gray-600' }}">
                        {{ $admin->is_active ? 'Active' : 'Inactive' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('admin.admins.index') }}" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>

            @if($isSuperAdmin || $isEditingSelf)
                <button type="submit" 
                        class="action-btn">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isEditingSelf ? 'Update My Profile' : 'Update Admin' }}
                </button>
            @else
                <button type="button" 
                        class="px-6 py-3 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-semibold"
                        disabled>
                    <i class="fas fa-lock mr-2"></i>
                    No Permission
                </button>
            @endif
        </div>
    </form>
</div>

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush

@endsection