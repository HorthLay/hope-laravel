<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $settings['site_name'] ?? 'Hope & Impact' }} | Changing Children's Lives</title>
     <meta name="description" content="{{ $settings['meta_description'] ?? $settings['site_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '' }}">
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    <meta name="description" content="Help transform children's lives through education, healthcare, and nutrition in Southeast Asia.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Hanuman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
    <style>
        /* CSS Variables for Consistency */
        :root {
            --primary-color: #e67e22;
            --secondary-color: #f5c518;
            --text-dark: #374151;
            --text-light: #f9fafb;
        }

        /* Tag filter buttons */
        .news-tag-btn, .top-tag-btn {
            transition: all .18s ease;
        }
        .news-tag-btn.opacity-60, .top-tag-btn.opacity-60 {
            opacity: .55;
        }
        .news-tag-btn.active-tag-btn,
        .top-tag-btn.active-tag-btn {
            background: var(--secondary-color) !important;
            color: #fff !important;
            border-color: var(--secondary-color) !important;
            opacity: 1 !important;
            box-shadow: 0 2px 10px rgba(249,115,22,.35);
        }

        /* Smooth hide/show for filtered cards */
        .news-card, .top-card {
            transition: opacity .2s ease;
        }

        /* Category filter buttons */
        .news-cat-btn {
            transition: all .18s ease;
        }
        .news-cat-btn.opacity-60 {
            opacity: .55;
        }
        .news-cat-btn.active-cat-btn {
            background: var(--secondary-color) !important;
            color: #fff !important;
            border-color: var(--secondary-color) !important;
            opacity: 1 !important;
            box-shadow: 0 2px 10px rgba(249,115,22,.35);
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 20px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary-color);
        }
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }
        .timeline-dot {
            position: absolute;
            left: -26px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary-color);
        }

        /* Team Card Hover */
        .team-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Accordion */
        .accordion-header {
            cursor: pointer;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s ease;
        }
        .accordion-header:hover {
            background-color: #f9fafb;
        }
        .accordion-icon {
            transition: transform 0.2s ease;
        }
        .accordion-header.active .accordion-icon {
            transform: rotate(180deg);
        }

        /* Hero Section */
        .hero-about {
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
        }
        .hero-about::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }
        .hero-about > div {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>

@include('layouts.loading')
@include('layouts.header')

<!-- Hero Section -->
<section class="hero-about" style="background-image: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1600');">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in-up">Our Story</h1>
        <p class="text-xl md:text-2xl mb-6 opacity-90 animate-fade-in-up delay-200">Empowering children and transforming communities since 1958</p>
        <div class="flex flex-wrap justify-center gap-4 animate-fade-in-up delay-400">
            <a href="#mission" class="btn-secondary">Learn Our Mission</a>
            <a href="#contact" class="btn-primary" style="background: white; color: var(--primary-color);">Get in Touch</a>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section id="mission" class="section bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
            <div class="animate-fade-in-left">
                <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800" alt="Our Mission" class="rounded-2xl shadow-2xl">
            </div>
            <div class="animate-fade-in-right">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 md:mb-6">Our Mission</h2>
                <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-4 md:mb-6">
                    At Hope & Impact, we believe every child deserves access to quality education, healthcare, and the opportunity to reach their full potential. Since 1958, we've been working tirelessly to break the cycle of poverty and create lasting change in vulnerable communities across Southeast Asia.
                </p>
                <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-4 md:mb-6">
                    Our holistic approach addresses not just immediate needs, but creates sustainable solutions that empower entire families and communities to build better futures.
                </p>
                <div class="flex flex-col sm:flex-row flex-wrap gap-3 md:gap-4">
                    <a href="donate-page.html" class="btn-primary text-center">Support Our Mission</a>
                    <a href="#programs" class="btn-secondary text-center" style="color: var(--primary-color); border-color: var(--primary-color);">Our Programs</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section" style="background: linear-gradient(135deg, var(--primary-color) 0%, #d35400 100%); color: white;">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 md:mb-12 animate-fade-in-up">Our Impact in Numbers</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
            <div class="stat-box scroll-animate text-center">
                <div class="text-4xl mb-2"><i class="fas fa-child"></i></div>
                <div class="stat-number counter text-4xl font-bold" data-target="50000">0</div>
                <p class="text-sm md:text-lg font-semibold">Children Sponsored</p>
            </div>
            <div class="stat-box scroll-animate text-center delay-200">
                <div class="text-4xl mb-2"><i class="fas fa-globe"></i></div>
                <div class="stat-number counter text-4xl font-bold" data-target="15">0</div>
                <p class="text-sm md:text-lg font-semibold">Countries Served</p>
            </div>
            <div class="stat-box scroll-animate text-center delay-400">
                <div class="text-4xl mb-2"><i class="fas fa-users"></i></div>
                <div class="stat-number counter text-4xl font-bold" data-target="850">0</div>
                <p class="text-sm md:text-lg font-semibold">Communities Transformed</p>
            </div>
            <div class="stat-box scroll-animate text-center delay-600">
                <div class="text-4xl mb-2"><i class="fas fa-calendar-alt"></i></div>
                <div class="stat-number counter text-4xl font-bold" data-target="65">0</div>
                <p class="text-sm md:text-lg font-semibold">Years of Service</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="section bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-4 animate-fade-in-up">Our Core Values</h2>
        <p class="text-lg md:text-xl text-gray-600 text-center mb-8 md:mb-12 animate-fade-in-up delay-200">The principles that guide everything we do</p>
        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="card scroll-animate">
                <div class="value-card p-6 text-center">
                    <div class="value-icon w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-xl text-orange-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Compassion</h3>
                    <p class="text-gray-600 text-sm">We approach every child and family with empathy, dignity, and respect.</p>
                </div>
            </div>
            <div class="card scroll-animate delay-200">
                <div class="value-card p-6 text-center">
                    <div class="value-icon w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-xl text-orange-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Integrity</h3>
                    <p class="text-gray-600 text-sm">We maintain the highest standards of honesty and transparency in all we do.</p>
                </div>
            </div>
            <div class="card scroll-animate delay-400">
                <div class="value-card p-6 text-center">
                    <div class="value-icon w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-xl text-orange-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Partnership</h3>
                    <p class="text-gray-600 text-sm">We work alongside communities, empowering them to create their own solutions.</p>
                </div>
            </div>
            <div class="card scroll-animate delay-600">
                <div class="value-card p-6 text-center">
                    <div class="value-icon w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-xl text-orange-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Excellence</h3>
                    <p class="text-gray-600 text-sm">We strive for the highest quality in our programs and sustainable impact.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our History Timeline -->
<section class="section">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 text-center mb-3 md:mb-4 animate-fade-in-up">Our Journey</h2>
        <p class="text-base md:text-lg lg:text-xl text-gray-600 text-center mb-8 md:mb-12 animate-fade-in-up delay-200">65+ years of making a difference</p>
        <div class="timeline">
            <div class="timeline-item scroll-animate">
                <div class="timeline-dot"></div>
                <div class="card">
                    <div class="p-6">
                        <span class="text-orange-500 font-bold text-sm">1958</span>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">The Beginning</h3>
                        <p class="text-gray-600">Founded by missionary Dr. Robert Pierce after witnessing the dire conditions of orphaned children in Southeast Asia following the Korean War.</p>
                    </div>
                </div>
            </div>
            <div class="timeline-item scroll-animate">
                <div class="timeline-dot"></div>
                <div class="card">
                    <div class="p-6">
                        <span class="text-orange-500 font-bold text-sm">1970s</span>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Expansion</h3>
                        <p class="text-gray-600">Expanded operations to include education programs, building our first schools and establishing child sponsorship programs.</p>
                    </div>
                </div>
            </div>
            <div class="timeline-item scroll-animate">
                <div class="timeline-dot"></div>
                <div class="card">
                    <div class="p-6">
                        <span class="text-orange-500 font-bold text-sm">1990s</span>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Healthcare Initiative</h3>
                        <p class="text-gray-600">Launched comprehensive healthcare programs, opening medical clinics in underserved rural communities.</p>
                    </div>
                </div>
            </div>
            <div class="timeline-item scroll-animate">
                <div class="timeline-dot"></div>
                <div class="card">
                    <div class="p-6">
                        <span class="text-orange-500 font-bold text-sm">2010</span>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Regional Impact</h3>
                        <p class="text-gray-600">Reached milestone of serving 15 countries and sponsoring over 30,000 children annually across Southeast Asia.</p>
                    </div>
                </div>
            </div>
            <div class="timeline-item scroll-animate">
                <div class="timeline-dot"></div>
                <div class="card">
                    <div class="p-6">
                        <span class="text-orange-500 font-bold text-sm">2024</span>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Today & Beyond</h3>
                        <p class="text-gray-600">Continuing to innovate and expand, now serving over 50,000 children with holistic community development programs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Team -->
<section class="section bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-4 animate-fade-in-up">Our Leadership</h2>
        <p class="text-lg md:text-xl text-gray-600 text-center mb-8 md:mb-12 animate-fade-in-up delay-200">Dedicated individuals committed to our mission</p>
        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            <div class="card team-card scroll-animate">
                <div class="p-6 text-center">
                    <div class="team-image w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=300" alt="CEO" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1">David Thompson</h3>
                    <p class="text-orange-500 text-sm font-semibold mb-3">CEO & President</p>
                    <p class="text-gray-600 text-sm">25+ years in nonprofit leadership, passionate about sustainable community development.</p>
                </div>
            </div>
            <div class="card team-card scroll-animate delay-200">
                <div class="p-6 text-center">
                    <div class="team-image w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300" alt="Programs Director" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Sarah Chen</h3>
                    <p class="text-orange-500 text-sm font-semibold mb-3">Director of Programs</p>
                    <p class="text-gray-600 text-sm">Expert in child development with a PhD in International Education Policy.</p>
                </div>
            </div>
            <div class="card team-card scroll-animate delay-400">
                <div class="p6 text-center">
                    <div class="team-image w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=300" alt="Operations Director" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Michael Rodriguez</h3>
                    <p class="text-orange-500 text-sm font-semibold mb-3">Director of Operations</p>
                    <p class="text-gray-600 text-sm">Operations specialist ensuring efficient resource allocation and program delivery.</p>
                </div>
            </div>
            <div class="card team-card scroll-animate delay-600">
                <div class="p-6 text-center">
                    <div class="team-image w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=300" alt="Development Director" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Emily Watson</h3>
                    <p class="text-orange-500 text-sm font-semibold mb-3">Director of Development</p>
                    <p class="text-gray-600 text-sm">Fundraising expert building lasting relationships with donors and partners.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Section -->
<section class="section parallax" style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1600');">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white text-center mb-3 md:mb-4 animate-fade-in-up">See Our Impact</h2>
        <p class="text-base md:text-lg lg:text-xl text-white text-center mb-6 md:mb-8 opacity-90 animate-fade-in-up delay-200">Watch how your support transforms lives</p>
        <div class="video-container scroll-animate delay-400">
            <iframe src="https://www.youtube.com/embed/E1xkXZs0cAQ?si=87osvLVMot9MzXOE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full aspect-video"></iframe>
        </div>
    </div>
</section>

<!-- Programs Section -->
<section id="programs" class="section bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-4 animate-fade-in-up">Our Programs</h2>
        <p class="text-lg md:text-xl text-gray-600 text-center mb-8 md:mb-12 animate-fade-in-up delay-200">Comprehensive solutions for lasting change</p>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">
            <div class="card scroll-animate">
                <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=600" alt="Education" class="w-full h-48 object-cover" loading="lazy">
                <div class="p-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-graduation-cap text-orange-500 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Education</h3>
                    <p class="text-gray-600 mb-4">Quality education programs including school construction, teacher training, and scholarship programs.</p>
                </div>
            </div>
            <div class="card scroll-animate delay-200">
                <img src="https://images.unsplash.com/photo-1576765607924-3f7b8410a787?w=600" alt="Healthcare" class="w-full h-48 object-cover" loading="lazy">
                <div class="p-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-heartbeat text-orange-500 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Healthcare</h3>
                    <p class="text-gray-600 mb-4">Medical clinics, health education, vaccination programs, and maternal care services.</p>
                  
                </div>
            </div>
            <div class="card scroll-animate delay-400">
                <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600" alt="Nutrition" class="w-full h-48 object-cover" loading="lazy">
                <div class="p-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-utensils text-orange-500 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Nutrition</h3>
                    <p class="text-gray-600 mb-4">Meal programs, nutrition education, and support for sustainable food security.</p>
                  
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 text-center mb-3 md:mb-4 animate-fade-in-up">Frequently Asked Questions</h2>
        <p class="text-base md:text-lg lg:text-xl text-gray-600 text-center mb-8 md:mb-12 animate-fade-in-up delay-200">Everything you need to know</p>
        <div class="space-y-4">
            <div class="accordion-item scroll-animate">
                <div class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false" role="button">
                    <h3 class="font-bold text-gray-800">How does child sponsorship work?</h3>
                    <i class="fas fa-chevron-down text-orange-500 accordion-icon"></i>
                </div>
                <div class="accordion-content" style="display: none;">
                    <div class="accordion-body p-4">
                        <p class="text-gray-600">When you sponsor a child, your monthly donation provides them with access to education, healthcare, nutrition, and mentorship. You'll receive regular updates, photos, and letters from your sponsored child, and can write to them as well. Your support also benefits their entire community through our holistic development approach.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item scroll-animate">
                <div class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false" role="button">
                    <h3 class="font-bold text-gray-800">Where does my donation go?</h3>
                    <i class="fas fa-chevron-down text-orange-500 accordion-icon"></i>
                </div>
                <div class="accordion-content" style="display: none;">
                    <div class="accordion-body p-4">
                        <p class="text-gray-600">90% of all donations go directly to our programs. The remaining 10% covers essential administrative costs and fundraising. We're committed to transparency and publish detailed financial reports annually, which are available on our website.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item scroll-animate">
                <div class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false" role="button">
                    <h3 class="font-bold text-gray-800">Can I visit my sponsored child?</h3>
                    <i class="fas fa-chevron-down text-orange-500 accordion-icon"></i>
                </div>
                <div class="accordion-content" style="display: none;">
                    <div class="accordion-body p-4">
                        <p class="text-gray-600">Yes! We encourage sponsors to visit their sponsored children when possible. We'll help coordinate your visit with advance notice, ensuring it's a meaningful experience for both you and the child while respecting local customs and the child's schedule.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item scroll-animate">
                <div class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false" role="button">
                    <h3 class="font-bold text-gray-800">How do you measure impact?</h3>
                    <i class="fas fa-chevron-down text-orange-500 accordion-icon"></i>
                </div>
                <div class="accordion-content" style="display: none;">
                    <div class="accordion-body p-4">
                        <p class="text-gray-600">We use comprehensive monitoring and evaluation systems to track outcomes across education, health, and economic indicators. We conduct regular assessments, gather community feedback, and work with third-party evaluators to ensure our programs are effective and continuously improving.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item scroll-animate">
                <div class="accordion-header" onclick="toggleAccordion(this)" aria-expanded="false" role="button">
                    <h3 class="font-bold text-gray-800">How can I get involved besides donating?</h3>
                    <i class="fas fa-chevron-down text-orange-500 accordion-icon"></i>
                </div>
                <div class="accordion-content" style="display: none;">
                    <div class="accordion-body p-4">
                        <p class="text-gray-600">There are many ways to support our mission! You can volunteer locally or internationally, advocate for children's rights, organize fundraising events, spread awareness on social media, or use your professional skills to help (we need lawyers, accountants, marketers, and more!).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@include('layouts.footer')
@include('layouts.navigation')

<script>
    // Loader and Popup
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.getElementById('loader')?.classList.add('hidden');
            setTimeout(() => document.getElementById('popup-modal')?.classList.add('active'), 3000);
        }, 1000);
    });

    // Popup Close
    const popup = document.getElementById('popup-modal');
    document.getElementById('close-popup')?.addEventListener('click', () => popup?.classList.remove('active'));
    document.getElementById('remind-later')?.addEventListener('click', () => popup?.classList.remove('active'));
    popup?.addEventListener('click', (e) => {
        if (e.target === popup) popup.classList.remove('active');
    });

    // Mobile Menu
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const openMenu = () => {
        mobileMenu?.classList.add('active');
        mobileMenuOverlay?.classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    const closeMenu = () => {
        mobileMenu?.classList.remove('active');
        mobileMenuOverlay?.classList.remove('active');
        document.body.style.overflow = '';
    };
    document.getElementById('mobile-menu-btn')?.addEventListener('click', openMenu);
    document.getElementById('menu-nav-item')?.addEventListener('click', (e) => {
        e.preventDefault();
        openMenu();
    });
    document.getElementById('close-menu')?.addEventListener('click', closeMenu);
    mobileMenuOverlay?.addEventListener('click', closeMenu);
    document.querySelectorAll('.mobile-menu-link').forEach(l => l.addEventListener('click', closeMenu));

    // Nav Active State
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function() {
            if (this.id !== 'menu-nav-item') {
                document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - (window.innerWidth < 768 ? 70 : 80),
                    behavior: 'smooth'
                });
            }
        });
    });

    // Scroll Animations
    const checkScroll = () => {
        document.querySelectorAll('.scroll-animate').forEach(el => {
            if (el.getBoundingClientRect().top <= (window.innerHeight || document.documentElement.clientHeight) - 80) {
                el.classList.add('show');
            }
        });
    };
    window.addEventListener('scroll', checkScroll);
    checkScroll();

    // Counter Animation
    document.querySelectorAll('.counter').forEach(el => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const target = +el.getAttribute('data-target');
                const step = Math.max(1, Math.ceil(target / 200));
                let current = 0;
                const tick = () => {
                    current = Math.min(current + step, target);
                    el.innerText = current.toLocaleString();
                    if (current < target) setTimeout(tick, 5);
                };
                tick();
                observer.unobserve(el);
            });
        }, { threshold: 0.5 });
        observer.observe(el);
    });

    // Accordion
    function toggleAccordion(header) {
        const content = header.nextElementSibling;
        const isActive = header.classList.contains('active');
        document.querySelectorAll('.accordion-header').forEach(h => {
            h.classList.remove('active');
            h.nextElementSibling.style.display = 'none';
        });
        if (!isActive) {
            header.classList.add('active');
            content.style.display = 'block';
        }
    }

    // Category filter — Latest News
    function filterNewsCat(catId, btn) {
        document.querySelectorAll('.news-cat-btn').forEach(b => {
            b.classList.remove('active-cat-btn', 'bg-orange-500', 'text-white');
            b.style.backgroundColor = '';
            b.style.color = b.dataset.catId ? b.style.borderColor || '#f97316' : '';
            b.classList.add('opacity-60');
        });
        btn.classList.add('active-cat-btn', 'bg-orange-500', 'text-white');
        btn.style.backgroundColor = '#f97316';
        btn.style.color = '#fff';
        btn.classList.remove('opacity-60');

        const cards = document.querySelectorAll('.news-card');
        let shown = 0;
        const hero = document.querySelector('#news-grid .news-card:first-child');

        cards.forEach(card => {
            const match = catId === 'all' || card.dataset.catId == catId;
            card.style.display = match ? '' : 'none';
            if (match) shown++;
        });

        if (hero) {
            hero.classList.toggle('md:col-span-2', catId === 'all');
            hero.classList.toggle('lg:row-span-2', catId === 'all');
        }

        document.getElementById('news-no-results').classList.toggle('hidden', shown > 0);
        document.getElementById('news-grid').classList.toggle('hidden', shown === 0);
    }

    // Tag filter — Most Read
    function filterTopTag(tagId, btn) {
        document.querySelectorAll('.top-tag-btn').forEach(b => {
            b.classList.remove('active-tag-btn', 'bg-orange-500', 'text-white');
            b.classList.add('opacity-60');
        });
        btn.classList.add('active-tag-btn', 'bg-orange-500', '!text-white');
        btn.classList.remove('opacity-60');

        const cards = document.querySelectorAll('.top-card');
        let shown = 0;

        cards.forEach(card => {
            const ids = card.dataset.tagIds ? card.dataset.tagIds.split(',').map(Number) : [];
            const match = tagId === 'all' || ids.includes(Number(tagId));
            card.style.display = match ? '' : 'none';
            if (match) shown++;
        });

        document.getElementById('top-no-results').classList.toggle('hidden', shown > 0);
        document.getElementById('top-grid').classList.toggle('hidden', shown === 0);
    }
</script>
</body>
</html>
