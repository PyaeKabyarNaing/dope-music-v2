<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Song;
use App\Models\Comment as UserComment;
use Dom\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    // public function detail(Album $album, Song $song)
    // {
    //     $album->load('songs', 'songs.user', 'songs.comments.user');

    //     return view('albums.detail', [
    //     'album' => $album,
    //     'songs' => $album->songs,
    // ]);

    // $songs = $album->songs;

    // return view('albums.detail', compact('album', 'songs', 'song'));
    // }

    public function detail(Album $album)
    {
        $album->load('songs', 'songs.user', 'songs.comments.user');

        return view('albums.detail', [
        'album' => $album,
        'songs' => $album->songs,
    ]);

    return view('albums.detail', compact('album', 'songs'));
    }

    // Show create album form
    public function create()
    {
        return view('albums.create');
    }

    // Store new album
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'artist_name' => 'required',
            'cover_image' => 'required',
            'description' => 'nullable',
            'release_year' => 'nullable',
        ]);

        if ($request->hasFile('cover_image')) {
        $cover = $request->file('cover_image');

        $coverName = uniqid() . '.' . $cover->getClientOriginalExtension();

        // save to storage/app/public/covers
        $cover->storeAs('images', $coverName, 'public');
    }

        Album::create([
            'name' => $request->name,
            'artist_name' => $request->artist_name,
            'cover_image' => 'images/' . $coverName,
            'description' => $request->description,
            'release_year' => $request->release_year,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('album.create')
            ->with('success', 'Album created successfully!');
    }

    public function edit(Album $album)
    {
        $allSongs = Song::all();

        return view('albums.edit', compact('album', 'allSongs'));
    }

    public function update(Request $request, Album $album)
{
    $request->validate([
        'name' => 'required',
        'artist_name' => 'required',
        'cover_image' => 'nullable|image',
        'description' => 'nullable',
        'release_year' => 'nullable',
        'songs' => 'nullable|array', // for syncing songs
    ]);

    // Handle cover image
    if ($request->hasFile('cover_image')) {
        // Delete old image if exists
        if ($album->cover_image && Storage::disk('public')->exists($album->cover_image)) {
            Storage::disk('public')->delete($album->cover_image);
        }

        $cover = $request->file('cover_image');
        $coverName = uniqid() . '.' . $cover->getClientOriginalExtension();
        $cover->storeAs('images', $coverName, 'public');
        $album->cover_image = 'images/' . $coverName;
    }

    $album->name = $request->name;
    $album->artist_name = $request->artist_name;
    $album->description = $request->description;
    $album->release_year = $request->release_year;
    $album->save();

    // Sync songs if any
    if ($request->has('songs')) {
        $album->songs()->sync($request->songs);
    }

    return redirect()->route('album.edit', $album->id)
        ->with('success', 'Album updated successfully!');
}

public function addSong(Request $request, Album $album)
{
    $song = Song::find($request->song_id);
    if ($song && !$album->songs->contains($song->id)) {
        // $song->album_id = $album->id;
        // $song->save();
        $album->songs()->attach($song->id);

    }
    return back()->with('success', 'Song added to album!');
}

public function removeSong(Album $album, Song $song)
{
    if ($album->songs->contains($song->id)) {
        // $song->album_id = null;
        // $song->save();
        $album->songs()->detach($song->id);
    }
    return redirect()->route('album.edit', $album)->with('success', 'Song removed successfully.');
}
}
