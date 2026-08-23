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
        position: relative;
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

    /* NEW badge for fresh content */
    .new-pulse {
        position: absolute; top: -7px; right: -7px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff; font-size: 9px; font-weight: 900;
        padding: 3px 7px; border-radius: 999px;
        border: 2px solid var(--bg);
        box-shadow: 0 3px 10px rgba(239,68,68,.45);
        display: none; pointer-events: none;
        letter-spacing: .04em; z-index: 3;
        animation: pulseBadge 1.8s ease-in-out infinite;
        white-space: nowrap;
    }
    .new-pulse.show { display: block; }
    @keyframes pulseBadge {
        0%, 100% { transform: scale(1); box-shadow: 0 3px 10px rgba(239,68,68,.45); }
        50% { transform: scale(1.14); box-shadow: 0 4px 16px rgba(239,68,68,.7); }
    }
    /* small new-dot used on wcard titles inside a panel */
    .new-dot {
        display: inline-block; width: 8px; height: 8px;
        background: #ef4444; border-radius: 50%;
        margin-left: 6px; vertical-align: middle;
        animation: pulseBadge 1.8s ease-in-out infinite;
        box-shadow: 0 0 0 0 rgba(239,68,68,.5);
    }

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
    /* Special styling for the "All updates" pill — subtle differentiation */
    .y-pill[data-year="all"] { border-style: dashed; }
    .y-pill[data-year="all"].active { border-style: solid; }
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

    /* Year separator inside "All updates" timeline */
    .yr-sep {
        display: flex; align-items: center; gap: 10px;
        margin: 18px 0 12px; padding-left: 0;
    }
    .yr-sep:first-child { margin-top: 0; }
    .yr-sep-line { flex: 1; height: 1px; background: var(--border); }
    .yr-sep-label {
        font-size: 11px; font-weight: 900; color: var(--brand);
        background: var(--brand-lt); padding: 4px 12px; border-radius: 999px;
        letter-spacing: .08em;
    }

    /* Story / About section */
    .about-text { font-size: 14.5px; color: var(--muted); line-height: 1.75; }
    .about-text + .about-text { margin-top: 12px; }
    .see-more { color: var(--orange); font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; transition: color .18s; margin-top: 14px; }
    .see-more:hover { color: #d97000; }

    /* Photo gallery */
    .photo-gallery { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; }
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
        cursor: pointer; background: none; border: none; padding: 0;
        font-family: inherit;
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
@include('sponsor.layouts.header')

@php
    $children = $sponsor->children->sortByDesc(fn($c) => $c->pivot->created_at)->values();
    $families = $sponsor->families->sortByDesc(fn($f) => $f->pivot->created_at)->values();
    $hasActiveSponsorship = $children->count() > 0 || $families->count() > 0;
@endphp

<div class="pw" style="max-width: 960px; margin: 0 auto; padding-top: 48px;">
    
    {{-- ══════════ HERO SECTION ══════════ --}}
    <div style="background: linear-gradient(135deg, var(--brand) 0%, #ea580c 100%); border-radius: 24px; padding: 40px 48px; display: flex; align-items: center; justify-content: space-between; gap: 32px; margin-bottom: 48px; box-shadow: 0 20px 40px rgba(234,88,12,.2); position: relative; overflow: hidden;" class="anim-up">
        <div style="position: absolute; right: -50px; top: -100px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.15), transparent 70%); border-radius: 50%;"></div>
        <div style="position: absolute; left: 20%; bottom: -150px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%); border-radius: 50%;"></div>
        
        <div style="position: relative; z-index: 1;">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); border-radius: 16px; margin-bottom: 20px;">
                <i class="fas fa-hand-holding-heart" style="color: #fff; font-size: 24px;"></i>
            </div>
            <h1 style="color: #fff; font-family: 'Lora', serif; font-size: 40px; font-weight: 700; margin-bottom: 12px; line-height: 1.1;">Sponsorship Details</h1>
            <p style="color: rgba(255,255,255,0.9); font-size: 16px; max-width: 500px; line-height: 1.6;">Thank you for being a vital part of our mission, {{ $sponsor->first_name }}. Here you can view and manage the details of the children and families you support.</p>
        </div>
        
        {{-- <div style="position: relative; z-index: 1; display: flex; flex-direction: column; gap: 12px; min-width: 200px;">
            <a href="{{ route('support.donate') }}" style="background: #fff; color: var(--brand); font-weight: 800; padding: 14px 24px; border-radius: 12px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 28px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'">
                <i class="fas fa-plus-circle"></i> Add Sponsorship
            </a>
        </div> --}}
    </div>

    @if($hasActiveSponsorship)
        {{-- ══════════ SPONSORED CHILDREN ══════════ --}}
        @if($children->count() > 0)
        <div class="anim-up" style="animation-delay: 0.1s; margin-bottom: 48px;">
            <h2 style="font-family: 'Lora', serif; font-size: 24px; font-weight: 700; color: var(--dark); margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-child" style="color: var(--brand);"></i> Sponsored Children
                <span style="font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; background: var(--brand-lt); color: var(--brand); padding: 4px 12px; border-radius: 999px;">{{ $children->count() }}</span>
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @foreach($children as $child)
                <div style="background: #fff; border-radius: 20px; border: 1px solid var(--border); overflow: hidden; box-shadow: var(--card-sh); transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--card-sh2)'" onmouseout="this.style.transform='none';this.style.boxShadow='var(--card-sh)'">
                    <div style="height: 180px; position: relative;">
                        @if($child->profile_photo)
                            <img src="{{ $child->profile_photo }}" alt="{{ $child->first_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--brand-lt), #fde9b8); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-child" style="font-size: 48px; color: var(--brand);"></i>
                            </div>
                        @endif
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 80px; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"></div>
                        <div style="position: absolute; bottom: 16px; left: 24px;">
                            <h3 style="color: #fff; font-family: 'Lora', serif; font-size: 22px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $child->first_name }} {{ $child->last_name }}</h3>
                        </div>
                    </div>
                    <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                        <div style="display: flex; gap: 12px; margin-bottom: 24px;">
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: var(--brand); background: var(--brand-lt); padding: 4px 12px; border-radius: 8px;">
                                <i class="fas fa-birthday-cake"></i> {{ $child->date_of_birth ? \Carbon\Carbon::parse($child->date_of_birth)->age . ' yrs' : 'N/A' }}
                            </span>
                            @if($child->country)
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #4b5563; background: #f3f4f6; padding: 4px 12px; border-radius: 8px;">
                                <i class="fas fa-map-marker-alt"></i> {{ $child->country }}
                            </span>
                            @endif
                        </div>
                        
                        <div style="margin-top: auto; border-top: 1px dashed var(--border); padding-top: 16px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <span style="font-size: 13px; color: var(--muted); font-weight: 500;">Start Date</span>
                                <span style="font-size: 13px; font-weight: 700; color: var(--dark);">{{ $child->pivot->created_at ? $child->pivot->created_at->format('M d, Y') : '—' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-size: 13px; color: var(--muted); font-weight: 500;">Monthly Amount</span>
                                <span style="font-size: 13px; font-weight: 700; color: var(--brand);">As arranged</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ══════════ SPONSORED FAMILIES ══════════ --}}
        @if($families->count() > 0)
        <div class="anim-up" style="animation-delay: 0.2s; margin-bottom: 48px;">
            <h2 style="font-family: 'Lora', serif; font-size: 24px; font-weight: 700; color: var(--dark); margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-house-user" style="color: #2563eb;"></i> Sponsored Families
                <span style="font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; background: #dbeafe; color: #2563eb; padding: 4px 12px; border-radius: 999px;">{{ $families->count() }}</span>
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @foreach($families as $family)
                <div style="background: #fff; border-radius: 20px; border: 1px solid var(--border); overflow: hidden; box-shadow: var(--card-sh); transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--card-sh2)'" onmouseout="this.style.transform='none';this.style.boxShadow='var(--card-sh)'">
                    <div style="height: 180px; position: relative;">
                        @if($family->profile_photo)
                            <img src="{{ $family->profile_photo_url }}" alt="{{ $family->name }} Family" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #dbeafe, #bfdbfe); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-house-user" style="font-size: 48px; color: #2563eb;"></i>
                            </div>
                        @endif
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 80px; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"></div>
                        <div style="position: absolute; bottom: 16px; left: 24px;">
                            <h3 style="color: #fff; font-family: 'Lora', serif; font-size: 22px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $family->name }} Family</h3>
                        </div>
                    </div>
                    <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                        <div style="display: flex; gap: 12px; margin-bottom: 24px;">
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #2563eb; background: #dbeafe; padding: 4px 12px; border-radius: 8px;">
                                <i class="fas fa-users"></i> {{ $family->members ? $family->members->count() : 'Unknown' }} Members
                            </span>
                            @if($family->country)
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #4b5563; background: #f3f4f6; padding: 4px 12px; border-radius: 8px;">
                                <i class="fas fa-map-marker-alt"></i> {{ $family->country }}
                            </span>
                            @endif
                        </div>
                        
                        <div style="margin-top: auto; border-top: 1px dashed var(--border); padding-top: 16px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <span style="font-size: 13px; color: var(--muted); font-weight: 500;">Start Date</span>
                                <span style="font-size: 13px; font-weight: 700; color: var(--dark);">{{ $family->pivot->created_at ? $family->pivot->created_at->format('M d, Y') : '—' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-size: 13px; color: var(--muted); font-weight: 500;">Monthly Amount</span>
                                <span style="font-size: 13px; font-weight: 700; color: #2563eb;">As arranged</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    @else
        {{-- ══════════ NO ACTIVE SPONSORSHIPS ══════════ --}}
        <div class="anim-up" style="animation-delay: 0.1s; text-align: center; padding: 80px 24px; background: #fff; border-radius: 24px; border: 1px dashed #d1d5db; margin-bottom: 48px;">
            <div style="width: 80px; height: 80px; background: #f3f4f6; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                <i class="fas fa-box-open" style="font-size: 32px; color: #9ca3af;"></i>
            </div>
            <h2 style="font-family: 'Lora', serif; font-size: 28px; font-weight: 700; color: var(--dark); margin-bottom: 16px;">No Active Sponsorships</h2>
            <p style="font-size: 16px; color: var(--muted); max-width: 500px; margin: 0 auto 32px; line-height: 1.6;">You are not currently sponsoring any families or children. Explore our families and children in need and make a lasting impact today.</p>
            <a href="{{ route('support.donate') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 32px; background: var(--brand); color: #fff; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 16px; box-shadow: 0 8px 24px rgba(239, 125, 0, 0.25); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 28px rgba(239, 125, 0, 0.35)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 24px rgba(239, 125, 0, 0.25)'">
                Become a Sponsor <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    @endif
</div>

@include('sponsor.layouts.nav')

<script>
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
}
function dashClosePanel() { const p = document.getElementById('dash-translate-panel'), c = document.getElementById('dash-caret'); if (p) p.classList.remove('open'); if (c) c.style.transform = ''; }
document.addEventListener('click', e => {
    const w = document.getElementById('dash-translate-wrapper'); if (w && !w.contains(e.target)) dashClosePanel();
});
document.addEventListener('DOMContentLoaded', () => {
    const ck = document.cookie.split(';').find(c => c.trim().startsWith('googtrans=')); const st = localStorage.getItem('gt_lang');
    if (ck) { const pts = ck.split('/'); const cl = pts[pts.length - 1].trim(); if (cl && DLANG[cl]) { dLang = cl; localStorage.setItem('gt_lang', cl); } }
    else if (!st) { const pair = '/en/fr'; document.cookie = 'googtrans=' + pair + '; path=/'; document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname; localStorage.setItem('gt_lang', 'fr'); location.reload(); return; }
    dashUpdateUI(dLang);
});
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>
</body>
</html>