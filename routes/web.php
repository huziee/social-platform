<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home.index');

Route::middleware('auth')->group(function () {
    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/posts/{postId}/edit', [PostController::class, 'edit']);
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::delete('/post-image/{id}', [PostController::class, 'deleteImage'])->name('post.deleteimage');
    Route::post('/post-image/{id}', [PostController::class, 'updateImage'])->name('post.updateImage');
    Route::post('/posts/{id}/update-modal', [PostController::class, 'updateModal'])->name('posts.updateModal');

    Route::get('/posts/{id}/preview', [PostController::class, 'preview'])->name('posts.preview');

Route::post('/like/{post}', [LikeController::class, 'togglestatus']);
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{postId}', [CommentController::class, 'fetch'])->name('comments.fetch');



    Route::post('/follow/{user}', [FollowController::class, 'toggle'])
        ->name('follow.toggle');

    Route::get('/my-profile', [MyAccountController::class, 'index'])->name('profile.index');
    Route::get('/pp', [MyAccountController::class, 'privacyTerms'])->name('home.pp');
    Route::get('/help', [MyAccountController::class, 'help'])->name('home.help');
    Route::get('/chat', [MyAccountController::class, 'chat'])->name('home.chat');

    Route::get('/get-stories',[StoryController::class, 'index'])->name('stories.get');
    Route::post('/stories/upload',[StoryController::class, 'store'])->name('stories.store');
    Route::delete('/delete-stories/{id}', [StoryController::class, 'destroy'])
    ->name('stories.destroy');

    Route::post('/my-profile/about', [ProfileController::class, 'updateAbout'])->name('profile.about.update');





});

require __DIR__ . '/auth.php';

