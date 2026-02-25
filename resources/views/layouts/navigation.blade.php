{{-- Mobile Bottom Nav Bar --}}
<style>
.mobile-bottom-nav {
    display: none;
    position: fixed;
    bottom: 0; left: 0; right: 0;
    z-index: 1080;
    background: #fff;
    border-top: 1px solid #e5e7eb;
    box-shadow: 0 -4px 20px rgba(0,0,0,.10);
    height: 62px;
    padding: 0 4px;
    align-items: stretch;
    justify-content: space-around;
}

@media (max-width: 1023px) {
    .mobile-bottom-nav { display: flex; }
    /* push page content above the bar */
    body { padding-bottom: 62px; }
}

.mobile-bottom-nav .nav-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 3px;
    text-decoration: none;
    color: #6b7280;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
    padding: 6px 2px;
    border-radius: 12px;
    transition: color .18s, background .18s;
    position: relative;
}

.mobile-bottom-nav .nav-item i {
    font-size: 18px;
    line-height: 1;
    transition: transform .2s;
}

.mobile-bottom-nav .nav-item:hover {
    color: #f97316;
    background: #fff7ed;
}

.mobile-bottom-nav .nav-item:hover i {
    transform: translateY(-2px);
}

/* Active state */
.mobile-bottom-nav .nav-item.active {
    color: #f97316;
}

.mobile-bottom-nav .nav-item.active i {
    transform: translateY(-2px);
}

/* Active indicator dot */
.mobile-bottom-nav .nav-item.active::after {
    content: '';
    position: absolute;
    bottom: 5px;
    width: 4px; height: 4px;
    background: #f97316;
    border-radius: 50%;
}

/* Sponsor item — highlighted pill */
.mobile-bottom-nav .nav-item.nav-highlight {
    color: #fff;
    background: linear-gradient(135deg, #f97316, #ea580c);
    box-shadow: 0 4px 14px rgba(249,115,22,.40);
    margin: 8px 4px;
    border-radius: 14px;
    padding: 4px 6px;
}

.mobile-bottom-nav .nav-item.nav-highlight:hover {
    background: linear-gradient(135deg, #ea580c, #c2410c);
    color: #fff;
}

.mobile-bottom-nav .nav-item.nav-highlight.active::after {
    display: none;
}
</style>

<nav class="mobile-bottom-nav">
    <a href="{{ route('home') }}" class="nav-item active" id="bottom-nav-home">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('sponsor.children') }}" class="nav-item nav-highlight" id="bottom-nav-sponsor">
        <i class="fas fa-child"></i>
        <span>Sponsor</span>
    </a>
    <a href="{{ route('sponsor.contact') }}" class="nav-item" id="bottom-nav-contact">
        <i class="fas fa-heart"></i>
        <span>Services</span>
    </a>
    <a href="{{ route('learn-more') }}" class="nav-item" id="bottom-nav-story">
        <i class="fas fa-newspaper"></i>
        <span>Our Story</span>
    </a>
    <a href="#" id="menu-nav-item" class="nav-item">
        <i class="fas fa-bars"></i>
        <span>Menu</span>
    </a>
</nav>

<script>
// Auto-highlight active item based on current URL
document.addEventListener('DOMContentLoaded', () => {
    const path = window.location.pathname;
    const map = {
        'bottom-nav-home':    ['/'],
        'bottom-nav-sponsor': ['/sponsor', '/children'],
        'bottom-nav-contact': ['/contact'],
        'bottom-nav-story':   ['/learn-more', '/about'],
    };
    document.querySelectorAll('.mobile-bottom-nav .nav-item').forEach(el => el.classList.remove('active'));
    for (const [id, paths] of Object.entries(map)) {
        if (paths.some(p => p === '/' ? path === p : path.startsWith(p))) {
            document.getElementById(id)?.classList.add('active');
            break;
        }
    }

    // Wire Menu button to open the existing mobile drawer
    document.getElementById('menu-nav-item')?.addEventListener('click', e => {
        e.preventDefault();
        document.getElementById('mobile-menu')?.classList.add('active');
        document.getElementById('mobile-menu-overlay')?.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
});
</script>