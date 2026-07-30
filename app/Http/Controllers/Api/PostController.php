<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $posts = Post::with('user')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data post berhasil diambil',
            'data' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'caption' => 'required|max:1000',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $image = $request->file('image')->store('posts', 'public');

        $post = Post::create([
            'user_id' => Auth::id(),
            'caption' => $request->caption,
            'image' => $image,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil dibuat',
            'data' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         return response()->json([
            'success' => true,
            'data' => $post->load('user')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          if ($post->user_id != Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'caption' => 'required|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete($post->image);

            $post->image = $request->file('image')
                ->store('posts', 'public');
        }

        $post->caption = $request->caption;

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil diupdate',
            'data' => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         if ($post->user_id != Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        Storage::disk('public')->delete($post->image);

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil dihapus'
        ]);
    }
}
