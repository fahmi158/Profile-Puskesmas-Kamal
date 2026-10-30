<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
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
            'content' => collect(fake()->paragraphs(3))->map(fn ($p) => "<p>{$p}</p>")->implode(''),
            'thumbnail' => null,
            'is_active' => true,
            'priority' => fake()->numberBetween(0, 5),
            'starts_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'ends_at' => fake()->dateTimeBetween('now', '+2 months'),
            'status' => 'published',
        ];
    }
}
