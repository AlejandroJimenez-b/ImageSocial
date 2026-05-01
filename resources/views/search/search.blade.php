<x-app-layout>
<div class="max-w-3xl mx-auto mt-8 px-4 pb-10">

    <h2 class="text-white font-semibold text-lg mb-6">
        Resultados para: <span class="text-indigo-400">"{{ $q }}"</span>
    </h2>

    {{-- USUARIOS --}}
    @if(count($users) > 0)
        <h3 class="text-gray-400 text-sm font-semibold uppercase mb-3">Personas</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            @foreach($users as $user)
                <a href="{{ route('gente.profile', $user->id) }}">
                    <div class="bg-gray-800 rounded-xl p-4 flex items-center gap-4 border border-gray-700 hover:border-indigo-500 transition">
                        <img src="{{ route('user.avatar', ['filename' => $user->image]) }}"
                             class="w-12 h-12 rounded-full object-cover flex-shrink-0"/>
                        <div>
                            <p class="text-white text-sm font-semibold">{{ $user->name }} {{ $user->surname }}</p>
                            <p class="text-gray-400 text-xs">@ {{ $user->nick }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    {{-- IMÁGENES --}}
    @if(count($images) > 0)
        <h3 class="text-gray-400 text-sm font-semibold uppercase mb-3">Publicaciones</h3>
        <div class="flex flex-col gap-4">
            @foreach($images as $image)
                <a href="{{ route('images.details', $image->id) }}">
                    <div class="bg-gray-800 rounded-xl overflow-hidden border border-gray-700 hover:border-indigo-500 transition flex gap-4 p-3">
                        <img src="{{ route('images.show', $image->image_path) }}"
                             class="w-32 h-24 object-cover rounded-lg flex-shrink-0"/>
                        <div class="flex flex-col justify-between py-1">
                            <p class="text-gray-200 text-sm italic">{{ $image->description }}</p>
                            <p class="text-gray-500 text-xs">{{ $image->created_at_human }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    {{-- SIN RESULTADOS --}}
    @if(count($users) == 0 && count($images) == 0)
        <p class="text-gray-500 text-sm">No se encontraron resultados para "{{ $q }}".</p>
    @endif

</div>
</x-app-layout>