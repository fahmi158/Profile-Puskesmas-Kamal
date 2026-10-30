<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 9999),
            'description' => collect(fake()->paragraphs(3))->map(fn ($p) => "<p>{$p}</p>")->implode(''),
            'requirements' => '<ul><li>Kartu identitas</li><li>Kartu BPJS/Asuransi (bila ada)</li></ul>',
            'schedule' => 'Senin - Jumat, 08.00 - 14.00',
            'location' => 'Gedung Utama Puskesmas',
            'icon' => 'heart',
            'featured' => fake()->boolean(40),
            'status' => 'published',
        ];
    }
}
