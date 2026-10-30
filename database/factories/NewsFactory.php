<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 9999),
            'category' => fake()->randomElement(['Berita', 'Artikel Kesehatan']),
            'thumbnail' => null,
            'excerpt' => fake()->paragraph(),
            'content' => collect(fake()->paragraphs(4))->map(fn ($p) => "<p>{$p}</p>")->implode(''),
            'user_id' => User::factory(),
            'is_featured' => fake()->boolean(25),
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
