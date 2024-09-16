<?php

use App\Http\Controllers\Oauth2Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/auth2', [Oauth2Controller::class, 'index']);

Route::get('auth/google', [Oauth2Controller::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [Oauth2Controller::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';
