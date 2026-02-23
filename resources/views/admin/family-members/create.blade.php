{{-- resources/views/admin/family-members/create.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Add Family Member')
@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.family-members.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-arrow-left text-gray-600"></i>
    </a>
    <div>
        <h1 class="page-title">Add Family Member</h1>
        <p class="page-subtitle">Create a new member and assign them to a family</p>
    </div>
</div>

<form action="{{ route('admin.family-members.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- Pass redirect_to_family flag if pre-selected --}}
    @if($selectedFamily)
    <input type="hidden" name="redirect_to_family" value="1">
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── MAIN ── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Member Info --}}
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
                    <i class="fas fa-user text-orange-500"></i> Member Details
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('name') border-red-500 @enderror"
                               placeholder="e.g. Chan Sopheak">
                        @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Relationship <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="relationship" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none appearance-none bg-white @error('relationship') border-red-500 @enderror"
                                        onchange="handleCustomRelationship(this)">
                                    <option value="">Select role...</option>
                                    @foreach($relationships as $rel)
                                    <option value="{{ $rel }}" {{ old('relationship') === $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                    @endforeach
                                    <option value="__custom__" {{ old('relationship') && !in_array(old('relationship'), $relationships) ? 'selected' : '' }}>Custom...</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                            </div>
                            <input type="text" id="custom-relationship" name="relationship_custom"
                                   value="{{ old('relationship') && !in_array(old('relationship'), $relationships) ? old('relationship') : '' }}"
                                   placeholder="Enter custom relationship..."
                                   class="mt-2 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none text-sm {{ old('relationship') && !in_array(old('relationship'), $relationships) ? '' : 'hidden' }}">
                            @error('relationship')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <div class="flex items-center justify-between px-4 py-2.5 border border-gray-300 rounded-lg h-[42px]">
                                <span class="text-sm text-gray-600">Active</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-orange-500"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-phone text-gray-400 mr-1"></i>Phone
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none"
                                   placeholder="+855 xx xxx xxxx">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-gray-400 mr-1"></i>Email
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('email') border-red-500 @enderror"
                                   placeholder="member@email.com">
                            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Family Picker --}}
            <div class="card" id="family-picker-card">
                <h3 class="font-bold text-gray-800 mb-1 flex items-center gap-2">
                    <i class="fas fa-home text-orange-500"></i> Assign to Family
                    <span class="text-red-500 text-sm">*</span>
                </h3>
                <p class="text-xs text-gray-400 mb-4">Select which family this member belongs to</p>

                {{-- Hidden input that holds the actual value --}}
                <input type="hidden" name="family_id" id="family_id_input" value="{{ old('family_id', $selectedFamily?->id) }}" required>

                {{-- Selected family card --}}
                <div id="selected-family-card" class="{{ old('family_id', $selectedFamily) ? '' : 'hidden' }} mb-4">
                    <div class="flex items-center gap-3 p-4 bg-orange-50 border-2 border-orange-300 rounded-2xl relative">
                        <div id="selected-family-photo" class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 border-2 border-orange-200 bg-orange-100 flex items-center justify-center">
                            @if($selectedFamily?->profile_photo)
                            <img src="{{ $selectedFamily->profile_photo_url }}" class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-home text-orange-300 text-xl"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p id="selected-family-name" class="font-black text-gray-800 text-base">{{ $selectedFamily?->name ?? '' }}</p>
                            <p id="selected-family-meta" class="text-xs text-gray-500 mt-0.5">
                                {{ $selectedFamily ? ($selectedFamily->code . ($selectedFamily->country ? ' · '.$selectedFamily->country : '')) : '' }}
                            </p>
                        </div>
                        <button type="button" onclick="clearFamilySelection()"
                                class="absolute top-2 right-2 w-7 h-7 flex items-center justify-center bg-white hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-full shadow transition">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                        <i class="fas fa-check-circle text-2xl text-orange-400 flex-shrink-0"></i>
                    </div>
                </div>

                {{-- Search + dropdown --}}
                <div id="family-search-area" class="{{ old('family_id', $selectedFamily) ? 'hidden' : '' }}">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"></i>
                        <input type="text" id="family-search-input"
                               placeholder="Search families by name or code..."
                               oninput="searchFamilies(this.value)"
                               onfocus="openFamilyList()"
                               autocomplete="off"
                               class="w-full pl-9 pr-4 py-3 border-2 border-dashed border-gray-300 rounded-xl focus:border-orange-400 focus:ring-0 outline-none text-sm transition">
                    </div>
                    <div id="family-list"
                         class="hidden mt-2 border border-gray-200 rounded-2xl overflow-hidden shadow-xl bg-white max-h-72 overflow-y-auto">
                        @forelse($families as $family)
                        <div class="family-row flex items-center gap-3 px-4 py-3.5 cursor-pointer hover:bg-orange-50 border-b border-gray-50 last:border-0 transition"
                             data-id="{{ $family->id }}"
                             data-name="{{ $family->name }}"
                             data-code="{{ $family->code }}"
                             data-country="{{ $family->country }}"
                             data-photo="{{ $family->profile_photo_url ?? '' }}"
                             data-has-photo="{{ $family->profile_photo ? '1' : '0' }}"
                             data-search="{{ strtolower($family->name . ' ' . $family->code . ' ' . $family->country) }}"
                             onclick="selectFamily(this)">
                            @if($family->profile_photo)
                            <img src="{{ $family->profile_photo_url }}"
                                 class="w-10 h-10 rounded-xl object-cover flex-shrink-0 border border-gray-200">
                            @else
                            <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-home text-orange-400"></i>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-800 text-sm">{{ $family->name }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $family->code }}{{ $family->country ? ' · '.$family->country : '' }}
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-300"></i>
                        </div>
                        @empty
                        <div class="px-4 py-8 text-center">
                            <i class="fas fa-home text-3xl text-gray-200 block mb-2"></i>
                            <p class="text-sm text-gray-400">No active families found.</p>
                            <a href="{{ route('admin.families.create') }}" class="mt-2 inline-block text-orange-500 text-sm hover:underline font-semibold">Create a family first →</a>
                        </div>
                        @endforelse
                        <div id="family-no-results" class="hidden px-4 py-6 text-center text-sm text-gray-400">No families match your search.</div>
                    </div>
                    @error('family_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ── SIDEBAR ── --}}
        <div class="space-y-6">

            {{-- Profile Photo --}}
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-camera text-orange-500"></i> Profile Photo
                </h3>
                {{-- Avatar preview --}}
                <div class="flex justify-center mb-4">
                    <div class="relative">
                        <div id="avatar-preview"
                             class="w-28 h-28 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center shadow-lg overflow-hidden">
                            <span id="avatar-initials" class="text-4xl font-black text-white">?</span>
                            <img id="avatar-img" src="" class="hidden w-full h-full object-cover absolute inset-0">
                        </div>
                        <button type="button" onclick="document.getElementById('profile_photo').click()"
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center shadow transition">
                            <i class="fas fa-camera text-xs"></i>
                        </button>
                    </div>
                </div>
                <div id="upload-area" class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-orange-400 transition cursor-pointer group"
                     onclick="document.getElementById('profile_photo').click()"
                     ondragover="event.preventDefault();this.classList.add('border-orange-400','bg-orange-50')"
                     ondragleave="this.classList.remove('border-orange-400','bg-orange-50')"
                     ondrop="handleDrop(event)">
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                    <p class="text-sm text-gray-500 font-medium group-hover:text-orange-500">Click or drag photo</p>
                    <p class="text-xs text-gray-400 mt-0.5">JPG, PNG · Max 2MB</p>
                </div>
                <div id="photo-actions" class="hidden mt-2 text-center">
                    <button type="button" onclick="removePhoto()" class="text-xs text-red-400 hover:text-red-600">
                        <i class="fas fa-times mr-1"></i>Remove photo
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <div class="card space-y-3">
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition shadow-sm">
                    <i class="fas fa-user-plus"></i> Add Member
                </button>
                <a href="{{ route('admin.family-members.index') }}" class="block w-full px-4 py-3 border border-gray-200 text-gray-500 text-center rounded-xl hover:bg-gray-50 text-sm font-medium">Cancel</a>
            </div>

            {{-- Tip --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <p class="text-xs text-blue-700 leading-relaxed">
                    <i class="fas fa-lightbulb text-blue-400 mr-1.5"></i>
                    <strong>Tip:</strong> You can also add members directly from a family's profile page.
                </p>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
// ── Name → avatar initials live update ───────────────────────────────
document.querySelector('input[name="name"]').addEventListener('input', function() {
    const words = this.value.trim().split(/\s+/);
    const initials = (words[0]?.[0] || '') + (words[1]?.[0] || '');
    document.getElementById('avatar-initials').textContent = initials.toUpperCase() || '?';
});

// ── Custom relationship ───────────────────────────────────────────────
function handleCustomRelationship(select) {
    const custom = document.getElementById('custom-relationship');
    if (select.value === '__custom__') {
        custom.classList.remove('hidden');
        custom.setAttribute('name', 'relationship');
        select.removeAttribute('name');
        custom.focus();
    } else {
        custom.classList.add('hidden');
        custom.removeAttribute('name');
        select.setAttribute('name', 'relationship');
    }
}

// ── Family picker ─────────────────────────────────────────────────────
function openFamilyList() {
    document.getElementById('family-list').classList.remove('hidden');
}

function searchFamilies(q) {
    q = q.toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('.family-row').forEach(row => {
        const match = !q || row.dataset.search.includes(q);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('family-no-results').classList.toggle('hidden', visible > 0 || !q);
    openFamilyList();
}

function selectFamily(el) {
    const id      = el.dataset.id;
    const name    = el.dataset.name;
    const code    = el.dataset.code;
    const country = el.dataset.country;
    const photo   = el.dataset.photo;
    const hasPhoto= el.dataset.hasPhoto === '1';

    // Set hidden input
    document.getElementById('family_id_input').value = id;

    // Update selected card
    const photoEl = document.getElementById('selected-family-photo');
    photoEl.innerHTML = hasPhoto
        ? `<img src="${photo}" class="w-full h-full object-cover">`
        : `<i class="fas fa-home text-orange-300 text-xl"></i>`;

    document.getElementById('selected-family-name').textContent = name;
    document.getElementById('selected-family-meta').textContent = code + (country ? ' · ' + country : '');

    // Show card, hide search
    document.getElementById('selected-family-card').classList.remove('hidden');
    document.getElementById('family-search-area').classList.add('hidden');
    document.getElementById('family-list').classList.add('hidden');
    document.getElementById('family-search-input').value = '';
}

function clearFamilySelection() {
    document.getElementById('family_id_input').value = '';
    document.getElementById('selected-family-card').classList.add('hidden');
    document.getElementById('family-search-area').classList.remove('hidden');
    setTimeout(() => document.getElementById('family-search-input').focus(), 50);
}

// ── Photo preview ─────────────────────────────────────────────────────
function previewPhoto(e) {
    const f = e.target.files[0];
    if (!f) return;
    const r = new FileReader();
    r.onload = ev => {
        document.getElementById('avatar-img').src = ev.target.result;
        document.getElementById('avatar-img').classList.remove('hidden');
        document.getElementById('avatar-initials').classList.add('hidden');
        document.getElementById('photo-actions').classList.remove('hidden');
        document.getElementById('upload-area').classList.add('hidden');
    };
    r.readAsDataURL(f);
}

function removePhoto() {
    document.getElementById('profile_photo').value = '';
    document.getElementById('avatar-img').classList.add('hidden');
    document.getElementById('avatar-initials').classList.remove('hidden');
    document.getElementById('photo-actions').classList.add('hidden');
    document.getElementById('upload-area').classList.remove('hidden');
}

function handleDrop(e) {
    e.preventDefault();
    e.currentTarget.classList.remove('border-orange-400','bg-orange-50');
    const f = e.dataTransfer.files[0];
    if (!f || !f.type.startsWith('image/')) return;
    const dt = new DataTransfer(); dt.items.add(f);
    document.getElementById('profile_photo').files = dt.files;
    const r = new FileReader();
    r.onload = ev => {
        document.getElementById('avatar-img').src = ev.target.result;
        document.getElementById('avatar-img').classList.remove('hidden');
        document.getElementById('avatar-initials').classList.add('hidden');
        document.getElementById('photo-actions').classList.remove('hidden');
        document.getElementById('upload-area').classList.add('hidden');
    };
    r.readAsDataURL(f);
}

// Close dropdown on outside click
document.addEventListener('click', e => {
    if (!e.target.closest('#family-picker-card')) {
        document.getElementById('family-list').classList.add('hidden');
    }
});
</script>
@endpush
@endsection