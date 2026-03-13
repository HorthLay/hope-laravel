{{-- resources/views/sponsor/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard | {{ $sponsor->full_name }}</title>
    <meta name="description" content="@yield('meta_description', $settings['meta_description'] ?? '')">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f4f3ef; margin: 0; overflow-x: hidden; }
        body { top: 0 !important; }
        .goog-te-banner-frame,.goog-te-balloon-frame,#goog-gt-tt,.goog-te-spinner-pos,.skiptranslate { display:none !important; }
        iframe.goog-te-banner-frame { display:none !important; }

        /* ══════════════════════════════════════
           KEYFRAMES
        ══════════════════════════════════════ */
        @keyframes fadeUp       { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:none} }
        @keyframes fadeIn       { from{opacity:0} to{opacity:1} }
        @keyframes slideInLeft  { from{opacity:0;transform:translateX(-28px)} to{opacity:1;transform:none} }
        @keyframes slideInRight { from{opacity:0;transform:translateX(28px)} to{opacity:1;transform:none} }
        @keyframes scaleIn      { from{opacity:0;transform:scale(.92)} to{opacity:1;transform:scale(1)} }
        @keyframes shimmer      { 0%{background-position:-400px 0} 100%{background-position:400px 0} }
        @keyframes heroFloat    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        @keyframes heroPulse    { 0%,100%{transform:scale(1);opacity:.28} 50%{transform:scale(1.15);opacity:.4} }
        @keyframes pulse-dot    { 0%,100%{opacity:1} 50%{opacity:.4} }
        @keyframes ripple       { 0%{transform:scale(0);opacity:.4} 100%{transform:scale(3);opacity:0} }
        @keyframes bounceIn     { 0%{opacity:0;transform:scale(.5)} 60%{transform:scale(1.08)} 80%{transform:scale(.96)} 100%{opacity:1;transform:scale(1)} }
        @keyframes slideDown    { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:none} }
        @keyframes cardEntrance { from{opacity:0;transform:translateY(20px) scale(.97)} to{opacity:1;transform:none} }

        /* ══════════════════════════════════════
           SCROLL-REVEAL
        ══════════════════════════════════════ */
        .reveal { opacity:0; transform:translateY(28px); transition:opacity .55s ease,transform .55s ease; }
        .reveal.visible { opacity:1; transform:none; }
        .reveal-left { opacity:0; transform:translateX(-28px); transition:opacity .5s ease,transform .5s ease; }
        .reveal-left.visible { opacity:1; transform:none; }
        .reveal-scale { opacity:0; transform:scale(.94); transition:opacity .45s ease,transform .45s ease; }
        .reveal-scale.visible { opacity:1; transform:scale(1); }
        .stagger-1 { transition-delay:.07s; }
        .stagger-2 { transition-delay:.14s; }
        .stagger-3 { transition-delay:.21s; }
        .stagger-4 { transition-delay:.28s; }
        .stagger-5 { transition-delay:.35s; }

        /* ══════════════════════════════════════
           HEADER
        ══════════════════════════════════════ */
        .site-header {
            background:#fff; border-bottom:1px solid rgba(0,0,0,.07);
            position:sticky; top:0; z-index:100;
            box-shadow:0 2px 20px rgba(0,0,0,.06);
            animation:slideDown .4s ease both;
        }
        .header-inner {
            max-width:1200px; margin:0 auto; padding:12px 20px;
            display:flex; align-items:center; justify-content:space-between; gap:12px;
        }
        .header-logo { height:56px; width:auto; transition:opacity .2s; }
        .header-logo:hover { opacity:.8; }
        .header-right { display:flex; align-items:center; gap:10px; }

        .sponsor-chip {
            display:flex; align-items:center; gap:10px;
            background:#f8f9fa; border-radius:12px; padding:7px 12px;
            border:1px solid #e9ecef; animation:fadeIn .5s .2s both;
        }
        .sponsor-avatar {
            width:34px; height:34px; border-radius:9px;
            background:linear-gradient(135deg,#f97316,#ea580c);
            color:#fff; font-weight:900; font-size:14px;
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .sponsor-name { font-size:12px; font-weight:800; color:#0f172a; }
        .sponsor-email { font-size:10px; color:#94a3b8; }

        .logout-btn {
            display:inline-flex; align-items:center; gap:6px;
            padding:8px 14px; border-radius:10px;
            background:#f1f5f9; border:none; cursor:pointer;
            font-size:12px; font-weight:700; color:#475569;
            transition:all .2s; font-family:inherit; position:relative; overflow:hidden;
        }
        .logout-btn::after {
            content:''; position:absolute; inset:0; border-radius:10px;
            background:rgba(220,38,38,.08); transform:scale(0);
            transition:transform .3s; border-radius:50%;
        }
        .logout-btn:hover { background:#fee2e2; color:#dc2626; }

        /* Language */
        .lang-pill {
            display:inline-flex; align-items:center; gap:6px;
            padding:7px 11px; border-radius:10px; border:1px solid #e5e7eb;
            background:#fff; cursor:pointer; font-size:12px; font-weight:800;
            color:#374151; transition:all .2s; white-space:nowrap;
        }
        .lang-pill:hover { border-color:#f97316; color:#f97316; box-shadow:0 2px 8px rgba(249,115,22,.15); }
        #dash-translate-panel {
            position:absolute; top:calc(100% + 8px); right:0;
            width:196px; background:#fff; border-radius:14px;
            box-shadow:0 20px 56px rgba(0,0,0,.18); border:1px solid #f0f0f0;
            padding:10px; opacity:0; visibility:hidden; transform:translateY(-8px) scale(.97);
            transition:all .22s cubic-bezier(.34,1.56,.64,1); z-index:9999;
        }
        #dash-translate-panel.open { opacity:1; visibility:visible; transform:translateY(0) scale(1); }
        .lang-opt {
            display:flex; align-items:center; gap:9px; width:100%;
            padding:9px 10px; border-radius:9px; border:2px solid transparent;
            background:transparent; cursor:pointer; transition:all .15s;
            text-align:left; font-size:12px; font-weight:600; color:#374151; font-family:inherit;
        }
        .lang-opt:hover { background:#fff7ed; border-color:#fed7aa; }
        .lang-opt.active { background:linear-gradient(135deg,#fff7ed,#ffedd5); border-color:#f97316; color:#c2410c; }
        .lang-opt .flag { width:22px; height:15px; object-fit:cover; border-radius:3px; box-shadow:0 1px 4px rgba(0,0,0,.15); flex-shrink:0; }
        .lang-opt .chk { margin-left:auto; color:#f97316; font-size:10px; }

        /* ══════════════════════════════════════
           PAGE WRAP
        ══════════════════════════════════════ */
        .page-wrap { max-width:1200px; margin:0 auto; padding:28px 20px 80px; }

        /* ══════════════════════════════════════
           WELCOME HERO
        ══════════════════════════════════════ */
        .welcome-hero {
            background:linear-gradient(135deg,#1e2d3d 0%,#2d4a2d 55%,#1a3828 100%);
            border-radius:24px; padding:32px 36px; margin-bottom:28px;
            position:relative; overflow:hidden;
            animation:scaleIn .55s cubic-bezier(.34,1.1,.64,1) both;
        }
        .hero-orb-1 {
            position:absolute; top:-90px; right:-90px; width:340px; height:340px; border-radius:50%;
            background:radial-gradient(circle,rgba(249,115,22,.3) 0%,transparent 65%);
            animation:heroPulse 4s ease-in-out infinite; pointer-events:none;
        }
        .hero-orb-2 {
            position:absolute; bottom:-70px; left:140px; width:220px; height:220px; border-radius:50%;
            background:radial-gradient(circle,rgba(255,255,255,.05) 0%,transparent 65%);
            animation:heroPulse 6s ease-in-out infinite 1s; pointer-events:none;
        }
        .hero-orb-3 {
            position:absolute; top:20px; left:-40px; width:160px; height:160px; border-radius:50%;
            background:radial-gradient(circle,rgba(251,146,60,.1) 0%,transparent 65%);
            pointer-events:none;
        }
        .hero-content { position:relative; z-index:1; display:flex; align-items:center; gap:22px; flex-wrap:wrap; }
        .hero-avatar {
            width:68px; height:68px; border-radius:18px;
            background:rgba(255,255,255,.15); border:2px solid rgba(255,255,255,.25);
            display:flex; align-items:center; justify-content:center;
            font-size:26px; font-weight:900; color:#fff; flex-shrink:0;
            backdrop-filter:blur(10px);
            animation:bounceIn .6s .2s both;
            box-shadow:0 8px 24px rgba(0,0,0,.2);
        }
        .hero-text { animation:slideInLeft .5s .3s both; }
        .hero-text h2 {
            font-family:'Instrument Serif',serif;
            font-size:28px; color:#fff; margin:0 0 5px; line-height:1.2;
        }
        .hero-text h2 em { color:#fb923c; font-style:italic; }
        .hero-text p { color:rgba(255,255,255,.5); font-size:13px; font-weight:500; margin:0 0 14px; }
        .hero-badges { display:flex; flex-wrap:wrap; gap:8px; animation:fadeUp .5s .5s both; }
        .hero-badge {
            display:inline-flex; align-items:center; gap:6px;
            background:rgba(255,255,255,.13); border:1px solid rgba(255,255,255,.2);
            border-radius:99px; padding:6px 14px; font-size:12px; font-weight:700;
            color:rgba(255,255,255,.9); backdrop-filter:blur(6px);
            transition:all .2s;
        }
        .hero-badge:hover { background:rgba(255,255,255,.22); transform:translateY(-1px); }

        /* ══════════════════════════════════════
           SECTION HEAD
        ══════════════════════════════════════ */
        .sec-head { margin-bottom:18px; }
        .sec-title {
            font-family:'Instrument Serif',serif; font-size:21px; color:#0f172a;
            display:flex; align-items:center; gap:10px; margin:0 0 3px;
        }
        .sec-title-icon {
            width:33px; height:33px; border-radius:10px;
            display:inline-flex; align-items:center; justify-content:center;
            font-size:14px; flex-shrink:0;
        }
        .sec-sub { font-size:12px; color:#94a3b8; font-weight:500; }

        /* ══════════════════════════════════════
           ENTITY CARDS
        ══════════════════════════════════════ */
        .entities-grid {
            display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
            gap:14px; margin-bottom:12px;
        }
        .entity-card {
            background:#fff; border-radius:20px; overflow:hidden;
            border:2.5px solid transparent; cursor:pointer;
            transition:transform .25s cubic-bezier(.34,1.2,.64,1),
                        box-shadow .25s ease, border-color .2s;
            box-shadow:0 2px 12px rgba(0,0,0,.07); position:relative;
            animation:cardEntrance .45s ease both;
        }
        .entity-card:hover {
            box-shadow:0 16px 48px rgba(0,0,0,.14);
            transform:translateY(-5px) scale(1.01);
        }
        .entity-card:active { transform:translateY(-2px) scale(.99); }
        .entity-card.active-card { border-color:#f97316; box-shadow:0 8px 36px rgba(249,115,22,.22); }
        .entity-card.active-card .card-active-bar { transform:scaleX(1); }

        .card-active-bar {
            position:absolute; top:0; left:0; right:0; height:4px;
            background:linear-gradient(to right,#f97316,#fb923c,#fbbf24);
            transform:scaleX(0); transform-origin:left;
            transition:transform .3s cubic-bezier(.34,1.2,.64,1);
        }
        .card-photo { width:100%; height:175px; object-fit:cover; object-position:top; display:block; transition:transform .4s ease; }
        .entity-card:hover .card-photo { transform:scale(1.04); }
        .card-photo-placeholder {
            width:100%; height:175px;
            display:flex; align-items:center; justify-content:center; font-size:48px;
        }
        .card-body { padding:14px 16px 10px; }
        .card-type-badge {
            display:inline-flex; align-items:center; gap:5px; font-size:10px;
            font-weight:800; letter-spacing:.06em; text-transform:uppercase;
            padding:3px 10px; border-radius:99px; margin-bottom:7px;
        }
        .card-name {
            font-size:15px; font-weight:800; color:#0f172a;
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:4px;
        }
        .card-meta {
            font-size:11px; color:#94a3b8; font-weight:600;
            display:flex; align-items:center; gap:8px; flex-wrap:wrap;
        }
        .card-meta i { font-size:9px; }
        .card-stats { display:flex; gap:6px; flex-wrap:wrap; padding:10px 14px 14px; }
        .card-stat-pill {
            font-size:10px; font-weight:700; padding:4px 10px; border-radius:99px;
            display:inline-flex; align-items:center; gap:4px;
            transition:transform .15s, box-shadow .15s;
        }
        .card-stat-pill:hover { transform:translateY(-1px); box-shadow:0 2px 8px rgba(0,0,0,.1); }

        /* ══════════════════════════════════════
           DETAIL PANEL
        ══════════════════════════════════════ */
        .detail-panel { display:none; }
        .detail-panel.active { display:block; animation:fadeUp .35s ease both; }

        /* ── Year bar ── */
        .year-bar {
            display:flex; align-items:center; gap:8px;
            margin-bottom:22px; overflow-x:auto; -webkit-overflow-scrolling:touch;
            scrollbar-width:none; padding-bottom:4px;
        }
        .year-bar::-webkit-scrollbar { display:none; }
        .year-bar-label {
            font-size:11px; font-weight:800; color:#94a3b8; text-transform:uppercase;
            letter-spacing:.06em; white-space:nowrap; flex-shrink:0;
        }
        .year-pill {
            padding:7px 16px; border-radius:99px; border:1.5px solid #e2e8f0;
            background:#fff; font-size:12px; font-weight:700; color:#64748b;
            cursor:pointer; transition:all .2s; white-space:nowrap; flex-shrink:0;
            font-family:inherit;
        }
        .year-pill:hover { border-color:#f97316; color:#f97316; }
        .year-pill.active {
            background:#f97316; border-color:#f97316; color:#fff;
            box-shadow:0 4px 14px rgba(249,115,22,.38);
            transform:scale(1.04);
        }

        .year-section { display:none; }
        .year-section.active { display:block; animation:fadeUp .22s ease both; }

        /* ── Content grid ── */
        .content-grid { display:grid; grid-template-columns:1fr 310px; gap:18px; }

        /* ── White card ── */
        .white-card {
            background:#fff; border-radius:18px; padding:22px;
            border:1px solid rgba(0,0,0,.06); box-shadow:0 2px 12px rgba(0,0,0,.05);
            transition:box-shadow .2s, transform .2s;
        }
        .white-card:hover { box-shadow:0 6px 24px rgba(0,0,0,.08); }
        .white-card + .white-card { margin-top:14px; }
        .wc-title {
            font-size:14px; font-weight:800; color:#0f172a;
            display:flex; align-items:center; gap:8px; margin-bottom:16px;
        }
        .wc-icon {
            width:27px; height:27px; border-radius:8px;
            display:inline-flex; align-items:center; justify-content:center;
            font-size:12px; flex-shrink:0;
        }
        .wc-badge { margin-left:auto; font-size:10px; font-weight:800; padding:2px 8px; border-radius:99px; }

        /* ── Updates ── */
        .update-item { padding:13px 0; border-bottom:1px solid #f1f5f9; animation:fadeUp .3s ease both; }
        .update-item:first-child { padding-top:0; }
        .update-item:last-child { border-bottom:none; padding-bottom:0; }
        .update-head { display:flex; align-items:flex-start; justify-content:space-between; gap:8px; margin-bottom:5px; }
        .update-title { font-size:13px; font-weight:800; color:#0f172a; }
        .update-date  { font-size:11px; color:#94a3b8; font-weight:600; flex-shrink:0; }
        .update-body  { font-size:13px; color:#475569; line-height:1.65; }
        .update-type-badge {
            display:inline-flex; align-items:center; font-size:10px; font-weight:800;
            padding:2px 8px; border-radius:99px; margin-right:5px; text-transform:capitalize;
        }
        .badge-health    { background:#dcfce7;color:#166534; }
        .badge-education { background:#dbeafe;color:#1e40af; }
        .badge-study     { background:#e0e7ff;color:#3730a3; }
        .badge-financial { background:#fef9c3;color:#854d0e; }
        .badge-general   { background:#f1f5f9;color:#475569; }
        .badge-visit     { background:#fce7f3;color:#9d174d; }

        /* ── Media grid ── */
        .media-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:9px; }
        .media-thumb {
            position:relative; aspect-ratio:1; border-radius:12px;
            overflow:hidden; cursor:pointer; background:#f8f9fa;
            transition:transform .25s ease, box-shadow .25s ease;
        }
        .media-thumb:hover { transform:scale(1.03); box-shadow:0 8px 24px rgba(0,0,0,.15); }
        .media-thumb img,.media-thumb video {
            width:100%; height:100%; object-fit:cover; transition:transform .4s ease; pointer-events:none;
        }
        .media-thumb:hover img,.media-thumb:hover video { transform:scale(1.08); }
        .media-overlay {
            position:absolute; inset:0; background:rgba(0,0,0,.28);
            display:flex; align-items:center; justify-content:center;
            opacity:0; transition:opacity .2s;
        }
        .media-thumb:hover .media-overlay { opacity:1; }
        .media-play-btn {
            width:40px; height:40px; background:rgba(255,255,255,.92);
            border-radius:50%; display:flex; align-items:center; justify-content:center;
            box-shadow:0 4px 16px rgba(0,0,0,.25);
            transition:transform .2s; animation:scaleIn .2s ease both;
        }
        .media-play-btn i { color:#f97316; font-size:14px; }
        .media-thumb:hover .media-play-btn { transform:scale(1.1); }
        .media-video-tag {
            position:absolute; top:7px; left:7px; background:rgba(0,0,0,.7);
            color:#fff; font-size:9px; font-weight:800; padding:2px 7px; border-radius:5px;
            display:flex; align-items:center; gap:3px; z-index:2;
        }
        .media-caption {
            position:absolute; bottom:0; left:0; right:0;
            background:linear-gradient(transparent,rgba(0,0,0,.65));
            color:#fff; font-size:9px; padding:14px 8px 6px;
            pointer-events:none; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        }

        /* ── Documents ── */
        .doc-item {
            display:flex; align-items:center; gap:11px;
            padding:11px 12px; border-radius:12px; background:#f8fafc;
            border:1px solid #f1f5f9; margin-bottom:7px;
            transition:all .2s; position:relative; overflow:hidden;
        }
        .doc-item:last-child { margin-bottom:0; }
        .doc-item:hover { background:#fff7ed; border-color:#fed7aa; transform:translateX(3px); }
        .doc-icon {
            width:36px; height:36px; border-radius:10px; background:#fee2e2;
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
            transition:transform .2s;
        }
        .doc-item:hover .doc-icon { transform:scale(1.1); }
        .doc-icon i { color:#ef4444; font-size:14px; }
        .doc-info { flex:1; min-width:0; }
        .doc-name { font-size:12px; font-weight:700; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .doc-meta { font-size:10px; color:#94a3b8; font-weight:500; margin-top:1px; }
        .doc-dl {
            width:30px; height:30px; border-radius:8px;
            background:#fff7ed; color:#f97316; display:flex; align-items:center;
            justify-content:center; text-decoration:none; transition:all .2s; flex-shrink:0;
            font-size:11px;
        }
        .doc-dl:hover { background:#f97316; color:#fff; transform:scale(1.1); }

        /* ── Family mini card ── */
        .family-mini-card {
            display:flex; align-items:center; gap:12px;
            background:#f0fdf4; border:1.5px solid #bbf7d0; border-radius:14px;
            padding:13px 15px; margin-bottom:14px; transition:all .2s;
        }
        .family-mini-card:hover { background:#dcfce7; border-color:#86efac; }
        .family-mini-photo { width:46px; height:46px; border-radius:11px; object-fit:cover; border:2px solid #86efac; flex-shrink:0; }
        .family-mini-icon { width:46px; height:46px; border-radius:11px; background:#dcfce7; display:flex; align-items:center; justify-content:center; flex-shrink:0; }

        /* ══════════════════════════════════════
           LIGHTBOX
        ══════════════════════════════════════ */
        #lightbox { display:none; }
        #lightbox.open {
            display:flex; animation:fadeIn .22s ease both;
        }
        #lb-inner { animation:scaleIn .25s cubic-bezier(.34,1.1,.64,1) both; }

        /* ══════════════════════════════════════
           FOOTER NOTE
        ══════════════════════════════════════ */
        .footer-note {
            background:#fff; border-radius:16px; padding:18px 22px;
            border-left:4px solid #f97316; margin-top:28px;
            box-shadow:0 2px 12px rgba(0,0,0,.05);
            transition:box-shadow .2s;
        }
        .footer-note:hover { box-shadow:0 6px 24px rgba(0,0,0,.09); }

        /* ── NEW badge ── */
        .new-dot::after {
            content:'NEW'; font-size:9px; font-weight:900;
            background:#ef4444; color:#fff; padding:1px 5px; border-radius:99px;
            margin-left:6px; vertical-align:middle;
            animation:pulse-dot 1.4s infinite;
        }

        /* ══════════════════════════════════════
           MOBILE NAV BOTTOM (≤640px)
        ══════════════════════════════════════ */
        .mobile-bottom-bar {
            display:none; position:fixed; bottom:0; left:0; right:0;
            background:#fff; border-top:1px solid #e5e7eb;
            padding:8px 16px 12px; z-index:90;
            box-shadow:0 -4px 20px rgba(0,0,0,.08);
        }

        /* ══════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════ */
        @media (max-width:1024px) {
            .content-grid { grid-template-columns:1fr; }
        }
        @media (max-width:768px) {
            .welcome-hero { padding:24px 20px; border-radius:18px; }
            .hero-text h2 { font-size:22px; }
            .hero-content { gap:16px; }
            .hero-avatar { width:56px; height:56px; font-size:22px; }
            .header-inner { padding:10px 14px; }
            .header-logo { height:44px; }
            .entities-grid { grid-template-columns:repeat(2,1fr); gap:10px; }
            .card-photo,.card-photo-placeholder { height:148px; }
            .card-name { font-size:13px; }
            .media-grid { grid-template-columns:repeat(2,1fr); }
            .page-wrap { padding:18px 14px 90px; }
            .sponsor-chip { display:none !important; }
            .mobile-bottom-bar { display:flex; align-items:center; justify-content:space-around; }
            .year-bar { gap:6px; }
            .white-card { padding:16px; }
            .footer-note { border-radius:12px; }
        }
        @media (max-width:480px) {
            .hero-text h2 { font-size:19px; }
            .hero-badge { font-size:11px; padding:5px 11px; }
            .entities-grid { grid-template-columns:repeat(2,1fr); gap:8px; }
            .card-photo,.card-photo-placeholder { height:130px; }
            .card-body { padding:10px 12px 8px; }
            .card-stats { padding:8px 12px 12px; gap:5px; }
            .card-stat-pill { font-size:9px; padding:3px 8px; }
            .welcome-hero { padding:20px 16px; }
            .content-grid { gap:12px; }
            .white-card { padding:14px; }
            .media-grid { gap:6px; }
            .update-head { flex-direction:column; gap:4px; }
            .update-date { align-self:flex-start; }
        }
        @media (max-width:360px) {
            .entities-grid { grid-template-columns:1fr 1fr; }
            .card-photo,.card-photo-placeholder { height:115px; }
        }

        /* touch tap feedback */
        @media (hover:none) {
            .entity-card:active { transform:scale(.97); box-shadow:0 2px 8px rgba(0,0,0,.1); }
            .media-thumb:hover { transform:none; }
            .media-thumb:active { transform:scale(.96); }
        }
    </style>
    <script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage:'en', includedLanguages:'en,km,fr',
            layout:google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay:false, multilanguagePage:true
        },'google_translate_element');
    }
    </script>
</head>
<body>

{{-- ═══════════════════════════
     HEADER
═══════════════════════════ --}}
<header class="site-header">
    <div class="header-inner">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" class="header-logo" alt="Logo">
        </a>
        <div class="header-right">

            {{-- Language --}}
            <div style="position:relative" id="dash-translate-wrapper">
                <div id="google_translate_element" style="display:none;position:absolute"></div>
                <button class="lang-pill" onclick="dashTogglePanel()" id="dash-translate-toggle">
                    <img src="https://flagcdn.com/w40/fr.png" id="dash-flag" style="width:20px;height:14px;border-radius:2px;object-fit:cover" alt="">
                    <span id="dash-lang-label">FR</span>
                    <i class="fas fa-chevron-down" style="font-size:8px;color:#94a3b8;transition:transform .2s" id="dash-caret"></i>
                </button>
                <div id="dash-translate-panel">
                    <p style="font-size:10px;font-weight:800;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;padding:4px 4px 8px;display:flex;align-items:center;gap:6px">
                        <i class="fas fa-globe" style="color:#f97316"></i> Language
                    </p>
                    <button class="lang-opt" id="dash-btn-en" onclick="dashSwitchLang('en')">
                        <img src="https://flagcdn.com/w40/us.png" class="flag" alt="">
                        <div><div style="font-weight:700">English</div><div style="font-size:10px;color:#94a3b8">Original</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-en"></i>
                    </button>
                    <button class="lang-opt" id="dash-btn-fr" onclick="dashSwitchLang('fr')">
                        <img src="https://flagcdn.com/w40/fr.png" class="flag" alt="">
                        <div><div style="font-weight:700">Français</div><div style="font-size:10px;color:#94a3b8">French</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-fr"></i>
                    </button>
                    <button class="lang-opt" id="dash-btn-km" onclick="dashSwitchLang('km')">
                        <img src="https://flagcdn.com/w40/kh.png" class="flag" alt="">
                        <div><div style="font-weight:700">ខ្មែរ</div><div style="font-size:10px;color:#94a3b8">Cambodian</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-km"></i>
                    </button>
                </div>
            </div>

            {{-- Sponsor chip (desktop only) --}}
            <div class="sponsor-chip hidden md:flex">
                <div class="sponsor-avatar">{{ strtoupper(substr($sponsor->first_name,0,1)) }}</div>
                <div>
                    <div class="sponsor-name">{{ $sponsor->full_name }}</div>
                    <div class="sponsor-email">{{ $sponsor->email }}</div>
                </div>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('sponsor.logout') }}">
                @csrf
                <button class="logout-btn">
                    <i class="fas fa-sign-out-alt" style="font-size:11px"></i>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </div>
</header>

{{-- ═══════════════════════════
     PAGE BODY
═══════════════════════════ --}}
<div class="page-wrap">

    {{-- Welcome Hero --}}
    <div class="welcome-hero">
        <div class="hero-orb-1"></div>
        <div class="hero-orb-2"></div>
        <div class="hero-orb-3"></div>
        <div class="hero-content">
            <div class="hero-avatar">{{ strtoupper(substr($sponsor->first_name,0,1)) }}</div>
            <div class="hero-text">
                <h2>Welcome back, <em>{{ $sponsor->first_name }}</em>!</h2>
                <p>Thank you for changing lives through your generous support.</p>
                <div class="hero-badges">
                    @if($families->isNotEmpty())
                    <span class="hero-badge">
                        <i class="fas fa-home" style="font-size:11px;color:#fb923c"></i>
                        {{ $families->count() }} {{ Str::plural('Family',$families->count()) }} Sponsored
                    </span>
                    @endif
                    @if($children->isNotEmpty())
                    <span class="hero-badge">
                        <i class="fas fa-child" style="font-size:11px;color:#fb923c"></i>
                        {{ $children->count() }} {{ Str::plural('Child',$children->count()) }} Sponsored
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Entity Cards --}}
    @php $totalEntities = $families->count() + $children->count(); @endphp

    @if($totalEntities > 0)
    <div class="sec-head reveal">
        <h2 class="sec-title">
            <span class="sec-title-icon" style="background:#fff7ed;color:#f97316"><i class="fas fa-heart"></i></span>
            Your Sponsored {{ $totalEntities > 1 ? 'Ones' : ($families->isNotEmpty() ? 'Family' : 'Child') }}
        </h2>
        <p class="sec-sub">{{ $totalEntities > 1 ? 'Tap a card to view their updates, photos & documents' : 'View updates, photos & documents below' }}</p>
    </div>

    <div class="entities-grid" id="entity-cards">
        @foreach($families as $fi => $family)
        @php $eidx = $fi; @endphp
        <div class="entity-card reveal stagger-{{ ($eidx % 4)+1 }} {{ ($totalEntities===1||$eidx===0)?'active-card':'' }}"
             id="card-{{ $eidx }}" onclick="selectEntity({{ $eidx }})">
            <div class="card-active-bar"></div>
            @if($family->profile_photo)
                <img src="{{ $family->profile_photo_url ?? asset($family->profile_photo) }}" class="card-photo" alt="{{ $family->name }}">
            @else
                <div class="card-photo-placeholder" style="background:linear-gradient(135deg,#fffbeb,#fef3c7)">
                    <i class="fas fa-home" style="color:#fbbf24;opacity:.4"></i>
                </div>
            @endif
            <div class="card-body">
                <div class="card-type-badge" style="background:#fff7ed;color:#c2410c">
                    <i class="fas fa-home" style="font-size:9px"></i> Family
                </div>
                <div class="card-name">{{ $family->name }}</div>
                <div class="card-meta">
                    @if($family->country)<span><i class="fas fa-map-marker-alt"></i> {{ $family->country }}</span>@endif
                    <span style="font-family:monospace;font-size:9px;background:#f1f5f9;padding:1px 6px;border-radius:4px;color:#64748b">{{ $family->code }}</span>
                </div>
            </div>
            <div class="card-stats">
                <span class="card-stat-pill" style="background:#dcfce7;color:#166534"><i class="fas fa-newspaper" style="font-size:8px"></i> {{ $family->updates->count() }} Updates</span>
                <span class="card-stat-pill" style="background:#dbeafe;color:#1e40af"><i class="fas fa-images" style="font-size:8px"></i> {{ $family->media->count() }} Media</span>
                <span class="card-stat-pill" style="background:#fef9c3;color:#854d0e"><i class="fas fa-file" style="font-size:8px"></i> {{ $family->documents->count() }}</span>
            </div>
        </div>
        @endforeach

        @foreach($children as $ci => $child)
        @php $eidx = $families->count() + $ci; @endphp
        <div class="entity-card reveal stagger-{{ ($eidx % 4)+1 }} {{ ($totalEntities===1||$eidx===0)?'active-card':'' }}"
             id="card-{{ $eidx }}" onclick="selectEntity({{ $eidx }})">
            <div class="card-active-bar"></div>
            @if($child->profile_photo)
                <img src="{{ asset($child->profile_photo) }}" class="card-photo" alt="{{ $child->first_name }}">
            @else
                <div class="card-photo-placeholder" style="background:linear-gradient(135deg,#fff7ed,#ffedd5)">
                    <i class="fas fa-child" style="color:#fb923c;opacity:.4"></i>
                </div>
            @endif
            <div class="card-body">
                <div class="card-type-badge" style="background:#eff6ff;color:#1d4ed8">
                    <i class="fas fa-child" style="font-size:9px"></i> Child
                </div>
                <div class="card-name">{{ $child->first_name }}</div>
                <div class="card-meta">
                    @if($child->country)<span><i class="fas fa-map-marker-alt"></i> {{ $child->country }}</span>@endif
                    @if($child->age ?? null)<span><i class="fas fa-birthday-cake"></i> {{ $child->age }}y</span>@endif
                    @if($child->gender)
                    <span style="color:{{ strtolower($child->gender)==='female'?'#ec4899':'#3b82f6' }}">
                        <i class="fas {{ strtolower($child->gender)==='female'?'fa-venus':'fa-mars' }}"></i>
                    </span>
                    @endif
                </div>
            </div>
            <div class="card-stats">
                <span class="card-stat-pill" style="background:#dcfce7;color:#166534"><i class="fas fa-newspaper" style="font-size:8px"></i> {{ $child->updates->count() }}</span>
                <span class="card-stat-pill" style="background:#dbeafe;color:#1e40af"><i class="fas fa-images" style="font-size:8px"></i> {{ $child->media->count() }}</span>
                <span class="card-stat-pill" style="background:#fef9c3;color:#854d0e"><i class="fas fa-file" style="font-size:8px"></i> {{ $child->documents->count() }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ═══════════════════════════════════════
         FAMILY PANELS
    ═══════════════════════════════════════ --}}
    @foreach($families as $fi => $family)
    @php
        $eidx = $fi; $panelId = "panel-{$eidx}";
        $fYears = collect();
        foreach($family->updates   as $u){ $fYears->push(\Carbon\Carbon::parse($u->report_date??$u->created_at)->year); }
        foreach($family->media     as $m){ $fYears->push($m->created_at->year); }
        foreach($family->documents as $d){ $fYears->push($d->created_at->year); }
        $fYears = $fYears->unique()->sortDesc()->values();
    @endphp
    <div class="detail-panel {{ ($totalEntities===1||$eidx===0)?'active':'' }}" id="{{ $panelId }}" style="margin-top:28px">

        @if($fYears->isNotEmpty())
        <div class="year-bar reveal">
            <span class="year-bar-label">Year:</span>
            <button class="year-pill active" data-panel="{{ $panelId }}" data-year="latest" onclick="switchYear('{{ $panelId }}','latest')">
                <i class="fas fa-star" style="font-size:9px;margin-right:4px;color:inherit"></i> Latest
            </button>
            @foreach($fYears as $yr)
            <button class="year-pill" data-panel="{{ $panelId }}" data-year="{{ $yr }}" onclick="switchYear('{{ $panelId }}','{{ $yr }}')">{{ $yr }}</button>
            @endforeach
        </div>
        @endif

        {{-- Latest --}}
        <div class="year-section active" data-panel="{{ $panelId }}" data-section="latest">
            <div class="content-grid">
                <div>
                    <div class="white-card reveal">
                        <div class="wc-title">
                            <span class="wc-icon" style="background:#f0fdf4;color:#22c55e"><i class="fas fa-newspaper"></i></span>
                            Latest Updates <span class="wc-badge new-dot" style="background:#dcfce7;color:#166534"></span>
                        </div>
                        @forelse($family->updates->sortByDesc('report_date')->take(3) as $update)
                        <div class="update-item">
                            <div class="update-head">
                                <div>
                                    @if($update->type)<span class="update-type-badge badge-{{ $update->type }}">{{ $update->type }}</span>@endif
                                    @if($update->title)<span class="update-title">{{ $update->title }}</span>@endif
                                </div>
                                <span class="update-date">{{ \Carbon\Carbon::parse($update->report_date??$update->created_at)->format('M d, Y') }}</span>
                            </div>
                            <p class="update-body">{{ $update->content }}</p>
                        </div>
                        @empty
                        <p style="text-align:center;color:#94a3b8;font-size:13px;padding:24px 0">No updates yet.</p>
                        @endforelse
                    </div>
                    <div class="white-card reveal" style="margin-top:14px">
                        <div class="wc-title">
                            <span class="wc-icon" style="background:#fff7ed;color:#f97316"><i class="fas fa-photo-film"></i></span>
                            Latest Media <span class="wc-badge new-dot" style="background:#fff7ed;color:#ea580c"></span>
                        </div>
                        @php $latestFMedia = $family->media->sortByDesc('created_at')->take(6); @endphp
                        @if($latestFMedia->isNotEmpty())
                        <div class="media-grid">
                            @foreach($latestFMedia as $m)
                            <div class="media-thumb reveal-scale stagger-{{ ($loop->index%3)+1 }}"
                                 onclick="openLightbox('{{ asset($m->file_path) }}','{{ $m->type }}','{{ addslashes($m->caption??"") }}','{{ route("sponsor.download",["type"=>"family_media","id"=>$m->id]) }}')">
                                @if($m->type==='video')
                                    <video src="{{ asset($m->file_path) }}" muted playsinline></video>
                                    <div class="media-video-tag"><i class="fas fa-play" style="font-size:7px"></i> VIDEO</div>
                                @else
                                    <img src="{{ asset($m->file_path) }}" alt="">
                                @endif
                                <div class="media-overlay"><div class="media-play-btn"><i class="fas fa-{{ $m->type==='video'?'play':'expand' }}" style="{{ $m->type==='video'?'margin-left:2px':'' }}"></i></div></div>
                                @if($m->caption)<div class="media-caption">{{ $m->caption }}</div>@endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div style="text-align:center;padding:30px 0;color:#94a3b8">
                            <i class="fas fa-images" style="font-size:32px;display:block;margin-bottom:8px;opacity:.25"></i>
                            <p style="font-size:13px;font-weight:600">No media yet.</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="white-card reveal reveal-right">
                        <div class="wc-title">
                            <span class="wc-icon" style="background:#fef9c3;color:#854d0e"><i class="fas fa-folder-open"></i></span>
                            Documents
                        </div>
                        @forelse($family->documents->sortByDesc('created_at')->take(8) as $doc)
                        <div class="doc-item">
                            <div class="doc-icon"><i class="fas fa-file-pdf"></i></div>
                            <div class="doc-info">
                                <div class="doc-name">{{ $doc->title }}</div>
                                <div class="doc-meta">@if($doc->document_date){{ \Carbon\Carbon::parse($doc->document_date)->format('M d, Y') }}@endif @if($doc->type) · {{ strtoupper($doc->type) }}@endif</div>
                            </div>
                            <a href="{{ route('sponsor.download',['type'=>'family_document','id'=>$doc->id]) }}" class="doc-dl"><i class="fas fa-download"></i></a>
                        </div>
                        @empty
                        <p style="text-align:center;color:#94a3b8;font-size:13px;padding:16px 0">No documents yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        @foreach($fYears as $yr)
        @php
            $yFUpdates = $family->updates->filter(fn($u)=>\Carbon\Carbon::parse($u->report_date??$u->created_at)->year==$yr)->sortByDesc('report_date');
            $yFMedia   = $family->media->filter(fn($m)=>$m->created_at->year==$yr)->sortByDesc('created_at');
            $yFDocs    = $family->documents->filter(fn($d)=>$d->created_at->year==$yr)->sortByDesc('created_at');
            $yFPhotos  = $yFMedia->where('type','photo');
            $yFVideos  = $yFMedia->where('type','video');
        @endphp
        <div class="year-section" data-panel="{{ $panelId }}" data-section="{{ $yr }}">
            <div class="content-grid">
                <div>
                    @if($yFUpdates->isNotEmpty())
                    <div class="white-card">
                        <div class="wc-title"><span class="wc-icon" style="background:#f0fdf4;color:#22c55e"><i class="fas fa-newspaper"></i></span> Updates · {{ $yr }} <span class="wc-badge" style="background:#dcfce7;color:#166534">{{ $yFUpdates->count() }}</span></div>
                        @foreach($yFUpdates as $update)
                        <div class="update-item">
                            <div class="update-head"><div>@if($update->type)<span class="update-type-badge badge-{{ $update->type }}">{{ $update->type }}</span>@endif @if($update->title)<span class="update-title">{{ $update->title }}</span>@endif</div><span class="update-date">{{ \Carbon\Carbon::parse($update->report_date??$update->created_at)->format('M d, Y') }}</span></div>
                            <p class="update-body">{{ $update->content }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if($yFPhotos->isNotEmpty())
                    <div class="white-card" style="margin-top:14px">
                        <div class="wc-title"><span class="wc-icon" style="background:#eff6ff;color:#3b82f6"><i class="fas fa-images"></i></span> Photos · {{ $yr }} <span class="wc-badge" style="background:#dbeafe;color:#1e40af">{{ $yFPhotos->count() }}</span></div>
                        <div class="media-grid">
                            @foreach($yFPhotos as $p)
                            <div class="media-thumb" onclick="openLightbox('{{ asset($p->file_path) }}','image','{{ addslashes($p->caption??"") }}','{{ route("sponsor.download",["type"=>"family_media","id"=>$p->id]) }}')">
                                <img src="{{ asset($p->file_path) }}" alt=""><div class="media-overlay"><div class="media-play-btn"><i class="fas fa-expand"></i></div></div>@if($p->caption)<div class="media-caption">{{ $p->caption }}</div>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($yFVideos->isNotEmpty())
                    <div class="white-card" style="margin-top:14px">
                        <div class="wc-title"><span class="wc-icon" style="background:#faf5ff;color:#9333ea"><i class="fas fa-video"></i></span> Videos · {{ $yr }} <span class="wc-badge" style="background:#e9d5ff;color:#7c3aed">{{ $yFVideos->count() }}</span></div>
                        <div class="media-grid">
                            @foreach($yFVideos as $v)
                            <div class="media-thumb" style="aspect-ratio:16/9" onclick="openLightbox('{{ asset($v->file_path) }}','video','{{ addslashes($v->caption??"") }}','{{ route("sponsor.download",["type"=>"family_media","id"=>$v->id]) }}')">
                                <video src="{{ asset($v->file_path) }}" muted playsinline></video>
                                <div class="media-video-tag"><i class="fas fa-play" style="font-size:7px"></i> VIDEO</div>
                                <div class="media-overlay" style="opacity:1;background:rgba(0,0,0,.35)"><div class="media-play-btn"><i class="fas fa-play" style="margin-left:2px"></i></div></div>
                                @if($v->caption)<div class="media-caption">{{ $v->caption }}</div>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($yFUpdates->isEmpty()&&$yFPhotos->isEmpty()&&$yFVideos->isEmpty())
                    <div class="white-card" style="text-align:center;padding:48px 24px">
                        <i class="fas fa-calendar" style="font-size:38px;color:#e2e8f0;display:block;margin-bottom:12px"></i>
                        <p style="color:#94a3b8;font-size:14px;font-weight:600">No content for {{ $yr }}.</p>
                    </div>
                    @endif
                </div>
                <div>
                    <div class="white-card">
                        <div class="wc-title"><span class="wc-icon" style="background:#fef9c3;color:#854d0e"><i class="fas fa-folder-open"></i></span> Documents · {{ $yr }} @if($yFDocs->isNotEmpty())<span class="wc-badge" style="background:#fef9c3;color:#854d0e">{{ $yFDocs->count() }}</span>@endif</div>
                        @forelse($yFDocs as $doc)
                        <div class="doc-item"><div class="doc-icon"><i class="fas fa-file-pdf"></i></div><div class="doc-info"><div class="doc-name">{{ $doc->title }}</div><div class="doc-meta">@if($doc->document_date){{ \Carbon\Carbon::parse($doc->document_date)->format('M d, Y') }}@endif</div></div><a href="{{ route('sponsor.download',['type'=>'family_document','id'=>$doc->id]) }}" class="doc-dl"><i class="fas fa-download"></i></a></div>
                        @empty
                        <p style="text-align:center;color:#94a3b8;font-size:13px;padding:16px 0">No documents for {{ $yr }}.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    {{-- ═══════════════════════════════════════
         CHILD PANELS
    ═══════════════════════════════════════ --}}
    @foreach($children as $ci => $child)
    @php
        $eidx = $families->count()+$ci; $panelId = "panel-{$eidx}";
        $cYears = collect();
        foreach($child->updates   as $u){ $cYears->push(\Carbon\Carbon::parse($u->report_date??$u->created_at)->year); }
        foreach($child->media     as $m){ $cYears->push($m->created_at->year); }
        foreach($child->documents as $d){ $cYears->push($d->created_at->year); }
        $cYears = $cYears->unique()->sortDesc()->values();
    @endphp
    <div class="detail-panel {{ ($totalEntities===1||$eidx===0)?'active':'' }}" id="{{ $panelId }}" style="margin-top:28px">

        @if($cYears->isNotEmpty())
        <div class="year-bar reveal">
            <span class="year-bar-label">Year:</span>
            <button class="year-pill active" data-panel="{{ $panelId }}" data-year="latest" onclick="switchYear('{{ $panelId }}','latest')">
                <i class="fas fa-star" style="font-size:9px;margin-right:4px;color:inherit"></i> Latest
            </button>
            @foreach($cYears as $yr)
            <button class="year-pill" data-panel="{{ $panelId }}" data-year="{{ $yr }}" onclick="switchYear('{{ $panelId }}','{{ $yr }}')">{{ $yr }}</button>
            @endforeach
        </div>
        @endif

        {{-- Latest --}}
        <div class="year-section active" data-panel="{{ $panelId }}" data-section="latest">
            <div class="content-grid">
                <div>
                    <div class="white-card reveal">
                        <div class="wc-title"><span class="wc-icon" style="background:#f0fdf4;color:#22c55e"><i class="fas fa-newspaper"></i></span> Latest Updates <span class="wc-badge new-dot" style="background:#dcfce7;color:#166534"></span></div>
                        @forelse($child->updates->sortByDesc('report_date')->take(3) as $update)
                        <div class="update-item">
                            <div class="update-head"><div>@if($update->type)<span class="update-type-badge badge-{{ $update->type }}">{{ $update->type }}</span>@endif @if($update->title)<span class="update-title">{{ $update->title }}</span>@endif</div><span class="update-date">{{ \Carbon\Carbon::parse($update->report_date??$update->created_at)->format('M d, Y') }}</span></div>
                            <p class="update-body">{{ $update->content }}</p>
                        </div>
                        @empty
                        <p style="text-align:center;color:#94a3b8;font-size:13px;padding:24px 0">No updates yet.</p>
                        @endforelse
                    </div>
                    <div class="white-card reveal" style="margin-top:14px">
                        <div class="wc-title"><span class="wc-icon" style="background:#fff7ed;color:#f97316"><i class="fas fa-photo-film"></i></span> Latest Media</div>
                        @php $latestCMedia = $child->media->sortByDesc('created_at')->take(6); @endphp
                        @if($latestCMedia->isNotEmpty())
                        <div class="media-grid">
                            @foreach($latestCMedia as $m)
                            <div class="media-thumb reveal-scale stagger-{{ ($loop->index%3)+1 }}"
                                 onclick="openLightbox('{{ asset($m->file_path) }}','{{ $m->type }}','{{ addslashes($m->caption??"") }}','{{ route("sponsor.download",["type"=>"media","id"=>$m->id]) }}')">
                                @if($m->type==='video')
                                    <video src="{{ asset($m->file_path) }}" muted playsinline></video>
                                    <div class="media-video-tag"><i class="fas fa-play" style="font-size:7px"></i> VIDEO</div>
                                @else
                                    <img src="{{ asset($m->file_path) }}" alt="">
                                @endif
                                <div class="media-overlay"><div class="media-play-btn"><i class="fas fa-{{ $m->type==='video'?'play':'expand' }}" style="{{ $m->type==='video'?'margin-left:2px':'' }}"></i></div></div>
                                @if($m->caption)<div class="media-caption">{{ $m->caption }}</div>@endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div style="text-align:center;padding:30px 0;color:#94a3b8">
                            <i class="fas fa-images" style="font-size:32px;display:block;margin-bottom:8px;opacity:.25"></i>
                            <p style="font-size:13px;font-weight:600">No media yet.</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div>
                    @if($child->has_family && $child->family)
                    <div class="white-card reveal reveal-right" style="margin-bottom:14px">
                        <div class="wc-title"><span class="wc-icon" style="background:#f0fdf4;color:#22c55e"><i class="fas fa-home"></i></span> Family</div>
                        <div class="family-mini-card">
                            @if($child->family->profile_photo)
                                <img src="{{ asset($child->family->profile_photo) }}" class="family-mini-photo" alt="">
                            @else
                                <div class="family-mini-icon"><i class="fas fa-users" style="color:#22c55e;font-size:18px"></i></div>
                            @endif
                            <div style="min-width:0">
                                <div style="font-size:13px;font-weight:800;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $child->family->name }}</div>
                                @if($child->family->country)<div style="font-size:11px;color:#64748b;font-weight:600;margin-top:2px"><i class="fas fa-map-marker-alt" style="color:#f97316;font-size:9px"></i> {{ $child->family->country }}</div>@endif
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="white-card reveal reveal-right">
                        <div class="wc-title"><span class="wc-icon" style="background:#fef9c3;color:#854d0e"><i class="fas fa-folder-open"></i></span> Documents</div>
                        @forelse($child->documents->sortByDesc('created_at')->take(8) as $doc)
                        <div class="doc-item"><div class="doc-icon"><i class="fas fa-file-pdf"></i></div><div class="doc-info"><div class="doc-name">{{ $doc->title }}</div><div class="doc-meta">@if($doc->document_date){{ \Carbon\Carbon::parse($doc->document_date)->format('M d, Y') }}@endif @if($doc->type) · {{ strtoupper($doc->type) }}@endif</div></div><a href="{{ route('sponsor.download',['type'=>'document','id'=>$doc->id]) }}" class="doc-dl"><i class="fas fa-download"></i></a></div>
                        @empty
                        <p style="text-align:center;color:#94a3b8;font-size:13px;padding:16px 0">No documents yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        @foreach($cYears as $yr)
        @php
            $yUpdates = $child->updates->filter(fn($u)=>\Carbon\Carbon::parse($u->report_date??$u->created_at)->year==$yr)->sortByDesc('report_date');
            $yMedia   = $child->media->filter(fn($m)=>$m->created_at->year==$yr)->sortByDesc('created_at');
            $yDocs    = $child->documents->filter(fn($d)=>$d->created_at->year==$yr)->sortByDesc('created_at');
            $yPhotos  = $yMedia->filter(fn($m)=>in_array($m->type,['image','photo']));
            $yVideos  = $yMedia->where('type','video');
        @endphp
        <div class="year-section" data-panel="{{ $panelId }}" data-section="{{ $yr }}">
            <div class="content-grid">
                <div>
                    @if($yUpdates->isNotEmpty())
                    <div class="white-card">
                        <div class="wc-title"><span class="wc-icon" style="background:#f0fdf4;color:#22c55e"><i class="fas fa-newspaper"></i></span> Updates · {{ $yr }} <span class="wc-badge" style="background:#dcfce7;color:#166534">{{ $yUpdates->count() }}</span></div>
                        @foreach($yUpdates as $update)
                        <div class="update-item"><div class="update-head"><div>@if($update->type)<span class="update-type-badge badge-{{ $update->type }}">{{ $update->type }}</span>@endif @if($update->title)<span class="update-title">{{ $update->title }}</span>@endif</div><span class="update-date">{{ \Carbon\Carbon::parse($update->report_date??$update->created_at)->format('M d, Y') }}</span></div><p class="update-body">{{ $update->content }}</p></div>
                        @endforeach
                    </div>
                    @endif
                    @if($yPhotos->isNotEmpty())
                    <div class="white-card" style="margin-top:14px">
                        <div class="wc-title"><span class="wc-icon" style="background:#eff6ff;color:#3b82f6"><i class="fas fa-images"></i></span> Photos · {{ $yr }} <span class="wc-badge" style="background:#dbeafe;color:#1e40af">{{ $yPhotos->count() }}</span></div>
                        <div class="media-grid">
                            @foreach($yPhotos as $p)
                            <div class="media-thumb" onclick="openLightbox('{{ asset($p->file_path) }}','image','{{ addslashes($p->caption??"") }}','{{ route("sponsor.download",["type"=>"media","id"=>$p->id]) }}')">
                                <img src="{{ asset($p->file_path) }}" alt=""><div class="media-overlay"><div class="media-play-btn"><i class="fas fa-expand"></i></div></div>@if($p->caption)<div class="media-caption">{{ $p->caption }}</div>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($yVideos->isNotEmpty())
                    <div class="white-card" style="margin-top:14px">
                        <div class="wc-title"><span class="wc-icon" style="background:#faf5ff;color:#9333ea"><i class="fas fa-video"></i></span> Videos · {{ $yr }} <span class="wc-badge" style="background:#e9d5ff;color:#7c3aed">{{ $yVideos->count() }}</span></div>
                        <div class="media-grid">
                            @foreach($yVideos as $v)
                            <div class="media-thumb" style="aspect-ratio:16/9" onclick="openLightbox('{{ asset($v->file_path) }}','video','{{ addslashes($v->caption??"") }}','{{ route("sponsor.download",["type"=>"media","id"=>$v->id]) }}')">
                                <video src="{{ asset($v->file_path) }}" muted playsinline></video><div class="media-video-tag"><i class="fas fa-play" style="font-size:7px"></i> VIDEO</div><div class="media-overlay" style="opacity:1;background:rgba(0,0,0,.35)"><div class="media-play-btn"><i class="fas fa-play" style="margin-left:2px"></i></div></div>@if($v->caption)<div class="media-caption">{{ $v->caption }}</div>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($yUpdates->isEmpty()&&$yPhotos->isEmpty()&&$yVideos->isEmpty())
                    <div class="white-card" style="text-align:center;padding:48px 24px">
                        <i class="fas fa-calendar" style="font-size:38px;color:#e2e8f0;display:block;margin-bottom:12px"></i>
                        <p style="color:#94a3b8;font-size:14px;font-weight:600">No content for {{ $yr }}.</p>
                    </div>
                    @endif
                </div>
                <div>
                    @if($child->has_family && $child->family)
                    <div class="white-card" style="margin-bottom:14px">
                        <div class="wc-title"><span class="wc-icon" style="background:#f0fdf4;color:#22c55e"><i class="fas fa-home"></i></span> Family</div>
                        <div class="family-mini-card">
                            @if($child->family->profile_photo)<img src="{{ asset($child->family->profile_photo) }}" class="family-mini-photo" alt="">@else<div class="family-mini-icon"><i class="fas fa-users" style="color:#22c55e;font-size:18px"></i></div>@endif
                            <div style="min-width:0"><div style="font-size:13px;font-weight:800;color:#0f172a">{{ $child->family->name }}</div>@if($child->family->country)<div style="font-size:11px;color:#64748b;font-weight:600;margin-top:2px"><i class="fas fa-map-marker-alt" style="color:#f97316;font-size:9px"></i> {{ $child->family->country }}</div>@endif</div>
                        </div>
                    </div>
                    @endif
                    <div class="white-card">
                        <div class="wc-title"><span class="wc-icon" style="background:#fef9c3;color:#854d0e"><i class="fas fa-folder-open"></i></span> Documents · {{ $yr }} @if($yDocs->isNotEmpty())<span class="wc-badge" style="background:#fef9c3;color:#854d0e">{{ $yDocs->count() }}</span>@endif</div>
                        @forelse($yDocs as $doc)
                        <div class="doc-item"><div class="doc-icon"><i class="fas fa-file-pdf"></i></div><div class="doc-info"><div class="doc-name">{{ $doc->title }}</div><div class="doc-meta">@if($doc->document_date){{ \Carbon\Carbon::parse($doc->document_date)->format('M d, Y') }}@endif</div></div><a href="{{ route('sponsor.download',['type'=>'document','id'=>$doc->id]) }}" class="doc-dl"><i class="fas fa-download"></i></a></div>
                        @empty
                        <p style="text-align:center;color:#94a3b8;font-size:13px;padding:16px 0">No documents for {{ $yr }}.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    {{-- Footer --}}
    <div class="footer-note reveal">
        <p style="font-size:13px;color:#374151;line-height:1.7;margin:0">
            <i class="fas fa-heart" style="color:#f97316;margin-right:8px"></i>
            <strong>Thank you for your continued support!</strong> Your sponsorship makes a real difference.
            Questions? <a href="https://mail.google.com/mail/?view=cm&to=asso.desailespourgrandir@gmail.com" target="_blank" style="color:#f97316;font-weight:700;text-decoration:none">asso.desailespourgrandir@gmail.com</a>
        </p>
    </div>
</div>

{{-- Mobile bottom bar --}}
<div class="mobile-bottom-bar">
    <div style="display:flex;align-items:center;gap:8px">
        <div class="sponsor-avatar" style="width:30px;height:30px;border-radius:8px;font-size:12px">{{ strtoupper(substr($sponsor->first_name,0,1)) }}</div>
        <span style="font-size:12px;font-weight:800;color:#0f172a">{{ $sponsor->first_name }}</span>
    </div>
    <form method="POST" action="{{ route('sponsor.logout') }}" style="margin:0">
        @csrf
        <button style="padding:7px 14px;border-radius:9px;background:#f1f5f9;border:none;cursor:pointer;font-size:11px;font-weight:700;color:#475569;font-family:inherit;display:flex;align-items:center;gap:5px">
            <i class="fas fa-sign-out-alt" style="font-size:10px"></i> Logout
        </button>
    </form>
</div>

{{-- Lightbox --}}
<div id="lightbox" class="fixed inset-0 z-[100] items-center justify-center p-4"
     style="background:rgba(0,0,0,.96);backdrop-filter:blur(10px)" onclick="closeLightbox()">
    <div style="position:absolute;top:0;left:0;right:0;display:flex;align-items:center;justify-content:space-between;padding:14px 18px;z-index:10" onclick="event.stopPropagation()">
        <p id="lb-caption" style="color:rgba(255,255,255,.75);font-size:13px;font-weight:700;max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"></p>
        <div style="display:flex;align-items:center;gap:8px">
            <a id="lb-download" href="#" download style="display:flex;align-items:center;gap:5px;padding:7px 13px;background:rgba(255,255,255,.12);color:#fff;border-radius:9px;font-size:11px;font-weight:700;text-decoration:none;transition:background .15s" onmouseover="this.style.background='rgba(255,255,255,.2)'" onmouseout="this.style.background='rgba(255,255,255,.12)'">
                <i class="fas fa-download" style="font-size:10px"></i> <span class="hidden sm:inline">Download</span>
            </a>
            <button onclick="closeLightbox()" style="width:36px;height:36px;background:rgba(255,255,255,.12);border:none;color:#fff;border-radius:9px;cursor:pointer;font-size:15px;display:flex;align-items:center;justify-content:center;transition:background .15s" onmouseover="this.style.background='rgba(255,255,255,.22)'" onmouseout="this.style.background='rgba(255,255,255,.12)'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div id="lb-inner" onclick="event.stopPropagation()" style="display:flex;align-items:center;justify-content:center;margin-top:54px;max-height:calc(100vh - 90px);width:100%">
        <img id="lb-img" src="" alt="" style="max-width:100%;max-height:calc(100vh - 90px);border-radius:14px;box-shadow:0 24px 64px rgba(0,0,0,.5);object-fit:contain;display:none">
        <video id="lb-video" src="" controls autoplay style="max-width:100%;max-height:calc(100vh - 90px);border-radius:14px;box-shadow:0 24px 64px rgba(0,0,0,.5);display:none;width:100%"></video>
    </div>
    <p style="position:absolute;bottom:12px;left:50%;transform:translateX(-50%);color:rgba(255,255,255,.2);font-size:11px;font-weight:600;white-space:nowrap">Press ESC or tap outside to close</p>
</div>

<script>
// ── Scroll reveal ──
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            revealObserver.unobserve(e.target);
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

function initReveal() {
    document.querySelectorAll('.reveal,.reveal-left,.reveal-scale,.reveal-right').forEach(el => {
        revealObserver.observe(el);
    });
}

// ── Entity select ──
function selectEntity(index) {
    document.querySelectorAll('.entity-card').forEach((c, i) => c.classList.toggle('active-card', i === index));
    document.querySelectorAll('.detail-panel').forEach((p, i) => {
        if (i === index) {
            p.classList.add('active');
            setTimeout(() => initReveal(), 50);
        } else {
            p.classList.remove('active');
        }
    });
    setTimeout(() => {
        const panel = document.getElementById('panel-' + index);
        if (panel) panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 60);
}

// ── Year filter ──
function switchYear(panelId, year) {
    document.querySelectorAll(`.year-pill[data-panel="${panelId}"]`).forEach(btn => {
        btn.classList.toggle('active', btn.dataset.year === String(year));
    });
    document.querySelectorAll(`.year-section[data-panel="${panelId}"]`).forEach(sec => {
        sec.classList.toggle('active', sec.dataset.section === String(year));
    });
    setTimeout(() => initReveal(), 50);
}

// ── Lightbox ──
function openLightbox(src, type, caption, downloadUrl) {
    const lb  = document.getElementById('lightbox');
    const img = document.getElementById('lb-img');
    const vid = document.getElementById('lb-video');
    const inner = document.getElementById('lb-inner');

    if (type === 'video') {
        vid.src = src; vid.style.display = 'block';
        img.style.display = 'none'; img.src = '';
    } else {
        img.src = src; img.style.display = 'block';
        vid.style.display = 'none'; vid.pause(); vid.src = '';
    }
    document.getElementById('lb-caption').textContent = caption || '';
    document.getElementById('lb-download').href = downloadUrl || src;
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
    inner.style.animation = 'none';
    requestAnimationFrame(() => { inner.style.animation = 'scaleIn .25s cubic-bezier(.34,1.1,.64,1) both'; });
}
function closeLightbox() {
    const vid = document.getElementById('lb-video');
    vid.pause(); vid.src = '';
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

// ── Touch swipe to close lightbox ──
let tsY = 0;
document.getElementById('lightbox').addEventListener('touchstart', e => { tsY = e.touches[0].clientY; }, {passive:true});
document.getElementById('lightbox').addEventListener('touchend', e => {
    if (e.changedTouches[0].clientY - tsY > 80) closeLightbox();
}, {passive:true});

// ── Language ──
const DASH_LANGS = {
    en:{label:'EN',flag:'https://flagcdn.com/w40/us.png'},
    fr:{label:'FR',flag:'https://flagcdn.com/w40/fr.png'},
    km:{label:'KM',flag:'https://flagcdn.com/w40/kh.png'}
};
let dashCurrentLang = localStorage.getItem('gt_lang') || 'fr';

function dashTriggerTranslate(lang) {
    return new Promise(resolve => {
        const exp = 'expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = 'googtrans=; '+exp;
        document.cookie = 'googtrans=; '+exp+' domain='+location.hostname+';';
        document.cookie = 'googtrans=; '+exp+' domain=.'+location.hostname+';';
        if (lang === 'en') { resolve(); setTimeout(()=>location.reload(),80); return; }
        const pair = '/en/'+lang;
        document.cookie = 'googtrans='+pair+'; path=/';
        document.cookie = 'googtrans='+pair+'; path=/; domain='+location.hostname;
        const trySelect = tries => {
            const sel = document.querySelector('select.goog-te-combo');
            if (sel) { sel.value=lang; sel.dispatchEvent(new Event('change')); resolve(); }
            else if (tries>0) setTimeout(()=>trySelect(tries-1),200);
            else { resolve(); setTimeout(()=>location.reload(),80); }
        };
        trySelect(8);
    });
}
function dashUpdateUI(lang) {
    const cfg = DASH_LANGS[lang]||DASH_LANGS.en;
    const f = document.getElementById('dash-flag');
    const l = document.getElementById('dash-lang-label');
    if (f){f.src=cfg.flag;f.alt=cfg.label;}
    if (l) l.textContent=cfg.label;
    ['en','fr','km'].forEach(lc=>{
        document.getElementById('dash-btn-'+lc)?.classList.toggle('active',lc===lang);
        const chk=document.getElementById('dash-check-'+lc);
        if(chk) chk.classList.toggle('hidden',lc!==lang);
    });
    document.body.style.fontFamily = lang==='km'
        ? "'Hanuman','Battambang','Content','Plus Jakarta Sans',sans-serif"
        : "'Plus Jakarta Sans',sans-serif";
    dashCurrentLang=lang;
    localStorage.setItem('gt_lang',lang);
}
async function dashSwitchLang(lang) {
    if (lang===dashCurrentLang){dashClosePanel();return;}
    dashUpdateUI(lang); await dashTriggerTranslate(lang); dashClosePanel();
}
function dashTogglePanel(){
    const p=document.getElementById('dash-translate-panel');
    const c=document.getElementById('dash-caret');
    const o=p.classList.toggle('open');
    if(c) c.style.transform=o?'rotate(180deg)':'';
}
function dashClosePanel(){
    const p=document.getElementById('dash-translate-panel');
    const c=document.getElementById('dash-caret');
    if(p) p.classList.remove('open');
    if(c) c.style.transform='';
}
document.addEventListener('click',e=>{
    const w=document.getElementById('dash-translate-wrapper');
    if(w&&!w.contains(e.target)) dashClosePanel();
});

document.addEventListener('DOMContentLoaded',()=>{
    // Init scroll reveal
    initReveal();

    // Card entrance stagger
    document.querySelectorAll('.entity-card').forEach((card,i)=>{
        card.style.animationDelay = (i*0.08)+'s';
    });

    // Language
    const cookie=document.cookie.split(';').find(c=>c.trim().startsWith('googtrans='));
    const stored=localStorage.getItem('gt_lang');
    if (cookie){
        const parts=cookie.split('/');
        const cl=parts[parts.length-1].trim();
        if(cl&&DASH_LANGS[cl]){dashCurrentLang=cl;localStorage.setItem('gt_lang',cl);}
    } else if(!stored){
        const pair='/en/fr';
        document.cookie='googtrans='+pair+'; path=/';
        document.cookie='googtrans='+pair+'; path=/; domain='+location.hostname;
        localStorage.setItem('gt_lang','fr');
        location.reload(); return;
    }
    dashUpdateUI(dashCurrentLang);
});
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>
</body>
</html> 