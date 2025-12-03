<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Album extends Model
{
    use Searchable;

    protected $fillable = [
        'name',
        'artist_name',
        'cover_image',
        'description',
        'release_year',
        'user_id'
    ];

    // public function songs()
    // {
    //     return $this->hasMany(Song::class);
    // }

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'album_song');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'artist_name' => $this->artist_name,
            'description' => $this->description,
            'created_at' => $this->created_at->timestamp,
        ];
    }
}
