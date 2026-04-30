<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            Gente
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-4">

        {{-- GRID DE USUARIOS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            @foreach($users as $user)
            <a href="{{ route('gente.profile', $user->id) }}">
                <div class="bg-gray-800 rounded-xl p-5 flex items-center gap-4 border border-gray-700 hover:border-indigo-500 transition">

                    {{-- AVATAR --}}
                    <img src="{{ route('user.avatar', ['filename' => $user->image]) }}"
                        alt="avatar"
                        class="w-14 h-14 rounded-full object-cover flex-shrink-0"/>
                    <a href="{{ route('gente.profile', $user->id) }}">
                    {{-- INFO --}}
                    <div>
                        <p class="text-white font-semibold text-sm">{{ $user->name }} {{ $user->surname }}</p>
                        <p class="text-gray-400 text-xs mt-0.5">{{' @'.$user->nick }}</p>
                    </div>
                </div>
            </a>
            @endforeach

        </div>
    </div>
</x-app-layout>