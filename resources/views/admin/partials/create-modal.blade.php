<div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-xl shadow-2xl p-6 max-w-lg w-full relative">
        <button type="button" onclick="document.getElementById('modal-container').innerHTML = ''"
            class="absolute top-4 right-4 text-gray-400 hover:text-black font-bold">✕</button>

        <h2 class="text-xl font-bold mb-4 text-gray-900">Film Zoeken op TMDB & Toevoegen</h2>

        <div class="relative mb-4">
            <input type="text" name="search" placeholder="Typ een filmtitel (bijv. Interstellar)..."
                hx-get="{{ route('admin.tmdb.search') }}" hx-trigger="keyup changed delay:300ms, search"
                hx-target="#tmdb-results"
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                autofocus>
        </div>

        <div id="tmdb-results" class="max-h-72 overflow-y-auto space-y-2 border-t pt-3">
            <p class="text-sm text-gray-500 text-center py-4">Typ een titel om te zoeken...</p>
        </div>
    </div>
</div>