<x-app-layout>
<div class="max-w-3xl mx-auto mt-8 px-4 pb-10">

    <h2 class="text-white font-semibold text-lg mb-6">💬 Mensajes</h2>

    @if(count($friends) > 0)
        <div class="flex flex-col gap-3">
            @foreach($friends as $friend)

                @php
                    // Último mensaje con este amigo
                    $lastMessage = \App\Models\Message::where(function($q) use ($friend) {
                        $q->where('sender_id', auth()->id())
                          ->where('receiver_id', $friend->id);
                    })->orWhere(function($q) use ($friend) {
                        $q->where('sender_id', $friend->id)
                          ->where('receiver_id', auth()->id());
                    })->orderBy('created_at', 'desc')->first();

                    // Mensajes no leídos de este amigo
                    $unread = \App\Models\Message::where('sender_id', $friend->id)
                                ->where('receiver_id', auth()->id())
                                ->whereNull('read_at')
                                ->count();
                @endphp

                <a href="{{ route('chat.show', $friend->id) }}">
                    <div class="bg-gray-800 rounded-xl p-4 flex items-center gap-4 border border-gray-700 hover:border-indigo-500 transition">

                        {{-- Avatar --}}
                        <div class="relative">
                            <img src="{{ route('user.avatar', ['filename' => $friend->image]) }}"
                                 alt="avatar"
                                 class="w-12 h-12 rounded-full object-cover flex-shrink-0"/>
                            {{-- Indicador no leídos --}}
                            @if($unread > 0)
                                <span class="absolute -top-1 -right-1 bg-indigo-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                                    {{ $unread }}
                                </span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-sm font-semibold">{{ $friend->name }} {{ $friend->surname }}</p>
                            <p class="text-gray-400 text-xs truncate mt-0.5">
                                @if($lastMessage)
                                    {{ $lastMessage->sender_id == auth()->id() ? 'Tú: ' : '' }}{{ $lastMessage->content }}
                                @else
                                    <span class="text-gray-600 italic">Sin mensajes aún</span>
                                @endif
                            </p>
                        </div>

                        {{-- Hora último mensaje --}}
                        @if($lastMessage)
                            <p class="text-gray-500 text-xs flex-shrink-0">
                                {{ $lastMessage->created_at->format('H:i') }}
                            </p>
                        @endif

                    </div>
                </a>

            @endforeach
        </div>

    @else
        <p class="text-gray-500 text-sm">No tienes amigos aún. ¡Ve a la sección Gente para conectar con gente!</p>
    @endif

</div>
</x-app-layout>