{{-- resources/views/layouts/navigation.blade.php --}}
{{-- (or paste directly at the bottom of header.blade.php before </body>) --}}

<style>
/* ══════════════════════════════════════════════
   MOBILE BOTTOM NAV BAR
══════════════════════════════════════════════ */
.mobile-bottom-nav {
    display: none;
    position: fixed;
    bottom: 0; left: 0; right: 0;
    z-index: 1080;
    background: #fff;
    border-top: 1px solid #e5e7eb;
    box-shadow: 0 -4px 20px rgba(0,0,0,.10);
    height: 64px;
    padding: 0 2px;
    align-items: stretch;
    justify-content: space-around;
}
@media (max-width: 1023px) {
    .mobile-bottom-nav { display: flex; }
    body { padding-bottom: 64px; }
}

/* ── Base nav item ── */
.mobile-bottom-nav .nav-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 3px;
    text-decoration: none;
    color: #6b7280;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
    padding: 5px 2px;
    border-radius: 12px;
    transition: color .18s, background .18s;
    position: relative;
    border: none; background: none; cursor: pointer;
    font-family: inherit;
    -webkit-tap-highlight-color: transparent;
}
.mobile-bottom-nav .nav-item i {
    font-size: 18px;
    line-height: 1;
    transition: transform .2s;
}
.mobile-bottom-nav .nav-item:hover { color: #f97316; background: #fff7ed; }
.mobile-bottom-nav .nav-item:hover i { transform: translateY(-2px); }

/* Active state */
.mobile-bottom-nav .nav-item.active { color: #f97316; }
.mobile-bottom-nav .nav-item.active i { transform: translateY(-2px); }
.mobile-bottom-nav .nav-item.active::after {
    content: '';
    position: absolute;
    bottom: 4px;
    width: 4px; height: 4px;
    background: #f97316;
    border-radius: 50%;
}

/* ── Sponsor pill (orange gradient) ── */
.mobile-bottom-nav .nav-item.nav-highlight {
    color: #fff;
    background: linear-gradient(135deg, #f97316, #ea580c);
    box-shadow: 0 4px 14px rgba(249,115,22,.40);
    margin: 8px 3px;
    border-radius: 14px;
    padding: 4px 5px;
    flex: 1.2;
}
.mobile-bottom-nav .nav-item.nav-highlight:hover {
    background: linear-gradient(135deg, #ea580c, #c2410c);
    color: #fff;
}
.mobile-bottom-nav .nav-item.nav-highlight.active::after { display: none; }

/* ── Map pill (dark green) ── */
.mobile-bottom-nav .nav-item.nav-map {
    color: #fff;
    background: linear-gradient(135deg, #1a6b4a, #145a3d);
    box-shadow: 0 4px 14px rgba(26,107,74,.38);
    margin: 8px 3px;
    border-radius: 14px;
    padding: 4px 5px;
    flex: 1.2;
}
.mobile-bottom-nav .nav-item.nav-map:hover {
    background: linear-gradient(135deg, #145a3d, #0f4630);
    color: #fff;
}
.mobile-bottom-nav .nav-item.nav-map.active::after { display: none; }
</style>

<nav class="mobile-bottom-nav" id="mobile-bottom-nav">
    {{-- Home --}}
    <a href="{{ route('home') }}" class="nav-item" id="bottom-nav-home">
        <i class="fas fa-home"></i>
        <span data-en="Home" data-fr="Accueil" data-km="ផ្ទះ">Home</span>
    </a>


     {{-- Map — green pill, opens modal --}}
 <button class="nav-item" id="bottom-nav-map" onclick="openMapModal()">
    <i class="fas fa-map-marked-alt"></i>
    <span data-en="Map" data-fr="Carte" data-km="ផែនទី">Carte</span>
</button>

    {{-- Sponsor — orange pill --}}
    <a href="{{ route('sponsor.children') }}" class="nav-item nav-highlight" id="bottom-nav-sponsor">
        <i class="fas fa-child"></i>
        <span data-en="Sponsor" data-fr="Parrainer" data-km="ឧបត្ថម្ភ">Sponsor</span>
    </a>

   
    {{-- Services --}}
    <a href="{{ route('sponsor.contact') }}" class="nav-item" id="bottom-nav-services">
        <i class="fas fa-heart"></i>
        <span data-en="Services" data-fr="Services" data-km="សេវាកម្ម">Services</span>
    </a>

    {{-- Menu (opens the drawer) --}}
    <button class="nav-item" id="menu-nav-item">
        <i class="fas fa-bars"></i>
        <span data-en="Menu" data-fr="Menu" data-km="ម៉ឺនុយ">Menu</span>
    </button>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ── Auto-highlight active item ── */
    const path = window.location.pathname;
    const navMap = {
        'bottom-nav-home':     ['/'],
        'bottom-nav-sponsor':  ['/sponsor', '/children'],
        'bottom-nav-services': ['/contact', '/service'],
    };
    document.querySelectorAll('.mobile-bottom-nav .nav-item').forEach(el => el.classList.remove('active'));
    for (const [id, paths] of Object.entries(navMap)) {
        if (paths.some(p => p === '/' ? path === p : path.startsWith(p))) {
            document.getElementById(id)?.classList.add('active');
            break;
        }
    }

    /* ── Menu button → open mobile drawer ── */
    document.getElementById('menu-nav-item')?.addEventListener('click', e => {
        e.preventDefault();
        document.getElementById('mobile-menu')?.classList.add('active');
        document.getElementById('mobile-menu-overlay')?.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    /* ── Map button → open map modal ── */
    /* openMapModal() is defined in header.blade.php — already wired via onclick */

    /* ── Sync language labels with the header switcher ── */
    /* The header's updateLangUI() translates [data-xx] elements globally,
       so nav item labels translate automatically when language is changed.  */

});
</script>