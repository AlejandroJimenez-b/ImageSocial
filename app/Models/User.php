<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // Ajusto este atributo con las columnas(de la tabla user) de mi db real que he añadido en el RegisterController
    protected $fillable = [
        'role',
        'name',
        'surname',
        'nick',
        'email',
        'password',
        'last_activity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_activity' => 'datetime'
        ];
    }

    // Metodo de uno a muchos
    // Un usuario puede tener muchas imagenes
    public function images() {
        return $this->hasMany('App\Models\Image');
    }

    // Solicitudes enviadas por este usuario
    // Un usuario puede enviar muchas peticiones (hasMany)
    // Solicitudes que ESTE usuario ha enviado
    // Relación con Friendship donde user_id = este usuario
    public function sentFriendships() {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    // Solicitudes recibidas por este usuario
    // Un usuario puede recibir muchas peticiones (hasMany)
    // Solicitudes que ESTE usuario ha recibido
    // Relación con Friendship donde friend_id = este usuario
    public function receivedFriendships() {
        return $this->hasMany(Friendship::class, 'friend_id');
    }

    // Mensajes enviados
    public function sentMessages() {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Mensajes recibidos
    public function receivedMessages() {
        return $this->hasMany(Message::class, 'receiver_id');
    }

}
