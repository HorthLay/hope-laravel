{{-- resources/views/sponsor/index.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Histoire - Parrainage | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
    <meta name="description" content="{{ $settings['meta_description'] ?? $settings['site_description'] ?? '' }}">
    
    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @include('css.style')
    
    <style>
        body { font-family: 'Inter', sans-serif; }

        .story-wrapper {
            position: relative;
            min-height: calc(100dvh - 140px);
            display: flex;
            flex-direction: column;
            overflow: visible;
        }

        .scene {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1.25rem 7rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 1s ease-in-out;
            overflow-y: auto;
        }

        .scene.active {
            opacity: 1;
            pointer-events: auto;
        }

        .scene-inner {
            width: 100%;
            max-width: 48rem;
            text-align: center;
        }

        .nav-buttons {
            position: absolute;
            bottom: 1.25rem;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.75rem;
            z-index: 10;
            padding: 0 1rem;
        }

        /* ── Progress dots ── */
        .progress-dots {
            position: absolute;
            bottom: 5.25rem;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            z-index: 10;
            padding: 0 1rem;
            overflow: visible;
        }

        .dot {
            height: 8px;
            width: 8px;
            min-width: 8px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.35);
            transition: background 0.4s ease, width 0.4s ease, min-width 0.4s ease;
            flex-shrink: 0;
        }

        .dot.active {
            background: #fff;
            width: 28px;
            min-width: 28px;
        }

        /* ── Background slider ── */
        .bg-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 2s ease-in-out;
        }

        .bg-slide.active {
            opacity: 1;
        }

        /* ── Sound toggle button ── */
        .sound-btn {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 20;
            width: 40px;
            height: 40px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.25s, transform 0.2s;
            color: white;
            font-size: 14px;
        }

        .sound-btn:hover {
            background: rgba(255, 255, 255, 0.28);
            transform: scale(1.08);
        }

        /* ── Soundwave bars animation ── */
        .soundwave {
            display: flex;
            align-items: center;
            gap: 2px;
            height: 16px;
        }

        .soundwave span {
            display: block;
            width: 3px;
            border-radius: 2px;
            background: white;
            animation: wave 0.8s ease-in-out infinite;
            transform-origin: bottom;
        }

        .soundwave span:nth-child(1) { height: 6px;  animation-delay: 0s;    }
        .soundwave span:nth-child(2) { height: 14px; animation-delay: 0.15s; }
        .soundwave span:nth-child(3) { height: 10px; animation-delay: 0.3s;  }
        .soundwave span:nth-child(4) { height: 14px; animation-delay: 0.45s; }
        .soundwave span:nth-child(5) { height: 6px;  animation-delay: 0.6s;  }

        @keyframes wave {
            0%, 100% { transform: scaleY(1);   }
            50%       { transform: scaleY(0.3); }
        }

        .soundwave.paused span {
            animation-play-state: paused;
            transform: scaleY(0.3);
        }

        /* ── Autoplay nudge toast ── */
        .autoplay-toast {
            position: absolute;
            top: 1.25rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            font-size: 12px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .autoplay-toast.show {
            opacity: 1;
        }

        /* ── Mobile typography ── */
        @media (max-width: 480px) {
            .scene-h1-lg { font-size: 1.75rem; line-height: 1.2; }
            .scene-h1-md { font-size: 1.5rem;  line-height: 1.2; }
            .scene-p     { font-size: 0.9rem;  line-height: 1.75; }
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

@include('layouts.header')

{{-- Hidden audio element --}}
<audio id="bg-music" loop preload="auto">
    <source src="{{ asset('music/sound-1.mp3') }}" type="audio/mpeg">
</audio>

<main class="flex-grow relative text-white">
    <!-- Background Image Slider -->
    <div id="bg-slider" class="absolute inset-0 z-0 overflow-hidden bg-black"></div>
    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-black/55 z-0"></div>

    <div class="story-wrapper max-w-5xl mx-auto w-full relative z-10">

        <!-- ══ SOUND TOGGLE ══ -->
        <button class="sound-btn" id="sound-btn" onclick="toggleSound()" title="Toggle music">
            <div class="soundwave paused" id="soundwave">
                <span></span><span></span><span></span><span></span><span></span>
            </div>
        </button>

        <!-- ══ AUTOPLAY TOAST ══ -->
        <div class="autoplay-toast" id="autoplay-toast">
            <i class="fas fa-music text-orange-300"></i>
            <span id="toast-text" data-fr="Appuyez pour activer la musique" data-en="Tap to enable music" data-km="ចុចដើម្បីបើកតន្ត្រី">
                Appuyez pour activer la musique
            </span>
        </div>

        <!-- ══ SCENE 1 ══ -->
        <div class="scene active">
            <div class="scene-inner">
                <h1 class="scene-h1-lg text-3xl md:text-5xl lg:text-6xl font-black mb-5 leading-tight drop-shadow-sm"
                    data-fr="Il existe des histoires qui avancent doucement"
                    data-en="There are stories that move forward slowly"
                    data-km="មានរឿងរ៉ាវដែលឈានទៅមុខយ៉ាងយឺតៗ">
                    Il existe des histoires qui avancent doucement
                </h1>
                <p class="scene-p text-sm md:text-xl lg:text-2xl font-medium leading-relaxed opacity-90"
                   data-fr="Des vies discrètes.<br>Qui grandissent sans bruit.<br><br>Mais qui avancent malgré tout."
                   data-en="Quiet lives.<br>Growing without noise.<br><br>But moving forward nonetheless."
                   data-km="ជីវិតស្ងៀមស្ងាត់។<br>លូតលាស់ដោយគ្មានសំឡេង។<br><br>តែនៅតែបន្តដំណើរទៅមុខ។">
                    Des vies discrètes.<br>Qui grandissent sans bruit.<br><br>Mais qui avancent malgré tout.
                </p>
            </div>
        </div>

        <!-- ══ SCENE 2 ══ -->
        <div class="scene">
            <div class="scene-inner">
                <p class="scene-p text-sm md:text-xl lg:text-2xl font-medium leading-relaxed opacity-90 mb-5"
                   data-fr="Certaines de ces histoires restent invisibles.<br><br>Pourtant, elles cherchent déjà quelque chose."
                   data-en="Some of these stories remain invisible.<br><br>Yet, they are already looking for something."
                   data-km="រឿងខ្លះនៅតែមើលមិនឃើញ។<br><br>ប៉ុន្តែពួកវាបាននឹងកំពុងស្វែងរកអ្វីមួយរួចហើយ។">
                    Certaines de ces histoires restent invisibles.<br><br>
                    Pourtant, elles cherchent déjà quelque chose.
                </p>
                <h1 class="scene-h1-md text-3xl md:text-6xl font-black leading-tight drop-shadow-sm"
                    data-fr="Une présence."
                    data-en="A presence."
                    data-km="វត្តមានមួយ។">
                    Une présence.
                </h1>
            </div>
        </div>

        <!-- ══ SCENE 3 ══ -->
        <div class="scene">
            <div class="scene-inner">
                <h1 class="scene-h1-md text-2xl md:text-5xl font-black mb-5 leading-tight drop-shadow-sm"
                    data-fr="Un chemin approche"
                    data-en="A path approaches"
                    data-km="ផ្លូវមួយកំពុងមកដល់">
                    Un chemin approche
                </h1>
                <p class="scene-p text-xs md:text-lg lg:text-xl font-medium leading-relaxed opacity-90"
                   data-fr="Un enfant grandit.<br><br>Chaque jour.<br>Avec patience.<br>Avec simplicité.<br><br>Il apprend à comprendre le monde autour de lui.<br><br>Et sans le dire.<br>Il attend.<br><br>Quelqu'un.<br>Une présence stable.<br>Une main qui ne disparaît pas.<br><br>Ce moment n'est pas encore arrivé.<br><br>Mais il approche."
                   data-en="A child grows.<br><br>Every day.<br>With patience.<br>With simplicity.<br><br>Learning to understand the world around them.<br><br>And without saying it.<br>Waiting.<br><br>For someone.<br>A stable presence.<br>A hand that does not disappear.<br><br>This moment has not yet arrived.<br><br>But it is approaching."
                   data-km="ក្មេងម្នាក់ធំធាត់។<br><br>រៀងរាល់ថ្ងៃ។<br>ដោយភាពអត់ធ្មត់។<br>ដោយភាពសាមញ្ញ។<br><br>រៀនយល់ពីពិភពលោកជុំវិញខ្លួន។<br><br>ហើយដោយមិននិយាយ។<br>រង់ចាំ។<br><br>នរណាម្នាក់។<br>វត្តមានដ៏រឹងមាំមួយ។<br>ដៃមួយដែលមិនបាត់បង់។<br><br>ពេលវេលានេះមិនទាន់មកដល់ទេ។<br><br>ប៉ុន្តែវាកំពុងខិតចូលមក។">
                    Un enfant grandit.<br><br>
                    Chaque jour.<br>Avec patience.<br>Avec simplicité.<br><br>
                    Il apprend à comprendre le monde autour de lui.<br><br>
                    Et sans le dire.<br>Il attend.<br><br>
                    Quelqu'un.<br>Une présence stable.<br>Une main qui ne disparaît pas.<br><br>
                    Ce moment n'est pas encore arrivé.<br><br>Mais il approche.
                </p>
            </div>
        </div>

        <!-- ══ SCENE 4 ══ -->
        <div class="scene">
            <div class="scene-inner">
                <p class="scene-p text-sm md:text-xl lg:text-2xl font-medium leading-relaxed opacity-90 mb-5"
                   data-fr="Bientôt.<br><br>Deux chemins vont se rencontrer."
                   data-en="Soon.<br><br>Two paths will meet."
                   data-km="ឆាប់ៗនេះ។<br><br>ផ្លូវពីរនឹងជួបគ្នា។">
                    Bientôt.<br><br>Deux chemins vont se rencontrer.
                </p>
                <h1 class="scene-h1-md text-3xl md:text-6xl font-black leading-tight drop-shadow-sm"
                    data-fr="Le vôtre. Et le sien."
                    data-en="Yours. And theirs."
                    data-km="ផ្លូវរបស់អ្នក។ និងផ្លូវរបស់គេ។">
                    Le vôtre. Et le sien.
                </h1>
            </div>
        </div>

        <!-- ══ SCENE 5 ══ -->
        <div class="scene">
            <div class="scene-inner">
                <p class="scene-p text-sm md:text-xl lg:text-2xl font-medium leading-relaxed opacity-90"
                   data-fr="Ce lien ne transforme pas tout immédiatement.<br><br>Mais il change la manière dont un enfant traverse ses jours."
                   data-en="This bond does not transform everything immediately.<br><br>But it changes the way a child goes through their days."
                   data-km="ចំណងនេះមិនអាចផ្លាស់ប្តូរអ្វីៗភ្លាមៗនោះទេ។<br><br>ប៉ុន្តែវាផ្លាស់ប្តូររបៀបដែលក្មេងម្នាក់ឆ្លងកាត់ជីវិតប្រចាំថ្ងៃរបស់គេ។">
                    Ce lien ne transforme pas tout immédiatement.<br><br>
                    Mais il change la manière dont un enfant traverse ses jours.
                </p>
            </div>
        </div>

        <!-- ══ SCENE 6 ══ -->
        <div class="scene">
            <div class="scene-inner">
                <h1 class="scene-h1-lg text-4xl md:text-6xl font-black mb-5 leading-tight drop-shadow-sm"
                    data-fr="Merci"
                    data-en="Thank you"
                    data-km="សូមអរគុណ">
                    Merci
                </h1>
                <p class="scene-p text-sm md:text-xl lg:text-2xl font-medium leading-relaxed opacity-90"
                   data-fr="Une histoire vient de commencer.<br><br>Sans bruit.<br>Mais déjà réelle."
                   data-en="A story has just begun.<br><br>Without noise.<br>But already real."
                   data-km="រឿងមួយទើបតែចាប់ផ្តើម។<br><br>ដោយគ្មានសំឡេង។<br>ប៉ុន្តែក្លាយជាការពិតរួចទៅហើយ។">
                    Une histoire vient de commencer.<br><br>
                    Sans bruit.<br>Mais déjà réelle.
                </p>
            </div>
        </div>

        <!-- ══ PROGRESS DOTS ══ -->
        <div class="progress-dots" id="progress-dots"></div>

        <!-- ══ NAV BUTTONS ══ -->
        <div class="nav-buttons">
            <button onclick="prev()"
                class="px-4 md:px-6 py-2.5 md:py-3 bg-white/20 hover:bg-white/30 text-white font-bold rounded-full backdrop-blur-sm border border-white/40 transition flex items-center gap-2 text-sm md:text-base">
                <i class="fas fa-arrow-left text-xs md:text-sm"></i>
                <span class="hidden sm:inline" id="prev-text"
                      data-fr="Précédent" data-en="Previous" data-km="ត្រឡប់ក្រោយ">Précédent</span>
            </button>
            <button onclick="next()" id="next-btn"
                class="px-4 md:px-6 py-2.5 md:py-3 bg-white text-orange-500 hover:bg-gray-100 font-bold rounded-full shadow-lg transition flex items-center gap-2 text-sm md:text-base">
                <span id="next-text"
                      data-fr="Continuer" data-en="Continue" data-km="បន្តទៀត">Continuer</span>
                <i class="fas fa-arrow-right text-xs md:text-sm" id="next-icon"></i>
            </button>
        </div>

    </div>
</main>

@include('layouts.footer')
@include('layouts.navigation')

<script>
    let current = 0;
    const scenes    = document.querySelectorAll(".scene");
    const nextText  = document.getElementById("next-text");
    const nextIcon  = document.getElementById("next-icon");
    const dotsWrap  = document.getElementById("progress-dots");
    const music     = document.getElementById("bg-music");
    const soundwave = document.getElementById("soundwave");
    const toast     = document.getElementById("autoplay-toast");
    let   isPlaying = false;

    /* ── Language helper ── */
    function getLang() {
        const htmlLang = document.documentElement.lang.split('-')[0];
        return ['fr', 'en', 'km'].includes(htmlLang) ? htmlLang : 'fr';
    }

    function translateApp() {
        const lang = getLang();
        document.querySelectorAll('[data-fr]').forEach(el => {
            if (el.hasAttribute('data-' + lang)) {
                el.innerHTML = el.getAttribute('data-' + lang);
            }
        });
    }

    /* ── Sound toggle ── */
    function toggleSound() {
        if (isPlaying) {
            music.pause();
            isPlaying = false;
            soundwave.classList.add('paused');
        } else {
            music.volume = 0.45;
            music.play().then(() => {
                isPlaying = true;
                soundwave.classList.remove('paused');
                hideToast();
            }).catch(() => {
                // Autoplay still blocked — user must interact again
            });
        }
    }

    /* ── Toast helpers ── */
    function showToast() {
        translateApp(); // ensure toast text is translated
        toast.classList.add('show');
    }

    function hideToast() {
        toast.classList.remove('show');
    }

    /* ── Attempt autoplay on first load ── */
    window.addEventListener('load', () => {
        music.volume = 0.45;
        music.play().then(() => {
            isPlaying = true;
            soundwave.classList.remove('paused');
        }).catch(() => {
            // Autoplay blocked by browser — show nudge toast
            showToast();
        });
    });

    /* ── Fade volume on page leave ── */
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            music.volume = 0;
        } else if (isPlaying) {
            music.volume = 0.45;
        }
    });

    /* ── Build progress dots ── */
    const dots = [];
    scenes.forEach((_, i) => {
        const d = document.createElement('div');
        d.className = 'dot' + (i === 0 ? ' active' : '');
        dotsWrap.appendChild(d);
        dots.push(d);
    });

    /* ── Background slider ── */
    const TOTAL_IMAGES    = 4;
    const sliderContainer = document.getElementById('bg-slider');
    const bgSlides        = [];
    const sceneToImageMap = [0, 0, 1, 2, 2, 3];

    for (let i = 1; i <= TOTAL_IMAGES; i++) {
        const img = document.createElement('img');
        img.src   = `{{ asset('images/hand/image-') }}${i}.jpg`;
        img.className = 'bg-slide';
        sliderContainer.appendChild(img);
        bgSlides.push(img);
    }

    /* ── Show scene ── */
    function show(index) {
        scenes.forEach(s => s.classList.remove("active"));
        if (scenes[index]) scenes[index].classList.add("active");

        if (bgSlides.length > 0) {
            bgSlides.forEach(img => img.classList.remove("active"));
            const mi = sceneToImageMap[index] ?? 0;
            if (bgSlides[mi]) bgSlides[mi].classList.add("active");
        }

        dots.forEach((d, i) => d.classList.toggle('active', i === index));

        const isLast = index === scenes.length - 1;
        nextText.setAttribute('data-fr', isLast ? 'Terminer'  : 'Continuer');
        nextText.setAttribute('data-en', isLast ? 'Finish'    : 'Continue');
        nextText.setAttribute('data-km', isLast ? 'បញ្ចប់'    : 'បន្តទៀត');
        nextIcon.classList.toggle("fa-arrow-right", !isLast);
        nextIcon.classList.toggle("fa-check",       isLast);

        translateApp();
    }

    function next() {
        if (current < scenes.length - 1) { current++; show(current); }
        else { window.location.href = "{{ route('sponsor.contact') }}"; }
    }

    function prev() {
        if (current > 0) { current--; show(current); }
    }

    /* ── Swipe support ── */
    let touchStartX = 0;
    document.querySelector('.story-wrapper').addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
        // First touch = good moment to start audio if blocked
        if (!isPlaying) {
            music.play().then(() => {
                isPlaying = true;
                soundwave.classList.remove('paused');
                hideToast();
            }).catch(() => {});
        }
    }, { passive: true });
    document.querySelector('.story-wrapper').addEventListener('touchend', e => {
        const diff = touchStartX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 50) { diff > 0 ? next() : prev(); }
    }, { passive: true });

    /* ── Init ── */
    translateApp();
    show(0);
</script>

</body>
</html>