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
    </style>
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