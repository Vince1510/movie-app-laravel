@forelse($results as $item)
    <div
        class="flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg transition mb-2">
        <div class="flex items-center space-x-3">
            @if(!empty($item['poster_path']))
                <img src="https://image.tmdb.org/t/p/w92{{ $item['poster_path'] }}"
                    class="w-12 h-16 object-cover rounded shadow-sm">
            @else
                <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">
                    Geen poster
                </div>
            @endif

            <div class="max-w-xs">
                <h4 class="font-bold text-gray-900 text-sm truncate">{{ $item['title'] }}</h4>
                <p class="text-xs text-gray-500 mb-1">
                    {{ !empty($item['release_date']) ? substr($item['release_date'], 0, 4) : 'Jaar onbekend' }}
                </p>
                <p class="text-xs text-gray-600 line-clamp-2">
                    {{ $item['overview'] ?? 'Geen beschrijving beschikbaar.' }}
                </p>
            </div>
        </div>

        <form hx-post="{{ route('admin.movies.store') }}" hx-target="#movies-list" hx-swap="beforeend"
            hx-on::after-request="if(event.detail.successful) document.getElementById('modal-container').innerHTML = ''">
            @csrf
            <input type="hidden" name="tmdb_id" value="{{ $item['id'] }}">
            <input type="hidden" name="title" value="{{ $item['title'] }}">
            <input type="hidden" name="overview" value="{{ $item['overview'] ?? '' }}">
            <input type="hidden" name="poster_path" value="{{ $item['poster_path'] ?? '' }}">
            <input type="hidden" name="release_date" value="{{ $item['release_date'] ?? null }}">

            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition cursor-pointer">
                + Toevoegen
            </button>
        </form>
    </div>
@empty
    <p class="text-sm text-gray-500 text-center py-4">Geen films gevonden voor deze zoekopdracht.</p>
@endforelse