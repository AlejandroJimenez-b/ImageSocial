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

        return response()->json(['success' => true]);

    }

    public function destroy($comment_id) {
        $user = Auth::user();

        $comment = Comment::where('user_id', $user->id)
        ->where('id', $comment_id)
        ->first();

        if ($comment) {
            $comment->delete();
        }

        return response()->json(['success' => true]);
    }

    public function getComments($image_id) {
        $comments = Comment::where('image_id', $image_id)
            ->with('user')  // ✅ evita N+1 queries
            ->get();

        return response()->json([
            'comments' => $comments->map(function($comment) {
                return [
                    'id'         => $comment->id,
                    'content'    => $comment->content,
                    'nick'       => $comment->user->nick,
                    'avatar'     => route('user.avatar', ['filename' => $comment->user->image]),
                    'created_at' => $comment->created_at_human,
                    'is_owner'   => $comment->user_id == auth()->user()->id,
                ];
            })
        ]);
    }

}


