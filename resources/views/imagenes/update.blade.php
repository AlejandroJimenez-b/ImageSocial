<x-app-layout>
<div class="max-w-3xl mx-auto py-10 px-4">

    {{-- IMAGEN A PANTALLA COMPLETA --}}
    <div class="bg-gray-800 mt-4 rounded-xl overflow-hidden shadow-xl p-3">
        <img src="{{ route('images.show', $image->image_path) }}"
            alt="imagen"
            class="max-h-[60vh] w-auto mx-auto rounded-lg"/>
        <form method="POST" action="{{ route('images.updatesave', $image->id) }}">
        @csrf
        <div class="mt-6">                        
            <x-input-label for="description" :value="__('Descripcion')" />
            <textarea id="description" name="description" class="form-control block mt-1 w-full text-sm text-gray-900 block mt-1 w-full text-sm text-gray-900 bg-gray-50 dark:text-gray-400 focus:outline-none"required >{{ $image->description }}</textarea>
        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button>
                Guardar cambios
            </x-primary-button>
        </div>

    </form>
</div>
</x-app-layout>