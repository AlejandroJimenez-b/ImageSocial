<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Enlazo este modelo con su tabla correspondiente
    // Lo enlazo con un atributo/propiedad protected y el nombre de la tabla
    protected $table = 'comments';

    // Los comentarios seran de muchos a uno (belongTo)
    // Muchos comentarios pertenecen a un usuario (de la imagen de un usuario)
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id'); // despues de la coma -> es el foreing key de la tabla del protected
    }

    // Los comentarios seran de muchos a uno (belongsTo)
    // Muchos comentarios van a pertenecer a una sola imagenen
    public function image() {
        return $this->belongsTo('App\Models\Image', 'image_id');
    }
}
