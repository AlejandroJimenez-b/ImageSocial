<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\FormatTime;

class Image extends Model
{
    // Enlazo este modelo con su tabla correspondiente
    // Lo enlazo con un atributo/propiedad protected y el nombre de la tabla
    protected $table = 'images';

    // Relacion One To Many (de una a muchas) (hasMany())
    // Se relacionan por los id: id de imagenes -> image_id (tabla comentarios) -> user_id (tabla comentarios) que conecta con el id de la tabla usuarios-> coments_id (tabla comentarios) (hare un metodo para esto)
    public function comments() {
        return $this->hasMany('App\Models\Comment')->orderBy('id', 'desc');
    }
    
    public function likes() {
        return $this->hasMany('App\Models\Like');
    }

    // Como un user puede tener varias imagenes (o solo una) hago una relacion De Muchos A Uno (belongsTo)
    // Relacion: id de Users -> user_id de la tabla Images
    // Muchas imagenes pertenecen a 1 solo usuario
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id'); // despues de la coma -> es el foreing key de la tabla del protected
    }

    public function getCreatedAtHumanAttribute(){
        // Con este metodo propio de Eloquent, para la vista tendria que acceder asi: $image created_at_human (lo genera el mismo Eloquent porque ya sabe que el nombre de este metodo implica eso y hace la logica que he creado en el helper FormatTime)
        return FormatTime::longTimeFilter($this->created_at);
    }

    // Metodo 'accesor' para usar la relacion is_liked con la variable image del foreach(para la logica like, dislike)
    public function getIsLikedAttribute()
    {
        if (!Auth::check()) {
            return false;
        }

        return $this->likes()
            ->where('user_id', Auth::id())
            ->exists();
    }
}
