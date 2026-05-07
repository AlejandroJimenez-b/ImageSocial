<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class ChatController extends Controller
{
    // Vista principal del chat — lista de conversaciones
    public function index()
    {
        $user = Auth::user();

        // Solo amigos pueden chatear
        $friends = Friendship::where(function($q) use ($user) {
                        $q->where('user_id', $user->id)
                          ->where('status', 'accepted');
                    })->orWhere(function($q) use ($user) {
                        $q->where('friend_id', $user->id)
                          ->where('status', 'accepted');
                    })->get()
                    ->map(function($friendship) use ($user) {
                        return $friendship->user_id == $user->id
                            ? $friendship->receiver
                            : $friendship->sender;
                    });

        return view('chat.index', compact('friends'));
    }

    // Vista del chat con un usuario específico
    public function show($id)
    {
        $user     = Auth::user();
        $receiver = User::findOrFail($id);

        // Seguridad: verificar que son amigos
        $areFriends = Friendship::where(function($q) use ($user, $id) {
                        $q->where('user_id', $user->id)
                          ->where('friend_id', $id);
                    })->orWhere(function($q) use ($user, $id) {
                        $q->where('user_id', $id)
                          ->where('friend_id', $user->id);
                    })->where('status', 'accepted')->exists();

        if (!$areFriends) {
            return redirect()->route('chat.index')
                             ->with('error', 'Solo puedes chatear con tus amigos.');
        }

        // Obtener mensajes entre los dos usuarios
        $messages = Message::where(function($q) use ($user, $id) {
                        $q->where('sender_id', $user->id)
                          ->where('receiver_id', $id);
                    })->orWhere(function($q) use ($user, $id) {
                        $q->where('sender_id', $id)
                          ->where('receiver_id', $user->id);
                    })->orderBy('created_at', 'asc')
                      ->get();

        // Marcar mensajes recibidos como leídos
        Message::where('sender_id', $id)
               ->where('receiver_id', $user->id)
               ->whereNull('read_at')
               ->update(['read_at' => now()]);

        return view('chat.show', compact('receiver', 'messages'));
    }

    // Enviar mensaje
    public function send(Request $request, $id)
    {
        $user = Auth::user();

        // Rate limiting: máximo 30 mensajes por minuto
        $key = 'chat.' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 30)) {
            return response()->json([
                'error' => 'Demasiados mensajes. Espera un momento.'
            ], 429);
        }
        RateLimiter::hit($key, 60);

        // Seguridad: verificar amistad
        $areFriends = Friendship::where(function($q) use ($user, $id) {
                        $q->where('user_id', $user->id)
                          ->where('friend_id', $id);
                    })->orWhere(function($q) use ($user, $id) {
                        $q->where('user_id', $id)
                          ->where('friend_id', $user->id);
                    })->where('status', 'accepted')->exists();

        if (!$areFriends) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        // Validación estricta
        $request->validate([
            'content' => ['required', 'string', 'max:1000', 'min:1']
        ]);

        // Crear mensaje
        $message = Message::create([
            'sender_id'   => $user->id,
            'receiver_id' => $id,
            'content'     => strip_tags($request->content), // anti XSS
        ]);

        $message->load('sender');

        // Emitir evento en tiempo real
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }
}
