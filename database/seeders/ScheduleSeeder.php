<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

        $services = [
            'poli-umum' => ['days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'], 'start' => '08:00', 'end' => '14:00'],
            'poli-gigi' => ['days' => $weekdays, 'start' => '08:00', 'end' => '13:00'],
            'kia-kb' => ['days' => $weekdays, 'start' => '08:00', 'end' => '13:00'],
            'imunisasi' => ['days' => ['tuesday', 'thursday'], 'start' => '08:00', 'end' => '11:00'],
            'gizi' => ['days' => $weekdays, 'start' => '08:00', 'end' => '12:00'],
            'laboratorium' => ['days' => $weekdays, 'start' => '08:00', 'end' => '12:00'],
        ];

        foreach ($services as $slug => $config) {
            $service = Service::where('slug', $slug)->first();

            if (! $service) {
                continue;
            }

            foreach ($config['days'] as $day) {
                Schedule::updateOrCreate(
                    ['service_id' => $service->id, 'day' => $day],
                    [
                        'service_name' => $service->name,
                        'start_time' => $config['start'],
                        'end_time' => $config['end'],
                        'location' => $service->location,
                        'status' => 'active',
                    ],
                );
            }
        }
    }
}
