<?php

namespace App\Mail;
 
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
 
class SponsorPasswordReset extends Mailable
{
    use Queueable, SerializesModels;
 
    public function __construct(
        public string $sponsor,
        public string $email,
        public string $username,
        public string $newPassword,
        public string $loginUrl,
        public string $lang = 'fr',   // ← trilingual support
    ) {}
 
    public function envelope(): Envelope
    {
        $settings = $this->loadSettings();
        $subjects = [
            'fr' => '🔐 Réinitialisation de votre mot de passe – ',
            'en' => '🔐 Your password has been reset – ',
            'km' => '🔐 ពាក្យសម្ងាត់របស់អ្នកត្រូវបានកំណត់ឡើងវិញ – ',
        ];
        $prefix = $subjects[$this->lang] ?? $subjects['fr'];
        return new Envelope(
            subject: $prefix . ($settings['site_name'] ?? 'Des Ailes pour Grandir'),
        );
    }
 
    public function content(): Content
    {
        $settings = $this->loadSettings();
        $logoPath = !empty($settings['logo']) ? asset($settings['logo']) : null;
        return new Content(
            view: 'emails.sponsor.password_reset',
            with: [
                'siteName'     => $settings['site_name']     ?? 'Des Ailes pour Grandir',
                'siteLogo'     => $logoPath,
                'contactEmail' => $settings['contact_email'] ?? null,
                'sponsor'      => $this->sponsor,
                'email'        => $this->email,
                'username'     => $this->username,
                'newPassword'  => $this->newPassword,
                'loginUrl'     => $this->loginUrl,
                'lang'         => $this->lang,
            ],
        );
    }
 
    private function loadSettings(): array
    {
        $file = storage_path('app/settings.json');
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    }
}