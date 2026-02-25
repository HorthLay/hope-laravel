{{-- resources/views/sponsor/partials/contact-links.blade.php --}}
{{-- Reusable contact links list — requires $settings to be available in scope --}}
@php
    $emailUrl     = !empty($settings['contact_email'])  ? 'https://mail.google.com/mail/?view=cm&to=' . $settings['contact_email'] : null;
    $whatsappUrl  = !empty($settings['whatsapp_url'])   ? 'https://wa.me/' . $settings['whatsapp_url']  : null;
    $telegramUrl  = !empty($settings['telegram_url'])   ? 'https://t.me/' . $settings['telegram_url']   : null;
    $facebookUrl  = $settings['facebook_url']  ?? null ?: null;
    $instagramUrl = $settings['instagram_url'] ?? null ?: null;
    $youtubeUrl   = $settings['youtube_url']   ?? null ?: null;
    $linkedinUrl  = $settings['linkedin_url']  ?? null ?: null;
@endphp

@if($emailUrl)
<a href="{{ $emailUrl }}" target="_blank" class="contact-btn email">
    <div class="btn-icon" style="background:#fff7ed;">
        <i class="fas fa-envelope" style="color:#f97316;"></i>
    </div>
    <div class="btn-body">
        <div class="btn-title" data-fr="E-mail" data-en="Email" data-km="អ៊ីមែល">E-mail</div>
        <div class="btn-sub">{{ $settings['contact_email'] }}</div>
    </div>
    <i class="fas fa-external-link-alt btn-arrow"></i>
</a>
@endif

@if($whatsappUrl)
<a href="{{ $whatsappUrl }}" target="_blank" class="contact-btn whatsapp">
    <div class="btn-icon" style="background:#f0fdf4;">
        <i class="fab fa-whatsapp" style="color:#22c55e;font-size:21px;"></i>
    </div>
    <div class="btn-body">
        <div class="btn-title">WhatsApp</div>
        <div class="btn-sub" data-fr="Chat instantané" data-en="Instant chat" data-km="ជជែកភ្លាមៗ">Chat instantané</div>
    </div>
    <i class="fas fa-external-link-alt btn-arrow"></i>
</a>
@endif

@if($telegramUrl)
<a href="{{ $telegramUrl }}" target="_blank" class="contact-btn telegram">
    <div class="btn-icon" style="background:#f0f9ff;">
        <i class="fab fa-telegram" style="color:#0ea5e9;font-size:21px;"></i>
    </div>
    <div class="btn-body">
        <div class="btn-title">Telegram</div>
        <div class="btn-sub">&#64;{{ $settings['telegram_url'] }}</div>
    </div>
    <i class="fas fa-external-link-alt btn-arrow"></i>
</a>
@endif

@if($facebookUrl)
<a href="{{ $facebookUrl }}" target="_blank" class="contact-btn facebook">
    <div class="btn-icon" style="background:#eff6ff;">
        <i class="fab fa-facebook" style="color:#2563eb;font-size:21px;"></i>
    </div>
    <div class="btn-body">
        <div class="btn-title">Facebook</div>
        <div class="btn-sub" data-fr="Page officielle" data-en="Official page" data-km="ទំព័រផ្លូវការ">Page officielle</div>
    </div>
    <i class="fas fa-external-link-alt btn-arrow"></i>
</a>
@endif

@if($instagramUrl)
<a href="{{ $instagramUrl }}" target="_blank" class="contact-btn instagram">
    <div class="btn-icon" style="background:#fdf2f8;">
        <i class="fab fa-instagram" style="color:#ec4899;font-size:21px;"></i>
    </div>
    <div class="btn-body">
        <div class="btn-title">Instagram</div>
        <div class="btn-sub">{{ $settings['instagram_url'] }}</div>
    </div>
    <i class="fas fa-external-link-alt btn-arrow"></i>
</a>
@endif

@if($youtubeUrl)
<a href="{{ $youtubeUrl }}" target="_blank" class="contact-btn youtube">
    <div class="btn-icon" style="background:#fef2f2;">
        <i class="fab fa-youtube" style="color:#dc2626;font-size:21px;"></i>
    </div>
    <div class="btn-body">
        <div class="btn-title">YouTube</div>
        <div class="btn-sub">{{ $settings['youtube_url'] }}</div>
    </div>
    <i class="fas fa-external-link-alt btn-arrow"></i>
</a>
@endif

@if($linkedinUrl)
<a href="{{ $linkedinUrl }}" target="_blank" class="contact-btn linkedin">
    <div class="btn-icon" style="background:#eff6ff;">
        <i class="fab fa-linkedin" style="color:#1d4ed8;font-size:21px;"></i>
    </div>
    <div class="btn-body">
        <div class="btn-title">LinkedIn</div>
        <div class="btn-sub">{{ $settings['linkedin_url'] }}</div>
    </div>
    <i class="fas fa-external-link-alt btn-arrow"></i>
</a>
@endif

@if(!$emailUrl && !$whatsappUrl && !$telegramUrl && !$facebookUrl && !$instagramUrl && !$youtubeUrl && !$linkedinUrl)
<div style="padding:20px;text-align:center;color:#9ca3af;font-size:12px;background:#f9fafb;border-radius:12px;">
    <i class="fas fa-info-circle" style="margin-right:6px;"></i>
    No contact links configured yet.
</div>
@endif