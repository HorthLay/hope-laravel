<div>
<style>
.faq-body-lw{max-height:0;overflow:hidden;opacity:0;transition:max-height .45s ease,opacity .35s ease;}
.faq-item-lw.open .faq-body-lw{max-height:800px;opacity:1;}
.faq-item-lw.open .faq-icon-lw{transform:rotate(45deg);}
.faq-icon-lw{transition:transform .3s ease;}
.cat-btn-active-orange{background:#fff7ed;color:#ea580c;font-weight:800;}
.cat-btn-active-blue{background:#eff6ff;color:#2563eb;font-weight:800;}
</style>

{{-- Search --}}
<div class="text-center max-w-2xl mx-auto mb-16">
    <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">How can we help you?</h2>
    <div class="relative max-w-lg mx-auto">
        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400">
            <i class="fas fa-search"></i>
        </div>
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-200 shadow-sm bg-white text-gray-700 transition-all text-base placeholder-gray-400 outline-none focus:border-{{ $theme === 'orange' ? 'orange' : 'blue' }}-500 focus:ring-4 focus:ring-{{ $theme === 'orange' ? 'orange' : 'blue' }}-500/10"
            placeholder="Search for questions..."
        >
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-10">

    {{-- Sidebar Categories --}}
    <div class="w-full lg:w-1/4 flex-shrink-0">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 sticky top-24">
            <h3 class="text-xs font-extrabold text-gray-400 uppercase tracking-widest mb-4 px-2">Categories</h3>
            <ul class="space-y-2">
                <li>
                    <button
                        wire:click="setCategory('all')"
                        class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $activeCategory === 'all' ? 'cat-btn-active-'.$theme : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                    >All Questions</button>
                </li>
                @foreach($categories as $cat)
                <li>
                    <button
                        wire:click="setCategory('{{ $cat['key'] }}')"
                        class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $activeCategory === $cat['key'] ? 'cat-btn-active-'.$theme : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                    >{{ $cat['label'] }}</button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- FAQ Items --}}
    <div class="w-full lg:w-3/4">

        {{-- Empty State --}}
        @if(empty($filteredItems))
        <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm mb-4">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-search text-gray-300 text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-gray-900 mb-2">No matching questions</h3>
            <p class="text-gray-500">Try adjusting your search or selecting a different category.</p>
        </div>
        @endif

        <div class="space-y-4">
            @foreach($filteredItems as $key => $item)
            @php $isOpen = $openKey === (string)$key; @endphp
            <div class="faq-item-lw group bg-white rounded-2xl border shadow-sm transition-all duration-300
                {{ $isOpen
                    ? ($theme === 'orange' ? 'border-orange-200 shadow-md' : 'border-blue-200 shadow-md')
                    : 'border-gray-100 hover:shadow-md '.($theme === 'orange' ? 'hover:border-orange-100' : 'hover:border-blue-100') }}
                {{ $isOpen ? 'open' : '' }}">

                <button
                    wire:click="toggle('{{ $key }}')"
                    class="w-full flex items-center justify-between px-6 md:px-8 py-5 md:py-6 text-left focus:outline-none bg-white rounded-2xl transition-colors
                        {{ $theme === 'orange' ? 'hover:bg-orange-50/30' : 'hover:bg-blue-50/30' }}"
                    type="button"
                >
                    <span class="font-bold text-lg pr-6 transition-colors
                        {{ $isOpen
                            ? ($theme === 'orange' ? 'text-orange-600' : 'text-blue-600')
                            : 'text-gray-800 group-hover:'.($theme === 'orange' ? 'text-orange-600' : 'text-blue-600') }}">
                        {{ $item['question'] }}
                    </span>
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 transition-all shadow-sm border
                        {{ $isOpen
                            ? ($theme === 'orange' ? 'bg-orange-100 border-orange-200' : 'bg-blue-100 border-blue-200')
                            : 'bg-gray-50 border-gray-100 group-hover:'.($theme === 'orange' ? 'bg-orange-100 border-orange-200' : 'bg-blue-100 border-blue-200') }}">
                        <i class="fas fa-plus faq-icon-lw
                            {{ $isOpen
                                ? ($theme === 'orange' ? 'text-orange-600' : 'text-blue-600')
                                : 'text-gray-400 group-hover:'.($theme === 'orange' ? 'text-orange-600' : 'text-blue-600') }}">
                        </i>
                    </div>
                </button>

                <div class="faq-body-lw px-6 md:px-8 pb-0">
                    <div class="pb-6 md:pb-8 text-gray-600 leading-relaxed border-t border-gray-100 pt-5 text-base">
                        {!! $item['answer'] !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- CTA slot --}}
        {{ $slot ?? '' }}
    </div>
</div>
</div>
