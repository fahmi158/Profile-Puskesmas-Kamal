<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Seeder;

class AlbumPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $albums = Album::orderBy('id')->get();

        if ($albums->isEmpty()) {
            return;
        }

        foreach ($albums as $album) {
            $album->update(['cover_image' => 'photos/placeholder.svg']);

            foreach (range(1, 4) as $index) {
                $album->photos()->updateOrCreate(
                    ['sort_order' => $index],
                    [
                        'image' => 'photos/placeholder.svg',
                        'caption' => $album->title." - foto {$index}",
                    ],
                );
            }
        }
    }
}
