{{-- resources/views/sponsor/messages.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | {{ $sponsor->full_name }}</title>
    <meta name="robots" content="noindex, nofollow">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <script>function googleTranslateElementInit(){new google.translate.TranslateElement({pageLanguage:'en',includedLanguages:'en,km,fr',layout:google.translate.TranslateElement.InlineLayout.SIMPLE,autoDisplay:false,multilanguagePage:true},'google_translate_element');}</script>

    @livewireStyles

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

    @keyframes fadeUp    { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:none} }
    @keyframes fadeIn    { from{opacity:0} to{opacity:1} }
    @keyframes slideDown { from{opacity:0;transform:translateY(-14px)} to{opacity:1;transform:none} }
    @keyframes pulseGreen{ 0%,100%{opacity:1} 50%{opacity:.4} }

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
        transition: color .18s, background .18s; position: relative; white-space: nowrap;
    }
    .hdr-nav-link:hover { color: var(--brand); background: var(--brand-lt); }
    .hdr-nav-link.active { color: var(--brand); font-weight: 700; }
    .hdr-nav-link.active::after {
        content: ''; position: absolute; bottom: -13px; left: 0; right: 0;
        height: 3px; background: var(--brand); border-radius: 3px 3px 0 0;
    }
    .hdr-right { display: flex; align-items: center; gap: 10px; }

    /* ── LANGUAGE PILL ── */
    .lang-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 11px; border-radius: 10px; border: 1px solid var(--border);
        background: #fff; cursor: pointer; font-size: 12px; font-weight: 700;
        color: var(--dark); transition: all .18s; white-space: nowrap;
        font-family: inherit;
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
    .lang-opt .flag { width: 22px; height: 15px; object-fit: cover; border-radius: 3px; }
    .lang-opt .chk  { margin-left: auto; color: var(--orange); font-size: 10px; }

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
        border: 1px solid var(--border); box-shadow: 0 20px 60px rgba(0,0,0,.13);
        opacity: 0; visibility: hidden; transform: translateY(-8px) scale(.97);
        transition: all .22s cubic-bezier(.34,1.3,.64,1); z-index: 999; overflow: hidden;
    }
    .notif-panel.open { opacity:1; visibility:visible; transform:none; }
    .notif-header { padding: 14px 16px 0; border-bottom: 1px solid var(--border); }
    .notif-title-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
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
    .nitem-meta  { display: flex; align-items: center; gap: 5px; margin-bottom: 3px; flex-wrap: wrap; }
    .nitem-entity{ font-size: 11px; color: var(--muted); font-weight: 600; }
    .nitem-date  { font-size: 11px; color: var(--muted); }
    .nitem-title { font-size: 13px; font-weight: 700; color: var(--dark); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .nitem-text  { font-size: 12px; color: var(--muted); line-height: 1.55; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .nitem-dot   { width: 7px; height: 7px; background: var(--orange); border-radius: 50%; flex-shrink: 0; margin-top: 5px; }
    .nitem-dl {
        width: 28px; height: 28px; border-radius: 7px; flex-shrink: 0;
        background: #f3f2ee; color: var(--muted); border: none;
        display: flex; align-items: center; justify-content: center;
        text-decoration: none; transition: all .18s; font-size: 11px; cursor: pointer;
    }
    .nitem-dl:hover { background: var(--orange); color: #fff; transform: scale(1.08); }
    .notif-footer { padding: 11px 16px; border-top: 1px solid var(--border); text-align: center; }
    .notif-footer a {
        font-size: 12px; color: var(--orange); font-weight: 700;
        text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
    }
    .notif-footer a:hover { color: #d97000; }

    /* type badges (needed for notification updates pane) */
    .type-badge { display:inline-flex;align-items:center;font-size:10px;font-weight:800;padding:2px 8px;border-radius:999px;margin-right:4px;text-transform:capitalize; }
    .badge-health    { background:#fef3c7;color:#f97316; }
    .badge-education { background:#dbeafe;color:#1e40af; }
    .badge-study     { background:#e0e7ff;color:#3730a3; }
    .badge-financial { background:#fef9c3;color:#854d0e; }
    .badge-general   { background:#f1f5f9;color:#475569; }
    .badge-visit     { background:#fce7f3;color:#9d174d; }

    /* ── SPONSOR CHIP ── */
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
    .pw { max-width: 820px; margin: 0 auto; padding: 36px 24px 80px; }

    /* ── PAGE HEADER ── */
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; animation: fadeUp .5s ease both; }
    .page-title  { font-family: 'Lora', serif; font-size: 30px; color: var(--dark); display: flex; align-items: center; gap: 12px; }
    .page-title-icon { width: 44px; height: 44px; border-radius: 13px; background: var(--brand-lt); display: flex; align-items: center; justify-content: center; color: var(--brand); font-size: 18px; }
    .page-subtitle { font-size: 13px; color: var(--muted); font-weight: 500; margin-top: 4px; }

    .online-dot { width: 7px; height: 7px; background: #22c55e; border-radius: 50%; animation: pulseGreen 2s ease-in-out infinite; display: inline-block; }

    /* ── MOBILE NAV ── */
    .mob-bar {
        display: none; position: fixed; bottom: 0; left: 0; right: 0;
        background: rgba(255,255,255,.97); backdrop-filter: blur(14px);
        border-top: 1px solid var(--border);
        padding: 8px 20px calc(8px + env(safe-area-inset-bottom));
        z-index: 190; box-shadow: 0 -4px 24px rgba(0,0,0,.08);
        gap: 4px; align-items: stretch; justify-content: space-around;
    }
    .mob-nav-item {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 3px; flex: 1; padding: 6px 4px; color: var(--muted);
        font-size: 9.5px; font-weight: 700; text-decoration: none; border-radius: 10px;
        transition: color .18s, background .18s; letter-spacing: .02em; text-transform: uppercase;
    }
    .mob-nav-item i { font-size: 17px; }
    .mob-nav-item:hover,.mob-nav-item.active { color: var(--brand); background: var(--brand-lt); }
    .mob-nav-logout { background: none; border: none; cursor: pointer; font-family: inherit; flex: 1; }

    @media (max-width:640px) {
        .pw { padding: 18px 14px 100px; }
        .mob-bar { display: flex; }
        .sponsor-chip { display: none !important; }
        .header-inner { padding: 0 14px; height: 60px; }
        .hdr-logo { height: 46px; }
        .hdr-nav { display: none; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 8px; }
        .page-title { font-size: 24px; }
        .notif-panel { width: calc(100vw - 28px); right: -14px; }
    }
    </style>
</head>
<body>

{{-- ════════════════════ HEADER ════════════════════ --}}
@include('sponsor.layouts.header')

{{-- ════════════════════ PAGE BODY ════════════════════ --}}
<div class="pw">
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <div class="page-title-icon"><i class="fas fa-headset"></i></div>
                Support
            </h1>
            <p class="page-subtitle">Direct line to our team · We respond within 48 hours</p>
        </div>
    </div>

    @livewire('messages-chat')
</div>

{{-- ── MOBILE BOTTOM BAR ── --}}
@include('sponsor.layouts.nav')
@livewireScripts

{{-- ════════════════════ SCRIPTS (identical to dashboard) ════════════════════ --}}
<script>
/* ── Language switcher ── */
const DLANG = {
    en: { label: 'EN', flag: 'https://flagcdn.com/w40/us.png' },
    fr: { label: 'FR', flag: 'https://flagcdn.com/w40/fr.png' },
    km: { label: 'KM', flag: 'https://flagcdn.com/w40/kh.png' },
};
let dLang = localStorage.getItem('gt_lang') || 'fr';

function dashTriggerTranslate(l) {
    return new Promise(res => {
        const exp = 'expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = 'googtrans=; ' + exp;
        document.cookie = 'googtrans=; ' + exp + ' domain=' + location.hostname + ';';
        document.cookie = 'googtrans=; ' + exp + ' domain=.' + location.hostname + ';';
        if (l === 'en') { res(); setTimeout(() => location.reload(), 80); return; }
        const pair = '/en/' + l;
        document.cookie = 'googtrans=' + pair + '; path=/';
        document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname;
        const tryS = t => {
            const s = document.querySelector('select.goog-te-combo');
            if (s) { s.value = l; s.dispatchEvent(new Event('change')); res(); }
            else if (t > 0) setTimeout(() => tryS(t - 1), 200);
            else { res(); setTimeout(() => location.reload(), 80); }
        };
        tryS(8);
    });
}

function dashUpdateUI(l) {
    const c = DLANG[l] || DLANG.en;
    const f = document.getElementById('dash-flag'), lb = document.getElementById('dash-lang-label');
    if (f) { f.src = c.flag; f.alt = c.label; }
    if (lb) lb.textContent = c.label;
    ['en', 'fr', 'km'].forEach(x => {
        document.getElementById('dash-btn-' + x)?.classList.toggle('active', x === l);
        const ch = document.getElementById('dash-check-' + x);
        if (ch) ch.classList.toggle('hidden', x !== l);
    });
    document.body.style.fontFamily = l === 'km'
        ? "'Hanuman','Battambang','Content','Plus Jakarta Sans',sans-serif"
        : "'Plus Jakarta Sans',sans-serif";
    dLang = l;
    localStorage.setItem('gt_lang', l);
}

async function dashSwitchLang(l) {
    if (l === dLang) { dashClosePanel(); return; }
    dashUpdateUI(l);
    await dashTriggerTranslate(l);
    dashClosePanel();
}

function dashTogglePanel() {
    const p = document.getElementById('dash-translate-panel');
    const c = document.getElementById('dash-caret');
    const o = p.classList.toggle('open');
    if (c) c.style.transform = o ? 'rotate(180deg)' : '';
    if (o) closeNotif();
}

function dashClosePanel() {
    const p = document.getElementById('dash-translate-panel');
    const c = document.getElementById('dash-caret');
    if (p) p.classList.remove('open');
    if (c) c.style.transform = '';
}

/* ── Notification dropdown ── */
function toggleNotif() {
    const open = document.getElementById('notif-panel').classList.toggle('open');
    if (open) dashClosePanel();
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

/* ── Close dropdowns on outside click ── */
document.addEventListener('click', e => {
    const tw = document.getElementById('dash-translate-wrapper');
    if (tw && !tw.contains(e.target)) dashClosePanel();
    const nw = document.getElementById('notif-wrapper');
    if (nw && !nw.contains(e.target)) closeNotif();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') { dashClosePanel(); closeNotif(); } });

/* ── Init on load ── */
document.addEventListener('DOMContentLoaded', () => {
    const ck  = document.cookie.split(';').find(c => c.trim().startsWith('googtrans='));
    const st  = localStorage.getItem('gt_lang');
    if (ck) {
        const pts = ck.split('/');
        const cl  = pts[pts.length - 1].trim();
        if (cl && DLANG[cl]) { dLang = cl; localStorage.setItem('gt_lang', cl); }
    } else if (!st) {
        const pair = '/en/fr';
        document.cookie = 'googtrans=' + pair + '; path=/';
        document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname;
        localStorage.setItem('gt_lang', 'fr');
        location.reload();
        return;
    }
    dashUpdateUI(dLang);
});
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>
</body>
</html>