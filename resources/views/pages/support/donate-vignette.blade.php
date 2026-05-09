{{-- resources/views/pages/support/donate-vignette.blade.php --}}
{{-- Standalone page — NO layout, just the HelloAsso vignette iframe --}}
{{-- Shareable as a direct link, embeddable in bank pages, newsletters, etc. --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex,nofollow"/>
    <title>{{ $title }} — {{ $siteName }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Montserrat:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Unfurl meta for link previews (WhatsApp, email, Slack…) --}}
    <meta property="og:title"       content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image"       content="{{ $imgUrl }}">
    <meta property="og:type"        content="website">
    <meta name="twitter:card"       content="summary_large_image">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            width: 100%; height: 100%;
            background: #f0f4f8;
            font-family: system-ui, -apple-system, sans-serif;
            display: flex; flex-direction: column;
            align-items: center; justify-content: flex-start;
            min-height: 100vh;
        }

        /* â”€â”€ Slim branding bar â”€â”€ */
        .top-bar {
            width: 100%; background: #0f172a;
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 20px; flex-shrink: 0; gap: 12px;
        }
        .top-bar-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .top-bar-brand img {
            height: 32px; width: auto; object-fit: contain;
            border-radius: 6px;
        }
        .top-bar-brand span {
            font-size: 13px; font-weight: 800; color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            max-width: 200px;
        }
        .top-bar-badge {
            display: flex; align-items: center; gap: 6px;
            background: rgba(249,115,22,.18); border: 1px solid rgba(249,115,22,.35);
            border-radius: 99px; padding: 4px 12px; flex-shrink: 0;
        }
        .top-bar-badge span { font-size: 11px; font-weight: 700; color: #fb923c; }

        /* â”€â”€ Project title bar â”€â”€ */
        .project-bar {
            width: 100%; max-width: 420px;
            padding: 14px 16px 10px;
            text-align: center;
        }
        .project-bar h1 {
            font-size: 15px; font-weight: 900; color: #1e293b; line-height: 1.3;
            margin-bottom: 4px;
        }
        .project-bar p {
            font-size: 12px; color: #94a3b8; line-height: 1.5;
        }

        /* â”€â”€ iframe container â”€â”€ */
        .iframe-wrap {
            width: 100%; max-width: 420px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,.12);
            flex-shrink: 0;
        }
        .iframe-wrap iframe {
            display: block;
            width: 100%;
            height: 480px;
            border: none;
        }

        /* â”€â”€ Secure footer â”€â”€ */
        .secure-bar {
            width: 100%; max-width: 420px;
            display: flex; align-items: center; justify-content: center;
            gap: 16px; flex-wrap: wrap;
            padding: 12px 16px 20px;
        }
        .secure-item {
            display: flex; align-items: center; gap: 5px;
            font-size: 11px; font-weight: 600; color: #94a3b8;
        }

        @media (max-width: 440px) {
            .iframe-wrap iframe { height: 500px; }
            .top-bar-brand span { max-width: 140px; }
        }
    
/* Donate page global header/font match */
body{font-family:'Outfit',sans-serif!important;}
body [style*="font-family"]{font-family:'Outfit',sans-serif!important;}
h1[style*="font-family"],h2[style*="font-family"],h3[style*="font-family"],h4[style*="font-family"],h5[style*="font-family"],h6[style*="font-family"]{font-family:'Montserrat',sans-serif!important;}
h1,h2,h3,h4,h5,h6,
.hero-h1,.section-title,.section-pill,.breadcrumb,.pill,.hero-pill,
.hero-eyebrow,.hero-meta,.hero-sub,.hero-ref-btn,.hero-btn,.hero-cta,
.btn-gold,.btn-ghost,.stat-number-sm,.stat-num,.stat-label{
    font-family:'Montserrat',sans-serif!important;
}
.page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{
    position:relative!important;
    min-height:370px!important;
    height:370px!important;
    display:flex!important;
    align-items:center!important;
    overflow:hidden!important;
    background:#1a1109 url('{{ asset('images/image-background.jpg') }}') center 45%/cover no-repeat!important;
    isolation:isolate!important;
    border-radius:0!important;
}
.page-hero::after,.legal-hero::after,.edu-hero::after,.ch-hero::after,.pd-hero::after,.cp-hero::after,.hero::after{
    content:''!important;
    position:absolute!important;inset:0!important;z-index:1!important;
    background:
        linear-gradient(90deg,rgba(0,0,0,.34) 0%,rgba(0,0,0,.30) 34%,rgba(0,0,0,.18) 68%,rgba(0,0,0,.10) 100%),
        linear-gradient(180deg,rgba(0,0,0,.16) 0%,rgba(0,0,0,.08) 48%,rgba(0,0,0,.18) 100%)!important;
    pointer-events:none!important;
}
.page-hero-bg,.hero-bg,.cp-hero-bg,.hero-bg-img{
    position:absolute!important;inset:0!important;z-index:0!important;
    display:block!important;
    width:100%!important;height:100%!important;
    object-fit:cover!important;object-position:center 45%!important;
    background-image:url('{{ asset('images/image-background.jpg') }}')!important;
    background-size:cover!important;background-position:center 45%!important;
    filter:none!important;transform:none!important;transition:none!important;
    opacity:1!important;
}
.page-hero:hover .page-hero-bg,.edu-hero:hover .hero-bg,.ch-hero:hover .hero-bg,.pd-hero:hover .hero-bg,.cp-hero:hover .cp-hero-bg,.hero:hover .hero-bg{
    transform:none!important;
}
.page-hero-overlay,.hero-grad,.cp-hero-gradient,.hero-shape,.hero-ring,.hero-img-strip,.hero-collage,.hero-stats,.hero-orb,#legalCanvas,.l-glow{
    display:none!important;
}
.page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{
    position:relative!important;z-index:2!important;
    max-width:1020px!important;width:100%!important;
    margin:0 auto!important;
    padding:68px 28px 56px!important;
    display:block!important;
    text-align:left!important;
}
.page-hero .breadcrumb,.legal-hero .breadcrumb,.edu-hero .breadcrumb,.ch-hero .breadcrumb,.pd-hero .breadcrumb,.cp-hero .breadcrumb,.hero .breadcrumb,
.page-hero .pill,.page-hero .hero-pill,.legal-hero .hero-pill,.edu-hero .hero-eyebrow,.ch-hero .hero-eyebrow,.pd-hero .hero-eyebrow,.cp-hero .hero-eyebrow,.hero .hero-eyebrow{
    display:none!important;
}
.page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{
    font-family:'Montserrat',sans-serif!important;
    font-size:clamp(2.7rem,4vw,3.55rem)!important;
    font-weight:900!important;
    line-height:.96!important;
    letter-spacing:-.015em!important;
    color:#fff!important;
    max-width:650px!important;
    margin:0 0 22px!important;
    text-align:left!important;
    text-shadow:0 2px 2px rgba(0,0,0,.75),0 4px 10px rgba(0,0,0,.62)!important;
    animation:fadeUp .6s .08s ease both!important;
}
.page-hero h1 span,.page-hero h1 em,.legal-hero h1 span,.legal-hero h1 em,.edu-hero h1 span,.edu-hero h1 em,
.ch-hero h1 span,.ch-hero h1 em,.pd-hero h1 span,.pd-hero h1 em,.cp-hero h1 span,.cp-hero h1 em,.hero h1 span,.hero h1 em,
.text-gradient,.glow{
    background:none!important;
    color:#fff!important;
    -webkit-text-fill-color:#fff!important;
    filter:none!important;
}
.page-hero p,.legal-hero p,.edu-hero p,.ch-hero p,.pd-hero p,.cp-hero p,.hero p,.hero-sub,.hero-meta{
    font-family:'Montserrat',sans-serif!important;
    font-size:clamp(1rem,1.25vw,1.18rem)!important;
    font-weight:700!important;
    color:#fff!important;
    line-height:1.55!important;
    max-width:665px!important;
    margin:0!important;
    text-align:left!important;
    text-shadow:0 2px 2px rgba(0,0,0,.78),0 4px 10px rgba(0,0,0,.58)!important;
}
@media(max-width:1024px){
    .page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{height:340px!important;min-height:340px!important;}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{max-width:860px!important;padding:56px 28px 46px!important;}
}
@media(max-width:768px){
    .page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{height:360px!important;min-height:360px!important;}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{padding:56px 24px 44px!important;}
    .page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{font-size:clamp(2.2rem,8vw,3rem)!important;max-width:560px!important;}
    .page-hero-bg,.hero-bg,.cp-hero-bg,.hero-bg-img{background-position:58% 50%!important;object-position:58% 50%!important;}
}
@media(max-width:480px){
    .page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{height:390px!important;min-height:390px!important;}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{padding:48px 20px 40px!important;}
    .page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{font-size:clamp(1.95rem,10vw,2.5rem)!important;line-height:1!important;margin-bottom:16px!important;}
    .page-hero p,.legal-hero p,.edu-hero p,.ch-hero p,.pd-hero p,.cp-hero p,.hero p,.hero-sub,.hero-meta{font-size:.95rem!important;line-height:1.55!important;}
}</style>
</head>
<body>

    {{-- Top branding bar --}}
    <div class="top-bar">
        <a href="{{ url('/') }}" class="top-bar-brand">
            @if($logoUrl)
            <img src="{{ $logoUrl }}" alt="{{ $siteName }}">
            @endif
            <span>{{ $siteName }}</span>
        </a>
        <div class="top-bar-badge">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="#fb923c"><circle cx="12" cy="12" r="10"/></svg>
            <span>Donate</span>
        </div>
    </div>

    {{-- Project title --}}
    <div class="project-bar">
        <h1>{{ $title }}</h1>
        @if($description)
        <p>{{ Str::limit($description, 120) }}</p>
        @endif
    </div>

    {{-- HelloAsso vignette iframe --}}
    <div class="iframe-wrap">
        <iframe
            src="{{ $vignetteUrl }}"
            allowtransparency="true"
            loading="lazy"
            title="{{ $title }}">
        </iframe>
    </div>

    {{-- Security footer --}}
    <div class="secure-bar">
        <span class="secure-item">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="#22c55e"><path d="M12 1L3 5v6c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V5L12 1z"/></svg>
            Secure payment
        </span>
        <span class="secure-item">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="#f97316"><path d="M4 4h16v2H4zm0 4h16v12H4z"/></svg>
            Receipt provided
        </span>
        <span class="secure-item" style="color:#64748b;">
            Powered by HelloAsso
        </span>
    </div>

</body>
</html>