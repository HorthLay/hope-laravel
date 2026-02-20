<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Hope & Impact Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    
    <style>
        :root {
            --sidebar-width: 280px;
            --topbar-height: 64px;
            --primary-orange: #f97316;
            --primary-dark: #ea580c;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* ========== DESKTOP SIDEBAR ========== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            z-index: 1000;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.2);
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-logo {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-logo .logo-icon {
            width: 80px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
        }

        .sidebar-nav {
            padding: 1rem;
            overflow-y: auto;
            height: calc(100vh - 180px);
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary-orange);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transform: translateX(4px);
        }

        .nav-item.active {
            background: rgba(249, 115, 22, 0.15);
            color: white;
        }

        .nav-item.active::before {
            transform: scaleY(1);
        }

        .nav-item i {
            width: 20px;
            font-size: 18px;
        }

        .nav-group-title {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 1.5rem 0 0.75rem 1rem;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
        }

        /* Role Badge in Sidebar Footer */
        .role-badge {
            font-size: 0.65rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-weight: 600;
            margin-top: 0.25rem;
            display: inline-block;
        }

        .role-super-admin {
            background: rgba(168, 85, 247, 0.2);
            color: #c084fc;
        }

        .role-admin {
            background: rgba(59, 130, 246, 0.2);
            color: #93c5fd;
        }

        .role-editor {
            background: rgba(34, 197, 94, 0.2);
            color: #86efac;
        }

        /* ========== MOBILE TOP BAR ========== */
        .mobile-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid #e5e7eb;
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            z-index: 999;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: #f8fafc;
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .content-wrapper {
            padding: 2rem;
            max-width: 1400px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .mobile-topbar {
                display: flex;
            }

            .main-content {
                margin-left: 0;
                padding-top: var(--topbar-height);
            }

            .content-wrapper {
                padding: 1rem;
            }
        }

        /* ========== MOBILE OVERLAY ========== */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* ========== COMMON COMPONENTS ========== */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6b7280;
        }

        .action-btn {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide-in {
            animation: slideInRight 0.6s ease forwards;
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay" onclick="closeSidebar()"></div>

    <!-- Desktop Sidebar -->
    <aside id="sidebar" class="sidebar">
        <!-- Logo -->
        <div class="sidebar-logo flex items-center gap-3 px-4 py-4 relative overflow-hidden"
     style="min-height: 88px;">

    <!-- Background Image with dark overlay to keep text readable -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/image.jpg') }}" 
             alt="" 
             class="w-full h-full object-cover object-center">
        <!-- Gradient overlay to blend with sidebar dark theme -->
        <div class="absolute inset-0" 
             style="background: linear-gradient(135deg, rgba(15,23,42,0.75) 0%, rgba(249,115,22,0.55) 60%, rgba(234,88,12,0.65) 100%);"></div>
    </div>

    <!-- Animated Particles -->
    <div class="particles-container absolute inset-0 pointer-events-none z-10">
        <span class="particle" style="--x: 15%; --delay: 0s;   --size: 4px; --duration: 4s;"></span>
        <span class="particle" style="--x: 30%; --delay: 0.8s; --size: 3px; --duration: 5s;"></span>
        <span class="particle" style="--x: 50%; --delay: 1.5s; --size: 5px; --duration: 3.5s;"></span>
        <span class="particle" style="--x: 65%; --delay: 0.3s; --size: 3px; --duration: 4.5s;"></span>
        <span class="particle" style="--x: 80%; --delay: 1s;   --size: 4px; --duration: 5.5s;"></span>
        <span class="particle" style="--x: 90%; --delay: 2s;   --size: 2px; --duration: 4s;"></span>
        <span class="particle" style="--x: 42%; --delay: 2.5s; --size: 3px; --duration: 3s;"></span>
        <span class="particle" style="--x: 72%; --delay: 1.8s; --size: 5px; --duration: 6s;"></span>

        <!-- Glowing orbs -->
        <div class="glow-orb" style="width:90px; height:90px; top:-25px; right:-15px; --orb-color: rgba(249,115,22,0.4);"></div>
        <div class="glow-orb" style="width:60px; height:60px; bottom:-20px; left:35%; --orb-color: rgba(234,88,12,0.3);"></div>
    </div>

    <!-- Logo with glow ring -->
    <div class="relative z-20 flex-shrink-0">
    <img src="{{ asset('images/logo.png') }}"
         alt="Hope & Impact Logo"
         class="h-14 w-auto object-contain drop-shadow-lg">
</div>

    <!-- Text Block -->
    <div class="relative z-20">
        <p class="text-white font-extrabold text-base leading-tight tracking-wide"
           style="text-shadow: 0 1px 8px rgba(0,0,0,0.6);">
            Admin Dashboard
        </p>
      
    </div>
</div>

<style>
/* ===== PARTICLES ===== */
.particle {
    position: absolute;
    left: var(--x);
    bottom: -6px;
    width: var(--size);
    height: var(--size);
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.85);
    animation: floatUp var(--duration) ease-in var(--delay) infinite;
    box-shadow: 0 0 5px rgba(255, 255, 255, 0.6);
}

@keyframes floatUp {
    0%   { transform: translateY(0) scale(1);    opacity: 0; }
    10%  { opacity: 1; }
    80%  { opacity: 0.5; }
    100% { transform: translateY(-95px) scale(0.3); opacity: 0; }
}

/* ===== GLOWING ORBS ===== */
.glow-orb {
    position: absolute;
    border-radius: 50%;
    background: var(--orb-color);
    filter: blur(20px);
    animation: pulse-orb 4s ease-in-out infinite alternate;
}

@keyframes pulse-orb {
    0%   { transform: scale(1);   opacity: 0.5; }
    100% { transform: scale(1.4); opacity: 1;   }
}

/* ===== LOGO RING ===== */
.logo-ring {
    padding: 6px;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(8px);
    box-shadow:
        0 0 0 2px rgba(249, 115, 22, 0.45),
        0 4px 20px rgba(0, 0, 0, 0.4);
    animation: ring-pulse 3s ease-in-out infinite;
}

@keyframes ring-pulse {
    0%, 100% { box-shadow: 0 0 0 2px rgba(249,115,22,0.45), 0 4px 20px rgba(0,0,0,0.4); }
    50%       { box-shadow: 0 0 0 4px rgba(249,115,22,0.75), 0 4px 24px rgba(249,115,22,0.35); }
}
</style>


        <!-- Navigation -->
        <nav class="sidebar-nav">
            @php
                $currentAdmin = Auth::guard('admin')->user();
                $isSuperAdmin = $currentAdmin->role === 'super_admin';
                $isAdmin = $currentAdmin->role === 'admin';
                $isEditor = $currentAdmin->role === 'editor';
            @endphp

            {{-- Dashboard - Available to ALL roles --}}
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            {{-- Content Management - Available to ALL roles --}}
            <div class="nav-group-title">Content Management</div>
            
            <a href="{{ route('admin.articles.index') }}" class="nav-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i>
                <span class="font-medium">Articles</span>
                @php
                    $draftCount = \App\Models\Article::where('status', 'draft')->count();
                @endphp
                @if($draftCount > 0)
                    <span class="ml-auto bg-orange-500 text-white text-xs px-2 py-1 rounded-full">{{ $draftCount }}</span>
                @endif
            </a>


            <a href="{{ route('admin.tags.index') }}" class="nav-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i>
                <span class="font-medium">Tags</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-folder"></i>
                <span class="font-medium">Categories</span>
            </a>

            <a href="{{ route('admin.media.index') }}" class="nav-item {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <i class="fas fa-images"></i>
                <span class="font-medium">Media Library</span>
            </a>


            
            <a href="{{ route('admin.children.index') }}" class="nav-item {{ request()->routeIs('admin.children.*') ? 'active' : '' }}">
                <i class="fas fa-child"></i>
                <span class="font-medium">Children</span>
            </a>


            <a href="{{ route('admin.families.index') }}" class="nav-item {{ request()->routeIs('admin.families.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span class="font-medium">Families</span>
            </a>

             <a href="{{ route('admin.sponsors.index') }}" class="nav-item {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-heart"></i>
                <span class="font-medium">Sponsors</span>
            </a>

            



            {{-- User Management - Only SUPER ADMIN & ADMIN --}}
            @if($isSuperAdmin || $isAdmin)
                <div class="nav-group-title">User Management</div>
                
                {{-- Admins - Only SUPER ADMIN --}}
                @if($isSuperAdmin)
                    <a href="{{ route('admin.admins.index') }}" class="nav-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span class="font-medium">Admins</span>
                        @php
                            $adminCount = \App\Models\Admin::count();
                        @endphp
                        <span class="ml-auto text-xs text-gray-400">{{ $adminCount }}</span>
                    </a>
                @endif

                {{-- Additional user management items for Admin & Super Admin --}}
                {{-- You can add more items here like Sponsors, Donations, etc. --}}
            @endif

            {{-- Reports & Analytics - Only SUPER ADMIN & ADMIN --}}
            @if($isSuperAdmin || $isAdmin)
                <div class="nav-group-title">Reports & Analytics</div>
                
                <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span class="font-medium">Reports</span>
                </a>

                <a href="{{ route('admin.analytics.index') }}" class="nav-item {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span class="font-medium">Analytics</span>
                </a>
            @endif

            {{-- Settings - Only SUPER ADMIN --}}
            @if($isSuperAdmin)
                <div class="nav-group-title">System</div>
                
                <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span class="font-medium">Settings</span>
                </a>
            @endif

            {{-- My Profile - Available to ALL roles --}}
            <div class="nav-group-title">Account</div>
            
            <a href="{{ route('admin.admins.edit', $currentAdmin) }}" class="nav-item {{ request()->routeIs('admin.admins.edit') && request()->route('admin')->id == $currentAdmin->id ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i>
                <span class="font-medium">My Profile</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($currentAdmin->name) }}&background=f97316&color=fff" 
                         alt="{{ $currentAdmin->name }}" 
                         class="w-10 h-10 rounded-full">
                    @if($currentAdmin->is_active)
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-gray-800 rounded-full"></span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-semibold truncate">{{ $currentAdmin->name }}</p>
                    <div class="flex items-center gap-2">
                        @if($isSuperAdmin)
                            <span class="role-badge role-super-admin">
                                <i class="fas fa-crown text-xs"></i> Super Admin
                            </span>
                        @elseif($isAdmin)
                            <span class="role-badge role-admin">
                                <i class="fas fa-user-shield text-xs"></i> Admin
                            </span>
                        @else
                            <span class="role-badge role-editor">
                                <i class="fas fa-user-edit text-xs"></i> Editor
                            </span>
                        @endif
                    </div>
                </div>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
                <button onclick="logout()" class="text-gray-400 hover:text-white transition" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>
    </aside>

    <!-- Mobile Top Bar -->
    <div class="mobile-topbar">
        <button onclick="toggleSidebar()" class="text-gray-700 hover:text-orange-500 transition">
            <i class="fas fa-bars text-xl"></i>
        </button>

     <div class="flex items-center gap-2">
    
    <!-- Logo Image -->
    <img src="{{ asset('images/logo.png') }}" 
         alt="Hope & Impact Logo" 
         class="w-8 h-8 object-contain rounded-lg">
        
    </div>


        <button class="text-gray-700 hover:text-orange-500 transition">
            <i class="fas fa-bell text-xl"></i>
        </button>
    </div>

    <!-- Main Content -->
    <main id="main-content" class="main-content">
        <div class="content-wrapper">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-center animate-slide-in">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 flex items-center animate-slide-in">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Page Content --}}
            @yield('content')
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                document.getElementById('logout-form').submit();
            }
        }

        // Close sidebar on nav item click (mobile)
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 1024) {
                    closeSidebar();
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s, transform 0.5s';
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(20px)';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

    @stack('scripts')

</body>
</html>