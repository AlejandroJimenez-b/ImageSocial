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

    <div class="py-12">
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
                        <img class="w-48 h-32 object-cover" src="{{ route('images.show', ['filename' => $image->image_path]) }}">
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
                                    <a href="{{ route('comments.view', ['image_id' => $image->id]) }}" class="bg-gray-500 px-4 py-2 rounded hover:bg-gray-600 text-xs">Comentarios
                                        
                                    </a>
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
</x-app-layout>
