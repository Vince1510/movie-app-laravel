<tr id="movie-{{ $movie->id }}" class="border-b border-gray-100 hover:bg-gray-50 transition">
    <td class="p-3">
        @if($movie->poster_path)
            <img src="https://image.tmdb.org/t/p/w92{{ $movie->poster_path }}"
                class="w-10 h-14 object-cover rounded shadow-sm">
        @else
            <div class="w-10 h-14 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-400">N/A</div>
        @endif
    </td>
    <td class="p-3 font-semibold text-gray-800">{{ $movie->title }}</td>
    <td class="p-3">
        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Actief</span>
    </td>
    <td class="p-3 text-right">
        <button type="button" hx-delete="{{ route('admin.movies.destroy', $movie) }}"
            hx-target="#movie-{{ $movie->id }}" hx-swap="outerHTML"
            hx-confirm="Weet je zeker dat je deze film wilt verwijderen?"
            class="text-red-600 hover:text-red-800 text-xs font-semibold px-2 py-1 cursor-pointer">
            Verwijderen
        </button>
    </td>
</tr>