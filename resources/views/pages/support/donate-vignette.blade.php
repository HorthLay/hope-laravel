{{-- resources/views/pages/support/donate-vignette.blade.php --}}
{{-- Standalone page - NO layout, just the HelloAsso vignette iframe --}}
{{-- Shareable as a direct link, embeddable in bank pages, newsletters, etc. --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex,nofollow"/>
    <title>{{ $title }} - {{ $siteName }}</title>


    {{-- Unfurl meta for link previews (WhatsApp, email, Slack-) --}}
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
            font-family: 'Montserrat', sans-serif;
            display: flex; flex-direction: column;
            align-items: center; justify-content: flex-start;
            min-height: 100vh;
        }

        /* ── Slim branding bar ── */
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

        /* ── Project title bar ── */
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

        /* ── iframe container ── */
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

        /* ── Secure footer ── */
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
    
/* --- GLOBAL STYLE OVERRIDE --- */
body{font-family: 'Montserrat', sans-serif;}
h1,h2,h3,h4,h5,h6,.hero-h1,.section-title,.stat-number-sm,.stat-num,.stat-label,.pill,.breadcrumb{font-family: 'Montserrat', sans-serif;}
.page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{
    position:relative!important;min-height:clamp(480px,65vh,700px)!important;height:auto!important;
    display:flex!important;align-items:flex-end!important;overflow:hidden!important;
    background:#0d1a0a url('{{ asset("images/image-background.jpg") }}') center 45%/cover no-repeat!important;
    isolation:isolate!important;border-radius:0!important;
}
.page-hero::after,.legal-hero::after,.edu-hero::after,.ch-hero::after,.pd-hero::after,.cp-hero::after,.hero::after{
    content:''!important;position:absolute!important;inset:0!important;z-index:1!important;
    background:linear-gradient(0deg,rgba(0,0,0,.80) 0%,rgba(0,0,0,.50) 38%,rgba(0,0,0,.18) 70%,rgba(0,0,0,.05) 100%)!important;
    pointer-events:none!important;
}
.page-hero-bg,.hero-bg,.cp-hero-bg,.hero-bg-img{
    position:absolute!important;inset:0!important;z-index:0!important;
    width:100%!important;height:100%!important;
    object-fit:cover!important;object-position:center 45%!important;
    background-image:url('{{ asset("images/image-background.jpg") }}')!important;
    background-size:cover!important;background-position:center 45%!important;
    filter:none!important;transform:none!important;transition:none!important;opacity:1!important;
}
.page-hero:hover .page-hero-bg,.edu-hero:hover .hero-bg,.ch-hero:hover .hero-bg,.pd-hero:hover .hero-bg,.cp-hero:hover .cp-hero-bg,.hero:hover .hero-bg{transform:none!important;}
.page-hero-overlay,.hero-grad,.cp-hero-gradient,.hero-shape,.hero-ring,.hero-img-strip,.hero-collage,.hero-stats,.hero-orb,#legalCanvas,.l-glow,.cp-orb,.shape-circle,.shape-circle-sm,.shape-dot-grid{display:none!important;}
.page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{
    position:relative!important;z-index:2!important;
    max-width:1100px!important;width:100%!important;
    margin:0 auto!important;padding:0 40px 60px!important;
    display:block!important;text-align:left!important;
}
.page-hero .breadcrumb,.legal-hero .breadcrumb,.edu-hero .breadcrumb,.ch-hero .breadcrumb,.pd-hero .breadcrumb,.cp-hero .breadcrumb,.hero .breadcrumb,
.page-hero .pill,.page-hero .hero-pill,.legal-hero .hero-pill,.edu-hero .hero-eyebrow,.ch-hero .hero-eyebrow,.pd-hero .hero-eyebrow,.cp-hero .hero-eyebrow,.hero .hero-eyebrow,.hero-eyebrow{display:none!important;}
.page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{
    font-family: 'Montserrat', sans-serif;
    font-size:clamp(2.4rem,4.5vw,3.8rem)!important;font-weight:900!important;
    line-height:1.0!important;letter-spacing:-.02em!important;color:#fff!important;
    max-width:720px!important;margin:0 0 18px!important;text-align:left!important;
    text-shadow:0 2px 8px rgba(0,0,0,.8),0 4px 20px rgba(0,0,0,.6)!important;
    animation:fadeUp .65s .08s ease both!important;
}
.page-hero h1 span,.page-hero h1 em,.legal-hero h1 span,.legal-hero h1 em,.edu-hero h1 span,.edu-hero h1 em,.ch-hero h1 span,.ch-hero h1 em,.pd-hero h1 span,.pd-hero h1 em,.cp-hero h1 span,.cp-hero h1 em,.hero h1 span,.hero h1 em,.hero-h1 span,.hero-h1 em,.text-gradient,.glow{
    background:none!important;color:#fff!important;-webkit-text-fill-color:#fff!important;filter:none!important;
}
.page-hero p,.legal-hero p,.edu-hero p,.ch-hero p,.pd-hero p,.cp-hero p,.hero p,.hero-sub,.hero-meta{
    font-family: 'Montserrat', sans-serif;font-size:clamp(.95rem,1.4vw,1.15rem)!important;
    font-weight:500!important;color:rgba(255,255,255,.92)!important;line-height:1.65!important;
    max-width:640px!important;margin:0 0 28px!important;text-align:left!important;
    text-shadow:0 1px 6px rgba(0,0,0,.7)!important;
}
/* Hero CTA Buttons */
.hero-cta-wrap{display:flex!important;flex-wrap:wrap!important;gap:14px!important;align-items:center!important;}
.hero-cta-btn{
    display:inline-flex!important;align-items:center!important;gap:10px!important;
    padding:13px 28px!important;background:#0ea5e9!important;color:#fff!important;
    font-family: 'Montserrat', sans-serif;font-size:12.5px!important;
    font-weight:800!important;letter-spacing:.07em!important;text-transform:uppercase!important;
    border-radius:6px!important;text-decoration:none!important;
    transition:background .2s,transform .18s!important;border:2px solid transparent!important;
    box-shadow:0 4px 14px rgba(14,165,233,.35)!important;
}
.hero-cta-btn:hover{background:#0284c7!important;transform:translateY(-2px)!important;color:#fff!important;}
.hero-cta-btn.outline{background:transparent!important;border:2px solid rgba(255,255,255,.75)!important;box-shadow:none!important;color:#fff!important;}
.hero-cta-btn.outline:hover{background:rgba(255,255,255,.15)!important;border-color:#fff!important;}
/* Mobile */
@media(max-width:1024px){
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{max-width:900px!important;padding:0 28px 50px!important;}
}
@media(max-width:768px){
    .page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{min-height:clamp(420px,75vw,560px)!important;}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{padding:0 20px 40px!important;}
    .page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{font-size:clamp(2rem,7vw,3rem)!important;}
    .page-hero-bg,.hero-bg,.cp-hero-bg,.hero-bg-img{background-position:55% 45%!important;object-position:55% 45%!important;}
    .hero-cta-wrap{flex-direction:column!important;gap:10px!important;}
    .hero-cta-btn{width:100%!important;justify-content:center!important;padding:14px 20px!important;}
}
@media(max-width:480px){
    .page-hero,.legal-hero,.edu-hero,.ch-hero,.pd-hero,.cp-hero,.hero{min-height:clamp(380px,85vw,480px)!important;}
    .page-hero-content,.legal-hero-content,.hero-inner,.cp-hero-inner{padding:0 16px 36px!important;}
    .page-hero h1,.legal-hero h1,.edu-hero h1,.ch-hero h1,.pd-hero h1,.cp-hero h1,.hero h1,.hero-h1{font-size:clamp(1.75rem,9vw,2.4rem)!important;margin-bottom:14px!important;}
    .page-hero p,.legal-hero p,.edu-hero p,.ch-hero p,.pd-hero p,.cp-hero p,.hero p,.hero-sub,.hero-meta{font-size:.9rem!important;margin-bottom:22px!important;}
    .hero-cta-btn{font-size:11.5px!important;padding:12px 18px!important;}
}
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