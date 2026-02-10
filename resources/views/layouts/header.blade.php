<header class="main-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Logo -->
            <a href="#home" class="flex items-center gap-3">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-heart text-white text-xl md:text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800" data-en="Hope & Impact" data-km="សង្ឃឹម និងផលប៉ះពាល់">Hope & Impact</h1>
                    <p class="text-xs md:text-sm text-gray-500" data-en="Changing Lives Together" data-km="ផ្លាស់ប្តូរជីវិតជាមួយគ្នា">Changing Lives Together</p>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-8">
                <a href="#home" class="nav-link text-gray-700 hover:text-orange-500 font-medium transition" data-en="Home" data-km="ទំព័រដើម">Home</a>
                <a href="#sponsor" class="nav-link text-gray-700 hover:text-orange-500 font-medium transition" data-en="Sponsor" data-km="ឧបត្ថម្ភ">Sponsor</a>
                <a href="#our-work" class="nav-link text-gray-700 hover:text-orange-500 font-medium transition" data-en="Our Work" data-km="ការងាររបស់យើង">Our Work</a>
                <a href="learn-more.html" class="nav-link text-gray-700 hover:text-orange-500 font-medium transition" data-en="About" data-km="អំពីយើង">About</a>
                <a href="#news" class="nav-link text-gray-700 hover:text-orange-500 font-medium transition" data-en="News" data-km="ព័ត៌មាន">News</a>
            </nav>

            <!-- Desktop Actions -->
            <div class="hidden md:flex items-center gap-3">
                <!-- Language Switcher Desktop -->
                <div class="relative language-switcher">
                    <button id="lang-toggle" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-globe text-gray-600"></i>
                        <span id="current-lang" class="text-sm font-medium text-gray-700">EN</span>
                        <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="lang-dropdown" class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible transition-all duration-200 z-50">
                        <button onclick="changeLanguage('en')" class="lang-option w-full flex items-center gap-3 px-4 py-3 hover:bg-orange-50 transition-colors text-left rounded-t-lg">
                            <img src="https://flagcdn.com/w40/us.png" alt="English" class="w-6 h-4 object-cover rounded">
                            <span class="text-sm font-medium text-gray-700">English</span>
                        </button>
                        <button onclick="changeLanguage('km')" class="lang-option w-full flex items-center gap-3 px-4 py-3 hover:bg-orange-50 transition-colors text-left rounded-b-lg">
                            <img src="https://flagcdn.com/w40/kh.png" alt="Khmer" class="w-6 h-4 object-cover rounded">
                            <span class="text-sm font-medium text-gray-700">Khmer</span>
                        </button>
                    </div>
                </div>

                <a href="donate-page.html" class="btn-primary" data-en="Donate Now" data-km="បរិច្ចាគឥឡូវ">Donate Now</a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<!-- ========== MOBILE MENU OVERLAY ========== -->
<div id="mobile-menu-overlay" class="mobile-menu-overlay"></div>

<!-- ========== MOBILE MENU ========== -->
<div id="mobile-menu" class="mobile-menu">
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-heart text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800" data-en="Hope & Impact" data-km="សង្ឃឹម និងផលប៉ះពាល់">Hope & Impact</h2>
                    <p class="text-xs text-gray-500" data-en="Menu" data-km="ម៉ឺនុយ">Menu</p>
                </div>
            </div>
            <button id="close-menu" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex flex-col gap-2 mb-6">
            <a href="#home" class="mobile-menu-link p-4 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg font-medium transition flex items-center">
                <i class="fas fa-home w-6 mr-3"></i> 
                <span data-en="Home" data-km="ទំព័រដើម">Home</span>
            </a>
            <a href="#sponsor" class="mobile-menu-link p-4 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg font-medium transition flex items-center">
                <i class="fas fa-child w-6 mr-3"></i> 
                <span data-en="Sponsor a Child" data-km="ឧបត្ថម្ភកុមារ">Sponsor a Child</span>
            </a>
            <a href="#our-work" class="mobile-menu-link p-4 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg font-medium transition flex items-center">
                <i class="fas fa-hands-helping w-6 mr-3"></i> 
                <span data-en="What We Do" data-km="អ្វីដែលយើងធ្វើ">What We Do</span>
            </a>
            <a href="learn-more.html" class="mobile-menu-link p-4 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg font-medium transition flex items-center">
                <i class="fas fa-users w-6 mr-3"></i> 
                <span data-en="About Us" data-km="អំពីយើង">About Us</span>
            </a>
            <a href="#news" class="mobile-menu-link p-4 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg font-medium transition flex items-center">
                <i class="fas fa-newspaper w-6 mr-3"></i> 
                <span data-en="News & Stories" data-km="ព័ត៌មាន និងរឿងរ៉ាវ">News & Stories</span>
            </a>
        </nav>

        <!-- Language Switcher Section -->
        <div class="mb-6 p-4 bg-gray-50 rounded-xl">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-semibold text-gray-600 flex items-center gap-2">
                    <i class="fas fa-globe text-orange-500"></i>
                    <span data-en="Language" data-km="ភាសា">Language</span>
                </p>
                <span id="mobile-current-lang" class="text-xs font-bold text-orange-500 px-2 py-1 bg-orange-100 rounded-full">EN</span>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <button onclick="changeLanguage('en')" id="lang-btn-en" class="lang-btn-mobile flex flex-col items-center gap-2 p-3 bg-white hover:bg-orange-50 border-2 border-gray-200 hover:border-orange-500 rounded-lg transition-all transform hover:scale-105 active">
                    <img src="https://flagcdn.com/w80/us.png" alt="English" class="w-10 h-7 object-cover rounded shadow-sm">
                    <span class="text-xs font-semibold text-gray-700">English</span>
                </button>
                <button onclick="changeLanguage('km')" id="lang-btn-km" class="lang-btn-mobile flex flex-col items-center gap-2 p-3 bg-white hover:bg-orange-50 border-2 border-gray-200 hover:border-orange-500 rounded-lg transition-all transform hover:scale-105">
                    <img src="https://flagcdn.com/w80/kh.png" alt="Khmer" class="w-10 h-7 object-cover rounded shadow-sm">
                    <span class="text-xs font-semibold text-gray-700">Khmer</span>
                </button>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="donate-page.html" class="btn-primary w-full text-center block" data-en="Donate Now" data-km="បរិច្ចាគឥឡូវ">Donate Now</a>
            <a href="#volunteer" class="block w-full text-center py-3 px-6 border-2 border-orange-500 text-orange-500 rounded-full font-semibold hover:bg-orange-50 transition" data-en="Volunteer" data-km="ស្ម័គ្រចិត្ត">Volunteer</a>
        </div>

        <!-- Footer Info -->
        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
            <p class="text-xs text-gray-500" data-en="© 2026 Hope & Impact. All rights reserved." data-km="© ២០២៦ សង្ឃឹម និងផលប៉ះពាល់។ រក្សាសិទ្ធិគ្រប់យ៉ាង។">© 2026 Hope & Impact. All rights reserved.</p>
        </div>
    </div>
</div>

<style>
/* Language Switcher Desktop */
.language-switcher {
    position: relative;
}

#lang-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

#lang-dropdown {
    transform: translateY(-10px);
}

.lang-option:hover {
    background-color: #fff5eb;
}

.lang-option.active {
    background-color: #fed7aa;
}

/* Mobile Language Buttons */
.lang-btn-mobile.active {
    background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
    border-color: #fb923c;
    box-shadow: 0 4px 12px rgba(251, 146, 60, 0.3);
}

.lang-btn-mobile.active span {
    color: #7c2d12;
    font-weight: 700;
}

.lang-btn-mobile {
    transition: all 0.3s ease;
}

/* Current language badge */
#mobile-current-lang {
    transition: all 0.3s ease;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Smooth transition for text changes */
[data-en], [data-km] {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
</style>

<script>
// Complete Language Switcher with Mobile Menu Integration
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Elements
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const closeMenuBtn = document.getElementById('close-menu');
    const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');

    // Desktop Language Elements
    const langToggle = document.getElementById('lang-toggle');
    const langDropdown = document.getElementById('lang-dropdown');
    const currentLangSpan = document.getElementById('current-lang');
    
    // Mobile Language Elements
    const mobileCurrentLang = document.getElementById('mobile-current-lang');
    
    // Load saved language preference
    let currentLanguage = localStorage.getItem('language') || 'en';
    changeLanguage(currentLanguage);
    
    // Mobile Menu Functions
    function openMenu() {
        mobileMenu.classList.add('active');
        mobileMenuOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        mobileMenu.classList.remove('active');
        mobileMenuOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMenu);
    if (closeMenuBtn) closeMenuBtn.addEventListener('click', closeMenu);
    if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', closeMenu);

    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', closeMenu);
    });
    
    // Desktop Language Toggle
    if (langToggle) {
        langToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            langDropdown.classList.toggle('show');
        });
    }
    
    // Close dropdown on outside click
    document.addEventListener('click', function(e) {
        if (langToggle && !langToggle.contains(e.target) && !langDropdown.contains(e.target)) {
            langDropdown.classList.remove('show');
        }
    });
});

function changeLanguage(lang) {
    // Update all language displays
    const currentLangSpan = document.getElementById('current-lang');
    const mobileCurrentLang = document.getElementById('mobile-current-lang');
    const langDropdown = document.getElementById('lang-dropdown');
    
    if (currentLangSpan) currentLangSpan.textContent = lang.toUpperCase();
    if (mobileCurrentLang) mobileCurrentLang.textContent = lang.toUpperCase();
    
    // Update active button state in mobile menu
    const langButtons = document.querySelectorAll('.lang-btn-mobile');
    langButtons.forEach(btn => btn.classList.remove('active'));
    
    const activeBtn = document.getElementById(`lang-btn-${lang}`);
    if (activeBtn) activeBtn.classList.add('active');
    
    // Get all elements with language attributes
    const elements = document.querySelectorAll('[data-en], [data-km]');
    
    elements.forEach(element => {
        // Add fade effect
        element.style.opacity = '0.5';
        element.style.transform = 'translateY(-2px)';
        
        setTimeout(() => {
            if (lang === 'en') {
                element.textContent = element.getAttribute('data-en');
            } else if (lang === 'km') {
                element.textContent = element.getAttribute('data-km');
            }
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 150);
    });
    
    // Save language preference
    localStorage.setItem('language', lang);
    
    // Update HTML lang attribute
    document.documentElement.lang = lang === 'km' ? 'km' : 'en';
    
    // Close dropdown
    if (langDropdown) langDropdown.classList.remove('show');
    
    // Update font for Khmer text
    if (lang === 'km') {
        document.body.style.fontFamily = "'Hanuman', 'Battambang', 'Content', sans-serif";
    } else {
        document.body.style.fontFamily = "'Montserrat', sans-serif";
    }
    
    // Animation feedback
    if (mobileCurrentLang) {
        mobileCurrentLang.style.animation = 'none';
        setTimeout(() => {
            mobileCurrentLang.style.animation = 'pulse 2s infinite';
        }, 10);
    }
}
</script>