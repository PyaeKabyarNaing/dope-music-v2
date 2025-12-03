<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->colorName(),
            'artist_name' => $this->faker->name(),
            'ft_artist_name' => $this->faker->name(),
            'cover_image' => 'images/69281e28b7a43.jpg',
            'audio_file' => 'songs/69281e28b9412.mp3',
            'genre_id' => rand(1, 13),
            'description' => $this->faker->sentence(),
            'user_id' => rand(3, 11),
        ];
    }
}
