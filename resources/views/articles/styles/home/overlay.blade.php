<div class="relative group overflow-hidden rounded-xl shadow-lg h-full scroll-animate">

    {{-- Image or placeholder --}}
    @if($article->image)
        <img src="{{ $article->image->url }}"
             alt="{{ $article->title }}"
             class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110">
    @else
        <div class="w-full h-56 flex items-center justify-center transition-transform duration-500 group-hover:scale-105"
             style="background:linear-gradient(135deg,{{ $article->category->color ?? '#f97316' }}22,{{ $article->category->color ?? '#f97316' }}08)">
            <i class="{{ $article->category->icon ?? 'fas fa-newspaper' }} text-5xl opacity-20"
               style="color:{{ $article->category->color ?? '#f97316' }}"></i>
        </div>
    @endif

    {{-- Gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex flex-col justify-end p-4 md:p-5">
        {{-- Category + Tags row --}}
        <div class="flex flex-wrap items-center gap-1 mb-1.5">
            @if($article->category)
                <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                   class="text-xs font-bold hover:underline transition"
                   style="color:{{ $article->category->color ?? '#f97316' }}">
                    @if($article->category->icon)<i class="{{ $article->category->icon }} text-xs mr-0.5"></i>@endif{{ $article->category->name }}
                </a>
            @endif
            @if($article->relationLoaded('tags') && $article->tags->isNotEmpty())
                @foreach($article->tags->take(2) as $tag)
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full"
                          style="background:{{ $tag->color }}33;color:#fff;border:1px solid {{ $tag->color }}55;">
                        {{ $tag->name }}
                    </span>
                @endforeach
            @endif
        </div>

        <h3 class="text-sm md:text-base font-bold text-white line-clamp-2 leading-snug mb-2">
            {{ $article->title }}
        </h3>

        <div class="flex items-center justify-between">
            <a href="{{ route('articles.show', $article->encrypted_slug) }}"
               class="text-white/90 hover:text-orange-300 text-xs font-semibold
                      inline-flex items-center gap-1 group/link transition">
                READ MORE
                <i class="fas fa-arrow-right text-[10px] transition-transform group-hover/link:translate-x-1"></i>
            </a>
            <span class="text-white/50 text-xs hidden sm:block">
                {{ $article->published_at?->format('M d, Y') }}
            </span>
        </div>
    </div>
</div>