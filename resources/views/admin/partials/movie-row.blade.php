<tr id="movie-row-{{ $movie->id }}" class="border-b hover:bg-gray-50">
    <td class="p-3">
        <img src="{{ $movie->poster_url }}" class="w-12 h-16 object-cover rounded">
    </td>
    <td class="p-3 font-semibold">{{ $movie->title }}</td>
    <td class="p-3">
        <!-- Status Button (Verplichte eis: POST / Toggle via HTMX) -->
        <button hx-post="{{ route('admin.movies.toggle-status', $movie) }}" hx-target="#movie-row-{{ $movie->id }}"
            hx-swap="outerHTML"
            class="px-2 py-1 rounded text-xs font-bold {{ $movie->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $movie->is_active ? 'Actief' : 'Concept' }}
        </button>
    </td>
    <td class="p-3 text-right space-x-2">
        <!-- Edit Knop: laadt Edit Overlay in -->
        <button hx-get="{{ route('admin.movies.edit', $movie) }}" hx-target="#modal-container"
            class="text-blue-600 hover:underline">
            Bewerken
        </button>

        <!-- Delete Knop: verwijdert de rij direct uit de DOM -->
        <button hx-delete="{{ route('admin.movies.destroy', $movie) }}"
            hx-confirm="Weet je zeker dat je {{ $movie->title }} wilt verwijderen?"
            hx-target="#movie-row-{{ $movie->id }}" hx-swap="outerHTML swap:0.5s" class="text-red-600 hover:underline">
            Verwijderen
        </button>
    </td>
</tr>