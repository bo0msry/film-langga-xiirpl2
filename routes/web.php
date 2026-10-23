<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FilmController,
    AuthController,
    KritikController,
    AdminFilmController
};

// Route Halaman Publik / Utama
Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');

// Route Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Komentar (Harus Login)
Route::middleware(['auth'])->group(function () {
    Route::post('/movies/{film}/comments', [KritikController::class, 'store'])->name('kritik.store');
});

// Route Dashboard Admin CRUD (Dibutuhkan login)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('films', AdminFilmController::class);
});
