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

<body>
    <div>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.movies.index') }}" class="text-blue-600 font-bold">
                    Admin Scherm
                </a>
            @endif
        @endauth
        @auth
            <a href="{{ route('profile.edit') }}">
                Naar Profiel
            </a>
        @else
            <div>
                <a href="{{ route('login') }}">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">
                        Registreren
                    </a>
                @endif
            </div>
        @endauth
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Beschikbare Films</h1>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @forelse($movies as $movie)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                        @if($movie->poster_path)
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }}"
                                class="w-full h-72 object-cover">
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
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        Er zijn nog geen films toegevoegd.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>

</html>