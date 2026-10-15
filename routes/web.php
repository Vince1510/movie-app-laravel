<?php

use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Publieke Routes (Toegankelijk voor iedereen)
|--------------------------------------------------------------------------
*/

// Homepagina: toont alle films, optioneel gefilterd op genre via ?genre=...
Route::get('/', function (Request $request) {
    $selectedGenre = $request->query('genre');

    // Sorteer op de nieuwste films
    $query = Movie::latest();

    // Als er een genre is gekozen, filter de database-uitslag
    if ($selectedGenre) {
        $query->where('genre', 'LIKE', '%' . $selectedGenre . '%');
    }

    $movies = $query->get();

    // Haal alle unieke genres op uit de database voor het filter-menu
    $genres = Movie::whereNotNull('genre')
        ->pluck('genre')
        ->flatMap(fn($item) => explode(', ', $item))
        ->unique()
        ->sort()
        ->values();

    return view('index', compact('movies', 'genres', 'selectedGenre'));
})->name('home');

// Detailpagina van één specifieke film (publiek inziebaar)
Route::get('/movies/{movie}', function (Movie $movie) {
    return view('movies.show', compact('movie'));
})->name('movies.show');

/*
|--------------------------------------------------------------------------
| Ingelogde Gebruikers Routes ('auth' middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Gebruikersprofiel beheren
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // "Mijn Lijst" / Favorietenpagina van de ingelogde gebruiker
    Route::get('/library', [FavoriteController::class, 'index'])->name('library.index');

    // Actie om een film toe te voegen aan of te verwijderen uit favorieten (Hartje)
    Route::post('/movies/{movie}/favorite', [FavoriteController::class, 'toggle'])->name('movies.favorite');
});

/*
|--------------------------------------------------------------------------
| Admin Routes ('auth' en 'admin' middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard overzicht van films in het beheerpaneel
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');

    // HTMX Modal voor het toevoegen van films
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');

    // Opslaan van een film in de lokale database vanuit TMDB
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');

    // Live zoeken naar films via de TMDB API (HTMX)
    Route::get('/tmdb/search', [MovieController::class, 'searchTmdb'])->name('tmdb.search');

    // Bewerken en bijwerken van bestaande films
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');

    // Verwijderen van een film uit de database
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');
});

// Extra authenticatieroutes (zoals login, register, logout uit Breeze/Fortify)
require __DIR__ . '/auth.php';