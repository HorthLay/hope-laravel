{{-- ═══════════════════════════════════════════════
     MINIMAL STYLE — text-focused, left accent border, small thumbnail
     Used in: Sidebar lists, compact sections
═══════════════════════════════════════════════ --}}
<div class="bg-white rounded-xl overflow-hidden hover:shadow-md transition-all duration-300 group
            flex gap-3 p-3 border-l-4 scroll-animate"
     style="border-color:{{ $article->category->color ?? '#f97316' }}">

    {{-- Small thumbnail --}}
    <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden">
        @if($article->image)
            <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        @else
            <div class="w-full h-full flex items-center justify-center"
                 style="background:{{ $article->category->color ?? '#f97316' }}15">
                <i class="{{ $article->category->icon ?? 'fas fa-newspaper' }} text-xl opacity-30"
                   style="color:{{ $article->category->color ?? '#f97316' }}"></i>
            </div>
        @endif
    </div>

    {{-- Text content --}}
    <div class="flex-1 min-w-0 flex flex-col">
        {{-- Category --}}
        @if($article->category)
            <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
               class="text-[9px] font-black uppercase tracking-widest hover:underline"
               style="color:{{ $article->category->color ?? '#f97316' }}">
                {{ $article->category->name }}
            </a>
        @endif

        <h3 class="text-sm font-bold text-gray-800 line-clamp-2 leading-snug mt-0.5
                   group-hover:text-orange-500 transition flex-1">
            <a href="{{ route('articles.show', $article->encrypted_slug) }}">{{ $article->title }}</a>
        </h3>

        {{-- Tags inline --}}
        @if($article->relationLoaded('tags') && $article->tags->isNotEmpty())
            <div class="flex flex-wrap gap-1 mt-1">
                @foreach($article->tags->take(2) as $tag)
                    <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif

        <div class="flex items-center gap-3 mt-1.5">
            <span class="text-[10px] text-gray-400">
                <i class="fas fa-eye mr-0.5"></i>{{ number_format($article->views_count) }}
            </span>
            <span class="text-[10px] text-gray-400">{{ $article->published_at?->format('M d') }}</span>
            <a href="{{ route('articles.show', $article->encrypted_slug) }}"
               class="ml-auto text-[10px] font-bold flex items-center gap-0.5 hover:gap-1.5 transition-all"
               style="color:{{ $article->category->color ?? '#f97316' }}">
                Read <i class="fas fa-arrow-right text-[9px]"></i>
            </a>
        </div>
    </div>
</div>