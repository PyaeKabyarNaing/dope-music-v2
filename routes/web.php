<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/album', [AlbumController::class, 'index'])->name('album.index');

Route::get('/search', [SongController::class, 'search'])->name('search');

Route::get('/songs/genre/{genre}', [SongController::class, 'filterByGenre'])
    ->name('songs.byGenre');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// billing
Route::middleware('auth')->get('/billing/checkout', [BillingController::class, 'checkout']);

Route::get('/billing/success', function () {
    return redirect()->route('home')->with('success', 'You are now Premium User');
})->name('billing.success');

Route::get('/billing/cancel', function () {
    return redirect()->route('home')->with('error', 'Payment canceled.');
})->name('billing.cancel');

Route::middleware('auth')->group(function () {
    Route::get('/home', [SongController::class, 'index'])->name('home');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{id}', [ProfileController::class, 'view'])->name('user.profile');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// artist
Route::middleware(['auth', 'role:artist'])->group(function () {
    Route::get('/song/upload', [SongController::class, 'create'])->name('song.create');
    Route::get('/song/{song}/edit', [SongController::class, 'edit'])->name('song.edit');
    Route::post('/song', [SongController::class, 'store'])->name('song.store');
    Route::put('/song/update/{id}', [SongController::class, 'update'])->name('song.update');
    
    Route::get('/album/upload', [AlbumController::class, 'create'])->name('album.create');
    Route::post('/album', [AlbumController::class, 'store'])->name('album.store');
    Route::delete('/album/{album}/song/{song}', [AlbumController::class, 'removeSong'])->name('album.removeSong');
    Route::get('/album/{album}/edit', [AlbumController::class, 'edit'])->name('album.edit');
Route::put('/album/{album}', [AlbumController::class, 'update'])->name('album.update');
Route::post('/album/{album}/song', [AlbumController::class, 'addSong'])->name('album.addSong');
});

Route::get('/album/{album}', [AlbumController::class, 'show'])->name('album.show');
Route::get('/song/{song}', [SongController::class, 'show'])->name('song.show');

// comment

Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');
Route::get('/song/{id}/comments', [CommentController::class, 'fetch']);

// admin

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [UserController::class, 'index'])->name('admins.index');
    Route::post('/admin/{user}/role', [UserController::class, 'updateRoles'])->name('admins.updateRoles');
});

require __DIR__.'/auth.php';

// example spatie use in web.php
Route::get('/admin/user/create', function () {
    return view('admin.create-user');
})->middleware(['auth', 'verified', 'can:create user'])->name('user.create');
