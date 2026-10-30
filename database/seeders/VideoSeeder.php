<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Video::where('slug', 'like', 'demo-%')
            ->orWhere('title', 'like', '[DEMO]%')
            ->delete();

        $items = [
            [
                'title' => 'Cuci Tangan Pakai Sabun dengan Air Mengalir',
                'id' => '7-DsLkpJtfc',
                'offset' => '-10 days',
                'description' => 'Video edukasi mengenai cara mencuci tangan pakai sabun dengan air mengalir yang benar.',
            ],
            [
                'title' => 'Cegah Stunting dengan ABCDE',
                'id' => 'NU_MDQ2iNYE',
                'offset' => '-30 days',
                'description' => 'Video edukasi Kementerian Kesehatan mengenai pencegahan stunting melalui pendekatan ABCDE.',
            ],
        ];

        foreach ($items as $item) {
            Video::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'youtube_url' => 'https://www.youtube.com/watch?v='.$item['id'],
                    'thumbnail' => null,
                    'published_at' => now()->parse($item['offset']),
                    'status' => 'published',
                ],
            );
        }
    }
}
