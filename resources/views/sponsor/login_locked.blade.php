<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès bloqué | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
    @if(!empty($settings['favicon']))<link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">@endif
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        body { font-family: 'Montserrat', sans-serif; }

        @keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        @keyframes pulse   { 0%,100%{transform:scale(1)} 50%{transform:scale(1.04)} }
        .animate-slide-up  { animation: slideUp .5s ease-out; }
        .animate-pulse-slow { animation: pulse 2.2s ease-in-out infinite; }

        /* Countdown ring */
        .ring-track { fill:none; stroke:#fee2e2; stroke-width:6; }
        .ring-fill  { fill:none; stroke:#ef4444; stroke-width:6;
                      stroke-linecap:round; stroke-dasharray:283;
                      transition:stroke-dashoffset 1s linear; transform-origin:center;
                      transform:rotate(-90deg); }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-orange-50 to-orange-100 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md animate-slide-up">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
            @if(!empty($settings['logo']))
                <img src="{{ asset($settings['logo']) }}" alt="{{ $settings['site_name'] ?? '' }}"
                     style="height:100px;width:auto;object-fit:contain;">
            @else
                <img src="{{ asset('images/logo.png') }}" alt="{{ $settings['site_name'] ?? 'Logo' }}"
                     style="height:100px;width:auto;object-fit:contain;">
            @endif
        </a>
    </div>


  

    {{-- Lockout card --}}
    <div class="bg-white rounded-2xl shadow-2xl p-8 border border-red-100 text-center">

        {{-- Icon + ring --}}
        <div class="relative w-24 h-24 mx-auto mb-6">
            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100">
                <circle class="ring-track" cx="50" cy="50" r="45"/>
                <circle class="ring-fill" id="countdown-ring" cx="50" cy="50" r="45"
                        stroke-dashoffset="0"/>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center animate-pulse-slow">
                    <i class="fas fa-shield-exclamation text-red-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-black text-gray-800 mb-2">Accès temporairement bloqué</h2>
        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
            Trop de tentatives de connexion échouées.<br>
            Veuillez patienter avant de réessayer.
        </p>

        {{-- Countdown display --}}
        <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-5 mb-6">
            <p class="text-xs font-bold text-red-400 uppercase tracking-wider mb-2">
                <i class="fas fa-clock mr-1"></i> Temps restant
            </p>
            <div id="countdown-display" class="text-5xl font-black text-red-500 tabular-nums">5:00</div>
            <p class="text-xs text-red-400 mt-2">minutes · secondes</p>
        </div>

        {{-- Attempt info --}}
        <div class="flex items-start gap-3 bg-amber-50 border border-amber-100 rounded-xl p-4 mb-6 text-left">
            <i class="fas fa-info-circle text-amber-400 mt-0.5 flex-shrink-0"></i>
            <p class="text-xs text-amber-700 leading-relaxed font-medium">
                5 tentatives de connexion ont été détectées depuis votre adresse IP.
                Pour des raisons de sécurité, l'accès est suspendu pendant <strong>5 minutes</strong>.
            </p>
        </div>

        {{-- Try again button (disabled until countdown hits 0) --}}
        <a href="{{ route('sponsor.login') }}" id="retry-btn"
           class="block w-full py-3.5 font-bold text-sm uppercase tracking-wide rounded-lg transition-all shadow
                  bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none"
           aria-disabled="true">
            <i class="fas fa-rotate-left mr-2"></i>
            Réessayer (<span id="retry-label">5:00</span>)
        </a>
    </div>

    {{-- Footer --}}
    <div class="mt-6 text-center text-xs text-gray-400">
        <p>© {{ date('Y') }} {{ $settings['site_name'] ?? 'Association Des Ailes Pour Grandir' }}</p>
    </div>
</div>

<script>
(function () {
    let remaining = {{ (int) $seconds }};
    const circumference = 2 * Math.PI * 45; // ≈ 283

    const ring    = document.getElementById('countdown-ring');
    const display = document.getElementById('countdown-display');
    const label   = document.getElementById('retry-label');
    const btn     = document.getElementById('retry-btn');

    ring.style.strokeDasharray  = circumference;
    ring.style.strokeDashoffset = 0;

    function fmt(s) {
        const m = Math.floor(s / 60);
        const sec = s % 60;
        return m + ':' + String(sec).padStart(2, '0');
    }

    function tick() {
        if (remaining <= 0) {
            display.textContent = '0:00';
            label.textContent   = '0:00';
            // Unlock the button
            btn.classList.remove('bg-gray-200','text-gray-400','cursor-not-allowed','pointer-events-none');
            btn.classList.add('bg-gradient-to-r','from-orange-500','to-orange-600',
                              'hover:from-orange-600','hover:to-orange-700','text-white',
                              'hover:shadow-xl','transform','hover:-translate-y-0.5');
            btn.removeAttribute('aria-disabled');
            btn.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i> Réessayer maintenant';
            ring.style.stroke = '#22c55e'; // turn green
            ring.style.strokeDashoffset = 0;
            return;
        }

        display.textContent = fmt(remaining);
        label.textContent   = fmt(remaining);

        // Shrink the ring as time passes
        const total   = {{ (int) $seconds }};
        const elapsed = total - remaining;
        const offset  = (elapsed / total) * circumference;
        ring.style.strokeDashoffset = offset;

        remaining--;
        setTimeout(tick, 1000);
    }

    tick();
})();
</script>
</body>
</html>