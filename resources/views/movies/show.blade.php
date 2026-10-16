<x-app-layout>
    <div class="py-10 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Terugknop -->
            <a href="{{ route('home') }}"
                class="inline-flex items-center mb-6 text-sm font-medium text-zinc-400 hover:text-white transition-colors">
                &larr; Terug naar overzicht
            </a>

            <div class="bg-zinc-900/70 border border-zinc-800 overflow-hidden shadow-xl shadow-black/20 rounded-2xl">
                <div class="p-6 md:p-8 flex flex-col md:flex-row gap-8">
                    <!-- Poster -->
                    <div class="w-full md:w-1/3 flex-shrink-0">
                        @if($movie->poster_path)
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }}"
                                class="w-full h-auto rounded-xl shadow-lg object-cover">
                        @else
                            <div class="w-full h-96 bg-zinc-800 rounded-xl flex items-center justify-center text-zinc-500">
                                Geen poster beschikbaar
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="w-full md:w-2/3 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <h1 class="text-3xl font-bold tracking-tight text-white mb-2">
                                    {{ $movie->title }}
                                </h1>

                                <!-- Favorietenknop (Hartje) -->
                                @auth
                                    <form action="{{ route('movies.favorite', $movie) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="text-rose-400 hover:text-rose-300 hover:scale-110 active:scale-95 text-3xl transition duration-200 cursor-pointer leading-none"
                                            title="{{ auth()->user()->favoriteMovies->contains($movie->id) ? 'Verwijder uit favorieten' : 'Toevoegen aan favorieten' }}">
                                            {{ auth()->user()->favoriteMovies->contains($movie->id) ? '♥︎' : '♡︎' }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="text-zinc-500 hover:text-rose-400 text-3xl transition-colors inline-block leading-none"
                                        title="Log in om toe te voegen aan favorieten">
                                        ♡︎
                                    </a>
                                @endauth
                            </div>

                            <!-- Meta informatie -->
                            <div class="flex items-center gap-4 text-sm text-zinc-400 mb-6">
                                @if($movie->release_date)
                                    <span>Uitgebracht:
                                        {{ \Carbon\Carbon::parse($movie->release_date)->format('d-m-Y') }}</span>
                                @endif

                                @if($movie->genre)
                                    <span
                                        class="bg-white/10 text-zinc-200 text-xs font-medium px-3 py-1 rounded-full ring-1 ring-white/10">
                                        {{ $movie->genre }}
                                    </span>
                                @endif
                            </div>

                            <!-- Beschrijving -->
                            <h2 class="text-lg font-semibold text-white mb-2">Samenvatting</h2>
                            <p class="text-zinc-400 leading-relaxed">
                                {{ $movie->overview ?? 'Geen beschrijving beschikbaar voor deze film.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>