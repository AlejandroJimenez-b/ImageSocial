<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">

                        <svg 
                            viewBox="260 40 160 130"
                            role="img"
                            class="block h-10 w-auto">

                            <title>ImageSocial logo</title>

                            <polygon points="340,48 390,76 390,132 340,160 290,132 290,76"
                                fill="#1e293b"
                                stroke="#6366f1"
                                stroke-width="2.5"/>

                            <polygon points="340,58 382,82 382,128 340,152 298,128 298,82"
                                fill="#0f172a"
                                stroke="#4f46e5"
                                stroke-width="1"/>

                            <rect x="316" y="78" width="22" height="6" rx="3" fill="#6366f1"/>
                            <rect x="324" y="84" width="6" height="40" rx="3" fill="#818cf8"/>
                            <rect x="316" y="124" width="22" height="6" rx="3" fill="#6366f1"/>

                            <path d="M344 84 Q344 78 352 78 Q364 78 364 90 Q364 100 352 103 Q340 106 340 116 Q340 130 352 130 Q364 130 364 124"
                                fill="none"
                                stroke="#a5b4fc"
                                stroke-width="5.5"
                                stroke-linecap="round"/>

                            <circle cx="385" cy="72" r="4" fill="#6366f1" opacity="0.7"/>
                            <circle cx="393" cy="80" r="2.5" fill="#818cf8" opacity="0.5"/>
                            <circle cx="390" cy="65" r="2" fill="#4f46e5" opacity="0.6"/>
                            <circle cx="295" cy="138" r="4" fill="#6366f1" opacity="0.7"/>
                            <circle cx="287" cy="130" r="2.5" fill="#818cf8" opacity="0.5"/>

                        </svg>

                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Inicio') }}
                    </x-nav-link>
                </div>
                <!-- Amigos -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('friends.view')" :active="request()->routeIs('friends.*')">
                        <div class="relative inline-flex items-center pr-4">
                            {{ __('Amigos') }}

                            @php
                                $pendingCount = \App\Models\Friendship::where('friend_id', auth()->id())
                                    ->where('status', 'pending')
                                    ->count();
                            @endphp
                        </div>
                        <div class="relative inline-flex items-center justify-center mb">
                        @if($pendingCount > 0)
                            <span class="absolute -top-0 -right-1 bg-indigo-500 text-white text-xs font-bold w-4 h-4 rounded-full flex items-center justify-center">
                                {{ $pendingCount }}
                            </span>
                        @endif
                        </div>
                    </x-nav-link>
                </div>
                <!-- gente -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('gente.view')" :active="request()->routeIs('gente.*')">
                        {{ __('Gente') }}
                    </x-nav-link>
                </div>
                <!-- favoritos -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('favoritos.view')" :active="request()->routeIs('favoritos.*')">
                        {{ __('Favoritos') }}
                    </x-nav-link>
                </div>
                <!-- imagen -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('images.view')" :active="request()->routeIs('images.*')">
                        {{ __('Subir imagen') }}
                    </x-nav-link>
                </div>
                <!-- Chat -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.*')">
                        <div class="relative inline-flex items-center pr-4">
                            {{ __('Chat') }}
                            @php
                                $unreadCount = \App\Models\Message::where('receiver_id', auth()->id())
                                    ->whereNull('read_at')
                                    ->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute -top-0 -right-1 bg-indigo-500 text-white text-xs font-bold w-4 h-4 rounded-full flex items-center justify-center">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </div>
                    </x-nav-link>
                </div>

                <!-- buscador -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <form action="{{ route('search.view') }}" method="GET" class="flex items-center">
                        <input 
                            type="text" 
                            name="q"
                            placeholder="Buscar..."
                            value="{{ request('q') }}"
                            class="bg-gray-700 text-gray-200 text-sm rounded-lg px-4 py-1.5 w-48 focus:w-64 focus:outline-none focus:ring-1 focus:ring-indigo-500 border border-gray-600 placeholder-gray-400 transition-all duration-300"/>
                    </form>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            @include('includes.avatar')
                            <span>{{ auth()->user()->name }}</span>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Ir a inicio desde el menu desplegable(agregado por mi) -->
                        <x-dropdown-link :href="route('dashboard')">
                            {{ __('Inicio') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('gente.profile', auth()->user()->id)">
                            {{ __('Mi perfil') }}
                        </x-dropdown-link>
                        
                        <!-- Configuracion (agregado por mi) -->
                        <x-dropdown-link :href="route('config.view')">
                            {{ __('Configuracion') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
