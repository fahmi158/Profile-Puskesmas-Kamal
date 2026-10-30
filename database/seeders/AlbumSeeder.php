<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Album::where('slug', 'like', 'demo-%')
            ->orWhere('title', 'like', '[DEMO]%')
            ->delete();

        $items = [
            ['title' => 'Dokumentasi Kegiatan Posyandu', 'category' => 'Posyandu', 'offset' => '-20 days'],
            ['title' => 'Dokumentasi Penyuluhan Kesehatan', 'category' => 'Penyuluhan', 'offset' => '-45 days'],
            ['title' => 'Dokumentasi Pelatihan Kader Kesehatan', 'category' => 'Pelatihan', 'offset' => '-70 days'],
        ];

        foreach ($items as $item) {
            Album::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'description' => 'Dokumentasi kegiatan Puskesmas Kamal.',
                    'event_date' => now()->parse($item['offset'])->toDateString(),
                    'category' => $item['category'],
                    'cover_image' => null,
                    'status' => 'published',
                ],
            );
        }
    }
}
