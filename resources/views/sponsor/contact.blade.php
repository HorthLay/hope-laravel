<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte Parrain | Association Des Ailes Pour Grandir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        body.km { font-family: 'Hanuman', sans-serif; }
        .logo-mark { display: flex; align-items: center; gap: 14px; text-decoration: none; }
        .logo-img { width: 70px; height: 70px; object-fit: contain; }
        .logo-assoc { font-size: 10px; font-weight: 600; color: #6b7280; text-transform: uppercase; }
        .logo-main-title { font-size: 18px; font-weight: 900; color: #1f2937; line-height: 1.1; }

        .lang-btn { padding: 6px 12px; border-radius: 8px; border: 2px solid #e5e7eb; font-size: 12px; font-weight: 700; cursor: pointer; transition: all .2s; background: white; }
        .lang-btn:hover { border-color: #f97316; background: #fff7ed; }
        .lang-btn.active { border-color: #f97316; background: linear-gradient(135deg,#fff7ed,#ffedd5); color: #c2410c; }
        .lang-btn img { width: 20px; height: 14px; border-radius: 2px; margin-right: 4px; }

        .contact-method { transition: all .2s; }
        .contact-method:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.1); }
    </style>
</head>
<body class="bg-gray-50">

{{-- Header --}}
<header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="logo-mark">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
            <div>
                <div class="logo-assoc">Association</div>
                <div class="logo-main-title">DES AILES<br>POUR GRANDIR</div>
            </div>
        </a>
        <div class="flex items-center gap-3">
            <div class="hidden sm:flex gap-2">
                <button class="lang-btn active" data-lang="fr" onclick="switchLang('fr')">
                    <img src="https://flagcdn.com/w40/fr.png" alt="FR">FR
                </button>
                <button class="lang-btn" data-lang="en" onclick="switchLang('en')">
                    <img src="https://flagcdn.com/w40/us.png" alt="EN">EN
                </button>
                <button class="lang-btn" data-lang="km" onclick="switchLang('km')">
                    <img src="https://flagcdn.com/w40/kh.png" alt="KM">ខ្មែរ
                </button>
            </div>
            <a href="{{ route('sponsor.login') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold rounded-lg transition">
                <i class="fas fa-sign-in-alt mr-1"></i>
                <span data-fr="Connexion" data-en="Login" data-km="ចូល">Connexion</span>
            </a>
        </div>
    </div>
</header>

<div class="max-w-6xl mx-auto px-4 py-8 md:py-12">

    {{-- Hero Section --}}
    <div class="text-center mb-12">
        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-user-plus text-orange-500 text-3xl"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-black text-gray-800 mb-3"
            data-fr="Créer un Compte Parrain"
            data-en="Create a Sponsor Account"
            data-km="បង្កើតគណនីអ្នកឧបត្ថម្ភ">Créer un Compte Parrain</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto"
           data-fr="Contactez-nous directement pour créer votre compte parrain et commencer à changer la vie d'un enfant."
           data-en="Contact us directly to create your sponsor account and start changing a child's life."
           data-km="ទាក់ទងយើងដោយផ្ទាល់ដើម្បីបង្កើតគណនីអ្នកឧបត្ថម្ភ ហើយចប់ផ្តើមការផ្លាស់ប្តូរជីវិតកុមារនៅឡើយ។">Contactez-nous directement pour créer votre compte parrain et commencer à changer la vie d'un enfant.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8">

        {{-- Left: How to Create Account --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
            <h2 class="text-2xl font-black text-gray-800 mb-4"
                data-fr="Comment créer un compte ?"
                data-en="How to create an account?"
                data-km="តើអ្នកអាចបង្កើតគណនីដូចម្តេច ?">Comment créer un compte ?</h2>
            <p class="text-sm text-gray-600 mb-6"
               data-fr="Pour créer un compte parrain, veuillez nous contacter via l'une des méthodes ci-dessous. Notre équipe vous guidera à travers le processus."
               data-en="To create a sponsor account, please contact us via one of the methods below. Our team will guide you through the process."
               data-km="ដើម្បីបង្កើតគណនីអ្នកឧបត្ថម្ភ។ សូមទាក់ទងយើងតាមរយៈវិធីណាមួយខាងក្រោម។ ក្រុមយើងនឹងណែនាំអ្នកតាមរយៈដំណើរការ។">Pour créer un compte parrain, veuillez nous contacter via l'une des méthodes ci-dessous. Notre équipe vous guidera à travers le processus.</p>

            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                        <i class="fas fa-envelope text-orange-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800"
                            data-fr="Envoyez-nous un e-mail"
                            data-en="Send us an email"
                            data-km="ផ្ញើអ៊ីមែលទៅយើង">Envoyez-nous un e-mail</h3>
                        <p class="text-sm text-gray-600"
                           data-fr="Envoyez un message à l'adresse ci-dessous avec vos coordonnées (nom, e-mail, numéro de téléphone)."
                           data-en="Send a message to the address below with your details (name, email, phone number)."
                           data-km="ផ្ញើសារទៅអាស័យដ្ឋានអ៊ីមែលខាងក្រោមនេះជាមួយព័ត៌មានរបស់អ្នក (ឈ្មោះ។ ល។ លេខទូរស័ព្ទ)។">Envoyez un message à l'adresse ci-dessous avec vos coordonnées (nom, e-mail, numéro de téléphone).</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                        <i class="fab fa-whatsapp text-green-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800"
                            data-fr="Contactez-nous sur WhatsApp"
                            data-en="Contact us on WhatsApp"
                            data-km="ទាក់ទងយើងតាមរយៈ WhatsApp">Contactez-nous sur WhatsApp</h3>
                        <p class="text-sm text-gray-600"
                           data-fr="Envoyez un message via WhatsApp pour une assistance immédiate."
                           data-en="Send a message via WhatsApp for immediate assistance."
                           data-km="ផ្ញើសារតាមរយៈ WhatsApp ដើម្បីទទួលជួយជាពិសេស។">Envoyez un message via WhatsApp pour une assistance immédiate.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                        <i class="fab fa-telegram text-blue-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800"
                            data-fr="Envoyez-nous un message sur Telegram"
                            data-en="Send us a message on Telegram"
                            data-km="ផ្ញើសារទៅយើងតាមរយៈ Telegram">Envoyez-nous un message sur Telegram</h3>
                        <p class="text-sm text-gray-600"
                           data-fr="Contactez-nous via Telegram pour créer votre compte."
                           data-en="Contact us via Telegram to create your account."
                           data-km="ទាក់ទងយើងតាមរយៈ Telegram ដើម្បីបង្កើតគណនីរបស់អ្នក។">Contactez-nous via Telegram pour créer votre compte.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Contact Methods --}}
        <div class="space-y-6">

            {{-- Direct Contact --}}
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-black text-gray-800 mb-4"
                    data-fr="Nous Contacter Directement"
                    data-en="Contact Us Directly"
                    data-km="ទាក់ទងយើងដោយផ្ទាល់">Nous Contacter Directement</h3>

                <div class="space-y-3">
                    <a href="mailto:parrains@ailespourgrandir.org" class="contact-method flex items-center gap-4 p-4 bg-gray-50 hover:bg-orange-50 rounded-xl">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-orange-500"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm text-gray-800"
                                 data-fr="E-mail"
                                 data-en="Email"
                                 data-km="អ៊ីមែល">E-mail</div>
                            <div class="text-xs text-gray-600 truncate">parrains@ailespourgrandir.org</div>
                        </div>
                        <i class="fas fa-external-link-alt text-gray-400 text-xs"></i>
                    </a>

                    <a href="https://wa.me/33123456789" target="_blank" class="contact-method flex items-center gap-4 p-4 bg-gray-50 hover:bg-green-50 rounded-xl">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-green-500 text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm text-gray-800">WhatsApp</div>
                            <div class="text-xs text-gray-600"
                                 data-fr="Chat instantané"
                                 data-en="Instant chat"
                                 data-km="ជជែកភ្លាមៗ">Chat instantané</div>
                        </div>
                        <i class="fas fa-external-link-alt text-gray-400 text-xs"></i>
                    </a>

                    <a href="https://t.me/ailespourgrandir" target="_blank" class="contact-method flex items-center gap-4 p-4 bg-gray-50 hover:bg-blue-50 rounded-xl">
                        <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-telegram text-sky-500 text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm text-gray-800">Telegram</div>
                            <div class="text-xs text-gray-600">@ailespourgrandir</div>
                        </div>
                        <i class="fas fa-external-link-alt text-gray-400 text-xs"></i>
                    </a>

                    <a href="https://facebook.com/ailespourgrandir" target="_blank" class="contact-method flex items-center gap-4 p-4 bg-gray-50 hover:bg-blue-50 rounded-xl">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-facebook text-blue-600 text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm text-gray-800">Facebook</div>
                            <div class="text-xs text-gray-600"
                                 data-fr="Page officielle"
                                 data-en="Official page"
                                 data-km="ទំព័រផ្លូវការ">Page officielle</div>
                        </div>
                        <i class="fas fa-external-link-alt text-gray-400 text-xs"></i>
                    </a>
                </div>
            </div>

            {{-- Why Sponsor --}}
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
                <h3 class="text-xl font-black mb-3"
                    data-fr="Pourquoi Devenir Parrain ?"
                    data-en="Why Become a Sponsor?"
                    data-km="ហេតុអ្វីត្រូវក្លាយជាអ្នកឧបត្ថម្ភ?">Pourquoi Devenir Parrain ?</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5"></i>
                        <span
                            data-fr="Changez directement la vie d'un enfant"
                            data-en="Directly change a child's life"
                            data-km="ផ្លាស់ប្តូរជីវិតកុមារដោយផ្ទាល់">Changez directement la vie d'un enfant</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5"></i>
                        <span
                            data-fr="Recevez des nouvelles régulières"
                            data-en="Receive regular updates"
                            data-km="ទទួលព័ត៌មានទៀងទាត់">Recevez des nouvelles régulières</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5"></i>
                        <span
                            data-fr="84% des fonds vont aux programmes"
                            data-en="84% of funds go to programs"
                            data-km="៨៤% នៃមូលនិធិទៅកម្មវិធី">84% des fonds vont aux programmes</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-0.5"></i>
                        <span
                            data-fr="Suivez la scolarité de votre filleul·e"
                            data-en="Track your child's education"
                            data-km="តាមដានការអប់រំរបស់កូនអ្នក">Suivez la scolarité de votre filleul·e</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

</div>

<script>
let currentLang = localStorage.getItem('sponsor_lang') || 'fr';

function switchLang(lang) {
    currentLang = lang;
    localStorage.setItem('sponsor_lang', lang);

    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.lang === lang);
    });

    document.querySelectorAll('[data-' + lang + ']').forEach(el => {
        const text = el.getAttribute('data-' + lang);
        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
            el.placeholder = text;
        } else {
            el.textContent = text;
        }
    });

    document.body.classList.toggle('km', lang === 'km');
}

document.addEventListener('DOMContentLoaded', () => switchLang(currentLang));
</script>

</body>
</html>
