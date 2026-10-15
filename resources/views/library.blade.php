<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Mijn Lijst</h1>

            @if($movies->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                    Je hebt nog geen favoriete films opgeslagen.
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($movies as $movie)
                        <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col justify-between">
                            <a href="{{ route('movies.show', $movie) }}">
                                @if($movie->poster_path)
                                    <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }}"
                                        class="w-full h-64 object-cover">
                                @else
                                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500 text-sm">Geen
                                        poster</div>
                                @endif
                                <div class="p-4">
                                    <h2 class="font-bold text-gray-800 text-sm truncate">{{ $movie->title }}</h2>
                                </div>
                            </a>

                            <!-- Knop om te verwijderen uit favorieten -->
                            <div class="p-4 pt-0">
                                <form action="{{ route('movies.favorite', $movie) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-red-100 text-red-600 hover:bg-red-200 text-xs py-2 px-3 rounded transition font-medium">
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