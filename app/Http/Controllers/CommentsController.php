<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Image;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function comments($image_id) {
        $image = Image::findOrFail($image_id);
        $comments = Comment::where('image_id', $image_id)
        ->orderBy('id', 'desc')
        ->get();
        return view('comments.comments',[
            "comments" => $comments,
            'image' => $image
        ]);
    }

    public function store(Request $request, $image_id) {

        $this->validate($request, [
            'comments' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $request->input('comments');

        $comment->save();

        return redirect()->route('comments.view', ['image_id' => $image_id]);

    }

    public function destroy() {
        // mira el diseño del cuaderno
    }
}


