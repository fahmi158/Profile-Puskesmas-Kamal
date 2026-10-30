<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement(['Standar Pelayanan', 'Laporan', 'Profil', 'Regulasi']),
            'file' => 'documents/'.fake()->uuid().'.pdf',
            'file_type' => 'pdf',
            'file_size' => fake()->numberBetween(100_000, 5_000_000),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'status' => 'published',
        ];
    }
}
