<?php

use App\Http\Controllers\AdminFilmController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\KritikController;
use Illuminate\Support\Facades\Route;

// Route Halaman Publik / Utama
Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');

// Route Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Komentar (Harus Login)
Route::post('/movies/{film}/comments', [KritikController::class, 'store'])
    ->middleware('auth')
    ->name('kritik.store');

// Route Dashboard Admin CRUD (Dibutuhkan login)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('films', AdminFilmController::class);
});
