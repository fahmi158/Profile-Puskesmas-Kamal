<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcement::where('slug', 'like', 'demo-%')
            ->orWhere('title', 'like', '[DEMO]%')
            ->delete();

        $items = [
            [
                'title' => 'Informasi Jam Pelayanan Puskesmas Kamal',
                'priority' => 1,
                'content' => '<p>Layanan Puskesmas Kamal tersedia pada hari kerja sesuai jam operasional yang berlaku. Untuk informasi terkini mengenai jadwal pelayanan, masyarakat dapat menghubungi nomor telepon puskesmas atau melalui WhatsApp informasi dan pengaduan.</p>'
                    .'<p>Masyarakat diimbau membawa kartu identitas dan kartu BPJS Kesehatan (bila ada) untuk mempercepat proses pendaftaran.</p>',
            ],
            [
                'title' => 'Layanan Informasi dan Pengaduan via WhatsApp',
                'priority' => 2,
                'content' => '<p>Puskesmas Kamal membuka layanan informasi dan pengaduan melalui WhatsApp untuk kemudahan masyarakat. Masyarakat dapat menyampaikan pertanyaan seputar layanan, jadwal pemeriksaan, atau masukan terkait pelayanan kesehatan.</p>'
                    .'<p>Layanan ini melengkapi kanal kontak lain seperti telepon, email, dan formulir kontak di website resmi Puskesmas Kamal.</p>',
            ],
        ];

        foreach ($items as $item) {
            Announcement::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'content' => $item['content'],
                    'thumbnail' => null,
                    'is_active' => true,
                    'priority' => $item['priority'],
                    'starts_at' => now()->subDays(2),
                    'ends_at' => now()->addDays(30),
                    'status' => 'published',
                ],
            );
        }
    }
}
