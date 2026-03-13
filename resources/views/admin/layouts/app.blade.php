@php
    $settings  = (function() {
        $file = storage_path('app/settings.json');
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    })();
    $siteName  = $settings['site_name']    ?? 'Hope & Impact';
    $siteLogo  = $settings['logo']         ?? null;
    $siteImage = $settings['header_image'] ?? $settings['cover_image'] ?? null;
    $favicon   = $settings['favicon']      ?? null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ $siteName }} Admin</title>
    @if($favicon)
    <link rel="icon" type="image/png" href="{{ asset($favicon) }}">
    @endif
    
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

        body { font-family: 'Inter', sans-serif; }

        /* ========== DESKTOP SIDEBAR ========== */
        .sidebar {
            position: fixed; left: 0; top: 0;
            width: var(--sidebar-width); height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            z-index: 1000;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.2);
        }
        .sidebar.collapsed { transform: translateX(-100%); }

        .sidebar-logo {
            padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; gap: 1rem;
        }
        .sidebar-logo .logo-icon {
            width: 80px; height: 60px;
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-dark) 100%);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(249,115,22,0.4);
        }

        .sidebar-nav {
            padding: 1rem; overflow-y: auto;
            height: calc(100vh - 180px);
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 2px; }

        .nav-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.875rem 1rem; margin-bottom: 0.5rem;
            color: rgba(255,255,255,0.7); border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            cursor: pointer; position: relative; overflow: hidden;
            text-decoration: none;
        }
        .nav-item::before {
            content: ''; position: absolute; left: 0; top: 0;
            height: 100%; width: 3px; background: var(--primary-orange);
            transform: scaleY(0); transition: transform 0.3s ease;
        }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: white; transform: translateX(4px); }
        .nav-item.active { background: rgba(249,115,22,0.15); color: white; }
        .nav-item.active::before { transform: scaleY(1); }
        .nav-item i { width: 20px; font-size: 18px; }

        .nav-group-title {
            color: rgba(255,255,255,0.4); font-size: 0.75rem;
            font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.05em; margin: 1.5rem 0 0.75rem 1rem;
        }

        .sidebar-footer {
            position: absolute; bottom: 0; left: 0; right: 0;
            padding: 1rem; border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
        }

        .role-badge {
            font-size: 0.65rem; padding: 0.25rem 0.5rem;
            border-radius: 9999px; font-weight: 600;
            margin-top: 0.25rem; display: inline-block;
        }
        .role-super-admin { background: rgba(168,85,247,0.2); color: #c084fc; }
        .role-admin { background: rgba(59,130,246,0.2); color: #93c5fd; }
        .role-editor { background: rgba(34,197,94,0.2); color: #86efac; }

        /* ========== MOBILE TOP BAR ========== */
        .mobile-topbar {
            position: fixed; top: 0; left: 0; right: 0;
            height: var(--topbar-height); background: white;
            border-bottom: 1px solid #e5e7eb;
            display: none; align-items: center;
            justify-content: space-between; padding: 0 1rem; z-index: 999;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: var(--sidebar-width); min-height: 100vh;
            background: #f8fafc;
            transition: margin-left 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .content-wrapper { padding: 2rem; max-width: 1400px; }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .mobile-topbar { display: flex; }
            .main-content { margin-left: 0; padding-top: var(--topbar-height); }
            .content-wrapper { padding: 1rem; }
        }

        /* ========== MOBILE OVERLAY ========== */
        .mobile-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
            z-index: 999; opacity: 0; visibility: hidden;
            transition: all 0.3s ease;
        }
        .mobile-overlay.active { opacity: 1; visibility: visible; }

        /* ========== COMMON COMPONENTS ========== */
        .page-header { margin-bottom: 2rem; }
        .page-title { font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem; }
        .page-subtitle { color: #6b7280; }

        .action-btn {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-dark) 100%);
            color: white; padding: 0.75rem 1.5rem; border-radius: 12px;
            font-weight: 600; transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(249,115,22,0.3);
            text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(249,115,22,0.4); }

        .card {
            background: white; border-radius: 16px; padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .animate-slide-in { animation: slideInRight 0.6s ease forwards; }

        /* ═══════════════════════════════════════════
           ENHANCED ALERT STYLES
        ═══════════════════════════════════════════ */
        .flash-alert {
            position: relative; overflow: hidden;
            border-radius: 14px; padding: 0 1.5rem;
            margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 14px;
            min-height: 60px;
            animation: alertIn .45s cubic-bezier(.16,1,.3,1) both;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
        }
        @keyframes alertIn {
            from { opacity: 0; transform: translateY(-14px) scale(.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1); }
        }

        /* Animated left bar */
        .flash-alert::before {
            content: ''; position: absolute; left: 0; top: 0;
            width: 4px; height: 100%; border-radius: 14px 0 0 14px;
        }
        /* Shimmer sweep */
        .flash-alert::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.25) 50%, transparent 100%);
            transform: translateX(-100%);
            animation: shimmer .7s .45s ease forwards;
        }
        @keyframes shimmer { to { transform: translateX(100%); } }

        /* Progress bar */
        .flash-progress {
            position: absolute; bottom: 0; left: 0;
            height: 3px; border-radius: 0 0 14px 14px;
            animation: shrink 5s linear forwards;
            transform-origin: left;
        }
        @keyframes shrink { from { width: 100%; } to { width: 0%; } }

        /* Success */
        .flash-success {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1.5px solid #86efac;
            color: #166534;
        }
        .flash-success::before { background: #22c55e; }
        .flash-success .flash-progress { background: linear-gradient(90deg, #22c55e, #16a34a); }
        .flash-success .flash-icon-wrap {
            width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
            background: rgba(34,197,94,.15); display: flex; align-items: center; justify-content: center;
            animation: iconPop .5s .3s cubic-bezier(.34,1.56,.64,1) both;
        }
        .flash-success .flash-icon-wrap i { color: #16a34a; font-size: 18px; }

        /* Error */
        .flash-error {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1.5px solid #fca5a5;
            color: #991b1b;
            animation: alertIn .45s cubic-bezier(.16,1,.3,1) both, shakeX .5s .45s ease;
        }
        .flash-error::before { background: #ef4444; }
        .flash-error .flash-progress { background: linear-gradient(90deg, #ef4444, #dc2626); }
        .flash-error .flash-icon-wrap {
            width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
            background: rgba(239,68,68,.15); display: flex; align-items: center; justify-content: center;
            animation: iconPop .5s .3s cubic-bezier(.34,1.56,.64,1) both;
        }
        .flash-error .flash-icon-wrap i { color: #dc2626; font-size: 18px; }

        @keyframes iconPop { from { opacity: 0; transform: scale(.5) rotate(-10deg); } to { opacity: 1; transform: scale(1) rotate(0); } }
        @keyframes shakeX { 0%,100%{transform:translateX(0);} 20%,60%{transform:translateX(-6px);} 40%,80%{transform:translateX(6px);} }

        .flash-body { flex: 1; min-width: 0; }
        .flash-title { font-size: 14px; font-weight: 700; }
        .flash-msg   { font-size: 13px; opacity: .8; margin-top: 1px; }

        .flash-close {
            background: none; border: none; cursor: pointer;
            opacity: .45; font-size: 14px; padding: 4px; transition: opacity .15s;
            flex-shrink: 0; color: inherit;
        }
        .flash-close:hover { opacity: 1; }

        /* Sound preference toggle */
        #sfxToggle {
            position: fixed; bottom: 20px; right: 20px; z-index: 2000;
            width: 40px; height: 40px; border-radius: 50%;
            background: #1e293b; border: 1.5px solid rgba(255,255,255,.12);
            color: rgba(255,255,255,.55); font-size: 14px;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all .2s; box-shadow: 0 4px 16px rgba(0,0,0,.25);
        }
        #sfxToggle:hover { background: #f97316; color: #fff; border-color: #f97316; }
        #sfxToggle.off { opacity: .45; }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay" onclick="closeSidebar()"></div>

    <!-- Desktop Sidebar -->
    <aside id="sidebar" class="sidebar">
        <!-- Logo Header -->
        <div class="sidebar-logo flex items-center gap-3 px-4 py-4 relative overflow-hidden" style="min-height:88px;">
            <div class="absolute inset-0 z-0">
                <img src="{{ $siteImage ? asset($siteImage) : asset('images/image.jpg') }}" alt="" class="w-full h-full object-cover object-center">
                <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(15,23,42,.75) 0%,rgba(249,115,22,.55) 60%,rgba(234,88,12,.65) 100%);"></div>
            </div>
            <div class="particles-container absolute inset-0 pointer-events-none z-10">
                <span class="particle" style="--x:15%;--delay:0s;--size:4px;--duration:4s;"></span>
                <span class="particle" style="--x:30%;--delay:.8s;--size:3px;--duration:5s;"></span>
                <span class="particle" style="--x:50%;--delay:1.5s;--size:5px;--duration:3.5s;"></span>
                <span class="particle" style="--x:65%;--delay:.3s;--size:3px;--duration:4.5s;"></span>
                <span class="particle" style="--x:80%;--delay:1s;--size:4px;--duration:5.5s;"></span>
                <span class="particle" style="--x:90%;--delay:2s;--size:2px;--duration:4s;"></span>
                <div class="glow-orb" style="width:90px;height:90px;top:-25px;right:-15px;--orb-color:rgba(249,115,22,.4);"></div>
                <div class="glow-orb" style="width:60px;height:60px;bottom:-20px;left:35%;--orb-color:rgba(234,88,12,.3);"></div>
            </div>
            <div class="relative z-20 flex-shrink-0">
                <img src="{{ $siteLogo ? asset($siteLogo) : asset('images/logo.png') }}" alt="{{ $siteName }}" class="h-14 w-auto object-contain drop-shadow-lg">
            </div>
            <div class="relative z-20">
                <p class="text-white font-extrabold text-base leading-tight tracking-wide" style="text-shadow:0 1px 8px rgba(0,0,0,.6);">{{ $siteName }}</p>
            </div>
        </div>

        <style>
            .particle { position:absolute; left:var(--x); bottom:-6px; width:var(--size); height:var(--size); border-radius:50%; background:rgba(255,255,255,.85); animation:floatUp var(--duration) ease-in var(--delay) infinite; box-shadow:0 0 5px rgba(255,255,255,.6); }
            @keyframes floatUp { 0%{transform:translateY(0) scale(1);opacity:0;} 10%{opacity:1;} 80%{opacity:.5;} 100%{transform:translateY(-95px) scale(.3);opacity:0;} }
            .glow-orb { position:absolute; border-radius:50%; background:var(--orb-color); filter:blur(20px); animation:pulse-orb 4s ease-in-out infinite alternate; }
            @keyframes pulse-orb { 0%{transform:scale(1);opacity:.5;} 100%{transform:scale(1.4);opacity:1;} }
        </style>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            @php
                $currentAdmin = Auth::guard('admin')->user();
                $isSuperAdmin = $currentAdmin->role === 'super_admin';
                $isAdmin      = $currentAdmin->role === 'admin';
                $isEditor     = $currentAdmin->role === 'editor';
            @endphp

            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i><span class="font-medium">Dashboard</span>
            </a>

            <div class="nav-group-title">Content Management</div>

            <a href="{{ route('admin.articles.index') }}" class="nav-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i><span class="font-medium">Articles</span>
                @php $draftCount = \App\Models\Article::where('status','draft')->count(); @endphp
                @if($draftCount > 0)<span class="ml-auto bg-orange-500 text-white text-xs px-2 py-1 rounded-full">{{ $draftCount }}</span>@endif
            </a>
            <a href="{{ route('admin.tags.index') }}" class="nav-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i><span class="font-medium">Tags</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-folder"></i><span class="font-medium">Categories</span>
            </a>
            <a href="{{ route('admin.media.index') }}" class="nav-item {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <i class="fas fa-images"></i><span class="font-medium">Media Library</span>
            </a>
            <a href="{{ route('admin.children.index') }}" class="nav-item {{ request()->routeIs('admin.children.*') ? 'active' : '' }}">
                <i class="fas fa-child"></i><span class="font-medium">Children</span>
            </a>
            <a href="{{ route('admin.families.index') }}" class="nav-item {{ request()->routeIs('admin.families.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i><span class="font-medium">Families</span>
            </a>
            <a href="{{ route('admin.family-members.index') }}" class="nav-item {{ request()->routeIs('admin.family-members.*') ? 'active' : '' }}">
                <i class="fas fa-user-friends"></i><span class="font-medium">Family Members</span>
            </a>
            <a href="{{ route('admin.sponsors.index') }}" class="nav-item {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-heart"></i><span class="font-medium">Sponsors</span>
            </a>

            @if($isSuperAdmin || $isAdmin)
                <div class="nav-group-title">User Management</div>
                @if($isSuperAdmin)
                    <a href="{{ route('admin.admins.index') }}" class="nav-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i><span class="font-medium">Admins</span>
                        @php $adminCount = \App\Models\Admin::count(); @endphp
                        <span class="ml-auto text-xs text-gray-400">{{ $adminCount }}</span>
                    </a>
                @endif

                <div class="nav-group-title">Reports & Analytics</div>
                <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i><span class="font-medium">Reports</span>
                </a>
                <a href="{{ route('admin.analytics.index') }}" class="nav-item {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i><span class="font-medium">Analytics</span>
                </a>
            @endif

            @if($isSuperAdmin)
                <div class="nav-group-title">System</div>
                <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i><span class="font-medium">Settings</span>
                </a>
            @endif

            <div class="nav-group-title">Account</div>
            <a href="{{ route('admin.admins.edit', $currentAdmin) }}" class="nav-item {{ request()->routeIs('admin.admins.edit') && request()->route('admin')->id == $currentAdmin->id ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i><span class="font-medium">My Profile</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($currentAdmin->name) }}&background=f97316&color=fff"
                         alt="{{ $currentAdmin->name }}" class="w-10 h-10 rounded-full">
                    @if($currentAdmin->is_active)
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-gray-800 rounded-full"></span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-semibold truncate">{{ $currentAdmin->name }}</p>
                    <div class="flex items-center gap-2">
                        @if($isSuperAdmin)
                            <span class="role-badge role-super-admin"><i class="fas fa-crown text-xs"></i> Super Admin</span>
                        @elseif($isAdmin)
                            <span class="role-badge role-admin"><i class="fas fa-user-shield text-xs"></i> Admin</span>
                        @else
                            <span class="role-badge role-editor"><i class="fas fa-user-edit text-xs"></i> Editor</span>
                        @endif
                    </div>
                </div>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">@csrf</form>
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
            <img src="{{ $siteLogo ? asset($siteLogo) : asset('images/logo.png') }}" alt="{{ $siteName }}" class="w-8 h-8 object-contain rounded-lg">
        </div>
        <button class="text-gray-700 hover:text-orange-500 transition">
            <i class="fas fa-bell text-xl"></i>
        </button>
    </div>

    <!-- Main Content -->
    <main id="main-content" class="main-content">
        <div class="content-wrapper">

            {{-- ═══ SUCCESS FLASH ═══ --}}
            @if(session('success'))
            <div class="flash-alert flash-success" id="flashSuccess" role="alert">
                <div class="flash-icon-wrap">
                    <i class="fas fa-circle-check"></i>
                </div>
                <div class="flash-body">
                    <div class="flash-title">Success</div>
                    <div class="flash-msg">{{ session('success') }}</div>
                </div>
                <button class="flash-close" onclick="dismissAlert('flashSuccess')" title="Dismiss">
                    <i class="fas fa-xmark"></i>
                </button>
                <div class="flash-progress"></div>
            </div>
            @endif

            {{-- ═══ ERROR FLASH ═══ --}}
            @if(session('error'))
            <div class="flash-alert flash-error" id="flashError" role="alert">
                <div class="flash-icon-wrap">
                    <i class="fas fa-circle-exclamation"></i>
                </div>
                <div class="flash-body">
                    <div class="flash-title">Error</div>
                    <div class="flash-msg">{{ session('error') }}</div>
                </div>
                <button class="flash-close" onclick="dismissAlert('flashError')" title="Dismiss">
                    <i class="fas fa-xmark"></i>
                </button>
                <div class="flash-progress"></div>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- ── Sound effects toggle (bottom-right) ── --}}
    <button id="sfxToggle" title="Toggle alert sounds" onclick="toggleSfx()">
        <i class="fas fa-bell" id="sfxIcon"></i>
    </button>

    <script>
    /* ═══════════════════════════════════════════════════════════
       WEB AUDIO — synthesized sounds, zero external files
    ═══════════════════════════════════════════════════════════ */
    let _ctx  = null;
    let sfxOn = localStorage.getItem('adminSfx') !== 'off';

    function _getCtx() {
        if (!_ctx) _ctx = new (window.AudioContext || window.webkitAudioContext)();
        if (_ctx.state === 'suspended') _ctx.resume();
        return _ctx;
    }

    function toggleSfx() {
        sfxOn = !sfxOn;
        localStorage.setItem('adminSfx', sfxOn ? 'on' : 'off');
        document.getElementById('sfxToggle').classList.toggle('off', !sfxOn);
        document.getElementById('sfxIcon').className = sfxOn ? 'fas fa-bell' : 'fas fa-bell-slash';
        if (sfxOn) { _getCtx(); _playClick(); }
        // Cancel any speech if toggling off
        if (!sfxOn && window.speechSynthesis) window.speechSynthesis.cancel();
    }

    /* ── Tiny UI click ── */
    function _playClick() {
        if (!sfxOn) return;
        const c = _getCtx();
        const o = c.createOscillator(), g = c.createGain();
        o.connect(g); g.connect(c.destination);
        o.type = 'sine'; o.frequency.value = 800;
        g.gain.setValueAtTime(.04, c.currentTime);
        g.gain.exponentialRampToValueAtTime(.0001, c.currentTime + .07);
        o.start(); o.stop(c.currentTime + .08);
    }

    /* ── SUCCESS — bright rising triple chime ── */
    function playSoundSuccess() {
        if (!sfxOn) return;
        const c = _getCtx();
        // Soft noise whoosh
        const buf = c.createBuffer(1, c.sampleRate * .25, c.sampleRate);
        const d   = buf.getChannelData(0);
        for (let i = 0; i < d.length; i++) d[i] = (Math.random()*2-1) * (1 - i/d.length);
        const src = c.createBufferSource(); src.buffer = buf;
        const flt = c.createBiquadFilter(); flt.type = 'highpass'; flt.frequency.value = 1800;
        const wg  = c.createGain(); wg.gain.setValueAtTime(.06, c.currentTime);
        wg.gain.exponentialRampToValueAtTime(.0001, c.currentTime + .22);
        src.connect(flt); flt.connect(wg); wg.connect(c.destination);
        src.start(); src.stop(c.currentTime + .25);

        // Triple bell (C5 → E5 → G5)
        [[0, 523],[.12, 659],[.25, 784]].forEach(([delay, freq]) => {
            const o = c.createOscillator(), g = c.createGain();
            o.connect(g); g.connect(c.destination);
            o.type = 'sine'; o.frequency.value = freq;
            g.gain.setValueAtTime(.0001, c.currentTime + delay);
            g.gain.linearRampToValueAtTime(.11, c.currentTime + delay + .02);
            g.gain.exponentialRampToValueAtTime(.0001, c.currentTime + delay + .55);
            o.start(c.currentTime + delay);
            o.stop(c.currentTime + delay + .6);

            // Harmonic overtone
            const o2 = c.createOscillator(), g2 = c.createGain();
            o2.connect(g2); g2.connect(c.destination);
            o2.type = 'sine'; o2.frequency.value = freq * 2;
            g2.gain.setValueAtTime(.0001, c.currentTime + delay);
            g2.gain.linearRampToValueAtTime(.035, c.currentTime + delay + .02);
            g2.gain.exponentialRampToValueAtTime(.0001, c.currentTime + delay + .3);
            o2.start(c.currentTime + delay);
            o2.stop(c.currentTime + delay + .35);
        });
    }

    /* ── ERROR — low thud + double buzz ── */
    function playSoundError() {
        if (!sfxOn) return;
        const c = _getCtx();

        // Deep thud (sub bass drop)
        const o1 = c.createOscillator(), g1 = c.createGain();
        o1.connect(g1); g1.connect(c.destination);
        o1.type = 'sine';
        o1.frequency.setValueAtTime(180, c.currentTime);
        o1.frequency.exponentialRampToValueAtTime(55, c.currentTime + .22);
        g1.gain.setValueAtTime(.18, c.currentTime);
        g1.gain.exponentialRampToValueAtTime(.0001, c.currentTime + .28);
        o1.start(); o1.stop(c.currentTime + .3);

        // Noise crackle
        const buf = c.createBuffer(1, c.sampleRate * .15, c.sampleRate);
        const d   = buf.getChannelData(0);
        for (let i = 0; i < d.length; i++) d[i] = (Math.random()*2-1) * (1 - i/d.length);
        const src = c.createBufferSource(); src.buffer = buf;
        const flt = c.createBiquadFilter(); flt.type = 'lowpass'; flt.frequency.value = 400;
        const ng  = c.createGain(); ng.gain.setValueAtTime(.12, c.currentTime);
        ng.gain.exponentialRampToValueAtTime(.0001, c.currentTime + .14);
        src.connect(flt); flt.connect(ng); ng.connect(c.destination);
        src.start(); src.stop(c.currentTime + .16);

        // Double click stutter
        [.08, .16].forEach(delay => {
            const o = c.createOscillator(), g = c.createGain();
            o.connect(g); g.connect(c.destination);
            o.type = 'sawtooth'; o.frequency.value = 160;
            g.gain.setValueAtTime(.07, c.currentTime + delay);
            g.gain.exponentialRampToValueAtTime(.0001, c.currentTime + delay + .06);
            o.start(c.currentTime + delay);
            o.stop(c.currentTime + delay + .07);
        });
    }

    /* ═══════════════════════════════════════════════════════════
       AI VOICE — Web Speech API speaks "Success!" on success alert
       Uses the best available neural voice (Google/Microsoft/Siri)
    ═══════════════════════════════════════════════════════════ */
    function speakSuccess() {
        if (!sfxOn) return;
        if (!window.speechSynthesis) return;

        // Cancel any ongoing speech
        window.speechSynthesis.cancel();

        const utter        = new SpeechSynthesisUtterance('Success!');
        utter.rate         = 0.92;   // slightly slower = more natural/confident
        utter.pitch        = 1.15;   // slightly upbeat tone
        utter.volume       = 0.9;

        const doSpeak = () => {
            const voices = window.speechSynthesis.getVoices();

            // Priority: Google Neural > Microsoft Neural > Apple > any English
            const preferred =
                voices.find(v => /Google US English/i.test(v.name))          ||
                voices.find(v => /Google UK English Female/i.test(v.name))   ||
                voices.find(v => /Microsoft.*Natural/i.test(v.name) && /en/i.test(v.lang)) ||
                voices.find(v => /Microsoft Aria|Microsoft Jenny|Microsoft Guy/i.test(v.name)) ||
                voices.find(v => /Samantha|Karen|Daniel|Moira/i.test(v.name)) ||
                voices.find(v => /en[-_]US/i.test(v.lang))                   ||
                voices.find(v => /en/i.test(v.lang));

            if (preferred) utter.voice = preferred;

            // Delay slightly so it plays AFTER the chime finishes (chime is ~0.85s)
            setTimeout(() => window.speechSynthesis.speak(utter), 900);
        };

        // Voices load asynchronously on first page load — handle both cases
        if (window.speechSynthesis.getVoices().length === 0) {
            window.speechSynthesis.addEventListener('voiceschanged', doSpeak, { once: true });
        } else {
            doSpeak();
        }
    }

    /* ═══════════════════════════════════════════════════════════
       ALERT DISMISS
    ═══════════════════════════════════════════════════════════ */
    function dismissAlert(id) {
        const el = document.getElementById(id);
        if (!el) return;
        _playClick();
        // Stop any ongoing speech when manually dismissed
        if (window.speechSynthesis) window.speechSynthesis.cancel();
        el.style.transition = 'opacity .3s, transform .3s';
        el.style.opacity = '0';
        el.style.transform = 'translateX(16px)';
        setTimeout(() => el.remove(), 320);
    }

    /* ═══════════════════════════════════════════════════════════
       AUTO-PLAY ON LOAD
    ═══════════════════════════════════════════════════════════ */
    window.addEventListener('DOMContentLoaded', () => {
        // Sync toggle button state
        document.getElementById('sfxToggle').classList.toggle('off', !sfxOn);
        document.getElementById('sfxIcon').className = sfxOn ? 'fas fa-bell' : 'fas fa-bell-slash';

        @if(session('success'))
        setTimeout(() => {
            playSoundSuccess();   // chime plays immediately
            speakSuccess();       // AI voice says "Success!" ~900ms after chime
            setTimeout(() => dismissAlert('flashSuccess'), 5000);
        }, 350);
        @endif

        @if(session('error'))
        setTimeout(() => {
            playSoundError();
            setTimeout(() => dismissAlert('flashError'), 6000);
        }, 350);
        @endif
    });

    /* ═══════════════════════════════════════════════════════════
       SIDEBAR & NAV
    ═══════════════════════════════════════════════════════════ */
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('mobile-overlay').classList.toggle('active');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('mobile-overlay').classList.remove('active');
    }
    function logout() {
        if (confirm('Are you sure you want to logout?')) {
            document.getElementById('logout-form').submit();
        }
    }
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', () => { if (window.innerWidth <= 1024) closeSidebar(); });
    });
    </script>

    @stack('scripts')
</body>
</html>