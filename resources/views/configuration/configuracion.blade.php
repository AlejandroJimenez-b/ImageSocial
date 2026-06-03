<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            Configuración del usuario
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @include('includes.message')

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" enctype="multipart/form-data" action="{{ route('config.update') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name', auth()->user()->name)" required />
                    </div>

                    <!-- Surname -->
                    <div class="mt-4">
                        <x-input-label for="surname" :value="__('Surname')" />
                        <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname"
                            :value="old('surname', auth()->user()->surname)" required />
                    </div>

                    <!-- Nick -->
                    <div class="mt-4">
                        <x-input-label for="nick" :value="__('Nick')" />
                        <x-text-input id="nick" class="block mt-1 w-full" type="text" name="nick"
                            :value="old('nick', auth()->user()->nick)" required />
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email', auth()->user()->email)" required />
                    </div>

                    <!-- Imagen de avatar -->
                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Avatar')" class="mb-2" />
                        
                        <!-- Mostrar la imagen de avatar -->
                        <!-- Ruta get: user.avatar y llama al metodo getImage de ConfiguracionController -->
                        <!-- El codigo de la etiqueta img que obtiene la imagen esta en includes avatar.blade.php y aqui solo lo incluyo -->
                        @include('includes.avatar')

                        <!-- Subir la imagen -->
                        <x-text-input id="image_path" class="block mt-1 w-full" type="file" name="image_path"
                        />
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-primary-button>
                            Update
                        </x-primary-button>
                    </div>

                </form>
                <form action="{{ route('user.delete', auth()->user()->id) }}" method="POST"
                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar tu cuenta? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end mt-4">
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                            Eliminar cuenta
                        </button>
                    </div>
                </form>
            </div>

            
        </div>
    </div>

</x-app-layout>