{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Hope & Impact | Changing Children's Lives</title>
    <meta name="description" content="Help transform children's lives through education, healthcare, and nutrition in Southeast Asia.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
    <style>
    /* Tag filter buttons */
    .news-tag-btn, .top-tag-btn {
        transition: all .18s ease;
    }
    .news-tag-btn.opacity-60, .top-tag-btn.opacity-60 {
        opacity: .55;
    }
    .news-tag-btn.active-tag-btn,
    .top-tag-btn.active-tag-btn {
        background: #f97316 !important;
        color: #fff !important;
        border-color: #f97316 !important;
        opacity: 1 !important;
        box-shadow: 0 2px 10px rgba(249,115,22,.35);
    }
    /* Smooth hide/show for filtered cards */
    .news-card, .top-card {
        transition: opacity .2s ease;
    }
    /* Category filter buttons */
    .news-cat-btn { transition: all .18s ease; }
    .news-cat-btn.opacity-60 { opacity: .55; }
    .news-cat-btn.active-cat-btn {
        background: #f97316 !important;
        color: #fff !important;
        border-color: #f97316 !important;
        opacity: 1 !important;
        box-shadow: 0 2px 10px rgba(249,115,22,.35);
    }
    </style>
</head>
<body>

@include('layouts.loading')
@include('layouts.header')

{{-- ═══════ HERO ═══════ --}}
<section id="home" class="hero-section">
    <video autoplay muted loop playsinline class="hero-video">
        <source src="{{ asset('project/videos/video.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fade-in-down">
                Sponsor a Child Today
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl mb-10 opacity-95 animate-fade-in-up delay-200">
                And change a life with the gift of education
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up delay-400">
                <a href="#sponsor" class="btn-primary text-lg">Sponsor a Child Now</a>
                <a href="{{ route('learn-more') }}" class="btn-secondary text-lg">Learn More</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════ STATS ═══════ --}}
<section class="stats-section scroll-animate">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Impact Since 1958</h2>
            <p class="text-lg opacity-90">Transparency and efficiency in action</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            <div class="text-center"><div class="stat-number counter" data-target="95000">0</div><p class="text-base md:text-lg font-medium">Children Helped</p></div>
            <div class="text-center"><div class="stat-number counter" data-target="84">0</div><p class="text-base md:text-lg font-medium">% To Programs</p></div>
            <div class="text-center"><div class="stat-number counter" data-target="7">0</div><p class="text-base md:text-lg font-medium">Countries</p></div>
            <div class="text-center"><div class="stat-number counter" data-target="{{ $stats['total_articles'] ?? 1000 }}">0</div><p class="text-base md:text-lg font-medium">Articles Published</p></div>
        </div>
    </div>
</section>

{{-- ═══════ CATEGORY NAV BAR ═══════ --}}
@if($categories->isNotEmpty())
<section class="bg-white border-b border-gray-100 py-3 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-2 overflow-x-auto scrollbar-hide">
            <a href="{{ route('home') }}" class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-bold bg-orange-500 text-white hover:bg-orange-600 transition">All</a>
            @foreach($categories as $cat)
                <a href="{{ route('category.articles', $cat->encrypted_slug) }}"
                   class="flex-shrink-0 flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold border-2 transition whitespace-nowrap"
                   style="border-color:{{ $cat->color ?? '#f97316' }};color:{{ $cat->color ?? '#f97316' }};"
                   onmouseover="this.style.backgroundColor=this.style.borderColor;this.style.color='#fff';"
                   onmouseout="this.style.backgroundColor='';this.style.color=this.style.borderColor;">
                    @if($cat->icon)<i class="{{ $cat->icon }} text-xs"></i>@endif
                    {{ $cat->name }}
                    @if($cat->articles_count)<span class="opacity-60">({{ $cat->articles_count }})</span>@endif
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════ WHY CHOOSE US ═══════ --}}
<section class="section">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-8 md:mb-12 scroll-animate">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Why Choose Us</h2>
            <p class="text-base md:text-lg text-gray-600 max-w-3xl mx-auto">Trusted by thousands of donors worldwide for our transparency and commitment</p>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach([
                ['icon'=>'fas fa-shield-alt','bg'=>'orange','label'=>'100% Transparent','desc'=>'Full accountability on how your donations are used'],
                ['icon'=>'fas fa-certificate','bg'=>'blue','label'=>'Certified NGO','desc'=>'Internationally recognized and accredited organization'],
                ['icon'=>'fas fa-hand-holding-heart','bg'=>'green','label'=>'Direct Impact','desc'=>'Your support directly reaches children in need'],
                ['icon'=>'fas fa-users','bg'=>'purple','label'=>'Strong Network','desc'=>'1000+ local volunteers ensuring quality programs'],
            ] as $i => $h)
            <div class="bg-white rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all scroll-animate text-center" style="animation-delay:{{ $i*0.1 }}s">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-{{ $h['bg'] }}-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <i class="{{ $h['icon'] }} text-{{ $h['bg'] }}-600 text-xl md:text-3xl"></i>
                </div>
                <h3 class="text-sm md:text-lg font-bold text-gray-800 mb-2">{{ $h['label'] }}</h3>
                <p class="text-xs md:text-sm text-gray-600">{{ $h['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 mt-4 md:mt-6">
            @foreach([
                ['bg'=>'orange','icon'=>'fas fa-envelope','label'=>'Monthly Updates','desc'=>'Receive letters and photos from your sponsored child'],
                ['bg'=>'blue','icon'=>'fas fa-globe','label'=>'Global Reach','desc'=>'Operating in 7 countries across Southeast Asia'],
                ['bg'=>'green','icon'=>'fas fa-heart','label'=>'Long-term Support','desc'=>"Follow children's progress throughout their education",'span'=>true],
            ] as $i => $e)
            <div class="bg-gradient-to-br from-{{ $e['bg'] }}-50 to-{{ $e['bg'] }}-100 rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all scroll-animate {{ isset($e['span']) ? 'col-span-2 md:col-span-1':'' }}" style="animation-delay:{{ (4+$i)*0.1 }}s">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-{{ $e['bg'] }}-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="{{ $e['icon'] }} text-white text-sm md:text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm md:text-base font-bold text-gray-800 mb-1">{{ $e['label'] }}</h4>
                        <p class="text-xs md:text-sm text-gray-600">{{ $e['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ TRANSPARENCY ═══════ --}}
<section class="section bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 md:mb-12 scroll-animate">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Transparency and Efficiency of Our Action</h2>
            <div class="green-line"></div>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            @foreach([
                ['img'=>'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600','overlay'=>'1958','title'=>'66 years of experience','desc'=>'With its wealth of experience, Children of Mekong has relied since 1958 on a network of friends made up of more than 1,000 local volunteers.','btn'=>'OUR HISTORY'],
                ['img'=>'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=600','overlay'=>'MISSION','title'=>'Providing education and support','desc'=>'Educate, train, and support young people so that they can improve their material living conditions and build themselves intellectually.','btn'=>'VISION AND ETHICS'],
                ['img'=>'https://images.unsplash.com/photo-1544027993-37dbfe43562a?w=600','overlay'=>'84%','title'=>'Charitable Expenditure','desc'=>'84% of the funds raised are dedicated to our education programmes. In Asia, over 95,000 children benefit from our work every year.','btn'=>'ANNUAL REPORT'],
                ['img'=>'https://images.unsplash.com/photo-1497486751825-1233686d5d80?w=600','overlay'=>'IDEAS','title'=>'Label renewed in 2024','desc'=>'Children of the Mekong was awarded the IDEAS label for good governance, transparency, and monitoring of the effectiveness of its actions.','btn'=>'TRANSPARENCY'],
            ] as $i => $card)
            <div class="card scroll-animate" style="animation-delay:{{ $i*0.1 }}s">
                <div class="relative overflow-hidden">
                    <img src="{{ $card['img'] }}" alt="{{ $card['title'] }}" class="w-full h-64 object-cover">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                        <h3 class="text-5xl md:text-6xl font-black text-white text-center px-2">{{ $card['overlay'] }}</h3>
                    </div>
                </div>
                <div class="p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-3">{{ $card['title'] }}</h4>
                    <p class="text-sm text-gray-600 mb-6">{{ $card['desc'] }}</p>
                    <a href="{{ route('learn-more') }}" class="inline-block px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold text-sm rounded transition">{{ $card['btn'] }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ LATEST NEWS — DB articles, each rendered with its own saved style ═══════ --}}
{{-- ═══════ LATEST NEWS — top categories filter ═══════ --}}
<section id="news" class="section bg-white">
    <div class="max-w-7xl mx-auto">

        <div class="mb-3 scroll-animate">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Latest News from Southeast Asia</h2>
            <div class="green-line"></div>
        </div>

        {{-- Category filter bar --}}
        @if($categories->isNotEmpty())
        <div class="flex flex-wrap items-center gap-2 mb-7 scroll-animate" id="news-cat-filters">
            <button type="button" onclick="filterNewsCat('all', this)"
                    class="news-cat-btn active-cat-btn px-3 py-1.5 rounded-full text-xs font-bold bg-orange-500 text-white transition-all">
                <i class="fas fa-border-all text-[10px] mr-0.5"></i> All
            </button>
            @foreach($categories as $cat)
            <button type="button" onclick="filterNewsCat({{ $cat->id }}, this)"
                    class="news-cat-btn px-3 py-1.5 rounded-full text-xs font-bold border-2 transition-all whitespace-nowrap"
                    data-cat-id="{{ $cat->id }}"
                    style="border-color:{{ $cat->color ?? '#f97316' }};color:{{ $cat->color ?? '#f97316' }};">
                @if($cat->icon)<i class="{{ $cat->icon }} text-xs mr-0.5"></i>@endif
                {{ $cat->name }}
                @if($cat->articles_count)<span class="opacity-60">({{ $cat->articles_count }})</span>@endif
            </button>
            @endforeach
        </div>
        @endif

        @if($articles->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5" id="news-grid">

                {{-- First article: featured hero --}}
                <div class="md:col-span-2 lg:row-span-2 scroll-animate news-card"
                     data-cat-id="{{ $articles->first()->category_id }}">
                    @include('articles.styles.home.featured', ['article' => $articles->first()])
                </div>

                @foreach($articles->skip(1) as $article)
                    @php
                        $st = in_array($article->style, ['overlay','card','magazine','featured','minimal'])
                            ? $article->style : 'overlay';
                    @endphp
                    <div class="scroll-animate news-card" data-cat-id="{{ $article->category_id }}">
                        @include('articles.styles.home.' . $st, ['article' => $article])
                    </div>
                @endforeach
            </div>

            <div id="news-no-results" class="hidden py-12 text-center">
                <div class="w-16 h-16 rounded-full bg-orange-50 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-folder-open text-2xl text-orange-300"></i>
                </div>
                <p class="text-gray-500 text-sm font-medium">No articles in this category yet.</p>
                <button type="button" onclick="filterNewsCat('all', document.querySelector('.news-cat-btn'))"
                        class="mt-3 text-xs font-bold text-orange-500 hover:underline">Show all articles</button>
            </div>

            @if($categories->isNotEmpty())
            <div class="text-center mt-8 scroll-animate">
                <a href="{{ route('category.articles', $categories->first()->encrypted_slug) }}"
                   class="inline-flex items-center gap-2 px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-full transition shadow-md hover:shadow-lg">
                    <i class="fas fa-newspaper"></i> View All Articles <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif

        @else
            <div class="py-16 flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-newspaper text-3xl text-orange-300"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-700 mb-2">No Articles Yet</h3>
                <p class="text-gray-500 text-sm mb-6 max-w-sm">Stories are being prepared. Sponsor a child today.</p>
                <a href="{{ route('detail') }}" class="btn-primary">Sponsor a Child Now</a>
            </div>
        @endif
    </div>
</section>

{{-- ═══════ PER-CATEGORY SECTIONS — each article uses its own saved style ═══════ --}}
@foreach($categories->take(3) as $cat)
    @if(isset($categoryArticles[$cat->id]) && $categoryArticles[$cat->id]->isNotEmpty())
    <section class="section {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
        <div class="max-w-7xl mx-auto">
            {{-- Category header --}}
            <div class="flex items-center justify-between mb-7 scroll-animate">
                <div>
                    <div class="flex items-center gap-3 mb-1.5">
                        @if($cat->icon)
                            <div class="w-9 h-9 rounded-full flex items-center justify-center" style="background:{{ $cat->color ?? '#f97316' }}22">
                                <i class="{{ $cat->icon }}" style="color:{{ $cat->color ?? '#f97316' }}"></i>
                            </div>
                        @endif
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $cat->name }}</h2>
                    </div>
                    <div class="h-1 w-14 rounded-full" style="background:{{ $cat->color ?? '#f97316' }}"></div>
                </div>
                <a href="{{ route('category.articles', $cat->encrypted_slug) }}"
                   class="flex-shrink-0 text-sm font-semibold flex items-center gap-1 hover:gap-2 transition-all"
                   style="color:{{ $cat->color ?? '#f97316' }}">
                    See All <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            {{-- Articles — each uses its own saved style, fallback = card --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
                @foreach($categoryArticles[$cat->id] as $article)
                    @php
                        $st = in_array($article->style, ['overlay','card','magazine','featured','minimal'])
                            ? $article->style : 'card';
                    @endphp
                    <div class="scroll-animate" style="animation-delay:{{ $loop->index * 0.08 }}s">
                        @include('articles.styles.home.' . $st, ['article' => $article])
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endforeach

{{-- ═══════ TOP ARTICLES — ranked by views, tag filter ═══════ --}}
@if($articles->isNotEmpty())
@php
    $topTags = $articles->sortByDesc('views_count')->take(6)
        ->flatMap(fn($a) => $a->tags ?? collect())->unique('id')->values();
@endphp
<section class="section bg-white">
    <div class="max-w-7xl mx-auto">
        {{-- Heading --}}
        <div class="mb-3 scroll-animate">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Most Read Stories</h2>
            <div class="green-line"></div>
        </div>

        {{-- Tag filter bar --}}
        @if($topTags->isNotEmpty())
        <div class="flex flex-wrap items-center gap-2 mb-7 scroll-animate" id="top-tag-filters">
            <button type="button"
                    onclick="filterTopTag('all', this)"
                    class="top-tag-btn active-tag-btn px-3 py-1.5 rounded-full text-xs font-bold bg-orange-500 text-white transition-all">
                <i class="fas fa-border-all text-[10px] mr-0.5"></i> All
            </button>
            @foreach($topTags as $tag)
            <button type="button"
                    onclick="filterTopTag({{ $tag->id }}, this)"
                    class="top-tag-btn px-3 py-1.5 rounded-full text-xs font-bold border transition-all"
                    data-tag-id="{{ $tag->id }}"
                    style="{{ $tag->badge_style }}; border-color:currentColor;">
                {{ $tag->name }}
            </button>
            @endforeach
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="top-grid">
            @foreach($articles->sortByDesc('views_count')->take(6) as $i => $article)
            <div class="top-card flex gap-3 p-3 bg-gray-50 rounded-xl hover:shadow-md transition group scroll-animate"
                 data-tag-ids="{{ $article->tags->pluck('id')->join(',') }}"
                 style="animation-delay:{{ $i*0.1 }}s">
                {{-- Rank --}}
                <div class="flex-shrink-0 w-9 h-9 rounded-full flex items-center justify-center font-black text-base
                    {{ $i===0?'bg-orange-500 text-white':($i===1?'bg-orange-200 text-orange-700':'bg-gray-200 text-gray-600') }}">
                    {{ $i + 1 }}
                </div>
                {{-- Thumbnail --}}
                <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                    @if($article->image)
                        <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background:{{ $article->category->color ?? '#f97316' }}15">
                            <i class="{{ $article->category->icon ?? 'fas fa-newspaper' }} text-xl opacity-30" style="color:{{ $article->category->color ?? '#f97316' }}"></i>
                        </div>
                    @endif
                </div>
                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    @if($article->category)
                        <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                           class="text-[10px] font-semibold hover:underline block" style="color:{{ $article->category->color ?? '#f97316' }}">
                            {{ $article->category->name }}
                        </a>
                    @endif
                    @if($article->relationLoaded('tags') && $article->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-1 mt-0.5">
                            @foreach($article->tags->take(2) as $tag)
                                <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    <h4 class="text-xs font-bold text-gray-800 line-clamp-2 mt-0.5 group-hover:text-orange-500 transition">
                        <a href="{{ route('articles.show', $article->encrypted_slug) }}">{{ $article->title }}</a>
                    </h4>
                    <p class="text-[10px] text-gray-500 mt-1">
                        <i class="fas fa-eye mr-0.5"></i>{{ number_format($article->views_count) }} views
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- No-results placeholder --}}
        <div id="top-no-results" class="hidden py-12 text-center">
            <div class="w-16 h-16 rounded-full bg-orange-50 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-tag text-2xl text-orange-300"></i>
            </div>
            <p class="text-gray-500 text-sm font-medium">No articles found for this tag.</p>
            <button type="button" onclick="filterTopTag('all', document.querySelector('.top-tag-btn'))"
                    class="mt-3 text-xs font-bold text-orange-500 hover:underline">
                Show all stories
            </button>
        </div>
    </div>
</section>
@endif

{{-- ═══════ SUCCESS STORY — featured article from DB ═══════ --}}
<section class="section bg-gradient-to-br from-orange-50 to-orange-100">
    <div class="max-w-7xl mx-auto">
        @if($successStory)
        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
            <div class="img-hover rounded-2xl overflow-hidden shadow-xl scroll-animate">
                @if($successStory->image)
                    <img src="{{ $successStory->image->url }}" alt="{{ $successStory->title }}" class="w-full h-64 md:h-full object-cover">
                @else
                    <div class="w-full h-64 md:h-96 flex items-center justify-center" style="background:{{ $successStory->category->color ?? '#f97316' }}15">
                        <i class="{{ $successStory->category->icon ?? 'fas fa-star' }} text-8xl opacity-20" style="color:{{ $successStory->category->color ?? '#f97316' }}"></i>
                    </div>
                @endif
            </div>
            <div class="scroll-animate" style="animation-delay:0.2s">
                <span class="inline-block bg-orange-500 text-white text-xs font-semibold px-4 py-2 rounded-full mb-4">SUCCESS STORY</span>
                @if($successStory->category)
                    <a href="{{ route('category.articles', $successStory->category->encrypted_slug) }}"
                       class="block text-sm font-semibold mb-2 hover:underline" style="color:{{ $successStory->category->color ?? '#f97316' }}">
                        @if($successStory->category->icon)<i class="{{ $successStory->category->icon }} mr-1"></i>@endif{{ $successStory->category->name }}
                    </a>
                @endif
                {{-- Tags with badge styles from Tag model --}}
                @if($successStory->relationLoaded('tags') && $successStory->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($successStory->tags as $tag)
                            <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4 md:mb-6">{{ $successStory->title }}</h2>
                <p class="text-base md:text-lg text-gray-700 mb-6 leading-relaxed">
                    {{ Str::limit(strip_tags($successStory->excerpt ?? $successStory->content ?? ''), 220) }}
                </p>
                <a href="{{ route('articles.show', $successStory->encrypted_slug) }}" class="btn-primary">Read Full Story</a>
            </div>
        </div>
        @else
        <div class="text-center py-12 scroll-animate">
            <span class="inline-block bg-orange-500 text-white text-xs font-semibold px-4 py-2 rounded-full mb-4">SUCCESS STORY</span>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">From Dropout to Top Student</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-6 leading-relaxed">"At age 8, I had never been to school. Today, I'm top of my class and dream of becoming a doctor. Your support changed my life forever!"</p>
            <a href="{{ route('learn-more') }}" class="btn-primary">Read More Stories</a>
        </div>
        @endif
    </div>
</section>

{{-- ═══════ YOUTUBE / VIDEO ARTICLES — articles with video_url, auto-embedded ═══════ --}}
{{-- ═══════ YOUTUBE / VIDEO ARTICLES — articles with video_url, auto-embedded ═══════ --}}
@if($videoArticles->isNotEmpty())
<section id="videos" class="section bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 md:mb-10 scroll-animate">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Watch Our Impact Stories</h2>
            <div class="green-line"></div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($videoArticles as $article)
                {{-- Real DB article with video_url --}}
                <div class="group scroll-animate">
                    <div class="relative overflow-hidden rounded-xl shadow-lg mb-4">
                        <div class="aspect-video">
                            <iframe class="w-full h-full"
                                    src="{{ $article->embed_url }}"
                                    title="{{ $article->title }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                        @if($article->category)
                            <a href=""
                               class="text-xs font-bold hover:underline flex items-center gap-1"
                               style="color:{{ $article->category->color ?? '#f97316' }}">
                                @if($article->category->icon)<i class="{{ $article->category->icon }} text-xs"></i>@endif{{ $article->category->name }}
                            </a>
                        @endif
                        @if($article->relationLoaded('tags') && $article->tags->isNotEmpty())
                            @foreach($article->tags->take(2) as $tag)
                                <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">{{ $tag->name }}</span>
                            @endforeach
                        @endif
                    </div>
                    <h4 class="font-bold text-gray-800 mb-1 group-hover:text-orange-500 transition leading-snug">
                        <a href="{{ route('articles.show', $article->encrypted_slug) }}">{{ $article->title }}</a>
                    </h4>
                    @if($article->excerpt)
                        <p class="text-sm text-gray-600 line-clamp-2 mb-2">{{ Str::limit(strip_tags($article->excerpt), 100) }}</p>
                    @endif
                    <div class="flex items-center gap-3 text-xs text-gray-400">
                        <span><i class="fas fa-eye mr-0.5"></i>{{ number_format($article->views_count) }}</span>
                        <span>{{ $article->published_at?->format('M d, Y') }}</span>
                        <a href="{{ route('articles.show', $article->encrypted_slug) }}"
                           class="ml-auto font-semibold text-orange-500 hover:text-orange-600 flex items-center gap-1">
                            Read More <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════ MOST VIEWED — article loop with Sponsor Now ═══════ --}}
<section id="sponsor" class="section bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-10 scroll-animate">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Children Waiting to be Sponsored</h2>
            <p class="text-base md:text-lg text-gray-600">Our most-read stories — meet the children who need your support</p>
        </div>

        @php $sponsorArticles = $articles->sortByDesc('views_count')->take(3); @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse($sponsorArticles as $i => $article)
            <div class="card scroll-animate {{ $loop->last && $loop->count < 3 ? 'sm:col-span-2 lg:col-span-1' : '' }}"
                 style="animation-delay:{{ $i*0.15 }}s">

                {{-- Image --}}
                <div class="img-hover overflow-hidden relative">
                    @if($article->image)
                        <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
                             class="w-full h-52 md:h-64 object-cover">
                    @else
                        <div class="w-full h-52 md:h-64 flex items-center justify-center"
                             style="background:linear-gradient(135deg,{{ $article->category->color ?? '#f97316' }}22,{{ $article->category->color ?? '#f97316' }}08)">
                            <i class="{{ $article->category->icon ?? 'fas fa-newspaper' }} text-6xl opacity-20"
                               style="color:{{ $article->category->color ?? '#f97316' }}"></i>
                        </div>
                    @endif
                    {{-- Views badge --}}
                    <div class="absolute top-3 right-3 flex items-center gap-1 bg-black/60 text-white text-xs font-bold px-2 py-1 rounded-full">
                        <i class="fas fa-eye text-[10px]"></i> {{ number_format($article->views_count) }}
                    </div>
                    {{-- Rank badge --}}
                    <div class="absolute top-3 left-3 w-8 h-8 rounded-full flex items-center justify-center font-black text-sm
                        {{ $i===0?'bg-orange-500 text-white':($i===1?'bg-orange-200 text-orange-700':'bg-white text-gray-700') }} shadow">
                        #{{ $i + 1 }}
                    </div>
                </div>

                <div class="p-4 md:p-5">
                    {{-- Category --}}
                    @if($article->category && $article->category->encrypted_slug)
                        <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                           class="text-[10px] font-black uppercase tracking-wide hover:underline flex items-center gap-1 mb-2"
                           style="color:{{ $article->category->color ?? '#f97316' }}">
                            @if($article->category->icon)<i class="{{ $article->category->icon }}"></i>@endif
                            {{ $article->category->name }}
                        </a>
                    @endif

                    {{-- Tags --}}
                    @if($article->relationLoaded('tags') && $article->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-1 mb-2">
                            @foreach($article->tags->take(2) as $tag)
                                <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    <h3 class="text-sm md:text-base font-bold text-gray-800 mb-2 line-clamp-2 leading-snug">{{ $article->title }}</h3>

                    @if($article->excerpt)
                        <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ Str::limit(strip_tags($article->excerpt), 90) }}</p>
                    @endif

                    <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                        <a href="{{ route('articles.show', $article->encrypted_slug) }}"
                           class="flex-1 text-center py-2.5 rounded-lg text-xs font-bold border-2 transition hover:opacity-80"
                           style="border-color:{{ $article->category->color ?? '#f97316' }};color:{{ $article->category->color ?? '#f97316' }}">
                            Read Story
                        </a>
                        <a href="{{ route('detail') }}"
                           class="flex-1 text-center py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold transition shadow-sm">
                            <i class="fas fa-heart mr-1"></i> Sponsor Now
                        </a>
                    </div>
                </div>
            </div>
            @empty
            {{-- Fallback if no articles --}}
            @foreach([
                ['country'=>'Cambodia','title'=>'Support Children in Slums','desc'=>'Give hope to children living in poverty','pct'=>94],
                ['country'=>'Myanmar','title'=>'Education in Karen State','desc'=>'Provide safe housing and education','pct'=>85],
                ['country'=>'Vietnam','title'=>"Girls' Education Program",'desc'=>'Support young girls in education','pct'=>46],
            ] as $i => $s)
            <div class="card scroll-animate" style="animation-delay:{{ $i*0.2 }}s">
                <div class="p-5">
                    <span class="inline-block bg-orange-100 text-orange-600 text-xs font-semibold px-3 py-1 rounded-full mb-3">{{ $s['country'] }}</span>
                    <h3 class="text-base font-bold text-gray-800 mb-2">{{ $s['title'] }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ $s['desc'] }}</p>
                    <a href="{{ route('detail') }}" class="btn-primary w-full text-center">Sponsor Now</a>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════ CTA — #1 most-viewed article featured right ═══════ --}}
@php $topArticle = $articles->sortByDesc('views_count')->first(); @endphp
<section class="section bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 scroll-animate">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Sponsor a Child Today and Change a Life!</h2>
            <div class="green-line"></div>
        </div>
        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
            <div class="scroll-animate">
                <p class="text-base md:text-lg text-gray-700 mb-6 leading-relaxed">
                    Access to school can be a real challenge for poor children in Southeast Asia.
                    <span class="font-bold text-gray-900">Sponsoring a child is a simple and efficient way to help a child to go to school.</span>
                </p>
                <p class="text-base md:text-lg text-gray-700 mb-6 leading-relaxed">
                    With your financial support, Children of the Mekong will help
                    <span class="font-bold text-gray-900">your sponsored child continue his/her education</span>
                    without fear of dropping out.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('detail') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded transition shadow-md hover:shadow-lg">
                        <i class="fas fa-child text-2xl"></i> SPONSOR A CHILD TODAY!
                    </a>
                    @if($topArticle)
                    <a href="{{ route('articles.show', $topArticle->encrypted_slug) }}"
                       class="inline-flex items-center gap-2 px-6 py-4 border-2 border-orange-400 text-orange-600 hover:bg-orange-50 font-bold rounded transition">
                        <i class="fas fa-book-open"></i> Read Top Story
                    </a>
                    @endif
                </div>
            </div>

            {{-- Right: #1 most-viewed article card --}}
            @if($topArticle)
            <div class="scroll-animate" style="animation-delay:0.2s">
                <a href="{{ route('articles.show', $topArticle->encrypted_slug) }}"
                   class="group relative block rounded-2xl overflow-hidden shadow-2xl">
                    @if($topArticle->image)
                        <img src="{{ $topArticle->image->url }}" alt="{{ $topArticle->title }}"
                             class="w-full h-72 md:h-80 object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-72 md:h-80 flex items-center justify-center"
                             style="background:linear-gradient(135deg,{{ $topArticle->category->color ?? '#f97316' }}33,{{ $topArticle->category->color ?? '#f97316' }}11)">
                            <i class="{{ $topArticle->category->icon ?? 'fas fa-newspaper' }} text-8xl opacity-20"
                               style="color:{{ $topArticle->category->color ?? '#f97316' }}"></i>
                        </div>
                    @endif
                    {{-- Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                    {{-- Badge --}}
                    <div class="absolute top-4 left-4 flex items-center gap-2">
                        <span class="bg-orange-500 text-white text-xs font-black px-3 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-fire text-[10px]"></i> #1 Most Read
                        </span>
                        <span class="bg-black/50 text-white text-xs font-bold px-2 py-1 rounded-full">
                            <i class="fas fa-eye mr-1 text-[10px]"></i>{{ number_format($topArticle->views_count) }}
                        </span>
                    </div>
                    {{-- Content --}}
                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        @if($topArticle->category && $topArticle->category->encrypted_slug)
                            <a href="{{ route('category.articles', $topArticle->category->encrypted_slug) }}"
                               class="text-xs font-bold mb-2 block hover:underline"
                               style="color:{{ $topArticle->category->color ?? '#f97316' }}">
                                @if($topArticle->category->icon)<i class="{{ $topArticle->category->icon }} mr-1"></i>@endif
                                {{ $topArticle->category->name }}
                            </a>
                        @endif
                        <h3 class="text-base md:text-xl font-black text-white mb-2 leading-snug line-clamp-2 group-hover:text-orange-300 transition">
                            {{ $topArticle->title }}
                        </h3>
                        @if($topArticle->excerpt)
                            <p class="text-white/70 text-xs line-clamp-2 mb-3 hidden md:block">
                                {{ Str::limit(strip_tags($topArticle->excerpt), 100) }}
                            </p>
                        @endif
                        <span class="inline-flex items-center gap-1 text-white text-xs font-bold group-hover:text-orange-300 transition">
                            Read Story <i class="fas fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                        </span>
                    </div>
                </a>
            </div>
            @else
            <div class="scroll-animate" style="animation-delay:0.2s">
                <div class="rounded-2xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=800" alt="Happy Child" class="w-full h-auto object-cover">
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ═══════ NEWSLETTER ═══════ --}}
<section class="section bg-gray-800 text-white">
    <div class="max-w-4xl mx-auto text-center scroll-animate px-4">
        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-3 md:mb-4">Stay Connected</h2>
        <p class="text-sm md:text-base lg:text-lg mb-6 md:mb-8 opacity-90">Receive impact stories and updates from Southeast Asia</p>
        <form class="flex flex-col sm:flex-row gap-3 md:gap-4 max-w-md mx-auto" method="POST" action="{{ route('contact') }}">
            @csrf
            <input type="email" name="email" placeholder="Your email address"
                   class="flex-1 px-6 py-4 rounded-full text-sm md:text-base text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500">
            <button type="submit" class="btn-primary whitespace-nowrap">Subscribe</button>
        </form>
        @if(session('newsletter_success'))
            <p class="mt-4 text-green-400 text-sm"><i class="fas fa-check-circle mr-1"></i>{{ session('newsletter_success') }}</p>
        @endif
    </div>
</section>

@include('layouts.footer')
@include('layouts.navigation')
@include('layouts.ads')

<script>
window.addEventListener('load',()=>{setTimeout(()=>{document.getElementById('loader')?.classList.add('hidden');setTimeout(()=>document.getElementById('popup-modal')?.classList.add('active'),3000);},1000);});
const popup=document.getElementById('popup-modal');
document.getElementById('close-popup')?.addEventListener('click',()=>popup?.classList.remove('active'));
document.getElementById('remind-later')?.addEventListener('click',()=>popup?.classList.remove('active'));
popup?.addEventListener('click',(e)=>{if(e.target===popup)popup.classList.remove('active');});
const mobileMenu=document.getElementById('mobile-menu'),mobileMenuOverlay=document.getElementById('mobile-menu-overlay');
const openMenu=()=>{mobileMenu?.classList.add('active');mobileMenuOverlay?.classList.add('active');document.body.style.overflow='hidden';};
const closeMenu=()=>{mobileMenu?.classList.remove('active');mobileMenuOverlay?.classList.remove('active');document.body.style.overflow='';};
document.getElementById('mobile-menu-btn')?.addEventListener('click',openMenu);
document.getElementById('menu-nav-item')?.addEventListener('click',(e)=>{e.preventDefault();openMenu();});
document.getElementById('close-menu')?.addEventListener('click',closeMenu);
mobileMenuOverlay?.addEventListener('click',closeMenu);
document.querySelectorAll('.mobile-menu-link').forEach(l=>l.addEventListener('click',closeMenu));
document.querySelectorAll('.nav-item').forEach(item=>{item.addEventListener('click',function(){if(this.id!=='menu-nav-item'){document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active'));this.classList.add('active');}});});
document.querySelectorAll('a[href^="#"]').forEach(a=>{a.addEventListener('click',function(e){e.preventDefault();const t=document.querySelector(this.getAttribute('href'));if(t)window.scrollTo({top:t.offsetTop-(window.innerWidth<768?70:80),behavior:'smooth'});});});
const checkScroll=()=>document.querySelectorAll('.scroll-animate').forEach(el=>{if(el.getBoundingClientRect().top<=(window.innerHeight||document.documentElement.clientHeight)-80)el.classList.add('show');});
window.addEventListener('scroll',checkScroll);checkScroll();
document.querySelectorAll('.counter').forEach(el=>{const obs=new IntersectionObserver((entries)=>{entries.forEach(entry=>{if(!entry.isIntersecting)return;const target=+el.getAttribute('data-target'),step=Math.max(1,Math.ceil(target/200));let cur=0;const tick=()=>{cur=Math.min(cur+step,target);el.innerText=cur.toLocaleString();if(cur<target)setTimeout(tick,5);};tick();obs.unobserve(el);});},{threshold:0.5});obs.observe(el);});
document.querySelectorAll('.progress-fill').forEach(el=>{const obs=new IntersectionObserver((entries)=>{entries.forEach(entry=>{if(!entry.isIntersecting)return;setTimeout(()=>entry.target.style.width=entry.target.getAttribute('data-progress')+'%',200);obs.unobserve(entry.target);});},{threshold:0.5});obs.observe(el);});

// ── Category filter — Latest News ───────────────────────────────────────
function filterNewsCat(catId, btn) {
    // Button states
    document.querySelectorAll('.news-cat-btn').forEach(b => {
        b.classList.remove('active-cat-btn','bg-orange-500','text-white');
        b.style.backgroundColor = '';
        b.style.color = b.dataset.catId ? b.style.borderColor || '#f97316' : '';
        b.classList.add('opacity-60');
    });
    btn.classList.add('active-cat-btn','bg-orange-500','text-white');
    btn.style.backgroundColor = '#f97316';
    btn.style.color = '#fff';
    btn.classList.remove('opacity-60');

    const cards = document.querySelectorAll('.news-card');
    let shown = 0;
    const hero = document.querySelector('#news-grid .news-card:first-child');

    cards.forEach(card => {
        const match = catId === 'all' || card.dataset.catId == catId;
        card.style.display = match ? '' : 'none';
        if (match) shown++;
    });

    // Hero grid span: full when showing all, normal when filtered
    if (hero) {
        hero.classList.toggle('md:col-span-2', catId === 'all');
        hero.classList.toggle('lg:row-span-2', catId === 'all');
    }

    document.getElementById('news-no-results').classList.toggle('hidden', shown > 0);
    document.getElementById('news-grid').classList.toggle('hidden', shown === 0);
}

// ── Tag filter — Most Read ────────────────────────────────────────────────
function filterTopTag(tagId, btn) {
    document.querySelectorAll('.top-tag-btn').forEach(b => {
        b.classList.remove('active-tag-btn','bg-orange-500','text-white');
        b.classList.add('opacity-60');
    });
    btn.classList.add('active-tag-btn','bg-orange-500','!text-white');
    btn.classList.remove('opacity-60');

    const cards = document.querySelectorAll('.top-card');
    let shown = 0;

    cards.forEach(card => {
        const ids   = card.dataset.tagIds ? card.dataset.tagIds.split(',').map(Number) : [];
        const match = tagId === 'all' || ids.includes(Number(tagId));
        card.style.display = match ? '' : 'none';
        if (match) shown++;
    });

    document.getElementById('top-no-results').classList.toggle('hidden', shown > 0);
    document.getElementById('top-grid').classList.toggle('hidden', shown === 0);
}
</script>
</body>
</html>