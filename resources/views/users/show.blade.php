<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->name }} - InstaApp</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Pacifico&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], brand: ['Pacifico', 'cursive'], } } } }
    </script>
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

    <main class="max-w-4xl mx-auto pt-24 px-4 pb-14">
        <div class="flex items-center sm:items-start gap-8 sm:gap-20 mb-12 border-b border-gray-200 pb-12">
            <div class="flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=150" class="w-24 h-24 sm:w-36 sm:h-36 rounded-full border border-gray-200 object-cover">
            </div>

            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-4">
                    <h2 class="text-xl sm:text-2xl">{{ $user->name }}</h2>
                    @if(Auth::id() === $user->id)
                        <a href="/profile" class="bg-gray-100 hover:bg-gray-200 text-black font-semibold text-sm px-4 py-1.5 rounded-md transition-colors">Edit Profile</a>
                    @else
                        <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm px-5 py-1.5 rounded-md transition-colors">Follow</button>
                    @endif
                </div>

                <div class="flex gap-6 text-base">
                    <div><span class="font-semibold">{{ $user->posts->count() }}</span> posts</div>
                    <div><span class="font-semibold">0</span> followers</div>
                    <div><span class="font-semibold">0</span> following</div>
                </div>

                <div class="text-sm">
                    <p class="font-semibold">{{ $user->name }}</p>
                    <p class="text-gray-600">InstaApp Member</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-1 sm:gap-4">
            @forelse($user->posts as $post)
                <div class="aspect-square overflow-hidden bg-gray-100 relative group cursor-pointer">
                    <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex justify-center items-center opacity-0 group-hover:opacity-100">
                        <div class="flex gap-4 text-white font-bold">
                            <div class="flex items-center gap-1">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                <span>{{ $post->likes ? $post->likes->count() : 0 }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-5 h-5 fill-current" viewBox="0 24 24"><path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18z"/></svg>
                                <span>{{ $post->comments ? $post->comments->count() : 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20 text-gray-500">
                    No posts yet.
                </div>
            @endforelse
        </div>
    </main>

    <div class="sm:hidden fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around items-center h-12 z-50">
        <a href="/dashboard" class="p-2"><svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></a>
        <a href="{{ route('user.show', Auth::user()) }}" class="p-2"><img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-6 h-6 rounded-full border border-gray-300"></a>
    </div>
</body>
</html>
