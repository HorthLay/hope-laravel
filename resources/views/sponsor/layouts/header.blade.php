<header class="site-header">
    <div class="header-inner">

        {{-- Logo --}}
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" class="hdr-logo" alt="{{ $settings['site_name'] ?? 'Logo' }}">
        </a>

        {{-- Desktop nav --}}
     <nav class="hdr-nav">
    <a href="{{ route('sponsor.dashboard') }}"
       class="hdr-nav-link {{ request()->routeIs('sponsor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-user-friends" style="font-size:12px"></i> My Child
    </a>
    <a href="{{ route('sponsor.messages.home') }}"
       class="hdr-nav-link {{ request()->routeIs('sponsor.messages.home', 'sponsor.messages.*') ? 'active' : '' }}">
        <i class="far fa-envelope" style="font-size:12px"></i> Messages
    </a>
    <a href="{{ route('support.donate') }}"
       class="hdr-nav-link {{ request()->routeIs('support.donate') ? 'active' : '' }}">
        <i class="fas fa-hand-holding-heart" style="font-size:12px"></i> Sponsorship
    </a>
    <a href="{{ route('home') }}"
       class="hdr-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="far fa-newspaper" style="font-size:12px"></i> News
    </a>
</nav>

        <div class="hdr-right">

            {{-- ── Language switcher (identical to dashboard) ── --}}
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

            {{-- ── Notification bell (identical to dashboard) ── --}}
            @php
                $allUpdates = collect();
                foreach($children as $child) {
                    foreach($child->updates as $u) {
                        $allUpdates->push([
                            'type'     => 'child',
                            'name'     => $child->first_name,
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
                            'name'     => \Illuminate\Support\Str::words($family->name, 1, ''),
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
                            'entity' => 'child',
                            'name'   => $child->first_name,
                            'title'  => $d->title,
                            'date'   => $d->document_date ? \Carbon\Carbon::parse($d->document_date) : $d->created_at,
                            'sort'   => ($d->document_date ? \Carbon\Carbon::parse($d->document_date) : $d->created_at)->timestamp,
                            'dl_url' => route('sponsor.download', ['type' => 'document', 'id' => $d->id]),
                        ]);
                    }
                }
                foreach($families as $family) {
                    foreach($family->documents as $d) {
                        $allDocs->push([
                            'entity' => 'family',
                            'name'   => \Illuminate\Support\Str::words($family->name, 1, ''),
                            'title'  => $d->title,
                            'date'   => $d->document_date ? \Carbon\Carbon::parse($d->document_date) : $d->created_at,
                            'sort'   => ($d->document_date ? \Carbon\Carbon::parse($d->document_date) : $d->created_at)->timestamp,
                            'dl_url' => route('sponsor.download', ['type' => 'family_document', 'id' => $d->id]),
                        ]);
                    }
                }
                $allDocs    = $allDocs->sortByDesc('sort')->take(6)->values();
                $notifTotal = $allUpdates->count() + $allDocs->count();
            @endphp

            <div style="position:relative" id="notif-wrapper">
                <button class="notif-btn" onclick="toggleNotif()" aria-label="Notifications">
                    <i class="far fa-bell"></i>
                    @if($notifTotal > 0)
                    <span class="notif-badge">{{ $notifTotal > 9 ? '9+' : $notifTotal }}</span>
                    @endif
                </button>

                <div class="notif-panel" id="notif-panel">
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
                                <div class="nitem-icon doc"><i class="fas fa-file-pdf"></i></div>
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
                <div class="s-avatar">{{ strtoupper(substr($sponsor->first_name, 0, 1)) }}</div>
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