<div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full relative">
        <button onclick="document.getElementById('modal-container').innerHTML = ''"
            class="absolute top-3 right-3 text-gray-500 hover:text-black">✕</button>

        <h2 class="text-xl font-bold mb-4">Film Zoeken op TMDB & Toevoegen</h2>

        <!-- HTMX Live Zoekveld in TMDB -->
        <input type="text" name="search" placeholder="Typ een filmtitel..." hx-get="{{ route('admin.tmdb.search') }}"
            hx-trigger="keyup changed delay:500ms" hx-target="#tmdb-results" class="w-full border rounded p-2 mb-4">

        <!-- Resultatenlijst van TMDB -->
        <div id="tmdb-results" class="max-h-60 overflow-y-auto space-y-2">
            <p class="text-sm text-gray-500">Typ een titel om te zoeken...</p>
        </div>
    </div>
</div>