<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Genre;
use App\Models\Album;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{

public function index(Request $request)
    {
        $users = User::all();
        $songs = Song::orderBy('created_at', 'desc')->get();
        $albums = Album::all();
        $genres = Genre::all();
        $artists = User::role('artist')->get();

        $users_query = User::query();

        $search_param = $request->query('q');

        if($search_param) {
            $users_query = User::search($search_param);
        }

        $searchSongs = $users_query->get();

        return view('welcome', compact('users', 'genres', 'songs', 'albums', 'artists', 'search_param', 'searchSongs'));
    }

    public function filterByGenre(Genre $genre)
    {
        $songs = Song::where('genre_id', $genre->id)->get();
        $genres = Genre::all();
        $albums = Album::all();
        $artists = User::role('artist')->get();

        return view('welcome', compact('songs', 'genres', 'albums', 'artists'));
    }
}