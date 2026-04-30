<x-app-layout>

<div class="max-w-6xl mx-auto mt-8 py-1 pb-4">

    {{-- CABECERA PERFIL --}}
    <div class="bg-gray-800 rounded-xl p-6 flex items-center gap-5 border border-gray-700">

        <img src="{{ route('user.avatar', ['filename' => $user->image]) }}"
            alt="avatar"
            class="w-20 h-20 rounded-full object-cover flex-shrink-0 border-2 border-indigo-500"/>

        <div class="flex-1">
            <p class="text-white font-semibold text-lg">{{ $user->name }} {{ $user->surname }}</p>
            <p class="text-gray-400 text-sm mt-0.5"> {{' @'.$user->nick }}</p>
        </div>

    </div>

    <hr class="my-6 mt-2 mb-2 border-gray-700"/>

    <h2 class="text-white font-semibold text-base mb-4 text-center">Favoritos</h2>

    <!-- 🔥 SOLO AQUÍ VA EL GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($images as $image)

            <div class="bg-gray-800 rounded-xl overflow-hidden border border-gray-700 hover:border-indigo-500 transition">
                <x-image-card :image="$image" />
            </div>

        @endforeach

    </div>

</div> <!-- contenedor principal -->

</x-app-layout>