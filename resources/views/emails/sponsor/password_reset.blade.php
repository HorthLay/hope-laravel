{{--
  resources/views/emails/sponsor/password_reset.blade.php
  Variables: $sponsor, $email, $username, $newPassword, $loginUrl,
             $siteName, $siteLogo, $contactEmail, $lang (fr|en|km)
--}}
@php
$lang = $lang ?? 'fr';
$sn   = $siteName ?? 'Des Ailes pour Grandir';

$t = [
    'fr' => [
        'html_lang'    => 'fr',
        'title'        => 'Réinitialisation – ' . $sn,
        'badge'        => 'RÉINITIALISATION',
        'headline'     => 'Nouveau mot de passe',
        'headline_sub' => 'pour votre compte',
        'subtitle'     => 'Un nouveau mot de passe a été généré suite à votre demande',
        'greeting'     => 'Bonjour',
        'intro'        => "Nous avons reçu une demande de réinitialisation pour votre compte parrain sur <strong style=\"color:#f97316;\">%s</strong>. Voici vos nouveaux identifiants :",
        'box_title'    => '🔑 VOS NOUVEAUX IDENTIFIANTS',
        'lbl_email'    => 'Adresse Email',
        'lbl_user'     => "Nom d'Utilisateur",
        'lbl_pass'     => 'Nouveau Mot de Passe',
        'security'     => '🛡️ <strong>Sécurité :</strong> Connectez-vous immédiatement et changez ce mot de passe. Ne partagez jamais vos identifiants.',
        'cta'          => 'Se Connecter →',
        'cta_link'     => 'Lien direct :',
        'not_you_h'    => "⚠️ Ce n'était pas vous ?",
        'not_you_b'    => "Si vous n'avez pas demandé cette réinitialisation, contactez-nous immédiatement à %s.",
        'footer_note'  => "Cet email a été envoyé automatiquement. Ne répondez pas directement.<br/>Votre sécurité est notre priorité.",
        'rights'       => 'Tous droits réservés · Cambodge',
        'font'         => "'Georgia',serif",
    ],
    'en' => [
        'html_lang'    => 'en',
        'title'        => 'Password Reset – ' . $sn,
        'badge'        => 'PASSWORD RESET',
        'headline'     => 'New password',
        'headline_sub' => 'for your account',
        'subtitle'     => 'A new password has been generated following your request',
        'greeting'     => 'Hello',
        'intro'        => "We received a password reset request for your sponsor account at <strong style=\"color:#f97316;\">%s</strong>. Here are your new login credentials:",
        'box_title'    => '🔑 YOUR NEW CREDENTIALS',
        'lbl_email'    => 'Email Address',
        'lbl_user'     => 'Username',
        'lbl_pass'     => 'New Password',
        'security'     => '🛡️ <strong>Security:</strong> Log in immediately and change this password from your profile. Never share your credentials.',
        'cta'          => 'Log In Now →',
        'cta_link'     => 'Direct link:',
        'not_you_h'    => '⚠️ Was this not you?',
        'not_you_b'    => "If you didn't request this, contact us immediately at %s.",
        'footer_note'  => "This email was sent automatically. Do not reply directly.<br/>Your security is our priority.",
        'rights'       => 'All rights reserved · Cambodia',
        'font'         => "'Georgia',serif",
    ],
    'km' => [
        'html_lang'    => 'km',
        'title'        => 'កំណត់ពាក្យសម្ងាត់ឡើងវិញ – ' . $sn,
        'badge'        => 'កំណត់ពាក្យសម្ងាត់',
        'headline'     => 'ពាក្យសម្ងាត់ថ្មី',
        'headline_sub' => 'សម្រាប់គណនីរបស់អ្នក',
        'subtitle'     => 'ពាក្យសម្ងាត់ថ្មីត្រូវបានបង្កើតតាមការស្នើសុំរបស់អ្នក',
        'greeting'     => 'សួស្ដី',
        'intro'        => "យើងបានទទួលការស្នើសុំកំណត់ពាក្យសម្ងាត់ឡើងវិញសម្រាប់គណនីអ្នកឧបត្ថម្ភរបស់អ្នកនៅ <strong style=\"color:#f97316;\">%s</strong>។ នេះជាព័ត៌មានចូលថ្មីរបស់អ្នក :",
        'box_title'    => '🔑 ព័ត៌មានចូលថ្មីរបស់អ្នក',
        'lbl_email'    => 'អាសយដ្ឋានអ៊ីមែល',
        'lbl_user'     => 'ឈ្មោះអ្នកប្រើ',
        'lbl_pass'     => 'ពាក្យសម្ងាត់ថ្មី',
        'security'     => '🛡️ <strong>សុវត្ថិភាព :</strong> ចូលប្រើភ្លាមៗ ហើយផ្លាស់ប្ដូរពាក្យសម្ងាត់នេះ។ កុំចែករំលែកព័ត៌មានចូលរបស់អ្នក។',
        'cta'          => 'ចូលប្រើឥឡូវ →',
        'cta_link'     => 'តំណផ្ទាល់ :',
        'not_you_h'    => '⚠️ តើអ្នកមិនបានស្នើសុំទេ?',
        'not_you_b'    => 'ប្រសិនបើអ្នកមិនបានស្នើសុំ ទាក់ទងយើងភ្លាមៗតាម %s។',
        'footer_note'  => "អ៊ីមែលនេះត្រូវបានផ្ញើដោយស្វ័យប្រវត្តិ។ កុំឆ្លើយតបដោយផ្ទាល់។<br/>សុវត្ថិភាពរបស់អ្នកជាអាទិភាពរបស់យើង។",
        'rights'       => 'រក្សាសិទ្ធិគ្រប់យ៉ាង · កម្ពុជា',
        'font'         => "'Hanuman','Battambang',Arial,sans-serif",
    ],
];
$T = $t[$lang] ?? $t['en'];
@endphp
<!DOCTYPE html>
<html lang="{{ $T['html_lang'] }}" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  @if($lang === 'km')
  <link href="https://fonts.googleapis.com/css2?family=Hanuman:wght@400;700&family=Battambang:wght@400;700&display=swap" rel="stylesheet"/>
  @endif
  <title>{{ $T['title'] }}</title>
</head>
<body style="margin:0;padding:0;background-color:#eef2ff;font-family:{{ $T['font'] }};">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#eef2ff;min-height:100vh;">
<tr><td align="center" style="padding:40px 16px;">

  <table width="480" cellpadding="0" cellspacing="0" border="0"
         style="max-width:480px;width:100%;background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 12px 48px rgba(0,0,0,0.13);">

    {{-- ── HERO ── --}}
    <tr>
      <td style="background:linear-gradient(160deg,#0f172a 0%,#1e2d5a 55%,#7c3aed 130%);padding:0;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="padding:44px 40px 28px;text-align:center;">

              {{-- Logo --}}
              @if(!empty($siteLogo))
              <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 20px;">
                <tr>
                  <td style="width:88px;height:88px;border-radius:50%;background:rgba(255,255,255,0.12);border:3px solid rgba(249,115,22,0.5);text-align:center;vertical-align:middle;padding:0;overflow:hidden;">
                    <img src="{{ $siteLogo }}" alt="{{ $sn }}" width="60" height="60"
                         style="width:60px;height:60px;object-fit:contain;display:block;margin:14px auto;"/>
                  </td>
                </tr>
              </table>
              @else
              <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 20px;">
                <tr>
                  <td style="width:88px;height:88px;border-radius:50%;background:rgba(255,255,255,0.10);border:3px solid rgba(249,115,22,0.45);text-align:center;vertical-align:middle;font-size:38px;line-height:88px;padding:0;">
                    🔐
                  </td>
                </tr>
              </table>
              @endif

              {{-- Badge --}}
              <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 18px;">
                <tr>
                  <td style="background:rgba(249,115,22,0.22);border:1.5px solid rgba(249,115,22,0.55);border-radius:99px;padding:5px 18px;">
                    <span style="color:#fcd9b8;font-family:Arial,sans-serif;font-size:{{ $lang==='km'?'10':'11' }}px;font-weight:700;letter-spacing:{{ $lang==='km'?'0':'2.5' }}px;text-transform:uppercase;white-space:nowrap;">{{ $T['badge'] }}</span>
                  </td>
                </tr>
              </table>

              {{-- Headline --}}
              <h1 style="margin:0;color:#ffffff;font-family:{{ $T['font'] }};font-size:{{ $lang==='km'?'26':'30' }}px;font-weight:700;line-height:1.35;letter-spacing:{{ $lang==='km'?'0':'-0.5px' }};">
                {{ $T['headline'] }}<br/>
                <span style="color:#fdba74;">{{ $T['headline_sub'] }}</span>
              </h1>
              <p style="margin:14px 0 0;color:rgba(255,255,255,0.62);font-family:{{ $T['font'] }};font-size:13px;line-height:1.7;">
                {{ $T['subtitle'] }}
              </p>
            </td>
          </tr>

          {{-- Wave --}}
          <tr>
            <td style="padding:0;line-height:0;font-size:0;">
              <svg viewBox="0 0 480 44" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                   style="display:block;width:100%;height:44px;">
                <path d="M0,44 C120,4 360,40 480,14 L480,44 Z" fill="#ffffff"/>
              </svg>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    {{-- ── GREETING ── --}}
    <tr>
      <td style="padding:32px 40px 16px;">
        <p style="margin:0 0 10px;color:#1e293b;font-family:{{ $T['font'] }};font-size:16px;line-height:1.7;">
          {{ $T['greeting'] }} <strong style="color:#0f172a;">{{ $sponsor ?? 'Sponsor' }}</strong>,
        </p>
        <p style="margin:0;color:#64748b;font-family:{{ $T['font'] }};font-size:14px;line-height:1.85;">
          {!! sprintf($T['intro'], $sn) !!}
        </p>
      </td>
    </tr>

    {{-- ── CREDENTIALS BOX ── --}}
    <tr>
      <td style="padding:8px 40px 32px;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0"
               style="background:#eef2ff;border-radius:16px;border:2px solid #c7d2fe;overflow:hidden;">

          {{-- Header --}}
          <tr>
            <td style="background:linear-gradient(90deg,#f97316,#ea580c);padding:13px 22px;">
              <span style="color:#fff;font-family:{{ $T['font'] }};font-size:{{ $lang==='km'?'11':'11' }}px;font-weight:700;letter-spacing:{{ $lang==='km'?'0':'1.8px' }};text-transform:uppercase;">
                {{ $T['box_title'] }}
              </span>
            </td>
          </tr>

          <tr><td style="padding:22px 22px 8px;">

            {{-- Email row --}}
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:14px;">
              <tr>
                <td width="34" style="vertical-align:top;padding-top:2px;">
                  <table cellpadding="0" cellspacing="0" border="0"><tr>
                    <td style="width:28px;height:28px;background:#fff;border-radius:7px;border:1.5px solid #e2e8f0;text-align:center;vertical-align:middle;font-size:13px;line-height:28px;padding:0;">📧</td>
                  </tr></table>
                </td>
                <td style="padding-left:10px;vertical-align:top;">
                  <div style="font-family:{{ $T['font'] }};font-size:10px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:{{ $lang==='km'?'0':'1px' }};margin-bottom:4px;">{{ $T['lbl_email'] }}</div>
                  <div style="font-family:'Courier New',monospace;font-size:14px;color:#1e293b;font-weight:600;background:#fff;border-radius:8px;padding:9px 13px;border:1.5px solid #e2e8f0;word-break:break-all;">{{ $email }}</div>
                </td>
              </tr>
            </table>

            {{-- Username row --}}
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:14px;">
              <tr>
                <td width="34" style="vertical-align:top;padding-top:2px;">
                  <table cellpadding="0" cellspacing="0" border="0"><tr>
                    <td style="width:28px;height:28px;background:#fff;border-radius:7px;border:1.5px solid #e2e8f0;text-align:center;vertical-align:middle;font-size:13px;line-height:28px;padding:0;">👤</td>
                  </tr></table>
                </td>
                <td style="padding-left:10px;vertical-align:top;">
                  <div style="font-family:{{ $T['font'] }};font-size:10px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:{{ $lang==='km'?'0':'1px' }};margin-bottom:4px;">{{ $T['lbl_user'] }}</div>
                  <div style="font-family:'Courier New',monospace;font-size:14px;color:#1e293b;font-weight:600;background:#fff;border-radius:8px;padding:9px 13px;border:1.5px solid #e2e8f0;">{{ $username }}</div>
                </td>
              </tr>
            </table>

            {{-- New Password — orange highlight --}}
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td width="34" style="vertical-align:top;padding-top:2px;">
                  <table cellpadding="0" cellspacing="0" border="0"><tr>
                    <td style="width:28px;height:28px;background:#fff7ed;border-radius:7px;border:1.5px solid #fed7aa;text-align:center;vertical-align:middle;font-size:13px;line-height:28px;padding:0;">✨</td>
                  </tr></table>
                </td>
                <td style="padding-left:10px;vertical-align:top;">
                  <div style="font-family:{{ $T['font'] }};font-size:10px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:{{ $lang==='km'?'0':'1px' }};margin-bottom:4px;">{{ $T['lbl_pass'] }}</div>
                  <div style="font-family:'Courier New',monospace;font-size:22px;color:#f97316;font-weight:700;background:#fff7ed;border-radius:10px;padding:14px 16px;border:2.5px solid #fed7aa;text-align:center;letter-spacing:4px;word-break:break-all;">{{ $newPassword }}</div>
                </td>
              </tr>
            </table>

          </td></tr>

          {{-- Security note --}}
          <tr>
            <td style="padding:4px 22px 20px;">
              <div style="background:rgba(249,115,22,0.07);border-left:3px solid #f97316;border-radius:0 8px 8px 0;padding:10px 14px;">
                <span style="font-family:{{ $T['font'] }};font-size:12px;color:#92400e;line-height:1.7;">
                  {!! $T['security'] !!}
                </span>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    {{-- ── CTA ── --}}
    <tr>
      <td style="padding:0 40px 36px;text-align:center;">
        <a href="{{ $loginUrl ?? '#' }}"
           style="display:inline-block;background:linear-gradient(135deg,#f97316,#ea580c);color:#ffffff;font-family:{{ $T['font'] }};font-size:15px;font-weight:700;text-decoration:none;padding:15px 44px;border-radius:14px;box-shadow:0 6px 20px rgba(249,115,22,0.38);">
          {{ $T['cta'] }}
        </a>
        <p style="margin:12px 0 0;font-family:{{ $T['font'] }};font-size:11px;color:#94a3b8;">
          {{ $T['cta_link'] }} <a href="{{ $loginUrl ?? '#' }}" style="color:#f97316;word-break:break-all;">{{ $loginUrl ?? '#' }}</a>
        </p>
      </td>
    </tr>

    {{-- ── NOT YOU? ── --}}
    <tr>
      <td style="padding:0 40px 36px;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0"
               style="background:#fef2f2;border-radius:12px;border:1.5px solid #fca5a5;">
          <tr>
            <td style="padding:18px 20px;">
              <p style="margin:0 0 5px;font-family:{{ $T['font'] }};font-size:13px;font-weight:700;color:#991b1b;">
                {{ $T['not_you_h'] }}
              </p>
              <p style="margin:0;font-family:{{ $T['font'] }};font-size:12px;color:#b91c1c;line-height:1.7;">
                {!! sprintf($T['not_you_b'], '<a href="mailto:'.($contactEmail ?? 'contact@example.com').'" style="color:#dc2626;font-weight:700;">'.($contactEmail ?? 'contact@example.com').'</a>') !!}
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    {{-- ── FOOTER ── --}}
    <tr>
      <td style="background:linear-gradient(135deg,#0f172a,#1e293b);padding:28px 40px;border-radius:0 0 24px 24px;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="text-align:center;">
              @if(!empty($siteLogo))
              <img src="{{ $siteLogo }}" alt="{{ $sn }}" width="36" height="36"
                   style="width:36px;height:36px;object-fit:contain;border-radius:8px;margin-bottom:10px;opacity:0.8;display:block;margin-left:auto;margin-right:auto;"/>
              @endif
              <p style="margin:0 0 6px;font-family:{{ $T['font'] }};font-size:15px;color:#fdba74;font-weight:700;">
                {{ $sn }}
              </p>
              <p style="margin:0 0 14px;font-family:{{ $T['font'] }};font-size:11px;color:rgba(255,255,255,0.38);line-height:1.7;">
                {!! $T['footer_note'] !!}
              </p>
              <div style="border-top:1px solid rgba(255,255,255,0.08);padding-top:14px;">
                <p style="margin:0;font-family:{{ $T['font'] }};font-size:10px;color:rgba(255,255,255,0.22);">
                  © {{ date('Y') }} {{ $sn }} · {{ $T['rights'] }}
                </p>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>

  </table>
</td></tr>
</table>
</body>
</html>