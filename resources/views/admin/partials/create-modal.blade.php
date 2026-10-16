<div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
    <div class="bg-zinc-900 border border-zinc-700/70 rounded-2xl shadow-2xl shadow-black/50 p-6 max-w-lg w-full relative">
        <button type="button" onclick="document.getElementById('modal-container').innerHTML = ''"
            class="absolute top-4 right-4 text-zinc-500 hover:text-white font-bold transition-colors">✕</button>

        <h2 class="text-xl font-semibold mb-4 text-white">Film Zoeken op TMDB & Toevoegen</h2>

        <div class="relative mb-4">
            <input type="text" name="search" placeholder="Typ een filmtitel (bijv. Interstellar)..."
                hx-get="{{ route('admin.tmdb.search') }}" hx-trigger="keyup changed delay:300ms, search"
                hx-target="#tmdb-results"
                class="w-full bg-zinc-800/90 backdrop-blur-md border border-zinc-700/50 rounded-xl p-3 text-sm text-zinc-100 placeholder:text-zinc-500 shadow-2xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40 outline-none transition"
                autofocus>
        </div>

        <div id="tmdb-results" class="max-h-72 overflow-y-auto space-y-2 border-t border-zinc-800 pt-3">
            <p class="text-sm text-zinc-500 text-center py-4">Typ een titel om te zoeken...</p>
        </div>
    </div>
</div>