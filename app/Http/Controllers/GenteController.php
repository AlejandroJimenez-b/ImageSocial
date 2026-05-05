<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Friendship;

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

    // Busca si existe alguna relacion entre el usuario logueado y este perfil
    $friendship = Friendship::where(function($q) use ($id) {
                        $q->where('user_id', Auth::id())
                          ->where('friend_id', $id);
                    })->orWhere(function($q) use ($id) {
                        $q->where('user_id', $id)
                          ->where('friend_id', Auth::id());
                    })->first();

    return view('people.profile', compact('user', 'images', 'friendship'));
}

    // Añadir gente a tu perfil (amigos) (update)
    // Eliminar gente de tu perfil (amigos) (delete)
}
