<x-app-layout>
<div class="max-w-3xl mx-auto mt-8 py-1 pb-4">

    {{-- CABECERA PERFIL --}}
    <div class="bg-gray-800 rounded-xl p-6 flex items-center gap-5 border border-gray-700">

        <img src="{{ route('user.avatar', ['filename' => $user->image]) }}"
             alt="avatar"
             class="w-20 h-20 rounded-full object-cover flex-shrink-0 border-2 border-indigo-500"/>

        <div class="flex-1">
            <p class="text-white font-semibold text-lg">{{ $user->name }} {{ $user->surname }}</p>
            <p class="text-gray-400 text-sm mt-0.5">@{{ $user->nick }}</p>
            <p class="text-gray-500 text-xs mt-1">{{ count($images) }} publicaciones</p>
        </div>

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
        <a href="{{ route('images.details', $image->id) }}">
            <div class="bg-gray-800 rounded-xl overflow-hidden border border-gray-700 hover:border-indigo-500 transition mb-4">

                <img src="{{ route('images.show', $image->image_path) }}"
                     alt="imagen"
                     class="w-full max-h-72 object-cover"/>

                <div class="p-4 flex items-center justify-between">
                    <div>
                        <p class="text-gray-200 text-sm italic">{{ $image->description }}</p>
                        <p class="text-gray-500 text-xs mt-1">{{ $image->created_at_human }}</p>
                    </div>
                    <div class="flex items-center gap-1 text-gray-400 text-sm">
                        ❤️ <span>{{ $image->likes()->count() }}</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm italic">Comentarios<a href="{{ route('comments.view', $image->id) }}"></a></p>
                    </div>
                </div>

            </div>
        </a>
    @empty
        <p class="text-gray-500 text-sm">Este usuario no tiene publicaciones aún.</p>
    @endforelse

</div>
</x-app-layout>