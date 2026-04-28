<?php

namespace App\Http\Controllers;
use App\Models\Image;
use Illuminate\Http\Request;

// Este controller sera el que distribuya las peticiones de todo lo que conlleve un perfil (su vista sera dashboard.blade.php y en esa vista se podra llamar a diferentes rutas(tambien de otros controllers porque es la general del perfil), imagenes, users, los likes...etc)
class PerfilController extends Controller
{
    public function index(Request $request) {
        // Aqui hago la paginacion, y los parametros del 'with' es para evitr N + 1 queries (queris de mas a la db que haran mas lentas las consultas)
        $images = Image::with(['user', 'likes', 'comments'])->orderBy('id', 'desc')->paginate(5);

        // Infinite Scroll con ajax (por eso el parametro request)
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.images-loop', compact('images'))->render(),
                'hasMore' => $images->hasMorePages()
            ]);
        }
        // paginacion normal
        return view('dashboard', compact('images'));
    }
}
