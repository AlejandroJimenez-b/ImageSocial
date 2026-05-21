<x-app-layout>
<div class="max-w-3xl mx-auto mt-8 px-4 pb-10">

    {{-- CABECERA --}}
    <div class="bg-gray-800 rounded-xl p-4 flex items-center gap-4 border border-gray-700 mb-4">
        <a href="{{ route('chat.index') }}" class="text-gray-400 hover:text-white transition text-sm">← Volver</a>
        <img src="{{ route('user.avatar', ['filename' => $receiver->image]) }}"
             alt="avatar"
             class="w-10 h-10 rounded-full object-cover"/>
        <div>
            <p class="text-white text-sm font-semibold">{{ $receiver->name }} {{ $receiver->surname }}</p>
            <p class="text-gray-400 text-xs">@ {{ $receiver->nick }}</p>
        </div>
    </div>

    {{-- MENSAJES --}}
    <div id="messages-container"
         class="bg-gray-800 rounded-xl p-4 border border-gray-700 flex flex-col gap-3 min-h-96 max-h-[60vh] overflow-y-auto mb-4">

        @forelse($messages as $message)
            <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs px-4 py-2 rounded-2xl text-sm
                    {{ $message->sender_id == auth()->id()
                        ? 'bg-indigo-600 text-white rounded-br-none'
                        : 'bg-gray-700 text-gray-200 rounded-bl-none' }}">
                    <p>{{ $message->content }}</p>
                    <p class="text-xs mt-1 opacity-60 text-right">{{ $message->created_at->format('H:i') }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-sm text-center mt-auto">No hay mensajes aún. ¡Saluda! 👋</p>
        @endforelse

    </div>

    {{-- FORMULARIO --}}
    <div class="bg-gray-800 rounded-xl p-4 border border-gray-700">
        <div class="flex gap-3 items-end">
            <textarea
                id="message-input"
                rows="1"
                maxlength="1000"
                placeholder="Escribe un mensaje..."
                class="flex-1 bg-gray-900 text-gray-200 text-sm rounded-lg px-4 py-3 border border-gray-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none resize-none placeholder-gray-500 transition"></textarea>
            <button id="send-btn"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-3 rounded-lg transition flex-shrink-0">
                Enviar
            </button>
        </div>
        <p class="text-gray-600 text-xs mt-2 text-right" id="char-count">0 / 1000</p>
    </div>

</div>

{{-- DATOS PARA JS --}}
<script>
    window.receiverId = {{ $receiver->id }};
    window.authId = {{ auth()->id() }};
    window.sendUrl = "{{ route('chat.send', $receiver->id) }}";
    window.csrfToken = "{{ csrf_token() }}";
    window.avatarUrl = "{{ route('user.avatar', ['filename' => auth()->user()->image]) }}";
    window.receiverAvatarUrl = "{{ route('user.avatar', ['filename' => $receiver->image]) }}";
</script>

@vite(['resources/js/chat.js'])

</x-app-layout>