<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startHour = fake()->numberBetween(7, 13);

        return [
            'service_id' => Service::factory(),
            'service_name' => null,
            'day' => fake()->randomElement(['monday', 'tuesday', 'wednesday', 'thursday', 'friday']),
            'start_time' => sprintf('%02d:00', $startHour),
            'end_time' => sprintf('%02d:00', min($startHour + 4, 20)),
            'location' => 'Gedung Utama Puskesmas',
            'status' => 'active',
        ];
    }
}
