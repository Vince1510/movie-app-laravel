<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->get();

        return view('admin.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.partials.create-modal');
    }

    public function searchTmdb(Request $request)
    {
        $query = $request->input('search');

        if (empty($query) || strlen($query) < 2) {
            return view('admin.partials.tmdb-results', ['results' => []]);
        }

        $apiKey = config('services.tmdb.key');
        $baseUrl = config('services.tmdb.url', 'https://api.themoviedb.org/3');

        $response = Http::get("{$baseUrl}/search/movie", [
            'api_key' => $apiKey,
            'query' => $query,
            'language' => 'nl-NL',
        ]);

        if ($response->failed()) {
            logger('TMDB API Error: ' . $response->body());
            return view('admin.partials.tmdb-results', ['results' => []]);
        }

        $results = $response->json()['results'] ?? [];

        return view('admin.partials.tmdb-results', compact('results'));
    }

    public function store(Request $request)
    {
        if ($request->input('release_date') === '') {
            $request->merge(['release_date' => null]);
        }

        $validated = $request->validate([
            'tmdb_id' => 'required|string',
            'title' => 'required|string|max:255',
            'overview' => 'nullable|string',
            'poster_path' => 'nullable|string',
            'release_date' => 'nullable|date',
        ]);

        $movie = Movie::updateOrCreate(
            ['tmdb_id' => $validated['tmdb_id']],
            $validated
        );

        if ($request->header('HX-Request')) {
            return view('admin.partials.movie-row', compact('movie'));
        }

        return redirect()->route('admin.movies.index');
    }

    public function destroy(Request $request, Movie $movie)
    {
        $movie->delete();

        if ($request->header('HX-Request')) {
            return response('');
        }

        return redirect()->route('admin.movies.index');
    }
}