{{-- resources/views/layouts/loading.blade.php --}}
{{-- Universal skeleton — desktop + mobile, fits every page of the site --}}

<style>
/* ── Shimmer keyframes ───────────────────────────────────────────── */
@keyframes skSlide {
    0%   { background-position: -900px 0; }
    100% { background-position:  900px 0; }
}

/* ── Skeleton base blocks ────────────────────────────────────────── */
.sk {                           /* light — white/grey bg */
    display: block;
    border-radius: 6px;
    background: linear-gradient(90deg, #d8dfe9 25%, #eaeff6 50%, #d8dfe9 75%);
    background-size: 1800px 100%;
    animation: skSlide 1.1s ease-in-out infinite;
    flex-shrink: 0;
}
.sk-d {                         /* dark — on dark hero/banner bg */
    display: block;
    border-radius: 6px;
    background: linear-gradient(90deg,
        rgba(255,255,255,.07) 25%,
        rgba(255,255,255,.20) 50%,
        rgba(255,255,255,.07) 75%);
    background-size: 1800px 100%;
    animation: skSlide 1.2s ease-in-out infinite;
    flex-shrink: 0;
}
.sk-o {                         /* orange band */
    display: block;
    border-radius: 6px;
    background: linear-gradient(90deg,
        rgba(255,255,255,.13) 25%,
        rgba(255,255,255,.30) 50%,
        rgba(255,255,255,.13) 75%);
    background-size: 1800px 100%;
    animation: skSlide 1.1s ease-in-out infinite;
    flex-shrink: 0;
}
.sk-w {                         /* on white bg, mid-grey */
    display: block;
    border-radius: 6px;
    background: linear-gradient(90deg, #e4e9f0 25%, #f2f5fa 50%, #e4e9f0 75%);
    background-size: 1800px 100%;
    animation: skSlide 1.15s ease-in-out infinite;
    flex-shrink: 0;
}

/* ── Loader shell ────────────────────────────────────────────────── */
#sk-loader {
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: #f4f6fa;
    overflow-y: auto;
    overflow-x: hidden;
    transition: opacity .32s ease, visibility .32s ease;
}
#sk-loader.sk-gone {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

/* ════════════════════════════════════════════════════════════════
   DESKTOP LAYOUT  (> 768 px)
════════════════════════════════════════════════════════════════ */

/* 1 — Utility bar */
.sk-util {
    height: 36px;
    background: #1b2533;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
}
.sk-util-sep { width:1px; height:14px; background:rgba(255,255,255,.16); flex-shrink:0; }

/* 2 — Header banner */
.sk-banner {
    position: relative;
    height: 165px;
    background: linear-gradient(160deg, #1e2e18 0%, #2b3e1e 55%, #192810 100%);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 48px;
}
.sk-banner::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(90deg,
        transparent 20%, rgba(255,255,255,.06) 50%, transparent 80%);
    background-size: 1800px 100%;
    animation: skSlide 1.4s ease-in-out infinite;
    pointer-events: none;
}
.sk-banner-logo {
    position: absolute; left:50%; top:50%;
    transform: translate(-50%,-50%);
    z-index: 2;
    display: flex; align-items: center; gap: 14px;
}
.sk-logo-circle { width:92px; height:92px; border-radius:50%; flex-shrink:0; }
.sk-logo-lines  { display:flex; flex-direction:column; gap:8px; }

/* 3 — Sticky nav */
.sk-nav {
    height: 58px;
    background: #fff;
    border-bottom: 1px solid #e3e9f2;
    display: flex; align-items: center; justify-content: center;
    position: relative;
    padding: 0 40px;
}
.sk-nav-links { display:flex; align-items:center; gap:40px; }
.sk-nav-link  { display:flex; align-items:center; gap:7px; }
.sk-nav-ctas  { position:absolute; right:40px; display:flex; gap:10px; align-items:center; }
.sk-btn-amber {
    width:152px; height:38px; border-radius:8px; display:block;
    background: linear-gradient(90deg, #b87a08 25%, #d9a020 50%, #b87a08 75%);
    background-size: 1800px 100%;
    animation: skSlide 1.1s ease-in-out infinite;
}
.sk-btn-green {
    width:110px; height:38px; border-radius:8px; display:block;
    background: linear-gradient(90deg, #1a6e30 25%, #27963f 50%, #1a6e30 75%);
    background-size: 1800px 100%;
    animation: skSlide 1.1s ease-in-out infinite;
}

/* 4 — Desktop hero */
.sk-hero-desk {
    position: relative;
    height: 340px;
    overflow: hidden;
    display: flex; align-items: flex-end;
    padding: 0 72px 52px;
}
.sk-hero-bg {
    position:absolute; inset:0;
    background: linear-gradient(145deg, #26201a 0%, #3a2e22 35%, #1e1a14 70%, #111 100%);
}
.sk-hero-sweep {
    position:absolute; inset:0;
    background: linear-gradient(90deg,
        transparent 15%, rgba(255,255,255,.05) 50%, transparent 85%);
    background-size:1800px 100%;
    animation: skSlide 1.35s ease-in-out infinite;
}
.sk-hero-vig {
    position:absolute; inset:0;
    background: linear-gradient(to right,
        rgba(0,0,0,.72) 0%, rgba(0,0,0,.30) 40%, transparent 68%);
}
.sk-hero-body { position:relative; z-index:3; display:flex; flex-direction:column; gap:13px; max-width:460px; }
.sk-breadcrumb { display:flex; align-items:center; gap:9px; margin-bottom:4px; }
.sk-scroll { position:absolute; bottom:20px; right:36px; z-index:3;
    display:flex; flex-direction:column; align-items:center; gap:5px; }

/* 5 — Desktop content */
.sk-content-desk {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 40px 60px;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 28px;
}
.sk-main  { display:flex; flex-direction:column; gap:22px; }
.sk-aside { display:flex; flex-direction:column; gap:18px; }
.sk-card  { background:#fff; border:1px solid #e3e9f2; border-radius:16px; padding:22px;
    display:flex; flex-direction:column; gap:14px; }
.sk-stat-row { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
.sk-stat-box { background:#fff; border:1px solid #e3e9f2; border-radius:14px; padding:20px 14px;
    display:flex; flex-direction:column; align-items:center; gap:10px; }
.sk-img-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; }
.sk-img-card { border:1px solid #e3e9f2; border-radius:12px; overflow:hidden; }
.sk-img-body { padding:14px; display:flex; flex-direction:column; gap:8px; }
.sk-list     { display:flex; flex-direction:column; gap:14px; }
.sk-list-row { display:flex; align-items:center; gap:12px; }
.sk-avatar   { width:42px; height:42px; border-radius:50%; flex-shrink:0; }
.sk-two-col  { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
.sk-para     { display:flex; flex-direction:column; gap:9px; }

/* 6 — Orange stats band */
.sk-stats-band {
    background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
    padding: 54px 40px 58px;
    display:flex; flex-direction:column; align-items:center; gap:36px;
}
.sk-stats-head { display:flex; flex-direction:column; align-items:center; gap:11px; }
.sk-stats-cols-desk { display:grid; grid-template-columns:repeat(4,1fr);
    width:100%; max-width:860px; }
.sk-stat-col { display:flex; flex-direction:column; align-items:center; gap:13px;
    padding:0 20px; border-right:1px solid rgba(255,255,255,.28); }
.sk-stat-col:last-child { border-right:none; }

/* ════════════════════════════════════════════════════════════════
   MOBILE LAYOUT  (≤ 768 px)  — matches screenshot exactly
════════════════════════════════════════════════════════════════ */

/* Mobile top bar: dark, logo left + sponsor btn + hamburger */
.sk-mob-topbar {
    height: 56px;
    background: #1e2535;
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 0 18px;
    position: sticky; top:0; z-index:10;
}
.sk-mob-logo  { display:flex; align-items:center; gap:10px; }
.sk-mob-right { display:flex; align-items:center; gap:10px; }
/* amber sponsor button */
.sk-mob-sponsor {
    height: 36px; width: 110px; border-radius:8px;
    background: linear-gradient(90deg, #b87a08 25%, #d9a020 50%, #b87a08 75%);
    background-size: 1800px 100%;
    animation: skSlide 1.1s ease-in-out infinite;
    display:block;
}
/* hamburger lines */
.sk-mob-ham { display:flex; flex-direction:column; gap:5px; padding:4px; }
.sk-mob-ham-line { width:22px; height:2px; border-radius:2px; }

/* Mobile hero: dark bg, breadcrumb, pill, title, subtitle */
.sk-mob-hero {
    position: relative;
    min-height: 300px;
    background: linear-gradient(160deg, #1e2535 0%, #252d3d 60%, #1a2030 100%);
    overflow: hidden;
    padding: 32px 20px 40px;
    display: flex; flex-direction: column; gap:16px;
}
.sk-mob-hero::after {
    content:'';
    position:absolute; inset:0;
    background: linear-gradient(90deg,
        transparent 20%, rgba(255,255,255,.04) 50%, transparent 80%);
    background-size: 1800px 100%;
    animation: skSlide 1.4s ease-in-out infinite;
    pointer-events:none;
}
.sk-mob-breadcrumb { display:flex; align-items:center; gap:8px; }
/* orange pill tag (WHO WE ARE / page label) */
.sk-mob-pill {
    height: 32px; width: 130px; border-radius:99px;
    background: linear-gradient(90deg, #b86008 25%, #d97a18 50%, #b86008 75%);
    background-size: 1800px 100%;
    animation: skSlide 1.1s ease-in-out infinite;
    display:block;
}
.sk-mob-hero-lines { display:flex; flex-direction:column; gap:12px; }

/* Mobile quote section: white bg, centred icon circle + lines */
.sk-mob-quote {
    background: #fff;
    padding: 48px 24px 52px;
    display: flex; flex-direction: column; align-items: center; gap: 28px;
}
.sk-mob-quote-icon {
    width:68px; height:68px; border-radius:50%;
    background: linear-gradient(90deg, #f0e0cc 25%, #f8edd8 50%, #f0e0cc 75%);
    background-size: 1800px 100%;
    animation: skSlide 1.2s ease-in-out infinite;
}
.sk-mob-quote-lines { display:flex; flex-direction:column; align-items:center; gap:10px; width:100%; }
/* "OUR MISSION" divider row */
.sk-mob-mission {
    display:flex; align-items:center; gap:12px; width:100%; justify-content:center; margin-top:8px;
}
.sk-mob-mission-line { flex:1; height:1px; background:#e3e9f2; max-width:60px; }

/* Mobile orange stats: 2×2 grid */
.sk-mob-stats {
    background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
    padding: 44px 20px 52px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
}
.sk-mob-stat {
    display:flex; flex-direction:column; align-items:center; gap:12px;
    padding: 24px 16px;
    border-right: 1px solid rgba(255,255,255,.25);
    border-bottom: 1px solid rgba(255,255,255,.25);
}
.sk-mob-stat:nth-child(2n) { border-right:none; }
.sk-mob-stat:nth-child(3),
.sk-mob-stat:nth-child(4)  { border-bottom:none; }

/* Mobile content cards below stats */
.sk-mob-content { padding: 24px 16px 100px; display:flex; flex-direction:column; gap:18px; }
.sk-mob-card    { background:#fff; border:1px solid #e3e9f2; border-radius:14px;
    padding:18px; display:flex; flex-direction:column; gap:12px; }
.sk-mob-list-row { display:flex; align-items:center; gap:12px; }
.sk-mob-avatar   { width:38px; height:38px; border-radius:50%; flex-shrink:0; }

/* Mobile fixed bottom tab bar */
.sk-mob-tabbar {
    position: fixed; bottom:0; left:0; right:0; z-index:20;
    height: 60px;
    background: #fff;
    border-top: 1px solid #e3e9f2;
    display: grid;
    grid-template-columns: repeat(4,1fr);
}
.sk-mob-tab {
    display:flex; flex-direction:column; align-items:center;
    justify-content:center; gap:5px;
}
/* active tab — amber background */
.sk-mob-tab.active {
    background: linear-gradient(90deg, #b87a08 25%, #d9a020 50%, #b87a08 75%);
    background-size: 1800px 100%;
    animation: skSlide 1.1s ease-in-out infinite;
}

/* ════════════════════════════════════════════════════════════════
   SHOW / HIDE RULES
════════════════════════════════════════════════════════════════ */
.sk-desktop { display:block; }
.sk-mobile  { display:none;  }

@media (max-width: 768px) {
    .sk-desktop { display:none !important; }
    .sk-mobile  { display:block !important; }
    #sk-loader  { background: #1e2535; }   /* match dark mobile bg */
    .sk-stats-band { display:none; }        /* replaced by mob stats */
}

/* Desktop responsive tweaks */
@media (max-width:960px) {
    .sk-content-desk { grid-template-columns:1fr; }
    .sk-aside { display:none; }
}
@media (max-width:768px) {
    .sk-nav-ctas { display:none; }
}
</style>

{{-- ══════════════════════════════════════════════════════════════
     LOADER
══════════════════════════════════════════════════════════════════ --}}
<div id="sk-loader" role="status" aria-label="Loading…">

    {{-- ▓▓▓▓▓▓▓▓▓▓ DESKTOP ▓▓▓▓▓▓▓▓▓▓ --}}
    <div class="sk-desktop">

        {{-- 1. Utility bar --}}
        <div class="sk-util">
            <div style="display:flex;align-items:center;gap:10px">
                <div class="sk-d" style="width:24px;height:15px;border-radius:3px"></div>
                <div class="sk-d" style="width:24px;height:11px"></div>
            </div>
            <div style="display:flex;align-items:center;gap:13px">
                <div class="sk-d" style="width:68px;height:11px"></div>
                <div class="sk-util-sep"></div>
                <div class="sk-d" style="width:12px;height:12px;border-radius:50%"></div>
                <div class="sk-d" style="width:12px;height:12px;border-radius:50%"></div>
                <div class="sk-d" style="width:12px;height:12px;border-radius:50%"></div>
                <div class="sk-d" style="width:12px;height:12px;border-radius:50%"></div>
                <div class="sk-util-sep"></div>
                <div class="sk-d" style="width:26px;height:11px"></div>
            </div>
        </div>

        {{-- 2. Header banner --}}
        <div class="sk-banner">
            <div style="flex:1"></div>
            <div class="sk-banner-logo">
                <div class="sk-d sk-logo-circle"></div>
                <div class="sk-logo-lines">
                    <div class="sk-d" style="width:54px;height:11px"></div>
                    <div class="sk-d" style="width:118px;height:22px;border-radius:5px"></div>
                    <div class="sk-d" style="width:96px;height:22px;border-radius:5px"></div>
                </div>
            </div>
            <div style="flex:1;display:flex;justify-content:flex-end;position:relative;z-index:2">
                <div class="sk-btn-green"></div>
            </div>
        </div>

        {{-- 3. Sticky nav --}}
        <div class="sk-nav">
            <div class="sk-nav-links">
                <div class="sk-nav-link">
                    <div class="sk" style="width:76px;height:13px"></div>
                    <div class="sk" style="width:9px;height:9px;border-radius:2px"></div>
                </div>
                <div class="sk-nav-link">
                    <div class="sk" style="width:84px;height:13px"></div>
                    <div class="sk" style="width:9px;height:9px;border-radius:2px"></div>
                </div>
                <div class="sk-nav-link">
                    <div class="sk" style="width:92px;height:13px"></div>
                    <div class="sk" style="width:9px;height:9px;border-radius:2px"></div>
                </div>
            </div>
            <div class="sk-nav-ctas">
                <div class="sk-btn-amber"></div>
                <div class="sk-btn-green"></div>
            </div>
        </div>

        {{-- 4. Hero --}}
        <div class="sk-hero-desk">
            <div class="sk-hero-bg"></div>
            <div class="sk-hero-sweep"></div>
            <div class="sk-hero-vig"></div>
            <div class="sk-hero-body">
                <div class="sk-breadcrumb">
                    <div class="sk-d" style="width:46px;height:10px"></div>
                    <div class="sk-d" style="width:7px;height:7px;border-radius:50%"></div>
                    <div class="sk-d" style="width:88px;height:10px"></div>
                    <div class="sk-d" style="width:7px;height:7px;border-radius:50%"></div>
                    <div class="sk-d" style="width:70px;height:10px"></div>
                </div>
                {{-- orange pill tag --}}
                <div style="display:inline-block;width:130px;height:30px;border-radius:99px;
                    background:linear-gradient(90deg,#b86008 25%,#d97a18 50%,#b86008 75%);
                    background-size:1800px 100%;animation:skSlide 1.1s ease-in-out infinite">
                </div>
                <div class="sk-d" style="width:min(380px,90%);height:46px;border-radius:9px"></div>
                <div class="sk-d" style="width:min(260px,70%);height:46px;border-radius:9px;
                    background:linear-gradient(90deg,rgba(249,115,22,.4) 25%,rgba(249,115,22,.7) 50%,rgba(249,115,22,.4) 75%)">
                </div>
                <div class="sk-d" style="width:min(320px,85%);height:14px;border-radius:5px;margin-top:4px"></div>
                <div class="sk-d" style="width:min(280px,75%);height:14px;border-radius:5px"></div>
            </div>
            <div class="sk-scroll">
                <div class="sk-d" style="width:1px;height:28px;border-radius:0"></div>
                <div class="sk-d" style="width:38px;height:10px"></div>
            </div>
        </div>

        {{-- 5. Content --}}
        <div class="sk-content-desk" style="background:#f4f6fa">
            <div class="sk-main">

                {{-- quote section --}}
                <div class="sk-card" style="align-items:center;padding:40px 32px;gap:20px">
                    <div class="sk-w" style="width:64px;height:64px;border-radius:50%;
                        background:linear-gradient(90deg,#f0e0cc 25%,#f8edd8 50%,#f0e0cc 75%);
                        background-size:1800px 100%;animation:skSlide 1.2s ease-in-out infinite">
                    </div>
                    <div style="display:flex;flex-direction:column;align-items:center;gap:10px;width:100%">
                        <div class="sk-w" style="width:90%;height:13px"></div>
                        <div class="sk-w" style="width:95%;height:13px"></div>
                        <div class="sk-w" style="width:85%;height:13px"></div>
                        <div class="sk-w" style="width:78%;height:13px"></div>
                    </div>
                    <div style="display:flex;align-items:center;gap:14px;width:100%;justify-content:center;margin-top:4px">
                        <div style="flex:1;height:1px;background:#e3e9f2;max-width:80px"></div>
                        <div class="sk-w" style="width:96px;height:12px"></div>
                        <div style="flex:1;height:1px;background:#e3e9f2;max-width:80px"></div>
                    </div>
                </div>

                {{-- stat strip --}}
                <div class="sk-stat-row">
                    <div class="sk-stat-box">
                        <div class="sk" style="width:60px;height:36px;border-radius:7px"></div>
                        <div class="sk" style="width:100px;height:12px"></div>
                    </div>
                    <div class="sk-stat-box">
                        <div class="sk" style="width:52px;height:36px;border-radius:7px"></div>
                        <div class="sk" style="width:110px;height:12px"></div>
                    </div>
                    <div class="sk-stat-box">
                        <div class="sk" style="width:44px;height:36px;border-radius:7px"></div>
                        <div class="sk" style="width:88px;height:12px"></div>
                    </div>
                </div>

                {{-- image grid --}}
                <div class="sk-card" style="padding:20px">
                    <div class="sk" style="width:140px;height:15px"></div>
                    <div class="sk-img-grid">
                        @for($i=0;$i<4;$i++)
                        <div class="sk-img-card">
                            <div class="sk" style="width:100%;height:130px;border-radius:0"></div>
                            <div class="sk-img-body">
                                <div class="sk" style="width:85%;height:13px"></div>
                                <div class="sk" style="width:60%;height:12px"></div>
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px">
                                    <div class="sk" style="width:56px;height:11px"></div>
                                    <div class="sk" style="width:44px;height:26px;border-radius:7px"></div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                {{-- text / about --}}
                <div class="sk-card">
                    <div class="sk" style="width:110px;height:15px"></div>
                    <div class="sk-two-col">
                        <div class="sk-para">
                            @for($i=0;$i<5;$i++)
                            <div class="sk" style="width:{{ [100,96,88,92,74][$i] }}%;height:12px"></div>
                            @endfor
                        </div>
                        <div class="sk-para">
                            @for($i=0;$i<5;$i++)
                            <div class="sk" style="width:{{ [100,90,94,80,68][$i] }}%;height:12px"></div>
                            @endfor
                        </div>
                    </div>
                    <div style="display:flex;gap:10px;margin-top:4px">
                        <div class="sk" style="width:108px;height:38px;border-radius:9px"></div>
                        <div class="sk" style="width:88px;height:38px;border-radius:9px"></div>
                    </div>
                </div>

                {{-- list --}}
                <div class="sk-card">
                    <div class="sk" style="width:120px;height:15px"></div>
                    <div class="sk-list">
                        @for($i=0;$i<4;$i++)
                        <div class="sk-list-row">
                            <div class="sk sk-avatar"></div>
                            <div style="flex:1;display:flex;flex-direction:column;gap:7px">
                                <div class="sk" style="width:{{ 55+($i*7%20) }}%;height:13px"></div>
                                <div class="sk" style="width:{{ 30+($i*5%18) }}%;height:11px"></div>
                            </div>
                            <div class="sk" style="width:60px;height:28px;border-radius:8px;flex-shrink:0"></div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="sk-aside">
                <div class="sk-card">
                    <div class="sk" style="width:100px;height:14px"></div>
                    <div class="sk" style="width:100%;height:116px;border-radius:10px"></div>
                    <div class="sk-para">
                        <div class="sk" style="width:100%;height:12px"></div>
                        <div class="sk" style="width:85%;height:12px"></div>
                        <div class="sk" style="width:90%;height:12px"></div>
                    </div>
                    <div class="sk-btn-amber" style="width:100%;height:42px;border-radius:10px"></div>
                </div>
                <div class="sk-card">
                    <div class="sk" style="width:114px;height:14px"></div>
                    <div style="display:flex;flex-direction:column;gap:12px">
                        @for($i=0;$i<5;$i++)
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="sk" style="width:22px;height:22px;border-radius:5px;flex-shrink:0"></div>
                            <div class="sk" style="width:{{ 55+($i*9%22) }}%;height:12px"></div>
                        </div>
                        @endfor
                    </div>
                </div>
                <div class="sk-card">
                    <div class="sk" style="width:86px;height:14px"></div>
                    <div style="display:flex;gap:10px">
                        <div class="sk" style="width:40px;height:40px;border-radius:10px"></div>
                        <div class="sk" style="width:40px;height:40px;border-radius:10px"></div>
                        <div class="sk" style="width:40px;height:40px;border-radius:10px"></div>
                        <div class="sk" style="width:40px;height:40px;border-radius:10px"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 6. Orange stats band --}}
        <div class="sk-stats-band">
            <div class="sk-stats-head">
                <div class="sk-o" style="width:268px;height:28px;border-radius:7px"></div>
                <div class="sk-o" style="width:214px;height:14px;border-radius:5px"></div>
            </div>
            <div class="sk-stats-cols-desk">
                <div class="sk-stat-col">
                    <div class="sk-o" style="width:50px;height:56px;border-radius:8px"></div>
                    <div class="sk-o" style="width:130px;height:13px"></div>
                </div>
                <div class="sk-stat-col">
                    <div class="sk-o" style="width:74px;height:56px;border-radius:8px"></div>
                    <div class="sk-o" style="width:110px;height:13px"></div>
                </div>
                <div class="sk-stat-col">
                    <div class="sk-o" style="width:44px;height:56px;border-radius:8px"></div>
                    <div class="sk-o" style="width:86px;height:13px"></div>
                </div>
                <div class="sk-stat-col">
                    <div class="sk-o" style="width:44px;height:56px;border-radius:8px"></div>
                    <div class="sk-o" style="width:140px;height:13px"></div>
                </div>
            </div>
        </div>

    </div>{{-- /sk-desktop --}}


    {{-- ▓▓▓▓▓▓▓▓▓▓ MOBILE ▓▓▓▓▓▓▓▓▓▓ --}}
    <div class="sk-mobile">

        {{-- Mobile top bar --}}
        <div class="sk-mob-topbar">
            <div class="sk-mob-logo">
                <div class="sk-d" style="width:38px;height:38px;border-radius:50%"></div>
                <div class="sk-d" style="width:90px;height:13px"></div>
            </div>
            <div class="sk-mob-right">
                <div class="sk-mob-sponsor"></div>
                <div class="sk-mob-ham">
                    <div class="sk-d sk-mob-ham-line"></div>
                    <div class="sk-d sk-mob-ham-line"></div>
                    <div class="sk-d sk-mob-ham-line"></div>
                </div>
            </div>
        </div>

        {{-- Mobile hero --}}
        <div class="sk-mob-hero">
            {{-- breadcrumb --}}
            <div class="sk-mob-breadcrumb">
                <div class="sk-d" style="width:40px;height:10px"></div>
                <div class="sk-d" style="width:7px;height:7px;border-radius:50%"></div>
                <div class="sk-d" style="width:80px;height:10px"></div>
                <div class="sk-d" style="width:7px;height:7px;border-radius:50%"></div>
                <div class="sk-d" style="width:64px;height:10px"></div>
            </div>
            {{-- orange pill --}}
            <div class="sk-mob-pill"></div>
            {{-- title lines --}}
            <div class="sk-mob-hero-lines">
                <div class="sk-d" style="width:85%;height:38px;border-radius:8px"></div>
                {{-- second line orange tint --}}
                <div style="width:75%;height:38px;border-radius:8px;
                    background:linear-gradient(90deg,rgba(249,115,22,.45) 25%,rgba(249,115,22,.75) 50%,rgba(249,115,22,.45) 75%);
                    background-size:1800px 100%;animation:skSlide 1.1s ease-in-out infinite">
                </div>
            </div>
            {{-- subtitle --}}
            <div style="display:flex;flex-direction:column;gap:9px;margin-top:4px">
                <div class="sk-d" style="width:95%;height:13px;border-radius:5px"></div>
                <div class="sk-d" style="width:85%;height:13px;border-radius:5px"></div>
                <div class="sk-d" style="width:70%;height:13px;border-radius:5px"></div>
            </div>
        </div>

        {{-- Mobile quote / mission section --}}
        <div class="sk-mob-quote">
            {{-- quote icon circle (beige/warm) --}}
            <div class="sk-mob-quote-icon"></div>
            {{-- quote text lines --}}
            <div class="sk-mob-quote-lines">
                <div class="sk-w" style="width:95%;height:13px"></div>
                <div class="sk-w" style="width:100%;height:13px"></div>
                <div class="sk-w" style="width:90%;height:13px"></div>
                <div class="sk-w" style="width:88%;height:13px"></div>
                <div class="sk-w" style="width:72%;height:13px"></div>
            </div>
            {{-- OUR MISSION divider --}}
            <div class="sk-mob-mission">
                <div class="sk-mob-mission-line"></div>
                <div class="sk-w" style="width:88px;height:11px;border-radius:4px"></div>
                <div class="sk-mob-mission-line"></div>
            </div>
        </div>

        {{-- Mobile orange stats 2×2 --}}
        <div class="sk-mob-stats">
            {{-- 95,000 Children Helped --}}
            <div class="sk-mob-stat">
                <div class="sk-o" style="width:80px;height:48px;border-radius:8px"></div>
                <div class="sk-o" style="width:110px;height:13px"></div>
            </div>
            {{-- 84% Programs --}}
            <div class="sk-mob-stat">
                <div class="sk-o" style="width:56px;height:48px;border-radius:8px"></div>
                <div class="sk-o" style="width:100px;height:13px"></div>
            </div>
            {{-- 7 Countries --}}
            <div class="sk-mob-stat" style="border-bottom:none">
                <div class="sk-o" style="width:36px;height:48px;border-radius:8px"></div>
                <div class="sk-o" style="width:80px;height:13px"></div>
            </div>
            {{-- 65+ Years --}}
            <div class="sk-mob-stat" style="border-bottom:none">
                <div class="sk-o" style="width:60px;height:48px;border-radius:8px"></div>
                <div class="sk-o" style="width:104px;height:13px"></div>
            </div>
        </div>

        {{-- Mobile content cards --}}
        <div class="sk-mob-content">
            <div class="sk-mob-card">
                <div class="sk" style="width:120px;height:14px"></div>
                <div style="display:flex;flex-direction:column;gap:9px">
                    <div class="sk" style="width:100%;height:12px"></div>
                    <div class="sk" style="width:92%;height:12px"></div>
                    <div class="sk" style="width:86%;height:12px"></div>
                    <div class="sk" style="width:78%;height:12px"></div>
                </div>
                <div class="sk" style="width:140px;height:38px;border-radius:9px;margin-top:4px"></div>
            </div>

            <div class="sk-mob-card">
                <div class="sk" style="width:100px;height:14px"></div>
                <div style="display:flex;flex-direction:column;gap:13px">
                    @for($i=0;$i<3;$i++)
                    <div class="sk-mob-list-row">
                        <div class="sk sk-mob-avatar"></div>
                        <div style="flex:1;display:flex;flex-direction:column;gap:6px">
                            <div class="sk" style="width:{{ 60+($i*8%20) }}%;height:13px"></div>
                            <div class="sk" style="width:{{ 35+($i*6%16) }}%;height:11px"></div>
                        </div>
                        <div class="sk" style="width:52px;height:26px;border-radius:7px;flex-shrink:0"></div>
                    </div>
                    @endfor
                </div>
            </div>

            <div class="sk-mob-card">
                <div class="sk" style="width:100%;height:140px;border-radius:10px"></div>
                <div class="sk" style="width:80%;height:14px"></div>
                <div class="sk" style="width:100%;height:12px"></div>
                <div class="sk" style="width:90%;height:12px"></div>
            </div>
        </div>

        {{-- Mobile fixed bottom tab bar --}}
        <div class="sk-mob-tabbar">
            {{-- HOME --}}
            <div class="sk-mob-tab">
                <div class="sk" style="width:20px;height:20px;border-radius:4px"></div>
                <div class="sk" style="width:32px;height:9px"></div>
            </div>
            {{-- SPONSOR (active — amber) --}}
            <div class="sk-mob-tab active">
                <div class="sk-d" style="width:20px;height:20px;border-radius:4px"></div>
                <div class="sk-d" style="width:52px;height:9px"></div>
            </div>
            {{-- SERVICES --}}
            <div class="sk-mob-tab">
                <div class="sk" style="width:20px;height:20px;border-radius:4px"></div>
                <div class="sk" style="width:44px;height:9px"></div>
            </div>
            {{-- MENU --}}
            <div class="sk-mob-tab">
                <div class="sk" style="width:20px;height:20px;border-radius:4px"></div>
                <div class="sk" style="width:34px;height:9px"></div>
            </div>
        </div>

    </div>{{-- /sk-mobile --}}

</div>{{-- /sk-loader --}}

<script>
(function () {
    var done = false;
    function hide() {
        if (done) return;
        done = true;
        var el = document.getElementById('sk-loader');
        if (!el) return;
        requestAnimationFrame(function () {
            el.classList.add('sk-gone');
            setTimeout(function () {
                if (el && el.parentNode) el.parentNode.removeChild(el);
            }, 360);
        });
    }
    if (document.readyState !== 'loading') { hide(); }
    else {
        document.addEventListener('DOMContentLoaded', hide);
        window.addEventListener('load', hide);
    }
    setTimeout(hide, 3500);
})();
</script>