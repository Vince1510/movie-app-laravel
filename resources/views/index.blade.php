<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigatiebalk -->
    <nav class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <!-- Logo / Home Link -->
                <a href="{{ route('home') }}" class="font-bold text-xl text-indigo-600">
                    MovieApp
                </a>

                <!-- Link naar Mijn Lijst (Library) -->
                <a href="{{ route('library.index') }}"
                    class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition">
                    Mijn Lijst
                </a>

                <!-- Admin Link (Alleen zichtbaar voor admins) -->
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.movies.index') }}"
                            class="text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                            Admin Scherm
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Gebruikersmenu (Profiel / Inloggen) -->
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                        Naar Profiel
                    </a>
                @else
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-sm bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 font-medium transition">
                                Registreren
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hoofdinhoud -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Genre Filter Knoppen -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Films Ontdekken</h1>

            <div class="flex flex-wrap gap-2">
                <!-- 'Alle' knop -->
                <a href="{{ route('home') }}"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition {{ empty($selectedGenre) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Alle
                </a>

                <!-- Dynamische Genre Knoppen -->
                @foreach($genres as $genre)
                    <a href="{{ route('home', ['genre' => $genre]) }}"
                        class="px-3 py-1.5 rounded-full text-xs font-semibold transition {{ $selectedGenre === $genre ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ $genre }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Film Overzicht Grid -->
        <div>
            <h2 class="text-xl font-bold mb-6 text-gray-800">
                {{ $selectedGenre ? 'Films in genre: ' . $selectedGenre : 'Beschikbare Films' }}
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @forelse($movies as $movie)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            @if($movie->poster_path)
                                <a href="{{ route('movies.show', $movie) }}">
                                    <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}"
                                        alt="{{ $movie->title }}" class="w-full h-72 object-cover">
                                </a>
                            @else
                                <div class="w-full h-72 bg-gray-200 flex items-center justify-center text-xs text-gray-400">
                                    Geen poster
                                </div>
                            @endif

                            <div class="p-3">
                                <h3 class="font-bold text-sm text-gray-900 truncate" title="{{ $movie->title }}">
                                    {{ $movie->title }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $movie->release_date ? substr($movie->release_date, 0, 4) : 'Jaar onbekend' }}
                                </p>
                            </div>
                        </div>

                        <!-- Hartje voor favorieten onderaan het kaartje -->
                        <div class="p-3 pt-0 flex justify-end">
                            @auth
                                <form action="{{ route('movies.favorite', $movie) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:scale-110 transition cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                            fill="{{ auth()->user()->favoriteMovies->contains($movie->id) ? 'currentColor' : 'none' }}"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.646a4.5 4.5 0 00-1.78-7.64-4.5 4.5 0 00-5.902.162L12 5.25l-1.002-1.014a4.5 4.5 0 00-6.68 0z" />
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-400 hover:text-red-500 transition"
                                    title="Log in om favorieten op te slaan">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.646a4.5 4.5 0 00-1.78-7.64-4.5 4.5 0 00-5.902.162L12 5.25l-1.002-1.014a4.5 4.5 0 00-6.68 0z" />
                                    </svg>
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        Er zijn nog geen films gevonden.
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</body>

</html>