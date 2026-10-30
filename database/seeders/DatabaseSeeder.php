<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PageSeeder::class,
            ServiceSeeder::class,
            ScheduleSeeder::class,
            NewsSeeder::class,
            EventSeeder::class,
            AnnouncementSeeder::class,
            AlbumSeeder::class,
            AlbumPhotoSeeder::class,
            VideoSeeder::class,
            FaqSeeder::class,
            DocumentSeeder::class,
        ]);
    }
}
