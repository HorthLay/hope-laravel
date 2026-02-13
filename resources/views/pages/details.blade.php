{{-- resources/views/pages/details.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sponsor a Child | Hope & Impact</title>
    <meta name="description" content="Sponsor a child today and change a life forever. Connect with us via Telegram, WhatsApp, Instagram, or X (Twitter) to begin your sponsorship journey.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')

    <style>
        /* ── Animations ── */
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        @keyframes pulse-ring { 0%{transform:scale(1);opacity:.6} 100%{transform:scale(1.5);opacity:0} }
        @keyframes slide-up { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fade-in { from{opacity:0} to{opacity:1} }
        @keyframes shimmer { 0%{background-position:200% center} 100%{background-position:-200% center} }
        @keyframes bounce-in { 0%{transform:scale(.3);opacity:0} 50%{transform:scale(1.1)} 70%{transform:scale(.9)} 100%{transform:scale(1);opacity:1} }

        .float    { animation: float 3s ease-in-out infinite; }
        .slide-up { animation: slide-up .7s ease forwards; }
        .fade-in  { animation: fade-in .5s ease forwards; }

        /* ── Gradient text ── */
        .gradient-text {
            background: linear-gradient(135deg, #f97316, #ea580c, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .shimmer-text {
            background: linear-gradient(90deg, #f97316 0%, #fbbf24 30%, #f97316 60%, #ea580c 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        /* ── Hero ── */
        .sponsor-hero {
            background: linear-gradient(135deg, #1c0a00 0%, #431407 40%, #7c2d12 70%, #1c0a00 100%);
            position: relative;
            overflow: hidden;
        }
        .sponsor-hero::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(249,115,22,.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(234,88,12,.12) 0%, transparent 40%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f97316' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* ── Tier cards ── */
        /* tier-card styles now handled inline per card */

        /* ── Pulse ring ── */
        .pulse-ring::before, .pulse-ring::after {
            content: '';
            position: absolute; inset: -6px;
            border-radius: 50%;
            border: 2px solid #f97316;
            animation: pulse-ring 2s ease-out infinite;
        }
        .pulse-ring::after { animation-delay: 1s; }

        /* ── Contact card ── */
        .contact-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 16px rgba(0,0,0,.06);
            transition: all .25s ease;
        }
        .contact-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,.12);
        }

        /* ── Step connector ── */
        .step-line::after {
            content: '';
            position: absolute; top: 50%; left: calc(100% + 8px);
            width: calc(100% - 16px); height: 2px;
            background: linear-gradient(90deg, #f97316, transparent);
            transform: translateY(-50%);
        }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 9999;
            background: rgba(0,0,0,.8);
            backdrop-filter: blur(6px);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden;
            transition: all .3s ease;
        }
        .modal-overlay.active {
            opacity: 1; visibility: visible;
        }
        .modal-box {
            background: #fff;
            border-radius: 2rem;
            max-width: 420px; width: 90%;
            transform: scale(.85);
            transition: transform .35s cubic-bezier(.34,1.56,.64,1);
            box-shadow: 0 40px 80px rgba(0,0,0,.4);
            overflow: hidden;
            position: relative;
        }
        .modal-overlay.active .modal-box {
            transform: scale(1);
        }

        /* ── KHQR frame ── */
        .khqr-frame {
            background: linear-gradient(135deg, #c8102e, #be0026);
            padding: 16px;
            border-radius: 1.25rem;
        }
        .khqr-inner {
            background: #fff;
            border-radius: 0.75rem;
            padding: 12px;
        }

        /* ── Scroll animate ── */
        .reveal { opacity:0; transform:translateY(24px); transition:all .6s ease; }
        .reveal.show { opacity:1; transform:none; }
    </style>
</head>
<body class="bg-gray-50">

@include('layouts.header')

@php
    // Build contact URLs from settings (with safe fallbacks)
    $tgUrl    = !empty($settings['telegram_url'])
                    ? 'https://t.me/' . ltrim($settings['telegram_url'], '@/')
                    : '#';
    $waUrl    = !empty($settings['whatsapp_url'])
                    ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $settings['whatsapp_url'])
                    : '#';
    $igUrl    = $settings['instagram_url']  ?? '#';
    $xUrl     = $settings['x_url']          ?? '#';
    $khqrImg  = !empty($settings['khqr_image'])
                    ? asset($settings['khqr_image'])
                    : asset('images/khqr.png');
    $accName  = $settings['account_name'] ?? 'Hope & Impact Foundation';
    $accBank  = $settings['account_bank'] ?? 'ABA Bank · Phnom Penh, Cambodia';
@endphp


{{-- ══════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════ --}}
<section class="sponsor-hero min-h-[65vh] flex items-center py-20 md:py-28">
    <div class="relative z-10 max-w-7xl mx-auto px-4 text-center text-white">

        {{-- Floating hearts decoration --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            @foreach([['top-10','left-8','text-2xl','delay-0'],['top-20','right-12','text-lg','delay-700'],['bottom-16','left-20','text-xl','delay-300'],['bottom-8','right-8','text-3xl','delay-1000']] as $h)
            <i class="fas fa-heart absolute opacity-10 float {{ $h[2] }} {{ $h[3] }}"
               style="top:{{ $loop->index * 22 + 5 }}%;{{ $loop->index % 2 === 0 ? 'left' : 'right' }}:{{ $loop->index * 15 + 5 }}%;animation-delay:{{ $loop->index * 0.4 }}s"></i>
            @endforeach
        </div>

        <div class="inline-flex items-center gap-2 bg-orange-500/20 border border-orange-500/30 text-orange-300 text-xs font-bold px-4 py-2 rounded-full mb-6 backdrop-blur-sm">
            <i class="fas fa-heart text-orange-400"></i>
            Change a Life Today
        </div>

        <h1 class="text-4xl sm:text-5xl md:text-7xl  mb-6 leading-tight" style="font-weight:900">
            Become a <span class="shimmer-text">Sponsor</span>
        </h1>
        <p class="text-base md:text-xl text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">
            For the cost of a coffee a day, you can give a child in Southeast Asia
            access to education, meals, and a future full of possibility.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button onclick="openKhqr()"
                    class="group relative inline-flex items-center gap-3 px-8 py-4 bg-orange-500 hover:bg-orange-400 text-white font-black text-base rounded-2xl transition-all shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:scale-105">
                <div class="relative w-6 h-6 pulse-ring">
                    <i class="fas fa-qrcode text-white relative z-10"></i>
                </div>
                Donate via KHQR
                <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </button>
            <a href="#contact"
               class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white/30 hover:border-white text-white font-bold text-base rounded-2xl transition-all hover:bg-white/10 backdrop-blur-sm">
                <i class="fas fa-comment-dots"></i>
                Contact Us to Sponsor
            </a>
        </div>

        {{-- Quick trust stats --}}
        <div class="mt-16 grid grid-cols-3 gap-4 max-w-lg mx-auto">
            @foreach([['95,000+','Children Helped'],['66','Years of Service'],['84%','Goes to Programs']] as $s)
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3">
                <div class="text-xl md:text-2xl font-black text-orange-300">{{ $s[0] }}</div>
                <div class="text-xs text-white/70 font-medium">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     SPONSORSHIP TIERS
══════════════════════════════════════════════════════ --}}
<section class="py-16 md:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-14 reveal">
            <span class="inline-block bg-orange-100 text-orange-600 text-xs font-bold px-4 py-2 rounded-full mb-4">SPONSORSHIP OPTIONS</span>
            <h2 class="text-3xl md:text-4xl text-gray-900 mb-3" style="font-weight:900">Choose Your Impact</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Every contribution, big or small, directly reaches children in need. Choose a level that works for you.</p>
        </div>

        {{-- Wrapper with padding-top so the badge floats above cards without clipping --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 items-start" style="padding-top:1.5rem">

            {{-- Basic --}}
            <div class="reveal" style="transition-delay:.1s">
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-7 h-full flex flex-col border border-gray-100">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-5">
                        <i class="fas fa-seedling text-blue-500 text-2xl"></i>
                    </div>
                    <div class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-2">Hope Giver</div>
                    <div class="flex items-end gap-1 mb-1">
                        <span class="text-5xl text-gray-900" style="font-weight:900">$15</span>
                        <span class="text-gray-400 text-sm mb-2">/ month</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-6">≈ $0.50 per day</p>
                    <ul class="space-y-3 mb-7 text-sm flex-1">
                        @foreach(['School supplies & books','Monthly progress report','Photo updates','Certificate of sponsorship'] as $b)
                        <li class="flex items-center gap-3 text-gray-600">
                            <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-blue-500" style="font-size:9px"></i>
                            </div>
                            {{ $b }}
                        </li>
                        @endforeach
                    </ul>
                    <button onclick="openContact('Hope Giver – $15/month')"
                            class="w-full py-3.5 rounded-xl border-2 border-blue-400 text-blue-600 font-bold hover:bg-blue-500 hover:text-white hover:border-blue-500 transition-all text-sm">
                        Start Sponsoring
                    </button>
                </div>
            </div>

            {{-- Popular — badge sits ABOVE the card, no overflow clipping --}}
            <div class="reveal" style="transition-delay:.2s">
                {{-- Badge outside the card so it never gets clipped --}}
                <div class="text-center mb-[-1px] relative z-10">
                    <span class="inline-flex items-center gap-1.5 bg-orange-500 text-white text-xs font-bold px-5 py-2 rounded-t-2xl shadow-md" style="font-weight:800">
                        ⭐ MOST POPULAR
                    </span>
                </div>
                <div class="bg-white rounded-3xl shadow-xl transition-all duration-300 hover:-translate-y-1 p-7 h-full flex flex-col"
                     style="border:3px solid #f97316;border-top-left-radius:0;box-shadow:0 20px 50px rgba(249,115,22,.18)">
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center mb-5">
                        <i class="fas fa-star text-orange-500 text-2xl"></i>
                    </div>
                    <div class="text-xs font-bold text-orange-500 uppercase tracking-widest mb-2">Life Changer</div>
                    <div class="flex items-end gap-1 mb-1">
                        <span class="text-5xl text-gray-900" style="font-weight:900">$30</span>
                        <span class="text-gray-400 text-sm mb-2">/ month</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-6">≈ $1 per day</p>
                    <ul class="space-y-3 mb-7 text-sm flex-1">
                        @foreach(['Everything in Hope Giver','School fees covered','Healthcare check-ups','Nutritional meal program','Personal letters from child','Annual visit opportunity'] as $b)
                        <li class="flex items-center gap-3 text-gray-700">
                            <div class="w-5 h-5 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-orange-500" style="font-size:9px"></i>
                            </div>
                            {{ $b }}
                        </li>
                        @endforeach
                    </ul>
                    <button onclick="openContact('Life Changer – $30/month')"
                            class="w-full py-3.5 rounded-xl bg-orange-500 hover:bg-orange-400 text-white font-bold transition-all text-sm"
                            style="box-shadow:0 8px 24px rgba(249,115,22,.35)">
                        Start Sponsoring
                    </button>
                </div>
            </div>

            {{-- Premium --}}
            <div class="reveal" style="transition-delay:.3s">
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-7 h-full flex flex-col border border-gray-100">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center mb-5">
                        <i class="fas fa-crown text-purple-500 text-2xl"></i>
                    </div>
                    <div class="text-xs font-bold text-purple-500 uppercase tracking-widest mb-2">Future Builder</div>
                    <div class="flex items-end gap-1 mb-1">
                        <span class="text-5xl text-gray-900" style="font-weight:900">$60</span>
                        <span class="text-gray-400 text-sm mb-2">/ month</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-6">≈ $2 per day</p>
                    <ul class="space-y-3 mb-7 text-sm flex-1">
                        @foreach(['Everything in Life Changer','University sponsorship fund','Business skills training','Family support program','Dedicated case manager','Impact report & videos'] as $b)
                        <li class="flex items-center gap-3 text-gray-600">
                            <div class="w-5 h-5 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-purple-500" style="font-size:9px"></i>
                            </div>
                            {{ $b }}
                        </li>
                        @endforeach
                    </ul>
                    <button onclick="openContact('Future Builder – $60/month')"
                            class="w-full py-3.5 rounded-xl border-2 border-purple-400 text-purple-600 font-bold hover:bg-purple-500 hover:text-white hover:border-purple-500 transition-all text-sm">
                        Start Sponsoring
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     HOW IT WORKS
══════════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12 reveal">
            <span class="inline-block bg-orange-100 text-orange-600 text-xs font-bold px-4 py-2 rounded-full mb-4">SIMPLE PROCESS</span>
            <h2 class="text-3xl md:text-4xl  text-gray-900 mb-3" style="font-weight:900">How Sponsorship Works</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Three simple steps to start changing a child's life forever.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            {{-- Connecting line (desktop only) --}}
            <div class="hidden md:block absolute top-10 left-[33%] right-[33%] h-0.5 bg-gradient-to-r from-orange-300 via-orange-400 to-orange-300"></div>

            @foreach([
                ['fas fa-hand-holding-heart','1','Choose a Tier','Select a monthly sponsorship level that fits your budget — every amount makes a real difference.','orange'],
                ['fas fa-comment-dots','2','Contact Us','Reach us via Telegram, WhatsApp, or Instagram. We\'ll match you with a child and guide you through the process.','blue'],
                ['fas fa-child','3','Change a Life','Receive regular updates, photos, and letters directly from your sponsored child as they grow.','green'],
            ] as $i => $step)
            <div class="reveal text-center" style="transition-delay:{{ $i * 0.15 }}s">
                <div class="relative w-20 h-20 rounded-full bg-{{ $step[4] }}-500 flex items-center justify-center mx-auto mb-5 shadow-lg shadow-{{ $step[4] }}-200">
                    <i class="{{ $step[0] }} text-white text-2xl"></i>
                    <div class="absolute -top-2 -right-2 w-7 h-7 rounded-full bg-white border-2 border-{{ $step[4] }}-500 flex items-center justify-center font-black text-{{ $step[4] }}-600 text-sm shadow">
                        {{ $step[1] }}
                    </div>
                </div>
                <h3 class="text-lg  text-gray-900 mb-2" style="font-weight:900">{{ $step[2] }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">{{ $step[3] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     CONTACT / REACH US  (id="contact")
══════════════════════════════════════════════════════ --}}
<section id="contact" class="py-16 md:py-24 bg-white">
    <div class="max-w-5xl mx-auto px-4">

        <div class="text-center mb-12 reveal">
            <span class="inline-block bg-orange-100 text-orange-600 text-xs font-bold px-4 py-2 rounded-full mb-4">GET IN TOUCH</span>
            <h2 class="text-3xl md:text-4xl  text-gray-900 mb-3" style="font-weight:900">Ready to Sponsor?</h2>
            <p class="text-gray-500 max-w-lg mx-auto">No complicated forms. Just reach out on any platform you prefer — our team responds within 24 hours.</p>
        </div>

        {{-- Contact cards grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-12">

            {{-- Telegram --}}
            <a href="{{ $tgUrl }}" target="_blank" rel="noopener"
               class="contact-card p-6 text-center group reveal" style="transition-delay:.05s">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 bg-[#2ca5e0]/10 group-hover:bg-[#2ca5e0]/20 transition">
                    <i class="fab fa-telegram text-[#2ca5e0] text-3xl"></i>
                </div>
                <h3 class=" text-gray-900 text-base mb-1" style="font-weight:900">Telegram</h3>
                <p class="text-xs text-gray-500 mb-3 leading-relaxed">Fastest response — chat directly with our team</p>
                <span class="inline-flex items-center gap-1 text-[#2ca5e0] text-xs font-bold group-hover:gap-2 transition-all">
                    Message Us <i class="fas fa-arrow-right text-[10px]"></i>
                </span>
            </a>

            {{-- WhatsApp --}}
            <a href="{{ $waUrl }}" target="_blank" rel="noopener"
               class="contact-card p-6 text-center group reveal" style="transition-delay:.1s">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 bg-[#25d366]/10 group-hover:bg-[#25d366]/20 transition">
                    <i class="fab fa-whatsapp text-[#25d366] text-3xl"></i>
                </div>
                <h3 class=" text-gray-900 text-base mb-1" style="font-weight:900">WhatsApp</h3>
                <p class="text-xs text-gray-500 mb-3 leading-relaxed">Call or message us anytime from anywhere</p>
                <span class="inline-flex items-center gap-1 text-[#25d366] text-xs font-bold group-hover:gap-2 transition-all">
                    Chat Now <i class="fas fa-arrow-right text-[10px]"></i>
                </span>
            </a>

            {{-- Instagram --}}
            <a href="{{ $igUrl }}" target="_blank" rel="noopener"
               class="contact-card p-6 text-center group reveal" style="transition-delay:.15s">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 bg-pink-50 group-hover:bg-pink-100 transition">
                    <i class="fab fa-instagram text-3xl" style="background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text"></i>
                </div>
                <h3 class=" text-gray-900 text-base mb-1" style="font-weight:900">Instagram</h3>
                <p class="text-xs text-gray-500 mb-3 leading-relaxed">Follow our stories and DM us to get started</p>
                <span class="inline-flex items-center gap-1 text-pink-500 text-xs font-bold group-hover:gap-2 transition-all">
                    Follow & DM <i class="fas fa-arrow-right text-[10px]"></i>
                </span>
            </a>

            {{-- KHQR --}}
            <button onclick="openKhqr()"
                    class="contact-card p-6 text-center group reveal w-full cursor-pointer" style="transition-delay:.2s">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 bg-red-50 group-hover:bg-red-100 transition">
                    <i class="fas fa-qrcode text-[#c8102e] text-3xl"></i>
                </div>
                <h3 class=" text-gray-900 text-base mb-1" style="font-weight:900">KHQR / ABA</h3>
                <p class="text-xs text-gray-500 mb-3 leading-relaxed">Scan to donate directly — fast & secure</p>
                <span class="inline-flex items-center gap-1 text-[#c8102e] text-xs font-bold group-hover:gap-2 transition-all">
                    Scan QR Code <i class="fas fa-arrow-right text-[10px]"></i>
                </span>
            </button>
        </div>

        {{-- Bottom CTA strip --}}
        <div class="reveal bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl p-8 md:p-10 text-white text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image:url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23fff' fill-opacity='1' fill-rule='evenodd'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3C/g%3E%3C/svg%3E\")"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl md:text-3xl  mb-2" style="font-weight:900">Not Sure Where to Start?</h3>
                <p class="text-white/85 mb-6 max-w-md mx-auto leading-relaxed">Our team will personally guide you through the entire sponsorship process. It takes less than 5 minutes to begin.</p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ $tgUrl }}" target="_blank"
                       class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-orange-600 font-bold rounded-2xl hover:bg-orange-50 transition shadow-lg text-sm">
                        <i class="fab fa-telegram"></i> Telegram
                    </a>
                    <a href="{{ $waUrl }}" target="_blank"
                       class="inline-flex items-center gap-2 px-7 py-3.5 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-bold rounded-2xl transition text-sm">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="{{ $xUrl }}" target="_blank"
                       class="inline-flex items-center gap-2 px-7 py-3.5 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-bold rounded-2xl transition text-sm">
                        <i class="fab fa-x-twitter"></i> X (Twitter)
                    </a>
                    <button onclick="openKhqr()"
                            class="inline-flex items-center gap-2 px-7 py-3.5 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-bold rounded-2xl transition text-sm">
                        <i class="fas fa-qrcode"></i> KHQR
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     FEATURED ARTICLES (from controller)
══════════════════════════════════════════════════════ --}}
@if($featuredArticles->isNotEmpty())
<section class="py-14 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8 reveal">
            <div>
                <h2 class="text-2xl md:text-3xl  text-gray-900 mb-1" style="font-weight:900">Impact Stories</h2>
                <div class="h-1 w-12 rounded-full bg-orange-500"></div>
            </div>
            <a href="{{ route('home') }}#news"
               class="text-sm font-bold text-orange-500 hover:text-orange-600 flex items-center gap-1 hover:gap-2 transition-all">
                All Stories <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            @foreach($featuredArticles as $i => $article)
            <a href="{{ route('articles.show', $article->encrypted_slug) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all hover:-translate-y-1 reveal"
               style="transition-delay:{{ $i*0.1 }}s">
                @if($article->image)
                    <div class="overflow-hidden">
                        <img src="{{ $article->image->url }}" alt="{{ $article->title }}"
                             class="w-full h-44 object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                @else
                    <div class="w-full h-44 flex items-center justify-center"
                         style="background:{{ $article->category->color ?? '#f97316' }}12">
                        <i class="{{ $article->category->icon ?? 'fas fa-star' }} text-5xl opacity-20"
                           style="color:{{ $article->category->color ?? '#f97316' }}"></i>
                    </div>
                @endif
                <div class="p-4">
                    <h3 class="text-sm font-bold text-gray-800 line-clamp-2 group-hover:text-orange-500 transition leading-snug">
                        {{ $article->title }}
                    </h3>
                    @if($article->excerpt)
                        <p class="text-xs text-gray-500 mt-1.5 line-clamp-2">{{ Str::limit(strip_tags($article->excerpt), 80) }}</p>
                    @endif
                    <div class="flex items-center gap-1 mt-3 text-orange-500 text-xs font-bold">
                        Read Story <i class="fas fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('layouts.footer')
@include('layouts.navigation')

{{-- ══════════════════════════════════════════════════════
     KHQR MODAL
══════════════════════════════════════════════════════ --}}
<div class="modal-overlay" id="khqr-modal" onclick="closeKhqr(event)">
    <div class="modal-box" onclick="event.stopPropagation()">

        {{-- Modal header --}}
        <div class="bg-gradient-to-r from-[#c8102e] to-[#a00d24] px-6 pt-6 pb-4 text-white relative">
            <button onclick="closeKhqr()"
                    class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition">
                <i class="fas fa-times text-sm"></i>
            </button>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-qrcode text-white text-xl"></i>
                </div>
                <div>
                    <h3 class=" text-lg leading-tight" style="font-weight:900">Scan to Donate</h3>
                    <p class="text-white/75 text-xs">KHQR · ABA Bank · Wing</p>
                </div>
            </div>
        </div>

        {{-- QR Area --}}
        <div class="p-6">
            <div class="khqr-frame mb-4">
                <div class="khqr-inner">
                    {{-- KHQR header bar --}}
                    <div class="flex items-center justify-between mb-3 px-1">
                        <img src="https://www.nbc.gov.kh/nbc/images/khqr-logo.png"
                             onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';"
                             class="h-7 object-contain" alt="KHQR">
                        <div style="display:none" class="items-center gap-1 bg-red-600 text-white text-xs font-black px-3 py-1 rounded-full">
                            <span>KH</span><i class="fas fa-qrcode"></i><span>QR</span>
                        </div>
                        <span class="text-[10px] text-gray-400 font-medium">Scan with any banking app</span>
                    </div>

                    {{-- QR Code image — replace src with your actual KHQR image --}}
                    <div class="flex items-center justify-center bg-white p-3 rounded-lg border border-gray-100 min-h-[200px]">
                        <img src="{{ $khqrImg }}"
                             onerror="this.style.display='none';document.getElementById('qr-placeholder').style.display='flex';"
                             class="max-w-[180px] w-full" alt="KHQR QR Code">
                        {{-- Fallback placeholder --}}
                        <div id="qr-placeholder" style="display:none"
                             class="flex-col items-center justify-center text-center p-6">
                            <div class="w-40 h-40 bg-gray-100 rounded-xl flex flex-col items-center justify-center mb-3">
                                <i class="fas fa-qrcode text-5xl text-gray-300 mb-2"></i>
                                <span class="text-xs text-gray-400 font-medium">Place your KHQR<br>image here</span>
                            </div>
                            <p class="text-xs text-gray-400">
                                Upload your QR in<br>
                                <code class="text-orange-500">Admin → Settings → Sponsor/KHQR</code>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Account info --}}
            <div class="bg-gray-50 rounded-xl p-4 mb-4 text-center">
                <p class="text-xs text-gray-500 mb-1">Account Name</p>
                <p class="text-gray-900 text-base" style="font-weight:900">{{ $accName }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $accBank }}</p>
            </div>

            {{-- Instructions --}}
            <div class="grid grid-cols-3 gap-2 mb-5">
                @foreach([['fas fa-mobile-alt','Open your banking app'],['fas fa-qrcode','Scan QR code'],['fas fa-heart','Your donation is sent']] as $s)
                <div class="text-center">
                    <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-1.5">
                        <i class="{{ $s[0] }} text-orange-500 text-xs"></i>
                    </div>
                    <p class="text-[10px] text-gray-500 leading-tight">{{ $s[1] }}</p>
                </div>
                @endforeach
            </div>

            {{-- After donating --}}
            <p class="text-center text-xs text-gray-500 mb-4">After donating, please let us know so we can connect you with your child.</p>

            <div class="grid grid-cols-4 gap-2">
                <a href="{{ $tgUrl }}" target="_blank"
                   class="flex flex-col items-center gap-1 py-3 rounded-xl bg-[#2ca5e0]/10 hover:bg-[#2ca5e0]/20 transition">
                    <i class="fab fa-telegram text-[#2ca5e0] text-xl"></i>
                    <span class="text-[10px] font-bold text-[#2ca5e0]">Telegram</span>
                </a>
                <a href="{{ $waUrl }}" target="_blank"
                   class="flex flex-col items-center gap-1 py-3 rounded-xl bg-[#25d366]/10 hover:bg-[#25d366]/20 transition">
                    <i class="fab fa-whatsapp text-[#25d366] text-xl"></i>
                    <span class="text-[10px] font-bold text-[#25d366]">WhatsApp</span>
                </a>
                <a href="{{ $igUrl }}" target="_blank"
                   class="flex flex-col items-center gap-1 py-3 rounded-xl bg-pink-50 hover:bg-pink-100 transition">
                    <i class="fab fa-instagram text-pink-500 text-xl"></i>
                    <span class="text-[10px] font-bold text-pink-500">Instagram</span>
                </a>
                <a href="{{ $xUrl }}" target="_blank"
                   class="flex flex-col items-center gap-1 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 transition">
                    <i class="fab fa-x-twitter text-gray-900 text-xl"></i>
                    <span class="text-[10px] font-bold text-gray-800">X</span>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     CONTACT MODAL (for tier buttons)
══════════════════════════════════════════════════════ --}}
<div class="modal-overlay" id="contact-modal" onclick="closeContact(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 pt-6 pb-4 text-white relative">
            <button onclick="closeContact()"
                    class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition">
                <i class="fas fa-times text-sm"></i>
            </button>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-heart text-white text-xl"></i>
                </div>
                <div>
                    <h3 class=" text-lg leading-tight" style="font-weight:900">Start Your Sponsorship</h3>
                    <p class="text-white/75 text-xs" id="contact-tier-label">Choose how to reach us</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <p class="text-sm text-gray-600 text-center mb-5 leading-relaxed">
                Choose your preferred way to connect. Our team will guide you through the full sponsorship process.
            </p>

            <div class="space-y-3">
                <a href="{{ $tgUrl }}" target="_blank"
                   class="flex items-center gap-4 p-4 rounded-2xl border-2 border-[#2ca5e0]/20 hover:border-[#2ca5e0] hover:bg-[#2ca5e0]/5 transition group">
                    <div class="w-12 h-12 rounded-xl bg-[#2ca5e0]/10 flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-telegram text-[#2ca5e0] text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-sm">Telegram</p>
                        <p class="text-xs text-gray-400 font-mono">{{ $tgUrl !== "#" ? $tgUrl : "Not set" }}</p>
                    </div>
                    <i class="fas fa-arrow-right text-gray-300 group-hover:text-[#2ca5e0] group-hover:translate-x-1 transition-all"></i>
                </a>

                <a href="{{ $waUrl }}" target="_blank"
                   class="flex items-center gap-4 p-4 rounded-2xl border-2 border-[#25d366]/20 hover:border-[#25d366] hover:bg-[#25d366]/5 transition group">
                    <div class="w-12 h-12 rounded-xl bg-[#25d366]/10 flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-whatsapp text-[#25d366] text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-sm">WhatsApp</p>
                        <p class="text-xs text-gray-400">+855 XX XXX XXXX</p>
                    </div>
                    <i class="fas fa-arrow-right text-gray-300 group-hover:text-[#25d366] group-hover:translate-x-1 transition-all"></i>
                </a>

                <a href="{{ $igUrl }}" target="_blank"
                   class="flex items-center gap-4 p-4 rounded-2xl border-2 border-pink-100 hover:border-pink-400 hover:bg-pink-50 transition group">
                    <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-instagram text-pink-500 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-sm">Instagram</p>
                        <p class="text-xs text-gray-400 font-mono">{{ $igUrl !== "#" ? $igUrl : "Not set" }}</p>
                    </div>
                    <i class="fas fa-arrow-right text-gray-300 group-hover:text-pink-500 group-hover:translate-x-1 transition-all"></i>
                </a>

                <a href="{{ $xUrl }}" target="_blank"
                   class="flex items-center gap-4 p-4 rounded-2xl border-2 border-gray-100 hover:border-gray-900 hover:bg-gray-50 transition group">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-x-twitter text-gray-900 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-sm">X (Twitter)</p>
                        <p class="text-xs text-gray-400 font-mono">{{ $xUrl !== "#" ? $xUrl : "Not set" }}</p>
                    </div>
                    <i class="fas fa-arrow-right text-gray-300 group-hover:text-gray-900 group-hover:translate-x-1 transition-all"></i>
                </a>

                <button onclick="closeContact();openKhqr();"
                        class="w-full flex items-center gap-4 p-4 rounded-2xl border-2 border-red-100 hover:border-red-400 hover:bg-red-50 transition group">
                    <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-qrcode text-[#c8102e] text-2xl"></i>
                    </div>
                    <div class="flex-1 text-left">
                        <p class="font-bold text-gray-900 text-sm">Donate via KHQR</p>
                        <p class="text-xs text-gray-400">Scan & pay with any banking app</p>
                    </div>
                    <i class="fas fa-arrow-right text-gray-300 group-hover:text-red-500 group-hover:translate-x-1 transition-all"></i>
                </button>
            </div>

            <p class="text-center text-xs text-gray-400 mt-5">
                <i class="fas fa-shield-alt text-green-400 mr-1"></i>
                100% of your sponsorship reaches the child directly
            </p>
        </div>
    </div>
</div>

<script>
// ── Modal controls ──────────────────────────────────────────────────────
function openKhqr() {
    document.getElementById('khqr-modal').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeKhqr(e) {
    if (!e || e.target === document.getElementById('khqr-modal')) {
        document.getElementById('khqr-modal').classList.remove('active');
        document.body.style.overflow = '';
    }
}
function openContact(tier) {
    if (tier) document.getElementById('contact-tier-label').textContent = tier;
    document.getElementById('contact-modal').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeContact(e) {
    if (!e || e.target === document.getElementById('contact-modal')) {
        document.getElementById('contact-modal').classList.remove('active');
        document.body.style.overflow = '';
    }
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeKhqr(); closeContact(); }
});

// ── Scroll reveal ───────────────────────────────────────────────────────
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(el => {
        if (el.isIntersecting) { el.target.classList.add('show'); revealObserver.unobserve(el.target); }
    });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// ── Mobile menu ─────────────────────────────────────────────────────────
const mobileMenu = document.getElementById('mobile-menu'), mobileOverlay = document.getElementById('mobile-menu-overlay');
const openMenu  = () => { mobileMenu?.classList.add('active'); mobileOverlay?.classList.add('active'); document.body.style.overflow='hidden'; };
const closeMenu = () => { mobileMenu?.classList.remove('active'); mobileOverlay?.classList.remove('active'); document.body.style.overflow=''; };
document.getElementById('mobile-menu-btn')?.addEventListener('click', openMenu);
document.getElementById('menu-nav-item')?.addEventListener('click', e => { e.preventDefault(); openMenu(); });
document.getElementById('close-menu')?.addEventListener('click', closeMenu);
mobileOverlay?.addEventListener('click', closeMenu);
document.querySelectorAll('.mobile-menu-link').forEach(l => l.addEventListener('click', closeMenu));

// ── Bottom nav active ───────────────────────────────────────────────────
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function() {
        if (this.id !== 'menu-nav-item') {
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            this.classList.add('active');
        }
    });
});

// ── Smooth scroll ────────────────────────────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', function(e) {
        e.preventDefault();
        const t = document.querySelector(this.getAttribute('href'));
        if (t) window.scrollTo({ top: t.offsetTop - 80, behavior: 'smooth' });
    });
});
</script>

</body>
</html>