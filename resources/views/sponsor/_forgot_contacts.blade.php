{{-- resources/views/sponsor/_forgot_contacts.blade.php --}}
{{-- Shared partial: contact rows for the forgot password modal --}}

@if($fp_email)
<a href="https://mail.google.com/mail/?view=cm&to={{ $fp_email }}&subject={{ urlencode('Réinitialisation mot de passe / Password Reset') }}"
   target="_blank" class="contact-row cr-email">
    <div class="cr-icon" style="background:#fff7ed"><i class="fas fa-envelope" style="color:#f97316"></i></div>
    <div class="cr-body">
        <div class="cr-title" data-fr="Envoyer un email" data-en="Send an email" data-km="ផ្ញើអ៊ីមែល">Envoyer un email</div>
        <div class="cr-sub">{{ $fp_email }}</div>
    </div>
    <i class="fas fa-external-link-alt cr-arrow"></i>
</a>
@endif

@if($fp_whatsapp)
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $fp_whatsapp) }}?text={{ urlencode("Bonjour, j'ai oublié mon mot de passe de l'espace parrain.") }}"
   target="_blank" class="contact-row cr-whatsapp">
    <div class="cr-icon" style="background:#f0fdf4"><i class="fab fa-whatsapp" style="color:#22c55e;font-size:22px"></i></div>
    <div class="cr-body">
        <div class="cr-title">WhatsApp</div>
        <div class="cr-sub" data-fr="Message instantané" data-en="Instant message" data-km="សារភ្លាមៗ">Message instantané</div>
    </div>
    <i class="fas fa-external-link-alt cr-arrow"></i>
</a>
@endif

@if($fp_telegram)
<a href="https://t.me/{{ ltrim($fp_telegram, '@') }}" target="_blank" class="contact-row cr-telegram">
    <div class="cr-icon" style="background:#f0f9ff"><i class="fab fa-telegram" style="color:#0ea5e9;font-size:22px"></i></div>
    <div class="cr-body">
        <div class="cr-title">Telegram</div>
        <div class="cr-sub">{{ $fp_telegram }}</div>
    </div>
    <i class="fas fa-external-link-alt cr-arrow"></i>
</a>
@endif

@if($fp_facebook)
<a href="{{ $fp_facebook }}" target="_blank" class="contact-row cr-facebook">
    <div class="cr-icon" style="background:#eff6ff"><i class="fab fa-facebook-messenger" style="color:#2563eb;font-size:22px"></i></div>
    <div class="cr-body">
        <div class="cr-title">Facebook Messenger</div>
        <div class="cr-sub" data-fr="Écrivez-nous sur Facebook" data-en="Message us on Facebook" data-km="ផ្ញើសារមកយើងតាម Facebook">Écrivez-nous sur Facebook</div>
    </div>
    <i class="fas fa-external-link-alt cr-arrow"></i>
</a>
@endif

@if($fp_instagram)
<a href="{{ $fp_instagram }}" target="_blank" class="contact-row cr-instagram">
    <div class="cr-icon" style="background:#fdf2f8"><i class="fab fa-instagram" style="color:#ec4899;font-size:22px"></i></div>
    <div class="cr-body">
        <div class="cr-title">Instagram</div>
        <div class="cr-sub" data-fr="Envoyez un DM" data-en="Send a DM" data-km="ផ្ញើ DM">Envoyez un DM</div>
    </div>
    <i class="fas fa-external-link-alt cr-arrow"></i>
</a>
@endif

@if($fp_phone)
<a href="tel:{{ preg_replace('/\s+/', '', $fp_phone) }}" class="contact-row cr-phone">
    <div class="cr-icon" style="background:#f0fdf4"><i class="fas fa-phone" style="color:#16a34a"></i></div>
    <div class="cr-body">
        <div class="cr-title" data-fr="Appeler" data-en="Call us" data-km="ហៅទូរស័ព្ទ">Appeler</div>
        <div class="cr-sub">{{ $fp_phone }}</div>
    </div>
    <i class="fas fa-phone-alt cr-arrow" style="color:#16a34a"></i>
</a>
@endif

@if(!$fp_email && !$fp_whatsapp && !$fp_telegram && !$fp_facebook && !$fp_instagram && !$fp_phone)
<div class="text-center py-6 text-gray-400 text-sm">
    <i class="fas fa-info-circle block text-2xl text-orange-200 mb-2"></i>
    <span data-fr="Aucun contact configuré dans les paramètres" data-en="No contacts configured in settings yet" data-km="គ្មានទំនាក់ទំនងដែលបានកំណត់">
        Aucun contact configuré dans les paramètres
    </span>
</div>
@endif