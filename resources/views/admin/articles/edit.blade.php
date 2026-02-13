{{-- resources/views/admin/articles/edit.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Edit Article')
@section('content')

<div class="page-header">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.articles.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div class="flex-1">
            <h1 class="page-title">Edit Article</h1>
            <p class="page-subtitle">Update article details</p>
        </div>
        <a href="{{ route('admin.articles.show', $article) }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-sm">
            <i class="fas fa-eye mr-1"></i> View
        </a>
    </div>
</div>

{{-- Article info banner --}}
<div class="mb-6">
    <div class="card" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);border-color:#fed7aa">
        <div class="flex items-center gap-4">
            @if($article->image)
                <img src="{{ $article->image->thumbnail_url }}" class="w-16 h-16 rounded-xl object-cover flex-shrink-0">
            @else
                <div class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $article->category->color ?? '#f97316' }}20">
                    <i class="{{ $article->category->icon ?? 'fas fa-newspaper' }} text-2xl" style="color:{{ $article->category->color ?? '#f97316' }};opacity:.5"></i>
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-gray-800 truncate">{{ $article->title }}</h3>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class="px-2 py-0.5 text-xs font-bold rounded-full
                        {{ $article->status==='published'?'bg-green-100 text-green-700':($article->status==='draft'?'bg-yellow-100 text-yellow-700':'bg-gray-100 text-gray-600') }}">
                        {{ ucfirst($article->status) }}
                    </span>
                    {{-- Current style badge --}}
                    <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-orange-100 text-orange-600 flex items-center gap-1">
                        <i class="fas fa-th-large text-xs"></i>
                        Style: {{ ucfirst($article->style ?? 'overlay') }}
                    </span>
                    <span class="text-xs text-gray-500"><i class="fas fa-eye mr-1"></i>{{ number_format($article->views_count) }} views</span>
                    <span class="text-xs text-gray-500"><i class="fas fa-calendar mr-1"></i>{{ $article->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="article-form">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- MAIN COLUMN --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Title --}}
            <div class="card">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Article Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required oninput="generateSlug()"
                       class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none transition @error('title') border-red-500 @enderror"
                       placeholder="Enter article title...">
                @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Slug --}}
            <div class="card">
                <label class="block text-sm font-semibold text-gray-700 mb-2">URL Slug <span class="text-xs text-gray-400 font-normal">(auto-generated)</span></label>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-400 whitespace-nowrap">yoursite.com/article/</span>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $article->slug) }}"
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none transition"
                           placeholder="article-url-slug">
                </div>
            </div>

            {{-- Quill Content --}}
            <div class="card">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Content <span class="text-red-500">*</span></label>
                <div id="content-editor" style="min-height:380px"></div>
                <textarea id="content" name="content" class="hidden">{{ old('content', $article->content) }}</textarea>
                @error('content')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Excerpt --}}
            <div class="card">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Excerpt <span class="text-xs text-gray-400 font-normal">(shown in article lists)</span></label>
                <textarea name="excerpt" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none"
                          placeholder="Brief summary...">{{ old('excerpt', $article->excerpt) }}</textarea>
                <p class="mt-1 text-xs text-gray-400">Max 500 characters</p>
            </div>

            {{-- Video URL --}}
            <div class="card">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    <i class="fab fa-youtube text-red-500 mr-1"></i>
                    Video URL
                    <span class="text-xs text-gray-400 font-normal ml-1">(appears in Watch Our Impact section)</span>
                </label>
                <input type="url" id="video_url" name="video_url"
                       value="{{ old('video_url', $article->video_url) }}"
                       oninput="previewYoutube(this.value)"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none"
                       placeholder="https://www.youtube.com/watch?v=...">
                <div id="video-preview-wrap" class="{{ old('video_url', $article->video_url) ? '' : 'hidden' }} mt-3">
                    <p class="text-xs text-green-500 mb-2"><i class="fas fa-check-circle mr-1"></i>YouTube URL — preview:</p>
                    <div class="aspect-video rounded-xl overflow-hidden shadow">
                        <iframe id="video-preview-iframe"
                                src="{{ old('video_url', $article->video_url) ? 'https://www.youtube.com/embed/'.($article->video_url ? preg_replace('/.*(?:youtu\.be\/|v=|embed\/)([a-zA-Z0-9_\-]{11}).*/','$1',$article->video_url) : '').'?rel=0' : '' }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen class="w-full h-full"></iframe>
                    </div>
                </div>
            </div>

            {{-- ═══ HOME PAGE CARD STYLE PICKER ═══ --}}
            <div class="card">
                <div class="flex items-center justify-between mb-1">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-th-large text-orange-500"></i> Home Page Card Style
                    </h3>
                    <span id="style-label-display" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-600">
                        <i class="fas fa-check-circle"></i>
                        <span id="style-label-text">{{ ucfirst($article->style ?? 'overlay') }}</span>
                    </span>
                </div>
                <p class="text-xs text-gray-400 mb-4">
                    <i class="fas fa-info-circle text-orange-300 mr-1"></i>
                    First article in Latest News always renders as a full-width hero. This style applies to all other positions.
                </p>
                <input type="hidden" name="style" id="article-style-input" value="{{ old('style', $article->style ?? 'overlay') }}">

                <div class="grid grid-cols-5 gap-3" id="article-style-cards">
                    @foreach([
                        ['key'=>'overlay', 'label'=>'Overlay', 'desc'=>'Dark image'],
                        ['key'=>'card',    'label'=>'Card',    'desc'=>'White card'],
                        ['key'=>'magazine','label'=>'Magazine','desc'=>'Img + text'],
                        ['key'=>'featured','label'=>'Featured','desc'=>'Large hero'],
                        ['key'=>'minimal', 'label'=>'Minimal', 'desc'=>'Border accent'],
                    ] as $s)
                    @php $isActive = old('style', $article->style ?? 'overlay') === $s['key']; @endphp
                    <div class="article-style-card relative rounded-2xl border-2 p-2.5 cursor-pointer transition-all duration-150 hover:border-orange-400 hover:shadow-md hover:-translate-y-0.5
                                {{ $isActive ? 'border-orange-500 bg-orange-50 shadow-md' : 'border-gray-200 bg-gray-50' }}"
                         data-style="{{ $s['key'] }}" data-label="{{ $s['label'] }}"
                         onclick="pickArticleStyle('{{ $s['key'] }}')">
                        <span class="style-check absolute -top-2 -right-2 w-5 h-5 bg-orange-500 rounded-full flex items-center justify-center shadow transition-all duration-200
                                     {{ $isActive ? 'opacity-100 scale-100' : 'opacity-0 scale-50' }}">
                            <i class="fas fa-check text-white text-[9px]"></i>
                        </span>
                        @if($s['key']==='overlay')
                        <div class="h-12 rounded-lg overflow-hidden relative mb-2" style="background:linear-gradient(135deg,#374151,#1f2937)">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-1 left-1.5 right-1.5">
                                <div class="h-1.5 bg-white/70 rounded mb-0.5" style="width:80%"></div>
                                <div class="h-1 bg-white/40 rounded" style="width:55%"></div>
                            </div>
                        </div>
                        @elseif($s['key']==='card')
                        <div class="h-12 rounded-lg overflow-hidden mb-2 bg-white border border-gray-200">
                            <div class="h-6 bg-gray-200"></div>
                            <div class="px-1 pt-1">
                                <div class="h-1.5 bg-gray-300 rounded mb-0.5" style="width:90%"></div>
                                <div class="h-1 bg-gray-200 rounded" style="width:65%"></div>
                            </div>
                        </div>
                        @elseif($s['key']==='magazine')
                        <div class="h-12 rounded-lg overflow-hidden mb-2 bg-white border border-gray-200 flex gap-1 p-1">
                            <div class="w-7 flex-shrink-0 bg-gray-200 rounded-sm"></div>
                            <div class="flex-1 flex flex-col justify-center gap-0.5">
                                <div class="h-1.5 bg-gray-300 rounded" style="width:100%"></div>
                                <div class="h-1 bg-gray-200 rounded" style="width:75%"></div>
                            </div>
                        </div>
                        @elseif($s['key']==='featured')
                        <div class="h-12 rounded-lg overflow-hidden relative mb-2" style="background:linear-gradient(135deg,#1e3a5f,#0f1e3a)">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                            <div class="absolute top-1 left-1.5"><div class="h-1.5 w-5 rounded-full bg-orange-500/80"></div></div>
                            <div class="absolute bottom-1 left-1.5 right-1.5">
                                <div class="h-2 bg-white/80 rounded mb-0.5" style="width:85%"></div>
                                <div class="h-1 bg-white/50 rounded" style="width:60%"></div>
                            </div>
                        </div>
                        @else
                        <div class="h-12 rounded-lg overflow-hidden mb-2 bg-white border-l-4 border-orange-500 flex gap-1 p-1">
                            <div class="w-6 flex-shrink-0 bg-gray-100 rounded-sm"></div>
                            <div class="flex-1 flex flex-col justify-center gap-0.5">
                                <div class="h-1 bg-orange-400 rounded w-6"></div>
                                <div class="h-1.5 bg-gray-300 rounded" style="width:100%"></div>
                            </div>
                        </div>
                        @endif
                        <p class="text-[10px] font-black text-gray-700 uppercase tracking-wide leading-none">{{ $s['label'] }}</p>
                        <p class="text-[9px] text-gray-400 mt-0.5">{{ $s['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>{{-- /main col --}}

        {{-- SIDEBAR --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Publish Settings --}}
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-cog text-orange-500"></i> Publish Settings
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                            <option value="draft"     {{ old('status',$article->status)=='draft'    ?'selected':'' }}>Draft</option>
                            <option value="published" {{ old('status',$article->status)=='published' ?'selected':'' }}>Published</option>
                            <option value="archived"  {{ old('status',$article->status)=='archived'  ?'selected':'' }}>Archived</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id',$article->category_id)==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Featured Article</p>
                            <p class="text-xs text-gray-400">Show in featured sections</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1"
                                   {{ old('is_featured', $article->is_featured)?'checked':'' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Publish Date</label>
                        <input type="datetime-local" name="published_at"
                               value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                        <p class="mt-1 text-xs text-gray-400">Leave empty to publish immediately</p>
                    </div>
                </div>
            </div>

            {{-- Tags --}}
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-1 flex items-center gap-2">
                    <i class="fas fa-tags text-orange-500"></i> Tags
                    <span class="ml-auto text-xs font-normal text-gray-400">optional</span>
                </h3>
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs text-gray-400"><span id="tag-count">0</span> selected</p>
                    <button type="button" id="clear-tags-btn" onclick="clearAllTags()"
                            class="text-xs text-red-400 hover:text-red-600 hidden">Clear all</button>
                </div>
                <div class="relative mb-3">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                    <input type="text" placeholder="Filter tags..." oninput="filterTags(this.value)"
                           class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none bg-gray-50">
                </div>
                @php $selectedTagIds = old('tags', $article->tags->pluck('id')->toArray()); @endphp
                <div id="tags-list" class="space-y-1 max-h-60 overflow-y-auto pr-0.5">
                    @forelse($tags ?? [] as $tag)
                        @php $checked = in_array($tag->id, $selectedTagIds); @endphp
                        <label class="tag-item flex items-center gap-3 px-3 py-2.5 rounded-xl cursor-pointer transition-all duration-150 border border-transparent hover:bg-gray-50 group {{ $checked?'bg-orange-50 border-orange-200':'' }}"
                               data-name="{{ strtolower($tag->name) }}" id="tag-label-{{ $tag->id }}">
                            <div class="relative flex-shrink-0 w-5 h-5">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                       {{ $checked?'checked':'' }} class="peer sr-only" onchange="onTagChange(this)">
                                <div class="w-5 h-5 rounded-md border-2 border-gray-300 bg-white peer-checked:border-0 peer-checked:bg-orange-500 transition-all flex items-center justify-center">
                                    <i class="fas fa-check text-white text-[10px] opacity-0 peer-checked:opacity-100"></i>
                                </div>
                            </div>
                            <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">{{ $tag->name }}</span>
                            <span class="ml-auto text-xs text-gray-300 capitalize opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0">{{ $tag->style }}</span>
                        </label>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-tags text-3xl text-gray-200 mb-2 block"></i>
                            <a href="{{ route('admin.tags.index') }}" class="text-xs font-semibold text-orange-500 hover:underline">Create tags →</a>
                        </div>
                    @endforelse
                </div>
                @if(($tags ?? collect())->isNotEmpty())
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.tags.index') }}" class="text-xs text-gray-400 hover:text-orange-500 flex items-center gap-1.5">
                        <i class="fas fa-plus-circle"></i> Manage / create more tags
                    </a>
                </div>
                @endif
            </div>

            {{-- Featured Image --}}
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-image text-orange-500"></i> Featured Image
                </h3>
                @if($article->image)
                    <div id="current-image" class="mb-4">
                        <img src="{{ $article->image->url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover rounded-xl mb-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-orange-500" onchange="toggleImageUpload(this)">
                            <span class="text-sm text-red-500 font-medium">Remove current image</span>
                        </label>
                    </div>
                @endif
                <div id="image-preview-container" class="hidden mb-4">
                    <div class="relative rounded-xl overflow-hidden">
                        <img id="image-preview" src="" alt="Preview" class="w-full h-44 object-cover">
                        <button type="button" onclick="removeImagePreview()"
                                class="absolute top-2 right-2 w-7 h-7 bg-black/50 hover:bg-red-500 text-white rounded-full flex items-center justify-center transition">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                </div>
                <div id="upload-area"
                     class="border-2 border-dashed border-gray-300 rounded-xl p-5 text-center hover:border-orange-400 transition cursor-pointer group {{ $article->image ? 'hidden' : '' }}"
                     onclick="document.getElementById('featured_image').click()"
                     ondragover="event.preventDefault();this.classList.add('border-orange-400','bg-orange-50')"
                     ondragleave="this.classList.remove('border-orange-400','bg-orange-50')"
                     ondrop="handleDrop(event)">
                    <input type="file" id="featured_image" name="featured_image" accept="image/*" class="hidden" onchange="previewImage(event)">
                    <i class="fas fa-cloud-upload-alt text-2xl text-gray-300 group-hover:text-orange-400 mb-1.5 transition"></i>
                    <p class="text-sm text-gray-500 font-medium">Click to {{ $article->image ? 'replace' : 'upload' }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, GIF · Max 5MB</p>
                </div>
                @error('featured_image')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- SEO --}}
            <div class="card">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-search text-orange-500"></i> SEO
                    <span class="ml-auto text-xs font-normal text-gray-400">optional</span>
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $article->meta_title) }}"
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="2"
                                  class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">{{ old('meta_description', $article->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card space-y-3">
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition shadow-sm hover:shadow-md">
                    <i class="fas fa-save"></i> Update Article
                </button>
                <a href="{{ route('admin.articles.index') }}"
                   class="block w-full px-4 py-3 border border-gray-200 text-gray-500 text-center rounded-xl hover:bg-gray-50 text-sm font-medium">
                    Cancel
                </a>
                <button type="button"
                        onclick="if(confirm('Delete this article permanently?')) document.getElementById('delete-form').submit()"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition border border-red-200">
                    <i class="fas fa-trash text-sm"></i> Delete Article
                </button>
            </div>
        </div>
    </div>
</form>

<form id="delete-form" action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
#tags-list input[type="checkbox"].peer:checked+div>i{opacity:1}
#tags-list::-webkit-scrollbar{width:4px}
#tags-list::-webkit-scrollbar-thumb{background:#e5e7eb;border-radius:4px}
</style>
@endpush
@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
const quill=new Quill('#content-editor',{theme:'snow',modules:{toolbar:[[{header:[1,2,3,4,5,6,false]}],['bold','italic','underline','strike'],['blockquote','code-block'],[{list:'ordered'},{list:'bullet'}],[{color:[]},{background:[]}],[{align:[]}],['link','image','video'],['clean']]},placeholder:'Write your article content here...'});
const existingContent=`{!! old('content', $article->content) !!}`;if(existingContent)quill.root.innerHTML=existingContent;
quill.on('text-change',()=>document.getElementById('content').value=quill.root.innerHTML);
document.getElementById('article-form').addEventListener('submit',function(e){document.getElementById('content').value=quill.root.innerHTML;if(!quill.getText().trim()||quill.getText().trim().length<=1){e.preventDefault();quill.focus();}});
function generateSlug(){document.getElementById('slug').value=document.getElementById('title').value.toLowerCase().replace(/[^\w\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-').trim();}
function previewImage(event){const file=event.target.files[0];if(!file)return;const reader=new FileReader();reader.onload=e=>{document.getElementById('image-preview').src=e.target.result;document.getElementById('image-preview-container').classList.remove('hidden');const ci=document.getElementById('current-image');if(ci)ci.classList.add('hidden');document.getElementById('upload-area').classList.add('hidden');};reader.readAsDataURL(file);}
function removeImagePreview(){document.getElementById('featured_image').value='';document.getElementById('image-preview-container').classList.add('hidden');const ci=document.getElementById('current-image');if(ci)ci.classList.remove('hidden');}
function toggleImageUpload(checkbox){const ci=document.getElementById('current-image');const ua=document.getElementById('upload-area');if(checkbox.checked){ci.style.opacity='0.5';ua.classList.remove('hidden');}else{ci.style.opacity='1';}}
function handleDrop(e){e.preventDefault();const area=document.getElementById('upload-area');area.classList.remove('border-orange-400','bg-orange-50');const file=e.dataTransfer.files[0];if(!file||!file.type.startsWith('image/'))return;const dt=new DataTransfer();dt.items.add(file);document.getElementById('featured_image').files=dt.files;const reader=new FileReader();reader.onload=ev=>{document.getElementById('image-preview').src=ev.target.result;document.getElementById('image-preview-container').classList.remove('hidden');area.classList.add('hidden');};reader.readAsDataURL(file);}
function previewYoutube(url){const match=url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_\-]{11})/);const wrap=document.getElementById('video-preview-wrap');if(match){document.getElementById('video-preview-iframe').src=`https://www.youtube.com/embed/${match[1]}?rel=0`;wrap.classList.remove('hidden');}else{wrap.classList.add('hidden');document.getElementById('video-preview-iframe').src='';}}
const styleLabels={overlay:'Overlay',card:'Card',magazine:'Magazine',featured:'Featured',minimal:'Minimal'};
function pickArticleStyle(style){document.getElementById('article-style-input').value=style;document.getElementById('style-label-text').textContent=styleLabels[style]||style;document.querySelectorAll('.article-style-card').forEach(card=>{const active=card.dataset.style===style;card.classList.toggle('border-orange-500',active);card.classList.toggle('bg-orange-50',active);card.classList.toggle('shadow-md',active);card.classList.toggle('border-gray-200',!active);card.classList.toggle('bg-gray-50',!active);const chk=card.querySelector('.style-check');if(chk){chk.classList.toggle('opacity-100',active);chk.classList.toggle('scale-100',active);chk.classList.toggle('opacity-0',!active);chk.classList.toggle('scale-50',!active);}});}
pickArticleStyle(document.getElementById('article-style-input').value||'overlay');
function onTagChange(cb){const label=document.getElementById('tag-label-'+cb.value);label.classList.toggle('bg-orange-50',cb.checked);label.classList.toggle('border-orange-200',cb.checked);label.classList.toggle('border-transparent',!cb.checked);updateTagCount();}
function updateTagCount(){const count=document.querySelectorAll('input[name="tags[]"]:checked').length;document.getElementById('tag-count').textContent=count;document.getElementById('clear-tags-btn').classList.toggle('hidden',count===0);}
function clearAllTags(){document.querySelectorAll('input[name="tags[]"]').forEach(cb=>{cb.checked=false;onTagChange(cb);});}
function filterTags(q){q=q.toLowerCase().trim();document.querySelectorAll('.tag-item').forEach(el=>{el.style.display=(!q||el.dataset.name.includes(q))?'':'none';});}
updateTagCount();
</script>
@endpush
@endsection