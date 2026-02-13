{{-- ═══════════════════════════════════════════════
     CARD STYLE — white background, image top, content below
     Used in: Per-category grids
═══════════════════════════════════════════════ --}}
<div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group h-full flex flex-col scroll-animate">
    <div class="overflow-hidden flex-shrink-0">
        @if($article->image)
            <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
                 class="w-full h-44 object-cover transition-transform duration-500 group-hover:scale-110">
        @else
            <div class="w-full h-44 flex items-center justify-center"
                 style="background:linear-gradient(135deg,{{ $article->category->color ?? '#f97316' }}18,{{ $article->category->color ?? '#f97316' }}06)">
                <i class="{{ $article->category->icon ?? 'fas fa-newspaper' }} text-5xl opacity-20"
                   style="color:{{ $article->category->color ?? '#f97316' }}"></i>
            </div>
        @endif
    </div>
    <div class="p-4 flex flex-col flex-1">
        @if($article->category)
            <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
               class="text-[10px] font-black uppercase tracking-wide mb-1.5 hover:underline"
               style="color:{{ $article->category->color ?? '#f97316' }}">
                @if($article->category->icon)<i class="{{ $article->category->icon }} mr-1"></i>@endif{{ $article->category->name }}
            </a>
        @endif
        <h3 class="text-sm md:text-base font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-orange-500 transition leading-snug flex-1">
            {{ $article->title }}
        </h3>
        @if($article->excerpt)
            <p class="text-xs text-gray-500 mb-2 line-clamp-2">{{ Str::limit(strip_tags($article->excerpt), 80) }}</p>
        @endif
        @if($article->relationLoaded('tags') && $article->tags->isNotEmpty())
            <div class="flex flex-wrap gap-1 mb-3">
                @foreach($article->tags->take(3) as $tag)
                    <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif
        <div class="flex items-center justify-between pt-3 border-t border-gray-100 mt-auto">
            <a href="{{ route('articles.show', $article->encrypted_slug) }}"
               class="text-xs font-semibold flex items-center gap-1 hover:gap-2 transition-all"
               style="color:{{ $article->category->color ?? '#f97316' }}">
                Read More <i class="fas fa-arrow-right text-xs"></i>
            </a>
            <span class="text-xs text-gray-400"><i class="fas fa-eye mr-1"></i>{{ number_format($article->views_count) }}</span>
        </div>
    </div>
</div>