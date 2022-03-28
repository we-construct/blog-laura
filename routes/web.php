<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('profile', ProfileController::class);
    Route::get('/all-users', [ProfileController::class, 'allUsers'])->name('all-users');
    Route::post('/follow-unfollow/{userId}', [ProfileController::class, 'followOrUnfollow'])->name('follow-unfollow');
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    Route::resource('posts', PostController::class);
    Route::get('/my-posts/{userId}', [PostController::class, 'myPosts']);
});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
