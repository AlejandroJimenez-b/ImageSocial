<x-app-layout>
<div class="max-w-3xl mx-auto mt-8 py-1 pb-4">

    {{-- CABECERA PERFIL --}}
    <div class="bg-gray-800 rounded-xl p-6 flex items-center gap-5 border border-gray-700">

        <img src="{{ route('user.avatar', ['filename' => $user->image]) }}"
             alt="avatar"
             class="w-20 h-20 rounded-full object-cover flex-shrink-0 border-2 border-indigo-500"/>

        <div class="flex-1">
            <p class="text-white font-semibold text-lg">{{ $user->name }} {{ $user->surname }}</p>
            <p class="text-gray-400 text-sm mt-0.5"> {{' @'.$user->nick }}</p>
            <p class="text-gray-500 text-xs mt-1">{{ count($images) }} publicaciones</p>
        </div>

        {{-- BOTÓN AMISTAD (solo en perfiles ajenos) --}}
        @if(auth()->id() != $user->id)

            @if(!$friendship)
                {{-- Sin relacion -> Añadir amigo --}}
                <form action="{{ route('friends.send', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                        + Añadir amigo
                    </button>
                </form>

            @elseif($friendship->status == 'pending' && $friendship->user_id == auth()->id())
                {{-- Yo envié la solicitud -> esperando --}}
                <span class="text-gray-400 text-xs font-semibold px-4 py-2 rounded-lg border border-gray-600">
                    Solicitud enviada
                </span>

            @elseif($friendship->status == 'pending' && $friendship->friend_id == auth()->id())
                {{-- Me enviaron a mi -> Aceptar o Rechazar --}}
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
                {{-- Ya sois amigos --}}
                <div class="flex gap-2 items-center">
                    <span class="text-green-400 text-xs font-semibold">✓ Amigos</span>
                    <form action="{{ route('friends.delete', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                            Eliminar amigo
                        </button>
                    </form>
                </div>

            @endif

        @endif

        {{-- BOTÓN EDITAR solo si es tu propio perfil --}}
        @if(auth()->id() == $user->id)
            <a href="{{ route('config.view') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                ✏️ Editar perfil
            </a>
        @endif

    </div>

    <hr class="my-6 mt-2 mb-2 border-gray-700"/>

    {{-- IMÁGENES --}}
    <h2 class="text-white font-semibold text-base mb-4 text-center">Publicaciones</h2>

    @forelse($images as $image)

        <div class="bg-gray-800 rounded-xl overflow-hidden border border-gray-700 hover:border-indigo-500 transition mb-4">


            <div class="max-w-7xl mx-auto items-center justify-between">
                <x-image-card :image="$image" />
            </div>

        </div>

    @empty
        <p class="text-gray-500 text-sm">Este usuario no tiene publicaciones aún.</p>
    @endforelse

</div>

</x-app-layout>