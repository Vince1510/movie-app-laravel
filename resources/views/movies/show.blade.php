<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Terugknop -->
            <a href="{{ route('home') }}"
                class="inline-flex items-center mb-6 text-sm font-medium text-gray-600 hover:text-gray-900">
                &larr; Terug naar overzicht
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 flex flex-col md:flex-row gap-8">
                    <!-- Poster -->
                    <div class="w-full md:w-1/3 flex-shrink-0">
                        @if($movie->poster_path)
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }}"
                                class="w-full h-auto rounded-lg shadow-md object-cover">
                        @else
                            <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                                Geen poster beschikbaar
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="w-full md:w-2/3 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                    {{ $movie->title }}
                                </h1>

                                <!-- Favorietenknop (Hartje) -->
                                @auth
                                    <form action="{{ route('movies.favorite', $movie) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-500 hover:scale-110 transition cursor-pointer"
                                            title="{{ auth()->user()->favoriteMovies->contains($movie->id) ? 'Verwijder uit favorieten' : 'Toevoegen aan favorieten' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"
                                                fill="{{ auth()->user()->favoriteMovies->contains($movie->id) ? 'currentColor' : 'none' }}"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.646a4.5 4.5 0 00-1.78-7.64-4.5 4.5 0 00-5.902.162L12 5.25l-1.002-1.014a4.5 4.5 0 00-6.68 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="text-gray-400 hover:text-red-500 transition inline-block"
                                        title="Log in om toe te voegen aan favorieten">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.646a4.5 4.5 0 00-1.78-7.64-4.5 4.5 0 00-5.902.162L12 5.25l-1.002-1.014a4.5 4.5 0 00-6.68 0z" />
                                        </svg>
                                    </a>
                                @endauth
                            </div>

                            <!-- Meta informatie -->
                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                                @if($movie->release_date)
                                    <span>Uitgebracht:
                                        {{ \Carbon\Carbon::parse($movie->release_date)->format('d-m-Y') }}</span>
                                @endif

                                @if($movie->genre)
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded">
                                        {{ $movie->genre }}
                                    </span>
                                @endif
                            </div>

                            <!-- Beschrijving -->
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Samenvatting</h2>
                            <p class="text-gray-600 leading-relaxed">
                                {{ $movie->overview ?? 'Geen beschrijving beschikbaar voor deze film.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>