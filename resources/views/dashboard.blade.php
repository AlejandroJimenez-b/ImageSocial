<x-app-layout>

    <x-slot name="slot">
        <div class="py-8">
            <div class="max-w-3xl mx-auto px-4">

                {{-- BIENVENIDO --}}
                <div class="bg-gray-800 rounded-xl shadow-sm border border-gray-700 mb-4 px-4 py-2 text-center mt-4 text-gray-200">
                    {{ __("Bienvenido/a") }} <span class="text-indigo-400 font-semibold">{{ auth()->user()->name }}</span>
                </div>

                {{-- FEED --}}
                <div class="bg-gray-800 rounded-xl shadow-sm border border-gray-500 mb-6 px-6 py-6 text-center">
                    <h2 class="font-semibold text-xl text-gray-200">{{ __('Feed') }}</h2>
                </div>

                {{-- PUBLICACIONES --}}
                <div id="feed-container" class="flex flex-col gap-4">
                    @include('partials.images-loop', ['images' => $images])
                </div>

                <div id="infinite-scroll-trigger" class="h-10"></div>

                <div id="loader" class="text-center py-4 hidden">
                    <span class="text-gray-400 text-sm">Cargando más imágenes...</span>
                </div>

                <div class="mt-6 flex justify-center">
                    {{ $images->links() }}
                </div>

            </div>
        </div>
    </x-slot>

</x-app-layout>