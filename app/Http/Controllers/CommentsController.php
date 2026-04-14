<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
// use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function comments($image_id) {
        $comments = Comment::where('image_id', $image_id)->get();
        return view('comments.comments',[
            "comment" => $comments
        ]);
    }

    public function store() {
        // mira el diseño del cuaderno
    }

    public function destroy() {
        // mira el diseño del cuaderno
    }
}


