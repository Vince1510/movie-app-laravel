<nav x-data="{ open: false }" class="bg-zinc-900 border-b border-zinc-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-6">
                <a href="{{ route('home') }}" class="font-bold text-xl tracking-tight text-white">
                    MovieApp
                </a>

                <a href="{{ route('library.index') }}"
                    class="hidden sm:inline-flex text-sm font-medium text-zinc-400 hover:text-white transition-colors">
                    Mijn Lijst
                </a>

                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.movies.index') }}"
                            class="hidden sm:inline-flex text-sm font-medium text-zinc-400 hover:text-white transition-colors">
                            Admin Scherm
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-2 px-3 py-2 border border-zinc-700/70 text-sm leading-4 font-medium rounded-lg text-zinc-300 bg-zinc-800/70 hover:text-white hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition duration-200">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profiel') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Uitloggen') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Inloggen</a>
                        <a href="{{ route('register') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Registreren</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger (Mobiel) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-lg text-zinc-400 hover:text-white hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu (Mobiel) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth
            <div class="pt-4 pb-1 border-t border-zinc-800">
                <div class="px-4 mb-3">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-zinc-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('library.index')">
                        Mijn Lijst
                    </x-responsive-nav-link>

                    @if(auth()->user()->is_admin)
                        <x-responsive-nav-link :href="route('admin.movies.index')">
                            Admin Scherm
                        </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profiel') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Uitloggen') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('library.index')">Mijn Lijst</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('login')">Inloggen</x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')">Registreren</x-responsive-nav-link>
                @endif
            </div>
        @endauth
    </div>
</nav>