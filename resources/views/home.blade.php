<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Hope & Impact | Changing Children's Lives</title>
    <meta name="description" content="Help transform children's lives through education, healthcare, and nutrition in Southeast Asia. Sponsor a child today.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    @include('css.style')
</head>
<body>
    @include('layouts.loading')
    <!-- ========== HEADER ========== -->

    @include('layouts.header')

    <!-- ========== HERO SECTION WITH VIDEO ========== -->
    <section id="home" class="hero-section">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="{{ asset('project/videos/video.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fade-in-down">
                    Sponsor a Child Today
                </h1>
                <p class="text-lg sm:text-xl md:text-2xl mb-10 opacity-95 animate-fade-in-up delay-200">
                    And change a life with the gift of education
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up delay-400">
                    <a href="#sponsor" class="btn-primary text-lg">Sponsor a Child Now</a>
                    <a href="learn-more.html" class="btn-secondary text-lg">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== STATS SECTION ========== -->
    <section class="stats-section scroll-animate">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Impact Since 1958</h2>
                <p class="text-lg opacity-90">Transparency and efficiency in action</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div class="text-center">
                    <div class="stat-number counter" data-target="95000">0</div>
                    <p class="text-base md:text-lg font-medium">Children Helped</p>
                </div>
                <div class="text-center">
                    <div class="stat-number counter" data-target="84">0</div>
                    <p class="text-base md:text-lg font-medium">% To Programs</p>
                </div>
                <div class="text-center">
                    <div class="stat-number counter" data-target="7">0</div>
                    <p class="text-base md:text-lg font-medium">Countries</p>
                </div>
                <div class="text-center">
                    <div class="stat-number counter" data-target="1000">0</div>
                    <p class="text-base md:text-lg font-medium">+ Volunteers</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== WHY CHOOSE US SECTION ========== -->
    <section class="section">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-8 md:mb-12 scroll-animate">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Why Choose Us</h2>
                <p class="text-base md:text-lg text-gray-600 max-w-3xl mx-auto">
                    Trusted by thousands of donors worldwide for our transparency and commitment
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <!-- Highlight 1 -->
                <div class="bg-white rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all scroll-animate text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                        <i class="fas fa-shield-alt text-orange-600 text-xl md:text-3xl"></i>
                    </div>
                    <h3 class="text-sm md:text-lg font-bold text-gray-800 mb-2">100% Transparent</h3>
                    <p class="text-xs md:text-sm text-gray-600">
                        Full accountability on how your donations are used
                    </p>
                </div>

                <!-- Highlight 2 -->
                <div class="bg-white rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all scroll-animate text-center" style="animation-delay: 0.1s;">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                        <i class="fas fa-certificate text-blue-600 text-xl md:text-3xl"></i>
                    </div>
                    <h3 class="text-sm md:text-lg font-bold text-gray-800 mb-2">Certified NGO</h3>
                    <p class="text-xs md:text-sm text-gray-600">
                        Internationally recognized and accredited organization
                    </p>
                </div>

                <!-- Highlight 3 -->
                <div class="bg-white rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all scroll-animate text-center" style="animation-delay: 0.2s;">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                        <i class="fas fa-hand-holding-heart text-green-600 text-xl md:text-3xl"></i>
                    </div>
                    <h3 class="text-sm md:text-lg font-bold text-gray-800 mb-2">Direct Impact</h3>
                    <p class="text-xs md:text-sm text-gray-600">
                        Your support directly reaches children in need
                    </p>
                </div>

                <!-- Highlight 4 -->
                <div class="bg-white rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all scroll-animate text-center" style="animation-delay: 0.3s;">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                        <i class="fas fa-users text-purple-600 text-xl md:text-3xl"></i>
                    </div>
                    <h3 class="text-sm md:text-lg font-bold text-gray-800 mb-2">Strong Network</h3>
                    <p class="text-xs md:text-sm text-gray-600">
                        1000+ local volunteers ensuring quality programs
                    </p>
                </div>
            </div>

            <!-- Additional Highlights Row -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 mt-4 md:mt-6">
                <!-- Highlight 5 -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all scroll-animate" style="animation-delay: 0.4s;">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-white text-sm md:text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-sm md:text-base font-bold text-gray-800 mb-1">Monthly Updates</h4>
                            <p class="text-xs md:text-sm text-gray-600">
                                Receive letters and photos from your sponsored child
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Highlight 6 -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all scroll-animate" style="animation-delay: 0.5s;">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-globe text-white text-sm md:text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-sm md:text-base font-bold text-gray-800 mb-1">Global Reach</h4>
                            <p class="text-xs md:text-sm text-gray-600">
                                Operating in 7 countries across Southeast Asia
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Highlight 7 -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition-all scroll-animate col-span-2 md:col-span-1" style="animation-delay: 0.6s;">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-heart text-white text-sm md:text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-sm md:text-base font-bold text-gray-800 mb-1">Long-term Support</h4>
                            <p class="text-xs md:text-sm text-gray-600">
                                Follow children's progress throughout their education
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== TRANSPARENCY & EFFICIENCY SECTION ========== -->
    <section class="section bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 md:mb-12 scroll-animate">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Transparency and Efficiency of Our Action</h2>
                <div class="green-line"></div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <!-- Card 1: 1958 -->
                <div class="card scroll-animate">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600" alt="1958 History" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                            <h3 class="text-6xl md:text-7xl font-black text-white">1958</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-3">66 years of experience</h4>
                        <p class="text-sm text-gray-600 mb-6">
                            With its wealth of experience, Children of Mekong has relied since 1958 on a network of friends made up of more than 1,000 local volunteers.
                        </p>
                        <a href="learn-more.html" class="inline-block px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold text-sm rounded transition">
                            OUR HISTORY
                        </a>
                    </div>
                </div>

                <!-- Card 2: Mission -->
                <div class="card scroll-animate" style="animation-delay: 0.1s;">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=600" alt="Mission" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-center justify-center">
                            <h3 class="text-5xl md:text-6xl font-black text-white">MISSION</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-3">Providing education and support</h4>
                        <p class="text-sm text-gray-600 mb-6">
                            Educate, train, and support young people so that they can improve their material living conditions and build themselves intellectually, emotionally, and morally.
                        </p>
                        <a href="learn-more.html" class="inline-block px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold text-sm rounded transition">
                            VISION AND ETHICS
                        </a>
                    </div>
                </div>

                <!-- Card 3: 84% -->
                <div class="card scroll-animate" style="animation-delay: 0.2s;">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544027993-37dbfe43562a?w=600" alt="84%" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                            <h3 class="text-6xl md:text-7xl font-black text-white">84%</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-3">Charitable Expenditure</h4>
                        <p class="text-sm text-gray-600 mb-6">
                            84% of the funds raised are dedicated to our education programmes. In Asia, over 95,000 children benefit from our work every year.
                        </p>
                        <a href="#" class="inline-block px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold text-sm rounded transition">
                            LATEST ANNUAL REPORT
                        </a>
                    </div>
                </div>

                <!-- Card 4: Transparency -->
                <div class="card scroll-animate" style="animation-delay: 0.3s;">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1497486751825-1233686d5d80?w=600" alt="Transparency" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-center justify-center">
                            <h3 class="text-4xl md:text-5xl font-black text-white text-center px-4">TRANSPARENCY</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-3">Label renewed in 2024</h4>
                        <p class="text-sm text-gray-600 mb-6">
                            Children of the Mekong was awarded the IDEAS label for good governance, transparency, and monitoring of the effectiveness of its actions in 2011, which was renewed in 2015, 2019 and 2024.
                        </p>
                        <a href="#" class="inline-block px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold text-sm rounded transition">
                            FINANCIAL TRANSPARENCY
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== WHAT WE DO SECTION ========== -->
    <section id="our-work" class="section bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 scroll-animate">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">What We Do</h2>
                <p class="text-base md:text-lg text-gray-600 max-w-3xl mx-auto">
                    We focus on providing education, healthcare, and nutrition to vulnerable children
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">
                <div class="card scroll-animate">
                    <div class="img-hover">
                        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=500" alt="Education" class="w-full h-48 md:h-64 object-cover">
                    </div>
                    <div class="p-4 md:p-6">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-100 rounded-full flex items-center justify-center mb-3 md:mb-4">
                            <i class="fas fa-graduation-cap text-blue-600 text-xl md:text-2xl"></i>
                        </div>
                        <h3 class="text-base md:text-xl font-bold mb-2 md:mb-3 text-gray-800">Education</h3>
                        <p class="text-xs md:text-base text-gray-600 mb-3 md:mb-4">
                            Quality education and school supplies to empower children
                        </p>
                        <a href="learn.html" class="text-orange-500 text-xs md:text-sm font-semibold hover:text-orange-600">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="card scroll-animate" style="animation-delay: 0.2s;">
                    <div class="img-hover">
                        <img src="https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?w=500" alt="Healthcare" class="w-full h-48 md:h-64 object-cover">
                    </div>
                    <div class="p-4 md:p-6">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-green-100 rounded-full flex items-center justify-center mb-3 md:mb-4">
                            <i class="fas fa-heartbeat text-green-600 text-xl md:text-2xl"></i>
                        </div>
                        <h3 class="text-base md:text-xl font-bold mb-2 md:mb-3 text-gray-800">Healthcare</h3>
                        <p class="text-xs md:text-base text-gray-600 mb-3 md:mb-4">
                            Essential medical care and clean water for healthy development
                        </p>
                        <a href="learn.html" class="text-orange-500 text-xs md:text-sm font-semibold hover:text-orange-600">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="card scroll-animate sm:col-span-2 md:col-span-1" style="animation-delay: 0.4s;">
                    <div class="img-hover">
                        <img src="https://images.unsplash.com/photo-1593113598332-cd288d649433?w=500" alt="Nutrition" class="w-full h-48 md:h-64 object-cover">
                    </div>
                    <div class="p-4 md:p-6">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-orange-100 rounded-full flex items-center justify-center mb-3 md:mb-4">
                            <i class="fas fa-utensils text-orange-600 text-xl md:text-2xl"></i>
                        </div>
                        <h3 class="text-base md:text-xl font-bold mb-2 md:mb-3 text-gray-800">Nutrition</h3>
                        <p class="text-xs md:text-base text-gray-600 mb-3 md:mb-4">
                            Nutritious meals to end childhood hunger and malnutrition
                        </p>
                        <a href="learn.html" class="text-orange-500 text-xs md:text-sm font-semibold hover:text-orange-600">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== CHILDREN WAITING TO BE SPONSORED ========== -->
    <section id="sponsor" class="section bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 scroll-animate">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Children Waiting to be Sponsored</h2>
                <p class="text-base md:text-lg text-gray-600">Meet the children who need your support today</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <div class="card scroll-animate">
                    <div class="img-hover">
                        <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=500" alt="Child" class="w-full h-48 md:h-72 object-cover">
                    </div>
                    <div class="p-4 md:p-6">
                        <span class="inline-block bg-orange-100 text-orange-600 text-xs font-semibold px-2 md:px-3 py-1 rounded-full mb-2 md:mb-3">Cambodia</span>
                        <h3 class="text-sm md:text-xl font-bold mb-1 md:mb-2 text-gray-800">Support Children in Slums</h3>
                        <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4">
                            Give hope to children living in poverty
                        </p>
                        <div class="mb-3 md:mb-4">
                            <div class="flex justify-between text-xs md:text-sm mb-2">
                                <span class="text-gray-600">Sponsored</span>
                                <span class="font-semibold text-orange-600">17/18</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" data-progress="94" style="width: 0%"></div>
                            </div>
                        </div>
                        <a href="detail-page.html" class="btn-primary w-full text-center text-xs md:text-base py-2 md:py-3">Sponsor Now</a>
                    </div>
                </div>

                <div class="card scroll-animate" style="animation-delay: 0.2s;">
                    <div class="img-hover">
                        <img src="https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=500" alt="Child" class="w-full h-48 md:h-72 object-cover">
                    </div>
                    <div class="p-4 md:p-6">
                        <span class="inline-block bg-blue-100 text-blue-600 text-xs font-semibold px-2 md:px-3 py-1 rounded-full mb-2 md:mb-3">Myanmar</span>
                        <h3 class="text-sm md:text-xl font-bold mb-1 md:mb-2 text-gray-800">Education in Karen State</h3>
                        <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4">
                            Provide safe housing and education
                        </p>
                        <div class="mb-3 md:mb-4">
                            <div class="flex justify-between text-xs md:text-sm mb-2">
                                <span class="text-gray-600">Sponsored</span>
                                <span class="font-semibold text-orange-600">17/20</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" data-progress="85" style="width: 0%"></div>
                            </div>
                        </div>
                        <a href="detail-page.html" class="btn-primary w-full text-center text-xs md:text-base py-2 md:py-3">Sponsor Now</a>
                    </div>
                </div>

                <div class="card scroll-animate sm:col-span-2 lg:col-span-1" style="animation-delay: 0.4s;">
                    <div class="img-hover">
                        <img src="https://images.unsplash.com/photo-1544027993-37dbfe43562a?w=500" alt="Child" class="w-full h-48 md:h-72 object-cover">
                    </div>
                    <div class="p-4 md:p-6">
                        <span class="inline-block bg-pink-100 text-pink-600 text-xs font-semibold px-2 md:px-3 py-1 rounded-full mb-2 md:mb-3">Vietnam</span>
                        <h3 class="text-sm md:text-xl font-bold mb-1 md:mb-2 text-gray-800">Girls' Education Program</h3>
                        <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4">
                            Support young girls to remain in education
                        </p>
                        <div class="mb-3 md:mb-4">
                            <div class="flex justify-between text-xs md:text-sm mb-2">
                                <span class="text-gray-600">Sponsored</span>
                                <span class="font-semibold text-orange-600">7/15</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" data-progress="46" style="width: 0%"></div>
                            </div>
                        </div>
                        <a href="detail-page.html" class="btn-primary w-full text-center text-xs md:text-base py-2 md:py-3">Sponsor Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SUCCESS STORY ========== -->
    <section class="section bg-gradient-to-br from-orange-50 to-orange-100">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="img-hover rounded-2xl overflow-hidden shadow-xl scroll-animate">
                    <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800" alt="Success Story" class="w-full h-64 md:h-full object-cover">
                </div>
                <div class="scroll-animate" style="animation-delay: 0.2s;">
                    <span class="inline-block bg-orange-500 text-white text-xs md:text-sm font-semibold px-3 md:px-4 py-1 md:py-2 rounded-full mb-3 md:mb-4">
                        SUCCESS STORY
                    </span>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4 md:mb-6">
                        From Dropout to Top Student
                    </h2>
                    <p class="text-base md:text-lg text-gray-700 mb-4 md:mb-6 leading-relaxed">
                        "At age 8, I had never been to school. Today, I'm top of my class and dream of becoming a doctor. Your support changed my life forever!"
                    </p>
                    <div class="space-y-2 md:space-y-3 mb-6 md:mb-8">
                        <div class="flex items-center gap-2 md:gap-3">
                            <i class="fas fa-check-circle text-orange-500 text-lg md:text-xl"></i>
                            <span class="text-sm md:text-base text-gray-700">5 years of quality education</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <i class="fas fa-check-circle text-orange-500 text-lg md:text-xl"></i>
                            <span class="text-sm md:text-base text-gray-700">Daily nutritious meals</span>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <i class="fas fa-check-circle text-orange-500 text-lg md:text-xl"></i>
                            <span class="text-sm md:text-base text-gray-700">Regular health check-ups</span>
                        </div>
                    </div>
                    <a href="learn-more.html" class="btn-primary text-sm md:text-base">Read More Stories</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SPONSOR A CHILD TODAY CTA ========== -->
    <section class="section bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 md:mb-12 scroll-animate">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Sponsor a Child Today and Change a Life!</h2>
                <div class="green-line"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
                <!-- Left Content -->
                <div class="scroll-animate">
                    <p class="text-base md:text-lg text-gray-700 mb-6 leading-relaxed">
                        Access to school can be a real challenge for poor children in Southeast Asia. 
                        <span class="font-bold text-gray-900">Sponsoring a child is a simple and efficient way to help a child to go to school.</span>
                    </p>

                    <p class="text-base md:text-lg text-gray-700 mb-6 leading-relaxed">
                        With your financial support, Children of the Mekong will help 
                        <span class="font-bold text-gray-900">your sponsored child can continue his/her education</span> 
                        without fear of dropping out to go to work. Your letters will also give 
                        <span class="font-bold text-gray-900">great encouragement</span> 
                        to pursue their schooling despite the hardships of their lives.
                    </p>

                    <a href="detail-page.html" class="inline-flex items-center gap-3 px-6 md:px-8 py-3 md:py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold text-sm md:text-base rounded transition shadow-md hover:shadow-lg">
                        <i class="fas fa-child text-xl md:text-2xl"></i>
                        SPONSOR A CHILD TODAY!
                    </a>
                </div>

                <!-- Right Image -->
                <div class="scroll-animate" style="animation-delay: 0.2s;">
                    <div class="rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=800" alt="Happy Child" class="w-full h-auto object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== LATEST NEWS FROM SOUTHEAST ASIA ========== -->
    <section id="news" class="section bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 md:mb-12 scroll-animate">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Latest News from Southeast Asia</h2>
                <div class="green-line"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <!-- Featured Large Article -->
                <div class="md:col-span-2 lg:row-span-2 relative group overflow-hidden rounded-lg shadow-lg scroll-animate">
                    <img src="https://images.unsplash.com/photo-1544776193-352d25ca82cd?w=300" alt="Mrs. Bounmy's Odyssey" class="w-full h-full object-cover min-h-[400px] transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-8">
                        <div class="flex items-center justify-center w-12 h-12 md:w-16 md:h-16 bg-white/20 backdrop-blur-sm rounded-full mb-4 cursor-pointer hover:bg-white/30 transition">
                            <i class="fas fa-play text-white text-lg md:text-2xl ml-1"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-2">Mrs. Bounmy's Odyssey in Laos</h3>
                        <a href="#" class="text-white/90 hover:text-white text-sm md:text-base font-medium inline-flex items-center gap-2">
                            READ MORE <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Article 2 -->
                <div class="relative group overflow-hidden rounded-lg shadow-lg scroll-animate">
                    <img src="https://images.unsplash.com/photo-1516733968668-dbdce39c4651?w=600" alt="Myanmar Border" class="w-full h-64 md:h-full min-h-[250px] object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-4 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-white mb-2">Clandestine Life at the Myanmar Border</h3>
                        <a href="#" class="text-white/90 hover:text-white text-xs md:text-sm font-medium inline-flex items-center gap-2">
                            READ MORE <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Article 3 -->
                <div class="relative group overflow-hidden rounded-lg shadow-lg scroll-animate">
                    <img src="https://images.unsplash.com/photo-1604537529586-cb299c94d6c4?w=600" alt="Sister Marie Catherine" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-4 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-white mb-2">Sister Marie Catherine, A Life for Laos</h3>
                        <a href="#" class="text-white/90 hover:text-white text-xs md:text-sm font-medium inline-flex items-center gap-2">
                            READ MORE <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Article 4 -->
                <div class="relative group overflow-hidden rounded-lg shadow-lg scroll-animate">
                    <img src="https://images.unsplash.com/photo-1583518257225-f9a8081f6a84?w=600" alt="Ethnic Groups" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-4 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-white mb-2">Why Do Ethnic Groups in Southeast Asia Need Help</h3>
                        <a href="#" class="text-white/90 hover:text-white text-xs md:text-sm font-medium inline-flex items-center gap-2">
                            READ MORE <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Article 5 -->
                <div class="relative group overflow-hidden rounded-lg shadow-lg scroll-animate">
                    <img src="https://images.unsplash.com/photo-1559181567-c3190ca9959b?w=600" alt="Cambodian Ballet" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-4 md:p-6">
                        <div class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-white/20 backdrop-blur-sm rounded-full mb-3 cursor-pointer hover:bg-white/30 transition">
                            <i class="fas fa-play text-white text-sm md:text-base ml-1"></i>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-white mb-2">The Perfect Motion: The Royal Cambodian Ballet</h3>
                        <a href="#" class="text-white/90 hover:text-white text-xs md:text-sm font-medium inline-flex items-center gap-2">
                            READ MORE <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Article 6 -->
                <div class="relative group overflow-hidden rounded-lg shadow-lg scroll-animate">
                    <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600" alt="Waray Tribe" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-4 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-white mb-2">People of Samar: The Waray Tribe</h3>
                        <a href="#" class="text-white/90 hover:text-white text-xs md:text-sm font-medium inline-flex items-center gap-2">
                            READ MORE <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Article 7 -->
                <div class="relative group overflow-hidden rounded-lg shadow-lg scroll-animate">
                    <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600" alt="Sponsored Child" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-4 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-white mb-2">Our Meeting with Your Sponsored Child Vichika!</h3>
                        <a href="#" class="text-white/90 hover:text-white text-xs md:text-sm font-medium inline-flex items-center gap-2">
                            READ MORE <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- YouTube Videos Section -->
            <div class="mt-12 md:mt-16 scroll-animate">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Watch Our Impact Stories</h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Video 1 -->
                    <div class="group">
                        <div class="relative overflow-hidden rounded-lg shadow-lg mb-4">
                            <div class="aspect-video">
                                <iframe 
                                    class="w-full h-full" 
                                    src="https://www.youtube.com/embed/E1xkXZs0cAQ?si=87osvLVMot9MzXOE" 
                                    title="Hope & Impact Story" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2 group-hover:text-orange-500 transition">Transforming Lives Through Education</h4>
                        <p class="text-sm text-gray-600">See how your donations are making a real difference in children's lives across Southeast Asia.</p>
                    </div>

                    <!-- Video 2 -->
                    <div class="group">
                        <div class="relative overflow-hidden rounded-lg shadow-lg mb-4">
                            <div class="aspect-video">
                                <iframe 
                                    class="w-full h-full" 
                                    src="https://www.youtube.com/embed/E1xkXZs0cAQ?si=87osvLVMot9MzXOE" 
                                    title="Community Impact" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2 group-hover:text-orange-500 transition">A Day in the Life of a Sponsored Child</h4>
                        <p class="text-sm text-gray-600">Follow Maria through her daily routine and see the impact of child sponsorship.</p>
                    </div>

                    <!-- Video 3 -->
                    <div class="group">
                        <div class="relative overflow-hidden rounded-lg shadow-lg mb-4">
                            <div class="aspect-video">
                                <iframe 
                                    class="w-full h-full" 
                                    src="https://www.youtube.com/embed/E1xkXZs0cAQ?si=87osvLVMot9MzXOE" 
                                    title="Our Programs" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2 group-hover:text-orange-500 transition">Healthcare Programs in Rural Cambodia</h4>
                        <p class="text-sm text-gray-600">Learn about our healthcare initiatives bringing medical care to remote communities.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== NEWSLETTER ========== -->
    <section class="section bg-gray-800 text-white">
        <div class="max-w-4xl mx-auto text-center scroll-animate px-4">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-3 md:mb-4">Stay Connected</h2>
            <p class="text-sm md:text-base lg:text-lg mb-6 md:mb-8 opacity-90">
                Receive impact stories and updates from Southeast Asia
            </p>
            <form class="flex flex-col sm:flex-row gap-3 md:gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Your email address" class="flex-1 px-4 md:px-6 py-3 md:py-4 rounded-full text-sm md:text-base text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500">
                <button type="submit" class="btn-primary whitespace-nowrap text-sm md:text-base py-3 md:py-4">Subscribe</button>
            </form>
        </div>
    </section>

    <!-- ========== FOOTER ========== -->
    @include('layouts.footer')

    <!-- ========== MOBILE BOTTOM NAVIGATION ========== -->
    @include('layouts.navigation')

    <!-- ========== POPUP MODAL ========== -->
    @include('layouts.ads')

    <!-- ========== JAVASCRIPT ========== -->
    <script>
        // ===== LOADING SCREEN =====
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('loader').classList.add('hidden');
                // Show popup after 3 seconds
                setTimeout(() => {
                    document.getElementById('popup-modal').classList.add('active');
                }, 3000);
            }, 1000);
        });

        // ===== POPUP MODAL =====
        const popupModal = document.getElementById('popup-modal');
        const closePopup = document.getElementById('close-popup');
        const remindLater = document.getElementById('remind-later');

        closePopup.addEventListener('click', () => {
            popupModal.classList.remove('active');
        });

        remindLater.addEventListener('click', () => {
            popupModal.classList.remove('active');
        });

        popupModal.addEventListener('click', (e) => {
            if (e.target === popupModal) {
                popupModal.classList.remove('active');
            }
        });

        // ===== MOBILE MENU =====
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const menuNavItem = document.getElementById('menu-nav-item');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
        const closeMenuBtn = document.getElementById('close-menu');
        const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');

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

        mobileMenuBtn.addEventListener('click', openMenu);
        menuNavItem?.addEventListener('click', (e) => {
            e.preventDefault();
            openMenu();
        });
        closeMenuBtn.addEventListener('click', closeMenu);
        mobileMenuOverlay.addEventListener('click', closeMenu);

        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        // ===== BOTTOM NAV ACTIVE STATE =====
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                if (this.id !== 'menu-nav-item') {
                    navItems.forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });

        // ===== SMOOTH SCROLL =====
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = window.innerWidth < 768 ? 70 : 80;
                    const targetPosition = target.offsetTop - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // ===== SCROLL ANIMATIONS =====
        const scrollElements = document.querySelectorAll('.scroll-animate');
        
        const elementInView = (el, offset = 100) => {
            const elementTop = el.getBoundingClientRect().top;
            return (
                elementTop <= (window.innerHeight || document.documentElement.clientHeight) - offset
            );
        };

        const displayScrollElement = (element) => {
            element.classList.add('show');
        };

        const handleScrollAnimation = () => {
            scrollElements.forEach((el) => {
                if (elementInView(el, 100)) {
                    displayScrollElement(el);
                }
            });
        };

        window.addEventListener('scroll', handleScrollAnimation);
        handleScrollAnimation();

        // ===== COUNTER ANIMATION =====
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        const animateCounter = (counter) => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(() => animateCounter(counter), 1);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => counterObserver.observe(counter));

        // ===== PROGRESS BAR ANIMATION =====
        const progressBars = document.querySelectorAll('.progress-fill');
        
        const progressObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const progress = entry.target.getAttribute('data-progress');
                    setTimeout(() => {
                        entry.target.style.width = progress + '%';
                    }, 200);
                    progressObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        progressBars.forEach(bar => progressObserver.observe(bar));
    </script>
</body>
</html>