<div class="relative group overflow-hidden rounded-xl shadow-lg scroll-animate" style="min-height:360px">

    @if($article->image)
        <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
             class="w-full h-full object-cover absolute inset-0 transition-transform duration-700 group-hover:scale-105"
             style="min-height:360px">
    @else
        <div class="w-full absolute inset-0 flex items-center justify-center"
             style="background:linear-gradient(135deg,{{ $article->category->color ?? '#f97316' }}33,{{ $article->category->color ?? '#f97316' }}11);min-height:360px">
            <i class="{{ $article->category->icon ?? 'fas fa-newspaper' }} text-8xl opacity-15"
               style="color:{{ $article->category->color ?? '#f97316' }}"></i>
        </div>
    @endif

    {{-- Deep gradient --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/92 via-black/45 to-transparent"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-8">

        {{-- Category + Tags --}}
        <div class="flex flex-wrap items-center gap-2 mb-3">
            @if($article->category)
                <a href="{{ route('category.articles', $article->category->encrypted_slug) }}"
                   class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full hover:opacity-80 transition"
                   style="background:{{ $article->category->color ?? '#f97316' }}44;color:#fff;border:1px solid {{ $article->category->color ?? '#f97316' }}88;">
                    @if($article->category->icon)<i class="{{ $article->category->icon }} text-xs"></i>@endif
                    {{ $article->category->name }}
                </a>
            @endif
            @if($article->relationLoaded('tags') && $article->tags->isNotEmpty())
                @foreach($article->tags->take(2) as $tag)
                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full"
                          style="background:{{ $tag->color }}44;color:#fff;border:1px solid {{ $tag->color }}77;">
                        {{ $tag->name }}
                    </span>
                @endforeach
            @endif
        </div>

        <h3 class="text-xl md:text-3xl lg:text-4xl font-bold text-white mb-2 leading-snug">
            {{ $article->title }}
        </h3>

        @if($article->excerpt)
            <p class="text-white/70 text-sm mb-3 line-clamp-2 hidden md:block">
                {{ Str::limit(strip_tags($article->excerpt), 130) }}
            </p>
        @endif

        <div class="flex items-center justify-between">
            <a href="{{ route('articles.show', $article->encrypted_slug) }}"
               class="text-white font-semibold text-sm md:text-base inline-flex items-center gap-2
                      group/link hover:text-orange-300 transition">
                READ MORE
                <i class="fas fa-arrow-right transition-transform group-hover/link:translate-x-1"></i>
            </a>
            <span class="text-white/50 text-xs">
                <i class="fas fa-eye mr-1"></i>{{ number_format($article->views_count) }}
                &nbsp;·&nbsp;{{ $article->published_at?->diffForHumans() }}
            </span>
        </div>
    </div>
</div>