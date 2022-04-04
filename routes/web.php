<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ProfileController::class, 'initialPage']);
Route::get('/all-posts', [PostController::class, 'allPosts'])->name('all-posts');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/{userId}/details', [ProfileController::class, 'show']);
    Route::get('/profile/edit', [ProfileController::class, 'edit']);
    Route::put('/profile/{userId}/update', [ProfileController::class, 'update']);
    Route::get('/all-users', [ProfileController::class, 'allUsers'])->name('all-users');
    Route::put('/update-avatar/{userId}', [ProfileController::class, 'updateAvatar'])->name('update-avatar');
    Route::post('/follow-unfollow/{userId}', [ProfileController::class, 'followOrUnfollow'])->name('follow-unfollow');
    Route::get('/profile/followers', [ProfileController::class, 'displayFollowers']);
    Route::get('/profile/followings', [ProfileController::class, 'displayFollowings']);
    Route::get('/country-posts/{userId}', [PostController::class, 'countryPosts']);
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    Route::resource('posts', PostController::class);
    Route::post('/like/{postId}', [PostController::class, 'likeOrDislike'])->name('like');
    Route::get('/liked-posts', [PostController::class, 'likedPosts'])->name('liked-posts');
    // TODO
    Route::resource('comments', CommentController::class);
});

require __DIR__.'/auth.php';
