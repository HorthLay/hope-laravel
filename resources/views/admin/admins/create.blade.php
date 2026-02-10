@extends('admin.layouts.app')

@section('title', 'Add Admin')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.admins.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="page-title">Add New Admin</h1>
            <p class="page-subtitle">Create a new administrator account</p>
        </div>
    </div>
</div>

<!-- Form -->
<div class="max-w-3xl">
    <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-6">
        @csrf

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
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('name') border-red-500 @enderror"
                           placeholder="John Doe"
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
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('email') border-red-500 @enderror"
                           placeholder="admin@hopeimpact.org"
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Security -->
        <div class="card">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-lock text-orange-500"></i>
                Security
            </h2>

            <div class="space-y-5">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password"
                               name="password" 
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('password') border-red-500 @enderror"
                               placeholder="••••••••"
                               required>
                        <button type="button" 
                                onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
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
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password_confirmation"
                               name="password_confirmation" 
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="••••••••"
                               required>
                        <button type="button" 
                                onclick="togglePassword('password_confirmation')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role & Permissions -->
        <div class="card">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-shield-alt text-orange-500"></i>
                Role & Permissions
            </h2>

            <div class="space-y-5">
                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select id="role"
                            name="role" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition @error('role') border-red-500 @enderror"
                            required>
                        <option value="">Select Role</option>
                        <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>
                            Super Admin - Full System Access
                        </option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                            Admin - Manage Content & Users
                        </option>
                        <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>
                            Editor - Manage Content Only
                        </option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Role Descriptions -->
                    <div class="mt-4 space-y-2">
                        <div class="flex items-start gap-3 p-3 bg-purple-50 rounded-lg">
                            <i class="fas fa-crown text-purple-500 mt-0.5"></i>
                            <div>
                                <p class="text-sm font-semibold text-purple-900">Super Admin</p>
                                <p class="text-xs text-purple-700">Full access to all features, settings, and user management</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-user-shield text-blue-500 mt-0.5"></i>
                            <div>
                                <p class="text-sm font-semibold text-blue-900">Admin</p>
                                <p class="text-xs text-blue-700">Manage articles, categories, media, and view analytics</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-user-edit text-green-500 mt-0.5"></i>
                            <div>
                                <p class="text-sm font-semibold text-green-900">Editor</p>
                                <p class="text-xs text-green-700">Create and edit articles, manage own content</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-5 h-5 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                        <div>
                            <span class="text-sm font-semibold text-gray-700">Active Account</span>
                            <p class="text-xs text-gray-500">User can login and access the admin panel</p>
                        </div>
                    </label>
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

            <button type="submit" 
                    class="action-btn">
                <i class="fas fa-save mr-2"></i>
                Create Admin
            </button>
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