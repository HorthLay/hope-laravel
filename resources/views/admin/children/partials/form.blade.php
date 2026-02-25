{{-- resources/views/admin/children/partials/form.blade.php --}}
@php $isEdit = isset($child); @endphp

<div class="grid lg:grid-cols-3 gap-6">

    {{-- ══ LEFT: Photo + Status ══ --}}
    <div class="space-y-5">

        {{-- Photo --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="text-sm font-black text-gray-700 mb-4 flex items-center gap-2">
                <i class="fas fa-camera text-orange-400"></i> Profile Photo
            </h3>

            {{-- Preview --}}
            <div class="w-full aspect-square rounded-xl overflow-hidden bg-orange-50 mb-4 flex items-center justify-center">
                @if($isEdit && $child->profile_photo)
                    <img src="{{ asset($child->profile_photo) }}"
                         alt="{{ $child->first_name }}"
                         class="w-full h-full object-cover" id="photo-preview">
                    <div id="photo-placeholder" class="text-center hidden">
                        <i class="fas fa-child text-orange-200 text-5xl mb-2 block"></i>
                        <p class="text-xs text-gray-400">No photo</p>
                    </div>
                @else
                    <img id="photo-preview" class="w-full h-full object-cover hidden" src="" alt="">
                    <div id="photo-placeholder" class="text-center">
                        <i class="fas fa-child text-orange-200 text-5xl mb-2 block"></i>
                        <p class="text-xs text-gray-400">No photo uploaded</p>
                    </div>
                @endif
            </div>

            <label class="flex items-center justify-center gap-2 w-full py-2.5 border-2 border-dashed border-orange-200 hover:border-orange-400 rounded-xl cursor-pointer text-sm font-bold text-orange-500 hover:text-orange-600 transition">
                <i class="fas fa-upload text-xs"></i> Upload Photo
                <input type="file" name="profile_photo" accept="image/*" class="hidden"
                       onchange="previewPhoto(this)">
            </label>
            <p class="text-center text-xs text-gray-400 mt-1.5">JPG, PNG · max 2 MB</p>

            @if($isEdit && $child->profile_photo)
            <label class="flex items-center gap-2 mt-3 cursor-pointer">
                <input type="checkbox" name="remove_photo" value="1" class="rounded accent-red-500">
                <span class="text-xs text-red-500 font-semibold">Remove current photo</span>
            </label>
            @endif
        </div>

        {{-- Active toggle --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="text-sm font-black text-gray-700 mb-4 flex items-center gap-2">
                <i class="fas fa-toggle-on text-green-400"></i> Status
            </h3>
            <label class="flex items-center justify-between cursor-pointer p-3 rounded-xl border-2 border-gray-100 hover:border-green-200 transition select-none">
                <div>
                    <p class="text-sm font-bold text-gray-700">Active</p>
                    <p class="text-xs text-gray-400">Child is visible and sponsorable</p>
                </div>
                <div class="relative">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                           id="is_active_toggle"
                           {{ ($isEdit ? $child->is_active : true) ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-checked:bg-green-500 rounded-full transition-colors duration-200"></div>
                    <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></div>
                </div>
            </label>
        </div>

        {{-- Has Family toggle --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="text-sm font-black text-gray-700 mb-4 flex items-center gap-2">
                <i class="fas fa-toggle-on text-green-400"></i> Has Family
            </h3>
            <label class="flex items-center justify-between cursor-pointer p-3 rounded-xl border-2 border-gray-100 hover:border-green-200 transition select-none">
                <div>
                    <p class="text-sm font-bold text-gray-700">Has Family</p>
                    <p class="text-xs text-gray-400">Child has a family</p>
                </div>
                <div class="relative">
                    <input type="hidden" name="has_family" value="0">
                    <input type="checkbox" name="has_family" value="1"
                           id="has_family_toggle"
                           {{ ($isEdit ? $child->has_family : false) ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-checked:bg-green-500 rounded-full transition-colors duration-200"></div>
                    <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></div>
                </div>
            </label>
        </div>

        {{-- Read-only info on edit --}}
        @if($isEdit)
        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5 space-y-3 text-sm">
            <p class="text-xs font-black text-gray-400 uppercase tracking-wide">Record Info</p>
            <div>
                <p class="text-xs text-gray-400">Created</p>
                <p class="font-semibold text-gray-700">{{ $child->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Last Updated</p>
                <p class="font-semibold text-gray-700">{{ $child->updated_at->format('d M Y, H:i') }}</p>
            </div>
            @if($child->sponsor)
            <div>
                <p class="text-xs text-gray-400">Sponsor</p>
                <p class="font-bold text-green-600">{{ $child->sponsor->name ?? '—' }}</p>
            </div>
            @endif
        </div>
        @endif
    </div>

    {{-- ══ RIGHT: Fields ══ --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Basic Info --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="text-sm font-black text-gray-700 mb-5 flex items-center gap-2">
                <i class="fas fa-id-card text-orange-400"></i> Basic Information
            </h3>
            <div class="grid sm:grid-cols-2 gap-4">

                {{-- First Name --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">
                        First Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="first_name"
                           value="{{ old('first_name', $isEdit ? $child->first_name : '') }}"
                           placeholder="e.g. Sokha"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 @error('first_name') border-red-400 bg-red-50 @enderror">
                    @error('first_name')
                        <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-0.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Code --}}
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">
                        Child Code
                        <span class="font-normal text-gray-400">(auto-generated if empty)</span>
                    </label>
                    <input type="text" name="code"
                           value="{{ old('code', $isEdit ? $child->code : '') }}"
                           placeholder="CH-XXXXXX"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm font-mono focus:outline-none focus:border-orange-400 @error('code') border-red-400 bg-red-50 @enderror">
                    @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Birth Year --}}
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Birth Year</label>
                    <input type="number" name="birth_year"
                           value="{{ old('birth_year', $isEdit ? $child->birth_year : '') }}"
                           placeholder="{{ now()->year - 10 }}"
                           min="1990" max="{{ now()->year }}"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 @error('birth_year') border-red-400 bg-red-50 @enderror">
                    @error('birth_year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if($isEdit && $child->birth_year)
                        <p class="text-xs text-gray-400 mt-1">Currently {{ $child->age }} years old</p>
                    @endif
                </div>

                {{-- Country --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Country</label>
                    <input type="text" name="country"
                           value="{{ old('country', $isEdit ? $child->country : 'Cambodia') }}"
                           placeholder="Cambodia"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400">
                </div>
            </div>
        </div>

        {{-- Story --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="text-sm font-black text-gray-700 mb-4 flex items-center gap-2">
                <i class="fas fa-book-open text-purple-400"></i> Story
            </h3>
            <textarea name="story" rows="6"
                      placeholder="Write the child's background, family situation, dreams and aspirations…"
                      class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-400 resize-none leading-relaxed">{{ old('story', $isEdit ? $child->story : '') }}</textarea>
            <p class="text-xs text-gray-400 mt-1.5">This story appears on the sponsorship page.</p>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-3 pt-1">
            <a href="{{ route('admin.children.index') }}"
               class="px-6 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-8 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl text-sm shadow-sm transition flex items-center gap-2">
                <i class="fas fa-{{ $isEdit ? 'save' : 'plus' }}"></i>
                {{ $isEdit ? 'Save Changes' : 'Add Child' }}
            </button>
        </div>
    </div>
</div>

<script>
function previewPhoto(input) {
    if (!input.files?.length) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('photo-preview');
        const placeholder = document.getElementById('photo-placeholder');
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder?.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>