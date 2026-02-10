{{-- resources/views/admin/admins/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Admins')

@section('content')
<!-- Page Header -->
<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="page-title">Admin Users</h1>
        <p class="page-subtitle">Manage administrators and their permissions</p>
    </div>

    <a href="{{ route('admin.admins.create') }}" class="action-btn">
        <i class="fas fa-user-plus"></i>
        <span>Add Admin</span>
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Admins -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-blue-500 text-xl"></i>
            </div>
            <span class="text-blue-500 text-sm font-semibold">Total</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $totalAdmins ?? 0 }}</h3>
        <p class="text-gray-600 text-sm">Total Admins</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                <i class="fas fa-user-check text-green-500 mr-1"></i>
                {{ $activeAdmins ?? 0 }} active
            </p>
        </div>
    </div>

    <!-- Active Admins -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-check text-green-500 text-xl"></i>
            </div>
            <span class="text-green-500 text-sm font-semibold">Active</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $activeAdmins ?? 0 }}</h3>
        <p class="text-gray-600 text-sm">Active Admins</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                <i class="fas fa-percentage text-green-500 mr-1"></i>
                {{ $totalAdmins > 0 ? round(($activeAdmins / $totalAdmins) * 100) : 0 }}% active rate
            </p>
        </div>
    </div>

    <!-- Super Admins -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-crown text-purple-500 text-xl"></i>
            </div>
            <span class="text-purple-500 text-sm font-semibold">Super</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $superAdmins ?? 0 }}</h3>
        <p class="text-gray-600 text-sm">Super Admins</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                <i class="fas fa-shield-alt text-purple-500 mr-1"></i>
                Full access
            </p>
        </div>
    </div>

    <!-- Inactive Admins -->
    <div class="card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-slash text-gray-500 text-xl"></i>
            </div>
            <span class="text-gray-500 text-sm font-semibold">Inactive</span>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $totalAdmins - $activeAdmins }}</h3>
        <p class="text-gray-600 text-sm">Inactive Admins</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                <i class="fas fa-ban text-gray-500 mr-1"></i>
                Cannot login
            </p>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <form action="{{ route('admin.admins.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <!-- Search -->
        <div class="flex-1">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by name or email..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            </div>
        </div>

        <!-- Role Filter -->
        <select name="role" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            <option value="">All Roles</option>
            <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>
                <i class="fas fa-crown"></i> Super Admin
            </option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                <i class="fas fa-user-shield"></i> Admin
            </option>
            <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>
                <i class="fas fa-user-edit"></i> Editor
            </option>
        </select>

        <!-- Status Filter -->
        <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

        <!-- Filter Button -->
        <button type="submit" class="px-6 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition font-medium">
            <i class="fas fa-filter mr-2"></i>
            Filter
        </button>

        <!-- Clear Filters -->
        @if(request('search') || request('role') || request('status'))
            <a href="{{ route('admin.admins.index') }}" 
               class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                <i class="fas fa-times mr-2"></i>
                Clear
            </a>
        @endif
    </form>
</div>

<!-- Admins Table -->
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Admin</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Last Login</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($admins ?? [] as $admin)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Admin Info -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=random" 
                                         alt="{{ $admin->name }}" 
                                         class="w-10 h-10 rounded-full ring-2 ring-white shadow">
                                    @if($admin->is_active)
                                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                                    @else
                                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-gray-400 border-2 border-white rounded-full"></span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-gray-800 truncate">
                                        {{ $admin->name }}
                                        @if($admin->id === Auth::guard('admin')->id())
                                            <span class="text-xs text-orange-500">(You)</span>
                                        @endif
                                    </h4>
                                    <p class="text-sm text-gray-500 md:hidden truncate">{{ $admin->email }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Email -->
                        <td class="px-6 py-4 hidden md:table-cell">
                            <span class="text-gray-600 text-sm">{{ $admin->email }}</span>
                        </td>

                        <!-- Role -->
                        <td class="px-6 py-4">
                            @if($admin->role === 'super_admin')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                    <i class="fas fa-crown mr-1"></i>
                                    Super Admin
                                </span>
                            @elseif($admin->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    <i class="fas fa-user-shield mr-1"></i>
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <i class="fas fa-user-edit mr-1"></i>
                                    Editor
                                </span>
                            @endif
                        </td>

                        <!-- Last Login -->
                        <td class="px-6 py-4 hidden lg:table-cell">
                            <div class="text-sm text-gray-600">
                                @if($admin->last_login_at)
                                    <i class="fas fa-clock text-xs text-gray-400 mr-1"></i>
                                    {{ $admin->last_login_at->diffForHumans() }}
                                @else
                                    <span class="text-gray-400">Never</span>
                                @endif
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            @if($admin->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold flex items-center gap-1 w-fit">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Active
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold flex items-center gap-1 w-fit">
                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Edit -->
                                <a href="{{ route('admin.admins.edit', $admin) }}" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete (Only if not current user) -->
                                @if($admin->id !== Auth::guard('admin')->id())
                                    <form action="{{ route('admin.admins.destroy', $admin) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this admin?\n\nAdmin: {{ $admin->name }}\nEmail: {{ $admin->email }}\n\nThis action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" 
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="p-2 text-gray-300 rounded-lg cursor-not-allowed" 
                                            title="Cannot delete yourself"
                                            disabled>
                                        <i class="fas fa-lock"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user-shield text-gray-300 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">No admins found</h3>
                            <p class="text-gray-500 mb-6">
                                @if(request('search') || request('role') || request('status'))
                                    No admins match your filters. Try adjusting your search.
                                @else
                                    Add administrators to manage the system
                                @endif
                            </p>
                            @if(request('search') || request('role') || request('status'))
                                <a href="{{ route('admin.admins.index') }}" class="action-btn">
                                    <i class="fas fa-times mr-2"></i>
                                    Clear Filters
                                </a>
                            @else
                                <a href="{{ route('admin.admins.create') }}" class="action-btn">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Add Admin</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($admins) && $admins->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $admins->links() }}
        </div>
    @endif
</div>

<!-- Mobile Action Button -->
<a href="{{ route('admin.admins.create') }}" class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform z-50">
    <i class="fas fa-user-plus text-xl"></i>
</a>
@endsection