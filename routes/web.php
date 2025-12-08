<?php

use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\LikesController;
use Illuminate\Support\Facades\Route;
Route::get('/', [ChirpController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::post('/chirps', [ChirpController::class, 'store']);
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);
    Route::post('/chirps/{chirp}/like', [LikesController::class, 'store'])->name('chirps.like');
    Route::delete('/chirps/{chirp}/like', [LikesController::class, 'destroy'])->name('chirps.unlike');
});


// Show all bookmarked chirps
Route::get('/bookmarks', [BookmarkController::class, 'index'])
    ->middleware('auth')
    ->name('bookmarks.index');

// Add a bookmark
Route::post('/chirps/{chirp}/bookmark', [BookmarkController::class, 'store'])
    ->middleware('auth')
    ->name('chirps.bookmark');

// Remove a bookmark
Route::delete('/chirps/{chirp}/bookmark', [BookmarkController::class, 'destroy'])
    ->middleware('auth')
    ->name('chirps.unbookmark');




// REGISTER ROUTES
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');

Route::post('/register', Register::class)
    ->middleware('guest');



// Login routes
Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', Login::class)
    ->middleware('guest');

// Logout route
Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');