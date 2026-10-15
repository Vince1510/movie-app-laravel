<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Film Beheer</h1>

            <!-- Knop die de Create Overlay inlaadt via HTMX -->
            <button hx-get="{{ route('admin.movies.create') }}" hx-target="#modal-container" hx-swap="innerHTML">
                +
            </button>
        </div>



        <!-- Film Tabel -->
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-left text-gray-600 uppercase text-xs">
                <tr>
                    <th class="p-3">Poster</th>
                    <th class="p-3">Titel</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Acties</th>
                </tr>
            </thead>
            <tbody id="movies-list">
                @foreach($movies as $movie)
                    @include('admin.partials.movie-row', ['movie' => $movie])
                @endforeach

                <!-- met css hidden -->
                <tr class="only:table-row hidden">
                    <td colspan="4" class="p-4 text-center text-gray-500">
                        Er zijn nog geen films toegevoegd.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Leeg container-element waar de overlays/modals in geladen worden -->
    <div id="modal-container"></div>
</x-app-layout>