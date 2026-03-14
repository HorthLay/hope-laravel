{{--
  resources/views/emails/sponsor/account_created.blade.php
  Variables: $sponsor, $email, $username, $password, $loginUrl, $siteName, $siteLogo, $lang (fr|en|km)
--}}
@php
$lang = $lang ?? 'fr';
$sn   = $siteName ?? 'Des Ailes pour Grandir';

$translations = [
    'fr' => [
        'html_lang'   => 'fr',
        'title'       => 'Votre compte ' . $sn,
        'badge'       => 'NOUVEAU COMPTE',
        'welcome'     => 'Bienvenue,',
        'salutation'  => 'Parrain',
        'subtitle'    => 'Votre compte parrain a été créé avec succès',
        'greeting'    => 'Bonjour',
        'intro'       => "L'équipe de <strong style=\"color:#f97316;\">%s</strong> a le plaisir de vous informer que votre compte parrain a été créé. Vous trouverez ci-dessous vos informations de connexion. Veuillez les conserver en lieu sûr.",
        'creds_title' => '🔐 Vos Identifiants de Connexion',
        'lbl_email'   => 'Adresse Email',
        'lbl_user'    => "Nom d'Utilisateur",
        'lbl_pass'    => 'Mot de Passe Temporaire',
        'warning'     => '<strong>Important :</strong> Veuillez changer votre mot de passe dès votre première connexion.',
        'cta'         => 'Se Connecter à Mon Compte →',
        'cta_link'    => 'Ou copiez ce lien :',
        'next_title'  => 'Prochaines étapes :',
        'steps'       => [
            ['🔓','Connectez-vous',"Utilisez vos identifiants ci-dessus pour accéder à votre espace parrain."],
            ['🔒','Changez votre mot de passe',"Sécurisez votre compte en définissant un mot de passe personnel dès la première connexion."],
            ['👧','Découvrez votre filleul',"Consultez le profil de l'enfant que vous parrainez et suivez son évolution."],
        ],
        'footer_note' => "Cet email a été envoyé automatiquement. Ne répondez pas directement.<br/>Si vous n'avez pas demandé ce compte, contactez-nous immédiatement.",
        'rights'      => 'Tous droits réservés · Cambodge',
        'font_stack'  => "'Georgia', serif",
    ],
    'en' => [
        'html_lang'   => 'en',
        'title'       => 'Your account at ' . $sn,
        'badge'       => 'NEW ACCOUNT',
        'welcome'     => 'Welcome,',
        'salutation'  => 'Sponsor',
        'subtitle'    => 'Your sponsor account has been successfully created',
        'greeting'    => 'Hello',
        'intro'       => "The team at <strong style=\"color:#f97316;\">%s</strong> is pleased to inform you that your sponsor account has been created. Your login credentials are below — please keep them safe.",
        'creds_title' => '🔐 Your Login Credentials',
        'lbl_email'   => 'Email Address',
        'lbl_user'    => 'Username',
        'lbl_pass'    => 'Temporary Password',
        'warning'     => '<strong>Important:</strong> Please change your password on your first login to secure your account.',
        'cta'         => 'Log In to My Account →',
        'cta_link'    => 'Or copy this link:',
        'next_title'  => 'Next steps:',
        'steps'       => [
            ['🔓','Log in','Use the credentials above to access your sponsor dashboard.'],
            ['🔒','Change your password','Set a personal password on your first login to secure your account.'],
            ['👧','Meet your child','View the profile of the child you sponsor and follow their progress.'],
        ],
        'footer_note' => "This email was sent automatically. Please do not reply directly.<br/>If you did not request this account, contact us immediately.",
        'rights'      => 'All rights reserved · Cambodia',
        'font_stack'  => "'Georgia', serif",
    ],
    'km' => [
        'html_lang'   => 'km',
        'title'       => 'គណនីរបស់អ្នកនៅ ' . $sn,
        'badge'       => 'គណនីថ្មី',
        'welcome'     => 'សូមស្វាគមន៍,',
        'salutation'  => 'អ្នកឧបត្ថម្ភ',
        'subtitle'    => 'គណនីអ្នកឧបត្ថម្ភរបស់អ្នកត្រូវបានបង្កើតដោយជោគជ័យ',
        'greeting'    => 'សួស្ដី',
        'intro'       => "ក្រុមការងារ <strong style=\"color:#f97316;\">%s</strong> មានសេចក្ដីរីករាយជូនដំណឹងថា គណនីអ្នកឧបត្ថម្ភរបស់អ្នកត្រូវបានបង្កើតហើយ។ ទិន្នន័យចូលប្រើគណនីរបស់អ្នកមាននៅខាងក្រោម — សូមរក្សាវាឱ្យបានសុវត្ថិភាព។",
        'creds_title' => '🔐 ព័ត៌មានចូលប្រើគណនី',
        'lbl_email'   => 'អាសយដ្ឋានអ៊ីមែល',
        'lbl_user'    => 'ឈ្មោះអ្នកប្រើ',
        'lbl_pass'    => 'ពាក្យសម្ងាត់បណ្ដោះអាសន្ន',
        'warning'     => '<strong>សំខាន់ :</strong> សូមប្ដូរពាក្យសម្ងាត់នៅពេលចូលប្រើដំបូង ដើម្បីការពារគណនី។',
        'cta'         => 'ចូលប្រើគណនីរបស់ខ្ញុំ →',
        'cta_link'    => 'ឬចម្លងតំណភ្ជាប់នេះ :',
        'next_title'  => 'ជំហានបន្ទាប់ :',
        'steps'       => [
            ['🔓','ចូលប្រើ','ប្រើព័ត៌មានខាងលើ ដើម្បីចូលទៅកាន់ទំព័រអ្នកឧបត្ថម្ភ។'],
            ['🔒','ប្ដូរពាក្យសម្ងាត់','ការពារគណនីដោយកំណត់ពាក្យសម្ងាត់ផ្ទាល់ខ្លួននៅពេលចូលដំបូង។'],
            ['👧','ស្គាល់កុមារ','មើលប្រវត្តិរូបរបស់កុមារ ហើយតាមដានការរីកចម្រើនរបស់គេ។'],
        ],
        'footer_note' => "អ៊ីមែលនេះត្រូវបានផ្ញើដោយស្វ័យប្រវត្តិ។ សូមមិនឆ្លើយតបដោយផ្ទាល់។<br/>ប្រសិនបើអ្នកមិនបានស្នើសុំគណនីនេះ សូមទាក់ទងមកយើងភ្លាមៗ។",
        'rights'      => 'រក្សាសិទ្ធិគ្រប់យ៉ាង · កម្ពុជា',
        'font_stack'  => "'Hanuman', 'Khmer OS', Arial, sans-serif",
    ],
];

$t = $translations[$lang] ?? $translations['fr'];
@endphp
<!DOCTYPE html>
<html lang="{{ $t['html_lang'] }}" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>{{ $t['title'] }}</title>
  @if($lang === 'km')
  <link href="https://fonts.googleapis.com/css2?family=Hanuman:wght@400;700&display=swap" rel="stylesheet"/>
  @endif
</head>
<body style="margin:0;padding:0;background-color:#fdf8f3;font-family:{{ $t['font_stack'] }};-webkit-font-smoothing:antialiased;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fdf8f3;min-height:100vh;">
<tr><td align="center" style="padding:40px 16px;">

  <table width="600" cellpadding="0" cellspacing="0" border="0"
         style="max-width:600px;width:100%;background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 8px 40px rgba(0,0,0,0.10);">

    {{-- ── HERO ── --}}
    <tr>
      <td style="background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 50%,#f97316 150%);padding:0;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="padding:44px 48px 36px;text-align:center;">
              @if(!empty($siteLogo))
                <img src="{{ $siteLogo }}"
                     alt="{{ $sn }}" width="80" height="80"
                     style="width:80px;height:80px;object-fit:contain;border-radius:16px;background:rgba(255,255,255,0.12);padding:8px;margin-bottom:20px;display:block;margin-left:auto;margin-right:auto;"/>
              @else
                <div style="width:80px;height:80px;background:rgba(255,255,255,0.15);border-radius:16px;margin:0 auto 20px;border:2px solid rgba(255,255,255,0.2);text-align:center;line-height:80px;font-size:32px;">🕊️</div>
              @endif

              <div style="display:inline-block;background:rgba(249,115,22,0.25);border:1.5px solid rgba(249,115,22,0.5);border-radius:99px;padding:5px 16px;margin-bottom:18px;">
                <span style="color:#fcd9b8;font-family:Arial,sans-serif;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;">{{ $t['badge'] }}</span>
              </div>

              <h1 style="margin:0;color:#ffffff;font-family:{{ $t['font_stack'] }};font-size:29px;font-weight:700;line-height:1.35;letter-spacing:-0.3px;">
                {{ $t['welcome'] }}<br/>
                <span style="color:#fdba74;">{{ $sponsor ?? $t['salutation'] }}</span> 🤝
              </h1>
              <p style="margin:14px 0 0;color:rgba(255,255,255,0.72);font-family:Arial,sans-serif;font-size:15px;line-height:1.6;">
                {{ $t['subtitle'] }}
              </p>
            </td>
          </tr>
          <tr>
            <td style="padding:0;line-height:0;font-size:0;">
              <svg viewBox="0 0 600 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%;height:40px;">
                <path d="M0,40 C150,0 450,40 600,10 L600,40 Z" fill="#ffffff"/>
              </svg>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    {{-- ── INTRO ── --}}
    <tr>
      <td style="padding:36px 48px 20px;">
        <p style="margin:0 0 16px;color:#374151;font-family:Arial,sans-serif;font-size:16px;line-height:1.8;">
          {{ $t['greeting'] }} <strong style="color:#0f172a;">{{ $sponsor ?? $t['salutation'] }}</strong>,
        </p>
        <p style="margin:0;color:#6b7280;font-family:Arial,sans-serif;font-size:15px;line-height:1.8;">
          {!! sprintf($t['intro'], $sn) !!}
        </p>
      </td>
    </tr>

    {{-- ── CREDENTIALS BOX ── --}}
    <tr>
      <td style="padding:8px 48px 32px;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0"
               style="background:linear-gradient(135deg,#fff7ed,#fef3c7);border-radius:16px;border:2px solid #fed7aa;overflow:hidden;">
          <tr>
            <td style="background:#f97316;padding:14px 24px;">
              <span style="color:#fff;font-family:Arial,sans-serif;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">{{ $t['creds_title'] }}</span>
            </td>
          </tr>
          <tr>
            <td style="padding:24px 24px 8px;">

              {{-- Email row --}}
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:14px;">
                <tr>
                  <td width="28" style="vertical-align:top;padding-top:2px;">
                    <div style="width:28px;height:28px;background:#fff7ed;border-radius:8px;border:1.5px solid #fed7aa;text-align:center;line-height:26px;font-size:14px;">📧</div>
                  </td>
                  <td style="padding-left:12px;vertical-align:top;">
                    <div style="font-family:Arial,sans-serif;font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;margin-bottom:3px;">{{ $t['lbl_email'] }}</div>
                    <div style="font-family:'Courier New',monospace;font-size:15px;color:#0f172a;font-weight:700;background:rgba(255,255,255,0.7);border-radius:8px;padding:8px 12px;border:1px solid #fed7aa;word-break:break-all;">{{ $email }}</div>
                  </td>
                </tr>
              </table>

              {{-- Username row --}}
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:14px;">
                <tr>
                  <td width="28" style="vertical-align:top;padding-top:2px;">
                    <div style="width:28px;height:28px;background:#fff7ed;border-radius:8px;border:1.5px solid #fed7aa;text-align:center;line-height:26px;font-size:14px;">👤</div>
                  </td>
                  <td style="padding-left:12px;vertical-align:top;">
                    <div style="font-family:Arial,sans-serif;font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;margin-bottom:3px;">{{ $t['lbl_user'] }}</div>
                    <div style="font-family:'Courier New',monospace;font-size:15px;color:#0f172a;font-weight:700;background:rgba(255,255,255,0.7);border-radius:8px;padding:8px 12px;border:1px solid #fed7aa;">{{ $username }}</div>
                  </td>
                </tr>
              </table>

              {{-- Password row --}}
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td width="28" style="vertical-align:top;padding-top:2px;">
                    <div style="width:28px;height:28px;background:#fef2f2;border-radius:8px;border:1.5px solid #fca5a5;text-align:center;line-height:26px;font-size:14px;">🔑</div>
                  </td>
                  <td style="padding-left:12px;vertical-align:top;">
                    <div style="font-family:Arial,sans-serif;font-size:11px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;margin-bottom:3px;">{{ $t['lbl_pass'] }}</div>
                    <div style="font-family:'Courier New',monospace;font-size:19px;color:#dc2626;font-weight:700;background:rgba(254,242,242,0.8);border-radius:8px;padding:10px 14px;border:1.5px solid #fca5a5;letter-spacing:3px;">{{ $password }}</div>
                  </td>
                </tr>
              </table>

            </td>
          </tr>
          <tr>
            <td style="padding:0 24px 20px;">
              <div style="background:rgba(249,115,22,0.08);border-left:3px solid #f97316;border-radius:0 8px 8px 0;padding:10px 14px;margin-top:8px;">
                <span style="font-family:Arial,sans-serif;font-size:12px;color:#92400e;line-height:1.7;">⚠️ {!! $t['warning'] !!}</span>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    {{-- ── CTA BUTTON ── --}}
    <tr>
      <td style="padding:0 48px 40px;text-align:center;">
        <a href="{{ $loginUrl ?? '#' }}"
           style="display:inline-block;background:linear-gradient(135deg,#f97316,#ea580c);color:#ffffff;font-family:Arial,sans-serif;font-size:16px;font-weight:700;text-decoration:none;padding:16px 40px;border-radius:14px;box-shadow:0 6px 20px rgba(249,115,22,0.4);">
          {{ $t['cta'] }}
        </a>
        <p style="margin:14px 0 0;font-family:Arial,sans-serif;font-size:12px;color:#9ca3af;">
          {{ $t['cta_link'] }} <a href="{{ $loginUrl ?? '#' }}" style="color:#f97316;word-break:break-all;">{{ $loginUrl ?? '#' }}</a>
        </p>
      </td>
    </tr>

    {{-- Divider --}}
    <tr><td style="padding:0 48px;"><div style="height:1px;background:linear-gradient(90deg,transparent,#e5e7eb,transparent);"></div></td></tr>

    {{-- ── NEXT STEPS ── --}}
    <tr>
      <td style="padding:32px 48px;">
        <p style="margin:0 0 20px;font-family:{{ $t['font_stack'] }};font-size:18px;font-weight:700;color:#0f172a;">{{ $t['next_title'] }}</p>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          @foreach($t['steps'] as [$icon, $title, $desc])
          <tr>
            <td style="padding-bottom:16px;vertical-align:top;">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td width="40" style="vertical-align:top;">
                    <div style="width:36px;height:36px;background:#fff7ed;border-radius:10px;border:1.5px solid #fed7aa;text-align:center;line-height:34px;font-size:18px;">{{ $icon }}</div>
                  </td>
                  <td style="padding-left:12px;vertical-align:top;">
                    <div style="font-family:{{ $t['font_stack'] }};font-size:14px;font-weight:700;color:#0f172a;margin-bottom:3px;">{{ $title }}</div>
                    <div style="font-family:Arial,sans-serif;font-size:13px;color:#6b7280;line-height:1.6;">{{ $desc }}</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          @endforeach
        </table>
      </td>
    </tr>

    {{-- ── FOOTER ── --}}
    <tr>
      <td style="background:#0f172a;padding:32px 48px;border-radius:0 0 20px 20px;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="text-align:center;">
              <p style="margin:0 0 8px;font-family:{{ $t['font_stack'] }};font-size:16px;color:#fdba74;font-weight:700;">{{ $sn }}</p>
              <p style="margin:0 0 16px;font-family:Arial,sans-serif;font-size:12px;color:rgba(255,255,255,0.45);line-height:1.6;">{!! $t['footer_note'] !!}</p>
              <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:16px;">
                <p style="margin:0;font-family:Arial,sans-serif;font-size:11px;color:rgba(255,255,255,0.25);">
                  © {{ date('Y') }} {{ $sn }} · {{ $t['rights'] }}
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