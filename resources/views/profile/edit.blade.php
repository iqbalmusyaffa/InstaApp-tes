<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile - InstaApp</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Pacifico&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], brand: ['Pacifico', 'cursive'], } } } }
        </script>
    @endif
</head>
<body class="bg-gray-50 text-gray-900 antialiased font-sans">
    
    <nav class="bg-white border-b border-gray-200 fixed w-full top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 h-14 flex justify-between items-center">
            <a href="/dashboard" class="font-brand text-2xl text-black">InstaApp</a>
            <div class="hidden sm:block">
                <input type="text" placeholder="Search..." class="bg-gray-100 border-none rounded-md px-4 py-1.5 text-sm w-64 focus:ring-1 focus:ring-gray-300">
            </div>
            <div class="flex items-center gap-5">
                <a href="/dashboard" class="text-black">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </a>
                <a href="{{ route('user.show', Auth::user()) }}" class="block">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-7 h-7 rounded-full border border-gray-200 object-cover hover:ring-1 hover:ring-gray-300 transition-all">
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 ml-2">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto pt-24 px-4 pb-14">
        <h2 class="font-semibold text-2xl mb-8">Edit Profile</h2>

        <div class="space-y-6">
            <div class="p-6 bg-white border border-gray-200 rounded-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-sm">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </main>

    <div class="sm:hidden fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around items-center h-12 z-50">
        <a href="/dashboard" class="p-2"><svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></a>
        <a href="{{ route('user.show', Auth::user()) }}" class="p-2"><img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-6 h-6 rounded-full border border-gray-300"></a>
    </div>
</body>
</html>
