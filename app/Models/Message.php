<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'read_at'
    ];

    // Quien envió el mensaje
    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Quien recibe el mensaje
    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
