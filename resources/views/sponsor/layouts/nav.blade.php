{{-- resources/views/sponsor/layouts/nav.blade.php --}}

<div class="mob-bar">

    {{-- My Child --}}
    <a href="{{ route('sponsor.dashboard') }}"
       class="mob-nav-item {{ request()->routeIs('sponsor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-user-friends"></i>
        <span>My Child</span>
    </a>

    {{-- Messages — badge sits top-right of the envelope icon --}}
    <a href="{{ route('sponsor.messages.home') }}"
       class="mob-nav-item {{ request()->routeIs('sponsor.messages.home', 'sponsor.messages.*') ? 'active' : '' }}">
        <span class="mob-msg-badge-wrap">
            <i class="far fa-envelope"></i>
            {{-- badge hidden by default; JS shows it when unread count > 0 --}}
            <span class="msg-notif-badge" aria-label="unread messages"></span>
        </span>
        <span>Messages</span>
    </a>

    {{-- Sponsorship --}}
    <a href="{{ route('support.donate') }}"
       class="mob-nav-item {{ request()->routeIs('support.donate') ? 'active' : '' }}">
        <i class="fas fa-hand-holding-heart"></i>
        <span>Sponsorship</span>
    </a>

    {{-- News --}}
    <a href="{{ route('home') }}"
       class="mob-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="far fa-newspaper"></i>
        <span>News</span>
    </a>

    {{-- Logout --}}
    <form method="POST" action="{{ route('sponsor.logout') }}" style="margin:0;flex:1;display:flex">
        @csrf
        <button type="submit" class="mob-nav-item mob-nav-logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </button>
    </form>

</div>