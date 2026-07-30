<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InstaApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            brand: ['Pacifico', 'cursive'],
                        }
                    }
                }
            }
        </script>
    @endif
</head>
<body class="bg-white text-gray-900 antialiased font-sans h-screen flex">
    <div class="hidden lg:flex lg:w-1/2 relative bg-gray-100">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover" alt="InstaApp Cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        <div class="absolute bottom-12 left-12 text-white">
            <h2 class="text-3xl font-bold mb-2">Connect with the world.</h2>
            <p class="text-gray-200">Share your favorite moments and discover new ones.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 bg-white overflow-y-auto">

        @if ($errors->any())
            <div class="w-full max-w-sm mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-md text-sm text-center">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div id="login-container" class="w-full max-w-sm block">
            <div class="text-center mb-10">
                <h1 class="font-brand text-5xl mb-3">InstaApp</h1>
                <p class="text-gray-500 text-sm">Log in to see photos and videos from your friends.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-3">
                @csrf
                <div>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required class="w-full px-4 py-3 rounded-md border border-gray-300 bg-gray-50 text-sm focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-3 rounded-md border border-gray-300 bg-gray-50 text-sm focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <button type="submit" class="w-full py-3 px-4 mt-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md text-sm transition-colors">
                    Log In
                </button>
            </form>

            <div class="flex items-center my-6">
                <div class="flex-grow h-px bg-gray-200"></div>
                <span class="px-4 text-xs font-semibold text-gray-500 uppercase">Or</span>
                <div class="flex-grow h-px bg-gray-200"></div>
            </div>

            @if (Route::has('password.request'))
            <div class="text-center">
                <a href="{{ route('password.request') }}" class="text-xs text-blue-900 hover:underline">Forgot password?</a>
            </div>
            @endif
        </div>

        <div id="register-container" class="w-full max-w-sm hidden">
            <div class="text-center mb-8">
                <h1 class="font-brand text-5xl mb-3">InstaApp</h1>
                <p class="text-gray-500 text-sm font-semibold">Sign up to see photos and videos from your friends.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-3">
                @csrf
                <div>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus class="w-full px-4 py-3 rounded-md border border-gray-300 bg-gray-50 text-sm focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required class="w-full px-4 py-3 rounded-md border border-gray-300 bg-gray-50 text-sm focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-3 rounded-md border border-gray-300 bg-gray-50 text-sm focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="w-full px-4 py-3 rounded-md border border-gray-300 bg-gray-50 text-sm focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <button type="submit" class="w-full py-3 px-4 mt-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md text-sm transition-colors">
                    Sign Up
                </button>
            </form>

            <p class="text-xs text-center text-gray-500 mt-5 leading-relaxed">
                By signing up, you agree to our Terms, Privacy Policy and Cookies Policy.
            </p>
        </div>

        <div class="w-full max-w-sm mt-6 border border-gray-200 py-5 text-center rounded-md">
            <p id="toggle-to-register" class="text-sm text-gray-600">
                Don't have an account?
                <button type="button" onclick="toggleAuthMode()" class="font-semibold text-blue-500 hover:text-blue-600 focus:outline-none">Sign up</button>
            </p>
            <p id="toggle-to-login" class="text-sm text-gray-600 hidden">
                Have an account?
                <button type="button" onclick="toggleAuthMode()" class="font-semibold text-blue-500 hover:text-blue-600 focus:outline-none">Log in</button>
            </p>
        </div>
    </div>

    <script>
        function toggleAuthMode() {
            const loginContainer = document.getElementById('login-container');
            const registerContainer = document.getElementById('register-container');
            const toRegisterText = document.getElementById('toggle-to-register');
            const toLoginText = document.getElementById('toggle-to-login');

            if (loginContainer.classList.contains('hidden')) {
                loginContainer.classList.remove('hidden');
                loginContainer.classList.add('block');
                registerContainer.classList.remove('block');
                registerContainer.classList.add('hidden');

                toRegisterText.classList.remove('hidden');
                toLoginText.classList.add('hidden');
            } else {
                loginContainer.classList.add('hidden');
                loginContainer.classList.remove('block');
                registerContainer.classList.add('block');
                registerContainer.classList.remove('hidden');

                toRegisterText.classList.add('hidden');
                toLoginText.classList.remove('hidden');
            }
        }
    </script>

    @if(old('name') || $errors->has('name') || $errors->has('password_confirmation'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                toggleAuthMode();
            });
        </script>
    @endif

</body>
</html>
