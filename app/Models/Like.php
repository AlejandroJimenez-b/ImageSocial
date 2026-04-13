<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // Enlazo este modelo con su tabla correspondiente
    // Lo enlazo con un atributo/propiedad protected y el nombre de la tabla
    protected $table = 'likes';

    // Los likes seran de muchos a uno (belongTo)
    // Muchos likes pertenecen a un usuario (a la imagen de un usuario)
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id'); // despues de la coma -> es el foreing key de la tabla del protected
    }
    
    // Las imagenes seran de muchos a uno (belongsTo)
    // Muchos likes van a pertenecer a una sola imagenen
    public function images() {
        return $this->belongsTo('App\Models\Image', 'image_id');
    }




}
