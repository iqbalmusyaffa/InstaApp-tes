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



            <div class="flex items-center gap-5">
                <a href="/dashboard" class="text-black">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 2.099l-9 7.64v12.161h6v-7.9h6v7.9h6v-12.16l-9-7.641zm0 2.617l6 5.093v9.091h-2v-7.9h-8v7.9h-2v-9.091l6-5.093z"/></svg>
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

    <main class="max-w-5xl mx-auto pt-20 px-4 flex justify-center gap-8 pb-14 sm:pb-10">
        <div class="w-full max-w-[470px] flex flex-col gap-6">

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-sm p-3 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white border border-gray-200 rounded-sm p-4">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-600 rounded-sm p-3 text-sm mb-3 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="/posts" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex gap-3 mb-1">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-8 h-8 rounded-full border border-gray-200 flex-shrink-0">
                        <textarea name="caption" rows="2" class="w-full border-0 focus:ring-0 text-sm resize-none bg-transparent p-1 placeholder-gray-400" placeholder="What's on your mind, {{ Auth::user()->name }}?">{{ old('caption') }}</textarea>
                    </div>
                    @error('caption')
                        <div class="text-red-500 text-xs ml-11 mb-2">{{ $message }}</div>
                    @enderror

                    <div class="flex items-center justify-between border-t border-gray-100 pt-3 mt-2">
                        <div>
                            <input type="file" name="image" class="text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                            @error('image')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm px-4 py-1.5 rounded-md transition-colors">Post</button>
                    </div>
                </form>
            </div>

            @forelse($posts as $post)
            <div class="bg-white border border-gray-200 rounded-sm">
                <div class="flex items-center justify-between p-3">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('user.show', $post->user) }}" class="flex items-center gap-3 group">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random" class="w-8 h-8 rounded-full border border-gray-200">
                            <span class="font-semibold text-sm group-hover:text-gray-600">{{ $post->user->name }}</span>
                        </a>
                        <span class="text-gray-400 text-xs font-normal">• {{ $post->created_at->diffForHumans(null, true, true) }}</span>
                    </div>
                    @if(Auth::id() === $post->user_id)
                    <div class="relative group cursor-pointer">
                        <button class="text-gray-500 hover:text-black p-1 focus:outline-none">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                        </button>
                        <div class="absolute right-0 mt-1 w-28 bg-white border border-gray-100 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                            <a href="{{ route('posts.edit', $post) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 font-semibold">Edit</a>
                            <form action="/posts/{{ $post->id }}" method="POST" onsubmit="return confirm('Delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50 font-semibold rounded-none rounded-b-md">Delete</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
                <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-auto max-h-[700px] object-contain bg-gray-50">
                <div class="p-3">
                    <div class="flex gap-4 mb-2 items-center">
                        @php
                            $hasLiked = $post->likes->where('user_id', Auth::id())->count() > 0;
                        @endphp
                        <form action="{{ $hasLiked ? route('posts.unlike', $post) : route('posts.like', $post) }}" method="POST" class="inline">
                            @csrf
                            @if($hasLiked)
                                @method('DELETE')
                            @endif
                            <button type="submit" class="{{ $hasLiked ? 'text-red-500' : 'text-black hover:text-gray-500' }}">
                                <svg class="w-6 h-6 {{ $hasLiked ? 'fill-current' : 'fill-none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </form>
                        <button class="text-black hover:text-gray-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg></button>
                    </div>
                    <div class="font-semibold text-sm mb-1">{{ $post->likes->count() }} likes</div>
                    <div class="text-sm">
                        <a href="{{ route('user.show', $post->user) }}" class="font-semibold hover:text-gray-600">{{ $post->user->name }}</a> {{ $post->caption }}
                    </div>
                    @if($post->comments->count() > 0)
                    <div class="mt-2 text-sm max-h-24 overflow-y-auto space-y-1">
                        @foreach($post->comments as $comment)
                            <div class="flex justify-between items-start group">
                                <div>
                                    <a href="{{ route('user.show', $comment->user) }}" class="font-semibold hover:text-gray-600">{{ $comment->user->name }}</a> 
                                    <span class="text-gray-800">{{ $comment->comment }}</span>
                                </div>
                                @if(Auth::id() === $comment->user_id)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-semibold px-2">x</button>
                                </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @endif
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="flex items-center gap-2 border-t border-gray-100 pt-2 mt-2">
                        @csrf
                        <input type="text" name="comment" placeholder="Add a comment..." class="w-full text-sm border-0 focus:ring-0 p-0 bg-transparent" required>
                        <button type="submit" class="text-blue-500 font-semibold text-sm">Post</button>
                    </form>
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


            <div class="mt-8 text-xs text-gray-400">
                <p>&copy; {{ date('Y') }} InstaApp. Built for Technical Test.</p>
            </div>
        </div>
    </main>
    <div class="sm:hidden fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around items-center h-12 z-50">
        <a href="/dashboard" class="p-2"><svg class="w-6 h-6 fill-current text-black" viewBox="0 0 24 24"><path d="M12 2.099l-9 7.64v12.161h6v-7.9h6v7.9h6v-12.16l-9-7.641zm0 2.617l6 5.093v9.091h-2v-7.9h-8v7.9h-2v-9.091l6-5.093z"/></svg></a>

        <a href="{{ route('user.show', Auth::user()) }}" class="p-2"><img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-6 h-6 rounded-full border border-gray-300"></a>
    </div>

</body>
</html>
