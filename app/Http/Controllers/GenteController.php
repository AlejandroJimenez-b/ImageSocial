<?php

namespace App\Http\Controllers;
use App\Models\User;

// use Illuminate\Http\Request;

class GenteController extends Controller
{
    // Vista para la seccion gente
    public function index() {
        $users = User::all();
        return view('people.gente',[
            'users' => $users
        ]);
    }

    public function profile($id) {
    $user = User::findOrFail($id);
    $images = $user->images()->orderBy('created_at', 'desc')->get();

    return view('people.profile', [
        'user'   => $user,
        'images' => $images,
    ]);
}

    // Añadir gente a tu perfil (amigos) (update)
    // Eliminar gente de tu perfil (amigos) (delete)
}
