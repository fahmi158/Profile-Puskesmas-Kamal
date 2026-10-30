<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 9999),
            'description' => fake()->paragraph(),
            'youtube_url' => 'https://www.youtube.com/watch?v='.Str::random(11),
            'thumbnail' => null,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'status' => 'published',
        ];
    }
}
