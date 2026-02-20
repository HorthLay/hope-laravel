{{--
    Props:
      $families          — Collection of all active Families
      $selectedFamilyIds — array of already-selected IDs (old input or existing pivot)
--}}
@php
    $selectedFamilyIds = $selectedFamilyIds ?? [];
    $selectedFamilies = $families->whereIn('id', $selectedFamilyIds);
@endphp

<div class="card" id="family-picker-card">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-1">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-users text-purple-500"></i> Families
            <span class="ml-1 inline-flex items-center justify-center w-5 h-5 rounded-full bg-purple-100 text-purple-600 text-[10px] font-black" id="family-count-badge">
                {{ count($selectedFamilyIds) }}
            </span>
        </h3>
        <button type="button" id="family-clear-all-btn"
                onclick="clearAllFamilies()"
                class="text-xs text-red-400 hover:text-red-600 {{ count($selectedFamilyIds) ? '' : 'hidden' }}">
            Clear all
        </button>
    </div>
    <p class="text-xs text-gray-400 mb-3">Link this article to one or more families</p>

    {{-- Selected chips --}}
    <div id="family-chips" class="flex flex-wrap gap-2 mb-3 {{ count($selectedFamilyIds) ? '' : 'hidden' }}">
        @foreach($selectedFamilies as $family)
        <div class="family-chip flex items-center gap-1.5 pl-1 pr-2 py-1 bg-purple-50 border border-purple-200 rounded-full text-xs font-semibold text-purple-700"
             data-id="{{ $family->id }}">
            <img src="{{ asset($family->profile_photo) }}"
                 class="w-5 h-5 rounded-full object-cover border border-purple-300"
                 onerror="this.src='{{ asset('images/family-placeholder.jpg') }}'">
            <span>{{ $family->name }}{{ $family->code ? ' ('.$family->code.')' : '' }}</span>
            <button type="button" onclick="removeFamily({{ $family->id }})"
                    class="ml-0.5 w-4 h-4 flex items-center justify-center rounded-full hover:bg-purple-200 transition">
                <i class="fas fa-times text-[9px]"></i>
            </button>
            {{-- Hidden input submitted with form --}}
            <input type="hidden" name="families[]" value="{{ $family->id }}">
        </div>
        @endforeach
    </div>

    {{-- Search box --}}
    <div class="relative mb-2">
        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
        <input type="text"
               id="family-search-input"
               placeholder="Search by name or code..."
               oninput="filterFamilies(this.value)"
               onfocus="openFamilyDropdown()"
               autocomplete="off"
               class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none transition bg-white">
    </div>

    {{-- Dropdown --}}
    <div id="family-dropdown"
         class="hidden border border-gray-200 rounded-xl overflow-hidden shadow-lg bg-white max-h-56 overflow-y-auto">

        @if($families->isEmpty())
        <div class="px-4 py-6 text-center text-xs text-gray-400">
            <i class="fas fa-users text-2xl text-gray-200 block mb-2"></i>
            No active families found.
        </div>
        @else
        @foreach($families as $family)
        <div class="family-option flex items-center gap-3 px-3 py-2.5 cursor-pointer transition hover:bg-purple-50 border-b border-gray-50 last:border-0"
             data-id="{{ $family->id }}"
             data-name="{{ $family->name }}"
             data-code="{{ $family->code }}"
             data-photo="{{ asset($family->profile_photo) }}"
             data-search="{{ strtolower($family->name . ' ' . $family->code) }}"
             onclick="toggleFamily(this)"
             id="family-opt-{{ $family->id }}">
            {{-- Checkbox visual --}}
            <div class="family-opt-check w-5 h-5 rounded-md border-2 flex-shrink-0 flex items-center justify-center transition-all
                        {{ in_array($family->id, $selectedFamilyIds) ? 'bg-purple-500 border-purple-500' : 'bg-white border-gray-300' }}">
                <i class="fas fa-check text-white text-[9px] {{ in_array($family->id, $selectedFamilyIds) ? '' : 'hidden' }}"></i>
            </div>
            <img src="{{ asset($family->profile_photo) }}"
                 class="w-8 h-8 rounded-full object-cover flex-shrink-0 border border-gray-200"
                 onerror="this.src='{{ asset('images/family-placeholder.jpg') }}'">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 leading-tight truncate">{{ $family->name }}</p>
                @if($family->code)
                <p class="text-xs text-gray-400">{{ $family->code }}</p>
                @endif
            </div>
        </div>
        @endforeach

        {{-- No results message --}}
        <div id="family-no-results" class="hidden px-4 py-4 text-center text-xs text-gray-400">
            <i class="fas fa-search text-gray-200 block text-xl mb-1"></i>
            No families match your search.
        </div>
        @endif
    </div>

    {{-- Empty state hint --}}
    <p id="family-empty-hint" class="text-xs text-gray-400 mt-2 {{ count($selectedFamilyIds) ? 'hidden' : '' }}">
        <i class="fas fa-info-circle text-purple-300 mr-1"></i>No families linked yet. Search above to add.
    </p>
</div>

@once
@push('scripts')
<script>
// ── Data store ────────────────────────────────────────────────────────
// Tracks currently selected IDs in JS (mirror of the hidden inputs)
const _familySelected = new Set(
    [...document.querySelectorAll('input[name="families[]"]')].map(i => parseInt(i.value))
);

function openFamilyDropdown() {
    document.getElementById('family-dropdown').classList.remove('hidden');
}

function filterFamilies(q) {
    q = q.toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('.family-option').forEach(opt => {
        const match = !q || opt.dataset.search.includes(q);
        opt.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('family-no-results').classList.toggle('hidden', visible > 0 || !q);
    openFamilyDropdown();
}

function toggleFamily(el) {
    const id = parseInt(el.dataset.id);
    if (_familySelected.has(id)) {
        removeFamily(id);
    } else {
        addFamily(id, el.dataset.name, el.dataset.code, el.dataset.photo);
    }
}

function addFamily(id, name, code, photo) {
    if (_familySelected.has(id)) return;
    _familySelected.add(id);

    // Add chip
    const chip = document.createElement('div');
    chip.className = 'family-chip flex items-center gap-1.5 pl-1 pr-2 py-1 bg-purple-50 border border-purple-200 rounded-full text-xs font-semibold text-purple-700';
    chip.dataset.id = id;
    chip.innerHTML = `
        <img src="${photo}" class="w-5 h-5 rounded-full object-cover border border-purple-300" onerror="this.src='{{ asset('images/family-placeholder.jpg') }}'">
        <span>${name}${code ? ' ('+code+')' : ''}</span>
        <button type="button" onclick="removeFamily(${id})" class="ml-0.5 w-4 h-4 flex items-center justify-center rounded-full hover:bg-purple-200 transition">
            <i class="fas fa-times text-[9px]"></i>
        </button>
        <input type="hidden" name="families[]" value="${id}">
    `;
    document.getElementById('family-chips').appendChild(chip);

    // Update dropdown checkbox
    const optBox = document.querySelector(`#family-opt-${id} .family-opt-check`);
    if (optBox) {
        optBox.classList.add('bg-purple-500', 'border-purple-500');
        optBox.classList.remove('bg-white', 'border-gray-300');
        optBox.querySelector('i').classList.remove('hidden');
    }

    _refreshFamilyUI();
}

function removeFamily(id) {
    id = parseInt(id);
    _familySelected.delete(id);

    // Remove chip
    const chip = document.querySelector(`.family-chip[data-id="${id}"]`);
    if (chip) chip.remove();

    // Reset dropdown checkbox
    const optBox = document.querySelector(`#family-opt-${id} .family-opt-check`);
    if (optBox) {
        optBox.classList.remove('bg-purple-500', 'border-purple-500');
        optBox.classList.add('bg-white', 'border-gray-300');
        optBox.querySelector('i').classList.add('hidden');
    }

    _refreshFamilyUI();
}

function clearAllFamilies() {
    [..._familySelected].forEach(id => removeFamily(id));
}

function _refreshFamilyUI() {
    const count = _familySelected.size;
    document.getElementById('family-count-badge').textContent = count;
    document.getElementById('family-chips').classList.toggle('hidden', count === 0);
    document.getElementById('family-clear-all-btn').classList.toggle('hidden', count === 0);
    document.getElementById('family-empty-hint').classList.toggle('hidden', count > 0);
}

// Close dropdown on outside click
document.addEventListener('click', function(e) {
    if (!e.target.closest('#family-picker-card')) {
        const dd = document.getElementById('family-dropdown');
        if (dd) dd.classList.add('hidden');
    }
});
</script>
@endpush
@endonce
