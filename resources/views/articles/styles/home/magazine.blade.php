{{-- ═══════════════════════════════════════════════
     MAGAZINE STYLE — horizontal card (image left, text right)
     Used in: List-style sections, most-read
═══════════════════════════════════════════════ --}}
<div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group flex h-full scroll-animate">

    {{-- Left: image --}}
    <div class="flex-shrink-0 w-32 sm:w-40 overflow-hidden">
        @if($article->image)
            <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                 style="min-height:120px">
        @else
            <div class="w-full h-full flex items-center justify-center"
                 style="background:linear-gradient(135deg,{{ $article->category->color ?? '#f97316' }}22,{{ $article->category->color ?? '#f97316' }}08);min-height:120px">
                <i class="{{ $article->category->icon ?? 'fas fa-newspaper' }} text-4xl opacity-20"
                   style="color:{{ $article->category->color ?? '#f97316' }}"></i>
            </div>
        @endif
    </div>

    {{-- Right: content --}}
    <div class="flex-1 p-3 flex flex-col min-w-0">
        {{-- Category --}}
        @if($article->category)
            <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
               class="text-[10px] font-black uppercase tracking-wide hover:underline mb-1 flex items-center gap-1"
               style="color:{{ $article->category->color ?? '#f97316' }}">
                @if($article->category->icon)<i class="{{ $article->category->icon }}"></i>@endif{{ $article->category->name }}
            </a>
        @endif

        <h3 class="text-sm font-bold text-gray-800 line-clamp-2 leading-snug group-hover:text-orange-500 transition flex-1">
            {{ $article->title }}
        </h3>

        {{-- Tags --}}
        @if($article->relationLoaded('tags') && $article->tags->isNotEmpty())
            <div class="flex flex-wrap gap-1 mt-1.5">
                @foreach($article->tags->take(2) as $tag)
                    <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif

        {{-- Footer --}}
        <div class="flex items-center gap-2 mt-2 pt-2 border-t border-gray-100">
            <a href="{{ route('articles.show', $article->encrypted_slug) }}"
               class="text-[10px] font-bold flex items-center gap-0.5 hover:gap-1.5 transition-all"
               style="color:{{ $article->category->color ?? '#f97316' }}">
                Read More <i class="fas fa-arrow-right text-[9px]"></i>
            </a>
            <span class="ml-auto text-[10px] text-gray-400">
                <i class="fas fa-eye mr-0.5"></i>{{ number_format($article->views_count) }}
            </span>
        </div>
    </div>
</div>