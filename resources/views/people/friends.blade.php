<x-app-layout>
    <x-slot name="header">
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl py-4 text-gray-800 dark:text-gray-200 leading-tight text-center">
                {{ __('Amigos') }}
            </h2>
        </div>
    </div>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-8 px-4 pb-10">

        {{-- SOLICITUDES PENDIENTES --}}
        @if(count($pendingReceived) > 0)
            <div class="mb-8">
                <h2 class="text-white font-semibold text-base mb-4">
                    Solicitudes pendientes
                    <span class="bg-indigo-600 text-white text-xs font-bold px-2 py-0.5 rounded-full ml-2">
                        {{ count($pendingReceived) }}
                    </span>
                </h2>

                <div class="flex flex-col gap-3">
                    @foreach($pendingReceived as $request)
                        <div class="bg-gray-800 rounded-xl p-4 flex items-center gap-4 border border-gray-700">

                            <img src="{{ route('user.avatar', ['filename' => $request->sender->image]) }}"
                                alt="avatar"
                                class="w-14 h-14 rounded-full object-cover flex-shrink-0"/>

                            <div class="flex-1">
                                <p class="text-white text-sm font-semibold">{{ $request->sender->name }} {{ $request->sender->surname }}</p>
                                <p class="text-gray-400 text-xs">@ {{ $request->sender->nick }}</p>
                            </div>

                            <div class="flex gap-2">
                                <form action="{{ route('friends.accept', $request->user_id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                        Aceptar
                                    </button>
                                </form>
                                <form action="{{ route('friends.reject', $request->user_id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                        Rechazar
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="border-gray-700 mb-8"/>
        @endif

        {{-- MIS AMIGOS --}}
        <h2 class="text-white font-semibold text-base mb-4">
            Mis amigos
            <span class="text-gray-500 font-normal text-sm">({{ count($friends) }})</span>
        </h2>

        @if(count($friends) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($friends as $friendship)

                    {{-- Determinar cual de los dos es el amigo (no yo) --}}
                    @php
                        $friend = $friendship->user_id == auth()->id()
                            ? $friendship->receiver
                            : $friendship->sender;
                    @endphp

                    <a href="{{ route('gente.profile', $friend->id) }}">
                        <div class="bg-gray-800 rounded-xl p-4 flex items-center gap-4 border border-gray-700 hover:border-indigo-500 transition">

                            <img src="{{ route('user.avatar', ['filename' => $friend->image]) }}"
                                alt="avatar"
                                class="w-14 h-14 rounded-full object-cover flex-shrink-0"/>

                            <div>
                                <p class="text-white text-sm font-semibold">{{ $friend->name }} {{ $friend->surname }}</p>
                                <p class="text-gray-400 text-xs">@ {{ $friend->nick }}</p>
                            </div>

                        </div>
                    </a>

                @endforeach
            </div>

        @else
            <p class="text-gray-500 text-sm">No tienes amigos aún. ¡Ve a la sección Gente para encontrar gente!</p>
        @endif

    </div>

</x-app-layout>