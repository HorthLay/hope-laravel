{{-- resources/views/articles/show.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $article->meta_title ?? $article->title }} | Hope & Impact</title>
    <meta name="description" content="{{ $article->meta_description ?? Str::limit(strip_tags($article->excerpt ?? $article->content ?? ''), 160) }}">
    @if($article->meta_keywords)
        <meta name="keywords" content="{{ $article->meta_keywords }}">
    @endif
    <meta property="og:title"       content="{{ $article->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($article->excerpt ?? ''), 160) }}">
    @if($article->image)
        <meta property="og:image" content="{{ $article->image->url }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
    <style>
        .article-body h1,.article-body h2,.article-body h3,.article-body h4{font-weight:700;margin-top:1.75rem;margin-bottom:.75rem;color:#1f2937;line-height:1.3}
        .article-body h1{font-size:1.875rem}.article-body h2{font-size:1.5rem;border-bottom:2px solid #fed7aa;padding-bottom:.5rem}
        .article-body h3{font-size:1.25rem}.article-body h4{font-size:1.125rem}
        .article-body p{margin-bottom:1.25rem;line-height:1.85;color:#374151}
        .article-body a{color:#f97316;text-decoration:underline;transition:color .2s}.article-body a:hover{color:#ea580c}
        .article-body ul,.article-body ol{padding-left:1.5rem;margin-bottom:1.25rem}
        .article-body ul{list-style-type:disc}.article-body ol{list-style-type:decimal}
        .article-body li{margin-bottom:.5rem;line-height:1.75;color:#374151}
        .article-body blockquote{border-left:4px solid #f97316;padding:1rem 1.5rem;margin:1.5rem 0;background:#fff7ed;font-style:italic;color:#92400e;border-radius:0 .75rem .75rem 0}
        .article-body img{max-width:100%;height:auto;border-radius:.75rem;margin:1.5rem auto;display:block;box-shadow:0 4px 20px rgba(0,0,0,.1)}
        .article-body strong{font-weight:700;color:#1f2937}
        .article-body em{font-style:italic;color:#4b5563}
        .article-body table{width:100%;border-collapse:collapse;margin-bottom:1.5rem;font-size:.9rem}
        .article-body th,.article-body td{padding:.75rem 1rem;border:1px solid #e5e7eb;text-align:left}
        .article-body th{background:#fff7ed;font-weight:600;color:#92400e}
        .article-body pre{background:#1f2937;color:#f9fafb;padding:1.25rem;border-radius:.75rem;overflow-x:auto;margin-bottom:1.5rem;font-size:.875rem;line-height:1.6}
        .article-body code{background:#f3f4f6;padding:.125rem .375rem;border-radius:.25rem;font-size:.875rem;color:#e11d48}
        .article-body pre code{background:transparent;padding:0;color:#f9fafb}
        .article-body hr{border:none;border-top:2px solid #fed7aa;margin:2rem 0}

        /* ── Quill editor alignment classes ─────────────────────────── */
        .article-body .ql-align-center,
        .article-body p.ql-align-center,
        .article-body h1.ql-align-center,
        .article-body h2.ql-align-center,
        .article-body h3.ql-align-center,
        .article-body h4.ql-align-center,
        .article-body li.ql-align-center   { text-align: center !important; }

        .article-body .ql-align-right,
        .article-body p.ql-align-right,
        .article-body h1.ql-align-right,
        .article-body h2.ql-align-right,
        .article-body h3.ql-align-right,
        .article-body h4.ql-align-right,
        .article-body li.ql-align-right    { text-align: right !important; }

        .article-body .ql-align-justify,
        .article-body p.ql-align-justify,
        .article-body li.ql-align-justify  { text-align: justify !important; }

        .article-body .ql-align-left,
        .article-body p.ql-align-left      { text-align: left !important; }

        /* ── Quill indent levels ─────────────────────────────────────── */
        .article-body .ql-indent-1  { padding-left: 3em !important; }
        .article-body .ql-indent-2  { padding-left: 6em !important; }
        .article-body .ql-indent-3  { padding-left: 9em !important; }
        .article-body .ql-indent-4  { padding-left: 12em !important; }
        .article-body .ql-indent-5  { padding-left: 15em !important; }
        .article-body .ql-indent-6  { padding-left: 18em !important; }
        .article-body .ql-indent-7  { padding-left: 21em !important; }
        .article-body .ql-indent-8  { padding-left: 24em !important; }

        /* ── Quill color/background spans ───────────────────────────── */
        .article-body span[style*="color"]      { /* preserve inline color */ }
        .article-body span[style*="background"] { /* preserve inline bg */ }

        /* ── Quill font-size spans ───────────────────────────────────── */
        .article-body .ql-size-small  { font-size: .85em !important; }
        .article-body .ql-size-large  { font-size: 1.5em !important; }
        .article-body .ql-size-huge   { font-size: 2em !important; }
    </style>
</head>
<body class="bg-gray-50">

@include('layouts.header')

{{-- ===== BREADCRUMB ===== --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-4 py-3">
        <nav class="flex items-center gap-2 text-sm text-gray-500 flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-orange-500 transition flex items-center gap-1">
                <i class="fas fa-home text-xs"></i> Home
            </a>
            <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            @if($article->category)
                <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                   class="hover:opacity-80 transition font-medium"
                   style="color:{{ $article->category->color ?? '#f97316' }}">
                    @if($article->category->icon)<i class="{{ $article->category->icon }} text-xs mr-1"></i>@endif
                    {{ $article->category->name }}
                </a>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            @endif
            <span class="text-gray-700 line-clamp-1">{{ Str::limit($article->title, 55) }}</span>
        </nav>
    </div>
</div>

{{-- ===== HERO IMAGE ===== --}}
@if($article->image)
<div class="w-full bg-gray-900 overflow-hidden" style="max-height:480px">
    <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
         class="w-full object-cover" style="max-height:480px;width:100%;object-position:center">
</div>
@endif

{{-- ===== MAIN LAYOUT ===== --}}
<div class="max-w-6xl mx-auto px-4 py-8 md:py-12">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

        {{-- ══════════════════════════════════════
             ARTICLE CONTENT — LEFT (2/3)
        ══════════════════════════════════════ --}}
        <article class="flex-1 min-w-0">

            {{-- Badges --}}
            <div class="flex flex-wrap items-center gap-2 mb-4">
                @if($article->category)
                    <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                       class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold transition hover:opacity-80"
                       style="background-color:{{ $article->category->color ?? '#f97316' }}22;
                              color:{{ $article->category->color ?? '#f97316' }};
                              border:1px solid {{ $article->category->color ?? '#f97316' }}44;">
                        @if($article->category->icon)<i class="{{ $article->category->icon }} text-xs"></i>@endif
                        {{ $article->category->name }}
                    </a>
                @endif
                @if($article->is_featured)
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                        <i class="fas fa-star text-xs"></i> Featured
                    </span>
                @endif
            </div>

            {{-- Title --}}
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-gray-900 mb-5 leading-tight">
                {{ $article->title }}
            </h1>

            {{-- Meta bar --}}
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pb-5 mb-6 border-b-2 border-orange-100">
                {{-- Author --}}
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr($article->admin?->name ?? 'H', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 leading-none">{{ $article->admin?->name ?? 'Hope & Impact' }}</p>
                        <p class="text-xs text-gray-400">{{ ucfirst(str_replace('_',' ', $article->admin?->role ?? 'editor')) }}</p>
                    </div>
                </div>
                <span class="text-gray-200">|</span>
                <span class="flex items-center gap-1 text-xs text-gray-500">
                    <i class="fas fa-calendar-alt text-orange-400"></i>
                    {{ $article->published_at?->format('F j, Y') }}
                </span>
                <span class="flex items-center gap-1 text-xs text-gray-500">
                    <i class="fas fa-clock text-orange-400"></i>
                    {{ $article->reading_time ?? max(1, ceil(str_word_count(strip_tags($article->content ?? '')) / 200)) }} min read
                </span>
                <span class="flex items-center gap-1 text-xs text-gray-500">
                    <i class="fas fa-eye text-orange-400"></i>
                    {{ number_format($article->views_count) }} views
                </span>
            </div>

            {{-- Excerpt lead --}}
            @if($article->excerpt)
                <div class="bg-orange-50 border-l-4 border-orange-400 rounded-r-xl px-5 py-4 mb-7">
                    <p class="text-base md:text-lg text-gray-700 font-medium leading-relaxed">
                        {{ strip_tags($article->excerpt) }}
                    </p>
                </div>
            @endif

            {{-- Body --}}
            <div class="article-body">
                {!! $article->content !!}
            </div>

            {{-- Tags / Share --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Share this story:</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                           target="_blank" rel="noopener"
                           class="flex items-center gap-2 px-4 py-2 bg-[#1877f2] hover:bg-[#166fe5] text-white text-xs font-bold rounded-lg transition">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->fullUrl()) }}"
                           target="_blank" rel="noopener"
                           class="flex items-center gap-2 px-4 py-2 bg-black hover:bg-gray-800 text-white text-xs font-bold rounded-lg transition">
                            <i class="fab fa-x-twitter"></i> X
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($article->title.' '.request()->fullUrl()) }}"
                           target="_blank" rel="noopener"
                           class="flex items-center gap-2 px-4 py-2 bg-[#25d366] hover:bg-[#22bf5c] text-white text-xs font-bold rounded-lg transition">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <button id="copyBtn"
                                onclick="navigator.clipboard.writeText(window.location.href).then(()=>{document.getElementById('copyBtn').innerHTML='<i class=\'fas fa-check\'></i> Copied!'; setTimeout(()=>document.getElementById('copyBtn').innerHTML='<i class=\'fas fa-link\'></i> Copy',2000)})"
                                class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition">
                            <i class="fas fa-link"></i> Copy
                        </button>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2 text-sm text-orange-500 hover:text-orange-600 font-semibold transition">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>

            {{-- ── PREV / NEXT ── --}}
            @if($prevArticle || $nextArticle)
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Prev --}}
                <div>
                @if($prevArticle)
                    <a href="{{ route('articles.show', $prevArticle->encrypted_slug) }}"
                       class="group flex items-center gap-3 p-4 bg-white rounded-xl border-2 border-gray-100 hover:border-orange-300 hover:shadow-md transition h-full">
                        <div class="w-10 h-10 rounded-full bg-orange-50 group-hover:bg-orange-100 flex items-center justify-center flex-shrink-0 transition">
                            <i class="fas fa-arrow-left text-orange-500 text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 font-medium mb-1">← Previous</p>
                            <p class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition line-clamp-2 leading-snug">
                                {{ $prevArticle->title }}
                            </p>
                            @if($prevArticle->category)
                                <span class="text-xs font-semibold mt-1 block" style="color:{{ $prevArticle->category->color ?? '#f97316' }}">
                                    {{ $prevArticle->category->name }}
                                </span>
                            @endif
                        </div>
                    </a>
                @endif
                </div>
                {{-- Next --}}
                <div>
                @if($nextArticle)
                    <a href="{{ route('articles.show', $nextArticle->encrypted_slug) }}"
                       class="group flex items-center gap-3 p-4 bg-white rounded-xl border-2 border-gray-100 hover:border-orange-300 hover:shadow-md transition text-right justify-end h-full">
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 font-medium mb-1">Next →</p>
                            <p class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition line-clamp-2 leading-snug">
                                {{ $nextArticle->title }}
                            </p>
                            @if($nextArticle->category)
                                <span class="text-xs font-semibold mt-1 block" style="color:{{ $nextArticle->category->color ?? '#f97316' }}">
                                    {{ $nextArticle->category->name }}
                                </span>
                            @endif
                        </div>
                        <div class="w-10 h-10 rounded-full bg-orange-50 group-hover:bg-orange-100 flex items-center justify-center flex-shrink-0 transition">
                            <i class="fas fa-arrow-right text-orange-500 text-sm"></i>
                        </div>
                    </a>
                @endif
                </div>
            </div>
            @endif

        </article>

        {{-- ══════════════════════════════════════
             SIDEBAR — RIGHT (1/3)
        ══════════════════════════════════════ --}}
        <aside class="w-full lg:w-80 flex-shrink-0 space-y-6">

            {{-- Author card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="h-12 bg-gradient-to-r from-orange-400 to-orange-600"></div>
                <div class="px-5 pb-5 -mt-6">
                    @if($article->admin?->avatar)
                        <img src="{{ asset('storage/' . $article->admin->avatar) }}" alt="{{ $article->admin->name }}"
                             class="w-14 h-14 rounded-full object-cover border-4 border-white shadow mb-3">
                    @else
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-black text-xl border-4 border-white shadow mb-3">
                            {{ strtoupper(substr($article->admin?->name ?? 'H', 0, 1)) }}
                        </div>
                    @endif
                    <p class="font-bold text-gray-900">{{ $article->admin?->name ?? 'Hope & Impact' }}</p>
                    <p class="text-xs text-orange-500 font-semibold mb-2">{{ ucfirst(str_replace('_',' ', $article->admin?->role ?? 'editor')) }}</p>
                    <p class="text-xs text-gray-500 leading-relaxed">Contributing writer covering children's education and welfare in Southeast Asia.</p>
                </div>
            </div>

            {{-- Category card --}}
            @if($article->category)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Filed Under</p>
                <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                   class="flex items-center gap-3 p-3 rounded-xl transition hover:opacity-90 group"
                   style="background-color:{{ $article->category->color ?? '#f97316' }}12;">
                    @if($article->category->icon)
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 transition group-hover:scale-110"
                             style="background-color:{{ $article->category->color ?? '#f97316' }}25;">
                            <i class="{{ $article->category->icon }}" style="color:{{ $article->category->color ?? '#f97316' }}"></i>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 text-sm">{{ $article->category->name }}</p>
                        @if($article->category->description)
                            <p class="text-xs text-gray-500 line-clamp-1">{{ $article->category->description }}</p>
                        @endif
                    </div>
                    <i class="fas fa-arrow-right text-xs flex-shrink-0" style="color:{{ $article->category->color ?? '#f97316' }}"></i>
                </a>
            </div>
            @endif

            {{-- Related articles --}}
            @if($related->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Related Articles</p>
                <div class="space-y-3">
                    @foreach($related as $rel)
                        <a href="{{ route('articles.show', $rel->encrypted_slug) }}"
                           class="flex gap-3 group p-2 -mx-2 rounded-xl hover:bg-orange-50 transition">
                            {{-- thumb --}}
                            <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                                @if($rel->image)
                                    <img src="{{ $rel->image->url }}" alt="{{ $rel->title }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-newspaper text-orange-300 text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            {{-- text --}}
                            <div class="flex-1 min-w-0">
                                @if($rel->category)
                                    <span class="text-xs font-bold block mb-1 leading-none"
                                          style="color:{{ $rel->category->color ?? '#f97316' }}">
                                        {{ $rel->category->name }}
                                    </span>
                                @endif
                                <p class="text-xs font-semibold text-gray-800 line-clamp-2 group-hover:text-orange-600 transition leading-snug">
                                    {{ $rel->title }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    <i class="fas fa-eye mr-1"></i>{{ number_format($rel->views_count) }}
                                    · {{ $rel->published_at?->format('M d') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Sponsor CTA --}}
            <div class="rounded-2xl overflow-hidden shadow-sm">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-5 text-center text-white">
                    <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-child text-3xl"></i>
                    </div>
                    <h3 class="font-black text-lg mb-1">Sponsor a Child</h3>
                    <p class="text-sm text-white/90 mb-4 leading-relaxed">Change a life for just $1 a day. Education, meals, and hope.</p>
                    <a href="{{ route('detail') }}"
                       class="block w-full bg-white text-orange-600 font-bold text-sm py-3 rounded-xl hover:bg-orange-50 transition shadow">
                        Sponsor Now <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

        </aside>
    </div>
</div>

{{-- ===== MORE FROM THIS CATEGORY (full width bottom) ===== --}}
@if($related->isNotEmpty())
<section class="bg-gray-50 py-12 mt-4">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">
                    More from
                    @if($article->category)
                        <span style="color:{{ $article->category->color ?? '#f97316' }}">{{ $article->category->name }}</span>
                    @else
                        Hope & Impact
                    @endif
                </h2>
                <div class="h-1 w-12 rounded-full bg-orange-500"></div>
            </div>
            @if($article->category)
                <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                   class="flex-shrink-0 text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all"
                   style="color:{{ $article->category->color ?? '#f97316' }}">
                    See All <i class="fas fa-arrow-right text-xs"></i>
                </a>
            @endif
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($related as $rel)
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition group">
                    <div class="overflow-hidden">
                        @if($rel->image)
                            <img src="{{ $rel->image->url }}" alt="{{ $rel->title }}"
                                 class="w-full h-44 object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-44 flex items-center justify-center"
                                 style="background-color:{{ $article->category->color ?? '#f97316' }}10;">
                                <i class="fas fa-newspaper text-4xl opacity-20"
                                   style="color:{{ $article->category->color ?? '#f97316' }}"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        @if($rel->category)
                            <a href="{{ route('category.articles', $rel->category->encrypted_slug) }}"
                               class="text-xs font-bold mb-2 block hover:underline"
                               style="color:{{ $rel->category->color ?? '#f97316' }}">
                                @if($rel->category->icon)<i class="{{ $rel->category->icon }} mr-1 text-xs"></i>@endif
                                {{ $rel->category->name }}
                            </a>
                        @endif
                        <h3 class="text-sm font-bold text-gray-800 line-clamp-2 mb-2 group-hover:text-orange-500 transition leading-snug">
                            {{ $rel->title }}
                        </h3>
                        @if($rel->excerpt)
                            <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ Str::limit(strip_tags($rel->excerpt), 80) }}</p>
                        @endif
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <a href="{{ route('articles.show', $rel->encrypted_slug) }}"
                               class="text-xs font-bold flex items-center gap-1 hover:gap-2 transition-all"
                               style="color:{{ $rel->category->color ?? '#f97316' }}">
                                Read More <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                            <span class="text-xs text-gray-400">
                                <i class="fas fa-eye mr-1"></i>{{ number_format($rel->views_count) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Lightbox --}}
<div id="lightbox" class="fixed inset-0 bg-black/90 z-[9999] hidden items-center justify-center p-4"
     onclick="closeLightbox()">
    <button class="absolute top-4 right-4 text-white text-3xl hover:text-orange-400 transition" onclick="closeLightbox()">
        <i class="fas fa-times"></i>
    </button>
    <img id="lightbox-img" src="" alt="" class="max-w-full max-h-full rounded-xl shadow-2xl">
</div>

@include('layouts.footer')
@include('layouts.navigation')

<script>
// Lightbox
function openLightbox(src){ const lb=document.getElementById('lightbox'); lb.style.display='flex'; document.getElementById('lightbox-img').src=src; document.body.style.overflow='hidden'; }
function closeLightbox(){ document.getElementById('lightbox').style.display='none'; document.body.style.overflow=''; }
document.addEventListener('keydown', e => { if(e.key==='Escape') closeLightbox(); });

// Mobile menu
const mobileMenu=document.getElementById('mobile-menu'), overlay=document.getElementById('mobile-menu-overlay');
const openMenu=()=>{ mobileMenu?.classList.add('active'); overlay?.classList.add('active'); document.body.style.overflow='hidden'; };
const closeMenu=()=>{ mobileMenu?.classList.remove('active'); overlay?.classList.remove('active'); document.body.style.overflow=''; };
document.getElementById('mobile-menu-btn')?.addEventListener('click', openMenu);
document.getElementById('menu-nav-item')?.addEventListener('click', e=>{ e.preventDefault(); openMenu(); });
document.getElementById('close-menu')?.addEventListener('click', closeMenu);
overlay?.addEventListener('click', closeMenu);

// Bottom nav
document.querySelectorAll('.nav-item').forEach(item=>{
    item.addEventListener('click', function(){ if(this.id!=='menu-nav-item'){ document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active')); this.classList.add('active'); } });
});

// Scroll animate
const checkScroll=()=>document.querySelectorAll('.scroll-animate').forEach(el=>{ if(el.getBoundingClientRect().top<=(window.innerHeight||document.documentElement.clientHeight)-80) el.classList.add('show'); });
window.addEventListener('scroll', checkScroll); checkScroll();
</script>
</body>
</html>