<tr id="movie-{{ $movie->id }}" class="border-b border-zinc-800/80 text-zinc-300 transition-colors hover:bg-zinc-800/60">
    <td class="p-3">
        @if($movie->poster_path)
            <img src="https://image.tmdb.org/t/p/w92{{ $movie->poster_path }}"
                class="w-10 h-14 object-cover rounded shadow-sm">
        @else
            <div class="w-10 h-14 rounded bg-zinc-800 flex items-center justify-center text-xs text-zinc-500">N/A</div>
        @endif
    </td>
    <td class="p-3 font-semibold text-white">{{ $movie->title }}</td>
    <td class="p-3">
        <span class="px-2 py-1 text-xs rounded-full bg-emerald-400/10 text-emerald-300 ring-1 ring-emerald-400/20">Actief</span>
    </td>
    <td class="p-3 text-right">
        <button type="button" hx-delete="{{ route('admin.movies.destroy', $movie) }}"
            hx-target="#movie-{{ $movie->id }}" hx-swap="outerHTML"
            hx-confirm="Weet je zeker dat je deze film wilt verwijderen?"
            class="text-rose-400 hover:text-rose-300 text-xs font-semibold px-2 py-1 cursor-pointer transition-colors">
            Verwijderen
        </button>
    </td>
</tr>