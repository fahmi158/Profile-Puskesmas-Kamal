<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Document::where('title', 'like', '[DEMO]%')->delete();

        $items = [
            ['title' => 'Standar Pelayanan Puskesmas', 'category' => 'Standar Pelayanan'],
            ['title' => 'Profil Puskesmas Kamal', 'category' => 'Profil'],
            ['title' => 'Laporan Tahunan', 'category' => 'Laporan'],
            ['title' => 'Surat Keputusan Tarif Layanan', 'category' => 'Regulasi'],
        ];

        foreach ($items as $item) {
            Document::updateOrCreate(
                ['title' => $item['title']],
                [
                    'description' => 'Dokumen kategori '.$item['category'].'. Berkas asli dapat diunggah oleh petugas melalui panel administrasi.',
                    'category' => $item['category'],
                    'file' => 'documents/placeholder.pdf',
                    'file_type' => 'pdf',
                    'file_size' => 672,
                    'published_at' => now()->subDays(5),
                    'status' => 'published',
                ],
            );
        }
    }
}
