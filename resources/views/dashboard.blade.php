<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-10 mt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Bienvenido/a") }} <span>{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div id="feed-container" class="bg-white dark:bg-gray-800">
                    @include('partials.images-loop', ['images' => $images])
                </div>

                <!-- 🔥 Sentinel -->
                <div id="infinite-scroll-trigger" class="h-10"></div>
                
                <div id="loader" class="text-center py-4 hidden">
                    <span class="text-gray-400 text-sm">Cargando más imágenes...</span>
                </div>
                <!-- paginación -->
                <div class="mt-6 flex justify-center">
                    {{ $images->links() }}
                </div>


            </div>
        </div>
    </div>

</x-app-layout>