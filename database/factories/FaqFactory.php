<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => fake()->sentence(6).'?',
            'answer' => '<p>'.fake()->paragraph().'</p>',
            'category' => fake()->randomElement(['Layanan', 'Pendaftaran', 'Umum']),
            'sort_order' => fake()->numberBetween(0, 20),
            'status' => 'published',
        ];
    }
}
