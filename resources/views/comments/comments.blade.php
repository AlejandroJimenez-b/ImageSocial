<x-app-layout>

<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md">

    <!-- Cabecera -->
    <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-3 border-b border-gray-100">
        Comentarios
    </h3>

    <!-- Formulario -->
    <form action="{{ route('comments.store', ['image_id' => $image->id]) }}" method="POST" class="mb-6">
        @csrf

        <div class="flex items-start gap-3">

            <!-- Avatar del usuario autenticado -->
        <div>
            <img 
                src="{{ route('user.avatar', ['filename' => auth()->user()->image]) }}"
                class="w-11 h-11 rounded-full object-cover" 
            >
        </div>

            <div class="flex-1">
                <textarea 
                    name="comments"
                    rows="2"
                    class="w-full border border-gray-200 rounded-xl p-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50"
                    placeholder="Escribe un comentario..."
                ></textarea>

                <div class="flex justify-end mt-2">
                    <button 
                        type="submit"
                        class="bg-blue-500 text-gray px-5 py-1.5 rounded-full text-sm font-medium hover:bg-blue-600 transition"
                    >
                        Comentar
                    </button>
                </div>
            </div>

        </div>
    </form>

    <!-- Lista de comentarios -->
    @foreach($comments as $comment)
        <div class="flex items-start gap-3 mb-4">

            <!-- Avatar del comentarista -->
            <div class="w-9 h-9 rounded-full overflow-hidden flex-shrink-0">  {{-- ✅ mismo fix --}}
                <img 
                    src="{{ route('user.avatar', ['filename' => $comment->user->image]) }}"
                    class="w-11 h-11 rounded-full object-cover"
                >
            </div>

            <!-- Contenido -->
            <div class="flex-1 bg-gray-50 rounded-2xl px-4 py-2.5">
                <div class="flex items-center justify-between mb-0.5">
                    <span class="text-sm font-semibold text-gray-800">
                        {{ $comment->user->nick }}
                    </span>
                    <span class="text-xs text-gray-400">
                        {{ $comment->created_at_human }}
                    </span>
                    @if($comment->user_id == auth()->user()->id)
                    <form action="{{ route('comments.destroy', ['comment_id' => $comment->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-400 hover:text-red-600 transition">
                            Eliminar
                        </button>
                    </form>
                    @endif
                </div>
                <p class="text-sm text-gray-700 leading-snug">
                    {{ $comment->content }}
                </p>
            </div>

        </div>
    @endforeach

</div>
</x-app-layout>