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

<body class="bg-neutral-950 font-sans antialiased text-zinc-100">
    <!-- Navigatiebalk -->
    <nav class="bg-zinc-900 border-b border-zinc-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <!-- Logo / Home Link -->
                <a href="{{ route('home') }}" class="font-bold text-xl tracking-tight text-white">
                    MovieApp
                </a>

                <!-- Link naar Mijn Lijst (Library) -->
                <a href="{{ route('library.index') }}"
                    class="text-sm font-medium text-zinc-400 hover:text-white transition-colors">
                    Mijn Lijst
                </a>

                <!-- Admin Link (Alleen zichtbaar voor admins) -->
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.movies.index') }}"
                            class="text-sm font-medium text-zinc-400 hover:text-white transition-colors">
                            Admin Scherm
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Gebruikersmenu (Profiel / Inloggen) -->
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('profile.edit') }}" class="text-sm text-zinc-400 hover:text-white font-medium transition-colors">
                        Naar Profiel
                    </a>
                @else
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-sm text-zinc-400 hover:text-white font-medium transition-colors">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-500 font-medium transition duration-200 hover:scale-105 active:scale-95">
                                Registreren
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hoofdinhoud -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Genre Filter Knoppen -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white mb-5">Films Ontdekken</h1>

            <div class="flex flex-wrap gap-2">
                <!-- 'Alle' knop -->
                <a href="{{ route('home') }}"
                    class="px-4 py-2 rounded-full text-xs font-medium transition duration-200 {{ empty($selectedGenre) ? 'bg-white/10 text-white ring-1 ring-white/15' : 'bg-zinc-800/80 text-zinc-400 hover:bg-zinc-700 hover:text-white' }}">
                    Alle
                </a>

                <!-- Dynamische Genre Knoppen -->
                @foreach($genres as $genre)
                    <a href="{{ route('home', ['genre' => $genre]) }}"
                        class="px-4 py-2 rounded-full text-xs font-medium transition duration-200 {{ $selectedGenre === $genre ? 'bg-white/10 text-white ring-1 ring-white/15' : 'bg-zinc-800/80 text-zinc-400 hover:bg-zinc-700 hover:text-white' }}">
                        {{ $genre }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Film Overzicht Grid -->
        <div>
            <h2 class="text-xl font-semibold tracking-tight mb-6 text-white">
                {{ $selectedGenre ? 'Films in genre: ' . $selectedGenre : 'Beschikbare Films' }}
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5 sm:gap-6">
                @forelse($movies as $movie)
                    <div
                        class="group bg-zinc-900/70 rounded-xl shadow-lg shadow-black/10 border border-zinc-800/80 overflow-hidden hover:border-zinc-700 hover:shadow-black/30 transition duration-300 flex flex-col justify-between">
                        <div>
                            @if($movie->poster_path)
                                <a href="{{ route('movies.show', $movie) }}">
                                    <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}"
                                        alt="{{ $movie->title }}"                                         class="w-full aspect-[2/3] object-cover transition-transform duration-300 ease-out group-hover:scale-105">
                                </a>
                            @else
                                <div class="w-full aspect-[2/3] bg-zinc-800 flex items-center justify-center text-xs text-zinc-500">
                                    Geen poster
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="font-semibold text-sm text-white truncate" title="{{ $movie->title }}">
                                    {{ $movie->title }}
                                </h3>
                                <p class="text-xs font-medium text-zinc-500 mt-1">
                                    {{ $movie->release_date ? substr($movie->release_date, 0, 4) : 'Jaar onbekend' }}
                                </p>
                            </div>
                        </div>

                        <!-- Hartje voor favorieten onderaan het kaartje -->
                        <div class="p-3 pt-0 flex justify-end">
                            @auth
                                <form action="{{ route('movies.favorite', $movie) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-rose-400 hover:text-rose-300 hover:scale-110 active:scale-95 text-xl transition duration-200 cursor-pointer leading-none"
                                        title="{{ auth()->user()->favoriteMovies->contains($movie->id) ? 'Verwijder uit favorieten' : 'Toevoegen aan favorieten' }}">
                                        {{ auth()->user()->favoriteMovies->contains($movie->id) ? '♥︎' : '♡︎' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-zinc-500 hover:text-rose-400 text-xl transition-colors inline-block leading-none"
                                    title="Log in om favorieten op te slaan">
                                    ♡︎
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-zinc-500">
                        Er zijn nog geen films gevonden.
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</body>

</html>