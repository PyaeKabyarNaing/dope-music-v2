<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Genre;
use App\Models\Song;
use App\Models\Album;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $list = ['Pop', 'Rock', 'Classical', 'Opera', 'Country', 'Jazz', 'Blues', 'EDM', 'Hip Hop', 'R&B', 'DJ', 'Metal', 'Punk'];
        foreach($list as $name) {
            Genre::create(['name' => $name]);
        }

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'tadmin@example.com',
        ]);
        User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
        ]);
    
        User::factory()->create([
            'name' => 'Queen',
            'email' => 'queen@example.com',
            'image' => 'images/69291652d9060.jpg',
        ]);
        User::factory()->create([
            'name' => 'Test Artist',
            'email' => 'tartist@example.com',
            'image' => 'images/692424182bb26.png',
        ]);
        User::factory()->create([
            'name' => 'Sia',
            'email' => 'sia@example.com',
            'image' => 'images/69281e28b7a43.jpg',
        ]);
        User::factory()->create([
            'name' => 'Billie Eilish',
            'email' => 'billie@example.com',
            'image' => 'images/69281d71221c1.jpg',
        ]);
        User::factory()->create([
            'name' => 'Eminem',
            'email' => 'enimem@example.com',
            'image' => 'images/Eminem.jpg',
        ]);
        User::factory()->create([
            'name' => 'Kendrick Lamar',
            'email' => 'kendrick@example.com',
            'image' => 'images/KDot.jpg',
        ]);
        User::factory()->create([
            'name' => 'Ariana Grande',
            'email' => 'ariana@example.com',
            'image' => 'images/Ariana.jpg',
        ]);
        User::factory()->create([
            'name' => '50 Cent',
            'email' => '50@example.com',
            'image' => 'images/50_Cent.jpeg',
        ]);
        User::factory()->create([
            'name' => 'J Cole',
            'email' => 'j@example.com',
            'image' => 'images/J_Cole.jpeg',
        ]);

        $this->call(RolePermissionSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // User::factory(10)->create();
        $this->call(UserSeeder::class);

        Album::create([
            'name' => 'Album Bohemian',
            'artist_name' => 'Queen',
            'cover_image' => 'images/69253a92d1f4b.jpg',
            'description' => 'des',
            'release_year' => 1999,
            'user_id' => 3,
        ]);
        Album::create([
            'name' => 'Summer Album',
            'artist_name' => 'Queen',
            'cover_image' => 'images/69253a2548f0e.jpg',
            'description' => 'des',
            'release_year' => 2000,
            'user_id' => 3,
        ]);
        Album::create([
            'name' => 'This Album',
            'artist_name' => 'Queen',
            'cover_image' => 'images/69253a2548f0e.jpg',
            'description' => 'des',
            'release_year' => 2000,
            'user_id' => 3,
        ]);
        Album::create([
            'name' => 'That Album',
            'artist_name' => 'Queen',
            'cover_image' => 'images/69253a2548f0e.jpg',
            'description' => 'des',
            'release_year' => 2000,
            'user_id' => 3,
        ]);
        Album::create([
            'name' => 'Just An Album',
            'artist_name' => 'Another Queen',
            'cover_image' => 'images/69253a2548f0e.jpg',
            'description' => 'des',
            'release_year' => 2000,
            'user_id' => 3,
        ]);
        Album::create([
            'name' => 'Not Boring Album',
            'artist_name' => 'Another Queen',
            'cover_image' => 'images/69253a2548f0e.jpg',
            'description' => 'des',
            'release_year' => 2000,
            'user_id' => 3,
        ]);

        Song::create([
            'name' => 'Bohemian Rhapsody',
            'artist_name' => 'Queen',
            'ft_artist_name' => 'noone',
            'cover_image' => 'images/69291652d9060.jpg',
            'audio_file' => 'songs/69253a254aba0.mp3',
            'genre_id' => Genre::where('name', 'Rock')->first()->id,
            'description' => 'des',
            'user_id' => 4,
        ]);
        Song::create([
            'name' => 'Snowman',
            'artist_name' => 'Sia',
            'cover_image' => 'images/69281e28b7a43.jpg',
            'audio_file' => 'songs/69281e28b9412.mp3',
            'genre_id' => Genre::where('name', 'Pop')->first()->id,
            'description' => 'des',
            'user_id' => 5,
        ]);

        Song::create([
            'name' => 'Bad Guy',
            'artist_name' => 'Billie Eilish',
            'cover_image' => 'images/69281d71221c1.jpg',
            'audio_file' => 'songs/69281d7123dec.mp3',
            'genre_id' => Genre::where('name', 'Pop')->first()->id,
            'description' => 'des',
            'user_id' => 6,
        ]);

        Song::create([
            'name' => 'M.A.A.D City',
            'artist_name' => 'Kendrick Lamar',
            'cover_image' => 'images/Maad_City.jpeg',
            'audio_file' => 'songs/69294882d9704.mp3',
            'genre_id' => Genre::where('name', 'Hip Hop')->first()->id,
            'description' => 'des',
            'user_id' => 8,
        ]);

        $this->call(SongSeeder::class);

        $album1 = Album::find(1);
        $album1->songs()->attach([1, 2, 3, 4]);

        $album2 = Album::find(2);
        $album2->songs()->attach([1, 2]);

        $albums = Album::where('id', '>', 0)->get();
        $songs = Song::all();

        $albums->each(function ($album) use ($songs) {
            $randomSongs = $songs->random(rand(1, 54))->pluck('id');
            $album->songs()->attach($randomSongs);
        });

    }
}
