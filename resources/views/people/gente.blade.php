<x-app-layout>
    <x-slot name="header">
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl py-4 text-gray-800 dark:text-gray-200 leading-tight text-center">
                {{ __('Gente') }}
            </h2>
        </div>
    </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            @foreach($users as $user)

                @php
                    $friendship = \App\Models\Friendship::where(function($q) use ($user) {
                        $q->where('user_id', auth()->id())
                          ->where('friend_id', $user->id);
                    })->orWhere(function($q) use ($user) {
                        $q->where('user_id', $user->id)
                          ->where('friend_id', auth()->id());
                    })->first();
                @endphp

                <div class="bg-gray-800 rounded-xl p-5 flex items-center gap-4 border border-gray-700 hover:border-indigo-500 transition">

                    {{-- AVATAR --}}
                    <a href="{{ route('gente.profile', $user->id) }}">
                        <img src="{{ route('user.avatar', ['filename' => $user->image]) }}"
                            alt="avatar"
                            class="w-14 h-14 rounded-full object-cover flex-shrink-0"/>
                    </a>

                    {{-- INFO --}}
                    <a href="{{ route('gente.profile', $user->id) }}" class="flex-1">
                        <p class="text-white font-semibold text-sm">{{ $user->name }} {{ $user->surname }}</p>
                        <p class="text-gray-400 text-xs mt-0.5">{{' @'.$user->nick }}</p>
                    </a>

                    {{-- BOTÓN AMISTAD --}}
                    @if(auth()->id() != $user->id)
                        @if(!$friendship)
                            <form action="{{ route('friends.send', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                    + Añadir amigo
                                </button>
                            </form>

                        @elseif($friendship->status == 'pending' && $friendship->user_id == auth()->id())
                            {{-- Yo envié -> botón cancelar --}}
                            <form action="{{ route('friends.cancel', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="bg-gray-600 hover:bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                    Solicitud enviada   ❌
                                </button>
                            </form>

                        @elseif($friendship->status == 'pending' && $friendship->friend_id == auth()->id())
                            <div class="flex gap-2">
                                <form action="{{ route('friends.accept', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                        Aceptar
                                    </button>
                                </form>
                                <form action="{{ route('friends.reject', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                        Rechazar
                                    </button>
                                </form>
                            </div>

                        @elseif($friendship->status == 'accepted')
                            <div class="flex gap-2 items-center">
                                <span class="text-green-400 text-xs font-semibold">✓ Amigos</span>
                                <form action="{{ route('friends.delete', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>

                        @endif
                    @endif

                </div>

            @endforeach

        </div>
    </div>
</x-app-layout>