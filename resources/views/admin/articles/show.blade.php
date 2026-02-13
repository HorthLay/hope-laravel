{{-- resources/views/admin/articles/show.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Article Details')
@section('content')

<div class="page-header">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.articles.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div class="flex-1">
            <h1 class="page-title">Article Details</h1>
            <p class="page-subtitle">{{ Str::limit($article->title, 60) }}</p>
        </div>
        <a href="{{ route('admin.articles.edit', $article) }}" class="action-btn">
            <i class="fas fa-edit"></i><span>Edit</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ══════ MAIN COLUMN ══════ --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Featured Image --}}
        @if($article->image)
        <div class="card p-0 overflow-hidden">
            <img src="{{ $article->image->url }}" alt="{{ $article->title }}" class="w-full h-80 object-cover">
        </div>
        @endif

        {{-- Article Content --}}
        <div class="card">
            {{-- Title + meta --}}
            <div class="mb-6 pb-6 border-b border-gray-100">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    {{-- Status --}}
                    <span class="px-3 py-1 text-xs font-bold rounded-full
                        {{ $article->status==='published'?'bg-green-100 text-green-700':($article->status==='draft'?'bg-yellow-100 text-yellow-700':'bg-gray-100 text-gray-600') }}">
                        <i class="fas fa-circle text-[8px] mr-1"></i>{{ ucfirst($article->status) }}
                    </span>
                    {{-- Featured badge --}}
                    @if($article->is_featured)
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-600">
                            <i class="fas fa-star text-xs mr-1"></i>Featured
                        </span>
                    @endif
                    {{-- Card style badge --}}
                    @php
                        $styleIcons = ['overlay'=>'fas fa-image','card'=>'fas fa-square','magazine'=>'fas fa-columns','featured'=>'fas fa-expand','minimal'=>'fas fa-minus'];
                        $styleColors = ['overlay'=>'bg-gray-100 text-gray-700','card'=>'bg-blue-100 text-blue-700','magazine'=>'bg-purple-100 text-purple-700','featured'=>'bg-orange-100 text-orange-700','minimal'=>'bg-green-100 text-green-700'];
                        $style = $article->style ?? 'overlay';
                    @endphp
                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $styleColors[$style] ?? 'bg-gray-100 text-gray-700' }}">
                        <i class="{{ $styleIcons[$style] ?? 'fas fa-th' }} text-xs mr-1"></i>
                        {{ ucfirst($style) }} Style
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 leading-tight">{{ $article->title }}</h1>
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <span><i class="fas fa-user text-orange-400 mr-1.5"></i>{{ $article->admin->name ?? '—' }}</span>
                    <span><i class="fas fa-calendar text-blue-400 mr-1.5"></i>{{ $article->created_at->format('M d, Y') }}</span>
                    <span><i class="fas fa-eye text-green-400 mr-1.5"></i>{{ number_format($stats['views']) }} views</span>
                    <span><i class="fas fa-book-open text-purple-400 mr-1.5"></i>{{ $stats['reading_time'] }} min read</span>
                    @if($article->category)
                        <a href="{{ route('admin.categories.show', $article->category) }}"
                           class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold hover:opacity-80 transition"
                           style="background:{{ $article->category->color ?? '#f97316' }}18;color:{{ $article->category->color ?? '#f97316' }}">
                            @if($article->category->icon)<i class="{{ $article->category->icon }} text-xs"></i>@endif{{ $article->category->name }}
                        </a>
                    @endif
                </div>
            </div>

            {{-- Tags --}}
            @if($article->tags->isNotEmpty())
            <div class="mb-5 flex flex-wrap gap-2 items-center">
                <span class="text-xs text-gray-400 font-semibold uppercase tracking-wide mr-1">Tags:</span>
                @foreach($article->tags as $tag)
                    <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">{{ $tag->name }}</span>
                @endforeach
            </div>
            @endif

            {{-- Excerpt --}}
            @if($article->excerpt)
                <div class="mb-6 p-4 bg-orange-50 border-l-4 border-orange-500 rounded-xl">
                    <p class="text-gray-700 text-sm italic leading-relaxed">{{ $article->excerpt }}</p>
                </div>
            @endif

            {{-- Article Content --}}
            <div class="prose prose-orange max-w-none text-gray-800">
                {!! $article->content !!}
            </div>
        </div>

        {{-- Video Embed --}}
        @if($article->video_url)
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fab fa-youtube text-red-500"></i> Embedded Video
            </h3>
            @php
                preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_\-]{11})/', $article->video_url, $ytm);
                $embedId = $ytm[1] ?? null;
            @endphp
            @if($embedId)
                <div class="aspect-video rounded-xl overflow-hidden shadow-md">
                    <iframe src="https://www.youtube.com/embed/{{ $embedId }}?rel=0&modestbranding=1"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen class="w-full h-full"></iframe>
                </div>
                <p class="text-xs text-gray-400 mt-2 flex items-center gap-1.5">
                    <i class="fas fa-link"></i>
                    <a href="{{ $article->video_url }}" target="_blank" class="hover:text-orange-500 hover:underline truncate">{{ $article->video_url }}</a>
                </p>
            @else
                <a href="{{ $article->video_url }}" target="_blank" class="text-sm text-orange-500 hover:underline break-all">{{ $article->video_url }}</a>
            @endif
        </div>
        @endif

        {{-- Home page style preview --}}
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-th-large text-orange-500"></i> Home Page Card Style
            </h3>
            <div class="grid grid-cols-5 gap-3">
                @foreach([
                    ['key'=>'overlay', 'label'=>'Overlay', 'desc'=>'Dark image'],
                    ['key'=>'card',    'label'=>'Card',    'desc'=>'White card'],
                    ['key'=>'magazine','label'=>'Magazine','desc'=>'Img + text'],
                    ['key'=>'featured','label'=>'Featured','desc'=>'Large hero'],
                    ['key'=>'minimal', 'label'=>'Minimal', 'desc'=>'Border accent'],
                ] as $s)
                @php $isActive = ($article->style ?? 'overlay') === $s['key']; @endphp
                <div class="relative rounded-2xl border-2 p-2.5 transition-all
                            {{ $isActive ? 'border-orange-500 bg-orange-50 shadow-md' : 'border-gray-200 bg-gray-50 opacity-50' }}">
                    @if($isActive)
                    <span class="absolute -top-2 -right-2 w-5 h-5 bg-orange-500 rounded-full flex items-center justify-center shadow">
                        <i class="fas fa-check text-white text-[9px]"></i>
                    </span>
                    @endif
                    @if($s['key']==='overlay')
                    <div class="h-10 rounded-lg overflow-hidden relative mb-1.5" style="background:linear-gradient(135deg,#374151,#1f2937)">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-1 left-1.5 right-1.5">
                            <div class="h-1.5 bg-white/70 rounded mb-0.5" style="width:80%"></div>
                        </div>
                    </div>
                    @elseif($s['key']==='card')
                    <div class="h-10 rounded-lg overflow-hidden mb-1.5 bg-white border border-gray-200">
                        <div class="h-5 bg-gray-200"></div>
                        <div class="px-1 pt-0.5"><div class="h-1.5 bg-gray-300 rounded" style="width:90%"></div></div>
                    </div>
                    @elseif($s['key']==='magazine')
                    <div class="h-10 rounded-lg overflow-hidden mb-1.5 bg-white border border-gray-200 flex gap-1 p-1">
                        <div class="w-6 flex-shrink-0 bg-gray-200 rounded-sm"></div>
                        <div class="flex-1 flex flex-col justify-center gap-0.5">
                            <div class="h-1.5 bg-gray-300 rounded" style="width:100%"></div>
                            <div class="h-1 bg-gray-200 rounded" style="width:75%"></div>
                        </div>
                    </div>
                    @elseif($s['key']==='featured')
                    <div class="h-10 rounded-lg overflow-hidden relative mb-1.5" style="background:linear-gradient(135deg,#1e3a5f,#0f1e3a)">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute top-1 left-1.5"><div class="h-1.5 w-4 rounded-full bg-orange-500/80"></div></div>
                        <div class="absolute bottom-1 left-1.5 right-1.5"><div class="h-1.5 bg-white/70 rounded" style="width:80%"></div></div>
                    </div>
                    @else
                    <div class="h-10 rounded-lg overflow-hidden mb-1.5 bg-white border-l-4 border-orange-500 flex gap-1 p-1">
                        <div class="w-5 flex-shrink-0 bg-gray-100 rounded-sm"></div>
                        <div class="flex-1 flex flex-col justify-center gap-0.5">
                            <div class="h-1 bg-orange-400 rounded w-5"></div>
                            <div class="h-1.5 bg-gray-300 rounded" style="width:100%"></div>
                        </div>
                    </div>
                    @endif
                    <p class="text-[10px] font-black uppercase tracking-wide leading-none {{ $isActive ? 'text-orange-600' : 'text-gray-400' }}">{{ $s['label'] }}</p>
                </div>
                @endforeach
            </div>
            <p class="text-xs text-gray-400 mt-3">
                <i class="fas fa-pencil-alt text-orange-300 mr-1"></i>
                Change the style in <a href="{{ route('admin.articles.edit', $article) }}" class="text-orange-500 hover:underline font-semibold">Edit Article</a>.
            </p>
        </div>

        {{-- Actions --}}
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4">Actions</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.articles.edit', $article) }}" class="action-btn">
                    <i class="fas fa-edit"></i> Edit Article
                </a>
                @if($article->status === 'published')
                    <a href="{{ route('articles.show', \Illuminate\Support\Facades\Crypt::encryptString($article->slug)) }}"
                       target="_blank"
                       class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-sm flex items-center gap-2">
                        <i class="fas fa-external-link-alt"></i> View Live
                    </a>
                @endif
                <button type="button"
                        onclick="if(confirm('Delete this article permanently?')) document.getElementById('delete-form').submit()"
                        class="px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition font-semibold text-sm flex items-center gap-2 border border-red-200">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    {{-- ══════ SIDEBAR ══════ --}}
    <div class="lg:col-span-1 space-y-6">

        {{-- Status + Info --}}
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-orange-500"></i> Article Info
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Status</span>
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full
                        {{ $article->status==='published'?'bg-green-100 text-green-700':($article->status==='draft'?'bg-yellow-100 text-yellow-700':'bg-gray-100 text-gray-600') }}">
                        {{ ucfirst($article->status) }}
                    </span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Card Style</span>
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $styleColors[$style] ?? 'bg-gray-100 text-gray-700' }}">
                        <i class="{{ $styleIcons[$style] ?? 'fas fa-th' }} text-xs mr-1"></i>{{ ucfirst($style) }}
                    </span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Featured</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $article->is_featured ? '✅ Yes' : '—' }}</span>
                </div>
                @if($article->published_at)
                <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Published</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $article->published_at->format('M d, Y') }}</span>
                </div>
                @endif
                <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Created</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $article->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center justify-between py-1.5">
                    <span class="text-sm text-gray-500">Last Updated</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $article->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-orange-500"></i> Statistics
            </h3>
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-eye text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xl font-black text-blue-600">{{ number_format($stats['views']) }}</p>
                        <p class="text-xs text-gray-500">Total Views</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-font text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xl font-black text-green-600">{{ number_format($stats['word_count']) }}</p>
                        <p class="text-xs text-gray-500">Words</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-xl">
                    <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clock text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xl font-black text-purple-600">{{ $stats['reading_time'] }} min</p>
                        <p class="text-xs text-gray-500">Reading Time</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Category --}}
        @if($article->category)
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-folder text-orange-500"></i> Category
            </h3>
            <div class="flex items-center gap-3 p-3 rounded-xl" style="background:{{ $article->category->color ?? '#f97316' }}10">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $article->category->color ?? '#f97316' }}22">
                    <i class="{{ $article->category->icon ?? 'fas fa-folder' }} text-xl" style="color:{{ $article->category->color ?? '#f97316' }}"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800">{{ $article->category->name }}</h4>
                    @if($article->category->description)
                        <p class="text-xs text-gray-500">{{ Str::limit($article->category->description, 50) }}</p>
                    @endif
                </div>
            </div>
            <a href="{{ route('admin.categories.show', $article->category) }}" class="block mt-3 text-center text-sm text-orange-500 hover:text-orange-600 font-semibold">
                View Category →
            </a>
        </div>
        @endif

        {{-- Tags --}}
        @if($article->tags->isNotEmpty())
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-tags text-orange-500"></i> Tags
                <span class="ml-auto text-xs text-gray-400">{{ $article->tags->count() }}</span>
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach($article->tags as $tag)
                    <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Image info --}}
        @if($article->image)
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-image text-orange-500"></i> Featured Image
            </h3>
            <img src="{{ $article->image->thumbnail_url }}" alt="{{ $article->title }}" class="w-full h-32 object-cover rounded-xl mb-3">
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">File</span><span class="font-semibold text-gray-800 truncate ml-2 max-w-[140px]">{{ $article->image->file_name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Size</span><span class="font-semibold text-gray-800">{{ $article->image->file_size_formatted }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Type</span><span class="font-semibold text-gray-800">{{ strtoupper(pathinfo($article->image->file_name, PATHINFO_EXTENSION)) }}</span></div>
            </div>
        </div>
        @endif

        {{-- SEO --}}
        @if($article->meta_title || $article->meta_description)
        <div class="card">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-search text-orange-500"></i> SEO Preview
            </h3>
            <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                @if($article->meta_title)
                    <h4 class="text-blue-600 font-semibold mb-1 text-sm">{{ $article->meta_title }}</h4>
                @endif
                @if($article->meta_description)
                    <p class="text-xs text-gray-600 leading-relaxed">{{ $article->meta_description }}</p>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

<form id="delete-form" action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>

@push('styles')
<style>
.prose p{margin-bottom:1em}
.prose h1,.prose h2,.prose h3,.prose h4{margin-top:1.5em;margin-bottom:.5em;font-weight:700}
.prose ul,.prose ol{margin-left:1.5em;margin-bottom:1em}
.prose img{max-width:100%;height:auto;border-radius:.5rem;margin:1.5em 0}
.prose a{color:#f97316;text-decoration:underline}
.prose blockquote{border-left:4px solid #f97316;padding-left:1rem;margin:1.5em 0;font-style:italic;color:#6b7280}
.prose code{background:#f3f4f6;padding:.1em .4em;border-radius:.25em;font-size:.85em}
.prose pre{background:#1f2937;color:#e5e7eb;padding:1.25em;border-radius:.75em;overflow-x:auto;margin:1.5em 0}
</style>
@endpush
@endsection