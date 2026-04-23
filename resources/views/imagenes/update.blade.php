<x-app-layout>
<div class="max-w-3xl mx-auto py-10 px-4">

    {{-- IMAGEN A PANTALLA COMPLETA --}}
    <div class="bg-gray-800 mt-4 rounded-xl overflow-hidden shadow-xl p-3">
        <img src="{{ route('images.show', $image->image_path) }}"
            alt="imagen"
            class="max-h-[60vh] w-auto mx-auto rounded-lg"/>
    </div>
    <div class="bg-gray-800 rounded-xl shadow-xl mt-6 p-6 border border-gray-700">
        <div class="flex items-center gap-2 mb-5">
            <span class="text-indigo-400 text-lg">✏️</span>
            <h2 class="text-white font-semibold text-lg">Editar descripción</h2>
        </div>
        <form method="POST" action="{{ route('images.updatesave', $image->id) }}">
        @csrf
                        
            <x-input-label for="description" :value="__('Descripcion')" />
            <textarea 
                id="description" 
                name="description"
                rows="4"
                placeholder="Escribe una nueva descripción para tu imagen..."
                class="form-control block mt-1 w-full text-sm text-gray-900 text-gray-200 block mt-1 w-full text-sm rounded-lg px-4 py-3 border border-gray-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 resize-none placeholder-gray-500 transition bg-gray-50 dark:text-gray-400 focus:outline-none"required >{{ $image->description }}
            </textarea>

            <p class="text-gray-500 text-xs mt-2">Máximo 255 caracteres.</p>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('images.details', $image->id) }}"
                   class="text-gray-400 hover:text-white text-sm transition">
                    ← Volver sin guardar
                </a>

                <button type="submit" class="bg-blue-700 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-2 rounded-lg transition">
                    Guardar cambios
                </button>
            </div>
            
        </form>
    </div>
    
</div>
</x-app-layout>