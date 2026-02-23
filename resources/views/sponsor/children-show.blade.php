{{-- resources/views/sponsor/children-show.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $child->first_name }} {{ $child->last_name ?? '' }} | Hope & Impact</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .fade-in { animation: fadeIn .5s ease; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .photo-hero { position: relative; height: 380px; overflow: hidden; }
        @media(max-width:640px) { .photo-hero { height: 260px; } }
        .sticky-cta { position: sticky; top: 16px; }
    </style>
</head>
<body class="bg-gray-50">

@include('layouts.header')

{{-- BREADCRUMB --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ route('home') }}" class="hover:text-orange-500 transition">Home</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <a href="{{ route('sponsor.children') }}" class="hover:text-orange-500 transition">Sponsor a Child</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-gray-700 font-semibold">{{ $child->first_name }}</span>
    </div>
</div>

@php $encId = \Illuminate\Support\Facades\Crypt::encryptString((string)$child->id); @endphp

<div class="max-w-5xl mx-auto px-4 py-8 fade-in">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ══ LEFT ══ --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- PHOTO HERO --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
                <div class="photo-hero relative w-full aspect-[4/5] md:aspect-[16/9] rounded-3xl overflow-hidden shadow-xl">

    <img 
        src="{{ $child->profile_photo ? asset($child->profile_photo) : asset('images/child-placeholder.jpg') }}"
        alt="{{ $child->first_name }}"
        class="absolute inset-0 w-full h-full object-cover object-top"
    >

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

    @if(!empty($child->gender))
    <div class="absolute top-4 right-4 w-10 h-10 rounded-full flex items-center justify-center shadow-lg
        {{ strtolower($child->gender) === 'female' ? 'bg-pink-500' : 'bg-blue-500' }}">
        <i class="fas {{ strtolower($child->gender) === 'female' ? 'fa-venus' : 'fa-mars' }} text-white text-sm"></i>
    </div>
    @endif

    <div class="absolute bottom-0 left-0 right-0 p-6">
        <h1 class="text-3xl md:text-4xl font-black text-white leading-tight mb-2">
            {{ $child->first_name }} {{ $child->last_name ?? '' }}
        </h1>

        <div class="flex flex-wrap items-center gap-2">
            
            @if(!empty($child->code))
            <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full font-mono">
                {{ $child->code }}
            </span>
            @endif

            @if(!empty($child->age) || !empty($child->date_of_birth))
            <span class="flex items-center gap-1.5 bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full">
                <i class="fas fa-birthday-cake text-orange-300 text-[10px]"></i>
                {{ $child->age ?? \Carbon\Carbon::parse($child->date_of_birth)->age }} years old
            </span>
            @endif

            @if(!empty($child->country))
            <span class="flex items-center gap-1.5 bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full">
                <i class="fas fa-map-marker-alt text-orange-300 text-[10px]"></i>
                {{ $child->country }}
            </span>
            @endif

            @if(!empty($child->grade))
            <span class="flex items-center gap-1.5 bg-purple-500/80 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full">
                <i class="fas fa-graduation-cap text-[10px]"></i>
                {{ $child->grade }}
            </span>
            @endif

        </div>
    </div>

</div>

                {{-- Quick stats --}}
                <div class="grid grid-cols-3 divide-x divide-gray-100 border-t border-gray-100">
                    <div class="py-4 text-center">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Age</p>
                        <p class="font-black text-gray-800">
                            {{ $child->age ?? \Carbon\Carbon::parse($child->date_of_birth ?? now())->age }}
                            <span class="font-normal text-sm text-gray-500">yrs</span>
                        </p>
                    </div>
                    <div class="py-4 text-center">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Grade</p>
                        <p class="font-black text-gray-800">{{ $child->grade ?? '—' }}</p>
                    </div>
                    <div class="py-4 text-center">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Status</p>
                        @if($child->is_sponsored)
                        <span class="inline-flex items-center gap-1 text-green-600 font-black text-sm">
                            <i class="fas fa-check-circle text-xs"></i> Sponsored
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 text-orange-500 font-black text-sm">
                            <i class="fas fa-clock text-xs"></i> Waiting
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- MY STORY --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-book-open text-orange-500"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-gray-800">My Story</h2>
                        <p class="text-xs text-gray-400">About {{ $child->first_name }}</p>
                    </div>
                </div>
                <div class="text-gray-600 leading-relaxed text-sm">
                    @if(!empty($child->story))
                        {!! nl2br(e($child->story)) !!}
                    @else
                        <p class="text-gray-400 italic">{{ $child->first_name }}'s story will be shared soon. Your sponsorship can help write a brighter chapter for their life.</p>
                    @endif
                </div>

                {{-- Extra details --}}
                @if(!empty($child->date_of_birth) || !empty($child->school) || !empty($child->dream) || !empty($child->hobbies))
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 pt-5 border-t border-gray-100">
                    @if(!empty($child->date_of_birth))
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-birthday-cake text-blue-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Birthday</p>
                            <p class="font-bold text-gray-700 text-sm">{{ \Carbon\Carbon::parse($child->date_of_birth)->format('F d, Y') }}</p>
                        </div>
                    </div>
                    @endif
                    @if(!empty($child->school))
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-school text-green-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">School</p>
                            <p class="font-bold text-gray-700 text-sm">{{ $child->school }}</p>
                        </div>
                    </div>
                    @endif
                    @if(!empty($child->dream))
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-star text-purple-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Dream</p>
                            <p class="font-bold text-gray-700 text-sm">{{ $child->dream }}</p>
                        </div>
                    </div>
                    @endif
                    @if(!empty($child->hobbies))
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-pink-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-palette text-pink-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Hobbies</p>
                            <p class="font-bold text-gray-700 text-sm">{{ $child->hobbies }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>

        </div>
        {{-- /LEFT --}}

        {{-- ══ RIGHT SIDEBAR ══ --}}
        <div class="w-full lg:w-72 flex-shrink-0">
            <div class="sticky-cta space-y-4">

                {{-- SPONSOR CARD --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                    <div class="text-center mb-4">
                        <span class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 text-xs font-black px-3 py-1.5 rounded-full border border-orange-100 mb-3">
                            <i class="fas fa-heart animate-pulse"></i> Sponsorship
                        </span>
                        <h3 class="text-xl font-black text-gray-800">Sponsor {{ $child->first_name }}</h3>
                        <p class="text-sm text-gray-400 mt-1">Make a direct impact in this child's life</p>
                    </div>

                    <div class="bg-orange-50 rounded-2xl p-4 mb-4 text-center border border-orange-100">
                        <p class="text-4xl font-black text-orange-500">$30</p>
                        <p class="text-xs text-gray-500 font-medium">per month · just $1/day</p>
                    </div>

                    <ul class="space-y-2.5 mb-5">
                        @foreach(['Education & school supplies','Nutritious daily meals','Healthcare & medical','Safe shelter support','Progress reports & updates'] as $benefit)
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-500 text-[9px]"></i>
                            </div>
                            {{ $benefit }}
                        </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('sponsor.child', $encId) }}"
                       class="block w-full py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-black text-center rounded-2xl transition shadow-md shadow-orange-200 text-base">
                        <i class="fas fa-heart mr-2"></i> Sponsor {{ $child->first_name }} Now
                    </a>
                    <p class="text-center text-[10px] text-gray-400 mt-3">
                        <i class="fas fa-lock mr-1"></i> Secure & safe donation process
                    </p>
                </div>

                {{-- BACK --}}
                <a href="{{ route('sponsor.children') }}"
                   class="flex items-center justify-center gap-2 py-3 bg-white hover:bg-gray-50 border border-gray-200 text-gray-600 font-bold text-sm rounded-2xl transition w-full">
                    <i class="fas fa-arrow-left text-xs"></i> Back to All Children
                </a>

            </div>
        </div>

    </div>
</div>

{{-- BOTTOM CTA --}}
<section class="bg-gradient-to-br from-orange-500 to-orange-600 py-14 mt-8">
    <div class="max-w-3xl mx-auto px-4 text-center text-white">
        <h2 class="text-2xl md:text-3xl font-black mb-3">Ready to Change {{ $child->first_name }}'s Life?</h2>
        <p class="text-white/90 text-base mb-6 max-w-lg mx-auto">
            Every month your support gives {{ $child->first_name }} access to education, meals, healthcare, and hope.
        </p>
        <a href="{{ route('sponsor.child', $encId) }}"
           class="inline-flex items-center gap-3 px-8 py-4 bg-white text-orange-600 hover:bg-orange-50 font-black text-base rounded-2xl transition shadow-lg">
            <i class="fas fa-heart text-orange-500"></i>
            Sponsor {{ $child->first_name }} — $30/month
        </a>
    </div>
</section>

@include('layouts.footer')
@include('layouts.navigation')

<script>
const mobileMenu = document.getElementById('mobile-menu');
const overlay    = document.getElementById('mobile-menu-overlay');
const openMenu   = () => { mobileMenu?.classList.add('active'); overlay?.classList.add('active'); document.body.style.overflow='hidden'; };
const closeMenu  = () => { mobileMenu?.classList.remove('active'); overlay?.classList.remove('active'); document.body.style.overflow=''; };
document.getElementById('mobile-menu-btn')?.addEventListener('click', openMenu);
document.getElementById('menu-nav-item')?.addEventListener('click', e => { e.preventDefault(); openMenu(); });
document.getElementById('close-menu')?.addEventListener('click', closeMenu);
overlay?.addEventListener('click', closeMenu);
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function() {
        if (this.id !== 'menu-nav-item') {
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            this.classList.add('active');
        }
    });
});
</script>
</body>
</html>