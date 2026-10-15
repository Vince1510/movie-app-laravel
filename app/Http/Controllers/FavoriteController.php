<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Toont de favorietenpagina (/library) van de ingelogde gebruiker.
     */
    public function index()
    {
        // Haal alleen de favoriete films op van de momenteel ingelogde gebruiker
        $movies = auth()->user()->favoriteMovies()->latest()->get();

        return view('library', compact('movies'));
    }

    /**
     * Voegt een film toe aan of verwijdert deze uit de favorieten (Toggle).
     */
    public function toggle(Movie $movie)
    {
        // toggle() voegt toe als hij nog niet bestaat, of verwijdert als hij er al staat
        auth()->user()->favoriteMovies()->toggle($movie->id);

        return back();
    }
}