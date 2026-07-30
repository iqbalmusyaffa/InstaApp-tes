<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $posts = \App\Models\Post::with(['user', 'likes', 'comments.user'])->latest()->get();
    return view('dashboard', compact('posts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/user/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('user.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('posts', PostController::class);
     // Like
    Route::post('/posts/{post}/like', [LikeController::class, 'store'])
        ->name('posts.like');

    Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])
        ->name('posts.unlike');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->name('comments.store');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->name('comments.destroy');
});

require __DIR__.'/auth.php';
