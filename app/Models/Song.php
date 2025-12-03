<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Laravel\Scout\Engines\Engine;
use Laravel\Scout\Scout;

class Song extends Model
{
    use HasFactory, Searchable;
    
    protected $fillable = [
        'name',
        'artist_name',
        'ft_artist_id',
        'genre_id',
        'cover_image',
        'audio_file',
        'description',
        'user_id',
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'album_song');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'artist_name' => $this->artist_name,
            'ft_artist_name' => $this->ft_artist_name,
            'description' => $this->description,
            'created_at' => $this->created_at->timestamp,
        ];
    }
}
