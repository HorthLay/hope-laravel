{{-- resources/views/admin/auth/login.blade.php --}}
@php
    $settings = (function() {
        $file = storage_path('app/settings.json');
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    })();
    $siteName = $settings['site_name'] ?? 'Hope & Impact';
    $siteLogo = $settings['logo']      ?? null;
    $favicon  = $settings['favicon']   ?? null;
    $hasErrors = $errors->any();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — {{ $siteName }}</title>
    @if($favicon)
    <link rel="icon" type="image/png" href="{{ asset($favicon) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        :root {
            --orange:   #f97316;
            --orange-d: #ea580c;
            --orange-l: #fff7ed;
            --dark:     #0b1117;
            --border:   #e2e8f0;
            --text:     #1e293b;
            --muted:    #64748b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100svh; display: flex;
            background: var(--dark); overflow-x: hidden;
        }

        /* ════════════════════════════
           LEFT — VIDEO PANEL
        ════════════════════════════ */
        .left {
            display: none; width: 46%; flex-shrink: 0;
            position: relative; overflow: hidden;
            flex-direction: column; justify-content: flex-end;
        }
        @media(min-width:900px){ .left { display: flex; } }

        /* Video fills panel */
        #bgVideo {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover; object-position: center;
            z-index: 0;
        }

        /* Multi-layer overlay: deep vignette + brand gradient at bottom */
        .vid-overlay {
            position: absolute; inset: 0; z-index: 1;
            background:
                linear-gradient(to bottom,
                    rgba(0,0,0,.55) 0%,
                    rgba(0,0,0,.20) 38%,
                    rgba(0,0,0,.15) 55%,
                    rgba(15,10,3,.80) 80%,
                    rgba(15,10,3,.96) 100%),
                linear-gradient(to right, rgba(0,0,0,.35) 0%, transparent 60%);
        }

        /* Subtle orange glow tint from bottom */
        .vid-glow {
            position: absolute; bottom: 0; left: 0; right: 0;
            height: 45%; z-index: 2;
            background: radial-gradient(ellipse at 30% 100%, rgba(249,115,22,.18) 0%, transparent 65%);
            pointer-events: none;
        }

        /* Grid texture overlay */
        .grid-tex {
            position: absolute; inset: 0; z-index: 2;
            background-image:
                linear-gradient(rgba(255,255,255,.018) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.018) 1px, transparent 1px);
            background-size: 44px 44px;
            pointer-events: none;
        }

        /* Animated ring decorations */
        .ring {
            position: absolute; border-radius: 50%;
            border: 1px solid rgba(249,115,22,.15);
            z-index: 3; pointer-events: none;
        }
        .r1 { width:360px;height:360px;top:-100px;right:-100px; animation: spin 40s linear infinite; }
        .r2 { width:200px;height:200px;top: 80px;right: -20px;  animation: spin 28s linear infinite reverse; border-color:rgba(249,115,22,.08); }
        @keyframes spin { to{ transform:rotate(360deg); } }

        .left-inner {
            position: relative; z-index: 4;
            padding: 44px 52px;
        }

        .brand-row {
            display: flex; align-items: center; gap: 14px;
            margin-bottom: 72px;
        }
        .brand-logo-img {
            height: 80px; width: auto; object-fit: contain;
            filter: drop-shadow(0 4px 16px rgba(249,115,22,.5)) brightness(1.1);
        }
        .brand-icon {
            width: 44px; height: 44px; border-radius: 13px;
            background: linear-gradient(135deg, var(--orange), var(--orange-d));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(249,115,22,.45);
        }
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 21px; font-weight: 700; color: #fff;
            text-shadow: 0 2px 8px rgba(0,0,0,.4);
        }

        .left-headline {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.9rem, 3vw, 3rem);
            font-weight: 800; line-height: 1.13; color: #fff;
            margin-bottom: 20px;
            text-shadow: 0 2px 16px rgba(0,0,0,.5);
        }
        .left-headline em { font-style: normal; color: var(--orange); }
        .left-sub {
            font-size: 14.5px; color: rgba(255,255,255,.55);
            line-height: 1.72; max-width: 320px; margin-bottom: 44px;
        }

        .stats { display: flex; gap: 28px; margin-bottom: 48px; }
        .stat-n {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem; font-weight: 800;
            color: var(--orange); line-height: 1;
            text-shadow: 0 4px 16px rgba(249,115,22,.4);
        }
        .stat-l { font-size: 11px; color: rgba(255,255,255,.4); margin-top: 5px; text-transform: uppercase; letter-spacing: .05em; }

        .badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            backdrop-filter: blur(8px);
            border-radius: 100px; padding: 8px 16px;
            font-size: 12px; color: rgba(255,255,255,.6); letter-spacing: .03em;
        }
        .badge i { color: var(--orange); font-size: 10px; }

        /* ════════════════════════════
           RIGHT — FORM PANEL
        ════════════════════════════ */
        .right {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 40px 24px;
            background: #f8fafc;
            position: relative; overflow: hidden;
        }
        .right::before {
            content: ''; position: absolute;
            top: -140px; right: -140px;
            width: 420px; height: 420px; border-radius: 50%;
            background: radial-gradient(circle, rgba(249,115,22,.07), transparent 65%);
            pointer-events: none;
        }
        .right::after {
            content: ''; position: absolute;
            bottom: -80px; left: -80px;
            width: 280px; height: 280px; border-radius: 50%;
            background: radial-gradient(circle, rgba(249,115,22,.04), transparent 65%);
            pointer-events: none;
        }

        .card {
            width: 100%; max-width: 408px;
            position: relative; z-index: 1;
        }

        /* Mobile brand */
        .mob-brand {
            display: flex; flex-direction: column; align-items: center;
            margin-bottom: 36px;
            animation: fadeUp .6s ease both;
        }
        @media(min-width:900px){ .mob-brand { display: none; } }
        .mob-icon {
            width: 64px; height: 64px; border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 12px;
            animation: floatY 5s ease-in-out infinite;
        }
        .mob-icon.has-logo { background: transparent; box-shadow: none; }
        .mob-icon.has-logo img { height: 58px; width: auto; object-fit: contain; }
        .mob-icon.no-logo {
            background: linear-gradient(135deg, var(--orange), var(--orange-d));
            box-shadow: 0 12px 32px rgba(249,115,22,.35);
        }
        @keyframes floatY { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-8px);} }
        .mob-name { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 800; color: var(--text); }
        .mob-sub  { font-size: 13px; color: var(--muted); margin-top: 3px; }

        .form-head { margin-bottom: 28px; animation: fadeUp .5s .1s ease both; }
        .form-title { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 800; color: var(--text); margin-bottom: 5px; }
        .form-sub   { font-size: 14px; color: var(--muted); }

        /* Alerts */
        .alert {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 12px 15px; border-radius: 12px; margin-bottom: 18px;
            font-size: 13px; font-weight: 500;
            animation: slideDown .35s ease;
        }
        @keyframes slideDown { from{opacity:0;transform:translateY(-10px);} to{opacity:1;transform:translateY(0);} }
        .alert i { margin-top: 1px; flex-shrink: 0; }
        .alert-ok  { background: #f0fdf4; border: 1.5px solid #86efac; color: #166534; }
        .alert-err { background: #fef2f2; border: 1.5px solid #fca5a5; color: #991b1b;
                     animation: slideDown .35s ease, shake .5s .35s ease; }
        @keyframes shake { 0%,100%{transform:translateX(0);} 20%,60%{transform:translateX(-5px);} 40%,80%{transform:translateX(5px);} }

        /* Fields */
        .fld { margin-bottom: 18px; animation: fadeUp .5s ease both; }
        .fld label {
            display: flex; align-items: center; gap: 7px;
            font-size: 12px; font-weight: 700; color: #374151;
            margin-bottom: 7px; letter-spacing: .06em; text-transform: uppercase;
        }
        .fld label i { color: var(--orange); font-size: 11px; width: 13px; text-align: center; }
        .fld input {
            width: 100%; padding: 13px 15px;
            border: 1.5px solid var(--border); border-radius: 11px;
            font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--text);
            background: #fff; outline: none;
            transition: border-color .2s, box-shadow .2s, transform .18s;
        }
        .fld input:focus {
            border-color: var(--orange);
            box-shadow: 0 0 0 4px rgba(249,115,22,.11);
            transform: translateY(-1px);
        }
        .fld input.err-inp { border-color: #ef4444; }
        .fld .err-txt { font-size: 12px; color: #ef4444; margin-top: 5px; display: flex; align-items: center; gap: 4px; }

        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 46px; }
        .pw-eye {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #94a3b8; font-size: 14px; padding: 4px;
            transition: color .15s;
        }
        .pw-eye:hover { color: var(--orange); }

        .opts-row { display: flex; align-items: center; margin-bottom: 22px; animation: fadeUp .5s .35s ease both; }
        .remember {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: #4b5563; cursor: pointer; user-select: none;
        }
        .remember input { width: 15px; height: 15px; accent-color: var(--orange); cursor: pointer; }

        .btn-login {
            width: 100%; padding: 14px;
            background: linear-gradient(130deg, var(--orange) 0%, var(--orange-d) 100%);
            color: #fff; border: none; border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px; font-weight: 700; letter-spacing: .02em;
            cursor: pointer; position: relative; overflow: hidden;
            box-shadow: 0 8px 28px rgba(249,115,22,.38);
            transition: transform .15s, box-shadow .2s;
            animation: fadeUp .5s .4s ease both;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 14px 36px rgba(249,115,22,.48); }
        .btn-login:active { transform: translateY(0); }
        .btn-login::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.2), transparent);
            transform: translateX(-120%); transition: transform .55s;
        }
        .btn-login:hover::after { transform: translateX(120%); }

        .sep { display: flex; align-items: center; gap: 12px; margin: 20px 0; }
        .sep::before,.sep::after { content:''; flex:1; height:1px; background:var(--border); }
        .sep span { font-size: 12px; color: #94a3b8; }

        .back-btn {
            display: flex; align-items: center; justify-content: center; gap: 7px;
            padding: 12px; border-radius: 12px;
            border: 1.5px solid var(--border); background: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px; font-weight: 600; color: var(--muted);
            text-decoration: none; transition: all .2s;
            animation: fadeUp .5s .5s ease both;
        }
        .back-btn:hover { border-color: var(--orange); color: var(--orange); background: var(--orange-l); }
        .foot { text-align: center; margin-top: 28px; font-size: 12px; color: #94a3b8; animation: fadeUp .5s .55s ease both; }

        @keyframes fadeUp { from{opacity:0;transform:translateY(18px);} to{opacity:1;transform:translateY(0);} }

        /* ════════════════════════════
           SOUND TOGGLE BUTTON
        ════════════════════════════ */
        #soundBtn {
            position: fixed; bottom: 20px; left: 20px; z-index: 100;
            width: 40px; height: 40px; border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,.18);
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(12px);
            color: rgba(255,255,255,.7); font-size: 14px;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all .2s;
        }
        #soundBtn:hover { background: rgba(249,115,22,.3); border-color: var(--orange); color: #fff; }
        #soundBtn.muted { opacity: .5; }

        /* Video mute button */
        #vidMuteBtn {
            position: absolute; top: 20px; right: 20px; z-index: 10;
            width: 36px; height: 36px; border-radius: 50%;
            border: 1px solid rgba(255,255,255,.2);
            background: rgba(0,0,0,.35);
            backdrop-filter: blur(8px);
            color: rgba(255,255,255,.8); font-size: 13px;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all .2s;
        }
        #vidMuteBtn:hover { background: rgba(249,115,22,.5); border-color: var(--orange); color: #fff; }

        /* Input ripple flash */
        @keyframes inputFlash {
            0%  { box-shadow: 0 0 0 0 rgba(249,115,22,.45); }
            100%{ box-shadow: 0 0 0 8px rgba(249,115,22,0); }
        }
        .input-ping { animation: inputFlash .4s ease forwards !important; }
    </style>
</head>
<body>

{{-- ════════ LEFT — VIDEO PANEL ════════ --}}
<div class="left">
    {{-- Background video (same as homepage) --}}
    <video id="bgVideo" autoplay muted loop playsinline preload="auto"
           poster="{{ asset('images/cambodia-bg.jpg') }}">
        <source src="{{ asset('project/videos/video.mp4') }}" type="video/mp4">
    </video>

    <div class="vid-overlay"></div>
    <div class="vid-glow"></div>
    <div class="grid-tex"></div>
    <div class="ring r1"></div>
    <div class="ring r2"></div>

    {{-- Video sound toggle --}}
    <button id="vidMuteBtn" title="Toggle video sound" onclick="toggleVidSound()">
        <i class="fas fa-volume-xmark" id="vidMuteIcon"></i>
    </button>

    <div class="left-inner">
        <div class="brand-row">
            @if($siteLogo)
                <img src="{{ asset($siteLogo) }}" alt="{{ $siteName }}" class="brand-logo-img">
            @else
                <div class="brand-icon">
                    <i class="fas fa-heart text-white text-xl"></i>
                </div>
            @endif
            <span class="brand-name">{{ $siteName }}</span>
        </div>

        <div class="left-headline">
            Every child<br>deserves a<br><em>brighter future.</em>
        </div>
        <p class="left-sub">
            Manage sponsorships, publish stories, and oversee the lives you're changing — all from one place.
        </p>

        <div class="stats">
            <div>
                <div class="stat-n">95K+</div>
                <div class="stat-l">Children helped</div>
            </div>
            <div>
                <div class="stat-n">84%</div>
                <div class="stat-l">To programs</div>
            </div>
            <div>
                <div class="stat-n">7</div>
                <div class="stat-l">Countries</div>
            </div>
        </div>

        <div class="badge">
            <i class="fas fa-shield-halved"></i>
            Certified NGO &middot; IDEAS Label 2024
        </div>
    </div>
</div>

{{-- ════════ RIGHT — FORM PANEL ════════ --}}
<div class="right">
    <div class="card">

        {{-- Mobile brand --}}
        <div class="mob-brand">
            @if($siteLogo)
                <div class="mob-icon has-logo">
                    <img src="{{ asset($siteLogo) }}" alt="{{ $siteName }}">
                </div>
            @else
                <div class="mob-icon no-logo">
                    <i class="fas fa-heart text-white text-2xl"></i>
                </div>
            @endif
            <span class="mob-name">{{ $siteName }}</span>
            <span class="mob-sub">Admin Portal</span>
        </div>

        <div class="form-head">
            <div class="form-title">Welcome back</div>
            <div class="form-sub">Sign in to your admin account to continue</div>
        </div>

        @if(session('success'))
        <div class="alert alert-ok" id="successAlert">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-err" id="errorAlert">
            <i class="fas fa-circle-exclamation"></i>
            <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" id="loginForm" novalidate>
            @csrf

            <div class="fld" style="animation-delay:.2s">
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="admin@example.org"
                       class="{{ $errors->has('email') ? 'err-inp' : '' }}"
                       required autofocus autocomplete="email">
                @error('email')
                <div class="err-txt"><i class="fas fa-circle-xmark"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="fld" style="animation-delay:.28s">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="pw-wrap">
                    <input type="password" id="password" name="password"
                           placeholder="Enter your password"
                           class="{{ $errors->has('password') ? 'err-inp' : '' }}"
                           required autocomplete="current-password">
                    <button type="button" class="pw-eye" onclick="togglePw()">
                        <i class="fas fa-eye" id="pwIcon"></i>
                    </button>
                </div>
                @error('password')
                <div class="err-txt"><i class="fas fa-circle-xmark"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="opts-row">
                <label class="remember">
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <button type="submit" class="btn-login" id="submitBtn">
                <i class="fas fa-arrow-right-to-bracket" style="margin-right:8px;"></i>Sign In
            </button>
        </form>

        <div class="sep"><span>or</span></div>

        <a href="{{ route('home') }}" class="back-btn">
            <i class="fas fa-arrow-left" style="font-size:12px;"></i> Back to Website
        </a>

        <div class="foot">© {{ date('Y') }} {{ $siteName }}. All rights reserved.</div>
    </div>
</div>

{{-- Sound effects toggle (bottom-left) --}}
<button id="soundBtn" class="muted" title="Toggle UI sounds" onclick="toggleUiSound()">
    <i class="fas fa-music" id="soundIcon"></i>
</button>

<script>
/* ═══════════════════════════════════════════════════
   WEB AUDIO — synthesized sound effects
   No external audio files needed.
═══════════════════════════════════════════════════ */
let audioCtx = null;
let uiSoundOn = false;   // user must opt-in (browser autoplay policy)
let vidSoundOn = false;

function getCtx() {
    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    if (audioCtx.state === 'suspended') audioCtx.resume();
    return audioCtx;
}

/* ── Soft key-click (each keystroke) ── */
function sfxKey() {
    if (!uiSoundOn) return;
    const c = getCtx();
    const o = c.createOscillator();
    const g = c.createGain();
    o.connect(g); g.connect(c.destination);
    o.type = 'sine';
    o.frequency.setValueAtTime(880, c.currentTime);
    o.frequency.exponentialRampToValueAtTime(440, c.currentTime + 0.06);
    g.gain.setValueAtTime(0.04, c.currentTime);
    g.gain.exponentialRampToValueAtTime(0.0001, c.currentTime + 0.08);
    o.start(c.currentTime); o.stop(c.currentTime + 0.1);
}

/* ── Focus "ping" ── */
function sfxFocus() {
    if (!uiSoundOn) return;
    const c = getCtx();
    const o = c.createOscillator();
    const g = c.createGain();
    o.connect(g); g.connect(c.destination);
    o.type = 'sine';
    o.frequency.setValueAtTime(600, c.currentTime);
    o.frequency.exponentialRampToValueAtTime(900, c.currentTime + 0.12);
    g.gain.setValueAtTime(0.06, c.currentTime);
    g.gain.exponentialRampToValueAtTime(0.0001, c.currentTime + 0.15);
    o.start(c.currentTime); o.stop(c.currentTime + 0.18);
}

/* ── Submit "whoosh + rise" ── */
function sfxSubmit() {
    if (!uiSoundOn) return;
    const c = getCtx();
    // Whoosh noise
    const buf = c.createBuffer(1, c.sampleRate * 0.3, c.sampleRate);
    const d = buf.getChannelData(0);
    for (let i = 0; i < d.length; i++) d[i] = (Math.random() * 2 - 1);
    const src = c.createBufferSource();
    src.buffer = buf;
    const flt = c.createBiquadFilter();
    flt.type = 'bandpass'; flt.frequency.value = 1200; flt.Q.value = 0.8;
    const g = c.createGain();
    src.connect(flt); flt.connect(g); g.connect(c.destination);
    g.gain.setValueAtTime(0.10, c.currentTime);
    g.gain.exponentialRampToValueAtTime(0.0001, c.currentTime + 0.28);
    src.start(c.currentTime); src.stop(c.currentTime + 0.3);

    // Rising tone
    const o = c.createOscillator();
    const og = c.createGain();
    o.connect(og); og.connect(c.destination);
    o.type = 'sine';
    o.frequency.setValueAtTime(300, c.currentTime);
    o.frequency.exponentialRampToValueAtTime(900, c.currentTime + 0.25);
    og.gain.setValueAtTime(0.07, c.currentTime);
    og.gain.exponentialRampToValueAtTime(0.0001, c.currentTime + 0.28);
    o.start(c.currentTime); o.stop(c.currentTime + 0.3);
}

/* ── Success "chime" (double bell) ── */
function sfxSuccess() {
    if (!uiSoundOn) return;
    const c = getCtx();
    [[0, 880],[0.15, 1320],[0.3, 1760]].forEach(([delay, freq]) => {
        const o = c.createOscillator();
        const g = c.createGain();
        o.connect(g); g.connect(c.destination);
        o.type = 'sine';
        o.frequency.setValueAtTime(freq, c.currentTime + delay);
        g.gain.setValueAtTime(0.09, c.currentTime + delay);
        g.gain.exponentialRampToValueAtTime(0.0001, c.currentTime + delay + 0.55);
        o.start(c.currentTime + delay); o.stop(c.currentTime + delay + 0.6);
    });
}

/* ── Error "buzz thud" ── */
function sfxError() {
    if (!uiSoundOn) return;
    const c = getCtx();
    // Low thud
    const o = c.createOscillator();
    const g = c.createGain();
    o.connect(g); g.connect(c.destination);
    o.type = 'sawtooth';
    o.frequency.setValueAtTime(120, c.currentTime);
    o.frequency.exponentialRampToValueAtTime(60, c.currentTime + 0.2);
    g.gain.setValueAtTime(0.12, c.currentTime);
    g.gain.exponentialRampToValueAtTime(0.0001, c.currentTime + 0.25);
    o.start(c.currentTime); o.stop(c.currentTime + 0.28);

    // Double click
    [0.05, 0.12].forEach(d => {
        const o2 = c.createOscillator();
        const g2 = c.createGain();
        o2.connect(g2); g2.connect(c.destination);
        o2.type = 'square'; o2.frequency.value = 200;
        g2.gain.setValueAtTime(0.05, c.currentTime + d);
        g2.gain.exponentialRampToValueAtTime(0.0001, c.currentTime + d + 0.06);
        o2.start(c.currentTime + d); o2.stop(c.currentTime + d + 0.08);
    });
}

/* ── Password toggle click ── */
function sfxClick() {
    if (!uiSoundOn) return;
    const c = getCtx();
    const o = c.createOscillator();
    const g = c.createGain();
    o.connect(g); g.connect(c.destination);
    o.type = 'square'; o.frequency.value = 700;
    g.gain.setValueAtTime(0.03, c.currentTime);
    g.gain.exponentialRampToValueAtTime(0.0001, c.currentTime + 0.05);
    o.start(c.currentTime); o.stop(c.currentTime + 0.06);
}

/* ═══════════════════════════════════════════════════
   VIDEO SOUND TOGGLE
═══════════════════════════════════════════════════ */
function toggleVidSound() {
    const vid = document.getElementById('bgVideo');
    const ic  = document.getElementById('vidMuteIcon');
    if (!vid) return;
    vidSoundOn = !vidSoundOn;
    vid.muted = !vidSoundOn;
    ic.className = vidSoundOn ? 'fas fa-volume-high' : 'fas fa-volume-xmark';
    sfxClick();
}

/* ═══════════════════════════════════════════════════
   UI SOUND TOGGLE
═══════════════════════════════════════════════════ */
function toggleUiSound() {
    uiSoundOn = !uiSoundOn;
    const btn = document.getElementById('soundBtn');
    const ic  = document.getElementById('soundIcon');
    btn.classList.toggle('muted', !uiSoundOn);
    ic.className = uiSoundOn ? 'fas fa-music' : 'fas fa-music-slash';
    if (uiSoundOn) { getCtx(); sfxFocus(); }
}

/* ═══════════════════════════════════════════════════
   FORM INTERACTIONS
═══════════════════════════════════════════════════ */
function togglePw() {
    const i  = document.getElementById('password');
    const ic = document.getElementById('pwIcon');
    i.type = i.type === 'password' ? 'text' : 'password';
    ic.classList.toggle('fa-eye');
    ic.classList.toggle('fa-eye-slash');
    sfxClick();
}

// Keystrokes
document.querySelectorAll('.fld input').forEach(inp => {
    inp.addEventListener('focus', () => { sfxFocus(); inp.classList.add('input-ping'); setTimeout(() => inp.classList.remove('input-ping'), 400); });
    inp.addEventListener('input', sfxKey);
});

// Submit
document.getElementById('loginForm').addEventListener('submit', function() {
    sfxSubmit();
    const b = document.getElementById('submitBtn');
    b.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:8px;"></i>Signing in…';
    b.disabled = true; b.style.opacity = '.75';
});

// Auto-hide success alert
setTimeout(() => {
    const a = document.getElementById('successAlert');
    if (a) {
        a.style.transition = 'opacity .4s, transform .4s';
        a.style.opacity = '0'; a.style.transform = 'translateY(-8px)';
        setTimeout(() => a.remove(), 400);
    }
}, 5000);

// Play error sound on page load if there are errors
@if($hasErrors)
window.addEventListener('load', () => {
    // Small delay to let the page settle
    setTimeout(() => { uiSoundOn = true; sfxError(); uiSoundOn = false; }, 400);
});
@endif

// Play success sound if success flash exists
@if(session('success'))
window.addEventListener('load', () => {
    setTimeout(() => { uiSoundOn = true; sfxSuccess(); uiSoundOn = false; }, 400);
});
@endif

// Video fallback
document.getElementById('bgVideo')?.addEventListener('error', function() {
    this.style.display = 'none';
    document.querySelector('.left-bg-fallback')?.classList.remove('hidden');
});
</script>
</body>
</html>