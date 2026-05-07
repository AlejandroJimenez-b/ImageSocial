<x-app-layout>

    <x-slot name="header">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 border-b border-gray-200 dark:border-gray-700">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("Bienvenido/a") }} <span>{{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl py-4 text-gray-800 dark:text-gray-200 leading-tight text-center">
                {{ __('Feed') }}
            </h2>
        </div>
    </div>

    </x-slot>

    <x-slot name="slot">
    <div class="flex items-center py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="max-w-7xl bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div id="feed-container" class="bg-gray-800 rounded-xl border border-gray-700 
                hover:border-indigo-500 transition 
                p-4 mb-6 shadow-sm">
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
    </x-slot>
</x-app-layout>