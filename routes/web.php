<?php

use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\ProfileController;
use App\Models\Movie;
use Illuminate\Support\Facades\Route;

/*
 Publieke Routes

*/
Route::get('/', function () {
    $movies = Movie::latest()->get();

    return view('index', compact('movies'));
})->name('home');

/*
Ingelogde Gebruikers Routes
*/

Route::get('/movies/{movie}', function (Movie $movie) {
    return view('movies.show', compact('movie'));
})->name('movies.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
 Admin Routes
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');

    Route::get('/tmdb/search', [MovieController::class, 'searchTmdb'])->name('tmdb.search');

    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');
});

require __DIR__ . '/auth.php';