<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        $like = Like::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil di-like.',
            'data' => $like
        ], 201);
    }
     public function destroy(Post $post)
    {
        Like::where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Like berhasil dihapus.'
        ]);
    }
}
