<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Friendship;
use App\Models\User;

class FriendshipController extends Controller
{
    // Vista "Mis Amigos"
    public function index() {
        $user = Auth::user();

        // Amigos aceptados (enviados o recibidos)
        $friends = Friendship::where(function($q) use ($user) {
                        $q->where('user_id', $user->id)
                          ->where('status', 'accepted');
                    })->orWhere(function($q) use ($user) {
                        $q->where('friend_id', $user->id)
                          ->where('status', 'accepted');
                    })->get();

        // Solicitudes recibidas pendientes
        $pendingReceived = Friendship::where('friend_id', $user->id)
                            ->where('status', 'pending')
                            ->get();

        return view('people.friends', compact('friends', 'pendingReceived'));
    }

    // Enviar solicitud de amistad
    public function sendRequest($id) {
        $user = Auth::user();

        // Verificar que no existe ya una solicitud entre estos dos usuarios
        $exists = Friendship::where(function($q) use ($user, $id) {
                        $q->where('user_id', $user->id)
                          ->where('friend_id', $id);
                    })->orWhere(function($q) use ($user, $id) {
                        $q->where('user_id', $id)
                          ->where('friend_id', $user->id);
                    })->exists();

        if (!$exists) {
            Friendship::create([
                'user_id'   => $user->id,
                'friend_id' => $id,
                'status'    => 'pending'
            ]);
        }

        return redirect()->back();
    }

    public function cancelRequest($id) {
        Friendship::where('user_id', Auth::id())
            ->where('friend_id', $id)
            ->where('status', 'pending')
            ->delete();

        return redirect()->back();
    }

    // Aceptar solicitud
    public function acceptRequest($id) {
        $friendship = Friendship::where('user_id', $id)
                        ->where('friend_id', Auth::id())
                        ->where('status', 'pending')
                        ->firstOrFail();

        $friendship->status = 'accepted';
        $friendship->save();

        return redirect()->back();
    }

    // Rechazar solicitud
    public function rejectRequest($id) {
        Friendship::where('user_id', $id)
            ->where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->delete();

        return redirect()->back();
    }

    // Eliminar amigo
    public function deleteFriend($id) {
        $user = Auth::user();

        Friendship::where(function($q) use ($user, $id) {
                $q->where('user_id', $user->id)
                  ->where('friend_id', $id);
            })->orWhere(function($q) use ($user, $id) {
                $q->where('user_id', $id)
                  ->where('friend_id', $user->id);
            })->delete();

        return redirect()->back();
    }
}