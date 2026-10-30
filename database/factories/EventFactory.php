<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
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
            'description' => collect(fake()->paragraphs(3))->map(fn ($p) => "<p>{$p}</p>")->implode(''),
            'event_date' => fake()->dateTimeBetween('-2 months', '+3 months')->format('Y-m-d'),
            'start_time' => fake()->time('H:i'),
            'end_time' => fake()->time('H:i'),
            'location' => fake()->city(),
            'featured_image' => null,
            'status' => 'published',
        ];
    }

    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_date' => fake()->dateTimeBetween('-6 months', '-1 day')->format('Y-m-d'),
        ]);
    }

    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_date' => fake()->dateTimeBetween('+1 day', '+3 months')->format('Y-m-d'),
        ]);
    }
}
