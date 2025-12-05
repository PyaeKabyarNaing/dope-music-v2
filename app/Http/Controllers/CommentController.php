<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function view($id)
    {
        $song = Song::findOrFail($id);
        return view('albums.show', compact('song'));
        // return view('songs.detail', compact('song'));
    }

    public function fetch($id)
    {
        $song = Song::with('comments.user')->findOrFail($id);
        return response()->json($song->comments);
    }


    public function store(Request $request) {
        $request->validate([
            'content' => 'required',
            'song_id' => 'required',
        ]);

        $comment = new Comment;
        $comment->content = $request->content;
        $comment->song_id = $request->song_id;
        $comment->user_id = Auth::id();
        $comment->save();

        return back()->with('success', 'Comment added!');
    }
}
