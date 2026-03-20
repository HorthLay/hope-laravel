{{-- resources/views/admin/donation-projects/form.blade.php --}}
@extends('admin.layouts.app')
@section('title', $project->exists ? 'Edit Project' : 'New Project')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<style>
/* ════════════════════════════════════════════
   DONATION PROJECT FORM — EDITORIAL DESIGN
════════════════════════════════════════════ */
:root {
    --brand:   #f97316;
    --brand-d: #ea580c;
    --navy:    #0f172a;
    --ink:     #1e293b;
    --muted:   #64748b;
    --border:  #e2e8f0;
    --surface: #f8fafc;
}
.dpf-wrap {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 28px;
    align-items: start;
    max-width: 1100px;
    margin: 0 auto;
}
@media (max-width: 900px) {
    .dpf-wrap { grid-template-columns: 1fr; }
    .dpf-sidebar { position: static !important; order: -1; }
}

/* ── SIDEBAR ── */
.dpf-sidebar {
    position: sticky;
    top: 24px;
}
.dpf-preview-card {
    background: linear-gradient(160deg, var(--navy) 0%, #1e3a5f 100%);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(15,23,42,.35);
}
.dpf-preview-img {
    width: 100%; height: 160px; object-fit: cover;
    display: block; opacity: .85;
}
.dpf-preview-img-placeholder {
    width: 100%; height: 160px;
    background: linear-gradient(135deg, #1e3a5f, #0f2942);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 8px; color: rgba(255,255,255,.25); font-size: 32px;
    border-bottom: 1px solid rgba(255,255,255,.07);
}
.dpf-preview-body { padding: 18px 20px 20px; }
.dpf-preview-badge {
    display: inline-block; font-size: 9px; font-weight: 800;
    letter-spacing: 1.5px; text-transform: uppercase;
    padding: 3px 10px; border-radius: 99px; margin-bottom: 10px;
    background: rgba(249,115,22,.25); color: #fdba74; border: 1px solid rgba(249,115,22,.3);
}
.dpf-preview-title {
    font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 800;
    color: #fff; line-height: 1.3; margin-bottom: 6px;
    min-height: 20px;
}
.dpf-preview-desc {
    font-size: 11px; color: rgba(255,255,255,.4); line-height: 1.6;
    min-height: 14px;
}

/* ── NAV DOTS ── */
.dpf-nav { padding: 4px 0; margin-top: 20px; }
.dpf-nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 12px; border-radius: 10px; cursor: pointer;
    transition: background .15s; text-decoration: none;
}
.dpf-nav-item:hover { background: rgba(249,115,22,.08); }
.dpf-nav-item.active { background: rgba(249,115,22,.12); }
.dpf-nav-dot {
    width: 28px; height: 28px; border-radius: 9px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 900; font-family: 'Outfit',sans-serif;
    background: #f1f5f9; color: #94a3b8; transition: all .2s;
}
.dpf-nav-item.active .dpf-nav-dot,
.dpf-nav-item:hover .dpf-nav-dot {
    background: linear-gradient(135deg, var(--brand), var(--brand-d));
    color: #fff; box-shadow: 0 4px 12px rgba(249,115,22,.3);
}
.dpf-nav-label {
    font-size: 12px; font-weight: 700; color: #64748b;
    font-family: 'Outfit', sans-serif;
}
.dpf-nav-item.active .dpf-nav-label { color: #c2410c; }

/* ── SAVE BUTTON ── */
.dpf-save-btn {
    width: 100%; padding: 14px; margin-top: 16px;
    background: linear-gradient(135deg, var(--brand), var(--brand-d));
    color: #fff; font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 800;
    border: none; border-radius: 14px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap-8px;
    box-shadow: 0 8px 24px rgba(249,115,22,.35);
    transition: all .22s; letter-spacing: .3px;
    gap: 8px;
}
.dpf-save-btn:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(249,115,22,.45); }
.dpf-save-btn:active { transform: translateY(0); }

.dpf-cancel-link {
    display: block; text-align: center; margin-top: 10px;
    font-size: 12px; font-weight: 600; color: #94a3b8;
    text-decoration: none; transition: color .15s;
}
.dpf-cancel-link:hover { color: #64748b; }

/* ── FORM SECTIONS ── */
.dpf-section {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(15,23,42,.04);
}
.dpf-section-head {
    padding: 20px 28px 0;
    display: flex; align-items: flex-start; gap: 14px;
    border-bottom: 1.5px solid var(--border);
    padding-bottom: 18px;
}
.dpf-section-num {
    font-family: 'Outfit', sans-serif; font-size: 11px; font-weight: 900;
    letter-spacing: .5px; color: var(--brand);
    background: #fff7ed; border: 1.5px solid #fed7aa;
    width: 32px; height: 32px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.dpf-section-title {
    font-family: 'Outfit', sans-serif; font-size: 16px; font-weight: 800;
    color: var(--ink); margin-bottom: 2px;
}
.dpf-section-sub { font-size: 12px; color: #94a3b8; }
.dpf-section-body { padding: 24px 28px; }

/* ── LANGUAGE TABS ── */
.lang-tabs { display: flex; gap: 6px; margin-bottom: 20px; }
.lang-tab {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 10px; border: 1.5px solid var(--border);
    background: var(--surface); font-size: 12px; font-weight: 700;
    cursor: pointer; transition: all .15s; color: #64748b;
}
.lang-tab:hover { border-color: #fed7aa; color: #c2410c; background: #fff7ed; }
.lang-tab.active {
    border-color: var(--brand); background: linear-gradient(135deg,#fff7ed,#fef3c7);
    color: #c2410c; box-shadow: 0 2px 8px rgba(249,115,22,.15);
}
.lang-pane { display: none; }
.lang-pane.active { display: block; }

/* ── INPUTS ── */
.dpf-label {
    display: block; font-size: 10.5px; font-weight: 800; letter-spacing: .8px;
    text-transform: uppercase; color: #94a3b8; margin-bottom: 7px;
    font-family: 'Outfit', sans-serif;
}
.dpf-label span.req { color: var(--brand); }
.dpf-input, .dpf-textarea, .dpf-select {
    width: 100%; padding: 11px 16px; border-radius: 12px;
    border: 1.5px solid var(--border); font-size: 14px; color: var(--ink);
    outline: none; background: var(--surface);
    transition: border-color .18s, box-shadow .18s, background .18s;
    font-family: inherit;
}
.dpf-input:focus, .dpf-textarea:focus, .dpf-select:focus {
    border-color: var(--brand);
    box-shadow: 0 0 0 4px rgba(249,115,22,.1);
    background: #fff;
}
.dpf-input.km, .dpf-textarea.km { font-family: 'Hanuman','Battambang',sans-serif; }
.dpf-input::placeholder, .dpf-textarea::placeholder { color: #cbd5e1; }
.dpf-textarea { resize: vertical; min-height: 90px; line-height: 1.65; }
.dpf-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; }
.dpf-input.mono { font-family: 'JetBrains Mono', 'Courier New', monospace; font-size: 13px; }
.dpf-field { margin-bottom: 18px; }
.dpf-field:last-child { margin-bottom: 0; }
.dpf-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media (max-width: 600px) { .dpf-grid-2 { grid-template-columns: 1fr; } }

/* ── HELLOASSO CARD ── */
.ha-card {
    border: 1.5px solid var(--border); border-radius: 14px;
    overflow: hidden; margin-bottom: 14px;
    transition: border-color .18s;
}
.ha-card:last-child { margin-bottom: 0; }
.ha-card:focus-within { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(249,115,22,.08); }
.ha-card-head {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 16px; background: var(--surface);
    border-bottom: 1.5px solid var(--border);
}
.ha-icon {
    width: 30px; height: 30px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;
}
.ha-card-label { font-size: 12px; font-weight: 800; color: var(--ink); font-family: 'Outfit', sans-serif; }
.ha-card-suffix { margin-left: auto; font-size: 10px; color: #94a3b8; font-weight: 600; }
.ha-card-suffix code { background: #f1f5f9; padding: 2px 6px; border-radius: 5px; font-family: monospace; }
.ha-card-body { padding: 12px 16px; }
.ha-preview-link {
    display: inline-flex; align-items: center; gap: 5px; margin-top: 6px;
    font-size: 11px; color: #3b82f6; font-weight: 600; text-decoration: none;
}
.ha-preview-link:hover { text-decoration: underline; }

/* ── QUICK FILL ── */
.qf-bar {
    display: flex; gap: 8px; margin-top: 18px; padding-top: 18px;
    border-top: 1.5px dashed #e2e8f0;
}
.qf-btn {
    flex-shrink: 0; padding: 11px 18px; border-radius: 12px;
    background: linear-gradient(135deg, var(--brand), var(--brand-d));
    color: #fff; font-size: 12px; font-weight: 800; border: none; cursor: pointer;
    transition: all .18s; white-space: nowrap; font-family: 'Outfit',sans-serif;
}
.qf-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(249,115,22,.35); }
.qf-input {
    flex: 1; padding: 11px 16px; border-radius: 12px;
    border: 1.5px dashed #fed7aa; background: #fff7ed;
    font-size: 12px; font-family: monospace; color: var(--ink); outline: none;
    transition: border-color .18s;
}
.qf-input:focus { border-color: var(--brand); border-style: solid; }

/* ── IMAGE UPLOAD ── */
.img-drop-zone {
    position: relative; border-radius: 16px;
    border: 2px dashed #e2e8f0; background: var(--surface);
    min-height: 180px; display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 10px;
    cursor: pointer; transition: all .2s; overflow: hidden;
    text-align: center; padding: 24px;
}
.img-drop-zone:hover, .img-drop-zone.dragging {
    border-color: var(--brand); background: #fff7ed;
}
.img-drop-zone.has-image { border-style: solid; padding: 0; }
.img-drop-zone img.preview-img {
    width: 100%; height: 180px; object-fit: cover; display: block;
    border-radius: 14px;
}
.img-overlay {
    position: absolute; inset: 0; background: rgba(15,23,42,.55);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 6px; opacity: 0; transition: opacity .2s; border-radius: 14px;
}
.img-drop-zone:hover .img-overlay { opacity: 1; }
.img-overlay span { color: #fff; font-size: 12px; font-weight: 700; font-family: 'Outfit',sans-serif; }
.img-upload-icon { font-size: 36px; color: #cbd5e1; }
.img-upload-title { font-size: 14px; font-weight: 700; color: #475569; font-family: 'Outfit',sans-serif; }
.img-upload-sub { font-size: 11px; color: #94a3b8; }
.img-path-hint { margin-top: 8px; font-size: 10.5px; color: #94a3b8; display: flex; align-items: center; gap: 4px; }
.img-path-hint code { background: #f1f5f9; padding: 1px 5px; border-radius: 4px; font-size: 10px; }

/* ── SETTINGS ── */
.setting-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
.setting-row:last-child { border-bottom: none; padding-bottom: 0; }
.setting-row-label { font-size: 12px; font-weight: 700; color: var(--ink); font-family: 'Outfit', sans-serif; }
.setting-row-sub { font-size: 11px; color: #94a3b8; margin-top: 1px; }

/* ── TOGGLE SWITCH ── */
.toggle-wrap { display: flex; align-items: center; gap: 8px; }
.toggle { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
.toggle input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
    position: absolute; inset: 0; background: #e2e8f0; border-radius: 99px; cursor: pointer;
    transition: background .2s;
}
.toggle-slider::before {
    content: ''; position: absolute;
    width: 18px; height: 18px; left: 3px; bottom: 3px;
    background: #fff; border-radius: 50%; transition: transform .2s;
    box-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.toggle input:checked + .toggle-slider { background: var(--brand); }
.toggle input:checked + .toggle-slider::before { transform: translateX(20px); }
.toggle-text { font-size: 12px; font-weight: 700; color: #64748b; }

/* ── BADGE COLOR SWATCH ── */
.swatch-group { display: flex; gap: 6px; }
.swatch {
    width: 28px; height: 28px; border-radius: 8px; cursor: pointer;
    border: 2px solid transparent; transition: all .15s;
    position: relative;
}
.swatch::after {
    content: '✓'; position: absolute; inset: 0; display: none;
    align-items: center; justify-content: center;
    font-size: 13px; font-weight: 900; color: #fff;
}
.swatch.selected { border-color: #fff; box-shadow: 0 0 0 3px var(--brand); }
.swatch.selected::after { display: flex; }

/* ── ERRORS ── */
.dpf-errors {
    background: #fef2f2; border: 1.5px solid #fecaca;
    border-radius: 14px; padding: 14px 18px; margin-bottom: 20px;
}
.dpf-errors li { font-size: 13px; color: #991b1b; margin-bottom: 4px; }
.dpf-errors li:last-child { margin-bottom: 0; }

/* ── ANIMATIONS ── */
@keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
.dpf-section { animation: fadeUp .4s ease both; }
.dpf-section:nth-child(1) { animation-delay: .05s; }
.dpf-section:nth-child(2) { animation-delay: .10s; }
.dpf-section:nth-child(3) { animation-delay: .15s; }
.dpf-section:nth-child(4) { animation-delay: .20s; }
</style>
@endpush

@section('content')

{{-- ── PAGE HEADER ── --}}
<div style="max-width:1100px;margin:0 auto 28px;display:flex;align-items:center;gap:14px;">
    <a href="{{ route('admin.donation-projects.index') }}"
       style="width:38px;height:38px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:#64748b;text-decoration:none;flex-shrink:0;transition:background .15s;"
       onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
        <i class="fas fa-arrow-left" style="font-size:13px;"></i>
    </a>
    <div>
        <h1 style="font-family:'Outfit',sans-serif;font-size:22px;font-weight:900;color:#0f172a;margin:0;line-height:1.2;">
            {{ $project->exists ? 'Edit Donation Project' : 'New Donation Project' }}
        </h1>
        <p style="font-size:13px;color:#94a3b8;margin:2px 0 0;">
            {{ $project->exists ? 'Update campaign details below.' : 'Configure your fundraising campaign.' }}
        </p>
    </div>

    @if($project->exists)
    <div style="margin-left:auto;display:flex;align-items:center;gap:6px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:99px;padding:5px 14px 5px 10px;">
        <span style="width:8px;height:8px;border-radius:50%;background:{{ $project->is_active ? '#22c55e' : '#94a3b8' }};display:inline-block;"></span>
        <span style="font-size:11px;font-weight:700;color:{{ $project->is_active ? '#15803d' : '#64748b' }};">
            {{ $project->is_active ? 'Active' : 'Hidden' }}
        </span>
    </div>
    @endif
</div>

<form method="POST"
      action="{{ $project->exists ? route('admin.donation-projects.update', $project) : route('admin.donation-projects.store') }}"
      enctype="multipart/form-data"
      id="dpf-form">
    @csrf
    @if($project->exists) @method('PUT') @endif

    <div class="dpf-wrap">

        {{-- ════════════════════════════════
             SIDEBAR
        ════════════════════════════════ --}}
        <div class="dpf-sidebar">

            {{-- Live preview card --}}
            <div class="dpf-preview-card">
                <div id="previewImgWrap">
                    @if($project->image)
                    <img src="{{ asset($project->image) }}" class="dpf-preview-img" id="previewImgEl">
                    @else
                    <div class="dpf-preview-img-placeholder" id="previewImgEl">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span style="font-size:11px;font-family:'Outfit',sans-serif;">No image yet</span>
                    </div>
                    @endif
                </div>
                <div class="dpf-preview-body">
                    <div class="dpf-preview-badge" id="prevBadge">
                        {{ $project->badge_label ?? 'Active' }}
                    </div>
                    <div class="dpf-preview-title" id="prevTitle">
                        {{ $project->title_en ?: 'Project title will appear here' }}
                    </div>
                    <div class="dpf-preview-desc" id="prevDesc">
                        {{ Str::limit($project->description_en ?? '', 80) ?: 'Short description preview...' }}
                    </div>
                </div>
            </div>

            {{-- Section nav --}}
            <div class="dpf-nav">
                <a href="#sec-titles"  class="dpf-nav-item active" onclick="setNav(this)">
                    <div class="dpf-nav-dot">01</div>
                    <span class="dpf-nav-label">Titles</span>
                </a>
                <a href="#sec-desc"    class="dpf-nav-item" onclick="setNav(this)">
                    <div class="dpf-nav-dot">02</div>
                    <span class="dpf-nav-label">Description</span>
                </a>
                <a href="#sec-ha"      class="dpf-nav-item" onclick="setNav(this)">
                    <div class="dpf-nav-dot">03</div>
                    <span class="dpf-nav-label">HelloAsso</span>
                </a>
                <a href="#sec-media"   class="dpf-nav-item" onclick="setNav(this)">
                    <div class="dpf-nav-dot">04</div>
                    <span class="dpf-nav-label">Image</span>
                </a>
                <a href="#sec-settings" class="dpf-nav-item" onclick="setNav(this)">
                    <div class="dpf-nav-dot">05</div>
                    <span class="dpf-nav-label">Settings</span>
                </a>
            </div>

            {{-- Save --}}
            <button type="submit" class="dpf-save-btn">
                <i class="fas fa-save"></i>
                {{ $project->exists ? 'Save Changes' : 'Create Project' }}
            </button>
            <a href="{{ route('admin.donation-projects.index') }}" class="dpf-cancel-link">
                <i class="fas fa-times" style="font-size:10px;"></i> Cancel
            </a>
        </div>

        {{-- ════════════════════════════════
             FORM SECTIONS
        ════════════════════════════════ --}}
        <div class="space-y-5">

            @if($errors->any())
            <div class="dpf-errors">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
            @endif

            {{-- ── 01 TITLES ── --}}
            <div class="dpf-section" id="sec-titles">
                <div class="dpf-section-head">
                    <div class="dpf-section-num">01</div>
                    <div>
                        <div class="dpf-section-title">Project Title</div>
                        <div class="dpf-section-sub">Name shown on the donation page in each language</div>
                    </div>
                </div>
                <div class="dpf-section-body">
                    <div class="lang-tabs" id="titleTabs">
                        <button type="button" class="lang-tab active" onclick="switchLang('title','en',this)">🇬🇧 English</button>
                        <button type="button" class="lang-tab" onclick="switchLang('title','fr',this)">🇫🇷 Français</button>
                        <button type="button" class="lang-tab" onclick="switchLang('title','km',this)">🇰🇭 ខ្មែរ</button>
                    </div>
                    <div class="lang-pane active" id="title-en">
                        <label class="dpf-label">English <span class="req">*</span></label>
                        <input type="text" name="title_en" class="dpf-input"
                               value="{{ old('title_en', $project->title_en) }}"
                               placeholder="e.g. School Supplies for Children"
                               oninput="document.getElementById('prevTitle').textContent=this.value||'Project title will appear here'">
                    </div>
                    <div class="lang-pane" id="title-fr">
                        <label class="dpf-label">Français</label>
                        <input type="text" name="title_fr" class="dpf-input"
                               value="{{ old('title_fr', $project->title_fr) }}"
                               placeholder="ex. Fournitures scolaires pour les enfants">
                    </div>
                    <div class="lang-pane" id="title-km">
                        <label class="dpf-label">ខ្មែរ</label>
                        <input type="text" name="title_km" class="dpf-input km"
                               value="{{ old('title_km', $project->title_km) }}"
                               placeholder="ចំណងជើងគម្រោង">
                    </div>
                </div>
            </div>

            {{-- ── 02 DESCRIPTION ── --}}
            <div class="dpf-section" id="sec-desc">
                <div class="dpf-section-head">
                    <div class="dpf-section-num">02</div>
                    <div>
                        <div class="dpf-section-title">Description</div>
                        <div class="dpf-section-sub">Short paragraph explaining the campaign's purpose</div>
                    </div>
                </div>
                <div class="dpf-section-body">
                    <div class="lang-tabs" id="descTabs">
                        <button type="button" class="lang-tab active" onclick="switchLang('desc','en',this)">🇬🇧 English</button>
                        <button type="button" class="lang-tab" onclick="switchLang('desc','fr',this)">🇫🇷 Français</button>
                        <button type="button" class="lang-tab" onclick="switchLang('desc','km',this)">🇰🇭 ខ្មែរ</button>
                    </div>
                    <div class="lang-pane active" id="desc-en">
                        <label class="dpf-label">English</label>
                        <textarea name="description_en" class="dpf-textarea" placeholder="Describe this campaign in a few sentences..."
                                  oninput="document.getElementById('prevDesc').textContent=this.value.slice(0,80)||(this.value?'...':'Short description preview...')">{{ old('description_en', $project->description_en) }}</textarea>
                    </div>
                    <div class="lang-pane" id="desc-fr">
                        <label class="dpf-label">Français</label>
                        <textarea name="description_fr" class="dpf-textarea" placeholder="Décrivez cette collecte en quelques phrases...">{{ old('description_fr', $project->description_fr) }}</textarea>
                    </div>
                    <div class="lang-pane" id="desc-km">
                        <label class="dpf-label">ខ្មែរ</label>
                        <textarea name="description_km" class="dpf-textarea km" placeholder="ពិពណ៌នាអំពីការប្រមូលទឹកប្រាក់...">{{ old('description_km', $project->description_km) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── 03 HELLOASSO ── --}}
            <div class="dpf-section" id="sec-ha">
                <div class="dpf-section-head">
                    <div class="dpf-section-num">03</div>
                    <div>
                        <div class="dpf-section-title">HelloAsso Integration</div>
                        <div class="dpf-section-sub">Paste embed URLs from your HelloAsso campaign → <strong>Intégrer</strong></div>
                    </div>
                </div>
                <div class="dpf-section-body">

                    {{-- Widget --}}
                    <div class="ha-card">
                        <div class="ha-card-head">
                            <div class="ha-icon" style="background:#fff7ed;">💳</div>
                            <div>
                                <div class="ha-card-label">Donation Form Widget</div>
                            </div>
                            <div class="ha-card-suffix">ends in <code>/widget</code></div>
                        </div>
                        <div class="ha-card-body">
                            <input type="url" name="helloasso_widget_url" class="dpf-input mono"
                                   value="{{ old('helloasso_widget_url', $project->helloasso_widget_url) }}"
                                   placeholder="https://www.helloasso.com/.../collectes/YOUR-SLUG/widget">
                            @if(!empty($project->helloasso_widget_url))
                            <a href="{{ $project->helloasso_widget_url }}" target="_blank" class="ha-preview-link">
                                <i class="fas fa-external-link-alt" style="font-size:9px;"></i> Open preview
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Counter --}}
                    <div class="ha-card">
                        <div class="ha-card-head">
                            <div class="ha-icon" style="background:#eff6ff;">📊</div>
                            <div>
                                <div class="ha-card-label">Progress Counter Widget</div>
                            </div>
                            <div class="ha-card-suffix">ends in <code>/widget-compteur</code></div>
                        </div>
                        <div class="ha-card-body">
                            <input type="url" name="helloasso_counter_url" class="dpf-input mono"
                                   value="{{ old('helloasso_counter_url', $project->helloasso_counter_url) }}"
                                   placeholder="https://www.helloasso.com/.../collectes/YOUR-SLUG/widget-compteur">
                            @if(!empty($project->helloasso_counter_url))
                            <a href="{{ $project->helloasso_counter_url }}" target="_blank" class="ha-preview-link">
                                <i class="fas fa-external-link-alt" style="font-size:9px;"></i> Open preview
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Vignette --}}
                    <div class="ha-card">
                        <div class="ha-card-head">
                            <div class="ha-icon" style="background:#f0fdf4;">🪪</div>
                            <div>
                                <div class="ha-card-label">Card / Vignette Widget</div>
                            </div>
                            <div class="ha-card-suffix">ends in <code>/widget-vignette</code></div>
                        </div>
                        <div class="ha-card-body">
                            <input type="url" name="helloasso_vignette_url" class="dpf-input mono"
                                   value="{{ old('helloasso_vignette_url', $project->helloasso_vignette_url) }}"
                                   placeholder="https://www.helloasso.com/.../collectes/YOUR-SLUG/widget-vignette">
                            @if(!empty($project->helloasso_vignette_url))
                            <a href="{{ $project->helloasso_vignette_url }}" target="_blank" class="ha-preview-link">
                                <i class="fas fa-external-link-alt" style="font-size:9px;"></i> Open preview
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Quick fill --}}
                    <div class="qf-bar">
                        <input type="url" id="qfBase" class="qf-input"
                               placeholder="⚡ Paste campaign base URL to fill all 3 at once…">
                        <button type="button" class="qf-btn" onclick="quickFill()">
                            <i class="fas fa-magic" style="margin-right:5px;"></i>Fill All
                        </button>
                    </div>

                </div>
            </div>

            {{-- ── 04 IMAGE ── --}}
            <div class="dpf-section" id="sec-media">
                <div class="dpf-section-head">
                    <div class="dpf-section-num">04</div>
                    <div>
                        <div class="dpf-section-title">Project Image</div>
                        <div class="dpf-section-sub">Cover photo displayed on the donate page</div>
                    </div>
                </div>
                <div class="dpf-section-body">

                    <div class="img-drop-zone {{ $project->image ? 'has-image' : '' }}"
                         id="dropZone"
                         onclick="document.getElementById('imgInput').click()"
                         ondragover="event.preventDefault();this.classList.add('dragging')"
                         ondragleave="this.classList.remove('dragging')"
                         ondrop="handleDrop(event)">

                        @if($project->image)
                        <img src="{{ asset($project->image) }}" class="preview-img" id="previewUploadImg">
                        <div class="img-overlay">
                            <i class="fas fa-cloud-upload-alt" style="font-size:20px;color:#fff;"></i>
                            <span>Replace image</span>
                        </div>
                        @else
                        <div id="dropPlaceholder">
                            <i class="fas fa-image img-upload-icon" style="display:block;margin:0 auto 8px;"></i>
                            <div class="img-upload-title">Drop image here or click to browse</div>
                            <div class="img-upload-sub">JPG, PNG, WebP — max 3MB</div>
                        </div>
                        <img src="" class="preview-img" id="previewUploadImg" style="display:none;">
                        <div class="img-overlay" id="imgOverlay" style="display:none;">
                            <i class="fas fa-cloud-upload-alt" style="font-size:20px;color:#fff;"></i>
                            <span>Replace image</span>
                        </div>
                        @endif

                        <input type="file" name="image" accept="image/*" class="hidden" id="imgInput"
                               onchange="handleFileSelect(this)">
                    </div>

                    <p class="img-path-hint">
                        <i class="fas fa-folder-open"></i>
                        Saved to <code>public/uploads/projects/</code> — no Storage symlink needed
                    </p>
                </div>
            </div>

            {{-- ── 05 SETTINGS ── --}}
            <div class="dpf-section" id="sec-settings">
                <div class="dpf-section-head">
                    <div class="dpf-section-num">05</div>
                    <div>
                        <div class="dpf-section-title">Settings</div>
                        <div class="dpf-section-sub">Badge, tags, visibility and sort order</div>
                    </div>
                </div>
                <div class="dpf-section-body">

                    <div class="dpf-field">
                        <label class="dpf-label">Tags <span style="font-weight:500;text-transform:none;letter-spacing:0;color:#cbd5e1;">(comma separated)</span></label>
                        <input type="text" name="tags" class="dpf-input"
                               value="{{ old('tags', is_array($project->tags) ? implode(', ', $project->tags) : '') }}"
                               placeholder="Children, Education, Cambodia, Food">
                    </div>

                    <div class="dpf-grid-2 dpf-field">
                        <div>
                            <label class="dpf-label">Badge Label</label>
                            <input type="text" name="badge_label" class="dpf-input"
                                   value="{{ old('badge_label', $project->badge_label ?? 'Active') }}"
                                   placeholder="Active"
                                   oninput="document.getElementById('prevBadge').textContent=this.value||'Active'">
                        </div>
                        <div>
                            <label class="dpf-label">Badge Color</label>
                            <div class="swatch-group" id="swatchGroup" style="margin-top:2px;">
                                @foreach(['orange'=>'#f97316','green'=>'#22c55e','blue'=>'#3b82f6','gray'=>'#9ca3af'] as $val=>$hex)
                                <div class="swatch {{ old('badge_color', $project->badge_color ?? 'orange') === $val ? 'selected' : '' }}"
                                     style="background:{{ $hex }};"
                                     title="{{ ucfirst($val) }}"
                                     onclick="selectSwatch(this,'{{ $val }}')">
                                </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="badge_color" id="badgeColorInput"
                                   value="{{ old('badge_color', $project->badge_color ?? 'orange') }}">
                        </div>
                    </div>

                    <div class="setting-row">
                        <div>
                            <div class="setting-row-label">Sort Order</div>
                            <div class="setting-row-sub">Lower number appears first</div>
                        </div>
                        <input type="number" name="sort_order" min="0"
                               value="{{ old('sort_order', $project->sort_order ?? 0) }}"
                               class="dpf-input" style="width:90px;text-align:center;padding:8px 12px;">
                    </div>

                    <div class="setting-row">
                        <div>
                            <div class="setting-row-label">Show on website</div>
                            <div class="setting-row-sub">Visible to visitors on the donate page</div>
                        </div>
                        <div class="toggle-wrap">
                            <input type="hidden" name="is_active" value="0">
                            <label class="toggle">
                                <input type="checkbox" name="is_active" value="1"
                                       {{ old('is_active', $project->is_active ?? true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>

        </div>{{-- end form sections --}}
    </div>{{-- end dpf-wrap --}}
</form>

<script>
/* ── Language tab switcher ── */
function switchLang(group, lang, btn) {
    document.querySelectorAll('#' + group + 'Tabs .lang-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('[id^="' + group + '-"]').forEach(p => p.classList.remove('active'));
    document.getElementById(group + '-' + lang).classList.add('active');
}

/* ── Sidebar nav ── */
function setNav(el) {
    document.querySelectorAll('.dpf-nav-item').forEach(i => i.classList.remove('active'));
    el.classList.add('active');
}

/* ── Scroll spy ── */
const sections = ['sec-titles','sec-desc','sec-ha','sec-media','sec-settings'];
const navItems = document.querySelectorAll('.dpf-nav-item');
window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(id => {
        const el = document.getElementById(id);
        if (el && el.getBoundingClientRect().top < 160) current = id;
    });
    navItems.forEach((item, i) => {
        item.classList.toggle('active', sections[i] === current || (!current && i === 0));
    });
}, { passive: true });

/* ── HelloAsso quick fill ── */
function quickFill() {
    const base = document.getElementById('qfBase').value.trim().replace(/\/$/, '');
    if (!base) return;
    const fields = [
        ['helloasso_widget_url',   '/widget'],
        ['helloasso_counter_url',  '/widget-compteur'],
        ['helloasso_vignette_url', '/widget-vignette'],
    ];
    fields.forEach(([name, suffix]) => {
        const el = document.querySelector('[name=' + name + ']');
        if (el) {
            el.value = base + suffix;
            el.style.borderColor = '#22c55e';
            setTimeout(() => el.style.borderColor = '', 1500);
        }
    });
    document.getElementById('qfBase').value = '';
}

/* ── Image upload ── */
function handleFileSelect(input) {
    if (input.files[0]) processImage(input.files[0]);
}
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('dropZone').classList.remove('dragging');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        document.getElementById('imgInput').files = e.dataTransfer.files;
        processImage(file);
    }
}
function processImage(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const zone = document.getElementById('dropZone');
        zone.classList.add('has-image');
        const placeholder = document.getElementById('dropPlaceholder');
        const img  = document.getElementById('previewUploadImg');
        const overlay = document.getElementById('imgOverlay');
        if (placeholder) placeholder.style.display = 'none';
        img.src = e.target.result;
        img.style.display = 'block';
        if (overlay) overlay.style.display = 'flex';

        // Update sidebar preview
        const sideImg = document.getElementById('previewImgEl');
        if (sideImg.tagName === 'IMG') {
            sideImg.src = e.target.result;
        } else {
            const newImg = document.createElement('img');
            newImg.src = e.target.result;
            newImg.className = 'dpf-preview-img';
            newImg.id = 'previewImgEl';
            sideImg.replaceWith(newImg);
        }
    };
    reader.readAsDataURL(file);
}

/* ── Badge color swatch ── */
function selectSwatch(el, val) {
    document.querySelectorAll('.swatch').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('badgeColorInput').value = val;
}

/* ── Nav smooth scroll ── */
document.querySelectorAll('.dpf-nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        const target = document.querySelector(href);
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>
@endsection