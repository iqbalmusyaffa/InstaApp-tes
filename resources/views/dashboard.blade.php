<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InstaApp</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Pacifico&display=swap" rel="stylesheet">

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
<body class="bg-gray-50 text-gray-900 antialiased font-sans">

    <nav class="bg-white border-b border-gray-200 fixed w-full top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 h-14 flex justify-between items-center">
            <a href="/dashboard" class="font-brand text-2xl text-black">InstaApp</a>

            <div class="hidden sm:block">
                <input type="text" placeholder="Search..." class="bg-gray-100 border-none rounded-md px-4 py-1.5 text-sm w-64 focus:ring-1 focus:ring-gray-300">
            </div>

            <div class="flex items-center gap-5">
                <a href="/dashboard" class="text-black">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 2.099l-9 7.64v12.161h6v-7.9h6v7.9h6v-12.16l-9-7.641zm0 2.617l6 5.093v9.091h-2v-7.9h-8v7.9h-2v-9.091l6-5.093z"/></svg>
                </a>
                <a href="#" class="text-black hidden sm:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </a>
                <a href="#" class="text-black">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                </a>
                <a href="/profile" class="block">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-7 h-7 rounded-full border border-gray-200 object-cover hover:ring-1 hover:ring-gray-300 transition-all">
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 ml-2">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto pt-20 px-4 flex justify-center gap-8 pb-14 sm:pb-10">
        <div class="w-full max-w-[470px] flex flex-col gap-6">

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-sm p-3 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Create Post Box -->
            <div class="bg-white border border-gray-200 rounded-sm p-4">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex gap-3 mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-8 h-8 rounded-full border border-gray-200 flex-shrink-0">
                        <textarea name="caption" rows="2" class="w-full outline-none text-sm resize-none bg-transparent pt-1 placeholder-gray-400" placeholder="What's on your mind, {{ Auth::user()->name }}?">{{ old('caption') }}</textarea>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-100 pt-3 mt-2">
                        <input type="file" name="image" class="text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm px-4 py-1.5 rounded-md transition-colors">Post</button>
                    </div>
                </form>
            </div>

            <!-- Posts Feed -->
            @forelse($posts as $post)
            <div class="bg-white border border-gray-200 rounded-sm">
                <!-- Header -->
                <div class="flex items-center justify-between p-3">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random" class="w-8 h-8 rounded-full border border-gray-200">
                        <span class="font-semibold text-sm">{{ $post->user->name }}</span>
                        <span class="text-gray-400 text-xs font-normal">• {{ $post->created_at->diffForHumans(null, true, true) }}</span>
                    </div>
                    @if(Auth::id() === $post->user_id)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                    @endif
                </div>
                <!-- Image -->
                <img src="{{ asset('storage/' . $post->image) }}" class="w-full object-cover aspect-square bg-gray-100">
                <!-- Actions -->
                <div class="p-3">
                    <div class="flex gap-4 mb-2">
                        <button class="text-black hover:text-gray-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg></button>
                        <button class="text-black hover:text-gray-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg></button>
                    </div>
                    <div class="font-semibold text-sm mb-1">{{ $post->likes->count() }} likes</div>
                    <div class="text-sm">
                        <span class="font-semibold">{{ $post->user->name }}</span> {{ $post->caption }}
                    </div>
                    @if($post->comments->count() > 0)
                    <div class="text-gray-400 text-sm mt-1 mb-2">View all {{ $post->comments->count() }} comments</div>
                    @endif
                    <!-- Comment Input -->
                    <div class="flex items-center gap-2 border-t border-gray-100 pt-2 mt-2">
                        <input type="text" placeholder="Add a comment..." class="w-full text-sm outline-none bg-transparent py-1">
                        <button class="text-blue-500 font-semibold text-sm">Post</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white border border-gray-200 rounded-sm p-8 text-center text-gray-500 text-sm">
                No posts yet. Be the first to post!
            </div>
            @endforelse

        </div>

        <div class="hidden lg:block w-[320px] pt-4">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-12 h-12 rounded-full border border-gray-200">
                    <div>
                        <div class="font-semibold text-sm">{{ Auth::user()->name }}</div>
                        <div class="text-gray-500 text-sm">Developer</div>
                    </div>
                </div>
            </div>

            <div class="text-gray-500 font-semibold text-sm mb-4">Suggestions for you</div>

            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Alex&background=random" class="w-8 h-8 rounded-full border border-gray-200">
                        <div>
                            <div class="font-semibold text-sm">alex_dev</div>
                            <div class="text-gray-400 text-xs">New to InstaApp</div>
                        </div>
                    </div>
                    <button class="text-blue-500 text-xs font-semibold hover:text-blue-700">Follow</button>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Sarah&background=random" class="w-8 h-8 rounded-full border border-gray-200">
                        <div>
                            <div class="font-semibold text-sm">sarah_codes</div>
                            <div class="text-gray-400 text-xs">Suggested for you</div>
                        </div>
                    </div>
                    <button class="text-blue-500 text-xs font-semibold hover:text-blue-700">Follow</button>
                </div>
            </div>

            <div class="mt-8 text-xs text-gray-400">
                <p>&copy; {{ date('Y') }} InstaApp. Built for Technical Test.</p>
            </div>
        </div>
    </main>
    <div class="sm:hidden fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around items-center h-12 z-50">
        <a href="/dashboard" class="p-2"><svg class="w-6 h-6 fill-current text-black" viewBox="0 0 24 24"><path d="M12 2.099l-9 7.64v12.161h6v-7.9h6v7.9h6v-12.16l-9-7.641zm0 2.617l6 5.093v9.091h-2v-7.9h-8v7.9h-2v-9.091l6-5.093z"/></svg></a>
        <a href="#" class="p-2"><svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></a>
        <a href="#" class="p-2"><svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg></a>
        <a href="/profile" class="p-2"><img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-6 h-6 rounded-full border border-gray-300"></a>
    </div>

</body>
</html>
