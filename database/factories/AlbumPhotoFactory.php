<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AlbumPhoto>
 */
class AlbumPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'album_id' => Album::factory(),
            'image' => 'photos/'.fake()->uuid().'.jpg',
            'caption' => fake()->sentence(4),
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }
}
