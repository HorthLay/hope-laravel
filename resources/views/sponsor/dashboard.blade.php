{{-- resources/views/sponsor/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsor Dashboard | {{ $sponsor->full_name }}</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
    body { font-family: 'Montserrat', sans-serif; }
    .tab-btn        { transition: all .15s; border-bottom: 3px solid transparent; }
    .tab-btn.active { border-bottom-color: #f97316; color: #f97316; font-weight: 900; }
    .tab-panel      { display: none; }
    .tab-panel.active { display: block; animation: fadeIn .2s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

{{-- Header --}}
<header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center">
                <i class="fas fa-heart text-white text-sm"></i>
            </div>
            <div><h1 class="text-lg font-black text-gray-800">Hope &amp; Impact</h1><p class="text-xs text-gray-500">Sponsor Dashboard</p></div>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden md:block text-right">
                <p class="text-sm font-bold text-gray-800">{{ $sponsor->full_name }}</p>
                <p class="text-xs text-gray-500">{{ $sponsor->email }}</p>
            </div>
            <form method="POST" action="{{ route('sponsor.logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-lg transition">
                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                </button>
            </form>
        </div>
    </div>
</header>

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Welcome banner --}}
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-8 mb-8 text-white shadow-xl">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0 shadow-lg">
                <span class="text-4xl font-black">{{ strtoupper(substr($sponsor->first_name, 0, 1)) }}</span>
            </div>
            <div class="text-center md:text-left flex-1">
                <h2 class="text-3xl md:text-4xl font-black mb-2">Welcome, {{ $sponsor->first_name }}!</h2>
                <p class="opacity-90 mb-3">Thank you for your generous support.</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-2">
                    @if($families->isNotEmpty())
                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/20 rounded-full text-sm font-bold">
                        <i class="fas fa-home text-xs"></i> {{ $families->count() }} {{ Str::plural('Family', $families->count()) }}
                    </span>
                    @endif
                    @if($children->isNotEmpty())
                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/20 rounded-full text-sm font-bold">
                        <i class="fas fa-child text-xs"></i> {{ $children->count() }} {{ Str::plural('Child', $children->count()) }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs (only if more than one entry total) --}}
    @php $totalTabs = $families->count() + $children->count(); @endphp
    @if($totalTabs > 1)
    <div class="bg-white rounded-2xl shadow-sm mb-6 overflow-x-auto">
        <div class="flex min-w-max px-2">
            @foreach($families as $fi => $family)
            <button type="button"
                    class="tab-btn flex items-center gap-2 px-5 py-4 text-sm font-bold text-gray-500 hover:text-orange-500 whitespace-nowrap {{ $fi === 0 ? 'active' : '' }}"
                    onclick="switchTab({{ $fi }})">
                <i class="fas fa-home text-xs"></i>
                {{ $family->name }}
            </button>
            @endforeach
            @foreach($children as $ci => $child)
            <button type="button"
                    class="tab-btn flex items-center gap-2 px-5 py-4 text-sm font-bold text-gray-500 hover:text-orange-500 whitespace-nowrap {{ ($families->count() + $ci) === 0 ? 'active' : '' }}"
                    onclick="switchTab({{ $families->count() + $ci }})">
                <i class="fas fa-child text-xs"></i>
                {{ $child->first_name }}
            </button>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ══ FAMILY PANELS ══ --}}
    @foreach($families as $fi => $family)
    <div class="tab-panel {{ ($totalTabs === 1 || $fi === 0) ? 'active' : '' }}" id="panel-{{ $fi }}">

        {{-- Family hero card --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden mb-6">
            <div class="flex flex-col sm:flex-row">
                <div class="sm:w-52 h-44 sm:h-auto bg-orange-50 flex-shrink-0 flex items-center justify-center overflow-hidden">
                    @if($family->profile_photo)
                        <img src="{{ $family->profile_photo_url }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-home text-6xl text-orange-200"></i>
                    @endif
                </div>
                <div class="p-6 flex-1">
                    <h3 class="text-2xl font-black text-gray-800 mb-1">{{ $family->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">
                        @if($family->country)<i class="fas fa-map-marker-alt text-orange-400 mr-1"></i>{{ $family->country }} · @endif
                        <span class="font-mono text-xs bg-gray-100 px-1.5 py-0.5 rounded">{{ $family->code }}</span>
                    </p>
                    @if($family->story)
                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">{{ $family->story }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Family stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl p-5 text-center shadow"><div class="text-3xl font-black text-blue-500">{{ $family->media->where('type','photo')->count() }}</div><div class="text-sm text-gray-600 mt-1">Photos</div></div>
            <div class="bg-white rounded-xl p-5 text-center shadow"><div class="text-3xl font-black text-purple-500">{{ $family->media->where('type','video')->count() }}</div><div class="text-sm text-gray-600 mt-1">Videos</div></div>
            <div class="bg-white rounded-xl p-5 text-center shadow"><div class="text-3xl font-black text-green-500">{{ $family->documents->count() }}</div><div class="text-sm text-gray-600 mt-1">Documents</div></div>
            <div class="bg-white rounded-xl p-5 text-center shadow"><div class="text-3xl font-black text-orange-500">{{ $family->media->count() + $family->documents->count() }}</div><div class="text-sm text-gray-600 mt-1">Total Files</div></div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-5">
                {{-- Photos --}}
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-images text-orange-500"></i> Photos</h3>
                    @if($family->media->where('type','photo')->isNotEmpty())
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($family->media->where('type','photo')->take(6) as $photo)
                        <a href="{{ route('sponsor.download', ['type'=>'family_media','id'=>$photo->id]) }}" class="group relative aspect-square overflow-hidden rounded-xl">
                            <img src="{{ $photo->file_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <i class="fas fa-download text-white text-lg"></i>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-400 text-sm text-center py-6"><i class="fas fa-images text-3xl text-gray-200 block mb-2"></i>No photos yet.</p>
                    @endif
                </div>
            </div>
            <div class="space-y-5">
                {{-- Documents --}}
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="text-base font-black text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-file-pdf text-orange-500"></i> Documents</h3>
                    @forelse($family->documents as $doc)
                    <a href="{{ route('sponsor.download', ['type'=>'family_document','id'=>$doc->id]) }}"
                       class="flex items-start gap-3 p-3 bg-gray-50 hover:bg-orange-50 rounded-xl mb-2 last:mb-0 transition group">
                        <div class="w-9 h-9 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0"><i class="fas fa-file-pdf text-red-500 text-sm"></i></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800 group-hover:text-orange-600 truncate">{{ $doc->title }}</p>
                            @if($doc->document_date)<p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($doc->document_date)->format('M d, Y') }}</p>@endif
                        </div>
                        <i class="fas fa-download text-gray-300 group-hover:text-orange-400 transition mt-1"></i>
                    </a>
                    @empty
                    <p class="text-gray-400 text-sm text-center py-3">No documents yet.</p>
                    @endforelse
                </div>
                {{-- Videos --}}
                @if($family->media->where('type','video')->isNotEmpty())
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="text-base font-black text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-video text-orange-500"></i> Videos</h3>
                    @foreach($family->media->where('type','video') as $video)
                    <a href="{{ route('sponsor.download', ['type'=>'family_media','id'=>$video->id]) }}"
                       class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-orange-50 rounded-xl mb-2 last:mb-0 transition group">
                        <i class="fas fa-play-circle text-2xl text-orange-400 flex-shrink-0"></i>
                        <div class="flex-1 min-w-0"><p class="text-sm font-bold text-gray-800 truncate">{{ $video->caption ?? 'Video' }}</p></div>
                        <i class="fas fa-download text-gray-300 group-hover:text-orange-400 transition"></i>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

    </div>{{-- /family panel --}}
    @endforeach

    {{-- ══ INDIVIDUAL CHILD PANELS ══ --}}
    @foreach($children as $ci => $child)
    @php $panelIdx = $families->count() + $ci; @endphp
    <div class="tab-panel {{ ($totalTabs === 1 || $panelIdx === 0) ? 'active' : '' }}" id="panel-{{ $panelIdx }}">

        {{-- Child hero --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden mb-6">
            <div class="flex flex-col sm:flex-row items-center gap-5 p-6">
                <div class="w-28 h-28 rounded-2xl overflow-hidden border-4 border-orange-100 flex-shrink-0 shadow">
                    <img src="{{ $child->profile_photo_url }}" alt="{{ $child->first_name }}" class="w-full h-full object-cover">
                </div>
                <div class="text-center sm:text-left">
                    <h3 class="text-2xl font-black text-gray-800">{{ $child->first_name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fas fa-birthday-cake text-orange-400 mr-1"></i>{{ $child->age }} years old ·
                        <i class="fas fa-map-marker-alt text-orange-400 mx-1"></i>{{ $child->country }}
                    </p>
                    <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded inline-block mt-1">{{ $child->code }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl p-5 text-center shadow"><div class="text-3xl font-black text-orange-500">{{ $child->updates->count() }}</div><div class="text-sm text-gray-600 mt-1">Updates</div></div>
            <div class="bg-white rounded-xl p-5 text-center shadow"><div class="text-3xl font-black text-blue-500">{{ $child->media->where('type','photo')->count() }}</div><div class="text-sm text-gray-600 mt-1">Photos</div></div>
            <div class="bg-white rounded-xl p-5 text-center shadow"><div class="text-3xl font-black text-green-500">{{ $child->documents->count() }}</div><div class="text-sm text-gray-600 mt-1">Documents</div></div>
            <div class="bg-white rounded-xl p-5 text-center shadow"><div class="text-3xl font-black text-purple-500">{{ $child->media->where('type','video')->count() }}</div><div class="text-sm text-gray-600 mt-1">Videos</div></div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-5">
                @if($child->story)
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="text-lg font-black text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-book text-orange-500"></i> {{ $child->first_name }}'s Story</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">{{ $child->story }}</p>
                </div>
                @endif
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-newspaper text-orange-500"></i> Latest Updates</h3>
                    @forelse($child->updates->take(3) as $update)
                    <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                        <div class="flex items-start justify-between mb-1">
                            <h4 class="font-bold text-gray-800 text-sm">{{ $update->title }}</h4>
                            <span class="text-xs text-gray-400 ml-2 flex-shrink-0">{{ \Carbon\Carbon::parse($update->report_date)->format('M d, Y') }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $update->content }}</p>
                    </div>
                    @empty
                    <p class="text-gray-400 text-sm text-center py-4">No updates yet.</p>
                    @endforelse
                </div>
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-images text-orange-500"></i> Photos</h3>
                    @if($child->media->where('type','photo')->isNotEmpty())
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($child->media->where('type','photo')->take(6) as $photo)
                        <a href="{{ route('sponsor.download', ['type'=>'media','id'=>$photo->id]) }}" class="group relative aspect-square overflow-hidden rounded-xl">
                            <img src="{{ $photo->file_url ?? asset($photo->file_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <i class="fas fa-download text-white text-lg"></i>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-400 text-sm text-center py-6"><i class="fas fa-images text-3xl text-gray-200 block mb-2"></i>No photos yet.</p>
                    @endif
                </div>
            </div>
            <div class="space-y-5">
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="text-base font-black text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-file-pdf text-orange-500"></i> Documents</h3>
                    @forelse($child->documents as $doc)
                    <a href="{{ route('sponsor.download', ['type'=>'document','id'=>$doc->id]) }}"
                       class="flex items-start gap-3 p-3 bg-gray-50 hover:bg-orange-50 rounded-xl mb-2 last:mb-0 transition group">
                        <div class="w-9 h-9 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0"><i class="fas fa-file-pdf text-red-500 text-sm"></i></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800 group-hover:text-orange-600 truncate">{{ $doc->title }}</p>
                            <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($doc->document_date)->format('M d, Y') }}</p>
                        </div>
                        <i class="fas fa-download text-gray-300 group-hover:text-orange-400 transition mt-1"></i>
                    </a>
                    @empty
                    <p class="text-gray-400 text-sm text-center py-3">No documents yet.</p>
                    @endforelse
                </div>
                @if($child->media->where('type','video')->isNotEmpty())
                <div class="bg-white rounded-xl p-6 shadow">
                    <h3 class="text-base font-black text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-video text-orange-500"></i> Videos</h3>
                    @foreach($child->media->where('type','video') as $video)
                    <a href="{{ route('sponsor.download', ['type'=>'media','id'=>$video->id]) }}"
                       class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-orange-50 rounded-xl mb-2 last:mb-0 transition group">
                        <i class="fas fa-play-circle text-2xl text-orange-400 flex-shrink-0"></i>
                        <div class="flex-1 min-w-0"><p class="text-sm font-bold text-gray-800 truncate">{{ $video->caption ?? 'Video' }}</p></div>
                        <i class="fas fa-download text-gray-300 group-hover:text-orange-400 transition"></i>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

    </div>{{-- /child panel --}}
    @endforeach

    <div class="mt-10 bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6">
        <p class="text-sm text-gray-700 leading-relaxed">
            <i class="fas fa-info-circle text-orange-500 mr-2"></i>
            <strong>Thank you for your continued support!</strong> Your sponsorship makes a real difference.
            Questions? Contact <a href="mailto:sponsors@hopeimpact.org" class="text-orange-600 hover:underline font-bold">sponsors@hopeimpact.org</a>
        </p>
    </div>

</div>

<script>
function switchTab(index) {
    document.querySelectorAll('.tab-btn').forEach((b, i) => b.classList.toggle('active', i === index));
    document.querySelectorAll('.tab-panel').forEach((p, i) => p.classList.toggle('active', i === index));
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
</body>
</html>