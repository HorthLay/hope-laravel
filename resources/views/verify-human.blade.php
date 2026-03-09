{{-- resources/views/verify-human.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? 'Hope & Impact' }} — Verifying...</title>
    <meta name="robots" content="noindex">
    @if(!empty($settings['favicon']))<link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">@endif
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: #f8fafc;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 20px; position: relative; overflow: hidden;
        }

        /* ── Background ── */
        .bg-pattern {
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(249,115,22,.06) 0%, transparent 55%),
                radial-gradient(ellipse at 80% 20%, rgba(251,191,36,.07) 0%, transparent 50%),
                linear-gradient(rgba(0,0,0,.022) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,.022) 1px, transparent 1px);
            background-size: auto, auto, 44px 44px, 44px 44px;
        }

        /* ── Card ── */
        .verify-card {
            position: relative; z-index: 1;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            padding: 44px 40px 36px;
            max-width: 440px; width: 100%;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,.04), 0 20px 44px rgba(0,0,0,.08);
            animation: cardIn .5s cubic-bezier(.34,1.1,.64,1) both;
        }
        @keyframes cardIn { from{opacity:0;transform:translateY(16px) scale(.98)} to{opacity:1;transform:none} }

        /* ── Icon ── */
        .icon-wrap {
            width: 72px; height: 72px; border-radius: 20px; margin: 0 auto 22px;
            display: flex; align-items: center; justify-content: center;
            position: relative; transition: background .4s, border-color .4s;
            background: linear-gradient(135deg, #fff7ed, #ffedd5);
            border: 1.5px solid #fed7aa;
        }
        .icon-wrap i { font-size: 30px; color: #f97316; transition: color .3s, transform .3s; }
        .icon-pulse {
            position: absolute; inset: -7px; border-radius: 25px;
            border: 2px solid rgba(249,115,22,.22);
            animation: pulsRing 2.4s ease-in-out infinite;
        }
        @keyframes pulsRing { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0;transform:scale(1.2)} }

        /* ── States ── */
        .icon-wrap.state-success {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border-color: #86efac;
        }
        .icon-wrap.state-success i { color: #16a34a; transform: scale(1.1); }
        .icon-wrap.state-success .icon-pulse { border-color: rgba(22,163,74,.25); }
        .icon-wrap.state-error {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border-color: #fca5a5;
        }
        .icon-wrap.state-error i { color: #dc2626; }
        .icon-wrap.state-error .icon-pulse { animation: none; opacity: 0; }

        /* ── Text ── */
        .site-label {
            font-size: 11px; font-weight: 700; color: #9ca3af;
            letter-spacing: .08em; text-transform: uppercase; margin-bottom: 10px;
        }
        h1 {
            font-size: 21px; font-weight: 900; color: #111827;
            line-height: 1.25; margin-bottom: 9px;
            transition: color .3s;
        }
        .subtitle {
            font-size: 13px; color: #6b7280; line-height: 1.65;
            margin-bottom: 26px; font-weight: 500; transition: color .3s;
        }

        /* ── Status bar ── */
        .status-bar {
            height: 4px; background: #f3f4f6; border-radius: 99px;
            margin-bottom: 22px; overflow: hidden;
        }
        .status-fill {
            height: 100%; width: 0; border-radius: 99px;
            background: linear-gradient(90deg, #f97316, #ea580c);
            transition: width .6s cubic-bezier(.4,0,.2,1), background .4s;
        }
        .status-fill.checking { width: 45%; }
        .status-fill.success  { width: 100%; background: linear-gradient(90deg, #16a34a, #15803d); }
        .status-fill.error    { width: 100%; background: #dc2626; }

        /* ── Status label ── */
        .status-label {
            font-size: 12px; font-weight: 700; color: #9ca3af;
            margin-bottom: 22px; display: flex; align-items: center;
            justify-content: center; gap: 7px; transition: color .3s;
            min-height: 20px;
        }
        .status-label i { font-size: 11px; }
        .status-label.success { color: #16a34a; }
        .status-label.error   { color: #dc2626; }

        /* ── Spinner ── */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spin { animation: spin .7s linear infinite; display: inline-block; }

        /* ── Turnstile ── */
        .turnstile-wrap {
            display: flex; justify-content: center; margin-bottom: 18px;
            transition: opacity .3s;
        }
        .turnstile-wrap.hidden-widget { opacity: 0; pointer-events: none; height: 0; overflow: hidden; margin: 0; }

        /* ── Redirect countdown ── */
        .redirect-notice {
            display: none;
            align-items: center; justify-content: center; gap: 8px;
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-radius: 12px; padding: 11px 16px;
            font-size: 13px; font-weight: 700; color: #15803d;
            margin-bottom: 18px;
        }
        .redirect-notice.visible { display: flex; animation: fadeUp .3s both; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:none} }

        /* ── Error msg ── */
        .error-msg {
            display: none;
            align-items: center; gap: 8px;
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 12px; padding: 11px 14px;
            font-size: 12px; font-weight: 600; color: #dc2626;
            margin-bottom: 16px; text-align: left;
        }
        .error-msg.visible { display: flex; animation: fadeUp .3s both; }

        /* ── Retry button ── */
        .retry-btn {
            display: none; width: 100%; padding: 12px;
            background: #f3f4f6; border: none; border-radius: 12px;
            font-family: inherit; font-size: 13px; font-weight: 700;
            color: #374151; cursor: pointer; transition: background .18s;
            margin-bottom: 16px;
        }
        .retry-btn.visible { display: block; }
        .retry-btn:hover { background: #e5e7eb; }

        /* ── Trust badges ── */
        .trust-row {
            display: flex; align-items: center; justify-content: center;
            gap: 16px; margin-top: 20px; flex-wrap: wrap;
        }
        .trust-item {
            display: flex; align-items: center; gap: 5px;
            font-size: 11px; color: #9ca3af; font-weight: 600;
        }
        .divider { height: 1px; background: #f3f4f6; margin: 18px 0; }
        .cf-badge {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: 11px; color: #9ca3af; font-weight: 500;
        }
        .cf-badge img { height: 13px; width: auto; opacity: .55; }

        .page-footer {
            position: relative; z-index: 1;
            margin-top: 22px; text-align: center;
            font-size: 11px; color: #9ca3af; font-weight: 500;
        }

        @media (max-width: 480px) {
            .verify-card { padding: 32px 20px 28px; border-radius: 20px; }
            h1 { font-size: 19px; }
        }
    </style>
</head>
<body>

<div class="bg-pattern"></div>

<div class="verify-card">

    {{-- Logo --}}
    @if(!empty($settings['logo']))
    <a href="/" style="display:inline-block;margin-bottom:18px;">
        <img src="{{ asset($settings['logo']) }}" alt="{{ $settings['site_name'] ?? '' }}" style="height:48px;width:auto;object-fit:contain;">
    </a>
    @endif

    {{-- Icon --}}
    <div class="icon-wrap" id="icon-wrap">
        <div class="icon-pulse" id="icon-pulse"></div>
        <i class="fas fa-shield-alt" id="icon-main"></i>
    </div>

    <p class="site-label">{{ $settings['site_name'] ?? 'Hope & Impact' }}</p>
    <h1 id="main-title">Checking your browser...</h1>
    <p class="subtitle" id="main-subtitle">
        Please wait while we verify you're human. This only takes a moment.
    </p>

    {{-- Progress bar --}}
    <div class="status-bar">
        <div class="status-fill checking" id="status-fill"></div>
    </div>

    {{-- Status label --}}
    <div class="status-label" id="status-label">
        <i class="fas fa-circle-notch spin"></i>
        <span id="status-text">Running security check...</span>
    </div>

    {{-- Session error --}}
    @if(session('turnstile_error'))
    <div class="error-msg visible" id="error-box">
        <i class="fas fa-exclamation-circle flex-shrink-0"></i>
        <span>{{ session('turnstile_error') }}</span>
    </div>
    @else
    <div class="error-msg" id="error-box">
        <i class="fas fa-exclamation-circle flex-shrink-0"></i>
        <span id="error-text">Verification failed. Please try again.</span>
    </div>
    @endif

    {{-- Redirect notice --}}
    <div class="redirect-notice" id="redirect-notice">
        <i class="fas fa-check-circle"></i>
        <span>Verified! Redirecting in <strong id="countdown">2</strong>s...</span>
    </div>

    {{-- Form (hidden, auto-submitted) --}}
    <form method="POST" action="{{ route('verify.human.submit') }}" id="verify-form" style="display:none">
        @csrf
        <input type="hidden" name="redirect_to" value="{{ session('intended_url', url('/')) }}">
        <input type="hidden" name="cf-turnstile-response" id="cf-token-input">
    </form>

    {{-- Visible Turnstile widget --}}
    <div class="turnstile-wrap" id="turnstile-wrap">
        <div class="cf-turnstile"
             data-sitekey="{{ config('services.turnstile.site_key') }}"
             data-theme="light"
             data-size="normal"
             data-callback="onTurnstileSuccess"
             data-error-callback="onTurnstileError"
             data-expired-callback="onTurnstileExpired">
        </div>
    </div>

    {{-- Retry button (shown only on error) --}}
    <button type="button" class="retry-btn" id="retry-btn" onclick="location.reload()">
        <i class="fas fa-redo mr-2"></i> Try Again
    </button>

    {{-- Trust badges --}}
    <div class="trust-row">
        <div class="trust-item"><i class="fas fa-lock" style="color:#22c55e"></i> Secure</div>
        <div class="trust-item"><i class="fas fa-user-shield" style="color:#3b82f6"></i> Privacy protected</div>
        <div class="trust-item"><i class="fas fa-bolt" style="color:#f59e0b"></i> One-time check</div>
    </div>

    <div class="divider"></div>

    <div class="cf-badge">
        <img src="https://www.cloudflare.com/favicon.ico" alt="Cloudflare">
        Protected by Cloudflare Turnstile
    </div>

</div>

<p class="page-footer">© {{ date('Y') }} {{ $settings['site_name'] ?? 'Hope & Impact' }} &nbsp;·&nbsp; All rights reserved</p>

<script>
// ── DOM refs ─────────────────────────────────────────
const iconWrap      = document.getElementById('icon-wrap');
const iconMain      = document.getElementById('icon-main');
const mainTitle     = document.getElementById('main-title');
const mainSubtitle  = document.getElementById('main-subtitle');
const statusFill    = document.getElementById('status-fill');
const statusLabel   = document.getElementById('status-label');
const statusText    = document.getElementById('status-text');
const errorBox      = document.getElementById('error-box');
const redirectNotice= document.getElementById('redirect-notice');
const turnstileWrap = document.getElementById('turnstile-wrap');
const retryBtn      = document.getElementById('retry-btn');
const form          = document.getElementById('verify-form');
const tokenInput    = document.getElementById('cf-token-input');

// ── Success callback — called by Turnstile automatically ──
function onTurnstileSuccess(token) {
    // 1. Put token into hidden form field
    tokenInput.value = token;

    // 2. Update UI → "Verified" state
    iconWrap.classList.add('state-success');
    iconMain.className = 'fas fa-check';
    mainTitle.textContent = 'Verification successful!';
    mainTitle.style.color = '#15803d';
    mainSubtitle.textContent = 'Identity confirmed. Taking you to the site now.';
    mainSubtitle.style.color = '#16a34a';
    statusFill.classList.remove('checking');
    statusFill.classList.add('success');
    statusLabel.classList.add('success');
    statusText.textContent = 'All checks passed';
    statusLabel.querySelector('i').className = 'fas fa-check-circle';

    // 3. Hide widget, show countdown
    turnstileWrap.classList.add('hidden-widget');
    redirectNotice.classList.add('visible');

    // 4. Countdown then auto-submit
    let count = 2;
    const countdown = document.getElementById('countdown');
    const tick = setInterval(() => {
        count--;
        if (countdown) countdown.textContent = count;
        if (count <= 0) {
            clearInterval(tick);
            if (countdown) countdown.textContent = '0';
            form.submit();
        }
    }, 1000);
}

// ── Error callback ────────────────────────────────────
function onTurnstileError() {
    iconWrap.classList.add('state-error');
    iconMain.className = 'fas fa-exclamation-triangle';
    mainTitle.textContent = 'Verification failed';
    mainTitle.style.color = '#dc2626';
    mainSubtitle.textContent = 'Something went wrong. Please try again.';
    statusFill.classList.remove('checking');
    statusFill.classList.add('error');
    statusLabel.classList.add('error');
    statusText.textContent = 'Check failed — please retry';
    statusLabel.querySelector('i').className = 'fas fa-times-circle';
    errorBox.querySelector('#error-text') &&
        (document.getElementById('error-text').textContent = 'Verification failed. Please refresh and try again.');
    errorBox.classList.add('visible');
    retryBtn.classList.add('visible');
    turnstileWrap.classList.add('hidden-widget');
}

// ── Expired callback ──────────────────────────────────
function onTurnstileExpired() {
    statusText.textContent = 'Verification expired — refreshing...';
    statusLabel.querySelector('i').className = 'fas fa-circle-notch spin';
    setTimeout(() => location.reload(), 1200);
}
</script>

</body>
</html>