<?php

namespace App\Http\Controllers;
use App\Models\Image;

// use Illuminate\Http\Request;

// Este controller sera el que distribuya las peticiones de todo lo que conlleve un perfil (su vista sera dashboard.blade.php y en esa vista se podra llamar a diferentes rutas(tambien de otros controllers porque es la general del perfil), imagenes, users, los likes...etc)
class PerfilController extends Controller
{
    public function index() {
        $images = Image::with('user')->orderBy('id', 'desc')->get();
        return view('dashboard', [
            'images' => $images
        ]);
    }
}
