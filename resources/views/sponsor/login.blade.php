{{-- resources/views/sponsor/login.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Parrain | Association Des Ailes Pour Grandir</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        body.km { font-family: 'Hanuman', 'Battambang', 'Content', sans-serif; }
        
        .logo-mark { display: flex; align-items: center; gap: 16px; text-decoration: none; }
        .logo-img { width: auto; height: 100px; object-fit: contain; flex-shrink: 0; }
        .logo-text-block { text-align: left; }
        .logo-assoc { font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .logo-main-title { font-size: 22px; font-weight: 900; color: #1f2937; line-height: 1.1; letter-spacing: -0.01em; }
        
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slide-up { animation: slideUp 0.5s ease-out; }
        
        /* Language switcher */
        .lang-btn { 
            padding: 6px 12px; border-radius: 8px; border: 2px solid #e5e7eb;
            font-size: 12px; font-weight: 700; cursor: pointer;
            transition: all .2s; background: white;
        }
        .lang-btn:hover { border-color: #f97316; background: #fff7ed; }
        .lang-btn.active { border-color: #f97316; background: linear-gradient(135deg, #fff7ed, #ffedd5); color: #c2410c; box-shadow: 0 2px 8px rgba(249,115,22,.2); }
        .lang-btn img { width: 20px; height: 14px; object-fit: cover; border-radius: 2px; margin-right: 4px; }
    </style>
</head>
<body>

<div class="bg-gradient-to-br from-orange-50 via-orange-50 to-orange-100 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md animate-slide-up">
    
    {{-- Language Switcher --}}
    <div class="flex justify-center gap-2 mb-6">
        <button class="lang-btn active" data-lang="fr" onclick="switchLang('fr')">
            <img src="https://flagcdn.com/w40/fr.png" alt="FR">
            <span>FR</span>
        </button>
        <button class="lang-btn" data-lang="en" onclick="switchLang('en')">
            <img src="https://flagcdn.com/w40/us.png" alt="EN">
            <span>EN</span>
        </button>
        <button class="lang-btn" data-lang="km" onclick="switchLang('km')">
            <img src="https://flagcdn.com/w40/kh.png" alt="KM">
            <span>ខ្មែរ</span>
        </button>
    </div>

    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="logo-mark inline-flex">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Association Des Ailes Pour Grandir Logo"
                 class="logo-img">
          
        </a>
        <p class="text-xs font-bold text-gray-500 mt-3 uppercase tracking-wider">
            <i class="fas fa-hand-holding-heart text-orange-500 mr-1"></i>
            <span data-fr="Espace Parrain" data-en="Sponsor Portal" data-km="តំបន់ឧបត្ថម្ភ">Espace Parrain</span>
        </p>
    </div>

    {{-- Login card --}}
    <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-black text-gray-800 mb-2" data-fr="Bienvenue" data-en="Welcome" data-km="សូមស្វាគមន៍">Bienvenue</h2>
            <p class="text-sm text-gray-600" data-fr="Connectez-vous pour accéder au profil de votre filleul·e" data-en="Log in to access your sponsored child's profile" data-km="ចូលដើម្បីចូលប្រើប្រវត្តិរូបកុមារឧបត្ថម្ភរបស់អ្នក">Connectez-vous pour accéder au profil de votre filleul·e</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-lg">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-lg">
                <div class="flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('sponsor.login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-user text-orange-500 mr-1 text-xs"></i>
                    <span data-fr="Nom d'utilisateur" data-en="Username" data-km="ឈ្មោះអ្នកប្រើប្រាស់">Nom d'utilisateur</span>
                </label>
                <input type="text" name="username" value="{{ old('username') }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition @error('username') border-red-300 bg-red-50 @enderror"
                       data-placeholder-fr="Entrez votre nom d'utilisateur"
                       data-placeholder-en="Enter your username"
                       data-placeholder-km="បញ្ចូលឈ្មោះអ្នកប្រើប្រាស់"
                       placeholder="Entrez votre nom d'utilisateur"
                       required autofocus>
                @error('username')
                    <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-lock text-orange-500 mr-1 text-xs"></i>
                    <span data-fr="Mot de passe" data-en="Password" data-km="ពាក្យសម្ងាត់">Mot de passe</span>
                </label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none transition @error('password') border-red-300 bg-red-50 @enderror"
                       data-placeholder-fr="Entrez votre mot de passe"
                       data-placeholder-en="Enter your password"
                       data-placeholder-km="បញ្ចូលពាក្យសម្ងាត់"
                       placeholder="Entrez votre mot de passe"
                       required>
                @error('password')
                    <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div class="mb-6 flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600 font-medium" data-fr="Se souvenir de moi" data-en="Remember me" data-km="ចងចាំខ្ញុំ">Se souvenir de moi</label>
                </div>
                <a href="mailto:parrains@ailespourgrandir.org" 
                   class="text-xs text-orange-500 hover:text-orange-600 font-semibold transition"
                   data-fr="Mot de passe oublié ?" data-en="Forgot password?" data-km="ភ្លេចពាក្យសម្ងាត់?">
                    Mot de passe oublié ?
                </a>
            </div>

            <button type="submit"
                    class="w-full py-3.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold text-sm uppercase tracking-wide rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-sign-in-alt mr-2"></i>
                <span data-fr="Se connecter" data-en="Log In" data-km="ចូល">Se connecter</span>
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="flex items-center justify-center gap-6 text-xs text-gray-500 flex-wrap">
                <div class="flex items-center gap-1">
                    <i class="fas fa-shield-alt text-green-500"></i>
                    <span data-fr="Connexion sécurisée" data-en="Secure login" data-km="ការចូលមានសុវត្ថិភាព">Connexion sécurisée</span>
                </div>
                <div class="flex items-center gap-1">
                    <i class="fas fa-lock text-orange-500"></i>
                    <span data-fr="Données protégées" data-en="Protected data" data-km="ទិន្នន័យត្រូវបានការពារ">Données protégées</span>
                </div>
            </div>
            <p class="text-center text-xs text-gray-500 mt-4">
                <span data-fr="Identifiants perdus ?" data-en="Lost credentials?" data-km="បាត់ព័ត៌មានចូល?">Identifiants perdus ?</span>
                <a href="mailto:parrains@ailespourgrandir.org" class="text-orange-500 hover:underline font-semibold" data-fr="Contactez-nous" data-en="Contact us" data-km="ទាក់ទងយើង">Contactez-nous</a>
            </p>
        </div>
    </div>

    {{-- New Sponsor / Donate CTA --}}
    <div class="mt-6 bg-white rounded-xl shadow-lg p-6 border-2 border-orange-200">
        <div class="text-center">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-heart text-orange-500 text-xl"></i>
            </div>
            <h3 class="font-black text-gray-800 mb-2" data-fr="Pas encore parrain ?" data-en="Not a sponsor yet?" data-km="មិនទាន់ជាអ្នកឧបត្ថម្ភ?">Pas encore parrain ?</h3>
            <p class="text-sm text-gray-600 mb-4" data-fr="Rejoignez-nous pour changer la vie d'un enfant" data-en="Join us to change a child's life" data-km="ចូលរួមជាមួយយើងដើម្បីផ្លាស់ប្តូរជីវិតកុមារ">Rejoignez-nous pour changer la vie d'un enfant</p>
            <a href="{{ route('sponsor.contact') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg transition shadow-md hover:shadow-lg">
                <i class="fas fa-envelope"></i>
                <span data-fr="Devenir parrain" data-en="Become a sponsor" data-km="ក្លាយជាអ្នកឧបត្ថម្ភ">Devenir parrain</span>
            </a>
        </div>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800 font-semibold transition">
            <i class="fas fa-arrow-left"></i>
            <span data-fr="Retour au site principal" data-en="Back to main site" data-km="ត្រលប់ទៅគេហទំព័រ">Retour au site principal</span>
        </a>
    </div>

    <div class="mt-8 text-center text-xs text-gray-400">
        <p>© {{ date('Y') }} Association Des Ailes Pour Grandir</p>
        <p class="mt-1" data-fr="Tous droits réservés" data-en="All rights reserved" data-km="រក្សាសិទ្ធិគ្រប់យ៉ាង">Tous droits réservés</p>
    </div>

</div>

</div>

<script>
let currentLang = localStorage.getItem('sponsor_lang') || 'fr';

function switchLang(lang) {
    currentLang = lang;
    localStorage.setItem('sponsor_lang', lang);
    
    // Update button states
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.lang === lang);
    });
    
    // Update all text with data-{lang} attributes
    document.querySelectorAll('[data-' + lang + ']').forEach(el => {
        const text = el.getAttribute('data-' + lang);
        if (el.tagName === 'INPUT') {
            el.placeholder = text;
        } else {
            el.textContent = text;
        }
    });
    
    // Update body font for Khmer
    document.body.classList.toggle('km', lang === 'km');
}

// Apply saved language on load
document.addEventListener('DOMContentLoaded', () => {
    switchLang(currentLang);
});
</script>

</body>
</html>