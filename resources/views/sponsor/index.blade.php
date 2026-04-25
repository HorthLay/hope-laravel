{{-- resources/views/sponsor/index.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Histoire - Parrainage | {{ $settings['site_name'] ?? 'Hope & Impact' }}</title>
    <meta name="description" content="{{ $settings['meta_description'] ?? $settings['site_description'] ?? '' }}">

    @if(!empty($settings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,700;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: #080c11;
            color: white;
            font-family: 'Inter', sans-serif;
        }

        /* ── Background images ── */
        .bg-slide {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 2s ease-in-out;
            z-index: 0;
        }
        .bg-slide.active { opacity: 1; }

        /* ── Dark overlay + grain ── */
        .bg-overlay {
            position: fixed;
            inset: 0;
            background: rgba(6, 9, 14, 0.62);
            z-index: 1;
        }
        .bg-overlay::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            opacity: 0.3;
            pointer-events: none;
        }

        /* ── Stage ── */
        .stage {
            position: fixed;
            inset: 0;
            z-index: 2;
        }

        /* ── Scenes ── */
        .scene {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5rem 8% 5rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 1.2s ease;
            overflow-y: auto;
        }
        .scene.active {
            opacity: 1;
            pointer-events: auto;
        }

        .scene-inner {
            max-width: 680px;
            width: 100%;
            text-align: center;
        }

        /* ── Typography ── */
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 500;
            line-height: 1.25;
            letter-spacing: -0.01em;
            margin-bottom: 1.5rem;
        }

        .scene-p {
            font-size: clamp(0.9rem, 2vw, 1.15rem);
            line-height: 2;
            font-weight: 300;
            opacity: 0.88;
            margin-bottom: 1.5rem;
        }
        .scene-p strong { font-weight: 600; color: #fff; }
        .scene-p .size-lg {
            font-size: 1.6em;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
        }
        .scene-p .size-xl {
            font-family: 'Playfair Display', serif;
            font-size: 2.2em;
            font-weight: 700;
            display: block;
            margin-top: 0.25em;
        }

        /* ── Per-scene action button ── */
        .scene-action {
            margin-top: 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.8s ease 0.65s, transform 0.8s ease 0.65s;
        }
        .scene.active .scene-action {
            opacity: 1;
            transform: translateY(0);
        }

        .btn-scene {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 30px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            background: transparent;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.02em;
            cursor: pointer;
            transition: background 0.3s, border-color 0.3s, color 0.3s, transform 0.2s;
            text-decoration: none;
        }
        .btn-scene:hover {
            background: white;
            color: #080c11;
            border-color: white;
            transform: translateY(-1px);
        }
        .btn-scene.primary {
            background: white;
            color: #080c11;
            border-color: white;
            font-weight: 600;
        }
        .btn-scene.primary:hover {
            background: rgba(255,255,255,0.88);
            transform: translateY(-1px);
        }

        .btn-hint {
            font-size: 12px;
            opacity: 0.4;
            font-weight: 400;
            letter-spacing: 0.01em;
        }

        /* ── Progress bar ── */
        .progress-wrap {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: min(55%, 480px);
            height: 1.5px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 999px;
            overflow: hidden;
            z-index: 10;
        }
        .progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, rgba(255,255,255,0.3), rgba(255,255,255,0.9));
            border-radius: 999px;
            transition: width 1s ease;
        }

        /* ── Corner buttons ── */
        .corner-btn {
            position: fixed;
            top: 1.4rem;
            z-index: 20;
            width: 38px;
            height: 38px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.25s, transform 0.2s;
            color: white;
            font-size: 13px;
            text-decoration: none;
        }
        .corner-btn:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: scale(1.08);
        }
        .corner-btn.left  { left: 1.4rem; }
        .corner-btn.right { right: 1.4rem; }

        /* ── Translate wrapper (center top) ── */
        #translate-wrapper {
            position: fixed;
            top: 1.4rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
        }

        /* ── Pill trigger button ── */
        #translate-toggle {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 5px 14px 5px 10px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(12px);
            color: rgba(255, 255, 255, 0.85);
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: background 0.25s, border-color 0.25s;
            white-space: nowrap;
        }
        #translate-toggle:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.35);
        }
        #translate-toggle img {
            width: 20px;
            height: 14px;
            border-radius: 3px;
            object-fit: cover;
        }
        #translate-caret {
            font-size: 9px;
            opacity: 0.55;
            transition: transform 0.25s;
        }
        #translate-wrapper.open #translate-caret {
            transform: rotate(180deg);
        }

        /* ── Dropdown panel ── */
        #translate-panel {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%);
            width: 210px;
            background: rgba(14, 20, 30, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 12px 10px 10px;
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 40px rgba(0,0,0,0.55);
        }
        #translate-wrapper.open #translate-panel {
            display: block;
            animation: panelIn 0.2s ease;
        }
        @keyframes panelIn {
            from { opacity: 0; transform: translateX(-50%) translateY(-6px); }
            to   { opacity: 1; transform: translateX(-50%) translateY(0); }
        }

        /* ── Panel header ── */
        #translate-panel .panel-header {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0 4px 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        #translate-panel .panel-header i {
            color: #f97316;
        }

        /* ── Language option buttons ── */
        .lang-option-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 8px;
            border-radius: 9px;
            border: none;
            background: transparent;
            color: rgba(255,255,255,0.75);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            text-align: left;
        }
        .lang-option-btn:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .lang-option-btn.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .lang-option-btn .flag {
            width: 22px;
            height: 15px;
            border-radius: 3px;
            object-fit: cover;
            flex-shrink: 0;
        }
        .lang-option-btn .check {
            margin-left: auto;
            font-size: 11px;
            color: #f97316;
        }
        .lang-option-btn .check.hidden { display: none; }
        .lang-option-btn .lang-sub {
            font-size: 10px;
            font-weight: 400;
            color: rgba(255,255,255,0.35);
            margin-top: 1px;
        }

        /* ── Auto translate button ── */
        #auto-translate-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid rgba(249,115,22,0.35);
            background: rgba(249,115,22,0.08);
            color: #fb923c;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s;
            letter-spacing: 0.02em;
        }
        #auto-translate-btn:hover {
            background: rgba(249,115,22,0.18);
            border-color: rgba(249,115,22,0.55);
        }

        /* ── Panel divider ── */
        .panel-divider {
            margin: 8px 0;
            border: none;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        /* ── Soundwave ── */
        .soundwave {
            display: flex;
            align-items: center;
            gap: 2px;
            height: 16px;
        }
        .soundwave span {
            display: block;
            width: 2.5px;
            border-radius: 2px;
            background: white;
            animation: wave 0.8s ease-in-out infinite;
            transform-origin: center;
        }
        .soundwave span:nth-child(1) { height: 5px;  animation-delay: 0s;    }
        .soundwave span:nth-child(2) { height: 13px; animation-delay: 0.15s; }
        .soundwave span:nth-child(3) { height: 9px;  animation-delay: 0.3s;  }
        .soundwave span:nth-child(4) { height: 13px; animation-delay: 0.45s; }
        .soundwave span:nth-child(5) { height: 5px;  animation-delay: 0.6s;  }

        @keyframes wave {
            0%, 100% { transform: scaleY(1);    }
            50%       { transform: scaleY(0.25); }
        }
        .soundwave.paused span {
            animation-play-state: paused;
            transform: scaleY(0.25);
        }

        /* ── Mobile ── */
        @media (max-width: 500px) {
            .scene            { padding: 4.5rem 7% 4rem; }
            .progress-wrap    { width: 70%; }
            h1                { font-size: 1.7rem; }
            .scene-p          { font-size: 0.875rem; line-height: 1.9; }
            .scene-p .size-lg { font-size: 1.35em; }
            .scene-p .size-xl { font-size: 1.7em; }
        }
    </style>
</head>
<body>

<audio id="bg-music" loop preload="auto">
    <source src="{{ asset('music/sound-1.mp3') }}" type="audio/mpeg">
</audio>

<!-- Background images -->
<div id="bg-slider"></div>

<!-- Overlay -->
<div class="bg-overlay"></div>

<!-- Back to home -->
<a href="{{ url('/') }}" class="corner-btn left" title="Retour">
    <i class="fas fa-arrow-left"></i>
</a>

<!-- Translate / Language switcher -->
<div id="translate-wrapper">
    <button id="translate-toggle" onclick="toggleTranslatePanel()">
        <img src="https://flagcdn.com/w40/fr.png" id="desktop-flag" alt="FR">
        <span id="desktop-lang-label">FR</span>
        <i class="fas fa-chevron-down" id="translate-caret"></i>
    </button>
    <div id="translate-panel">
        <div class="panel-header">
            <i class="fas fa-globe"></i> Language
        </div>
        <button class="lang-option-btn" id="btn-en" onclick="switchLanguage('en')">
            <img src="https://flagcdn.com/w40/us.png" class="flag" alt="EN">
            <div>
                <div>English</div>
                <div class="lang-sub">Original</div>
            </div>
            <i class="fas fa-check check hidden" id="check-en"></i>
        </button>
        <button class="lang-option-btn" id="btn-km" onclick="switchLanguage('km')">
            <img src="https://flagcdn.com/w40/kh.png" class="flag" alt="KM">
            <div>
                <div>ខ្មែរ (Khmer)</div>
                <div class="lang-sub">Cambodian</div>
            </div>
            <i class="fas fa-check check hidden" id="check-km"></i>
        </button>
        <button class="lang-option-btn active" id="btn-fr" onclick="switchLanguage('fr')">
            <img src="https://flagcdn.com/w40/fr.png" class="flag" alt="FR">
            <div>
                <div>Français</div>
                <div class="lang-sub">French</div>
            </div>
            <i class="fas fa-check check" id="check-fr"></i>
        </button>
        <hr class="panel-divider">
        <button id="auto-translate-btn" onclick="autoDetectAndTranslate()">
            <i class="fas fa-magic" style="font-size:10px"></i> Auto Translate
        </button>
    </div>
</div>

<!-- Sound toggle -->
<button class="corner-btn right" id="sound-btn" onclick="toggleSound()" title="Musique">
    <div class="soundwave paused" id="soundwave">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
</button>

<!-- Stage -->
<div class="stage" id="stage">

    <!-- ══ SCENE 1 ══ -->
    <div class="scene active">
        <div class="scene-inner">
            <h1 data-fr="Il existe des histoires qui avancent doucement."
                data-en="There are stories that move forward quietly."
                data-km="មានរឿងរ៉ាវដែលឈានទៅមុខយ៉ាងស្ងៀម។">
                Il existe des histoires qui avancent doucement.
            </h1>
            <p class="scene-p"
               data-fr="Sans éclat. Sans bruit.<br>Portées seulement par le passage du temps.<br><br>Des vies discrètes.<br>Construites dans l'ombre des jours.<br>Et pourtant, elles grandissent quand même."
               data-en="Without brilliance. Without noise.<br>Carried only by the passing of time.<br><br>Discreet lives.<br>Built in the shadow of days.<br>And yet, they grow nonetheless."
               data-km="គ្មានពន្លឺ។ គ្មានសំឡេង។<br>ត្រូវបានផ្ទុកតែដោយការហូរចូលនៃពេលវេលា។<br><br>ជីវិតដ៏ស្ងៀមស្ងាត់។<br>ត្រូវបានសាងសង់នៅក្នុងស្រមោលនៃថ្ងៃ។<br>ប៉ុន្តែនៅតែលូតលាស់។">
                Sans éclat. Sans bruit.<br>
                Portées seulement par le passage du temps.<br><br>
                Des vies discrètes.<br>
                Construites dans l'ombre des jours.<br>
                Et pourtant, elles grandissent quand même.
            </p>
            <div class="scene-action">
                <button class="btn-scene" onclick="goTo(1)">
                    <span data-fr="Découvrir l'histoire" data-en="Discover the story" data-km="រកឃើញរឿង">Découvrir l'histoire</span>
                    <i class="fas fa-arrow-right" style="font-size:11px;opacity:0.7"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ══ SCENE 2 ══ -->
    <div class="scene">
        <div class="scene-inner">
            <p class="scene-p"
               data-fr="Certaines de ces histoires passent inaperçues.<br><br>Elles n'ont pas encore de place dans le regard du monde.<br>Et pourtant, elles cherchent déjà. Doucement. Inévitablement."
               data-en="Some of these stories go unnoticed.<br><br>They do not yet have a place in the world's gaze.<br>And yet, they are already searching. Gently. Inevitably."
               data-km="រឿងខ្លះមិនត្រូវបានគេកត់សម្គាល់ទេ។<br><br>ពួកគេមិនទាន់មានកន្លែងក្នុងការចាប់អារម្មណ៍របស់ពិភពលោក។<br>ប៉ុន្តែពួកគេបានស្វែងរករួចហើយ។ ស្ងប់ស្ងាត់។">
                Certaines de ces histoires passent inaperçues.<br><br>
                Elles n'ont pas encore de place dans le regard du monde.<br>
                Et pourtant, elles cherchent déjà. Doucement. Inévitablement.
            </p>
            <h1 data-fr="Une présence."
                data-en="A presence."
                data-km="វត្តមានមួយ។">
                Une présence.
            </h1>
            <div class="scene-action">
                <button class="btn-scene" onclick="goTo(2)">
                    <span data-fr="Aller plus loin" data-en="Go further" data-km="ទៅឆ្ងាយជាងនេះ">Aller plus loin</span>
                    <i class="fas fa-arrow-right" style="font-size:11px;opacity:0.7"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ══ SCENE 3 ══ -->
    <div class="scene">
        <div class="scene-inner">
            <h1 data-fr="Un chemin approche."
                data-en="A path is approaching."
                data-km="ផ្លូវមួយកំពុងខិតចូលមក។">
                Un chemin approche.
            </h1>
            <p class="scene-p"
               data-fr="Un enfant grandit, un peu plus chaque jour.<br>Dans le silence des petites choses. Dans la force des moments simples.<br><br>Et sans le dire, il attend.<br>Une main tendue. Une main qui reste.<br><br><strong>C'est peut-être déjà vous qu'il attend.</strong>"
               data-en="A child is growing, a little more each day.<br>In the silence of small things. In the strength of simple moments.<br><br>And without saying it, he waits.<br>A hand extended. A hand that stays.<br><br><strong>Perhaps it is already you he is waiting for.</strong>"
               data-km="ក្មេងម្នាក់កំពុងធំធាត់ ខ្លាំងជារៀងរាល់ថ្ងៃ។<br>នៅក្នុងភាពស្ងៀមនៃរឿងតូចៗ។<br><br>ហើយដោយមិននិយាយ គេរង់ចាំ។<br>ដៃដែលលាតចេញ។ ដៃដែលនៅជាប់។<br><br><strong>ប្រហែលជាអ្នកគឺជាអ្នកដែលគេរង់ចាំ។</strong>">
                Un enfant grandit, un peu plus chaque jour.<br>
                Dans le silence des petites choses. Dans la force des moments simples.<br><br>
                Et sans le dire, il attend.<br>
                Une main tendue. Une main qui reste.<br><br>
                <strong>C'est peut-être déjà vous qu'il attend.</strong>
            </p>
            <div class="scene-action">
                <button class="btn-scene" onclick="goTo(3)">
                    <span data-fr="Se rapprocher de lui" data-en="Move closer to him" data-km="ជិតដល់គាត់">Se rapprocher de lui</span>
                    <i class="fas fa-arrow-right" style="font-size:11px;opacity:0.7"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ══ SCENE 4 ══ -->
    <div class="scene">
        <div class="scene-inner">
            <p class="scene-p"
               data-fr='<span class="size-lg">Bientôt,</span><br>deux chemins vont se rencontrer.<br><span class="size-xl">Le vôtre. Et le sien.</span>'
               data-en='<span class="size-lg">Soon,</span><br>two paths will meet.<br><span class="size-xl">Yours. And his.</span>'
               data-km='<span class="size-lg">ឆាប់ៗ,</span><br>ផ្លូវពីរនឹងជួបគ្នា។<br><span class="size-xl">ផ្លូវរបស់អ្នក។ និងផ្លូវរបស់គេ។</span>'>
                <span class="size-lg">Bientôt,</span><br>
                deux chemins vont se rencontrer.<br>
                <span class="size-xl">Le vôtre. Et le sien.</span>
            </p>
            <div class="scene-action">
                <button class="btn-scene" onclick="goTo(4)">
                    <span data-fr="Comprendre ce lien" data-en="Understand this bond" data-km="យល់ពីចំណងនេះ">Comprendre ce lien</span>
                    <i class="fas fa-arrow-right" style="font-size:11px;opacity:0.7"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ══ SCENE 5 ══ -->
    <div class="scene">
        <div class="scene-inner">
            <p class="scene-p"
               data-fr="Ce lien ne transforme pas tout immédiatement.<br><br>Mais il change la manière dont un enfant traverse ses jours.<br><br>Parfois, <strong>tout commence par une décision très simple.</strong>"
               data-en="This bond does not change everything immediately.<br><br>But it changes the way a child moves through their days.<br><br>Sometimes, <strong>everything begins with a very simple decision.</strong>"
               data-km="ចំណងនេះមិនផ្លាស់ប្តូរអ្វីៗគ្រប់យ៉ាងភ្លាមៗ។<br><br>ប៉ុន្តែវាផ្លាស់ប្តូររបៀបដែលក្មេងម្នាក់ដំណើរកាត់ជីវិត។<br><br>ពេលខ្លះ <strong>អ្វីៗគ្រប់យ៉ាងចាប់ផ្តើមដោយការសម្រេចចិត្តសាមញ្ញ។</strong>">
                Ce lien ne transforme pas tout immédiatement.<br><br>
                Mais il change la manière dont un enfant traverse ses jours.<br><br>
                Parfois, <strong>tout commence par une décision très simple.</strong>
            </p>
            <div class="scene-action">
                <button class="btn-scene" onclick="goTo(5)">
                    <span data-fr="Commencer cette histoire" data-en="Begin this story" data-km="ចាប់ផ្តើមរឿងនេះ">Commencer cette histoire</span>
                    <i class="fas fa-arrow-right" style="font-size:11px;opacity:0.7"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ══ SCENE 6 ══ -->
    <div class="scene">
        <div class="scene-inner">
            <h1 data-fr="Un enfant vous attend."
                data-en="A child is waiting for you."
                data-km="ក្មេងម្នាក់កំពុងរង់ចាំអ្នក។">
                Un enfant vous attend.
            </h1>
            <p class="scene-p"
               data-fr="Sans encore le savoir.<br>Mais prêt à avancer avec <strong>vous</strong>."
               data-en="Without yet knowing it.<br>But ready to move forward with <strong>you</strong>."
               data-km="ដោយមិនទាន់ដឹងនៅឡើយ។<br>ប៉ុន្តែរួចរាល់ដើម្បីឈានទៅមុខជាមួយ <strong>អ្នក</strong>។">
                Sans encore le savoir.<br>
                Mais prêt à avancer avec <strong>vous</strong>.
            </p>
            <div class="scene-action">
                <a href="{{ route('sponsor.contact') }}" class="btn-scene primary">
                    <span data-fr="Je commence le parrainage"
                          data-en="I begin the sponsorship"
                          data-km="ខ្ញុំចាប់ផ្តើមការឧបត្ថម្ភ">Je commence le parrainage</span>
                </a>
                <p class="btn-hint"
                   data-fr="L'enfant vous sera présenté après inscription."
                   data-en="The child will be revealed after registration."
                   data-km="ក្មេងនឹងត្រូវបានបង្ហាញបន្ទាប់ពីការចុះឈ្មោះ។">
                    L'enfant vous sera présenté après inscription.
                </p>
            </div>
        </div>
    </div>

</div><!-- /stage -->

<!-- Progress bar -->
<div class="progress-wrap">
    <div class="progress-fill" id="progress-fill"></div>
</div>

<script>
    let current    = 0;
    const scenes       = document.querySelectorAll(".scene");
    const progressFill = document.getElementById("progress-fill");
    const music        = document.getElementById("bg-music");
    const soundwave    = document.getElementById("soundwave");
    let   isPlaying    = false;
    let   userMuted    = false;

    /* ── Language config ── */
    const langConfig = {
        fr: { flag: 'https://flagcdn.com/w40/fr.png', label: 'FR' },
        en: { flag: 'https://flagcdn.com/w40/us.png', label: 'EN' },
        km: { flag: 'https://flagcdn.com/w40/kh.png', label: 'KM' },
    };

    let currentLang = localStorage.getItem('hi_lang') || 'fr';

    function switchLanguage(lang) {
        currentLang = lang;
        localStorage.setItem('hi_lang', lang);
        document.documentElement.lang = lang;

        // Update pill
        const cfg = langConfig[lang];
        document.getElementById('desktop-flag').src = cfg.flag;
        document.getElementById('desktop-flag').alt = cfg.label;
        document.getElementById('desktop-lang-label').textContent = cfg.label;

        // Update option buttons
        ['en', 'km', 'fr'].forEach(l => {
            const btn   = document.getElementById('btn-' + l);
            const check = document.getElementById('check-' + l);
            btn.classList.toggle('active', l === lang);
            check.classList.toggle('hidden', l !== lang);
        });

        translateApp();
        closeTranslatePanel();
    }

    function translateApp() {
        document.querySelectorAll('[data-fr]').forEach(el => {
            if (el.hasAttribute('data-' + currentLang)) {
                el.innerHTML = el.getAttribute('data-' + currentLang);
            }
        });
    }

    /* ── Translate panel toggle ── */
    function toggleTranslatePanel() {
        document.getElementById('translate-wrapper').classList.toggle('open');
    }

    function closeTranslatePanel() {
        document.getElementById('translate-wrapper').classList.remove('open');
    }

    // Close on outside click
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('translate-wrapper');
        if (!wrapper.contains(e.target)) closeTranslatePanel();
    });

    /* ── Auto detect language ── */
    function autoDetectAndTranslate() {
        const browserLang = (navigator.language || navigator.userLanguage || 'fr').toLowerCase().slice(0, 2);
        const supported   = ['fr', 'en', 'km'];
        const detected    = supported.includes(browserLang) ? browserLang : 'fr';
        switchLanguage(detected);
    }

    /* ── Background images ── */
    const sliderContainer = document.getElementById('bg-slider');
    const bgSlides        = [];
    const sceneToImageMap = [0, 0, 1, 2, 2, 3];

    for (let i = 1; i <= 4; i++) {
        const img     = document.createElement('img');
        img.src       = `{{ asset('images/hand/image-') }}${i}.jpg`;
        img.className = 'bg-slide';
        sliderContainer.appendChild(img);
        bgSlides.push(img);
    }

    /* ── Progress ── */
    function updateProgress(index) {
        const pct = scenes.length > 1 ? (index / (scenes.length - 1)) * 100 : 0;
        progressFill.style.width = pct + '%';
    }

    /* ── Show scene ── */
    function show(index) {
        scenes.forEach(s => s.classList.remove("active"));
        if (scenes[index]) scenes[index].classList.add("active");

        bgSlides.forEach(img => img.classList.remove("active"));
        const mi = sceneToImageMap[index] ?? 0;
        if (bgSlides[mi]) bgSlides[mi].classList.add("active");

        current = index;
        updateProgress(index);
        translateApp();
    }

    function goTo(index) {
        if (index >= 0 && index < scenes.length) show(index);
    }

    /* ── Sound ── */
    function toggleSound() {
        if (isPlaying) {
            music.pause();
            isPlaying = false;
            userMuted = true;
            soundwave.classList.add('paused');
        } else {
            userMuted = false;
            music.volume = 0.4;
            music.play().then(() => {
                isPlaying = true;
                soundwave.classList.remove('paused');
            }).catch(() => {});
        }
    }

    function startMusic() {
        if (isPlaying || userMuted) return;
        music.volume = 0.4;
        music.play().then(() => {
            isPlaying = true;
            soundwave.classList.remove('paused');
            ['click','touchstart','keydown','scroll','mousemove'].forEach(evt => {
                document.removeEventListener(evt, startMusic);
            });
        }).catch(() => {});
    }

    window.addEventListener('load', startMusic);
    ['click','touchstart','keydown','scroll','mousemove'].forEach(evt => {
        document.addEventListener(evt, startMusic, { passive: true });
    });

    document.addEventListener('visibilitychange', () => {
        if (!userMuted) music.volume = document.hidden ? 0 : (isPlaying ? 0.4 : 0);
    });

    /* ── Swipe ── */
    let touchStartX = 0;
    document.getElementById('stage').addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });
    document.getElementById('stage').addEventListener('touchend', e => {
        const diff = touchStartX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 50) diff > 0 ? goTo(current + 1) : goTo(current - 1);
    }, { passive: true });

    /* ── Keyboard ── */
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') goTo(current + 1);
        if (e.key === 'ArrowLeft'  || e.key === 'ArrowUp')   goTo(current - 1);
    });

    /* ── Init ── */
    switchLanguage(currentLang);
    show(0);
</script>

</body>
</html>