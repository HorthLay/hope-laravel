{{-- resources/views/sponsor/contact.blade.php --}}
@extends('layouts.app')

@section('title', 'Create a Sponsor Account')

@section('content')

@php
    $headerSettings = (function() {
        $file = storage_path('app/settings.json');
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    })();
    $emailUrl     = !empty($headerSettings['contact_email'])  ? 'https://mail.google.com/mail/?view=cm&to=' . $headerSettings['contact_email'] : null;
    $whatsappUrl  = !empty($headerSettings['whatsapp_url'])   ? 'https://wa.me/' . $headerSettings['whatsapp_url']  : null;
    $telegramUrl  = !empty($headerSettings['telegram_url'])   ? 'https://t.me/' . $headerSettings['telegram_url']   : null;
    $facebookUrl  = $headerSettings['facebook_url']  ?? null ?: null;
    $instagramUrl = $headerSettings['instagram_url'] ?? null ?: null;
    $youtubeUrl   = $headerSettings['youtube_url']   ?? null ?: null;
    $linkedinUrl  = $headerSettings['linkedin_url']  ?? null ?: null;
@endphp

<style>
/* ══════════════════════════════════════════════
   ANIMATIONS & REVEAL
══════════════════════════════════════════════ */
@keyframes fadeUp     { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
@keyframes pulse-soft { 0%,100%{transform:scale(1)} 50%{transform:scale(1.04)} }
.reveal       {opacity:0;transform:translateY(28px); transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-left  {opacity:0;transform:translateX(-36px);transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-right {opacity:0;transform:translateX(36px); transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal.visible,.reveal-left.visible,.reveal-right.visible{opacity:1;transform:none}
.stagger-1{transition-delay:.05s}.stagger-2{transition-delay:.12s}.stagger-3{transition-delay:.19s}
.stagger-4{transition-delay:.26s}.stagger-5{transition-delay:.33s}

/* ══════════════════════════════════════════════
   HERO
══════════════════════════════════════════════ */
.page-hero{position:relative;overflow:hidden;background:#1a1a1a;min-height:320px}
.page-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;filter:brightness(.45) saturate(1.1);transition:transform 8s ease}
.page-hero:hover .page-hero-bg{transform:scale(1.04)}
.page-hero-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,.65) 0%,rgba(0,0,0,.2) 60%,transparent 100%)}
.page-hero-content{position:relative;z-index:2;padding:70px 40px 60px;max-width:1280px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:18px}
.breadcrumb a:hover{color:#fff}
.breadcrumb span{color:rgba(255,255,255,.9)}
.pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:999px;font-size:11px;font-weight:800;letter-spacing:.06em;text-transform:uppercase}
.wave-divider{line-height:0;overflow:hidden}.wave-divider svg{display:block}
@media(max-width:640px){.page-hero-content{padding:50px 20px 44px}}

/* ══════════════════════════════════════════════
   LAYOUT
══════════════════════════════════════════════ */
.contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}
@media(max-width:767px){
    .contact-grid{grid-template-columns:1fr}
    .desktop-contact-col{display:none!important}
    .mobile-contact-trigger{display:flex!important}
    #why-mobile{display:block!important}
    #why-desktop{display:none!important}
}
@media(min-width:768px){
    .mobile-contact-trigger{display:none!important}
    #why-mobile{display:none!important}
    #why-desktop{display:block!important}
}

/* ══════════════════════════════════════════════
   CARDS
══════════════════════════════════════════════ */
.info-card{background:#fff;border-radius:20px;border:1px solid #f1f5f9;box-shadow:0 4px 20px rgba(0,0,0,.06);padding:28px}
.card-title{font-size:18px;font-weight:900;color:#1f2937;margin:0 0 6px}
.card-sub{font-size:13px;color:#6b7280;margin:0 0 22px;line-height:1.65}
.section-label{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;color:#9ca3af;margin:0 0 14px}

/* ══════════════════════════════════════════════
   HOW-TO STEPS
══════════════════════════════════════════════ */
.step{display:flex;align-items:flex-start;gap:13px}
.step+.step{margin-top:18px}
.step-icon{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;font-size:14px}
.step h3{font-size:13px;font-weight:800;color:#1f2937;margin:0 0 3px}
.step p{font-size:11px;color:#6b7280;margin:0;line-height:1.5}

/* ══════════════════════════════════════════════
   CONTACT BUTTONS
══════════════════════════════════════════════ */
.contact-list{display:flex;flex-direction:column;gap:10px}
.contact-btn{
    display:flex;align-items:center;gap:13px;
    padding:14px 16px;border-radius:14px;text-decoration:none;
    background:#f9fafb;border:1.5px solid #f3f4f6;
    transition:all .18s;min-height:64px;
}
.contact-btn:hover,.contact-btn:active{transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,.10)}
.btn-icon{width:44px;height:44px;border-radius:12px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:21px}
.btn-body{flex:1;min-width:0}
.btn-title{font-size:13px;font-weight:800;color:#1f2937}
.btn-sub{font-size:11px;color:#9ca3af;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.btn-arrow{color:#d1d5db;font-size:11px;flex-shrink:0}
.contact-btn.email:hover    {background:#fff7ed;border-color:#fed7aa}
.contact-btn.whatsapp:hover {background:#f0fdf4;border-color:#bbf7d0}
.contact-btn.telegram:hover {background:#f0f9ff;border-color:#bae6fd}
.contact-btn.facebook:hover {background:#eff6ff;border-color:#bfdbfe}
.contact-btn.instagram:hover{background:#fdf2f8;border-color:#f5d0fe}
.contact-btn.youtube:hover  {background:#fef2f2;border-color:#fecaca}
.contact-btn.linkedin:hover {background:#eff6ff;border-color:#bfdbfe}

/* ══════════════════════════════════════════════
   WHY CARD
══════════════════════════════════════════════ */
.why-card{background:linear-gradient(135deg,#f97316,#ea580c);border-radius:20px;padding:24px;color:#fff;box-shadow:0 8px 28px rgba(249,115,22,.30)}
.why-card h3{font-size:17px;font-weight:900;margin:0 0 16px}
.why-item{display:flex;align-items:flex-start;gap:9px;font-size:13px}
.why-item+.why-item{margin-top:10px}
.why-item i{margin-top:2px;flex-shrink:0}

/* ══════════════════════════════════════════════
   MOBILE TRIGGER BUTTON
══════════════════════════════════════════════ */
.mobile-contact-trigger{
    display:none;align-items:center;justify-content:center;gap:10px;
    width:100%;padding:18px;
    background:linear-gradient(135deg,#f97316,#ea580c);
    color:#fff;border:none;border-radius:16px;
    font-family:inherit;font-size:15px;font-weight:900;
    cursor:pointer;box-shadow:0 8px 24px rgba(249,115,22,.38);
    transition:transform .15s,box-shadow .15s;
}
.mobile-contact-trigger:active{transform:scale(.97)}
.mobile-contact-trigger i{font-size:18px}

/* ══════════════════════════════════════════════
   BOTTOM SHEET MODAL
══════════════════════════════════════════════ */
.modal-overlay{
    display:none;position:fixed;inset:0;z-index:1200;
    background:rgba(0,0,0,.45);backdrop-filter:blur(4px);
    align-items:flex-end;justify-content:center;
}
.modal-overlay.open{display:flex}
.modal-sheet{
    background:#fff;width:100%;max-width:520px;
    border-radius:24px 24px 0 0;
    max-height:90dvh;overflow-y:auto;
    transform:translateY(110%);
    transition:transform .35s cubic-bezier(.4,0,.2,1);
    padding-bottom:env(safe-area-inset-bottom,16px);
}
.modal-overlay.open .modal-sheet{transform:translateY(0)}
.modal-handle{width:40px;height:4px;background:#e5e7eb;border-radius:2px;margin:14px auto 0}
.modal-header{
    display:flex;align-items:center;justify-content:space-between;
    padding:14px 20px 12px;border-bottom:1px solid #f3f4f6;
    position:sticky;top:0;background:#fff;z-index:1
}
.modal-title{font-size:16px;font-weight:900;color:#1f2937}
.modal-close{
    width:32px;height:32px;border-radius:50%;
    border:none;background:#f3f4f6;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    color:#6b7280;font-size:13px;transition:background .2s
}
.modal-close:hover{background:#e5e7eb}
.modal-body{padding:18px 20px 28px}
</style>

{{-- HERO --}}
<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Sponsor</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span>Create Account</span>
        </nav>
        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-user-plus text-xs"></i> Become a Sponsor
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">Create a Sponsor Account</h1>
        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both">Contact us directly to create your sponsor account and start changing a child's life.</p>
    </div>
</section>

<div class="wave-divider" style="background:#f9fafb"><svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#ffffff"/></svg></div>

{{-- MAIN CONTENT --}}
<section class="bg-white py-14 md:py-20">
    <div class="max-w-5xl mx-auto px-4">

        {{-- Mobile trigger --}}
        <div class="mb-6">
            <button class="mobile-contact-trigger" onclick="openContactModal()">
                <i class="fas fa-paper-plane"></i>
                <span>Contact Us</span>
                <i class="fas fa-chevron-up" style="font-size:12px;margin-left:auto;opacity:.7;"></i>
            </button>
        </div>

        <div class="contact-grid">

            {{-- LEFT: How to + Why (mobile) --}}
            <div style="display:flex;flex-direction:column;gap:20px;">

                {{-- How to card --}}
                <div class="info-card reveal">
                    <h2 class="card-title">How to create an account?</h2>
                    <p class="card-sub">Contact us via one of the methods below. Our team will guide you through the process and create your account.</p>

                    @if($emailUrl)
                    <div class="step">
                        <div class="step-icon" style="background:#fff7ed"><i class="fas fa-envelope" style="color:#f97316"></i></div>
                        <div>
                            <h3>Send us an email</h3>
                            <p>Include your name, email and phone number.</p>
                        </div>
                    </div>
                    @endif

                    @if($whatsappUrl)
                    <div class="step">
                        <div class="step-icon" style="background:#f0fdf4"><i class="fab fa-whatsapp" style="color:#22c55e"></i></div>
                        <div>
                            <h3>Contact us on WhatsApp</h3>
                            <p>Immediate assistance via WhatsApp.</p>
                        </div>
                    </div>
                    @endif

                    @if($telegramUrl)
                    <div class="step">
                        <div class="step-icon" style="background:#f0f9ff"><i class="fab fa-telegram" style="color:#0ea5e9"></i></div>
                        <div>
                            <h3>Message on Telegram</h3>
                            <p>Create your account via Telegram.</p>
                        </div>
                    </div>
                    @endif

                    @if($facebookUrl)
                    <div class="step">
                        <div class="step-icon" style="background:#eff6ff"><i class="fab fa-facebook" style="color:#2563eb"></i></div>
                        <div>
                            <h3>Contact us on Facebook</h3>
                            <p>Via our official Facebook page.</p>
                        </div>
                    </div>
                    @endif

                    @if(!$emailUrl && !$whatsappUrl && !$telegramUrl && !$facebookUrl)
                    <div class="step">
                        <div class="step-icon" style="background:#f3f4f6"><i class="fas fa-headset" style="color:#9ca3af"></i></div>
                        <div>
                            <h3>Reach out to our team</h3>
                            <p>We will get back to you within 24 hours.</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Why card — mobile only --}}
                <div class="why-card reveal stagger-2" id="why-mobile">
                    <h3>Why Become a Sponsor?</h3>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Directly change a child's life</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Receive regular updates & photos</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>84% of funds go directly to programs</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Track your child's education journey</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>For just $1 a day — make a lasting impact</span></div>
                </div>
            </div>

            {{-- RIGHT: Contact list + Why — desktop only --}}
            <div class="desktop-contact-col" style="display:flex;flex-direction:column;gap:20px;">

                <div class="info-card reveal stagger-1">
                    <p class="section-label">Contact Us Directly</p>
                    <div class="contact-list">

                        @if($emailUrl)
                        <a href="{{ $emailUrl }}" target="_blank" class="contact-btn email">
                            <div class="btn-icon" style="background:#fff7ed"><i class="fas fa-envelope" style="color:#f97316"></i></div>
                            <div class="btn-body">
                                <div class="btn-title">Email</div>
                                <div class="btn-sub">{{ $headerSettings['contact_email'] ?? 'Send us a message' }}</div>
                            </div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif

                        @if($whatsappUrl)
                        <a href="{{ $whatsappUrl }}" target="_blank" class="contact-btn whatsapp">
                            <div class="btn-icon" style="background:#f0fdf4"><i class="fab fa-whatsapp" style="color:#22c55e"></i></div>
                            <div class="btn-body">
                                <div class="btn-title">WhatsApp</div>
                                <div class="btn-sub">Instant chat</div>
                            </div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif

                        @if($telegramUrl)
                        <a href="{{ $telegramUrl }}" target="_blank" class="contact-btn telegram">
                            <div class="btn-icon" style="background:#f0f9ff"><i class="fab fa-telegram" style="color:#0ea5e9"></i></div>
                            <div class="btn-body">
                                <div class="btn-title">Telegram</div>
                                <div class="btn-sub">{{ $headerSettings['telegram_url'] ?? '' }}</div>
                            </div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif

                        @if($facebookUrl)
                        <a href="{{ $facebookUrl }}" target="_blank" class="contact-btn facebook">
                            <div class="btn-icon" style="background:#eff6ff"><i class="fab fa-facebook" style="color:#2563eb"></i></div>
                            <div class="btn-body">
                                <div class="btn-title">Facebook</div>
                                <div class="btn-sub">Official page</div>
                            </div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif

                        @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" class="contact-btn instagram">
                            <div class="btn-icon" style="background:#fdf2f8"><i class="fab fa-instagram" style="color:#ec4899"></i></div>
                            <div class="btn-body">
                                <div class="btn-title">Instagram</div>
                                <div class="btn-sub">{{ $headerSettings['instagram_url'] ?? '' }}</div>
                            </div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif

                        @if($youtubeUrl)
                        <a href="{{ $youtubeUrl }}" target="_blank" class="contact-btn youtube">
                            <div class="btn-icon" style="background:#fef2f2"><i class="fab fa-youtube" style="color:#dc2626"></i></div>
                            <div class="btn-body">
                                <div class="btn-title">YouTube</div>
                                <div class="btn-sub">Watch our stories</div>
                            </div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif

                        @if($linkedinUrl)
                        <a href="{{ $linkedinUrl }}" target="_blank" class="contact-btn linkedin">
                            <div class="btn-icon" style="background:#eff6ff"><i class="fab fa-linkedin" style="color:#1d4ed8"></i></div>
                            <div class="btn-body">
                                <div class="btn-title">LinkedIn</div>
                                <div class="btn-sub">{{ $headerSettings['linkedin_url'] ?? '' }}</div>
                            </div>
                            <i class="fas fa-external-link-alt btn-arrow"></i>
                        </a>
                        @endif

                        @if(!$emailUrl && !$whatsappUrl && !$telegramUrl && !$facebookUrl && !$instagramUrl && !$youtubeUrl && !$linkedinUrl)
                        <div style="padding:20px;text-align:center;color:#9ca3af;font-size:12px;background:#f9fafb;border-radius:12px;">
                            <i class="fas fa-info-circle" style="margin-right:6px"></i>No contact links configured yet.
                        </div>
                        @endif

                    </div>
                </div>

                {{-- Why card — desktop only --}}
                <div class="why-card reveal stagger-2" id="why-desktop">
                    <h3>Why Become a Sponsor?</h3>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Directly change a child's life</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Receive regular updates & photos</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>84% of funds go directly to programs</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>Track your child's education journey</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i><span>For just $1 a day — make a lasting impact</span></div>
                </div>
            </div>

        </div>{{-- end contact-grid --}}

        {{-- Already have an account link --}}
        <div class="mt-10 text-center reveal">
            <p class="text-sm text-gray-400">
                Already have an account?
                <a href="{{ route('sponsor.login') }}" class="text-orange-500 font-bold hover:underline ml-1">
                    <i class="fas fa-sign-in-alt mr-1"></i>Log in here
                </a>
            </p>
        </div>

    </div>
</section>

{{-- Bottom CTA Banner --}}
<section class="bg-white pb-20">
    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-gradient-to-r from-orange-500 via-orange-500 to-amber-500 rounded-3xl p-10 md:p-14 relative overflow-hidden reveal">
            <div class="absolute inset-0 opacity-10" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="text-white text-center lg:text-left">
                    <h2 class="text-3xl md:text-4xl font-black mb-3">Ready to Change a Life?</h2>
                    <p class="text-white/85 text-lg max-w-lg">Contact us today and we'll set up your sponsor account and match you with a child.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-orange-600 font-black rounded-xl hover:bg-orange-50 transition shadow-lg justify-center">
                        <i class="fas fa-child"></i> Browse Children
                    </a>
                    <a href="{{ route('sponsor.login') }}" class="inline-flex items-center gap-3 px-8 py-4 border-2 border-white/50 text-white font-black rounded-xl hover:bg-white/10 transition justify-center">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     MOBILE BOTTOM SHEET MODAL
══════════════════════════════════════════ --}}
<div class="modal-overlay" id="contact-modal" onclick="handleOverlayClick(event)">
    <div class="modal-sheet" id="modal-sheet">
        <div class="modal-handle"></div>
        <div class="modal-header">
            <span class="modal-title">Contact Us</span>
            <button class="modal-close" onclick="closeContactModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="contact-list">

                @if($emailUrl)
                <a href="{{ $emailUrl }}" target="_blank" class="contact-btn email">
                    <div class="btn-icon" style="background:#fff7ed"><i class="fas fa-envelope" style="color:#f97316"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">Email</div>
                        <div class="btn-sub">{{ $headerSettings['contact_email'] ?? 'Send us a message' }}</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($whatsappUrl)
                <a href="{{ $whatsappUrl }}" target="_blank" class="contact-btn whatsapp">
                    <div class="btn-icon" style="background:#f0fdf4"><i class="fab fa-whatsapp" style="color:#22c55e"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">WhatsApp</div>
                        <div class="btn-sub">Instant chat</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($telegramUrl)
                <a href="{{ $telegramUrl }}" target="_blank" class="contact-btn telegram">
                    <div class="btn-icon" style="background:#f0f9ff"><i class="fab fa-telegram" style="color:#0ea5e9"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">Telegram</div>
                        <div class="btn-sub">@{{ $headerSettings['telegram_url'] ?? '' }}</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($facebookUrl)
                <a href="{{ $facebookUrl }}" target="_blank" class="contact-btn facebook">
                    <div class="btn-icon" style="background:#eff6ff"><i class="fab fa-facebook" style="color:#2563eb"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">Facebook</div>
                        <div class="btn-sub">Official page</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($instagramUrl)
                <a href="{{ $instagramUrl }}" target="_blank" class="contact-btn instagram">
                    <div class="btn-icon" style="background:#fdf2f8"><i class="fab fa-instagram" style="color:#ec4899"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">Instagram</div>
                        <div class="btn-sub">{{ $headerSettings['instagram_url'] ?? '' }}</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($youtubeUrl)
                <a href="{{ $youtubeUrl }}" target="_blank" class="contact-btn youtube">
                    <div class="btn-icon" style="background:#fef2f2"><i class="fab fa-youtube" style="color:#dc2626"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">YouTube</div>
                        <div class="btn-sub">Watch our stories</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if($linkedinUrl)
                <a href="{{ $linkedinUrl }}" target="_blank" class="contact-btn linkedin">
                    <div class="btn-icon" style="background:#eff6ff"><i class="fab fa-linkedin" style="color:#1d4ed8"></i></div>
                    <div class="btn-body">
                        <div class="btn-title">LinkedIn</div>
                        <div class="btn-sub">{{ $headerSettings['linkedin_url'] ?? '' }}</div>
                    </div>
                    <i class="fas fa-external-link-alt btn-arrow"></i>
                </a>
                @endif

                @if(!$emailUrl && !$whatsappUrl && !$telegramUrl && !$facebookUrl && !$instagramUrl && !$youtubeUrl && !$linkedinUrl)
                <div style="padding:20px;text-align:center;color:#9ca3af;font-size:12px;background:#f9fafb;border-radius:12px;">
                    <i class="fas fa-info-circle" style="margin-right:6px"></i>No contact links configured yet.
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

<script>
// ── Scroll reveal ─────────────────────────────────────────
(function(){
    const o=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('visible');o.unobserve(x.target)}})},{threshold:.08,rootMargin:'0px 0px -50px 0px'});
    document.querySelectorAll('.reveal,.reveal-left,.reveal-right').forEach(el=>o.observe(el));
})();

// ── Bottom sheet modal ────────────────────────────────────
function openContactModal() {
    document.getElementById('contact-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeContactModal() {
    document.getElementById('contact-modal').classList.remove('open');
    document.body.style.overflow = '';
}
function handleOverlayClick(e) {
    if (e.target === document.getElementById('contact-modal')) closeContactModal();
}

// Close on ESC
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeContactModal(); });

// Swipe down to close
let touchStartY = 0;
document.getElementById('modal-sheet').addEventListener('touchstart', e => {
    touchStartY = e.touches[0].clientY;
}, { passive: true });
document.getElementById('modal-sheet').addEventListener('touchmove', e => {
    if (e.touches[0].clientY - touchStartY > 80) closeContactModal();
}, { passive: true });
</script>

@endsection