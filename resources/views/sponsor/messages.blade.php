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
    @keyframes scaleUp   { from{opacity:0;transform:scale(.95)} to{opacity:1;transform:scale(1)} }
    @keyframes pulseGreen{ 0%,100%{opacity:1} 50%{opacity:.4} }

    /* ── HEADER (identical to dashboard) ── */
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

    /* ── PAGE HEADER ── */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 28px; animation: fadeUp .5s ease both;
    }
    .page-title {
        font-family: 'Lora', serif; font-size: 32px; color: var(--dark);
        display: flex; align-items: center; gap: 12px;
    }
    .page-title-icon {
        width: 44px; height: 44px; border-radius: 13px;
        background: var(--brand-lt); display: flex; align-items: center; justify-content: center;
        color: var(--brand); font-size: 18px;
    }
    .page-subtitle { font-size: 13px; color: var(--muted); font-family: 'Plus Jakarta Sans',sans-serif; font-weight: 500; margin-top: 4px; }

    /* ── COMPOSE BUTTON ── */
    .btn-compose {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--orange); color: #fff; border: none; border-radius: 12px;
        padding: 12px 20px; font-size: 14px; font-weight: 700; cursor: pointer;
        font-family: inherit; text-decoration: none;
        box-shadow: 0 4px 16px rgba(239,125,0,.28);
        transition: all .22s;
    }
    .btn-compose:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(239,125,0,.38); background: #d97000; }

    /* ── MESSAGES LAYOUT ── */
    .msg-layout {
        display: grid; grid-template-columns: 320px 1fr; gap: 20px;
        animation: fadeUp .5s .08s ease both; opacity: 0; animation-fill-mode: both;
    }

    /* ── SIDEBAR ── */
    .msg-sidebar {
        background: #fff; border-radius: 20px; border: 1px solid var(--border);
        box-shadow: var(--card-sh); overflow: hidden; display: flex; flex-direction: column;
        height: calc(100vh - 220px); min-height: 480px;
    }
    .sidebar-search {
        padding: 14px 14px 0;
    }
    .search-wrap {
        display: flex; align-items: center; gap: 9px;
        background: #f8f7f4; border-radius: 11px; padding: 9px 13px;
        border: 1.5px solid var(--border); transition: border-color .18s;
    }
    .search-wrap:focus-within { border-color: var(--orange); }
    .search-wrap i { color: var(--muted); font-size: 12px; flex-shrink: 0; }
    .search-wrap input {
        border: none; background: none; outline: none; font-family: inherit;
        font-size: 13px; color: var(--dark); width: 100%; font-weight: 500;
    }
    .search-wrap input::placeholder { color: #c4b7a8; }

    /* Filter pills */
    .filter-pills {
        display: flex; gap: 6px; padding: 12px 14px;
        border-bottom: 1px solid var(--border);
    }
    .fpill {
        padding: 5px 12px; border-radius: 999px; font-size: 11px; font-weight: 700;
        border: 1.5px solid var(--border); background: #fff; color: var(--muted);
        cursor: pointer; transition: all .18s; font-family: inherit;
        display: flex; align-items: center; gap: 5px;
    }
    .fpill:hover { border-color: var(--orange); color: var(--orange); }
    .fpill.active { background: var(--orange); border-color: var(--orange); color: #fff; }
    .fpill .fpill-count {
        background: rgba(255,255,255,.3); border-radius: 999px;
        padding: 1px 5px; font-size: 9px;
    }
    .fpill:not(.active) .fpill-count { background: #f0ece7; }

    /* Thread list */
    .thread-list { flex: 1; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #e8e4de transparent; }
    .thread-list::-webkit-scrollbar { width: 4px; }
    .thread-list::-webkit-scrollbar-track { background: transparent; }
    .thread-list::-webkit-scrollbar-thumb { background: #e8e4de; border-radius: 4px; }

    .thread-item {
        padding: 14px 16px; display: flex; align-items: flex-start; gap: 11px;
        border-bottom: 1px solid #f5f3ef; cursor: pointer; transition: background .15s;
        position: relative;
    }
    .thread-item:hover { background: #fafaf8; }
    .thread-item.active { background: var(--brand-lt); border-left: 3px solid var(--orange); }
    .thread-item.unread { background: #fffbf5; }
    .thread-item.unread .thread-name { color: var(--dark); }
    .thread-item.unread .thread-preview { color: #6b5a46; }
    .thread-avatar {
        width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
        object-fit: cover; border: 2px solid var(--border);
    }
    .thread-avatar-icon {
        width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
        background: linear-gradient(135deg,#fde68a,#f97316);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 15px; font-weight: 900;
    }
    .thread-body { flex: 1; min-width: 0; }
    .thread-row1 { display: flex; align-items: center; justify-content: space-between; margin-bottom: 3px; }
    .thread-name { font-size: 13px; font-weight: 700; color: #5a4e43; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 160px; }
    .thread-time { font-size: 10px; color: var(--muted); font-weight: 600; flex-shrink: 0; }
    .thread-preview { font-size: 12px; color: var(--muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.5; }
    .thread-badges { display: flex; align-items: center; gap: 5px; margin-top: 4px; }
    .t-tag {
        font-size: 9px; font-weight: 800; padding: 2px 7px; border-radius: 999px;
        text-transform: uppercase; letter-spacing: .04em;
    }
    .t-tag-child  { background: var(--brand-lt); color: var(--brand); }
    .t-tag-family { background: #dbeafe; color: #1e40af; }
    .t-tag-admin  { background: #f3e8ff; color: #7c3aed; }
    .unread-dot {
        width: 8px; height: 8px; background: var(--orange); border-radius: 50%;
        position: absolute; top: 16px; right: 14px; flex-shrink: 0;
    }
    .unread-badge {
        background: var(--orange); color: #fff; border-radius: 999px;
        font-size: 9px; font-weight: 900; padding: 1px 6px; margin-left: auto;
    }

    /* Empty thread list */
    .empty-threads {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 48px 24px; color: var(--muted); text-align: center; gap: 10px;
    }
    .empty-threads i { font-size: 36px; opacity: .25; }
    .empty-threads p { font-size: 13px; font-weight: 600; }

    /* ── CHAT PANEL ── */
    .chat-panel {
        background: #fff; border-radius: 20px; border: 1px solid var(--border);
        box-shadow: var(--card-sh); display: flex; flex-direction: column;
        height: calc(100vh - 220px); min-height: 480px; overflow: hidden;
    }

    /* Chat header */
    .chat-header {
        padding: 16px 20px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 13px; flex-shrink: 0;
        background: #fff;
    }
    .chat-header-avatar {
        width: 44px; height: 44px; border-radius: 12px; object-fit: cover;
    }
    .chat-header-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: linear-gradient(135deg,var(--brand-lt),#fde9b8);
        display: flex; align-items: center; justify-content: center;
        color: var(--brand); font-size: 18px;
    }
    .chat-header-info { flex: 1; min-width: 0; }
    .chat-header-name { font-size: 15px; font-weight: 800; color: var(--dark); }
    .chat-header-sub  { font-size: 12px; color: var(--muted); font-weight: 500; margin-top: 2px; display: flex; align-items: center; gap: 6px; }
    .online-dot { width: 7px; height: 7px; background: #22c55e; border-radius: 50%; animation: pulseGreen 2s ease-in-out infinite; display: inline-block; }
    .chat-header-actions { display: flex; gap: 8px; }
    .chat-action-btn {
        width: 36px; height: 36px; border-radius: 10px; background: #f8f7f4;
        border: 1px solid var(--border); color: var(--muted); cursor: pointer;
        display: flex; align-items: center; justify-content: center; font-size: 13px;
        transition: all .18s; font-family: inherit;
    }
    .chat-action-btn:hover { background: var(--brand-lt); color: var(--brand); border-color: var(--brand); }

    /* Messages body */
    .chat-body {
        flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column;
        gap: 14px; scrollbar-width: thin; scrollbar-color: #e8e4de transparent;
    }
    .chat-body::-webkit-scrollbar { width: 4px; }
    .chat-body::-webkit-scrollbar-thumb { background: #e8e4de; border-radius: 4px; }

    /* Date divider */
    .date-divider {
        display: flex; align-items: center; gap: 12px; margin: 6px 0;
    }
    .date-divider::before, .date-divider::after {
        content: ''; flex: 1; height: 1px; background: var(--border);
    }
    .date-divider span {
        font-size: 11px; font-weight: 700; color: var(--muted);
        background: #fff; padding: 3px 10px; border-radius: 999px;
        border: 1px solid var(--border); white-space: nowrap;
    }

    /* Bubble */
    .msg-row { display: flex; gap: 10px; align-items: flex-end; }
    .msg-row.me { flex-direction: row-reverse; }
    .msg-row-avatar {
        width: 30px; height: 30px; border-radius: 9px; object-fit: cover;
        flex-shrink: 0; border: 2px solid var(--border);
    }
    .msg-row-icon {
        width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0;
        background: linear-gradient(135deg,#fde68a,#f97316);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 11px; font-weight: 900;
    }
    .msg-row-icon.me-icon {
        background: linear-gradient(135deg,var(--orange),#d46a00);
    }
    .bubble-wrap { display: flex; flex-direction: column; gap: 3px; max-width: 68%; }
    .msg-row.me .bubble-wrap { align-items: flex-end; }
    .bubble {
        padding: 11px 14px; border-radius: 16px; font-size: 13.5px; line-height: 1.65;
        font-weight: 500; position: relative; word-break: break-word;
    }
    .bubble.them {
        background: #f5f2ed; color: var(--dark); border-bottom-left-radius: 4px;
    }
    .bubble.me {
        background: linear-gradient(135deg, var(--orange), #d97000); color: #fff;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 16px rgba(239,125,0,.28);
    }
    .bubble-meta {
        font-size: 10px; color: var(--muted); font-weight: 600;
        display: flex; align-items: center; gap: 5px;
    }
    .msg-row.me .bubble-meta { justify-content: flex-end; }
    .read-tick { color: var(--orange); }

    /* Attachment bubble */
    .bubble-attachment {
        display: flex; align-items: center; gap: 9px;
        background: rgba(255,255,255,.18); border-radius: 10px;
        padding: 8px 10px; margin-top: 6px; text-decoration: none;
        border: 1px solid rgba(255,255,255,.25);
    }
    .bubble-attachment.them-att {
        background: rgba(0,0,0,.04); border: 1px solid var(--border);
    }
    .bubble-attachment i { font-size: 18px; flex-shrink: 0; }
    .att-info { flex: 1; min-width: 0; }
    .att-name { font-size: 12px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .att-size { font-size: 10px; opacity: .7; }
    .att-dl { font-size: 11px; opacity: .7; transition: opacity .18s; }
    .bubble-attachment:hover .att-dl { opacity: 1; }

    /* Typing indicator */
    .typing-indicator {
        display: flex; gap: 10px; align-items: flex-end;
    }
    .typing-dots {
        background: #f5f2ed; border-radius: 16px; border-bottom-left-radius: 4px;
        padding: 13px 16px; display: flex; gap: 4px; align-items: center;
    }
    .typing-dots span {
        width: 7px; height: 7px; background: var(--muted); border-radius: 50%;
        animation: typingBounce 1.2s ease-in-out infinite;
    }
    .typing-dots span:nth-child(2) { animation-delay: .2s; }
    .typing-dots span:nth-child(3) { animation-delay: .4s; }
    @keyframes typingBounce {
        0%,60%,100% { transform: translateY(0); opacity: .4; }
        30% { transform: translateY(-6px); opacity: 1; }
    }

    /* Unread banner inside chat */
    .unread-banner {
        display: flex; align-items: center; gap: 10px;
        background: #fff9ed; border: 1px solid #fde68a; border-radius: 10px;
        padding: 8px 14px; font-size: 12px; font-weight: 700; color: #92400e;
    }

    /* Empty chat */
    .chat-empty {
        flex: 1; display: flex; flex-direction: column; align-items: center;
        justify-content: center; gap: 14px; color: var(--muted); padding: 48px;
    }
    .chat-empty-icon {
        width: 72px; height: 72px; border-radius: 20px; background: var(--brand-lt);
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; color: var(--brand);
        animation: scaleUp .5s ease both;
    }
    .chat-empty h3 { font-family: 'Lora',serif; font-size: 20px; color: var(--dark); text-align: center; }
    .chat-empty p  { font-size: 13px; text-align: center; max-width: 280px; line-height: 1.65; }

    /* Chat input */
    .chat-footer {
        padding: 14px 16px; border-top: 1px solid var(--border); flex-shrink: 0;
        background: #fff;
    }
    .chat-form {
        display: flex; align-items: flex-end; gap: 10px;
        background: #f8f7f4; border-radius: 14px; border: 1.5px solid var(--border);
        padding: 10px 12px; transition: border-color .18s;
    }
    .chat-form:focus-within { border-color: var(--orange); background: #fff; }
    .chat-form textarea {
        flex: 1; background: none; border: none; outline: none; resize: none;
        font-family: inherit; font-size: 13.5px; color: var(--dark); font-weight: 500;
        line-height: 1.6; max-height: 120px; min-height: 22px;
    }
    .chat-form textarea::placeholder { color: #c4b7a8; }
    .chat-form-actions { display: flex; gap: 6px; align-items: center; }
    .attach-btn {
        width: 34px; height: 34px; border-radius: 9px; background: none;
        border: 1.5px solid var(--border); color: var(--muted); cursor: pointer;
        display: flex; align-items: center; justify-content: center; font-size: 13px;
        transition: all .18s; font-family: inherit;
    }
    .attach-btn:hover { border-color: var(--orange); color: var(--orange); background: var(--brand-lt); }
    .send-btn {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--orange); color: #fff; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; font-size: 14px;
        transition: all .2s; font-family: inherit;
        box-shadow: 0 4px 12px rgba(239,125,0,.3);
    }
    .send-btn:hover { background: #d97000; transform: scale(1.06); }
    .send-btn:active { transform: scale(.96); }
    .char-count { font-size: 10px; color: var(--muted); font-weight: 600; padding-bottom: 4px; }

    /* No conversation selected */
    .no-conv-selected {
        flex: 1; display: flex; flex-direction: column; align-items: center;
        justify-content: center; gap: 16px; padding: 48px;
    }
    .no-conv-icon {
        width: 88px; height: 88px; border-radius: 24px; background: var(--brand-lt);
        display: flex; align-items: center; justify-content: center;
        font-size: 36px; color: var(--brand);
        animation: scaleUp .5s .1s ease both; opacity: 0; animation-fill-mode: both;
    }

    /* ── COMPOSE MODAL ── */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 500;
        display: none; align-items: center; justify-content: center; padding: 20px;
        backdrop-filter: blur(6px);
    }
    .modal-overlay.open { display: flex; animation: fadeIn .2s ease both; }
    .modal-box {
        background: #fff; border-radius: 22px; width: 100%; max-width: 540px;
        box-shadow: 0 24px 80px rgba(0,0,0,.2);
        animation: scaleUp .25s cubic-bezier(.34,1.1,.64,1) both;
    }
    .modal-header {
        padding: 22px 24px 18px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .modal-title { font-family: 'Lora',serif; font-size: 20px; color: var(--dark); }
    .modal-close {
        width: 34px; height: 34px; border-radius: 9px; background: #f3f2ee;
        border: none; cursor: pointer; font-size: 14px; color: var(--muted);
        display: flex; align-items: center; justify-content: center; transition: all .18s;
    }
    .modal-close:hover { background: #fee2e2; color: #dc2626; }
    .modal-body { padding: 22px 24px; display: flex; flex-direction: column; gap: 16px; }
    .form-label { font-size: 12px; font-weight: 800; color: var(--dark); margin-bottom: 6px; display: block; text-transform: uppercase; letter-spacing: .06em; }
    .form-select, .form-input, .form-textarea {
        width: 100%; padding: 10px 13px; border-radius: 11px;
        border: 1.5px solid var(--border); font-family: inherit; font-size: 13.5px;
        color: var(--dark); background: #fafaf7; outline: none;
        transition: border-color .18s, background .18s; font-weight: 500;
    }
    .form-select:focus, .form-input:focus, .form-textarea:focus {
        border-color: var(--orange); background: #fff;
    }
    .form-textarea { resize: vertical; min-height: 100px; line-height: 1.65; }
    .modal-footer {
        padding: 16px 24px; border-top: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
    }
    .btn-cancel {
        padding: 10px 18px; border-radius: 10px; background: #f3f2ee;
        border: none; font-family: inherit; font-size: 13px; font-weight: 700;
        color: var(--muted); cursor: pointer; transition: all .18s;
    }
    .btn-cancel:hover { background: #ebe9e4; }
    .btn-send-modal {
        padding: 10px 22px; border-radius: 10px;
        background: var(--orange); color: #fff; border: none;
        font-family: inherit; font-size: 13px; font-weight: 700;
        cursor: pointer; transition: all .2s; display: flex; align-items: center; gap: 7px;
        box-shadow: 0 4px 14px rgba(239,125,0,.28);
    }
    .btn-send-modal:hover { background: #d97000; transform: translateY(-1px); }

    /* ── MOBILE ── */
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

    @media (max-width:900px) {
        .msg-layout { grid-template-columns: 1fr; }
        .chat-panel { display: none; }
        .chat-panel.mobile-open { display: flex; }
        .msg-sidebar { height: auto; min-height: 0; }
        .thread-list { max-height: 60vh; }
    }
    @media (max-width:640px) {
        .pw { padding: 18px 14px 100px; }
        .mob-bar { display: flex; }
        .sponsor-chip { display: none !important; }
        .header-inner { padding: 0 14px; height: 60px; }
        .hdr-logo { height: 46px; }
        .hdr-nav { display: none; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .page-title { font-size: 24px; }
    }
    </style>
</head>
<body>

{{-- ════════════════════ HEADER ════════════════════ --}}
<header class="site-header">
    <div class="header-inner">
        <a href="{{ route('home') }}">
            <img src="{{  asset('images/logo.png') }}" class="hdr-logo" alt="{{ $settings['site_name'] ?? 'Logo' }}">
        </a>
        <nav class="hdr-nav">
            <a href="{{ route('sponsor.dashboard') }}" class="hdr-nav-link">
                <i class="fas fa-user-friends" style="font-size:12px"></i> My Child
            </a>
            <a href="{{ route('sponsor.contact') }}" class="hdr-nav-link active">
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
            <div class="sponsor-chip hidden md:flex">
                <div class="s-avatar">{{ strtoupper(substr($sponsor->first_name, 0, 1)) }}</div>
                <div>
                    <div class="s-name">{{ $sponsor->full_name }}</div>
                    <div class="s-email">{{ $sponsor->email }}</div>
                </div>
            </div>
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

    {{-- Page header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <div class="page-title-icon"><i class="far fa-envelope"></i></div>
                Messages
                @php $totalUnread = $threads->sum(fn($t) => $t['unread_count']); @endphp
                @if($totalUnread > 0)
                <span style="background:var(--orange);color:#fff;border-radius:999px;font-size:12px;font-weight:900;padding:2px 10px;font-family:'Plus Jakarta Sans',sans-serif">
                    {{ $totalUnread }} unread
                </span>
                @endif
            </h1>
            <p class="page-subtitle">Your conversation history with our team</p>
        </div>
        <button class="btn-compose" onclick="openCompose()">
            <i class="fas fa-pen-to-square" style="font-size:12px"></i> New message
        </button>
    </div>

    {{-- Messages layout --}}
    <div class="msg-layout">

        {{-- ── SIDEBAR ── --}}
        <div class="msg-sidebar">
            <div class="sidebar-search">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="thread-search" placeholder="Search messages…" oninput="filterThreads(this.value)">
                </div>
            </div>

            {{-- Filter pills --}}
            <div class="filter-pills">
                @php
                    $allCount    = $threads->count();
                    $unreadCount = $threads->where('unread_count', '>', 0)->count();
                    $childCount  = $threads->where('entity_type', 'child')->count();
                    $familyCount = $threads->where('entity_type', 'family')->count();
                @endphp
                <button class="fpill active" id="fpill-all" onclick="filterByType('all', this)">
                    All <span class="fpill-count">{{ $allCount }}</span>
                </button>
                @if($unreadCount > 0)
                <button class="fpill" id="fpill-unread" onclick="filterByType('unread', this)">
                    Unread <span class="fpill-count">{{ $unreadCount }}</span>
                </button>
                @endif
                @if($childCount > 0)
                <button class="fpill" id="fpill-child" onclick="filterByType('child', this)">
                    Child <span class="fpill-count">{{ $childCount }}</span>
                </button>
                @endif
                @if($familyCount > 0)
                <button class="fpill" id="fpill-family" onclick="filterByType('family', this)">
                    Family <span class="fpill-count">{{ $familyCount }}</span>
                </button>
                @endif
            </div>

            {{-- Thread list --}}
            <div class="thread-list" id="thread-list">
                @forelse($threads as $thread)
                <div class="thread-item {{ $thread['unread_count'] > 0 ? 'unread' : '' }}"
                     id="thread-{{ $thread['id'] }}"
                     data-type="{{ $thread['entity_type'] }}"
                     data-name="{{ strtolower($thread['name']) }}"
                     onclick="openThread({{ $thread['id'] }}, this)">
                    @if(!empty($thread['photo']))
                        <img src="{{ asset($thread['photo']) }}" class="thread-avatar" alt="">
                    @else
                        <div class="thread-avatar-icon">{{ strtoupper(substr($thread['name'], 0, 1)) }}</div>
                    @endif
                    <div class="thread-body">
                        <div class="thread-row1">
                            <span class="thread-name">{{ $thread['name'] }}</span>
                            <span class="thread-time">{{ $thread['last_date'] }}</span>
                        </div>
                        <div class="thread-preview">
                            @if($thread['last_sender'] === 'sponsor') <span style="color:var(--orange);font-weight:700">You: </span>@endif
                            {{ $thread['last_message'] }}
                        </div>
                        <div class="thread-badges">
                            <span class="t-tag t-tag-{{ $thread['entity_type'] }}">
                                {{ $thread['entity_type'] === 'child' ? 'Child' : ($thread['entity_type'] === 'family' ? 'Family' : 'Admin') }}
                            </span>
                            @if($thread['unread_count'] > 0)
                            <span class="unread-badge">{{ $thread['unread_count'] }}</span>
                            @endif
                        </div>
                    </div>
                    @if($thread['unread_count'] > 0)
                    <div class="unread-dot" id="dot-{{ $thread['id'] }}"></div>
                    @endif
                </div>
                @empty
                <div class="empty-threads">
                    <i class="far fa-comments"></i>
                    <p>No messages yet.<br>Send your first message!</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ── CHAT PANEL ── --}}
        <div class="chat-panel" id="chat-panel">

            {{-- Default / no thread selected --}}
            <div class="no-conv-selected" id="no-conv">
                <div class="no-conv-icon"><i class="far fa-comment-dots"></i></div>
                <h3 style="font-family:'Lora',serif;font-size:20px;color:var(--dark);text-align:center">Select a conversation</h3>
                <p style="font-size:13px;color:var(--muted);text-align:center;max-width:260px;line-height:1.65">Choose a thread from the left to read your messages, or compose a new one.</p>
                <button class="btn-compose" onclick="openCompose()" style="font-size:13px;padding:10px 18px">
                    <i class="fas fa-pen-to-square" style="font-size:11px"></i> New message
                </button>
            </div>

            {{-- Active thread view (hidden until selected) --}}
            <div id="thread-view" style="display:none;flex:1;flex-direction:column;overflow:hidden">
                {{-- Chat header (filled by JS) --}}
                <div class="chat-header" id="chat-header-content">
                    <div class="chat-header-icon" id="ch-icon"><i class="fas fa-user"></i></div>
                    <div class="chat-header-info">
                        <div class="chat-header-name" id="ch-name">—</div>
                        <div class="chat-header-sub">
                            <span class="online-dot"></span>
                            <span id="ch-sub">Team Support</span>
                        </div>
                    </div>
                    <div class="chat-header-actions">
                        <button class="chat-action-btn" title="Mark all as read" onclick="markThreadRead(currentThread)">
                            <i class="fas fa-check-double"></i>
                        </button>
                        <button class="chat-action-btn" title="Back" onclick="closeThread()" id="back-btn" style="display:none">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </div>
                </div>

                {{-- Messages body --}}
                <div class="chat-body" id="chat-body">
                    {{-- Populated by JS from thread data --}}
                </div>

                {{-- Input --}}
                <div class="chat-footer">
                    <div class="chat-form" id="chat-form">
                        <textarea id="msg-input" placeholder="Write your message…" rows="1" oninput="autoResize(this); updateCharCount(this);" onkeydown="handleKey(event)"></textarea>
                        <div class="chat-form-actions">
                            <span class="char-count" id="char-count">0</span>
                            <label class="attach-btn" title="Attach file">
                                <i class="fas fa-paperclip"></i>
                                <input type="file" style="display:none" id="file-attach" onchange="handleAttachment(this)">
                            </label>
                            <button class="send-btn" onclick="sendMessage()" title="Send">
                                <i class="fas fa-paper-plane" style="font-size:12px;margin-left:1px"></i>
                            </button>
                        </div>
                    </div>
                    <div id="attach-preview" style="margin-top:8px;display:none">
                        <div style="display:inline-flex;align-items:center;gap:7px;background:#f5f2ed;border-radius:9px;padding:6px 10px;font-size:12px;font-weight:700;color:var(--dark)">
                            <i class="fas fa-file" style="color:var(--orange)"></i>
                            <span id="attach-name"></span>
                            <button onclick="removeAttach()" style="background:none;border:none;cursor:pointer;color:var(--muted);font-size:13px;padding:0;line-height:1">×</button>
                        </div>
                    </div>
                    <p style="font-size:10px;color:var(--muted);margin-top:8px;font-weight:600;padding:0 2px">
                        <i class="fas fa-lock" style="font-size:9px;margin-right:3px"></i>
                        Messages are reviewed by our team · Response within 48h
                    </p>
                </div>
            </div>
        </div>

    </div><!-- /msg-layout -->
</div><!-- /pw -->

{{-- ── COMPOSE MODAL ── --}}
<div class="modal-overlay" id="compose-modal" onclick="closeCompose(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h2 class="modal-title">New message</h2>
            <button class="modal-close" onclick="closeCompose()"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('sponsor.messages.send') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div>
                    <label class="form-label">Regarding</label>
                    <select name="entity_type" class="form-select" id="entity-type-select" onchange="updateEntityList(this.value)" required>
                        <option value="">— Choose —</option>
                        @foreach($children as $child)
                        <option value="child_{{ $child->id }}">{{ $child->first_name }} {{ $child->last_name }} (Child)</option>
                        @endforeach
                        @foreach($families as $family)
                        <option value="family_{{ $family->id }}">{{ $family->name }} (Family)</option>
                        @endforeach
                        <option value="general">General inquiry</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-input" placeholder="Message subject…" required>
                </div>
                <div>
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-textarea" placeholder="Write your message here…" required></textarea>
                </div>
                <div>
                    <label class="form-label">Attachment <span style="font-weight:500;text-transform:none;color:var(--muted)">(optional)</span></label>
                    <input type="file" name="attachment" class="form-input" style="padding:8px;font-size:12px" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeCompose()">Cancel</button>
                <button type="submit" class="btn-send-modal">
                    <i class="fas fa-paper-plane" style="font-size:11px"></i> Send message
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MOBILE BOTTOM BAR ── --}}
<div class="mob-bar" id="mob-bar">
    <a href="{{ route('sponsor.dashboard') }}" class="mob-nav-item">
        <i class="fas fa-user-friends"></i><span>My Child</span>
    </a>
    <a href="{{ route('sponsor.contact') }}" class="mob-nav-item active">
        <i class="far fa-envelope"></i><span>Messages</span>
    </a>
    <a href="{{ route('support.donate') }}" class="mob-nav-item">
        <i class="fas fa-hand-holding-heart"></i><span>Sponsorship</span>
    </a>
    <a href="{{ route('home') }}" class="mob-nav-item">
        <i class="far fa-newspaper"></i><span>News</span>
    </a>
    <form method="POST" action="{{ route('sponsor.logout') }}" style="margin:0;flex:1;display:flex">
        @csrf
        <button type="submit" class="mob-nav-item mob-nav-logout" style="color:var(--muted)">
            <i class="fas fa-sign-out-alt"></i><span>Logout</span>
        </button>
    </form>
</div>

{{-- ── THREAD DATA (JSON for JS) ── --}}
<script id="thread-data" type="application/json">
   @json($threads)
</script>

<script>
const THREADS = JSON.parse(document.getElementById('thread-data').textContent);
const SPONSOR_NAME = @json($sponsor->full_name);
const SPONSOR_INIT = @json(strtoupper(substr($sponsor->first_name, 0, 1)));
const MARK_READ_URL = @json(route('sponsor.messages.markRead'));
const CSRF = @json(csrf_token());

let currentThread = null;
let attachFile    = null;

/* ── Thread selection ── */
function openThread(id, el) {
    const thread = THREADS.find(t => t.id == id);
    if (!thread) return;

    currentThread = id;

    // Sidebar active state
    document.querySelectorAll('.thread-item').forEach(t => t.classList.remove('active'));
    el.classList.add('active');

    // Show thread-view
    document.getElementById('no-conv').style.display = 'none';
    const tv = document.getElementById('thread-view');
    tv.style.display = 'flex';

    // Back button on mobile
    document.getElementById('back-btn').style.display = window.innerWidth <= 900 ? 'flex' : 'none';

    // Fill header
    document.getElementById('ch-name').textContent = thread.name;
    document.getElementById('ch-sub').textContent  = thread.entity_type === 'child' ? 'Child updates' : (thread.entity_type === 'family' ? 'Family updates' : 'Team Support');
    const icon = document.getElementById('ch-icon');
    if (thread.photo) {
        icon.outerHTML = `<img src="${thread.photo}" class="chat-header-avatar" id="ch-icon" alt="">`;
    } else {
        icon.innerHTML = `<i class="fas fa-${thread.entity_type === 'family' ? 'home' : 'child'}"></i>`;
    }

    // Render messages
    renderMessages(thread);

    // Mark as read
    if (thread.unread_count > 0) {
        markThreadRead(id);
    }
}

function closeThread() {
    document.getElementById('no-conv').style.display = 'flex';
    document.getElementById('thread-view').style.display = 'none';
    document.querySelectorAll('.thread-item').forEach(t => t.classList.remove('active'));
    currentThread = null;
}

/* ── Render messages ── */
function renderMessages(thread) {
    const body = document.getElementById('chat-body');
    body.innerHTML = '';

    const messages = thread.messages || [];
    if (messages.length === 0) {
        body.innerHTML = `
            <div class="chat-empty">
                <div class="chat-empty-icon"><i class="far fa-comment-smile"></i></div>
                <h3>No messages yet</h3>
                <p>Start the conversation by sending a message about ${thread.name}.</p>
            </div>`;
        return;
    }

    // Group by date
    let lastDate = null;
    let hasUnreadBanner = false;
    let unreadStart = thread.unread_count > 0 ? messages.length - thread.unread_count : -1;

    messages.forEach((msg, i) => {
        const d = new Date(msg.created_at);
        const dateStr = formatDate(d);

        // Date divider
        if (dateStr !== lastDate) {
            const div = document.createElement('div');
            div.className = 'date-divider';
            div.innerHTML = `<span>${dateStr}</span>`;
            body.appendChild(div);
            lastDate = dateStr;
        }

        // Unread banner
        if (!hasUnreadBanner && i === unreadStart && thread.unread_count > 0) {
            const banner = document.createElement('div');
            banner.className = 'unread-banner';
            banner.innerHTML = `<i class="fas fa-arrow-down" style="font-size:11px"></i> ${thread.unread_count} new message${thread.unread_count > 1 ? 's' : ''}`;
            body.appendChild(banner);
            hasUnreadBanner = true;
        }

        const isMe = msg.sender === 'sponsor';
        const row  = document.createElement('div');
        row.className = `msg-row ${isMe ? 'me' : ''}`;

        const avatar = isMe
            ? `<div class="msg-row-icon me-icon">${SPONSOR_INIT}</div>`
            : `<div class="msg-row-icon" style="background:linear-gradient(135deg,#fde68a,#f97316)"><i class="fas fa-${thread.entity_type === 'family' ? 'home' : 'user'}" style="font-size:11px;color:#fff"></i></div>`;

        let attachmentHTML = '';
        if (msg.attachment_url) {
            const cls = isMe ? '' : 'them-att';
            attachmentHTML = `
                <a href="${msg.attachment_url}" class="bubble-attachment ${cls}" download target="_blank">
                    <i class="fas fa-file-pdf" style="${isMe ? 'color:#fff' : 'color:#ef4444'}"></i>
                    <div class="att-info">
                        <div class="att-name">${msg.attachment_name || 'Attachment'}</div>
                        <div class="att-size">${msg.attachment_size || ''}</div>
                    </div>
                    <i class="fas fa-download att-dl" style="${isMe ? 'color:#fff' : ''}"></i>
                </a>`;
        }

        const ticks = isMe
            ? `<i class="fas fa-check-double read-tick" style="${msg.read_at ? '' : 'color:var(--muted)'}"></i>`
            : '';

        row.innerHTML = `
            ${avatar}
            <div class="bubble-wrap">
                <div class="bubble ${isMe ? 'me' : 'them'}">
                    ${msg.body ? `<span>${escHtml(msg.body)}</span>` : ''}
                    ${attachmentHTML}
                </div>
                <div class="bubble-meta">
                    ${!isMe ? `<span>${thread.name}</span> ·` : ''}
                    <span>${formatTime(d)}</span>
                    ${ticks}
                </div>
            </div>`;
        body.appendChild(row);
    });

    // Scroll to bottom
    setTimeout(() => { body.scrollTop = body.scrollHeight; }, 60);
}

/* ── Mark as read ── */
function markThreadRead(id) {
    const thread = THREADS.find(t => t.id == id); if (!thread) return;
    thread.unread_count = 0;
    // Remove UI indicators
    const dot = document.getElementById('dot-' + id);
    if (dot) dot.remove();
    const badge = document.querySelector(`#thread-${id} .unread-badge`);
    if (badge) badge.remove();
    document.getElementById(`thread-${id}`)?.classList.remove('unread');
    // Recalculate total badge in title
    const total = THREADS.reduce((s, t) => s + (t.unread_count || 0), 0);
    // Server call
    fetch(MARK_READ_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ thread_id: id })
    }).catch(() => {});
}

/* ── Send message ── */
function sendMessage() {
    if (!currentThread) return;
    const input   = document.getElementById('msg-input');
    const body    = input.value.trim();
    if (!body && !attachFile) return;

    // Optimistic UI
    const thread  = THREADS.find(t => t.id == currentThread);
    const now     = new Date();
    const fakeMsg = {
        id: 'tmp-' + Date.now(),
        sender: 'sponsor',
        body: body,
        created_at: now.toISOString(),
        read_at: null,
        attachment_url: null,
        attachment_name: attachFile ? attachFile.name : null,
    };
    if (!thread.messages) thread.messages = [];
    thread.messages.push(fakeMsg);
    thread.last_message = body || (attachFile ? attachFile.name : '');
    thread.last_date = 'Just now';

    renderMessages(thread);
    input.value = ''; autoResize(input); updateCharCount(input);
    removeAttach();

    // Update thread preview
    const previewEl = document.querySelector(`#thread-${currentThread} .thread-preview`);
    if (previewEl) previewEl.innerHTML = `<span style="color:var(--orange);font-weight:700">You: </span>${thread.last_message}`;

    // Show typing indicator after send
    showTyping();

    // POST to server
    const formData = new FormData();
    formData.append('thread_id', currentThread);
    formData.append('message', body);
    if (attachFile) formData.append('attachment', attachFile);
    formData.append('_token', CSRF);

    fetch(@json(route('sponsor.messages.reply')), {
        method: 'POST',
        body: formData,
    }).catch(() => {});
}

function showTyping() {
    const body = document.getElementById('chat-body');
    const ty = document.createElement('div');
    ty.className = 'typing-indicator'; ty.id = 'typing-indicator';
    ty.innerHTML = `<div class="msg-row-icon" style="background:linear-gradient(135deg,#fde68a,#f97316);width:30px;height:30px;border-radius:9px;display:flex;align-items:center;justify-content:center"><i class="fas fa-user" style="font-size:11px;color:#fff"></i></div><div class="typing-dots"><span></span><span></span><span></span></div>`;
    body.appendChild(ty);
    body.scrollTop = body.scrollHeight;
    setTimeout(() => ty.remove(), 3200);
}

/* ── Filters ── */
function filterByType(type, btn) {
    document.querySelectorAll('.fpill').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.thread-item').forEach(item => {
        const show = type === 'all'
            ? true
            : type === 'unread'
            ? item.querySelector('.unread-badge') !== null
            : item.dataset.type === type;
        item.style.display = show ? '' : 'none';
    });
}

function filterThreads(q) {
    q = q.toLowerCase();
    document.querySelectorAll('.thread-item').forEach(item => {
        item.style.display = item.dataset.name.includes(q) ? '' : 'none';
    });
}

/* ── Compose modal ── */
function openCompose()  { document.getElementById('compose-modal').classList.add('open'); }
function closeCompose(e){ if (!e || e.target === document.getElementById('compose-modal')) document.getElementById('compose-modal').classList.remove('open'); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') document.getElementById('compose-modal').classList.remove('open'); });

/* ── Helpers ── */
function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 120) + 'px';
}
function updateCharCount(el) {
    document.getElementById('char-count').textContent = el.value.length;
}
function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
}
function handleAttachment(input) {
    if (input.files[0]) {
        attachFile = input.files[0];
        document.getElementById('attach-preview').style.display = 'block';
        document.getElementById('attach-name').textContent = attachFile.name;
    }
}
function removeAttach() {
    attachFile = null;
    document.getElementById('attach-preview').style.display = 'none';
    document.getElementById('file-attach').value = '';
}
function formatDate(d) {
    const today = new Date(), yesterday = new Date(today); yesterday.setDate(today.getDate() - 1);
    if (d.toDateString() === today.toDateString()) return 'Today';
    if (d.toDateString() === yesterday.toDateString()) return 'Yesterday';
    return d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
}
function formatTime(d) {
    return d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
}
function escHtml(str) {
    const d = document.createElement('div'); d.textContent = str; return d.innerHTML;
}

// Open first unread or first thread on load
document.addEventListener('DOMContentLoaded', () => {
    const firstUnread = document.querySelector('.thread-item.unread');
    const first = firstUnread || document.querySelector('.thread-item');
    if (first && window.innerWidth > 900) first.click();
});
</script>
</body>
</html>