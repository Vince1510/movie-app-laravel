<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-white">Film Beheer</h1>

            <!-- Knop die de Create Overlay inlaadt via HTMX -->
            <button hx-get="{{ route('admin.movies.create') }}" hx-target="#modal-container" hx-swap="innerHTML"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-xl font-medium text-white shadow-lg shadow-indigo-950/30 transition duration-200 hover:scale-105 hover:bg-indigo-500 active:scale-95">
                +
            </button>
        </div>



        <!-- Film Tabel -->
        <table class="w-full overflow-hidden rounded-xl border border-zinc-800 bg-zinc-900/70 text-left shadow-xl shadow-black/20">
            <thead class="bg-zinc-800/80 text-left text-xs uppercase tracking-wider text-zinc-400">
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
                    <td colspan="4" class="p-4 text-center text-zinc-500">
                        Er zijn nog geen films toegevoegd.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Leeg container-element waar de overlays/modals in geladen worden -->
    <div id="modal-container"></div>
</x-app-layout>