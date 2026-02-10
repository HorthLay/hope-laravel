<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hope & Impact</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        /* Animated Background */
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animated-bg {
            background: linear-gradient(-45deg, #fff5eb, #fed7aa, #fdba74, #fb923c);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float {
            animation: float 6s ease-in-out infinite;
        }

        /* Fade in animations */
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

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.6s ease-out;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-scaleIn {
            animation: scaleIn 0.5s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse 3s ease-in-out infinite;
        }

        /* Delay classes */
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        /* Input focus effect */
        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(251, 146, 60, 0.3);
        }

        /* Button hover effect */
        .btn-hover {
            position: relative;
            overflow: hidden;
        }

        .btn-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-hover:hover::before {
            left: 100%;
        }

        /* Particles background */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(251, 146, 60, 0.3);
            border-radius: 50%;
            animation: rise 15s infinite ease-in;
        }

        @keyframes rise {
            0% {
                bottom: -100px;
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                bottom: 100%;
                opacity: 0;
            }
        }

        /* Shake animation for errors */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .shake {
            animation: shake 0.5s;
        }
    </style>
</head>
<body class="animated-bg min-h-screen flex items-center justify-center p-4 relative">
    
    <!-- Animated particles -->
    <div class="particles">
        <div class="particle" style="width: 10px; height: 10px; left: 10%; animation-duration: 12s;"></div>
        <div class="particle" style="width: 15px; height: 15px; left: 20%; animation-duration: 15s; animation-delay: 2s;"></div>
        <div class="particle" style="width: 8px; height: 8px; left: 30%; animation-duration: 18s; animation-delay: 4s;"></div>
        <div class="particle" style="width: 12px; height: 12px; left: 40%; animation-duration: 14s; animation-delay: 1s;"></div>
        <div class="particle" style="width: 10px; height: 10px; left: 50%; animation-duration: 16s; animation-delay: 3s;"></div>
        <div class="particle" style="width: 14px; height: 14px; left: 60%; animation-duration: 13s; animation-delay: 5s;"></div>
        <div class="particle" style="width: 9px; height: 9px; left: 70%; animation-duration: 17s; animation-delay: 2s;"></div>
        <div class="particle" style="width: 11px; height: 11px; left: 80%; animation-duration: 15s; animation-delay: 4s;"></div>
        <div class="particle" style="width: 13px; height: 13px; left: 90%; animation-duration: 14s; animation-delay: 1s;"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo/Brand -->
        <div class="text-center mb-8 animate-fadeInDown">
            <div class="inline-block bg-white rounded-full p-4 shadow-lg mb-4 float">
                <i class="fas fa-heart text-orange-500 text-4xl animate-pulse-slow"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Hope & Impact</h1>
            <p class="text-gray-600">Admin Portal</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8 animate-scaleIn">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center animate-fadeIn delay-200">Admin Login</h2>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center animate-fadeInDown" id="successAlert">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 shake" id="errorAlert">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle mr-2 mt-1"></i>
                        <div class="flex-1">
                            @foreach($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('admin.login.post') }}" method="POST" id="loginForm">
                @csrf

                <!-- Email -->
                <div class="mb-6 animate-fadeInUp delay-300">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope mr-2 text-orange-500"></i>Email Address
                    </label>
                    <input type="email" 
                           id="email"
                           name="email" 
                           value="{{ old('email') }}"
                           class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('email') border-red-500 @enderror"
                           placeholder="admin@hopeimpact.org"
                           required
                           autofocus>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6 animate-fadeInUp delay-400">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-orange-500"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password"
                               name="password" 
                               class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent pr-12 @error('password') border-red-500 @enderror"
                               placeholder="Enter your password"
                               required>
                        <button type="button" 
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6 animate-fadeInUp delay-500">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" 
                               name="remember" 
                               class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500 transition-transform group-hover:scale-110">
                        <span class="ml-2 text-sm text-gray-700">Remember me</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="btn-hover w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] hover:shadow-xl shadow-lg animate-fadeInUp delay-500">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </button>
            </form>

            <!-- Default Credentials Info -->
            {{-- <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg animate-fadeIn delay-500">
                <p class="text-xs text-yellow-800 font-semibold mb-2">
                    <i class="fas fa-info-circle mr-1"></i> Default Login Credentials:
                </p>
                <p class="text-xs text-yellow-700 mb-2">
                    <strong>Super Admin:</strong><br>
                    Email: <code class="bg-yellow-100 px-2 py-1 rounded">admin@hopeimpact.org</code><br>
                    Password: <code class="bg-yellow-100 px-2 py-1 rounded">Admin@123</code>
                </p>
                <p class="text-xs text-yellow-700 mb-2">
                    <strong>Editor:</strong><br>
                    Email: <code class="bg-yellow-100 px-2 py-1 rounded">editor@hopeimpact.org</code><br>
                    Password: <code class="bg-yellow-100 px-2 py-1 rounded">Editor@123</code>
                </p>
                <p class="text-xs text-yellow-700">
                    <strong>Admin User:</strong><br>
                    Email: <code class="bg-yellow-100 px-2 py-1 rounded">adminuser@hopeimpact.org</code><br>
                    Password: <code class="bg-yellow-100 px-2 py-1 rounded">Admin@123</code>
                </p>
                <p class="text-xs text-yellow-600 mt-2">
                    ⚠️ Please change these credentials after first login!
                </p>
            </div> --}}
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 animate-fadeInUp delay-500">
            <p class="text-sm text-gray-700">
                <a href="{{ route('home') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold transition-colors hover:underline">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Website
                </a>
            </p>
            <p class="text-xs text-gray-600 mt-4">
                © {{ date('Y') }} Hope & Impact. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Auto-hide success messages after 5 seconds
        setTimeout(function() {
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s, transform 0.5s';
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-20px)';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);

        // Add loading state to button on submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Signing in...';
            button.disabled = true;
        });

        // Add focus animation to inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-[1.02]');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-[1.02]');
            });
        });
    </script>
</body>
</html>