<?php

namespace App\Http\Controllers;
use App\Models\Favorite;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Http\Request;

class FavoritosController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth::user();

        $images = Image::whereHas('favorites', function($query) use ($user) {
        $query->where('user_id', $user->id);
        })
        ->with(['user', 'likes', 'comments'])
        ->orderBy('id', 'desc')
        ->get();

        return view('favourits.favoritos', compact('images'), compact('user'));
    }

    public function favorite($image_id) {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
        ->where('image_id', $image_id)
        ->count();

        if ($favorite == 0) {
            $favorite = new Favorite();
            $favorite->user_id = $user->id;
            $favorite->image_id = (int)$image_id;
            $favorite->save();
            $total = \App\Models\Favorite::where('image_id', $image_id)->count();
            return response()->json([
                "favorite" => $favorite,
                "total" => $total
            ]); 
        }else{
            return response()->json(["message", "Ya has dado favorito a esta imagen"]);
        }
    }

    public function disfavorite($image_id) {
        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)
        ->where('image_id', $image_id)
        ->first(); // first (me devuelve el objeto favorite)

        if ($favorite) {
            $favorite->delete();
            $total = \App\Models\Favorite::where('image_id', $image_id)->count();
            return response()->json([
                "favorite" => $favorite,
                "total" => $total,
                "message" => "Has eliminado esta publicacion de favoritos"
            ]);
        }else{
            return response()->json([
                "Error al eliminar de favoritos"
            ]);
        }
    }


}
