<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
        Favoritos
    </h2>
        <div class="max-w-7xl mx-auto">
            @foreach($images as $image)
                <x-image-card :image="$image" />
            @endforeach
        </div>
    </x-slot>
</x-app-layout>