{{-- resources/views/admin/family-members/edit.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Edit Member')
@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.family-members.show', $member) }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-arrow-left text-gray-600"></i>
    </a>
    <div class="flex-1"><h1 class="page-title">Edit Member</h1><p class="page-subtitle">{{ $member->name }}</p></div>
    <a href="{{ route('admin.family-members.show', $member) }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium transition">
        <i class="fas fa-eye mr-1"></i>View
    </a>
</div>

{{-- Banner --}}
<div class="card mb-6" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);border-color:#fed7aa">
    <div class="flex items-center gap-4">
        @if($member->profile_photo)
        <img src="{{ asset($member->profile_photo) }}" class="w-14 h-14 rounded-2xl object-cover flex-shrink-0 shadow border-2 border-orange-200">
        @else
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center flex-shrink-0 shadow">
            <span class="text-2xl font-black text-white">{{ strtoupper(substr($member->name,0,1)) }}</span>
        </div>
        @endif
        <div>
            <h3 class="font-black text-gray-800 text-lg">{{ $member->name }}</h3>
            <div class="flex items-center gap-2 mt-1">
                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">{{ $member->relationship }}</span>
                @if($member->family)
                <span class="px-2 py-0.5 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">
                    <i class="fas fa-home text-xs mr-1"></i>{{ $member->family->name }}
                </span>
                @endif
                <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $member->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-500' }}">
                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.family-members.update', $member) }}" method="POST" enctype="multipart/form-data" id="edit-form">
    @csrf @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">

            <div class="card">
                <h3 class="font-bold text-gray-800 mb-5 flex items-center gap-2"><i class="fas fa-user text-orange-500"></i> Member Details</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $member->name) }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('name') border-red-500 @enderror">
                        @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Relationship <span class="text-red-500">*</span></label>
                            @php $isCustom = !in_array(old('relationship', $member->relationship), ['Father','Mother','Son','Daughter','Guardian','Grandfather','Grandmother','Uncle','Aunt','Brother','Sister','Other']); @endphp
                            <div class="relative">
                                <select name="{{ $isCustom ? '_relationship_select' : 'relationship' }}"
                                        id="relationship-select"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none appearance-none bg-white"
                                        onchange="handleCustomRelationship(this)">
                                    @foreach($relationships as $rel)
                                    <option value="{{ $rel }}" {{ old('relationship', $member->relationship) === $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                    @endforeach
                                    <option value="__custom__" {{ $isCustom ? 'selected' : '' }}>Custom...</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                            </div>
                            <input type="text" id="custom-relationship"
                                   name="{{ $isCustom ? 'relationship' : 'relationship_custom' }}"
                                   value="{{ $isCustom ? old('relationship', $member->relationship) : '' }}"
                                   placeholder="Enter custom relationship..."
                                   class="mt-2 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none text-sm {{ $isCustom ? '' : 'hidden' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <div class="flex items-center justify-between px-4 py-2.5 border border-gray-300 rounded-lg h-[42px]">
                                <span class="text-sm text-gray-600">Active</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-orange-500"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-phone text-gray-400 mr-1"></i>Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none"
                                   placeholder="+855 xx xxx xxxx">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-envelope text-gray-400 mr-1"></i>Email</label>
                            <input type="email" name="email" value="{{ old('email', $member->email) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('email') border-red-500 @enderror">
                            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Family assignment --}}
            <div class="card" id="family-picker-card">
                <h3 class="font-bold text-gray-800 mb-1 flex items-center gap-2">
                    <i class="fas fa-home text-orange-500"></i> Family Assignment
                    <span class="text-red-500 text-sm">*</span>
                </h3>
                <p class="text-xs text-gray-400 mb-4">Change which family this member belongs to</p>

                <input type="hidden" name="family_id" id="family_id_input" value="{{ old('family_id', $member->family_id) }}" required>

                <div id="selected-family-card" class="{{ $member->family ? '' : 'hidden' }} mb-4">
                    <div class="flex items-center gap-3 p-4 bg-orange-50 border-2 border-orange-300 rounded-2xl relative">
                        <div id="selected-family-photo" class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 border-2 border-orange-200 bg-orange-100 flex items-center justify-center">
                            @if($member->family?->profile_photo)
                            <img src="{{ $member->family->profile_photo_url }}" class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-home text-orange-300 text-xl"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p id="selected-family-name" class="font-black text-gray-800 text-base">{{ $member->family?->name }}</p>
                            <p id="selected-family-meta" class="text-xs text-gray-500 mt-0.5">
                                {{ $member->family?->code }}{{ $member->family?->country ? ' · '.$member->family->country : '' }}
                            </p>
                        </div>
                        <button type="button" onclick="clearFamilySelection()"
                                class="absolute top-2 right-2 w-7 h-7 flex items-center justify-center bg-white hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-full shadow transition">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                        <i class="fas fa-check-circle text-2xl text-orange-400 flex-shrink-0"></i>
                    </div>
                </div>

                <div id="family-search-area" class="{{ $member->family ? 'hidden' : '' }}">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"></i>
                        <input type="text" id="family-search-input"
                               placeholder="Search families..."
                               oninput="searchFamilies(this.value)"
                               onfocus="openFamilyList()"
                               autocomplete="off"
                               class="w-full pl-9 pr-4 py-3 border-2 border-dashed border-gray-300 rounded-xl focus:border-orange-400 outline-none text-sm transition">
                    </div>
                    <div id="family-list" class="hidden mt-2 border border-gray-200 rounded-2xl overflow-hidden shadow-xl bg-white max-h-64 overflow-y-auto">
                        @foreach($families as $family)
                        <div class="family-row flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-orange-50 border-b border-gray-50 last:border-0 transition {{ $family->id == $member->family_id ? 'bg-orange-50' : '' }}"
                             data-id="{{ $family->id }}"
                             data-name="{{ $family->name }}"
                             data-code="{{ $family->code }}"
                             data-country="{{ $family->country }}"
                             data-photo="{{ $family->profile_photo_url }}"
                             data-has-photo="{{ $family->profile_photo ? '1' : '0' }}"
                             data-search="{{ strtolower($family->name . ' ' . $family->code . ' ' . $family->country) }}"
                             onclick="selectFamily(this)">
                            @if($family->profile_photo)
                            <img src="{{ $family->profile_photo_url }}" class="w-9 h-9 rounded-xl object-cover flex-shrink-0 border border-gray-200">
                            @else
                            <div class="w-9 h-9 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-home text-orange-400 text-sm"></i>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-800 text-sm">{{ $family->name }}</p>
                                <p class="text-xs text-gray-400">{{ $family->code }}{{ $family->country ? ' · '.$family->country : '' }}</p>
                            </div>
                            @if($family->id == $member->family_id)
                            <i class="fas fa-check text-orange-500 text-xs"></i>
                            @endif
                        </div>
                        @endforeach
                        <div id="family-no-results" class="hidden px-4 py-5 text-center text-sm text-gray-400">No families match.</div>
                    </div>
                    @error('family_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Photo --}}
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-camera text-orange-500"></i> Profile Photo</h3>
                <div class="flex justify-center mb-4">
                    <div class="relative">
                        <div id="avatar-preview" class="w-28 h-28 rounded-2xl overflow-hidden border-4 border-orange-100 shadow">
                            @if($member->profile_photo)
                            <img id="avatar-img" src="{{ asset($member->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                                <span id="avatar-initials" class="text-4xl font-black text-white">{{ strtoupper(substr($member->name,0,1)) }}</span>
                            </div>
                            @endif
                        </div>
                        <button type="button" onclick="document.getElementById('profile_photo').click()"
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center shadow transition">
                            <i class="fas fa-camera text-xs"></i>
                        </button>
                    </div>
                </div>
                @if($member->profile_photo)
                <label class="flex items-center justify-center gap-2 cursor-pointer mb-3">
                    <input type="checkbox" name="remove_photo" value="1" onchange="toggleUpload(this)" class="rounded border-gray-300 text-orange-500">
                    <span class="text-sm text-red-500 font-medium">Remove current photo</span>
                </label>
                @endif
                <div id="upload-area" class="{{ $member->profile_photo ? 'hidden' : '' }} border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-orange-400 transition cursor-pointer group"
                     onclick="document.getElementById('profile_photo').click()">
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                    <p class="text-sm text-gray-500 font-medium group-hover:text-orange-500">{{ $member->profile_photo ? 'Replace photo' : 'Upload photo' }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">JPG, PNG · Max 2MB</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card space-y-3">
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition shadow-sm">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('admin.family-members.show', $member) }}" class="block w-full px-4 py-3 border border-gray-200 text-gray-500 text-center rounded-xl hover:bg-gray-50 text-sm font-medium">Cancel</a>
                <button type="button"
                        onclick="document.getElementById('delete-form').submit()"
                        onmousedown="return confirm('Delete {{ addslashes($member->name) }}?')"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition border border-red-200 text-sm">
                    <i class="fas fa-trash"></i> Delete Member
                </button>
            </div>
        </div>
    </div>
</form>

<form id="delete-form" action="{{ route('admin.family-members.destroy', $member) }}" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>

@push('scripts')
<script>
function handleCustomRelationship(select) {
    const custom = document.getElementById('custom-relationship');
    if (select.value === '__custom__') {
        custom.classList.remove('hidden');
        custom.setAttribute('name', 'relationship');
        select.setAttribute('name', '_relationship_select');
        custom.focus();
    } else {
        custom.classList.add('hidden');
        custom.setAttribute('name', 'relationship_custom');
        select.setAttribute('name', 'relationship');
    }
}

function openFamilyList() { document.getElementById('family-list').classList.remove('hidden'); }

function searchFamilies(q) {
    q = q.toLowerCase().trim();
    let v = 0;
    document.querySelectorAll('.family-row').forEach(r => {
        const m = !q || r.dataset.search.includes(q);
        r.style.display = m ? '' : 'none';
        if (m) v++;
    });
    document.getElementById('family-no-results').classList.toggle('hidden', v > 0 || !q);
    openFamilyList();
}

function selectFamily(el) {
    document.getElementById('family_id_input').value = el.dataset.id;
    const photoEl = document.getElementById('selected-family-photo');
    photoEl.innerHTML = el.dataset.hasPhoto === '1'
        ? `<img src="${el.dataset.photo}" class="w-full h-full object-cover">`
        : `<i class="fas fa-home text-orange-300 text-xl"></i>`;
    document.getElementById('selected-family-name').textContent = el.dataset.name;
    document.getElementById('selected-family-meta').textContent = el.dataset.code + (el.dataset.country ? ' · ' + el.dataset.country : '');
    document.getElementById('selected-family-card').classList.remove('hidden');
    document.getElementById('family-search-area').classList.add('hidden');
}

function clearFamilySelection() {
    document.getElementById('family_id_input').value = '';
    document.getElementById('selected-family-card').classList.add('hidden');
    document.getElementById('family-search-area').classList.remove('hidden');
    setTimeout(() => document.getElementById('family-search-input').focus(), 50);
}

function previewPhoto(e) {
    const f = e.target.files[0]; if (!f) return;
    const r = new FileReader();
    r.onload = ev => {
        document.getElementById('avatar-preview').innerHTML =
            `<img id="avatar-img" src="${ev.target.result}" class="w-full h-full object-cover">`;
        document.getElementById('upload-area').classList.add('hidden');
    };
    r.readAsDataURL(f);
}

function toggleUpload(cb) {
    document.getElementById('upload-area').classList.toggle('hidden', !cb.checked);
}

document.addEventListener('click', e => {
    if (!e.target.closest('#family-picker-card')) {
        const fl = document.getElementById('family-list');
        if (fl) fl.classList.add('hidden');
    }
});
</script>
@endpush
@endsection