<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Response;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Creo este constructor para que cuando entre a este controller se asegure que el usuario esta autenticado (solamente podra acceder a los metodos del controller si esta identificado)
    public function __construct(){
        $this->middleware('auth');
    }

    // Metodo para logica de likes (crea un objeto like (un like) si no existe) 1 vez por usuario
    public function like($image_id) {
        // Primer paso: Recoger los datos del user y de la imagen
        $user = Auth::user();

        // Valido que el user solo pueda dar 1 like
        // Semanticamente significa: ¿Existe un like de este usuario concreto en esta imagen concreta?
        // Comprueba si el usuario actual ya ha dado like a esta imagen
        $like = Like::where('user_id', $user->id)
        ->where('image_id', $image_id)
        ->count();

        if ($like == 0) { // Si el objeto $like no existe (no hay likes del usuario identificado)
            $like = new Like(); // Preparo un nuevo like para guardarlo en la base de datos
            $like->user_id = $user->id; // Donde el user_id de la tabla likes sea igual al id del usuario
            $like->image_id = (int)$image_id; // Y donde image_id de la tabla likes sea igual al id de la imagen
            $like->save(); // Registro el like del usuario identificado en esa imagen -> en la db
            // Devuelvo un json porque asi lo requiere AJAX en javascript (para el sistema de likes y funcionalidad del boton like/dislike)
            $total = \App\Models\Like::where('image_id', $image_id)->count();
            return response()->json([
                "like" => $like,
                "total" => $total
                ]);
        }else{
            return response()->json(["message", "Ya has dado like a esta imagen"]);
        }

    }
    // Metodo para logica de dislikes (elimina un objeto like (un like) si existe) si ha pulsado mas de 1 vez por usuario
    public function dislike($image_id) {
        $user = Auth::user();
        $like = Like::where('user_id', $user->id)
        ->where('image_id', $image_id)
        ->first(); // first (me devuelve el objeto like)

        if ($like) {
            $like->delete();
            $total = \App\Models\Like::where('image_id', $image_id)->count();
            return response()->json([
                "like" => $like, // Me devuelve el objeto que he eliminado
                "total" => $total,
                "message", "Has dado dislike",
                ]);
        }else{
            return response()->json([
                "message", "El dislike no existe"
                ]);
        }

    }

}
