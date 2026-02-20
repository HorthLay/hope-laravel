{{-- resources/views/admin/families/edit.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Edit Family')
@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.families.show', $family) }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-arrow-left text-gray-600"></i>
    </a>
    <div class="flex-1"><h1 class="page-title">Edit Family</h1><p class="page-subtitle">{{ $family->name }}</p></div>
    <a href="{{ route('admin.families.show', $family) }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-sm">
        <i class="fas fa-eye mr-1"></i>View
    </a>
</div>

{{-- Banner --}}
<div class="card mb-6" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);border-color:#fed7aa">
    <div class="flex items-center gap-4">
        @if($family->profile_photo)
            <img src="{{ $family->profile_photo_url }}" class="w-14 h-14 rounded-2xl object-cover flex-shrink-0 shadow">
        @else
            <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-home text-orange-400 text-2xl"></i>
            </div>
        @endif
        <div class="flex-1 min-w-0">
            <h3 class="font-bold text-gray-800">{{ $family->name }}</h3>
            <div class="flex flex-wrap items-center gap-2 mt-1">
                <span class="font-mono text-xs text-gray-500">{{ $family->code }}</span>
                <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $family->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">{{ $family->is_active ? 'Active' : 'Inactive' }}</span>
                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-blue-100 text-blue-600">{{ $family->sponsors->count() }} sponsors</span>
            </div>
        </div>
    </div>
</div>

@php
    $selectedSponsorIds = old('sponsors', $family->sponsors->pluck('id')->toArray());
@endphp

<form action="{{ route('admin.families.update', $family) }}" method="POST" enctype="multipart/form-data" id="family-form">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- MAIN --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-home text-orange-500"></i> Family Info</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Family Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $family->name) }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('name') border-red-500 @enderror">
                        @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Code</label>
                            <input type="text" name="code" value="{{ old('code', $family->code) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('code') border-red-500 @enderror">
                            @error('code')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Country</label>
                            <input type="text" name="country" value="{{ old('country', $family->country) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Story</label>
                        <textarea name="story" rows="6" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none resize-none">{{ old('story', $family->story) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Status --}}
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-cog text-orange-500"></i> Settings</h3>
                <div class="flex items-center justify-between py-2">
                    <div><p class="text-sm font-semibold text-gray-700">Active</p><p class="text-xs text-gray-400">Visible to sponsors</p></div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $family->is_active) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                    </label>
                </div>
            </div>

            {{-- Sponsors picker --}}
            <div class="card" id="fs-picker">
                <div class="flex items-center justify-between mb-1">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-user-tie text-blue-500"></i> Sponsors
                        <span id="fs-badge" class="ml-1 w-5 h-5 rounded-full bg-blue-100 text-blue-600 text-[10px] font-black inline-flex items-center justify-center">{{ count($selectedSponsorIds) }}</span>
                    </h3>
                    <button type="button" id="fs-clear" onclick="fsClearAll()" class="text-xs text-red-400 hover:text-red-600 {{ count($selectedSponsorIds) ? '' : 'hidden' }}">Clear</button>
                </div>
                <div id="fs-chips" class="flex flex-wrap gap-2 mb-3 {{ count($selectedSponsorIds) ? '' : 'hidden' }}">
                    @foreach($sponsors->whereIn('id', $selectedSponsorIds) as $sp)
                    <div class="flex items-center gap-1.5 pl-2 pr-2 py-1 bg-blue-50 border border-blue-200 rounded-full text-xs font-semibold text-blue-700" data-id="{{ $sp->id }}">
                        <span>{{ $sp->full_name }}</span>
                        <button type="button" onclick="fsRemove({{ $sp->id }})" class="ml-1 w-4 h-4 flex items-center justify-center rounded-full hover:bg-blue-200 transition"><i class="fas fa-times text-[9px]"></i></button>
                        <input type="hidden" name="sponsors[]" value="{{ $sp->id }}">
                    </div>
                    @endforeach
                </div>
                <div class="relative mb-2">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                    <input type="text" id="fs-search" placeholder="Search sponsors..." oninput="fsFilter(this.value)" onfocus="fsOpen()" autocomplete="off"
                           class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                </div>
                <div id="fs-dropdown" class="hidden border border-gray-200 rounded-xl overflow-hidden shadow-lg bg-white max-h-52 overflow-y-auto">
                    @forelse($sponsors as $sp)
                    <div class="fs-opt flex items-center gap-3 px-3 py-2.5 cursor-pointer hover:bg-blue-50 border-b border-gray-50 last:border-0"
                         data-id="{{ $sp->id }}" data-name="{{ $sp->full_name }}"
                         data-search="{{ strtolower($sp->first_name.' '.$sp->last_name.' '.$sp->email) }}"
                         onclick="fsToggle(this)" id="fs-opt-{{ $sp->id }}">
                        <div class="fs-chk w-5 h-5 rounded-md border-2 flex-shrink-0 flex items-center justify-center transition-all {{ in_array($sp->id, $selectedSponsorIds) ? 'bg-blue-500 border-blue-500' : 'bg-white border-gray-300' }}">
                            <i class="fas fa-check text-white text-[9px] {{ in_array($sp->id, $selectedSponsorIds) ? '' : 'hidden' }}"></i>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center font-black text-blue-600 text-sm flex-shrink-0">{{ strtoupper(substr($sp->first_name,0,1)) }}</div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $sp->full_name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $sp->email }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="px-4 py-6 text-center text-xs text-gray-400">No active sponsors.</div>
                    @endforelse
                    <div id="fs-no-results" class="hidden px-4 py-4 text-center text-xs text-gray-400">No match.</div>
                </div>
            </div>

            {{-- Photo --}}
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-image text-orange-500"></i> Family Photo</h3>
                @if($family->profile_photo)
                <div id="current-photo" class="mb-3">
                    <img src="{{ $family->profile_photo_url }}" class="w-full h-40 object-cover rounded-xl mb-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remove_photo" value="1" onchange="toggleUpload(this)" class="rounded border-gray-300 text-orange-500">
                        <span class="text-sm text-red-500 font-medium">Remove photo</span>
                    </label>
                </div>
                @endif
                <div id="photo-preview" class="hidden mb-3 relative rounded-xl overflow-hidden">
                    <img id="photo-preview-img" src="" class="w-full h-40 object-cover">
                    <button type="button" onclick="removePhoto()" class="absolute top-2 right-2 w-7 h-7 bg-black/50 hover:bg-red-500 text-white rounded-full flex items-center justify-center transition"><i class="fas fa-times text-xs"></i></button>
                </div>
                <div id="upload-area" class="{{ $family->profile_photo ? 'hidden' : '' }} border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-orange-400 transition cursor-pointer group"
                     onclick="document.getElementById('profile_photo').click()">
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                    <i class="fas fa-cloud-upload-alt text-xl text-gray-300 group-hover:text-orange-400 mb-1 transition"></i>
                    <p class="text-sm text-gray-500 font-medium">{{ $family->profile_photo ? 'Replace photo' : 'Upload photo' }}</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card space-y-3">
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition shadow-sm">
                    <i class="fas fa-save"></i> Update Family
                </button>
                <a href="{{ route('admin.families.show', $family) }}" class="block w-full px-4 py-3 border border-gray-200 text-gray-500 text-center rounded-xl hover:bg-gray-50 text-sm font-medium">Cancel</a>
                <button type="button"
                        onclick="document.getElementById('delete-family-form').submit()"
                        onmousedown="return confirm('Delete {{ addslashes($family->name) }}? This cannot be undone.')"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition border border-red-200 text-sm">
                    <i class="fas fa-trash"></i> Delete Family
                </button>
            </div>
        </div>
    </div>
</form>

<form id="delete-family-form" action="{{ route('admin.families.destroy', $family) }}" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>

@push('styles')
<style>#fs-dropdown::-webkit-scrollbar{width:4px}#fs-dropdown::-webkit-scrollbar-thumb{background:#e5e7eb;border-radius:4px}</style>
@endpush
@push('scripts')
<script>
const _fs = new Set(@json($selectedSponsorIds));
function fsOpen(){document.getElementById('fs-dropdown').classList.remove('hidden');}
function fsFilter(q){q=q.toLowerCase().trim();let v=0;document.querySelectorAll('.fs-opt').forEach(o=>{const m=!q||o.dataset.search.includes(q);o.style.display=m?'':'none';if(m)v++;});document.getElementById('fs-no-results').classList.toggle('hidden',v>0||!q);fsOpen();}
function fsToggle(el){const id=parseInt(el.dataset.id);_fs.has(id)?fsRemove(id):fsAdd(id,el.dataset.name);}
function fsAdd(id,name){if(_fs.has(id))return;_fs.add(id);const chips=document.getElementById('fs-chips');const c=document.createElement('div');c.className='flex items-center gap-1.5 pl-2 pr-2 py-1 bg-blue-50 border border-blue-200 rounded-full text-xs font-semibold text-blue-700';c.dataset.id=id;c.innerHTML=`<span>${name}</span><button type="button" onclick="fsRemove(${id})" class="ml-1 w-4 h-4 flex items-center justify-center rounded-full hover:bg-blue-200 transition"><i class="fas fa-times text-[9px]"></i></button><input type="hidden" name="sponsors[]" value="${id}">`;chips.appendChild(c);const b=document.querySelector(`#fs-opt-${id} .fs-chk`);if(b){b.classList.add('bg-blue-500','border-blue-500');b.querySelector('i').classList.remove('hidden');}fsRefresh();}
function fsRemove(id){id=parseInt(id);_fs.delete(id);const chips=document.getElementById('fs-chips');[...chips.children].forEach(c=>{if(parseInt(c.dataset.id)===id)c.remove();});const b=document.querySelector(`#fs-opt-${id} .fs-chk`);if(b){b.classList.remove('bg-blue-500','border-blue-500');b.querySelector('i').classList.add('hidden');}fsRefresh();}
function fsClearAll(){[..._fs].forEach(fsRemove);}
function fsRefresh(){const n=_fs.size;document.getElementById('fs-badge').textContent=n;document.getElementById('fs-chips').classList.toggle('hidden',n===0);document.getElementById('fs-clear').classList.toggle('hidden',n===0);}
function previewPhoto(e){const f=e.target.files[0];if(!f)return;const r=new FileReader();r.onload=ev=>{document.getElementById('photo-preview-img').src=ev.target.result;document.getElementById('photo-preview').classList.remove('hidden');document.getElementById('upload-area').classList.add('hidden');const cp=document.getElementById('current-photo');if(cp)cp.classList.add('hidden');};r.readAsDataURL(f);}
function removePhoto(){document.getElementById('profile_photo').value='';document.getElementById('photo-preview').classList.add('hidden');document.getElementById('upload-area').classList.remove('hidden');}
function toggleUpload(cb){const cp=document.getElementById('current-photo');const ua=document.getElementById('upload-area');cp.style.opacity=cb.checked?'.5':'1';ua.classList.toggle('hidden',!cb.checked);}
document.addEventListener('click',e=>{if(!e.target.closest('#fs-picker'))document.getElementById('fs-dropdown').classList.add('hidden');});
</script>
@endpush
@endsection