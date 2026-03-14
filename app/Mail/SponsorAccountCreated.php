<?php 

use Carbon\Traits\Serialization;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class SponsorAccountCreated extends Mailable{
   use Queueable, SerializesModels;
 
    public function __construct(
        public string $sponsor,
        public string $email,
        public string $username,
        public string $password,
        public string $loginUrl,
        public string $lang = 'fr',   // fr | en | km
    ) {}
 
    public function envelope(): Envelope
    {
        $settings = $this->settings();
        $sn = $settings['site_name'] ?? 'Des Ailes pour Grandir';
 
        $subject = match($this->lang) {
            'en' => "🎉 Welcome – Your account at {$sn} has been created",
            'km' => "🎉 សូមស្វាគមន៍ – គណនីរបស់អ្នកនៅ {$sn} ត្រូវបានបង្កើត",
            default => "🎉 Bienvenue – Votre compte {$sn} a été créé",
        };
 
        return new Envelope(subject: $subject);
    }
 
    public function content(): Content
    {
        $settings = $this->settings();
        return new Content(
            view: 'emails.sponsor.account_created',
            with: [
                'siteName' => $settings['site_name'] ?? 'Des Ailes pour Grandir',
                'siteLogo' => $settings['logo']      ?? null,
                'sponsor'  => $this->sponsor,
                'email'    => $this->email,
                'username' => $this->username,
                'password' => $this->password,
                'loginUrl' => $this->loginUrl,
                'lang'     => $this->lang,
            ],
        );
    }
 
    private function settings(): array
    {
        $file = storage_path('app/settings.json');
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    }
}

