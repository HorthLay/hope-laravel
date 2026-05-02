<div class="mob-bar">
    <a href="{{ route('sponsor.dashboard') }}"
       class="mob-nav-item {{ request()->routeIs('sponsor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-user-friends"></i><span>My Child</span>
    </a>
    <a href="{{ route('sponsor.messages.home') }}"
       class="mob-nav-item {{ request()->routeIs('sponsor.messages.home', 'sponsor.messages.*') ? 'active' : '' }}">
        <i class="far fa-envelope"></i><span>Messages</span>
    </a>
    <a href="{{ route('support.donate') }}"
       class="mob-nav-item {{ request()->routeIs('support.donate') ? 'active' : '' }}">
        <i class="fas fa-hand-holding-heart"></i><span>Sponsorship</span>
    </a>
    <a href="{{ route('home') }}"
       class="mob-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="far fa-newspaper"></i><span>News</span>
    </a>
    <form method="POST" action="{{ route('sponsor.logout') }}" style="margin:0;flex:1;display:flex">
        @csrf
        <button type="submit" class="mob-nav-item mob-nav-logout">
            <i class="fas fa-sign-out-alt"></i><span>Logout</span>
        </button>
    </form>
</div>