{{-- resources/views/admin/sponsors/partials/_children_picker.blade.php --}}
{{--
    Props:
      $children          — Collection of all active SponsoredChild
      $selectedChildIds  — array of already-selected IDs
--}}
@php $selectedChildIds = $selectedChildIds ?? []; @endphp

<div class="card" id="children-picker-card">
    <div class="flex items-center justify-between mb-1">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-child text-orange-500"></i> Sponsored Children
            <span class="ml-1 inline-flex items-center justify-center w-5 h-5 rounded-full bg-orange-100 text-orange-600 text-[10px] font-black" id="children-count-badge">
                {{ count($selectedChildIds) }}
            </span>
        </h3>
        <button type="button" id="children-clear-all"
                onclick="clearAllSponsorChildren()"
                class="text-xs text-red-400 hover:text-red-600 {{ count($selectedChildIds) ? '' : 'hidden' }}">
            Clear all
        </button>
    </div>
    <p class="text-xs text-gray-400 mb-3">Assign one or more children to this sponsor</p>

    {{-- Selected chips --}}
    <div id="children-chips" class="flex flex-wrap gap-2 mb-3 {{ count($selectedChildIds) ? '' : 'hidden' }}">
        @foreach($children->whereIn('id', $selectedChildIds) as $child)
        <div class="sponsor-child-chip flex items-center gap-1.5 pl-1 pr-2 py-1 bg-purple-50 border border-purple-200 rounded-full text-xs font-semibold text-purple-700"
             data-id="{{ $child->id }}">
            <img src="{{ asset($child->profile_photo) }}"
                 class="w-5 h-5 rounded-full object-cover border border-purple-300"
                 onerror="this.src='{{ asset('images/child-placeholder.jpg') }}'">
            <span>{{ $child->first_name }}{{ $child->code ? ' ('.$child->code.')' : '' }}</span>
            <button type="button" onclick="removeSponsorChild({{ $child->id }})"
                    class="ml-0.5 w-4 h-4 flex items-center justify-center rounded-full hover:bg-purple-200 transition">
                <i class="fas fa-times text-[9px]"></i>
            </button>
            <input type="hidden" name="children[]" value="{{ $child->id }}">
        </div>
        @endforeach
    </div>

    {{-- Search --}}
    <div class="relative mb-2">
        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
        <input type="text"
               id="sponsor-child-search"
               placeholder="Search by name or code..."
               oninput="filterSponsorChildren(this.value)"
               onfocus="openSponsorChildDropdown()"
               autocomplete="off"
               class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none transition">
    </div>

    {{-- Dropdown --}}
    <div id="sponsor-child-dropdown"
         class="hidden border border-gray-200 rounded-xl overflow-hidden shadow-lg bg-white max-h-56 overflow-y-auto">

        @if($children->isEmpty())
        <div class="px-4 py-6 text-center text-xs text-gray-400">
            <i class="fas fa-child text-2xl text-gray-200 block mb-2"></i>
            No active sponsored children found.
        </div>
        @else
        @foreach($children as $child)
        <div class="sponsor-child-option flex items-center gap-3 px-3 py-2.5 cursor-pointer transition hover:bg-purple-50 border-b border-gray-50 last:border-0"
             data-id="{{ $child->id }}"
             data-name="{{ $child->first_name }}"
             data-code="{{ $child->code }}"
             data-photo="{{ asset($child->profile_photo) }}"
             data-search="{{ strtolower($child->first_name . ' ' . $child->code) }}"
             onclick="toggleSponsorChild(this)"
             id="sponsor-child-opt-{{ $child->id }}">
            <div class="sponsor-child-check w-5 h-5 rounded-md border-2 flex-shrink-0 flex items-center justify-center transition-all
                        {{ in_array($child->id, $selectedChildIds) ? 'bg-purple-500 border-purple-500' : 'bg-white border-gray-300' }}">
                <i class="fas fa-check text-white text-[9px] {{ in_array($child->id, $selectedChildIds) ? '' : 'hidden' }}"></i>
            </div>
            <img src="{{ asset($child->profile_photo) }}"
                 class="w-8 h-8 rounded-full object-cover flex-shrink-0 border border-gray-200"
                 onerror="this.src='{{ asset('images/child-placeholder.jpg') }}'">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 leading-tight truncate">{{ $child->first_name }}</p>
                @if($child->code)
                <p class="text-xs text-gray-400">{{ $child->code }}{{ $child->country ? ' · '.$child->country : '' }}</p>
                @endif
            </div>
        </div>
        @endforeach
        <div id="sponsor-child-no-results" class="hidden px-4 py-4 text-center text-xs text-gray-400">
            <i class="fas fa-search text-gray-200 block text-xl mb-1"></i>
            No children match your search.
        </div>
        @endif
    </div>

    {{-- Empty hint --}}
    <p id="sponsor-child-empty-hint" class="text-xs text-gray-400 mt-2 {{ count($selectedChildIds) ? 'hidden' : '' }}">
        <i class="fas fa-info-circle text-orange-300 mr-1"></i>No children assigned. Search above to add.
    </p>
</div>

@once
@push('scripts')
<script>
const _sponsorChildSelected = new Set(
    [...document.querySelectorAll('input[name="children[]"]')].map(i => parseInt(i.value))
);

function openSponsorChildDropdown() {
    document.getElementById('sponsor-child-dropdown').classList.remove('hidden');
}

function filterSponsorChildren(q) {
    q = q.toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('.sponsor-child-option').forEach(opt => {
        const match = !q || opt.dataset.search.includes(q);
        opt.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('sponsor-child-no-results').classList.toggle('hidden', visible > 0 || !q);
    openSponsorChildDropdown();
}

function toggleSponsorChild(el) {
    const id = parseInt(el.dataset.id);
    _sponsorChildSelected.has(id)
        ? removeSponsorChild(id)
        : addSponsorChild(id, el.dataset.name, el.dataset.code, el.dataset.photo);
}

function addSponsorChild(id, name, code, photo) {
    if (_sponsorChildSelected.has(id)) return;
    _sponsorChildSelected.add(id);

    const chip = document.createElement('div');
    chip.className = 'sponsor-child-chip flex items-center gap-1.5 pl-1 pr-2 py-1 bg-purple-50 border border-purple-200 rounded-full text-xs font-semibold text-purple-700';
    chip.dataset.id = id;
    chip.innerHTML = `
        <img src="${photo}" class="w-5 h-5 rounded-full object-cover border border-purple-300" onerror="this.src='{{ asset('images/child-placeholder.jpg') }}'">
        <span>${name}${code ? ' ('+code+')' : ''}</span>
        <button type="button" onclick="removeSponsorChild(${id})" class="ml-0.5 w-4 h-4 flex items-center justify-center rounded-full hover:bg-purple-200 transition">
            <i class="fas fa-times text-[9px]"></i>
        </button>
        <input type="hidden" name="children[]" value="${id}">
    `;
    document.getElementById('children-chips').appendChild(chip);

    const box = document.querySelector(`#sponsor-child-opt-${id} .sponsor-child-check`);
    if (box) {
        box.classList.add('bg-purple-500','border-purple-500');
        box.classList.remove('bg-white','border-gray-300');
        box.querySelector('i').classList.remove('hidden');
    }
    _refreshSponsorChildUI();
}

function removeSponsorChild(id) {
    id = parseInt(id);
    _sponsorChildSelected.delete(id);

    const chip = document.querySelector(`.sponsor-child-chip[data-id="${id}"]`);
    if (chip) chip.remove();

    const box = document.querySelector(`#sponsor-child-opt-${id} .sponsor-child-check`);
    if (box) {
        box.classList.remove('bg-purple-500','border-purple-500');
        box.classList.add('bg-white','border-gray-300');
        box.querySelector('i').classList.add('hidden');
    }
    _refreshSponsorChildUI();
}

function clearAllSponsorChildren() {
    [..._sponsorChildSelected].forEach(id => removeSponsorChild(id));
}

function _refreshSponsorChildUI() {
    const count = _sponsorChildSelected.size;
    document.getElementById('children-count-badge').textContent = count;
    document.getElementById('children-chips').classList.toggle('hidden', count === 0);
    document.getElementById('children-clear-all').classList.toggle('hidden', count === 0);
    document.getElementById('sponsor-child-empty-hint').classList.toggle('hidden', count > 0);
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#children-picker-card')) {
        const dd = document.getElementById('sponsor-child-dropdown');
        if (dd) dd.classList.add('hidden');
    }
});
</script>
@endpush
@endonce