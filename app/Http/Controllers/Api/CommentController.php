<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Menampilkan semua komentar dari sebuah post
     */
    public function index(Post $post)
    {
        return response()->json([
            'success' => true,
            'data' => $post->comments()
                ->with('user')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Menambahkan komentar
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan.',
            'data' => $comment
        ], 201);
    }

    /**
     * Detail komentar (opsional)
     */
    public function show(Comment $comment)
    {
        return response()->json([
            'success' => true,
            'data' => $comment->load('user', 'post')
        ]);
    }

    /**
     * Update komentar (opsional)
     */
    public function update(StoreCommentRequest $request, Comment $comment)
    {
        if ($comment->user_id != Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $comment->update([
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil diperbarui.',
            'data' => $comment
        ]);
    }

    /**
     * Hapus komentar
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id != Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dihapus.'
        ]);
    }
}
