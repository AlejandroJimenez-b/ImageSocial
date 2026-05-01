<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request) {
        $q = $request->input('q');

        $users = User::where('nick', 'LIKE', "%{$q}%")
                     ->orWhere('name', 'LIKE', "%{$q}%")
                     ->get();

        $images = Image::where('description', 'LIKE', "%{$q}%")
                       ->get();

        return view('search.search', compact('users', 'images', 'q'));
    }
}
