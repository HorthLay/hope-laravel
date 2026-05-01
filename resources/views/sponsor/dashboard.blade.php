<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard | {{ $sponsor->full_name }}</title>
    <meta name="robots" content="noindex, nofollow">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <script>function googleTranslateElementInit(){new google.translate.TranslateElement({pageLanguage:'en',includedLanguages:'en,km,fr',layout:google.translate.TranslateElement.InlineLayout.SIMPLE,autoDisplay:false,multilanguagePage:true},'google_translate_element');}</script>
    <style>
    :root {
        --bg:       #fcfbfa;
        --brand:    #f97316;
        --brand-lt: #fff4db;
        --brand-md: #fde68a;
        --orange:   #ef7d00;
        --orange-lt:#f3cd6c;
        --dark:     #2a3328;
        --muted:    rgb(148, 125, 102);
        --border:   #ede9e3;
        --white:    #ffffff;
        --card-sh:  0 2px 16px rgba(0,0,0,.05);
        --card-sh2: 0 8px 32px rgba(0,0,0,.09);
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--bg); color: var(--dark);
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
    }
    body { top: 0 !important; }
    .goog-te-banner-frame,.goog-te-balloon-frame,#goog-gt-tt,.goog-te-spinner-pos,.skiptranslate{display:none!important}

    /* ── TYPOGRAPHY ── */
    .serif { font-family: 'Lora', serif; }
    h1,h2,h3 { font-family: 'Lora', serif; color: var(--brand); }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp    { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:none} }
    @keyframes fadeIn    { from{opacity:0} to{opacity:1} }
    @keyframes fadeLeft  { from{opacity:0;transform:translateX(-20px)} to{opacity:1;transform:none} }
    @keyframes scaleUp   { from{opacity:0;transform:scale(.93)} to{opacity:1;transform:scale(1)} }
    @keyframes slideDown { from{opacity:0;transform:translateY(-14px)} to{opacity:1;transform:none} }
    @keyframes floatY    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
    @keyframes pulseOrb  { 0%,100%{opacity:.25;transform:scale(1)} 50%{opacity:.45;transform:scale(1.12)} }
    @keyframes checkPop  { 0%{opacity:0;transform:scale(0)} 70%{transform:scale(1.15)} 100%{opacity:1;transform:scale(1)} }
    @keyframes spin      { to{transform:rotate(360deg)} }
    @keyframes shimmer   { from{background-position:-600px 0} to{background-position:600px 0} }

    .anim-up  { animation: fadeUp  .6s cubic-bezier(.16,1,.3,1) both; }
    .anim-in  { animation: fadeIn  .5s ease both; }
    .anim-left{ animation: fadeLeft .55s cubic-bezier(.16,1,.3,1) both; }
    .anim-sc  { animation: scaleUp .55s cubic-bezier(.16,1,.3,1) both; }
    .d1{animation-delay:.08s}.d2{animation-delay:.16s}.d3{animation-delay:.24s}
    .d4{animation-delay:.32s}.d5{animation-delay:.40s}.d6{animation-delay:.48s}

    /* ── SCROLL REVEAL ── */
    .reveal { opacity:0; transform:translateY(24px); transition:opacity .55s ease,transform .55s ease; }
    .reveal.v { opacity:1; transform:none; }
    .reveal-l { opacity:0; transform:translateX(-22px); transition:opacity .5s ease,transform .5s ease; }
    .reveal-l.v { opacity:1; transform:none; }
    .reveal-r { opacity:0; transform:translateX(22px); transition:opacity .5s ease,transform .5s ease; }
    .reveal-r.v { opacity:1; transform:none; }
    .reveal-s { opacity:0; transform:scale(.93); transition:opacity .45s ease,transform .45s ease; }
    .reveal-s.v { opacity:1; transform:scale(1); }
    .sd1{transition-delay:.06s}.sd2{transition-delay:.12s}.sd3{transition-delay:.18s}
    .sd4{transition-delay:.24s}.sd5{transition-delay:.30s}.sd6{transition-delay:.36s}

    /* ── HEADER ── */
    .site-header {
        background: #fff; border-bottom: 1px solid var(--border);
        position: sticky; top: 0; z-index: 200;
        box-shadow: 0 2px 12px rgba(0,0,0,.04);
        animation: slideDown .38s ease both;
    }
    .header-inner {
        max-width: 1180px; margin: 0 auto; padding: 0 24px;
        height: 72px; display: flex; align-items: center; justify-content: space-between;
    }
    .hdr-logo { height: 64px; width: auto; display: block; transition: opacity .2s; }
    .hdr-logo:hover { opacity: .82; }
    .hdr-nav { display: flex; align-items: center; gap: 4px; height: 100%; }
    .hdr-nav-link {
        display: inline-flex; align-items: center; gap: 7px;
        color: var(--muted); font-size: 13.5px; font-weight: 600;
        padding: 6px 12px; border-radius: 8px; text-decoration: none;
        transition: color .18s, background .18s; position: relative;
        white-space: nowrap;
    }
    .hdr-nav-link:hover { color: var(--brand); background: var(--brand-lt); }
    .hdr-nav-link.active { color: var(--brand); font-weight: 700; }
    .hdr-nav-link.active::after {
        content: ''; position: absolute; bottom: -13px; left: 0; right: 0;
        height: 3px; background: var(--brand); border-radius: 3px 3px 0 0;
    }
    .hdr-right { display: flex; align-items: center; gap: 10px; }

    /* Language pill */
    .lang-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 11px; border-radius: 10px; border: 1px solid var(--border);
        background: #fff; cursor: pointer; font-size: 12px; font-weight: 700;
        color: var(--dark); transition: all .18s; white-space: nowrap;
    }
    .lang-pill:hover { border-color: var(--orange); color: var(--orange); }
    #dash-translate-panel {
        position: absolute; top: calc(100% + 8px); right: 0; width: 192px;
        background: #fff; border-radius: 14px; padding: 10px;
        box-shadow: 0 20px 50px rgba(0,0,0,.16); border: 1px solid #f0ece6;
        opacity: 0; visibility: hidden; transform: translateY(-6px) scale(.97);
        transition: all .22s cubic-bezier(.34,1.56,.64,1); z-index: 9999;
    }
    #dash-translate-panel.open { opacity:1; visibility:visible; transform:translateY(0) scale(1); }
    .lang-opt {
        display: flex; align-items: center; gap: 9px; width: 100%;
        padding: 8px 10px; border-radius: 9px; border: 2px solid transparent;
        background: transparent; cursor: pointer; font-size: 12px;
        font-weight: 600; color: var(--dark); font-family: inherit; transition: all .15s;
    }
    .lang-opt:hover { background: var(--orange-lt); border-color: #fbd7a6; }
    .lang-opt.active { background: linear-gradient(135deg,var(--orange-lt),#ffe4c0); border-color: var(--orange); color: #b45309; }
    .lang-opt .flag { width: 22px; height: 15px; object-fit: cover; object-position: center 20%;border-radius: 3px; }
    .lang-opt .chk { margin-left: auto; color: var(--orange); font-size: 10px; }

    /* ── NOTIFICATION DROPDOWN ── */
    .notif-btn {
        position: relative; width: 38px; height: 38px;
        background: #fff; border: 1px solid var(--border);
        border-radius: 11px; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: var(--muted); font-size: 15px; transition: all .18s;
        font-family: inherit;
    }
    .notif-btn:hover { border-color: var(--orange); color: var(--orange); }
    .notif-badge {
        position: absolute; top: -5px; right: -5px;
        width: 18px; height: 18px; background: var(--orange);
        border-radius: 50%; color: #fff; font-size: 9px; font-weight: 900;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid var(--bg); line-height: 1;
    }
    .notif-panel {
        position: absolute; top: calc(100% + 10px); right: 0;
        width: 340px; background: #fff; border-radius: 18px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 60px rgba(0,0,0,.13);
        opacity: 0; visibility: hidden;
        transform: translateY(-8px) scale(.97);
        transition: all .22s cubic-bezier(.34,1.3,.64,1);
        z-index: 999; overflow: hidden;
    }
    .notif-panel.open { opacity: 1; visibility: visible; transform: none; }
    .notif-header {
        padding: 14px 16px 0; border-bottom: 1px solid var(--border);
    }
    .notif-title-row {
        display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;
    }
    .notif-tabs { display: flex; }
    .ntab {
        flex: 1; padding: 8px 10px; font-size: 12px; font-weight: 700;
        border: none; background: none; cursor: pointer; font-family: inherit;
        color: var(--muted); border-bottom: 2px solid transparent;
        transition: color .18s, border-color .18s;
        display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .ntab.active { color: var(--orange); border-bottom-color: var(--orange); }
    .ntab .ntab-count {
        background: var(--brand-lt); color: var(--orange);
        border-radius: 999px; padding: 1px 7px; font-size: 10px; font-weight: 800;
    }
    .ntab:not(.active) .ntab-count { background: #f1f5f9; color: var(--muted); }
    .notif-body { max-height: 320px; overflow-y: auto; scrollbar-width: thin; }
    .notif-pane { display: none; }
    .notif-pane.active { display: block; }
    .nitem {
        padding: 12px 16px; display: flex; gap: 11px; align-items: flex-start;
        border-bottom: 1px solid var(--border); transition: background .15s; cursor: pointer;
    }
    .nitem:last-child { border-bottom: none; }
    .nitem:hover { background: #fafaf8; }
    .nitem.unread { background: #fffbf6; }
    .nitem-icon {
        width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 14px;
    }
    .nitem-icon.child  { background: var(--brand-lt); color: var(--brand); }
    .nitem-icon.family { background: #dbeafe; color: #1e40af; }
    .nitem-icon.doc    { background: #fee2e2; color: #ef4444; }
    .nitem-content { flex: 1; min-width: 0; }
    .nitem-meta { display: flex; align-items: center; gap: 5px; margin-bottom: 3px; flex-wrap: wrap; }
    .nitem-entity { font-size: 11px; color: var(--muted); font-weight: 600; }
    .nitem-date   { font-size: 11px; color: var(--muted); }
    .nitem-title  { font-size: 13px; font-weight: 700; color: var(--dark); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .nitem-text   { font-size: 12px; color: var(--muted); line-height: 1.55; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .nitem-dot    { width: 7px; height: 7px; background: var(--orange); border-radius: 50%; flex-shrink: 0; margin-top: 5px; }
    .nitem-dl {
        width: 28px; height: 28px; border-radius: 7px; flex-shrink: 0;
        background: #f3f2ee; color: var(--muted); border: none;
        display: flex; align-items: center; justify-content: center;
        text-decoration: none; transition: all .18s; font-size: 11px; cursor: pointer;
    }
    .nitem-dl:hover { background: var(--orange); color: #fff; transform: scale(1.08); }
    .notif-footer {
        padding: 11px 16px; border-top: 1px solid var(--border);
        text-align: center;
    }
    .notif-footer a {
        font-size: 12px; color: var(--orange); font-weight: 700;
        text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: color .18s;
    }
    .notif-footer a:hover { color: #d97000; }

    /* Sponsor chip */
    .sponsor-chip {
        display: flex; align-items: center; gap: 9px;
        background: #f8f7f3; border-radius: 12px; padding: 6px 12px;
        border: 1px solid var(--border);
    }
    .s-avatar {
        width: 33px; height: 33px; border-radius: 9px;
        background: linear-gradient(135deg,var(--orange),#d46a00);
        color: #fff; font-weight: 900; font-size: 13px;
        display: flex; align-items: center; justify-content: center;
    }
    .s-name  { font-size: 12px; font-weight: 800; color: var(--dark); line-height: 1.3; }
    .s-email { font-size: 10px; color: var(--muted); }
    .logout-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 13px; border-radius: 9px; background: #f3f2ee;
        border: none; cursor: pointer; font-size: 12px; font-weight: 700;
        color: var(--muted); transition: all .18s; font-family: inherit;
    }
    .logout-btn:hover { background: #fee2e2; color: #dc2626; }

    /* ── PAGE WRAP ── */
    .pw { max-width: 1180px; margin: 0 auto; padding: 36px 24px 80px; }

    /* ── ENTITY SELECTOR ── */
    .entity-tabs {
        display: flex; gap: 12px; flex-wrap: wrap;
        margin-bottom: 32px;
    }
    .entity-tabs::-webkit-scrollbar { display: none; }
    .entity-tab {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 18px; border-radius: 14px; cursor: pointer;
        background: #fff; border: 2px solid var(--border);
        font-size: 13px; font-weight: 700; color: var(--muted);
        transition: all .22s; box-shadow: var(--card-sh);
    }
    .entity-tab img { width: 36px; height: 36px; border-radius: 8px; object-fit: cover; }
    .entity-tab .et-icon {
        width: 36px; height: 36px; border-radius: 8px;
        background: var(--brand-lt); display: flex; align-items: center; justify-content: center;
        color: var(--brand); font-size: 15px;
    }
    .entity-tab:hover { border-color: var(--brand); color: var(--brand); transform: translateY(-2px); box-shadow: var(--card-sh2); }
    .entity-tab.active { border-color: var(--brand); background: var(--brand-lt); color: var(--brand); box-shadow: 0 6px 20px rgba(249,115,22,.18); }
    .entity-tab.active .et-icon { background: #fde9b8; }

    /* ── HERO SECTION ── */
    .hero-grid {
        display: grid; grid-template-columns: 280px 1fr 300px; gap: 20px;
        margin-bottom: 28px;
    }
    .hero-portrait {
        border-radius: 22px; overflow: hidden; position: relative;
        box-shadow: 0 12px 40px rgba(0,0,0,.14);
        aspect-ratio: 3/4;
    }
    .hero-portrait img {
        width: 100%; height: 100%; object-fit: cover;
        object-position: center 15%;
        transition: transform .5s ease;
    }
    .hero-portrait:hover img { transform: scale(1.04); }
    .hero-portrait-placeholder {
        width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg,var(--brand-lt),#fde9b8);
        font-size: 80px; color: var(--brand); opacity: .4;
    }

    /* Sponsorship since badge */
    .since-badge {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12.5px; font-weight: 600; color: var(--brand);
        margin-bottom: 12px;
    }
    .hero-name {
        font-family: 'Lora', serif; font-size: 52px; font-weight: 600;
        color: var(--dark); line-height: 1.1; margin-bottom: 24px;
        letter-spacing: -.5px;
    }
    .hero-info-list { list-style: none; display: flex; flex-direction: column; gap: 14px; margin-bottom: 24px; }
    .hero-info-item { display: flex; align-items: flex-start; gap: 14px; }
    .hero-info-icon { width: 20px; flex-shrink: 0; color: var(--orange); font-size: 14px; margin-top: 2px; }
    .hero-info-main { font-weight: 700; font-size: 15px; color: var(--dark); }
    .hero-info-sub  { font-size: 13px; color: var(--muted); margin-top: 1px; }

    /* Quote card */
    .quote-card {
        background: var(--orange-lt); border-radius: 16px;
        padding: 18px 20px; position: relative;
    }
    .quote-card .qq { font-size: 32px; color: #f6c08a; font-family: 'Lora', serif; line-height: 1; }
    .quote-text { font-size: 14px; font-style: italic; color: #4a3520; line-height: 1.65; font-weight: 500; }
    .quote-heart { position: absolute; bottom: -10px; right: -8px; color: var(--orange); font-size: 22px; transform: rotate(12deg); }

    /* Impact card */
    .impact-card {
        background: var(--brand-lt); border-radius: 22px; padding: 28px;
        display: flex; flex-direction: column; position: relative; overflow: hidden;
    }
    .impact-card::before {
        content: ''; position: absolute; bottom: -30px; right: -30px;
        width: 160px; height: 160px; border-radius: 50%;
        background: radial-gradient(circle, rgba(249,115,22,.12), transparent 70%);
        pointer-events: none;
    }
    .impact-icon-wrap {
        width: 64px; height: 64px; background: #fff; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px; box-shadow: 0 4px 14px rgba(0,0,0,.08);
        position: relative; z-index: 1;
    }
    .impact-icon-wrap i { font-size: 24px; color: var(--brand); }
    .impact-title { text-align: center; font-size: 22px; margin-bottom: 8px; }
    .impact-sub { text-align: center; font-size: 12.5px; color: var(--muted); margin-bottom: 20px; }
    .impact-list { list-style: none; display: flex; flex-direction: column; gap: 11px; flex: 1; }
    .impact-list li {
        display: flex; align-items: center; gap: 11px;
        font-size: 14px; font-weight: 600; color: var(--dark);
    }
    .impact-list li i { color: var(--brand); font-size: 15px; animation: checkPop .4s ease both; }
    .btn-orange {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        background: var(--orange); color: #fff; border: none; border-radius: 12px;
        padding: 14px 20px; font-size: 15px; font-weight: 700; cursor: pointer;
        font-family: inherit; text-decoration: none;
        box-shadow: 0 4px 16px rgba(239,125,0,.28);
        transition: all .22s; margin-top: 20px; position: relative; z-index: 1;
    }
    .btn-orange:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(239,125,0,.38); background: #d97000; }
    .btn-orange i { transition: transform .2s; }
    .btn-orange:hover i { transform: translateX(3px); }

    /* ── YEAR BAR ── */
    .year-bar {
        display: flex; align-items: center; gap: 8px; margin-bottom: 24px;
        overflow-x: auto; scrollbar-width: none; padding-bottom: 2px;
    }
    .year-bar::-webkit-scrollbar { display: none; }
    .year-lbl { font-size: 11px; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: .07em; flex-shrink: 0; }
    .y-pill {
        padding: 7px 16px; border-radius: 999px; border: 1.5px solid var(--border);
        background: #fff; font-size: 12px; font-weight: 700; color: var(--muted);
        cursor: pointer; transition: all .2s; white-space: nowrap; font-family: inherit;
        flex-shrink: 0;
    }
    .y-pill:hover { border-color: var(--brand); color: var(--brand); }
    .y-pill.active {
        background: var(--brand); border-color: var(--brand); color: #fff;
        box-shadow: 0 4px 14px rgba(249,115,22,.35); transform: scale(1.04);
    }
    .y-sec { display: none; }
    .y-sec.active { display: block; animation: fadeUp .22s ease both; }

    /* ── CONTENT GRID ── */
    .c-grid { display: grid; grid-template-columns: 1fr 310px; gap: 18px; }

    /* ── WHITE CARD ── */
    .wcard {
        background: #fff; border-radius: 20px; padding: 24px;
        border: 1px solid var(--border); box-shadow: var(--card-sh);
        transition: box-shadow .2s;
    }
    .wcard:hover { box-shadow: var(--card-sh2); }
    .wcard + .wcard { margin-top: 16px; }
    .wcard-title {
        font-family: 'Lora', serif; font-size: 18px; color: var(--dark);
        display: flex; align-items: center; gap: 10px; margin-bottom: 16px;
    }
    .wcard-title i { font-size: 14px; }
    .wc-badge {
        margin-left: auto; font-size: 10px; font-weight: 800;
        padding: 2px 9px; border-radius: 999px;
    }

    /* About section */
    .about-text { font-size: 14.5px; color: var(--muted); line-height: 1.75; margin-bottom: 18px; }
    .see-more { color: var(--orange); font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; transition: color .18s; }
    .see-more:hover { color: #d97000; }

    /* Photo gallery */
    .photo-gallery { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin-top: 18px; }
    .gallery-item {
        border-radius: 12px; overflow: hidden; cursor: pointer;
        aspect-ratio: 1; background: var(--brand-lt);
        transition: transform .28s ease, box-shadow .28s ease;
    }
    .gallery-item:hover { transform: scale(1.04); box-shadow: 0 8px 24px rgba(0,0,0,.15); }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; pointer-events: none; display: block; transition: transform .4s; }
    .gallery-item:hover img { transform: scale(1.08); }
    .gallery-item.view-all {
        background: var(--orange-lt); display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 6px;
    }
    .gallery-item.view-all i { color: var(--orange); font-size: 22px; }
    .gallery-item.view-all span { font-size: 11px; font-weight: 800; color: var(--orange); text-align: center; }

    /* ── TIMELINE (updates) ── */
    .timeline { position: relative; padding-left: 22px; }
    .timeline::before {
        content: ''; position: absolute; left: 8px; top: 12px; bottom: 0;
        width: 1px; background: var(--border);
    }
    .tl-item { position: relative; padding-bottom: 22px; }
    .tl-item:last-child { padding-bottom: 0; }
    .tl-dot {
        position: absolute; left: -22px; top: 6px;
        width: 18px; height: 18px; border-radius: 50%;
        background: #fff; border: 2px solid #c9c9c4;
        display: flex; align-items: center; justify-content: center;
        z-index: 1; transition: border-color .2s;
    }
    .tl-item:hover .tl-dot { border-color: var(--orange); }
    .tl-dot i { font-size: 8px; color: #9ca3af; }
    .tl-row { display: flex; align-items: flex-start; gap: 12px; }
    .tl-content { flex: 1; min-width: 0; }
    .tl-date { font-size: 12px; font-weight: 700; color: var(--dark); margin-bottom: 4px; }
    .tl-text { font-size: 13px; color: var(--muted); line-height: 1.6; }
    .tl-thumb { width: 64px; height: 64px; border-radius: 10px; object-fit: cover; flex-shrink: 0; cursor: pointer; transition: transform .2s; }
    .tl-thumb:hover { transform: scale(1.06); }
    .type-badge {
        display: inline-flex; align-items: center; font-size: 10px; font-weight: 800;
        padding: 2px 8px; border-radius: 999px; margin-right: 4px; text-transform: capitalize;
    }
    .badge-health    { background: #fef3c7;color:#f97316; }
    .badge-education { background:#dbeafe;color:#1e40af; }
    .badge-study     { background:#e0e7ff;color:#3730a3; }
    .badge-financial { background:#fef9c3;color:#854d0e; }
    .badge-general   { background:#f1f5f9;color:#475569; }
    .badge-visit     { background:#fce7f3;color:#9d174d; }
    .see-all-link {
        color: var(--orange); font-weight: 700; font-size: 13px;
        display: inline-flex; align-items: center; gap: 5px;
        text-decoration: none; margin-top: 16px; transition: color .18s;
    }
    .see-all-link:hover { color: #d97000; }

    /* ── SPONSORSHIP DETAILS ── */
    .spons-card {
        background: var(--brand-lt); border-radius: 20px; padding: 24px;
        position: relative; overflow: hidden;
        border: 1px solid var(--brand-md); box-shadow: var(--card-sh);
    }
    .spons-bg {
        position: absolute; bottom: 0; left: 0; right: 0; height: 110px;
        background-image: url('https://images.unsplash.com/photo-1502472584811-0a2f2feb8968?w=800&q=60');
        background-size: cover; background-position: bottom center;
        opacity: .12; mask-image: linear-gradient(to top,black,transparent);
        -webkit-mask-image: linear-gradient(to top,black,transparent);
        pointer-events: none;
    }
    .spons-sun {
        position: absolute; top: 52%; right: 56px; width: 22px; height: 22px;
        background: var(--orange); border-radius: 50%; opacity: .65;
        box-shadow: 0 0 12px rgba(239,125,0,.55); pointer-events: none;
        animation: floatY 3.5s ease-in-out infinite;
    }
    .spons-table { width: 100%; border-collapse: collapse; position: relative; z-index: 1; }
    .spons-table tr { border-bottom: 1px solid var(--brand-md); }
    .spons-table tr:last-child { border-bottom: none; }
    .spons-table td { padding: 10px 0; font-size: 13.5px; }
    .spons-table td:first-child { color: var(--muted); font-weight: 500; }
    .spons-table td:last-child  { text-align: right; font-weight: 700; color: var(--dark); }
    .manage-link {
        color: var(--orange); font-weight: 700; font-size: 13px;
        display: inline-flex; align-items: center; gap: 5px;
        text-decoration: none; margin-top: 14px; position: relative; z-index: 1; transition: color .18s;
    }
    .manage-link:hover { color: #d97000; }

    /* ── DOCUMENTS ── */
    .doc-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 10px 10px 0; transition: all .18s; border-radius: 10px;
        cursor: pointer;
    }
    .doc-item:hover { background: var(--brand-lt); padding-left: 10px; }
    .doc-item + .doc-item { border-top: 1px solid var(--border); }
    .doc-icon {
        width: 36px; height: 36px; border-radius: 9px; background: #fee2e2;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .doc-icon i { color: #ef4444; font-size: 14px; }
    .doc-info { flex: 1; min-width: 0; }
    .doc-name { font-size: 13px; font-weight: 700; color: var(--dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .doc-meta { font-size: 11px; color: var(--muted); margin-top: 1px; }
    .doc-dl {
        width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0;
        background: #f3f2ee; color: var(--muted);
        display: flex; align-items: center; justify-content: center;
        text-decoration: none; transition: all .18s; font-size: 11px;
    }
    .doc-dl:hover { background: var(--orange); color: #fff; transform: scale(1.1); }

    /* ── MEDIA GRID ── */
    .media-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 9px; }
    .m-thumb {
        aspect-ratio: 1; border-radius: 12px; overflow: hidden; cursor: pointer;
        position: relative; background: #f8f7f3;
        transition: transform .25s, box-shadow .25s;
    }
    .m-thumb:hover { transform: scale(1.04); box-shadow: 0 8px 22px rgba(0,0,0,.14); }
    .m-thumb img,.m-thumb video { width:100%;height:100%;object-fit:cover;pointer-events:none;display:block; }
    .m-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,.28);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity .2s;
    }
    .m-thumb:hover .m-overlay { opacity: 1; }
    .m-play {
        width: 38px; height: 38px; background: rgba(255,255,255,.92); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 14px rgba(0,0,0,.22); transition: transform .18s;
    }
    .m-play i { color: var(--orange); font-size: 13px; }
    .m-thumb:hover .m-play { transform: scale(1.12); }
    .m-vid-tag {
        position: absolute; top: 6px; left: 6px; z-index: 2;
        background: rgba(0,0,0,.7); color: #fff; font-size: 9px; font-weight: 800;
        padding: 2px 6px; border-radius: 5px; display: flex; align-items: center; gap: 3px;
    }
    .m-caption {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: linear-gradient(transparent,rgba(0,0,0,.6));
        color: #fff; font-size: 9px; padding: 12px 7px 5px;
        pointer-events: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    /* ── FAMILY MINI ── */
    .fam-mini {
        display: flex; align-items: center; gap: 12px;
        background: #fff7e6; border: 1.5px solid #fcd34d; border-radius: 14px;
        padding: 12px 14px; margin-bottom: 12px; transition: all .18s;
    }
    .fam-mini:hover { background: #fef3c7; border-color: #fbbf24; }
    .fam-mini-photo { width:44px;height:44px;border-radius:10px;object-fit:cover;border: 2px solid #fbbf24;flex-shrink:0; }
    .fam-mini-icon { width:44px;height:44px;border-radius:10px;background: #fef3c7;display:flex;align-items:center;justify-content:center;flex-shrink:0; }

    /* ── FOOTER BANNER ── */
    .footer-banner {
        border-radius: 22px; overflow: hidden; position: relative;
        min-height: 180px; margin-top: 32px; cursor: pointer;
    }
    .footer-banner-bg {
        position: absolute; inset: 0; background-size: cover; background-position: center;
        transition: transform .5s ease;
    }
    .footer-banner:hover .footer-banner-bg { transform: scale(1.03); }
    .footer-banner-overlay {
       position: absolute; inset: 0;
    background: linear-gradient(90deg, rgba(249,115,22,.92) 0%, rgba(249,115,22,.65) 35%, rgba(249,115,22,.15) 100%);
    }
    .footer-banner-content {
        position: relative; z-index: 1; display: flex; align-items: center;
        padding: 36px 40px; gap: 20px; min-height: 180px;
    }
    .footer-banner-content .fbc-icon { font-size: 36px; color: rgba(255,255,255,.8); flex-shrink: 0; transition: transform .3s; }
    .footer-banner:hover .fbc-icon { transform: scale(1.12); }
    .fbc-text h2 { font-family: 'Lora',serif; font-size: 28px; color: #fff; margin-bottom: 8px; line-height: 1.3; }
    .fbc-text p { color: rgba(255,255,255,.75); font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 6px; }

    /* ── LIGHTBOX ── */
    #lightbox { display: none; }
    #lightbox.open { display: flex; animation: fadeIn .2s ease both; }

    /* ── MOBILE BOTTOM NAV ── */
    .mob-bar {
        display: none;
        position: fixed; bottom: 0; left: 0; right: 0;
        background: rgba(255,255,255,.97);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-top: 1px solid var(--border);
        padding: 8px 20px calc(8px + env(safe-area-inset-bottom));
        z-index: 190;
        box-shadow: 0 -4px 24px rgba(0,0,0,.08);
        gap: 4px;
        align-items: stretch;
        justify-content: space-around;
    }
    .mob-nav-item {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 3px; flex: 1; padding: 6px 4px;
        color: var(--muted); font-size: 9.5px; font-weight: 700;
        text-decoration: none; border-radius: 10px;
        transition: color .18s, background .18s;
        letter-spacing: .02em; text-transform: uppercase;
    }
    .mob-nav-item i { font-size: 17px; }
    .mob-nav-item:hover, .mob-nav-item.active { color: var(--brand); background: var(--brand-lt); }
    .mob-nav-logout {
        background: none; border: none; cursor: pointer; font-family: inherit;
        flex: 1;
    }

    /* ── RESPONSIVE ── */
    @media (max-width:1024px) {
        .hero-grid { grid-template-columns: 220px 1fr 260px; }
        .c-grid { grid-template-columns: 1fr; }
    }
    @media (max-width:860px) {
        .hero-grid { grid-template-columns: 1fr 1fr; gap: 16px; }
        .hero-portrait { grid-column: 1; grid-row: 1; aspect-ratio: 3/4; max-height: 340px; }
        .impact-card { grid-column: 2; grid-row: 1; }
        .hero-info-col { justify-content: flex-start !important; padding-top: 8px; }
        .hdr-nav { display: none; }
    }
    @media (max-width:640px) {
        .hero-grid { grid-template-columns: 1fr; gap: 16px; }
        .hero-portrait { aspect-ratio: 16/10; max-height: 260px; border-radius: 18px; grid-column: 1; grid-row: 1; }
        .hero-info-col { justify-content: flex-start !important; padding-top: 8px; }
        .impact-card { grid-column: 1; grid-row: 3; padding: 20px; }
        .entity-tabs { flex-wrap: nowrap; overflow-x: auto; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; padding-bottom: 6px; gap: 10px; margin-left: -14px; margin-right: -14px; padding-left: 14px; padding-right: 14px; }
        .entity-tabs::-webkit-scrollbar { display: none; }
        .entity-tab { flex: 0 0 auto; scroll-snap-align: start; min-width: 160px; }
        .year-bar { margin-left: -14px; margin-right: -14px; padding-left: 14px; padding-right: 14px; }
        .wcard { padding: 18px 16px; }
        .spons-card { padding: 18px 16px; }
        .hero-name { font-size: 32px; margin-bottom: 16px; }
        .hero-info-main { font-size: 14px; }
        .hero-info-sub { font-size: 12px; }
        .hero-info-list { gap: 12px; }
        .hero-info-icon { font-size: 13px; }
        .since-badge { font-size: 12px; }
        .quote-card { padding: 14px 16px; }
        .quote-text { font-size: 13px; }
        .pw { padding: 18px 14px 100px; }
        .mob-bar { display: flex; }
        .sponsor-chip { display: none !important; }
        .header-inner { padding: 0 14px; height: 60px; }
        .hdr-logo { height: 46px; }
        .media-grid, .photo-gallery { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .footer-banner { min-height: 200px; margin-top: 24px; }
        .footer-banner-content { flex-direction: column; align-items: flex-start; gap: 12px; padding: 24px 20px; }
        .fbc-text h2 { font-size: 20px; }
        .fbc-icon { font-size: 28px !important; }
        .site-footer-inner { flex-direction: column; gap: 16px; text-align: center; }
        .site-footer-links { justify-content: center; flex-wrap: wrap; gap: 12px; }
        .site-footer-socials { justify-content: center; }
        .tl-thumb { width: 52px; height: 52px; }
        .spons-table td { font-size: 12.5px; }
        /* notification panel on mobile */
        .notif-panel { width: calc(100vw - 28px); right: -14px; }
    }
    @media (max-width:400px) {
        .entity-tab { padding: 9px 12px; font-size: 12px; min-width: 140px; }
        .hero-name { font-size: 28px; }
        .impact-title { font-size: 19px; }
        .wcard { padding: 16px 14px; }
    }
    @media (hover:none) {
        .gallery-item:active { transform: scale(.96); }
        .m-thumb:active { transform: scale(.96); }
        .entity-tab:active { transform: translateY(-1px); }
    }
    </style>
</head>
<body>

{{-- ════════════════════ HEADER ════════════════════ --}}
<header class="site-header">
    <div class="header-inner">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" class="hdr-logo" alt="{{ $settings['site_name'] ?? 'Logo' }}">
        </a>

        <nav class="hdr-nav">
            <a href="{{ route('sponsor.dashboard') }}" class="hdr-nav-link active">
                <i class="fas fa-user-friends" style="font-size:12px"></i> My Child
            </a>
            <a href="{{ route('sponsor.messages.home') ?? '#' }}" class="hdr-nav-link">
                <i class="far fa-envelope" style="font-size:12px"></i> Messages
            </a>
            <a href="{{ route('support.donate') }}" class="hdr-nav-link">
                <i class="fas fa-hand-holding-heart" style="font-size:12px"></i> Sponsorship
            </a>
            <a href="{{ route('home') }}" class="hdr-nav-link">
                <i class="far fa-newspaper" style="font-size:12px"></i> News
            </a>
        </nav>

        <div class="hdr-right">

            {{-- Language --}}
            <div style="position:relative" id="dash-translate-wrapper">
                <div id="google_translate_element" style="display:none;position:absolute"></div>
                <button class="lang-pill" onclick="dashTogglePanel()" id="dash-translate-toggle">
                    <img src="https://flagcdn.com/w40/fr.png" id="dash-flag" style="width:20px;height:13px;border-radius:2px;object-fit:cover" alt="">
                    <span id="dash-lang-label">FR</span>
                    <i class="fas fa-chevron-down" style="font-size:8px;color:#9ca3af;transition:transform .2s" id="dash-caret"></i>
                </button>
                <div id="dash-translate-panel">
                    <p style="font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:.08em;padding:4px 4px 8px;display:flex;align-items:center;gap:6px">
                        <i class="fas fa-globe" style="color:var(--orange)"></i> Language
                    </p>
                    <button class="lang-opt" id="dash-btn-en" onclick="dashSwitchLang('en')">
                        <img src="https://flagcdn.com/w40/us.png" class="flag" alt="">
                        <div><div style="font-weight:700">English</div><div style="font-size:10px;color:#9ca3af">Original</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-en"></i>
                    </button>
                    <button class="lang-opt" id="dash-btn-fr" onclick="dashSwitchLang('fr')">
                        <img src="https://flagcdn.com/w40/fr.png" class="flag" alt="">
                        <div><div style="font-weight:700">Français</div><div style="font-size:10px;color:#9ca3af">French</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-fr"></i>
                    </button>
                    <button class="lang-opt" id="dash-btn-km" onclick="dashSwitchLang('km')">
                        <img src="https://flagcdn.com/w40/kh.png" class="flag" alt="">
                        <div><div style="font-weight:700">ខ្មែរ</div><div style="font-size:10px;color:#9ca3af">Cambodian</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-km"></i>
                    </button>
                </div>
            </div>

            {{-- ── NOTIFICATION BELL ── --}}
            @php
                $allUpdates = collect();
                foreach($children as $child) {
                    foreach($child->updates as $u) {
                        $allUpdates->push([
                            'type'     => 'child',
                            'name'     => $child->first_name,
                            'photo'    => $child->profile_photo,
                            'upd_type' => $u->type ?? 'general',
                            'title'    => $u->title ?? '',
                            'content'  => $u->content,
                            'date'     => \Carbon\Carbon::parse($u->report_date ?? $u->created_at),
                            'sort'     => \Carbon\Carbon::parse($u->report_date ?? $u->created_at)->timestamp,
                        ]);
                    }
                }
                foreach($families as $family) {
                    foreach($family->updates as $u) {
                        $allUpdates->push([
                            'type'     => 'family',
                            'name'     => Str::words($family->name, 1, ''),
                            'photo'    => $family->profile_photo,
                            'upd_type' => $u->type ?? 'general',
                            'title'    => $u->title ?? '',
                            'content'  => $u->content,
                            'date'     => \Carbon\Carbon::parse($u->report_date ?? $u->created_at),
                            'sort'     => \Carbon\Carbon::parse($u->report_date ?? $u->created_at)->timestamp,
                        ]);
                    }
                }
                $allUpdates = $allUpdates->sortByDesc('sort')->take(8)->values();

                $allDocs = collect();
                foreach($children as $child) {
                    foreach($child->documents as $d) {
                        $allDocs->push([
                            'entity'  => 'child',
                            'name'    => $child->first_name,
                            'title'   => $d->title,
                            'date'    => $d->document_date ? \Carbon\Carbon::parse($d->document_date) : $d->created_at,
                            'sort'    => ($d->document_date ? \Carbon\Carbon::parse($d->document_date) : $d->created_at)->timestamp,
                            'dl_url'  => route('sponsor.download', ['type' => 'document', 'id' => $d->id]),
                        ]);
                    }
                }
                foreach($families as $family) {
                    foreach($family->documents as $d) {
                        $allDocs->push([
                            'entity'  => 'family',
                            'name'    => Str::words($family->name, 1, ''),
                            'title'   => $d->title,
                            'date'    => $d->document_date ? \Carbon\Carbon::parse($d->document_date) : $d->created_at,
                            'sort'    => ($d->document_date ? \Carbon\Carbon::parse($d->document_date) : $d->created_at)->timestamp,
                            'dl_url'  => route('sponsor.download', ['type' => 'family_document', 'id' => $d->id]),
                        ]);
                    }
                }
                $allDocs    = $allDocs->sortByDesc('sort')->take(6)->values();
                $notifTotal = $allUpdates->count() + $allDocs->count();
            @endphp

            <div style="position:relative" id="notif-wrapper">
                <button class="notif-btn" onclick="toggleNotif()" id="notif-btn" aria-label="Notifications">
                    <i class="far fa-bell"></i>
                    @if($notifTotal > 0)
                    <span class="notif-badge">{{ $notifTotal > 9 ? '9+' : $notifTotal }}</span>
                    @endif
                </button>

                <div class="notif-panel" id="notif-panel">

                    {{-- Header --}}
                    <div class="notif-header">
                        <div class="notif-title-row">
                            <span style="font-size:14px;font-weight:700;font-family:'Lora',serif;color:var(--dark)">Notifications</span>
                            <button onclick="markAllRead()" style="font-size:11px;color:var(--orange);font-weight:700;background:none;border:none;cursor:pointer;font-family:inherit;padding:0">Mark all read</button>
                        </div>
                        <div class="notif-tabs">
                            <button class="ntab active" id="ntab-updates" onclick="switchNotifTab('updates')">
                                <i class="fas fa-bell" style="font-size:10px"></i> Updates
                                <span class="ntab-count">{{ $allUpdates->count() }}</span>
                            </button>
                            <button class="ntab" id="ntab-docs" onclick="switchNotifTab('docs')">
                                <i class="far fa-folder" style="font-size:10px"></i> Documents
                                <span class="ntab-count">{{ $allDocs->count() }}</span>
                            </button>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="notif-body">

                        {{-- Updates pane --}}
                        <div class="notif-pane active" id="npane-updates">
                            @forelse($allUpdates as $i => $upd)
                            <div class="nitem {{ $i < 3 ? 'unread' : '' }}">
                                <div class="nitem-icon {{ $upd['type'] }}">
                                    <i class="fas {{ $upd['type'] === 'family' ? 'fa-home' : 'fa-child' }}"></i>
                                </div>
                                <div class="nitem-content">
                                    <div class="nitem-meta">
                                        <span class="type-badge badge-{{ $upd['upd_type'] }}">{{ $upd['upd_type'] }}</span>
                                        <span class="nitem-entity">{{ $upd['name'] }}</span>
                                        <span class="nitem-date">· {{ $upd['date']->format('M d, Y') }}</span>
                                    </div>
                                    @if($upd['title'])
                                    <div class="nitem-title">{{ $upd['title'] }}</div>
                                    @endif
                                    <div class="nitem-text">{{ $upd['content'] }}</div>
                                </div>
                                @if($i < 3)<div class="nitem-dot"></div>@endif
                            </div>
                            @empty
                            <div style="text-align:center;padding:32px 16px;color:var(--muted);font-size:13px">
                                <i class="far fa-bell-slash" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4"></i>
                                No updates yet.
                            </div>
                            @endforelse
                        </div>

                        {{-- Documents pane --}}
                        <div class="notif-pane" id="npane-docs">
                            @forelse($allDocs as $doc)
                            <div class="nitem" style="align-items:center">
                                <div class="nitem-icon doc">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="nitem-content">
                                    <div class="nitem-title">{{ $doc['title'] }}</div>
                                    <div style="font-size:11px;color:var(--muted);font-weight:600;margin-top:2px">
                                        PDF · {{ $doc['name'] }} · {{ $doc['date']->format('M Y') }}
                                    </div>
                                </div>
                                <a href="{{ $doc['dl_url'] }}" class="nitem-dl" download onclick="event.stopPropagation()" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                            @empty
                            <div style="text-align:center;padding:32px 16px;color:var(--muted);font-size:13px">
                                <i class="far fa-folder-open" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4"></i>
                                No documents yet.
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="notif-footer">
                        <a href="{{ route('sponsor.dashboard') }}">
                            View all on dashboard <i class="fas fa-chevron-down" style="font-size:9px"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Sponsor chip --}}
            <div class="sponsor-chip hidden md:flex">
                <div class="s-avatar">{{ strtoupper(substr($sponsor->first_name,0,1)) }}</div>
                <div>
                    <div class="s-name">{{ $sponsor->full_name }}</div>
                    <div class="s-email">{{ $sponsor->email }}</div>
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

{{-- ════════════════════ PAGE BODY ════════════════════ --}}
<div class="pw">

    @php $totalEntities = $families->count() + $children->count(); @endphp

    {{-- ── Entity Selector (only if multiple) ── --}}
    @if($totalEntities > 1)
    <div class="entity-tabs anim-up" id="entity-tabs">
        @foreach($families as $fi => $family)
        @php $eidx = $fi; @endphp
        <div class="entity-tab {{ $eidx===0?'active':'' }} sd{{ ($eidx%6)+1 }}"
             id="tab-{{ $eidx }}" onclick="selectEntity({{ $eidx }})">
            @if($family->profile_photo)
                <img src="{{ $family->profile_photo_url ?? asset($family->profile_photo) }}" alt="">
            @else
                <div class="et-icon"><i class="fas fa-home"></i></div>
            @endif
            <div>
                <div style="font-size:13px;font-weight:800;color:inherit">{{ $family->name }}</div>
                <div style="font-size:10px;font-weight:500;opacity:.7;margin-top:1px">Family</div>
            </div>
        </div>
        @endforeach
        @foreach($children as $ci => $child)
        @php $eidx = $families->count()+$ci; @endphp
        <div class="entity-tab {{ ($totalEntities===1||$eidx===0)?'active':'' }} sd{{ ($eidx%6)+1 }}"
             id="tab-{{ $eidx }}" onclick="selectEntity({{ $eidx }})">
            @if($child->profile_photo)
                <img src="{{ asset($child->profile_photo) }}" alt="">
            @else
                <div class="et-icon"><i class="fas fa-child"></i></div>
            @endif
            <div>
                <div style="font-size:13px;font-weight:800;color:inherit">{{ $child->first_name }}</div>
                <div style="font-size:10px;font-weight:500;opacity:.7;margin-top:1px">Child</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ══════════════════════════════════
         FAMILY PANELS
    ══════════════════════════════════ --}}
    @foreach($families as $fi => $family)
    @php
        $eidx   = $fi;
        $pid    = "panel-{$eidx}";
        $fYears = collect();
        foreach($family->updates   as $u){ $fYears->push(\Carbon\Carbon::parse($u->report_date??$u->created_at)->year); }
        foreach($family->media     as $m){ $fYears->push($m->created_at->year); }
        foreach($family->documents as $d){ $fYears->push($d->created_at->year); }
        $fYears = $fYears->unique()->sortDesc()->values();
        $latestUpdate = $family->updates->sortByDesc('report_date')->first();
        $sponsorSince = $family->created_at ? $family->created_at->format('M d, Y') : null;
    @endphp
    <div class="entity-panel {{ ($totalEntities===1||$eidx===0)?'active':'' }}" id="{{ $pid }}">

        {{-- ── HERO ── --}}
        <div class="hero-grid anim-up">
            <div class="hero-portrait">
                @if($family->profile_photo)
                    <img src="{{ $family->profile_photo_url ?? asset($family->profile_photo) }}" alt="{{ $family->name }}">
                @else
                    <div class="hero-portrait-placeholder"><i class="fas fa-home"></i></div>
                @endif
            </div>

            <div class="hero-info-col anim-left d2" style="display:flex;flex-direction:column;justify-content:flex-start;padding-top:8px;">
                @if($sponsorSince)
                <div class="since-badge">
                    <i class="fas fa-leaf" style="color:var(--brand);font-size:12px"></i>
                    Sponsorship since {{ $sponsorSince }}
                </div>
                @endif
                <h1 class="hero-name">{{ $family->name }}</h1>
                <ul class="hero-info-list">
                    @if($family->country)
                    <li class="hero-info-item">
                        <i class="fas fa-map-marker-alt hero-info-icon"></i>
                        <div>
                            <div class="hero-info-main">{{ $family->country }}</div>
                            @if($family->city)<div class="hero-info-sub">{{ $family->city }}</div>@endif
                        </div>
                    </li>
                    @endif
                    @if($family->code)
                    <li class="hero-info-item">
                        <i class="fas fa-hashtag hero-info-icon"></i>
                        <div><div class="hero-info-main" style="font-family:monospace;font-size:13px">{{ $family->code }}</div></div>
                    </li>
                    @endif
                </ul>
                @if($latestUpdate && $latestUpdate->content)
                <div class="quote-card anim-in d4">
                    <div class="qq">"</div>
                    <p class="quote-text" style="margin-top:-6px">{{ Str::limit($latestUpdate->content, 140) }}</p>
                    <i class="far fa-heart quote-heart"></i>
                </div>
                @endif
            </div>

            <div class="impact-card anim-sc d3">
                <div class="impact-icon-wrap" style="animation:floatY 3s ease-in-out infinite">
                    <i class="fas fa-mountain-sun"></i>
                </div>
                <h3 class="impact-title">Your impact</h3>
                <p class="impact-sub">Thanks to your support, {{ Str::words($family->name,1,'') }} benefits from:</p>
                <ul class="impact-list">
                    <li style="animation-delay:.1s"><i class="fas fa-check-circle"></i> Quality care & support</li>
                    <li style="animation-delay:.2s"><i class="fas fa-check-circle"></i> Housing stability</li>
                    <li style="animation-delay:.3s"><i class="fas fa-check-circle"></i> Health check-ups</li>
                    <li style="animation-delay:.4s"><i class="fas fa-check-circle"></i> Nutritious meals</li>
                    <li style="animation-delay:.5s"><i class="fas fa-check-circle"></i> A safe environment</li>
                </ul>
                <a href="mailto:asso.desailespourgrandir@gmail.com?subject=Message about {{ urlencode($family->name) }}" class="btn-orange">
                    Write to family <i class="far fa-paper-plane"></i>
                </a>
            </div>
        </div>

        {{-- ── YEAR BAR ── --}}
        @if($fYears->isNotEmpty())
        <div class="year-bar reveal">
            <span class="year-lbl">Year:</span>
            <button class="y-pill active" data-panel="{{ $pid }}" data-year="latest" onclick="switchYear('{{ $pid }}','latest')">
                <i class="fas fa-star" style="font-size:9px;margin-right:4px"></i> Latest
            </button>
            @foreach($fYears as $yr)
            <button class="y-pill" data-panel="{{ $pid }}" data-year="{{ $yr }}" onclick="switchYear('{{ $pid }}','{{ $yr }}')">{{ $yr }}</button>
            @endforeach
        </div>
        @endif

        {{-- ── LATEST ── --}}
        <div class="y-sec active" data-panel="{{ $pid }}" data-section="latest">
            <div class="c-grid">
                <div>
                    <div class="wcard reveal reveal-l">
                        <h3 class="wcard-title"><i class="far fa-user" style="color:var(--muted)"></i> About {{ Str::words($family->name,1,'') }}</h3>
                        @if($family->description ?? null)
                        <p class="about-text">{{ $family->description }}</p>
                        @else
                        <p class="about-text">{{ $family->story }}</p>
                        @endif
                        @php $galleryMedia = $family->media->where('type','photo')->take(5); @endphp
                        @if($galleryMedia->isNotEmpty())
                        <div class="photo-gallery">
                            @foreach($galleryMedia as $gm)
                            <div class="gallery-item reveal-s sd{{ ($loop->index%3)+1 }}"
                                 onclick="openLightbox('{{ asset($gm->file_path) }}','image','{{ addslashes($gm->caption??"") }}','{{ route("sponsor.download",["type"=>"family_media","id"=>$gm->id]) }}')">
                                <img src="{{ asset($gm->file_path) }}" alt="{{ $gm->caption ?? '' }}">
                            </div>
                            @endforeach
                            <div class="gallery-item view-all" onclick="switchYear('{{ $pid }}','{{ $fYears->first() ?? "latest" }}')">
                                <i class="fas fa-camera"></i>
                                <span>View all<br>photos</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="wcard reveal" style="margin-top:16px">
                        <h3 class="wcard-title">
                            <span style="width:24px;height:24px;border-radius:50%;background:var(--brand-lt);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fas fa-check" style="font-size:10px;color:var(--brand)"></i>
                            </span>
                            Latest updates
                            <span class="wc-badge" style="background:var(--brand-lt);color:var(--brand)">{{ $family->updates->count() }}</span>
                        </h3>
                        @if($family->updates->isNotEmpty())
                        <div class="timeline">
                            @foreach($family->updates->sortByDesc('report_date')->take(3) as $upd)
                            <div class="tl-item">
                                <div class="tl-dot">
                                    <i class="far {{ $upd->type==='health'?'fa-heart':($upd->type==='education'?'fa-graduation-cap':'fa-user') }}"></i>
                                </div>
                                <div class="tl-row">
                                    <div class="tl-content">
                                        <div class="tl-date">
                                            @if($upd->type)<span class="type-badge badge-{{ $upd->type }}">{{ $upd->type }}</span>@endif
                                            {{ \Carbon\Carbon::parse($upd->report_date??$upd->created_at)->format('M d, Y') }}
                                        </div>
                                        @if($upd->title)<div style="font-size:13px;font-weight:700;color:var(--dark);margin-bottom:3px">{{ $upd->title }}</div>@endif
                                        <div class="tl-text">{{ Str::limit($upd->content, 120) }}</div>
                                    </div>
                                    @php $upMedia = $family->media->where('type','photo')->first(); @endphp
                                    @if($upMedia)
                                    <img src="{{ asset($upMedia->file_path) }}" class="tl-thumb"
                                         onclick="openLightbox('{{ asset($upMedia->file_path) }}','image','','{{ route("sponsor.download",["type"=>"family_media","id"=>$upMedia->id]) }}')" alt="">
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('sponsor.family.stories') }}" class="see-all-link">See all updates <i class="fas fa-chevron-right" style="font-size:10px"></i></a>
                        @else
                        <p style="text-align:center;color:var(--muted);font-size:13px;padding:24px 0">No updates yet.</p>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="spons-card reveal reveal-r">
                        <div class="spons-sun"></div>
                        <h3 class="wcard-title" style="position:relative;z-index:1;margin-bottom:16px">
                            <span style="width:26px;height:26px;border-radius:50%;background:var(--brand);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fas fa-leaf" style="font-size:10px;color:#fff"></i>
                            </span>
                            Sponsorship details
                        </h3>
                        <table class="spons-table">
                            <tr><td>Start date</td><td>{{ $family->created_at ? $family->created_at->format('M d, Y') : '—' }}</td></tr>
                            <tr><td>Type</td><td>Family</td></tr>
                            @if($family->country)<tr><td>Location</td><td>{{ $family->country }}</td></tr>@endif
                            <tr><td>Documents</td><td>{{ $family->documents->count() }}</td></tr>
                            <tr><td>Media files</td><td>{{ $family->media->count() }}</td></tr>
                        </table>
                        <a href="{{ route('support.donate') }}" class="manage-link">
                            Manage my sponsorship <i class="fas fa-chevron-right" style="font-size:10px"></i>
                        </a>
                        <div class="spons-bg"></div>
                    </div>

                    <div class="wcard reveal reveal-r" style="margin-top:16px">
                        <h3 class="wcard-title">
                            <i class="far fa-folder" style="color:var(--muted)"></i> Documents
                        </h3>
                        <p style="font-size:12px;color:var(--muted);margin-bottom:16px">Access letters and documents related to this family's sponsorship.</p>
                        @forelse($family->documents->sortByDesc('created_at')->take(4) as $doc)
                        <div class="doc-item">
                            <div class="doc-icon"><i class="fas fa-file-pdf"></i></div>
                            <div class="doc-info">
                                <div class="doc-name">{{ $doc->title }}</div>
                                <div class="doc-meta">PDF @if($doc->document_date) · {{ \Carbon\Carbon::parse($doc->document_date)->format('M Y') }}@endif</div>
                            </div>
                            <a href="{{ route('sponsor.download',['type'=>'family_document','id'=>$doc->id]) }}" class="doc-dl" download>
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                        @empty
                        <p style="text-align:center;color:var(--muted);font-size:13px;padding:16px 0">No documents yet.</p>
                        @endforelse
                        @if($family->documents->count() > 4)
                        <a href="{{ route('sponsor.family.file') }}" class="see-all-link" style="margin-top:12px">
                            View all documents <i class="fas fa-chevron-right" style="font-size:10px"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ── YEAR SECTIONS ── --}}
        @foreach($fYears as $yr)
        @php
            $yUpd    = $family->updates->filter(fn($u)=>\Carbon\Carbon::parse($u->report_date??$u->created_at)->year==$yr)->sortByDesc('report_date');
            $yMedia  = $family->media->filter(fn($m)=>$m->created_at->year==$yr)->sortByDesc('created_at');
            $yDocs   = $family->documents->filter(fn($d)=>$d->created_at->year==$yr)->sortByDesc('created_at');
            $yPhotos = $yMedia->where('type','photo');
            $yVideos = $yMedia->where('type','video');
        @endphp
        <div class="y-sec" data-panel="{{ $pid }}" data-section="{{ $yr }}">
            <div class="c-grid">
                <div>
                    @if($yUpd->isNotEmpty())
                    <div class="wcard">
                        <h3 class="wcard-title"><span style="width:24px;height:24px;border-radius:50%;background:var(--brand-lt);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-check" style="font-size:10px;color:var(--brand)"></i></span> Updates · {{ $yr }} <span class="wc-badge" style="background:var(--brand-lt);color:var(--brand)">{{ $yUpd->count() }}</span></h3>
                        <div class="timeline">
                            @foreach($yUpd as $upd)
                            <div class="tl-item">
                                <div class="tl-dot"><i class="far fa-user"></i></div>
                                <div class="tl-row">
                                    <div class="tl-content">
                                        <div class="tl-date">@if($upd->type)<span class="type-badge badge-{{ $upd->type }}">{{ $upd->type }}</span>@endif {{ \Carbon\Carbon::parse($upd->report_date??$upd->created_at)->format('M d, Y') }}</div>
                                        @if($upd->title)<div style="font-size:13px;font-weight:700;color:var(--dark);margin-bottom:3px">{{ $upd->title }}</div>@endif
                                        <div class="tl-text">{{ $upd->content }}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($yPhotos->isNotEmpty())
                    <div class="wcard" style="margin-top:16px">
                        <h3 class="wcard-title"><i class="fas fa-images" style="color:#3b82f6"></i> Photos · {{ $yr }} <span class="wc-badge" style="background:#dbeafe;color:#1e40af">{{ $yPhotos->count() }}</span></h3>
                        <div class="media-grid">
                            @foreach($yPhotos as $p)
                            <div class="m-thumb" onclick="openLightbox('{{ asset($p->file_path) }}','image','{{ addslashes($p->caption??"") }}','{{ route("sponsor.download",["type"=>"family_media","id"=>$p->id]) }}')">
                                <img src="{{ asset($p->file_path) }}" alt="">
                                <div class="m-overlay"><div class="m-play"><i class="fas fa-expand"></i></div></div>
                                @if($p->caption)<div class="m-caption">{{ $p->caption }}</div>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($yVideos->isNotEmpty())
                    <div class="wcard" style="margin-top:16px">
                        <h3 class="wcard-title"><i class="fas fa-video" style="color:#9333ea"></i> Videos · {{ $yr }} <span class="wc-badge" style="background:#e9d5ff;color:#7c3aed">{{ $yVideos->count() }}</span></h3>
                        <div class="media-grid">
                            @foreach($yVideos as $v)
                            <div class="m-thumb" style="aspect-ratio:16/9" onclick="openLightbox('{{ asset($v->file_path) }}','video','{{ addslashes($v->caption??"") }}','{{ route("sponsor.download",["type"=>"family_media","id"=>$v->id]) }}')">
                                <video src="{{ asset($v->file_path) }}" muted playsinline></video>
                                <div class="m-vid-tag"><i class="fas fa-play" style="font-size:7px"></i> VIDEO</div>
                                <div class="m-overlay" style="opacity:1;background:rgba(0,0,0,.35)"><div class="m-play"><i class="fas fa-play" style="margin-left:2px"></i></div></div>
                                @if($v->caption)<div class="m-caption">{{ $v->caption }}</div>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($yUpd->isEmpty()&&$yPhotos->isEmpty()&&$yVideos->isEmpty())
                    <div class="wcard" style="text-align:center;padding:48px"><i class="fas fa-calendar" style="font-size:36px;color:#e2e8f0;display:block;margin-bottom:10px"></i><p style="color:var(--muted);font-size:14px">No content for {{ $yr }}.</p></div>
                    @endif
                </div>
                <div>
                    <div class="wcard">
                        <h3 class="wcard-title"><i class="far fa-folder" style="color:var(--muted)"></i> Documents · {{ $yr }} @if($yDocs->isNotEmpty())<span class="wc-badge" style="background:#fef9c3;color:#854d0e">{{ $yDocs->count() }}</span>@endif</h3>
                        @forelse($yDocs as $doc)
                        <div class="doc-item"><div class="doc-icon"><i class="fas fa-file-pdf"></i></div><div class="doc-info"><div class="doc-name">{{ $doc->title }}</div><div class="doc-meta">PDF @if($doc->document_date) · {{ \Carbon\Carbon::parse($doc->document_date)->format('M Y') }}@endif</div></div><a href="{{ route('sponsor.download',['type'=>'family_document','id'=>$doc->id]) }}" class="doc-dl" download><i class="fas fa-download"></i></a></div>
                        @empty
                        <p style="text-align:center;color:var(--muted);font-size:13px;padding:16px 0">No documents for {{ $yr }}.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    {{-- ══════════════════════════════════
         CHILD PANELS
    ══════════════════════════════════ --}}
    @foreach($children as $ci => $child)
    @php
        $eidx   = $families->count()+$ci;
        $pid    = "panel-{$eidx}";
        $cYears = collect();
        foreach($child->updates   as $u){ $cYears->push(\Carbon\Carbon::parse($u->report_date??$u->created_at)->year); }
        foreach($child->media     as $m){ $cYears->push($m->created_at->year); }
        foreach($child->documents as $d){ $cYears->push($d->created_at->year); }
        $cYears = $cYears->unique()->sortDesc()->values();
        $sponsorSince = $child->sponsor_since ? \Carbon\Carbon::parse($child->sponsor_since)->format('M d, Y') : ($child->created_at ? $child->created_at->format('M d, Y') : null);
        $latestQuote = $child->quote ?? null;
    @endphp
    <div class="entity-panel {{ ($totalEntities===1||$eidx===0)?'active':'' }}" id="{{ $pid }}">

        {{-- ── HERO ── --}}
        <div class="hero-grid anim-up">
            <div class="hero-portrait">
                @if($child->profile_photo)
                    <img src="{{ asset($child->profile_photo) }}" alt="{{ $child->first_name }}">
                @else
                    <div class="hero-portrait-placeholder"><i class="fas fa-child"></i></div>
                @endif
            </div>

            <div class="hero-info-col anim-left d2" style="display:flex;flex-direction:column;justify-content:flex-start;padding-top:8px;">
                @if($sponsorSince)
                <div class="since-badge">
                    <i class="fas fa-leaf" style="color:var(--brand);font-size:12px"></i>
                    Sponsorship since {{ $sponsorSince }}
                </div>
                @endif
                <h1 class="hero-name">{{ $child->first_name }} {{ $child->last_name ? strtoupper(substr($child->last_name,0,1)).'.' : '' }}</h1>
                <ul class="hero-info-list">
                    @if($child->age ?? ($child->date_of_birth ?? null))
                    <li class="hero-info-item">
                        <i class="far fa-calendar hero-info-icon"></i>
                        <div>
                            <div class="hero-info-main">{{ ($child->age ?? null) ? $child->age.' years old' : '' }}</div>
                            @if($child->date_of_birth)<div class="hero-info-sub">Born on {{ \Carbon\Carbon::parse($child->date_of_birth)->format('F d, Y') }}</div>@endif
                        </div>
                    </li>
                    @endif
                    @if($child->gender)
                    <li class="hero-info-item">
                        <i class="fas {{ strtolower($child->gender)==='female'?'fa-venus':'fa-mars' }} hero-info-icon" style="color:{{ strtolower($child->gender)==='female'?'#ec4899':'#3b82f6' }}"></i>
                        <div><div class="hero-info-main">{{ ucfirst($child->gender) }}</div></div>
                    </li>
                    @endif
                    @if($child->country)
                    <li class="hero-info-item">
                        <i class="fas fa-map-marker-alt hero-info-icon"></i>
                        <div>
                            <div class="hero-info-main">{{ $child->province ?? $child->country }}</div>
                            <div class="hero-info-sub">{{ $child->country }}</div>
                        </div>
                    </li>
                    @endif
                    @if($child->code)
                    <li class="hero-info-item">
                        <i class="fas fa-hashtag hero-info-icon"></i>
                        <div><div class="hero-info-main" style="font-family:monospace;font-size:13px">{{ $child->code }}</div></div>
                    </li>
                    @endif
                    @if($child->school_grade ?? ($child->education_level ?? null))
                    <li class="hero-info-item">
                        <i class="fas fa-book-open hero-info-icon"></i>
                        <div>
                            <div class="hero-info-main">{{ $child->school_grade ?? $child->education_level }}</div>
                            @if($child->school_name)<div class="hero-info-sub">{{ $child->school_name }}</div>@endif
                        </div>
                    </li>
                    @endif
                </ul>
                @if($latestQuote)
                <div class="quote-card anim-in d4">
                    <div class="qq">"</div>
                    <p class="quote-text" style="margin-top:-6px">"{{ $latestQuote }}"</p>
                    <i class="far fa-heart quote-heart"></i>
                </div>
                @elseif($child->updates->isNotEmpty())
                @php $firstUpdate = $child->updates->sortByDesc('report_date')->first(); @endphp
                <div class="quote-card anim-in d4">
                    <div class="qq">"</div>
                    <p class="quote-text" style="margin-top:-6px">{{ Str::limit($firstUpdate->content, 140) }}</p>
                    <i class="far fa-heart quote-heart"></i>
                </div>
                @endif
            </div>

            <div class="impact-card anim-sc d3">
                <div class="impact-icon-wrap" style="animation:floatY 3s ease-in-out infinite">
                    <i class="fas fa-mountain-sun"></i>
                </div>
                <h3 class="impact-title">Your impact</h3>
                <p class="impact-sub">Thanks to your support, {{ $child->first_name }} benefits from:</p>
                <ul class="impact-list">
                    <li style="animation-delay:.1s"><i class="fas fa-check-circle"></i> Quality education</li>
                    <li style="animation-delay:.2s"><i class="fas fa-check-circle"></i> School supplies</li>
                    <li style="animation-delay:.3s"><i class="fas fa-check-circle"></i> Health check-ups</li>
                    <li style="animation-delay:.4s"><i class="fas fa-check-circle"></i> Nutritious meals</li>
                    <li style="animation-delay:.5s"><i class="fas fa-check-circle"></i> A safe and supportive environment</li>
                </ul>
                <a href="mailto:asso.desailespourgrandir@gmail.com?subject=Message about {{ urlencode($child->first_name) }}" class="btn-orange">
                    Write to {{ $child->first_name }} <i class="far fa-paper-plane"></i>
                </a>
            </div>
        </div>

        {{-- ── YEAR BAR ── --}}
        @if($cYears->isNotEmpty())
        <div class="year-bar reveal">
            <span class="year-lbl">Year:</span>
            <button class="y-pill active" data-panel="{{ $pid }}" data-year="latest" onclick="switchYear('{{ $pid }}','latest')">
                <i class="fas fa-star" style="font-size:9px;margin-right:4px"></i> Latest
            </button>
            @foreach($cYears as $yr)
            <button class="y-pill" data-panel="{{ $pid }}" data-year="{{ $yr }}" onclick="switchYear('{{ $pid }}','{{ $yr }}')">{{ $yr }}</button>
            @endforeach
        </div>
        @endif

        {{-- ── LATEST ── --}}
        <div class="y-sec active" data-panel="{{ $pid }}" data-section="latest">
            <div class="c-grid">
                <div>
                    <div class="wcard reveal reveal-l">
                        <h3 class="wcard-title"><i class="far fa-user" style="color:var(--muted)"></i> About {{ $child->first_name }}</h3>
                        @if($child->biography ?? ($child->description ?? null))
                        <p class="about-text">{{ $child->biography ?? $child->description }}</p>
                        @else
                        <p class="about-text">{{ $child->story }}</p>
                        @endif
                        @php $galleryPhotos = $child->media->where('type','photo')->take(5); @endphp
                        @if($galleryPhotos->isNotEmpty())
                        <div class="photo-gallery">
                            @foreach($galleryPhotos as $gp)
                            <div class="gallery-item reveal-s sd{{ ($loop->index%3)+1 }}"
                                 onclick="openLightbox('{{ asset($gp->file_path) }}','image','{{ addslashes($gp->caption??"") }}','{{ route("sponsor.download",["type"=>"media","id"=>$gp->id]) }}')">
                                <img src="{{ asset($gp->file_path) }}" alt="">
                            </div>
                            @endforeach
                            <div class="gallery-item view-all" onclick="switchYear('{{ $pid }}','{{ $cYears->first() ?? "latest" }}')">
                                <i class="fas fa-camera"></i>
                                <span>View all<br>photos</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="wcard reveal" style="margin-top:16px">
                        <h3 class="wcard-title">
                            <span style="width:24px;height:24px;border-radius:50%;background:var(--brand-lt);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fas fa-check" style="font-size:10px;color:var(--brand)"></i>
                            </span>
                            Latest updates
                            <span class="wc-badge" style="background:var(--brand-lt);color:var(--brand)">{{ $child->updates->count() }}</span>
                        </h3>
                        @if($child->updates->isNotEmpty())
                        <div class="timeline">
                            @foreach($child->updates->sortByDesc('report_date')->take(3) as $upd)
                            @php $updThumb = $child->media->where('type','photo')->sortByDesc('created_at')->first(); @endphp
                            <div class="tl-item">
                                <div class="tl-dot"><i class="far fa-user"></i></div>
                                <div class="tl-row">
                                    <div class="tl-content">
                                        <div class="tl-date">
                                            @if($upd->type)<span class="type-badge badge-{{ $upd->type }}">{{ $upd->type }}</span>@endif
                                            {{ \Carbon\Carbon::parse($upd->report_date??$upd->created_at)->format('M d, Y') }}
                                        </div>
                                        @if($upd->title)<div style="font-size:13px;font-weight:700;color:var(--dark);margin-bottom:3px">{{ $upd->title }}</div>@endif
                                        <div class="tl-text">{{ Str::limit($upd->content, 120) }}</div>
                                    </div>
                                    @if($updThumb)
                                    <img src="{{ asset($updThumb->file_path) }}" class="tl-thumb"
                                         onclick="openLightbox('{{ asset($updThumb->file_path) }}','image','','{{ route("sponsor.download",["type"=>"media","id"=>$updThumb->id]) }}')" alt="">
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('sponsor.child.stories') }}" class="see-all-link">See all updates <i class="fas fa-chevron-right" style="font-size:10px"></i></a>
                        @else
                        <p style="text-align:center;color:var(--muted);font-size:13px;padding:24px 0">No updates yet.</p>
                        @endif
                    </div>
                </div>

                <div>
                    @if(($child->has_family ?? false) && $child->family)
                    <div class="wcard reveal reveal-r" style="margin-bottom:16px">
                        <h3 class="wcard-title"><i class="fas fa-home" style="color:var(--brand)"></i> Family</h3>
                        <div class="fam-mini">
                            @if($child->family->profile_photo)
                                <img src="{{ asset($child->family->profile_photo) }}" class="fam-mini-photo" alt="">
                            @else
                                <div class="fam-mini-icon"><i class="fas fa-users" style="color:#22c55e;font-size:18px"></i></div>
                            @endif
                            <div style="min-width:0">
                                <div style="font-size:13px;font-weight:800;color:var(--dark);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $child->family->name }}</div>
                                @if($child->family->country)<div style="font-size:11px;color:var(--muted);font-weight:600;margin-top:3px"><i class="fas fa-map-marker-alt" style="color:var(--orange);font-size:9px;margin-right:3px"></i>{{ $child->family->country }}</div>@endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="spons-card reveal reveal-r">
                        <div class="spons-sun"></div>
                        <h3 class="wcard-title" style="position:relative;z-index:1;margin-bottom:16px">
                            <span style="width:26px;height:26px;border-radius:50%;background:var(--brand);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fas fa-leaf" style="font-size:10px;color:#fff"></i>
                            </span>
                            Sponsorship details
                        </h3>
                        <table class="spons-table">
                            @if($sponsorSince)<tr><td>Start date</td><td>{{ $sponsorSince }}</td></tr>@endif
                            <tr><td>Type</td><td>{{ ucfirst($child->sponsorship_type ?? 'Education') }}</td></tr>
                            @if($child->country)<tr><td>Location</td><td>{{ $child->country }}</td></tr>@endif
                            <tr><td>Documents</td><td>{{ $child->documents->count() }}</td></tr>
                            <tr><td>Media files</td><td>{{ $child->media->count() }}</td></tr>
                        </table>
                        <a href="{{ route('sponsor.child.file') }}" class="manage-link">
                            Manage my sponsorship <i class="fas fa-chevron-right" style="font-size:10px"></i>
                        </a>
                        <div class="spons-bg"></div>
                    </div>

                    <div class="wcard reveal reveal-r" style="margin-top:16px">
                        <h3 class="wcard-title"><i class="far fa-folder" style="color:var(--muted)"></i> Documents</h3>
                        <p style="font-size:12px;color:var(--muted);margin-bottom:16px">Access letters and documents<br>related to {{ $child->first_name }}'s sponsorship.</p>
                        @forelse($child->documents->sortByDesc('created_at')->take(4) as $doc)
                        <div class="doc-item">
                            <div class="doc-icon"><i class="fas fa-file-pdf"></i></div>
                            <div class="doc-info">
                                <div class="doc-name">{{ $doc->title }}</div>
                                <div class="doc-meta">PDF @if($doc->document_date) · {{ \Carbon\Carbon::parse($doc->document_date)->format('M Y') }}@endif</div>
                            </div>
                            <a href="{{ route('sponsor.download',['type'=>'document','id'=>$doc->id]) }}" class="doc-dl" download>
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                        @empty
                        <p style="text-align:center;color:var(--muted);font-size:13px;padding:16px 0">No documents yet.</p>
                        @endforelse
                        @if($child->documents->count() > 4)
                        <a href="{{ route('sponsor.child.file') }}" class="see-all-link" style="margin-top:12px">
                            View all documents <i class="fas fa-chevron-right" style="font-size:10px"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ── YEAR SECTIONS ── --}}
        @foreach($cYears as $yr)
        @php
            $yUpd    = $child->updates->filter(fn($u)=>\Carbon\Carbon::parse($u->report_date??$u->created_at)->year==$yr)->sortByDesc('report_date');
            $yMedia  = $child->media->filter(fn($m)=>$m->created_at->year==$yr)->sortByDesc('created_at');
            $yDocs   = $child->documents->filter(fn($d)=>$d->created_at->year==$yr)->sortByDesc('created_at');
            $yPhotos = $yMedia->filter(fn($m)=>in_array($m->type,['image','photo']));
            $yVideos = $yMedia->where('type','video');
        @endphp
        <div class="y-sec" data-panel="{{ $pid }}" data-section="{{ $yr }}">
            <div class="c-grid">
                <div>
                    @if($yUpd->isNotEmpty())
                    <div class="wcard">
                        <h3 class="wcard-title"><span style="width:24px;height:24px;border-radius:50%;background:var(--brand-lt);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-check" style="font-size:10px;color:var(--brand)"></i></span> Updates · {{ $yr }} <span class="wc-badge" style="background:var(--brand-lt);color:var(--brand)">{{ $yUpd->count() }}</span></h3>
                        <div class="timeline">
                            @foreach($yUpd as $upd)
                            <div class="tl-item">
                                <div class="tl-dot"><i class="far fa-user"></i></div>
                                <div class="tl-row">
                                    <div class="tl-content">
                                        <div class="tl-date">@if($upd->type)<span class="type-badge badge-{{ $upd->type }}">{{ $upd->type }}</span>@endif {{ \Carbon\Carbon::parse($upd->report_date??$upd->created_at)->format('M d, Y') }}</div>
                                        @if($upd->title)<div style="font-size:13px;font-weight:700;color:var(--dark);margin-bottom:3px">{{ $upd->title }}</div>@endif
                                        <div class="tl-text">{{ $upd->content }}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($yPhotos->isNotEmpty())
                    <div class="wcard" style="margin-top:16px">
                        <h3 class="wcard-title"><i class="fas fa-images" style="color:#3b82f6"></i> Photos · {{ $yr }} <span class="wc-badge" style="background:#dbeafe;color:#1e40af">{{ $yPhotos->count() }}</span></h3>
                        <div class="media-grid">
                            @foreach($yPhotos as $p)
                            <div class="m-thumb" onclick="openLightbox('{{ asset($p->file_path) }}','image','{{ addslashes($p->caption??"") }}','{{ route("sponsor.download",["type"=>"media","id"=>$p->id]) }}')">
                                <img src="{{ asset($p->file_path) }}" alt=""><div class="m-overlay"><div class="m-play"><i class="fas fa-expand"></i></div></div>@if($p->caption)<div class="m-caption">{{ $p->caption }}</div>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($yVideos->isNotEmpty())
                    <div class="wcard" style="margin-top:16px">
                        <h3 class="wcard-title"><i class="fas fa-video" style="color:#9333ea"></i> Videos · {{ $yr }} <span class="wc-badge" style="background:#e9d5ff;color:#7c3aed">{{ $yVideos->count() }}</span></h3>
                        <div class="media-grid">
                            @foreach($yVideos as $v)
                            <div class="m-thumb" style="aspect-ratio:16/9" onclick="openLightbox('{{ asset($v->file_path) }}','video','{{ addslashes($v->caption??"") }}','{{ route("sponsor.download",["type"=>"media","id"=>$v->id]) }}')">
                                <video src="{{ asset($v->file_path) }}" muted playsinline></video><div class="m-vid-tag"><i class="fas fa-play" style="font-size:7px"></i> VIDEO</div><div class="m-overlay" style="opacity:1;background:rgba(0,0,0,.35)"><div class="m-play"><i class="fas fa-play" style="margin-left:2px"></i></div></div>@if($v->caption)<div class="m-caption">{{ $v->caption }}</div>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($yUpd->isEmpty()&&$yPhotos->isEmpty()&&$yVideos->isEmpty())
                    <div class="wcard" style="text-align:center;padding:48px"><i class="fas fa-calendar" style="font-size:36px;color:#e2e8f0;display:block;margin-bottom:10px"></i><p style="color:var(--muted);font-size:14px">No content for {{ $yr }}.</p></div>
                    @endif
                </div>
                <div>
                    @if(($child->has_family ?? false) && $child->family)
                    <div class="wcard" style="margin-bottom:16px">
                        <h3 class="wcard-title"><i class="fas fa-home" style="color:var(--brand)"></i> Family</h3>
                        <div class="fam-mini">
                            @if($child->family->profile_photo)<img src="{{ asset($child->family->profile_photo) }}" class="fam-mini-photo" alt="">@else<div class="fam-mini-icon"><i class="fas fa-users" style="color:#22c55e;font-size:18px"></i></div>@endif
                            <div style="min-width:0"><div style="font-size:13px;font-weight:800;color:var(--dark)">{{ $child->family->name }}</div>@if($child->family->country)<div style="font-size:11px;color:var(--muted);margin-top:3px"><i class="fas fa-map-marker-alt" style="color:var(--orange);font-size:9px;margin-right:3px"></i>{{ $child->family->country }}</div>@endif</div>
                        </div>
                    </div>
                    @endif
                    <div class="wcard">
                        <h3 class="wcard-title"><i class="far fa-folder" style="color:var(--muted)"></i> Documents · {{ $yr }} @if($yDocs->isNotEmpty())<span class="wc-badge" style="background:#fef9c3;color:#854d0e">{{ $yDocs->count() }}</span>@endif</h3>
                        @forelse($yDocs as $doc)
                        <div class="doc-item"><div class="doc-icon"><i class="fas fa-file-pdf"></i></div><div class="doc-info"><div class="doc-name">{{ $doc->title }}</div><div class="doc-meta">PDF @if($doc->document_date) · {{ \Carbon\Carbon::parse($doc->document_date)->format('M Y') }}@endif</div></div><a href="{{ route('sponsor.download',['type'=>'document','id'=>$doc->id]) }}" class="doc-dl" download><i class="fas fa-download"></i></a></div>
                        @empty
                        <p style="text-align:center;color:var(--muted);font-size:13px;padding:16px 0">No documents for {{ $yr }}.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    {{-- ── FOOTER BANNER ── --}}
    <div class="footer-banner reveal" style="animation-delay:.1s">
        <div class="footer-banner-bg" id="footer-banner-bg"></div>
        <div class="footer-banner-overlay"></div>
        <div class="footer-banner-content">
            <i class="far fa-heart fbc-icon"></i>
            <div class="fbc-text">
                <h2>Your support changes<br><span id="footer-banner-name">their</span> life and builds<br>their future.</h2>
                <p>Thank you for being there! <i class="fas fa-heart" style="color:var(--orange)"></i></p>
            </div>
        </div>
    </div>

    {{-- DATA lookup for JS --}}
    <div id="entity-banner-data" style="display:none">
        @foreach($families as $fi => $family)
        <span data-idx="{{ $fi }}" data-name="{{ Str::words($family->name,1,'') }}" data-photo="{{ $family->profile_photo ? asset($family->profile_photo_url ?? $family->profile_photo) : '' }}"></span>
        @endforeach
        @foreach($children as $ci => $child)
        <span data-idx="{{ $families->count()+$ci }}" data-name="{{ $child->first_name }}" data-photo="{{ $child->profile_photo ? asset($child->profile_photo) : '' }}"></span>
        @endforeach
    </div>

    {{-- ── SIMPLE FOOTER ── --}}
    <footer style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border)">
        <div class="site-footer-inner" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
            <p style="font-size:12px;color:var(--muted)">© {{ date('Y') }} {{ $settings['site_name'] ?? 'Des Ailes Pour Grandir' }}. All rights reserved.</p>
            <div class="site-footer-links" style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
                <a href="{{ route('home') }}#contact" style="font-size:12px;color:var(--muted);text-decoration:none;font-weight:600;transition:color .18s" onmouseover="this.style.color='var(--dark)'" onmouseout="this.style.color='var(--muted)'">Contact us</a>
                <a href="{{ route('sponsor.faq') }}" style="font-size:12px;color:var(--muted);text-decoration:none;font-weight:600;transition:color .18s" onmouseover="this.style.color='var(--dark)'" onmouseout="this.style.color='var(--muted)'">FAQ</a>
                <a href="mailto:asso.desailespourgrandir@gmail.com" style="font-size:12px;color:var(--muted);text-decoration:none;font-weight:600;transition:color .18s" onmouseover="this.style.color='var(--dark)'" onmouseout="this.style.color='var(--muted)'">Privacy policy</a>
                <div class="site-footer-socials" style="display:flex;gap:14px;font-size:17px">
                    @if(!empty($settings['facebook_url']))<a href="{{ $settings['facebook_url'] }}" target="_blank" style="color:var(--muted);transition:color .18s" onmouseover="this.style.color='var(--dark)'" onmouseout="this.style.color='var(--muted)'"><i class="fab fa-facebook-f"></i></a>@endif
                    @if(!empty($settings['instagram_url']))<a href="{{ $settings['instagram_url'] }}" target="_blank" style="color:var(--muted);transition:color .18s" onmouseover="this.style.color='var(--dark)'" onmouseout="this.style.color='var(--muted)'"><i class="fab fa-instagram"></i></a>@endif
                    @if(!empty($settings['youtube_url']))<a href="{{ $settings['youtube_url'] }}" target="_blank" style="color:var(--muted);transition:color .18s" onmouseover="this.style.color='var(--dark)'" onmouseout="this.style.color='var(--muted)'"><i class="fab fa-youtube"></i></a>@endif
                </div>
            </div>
        </div>
    </footer>
</div>

{{-- ── MOBILE BOTTOM BAR ── --}}
<div class="mob-bar" id="mob-bar">
    <a href="{{ route('sponsor.dashboard') }}" class="mob-nav-item active">
        <i class="fas fa-user-friends"></i>
        <span>My Child</span>
    </a>
    <a href="{{ route('sponsor.messages.home') }}" class="mob-nav-item">
        <i class="far fa-envelope"></i>
        <span>Messages</span>
    </a>
    <a href="{{ route('support.donate') }}" class="mob-nav-item">
        <i class="fas fa-hand-holding-heart"></i>
        <span>Sponsorship</span>
    </a>
    <a href="{{ route('home') }}" class="mob-nav-item">
        <i class="far fa-newspaper"></i>
        <span>News</span>
    </a>
    <form method="POST" action="{{ route('sponsor.logout') }}" style="margin:0;flex:1;display:flex">
        @csrf
        <button type="submit" class="mob-nav-item mob-nav-logout" style="color:var(--muted)">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </button>
    </form>
</div>

{{-- ── LIGHTBOX ── --}}
<div id="lightbox" class="fixed inset-0 z-[300] items-center justify-center p-4"
     style="background:rgba(0,0,0,.95);backdrop-filter:blur(12px)" onclick="closeLightbox()">
    <div style="position:absolute;top:0;left:0;right:0;display:flex;align-items:center;justify-content:space-between;padding:14px 18px;z-index:10" onclick="event.stopPropagation()">
        <p id="lb-caption" style="color:rgba(255,255,255,.7);font-size:13px;font-weight:700;max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"></p>
        <div style="display:flex;align-items:center;gap:8px">
            <a id="lb-download" href="#" download style="display:flex;align-items:center;gap:5px;padding:7px 13px;background:rgba(255,255,255,.1);color:#fff;border-radius:9px;font-size:11px;font-weight:700;text-decoration:none;transition:background .15s" onmouseover="this.style.background='rgba(255,255,255,.2)'" onmouseout="this.style.background='rgba(255,255,255,.1)'">
                <i class="fas fa-download" style="font-size:10px"></i> <span class="hidden sm:inline">Download</span>
            </a>
            <button onclick="closeLightbox()" style="width:36px;height:36px;background:rgba(255,255,255,.1);border:none;color:#fff;border-radius:9px;cursor:pointer;font-size:15px;display:flex;align-items:center;justify-content:center;transition:background .15s" onmouseover="this.style.background='rgba(255,255,255,.2)'" onmouseout="this.style.background='rgba(255,255,255,.1)'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div id="lb-inner" onclick="event.stopPropagation()" style="display:flex;align-items:center;justify-content:center;margin-top:54px;max-height:calc(100vh - 90px);width:100%">
        <img id="lb-img" src="" alt="" style="max-width:100%;max-height:calc(100vh - 90px);border-radius:14px;box-shadow:0 24px 64px rgba(0,0,0,.5);object-fit:contain;display:none">
        <video id="lb-video" src="" controls autoplay style="max-width:100%;max-height:calc(100vh - 90px);border-radius:14px;box-shadow:0 24px 64px rgba(0,0,0,.5);display:none;width:100%"></video>
    </div>
    <p style="position:absolute;bottom:12px;left:50%;transform:translateX(-50%);color:rgba(255,255,255,.18);font-size:11px;font-weight:600;white-space:nowrap">ESC or tap outside to close</p>
</div>

{{-- ════════════════════ SCRIPTS ════════════════════ --}}
<script>
/* ── Panels ── */
const panels = document.querySelectorAll('.entity-panel');
const tabs   = document.querySelectorAll('.entity-tab');

const style = document.createElement('style');
style.textContent = `.entity-panel{display:none!important}.entity-panel.active{display:block!important}`;
document.head.appendChild(style);

/* ── Year filter ── */
function switchYear(pid, year) {
    document.querySelectorAll(`.y-pill[data-panel="${pid}"]`).forEach(b => b.classList.toggle('active', b.dataset.year === String(year)));
    document.querySelectorAll(`.y-sec[data-panel="${pid}"]`).forEach(s => s.classList.toggle('active', s.dataset.section === String(year)));
    setTimeout(initReveal, 50);
}

/* ── Scroll reveal ── */
const ro = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('v'); ro.unobserve(e.target); } });
}, { threshold: .08, rootMargin: '0px 0px -30px 0px' });
function initReveal() {
    document.querySelectorAll('.reveal,.reveal-l,.reveal-r,.reveal-s').forEach(el => { if (!el.classList.contains('v')) ro.observe(el); });
}
document.addEventListener('DOMContentLoaded', initReveal);

/* ── Lightbox ── */
function openLightbox(src, type, caption, dlUrl) {
    const lb = document.getElementById('lightbox'), img = document.getElementById('lb-img'), vid = document.getElementById('lb-video'), inner = document.getElementById('lb-inner');
    type === 'video' ? (vid.src = src, vid.style.display = 'block', img.style.display = 'none', img.src = '') : (img.src = src, img.style.display = 'block', vid.style.display = 'none', vid.pause && vid.pause(), vid.src = '');
    document.getElementById('lb-caption').textContent = caption || '';
    document.getElementById('lb-download').href = dlUrl || src;
    lb.classList.add('open'); document.body.style.overflow = 'hidden';
    inner.style.animation = 'none'; requestAnimationFrame(() => { inner.style.animation = 'scaleUp .25s cubic-bezier(.34,1.1,.64,1) both'; });
}
function closeLightbox() {
    const vid = document.getElementById('lb-video'); vid.pause && vid.pause(); vid.src = '';
    document.getElementById('lightbox').classList.remove('open'); document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeLightbox(); closeNotif(); } });
let tsY = 0;
document.getElementById('lightbox').addEventListener('touchstart', e => { tsY = e.touches[0].clientY; }, { passive: true });
document.getElementById('lightbox').addEventListener('touchend', e => { if (e.changedTouches[0].clientY - tsY > 80) closeLightbox(); }, { passive: true });

/* ── Language ── */
const DLANG = { en: { label: 'EN', flag: 'https://flagcdn.com/w40/us.png' }, fr: { label: 'FR', flag: 'https://flagcdn.com/w40/fr.png' }, km: { label: 'KM', flag: 'https://flagcdn.com/w40/kh.png' } };
let dLang = localStorage.getItem('gt_lang') || 'fr';
function dashTriggerTranslate(l) {
    return new Promise(res => {
        const exp = 'expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = 'googtrans=; ' + exp; document.cookie = 'googtrans=; ' + exp + ' domain=' + location.hostname + ';'; document.cookie = 'googtrans=; ' + exp + ' domain=.' + location.hostname + ';';
        if (l === 'en') { res(); setTimeout(() => location.reload(), 80); return; }
        const pair = '/en/' + l; document.cookie = 'googtrans=' + pair + '; path=/'; document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname;
        const tryS = t => { const s = document.querySelector('select.goog-te-combo'); if (s) { s.value = l; s.dispatchEvent(new Event('change')); res(); } else if (t > 0) setTimeout(() => tryS(t - 1), 200); else { res(); setTimeout(() => location.reload(), 80); } }; tryS(8);
    });
}
function dashUpdateUI(l) {
    const c = DLANG[l] || DLANG.en; const f = document.getElementById('dash-flag'), lb = document.getElementById('dash-lang-label');
    if (f) { f.src = c.flag; f.alt = c.label; } if (lb) lb.textContent = c.label;
    ['en', 'fr', 'km'].forEach(x => { document.getElementById('dash-btn-' + x)?.classList.toggle('active', x === l); const ch = document.getElementById('dash-check-' + x); if (ch) ch.classList.toggle('hidden', x !== l); });
    document.body.style.fontFamily = l === 'km' ? "'Hanuman','Battambang','Content','Plus Jakarta Sans',sans-serif" : "'Plus Jakarta Sans',sans-serif";
    dLang = l; localStorage.setItem('gt_lang', l);
}
async function dashSwitchLang(l) { if (l === dLang) { dashClosePanel(); return; } dashUpdateUI(l); await dashTriggerTranslate(l); dashClosePanel(); }
function dashTogglePanel() {
    const p = document.getElementById('dash-translate-panel'), c = document.getElementById('dash-caret');
    const o = p.classList.toggle('open'); if (c) c.style.transform = o ? 'rotate(180deg)' : '';
    if (o) closeNotif(); // close notif if opening lang panel
}
function dashClosePanel() { const p = document.getElementById('dash-translate-panel'), c = document.getElementById('dash-caret'); if (p) p.classList.remove('open'); if (c) c.style.transform = ''; }
document.addEventListener('click', e => {
    const w = document.getElementById('dash-translate-wrapper'); if (w && !w.contains(e.target)) dashClosePanel();
    const nw = document.getElementById('notif-wrapper'); if (nw && !nw.contains(e.target)) closeNotif();
});

document.addEventListener('DOMContentLoaded', () => {
    const ck = document.cookie.split(';').find(c => c.trim().startsWith('googtrans=')); const st = localStorage.getItem('gt_lang');
    if (ck) { const pts = ck.split('/'); const cl = pts[pts.length - 1].trim(); if (cl && DLANG[cl]) { dLang = cl; localStorage.setItem('gt_lang', cl); } }
    else if (!st) { const pair = '/en/fr'; document.cookie = 'googtrans=' + pair + '; path=/'; document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname; localStorage.setItem('gt_lang', 'fr'); location.reload(); return; }
    dashUpdateUI(dLang);
    document.querySelectorAll('.entity-tab').forEach((t, i) => { t.style.opacity = '0'; t.style.transform = 'translateY(16px)'; setTimeout(() => { t.style.transition = 'opacity .4s ease,transform .4s ease'; t.style.opacity = '1'; t.style.transform = 'none'; }, i * 80 + 80); });
});

/* ── Notification Dropdown ── */
function toggleNotif() {
    const panel = document.getElementById('notif-panel');
    const isOpen = panel.classList.toggle('open');
    if (isOpen) dashClosePanel();
}
function closeNotif() {
    document.getElementById('notif-panel')?.classList.remove('open');
}
function switchNotifTab(tab) {
    ['updates', 'docs'].forEach(t => {
        document.getElementById('ntab-' + t)?.classList.toggle('active', t === tab);
        document.getElementById('npane-' + t)?.classList.toggle('active', t === tab);
    });
}
function markAllRead() {
    document.querySelectorAll('.nitem.unread').forEach(el => el.classList.remove('unread'));
    document.querySelectorAll('.nitem-dot').forEach(el => el.remove());
    const badge = document.querySelector('.notif-badge');
    if (badge) badge.style.display = 'none';
}

/* ── Banner data lookup ── */
const ENTITY_BANNER = {};
document.querySelectorAll('#entity-banner-data span[data-idx]').forEach(el => {
    ENTITY_BANNER[el.dataset.idx] = { name: el.dataset.name, photo: el.dataset.photo };
});
const FALLBACK_IMG = 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?w=1200&q=70';

function updateFooterBanner(idx) {
    const data = ENTITY_BANNER[String(idx)]; if (!data) return;
    const bg = document.getElementById('footer-banner-bg'), name = document.getElementById('footer-banner-name');
    if (bg) bg.style.backgroundImage = `url('${data.photo || FALLBACK_IMG}')`;
    if (name) name.textContent = data.name + "'s";
}

function selectEntity(idx) {
    panels.forEach((p, i) => p.classList.toggle('active', i === idx));
    tabs.forEach((t, i) => t.classList.toggle('active', i === idx));
    updateFooterBanner(idx);
    setTimeout(() => {
        initReveal();
        document.getElementById('panel-' + idx)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 60);
}

document.addEventListener('DOMContentLoaded', () => {
    const first = [...document.querySelectorAll('.entity-tab')].findIndex(t => t.classList.contains('active'));
    updateFooterBanner(first >= 0 ? first : 0);
});
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>
</body>
</html>