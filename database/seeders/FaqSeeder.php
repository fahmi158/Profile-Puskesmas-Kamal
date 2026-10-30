<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['category' => 'Pendaftaran', 'question' => 'Apa saja syarat untuk berobat di puskesmas?', 'answer' => '<p>Cukup membawa kartu identitas (KTP/KIA) dan kartu BPJS/Asuransi bila ada.</p>'],
            ['category' => 'Pendaftaran', 'question' => 'Apakah pendaftaran dikenakan biaya?', 'answer' => '<p>Pendaftaran tidak dikenakan biaya untuk pengguna BPJS maupun umum sesuai ketentuan yang berlaku.</p>'],
            ['category' => 'Layanan', 'question' => 'Apa saja layanan yang tersedia?', 'answer' => '<p>Tersedia layanan Poli Umum, Poli Gigi, KIA, Imunisasi, Gizi, dan Laboratorium.</p>'],
            ['category' => 'Layanan', 'question' => 'Berapa lama hasil pemeriksaan laboratorium keluar?', 'answer' => '<p>Hasil pemeriksaan sederhana umumnya selesai pada hari yang sama.</p>'],
            ['category' => 'Umum', 'question' => 'Apakah bisa mendaftar secara online?', 'answer' => '<p>Saat ini pendaftaran dilakukan langsung di loket puskesmas. Informasi daring akan menyusul.</p>'],
            ['category' => 'Umum', 'question' => 'Bagaimana cara menyampaikan keluhan?', 'answer' => '<p>Anda dapat menyampaikan keluhan melalui halaman Kontak atau langsung kepada petugas.</p>'],
        ];

        foreach ($items as $index => $item) {
            Faq::updateOrCreate(
                ['question' => $item['question']],
                [
                    'answer' => $item['answer'],
                    'category' => $item['category'],
                    'sort_order' => $index,
                    'status' => 'published',
                ],
            );
        }
    }
}
