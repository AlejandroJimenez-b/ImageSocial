                @if($image->user->image)
                    <div class="p-4 text-gray-800 dark:text-gray-100 bg-gray-800 rounded-xl border border-gray-700 hover:border-indigo-500 transition mb-4 shadow-sm">

                        <!-- Header usuario -->
                        <div class="flex items-center gap-3 mb-3">
                            <img class="w-10 h-10 rounded-full object-cover flex-shrink-0"
                                src="{{ route('user.avatar', ['filename' => $image->user->image]) }}">
                            <div>
                                <p class="font-semibold text-sm text-white">
                                    {{$image->user->name.' '.$image->user->surname}}
                                    <span class="text-xs text-gray-400">{{' | @'.$image->user->nick}}</span>
                                </p>
                                <span class="text-xs text-gray-500">{{$image->created_at_human}}</span>
                            </div>
                        </div>

                        <!-- Imagen -->
                        <a href="{{ route('images.details', $image->id) }}">
                            <div class="w-full h-56 overflow-hidden rounded-lg mb-3">
                                <img class="w-full h-full object-cover hover:scale-105 transition duration-300"
                                    src="{{ route('images.show', ['filename' => $image->image_path]) }}">
                            </div>
                        </a>

                        <!-- Meta -->
                        <!-- <div>
                            <span class="text-xs text-gray-500">
                                {{' @'.$image->user->nick.' | '.$image->created_at_human}}
                            </span>
                        </div> -->

                        <!-- Descripción + acciones -->
                        @if($image->description)
                            <p class="text-sm text-gray-400 mb-3 italic">{{ $image->description }}</p>
                        @endif

                            <div class="flex items-center gap-3">

                                <!-- Likes -->
                                <div class="flex items-center gap-1 text-xs text-gray-500">
                                    <?php $user_like = $image->likes->contains('user_id', auth()->id()); ?>
                                    @if($user_like)
                                        <img src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}"
                                            class="btn-dislike w-6 h-6 object-cover cursor-pointer">
                                    @else
                                        <img src="{{asset('img/heart-black.png')}}" data-id="{{$image->id}}"
                                            class="btn-like w-6 h-6 object-cover cursor-pointer">
                                    @endif
                                    <span class="like-count text-sm" data-id="{{$image->id}}">{{$image->likes->count()}}</span>
                                </div>

                                <!-- Favoritos -->
                                <div class="flex items-center gap-1 text-xs text-gray-500">
                                    <?php $user_favorite = $image->favorites->contains('user_id', auth()->id()); ?>
                                    @if($user_favorite)
                                        <img src="{{asset('img/favorite-yellow.png')}}" data-id="{{$image->id}}"
                                            class="btn-disfavorite w-6 h-6 object-cover cursor-pointer">
                                    @else
                                        <img src="{{asset('img/favorite-black.png')}}" data-id="{{$image->id}}"
                                            class="btn-favorite w-6 h-6 object-cover cursor-pointer">
                                    @endif
                                    <span class="favorite-count text-sm" data-id="{{$image->id}}">{{$image->favorites->count()}}</span>
                                </div>

                                <!-- Comentarios -->
                                <button class="btn-comments bg-gray-600 hover:bg-gray-500 text-white px-3 py-1.5 rounded-lg text-xs transition"
                                        data-id="{{$image->id}}"
                                        data-image="{{route('images.show', $image->image_path)}}"
                                        data-store="{{ route('comments.store', ['image_id' => $image->id]) }}">
                                    Comentarios (<span class="comment-count" data-id="{{$image->id}}">{{$image->comments->count()}}</span>)
                                </button>

                            </div>
                    </div>
                    @endif