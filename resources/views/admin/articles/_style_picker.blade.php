
<div class="mb-6">
    <label class="block text-sm font-semibold text-gray-700 mb-1">
        Card Display Style
        <span class="text-xs font-normal text-gray-400 ml-1">(how this article appears on the home page)</span>
    </label>

    {{-- Hidden input — submitted with the form --}}
    <input type="hidden" name="style" id="article-style-input" value="{{ old('style', $article->style ?? 'overlay') }}">

    {{-- 5 visual style cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3" id="article-style-cards">

        {{-- OVERLAY --}}
        <div class="article-style-card group relative rounded-2xl border-2 p-3 cursor-pointer transition-all duration-150
                    hover:border-orange-400 hover:shadow-md hover:-translate-y-0.5
                    {{ old('style', $article->style ?? 'overlay') === 'overlay' ? 'border-orange-500 bg-orange-50 shadow-md' : 'border-gray-200 bg-gray-50' }}"
             data-style="overlay"
             onclick="pickArticleStyle('overlay')">
            {{-- Selected check --}}
            <span class="style-check absolute -top-2 -right-2 w-5 h-5 bg-orange-500 rounded-full
                         flex items-center justify-center shadow transition-all duration-200
                         {{ old('style', $article->style ?? 'overlay') === 'overlay' ? 'opacity-100 scale-100' : 'opacity-0 scale-50' }}">
                <i class="fas fa-check text-white text-[9px]"></i>
            </span>
            {{-- Mini preview --}}
            <div class="h-14 rounded-lg overflow-hidden relative mb-2"
                 style="background:linear-gradient(135deg,#374151,#1f2937)">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-1.5 left-2 right-2">
                    <div class="h-1.5 bg-white/70 rounded mb-1" style="width:80%"></div>
                    <div class="h-1 bg-white/40 rounded" style="width:55%"></div>
                </div>
            </div>
            <p class="text-[10px] font-black text-gray-700 uppercase tracking-wide leading-none">Overlay</p>
            <p class="text-[9px] text-gray-400 mt-0.5">Dark image + text</p>
        </div>

        {{-- CARD --}}
        <div class="article-style-card group relative rounded-2xl border-2 p-3 cursor-pointer transition-all duration-150
                    hover:border-orange-400 hover:shadow-md hover:-translate-y-0.5
                    {{ old('style', $article->style ?? '') === 'card' ? 'border-orange-500 bg-orange-50 shadow-md' : 'border-gray-200 bg-gray-50' }}"
             data-style="card"
             onclick="pickArticleStyle('card')">
            <span class="style-check absolute -top-2 -right-2 w-5 h-5 bg-orange-500 rounded-full
                         flex items-center justify-center shadow transition-all duration-200
                         {{ old('style', $article->style ?? '') === 'card' ? 'opacity-100 scale-100' : 'opacity-0 scale-50' }}">
                <i class="fas fa-check text-white text-[9px]"></i>
            </span>
            <div class="h-14 rounded-lg overflow-hidden mb-2 bg-white border border-gray-200">
                <div class="h-7 bg-gray-200"></div>
                <div class="px-1.5 pt-1">
                    <div class="h-1.5 bg-gray-300 rounded mb-1" style="width:90%"></div>
                    <div class="h-1 bg-gray-200 rounded" style="width:65%"></div>
                </div>
            </div>
            <p class="text-[10px] font-black text-gray-700 uppercase tracking-wide leading-none">Card</p>
            <p class="text-[9px] text-gray-400 mt-0.5">White card + image top</p>
        </div>

        {{-- MAGAZINE --}}
        <div class="article-style-card group relative rounded-2xl border-2 p-3 cursor-pointer transition-all duration-150
                    hover:border-orange-400 hover:shadow-md hover:-translate-y-0.5
                    {{ old('style', $article->style ?? '') === 'magazine' ? 'border-orange-500 bg-orange-50 shadow-md' : 'border-gray-200 bg-gray-50' }}"
             data-style="magazine"
             onclick="pickArticleStyle('magazine')">
            <span class="style-check absolute -top-2 -right-2 w-5 h-5 bg-orange-500 rounded-full
                         flex items-center justify-center shadow transition-all duration-200
                         {{ old('style', $article->style ?? '') === 'magazine' ? 'opacity-100 scale-100' : 'opacity-0 scale-50' }}">
                <i class="fas fa-check text-white text-[9px]"></i>
            </span>
            <div class="h-14 rounded-lg overflow-hidden mb-2 bg-white border border-gray-200 flex gap-1.5 p-1.5">
                <div class="w-9 flex-shrink-0 bg-gray-200 rounded"></div>
                <div class="flex-1 flex flex-col justify-center gap-1">
                    <div class="h-1.5 bg-gray-300 rounded" style="width:100%"></div>
                    <div class="h-1 bg-gray-200 rounded" style="width:75%"></div>
                    <div class="h-1 bg-gray-200 rounded" style="width:55%"></div>
                </div>
            </div>
            <p class="text-[10px] font-black text-gray-700 uppercase tracking-wide leading-none">Magazine</p>
            <p class="text-[9px] text-gray-400 mt-0.5">Image left, text right</p>
        </div>

        {{-- FEATURED --}}
        <div class="article-style-card group relative rounded-2xl border-2 p-3 cursor-pointer transition-all duration-150
                    hover:border-orange-400 hover:shadow-md hover:-translate-y-0.5
                    {{ old('style', $article->style ?? '') === 'featured' ? 'border-orange-500 bg-orange-50 shadow-md' : 'border-gray-200 bg-gray-50' }}"
             data-style="featured"
             onclick="pickArticleStyle('featured')">
            <span class="style-check absolute -top-2 -right-2 w-5 h-5 bg-orange-500 rounded-full
                         flex items-center justify-center shadow transition-all duration-200
                         {{ old('style', $article->style ?? '') === 'featured' ? 'opacity-100 scale-100' : 'opacity-0 scale-50' }}">
                <i class="fas fa-check text-white text-[9px]"></i>
            </span>
            <div class="h-14 rounded-lg overflow-hidden relative mb-2"
                 style="background:linear-gradient(135deg,#1e3a5f,#0f1e3a)">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                <div class="absolute top-1.5 left-2">
                    <div class="h-2 w-7 rounded-full bg-orange-500/80"></div>
                </div>
                <div class="absolute bottom-1.5 left-2 right-2">
                    <div class="h-2 bg-white/80 rounded mb-1" style="width:85%"></div>
                    <div class="h-1 bg-white/50 rounded" style="width:60%"></div>
                </div>
            </div>
            <p class="text-[10px] font-black text-gray-700 uppercase tracking-wide leading-none">Featured</p>
            <p class="text-[9px] text-gray-400 mt-0.5">Large hero card</p>
        </div>

        {{-- MINIMAL --}}
        <div class="article-style-card group relative rounded-2xl border-2 p-3 cursor-pointer transition-all duration-150
                    hover:border-orange-400 hover:shadow-md hover:-translate-y-0.5
                    {{ old('style', $article->style ?? '') === 'minimal' ? 'border-orange-500 bg-orange-50 shadow-md' : 'border-gray-200 bg-gray-50' }}"
             data-style="minimal"
             onclick="pickArticleStyle('minimal')">
            <span class="style-check absolute -top-2 -right-2 w-5 h-5 bg-orange-500 rounded-full
                         flex items-center justify-center shadow transition-all duration-200
                         {{ old('style', $article->style ?? '') === 'minimal' ? 'opacity-100 scale-100' : 'opacity-0 scale-50' }}">
                <i class="fas fa-check text-white text-[9px]"></i>
            </span>
            <div class="h-14 rounded-lg overflow-hidden mb-2 bg-white border-l-4 border-orange-500 flex gap-1.5 p-1.5">
                <div class="w-8 flex-shrink-0 bg-gray-100 rounded-md"></div>
                <div class="flex-1 flex flex-col justify-center gap-1">
                    <div class="h-1 bg-orange-400 rounded w-8"></div>
                    <div class="h-1.5 bg-gray-300 rounded" style="width:100%"></div>
                    <div class="h-1 bg-gray-200 rounded" style="width:70%"></div>
                </div>
            </div>
            <p class="text-[10px] font-black text-gray-700 uppercase tracking-wide leading-none">Minimal</p>
            <p class="text-[9px] text-gray-400 mt-0.5">Text + border accent</p>
        </div>

    </div>

    {{-- Info note --}}
    <p class="text-xs text-gray-400 mt-2.5 flex items-center gap-1.5">
        <i class="fas fa-info-circle text-orange-400"></i>
        The first article in the Latest News section always renders as a full-width <strong>Featured</strong> hero regardless of style.
        Style applies to all other article positions.
    </p>
</div>

<script>
function pickArticleStyle(style) {
    document.getElementById('article-style-input').value = style;
    document.querySelectorAll('.article-style-card').forEach(function(card) {
        const active = card.dataset.style === style;
        card.classList.toggle('border-orange-500', active);
        card.classList.toggle('bg-orange-50',     active);
        card.classList.toggle('shadow-md',        active);
        card.classList.toggle('border-gray-200', !active);
        card.classList.toggle('bg-gray-50',      !active);
        const check = card.querySelector('.style-check');
        if (check) {
            check.classList.toggle('opacity-100', active);
            check.classList.toggle('scale-100',   active);
            check.classList.toggle('opacity-0',  !active);
            check.classList.toggle('scale-50',   !active);
        }
    });
}
</script>