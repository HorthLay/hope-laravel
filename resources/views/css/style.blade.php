    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }

        /* ========== HEADER ========== */
        .main-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* ========== HERO VIDEO SECTION ========== */
        .hero-section {
            position: relative;
            height: 100vh;
            min-height: 500px;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .hero-section {
                height: calc(100vh - 70px);
                min-height: 400px;
            }
        }

        .hero-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translateX(-50%) translateY(-50%);
            object-fit: cover;
            z-index: 1;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(125deg, rgba(244,182,48) 5%, rgba(160,149,31) 50%);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 20px;
        }

        /* ========== ANIMATIONS ========== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }
            to {
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.8s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.6s ease-out forwards;
        }

        .delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .delay-400 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        .delay-600 {
            animation-delay: 0.6s;
            opacity: 0;
        }

        /* ========== BUTTONS ========== */
        .btn-primary {
            background: #f4b630;
            color: white;
            padding: 16px 48px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(230, 126, 34, 0.3);
        }

        .btn-primary:hover {
            background: #d35400;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(230, 126, 34, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: white;
            color: #f4b630;
            padding: 16px 48px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            border: 2px solid white;
            font-size: 16px;
        }

        .btn-secondary:hover {
            background: rgba(255,255,255,0.9);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .btn-primary, .btn-secondary {
                padding: 14px 32px;
                font-size: 15px;
            }
        }

        /* ========== CARDS ========== */
        .card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        @media (max-width: 768px) {
            .card:hover {
                transform: translateY(-4px);
            }
        }

        .img-hover {
            overflow: hidden;
        }

        .img-hover img {
            transition: transform 0.5s ease;
        }

        .img-hover:hover img {
            transform: scale(1.1);
        }

        /* ========== PROGRESS BAR ========== */
        .progress-bar {
            height: 8px;
            background: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #f4b630, #d35400);
            border-radius: 10px;
            transition: width 1.5s ease;
        }

        /* ========== STATS SECTION ========== */
        .stats-section {
            background: linear-gradient(135deg, #f4b630 0%, #d35400 100%);
            color: white;
            padding: 60px 20px;
        }

        .stat-number {
            font-size: 48px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .stat-number {
                font-size: 36px;
            }
        }

        /* ========== SECTIONS ========== */
        .section {
            padding: 80px 20px;
        }

        @media (max-width: 768px) {
            .section {
                padding: 50px 20px 70px;
            }
        }

        /* ========== SCROLL ANIMATIONS ========== */
        .scroll-animate {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease-out;
        }

        .scroll-animate.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* ========== LOADING SCREEN ========== */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s, visibility 0.5s;
        }

        .loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #e67e22;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* ========== MOBILE MENU ========== */
        .hamburger {
            display: flex;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 5px;
        }

        .hamburger span {
            width: 28px;
            height: 3px;
            background: #333;
            border-radius: 3px;
            transition: all 0.3s;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 85%;
            max-width: 350px;
            height: 100%;
            background: white;
            z-index: 9999;
            transition: right 0.3s ease;
            overflow-y: auto;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* ========== MOBILE BOTTOM NAV ========== */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
            animation: slideUp 0.5s ease-out;
        }

        @media (max-width: 768px) {
            .mobile-bottom-nav {
                display: flex;
            }
        }

        .nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px 8px;
            color: #666;
            text-decoration: none;
            font-size: 11px;
            transition: all 0.3s;
            position: relative;
        }

        .nav-item i {
            font-size: 22px;
            margin-bottom: 4px;
            transition: all 0.3s;
        }

        .nav-item.active {
            color: #f4b630;
        }

        .nav-item.active i {
            transform: scale(1.1);
        }

        /* ========== POPUP MODAL ========== */
        .popup-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            padding: 20px;
        }

        .popup-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .popup-content {
            background: white;
            border-radius: 20px;
            max-width: 500px;
            width: 100%;
            position: relative;
            overflow: hidden;
            transform: scale(0.8);
            transition: transform 0.3s;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .popup-modal.active .popup-content {
            transform: scale(1);
            animation: bounceIn 0.5s ease-out;
        }

        .popup-close {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 35px;
            height: 35px;
            background: rgba(0,0,0,0.6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s;
        }

        .popup-close:hover {
            background: rgba(0,0,0,0.8);
            transform: rotate(90deg);
        }

        .popup-close i {
            color: white;
            font-size: 18px;
        }

        /* ========== YOUTUBE VIDEO ASPECT RATIO ========== */
        .aspect-video {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
        }

        .aspect-video iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* ========== FOOTER ========== */
        footer {
            background: #2c3e50;
            color: white;
        }

        /* ========== UTILITY CLASSES ========== */
        .green-line {
            width: 80px;
            height: 4px;
            background: #22c55e;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .green-line {
                width: 60px;
                height: 3px;
            }
        }
    </style>