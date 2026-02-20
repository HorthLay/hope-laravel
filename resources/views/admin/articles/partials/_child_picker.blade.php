{{-- resources/views/admin/articles/partials/_child_picker.blade.php --}}
{{--
    Props:
      $children          — Collection of all active SponsoredChild
      $selectedChildIds  — array of already-selected IDs (old input or existing pivot)
--}}
@php
    $selectedChildIds = $selectedChildIds ?? [];
    $selectedChildren = $children->whereIn('id', $selectedChildIds);
@endphp

<div class="card" id="child-picker-card">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-1">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-child text-orange-500"></i> Sponsored Children
            <span class="ml-1 inline-flex items-center justify-center w-5 h-5 rounded-full bg-orange-100 text-orange-600 text-[10px] font-black" id="child-count-badge">
                {{ count($selectedChildIds) }}
            </span>
        </h3>
        <button type="button" id="child-clear-all-btn"
                class="text-xs text-red-400 hover:text-red-600 {{ count($selectedChildIds) ? '' : 'hidden' }}">
            Clear all
        </button>
    </div>
    <p class="text-xs text-gray-400 mb-3">Link this article to one or more sponsored children</p>

    {{-- Selected chips --}}
    <div id="child-chips" class="flex flex-wrap gap-2 mb-3 {{ count($selectedChildIds) ? '' : 'hidden' }}">
        @foreach($selectedChildren as $child)
        <div class="child-chip flex items-center gap-1.5 pl-1 pr-2 py-1 bg-orange-50 border border-orange-200 rounded-full text-xs font-semibold text-orange-700"
             data-id="{{ $child->id }}">
            <img src="{{ asset($child->profile_photo) }}"
                 class="w-5 h-5 rounded-full object-cover border border-orange-300"
                 onerror="this.src='{{ asset('images/child-placeholder.jpg') }}'">
            <span>{{ $child->first_name }}{{ $child->code ? ' ('.$child->code.')' : '' }}</span>
            <button type="button" data-remove-child="{{ $child->id }}"
                    class="child-remove-btn ml-0.5 w-4 h-4 flex items-center justify-center rounded-full hover:bg-orange-200 transition">
                <i class="fas fa-times text-[9px] pointer-events-none"></i>
            </button>
            {{-- Hidden input submitted with form --}}
            <input type="hidden" name="children[]" value="{{ $child->id }}">
        </div>
        @endforeach
    </div>

    {{-- Search box --}}
    <div class="relative mb-2">
        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
        <input type="text"
               id="child-search-input"
               placeholder="Search by name or code..."
               oninput="filterChildren(this.value)"
               onfocus="openChildDropdown()"
               autocomplete="off"
               class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none transition bg-white">
    </div>

    {{-- Dropdown --}}
    <div id="child-dropdown"
         class="hidden border border-gray-200 rounded-xl overflow-hidden shadow-lg bg-white max-h-56 overflow-y-auto">

        @if($children->isEmpty())
        <div class="px-4 py-6 text-center text-xs text-gray-400">
            <i class="fas fa-child text-2xl text-gray-200 block mb-2"></i>
            No active sponsored children found.
        </div>
        @else
        @foreach($children as $child)
        <div class="child-option flex items-center gap-3 px-3 py-2.5 cursor-pointer transition hover:bg-orange-50 border-b border-gray-50 last:border-0"
             data-id="{{ $child->id }}"
             data-name="{{ $child->first_name }}"
             data-code="{{ $child->code }}"
             data-photo="{{ asset($child->profile_photo) }}"
             data-search="{{ strtolower($child->first_name . ' ' . $child->code) }}"
             id="child-opt-{{ $child->id }}">
            {{-- Checkbox visual --}}
            <div class="child-opt-check w-5 h-5 rounded-md border-2 flex-shrink-0 flex items-center justify-center transition-all
                        {{ in_array($child->id, $selectedChildIds) ? 'bg-orange-500 border-orange-500' : 'bg-white border-gray-300' }}">
                <i class="fas fa-check text-white text-[9px] {{ in_array($child->id, $selectedChildIds) ? '' : 'hidden' }}"></i>
            </div>
            <img src="{{ asset($child->profile_photo) }}"
                 class="w-8 h-8 rounded-full object-cover flex-shrink-0 border border-gray-200"
                 onerror="this.src='{{ asset('images/child-placeholder.jpg') }}'">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 leading-tight truncate">{{ $child->first_name }}</p>
                @if($child->code)
                <p class="text-xs text-gray-400">{{ $child->code }}</p>
                @endif
            </div>
        </div>
        @endforeach

        {{-- No results message --}}
        <div id="child-no-results" class="hidden px-4 py-4 text-center text-xs text-gray-400">
            <i class="fas fa-search text-gray-200 block text-xl mb-1"></i>
            No children match your search.
        </div>
        @endif
    </div>

    {{-- Empty state hint --}}
    <p id="child-empty-hint" class="text-xs text-gray-400 mt-2 {{ count($selectedChildIds) ? 'hidden' : '' }}">
        <i class="fas fa-info-circle text-orange-300 mr-1"></i>No children linked yet. Search above to add.
    </p>
</div>

@once
@push('scripts')
<script>
(function () {
    // ── Data store ────────────────────────────────────────────────────────
    const _childSelected = new Set(
        [...document.querySelectorAll('input[name="children[]"]')].map(i => parseInt(i.value))
    );

    const _childPlaceholder = '{{ asset('images/child-placeholder.jpg') }}';

    // ── Dropdown ──────────────────────────────────────────────────────────
    function openChildDropdown() {
        document.getElementById('child-dropdown').classList.remove('hidden');
    }

    function filterChildren(q) {
        q = q.toLowerCase().trim();
        let visible = 0;
        document.querySelectorAll('.child-option').forEach(opt => {
            const match = !q || opt.dataset.search.includes(q);
            opt.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        document.getElementById('child-no-results').classList.toggle('hidden', visible > 0 || !q);
        openChildDropdown();
    }

    // ── Add / Remove ──────────────────────────────────────────────────────
    function addChild(id, name, code, photo) {
        id = parseInt(id);
        if (_childSelected.has(id)) return;
        _childSelected.add(id);

        const chip = document.createElement('div');
        chip.className = 'child-chip flex items-center gap-1.5 pl-1 pr-2 py-1 bg-orange-50 border border-orange-200 rounded-full text-xs font-semibold text-orange-700';
        chip.dataset.id = id;
        chip.innerHTML = `
            <img src="${photo}" class="w-5 h-5 rounded-full object-cover border border-orange-300" onerror="this.src='${_childPlaceholder}'">
            <span>${name}${code ? ' (' + code + ')' : ''}</span>
            <button type="button" data-remove-child="${id}" class="child-remove-btn ml-0.5 w-4 h-4 flex items-center justify-center rounded-full hover:bg-orange-200 transition">
                <i class="fas fa-times text-[9px] pointer-events-none"></i>
            </button>
            <input type="hidden" name="children[]" value="${id}">
        `;
        document.getElementById('child-chips').appendChild(chip);

        const optBox = document.querySelector(`#child-opt-${id} .child-opt-check`);
        if (optBox) {
            optBox.classList.add('bg-orange-500', 'border-orange-500');
            optBox.classList.remove('bg-white', 'border-gray-300');
            optBox.querySelector('i').classList.remove('hidden');
        }

        _refreshChildUI();
    }

    function removeChild(id) {
        id = parseInt(id);
        _childSelected.delete(id);

        const chip = document.querySelector(`.child-chip[data-id="${id}"]`);
        if (chip) chip.remove();

        const optBox = document.querySelector(`#child-opt-${id} .child-opt-check`);
        if (optBox) {
            optBox.classList.remove('bg-orange-500', 'border-orange-500');
            optBox.classList.add('bg-white', 'border-gray-300');
            optBox.querySelector('i').classList.add('hidden');
        }

        _refreshChildUI();
    }

    function clearAllChildren() {
        [..._childSelected].forEach(id => removeChild(id));
    }

    function _refreshChildUI() {
        const count = _childSelected.size;
        document.getElementById('child-count-badge').textContent = count;
        document.getElementById('child-chips').classList.toggle('hidden', count === 0);
        document.getElementById('child-clear-all-btn').classList.toggle('hidden', count === 0);
        document.getElementById('child-empty-hint').classList.toggle('hidden', count > 0);
    }

    // ── Event delegation on the whole card ───────────────────────────────
    document.getElementById('child-picker-card').addEventListener('click', function (e) {
        // Clear all button
        if (e.target.closest('#child-clear-all-btn')) {
            clearAllChildren();
            return;
        }

        // Remove (×) button on a chip — matches button or the <i> inside it
        const removeBtn = e.target.closest('[data-remove-child]');
        if (removeBtn) {
            removeChild(removeBtn.dataset.removeChild);
            return;
        }

        // Dropdown option row
        const option = e.target.closest('.child-option');
        if (option) {
            const id = parseInt(option.dataset.id);
            if (_childSelected.has(id)) {
                removeChild(id);
            } else {
                addChild(id, option.dataset.name, option.dataset.code, option.dataset.photo);
            }
            return;
        }

        // Search input — open dropdown (handled by onfocus too, but just in case)
        if (e.target.id === 'child-search-input') {
            openChildDropdown();
        }
    });

    // Expose filterChildren globally (called via oninput on the input)
    window.filterChildren  = filterChildren;
    window.openChildDropdown = openChildDropdown;

    // Close dropdown on outside click
    document.addEventListener('click', function (e) {
        if (!e.target.closest('#child-picker-card')) {
            const dd = document.getElementById('child-dropdown');
            if (dd) dd.classList.add('hidden');
        }
    });
})();
</script>
@endpush
@endonce