<?php

namespace Database\Factories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 9999),
            'description' => fake()->paragraph(),
            'event_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'category' => fake()->randomElement(['Kegiatan', 'Penyuluhan', 'Posyandu', 'Pelatihan']),
            'cover_image' => null,
            'status' => 'published',
        ];
    }
}
