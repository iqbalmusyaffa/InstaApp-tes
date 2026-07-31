<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Post - InstaApp</title>

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

            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold">Edit Post</h1>
                <a href="/dashboard" class="text-sm text-blue-500 hover:text-blue-600">Back to Dashboard</a>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-sm p-3 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white border border-gray-200 rounded-sm p-4">
                <form action="/posts/{{ $post->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-auto max-h-[400px] object-contain bg-gray-50 mb-3 border border-gray-100">
                    </div>

                    <div class="flex gap-3 mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-8 h-8 rounded-full border border-gray-200 flex-shrink-0">
                        <textarea name="caption" rows="3" class="w-full border border-gray-200 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none bg-transparent p-2 placeholder-gray-400" required>{{ old('caption', $post->caption) }}</textarea>
                    </div>
                    @error('caption')
                        <div class="text-red-500 text-xs mb-2">{{ $message }}</div>
                    @enderror

                    <div class="flex items-center justify-between border-t border-gray-100 pt-3 mt-2">
                        <div>
                            <span class="text-xs text-gray-500 block mb-1">Update image (optional)</span>
                            <input type="file" name="image" class="text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                            @error('image')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm px-4 py-1.5 rounded-md transition-colors">Update Post</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
