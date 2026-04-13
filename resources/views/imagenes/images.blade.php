<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            Subir Imagenes
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @include('includes.message')

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" enctype="multipart/form-data" action="{{ route('images.save') }}">
                    @csrf

                    <!-- Imagen -->
                    <div>                        
                        <!-- Para subir la imagen -->
                        <x-input-label for="image_path" :value="__('Sube tu imagen')" />
                        <x-text-input id="image_path" class="block mt-1 w-full text-sm text-gray-900 block mt-1 w-full text-sm text-gray-900 bg-gray-50 dark:text-gray-400 focus:outline-none mb-2" type="file" name="image_path"
                        required />
                        <x-input-label for="description" :value="__('Descripcion')" />
                        <textarea id="description" name="description" class="form-control block mt-1 w-full text-sm text-gray-900 block mt-1 w-full text-sm text-gray-900 bg-gray-50 dark:text-gray-400 focus:outline-none"required ></textarea>
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-primary-button>
                            Subir
                        </x-primary-button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>