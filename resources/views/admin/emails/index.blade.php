{{-- resources/views/admin/emails/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Email Management')

@push('styles')
<style>
/* ══════════════════════════════════════════════════════════
   EMAIL PAGE — RESPONSIVE LAYOUT
══════════════════════════════════════════════════════════ */
.email-split {
    display: grid;
    grid-template-columns: 420px 1fr;
    gap: 24px;
    align-items: start;
}

/* ── Tablet (≤1200px): stack, preview below ── */
@media (max-width: 1200px) {
    .email-split { grid-template-columns: 1fr; gap: 16px; }
    .preview-panel { order: 2; position: static !important; }
}

/* ── Mobile (≤640px) ── */
@media (max-width: 640px) {
    .email-split { gap: 12px; }

    /* Page header — stack vertically */
    .email-page-header { flex-direction: column !important; align-items: flex-start !important; gap: 10px !important; }
    .gmail-badge { align-self: flex-start; }

    /* Cards — tighter padding */
    .card { padding: 14px !important; }

    /* Tab pills — side by side on mobile */
    .email-tabs-row { display: grid !important; grid-template-columns: 1fr 1fr; gap: 8px; }
    .email-tab-pill { padding: 10px 12px !important; font-size: 12px !important; }
    .email-tab-pill .pill-desc { display: none; } /* hide subtitle on mobile */

    /* Language selector — 3 cols already fine but tighter */
    #langSelector { gap: 6px; }
    .elang-btn { padding: 8px 4px !important; }
    .elang-btn .text-xl { font-size: 16px !important; }

    /* Name grid — stack on very small screens */
    .name-grid { grid-template-columns: 1fr !important; }

    /* Sponsor search action buttons — show icons only */
    .sp-action-btn { padding: 6px 8px !important; font-size: 13px !important; }

    /* Dropdown items — tighter */
    .sponsor-drop-item { padding: 9px 10px; gap: 8px; }
    .sponsor-drop-item .sp-avatar { width: 30px; height: 30px; font-size: 11px; }

    /* Send button — full height touch target */
    .send-btn { padding: 15px !important; font-size: 14px !important; }

    /* History items */
    .history-item { padding: 8px 10px; }

    /* Toast — full width */
    .send-toast { border-radius: 10px; font-size: 12px; }

    /* Preview — collapsible on mobile */
    .preview-toggle-btn { display: flex !important; }
    .preview-collapsible { transition: max-height .35s ease, opacity .3s ease; overflow: hidden; max-height: 1200px; }
    .preview-collapsible.collapsed { max-height: 0 !important; opacity: 0; pointer-events: none; }
    .preview-body { min-height: 340px !important; }
    #emailPreviewFrame { height: 480px !important; }
    .preview-loading { height: 480px !important; }

    /* Width selector buttons — wrap nicely */
    .preview-widths { flex-wrap: wrap; gap: 6px; }
    .preview-widths button { font-size: 11px; padding: 6px 10px; }
}

/* ── Very small (≤380px) ── */
@media (max-width: 380px) {
    .email-tab-pill .pill-badge { display: none; }
    .name-grid { grid-template-columns: 1fr !important; }
}

/* ── Tab Pills ── */
.email-tab-pill {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 20px; border-radius: 12px; border: 2px solid transparent;
    font-size: 13px; font-weight: 700; cursor: pointer;
    transition: all .22s cubic-bezier(.4,0,.2,1); background: transparent;
    width: 100%; text-align: left; color: #6b7280;
}
.email-tab-pill:hover { background: #fff7ed; color: #f97316; border-color: #fed7aa; }
.email-tab-pill.active {
    background: linear-gradient(135deg,#fff7ed,#fef3c7);
    color: #c2410c; border-color: #fed7aa;
    box-shadow: 0 2px 10px rgba(249,115,22,.15);
}
.email-tab-pill .pill-icon {
    width: 32px; height: 32px; border-radius: 9px; display: flex;
    align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;
    background: rgba(249,115,22,.1); transition: background .2s;
}
.email-tab-pill.active .pill-icon { background: rgba(249,115,22,.2); }
.email-tab-pill .pill-badge {
    margin-left: auto; background: #f97316; color: #fff;
    font-size: 9px; padding: 2px 7px; border-radius: 99px; font-weight: 700;
}

/* ── Form Fields ── */
.ef-label {
    display: block; font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .7px;
    color: #9ca3af; margin-bottom: 6px;
}
.ef-input {
    width: 100%; padding: 10px 14px; border-radius: 10px;
    border: 1.5px solid #e5e7eb; font-size: 14px; color: #111827;
    outline: none; transition: border-color .18s, box-shadow .18s;
    background: #fafafa;
    /* Prevent iOS zoom on focus */
    font-size: max(16px, 14px);
}
@media (min-width: 641px) {
    .ef-input { font-size: 14px; }
}
.ef-input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.1); background: #fff; }
.ef-input.error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.1); }

/* ── Send Button ── */
.send-btn {
    width: 100%; padding: 13px; border-radius: 12px;
    background: linear-gradient(135deg,#f97316,#ea580c);
    color: #fff; font-size: 15px; font-weight: 700; border: none;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .22s; box-shadow: 0 4px 14px rgba(249,115,22,.35);
    letter-spacing: .2px; min-height: 48px;
}
.send-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(249,115,22,.45); }
.send-btn:active { transform: translateY(0); }
.send-btn.loading { opacity: .75; pointer-events: none; }
.send-btn .btn-spinner {
    width: 16px; height: 16px; border: 2px solid rgba(255,255,255,.4);
    border-top-color: #fff; border-radius: 50%; animation: spin .7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Preview Panel ── */
.preview-panel { position: sticky; top: 24px; }
.preview-toggle-btn {
    display: none; /* hidden on desktop, shown on mobile via CSS */
    align-items: center; justify-content: space-between;
    width: 100%; padding: 12px 16px;
    background: linear-gradient(135deg,#0f172a,#1e293b);
    border-radius: 12px; border: none; cursor: pointer;
    color: rgba(255,255,255,.7); font-size: 13px; font-weight: 700;
    margin-bottom: 0;
}
.preview-toggle-btn i { transition: transform .3s; }
.preview-toggle-btn.open i.fa-chevron-down { transform: rotate(180deg); }
.preview-header {
    background: linear-gradient(135deg,#0f172a,#1e293b);
    border-radius: 16px 16px 0 0; padding: 14px 20px;
    display: flex; align-items: center; gap: 10px;
}
.preview-dots span {
    width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px;
}
.preview-browser-bar {
    flex: 1; background: rgba(255,255,255,.08); border-radius: 6px;
    padding: 5px 12px; font-size: 11px; color: rgba(255,255,255,.4); font-family: monospace;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.preview-body {
    border: 2px solid #e5e7eb; border-top: none; border-radius: 0 0 16px 16px;
    overflow: hidden; background: #f0f4ff; min-height: 640px;
}
#emailPreviewFrame {
    width: 100%; height: 720px; border: none; display: block;
    background: #f0f4ff;
}
.preview-loading {
    display: flex; align-items: center; justify-content: center;
    height: 720px; flex-direction: column; gap: 12px; color: #9ca3af;
}
.preview-loading .pulse-ring {
    width: 44px; height: 44px; border-radius: 50%;
    border: 3px solid #e5e7eb; border-top-color: #f97316;
    animation: spin .8s linear infinite;
}

/* ── History Item ── */
.history-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; border-radius: 10px;
    border: 1px solid #f3f4f6; transition: background .15s;
}
.history-item:hover { background: #f9fafb; }
.history-badge {
    font-size: 9px; font-weight: 700; padding: 2px 8px; border-radius: 99px;
    text-transform: uppercase; letter-spacing: .5px;
}
.badge-created { background: #d1fae5; color: #065f46; }
.badge-reset   { background: #dbeafe; color: #1e40af; }

/* ── Auto-generate toggle ── */
.auto-gen-pill {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 700; color: #6366f1;
    background: #eef2ff; border: 1.5px solid #c7d2fe;
    border-radius: 99px; padding: 4px 10px; cursor: pointer;
    transition: all .15s; user-select: none;
}
.auto-gen-pill:hover { background: #e0e7ff; }

/* ── Status toast ── */
.send-toast {
    display: none; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 12px; margin-bottom: 16px;
    font-size: 13px; font-weight: 600; animation: alertIn .4s both;
}
.send-toast.show { display: flex; }
.send-toast.ok  { background: #f0fdf4; border: 1.5px solid #86efac; color: #166534; }
.send-toast.err { background: #fef2f2; border: 1.5px solid #fca5a5; color: #991b1b; }

/* ── Sponsor search ── */
.sponsor-search-wrap { position: relative; }
.sponsor-drop-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; cursor: pointer;
    border-bottom: 1px solid #f3f4f6; transition: background .12s;
}
.sponsor-drop-item:last-child { border-bottom: none; }
.sponsor-drop-item:hover { background: #f9fafb; }
.sponsor-drop-item .sp-avatar {
    width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: #fff;
    background: linear-gradient(135deg,#f97316,#ea580c);
}
.sponsor-drop-item .sp-info { flex: 1; min-width: 0; }
.sponsor-drop-item .sp-name { font-size: 13px; font-weight: 700; color: #111827; }
.sponsor-drop-item .sp-email { font-size: 11px; color: #9ca3af; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.sponsor-drop-item .sp-actions { display: flex; gap: 5px; flex-shrink: 0; }
.sp-action-btn {
    font-size: 10px; font-weight: 700; padding: 4px 8px; border-radius: 7px;
    border: 1.5px solid; cursor: pointer; transition: all .15s; white-space: nowrap;
    min-width: 28px; min-height: 28px; display: flex; align-items: center; justify-content: center;
}
.sp-action-btn.fill    { border-color: #d1d5db; color: #6b7280; background: #f9fafb; }
.sp-action-btn.fill:hover { border-color: #f97316; color: #f97316; background: #fff7ed; }
.sp-action-btn.created { border-color: #86efac; color: #15803d; background: #f0fdf4; }
.sp-action-btn.created:hover { border-color: #22c55e; background: #dcfce7; }
.sp-action-btn.reset   { border-color: #c7d2fe; color: #4f46e5; background: #eef2ff; }
.sp-action-btn.reset:hover { border-color: #6366f1; background: #e0e7ff; }
.sp-drop-empty { padding: 20px; text-align: center; color: #9ca3af; font-size: 12px; }

/* ── elang active ── */
.elang-btn.active { border-color: #f97316 !important; background: linear-gradient(135deg,#fff7ed,#fef3c7) !important; color: #c2410c !important; box-shadow: 0 2px 10px rgba(249,115,22,.2); }
.elang-btn.active span { color: inherit; }
</style>
@endpush

@section('content')
@php
    /* ── Load settings the same way the layout does ── */
    $headerSettings = (function() {
        $file = storage_path('app/settings.json');
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    })();
    $emailLogoPath = !empty($headerSettings['logo'])
        ? asset($headerSettings['logo'])
        : asset('images/logo.png');
    $emailSiteName = $headerSettings['site_name'] ?? 'Des Ailes pour Grandir';

    /* ── All sponsors as JSON for JS search ── */
    $allSponsors = \App\Models\Sponsor::orderBy('first_name')
        ->get(['id','first_name','last_name','email','username'])
        ->map(fn($s) => [
            'id'         => $s->id,
            'first'      => $s->first_name ?? '',
            'last'       => $s->last_name  ?? '',
            'email'      => $s->email,
            'username'   => $s->username   ?? '',
            'label'      => trim(($s->first_name ?? '').' '.($s->last_name ?? '')).' ('.$s->email.')',
        ])->values();
@endphp

{{-- Page Header --}}
<div class="page-header">
    <div class="email-page-header flex items-center justify-between gap-4 mb-2">
        <div>
            <h1 class="page-title"
                data-fr="Gestion des Emails" data-en="Email Management" data-km="គ្រប់គ្រងអ៊ីមែល">Email Management</h1>
            <p class="page-subtitle"
               data-fr="Envoyer des emails aux parrains — création de compte et réinitialisation"
               data-en="Send emails to sponsors — account creation and password reset"
               data-km="ផ្ញើអ៊ីមែលទៅអ្នកឧបត្ថម្ភ — បង្កើតគណនី និងកំណត់ពាក្យសម្ងាត់ឡើងវិញ">
                Send emails to sponsors — account creation and password reset
            </p>
        </div>
        {{-- Gmail badge --}}
        <div class="gmail-badge flex items-center gap-2 bg-white border border-gray-200 rounded-xl px-4 py-2 shadow-sm flex-shrink-0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6Z" fill="#EA4335"/><path d="M22 6L12 13L2 6" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
            <span class="text-xs font-bold text-gray-600">Gmail SMTP</span>
            <span class="w-2 h-2 rounded-full bg-green-500 shadow-sm"></span>
        </div>
    </div>
</div>

{{-- Send Toast --}}
<div id="sendToast" class="send-toast">
    <i class="fas fa-circle-check text-lg"></i>
    <span id="sendToastMsg">Email envoyé avec succès !</span>
</div>

{{-- Main Split Layout --}}
<div class="email-split">

    {{-- ══════════════════════════════════════
         LEFT — Tab + Form Panel
    ══════════════════════════════════════ --}}
    <div class="space-y-4">

        {{-- Email Type Tabs --}}
        <div class="card p-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                <span data-fr="Type d'Email" data-en="Email Type" data-km="ប្រភេទអ៊ីមែល">Email Type</span>
            </p>
            <div class="email-tabs-row space-y-2">
                <button class="email-tab-pill active" id="pill-created" onclick="switchEmailTab('created')">
                    <div class="pill-icon">🎉</div>
                    <div>
                        <div class="text-sm font-bold" data-fr="Compte Créé" data-en="Account Created" data-km="គណនីត្រូវបានបង្កើត">Account Created</div>
                        <div class="pill-desc text-xs text-gray-400 font-normal" data-fr="Envoyer les identifiants à un nouveau parrain" data-en="Send credentials to new sponsor" data-km="ផ្ញើព័ត៌មានចូលទៅអ្នកឧបត្ថម្ភថ្មី">Send credentials to new sponsor</div>
                    </div>
                    <span class="pill-badge">NEW</span>
                </button>
                <button class="email-tab-pill" id="pill-reset" onclick="switchEmailTab('reset')">
                    <div class="pill-icon">🔐</div>
                    <div>
                        <div class="text-sm font-bold" data-fr="Réinitialisation" data-en="Password Reset" data-km="កំណត់ពាក្យសម្ងាត់ឡើងវិញ">Password Reset</div>
                        <div class="pill-desc text-xs text-gray-400 font-normal" data-fr="Envoyer un nouveau mot de passe au parrain" data-en="Send new password to sponsor" data-km="ផ្ញើពាក្យសម្ងាត់ថ្មីទៅអ្នកឧបត្ថម្ភ">Send new password to sponsor</div>
                    </div>
                </button>
            </div>
        </div>

        {{-- ── EMAIL LANGUAGE SELECTOR ── --}}
        <div class="card p-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                <i class="fas fa-language mr-1"></i>
                <span data-fr="Langue de l'Email" data-en="Email Language" data-km="ភាសាអ៊ីមែល">Email Language</span>
            </p>
            <div class="grid grid-cols-3 gap-2" id="langSelector">
                <button onclick="setEmailLang('fr')" id="elang-fr"
                        class="elang-btn active flex flex-col items-center gap-1.5 py-3 px-2 rounded-xl border-2 border-orange-200 bg-orange-50 text-orange-700 transition-all">
                    <span class="text-xl">🇫🇷</span>
                    <span class="text-xs font-bold">Français</span>
                    <span class="text-[9px] text-orange-400 font-semibold uppercase tracking-wide">Défaut</span>
                </button>
                <button onclick="setEmailLang('en')" id="elang-en"
                        class="elang-btn flex flex-col items-center gap-1.5 py-3 px-2 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-500 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 transition-all">
                    <span class="text-xl">🇬🇧</span>
                    <span class="text-xs font-bold">English</span>
                    <span class="text-[9px] text-gray-400 font-semibold uppercase tracking-wide">Default</span>
                </button>
                <button onclick="setEmailLang('km')" id="elang-km"
                        class="elang-btn flex flex-col items-center gap-1.5 py-3 px-2 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-500 hover:border-red-200 hover:bg-red-50 hover:text-red-700 transition-all">
                    <span class="text-xl">🇰🇭</span>
                    <span class="text-xs font-bold">ខ្មែរ</span>
                    <span class="text-[9px] text-gray-400 font-semibold uppercase tracking-wide">លំនាំដើម</span>
                </button>
            </div>
            <p class="text-[10px] text-gray-400 mt-2 text-center">
                <i class="fas fa-info-circle"></i>
                <span id="langHint">L'email sera envoyé en Français</span>
            </p>
        </div>

        {{-- ── FORM: Account Created ── --}}
        <div id="form-created" class="card space-y-4">
            <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                <div class="w-9 h-9 rounded-xl bg-orange-50 border-2 border-orange-100 flex items-center justify-center text-lg">🎉</div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm" data-fr="Nouveau Compte Parrain" data-en="New Sponsor Account" data-km="គណនីអ្នកឧបត្ថម្ភថ្មី">New Sponsor Account</h3>
                    <p class="text-xs text-gray-400" data-fr="L'email contiendra les identifiants de connexion" data-en="Email will contain login credentials" data-km="អ៊ីមែលនឹងមានព័ត៌មានចូលប្រើ">Email will contain login credentials</p>
                </div>
            </div>

            {{-- ── Sponsor Search ── --}}
            <div class="sponsor-search-wrap" id="searchWrap-created">
                <label class="ef-label flex items-center gap-1.5">
                    <i class="fas fa-magnifying-glass text-orange-400 text-[10px]"></i>
                    <span data-fr="Rechercher un Parrain" data-en="Search Sponsor" data-km="ស្វែងរកអ្នកឧបត្ថម្ភ">Search Sponsor</span>
                    <span class="ml-auto text-[9px] font-normal text-gray-400 normal-case tracking-normal">auto-fills the form below</span>
                </label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                    <input type="text" id="sponsorSearch-created" class="ef-input pl-9 pr-8"
                           placeholder="Type name or email…"
                           oninput="filterSponsors('created', this.value)"
                           onfocus="showDropdown('created')"
                           autocomplete="off" />
                    <button onclick="clearSearch('created')" title="Clear"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 hover:text-red-400 transition text-xs hidden" id="clearBtn-created">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
                {{-- Dropdown results --}}
                <div id="sponsorDrop-created"
                     class="sponsor-drop hidden"
                     style="position:absolute;z-index:200;left:0;right:0;background:#fff;border:1.5px solid #e5e7eb;border-top:none;border-radius:0 0 12px 12px;max-height:260px;overflow-y:auto;box-shadow:0 8px 24px rgba(0,0,0,.1);">
                    {{-- filled by JS --}}
                </div>
            </div>

            {{-- First + Last name side by side --}}
            <div class="name-grid grid grid-cols-2 gap-3">
                <div>
                    <label class="ef-label" data-fr="Prénom" data-en="First Name" data-km="នាមខ្លួន">First Name</label>
                    <input type="text" id="c_first_name" class="ef-input" placeholder="Jean"
                           oninput="autoUsername('c'); debouncedPreview()" />
                </div>
                <div>
                    <label class="ef-label" data-fr="Nom de Famille" data-en="Last Name" data-km="នាមត្រកូល">Last Name</label>
                    <input type="text" id="c_last_name" class="ef-input" placeholder="Dupont"
                           oninput="autoUsername('c'); debouncedPreview()" />
                </div>
            </div>
            <div>
                <label class="ef-label" data-fr="Adresse Email" data-en="Email Address" data-km="អាសយដ្ឋានអ៊ីមែល">Email Address</label>
                <input type="email" id="c_email" class="ef-input" placeholder="jean@example.com"
                       oninput="debouncedPreview()" />
            </div>
            <div>
                <label class="ef-label flex items-center justify-between">
                    <span data-fr="Nom d'Utilisateur" data-en="Username" data-km="ឈ្មោះអ្នកប្រើ">Username</span>
                    <span class="text-[9px] text-indigo-400 font-bold uppercase tracking-wider bg-indigo-50 border border-indigo-100 rounded-full px-2 py-0.5">
                        <i class="fas fa-magic text-[8px]"></i> Auto-generated
                    </span>
                </label>
                <input type="text" id="c_username" class="ef-input" placeholder="jean.dupont"
                       oninput="debouncedPreview()" />
            </div>
            <div>
                <label class="ef-label flex items-center justify-between">
                    <span data-fr="Mot de Passe Temporaire" data-en="Temporary Password" data-km="ពាក្យសម្ងាត់បណ្ដោះអាសន្ន">Temporary Password</span>
                    <button type="button" class="auto-gen-pill" onclick="genPassword('c_password')">
                        <i class="fas fa-dice text-[10px]"></i>
                        <span data-fr="Générer" data-en="Generate" data-km="បង្កើត">Generate</span>
                    </button>
                </label>
                <div class="relative">
                    <input type="text" id="c_password" class="ef-input pr-10" placeholder="Temp@Pass123"
                           oninput="debouncedPreview()" />
                    <button type="button" onclick="copyVal('c_password')" title="Copy"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition">
                        <i class="fas fa-copy text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Send button --}}
            <button class="send-btn" id="btn-send-created" onclick="sendEmail('created')">
                <i class="fas fa-paper-plane"></i>
                <span data-fr="Envoyer l'Email de Bienvenue" data-en="Send Welcome Email" data-km="ផ្ញើអ៊ីមែលស្វាគមន៍">Send Welcome Email</span>
            </button>
        </div>

        {{-- ── FORM: Password Reset ── --}}
        <div id="form-reset" class="card space-y-4 hidden">
            <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 border-2 border-indigo-100 flex items-center justify-center text-lg">🔐</div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm" data-fr="Réinitialisation du Mot de Passe" data-en="Password Reset" data-km="កំណត់ពាក្យសម្ងាត់ឡើងវិញ">Password Reset</h3>
                    <p class="text-xs text-gray-400" data-fr="Envoyer un nouveau mot de passe généré" data-en="Send a newly generated password" data-km="ផ្ញើពាក្យសម្ងាត់ដែលបានបង្កើតថ្មី">Send a newly generated password</p>
                </div>
            </div>

            {{-- ── Sponsor Search ── --}}
            <div class="sponsor-search-wrap" id="searchWrap-reset">
                <label class="ef-label flex items-center gap-1.5">
                    <i class="fas fa-magnifying-glass text-indigo-400 text-[10px]"></i>
                    <span data-fr="Rechercher un Parrain" data-en="Search Sponsor" data-km="ស្វែងរកអ្នកឧបត្ថម្ភ">Search Sponsor</span>
                    <span class="ml-auto text-[9px] font-normal text-gray-400 normal-case tracking-normal">auto-fills the form below</span>
                </label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                    <input type="text" id="sponsorSearch-reset" class="ef-input pl-9 pr-8"
                           placeholder="Type name or email…"
                           oninput="filterSponsors('reset', this.value)"
                           onfocus="showDropdown('reset')"
                           autocomplete="off" />
                    <button onclick="clearSearch('reset')" title="Clear"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 hover:text-red-400 transition text-xs hidden" id="clearBtn-reset">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
                <div id="sponsorDrop-reset"
                     class="sponsor-drop hidden"
                     style="position:absolute;z-index:200;left:0;right:0;background:#fff;border:1.5px solid #e5e7eb;border-top:none;border-radius:0 0 12px 12px;max-height:260px;overflow-y:auto;box-shadow:0 8px 24px rgba(0,0,0,.1);">
                </div>
            </div>

            {{-- First + Last name side by side --}}
            <div class="name-grid grid grid-cols-2 gap-3">
                <div>
                    <label class="ef-label" data-fr="Prénom" data-en="First Name" data-km="នាមខ្លួន">First Name</label>
                    <input type="text" id="r_first_name" class="ef-input" placeholder="Jean"
                           oninput="autoUsername('r'); debouncedPreview()" />
                </div>
                <div>
                    <label class="ef-label" data-fr="Nom de Famille" data-en="Last Name" data-km="នាមត្រកូល">Last Name</label>
                    <input type="text" id="r_last_name" class="ef-input" placeholder="Dupont"
                           oninput="autoUsername('r'); debouncedPreview()" />
                </div>
            </div>
            <div>
                <label class="ef-label" data-fr="Adresse Email" data-en="Email Address" data-km="អាសយដ្ឋានអ៊ីមែល">Email Address</label>
                <input type="email" id="r_email" class="ef-input" placeholder="jean@example.com"
                       oninput="debouncedPreview()" />
            </div>
            <div>
                <label class="ef-label flex items-center justify-between">
                    <span data-fr="Nom d'Utilisateur" data-en="Username" data-km="ឈ្មោះអ្នកប្រើ">Username</span>
                    <span class="text-[9px] text-indigo-400 font-bold uppercase tracking-wider bg-indigo-50 border border-indigo-100 rounded-full px-2 py-0.5">
                        <i class="fas fa-magic text-[8px]"></i> Auto-generated
                    </span>
                </label>
                <input type="text" id="r_username" class="ef-input" placeholder="jean.dupont"
                       oninput="debouncedPreview()" />
            </div>
            <div>
                <label class="ef-label flex items-center justify-between">
                    <span data-fr="Nouveau Mot de Passe" data-en="New Password" data-km="ពាក្យសម្ងាត់ថ្មី">New Password</span>
                    <button type="button" class="auto-gen-pill" onclick="genPassword('r_password')">
                        <i class="fas fa-dice text-[10px]"></i>
                        <span data-fr="Générer" data-en="Generate" data-km="បង្កើត">Generate</span>
                    </button>
                </label>
                <div class="relative">
                    <input type="text" id="r_password" class="ef-input pr-10" placeholder="New@Pass456"
                           oninput="debouncedPreview()" />
                    <button type="button" onclick="copyVal('r_password')" title="Copy"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-500 transition">
                        <i class="fas fa-copy text-sm"></i>
                    </button>
                </div>
            </div>

            <button class="send-btn" id="btn-send-reset"
                    onclick="sendEmail('reset')"
                    style="background:linear-gradient(135deg,#4f46e5,#6366f1);box-shadow:0 4px 14px rgba(79,70,229,.35);">
                <i class="fas fa-paper-plane"></i>
                <span data-fr="Envoyer le Nouveau Mot de Passe" data-en="Send New Password" data-km="ផ្ញើពាក្យសម្ងាត់ថ្មី">Send New Password</span>
            </button>
        </div>

        {{-- ── Recent sends ── --}}
        <div class="card">
            <h4 class="font-bold text-gray-700 text-sm mb-3 flex items-center gap-2">
                <i class="fas fa-clock-rotate-left text-orange-400 text-sm"></i>
                <span data-fr="Envois Récents" data-en="Recent Sends" data-km="ការផ្ញើថ្មីៗ">Recent Sends</span>
            </h4>
            <div id="sendHistory" class="space-y-2">
                <p class="text-xs text-gray-400 text-center py-4" id="historyEmpty"
                   data-fr="Aucun email envoyé dans cette session"
                   data-en="No emails sent this session"
                   data-km="គ្មានអ៊ីមែលបានផ្ញើក្នុងវគ្គនេះ">No emails sent this session</p>
            </div>
        </div>

    </div>
    {{-- end left panel --}}

    {{-- ══════════════════════════════════════
         RIGHT — Live Preview Panel
    ══════════════════════════════════════ --}}
    <div class="preview-panel">

        {{-- Mobile toggle button (hidden on desktop) --}}
        <button class="preview-toggle-btn" id="previewToggleBtn" onclick="togglePreviewMobile()">
            <span class="flex items-center gap-2">
                <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;display:inline-block;animation:pulse 2s infinite;"></span>
                <span data-fr="Aperçu de l'Email" data-en="Email Preview" data-km="មើលអ៊ីមែលជាមុន">Email Preview</span>
            </span>
            <i class="fas fa-chevron-down text-xs opacity-60"></i>
        </button>

        {{-- Collapsible wrapper (open by default; collapsed on mobile until toggled) --}}
        <div class="preview-collapsible" id="previewCollapsible">
            <div class="preview-header">
                <div class="preview-dots">
                    <span style="background:#ef4444;"></span>
                    <span style="background:#f59e0b;"></span>
                    <span style="background:#22c55e;"></span>
                </div>
                <div class="preview-browser-bar" id="previewLabel">
                    email-preview — account_created.html
                </div>
                <div class="flex items-center gap-2 ml-2">
                    <button onclick="refreshPreview()" title="Refresh"
                            class="text-white/40 hover:text-white transition text-sm">
                        <i class="fas fa-rotate-right"></i>
                    </button>
                    <button onclick="openPreviewFullscreen()" title="Open full"
                            class="text-white/40 hover:text-white transition text-sm">
                        <i class="fas fa-up-right-and-down-left-from-center"></i>
                    </button>
                </div>
            </div>

            {{-- Scale selector --}}
            <div style="background:#1e293b;padding:8px 16px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;border-top:1px solid rgba(255,255,255,.06);">
                <span style="color:rgba(255,255,255,.4);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;">Scale</span>
                <div style="display:flex;gap:4px;">
                    @foreach(['75'=>'75%','85'=>'85%','100'=>'100%'] as $val=>$label)
                    <button onclick="setPreviewScale({{ $val }})" id="scale-{{ $val }}"
                            style="font-size:10px;font-weight:700;padding:3px 8px;border-radius:6px;border:1.5px solid rgba(255,255,255,.12);color:rgba(255,255,255,.5);background:transparent;cursor:pointer;transition:all .15s;"
                            class="scale-btn {{ $val == '85' ? 'scale-active' : '' }}">{{ $label }}</button>
                    @endforeach
                </div>
                <div style="margin-left:auto;display:flex;align-items:center;gap:6px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;display:inline-block;animation:pulse 2s infinite;"></span>
                    <span style="color:rgba(255,255,255,.35);font-size:10px;" id="previewStatus">Live Preview</span>
                </div>
            </div>

            <div class="preview-body">
                <div id="previewLoading" class="preview-loading">
                    <div class="pulse-ring"></div>
                    <span style="font-size:13px;">Loading preview...</span>
                </div>
                <iframe id="emailPreviewFrame"
                        style="display:none;transform-origin:top left;"
                        sandbox="allow-same-origin"></iframe>
            </div>

            {{-- Email client size indicators --}}
            <div class="preview-widths mt-3 flex gap-2 flex-wrap">
                @foreach([
                    ['fas fa-desktop','Desktop Gmail','600px'],
                    ['fas fa-mobile-alt','Mobile','375px'],
                    ['fas fa-tablet-alt','Tablet','480px'],
                ] as [$icon,$label,$width])
                <button onclick="setPreviewWidth('{{ $width }}')"
                        class="text-xs text-gray-500 hover:text-orange-500 border border-gray-200 hover:border-orange-300 rounded-lg px-3 py-1.5 flex items-center gap-1.5 transition bg-white">
                    <i class="{{ $icon }} text-[10px]"></i>{{ $label }}
                </button>
                @endforeach
            </div>
        </div>
        {{-- end collapsible --}}

    </div>
    {{-- end right panel --}}

</div>

@push('scripts')
<style>
.scale-btn.scale-active { background:rgba(249,115,22,.25) !important; color:#fb923c !important; border-color:rgba(249,115,22,.5) !important; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
</style>
<script>
/* ═══════════════════════════════════════════════════════════
   DATA — injected from PHP
═══════════════════════════════════════════════════════════ */
const SPONSORS    = @json($allSponsors);
const SITE_LOGO   = '{{ $emailLogoPath }}';
const SITE_NAME   = '{{ addslashes($emailSiteName) }}';

/* ═══════════════════════════════════════════════════════════
   SPONSOR SEARCH ENGINE
═══════════════════════════════════════════════════════════ */
function filterSponsors(form, query) {
    const btn = document.getElementById('clearBtn-' + form);
    btn.classList.toggle('hidden', !query.length);

    if (!query.trim()) { hideDropdown(form); return; }

    const q       = query.toLowerCase();
    const results = SPONSORS.filter(s =>
        s.label.toLowerCase().includes(q) ||
        s.email.toLowerCase().includes(q)  ||
        (s.first + ' ' + s.last).toLowerCase().includes(q)
    ).slice(0, 8);

    renderDropdown(form, results, q);
}

/* ── Sponsor cache per form (set when rendering) ── */
const _dropCache = { created: [], reset: [] };

function renderDropdown(form, results, highlight) {
    const drop = document.getElementById('sponsorDrop-' + form);
    drop.classList.remove('hidden');
    _dropCache[form] = results;   // store so delegation can look up by index

    if (!results.length) {
        drop.innerHTML = '<div class="sp-drop-empty"><i class="fas fa-search mb-1 block text-lg"></i>No sponsors found</div>';
        return;
    }

    drop.innerHTML = results.map((s, i) => {
        const initials = ((s.first[0]||'') + (s.last[0]||'')).toUpperCase() || '?';
        const name     = hl(s.first + ' ' + s.last, highlight);
        const email    = hl(s.email, highlight);
        return `
        <div class="sponsor-drop-item" data-form="${form}" data-idx="${i}">
            <div class="sp-avatar">${initials}</div>
            <div class="sp-info">
                <div class="sp-name">${name}</div>
                <div class="sp-email">${email}</div>
            </div>
            <div class="sp-actions">
                <button class="sp-action-btn fill"  data-action="fill"    data-form="${form}" data-idx="${i}" title="Fill form">
                    <i class="fas fa-pen-to-square"></i>
                </button>
                <button class="sp-action-btn created" data-action="send-created" data-form="${form}" data-idx="${i}" title="Send Account Created email">
                    🎉
                </button>
                <button class="sp-action-btn reset"   data-action="send-reset"   data-form="${form}" data-idx="${i}" title="Send Password Reset email">
                    🔐
                </button>
            </div>
        </div>`;
    }).join('');
}

/* Highlight matching text */
function hl(str, q) {
    if (!q) return str;
    const re = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&') + ')', 'gi');
    return str.replace(re, '<mark style="background:#fef3c7;border-radius:2px;padding:0 1px;">$1</mark>');
}

function showDropdown(form) {
    const q = document.getElementById('sponsorSearch-' + form).value;
    if (q.trim()) filterSponsors(form, q);
}
function hideDropdown(form) {
    document.getElementById('sponsorDrop-' + form).classList.add('hidden');
}

/* Fill form only */
function quickFill(form, sp) {
    const p = form === 'created' ? 'c_' : 'r_';
    document.getElementById(p + 'first_name').value = sp.first;
    document.getElementById(p + 'last_name').value  = sp.last;
    document.getElementById(p + 'email').value      = sp.email;
    document.getElementById(p + 'username').value   = sp.username || buildUsername(sp.first, sp.last);
    document.getElementById('sponsorSearch-' + form).value = sp.first + ' ' + sp.last;
    document.getElementById('clearBtn-' + form).classList.remove('hidden');
    hideDropdown(form);
    debouncedPreview();
}

/* Fill form + switch tab + auto-send */
async function quickSend(type, sp) {
    hideDropdown('created'); hideDropdown('reset');
    // Switch to the right tab
    switchEmailTab(type);
    const p = type === 'created' ? 'c_' : 'r_';
    document.getElementById(p + 'first_name').value = sp.first;
    document.getElementById(p + 'last_name').value  = sp.last;
    document.getElementById(p + 'email').value      = sp.email;
    document.getElementById(p + 'username').value   = sp.username || buildUsername(sp.first, sp.last);
    const passField = type === 'created' ? 'c_password' : 'r_password';
    genPassword(passField);
    document.getElementById('sponsorSearch-' + type).value = sp.first + ' ' + sp.last;
    refreshPreview();
    // Small delay so user sees the form filled before confirm
    await new Promise(r => setTimeout(r, 400));
    sendEmail(type);
}

function buildUsername(first, last) {
    const slug = s => s.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/[^a-z0-9]/g,'');
    return last ? slug(first) + '.' + slug(last) : slug(first);
}

function clearSearch(form) {
    document.getElementById('sponsorSearch-' + form).value = '';
    document.getElementById('clearBtn-' + form).classList.add('hidden');
    hideDropdown(form);
}

/* ── Single delegated click handler for the whole document ── */
document.addEventListener('click', e => {
    const btn  = e.target.closest('[data-action]');
    const item = e.target.closest('.sponsor-drop-item');

    if (btn) {
        e.stopPropagation();
        const form = btn.dataset.form;
        const sp   = _dropCache[form][parseInt(btn.dataset.idx, 10)];
        if (!sp) return;
        const action = btn.dataset.action;
        if      (action === 'fill')         quickFill(form, sp);
        else if (action === 'send-created') quickSend('created', sp);
        else if (action === 'send-reset')   quickSend('reset',   sp);
        return;
    }

    /* Click on the row itself (not a button) → fill only */
    if (item) {
        e.stopPropagation();
        const form = item.dataset.form;
        const sp   = _dropCache[form][parseInt(item.dataset.idx, 10)];
        if (sp) quickFill(form, sp);
        return;
    }

    /* Click outside → close all dropdowns */
    ['created','reset'].forEach(form => {
        const wrap = document.getElementById('searchWrap-' + form);
        if (wrap && !wrap.contains(e.target)) hideDropdown(form);
    });
});

/* ═══════════════════════════════════════════════════════════
   STATE
═══════════════════════════════════════════════════════════ */
let currentTab   = 'created';
let previewScale = 85;
let previewWidth = '600px';
let debounceTimer;
let sendHistory  = [];
let emailLang    = 'fr'; // fr | en | km

/* ═══════════════════════════════════════════════════════════
   EMAIL LANGUAGE
═══════════════════════════════════════════════════════════ */
const langHints = {
    fr: "L'email sera envoyé en Français",
    en: "Email will be sent in English",
    km: "អ៊ីមែលនឹងត្រូវបានផ្ញើជាភាសាខ្មែរ",
};
function setEmailLang(lang) {
    emailLang = lang;
    // Update button styles
    document.querySelectorAll('.elang-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('elang-' + lang).classList.add('active');
    // Hint text
    document.getElementById('langHint').textContent = langHints[lang] || '';
    // Refresh preview
    debouncedPreview();
}

/* ═══════════════════════════════════════════════════════════
   TAB SWITCHING
═══════════════════════════════════════════════════════════ */
function switchEmailTab(tab) {
    currentTab = tab;
    // Pills
    document.getElementById('pill-created').classList.toggle('active', tab === 'created');
    document.getElementById('pill-reset').classList.toggle('active', tab === 'reset');
    // Forms
    document.getElementById('form-created').classList.toggle('hidden', tab !== 'created');
    document.getElementById('form-reset').classList.toggle('hidden', tab !== 'reset');
    // Preview label
    document.getElementById('previewLabel').textContent =
        tab === 'created' ? 'email-preview — account_created.html'
                          : 'email-preview — password_reset.html';
    refreshPreview();
}

/* ═══════════════════════════════════════════════════════════
   AUTO-FILL FROM SPONSOR PICKER
═══════════════════════════════════════════════════════════ */
function fillFromSponsor(type, sp) {
    const p = type === 'created' ? 'c_' : 'r_';
    document.getElementById(p + 'first_name').value = sp.first || '';
    document.getElementById(p + 'last_name').value  = sp.last  || '';
    document.getElementById(p + 'email').value      = sp.email || '';
    document.getElementById(p + 'username').value   = sp.username || buildUsername(sp.first||'', sp.last||'');
    debouncedPreview();
}

/* Auto-build username: firstname.lastname → lowercased, no accents, no spaces */
function autoUsername(prefix) {
    const p     = prefix + '_';
    const first = (document.getElementById(p + 'first_name').value || '').trim();
    const last  = (document.getElementById(p + 'last_name').value  || '').trim();
    if (!first && !last) return;
    document.getElementById(p + 'username').value = buildUsername(first, last);
}

/* ═══════════════════════════════════════════════════════════
   PASSWORD GENERATOR
═══════════════════════════════════════════════════════════ */
function genPassword(fieldId) {
    const chars   = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789!@#$%';
    const specials = '!@#$%';
    let pass = '';
    // Ensure at least 1 uppercase, 1 lowercase, 1 digit, 1 special
    pass += chars[Math.floor(Math.random() * 26)];              // uppercase
    pass += chars[26 + Math.floor(Math.random() * 26)];        // lowercase
    pass += chars[52 + Math.floor(Math.random() * 8)];         // digit
    pass += specials[Math.floor(Math.random() * specials.length)]; // special
    for (let i = 4; i < 12; i++) {
        pass += chars[Math.floor(Math.random() * chars.length)];
    }
    // Shuffle
    pass = pass.split('').sort(() => Math.random() - .5).join('');
    document.getElementById(fieldId).value = pass;
    debouncedPreview();
}

function copyVal(fieldId) {
    const val = document.getElementById(fieldId).value;
    if (!val) return;
    navigator.clipboard.writeText(val).then(() => showToast('ok', 'Copied to clipboard!', 1500));
}

/* ═══════════════════════════════════════════════════════════
   LIVE PREVIEW
═══════════════════════════════════════════════════════════ */
function getFormData() {
    const combine = (p) => {
        const f = (document.getElementById(p+'first_name').value || '').trim();
        const l = (document.getElementById(p+'last_name').value  || '').trim();
        return [f, l].filter(Boolean).join(' ') || 'Jean Dupont';
    };
    if (currentTab === 'created') {
        return {
            type:       'created',
            lang:       emailLang,
            logo:       SITE_LOGO,
            site_name:  SITE_NAME,
            first_name: document.getElementById('c_first_name').value || 'Jean',
            last_name:  document.getElementById('c_last_name').value  || 'Dupont',
            name:       combine('c_'),
            email:      document.getElementById('c_email').value    || 'jean@example.com',
            username:   document.getElementById('c_username').value || 'jean.dupont',
            password:   document.getElementById('c_password').value || 'Temp@Pass123',
        };
    } else {
        return {
            type:       'reset',
            lang:       emailLang,
            logo:       SITE_LOGO,
            site_name:  SITE_NAME,
            first_name: document.getElementById('r_first_name').value || 'Jean',
            last_name:  document.getElementById('r_last_name').value  || 'Dupont',
            name:       combine('r_'),
            email:      document.getElementById('r_email').value    || 'jean@example.com',
            username:   document.getElementById('r_username').value || 'jean.dupont',
            password:   document.getElementById('r_password').value || 'New@Pass456',
        };
    }
}

function debouncedPreview() {
    clearTimeout(debounceTimer);
    document.getElementById('previewStatus').textContent = 'Updating...';
    debounceTimer = setTimeout(refreshPreview, 600);
}

async function refreshPreview() {
    const frame   = document.getElementById('emailPreviewFrame');
    const loading = document.getElementById('previewLoading');
    const data    = getFormData();

    loading.style.display = 'flex';
    frame.style.display   = 'none';
    document.getElementById('previewStatus').textContent = 'Loading...';

    try {
        const res = await fetch('{{ route('admin.emails.preview') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            },
            body: JSON.stringify(data),
        });
        const html = await res.text();

        // Write HTML into iframe
        frame.style.display = 'block';
        loading.style.display = 'none';
        const doc = frame.contentDocument || frame.contentWindow.document;
        doc.open(); doc.write(html); doc.close();

        applyPreviewScale();
        document.getElementById('previewStatus').textContent = 'Live Preview';

    } catch(e) {
        loading.innerHTML = '<div style="color:#ef4444;text-align:center;padding:40px;"><i class="fas fa-exclamation-circle text-2xl mb-2 block"></i><span>Preview error — check route</span></div>';
        document.getElementById('previewStatus').textContent = 'Error';
    }
}

function applyPreviewScale() {
    const frame = document.getElementById('emailPreviewFrame');
    const body  = frame.closest('.preview-body');
    const scale = previewScale / 100;
    frame.style.transform = `scale(${scale})`;
    frame.style.width  = `calc(${previewWidth} / ${scale})`;
    frame.style.height = `${720 / scale}px`;
    body.style.height  = `${720}px`;
    body.style.overflow = 'hidden';
}

function setPreviewScale(val) {
    previewScale = parseInt(val);
    document.querySelectorAll('.scale-btn').forEach(b => b.classList.remove('scale-active'));
    document.getElementById('scale-' + val).classList.add('scale-active');
    applyPreviewScale();
}

function setPreviewWidth(w) {
    previewWidth = w;
    applyPreviewScale();
}

function openPreviewFullscreen() {
    const data = getFormData();
    const params = new URLSearchParams({ ...data, _token: document.querySelector('meta[name=csrf-token]').content });
    const url = '{{ route('admin.emails.preview') }}?' + params;
    window.open(url.replace('?', ''), '_blank');
    // POST form workaround
    const form = document.createElement('form');
    form.method = 'POST'; form.action = '{{ route('admin.emails.preview') }}'; form.target = '_blank';
    Object.entries(data).forEach(([k,v]) => {
        const i = document.createElement('input'); i.type='hidden'; i.name=k; i.value=v; form.appendChild(i);
    });
    const csrf = document.createElement('input'); csrf.type='hidden'; csrf.name='_token';
    csrf.value = document.querySelector('meta[name=csrf-token]').content; form.appendChild(csrf);
    document.body.appendChild(form); form.submit(); document.body.removeChild(form);
}

/* ═══════════════════════════════════════════════════════════
   SEND EMAIL
═══════════════════════════════════════════════════════════ */
async function sendEmail(type) {
    const data = getFormData();
    const btnId = 'btn-send-' + type;
    const btn   = document.getElementById(btnId);

    // Validate
    const emailField = document.getElementById(type === 'created' ? 'c_email'      : 'r_email');
    const nameField  = document.getElementById(type === 'created' ? 'c_first_name' : 'r_first_name');
    if (!emailField.value || !nameField.value) {
        emailField.classList.add('error'); nameField.classList.add('error');
        showToast('err', 'Veuillez remplir le prénom et l\'email.', 3000);
        setTimeout(() => { emailField.classList.remove('error'); nameField.classList.remove('error'); }, 2000);
        return;
    }

    // Loading state
    btn.classList.add('loading');
    btn.innerHTML = '<div class="btn-spinner"></div><span>Sending...</span>';

    try {
        const res = await fetch('{{ route('admin.emails.send') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            },
            body: JSON.stringify(data),
        });
        const json = await res.json();

        if (json.success) {
            showToast('ok', `✅ Email envoyé à ${data.email}`, 4000);
            addHistory(type, data);
            // Play success chime if available
            if (typeof playSoundSuccess === 'function') playSoundSuccess();
        } else {
            showToast('err', '❌ ' + (json.message || 'Erreur lors de l\'envoi.'), 4000);
            if (typeof playSoundError === 'function') playSoundError();
        }
    } catch(e) {
        showToast('err', '❌ Erreur réseau. Vérifiez la config Gmail.', 4000);
    } finally {
        btn.classList.remove('loading');
        if (type === 'created') {
            btn.innerHTML = '<i class="fas fa-paper-plane"></i><span>Send Welcome Email</span>';
        } else {
            btn.innerHTML = '<i class="fas fa-paper-plane"></i><span>Send New Password</span>';
        }
    }
}

/* ═══════════════════════════════════════════════════════════
   HISTORY
═══════════════════════════════════════════════════════════ */
function addHistory(type, data) {
    sendHistory.unshift({ type, name: data.name, email: data.email, time: new Date() });
    if (sendHistory.length > 5) sendHistory.pop();
    renderHistory();
}
function renderHistory() {
    const el = document.getElementById('sendHistory');
    const empty = document.getElementById('historyEmpty');
    if (!sendHistory.length) { if(empty) empty.style.display='block'; return; }
    if (empty) empty.style.display = 'none';
    el.innerHTML = sendHistory.map(h => `
        <div class="history-item">
            <div style="width:32px;height:32px;border-radius:9px;background:${h.type==='created'?'#d1fae5':'#dbeafe'};
                        display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">
                ${h.type === 'created' ? '🎉' : '🔐'}
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:12px;font-weight:700;color:#111827;truncate;">${h.name}</div>
                <div style="font-size:11px;color:#9ca3af;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${h.email}</div>
            </div>
            <div>
                <span class="history-badge ${h.type==='created'?'badge-created':'badge-reset'}">
                    ${h.type === 'created' ? 'Created' : 'Reset'}
                </span>
                <div style="font-size:9px;color:#d1d5db;text-align:right;margin-top:2px;">
                    ${h.time.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'})}
                </div>
            </div>
        </div>
    `).join('');
}

/* ═══════════════════════════════════════════════════════════
   TOAST
═══════════════════════════════════════════════════════════ */
let toastTimer;
function showToast(type, msg, duration = 3000) {
    const el  = document.getElementById('sendToast');
    const txt = document.getElementById('sendToastMsg');
    clearTimeout(toastTimer);
    el.className = 'send-toast show ' + (type === 'ok' ? 'ok' : 'err');
    el.querySelector('i').className = type === 'ok' ? 'fas fa-circle-check text-lg' : 'fas fa-circle-exclamation text-lg';
    txt.textContent = msg;
    toastTimer = setTimeout(() => el.classList.remove('show'), duration);
}

/* ═══════════════════════════════════════════════════════════
   MOBILE PREVIEW TOGGLE
═══════════════════════════════════════════════════════════ */
function togglePreviewMobile() {
    const el  = document.getElementById('previewCollapsible');
    const btn = document.getElementById('previewToggleBtn');
    const collapsed = el.classList.toggle('collapsed');
    btn.classList.toggle('open', !collapsed);
    // Load preview when expanding if not yet loaded
    if (!collapsed) refreshPreview();
}

/* ═══════════════════════════════════════════════════════════
   INIT
═══════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
    genPassword('c_password');
    genPassword('r_password');

    /* On mobile, start with preview collapsed */
    if (window.innerWidth <= 640) {
        const el  = document.getElementById('previewCollapsible');
        const btn = document.getElementById('previewToggleBtn');
        el.classList.add('collapsed');
        btn.classList.remove('open');
    } else {
        setTimeout(refreshPreview, 300);
    }
});
</script>
@endpush

@endsection