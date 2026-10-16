<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2.5 bg-zinc-800 border border-zinc-700 rounded-lg font-semibold text-xs text-zinc-200 uppercase tracking-widest shadow-sm hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-zinc-900 disabled:opacity-25 transition duration-200']) }}>
    {{ $slot }}
</button>
