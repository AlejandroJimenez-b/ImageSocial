<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $table = 'friendships';

    protected $fillable = ['user_id', 'friend_id', 'status'];

    // Quien envió la solicitud
    // Una peticion pertenece a un unico usuario (belongsTo)
    // Usuario que ENVÍA la solicitud de amistad
    // FK: user_id → users.id
    public function sender() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quien la recibe
    // La recepcion de una peticion pertenece a un solo usuario (belongsTo)
    // Usuario que RECIBE la solicitud
    // FK: friend_id → users.id
    public function receiver() {
        return $this->belongsTo(User::class, 'friend_id');
    }

}