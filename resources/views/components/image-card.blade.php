                @if($image->user->image)
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <!-- Header usuario -->
                        <div class="flex items-center gap-3 mb-2">
                            <img class="w-10 h-10 rounded-full object-cover"
                                src="{{ route('user.avatar', ['filename' => $image->user->image]) }}">

                            <div class="mb-2">
                                <p class="font-semibold text-sm text-gray-900 dark:text-gray-100 mt-4 bg-dark">
                                    <a href="">
                                        {{$image->user->name.' '.$image->user->surname}}
                                        <span class="text-xs text-gray-500">
                                            {{' | @'.$image->user->nick}}
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- Imagen -->
                        <div class="w-full max-h-96 overflow-hidden rounded-lg">
                            <a href="{{ route('images.details', $image->id) }}">
                                <img class="w-48 h-32 object-cover"
                                    src="{{ route('images.show', ['filename' => $image->image_path]) }}">
                            </a>
                        </div>

                        <!-- Meta -->
                        <div>
                            <span class="text-xs text-gray-600">
                                {{' @'.$image->user->nick.' | '.$image->created_at_human}}
                            </span>
                        </div>

                        <!-- Descripción + acciones -->
                        <div class="description">
                            <p class="text-xm text-gray-400">
                                {{ $image->description}}
                            </p>

                            <div class="flex items-center gap-3 mt-3 mb-2">

                                <!-- Likes -->
                                <div class="flex items-center gap-1 text-xs text-gray-500">
                                    <?php
                                        $user_like = $image->likes->contains('user_id', auth()->id());
                                    ?>

                                    @if($user_like)
                                        <img src="{{asset('img/heart-red.png')}}"
                                                data-id="{{$image->id}}"
                                                class="btn-dislike w-28 h-4 object-cover">
                                    @else
                                        <img src="{{asset('img/heart-black.png')}}"
                                                data-id="{{$image->id}}"
                                                class="btn-like w-28 h-4 object-cover">
                                    @endif

                                    <span class="like-count text-sm" data-id="{{$image->id}}">
                                        {{$image->likes->count()}}
                                    </span>
                                </div>

                                <!-- Favoritos -->
                                <div class="flex items-center gap-1 text-xs text-gray-500">
                                    <?php
                                        $user_favorite = $image->favorites->contains('user_id', auth()->id());
                                    ?>

                                    @if($user_favorite)
                                        <img src="{{asset('img/favorite-yellow.png')}}"
                                                data-id="{{$image->id}}"
                                                class="btn-disfavorite w-28 h-4 object-cover">
                                    @else
                                        <img src="{{asset('img/favorite-black.png')}}"
                                                data-id="{{$image->id}}"
                                                class="btn-favorite w-28 h-4 object-cover">
                                    @endif

                                    <span class="favorite-count text-sm" data-id="{{$image->id}}">
                                        {{$image->favorites->count()}}
                                    </span>
                                </div>

                                <!-- Comentarios -->
                                <div class="comments">
                                    <button
                                        class="btn-comments bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-xs"
                                        data-id="{{$image->id}}"
                                        data-image="{{route('images.show', $image->image_path)}}"
                                        data-store="{{ route('comments.store', ['image_id' => $image->id]) }}">

                                        Comentarios (
                                        <span class="comment-count" data-id="{{$image->id}}">
                                            {{$image->comments->count()}}
                                        </span>
                                        )
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>
                    @endif