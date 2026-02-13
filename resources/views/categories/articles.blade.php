{{-- resources/views/categories/articles.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $category->name }} | Hope & Impact</title>
    <meta name="description" content="{{ $category->description ?? 'Browse all articles in '.$category->name.' on Hope & Impact.' }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
</head>
<body class="bg-gray-50">

@include('layouts.header')

{{-- ===== CATEGORY HERO BANNER ===== --}}
<div class="relative overflow-hidden py-14 md:py-20"
     style="background: linear-gradient(135deg, {{ $category->color ?? '#f97316' }}dd 0%, {{ $category->color ?? '#f97316' }}99 100%);">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-8 -right-8 w-64 h-64 rounded-full border-4 border-white"></div>
        <div class="absolute -bottom-12 -left-12 w-80 h-80 rounded-full border-4 border-white"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 rounded-full border-4 border-white"></div>
    </div>
    <div class="max-w-6xl mx-auto px-4 relative text-white text-center">
        @if($category->icon)
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <i class="{{ $category->icon }} text-3xl text-white"></i>
            </div>
        @endif
        <h1 class="text-3xl md:text-5xl font-black mb-3">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-base md:text-lg text-white/90 max-w-2xl mx-auto mb-4">{{ $category->description }}</p>
        @endif
        <div class="flex items-center justify-center gap-3 text-sm text-white/80">
            <span><i class="fas fa-newspaper mr-1"></i>{{ $articles->total() }} articles</span>
            <span>·</span>
            <a href="{{ route('home') }}" class="hover:text-white transition">
                <i class="fas fa-home mr-1"></i>Home
            </a>
            <span>·</span>
            <span>{{ $category->name }}</span>
        </div>
    </div>
</div>

{{-- ===== ALL CATEGORIES NAV ===== --}}
@if($categories->isNotEmpty())
<div class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-40">
    <div class="max-w-6xl mx-auto px-4 py-3">
        <div class="flex items-center gap-2 overflow-x-auto scrollbar-hide">
            <a href="{{ route('home') }}"
               class="flex-shrink-0 px-4 py-2 rounded-full text-xs font-bold bg-gray-100 hover:bg-gray-200 text-gray-600 transition">
                <i class="fas fa-home mr-1"></i> All
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('category.articles', $cat->encrypted_slug) }}"
                   class="flex-shrink-0 flex items-center gap-1 px-4 py-2 rounded-full text-xs font-bold border-2 transition"
                   style="{{ $cat->id === $category->id
                       ? 'background-color:'.$cat->color.';color:#fff;border-color:'.$cat->color.';'
                       : 'border-color:'.($cat->color ?? '#f97316').';color:'.($cat->color ?? '#f97316').';' }}"
                   @if($cat->id !== $category->id)
                   onmouseover="this.style.backgroundColor=this.style.borderColor;this.style.color='#fff';"
                   onmouseout="this.style.backgroundColor='';this.style.color=this.style.borderColor;"
                   @endif>
                    @if($cat->icon)<i class="{{ $cat->icon }} text-xs"></i>@endif
                    {{ $cat->name }}
                    <span class="opacity-70">({{ $cat->articles_count }})</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ===== ARTICLES GRID ===== --}}
<div class="max-w-6xl mx-auto px-4 py-10 md:py-14">

    @if($articles->isNotEmpty())

        {{-- FEATURED FIRST ARTICLE — large card --}}
        @php $first = $articles->first(); @endphp
        <div class="relative group overflow-hidden rounded-2xl shadow-xl mb-8 scroll-animate">
            @if($first->image)
                <img src="{{ $first->image->url }}" alt="{{ $first->title }}"
                     class="w-full h-72 md:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
            @else
                <div class="w-full h-72 md:h-96 flex items-center justify-center"
                     style="background: linear-gradient(135deg, {{ $category->color ?? '#f97316' }}33, {{ $category->color ?? '#f97316' }}11);">
                    <i class="{{ $category->icon ?? 'fas fa-newspaper' }} text-8xl opacity-20"
                       style="color:{{ $category->color ?? '#f97316' }}"></i>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-10">
                {{-- Category badge --}}
                <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full mb-3 w-fit"
                      style="background-color:{{ $category->color ?? '#f97316' }}44;color:#fff;border:1px solid {{ $category->color ?? '#f97316' }}88;">
                    @if($category->icon)<i class="{{ $category->icon }} text-xs"></i>@endif
                    {{ $category->name }}
                </span>
                <h2 class="text-2xl md:text-4xl font-black text-white mb-3 leading-tight max-w-3xl">
                    {{ $first->title }}
                </h2>
                @if($first->excerpt)
                    <p class="text-white/80 text-sm md:text-base mb-4 line-clamp-2 max-w-2xl hidden md:block">
                        {{ Str::limit(strip_tags($first->excerpt), 150) }}
                    </p>
                @endif
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('articles.show', $first->encrypted_slug) }}"
                       class="inline-flex items-center gap-2 px-6 py-3 font-bold text-sm rounded-full text-white transition hover:opacity-90"
                       style="background-color:{{ $category->color ?? '#f97316' }}">
                        Read Article <i class="fas fa-arrow-right"></i>
                    </a>
                    <div class="flex items-center gap-3 text-white/70 text-xs">
                        <span><i class="fas fa-calendar-alt mr-1"></i>{{ $first->published_at?->format('M d, Y') }}</span>
                        <span><i class="fas fa-eye mr-1"></i>{{ number_format($first->views_count) }}</span>
                        <span><i class="fas fa-clock mr-1"></i>{{ max(1, ceil(str_word_count(strip_tags($first->content ?? '')) / 200)) }} min</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRID — all remaining articles --}}
        @if($articles->count() > 1)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach($articles->skip(1) as $article)
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group scroll-animate flex flex-col">

                    {{-- Image --}}
                    <div class="overflow-hidden flex-shrink-0">
                        @if($article->image)
                            <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-48 flex items-center justify-center"
                                 style="background: linear-gradient(135deg, {{ $category->color ?? '#f97316' }}22, {{ $category->color ?? '#f97316' }}08);">
                                <i class="{{ $category->icon ?? 'fas fa-newspaper' }} text-5xl opacity-20"
                                   style="color:{{ $category->color ?? '#f97316' }}"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col flex-1">
                        {{-- Category badge --}}
                        <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                           class="inline-flex items-center gap-1 text-xs font-bold mb-2 w-fit hover:underline"
                           style="color:{{ $article->category->color ?? '#f97316' }}">
                            @if($article->category->icon)<i class="{{ $article->category->icon }} text-xs"></i>@endif
                            {{ $article->category->name }}
                        </a>

                        {{-- Title --}}
                        <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-orange-500 transition leading-snug flex-1">
                            {{ $article->title }}
                        </h3>

                        {{-- Excerpt --}}
                        @if($article->excerpt)
                            <p class="text-xs text-gray-500 line-clamp-2 mb-3">
                                {{ Str::limit(strip_tags($article->excerpt), 90) }}
                            </p>
                        @endif

                        {{-- Footer --}}
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 mt-auto">
                            <a href="{{ route('articles.show', $article->encrypted_slug) }}"
                               class="text-xs font-bold flex items-center gap-1 hover:gap-2 transition-all"
                               style="color:{{ $article->category->color ?? '#f97316' }}">
                                Read More <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span><i class="fas fa-eye mr-1"></i>{{ number_format($article->views_count) }}</span>
                                <span class="hidden sm:inline">· {{ $article->published_at?->format('M d') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        {{-- ===== PAGINATION ===== --}}
        @if($articles->hasPages())
        <div class="flex items-center justify-center gap-2 mt-8 flex-wrap">
            {{-- Prev --}}
            @if($articles->onFirstPage())
                <span class="px-4 py-2 rounded-full text-sm bg-gray-100 text-gray-400 cursor-not-allowed">
                    <i class="fas fa-arrow-left mr-1"></i> Prev
                </span>
            @else
                <a href="{{ $articles->previousPageUrl() }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold bg-white border-2 text-gray-700 hover:border-orange-400 hover:text-orange-500 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Prev
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach($articles->getUrlRange(max(1, $articles->currentPage()-2), min($articles->lastPage(), $articles->currentPage()+2)) as $page => $url)
                @if($page == $articles->currentPage())
                    <span class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white shadow"
                          style="background-color:{{ $category->color ?? '#f97316' }}">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                       class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold bg-white border-2 border-gray-200 text-gray-700 hover:border-orange-400 hover:text-orange-500 transition shadow-sm">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($articles->hasMorePages())
                <a href="{{ $articles->nextPageUrl() }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold bg-white border-2 text-gray-700 hover:border-orange-400 hover:text-orange-500 transition shadow-sm">
                    Next <i class="fas fa-arrow-right ml-1"></i>
                </a>
            @else
                <span class="px-4 py-2 rounded-full text-sm bg-gray-100 text-gray-400 cursor-not-allowed">
                    Next <i class="fas fa-arrow-right ml-1"></i>
                </span>
            @endif
        </div>
        <p class="text-center text-xs text-gray-400 mt-3">
            Showing {{ $articles->firstItem() }}–{{ $articles->lastItem() }} of {{ $articles->total() }} articles
        </p>
        @endif

    @else
        {{-- Empty state --}}
        <div class="text-center py-20">
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5"
                 style="background-color:{{ $category->color ?? '#f97316' }}15;">
                <i class="{{ $category->icon ?? 'fas fa-newspaper' }} text-4xl opacity-40"
                   style="color:{{ $category->color ?? '#f97316' }}"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">No articles yet</h3>
            <p class="text-gray-500 mb-6">No published articles in <strong>{{ $category->name }}</strong> yet.</p>
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-bold text-sm text-white transition hover:opacity-90"
               style="background-color:{{ $category->color ?? '#f97316' }}">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
    @endif

</div>

{{-- ===== OTHER CATEGORIES ===== --}}
@if($categories->where('id', '!=', $category->id)->isNotEmpty())
<section class="bg-white py-12 border-t border-gray-100">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Browse Other Categories</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories->where('id', '!=', $category->id) as $cat)
                <a href="{{ route('category.articles', $cat->encrypted_slug) }}"
                   class="group flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-transparent hover:border-opacity-60 transition text-center"
                   style="background-color:{{ $cat->color ?? '#f97316' }}0d;"
                   onmouseover="this.style.borderColor='{{ $cat->color ?? '#f97316' }}';"
                   onmouseout="this.style.borderColor='transparent';">
                    @if($cat->icon)
                        <div class="w-11 h-11 rounded-full flex items-center justify-center transition group-hover:scale-110"
                             style="background-color:{{ $cat->color ?? '#f97316' }}22;">
                            <i class="{{ $cat->icon }}" style="color:{{ $cat->color ?? '#f97316' }}"></i>
                        </div>
                    @endif
                    <span class="text-xs font-bold text-gray-700">{{ $cat->name }}</span>
                    <span class="text-xs text-gray-400">{{ $cat->articles_count }} articles</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('layouts.footer')
@include('layouts.navigation')

<script>
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