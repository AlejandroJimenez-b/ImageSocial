<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Sesion Iniciada") }}
                </div>
            </div>
        </div>
    </div>
    <!-- justo en este div de abajo he alineado las imagenes al centro, esta bien pero tengo que arreglar con claude el ancho azul clarito del contenedor y el tamaño de las imagenes -->
    <div class="flex items-center py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            @foreach($images as $image)
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Imagen actual -->
                    <x-input-label for="image" class="mb-2"/>
                    @if($image->user->image)
                    <div class="flex items-center gap-3 mb-2">
                        <img class="w-10 h-10 rounded-full object-cover " src="{{ route('user.avatar', ['filename' => $image->user->image]) }}">

                        <div class="mb-2">
                            <p class="font-semibold text-sm text-gray-900 dark:text-gray-100 mt-4 bg-dark">
                            <a href="">
                            {{$image->user->name.' '.$image->user->surname}}
                            <span class="text-xs text-gray-500 ">
                                {{' | @'.$image->user->nick}}
                            </span>
                            </a>
                            </p>
                        </div>
                    </div>
                    <div class="w-full max-h-96 overflow-hidden rounded-lg">
                        <a href="{{ route('images.details', $image->id) }}">
                        <img class="w-48 h-32 object-cover" src="{{ route('images.show', ['filename' => $image->image_path]) }}">
                        </a>
                        <span class="text-xs text-gray-600">
                            {{' @'.$image->user->nick.' | '.$image->created_at_human}}
                        </span>
                        <div class="description">
                            <p class="text-xm text-gray-400 ">
                                    {{ $image->description}}
                            </p>
                            <div class="flex items-center gap-3 mt-3 mb-2">
                                <div class="flex items-center gap-1 text-xs text-gray-500 ">
                                    <!-- Sistema de likes preparado para AJAX -->
                                    <?php $user_like = false; ?>
                                    @foreach($image->likes as $like)
                                        @if($like->user->id == auth()->user()->id)
                                        <?php $user_like = true; ?>
                                        @endif
                                    @endforeach
                                    @if($user_like)
                                    <img src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}" class="btn-dislike w-28 h-4 object-cover">
                                    @else
                                    <img src="{{asset('img/heart-black.png')}}" data-id="{{$image->id}}" class="btn-like w-28 h-4 object-cover">
                                    @endif
                                    <span class="like-count text-sm" data-id="{{$image->id}}">{{count($image->likes)}}</span>
                                </div>
                                <div class="comments">
                                    <button
                                    class="btn-comments bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-xs"
                                    data-id="{{$image->id}}" 
                                    data-image="{{route('images.show', $image->image_path)}}"
                                    data-store="{{ route('comments.store', ['image_id' => $image->id]) }}">
                                    
                                    Comentarios (<span class="comment-count" data-id="{{$image->id}}">
                                                    {{count($image->comments)}}
                                                </span>)
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endif
                </div>
            @endforeach
            </div>
        </div>
    </div>
    <!-- Overlay -->
<div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-60 hidden z-40 backdrop-blur-sm"></div>

<!-- Modal -->
<div id="comments-modal" class="fixed inset-0 flex max-w-sm items-center justify-center hidden z-50 p-4">
    <div class="bg-gray-50 rounded-2xl shadow-2xl w-full mx-4 max-h-[90vh] flex flex-col border border-gray-200" style="max-width: 500px;">

        <!-- Cabecera modal -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 bg-white rounded-t-2xl">
            <h3 class="font-semibold text-gray-800 text-base">Comentarios</h3>
            <button id="modal-close" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition text-lg">✕</button>
        </div>

        <!-- Imagen del post -->
        <div class="px-5 pt-4 flex justify-center bg-white border-b border-gray-200 pb-4">
            <div class="w-full max-h-96 overflow-hidden rounded-lg bg-gray-100">
                <img id="modal-image" src="" class="w-48 h-32 object-cover mx-auto">
            </div>
        </div>

        <!-- Lista de comentarios -->
        <div id="modal-comments" class="flex-1 overflow-y-auto px-5 py-4 space-y-3 bg-white">
            <!-- JS inyectará aquí los comentarios -->
        </div>

        <!-- Formulario -->
        <div class="px-5 py-4 border-t border-gray-200 bg-white rounded-b-2xl">
            <form id="modal-form" action="" method="POST">
                @csrf
                @method('POST')
                <div class="flex items-start gap-3">
                    <img 
                        src="{{ route('user.avatar', ['filename' => auth()->user()->image]) }}"
                        class="w-8 h-8 rounded-full object-cover flex-shrink-0 border-2 border-gray-200"
                    >
                    <div class="flex-1">
                        <textarea 
                            name="comments"
                            rows="2"
                            class="w-full border-2 border-gray-200 rounded-xl p-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50 placeholder-gray-400"
                            placeholder="Escribe un comentario..."
                        ></textarea>
                        <div class="flex justify-end mt-2">
                            <button 
                                type="submit"
                                class="bg-blue-100 text-dark px-5 py-1.5 rounded-full text-sm font-medium hover:bg-blue-600 transition"
                            >
                                Comentar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@if(session('open_comments'))
    <script>
        window.openCommentsOnLoad = {{ session('open_comments') }};
    </script>
@endif
</x-app-layout>
