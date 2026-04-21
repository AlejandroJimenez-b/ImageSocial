<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">

        {{-- IMAGEN A PANTALLA COMPLETA --}}
        <div class="w-full rounded-lg overflow-hidden shadow-lg">
            <img src="{{ route('images.show', $image->image_path) }}"
                 alt="imagen"
                 class="w-full object-contain max-h-[70vh]"/>
        </div>

        {{-- INFO BÁSICA --}}
        <div class="mt-4 flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm">Subida por <span class="text-white font-semibold">{{ $image->user->nick }}</span></p>
                <p class="text-gray-500 text-xs mt-1">{{ $image->created_at_human }}</p>
            </div>
            {{-- LIKES --}}
            <div class="flex items-center gap-2 text-red-400 text-sm">
                ❤️ <span>{{ $likesCount }}</span> likes
            </div>
        </div>

        {{-- DESCRIPCIÓN --}}
        @if($image->description)
            <p class="mt-3 text-gray-300">{{ $image->description }}</p>
        @endif

        <hr class="my-6 border-gray-600"/>

        {{-- COMENTARIOS --}}
        <h2 class="text-white text-lg font-semibold mb-4">Comentarios ({{ count($comments) }})</h2>

        @forelse($comments as $comment)
            <div class="bg-gray-800 rounded-lg p-4 mb-3">
                <p class="text-gray-400 text-xs mb-1 font-semibold">{{ $comment->user->nick }}</p>
                <p class="text-white text-sm">{{ $comment->content }}</p>
            </div>
        @empty
            <p class="text-gray-500 text-sm">No hay comentarios aún.</p>
        @endforelse

    </div>
</x-app-layout>