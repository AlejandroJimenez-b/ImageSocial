<x-app-layout>
    <x-slot name="slot">
        <div class="py-8">
            <div class="max-w-6xl mx-auto px-4">

                {{-- BIENVENIDO --}}
                <div class="bg-gray-800 rounded-xl shadow-sm border border-gray-700 mb-4 px-6 py-4 text-center text-gray-400">
                    {{ __("Bienvenido/a") }} <span class="text-gray-400 font-semibold">{{ auth()->user()->name }}</span>
                </div>

                {{-- LAYOUT 2 COLUMNAS --}}
                <div class="flex gap-6">

                    {{-- COLUMNA IZQUIERDA — FEED --}}
                    <div class="flex-1">

                        <div class="bg-gray-800 rounded-xl shadow-sm border border-gray-700 mb-4 px-6 py-4 text-center">
                            <h2 class="font-semibold text-xl text-gray-200">{{ __('Feed') }}</h2>
                        </div>
                        @if($images->count() > 0)
                            <div id="feed-container" class="flex flex-col gap-4">
                                @include('partials.images-loop', ['images' => $images])
                            </div>

                            <div id="infinite-scroll-trigger" class="h-10"></div>

                            <div id="loader" class="text-center py-4 hidden">
                                <span class="text-gray-400 text-sm">Cargando más imágenes...</span>
                            </div>

                            <div class="mt-6 flex justify-center">
                                {{ $images->links() }}
                            </div>
                        @else
                            <div class="text-center py-10">
                                <span class="text-gray-400 text-sm">No hay imagenes que mostrar aún</span>
                            </div>
                        @endif

                    </div>

                    {{-- COLUMNA DERECHA — SIDEBAR --}}
                    <div class="w-72 flex-shrink-0">

                        <div class="bg-gray-800 rounded-xl border border-gray-700 p-4 sticky top-6">

                            <h3 class="text-white font-semibold text-sm mb-4 flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                Usuarios activos
                            </h3>

                            @forelse($activeUsers as $activeUser)
                                <div class="flex items-center gap-3 py-2 border-b border-gray-700 last:border-0">

                                    <div class="relative">
                                        <img src="{{ route('user.avatar', ['filename' => $activeUser->image]) }}"
                                            alt="avatar"
                                            class="w-9 h-9 rounded-full object-cover"/>
                                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 rounded-full border-2 border-gray-800"></span>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-white text-xs font-semibold truncate">{{ $activeUser->nick }}</p>
                                        <p class="text-gray-500 text-xs">{{ $activeUser->last_activity->diffForHumans() }}</p>
                                    </div>

                                    {{-- Botón chat si son amigos --}}
                                    @php
                                        $isFriend = \App\Models\Friendship::where(function($q) use ($activeUser) {
                                            $q->where('user_id', auth()->id())
                                              ->where('friend_id', $activeUser->id);
                                        })->orWhere(function($q) use ($activeUser) {
                                            $q->where('user_id', $activeUser->id)
                                              ->where('friend_id', auth()->id());
                                        })->where('status', 'accepted')->exists();
                                    @endphp

                                    @if($isFriend)
                                        <a href="{{ route('chat.show', $activeUser->id) }}"
                                           class="text-indigo-400 hover:text-indigo-300 text-xs transition">
                                            💬
                                        </a>
                                    @endif

                                </div>
                            @empty
                                <p class="text-gray-500 text-xs text-center py-4">No hay usuarios activos ahora mismo.</p>
                            @endforelse

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </x-slot>
</x-app-layout>