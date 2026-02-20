{{-- resources/views/admin/families/create.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Create Family')
@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.families.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-arrow-left text-gray-600"></i>
    </a>
    <div><h1 class="page-title">Create Family</h1><p class="page-subtitle">Add a new sponsored family</p></div>
</div>

<form action="{{ route('admin.families.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- MAIN --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-home text-orange-500"></i> Family Info</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Family Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('name') border-red-500 @enderror"
                               placeholder="e.g. The Chan Family">
                        @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Code <span class="text-xs text-gray-400 font-normal">(auto if blank)</span></label>
                            <input type="text" name="code" value="{{ old('code') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none @error('code') border-red-500 @enderror"
                                   placeholder="FM-XXXXXX">
                            @error('code')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Country</label>
                            <input type="text" name="country" value="{{ old('country') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none"
                                   placeholder="Cambodia">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Story</label>
                        <textarea name="story" rows="6"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none resize-none"
                                  placeholder="Tell this family's background story...">{{ old('story') }}</textarea>
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
                        <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                    </label>
                </div>
            </div>

            {{-- Sponsors picker --}}
            <div class="card" id="fs-picker">
                <div class="flex items-center justify-between mb-1">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-user-tie text-blue-500"></i> Sponsors
                        <span id="fs-badge" class="ml-1 w-5 h-5 rounded-full bg-blue-100 text-blue-600 text-[10px] font-black inline-flex items-center justify-center">0</span>
                    </h3>
                    <button type="button" id="fs-clear" onclick="fsClearAll()" class="text-xs text-red-400 hover:text-red-600 hidden">Clear</button>
                </div>
                <p class="text-xs text-gray-400 mb-3">Assign sponsors to this family</p>
                <div id="fs-chips" class="flex flex-wrap gap-2 mb-3 hidden"></div>
                <div class="relative mb-2">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                    <input type="text" id="fs-search" placeholder="Search sponsors..." oninput="fsFilter(this.value)" onfocus="fsOpen()" autocomplete="off"
                           class="w-full pl-8 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                </div>
                <div id="fs-dropdown" class="hidden border border-gray-200 rounded-xl overflow-hidden shadow-lg bg-white max-h-52 overflow-y-auto">
                    @forelse($sponsors as $sponsor)
                    <div class="fs-opt flex items-center gap-3 px-3 py-2.5 cursor-pointer hover:bg-blue-50 border-b border-gray-50 last:border-0"
                         data-id="{{ $sponsor->id }}" data-name="{{ $sponsor->full_name }}" data-email="{{ $sponsor->email }}"
                         data-search="{{ strtolower($sponsor->first_name.' '.$sponsor->last_name.' '.$sponsor->email) }}"
                         onclick="fsToggle(this)" id="fs-opt-{{ $sponsor->id }}">
                        <div class="fs-chk w-5 h-5 rounded-md border-2 border-gray-300 bg-white flex-shrink-0 flex items-center justify-center transition-all">
                            <i class="fas fa-check text-white text-[9px] hidden"></i>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center font-black text-blue-600 text-sm flex-shrink-0">
                            {{ strtoupper(substr($sponsor->first_name,0,1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $sponsor->full_name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $sponsor->email }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="px-4 py-6 text-center text-xs text-gray-400">No active sponsors found.</div>
                    @endforelse
                    <div id="fs-no-results" class="hidden px-4 py-4 text-center text-xs text-gray-400">No match.</div>
                </div>
            </div>

            {{-- Photo --}}
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-image text-orange-500"></i> Family Photo</h3>
                <div id="photo-preview" class="hidden mb-3 relative rounded-xl overflow-hidden">
                    <img id="photo-preview-img" src="" class="w-full h-44 object-cover">
                    <button type="button" onclick="removePhoto()" class="absolute top-2 right-2 w-7 h-7 bg-black/50 hover:bg-red-500 text-white rounded-full flex items-center justify-center transition">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <div id="upload-area" class="border-2 border-dashed border-gray-300 rounded-xl p-5 text-center hover:border-orange-400 transition cursor-pointer group"
                     onclick="document.getElementById('profile_photo').click()"
                     ondragover="event.preventDefault();this.classList.add('border-orange-400','bg-orange-50')"
                     ondragleave="this.classList.remove('border-orange-400','bg-orange-50')"
                     ondrop="handleDrop(event)">
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                    <i class="fas fa-cloud-upload-alt text-2xl text-gray-300 group-hover:text-orange-400 mb-1.5 transition"></i>
                    <p class="text-sm text-gray-500 font-medium group-hover:text-orange-500">Click or drag photo here</p>
                    <p class="text-xs text-gray-400 mt-0.5">JPG, PNG · Max 2MB</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card space-y-3">
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition shadow-sm">
                    <i class="fas fa-home"></i> Create Family
                </button>
                <a href="{{ route('admin.families.index') }}" class="block w-full px-4 py-3 border border-gray-200 text-gray-500 text-center rounded-xl hover:bg-gray-50 text-sm font-medium">Cancel</a>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>#fs-dropdown::-webkit-scrollbar{width:4px}#fs-dropdown::-webkit-scrollbar-thumb{background:#e5e7eb;border-radius:4px}</style>
@endpush
@push('scripts')
<script>
const _fs = new Set();
function fsOpen(){document.getElementById('fs-dropdown').classList.remove('hidden');}
function fsFilter(q){q=q.toLowerCase().trim();let v=0;document.querySelectorAll('.fs-opt').forEach(o=>{const m=!q||o.dataset.search.includes(q);o.style.display=m?'':'none';if(m)v++;});document.getElementById('fs-no-results').classList.toggle('hidden',v>0||!q);fsOpen();}
function fsToggle(el){const id=parseInt(el.dataset.id);_fs.has(id)?fsRemove(id):fsAdd(id,el.dataset.name);}
function fsAdd(id,name){if(_fs.has(id))return;_fs.add(id);const chips=document.getElementById('fs-chips');const c=document.createElement('div');c.className='flex items-center gap-1.5 pl-2 pr-2 py-1 bg-blue-50 border border-blue-200 rounded-full text-xs font-semibold text-blue-700';c.dataset.id=id;c.innerHTML=`<span>${name}</span><button type="button" onclick="fsRemove(${id})" class="ml-1 w-4 h-4 flex items-center justify-center rounded-full hover:bg-blue-200 transition"><i class="fas fa-times text-[9px]"></i></button><input type="hidden" name="sponsors[]" value="${id}">`;chips.appendChild(c);const b=document.querySelector(`#fs-opt-${id} .fs-chk`);if(b){b.classList.add('bg-blue-500','border-blue-500');b.querySelector('i').classList.remove('hidden');}fsRefresh();}
function fsRemove(id){id=parseInt(id);_fs.delete(id);const chips=document.getElementById('fs-chips');[...chips.children].forEach(c=>{if(parseInt(c.dataset.id)===id)c.remove();});const b=document.querySelector(`#fs-opt-${id} .fs-chk`);if(b){b.classList.remove('bg-blue-500','border-blue-500');b.querySelector('i').classList.add('hidden');}fsRefresh();}
function fsClearAll(){[..._fs].forEach(fsRemove);}
function fsRefresh(){const n=_fs.size;document.getElementById('fs-badge').textContent=n;document.getElementById('fs-chips').classList.toggle('hidden',n===0);document.getElementById('fs-clear').classList.toggle('hidden',n===0);}
function previewPhoto(e){const f=e.target.files[0];if(!f)return;const r=new FileReader();r.onload=ev=>{document.getElementById('photo-preview-img').src=ev.target.result;document.getElementById('photo-preview').classList.remove('hidden');document.getElementById('upload-area').classList.add('hidden');};r.readAsDataURL(f);}
function removePhoto(){document.getElementById('profile_photo').value='';document.getElementById('photo-preview').classList.add('hidden');document.getElementById('upload-area').classList.remove('hidden');}
function handleDrop(e){e.preventDefault();e.currentTarget.classList.remove('border-orange-400','bg-orange-50');const f=e.dataTransfer.files[0];if(!f||!f.type.startsWith('image/'))return;const dt=new DataTransfer();dt.items.add(f);document.getElementById('profile_photo').files=dt.files;const r=new FileReader();r.onload=ev=>{document.getElementById('photo-preview-img').src=ev.target.result;document.getElementById('photo-preview').classList.remove('hidden');document.getElementById('upload-area').classList.add('hidden');};r.readAsDataURL(f);}
document.addEventListener('click',e=>{if(!e.target.closest('#fs-picker'))document.getElementById('fs-dropdown').classList.add('hidden');});
</script>
@endpush
@endsection