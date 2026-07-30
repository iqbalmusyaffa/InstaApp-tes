<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - InstaApp</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], brand: ['Pacifico', 'cursive'], } } } }
    </script>
</head>
<body class="bg-gray-50 text-gray-900 antialiased font-sans h-screen flex flex-col justify-center items-center">
    
    <div class="w-full max-w-sm p-8 bg-white border border-gray-200 rounded-sm">
        <div class="text-center mb-6">
            <h1 class="font-brand text-4xl mb-4">InstaApp</h1>
            <p class="text-gray-500 text-sm">Enter your email and we'll send you a link to reset your password.</p>
        </div>

        @if(session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-600 rounded-md text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-md text-sm text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
            @csrf
            <div>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required autofocus class="w-full px-4 py-2.5 rounded-md border border-gray-300 bg-gray-50 text-sm focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>

            <button type="submit" class="w-full py-2.5 px-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md text-sm transition-colors">
                Send Reset Link
            </button>
        </form>
    </div>
    
    <div class="w-full max-w-sm mt-4 p-4 bg-white border border-gray-200 rounded-sm text-center">
        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-800 hover:text-gray-600">Back to login</a>
    </div>

</body>
</html>
