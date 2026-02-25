{{-- resources/views/sponsor/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsor Dashboard | {{ $sponsor->full_name }}</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        body { font-family: 'Montserrat', sans-serif; }

        /* ── Entity tabs (Family / Child) ── */
        .entity-btn { transition: all .15s; border-bottom: 3px solid transparent; }
        .entity-btn.active { border-bottom-color: #f97316; color: #f97316; font-weight: 900; }

        /* ── Year pills ── */
        .year-btn { transition: all .2s; }
        .year-btn.active { background: #f97316; color: #fff; box-shadow: 0 4px 12px rgba(249,115,22,.35); }

        /* ── Panels ── */
        .entity-panel { display: none; }
        .entity-panel.active { display: block; animation: fadeUp .25s ease; }
        .year-section { display: none; }
        .year-section.active { display: block; animation: fadeUp .2s ease; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: none; }
        }

        /* ── Update type badges ── */
        .badge-health    { background:#dcfce7; color:#166534; }
        .badge-education { background:#dbeafe; color:#1e40af; }
        .badge-study     { background:#e0e7ff; color:#3730a3; }
        .badge-financial { background:#fef9c3; color:#854d0e; }
        .badge-general   { background:#f1f5f9; color:#475569; }
        .badge-visit     { background:#fce7f3; color:#9d174d; }

        /* ── Video thumbnail play button ── */
        .play-overlay {
            position: absolute; inset: 0;
            background: rgba(0,0,0,.35);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity .2s;
        }
        .media-thumb:hover .play-overlay { opacity: 1; }

        /* ── Lightbox ── */
        #lightbox { display: none; }
        #lightbox.open { display: flex; }

        /* ── Hide Google Translate toolbar ── */
        body { top: 0 !important; }
        .goog-te-banner-frame,.goog-te-balloon-frame,#goog-gt-tt,.goog-te-spinner-pos,.skiptranslate { display:none !important; }
        iframe.goog-te-banner-frame { display:none !important; }

        /* ── Language dropdown ── */
        .lang-pill {
            display:inline-flex; align-items:center; gap:6px;
            padding:5px 12px 5px 8px; border-radius:999px;
            border:1px solid #e5e7eb; background:#fff;
            cursor:pointer; font-size:12px; font-weight:700; color:#374151;
            transition:all .18s; white-space:nowrap; box-shadow:0 1px 3px rgba(0,0,0,.07);
        }
        .lang-pill:hover { border-color:#f97316; color:#f97316; box-shadow:0 2px 8px rgba(249,115,22,.15); }
        #dash-translate-panel {
            position:absolute; top:calc(100% + 8px); left:0;
            width:200px; background:#fff; border-radius:12px;
            box-shadow:0 12px 40px rgba(0,0,0,.18); border:1px solid #f0f0f0;
            padding:10px; opacity:0; visibility:hidden;
            transform:translateY(-6px);
            transition:all .22s cubic-bezier(.34,1.56,.64,1);
            z-index:9999;
        }
        #dash-translate-panel.open { opacity:1; visibility:visible; transform:translateY(0); }
        .lang-opt {
            display:flex; align-items:center; gap:9px;
            width:100%; padding:8px 10px; border-radius:8px;
            border:2px solid transparent; background:transparent;
            cursor:pointer; transition:all .15s; text-align:left;
            font-size:12px; font-weight:600; color:#374151;
        }
        .lang-opt:hover { background:#fff7ed; border-color:#fed7aa; }
        .lang-opt.active { background:linear-gradient(135deg,#fff7ed,#ffedd5); border-color:#f97316; color:#c2410c; }
        .lang-opt .flag { width:22px; height:15px; object-fit:cover; border-radius:2px; box-shadow:0 1px 4px rgba(0,0,0,.15); flex-shrink:0; }
        .lang-opt .chk { margin-left:auto; color:#f97316; font-size:10px; }
        @keyframes gt-spin { to { transform:rotate(360deg); } }
        .gt-spin { display:inline-block; animation:gt-spin .7s linear infinite; }

        /* ── NEW badge ── */
        .new-dot::after {
            content: 'NEW';
            font-size: 9px; font-weight: 900;
            background: #ef4444; color: #fff;
            padding: 1px 5px; border-radius: 99px;
            margin-left: 6px; vertical-align: middle;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%,100% { opacity:1; } 50% { opacity:.5; }
        }
    </style>
    {{-- Google Translate --}}
    <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,km,fr',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false, multilanguagePage: true
        }, 'google_translate_element');
    }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">

{{-- ── Header ── --}}
<header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" style="height:80px;width:auto;" alt="Logo">
        </a>
        <div class="flex items-center gap-3">

            {{-- Language dropdown --}}
            <div class="relative" id="dash-translate-wrapper">
                <div id="google_translate_element" style="display:none;position:absolute"></div>
                <button class="lang-pill" onclick="dashTogglePanel()" id="dash-translate-toggle">
                    <img src="https://flagcdn.com/w40/fr.png" id="dash-flag" class="w-5 h-3.5 rounded object-cover shadow-sm" alt="FR">
                    <span id="dash-lang-label" class="font-black">FR</span>
                    <i class="fas fa-chevron-down text-[9px] text-gray-400" id="dash-caret"></i>
                </button>
                <div id="dash-translate-panel">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-1 mb-2">
                        <i class="fas fa-globe mr-1 text-orange-400"></i> Language
                    </p>
                    <button class="lang-opt" id="dash-btn-en" onclick="dashSwitchLang('en')">
                        <img src="https://flagcdn.com/w40/us.png" class="flag" alt="EN">
                        <div><div class="font-bold">English</div><div class="text-[10px] font-normal text-gray-400">Original</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-en"></i>
                    </button>
                    <button class="lang-opt" id="dash-btn-fr" onclick="dashSwitchLang('fr')">
                        <img src="https://flagcdn.com/w40/fr.png" class="flag" alt="FR">
                        <div><div class="font-bold">Français</div><div class="text-[10px] font-normal text-gray-400">French</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-fr"></i>
                    </button>
                    <button class="lang-opt" id="dash-btn-km" onclick="dashSwitchLang('km')">
                        <img src="https://flagcdn.com/w40/kh.png" class="flag" alt="KH">
                        <div><div class="font-bold">ខ្មែរ</div><div class="text-[10px] font-normal text-gray-400">Cambodian</div></div>
                        <i class="fas fa-check chk hidden" id="dash-check-km"></i>
                    </button>
                </div>
            </div>

            <div class="hidden md:block text-right">
                <p class="text-sm font-bold text-gray-800">{{ $sponsor->full_name }}</p>
                <p class="text-xs text-gray-500">{{ $sponsor->email }}</p>
            </div>
            <form method="POST" action="{{ route('sponsor.logout') }}">
                @csrf
                <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-lg transition">
                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                </button>
            </form>
        </div>
    </div>
</header>

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- ── Welcome banner ── --}}
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-8 mb-8 text-white shadow-xl">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0 shadow-lg">
                <span class="text-4xl font-black">{{ strtoupper(substr($sponsor->first_name, 0, 1)) }}</span>
            </div>
            <div class="text-center md:text-left flex-1">
                <h2 class="text-3xl md:text-4xl font-black mb-2">Welcome, {{ $sponsor->first_name }}!</h2>
                <p class="opacity-90 mb-3">Thank you for your generous support.</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-2">
                    @if($families->isNotEmpty())
                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/20 rounded-full text-sm font-bold">
                        <i class="fas fa-home text-xs"></i> {{ $families->count() }} {{ Str::plural('Family', $families->count()) }}
                    </span>
                    @endif
                    @if($children->isNotEmpty())
                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/20 rounded-full text-sm font-bold">
                        <i class="fas fa-child text-xs"></i> {{ $children->count() }} {{ Str::plural('Child', $children->count()) }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ── Entity tabs (families + children) ── --}}
    @php $totalEntities = $families->count() + $children->count(); @endphp
    @if($totalEntities > 1)
    <div class="bg-white rounded-2xl shadow-sm mb-6 overflow-x-auto">
        <div class="flex min-w-max px-2">
            @foreach($families as $fi => $family)
            <button type="button"
                    class="entity-btn flex items-center gap-2 px-5 py-4 text-sm font-bold text-gray-500 hover:text-orange-500 whitespace-nowrap {{ $fi === 0 ? 'active' : '' }}"
                    onclick="switchEntity({{ $fi }})">
                <i class="fas fa-home text-xs"></i> {{ $family->name }}
            </button>
            @endforeach
            @foreach($children as $ci => $child)
            @php $eidx = $families->count() + $ci; @endphp
            <button type="button"
                    class="entity-btn flex items-center gap-2 px-5 py-4 text-sm font-bold text-gray-500 hover:text-orange-500 whitespace-nowrap {{ $eidx === 0 ? 'active' : '' }}"
                    onclick="switchEntity({{ $eidx }})">
                <i class="fas fa-child text-xs"></i> {{ $child->first_name }}
            </button>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════ --}}
    {{-- FAMILY PANELS                               --}}
    {{-- ═══════════════════════════════════════════ --}}
    @foreach($families as $fi => $family)
    @php
        $fYears = collect();
        foreach($family->updates  as $u) { $fYears->push(\Carbon\Carbon::parse($u->report_date ?? $u->created_at)->year); }
        foreach($family->media    as $m) { $fYears->push($m->created_at->year); }
        foreach($family->documents as $d){ $fYears->push($d->created_at->year); }
        $fYears = $fYears->unique()->sortDesc()->values();
        $fLatestYear = $fYears->first() ?? now()->year;
        $fPanelId = "ep-{$fi}";
    @endphp
    <div class="entity-panel {{ ($totalEntities === 1 || $fi === 0) ? 'active' : '' }}" id="{{ $fPanelId }}">

        {{-- Family hero --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden mb-6">
            <div class="flex flex-col sm:flex-row">
                <div class="sm:w-56 h-48 sm:h-auto bg-orange-50 flex-shrink-0 flex items-center justify-center overflow-hidden">
                    @if($family->profile_photo)
                        <img src="{{ $family->profile_photo_url ?? asset($family->profile_photo) }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-home text-7xl text-orange-200"></i>
                    @endif
                </div>
                <div class="p-6 flex-1">
                    <h3 class="text-2xl font-black text-gray-800 mb-1">{{ $family->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">
                        @if($family->country)<i class="fas fa-map-marker-alt text-orange-400 mr-1"></i>{{ $family->country }} · @endif
                        <span class="font-mono text-xs bg-gray-100 px-1.5 py-0.5 rounded">{{ $family->code }}</span>
                    </p>
                    @if($family->story)
                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-4">{{ $family->story }}</p>
                    @endif
                    <div class="flex flex-wrap gap-3 mt-4">
                        <span class="flex items-center gap-1 text-xs font-bold text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                            <i class="fas fa-newspaper"></i> {{ $family->updates->count() }} Updates
                        </span>
                        <span class="flex items-center gap-1 text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">
                            <i class="fas fa-images"></i> {{ $family->media->where('type','photo')->count() }} Photos
                        </span>
                        <span class="flex items-center gap-1 text-xs font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full">
                            <i class="fas fa-video"></i> {{ $family->media->where('type','video')->count() }} Videos
                        </span>
                        <span class="flex items-center gap-1 text-xs font-bold text-yellow-700 bg-yellow-50 px-2.5 py-1 rounded-full">
                            <i class="fas fa-file"></i> {{ $family->documents->count() }} Documents
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Year filter bar --}}
        @if($fYears->isNotEmpty())
        <div class="flex items-center gap-2 mb-5 flex-wrap">
            <span class="text-xs font-black text-gray-400 uppercase tracking-wide mr-1">Filter by year:</span>
            <button onclick="switchYear('{{ $fPanelId }}', 'latest')"
                    class="year-btn active px-4 py-1.5 rounded-full text-sm font-bold border border-orange-200 text-orange-600 bg-orange-50"
                    data-panel="{{ $fPanelId }}" data-year="latest">
                <i class="fas fa-star text-xs mr-1"></i> Latest
            </button>
            @foreach($fYears as $yr)
            <button onclick="switchYear('{{ $fPanelId }}', '{{ $yr }}')"
                    class="year-btn px-4 py-1.5 rounded-full text-sm font-bold border border-gray-200 text-gray-600 bg-white hover:border-orange-300 hover:text-orange-500"
                    data-panel="{{ $fPanelId }}" data-year="{{ $yr }}">
                {{ $yr }}
            </button>
            @endforeach
        </div>
        @endif

        {{-- Latest section --}}
        <div class="year-section active" data-panel="{{ $fPanelId }}" data-section="latest">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-5">
                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-newspaper text-green-500"></i> Latest Updates
                            <span class="ml-auto text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">NEW</span>
                        </h3>
                        @forelse($family->updates->sortByDesc('report_date')->take(3) as $update)
                        <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                            <div class="flex items-start justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-2 flex-wrap">
                                    @if($update->title)
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $update->title }}</h4>
                                    @endif
                                    @if($update->type)
                                    <span class="text-[10px] font-black px-2 py-0.5 rounded-full badge-{{ $update->type }} capitalize">{{ $update->type }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-400 flex-shrink-0">{{ \Carbon\Carbon::parse($update->report_date ?? $update->created_at)->format('M d, Y') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $update->content }}</p>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm text-center py-4">No updates yet.</p>
                        @endforelse
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-photo-film text-orange-500"></i> Latest Media
                            <span class="ml-auto text-xs font-bold text-orange-500 bg-orange-50 px-2 py-0.5 rounded-full">NEW</span>
                        </h3>
                        @php $latestFMedia = $family->media->sortByDesc('created_at')->take(6); @endphp
                        @if($latestFMedia->isNotEmpty())
                        <div class="grid grid-cols-3 gap-3">
                            @foreach($latestFMedia as $m)
                            <div class="media-thumb group relative aspect-square overflow-hidden rounded-xl cursor-pointer bg-gray-100"
                                 onclick="openLightbox('{{ asset($m->file_path) }}', '{{ $m->type }}', '{{ addslashes($m->caption ?? '') }}', '{{ route('sponsor.download', ['type'=>'family_media','id'=>$m->id]) }}')">
                                @if($m->type === 'video')
                                    <video src="{{ asset($m->file_path) }}" class="w-full h-full object-cover pointer-events-none" muted playsinline></video>
                                    <div class="absolute top-1.5 left-1.5 bg-black/60 text-white rounded-md px-1.5 py-0.5 text-[9px] font-bold flex items-center gap-1 z-10">
                                        <i class="fas fa-play text-[7px]"></i> VIDEO
                                    </div>
                                @else
                                    <img src="{{ asset($m->file_path) }}" class="w-full h-full object-cover pointer-events-none group-hover:scale-110 transition duration-300">
                                @endif
                                <div class="play-overlay rounded-xl">
                                    <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="fas fa-{{ $m->type === 'video' ? 'play' : 'expand' }} text-orange-500 {{ $m->type === 'video' ? 'ml-0.5' : '' }}"></i>
                                    </div>
                                </div>
                                @if($m->caption)
                                <p class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[9px] px-1.5 py-1 truncate pointer-events-none">{{ $m->caption }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-400 text-sm text-center py-6"><i class="fas fa-images text-3xl text-gray-200 block mb-2"></i>No media yet.</p>
                        @endif
                    </div>
                </div>
                <div class="space-y-5">
                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-base font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-file-pdf text-orange-500"></i> Documents
                        </h3>
                        @forelse($family->documents->sortByDesc('created_at')->take(5) as $doc)
                        <div class="flex items-start gap-3 p-3 bg-gray-50 hover:bg-orange-50 rounded-xl mb-2 last:mb-0 transition group">
                            <div class="w-9 h-9 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-file-pdf text-red-500 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ $doc->title }}</p>
                                @if($doc->document_date)<p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($doc->document_date)->format('M d, Y') }}</p>@endif
                                @if($doc->type)<span class="text-[10px] font-bold text-gray-400 uppercase">{{ $doc->type }}</span>@endif
                            </div>
                            <a href="{{ route('sponsor.download', ['type'=>'family_document','id'=>$doc->id]) }}"
                               class="flex-shrink-0 w-8 h-8 bg-orange-100 hover:bg-orange-200 text-orange-500 rounded-full flex items-center justify-center transition" title="Download">
                                <i class="fas fa-download text-xs"></i>
                            </a>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm text-center py-3">No documents yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Per-year sections --}}
        @foreach($fYears as $yr)
        @php
            $yMedia = $family->media->filter(fn($m) => $m->created_at->year == $yr)->sortByDesc('created_at');
            $yDocs  = $family->documents->filter(fn($d) => $d->created_at->year == $yr)->sortByDesc('created_at');
            $yPhotos = $yMedia->where('type','photo');
            $yVideos = $yMedia->where('type','video');
        @endphp
        <div class="year-section" data-panel="{{ $fPanelId }}" data-section="{{ $yr }}">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-5">
                    @php $yFUpdates = $family->updates->filter(fn($u) => \Carbon\Carbon::parse($u->report_date ?? $u->created_at)->year == $yr)->sortByDesc('report_date'); @endphp
                    @if($yFUpdates->isNotEmpty())
                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-newspaper text-green-500"></i> Updates · {{ $yr }}
                            <span class="ml-auto text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">{{ $yFUpdates->count() }}</span>
                        </h3>
                        @php $fUpdateTypes = $yFUpdates->pluck('type')->filter()->unique()->values(); @endphp
                        @if($fUpdateTypes->count() > 1)
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wide self-center mr-1">Types:</span>
                            @foreach($fUpdateTypes as $utype)
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full badge-{{ $utype }} capitalize">{{ $utype }}</span>
                            @endforeach
                        </div>
                        @endif
                        @foreach($yFUpdates as $update)
                        <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                            <div class="flex items-start justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-2 flex-wrap">
                                    @if($update->title)
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $update->title }}</h4>
                                    @endif
                                    @if($update->type)
                                    <span class="text-[10px] font-black px-2 py-0.5 rounded-full badge-{{ $update->type }} capitalize">{{ $update->type }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-400 flex-shrink-0">{{ \Carbon\Carbon::parse($update->report_date ?? $update->created_at)->format('M d, Y') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $update->content }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if($yPhotos->isNotEmpty())
                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-images text-blue-500"></i> Photos · {{ $yr }}
                            <span class="ml-auto text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $yPhotos->count() }}</span>
                        </h3>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach($yPhotos as $photo)
                            <div class="media-thumb group relative aspect-square overflow-hidden rounded-xl cursor-pointer bg-gray-100"
                                 onclick="openLightbox('{{ asset($photo->file_path) }}', 'image', '{{ addslashes($photo->caption ?? '') }}', '{{ route('sponsor.download', ['type'=>'family_media','id'=>$photo->id]) }}')">
                                <img src="{{ asset($photo->file_path) }}" class="w-full h-full object-cover pointer-events-none group-hover:scale-110 transition duration-300">
                                <div class="play-overlay rounded-xl">
                                    <div class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center shadow">
                                        <i class="fas fa-expand text-orange-500 text-sm"></i>
                                    </div>
                                </div>
                                @if($photo->caption)
                                <p class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[9px] px-1.5 py-1 truncate pointer-events-none">{{ $photo->caption }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($yVideos->isNotEmpty())
                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-video text-purple-500"></i> Videos · {{ $yr }}
                            <span class="ml-auto text-xs font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">{{ $yVideos->count() }}</span>
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($yVideos as $video)
                            <div class="media-thumb group relative aspect-video overflow-hidden rounded-xl cursor-pointer bg-gray-900"
                                 onclick="openLightbox('{{ asset($video->file_path) }}', 'video', '{{ addslashes($video->caption ?? '') }}', '{{ route('sponsor.download', ['type'=>'family_media','id'=>$video->id]) }}')">
                                <video src="{{ asset($video->file_path) }}" class="w-full h-full object-cover pointer-events-none opacity-80" muted playsinline></video>
                                <div class="play-overlay rounded-xl" style="opacity:1;background:rgba(0,0,0,.4)">
                                    <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="fas fa-play text-orange-500 ml-0.5"></i>
                                    </div>
                                </div>
                                <div class="absolute top-1.5 left-1.5 bg-black/60 text-white rounded-md px-1.5 py-0.5 text-[9px] font-bold flex items-center gap-1">
                                    <i class="fas fa-play text-[7px]"></i> VIDEO
                                </div>
                                @if($video->caption)
                                <p class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-[9px] px-1.5 py-1 truncate">{{ $video->caption }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($yFUpdates->isEmpty() && $yPhotos->isEmpty() && $yVideos->isEmpty())
                    <div class="bg-white rounded-xl p-10 shadow text-center">
                        <i class="fas fa-calendar text-4xl text-gray-200 mb-3 block"></i>
                        <p class="text-gray-400 text-sm">No content for {{ $yr }}.</p>
                    </div>
                    @endif
                </div>
                <div class="space-y-5">
                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-base font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-folder text-yellow-500"></i> Documents · {{ $yr }}
                            @if($yDocs->isNotEmpty())
                            <span class="ml-auto text-xs font-bold text-yellow-700 bg-yellow-50 px-2 py-0.5 rounded-full">{{ $yDocs->count() }}</span>
                            @endif
                        </h3>
                        @forelse($yDocs as $doc)
                        <div class="flex items-start gap-3 p-3 bg-gray-50 hover:bg-orange-50 rounded-xl mb-2 last:mb-0 transition group">
                            <div class="w-9 h-9 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-file-pdf text-red-500 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ $doc->title }}</p>
                                @if($doc->document_date)<p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($doc->document_date)->format('M d, Y') }}</p>@endif
                                @if($doc->type)<span class="text-[10px] font-bold text-gray-400 uppercase">{{ $doc->type }}</span>@endif
                            </div>
                            <a href="{{ route('sponsor.download', ['type'=>'family_document','id'=>$doc->id]) }}"
                               class="flex-shrink-0 w-8 h-8 bg-orange-100 hover:bg-orange-200 text-orange-500 rounded-full flex items-center justify-center transition">
                                <i class="fas fa-download text-xs"></i>
                            </a>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm text-center py-4">No documents for {{ $yr }}.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>{{-- /family entity panel --}}
    @endforeach

    {{-- ═══════════════════════════════════════════ --}}
    {{-- CHILD PANELS                                --}}
    {{-- ═══════════════════════════════════════════ --}}
    @foreach($children as $ci => $child)
    @php
        $eidx = $families->count() + $ci;
        $cPanelId = "ep-{$eidx}";

        $cYears = collect();
        foreach($child->updates  as $u) { $cYears->push(\Carbon\Carbon::parse($u->report_date ?? $u->created_at)->year); }
        foreach($child->media    as $m) { $cYears->push($m->created_at->year); }
        foreach($child->documents as $d){ $cYears->push($d->created_at->year); }
        $cYears = $cYears->unique()->sortDesc()->values();
    @endphp
    <div class="entity-panel {{ ($totalEntities === 1 || $eidx === 0) ? 'active' : '' }}" id="{{ $cPanelId }}">

        {{-- ── Child hero ── --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden mb-6">
            <div class="flex flex-col sm:flex-row items-center gap-6 p-6">
                <div class="w-32 h-32 rounded-2xl overflow-hidden border-4 border-orange-100 flex-shrink-0 shadow-md bg-orange-50 flex items-center justify-center">
                    @if($child->profile_photo)
                        <img src="{{ asset($child->profile_photo) }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-child text-5xl text-orange-200"></i>
                    @endif
                </div>
                <div class="text-center sm:text-left flex-1">
                    <div class="flex items-center gap-3 justify-center sm:justify-start flex-wrap mb-1">
                        <h3 class="text-2xl font-black text-gray-800">{{ $child->first_name }}</h3>
                        {{-- ── Has Family status badge ── --}}
                        @if($child->has_family)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-green-100 text-green-700 border border-green-200">
                            <i class="fas fa-home text-[10px]"></i> Has Family
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-red-100 text-red-600 border border-red-200">
                            <i class="fas fa-home text-[10px]"></i> No Family
                        </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fas fa-birthday-cake text-orange-400 mr-1"></i>{{ $child->age }} years old ·
                        <i class="fas fa-map-marker-alt text-orange-400 mx-1"></i>{{ $child->country }}
                    </p>
                    <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded inline-block mt-1">{{ $child->code }}</span>
                    {{-- Stats row --}}
                    <div class="flex flex-wrap gap-2 mt-3 justify-center sm:justify-start">
                        <span class="text-xs font-bold text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                            <i class="fas fa-newspaper mr-1"></i>{{ $child->updates->count() }} Updates
                        </span>
                        <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">
                            <i class="fas fa-images mr-1"></i>{{ $child->media->where('type','image')->count() + $child->media->where('type','photo')->count() }} Photos
                        </span>
                        <span class="text-xs font-bold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-full">
                            <i class="fas fa-video mr-1"></i>{{ $child->media->where('type','video')->count() }} Videos
                        </span>
                        <span class="text-xs font-bold text-yellow-700 bg-yellow-50 px-2.5 py-1 rounded-full">
                            <i class="fas fa-file mr-1"></i>{{ $child->documents->count() }} Docs
                        </span>
                    </div>
                </div>
            </div>
            @if($child->story)
            <div class="px-6 pb-6 border-t border-gray-50 pt-4">
                <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">{{ $child->story }}</p>
            </div>
            @endif
        </div>

        {{-- Year filter bar --}}
        @if($cYears->isNotEmpty())
        <div class="flex items-center gap-2 mb-5 flex-wrap">
            <span class="text-xs font-black text-gray-400 uppercase tracking-wide mr-1">Filter by year:</span>
            <button onclick="switchYear('{{ $cPanelId }}', 'latest')"
                    class="year-btn active px-4 py-1.5 rounded-full text-sm font-bold border border-orange-200 text-orange-600 bg-orange-50"
                    data-panel="{{ $cPanelId }}" data-year="latest">
                <i class="fas fa-star text-xs mr-1"></i> Latest
            </button>
            @foreach($cYears as $yr)
            <button onclick="switchYear('{{ $cPanelId }}', '{{ $yr }}')"
                    class="year-btn px-4 py-1.5 rounded-full text-sm font-bold border border-gray-200 text-gray-600 bg-white hover:border-orange-300 hover:text-orange-500"
                    data-panel="{{ $cPanelId }}" data-year="{{ $yr }}">
                {{ $yr }}
            </button>
            @endforeach
        </div>
        @endif

        {{-- Latest section --}}
        <div class="year-section active" data-panel="{{ $cPanelId }}" data-section="latest">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-5">

                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-newspaper text-green-500"></i> Latest Updates
                            <span class="ml-auto text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">NEW</span>
                        </h3>
                        @forelse($child->updates->sortByDesc('report_date')->take(3) as $update)
                        <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                            <div class="flex items-start justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-2 flex-wrap">
                                    @if($update->title)
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $update->title }}</h4>
                                    @endif
                                    @if($update->type)
                                    <span class="text-[10px] font-black px-2 py-0.5 rounded-full badge-{{ $update->type }} capitalize">{{ $update->type }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-400 flex-shrink-0">{{ \Carbon\Carbon::parse($update->report_date ?? $update->created_at)->format('M d, Y') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $update->content }}</p>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm text-center py-4">No updates yet.</p>
                        @endforelse
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-photo-film text-orange-500"></i> Latest Media
                        </h3>
                        @php $latestCMedia = $child->media->sortByDesc('created_at')->take(6); @endphp
                        @if($latestCMedia->isNotEmpty())
                        <div class="grid grid-cols-3 gap-3">
                            @foreach($latestCMedia as $m)
                            <div class="media-thumb group relative aspect-square overflow-hidden rounded-xl cursor-pointer bg-gray-100"
                                 onclick="openLightbox('{{ asset($m->file_path) }}', '{{ $m->type }}', '{{ addslashes($m->caption ?? '') }}', '{{ route('sponsor.download', ['type'=>'media','id'=>$m->id]) }}')">
                                @if($m->type === 'video')
                                    <video src="{{ asset($m->file_path) }}" class="w-full h-full object-cover pointer-events-none" muted playsinline></video>
                                    <div class="absolute top-1.5 left-1.5 bg-black/60 text-white rounded-md px-1.5 py-0.5 text-[9px] font-bold flex items-center gap-1 z-10">
                                        <i class="fas fa-play text-[7px]"></i> VIDEO
                                    </div>
                                @else
                                    <img src="{{ asset($m->file_path) }}" class="w-full h-full object-cover pointer-events-none group-hover:scale-110 transition duration-300">
                                @endif
                                <div class="play-overlay rounded-xl">
                                    <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="fas fa-{{ $m->type === 'video' ? 'play' : 'expand' }} text-orange-500 {{ $m->type === 'video' ? 'ml-0.5' : '' }}"></i>
                                    </div>
                                </div>
                                @if($m->caption)
                                <p class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[9px] px-1.5 py-1 truncate pointer-events-none">{{ $m->caption }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-400 text-sm text-center py-6"><i class="fas fa-images text-3xl text-gray-200 block mb-2"></i>No media yet.</p>
                        @endif
                    </div>

                </div>
                <div class="space-y-5">
                    {{-- ── Family info card (only shown when child has a family) ── --}}
                    @if($child->has_family && $child->family)
                    <div class="bg-white rounded-xl p-5 shadow border-l-4 border-green-400">
                        <h3 class="text-sm font-black text-gray-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-home text-green-500"></i> Family
                        </h3>
                        <div class="flex items-center gap-3">
                            @if($child->family->profile_photo)
                            <img src="{{ asset($child->family->profile_photo) }}" class="w-12 h-12 rounded-xl object-cover border-2 border-green-100 flex-shrink-0">
                            @else
                            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0 border-2 border-green-100">
                                <i class="fas fa-users text-green-400 text-lg"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800 text-sm truncate">{{ $child->family->name }}</p>
                                @if($child->family->country)
                                <p class="text-xs text-gray-400"><i class="fas fa-map-marker-alt mr-1 text-orange-400 text-[10px]"></i>{{ $child->family->country }}</p>
                                @endif
                                @if($child->family->code)
                                <p class="font-mono text-[10px] text-gray-400 mt-0.5">{{ $child->family->code }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-base font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-file-pdf text-orange-500"></i> Documents
                        </h3>
                        @forelse($child->documents->sortByDesc('created_at')->take(5) as $doc)
                        <div class="flex items-start gap-3 p-3 bg-gray-50 hover:bg-orange-50 rounded-xl mb-2 last:mb-0 transition group">
                            <div class="w-9 h-9 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-file-pdf text-red-500 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ $doc->title }}</p>
                                @if($doc->document_date)<p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($doc->document_date)->format('M d, Y') }}</p>@endif
                                @if($doc->type)<span class="text-[10px] font-bold uppercase text-gray-400">{{ $doc->type }}</span>@endif
                            </div>
                            <a href="{{ route('sponsor.download', ['type'=>'document','id'=>$doc->id]) }}"
                               class="flex-shrink-0 w-8 h-8 bg-orange-100 hover:bg-orange-200 text-orange-500 rounded-full flex items-center justify-center transition">
                                <i class="fas fa-download text-xs"></i>
                            </a>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm text-center py-3">No documents yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Per-year sections for child --}}
        @foreach($cYears as $yr)
        @php
            $yUpdates = $child->updates->filter(fn($u) => \Carbon\Carbon::parse($u->report_date ?? $u->created_at)->year == $yr)->sortByDesc('report_date');
            $yMedia   = $child->media->filter(fn($m) => $m->created_at->year == $yr)->sortByDesc('created_at');
            $yDocs    = $child->documents->filter(fn($d) => $d->created_at->year == $yr)->sortByDesc('created_at');
            $yPhotos  = $yMedia->filter(fn($m) => in_array($m->type, ['image','photo']));
            $yVideos  = $yMedia->where('type','video');
        @endphp
        <div class="year-section" data-panel="{{ $cPanelId }}" data-section="{{ $yr }}">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-5">

                    @if($yUpdates->isNotEmpty())
                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-newspaper text-green-500"></i> Updates · {{ $yr }}
                            <span class="ml-auto text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">{{ $yUpdates->count() }}</span>
                        </h3>
                        @php $updateTypes = $yUpdates->pluck('type')->filter()->unique()->values(); @endphp
                        @if($updateTypes->count() > 1)
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wide self-center mr-1">Types:</span>
                            @foreach($updateTypes as $utype)
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full badge-{{ $utype }} capitalize cursor-default">{{ $utype }}</span>
                            @endforeach
                        </div>
                        @endif
                        @foreach($yUpdates as $update)
                        <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                            <div class="flex items-start justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-2 flex-wrap">
                                    @if($update->title)
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $update->title }}</h4>
                                    @endif
                                    @if($update->type)
                                    <span class="text-[10px] font-black px-2 py-0.5 rounded-full badge-{{ $update->type }} capitalize">{{ $update->type }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-400 flex-shrink-0">{{ \Carbon\Carbon::parse($update->report_date ?? $update->created_at)->format('M d, Y') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $update->content }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if($yPhotos->isNotEmpty())
                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-images text-blue-500"></i> Photos · {{ $yr }}
                            <span class="ml-auto text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $yPhotos->count() }}</span>
                        </h3>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach($yPhotos as $photo)
                            <div class="media-thumb group relative aspect-square overflow-hidden rounded-xl cursor-pointer bg-gray-100"
                                 onclick="openLightbox('{{ asset($photo->file_path) }}', 'image', '{{ addslashes($photo->caption ?? '') }}', '{{ route('sponsor.download', ['type'=>'media','id'=>$photo->id]) }}')">
                                <img src="{{ asset($photo->file_path) }}" class="w-full h-full object-cover pointer-events-none group-hover:scale-110 transition duration-300">
                                <div class="play-overlay rounded-xl">
                                    <div class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center shadow">
                                        <i class="fas fa-expand text-orange-500 text-sm"></i>
                                    </div>
                                </div>
                                @if($photo->caption)
                                <p class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[9px] px-1.5 py-1 truncate pointer-events-none">{{ $photo->caption }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($yVideos->isNotEmpty())
                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-video text-purple-500"></i> Videos · {{ $yr }}
                            <span class="ml-auto text-xs font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">{{ $yVideos->count() }}</span>
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($yVideos as $video)
                            <div class="media-thumb group relative aspect-video overflow-hidden rounded-xl cursor-pointer bg-gray-900"
                                 onclick="openLightbox('{{ asset($video->file_path) }}', 'video', '{{ addslashes($video->caption ?? '') }}', '{{ route('sponsor.download', ['type'=>'media','id'=>$video->id]) }}')">
                                <video src="{{ asset($video->file_path) }}" class="w-full h-full object-cover pointer-events-none opacity-80" muted playsinline></video>
                                <div class="play-overlay rounded-xl" style="opacity:1;background:rgba(0,0,0,.4)">
                                    <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="fas fa-play text-orange-500 ml-0.5"></i>
                                    </div>
                                </div>
                                <div class="absolute top-1.5 left-1.5 bg-black/60 text-white rounded-md px-1.5 py-0.5 text-[9px] font-bold flex items-center gap-1">
                                    <i class="fas fa-play text-[7px]"></i> VIDEO
                                </div>
                                @if($video->caption)
                                <p class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-[9px] px-1.5 py-1 truncate">{{ $video->caption }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($yUpdates->isEmpty() && $yPhotos->isEmpty() && $yVideos->isEmpty())
                    <div class="bg-white rounded-xl p-10 shadow text-center">
                        <i class="fas fa-calendar text-4xl text-gray-200 mb-3 block"></i>
                        <p class="text-gray-400 text-sm">No content for {{ $yr }}.</p>
                    </div>
                    @endif

                </div>
                <div class="space-y-5">
                    {{-- ── Family info card in year view ── --}}
                    @if($child->has_family && $child->family)
                    <div class="bg-white rounded-xl p-5 shadow border-l-4 border-green-400">
                        <h3 class="text-sm font-black text-gray-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-home text-green-500"></i> Family
                        </h3>
                        <div class="flex items-center gap-3">
                            @if($child->family->profile_photo)
                            <img src="{{ asset($child->family->profile_photo) }}" class="w-12 h-12 rounded-xl object-cover border-2 border-green-100 flex-shrink-0">
                            @else
                            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0 border-2 border-green-100">
                                <i class="fas fa-users text-green-400 text-lg"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800 text-sm truncate">{{ $child->family->name }}</p>
                                @if($child->family->country)
                                <p class="text-xs text-gray-400"><i class="fas fa-map-marker-alt mr-1 text-orange-400 text-[10px]"></i>{{ $child->family->country }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-base font-black text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-folder text-yellow-500"></i> Documents · {{ $yr }}
                            @if($yDocs->isNotEmpty())
                            <span class="ml-auto text-xs font-bold text-yellow-700 bg-yellow-50 px-2 py-0.5 rounded-full">{{ $yDocs->count() }}</span>
                            @endif
                        </h3>
                        @forelse($yDocs as $doc)
                        <div class="flex items-start gap-3 p-3 bg-gray-50 hover:bg-orange-50 rounded-xl mb-2 last:mb-0 transition group">
                            <div class="w-9 h-9 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-file-pdf text-red-500 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ $doc->title }}</p>
                                @if($doc->document_date)<p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($doc->document_date)->format('M d, Y') }}</p>@endif
                                @if($doc->type)<span class="text-[10px] font-bold uppercase text-gray-400">{{ $doc->type }}</span>@endif
                            </div>
                            <a href="{{ route('sponsor.download', ['type'=>'document','id'=>$doc->id]) }}"
                               class="flex-shrink-0 w-8 h-8 bg-orange-100 hover:bg-orange-200 text-orange-500 rounded-full flex items-center justify-center transition">
                                <i class="fas fa-download text-xs"></i>
                            </a>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm text-center py-4">No documents for {{ $yr }}.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>{{-- /child entity panel --}}
    @endforeach

    {{-- Footer note --}}
    <div class="mt-10 bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6">
        <p class="text-sm text-gray-700 leading-relaxed">
            <i class="fas fa-info-circle text-orange-500 mr-2"></i>
            <strong>Thank you for your continued support!</strong> Your sponsorship makes a real difference.
            Questions? Contact 
            <a href="https://mail.google.com/mail/?view=cm&to=asso.desailespourgrandir@gmail.com"
                target="_blank" rel="noopener"
                class="text-orange-600 hover:underline font-bold">
                    asso.desailespourgrandir@gmail.com
            </a>
        </p>
    </div>

</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- LIGHTBOX MODAL                              --}}
{{-- ═══════════════════════════════════════════ --}}
<div id="lightbox"
     class="fixed inset-0 bg-black/95 backdrop-blur-sm z-[100] items-center justify-center p-4"
     onclick="closeLightbox()">

    <div class="absolute top-0 left-0 right-0 flex items-center justify-between px-5 py-4 z-10" onclick="event.stopPropagation()">
        <p id="lb-caption" class="text-white/80 text-sm font-bold truncate max-w-sm"></p>
        <div class="flex items-center gap-2">
            <a id="lb-download" href="#" download
               class="flex items-center gap-1.5 px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-sm font-bold rounded-lg transition">
                <i class="fas fa-download text-xs"></i> Download
            </a>
            <button onclick="closeLightbox()"
                    class="w-10 h-10 bg-white/10 hover:bg-white/25 text-white rounded-full flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <div onclick="event.stopPropagation()" class="max-w-5xl max-h-[80vh] flex items-center justify-center mt-10">
        <img id="lb-img" src="" alt=""
             class="max-w-full max-h-[80vh] rounded-xl shadow-2xl object-contain"
             style="display:none;">
        <video id="lb-video" src="" controls autoplay
               class="max-w-full max-h-[80vh] rounded-xl shadow-2xl w-full"
               style="display:none;">
        </video>
    </div>

    <p class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/30 text-xs">Press ESC to close</p>
</div>

<script>
// ── Entity (family/child) tabs ──
function switchEntity(index) {
    document.querySelectorAll('.entity-btn').forEach((b, i) => b.classList.toggle('active', i === index));
    document.querySelectorAll('.entity-panel').forEach((p, i) => p.classList.toggle('active', i === index));
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Year filter ──
function switchYear(panelId, year) {
    document.querySelectorAll(`.year-btn[data-panel="${panelId}"]`).forEach(btn => {
        btn.classList.toggle('active', btn.dataset.year === String(year));
        if (btn.classList.contains('active')) {
            btn.classList.add('bg-orange-500','text-white','border-orange-500');
            btn.classList.remove('bg-white','bg-orange-50','text-gray-600','text-orange-600','border-gray-200','border-orange-200');
        } else {
            btn.classList.remove('bg-orange-500','text-white','border-orange-500');
            btn.classList.add('bg-white','text-gray-600','border-gray-200');
        }
    });
    document.querySelectorAll(`.year-section[data-panel="${panelId}"]`).forEach(sec => {
        sec.classList.toggle('active', sec.dataset.section === String(year));
    });
}

// ── Lightbox ──
function openLightbox(src, type, caption, downloadUrl) {
    const lb      = document.getElementById('lightbox');
    const img     = document.getElementById('lb-img');
    const video   = document.getElementById('lb-video');
    const capEl   = document.getElementById('lb-caption');
    const dlBtn   = document.getElementById('lb-download');

    if (type === 'video') {
        video.src           = src;
        video.style.display = 'block';
        img.style.display   = 'none';
        img.src             = '';
    } else {
        img.src             = src;
        img.style.display   = 'block';
        video.style.display = 'none';
        video.pause();
        video.src = '';
    }

    capEl.textContent = caption || '';
    dlBtn.href        = downloadUrl || src;
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lb    = document.getElementById('lightbox');
    const video = document.getElementById('lb-video');
    video.pause();
    video.src           = '';
    lb.classList.remove('open');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightbox();
});

// ── Init year buttons visual state ──
document.querySelectorAll('.year-btn.active').forEach(btn => {
    btn.classList.add('bg-orange-500','text-white','border-orange-500');
    btn.classList.remove('bg-orange-50','text-orange-600','border-orange-200');
});

// ══ Language controller ══════════════════════════════════════════

const DASH_LANGS = {
    en: { label:'EN', flag:'https://flagcdn.com/w40/us.png', name:'English' },
    fr: { label:'FR', flag:'https://flagcdn.com/w40/fr.png', name:'Français' },
    km: { label:'KM', flag:'https://flagcdn.com/w40/kh.png', name:'ខ្មែរ' }
};
let dashCurrentLang = localStorage.getItem('gt_lang') || 'fr';

function dashTriggerTranslate(targetLang) {
    return new Promise(resolve => {
        const exp = 'expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = 'googtrans=; ' + exp;
        document.cookie = 'googtrans=; ' + exp + ' domain=' + location.hostname + ';';
        document.cookie = 'googtrans=; ' + exp + ' domain=.' + location.hostname + ';';
        if (targetLang === 'en') { resolve(); setTimeout(() => location.reload(), 80); return; }
        const pair = '/en/' + targetLang;
        document.cookie = 'googtrans=' + pair + '; path=/';
        document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname;
        const trySelect = tries => {
            const sel = document.querySelector('select.goog-te-combo');
            if (sel) { sel.value = targetLang; sel.dispatchEvent(new Event('change')); resolve(); }
            else if (tries > 0) setTimeout(() => trySelect(tries - 1), 200);
            else { resolve(); setTimeout(() => location.reload(), 80); }
        };
        trySelect(8);
    });
}

function dashUpdateUI(lang) {
    const cfg = DASH_LANGS[lang] || DASH_LANGS.en;
    const flagEl  = document.getElementById('dash-flag');
    const labelEl = document.getElementById('dash-lang-label');
    if (flagEl)  { flagEl.src = cfg.flag; flagEl.alt = cfg.label; }
    if (labelEl) labelEl.textContent = cfg.label;
    ['en','fr','km'].forEach(l => {
        document.getElementById('dash-btn-' + l)?.classList.toggle('active', l === lang);
        const chk = document.getElementById('dash-check-' + l);
        if (chk) chk.classList.toggle('hidden', l !== lang);
    });
    document.body.style.fontFamily = lang === 'km'
        ? "'Hanuman','Battambang','Content','Montserrat',sans-serif"
        : "'Montserrat',sans-serif";
    dashCurrentLang = lang;
    localStorage.setItem('gt_lang', lang);
}

async function dashSwitchLang(lang) {
    if (lang === dashCurrentLang) { dashClosePanel(); return; }
    dashUpdateUI(lang);
    await dashTriggerTranslate(lang);
    dashClosePanel();
}

function dashTogglePanel() {
    const panel = document.getElementById('dash-translate-panel');
    const caret = document.getElementById('dash-caret');
    const open  = panel.classList.toggle('open');
    if (caret) caret.style.transform = open ? 'rotate(180deg)' : '';
}
function dashClosePanel() {
    const p = document.getElementById('dash-translate-panel');
    const c = document.getElementById('dash-caret');
    if (p) p.classList.remove('open');
    if (c) c.style.transform = '';
}
document.addEventListener('click', e => {
    const w = document.getElementById('dash-translate-wrapper');
    if (w && !w.contains(e.target)) dashClosePanel();
});

document.addEventListener('DOMContentLoaded', () => {
    const cookie = document.cookie.split(';').find(c => c.trim().startsWith('googtrans='));
    const stored = localStorage.getItem('gt_lang');
    if (cookie) {
        const parts = cookie.split('/');
        const cl = parts[parts.length - 1].trim();
        if (cl && DASH_LANGS[cl]) { dashCurrentLang = cl; localStorage.setItem('gt_lang', cl); }
    } else if (!stored) {
        const pair = '/en/fr';
        document.cookie = 'googtrans=' + pair + '; path=/';
        document.cookie = 'googtrans=' + pair + '; path=/; domain=' + location.hostname;
        localStorage.setItem('gt_lang', 'fr');
        location.reload();
        return;
    }
    dashUpdateUI(dashCurrentLang);
});
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>
</body>
</html>