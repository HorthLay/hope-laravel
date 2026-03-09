{{-- resources/views/layouts/maintenance.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
    <meta name="robots" content="noindex, nofollow">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @if(!empty($settings['favicon']))<link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">@endif
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family:'Plus Jakarta Sans',sans-serif;
            background:#0f172a;min-height:100vh;
            display:flex;align-items:center;justify-content:center;
            overflow:hidden;position:relative;
        }
        /* ── Grid ── */
        .bg-grid{
            position:absolute;inset:0;pointer-events:none;
            background-image:
                linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),
                linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);
            background-size:48px 48px;
        }
        /* ── Orbs ── */
        .bg-orb{position:absolute;border-radius:50%;pointer-events:none;filter:blur(80px);}
        .bg-orb-1{width:500px;height:500px;top:-150px;right:-100px;background:radial-gradient(circle,rgba(249,115,22,.2) 0%,transparent 65%);animation:orbFloat 8s ease-in-out infinite;}
        .bg-orb-2{width:400px;height:400px;bottom:-120px;left:-80px;background:radial-gradient(circle,rgba(251,191,36,.12) 0%,transparent 65%);animation:orbFloat 10s ease-in-out infinite reverse;}
        .bg-orb-3{width:280px;height:280px;top:40%;left:50%;background:radial-gradient(circle,rgba(99,102,241,.12) 0%,transparent 65%);animation:orbFloat3 12s ease-in-out infinite 2s;}
        @keyframes orbFloat{0%,100%{transform:translateY(0) scale(1)}50%{transform:translateY(-28px) scale(1.05)}}
        @keyframes orbFloat3{0%,100%{transform:translate(-50%,-50%) scale(1)}50%{transform:translate(-50%,-54%) scale(1.05)}}

        /* ── Card ── */
        .maint-card{
            position:relative;z-index:10;
            background:rgba(255,255,255,.04);
            border:1px solid rgba(255,255,255,.1);
            backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);
            border-radius:32px;padding:52px 44px 48px;
            max-width:520px;width:calc(100% - 32px);
            text-align:center;
            box-shadow:0 32px 96px rgba(0,0,0,.55),inset 0 1px 0 rgba(255,255,255,.1);
            animation:cardIn .65s cubic-bezier(.34,1.1,.64,1) both;
        }
        @keyframes cardIn{from{opacity:0;transform:translateY(28px) scale(.96)}to{opacity:1;transform:none}}

        /* ── Logo ── */
        .maint-logo{display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:32px;animation:fadeUp .5s .1s both;}
        @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
        .maint-logo img{height:52px;width:auto;}
        .maint-logo-name{font-size:15px;font-weight:900;color:#fff;text-align:left;line-height:1.2;}
        .maint-logo-tag{font-size:11px;color:rgba(255,255,255,.4);font-weight:500;text-align:left;margin-top:2px;}

        /* ── Label ── */
        .maint-label{
            display:inline-flex;align-items:center;gap:7px;
            background:rgba(249,115,22,.15);border:1px solid rgba(249,115,22,.3);
            color:#fb923c;font-size:11px;font-weight:800;letter-spacing:.1em;
            text-transform:uppercase;padding:5px 14px;border-radius:99px;margin-bottom:22px;
            animation:pulseLbl 2.2s ease-in-out infinite,fadeUp .5s .15s both;
        }
        @keyframes pulseLbl{0%,100%{opacity:1}50%{opacity:.6}}
        .maint-label .dot{width:7px;height:7px;border-radius:50%;background:#f97316;animation:pulseLbl 1.4s ease-in-out infinite;}

        /* ── Gear ── */
        .gear-wrap{
            width:84px;height:84px;border-radius:22px;margin:0 auto 26px;
            background:linear-gradient(135deg,rgba(249,115,22,.22),rgba(234,88,12,.12));
            border:1px solid rgba(249,115,22,.28);
            display:flex;align-items:center;justify-content:center;position:relative;
            animation:fadeUp .5s .2s both;
        }
        .gear-wrap::before{
            content:'';position:absolute;inset:-7px;border-radius:28px;
            border:1.5px dashed rgba(249,115,22,.22);
            animation:gearRing 14s linear infinite;
        }
        @keyframes gearRing{to{transform:rotate(360deg)}}
        .gear-icon{font-size:34px;color:#f97316;animation:gearSpin 7s linear infinite;}
        @keyframes gearSpin{to{transform:rotate(360deg)}}

        /* ── Heading ── */
        .maint-h1{
            font-family:'Instrument Serif',serif;
            font-size:clamp(24px,5.5vw,36px);color:#fff;
            line-height:1.2;margin-bottom:14px;
            animation:fadeUp .5s .25s both;
        }
        .maint-h1 em{color:#fb923c;font-style:italic;}

        /* ── Desc ── */
        .maint-desc{
            font-size:14px;color:rgba(255,255,255,.48);
            line-height:1.75;margin-bottom:28px;font-weight:500;
            animation:fadeUp .5s .3s both;
        }

        /* ── Features ── */
        .maint-features{display:flex;gap:8px;justify-content:center;flex-wrap:wrap;margin-bottom:28px;animation:fadeUp .5s .35s both;}
        .maint-feat{
            display:flex;align-items:center;gap:6px;
            background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);
            border-radius:10px;padding:7px 13px;
            font-size:11px;font-weight:700;color:rgba(255,255,255,.65);
            transition:background .2s,border-color .2s;
        }
        .maint-feat:hover{background:rgba(255,255,255,.09);border-color:rgba(249,115,22,.3);}
        .maint-feat i{font-size:10px;color:#f97316;}

        /* ── Divider ── */
        .maint-divider{
            height:1px;
            background:linear-gradient(to right,transparent,rgba(255,255,255,.1),transparent);
            margin-bottom:24px;animation:fadeUp .5s .38s both;
        }

        /* ── Contact ── */
        .maint-contact{display:flex;gap:9px;justify-content:center;flex-wrap:wrap;animation:fadeUp .5s .42s both;}
        .maint-contact a{
            display:inline-flex;align-items:center;gap:7px;
            padding:9px 16px;border-radius:11px;text-decoration:none;
            font-size:12px;font-weight:700;transition:all .2s;border:1px solid;
            font-family:'Plus Jakarta Sans',sans-serif;
        }
        .maint-contact a.primary{
            background:linear-gradient(135deg,#f97316,#ea580c);
            border-color:transparent;color:#fff;
            box-shadow:0 4px 20px rgba(249,115,22,.38);
        }
        .maint-contact a.primary:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(249,115,22,.5);}
        .maint-contact a.secondary{
            background:rgba(255,255,255,.06);
            border-color:rgba(255,255,255,.13);color:rgba(255,255,255,.72);
        }
        .maint-contact a.secondary:hover{background:rgba(255,255,255,.12);color:#fff;transform:translateY(-1px);}

        /* ── Footer ── */
        .maint-footer{
            margin-top:32px;font-size:11px;color:rgba(255,255,255,.2);
            font-weight:500;animation:fadeUp .5s .46s both;
        }

        /* ── Mobile ── */
        @media(max-width:480px){
            .maint-card{padding:36px 20px 32px;border-radius:24px;}
            .gear-wrap{width:70px;height:70px;border-radius:18px;}
            .gear-icon{font-size:28px;}
            .maint-feat{font-size:10px;padding:6px 10px;}
            .maint-contact a{padding:8px 13px;font-size:11px;}
            .maint-h1{font-size:clamp(22px,7vw,32px);}
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>

    <div class="maint-card">

        {{-- Logo --}}
        @if(!empty($settings['logo']))
        <div class="maint-logo">
            <img src="{{ asset($settings['logo']) }}" alt="{{ $settings['site_name'] ?? '' }}">
            <div>
                <div class="maint-logo-name">{{ $settings['site_name'] ?? 'Hope & Impact' }}</div>
                @if(!empty($settings['site_tagline']))<div class="maint-logo-tag">{{ $settings['site_tagline'] }}</div>@endif
            </div>
        </div>
        @else
        <div style="font-size:14px;font-weight:900;color:rgba(255,255,255,.6);margin-bottom:28px;letter-spacing:.04em;">
            {{ $settings['site_name'] ?? 'Hope & Impact' }}
        </div>
        @endif

        {{-- Status badge --}}
        <div class="maint-label"><span class="dot"></span> Under Maintenance</div>

        {{-- Gear --}}
        <div class="gear-wrap"><i class="fas fa-cog gear-icon"></i></div>

        {{-- Heading --}}
        <h1 class="maint-h1">We'll be <em>back soon!</em></h1>
        <p class="maint-desc">
            Our website is currently undergoing scheduled maintenance and improvements.
            We apologize for any inconvenience — we'll be back shortly!
        </p>

        {{-- Feature pills --}}
        <div class="maint-features">
            <div class="maint-feat"><i class="fas fa-wrench"></i> Updates in progress</div>
            <div class="maint-feat"><i class="fas fa-shield-alt"></i> Securing systems</div>
            <div class="maint-feat"><i class="fas fa-rocket"></i> Performance boost</div>
        </div>

        <div class="maint-divider"></div>

        <p style="font-size:12px;color:rgba(255,255,255,.38);margin-bottom:14px;font-weight:600;">Need urgent assistance?</p>

        {{-- Contact buttons --}}
        <div class="maint-contact">
            @php
                $mEmail    = $settings['contact_email'] ?? null;
                $mWhatsapp = $settings['whatsapp_url']  ?? null;
                $mFacebook = $settings['facebook_url']  ?? null;
            @endphp
            @if($mEmail)
            <a href="https://mail.google.com/mail/?view=cm&to={{ $mEmail }}" target="_blank" class="primary">
                <i class="fas fa-envelope"></i> Email Us
            </a>
            @endif
            @if($mWhatsapp)
            <a href="https://wa.me/{{ $mWhatsapp }}" target="_blank" class="secondary">
                <i class="fab fa-whatsapp" style="color:#4ade80"></i> WhatsApp
            </a>
            @endif
            @if($mFacebook)
            <a href="{{ $mFacebook }}" target="_blank" class="secondary">
                <i class="fab fa-facebook" style="color:#60a5fa"></i> Facebook
            </a>
            @endif
            @if(!$mEmail && !$mWhatsapp && !$mFacebook)
            <span style="font-size:11px;color:rgba(255,255,255,.3)">Contact details coming soon.</span>
            @endif
        </div>

        <p class="maint-footer">&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Hope & Impact' }} &middot; All rights reserved</p>
    </div>
</body>
</html>