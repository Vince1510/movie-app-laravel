<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    /**
     * Toont het overzicht van alle opgeslagen films op het admin dashboard.
     */
    public function index()
    {
        return view('admin.index', [
            'movies' => Movie::latest()->get(),
        ]);
    }

    /**
     * Geeft de HTMX partial terug voor de 'Nieuwe Film' modal overlay.
     */
    public function create()
    {
        return view('admin.partials.create-modal');
    }

    /**
     * Zoekt live naar films via de TMDB API op basis van de ingevoerde zoekterm.
     */
    public function searchTmdb(Request $request)
    {
        $query = trim($request->input('search', ''));

        // Geef lege resultaten terug als de zoekopdracht te kort is (< 2 tekens)
        if (strlen($query) < 2) {
            return view('admin.partials.tmdb-results', ['results' => []]);
        }

        // Haal de films op via de TMDB helper functie
        $results = $this->fetchFromTmdb($query);

        return view('admin.partials.tmdb-results', compact('results'));
    }

    /**
     * Slaat een gekozen TMDB film op in de lokale database (of ververst deze).
     */
    public function store(Request $request)
    {
        // Zet een lege datumstring ("") om naar NULL vóór de validatie
        if (blank($request->input('release_date'))) {
            $request->merge(['release_date' => null]);
        }

        // Valideer de inkomende gegevens vanuit het formulier
        $validated = $request->validate([
            'tmdb_id' => 'required|string',
            'title' => 'required|string|max:255',
            'overview' => 'nullable|string',
            'poster_path' => 'nullable|string',
            'genre' => 'nullable|string',
            'release_date' => 'nullable|date',
        ]);

        // Sla de film op of update de bestaande film op basis van het tmdb_id
        $movie = Movie::updateOrCreate(['tmdb_id' => $validated['tmdb_id']], $validated);

        // Bij een HTMX verzoek sturen we alleen de nieuwe tabelrij partial terug, anders een gewone redirect
        return $request->header('HX-Request')
            ? view('admin.partials.movie-row', compact('movie'))
            : redirect()->route('admin.movies.index');
    }

    /**
     * Verwijdert een film uit de database.
     */
    public function destroy(Request $request, Movie $movie)
    {
        $movie->delete();

        // Bij een HTMX verzoek sturen we een lege respons zodat HTMX de tabelrij verwijdert
        return $request->header('HX-Request')
            ? response('')
            : redirect()->route('admin.movies.index');
    }

    /**
     * Hulpfunctie: voert de daadwerkelijke HTTP GET request uit naar de TMDB API.
     */
    private function fetchFromTmdb(string $query): array
    {
        $response = Http::get(config('services.tmdb.url', 'https://api.themoviedb.org/3') . '/search/movie', [
            'api_key' => config('services.tmdb.key'),
            'query' => $query,
            'language' => 'nl-NL',
        ]);

        // Log eventuele API-fouten en geef een lege lijst terug
        if ($response->failed()) {
            logger()->error('TMDB API Error: ' . $response->body());
            return [];
        }

        return $response->json('results', []);
    }
}