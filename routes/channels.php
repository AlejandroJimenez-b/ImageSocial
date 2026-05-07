<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Friendship;

Broadcast::channel('chat.{id1}.{id2}', function ($user, $id1, $id2) {
    // Verificar que el usuario autenticado es uno de los dos del canal
    $isParticipant = ($user->id == $id1 || $user->id == $id2);

    if (!$isParticipant) {
        return false;
    }

    // Verificar que son amigos
    $areFriends = Friendship::where(function($q) use ($id1, $id2) {
                    $q->where('user_id', $id1)
                      ->where('friend_id', $id2);
                })->orWhere(function($q) use ($id1, $id2) {
                    $q->where('user_id', $id2)
                      ->where('friend_id', $id1);
                })->where('status', 'accepted')->exists();

    return $areFriends;
});
