import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

// Elementos del DOM
const messagesContainer = document.getElementById('messages-container');
const messageInput = document.getElementById('message-input');
const sendBtn = document.getElementById('send-btn');
const charCount = document.getElementById('char-count');

// Scroll al último mensaje
function scrollToBottom() {
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}
scrollToBottom();

// Contador de caracteres
messageInput.addEventListener('input', () => {
    charCount.textContent = `${messageInput.value.length} / 1000`;
});

// Enviar con Enter (Shift+Enter para nueva línea)
messageInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
});

sendBtn.addEventListener('click', sendMessage);

// Función para crear el HTML de un mensaje
function createMessageHTML(content, time, isMine, avatarUrl) {
    const align = isMine ? 'justify-end' : 'justify-start';
    const bubble = isMine
        ? 'bg-indigo-600 text-white rounded-br-none'
        : 'bg-gray-700 text-gray-200 rounded-bl-none';

    return `
        <div class="flex ${align}">
            <div class="max-w-xs px-4 py-2 rounded-2xl text-sm ${bubble}">
                <p>${content}</p>
                <p class="text-xs mt-1 opacity-60 text-right">${time}</p>
            </div>
        </div>
    `;
}

// Enviar mensaje
async function sendMessage() {
    const content = messageInput.value.trim();
    if (!content) return;

    // Deshabilitar botón mientras envía
    sendBtn.disabled = true;
    sendBtn.textContent = '...';

    try {
        const response = await fetch(sendUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ content })
        });

        if (response.status === 429) {
            alert('Demasiados mensajes. Espera un momento.');
            return;
        }

        if (!response.ok) {
            alert('Error al enviar el mensaje.');
            return;
        }

        const data = await response.json();

        // Añadir mensaje propio al chat
        const now = new Date();
        const time = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
        messagesContainer.innerHTML += createMessageHTML(content, time, true, avatarUrl);
        scrollToBottom();

        // Limpiar input
        messageInput.value = '';
        charCount.textContent = '0 / 1000';

    } catch (error) {
        alert('Error de conexión.');
    } finally {
        sendBtn.disabled = false;
        sendBtn.textContent = 'Enviar';
    }
}

// Escuchar mensajes en tiempo real
const ids = [authId, receiverId].sort((a, b) => a - b);
const channelName = `chat.${ids[0]}.${ids[1]}`;

window.Echo.private(channelName)
    .listen('MessageSent', (e) => {
        // Solo añadir si el mensaje es del otro usuario
        if (e.sender_id !== authId) {
            messagesContainer.innerHTML += createMessageHTML(
                e.content,
                e.created_at,
                false,
                receiverAvatarUrl
            );
            scrollToBottom();
        }
    });