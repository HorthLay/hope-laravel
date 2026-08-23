{{-- resources/views/articles/show.blade.php --}}
@if(!empty($settings['maintenance_mode']) && $settings['maintenance_mode'])
@include('layouts.maintenance')
<?php exit; ?>
@endif
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $settings['site_name'] ?? 'Hope & Impact' }} | {{ $article->meta_title ?? $article->title }}</title>
    @if(!empty($settings['favicon']))<link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">@endif
    <meta name="description" content="{{ $article->meta_description ?? Str::limit(strip_tags($article->excerpt ?? $article->content ?? ''), 160) }}">
    @if($article->meta_keywords)<meta name="keywords" content="{{ $article->meta_keywords }}">@endif
    <meta property="og:title"       content="{{ $article->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($article->excerpt ?? ''), 160) }}">
    @if($article->image)<meta property="og:image" content="{{ $article->image->url }}">@endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
    <style>
        @keyframes scaleUp { 0%{opacity:0;transform:scale(0.95)} 100%{opacity:1;transform:scale(1)} }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
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
        .article-body .ql-align-center,.article-body p.ql-align-center,.article-body h1.ql-align-center,.article-body h2.ql-align-center,.article-body h3.ql-align-center,.article-body h4.ql-align-center,.article-body li.ql-align-center{text-align:center!important}
        .article-body .ql-align-right,.article-body p.ql-align-right,.article-body h1.ql-align-right,.article-body h2.ql-align-right,.article-body h3.ql-align-right,.article-body h4.ql-align-right,.article-body li.ql-align-right{text-align:right!important}
        .article-body .ql-align-justify,.article-body p.ql-align-justify,.article-body li.ql-align-justify{text-align:justify!important}
        .article-body .ql-indent-1{padding-left:3em!important}.article-body .ql-indent-2{padding-left:6em!important}.article-body .ql-indent-3{padding-left:9em!important}.article-body .ql-indent-4{padding-left:12em!important}
        .article-body .ql-size-small{font-size:.85em!important}.article-body .ql-size-large{font-size:1.5em!important}.article-body .ql-size-huge{font-size:2em!important}
    </style>
</head>
<body class="bg-gray-50">
@include('layouts.header')

{{-- BREADCRUMB --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-4 py-3">
        <nav class="flex items-center gap-2 text-sm text-gray-500 flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-orange-500 transition flex items-center gap-1"><i class="fas fa-home text-xs"></i> Home</a>
            <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            @if($article->category)
                <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                   class="hover:opacity-80 transition font-medium" style="color:{{ $article->category->color ?? '#f97316' }}">
                    @if($article->category->icon)<i class="{{ $article->category->icon }} text-xs mr-1"></i>@endif
                    {{ $article->category->name }}
                </a>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            @endif
            <span class="text-gray-700 line-clamp-1">{{ Str::limit($article->title, 55) }}</span>
        </nav>
    </div>
</div>

{{-- HERO IMAGE --}}
@if($article->image)
<div class="w-full bg-gray-900 overflow-hidden" style="max-height:480px">
    <img src="{{ $article->image->url }}" alt="{{ $article->title }}" class="w-full object-cover" style="max-height:480px;width:100%;object-position:center">
</div>
@endif

<div class="max-w-6xl mx-auto px-4 py-8 md:py-12">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

        {{-- ══ ARTICLE CONTENT ══ --}}
        <article class="flex-1 min-w-0">

            {{-- Badges --}}
            <div class="flex flex-wrap items-center gap-2 mb-4">
                @if($article->category)
                    <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                       class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold transition hover:opacity-80"
                       style="background-color:{{ $article->category->color ?? '#f97316' }}22;color:{{ $article->category->color ?? '#f97316' }};border:1px solid {{ $article->category->color ?? '#f97316' }}44;">
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
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-gray-900 mb-5 leading-tight">{{ $article->title }}</h1>

            {{-- Meta bar --}}
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pb-5 mb-6 border-b-2 border-orange-100">
                <span class="flex items-center gap-1 text-xs text-gray-500"><i class="fas fa-calendar-alt text-orange-400"></i>{{ $article->published_at?->format('F j, Y') }}</span>
                <span class="flex items-center gap-1 text-xs text-gray-500"><i class="fas fa-clock text-orange-400"></i>{{ $article->reading_time ?? max(1, ceil(str_word_count(strip_tags($article->content ?? '')) / 200)) }} min read</span>
                <span class="flex items-center gap-1 text-xs text-gray-500"><i class="fas fa-eye text-orange-400"></i>{{ number_format($article->views_count) }} views</span>
            </div>

            {{-- Excerpt lead --}}
            @if($article->excerpt)
            <div class="bg-orange-50 border-l-4 border-orange-400 rounded-r-xl px-5 py-4 mb-7">
                <p class="text-base md:text-lg text-gray-700 font-medium leading-relaxed">{{ strip_tags($article->excerpt) }}</p>
            </div>
            @endif

            {{-- Body --}}
            <div class="article-body">{!! $article->content !!}</div>

            {{-- ══ PROFILES IN THIS STORY ══ --}}
            @if($article->families->isNotEmpty() || $article->sponsoredChildren->isNotEmpty())
            <div class="mt-12 mb-8 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-400 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-black text-white flex items-center gap-2">
                        <i class="fas fa-users text-white/80"></i> Profiles in This Article
                    </h2>
                </div>
                <div class="p-6">
                    @if($article->families->isNotEmpty())
                        <div class="mb-2">
                            <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="fas fa-home text-orange-400"></i> Families
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                @foreach($article->families as $family)
                                    <div class="flex items-center gap-5 p-5 rounded-2xl border border-gray-100 bg-gray-50 hover:bg-orange-50 hover:border-orange-200 transition group shadow-sm hover:shadow-md">
                                        <button onclick="openProfileModal('family-modal-{{ $family->id }}')" class="w-24 h-24 rounded-xl overflow-hidden border border-gray-200 flex-shrink-0 bg-white relative cursor-pointer group/img">
                                            @if($family->profile_photo)
                                                <img src="{{ asset($family->profile_photo) }}" class="w-full h-full object-cover group-hover/img:scale-110 transition duration-300">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center"><i class="fas fa-home text-3xl text-gray-300"></i></div>
                                            @endif
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                                <i class="fas fa-search-plus text-white text-xl"></i>
                                            </div>
                                        </button>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-900 text-base leading-tight mb-1 truncate cursor-pointer hover:text-orange-500 transition" onclick="openProfileModal('family-modal-{{ $family->id }}')">{{ $family->name }} Family</h4>
                                            @if($family->code)<p class="text-xs font-bold text-gray-500 mb-2">CODE: {{ $family->code }}</p>@endif
                                            @if($family->country)
                                                <p class="text-sm font-medium text-gray-600 flex items-center gap-2">
                                                    <i class="fas fa-map-marker-alt text-orange-400"></i> {{ $family->country }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Family Modal --}}
                                    <div id="family-modal-{{ $family->id }}" class="fixed inset-0 bg-black/60 z-[9999] hidden items-center justify-center p-4 backdrop-blur-sm profile-modal" onclick="closeProfileModal('family-modal-{{ $family->id }}')">
                                        <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl relative" style="animation: scaleUp 0.3s ease;" onclick="event.stopPropagation()">
                                            <button class="absolute top-4 right-4 w-10 h-10 bg-black/10 hover:bg-black/20 text-gray-700 rounded-full flex items-center justify-center transition z-10" onclick="closeProfileModal('family-modal-{{ $family->id }}')">
                                                <i class="fas fa-times text-lg"></i>
                                            </button>
                                            
                                            <div class="flex flex-col sm:flex-row max-h-[85vh]">
                                                <div class="w-full sm:w-2/5 h-64 sm:h-auto relative">
                                                    @if($family->profile_photo)
                                                        <img src="{{ asset($family->profile_photo) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center bg-gray-100"><i class="fas fa-home text-6xl text-gray-300"></i></div>
                                                    @endif
                                                </div>
                                                <div class="w-full sm:w-3/5 p-8 flex flex-col overflow-hidden">
                                                    <div class="mb-4 flex-shrink-0">
                                                        <h3 class="font-black text-2xl text-gray-900 mb-1">{{ $family->name }} Family</h3>
                                                        @if($family->code)<p class="text-sm font-bold text-orange-500 tracking-wide uppercase">CODE: {{ $family->code }}</p>@endif
                                                    </div>
                                                    
                                                    <div class="flex items-center gap-4 mb-6 flex-shrink-0">
                                                        @if($family->members)
                                                            <div class="bg-gray-50 px-3 py-2 rounded-lg border border-gray-100 flex items-center gap-2">
                                                                <i class="fas fa-users text-orange-400"></i>
                                                                <span class="text-sm font-bold text-gray-700">{{ $family->members->count() }} Members</span>
                                                            </div>
                                                        @endif
                                                        @if(!empty($family->country))
                                                            <div class="bg-gray-50 px-3 py-2 rounded-lg border border-gray-100 flex items-center gap-2">
                                                                <i class="fas fa-map-marker-alt text-orange-400"></i>
                                                                <span class="text-sm font-bold text-gray-700">{{ $family->country }}</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if(!empty($family->story))
                                                        <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                                                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Their Story</h4>
                                                            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ strip_tags($family->story) }}</p>
                                                        </div>
                                                    @else
                                                        <div class="flex-1 flex items-center justify-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                                            <p class="text-gray-400 text-sm italic">No detailed story available yet.</p>
                                                        </div>
                                                    @endif
                                                    
                                                    <div class="mt-6 pt-4 border-t border-gray-100 flex-shrink-0">
                                                        <a href="{{ url('/support/donate') }}" class="w-full flex items-center justify-center gap-2 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition shadow-[0_4px_14px_rgba(249,115,22,0.3)] hover:shadow-[0_6px_20px_rgba(249,115,22,0.4)]">
                                                            <i class="fas fa-heart"></i> Sponsor {{ $family->name }} Family
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($article->families->isNotEmpty() && $article->sponsoredChildren->isNotEmpty())
                        <div class="h-px bg-gray-100 my-6"></div>
                    @endif

                    @if($article->sponsoredChildren->isNotEmpty())
                        <div>
                            <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="fas fa-child text-orange-400"></i> Children
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                @foreach($article->sponsoredChildren as $child)
                                    <div class="flex items-center gap-5 p-5 rounded-2xl border border-gray-100 bg-gray-50 hover:bg-orange-50 hover:border-orange-200 transition group shadow-sm hover:shadow-md">
                                        <button onclick="openProfileModal('child-modal-{{ $child->id }}')" class="w-24 h-24 rounded-xl overflow-hidden border border-gray-200 flex-shrink-0 bg-white relative cursor-pointer group/img">
                                            <img src="{{ $child->profile_photo ? asset($child->profile_photo) : asset('images/child-placeholder.jpg') }}" class="w-full h-full object-cover group-hover/img:scale-110 transition duration-300">
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                                <i class="fas fa-search-plus text-white text-xl"></i>
                                            </div>
                                        </button>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-900 text-base leading-tight mb-1 truncate cursor-pointer hover:text-orange-500 transition" onclick="openProfileModal('child-modal-{{ $child->id }}')">{{ $child->first_name }} {{ $child->last_name }}</h4>
                                            @if($child->code)<p class="text-xs font-bold text-gray-500 mb-2">CODE: {{ $child->code }}</p>@endif
                                            <p class="text-sm font-medium text-gray-600 flex items-center gap-3 mt-1">
                                                @if(!empty($child->age) || !empty($child->date_of_birth))
                                                    <span class="flex items-center gap-1.5"><i class="fas fa-birthday-cake text-orange-400"></i> {{ $child->age ?? \Carbon\Carbon::parse($child->date_of_birth)->age }} yrs</span>
                                                @endif
                                                @if(!empty($child->country))
                                                    <span class="flex items-center gap-1.5"><i class="fas fa-map-marker-alt text-orange-400"></i> {{ $child->country }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Child Modal --}}
                                    <div id="child-modal-{{ $child->id }}" class="fixed inset-0 bg-black/60 z-[9999] hidden items-center justify-center p-4 backdrop-blur-sm profile-modal" onclick="closeProfileModal('child-modal-{{ $child->id }}')">
                                        <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl relative" style="animation: scaleUp 0.3s ease;" onclick="event.stopPropagation()">
                                            <button class="absolute top-4 right-4 w-10 h-10 bg-black/10 hover:bg-black/20 text-gray-700 rounded-full flex items-center justify-center transition z-10" onclick="closeProfileModal('child-modal-{{ $child->id }}')">
                                                <i class="fas fa-times text-lg"></i>
                                            </button>
                                            
                                            <div class="flex flex-col sm:flex-row max-h-[85vh]">
                                                <div class="w-full sm:w-2/5 h-64 sm:h-auto relative">
                                                    <img src="{{ $child->profile_photo ? asset($child->profile_photo) : asset('images/child-placeholder.jpg') }}" class="w-full h-full object-cover">
                                                </div>
                                                <div class="w-full sm:w-3/5 p-8 flex flex-col overflow-hidden">
                                                    <div class="mb-4 flex-shrink-0">
                                                        <h3 class="font-black text-2xl text-gray-900 mb-1">{{ $child->first_name }} {{ $child->last_name }}</h3>
                                                        @if($child->code)<p class="text-sm font-bold text-orange-500 tracking-wide uppercase">CODE: {{ $child->code }}</p>@endif
                                                    </div>
                                                    
                                                    <div class="flex items-center gap-4 mb-6 flex-shrink-0">
                                                        @if(!empty($child->age) || !empty($child->date_of_birth))
                                                            <div class="bg-gray-50 px-3 py-2 rounded-lg border border-gray-100 flex items-center gap-2">
                                                                <i class="fas fa-birthday-cake text-orange-400"></i>
                                                                <span class="text-sm font-bold text-gray-700">{{ $child->age ?? \Carbon\Carbon::parse($child->date_of_birth)->age }} yrs</span>
                                                            </div>
                                                        @endif
                                                        @if(!empty($child->country))
                                                            <div class="bg-gray-50 px-3 py-2 rounded-lg border border-gray-100 flex items-center gap-2">
                                                                <i class="fas fa-map-marker-alt text-orange-400"></i>
                                                                <span class="text-sm font-bold text-gray-700">{{ $child->country }}</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if(!empty($child->story))
                                                        <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                                                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">My Story</h4>
                                                            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ strip_tags($child->story) }}</p>
                                                        </div>
                                                    @else
                                                        <div class="flex-1 flex items-center justify-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                                            <p class="text-gray-400 text-sm italic">No detailed story available yet.</p>
                                                        </div>
                                                    @endif
                                                    
                                                    <div class="mt-6 pt-4 border-t border-gray-100 flex-shrink-0">
                                                        <a href="{{ url('/support/donate') }}" class="w-full flex items-center justify-center gap-2 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition shadow-[0_4px_14px_rgba(249,115,22,0.3)] hover:shadow-[0_6px_20px_rgba(249,115,22,0.4)]">
                                                            <i class="fas fa-heart"></i> Sponsor {{ $child->first_name }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif
{{-- Share + Back --}}
<div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Share this story:</p>
        <div class="flex flex-wrap gap-2">

            {{-- Facebook — only if facebook_url is set in settings --}}
            @if(!empty($settings['facebook_url']))
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
               target="_blank" rel="noopener"
               class="flex items-center gap-2 px-4 py-2 bg-[#1877f2] hover:bg-[#166fe5] text-white text-xs font-bold rounded-lg transition">
                <i class="fab fa-facebook-f"></i> Facebook
            </a>
            @endif

            {{-- X / Twitter — only if twitter_url is set in settings --}}
            @if(!empty($settings['twitter_url']))
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->fullUrl()) }}"
               target="_blank" rel="noopener"
               class="flex items-center gap-2 px-4 py-2 bg-black hover:bg-gray-800 text-white text-xs font-bold rounded-lg transition">
                <i class="fab fa-x-twitter"></i> X
            </a>
            @endif

            {{-- WhatsApp — only if whatsapp_url is set in settings --}}
            @if(!empty($settings['whatsapp_url']))
            <a href="https://wa.me/?text={{ urlencode($article->title.' '.request()->fullUrl()) }}"
               target="_blank" rel="noopener"
               class="flex items-center gap-2 px-4 py-2 bg-[#25d366] hover:bg-[#22bf5c] text-white text-xs font-bold rounded-lg transition">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
            @endif

            {{-- Telegram — only if telegram_url is set in settings --}}
            @if(!empty($settings['telegram_url']))
            <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article->title) }}"
               target="_blank" rel="noopener"
               class="flex items-center gap-2 px-4 py-2 bg-[#0088cc] hover:bg-[#0077b5] text-white text-xs font-bold rounded-lg transition">
                <i class="fab fa-telegram"></i> Telegram
            </a>
            @endif

            {{-- LinkedIn — only if linkedin_url is set in settings --}}
            @if(!empty($settings['linkedin_url']))
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
               target="_blank" rel="noopener"
               class="flex items-center gap-2 px-4 py-2 bg-[#0a66c2] hover:bg-[#004182] text-white text-xs font-bold rounded-lg transition">
                <i class="fab fa-linkedin-in"></i> LinkedIn
            </a>
            @endif

            {{-- Copy link — always shown --}}
            <button id="copyBtn"
                    onclick="navigator.clipboard.writeText(window.location.href).then(()=>{
                        document.getElementById('copyBtn').innerHTML='<i class=\'fas fa-check\'></i> Copied!';
                        setTimeout(()=>document.getElementById('copyBtn').innerHTML='<i class=\'fas fa-link\'></i> Copy',2000)
                    })"
                    class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition">
                <i class="fas fa-link"></i> Copy
            </button>

        </div>
    </div>
    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2 text-sm text-orange-500 hover:text-orange-600 font-semibold transition">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>
</div>

            {{-- Prev / Next --}}
            @if($prevArticle || $nextArticle)
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                @if($prevArticle)
                    <a href="{{ route('articles.show', $prevArticle->encrypted_slug) }}"
                       class="group flex items-center gap-3 p-4 bg-white rounded-xl border-2 border-gray-100 hover:border-orange-300 hover:shadow-md transition h-full">
                        <div class="w-10 h-10 rounded-full bg-orange-50 group-hover:bg-orange-100 flex items-center justify-center flex-shrink-0 transition">
                            <i class="fas fa-arrow-left text-orange-500 text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 font-medium mb-1">← Previous</p>
                            <p class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition line-clamp-2 leading-snug">{{ $prevArticle->title }}</p>
                            @if($prevArticle->category)<span class="text-xs font-semibold mt-1 block" style="color:{{ $prevArticle->category->color ?? '#f97316' }}">{{ $prevArticle->category->name }}</span>@endif
                        </div>
                    </a>
                @endif
                </div>
                <div>
                @if($nextArticle)
                    <a href="{{ route('articles.show', $nextArticle->encrypted_slug) }}"
                       class="group flex items-center gap-3 p-4 bg-white rounded-xl border-2 border-gray-100 hover:border-orange-300 hover:shadow-md transition text-right justify-end h-full">
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 font-medium mb-1">Next →</p>
                            <p class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition line-clamp-2 leading-snug">{{ $nextArticle->title }}</p>
                            @if($nextArticle->category)<span class="text-xs font-semibold mt-1 block" style="color:{{ $nextArticle->category->color ?? '#f97316' }}">{{ $nextArticle->category->name }}</span>@endif
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

        {{-- ══ SIDEBAR ══ --}}
        <aside class="w-full lg:w-80 flex-shrink-0 space-y-6">

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
                        @if($article->category->description)<p class="text-xs text-gray-500 line-clamp-1">{{ $article->category->description }}</p>@endif
                    </div>
                    <i class="fas fa-arrow-right text-xs flex-shrink-0" style="color:{{ $article->category->color ?? '#f97316' }}"></i>
                </a>
            </div>
            @endif

            @if($article->sponsoredChildren->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-50 to-white px-5 py-3 border-b border-orange-100">
                    <p class="text-xs font-black text-orange-600 uppercase tracking-wide flex items-center gap-1.5">
                        <i class="fas fa-child"></i> Children in This Article
                        <span class="ml-auto bg-orange-100 text-orange-600 text-[10px] font-black px-2 py-0.5 rounded-full">{{ $article->sponsoredChildren->count() }}</span>
                    </p>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($article->sponsoredChildren as $child)
                    @php $cEncId = \Illuminate\Support\Facades\Crypt::encryptString((string)$child->id); @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 border-2 border-orange-100">
                            <img src="{{ $child->profile_photo ? asset($child->profile_photo) : asset('images/child-placeholder.jpg') }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800 truncate">{{ $child->first_name }}</p>
                            <p class="text-xs text-black-400">{{ $child->code }}</p>
                            @if(!empty($child->age))<p class="text-xs text-gray-400">{{ $child->age }} yrs · {{ $child->country ?? '' }}</p>@endif
                            @if($child->has_family !== null)
                            <span class="text-xs font-bold flex items-center gap-1 {{ $child->has_family ? 'text-green-500' : 'text-red-500' }}">
                                <i class="fas fa-home text-[10px] {{ $child->has_family ? 'text-green-300' : 'text-red-300' }}"></i>
                                {{ $child->has_family ? 'Has Family' : 'No Family' }}
                            </span>
                            @endif
                        </div>
                        {{-- <div class="flex flex-col gap-1">
                            <a href="{{ route('children.show', $cEncId) }}" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 text-[10px] font-black rounded-lg transition text-center">Detail</a>
                            <a href="{{ url('/support/donate') }}" class="px-2.5 py-1 bg-orange-500 hover:bg-orange-600 text-white text-[10px] font-black rounded-lg transition text-center">Sponsor</a>
                        </div> --}}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($article->families->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-50 to-white px-5 py-3 border-b border-orange-100">
                    <p class="text-xs font-black text-orange-600 uppercase tracking-wide flex items-center gap-1.5">
                        <i class="fas fa-home"></i> Families in This Article
                        <span class="ml-auto bg-orange-100 text-orange-600 text-[10px] font-black px-2 py-0.5 rounded-full">{{ $article->families->count() }}</span>
                    </p>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($article->families as $family)
                    @php $fEncId = \Illuminate\Support\Facades\Crypt::encryptString((string)$family->id); @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 border-2 border-orange-100 bg-orange-50 flex items-center justify-center">
                            @if($family->profile_photo)<img src="{{ asset($family->profile_photo) }}" class="w-full h-full object-cover">
                            @else<i class="fas fa-home text-orange-300"></i>@endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800 truncate">{{ $family->name }}</p>
                            <p class="text-xs text-black-400">{{ $family->code }}</p>
                            @if($family->country)<p class="text-xs text-gray-400">{{ $family->country }}</p>@endif
                        </div>
                        {{-- <div class="flex flex-col gap-1">
                            <a href="{{ route('families.show', $fEncId) }}" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 text-[10px] font-black rounded-lg transition text-center">Detail</a>
                            <a href="{{ url('/support/donate') }}" class="px-2.5 py-1 bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-black rounded-lg transition text-center">Sponsor</a>
                        </div> --}}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($related->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Related Articles</p>
                <div class="space-y-3">
                    @foreach($related as $rel)
                    <a href="{{ route('articles.show', $rel->encrypted_slug) }}" class="flex gap-3 group p-2 -mx-2 rounded-xl hover:bg-orange-50 transition">
                        <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                            @if($rel->image)<img src="{{ $rel->image->url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else<div class="w-full h-full flex items-center justify-center"><i class="fas fa-newspaper text-orange-300 text-xl"></i></div>@endif
                        </div>
                        <div class="flex-1 min-w-0">
                            @if($rel->category)<span class="text-xs font-bold block mb-1 leading-none" style="color:{{ $rel->category->color ?? '#f97316' }}">{{ $rel->category->name }}</span>@endif
                            <p class="text-xs font-semibold text-gray-800 line-clamp-2 group-hover:text-orange-600 transition leading-snug">{{ $rel->title }}</p>
                            <p class="text-xs text-gray-400 mt-1"><i class="fas fa-eye mr-1"></i>{{ number_format($rel->views_count) }} · {{ $rel->published_at?->format('M d') }}</p>
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
                    <h3 class="font-black text-lg mb-1">Sponsor a Child or Family</h3>
                    <p class="text-sm text-white/90 mb-4 leading-relaxed">Change a life for just $1 a day. Education, meals, and hope.</p>
                    <a href="{{ route('sponsor.children') }}" class="block w-full bg-white text-orange-600 font-bold text-sm py-3 rounded-xl hover:bg-orange-50 transition shadow">
                        Sponsor Now <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

        </aside>
    </div>
</div>

{{-- More from this category --}}
@if($related->isNotEmpty())
<section class="bg-gray-50 py-12 mt-4">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">
                    More from
                    @if($article->category)<span style="color:{{ $article->category->color ?? '#f97316' }}">{{ $article->category->name }}</span>
                    @else Hope & Impact @endif
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
                    @if($rel->image)<img src="{{ $rel->image->url }}" class="w-full h-44 object-cover group-hover:scale-110 transition-transform duration-500">
                    @else<div class="w-full h-44 flex items-center justify-center" style="background-color:{{ $article->category->color ?? '#f97316' }}10;"><i class="fas fa-newspaper text-4xl opacity-20" style="color:{{ $article->category->color ?? '#f97316' }}"></i></div>@endif
                </div>
                <div class="p-4">
                    @if($rel->category)
                    <a href="{{ route('category.articles', $rel->category->encrypted_slug) }}" class="text-xs font-bold mb-2 block hover:underline" style="color:{{ $rel->category->color ?? '#f97316' }}">
                        @if($rel->category->icon)<i class="{{ $rel->category->icon }} mr-1 text-xs"></i>@endif{{ $rel->category->name }}
                    </a>
                    @endif
                    <h3 class="text-sm font-bold text-gray-800 line-clamp-2 mb-2 group-hover:text-orange-500 transition leading-snug">{{ $rel->title }}</h3>
                    @if($rel->excerpt)<p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ Str::limit(strip_tags($rel->excerpt), 80) }}</p>@endif
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <a href="{{ route('articles.show', $rel->encrypted_slug) }}" class="text-xs font-bold flex items-center gap-1 hover:gap-2 transition-all" style="color:{{ $rel->category->color ?? '#f97316' }}">
                            Read More <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                        <span class="text-xs text-gray-400"><i class="fas fa-eye mr-1"></i>{{ number_format($rel->views_count) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<div id="lightbox" class="fixed inset-0 bg-black/90 z-[9999] hidden items-center justify-center p-4" onclick="closeLightbox()">
    <button class="absolute top-4 right-4 text-white text-3xl hover:text-orange-400 transition" onclick="closeLightbox()"><i class="fas fa-times"></i></button>
    <img id="lightbox-img" src="" alt="" class="max-w-full max-h-full rounded-xl shadow-2xl">
</div>

@include('layouts.footer')
@include('layouts.navigation')

<script>
function openProfileModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeProfileModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = '';
}
function openLightbox(src){const lb=document.getElementById('lightbox');lb.style.display='flex';document.getElementById('lightbox-img').src=src;document.body.style.overflow='hidden';}
function closeLightbox(){document.getElementById('lightbox').style.display='none';document.body.style.overflow='';}
document.addEventListener('keydown',e=>{
    if(e.key==='Escape'){
        closeLightbox();
        document.querySelectorAll('.profile-modal').forEach(m => { m.style.display = 'none'; });
        document.body.style.overflow = '';
    }
});
const mobileMenu=document.getElementById('mobile-menu'),overlay=document.getElementById('mobile-menu-overlay');
const openMenu=()=>{mobileMenu?.classList.add('active');overlay?.classList.add('active');document.body.style.overflow='hidden';};
const closeMenu=()=>{mobileMenu?.classList.remove('active');overlay?.classList.remove('active');document.body.style.overflow='';};
document.getElementById('mobile-menu-btn')?.addEventListener('click',openMenu);
document.getElementById('menu-nav-item')?.addEventListener('click',e=>{e.preventDefault();openMenu();});
document.getElementById('close-menu')?.addEventListener('click',closeMenu);
overlay?.addEventListener('click',closeMenu);
document.querySelectorAll('.nav-item').forEach(item=>{item.addEventListener('click',function(){if(this.id!=='menu-nav-item'){document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active'));this.classList.add('active');}});});
const checkScroll=()=>document.querySelectorAll('.scroll-animate').forEach(el=>{if(el.getBoundingClientRect().top<=(window.innerHeight||document.documentElement.clientHeight)-80)el.classList.add('show');});
window.addEventListener('scroll',checkScroll);checkScroll();
</script>
</body>
</html>