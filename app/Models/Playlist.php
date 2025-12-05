<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'song_playlists');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
