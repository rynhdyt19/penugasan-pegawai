<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penjadwalan BPS</title>

     <link rel="shortcut icon" href="{{ asset('gambar/favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-pattern {
            background: linear-gradient(135deg, #e8f4f8 0%, #f0f9ff 100%);
            position: relative;
            overflow: hidden;
        }

        .bg-pattern::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #60d5f2 0%, #0ea5e9 100%);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            opacity: 0.15;
            animation: morph 8s ease-in-out infinite;
        }

        .bg-pattern::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            opacity: 0.12;
            animation: morph 10s ease-in-out infinite reverse;
        }

        @keyframes morph {

            0%,
            100% {
                border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            }

            50% {
                border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            }
        }

        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .accent-shape-1 {
            position: absolute;
            top: -80px;
            right: -80px;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #60d5f2 0%, #0ea5e9 100%);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            opacity: 0.9;
            z-index: 0;
        }

        .accent-shape-2 {
            position: absolute;
            bottom: -100px;
            left: -50px;
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            opacity: 0.85;
            z-index: 0;
        }

        .accent-line-1 {
            position: absolute;
            top: 30%;
            right: 15%;
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #fbbf24, transparent);
            transform: rotate(-25deg);
            opacity: 0.6;
        }

        .accent-line-2 {
            position: absolute;
            bottom: 25%;
            right: 10%;
            width: 150px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #10b981, transparent);
            transform: rotate(15deg);
            opacity: 0.6;
        }
    </style>
</head>

<body class="bg-pattern min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-6xl flex items-center justify-center relative">
        <!-- Decorative Shapes - Hidden on mobile -->
        <div class="hidden lg:block absolute accent-shape-1"></div>
        <div class="hidden lg:block absolute accent-shape-2"></div>
        <div class="hidden lg:block accent-line-1"></div>
        <div class="hidden lg:block accent-line-2"></div>

        <!-- Login Card -->
        <div class="login-card w-full max-w-md p-10 rounded-2xl shadow-2xl relative z-10">
            <!-- Logo BPS -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center">
                    <img src="{{ asset('gambar/bps_logo.png') }}" alt="Logo BPS" class="w-16 h-16 object-contain">
                </div>
            </div>

            <!-- Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Login</h1>
                <p class="text-gray-500 text-sm">Sistem Penjadwalan BPS</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded">
                    <ul class="text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="example@gmail.com" value="{{ old('email') }}">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="password">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <!-- Eye Icon (Show) -->
                            <svg id="eye-open"
                                class="h-5 w-5 text-gray-400 hover:text-gray-600 transition duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Eye Slash Icon (Hide) -->
                            <svg id="eye-closed"
                                class="h-5 w-5 text-gray-400 hover:text-gray-600 transition duration-200 hidden"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-[1.02] shadow-lg">
                    Login
                </button>
            </form>

            <!-- Forgot Password Link -->
            <div class="mt-6 text-center">
                <a href="#" class="text-sm text-gray-400 hover:text-blue-600 transition duration-200">
                    forgot password?
                </a>
            </div>

            <!-- Demo Info -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500 text-center mb-2">Demo Akun:</p>
                <div class="text-xs text-gray-600 space-y-1">
                    <p class="text-center">Admin: admin@example.com / password</p>
                    <p class="text-center">Pegawai: pegawai1@example.com / password</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
