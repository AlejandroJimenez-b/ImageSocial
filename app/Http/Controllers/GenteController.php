<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class GenteController extends Controller
{
    // Vista para la seccion gente
    public function index() {
        return view('people.gente');
    }

    // Añadir gente (update)
    // Eliminar gente (delete)
}
