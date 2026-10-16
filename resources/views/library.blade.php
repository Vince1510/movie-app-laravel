<x-app-layout>
    <div class="py-10 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white mb-8">Mijn Lijst</h1>

            @if($movies->isEmpty())
                <div class="bg-zinc-900/70 border border-zinc-800 p-8 rounded-2xl shadow-xl text-center text-zinc-400">
                    Je hebt nog geen favoriete films opgeslagen.
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5 sm:gap-6">
                    @foreach($movies as $movie)
                        <div class="group bg-zinc-900/70 border border-zinc-800 rounded-xl shadow-lg shadow-black/10 overflow-hidden flex flex-col justify-between transition duration-300 hover:border-zinc-700 hover:shadow-black/30">
                            <a href="{{ route('movies.show', $movie) }}">
                                @if($movie->poster_path)
                                    <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }}"
                                        class="w-full aspect-[2/3] object-cover transition-transform duration-300 ease-out group-hover:scale-105">
                                @else
                                    <div class="w-full aspect-[2/3] bg-zinc-800 flex items-center justify-center text-zinc-500 text-sm">Geen
                                        poster</div>
                                @endif
                                <div class="p-4">
                                    <h2 class="font-semibold text-white text-sm truncate">{{ $movie->title }}</h2>
                                </div>
                            </a>

                            <!-- Knop om te verwijderen uit favorieten -->
                            <div class="p-4 pt-0">
                                <form action="{{ route('movies.favorite', $movie) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-zinc-800 text-zinc-300 hover:bg-rose-500/15 hover:text-rose-300 text-xs py-2.5 px-3 rounded-lg transition duration-200 font-medium">
                                        Verwijderen uit lijst
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>