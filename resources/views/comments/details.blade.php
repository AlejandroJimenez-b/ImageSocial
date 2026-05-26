<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">

        {{-- IMAGEN A PANTALLA COMPLETA --}}
        <div class="bg-gray-800 mt-4 rounded-xl overflow-hidden shadow-xl p-3">
            <img src="{{ route('images.show', $image->image_path) }}"
                 alt="imagen"
                 class="max-full h-full w-auto mx-auto rounded-lg"/>
        </div>

        {{-- INFO BÁSICA --}}
        <div class="mt-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <p class="text-gray-500 text-sm">Subida por | <span class="text-white font-semibold">@ {{ $image->user->nick }}</span></p>
                <img class="w-6 h-6 rounded-full object-cover " src="{{ route('user.avatar', ['filename' => $image->user->image]) }}">
                <p class="text-gray-500 text-xs mt-1">{{ $image->created_at_human }}</p>

                {{-- LIKES --}}
                @if($likesCount == 1)
                <div class="flex items-center gap-2 text-gray-500 text-sm">
                    <p class="text-gray-500 text-sm">[</p>
                    ❤️ <span class="font-semibold text-white">{{ $likesCount }}</span> 
                        <span class="text-gray-500">Like</span>
                    <p class="text-gray-500 text-sm">]</p>
                </div>
                @else
                <div class="flex items-center gap-2 text-red-400 text-sm">
                    <p class="text-gray-500 text-sm">[</p>
                    ❤️ <span class="font-semibold text-white">{{ $likesCount }}</span>
                        <span class="text-gray-400">Likes</span>
                    <p class="text-gray-500 text-sm">]</p>
                </div>
                @endif

            </div>
            <!-- eliminar -->
            {{-- BOTÓN ELIMINAR (solo dueño) --}}
            @if(auth()->id() == $image->user_id)
                <div class="mt-5 flex justify-end">
                    <button type="button"
                            class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg m-2"
                            onclick="document.getElementById('modal-delete').classList.remove('hidden')">
                        🗑️ Eliminar imagen
                    </button>

                    <form action="{{ route('images.update', $image->id) }}" method="GET">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg"
                                onclick="document.getElementById('modal-edit').classList.remove('hidden')">
                                🖌 Editar imagen
                            </button>
                    </form>

                </div>
                   
                {{-- MODAL CONFIRMACIÓN --}}
                <div id="modal-delete" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
                    <div class="bg-gray-800 rounded-xl shadow-xl p-6 max-w-sm w-full mx-4">
                        <h3 class="text-white text-lg font-semibold mb-2">¿Eliminar imagen?</h3>
                        <p class="text-gray-400 text-sm mb-6">Esta acción no se puede deshacer. Se eliminarán también todos sus comentarios y likes.</p>

                        <div class="flex gap-3 justify-end">
                            {{-- Cancelar --}}
                            <button type="button"
                                    class="bg-gray-600 hover:bg-gray-700 text-white text-sm px-4 py-2 rounded-lg"
                                    onclick="document.getElementById('modal-delete').classList.add('hidden')">
                                Cancelar
                            </button>

                            {{-- Confirmar --}}
                            <form action="{{ route('images.delete', $image->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg">
                                    Sí, eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        

        {{-- DESCRIPCIÓN --}}
        @if($image->description)
        <div class="mt-4 bg-gray-800 border-l-8 border-indigo-500 rounded-r-lg px-4 py-3">
            <p class="mb-2 text-white text-mm italic text-center">{{ $image->description }}</p>
        </div>
        @endif


        <hr class="my-6 border-gray-500 mb-2"/>

        {{-- COMENTARIOS --}}
        <h2 class="text-white text-lg font-semibold mb-4">Comentarios ({{ count($comments) }})</h2>

        @forelse($comments as $comment)
            <div class="bg-gray-800 rounded-lg p-4 mb-3 flex gap-3 items-start">
                <img class="w-8 h-8 rounded-full object-cover flex-shrink-0" src="{{ route('user.avatar', ['filename' => $comment->user->image]) }}">
                <div>
                    <p class="text-indigo-400 text-gray-500 text-xs font-semibold mb-1">{{ $comment->user->nick }}</p>
                    <p class="text-white text-sm">{{ $comment->content }}</p>
                    <p class="text-gray-500 text-xs mt-1">{{ $comment->created_at_human }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-sm">No hay comentarios aún.</p>
        @endforelse

    </div>
</x-app-layout>