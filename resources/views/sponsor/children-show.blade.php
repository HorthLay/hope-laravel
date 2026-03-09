{{-- resources/views/sponsor/children-show.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $child->first_name }} {{ $child->last_name ?? '' }} | {{ ($settings['site_name'] ?? 'Hope & Impact') }}</title>
    <meta name="description" content="{{ $child->story ? \Illuminate\Support\Str::limit(strip_tags($child->story), 150) : ($settings['meta_description'] ?? $settings['site_description'] ?? '') }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '' }}">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
     @endif
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
@if(!empty($settings['maintenance_mode']) && $settings['maintenance_mode'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; position: relative;
        }
        .bg-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(80px); }
        .bg-orb-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(249,115,22,.18) 0%, transparent 70%);
            top: -150px; right: -100px;
            animation: orbFloat 8s ease-in-out infinite;
        }
        .bg-orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(251,191,36,.1) 0%, transparent 70%);
            bottom: -120px; left: -80px;
            animation: orbFloat 10s ease-in-out infinite reverse;
        }
        .bg-orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(59,130,246,.1) 0%, transparent 70%);
            top: 40%; left: 50%;
            animation: orbFloat3 12s ease-in-out infinite 2s;
        }
        @keyframes orbFloat      { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-30px) scale(1.05)} }
        @keyframes orbFloat3     { 0%,100%{transform:translate(-50%,-50%) scale(1)} 50%{transform:translate(-50%,-55%) scale(1.05)} }
        .bg-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
            background-size: 48px 48px; pointer-events: none;
        }
        .maint-card {
            position: relative; z-index: 10;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.1);
            backdrop-filter: blur(24px);
            border-radius: 32px; padding: 52px 44px 48px;
            max-width: 520px; width: calc(100% - 32px);
            text-align: center;
            box-shadow: 0 32px 96px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.1);
            animation: cardIn .7s cubic-bezier(.34,1.1,.64,1) both;
        }
        @keyframes cardIn { from{opacity:0;transform:translateY(32px) scale(.96)} to{opacity:1;transform:none} }
        .gear-wrap {
            width: 88px; height: 88px; border-radius: 24px; margin: 0 auto 28px;
            background: linear-gradient(135deg, rgba(249,115,22,.25), rgba(234,88,12,.15));
            border: 1px solid rgba(249,115,22,.3);
            display: flex; align-items: center; justify-content: center; position: relative;
        }
        .gear-wrap::before {
            content: ''; position: absolute; inset: -6px; border-radius: 28px;
            border: 1px dashed rgba(249,115,22,.25);
            animation: gearSpin 12s linear infinite;
        }
        @keyframes gearSpin { to{transform:rotate(360deg)} }
        .gear-icon { font-size: 36px; color: #f97316; animation: gearSpin 6s linear infinite; }
        .maint-label {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(249,115,22,.15); border: 1px solid rgba(249,115,22,.3);
            color: #fb923c; font-size: 11px; font-weight: 800; letter-spacing: .1em;
            text-transform: uppercase; padding: 5px 14px; border-radius: 99px; margin-bottom: 20px;
            animation: pulseLbl 2s ease-in-out infinite;
        }
        @keyframes pulseLbl { 0%,100%{opacity:1} 50%{opacity:.65} }
        .maint-label .dot { width: 7px; height: 7px; border-radius: 50%; background: #f97316; animation: pulseLbl 1.4s ease-in-out infinite; }
        h1 { font-family: 'Instrument Serif', serif; font-size: clamp(26px,6vw,38px); color: #fff; line-height: 1.2; margin-bottom: 14px; }
        h1 em { color: #fb923c; font-style: italic; }
        .maint-desc { font-size: 15px; color: rgba(255,255,255,.5); line-height: 1.7; margin-bottom: 32px; font-weight: 500; }
        .maint-features { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-bottom: 32px; }
        .maint-feat {
            display: flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px; padding: 8px 14px;
            font-size: 12px; font-weight: 700; color: rgba(255,255,255,.7);
        }
        .maint-feat i { font-size: 11px; color: #f97316; }
        .maint-divider { height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,.1), transparent); margin-bottom: 28px; }
        .maint-contact { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .maint-contact a {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 18px; border-radius: 12px; text-decoration: none;
            font-size: 13px; font-weight: 700; transition: all .2s; border: 1px solid;
        }
        .maint-contact a.primary {
            background: linear-gradient(135deg,#f97316,#ea580c); border-color: transparent; color: #fff;
            box-shadow: 0 4px 20px rgba(249,115,22,.35);
        }
        .maint-contact a.primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(249,115,22,.45); }
        .maint-contact a.secondary { background: rgba(255,255,255,.05); border-color: rgba(255,255,255,.12); color: rgba(255,255,255,.7); }
        .maint-contact a.secondary:hover { background: rgba(255,255,255,.1); color: #fff; }
        .maint-logo { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 32px; }
        .maint-logo img { height: 52px; width: auto; filter: brightness(1.1); }
        .maint-logo-name { font-size: 15px; font-weight: 900; color: #fff; text-align: left; }
        .maint-logo-tag  { font-size: 11px; color: rgba(255,255,255,.4); font-weight: 600; text-align: left; }
        .maint-footer { margin-top: 36px; font-size: 11px; color: rgba(255,255,255,.25); font-weight: 600; }
        @media (max-width: 480px) {
            .maint-card { padding: 36px 24px 32px; border-radius: 24px; }
            .gear-wrap { width: 72px; height: 72px; border-radius: 20px; }
            .gear-icon { font-size: 28px; }
            .maint-feat { font-size: 11px; padding: 7px 11px; }
            .maint-contact a { padding: 9px 14px; font-size: 12px; }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
    <div class="maint-card">
        @if(!empty($settings['logo']))
        <div class="maint-logo">
            <img src="{{ asset($settings['logo']) }}" alt="{{ $settings['site_name'] ?? '' }}">
            <div>
                <div class="maint-logo-name">{{ $settings['site_name'] ?? 'Hope & Impact' }}</div>
                <div class="maint-logo-tag">{{ $settings['site_tagline'] ?? '' }}</div>
            </div>
        </div>
        @else
        <div style="font-size:15px;font-weight:900;color:#fff;margin-bottom:28px;opacity:.7">{{ $settings['site_name'] ?? 'Hope & Impact' }}</div>
        @endif
        <div class="maint-label"><span class="dot"></span> Under Maintenance</div>
        <div class="gear-wrap"><i class="fas fa-cog gear-icon"></i></div>
        <h1>We'll be <em>back soon!</em></h1>
        <p class="maint-desc">Our website is currently undergoing scheduled maintenance and improvements. We apologize for the inconvenience and appreciate your patience.</p>
        <div class="maint-features">
            <div class="maint-feat"><i class="fas fa-wrench"></i> Updates in progress</div>
            <div class="maint-feat"><i class="fas fa-shield-alt"></i> Securing systems</div>
            <div class="maint-feat"><i class="fas fa-rocket"></i> Performance boost</div>
        </div>
        <div class="maint-divider"></div>
        <p style="font-size:13px;color:rgba(255,255,255,.45);margin-bottom:16px;font-weight:600">Need urgent assistance?</p>
        <div class="maint-contact">
            @php
                $mEmail    = $settings['contact_email'] ?? null;
                $mWhatsapp = $settings['whatsapp_url']  ?? null;
                $mFacebook = $settings['facebook_url']  ?? null;
            @endphp
            @if($mEmail)
            <a href="https://mail.google.com/mail/?view=cm&to={{ $mEmail }}" target="_blank" class="primary">
                <i class="fas fa-envelope"></i> Email Us
            </a>
            @endif
            @if($mWhatsapp)
            <a href="https://wa.me/{{ $mWhatsapp }}" target="_blank" class="secondary">
                <i class="fab fa-whatsapp" style="color:#22c55e"></i> WhatsApp
            </a>
            @endif
            @if($mFacebook)
            <a href="{{ $mFacebook }}" target="_blank" class="secondary">
                <i class="fab fa-facebook" style="color:#60a5fa"></i> Facebook
            </a>
            @endif
            @if(!$mEmail && !$mWhatsapp && !$mFacebook)
            <span style="font-size:12px;color:rgba(255,255,255,.35)">Contact information coming soon.</span>
            @endif
        </div>
        <p class="maint-footer">&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Hope & Impact' }} &middot; All rights reserved</p>
    </div>
</body>
</html>
<?php exit; ?>
@endif
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

            @if(!empty($child->has_family))
             <span class="flex items-center gap-1.5 bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full">
                <i class="fas fa-home text-green-300 text-[10px]"></i>
                Has Family
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
                    <p class="text-xs text-gray-400 font-medium mb-0.5">Has Family</p>

                    <p class="font-black {{ $child->has_family ? 'text-green-600' : 'text-red-600' }}">
                        {{ $child->has_family ? 'Yes' : 'No' }}
                    </p>
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

                    <a href="https://www.helloasso.com/associations/des-ailes-pour-grandir/formulaires/1"
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