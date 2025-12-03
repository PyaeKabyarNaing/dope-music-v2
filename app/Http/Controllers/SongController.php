<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Genre;
use App\Models\Album;
use App\Models\Song;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class SongController extends Controller
{
    public function show(Song $song)
    {
        // $song = Song::with('user', 'comments.user')->findOrFail($song->id);
        $song->load('user', 'comments.user');

        return view('songs.detail', [
        'song' => $song,
        'user' => $song->user,
    ]);
    }

    public function index()
    {
        $users = User::all();
        $songs = Song::orderBy('created_at', 'desc')->get();
        $albums = Album::all();
        $genres = Genre::all();
        $artists = User::role('artist')->get();

        return view('users.index', compact('users', 'genres', 'songs', 'albums', 'artists'));
    }

    public function search(Request $request) {
        $search = $request->input('search');
        
        $songs = Song::query()
            ->when($search, function (Builder $query, $searchTerm) {
                return $query->whereIn('id', Song::search($searchTerm)->keys());
            })
            ->get();

        $albums = Album::query()
            ->when($search, function (Builder $query, $searchTerm) {
                return $query->whereIn('id', Album::search($searchTerm)->keys());
            })
            ->get();

            $users = User::query()
            ->when($search, function (Builder $query, $searchTerm) {
                return $query->whereIn('id', User::search($searchTerm)->keys());
            })
            ->get();
        
        return view('users.search', compact('songs', 'albums', 'users', 'search'));
    }

    // public function search(Request $request)
    // {
    // $request->validate([
    //     'search' => 'nullable|string|max:255',
    // ]);
    
    // $searchTerm = $request->input('search', '');
    
    // // Only search if term is provided
    // if (empty($searchTerm)) {
    //     return view('users.search', [
    //         'searchTerm' => '',
    //         'searchSongs' => collect(),
    //         'searchAlbums' => collect(),
    //         'searchUsers' => collect(),
    //     ]);
    // }
    
    // try {
    //     $searchSongs = Song::search($searchTerm)->get();
    //     $searchAlbums = Album::search($searchTerm)->get();
    //     $searchUsers = User::search($searchTerm)->get();
        
    //     return view('users.search', compact(
    //         'searchTerm', 
    //         'searchSongs', 
    //         'searchAlbums', 
    //         'searchUsers'
    //     ));
    // } catch (\Exception $e) {
    //     // Log error and return empty results
    //     Log::error('Search failed: ' . $e->getMessage());
        
    //     return view('users.search', [
    //         'searchTerm' => $searchTerm,
    //         'searchSongs' => collect(),
    //         'searchAlbums' => collect(),
    //         'searchUsers' => collect(),
    //         'error' => 'Search is temporarily unavailable',
    //     ]);
    // }
    // }

    public function filterByGenre(Genre $genre)
    {
        $songs = Song::where('genre_id', $genre->id)->get();
        $genres = Genre::all();
        $albums = Album::all();
        $artists = User::role('artist')->get();

        return view('users.index', compact('songs', 'genres', 'albums', 'artists'));
    }

    // create song page
    public function create() {
        $genres = Genre::all();
        $albums = Album::where('user_id', auth()->id())->get();

        return view('songs.create', [
            'genres' => $genres,
            'albums' => $albums,
        ]);
    }

    public function edit(Song $song) {
        $genres = Genre::all();
        $albums = Album::where('user_id', auth()->id())->get();

        return view('songs.edit', compact('song', 'genres', 'albums'));
    }

    public function store(Request $request) {
        $request->validate([
            "name" => "required",
            "artist_name" => "required",
            "ft_artist_name" => "nullable",
            "cover_image" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
            "audio_file" => "required|mimes:mp3,wav,ogg|max:10240",
            "genre_id" => "required",
            "album_id" => "nullable",
            "description" => "nullable",
        ]);

        if ($request->hasFile('cover_image')) {
        $cover = $request->file('cover_image');

        $coverName = uniqid() . '.' . $cover->getClientOriginalExtension();

        // save to storage/app/public/covers
        $cover->storeAs('images', $coverName, 'public');
    }

        // $audioPath = $request->file('audio_file')->store('songs', 'public');

        if ($request->hasFile('audio_file')) {
        $audio = $request->file('audio_file');

        // create random file name + keep extension
        $audioName = uniqid() . '.' . $audio->getClientOriginalExtension();

        // save to storage/app/public/songs
        $audio->storeAs('songs', $audioName, 'public');
    }

        $song = Song::create([
            'name' => $request->name,
            'artist_name' => $request->artist_name,
            'ft_artist_name' => $request->ft_artist_name,
            'genre_id' => $request->genre_id,
            'cover_image' => isset($coverName) ? ('images/' . $coverName) : null,
            'audio_file' => 'songs/' . $audioName,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);
        if ($request->has('album_ids') && array_filter($request->album_ids)) {
    $song->albums()->sync($request->album_ids); // attach selected albums
} else {
    $song->albums()->detach(); // no albums selected
}

        return redirect()->route('song.create')->with('success', 'Song uploaded successfully!');
    }

    public function update(Request $request, $id)
{ $song = Song::findOrFail($id);
    $request->validate([
        "name" => "required",
        "artist_name" => "required",
        "ft_artist_name" => "nullable",
        "cover_image" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
        "audio_file" => "nullable|mimes:mp3,wav,ogg|max:10240",
        "genre_id" => "required",
        "album_id" => "nullable",
        "description" => "nullable",
    ]);

    // COVER IMAGE
    if ($request->hasFile('cover_image')) {
        if ($song->cover_image && Storage::disk('public')->exists($song->cover_image)) {
            Storage::disk('public')->delete($song->cover_image);
        }
        $cover = $request->file('cover_image');
        $coverName = uniqid().'.'.$cover->getClientOriginalExtension();
        $cover->storeAs('images', $coverName, 'public');
        $song->cover_image = 'images/'.$coverName;
    }

    // AUDIO FILE
    if ($request->hasFile('audio_file')) {
        if ($song->audio_file && Storage::disk('public')->exists($song->audio_file)) {
            Storage::disk('public')->delete($song->audio_file);
        }
        $audio = $request->file('audio_file');
        $audioName = uniqid().'.'.$audio->getClientOriginalExtension();
        $audio->storeAs('songs', $audioName, 'public');
        $song->audio_file = 'songs/'.$audioName;
    }

    // TEXT FIELDS
    $song->name = $request->name;
    $song->artist_name = $request->artist_name;
    $song->ft_artist_name = $request->ft_artist_name;
    $song->genre_id = $request->genre_id;
    $song->description = $request->description;
    // $song->album_id = $request->album_id;
    if ($request->has('album_ids')) {
    $song->albums()->sync($request->album_ids); // replaces old associations
} else {
    $song->albums()->detach(); // remove all if none selected
}

    // KEEP EXISTING USER
    // do NOT change $song->user_id

    $song->save();

    return back()->with('success', 'Song updated successfully!');
}

}
