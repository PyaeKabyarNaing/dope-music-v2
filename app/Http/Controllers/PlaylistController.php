<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    public function show()
    {
        $playlists = Playlist::all();
        return view('playlists.show', compact('playlists'));
    }

    public function detail(Playlist $playlist)
    {
        $playlist->load('songs', 'songs.user', 'songs.comments.user');

        return view('playlists.detail', [
        'playlist' => $playlist,
        'songs' => $playlist->songs,
    ]);
    }

    // Show create playlist form
    public function create()
    {
        return view('playlists.create');
    }

    // Store new album
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        Playlist::create([
            'name' => $request->name,
            'description' => $request->description,
            'release_year' => $request->release_year,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('playlist.create')
            ->with('success', 'Album created successfully!');
    }
}
