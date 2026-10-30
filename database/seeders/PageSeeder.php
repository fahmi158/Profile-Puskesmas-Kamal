<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'tentang',
                'title' => 'Tentang Puskesmas Kamal',
                'excerpt' => 'Pusat Kesehatan Masyarakat Kecamatan Kamal, Kabupaten Bangkalan.',
                'content' => '<p>Puskesmas Kamal merupakan unit pelaksana teknis di bidang kesehatan yang bertanggung jawab menyelenggarakan pembangunan kesehatan di wilayah Kecamatan Kamal, Kabupaten Bangkalan. Kami berkomitmen memberikan pelayanan kesehatan yang bermutu, merata, dan terjangkau bagi seluruh masyarakat.</p><p>Layanan yang tersedia mencakup poli umum, poli gigi, kesehatan ibu dan anak serta keluarga berencana, imunisasi, gizi, dan penunjang laboratorium. Selain pelayanan kuratif, kami juga menyelenggarakan upaya promotif dan preventif melalui penyuluhan, pemantauan tumbuh kembang, dan kerja sama dengan kader kesehatan masyarakat.</p><p>Informasi lebih lanjut mengenai layanan dan kegiatan dapat diperoleh melalui halaman kontak atau menghubungi puskesmas secara langsung.</p>',
            ],
            [
                'slug' => 'sejarah',
                'title' => 'Sejarah Puskesmas',
                'excerpt' => 'Perjalanan dan perkembangan pelayanan Puskesmas Kamal.',
                'content' => '<p>Puskesmas Kamal didirikan sebagai bagian dari upaya pemerintah menyediakan layanan kesehatan dasar bagi masyarakat. Sejak berdiri hingga kini, puskesmas terus berkembang baik dari sisi sarana, prasarana, maupun sumber daya manusia guna memenuhi kebutuhan kesehatan masyarakat yang semakin meningkat.</p><p>Perkembangan pelayanan meliputi perluasan jenis layanan, peningkatan mutu, serta penguatan peran puskesmas sebagai pusat pembangunan kesehatan masyarakat di tingkat kecamatan.</p><p>Uraian sejarah lebih rinci akan dilengkapi oleh petugas puskesmas dengan data resmi.</p>',
            ],
            [
                'slug' => 'visi-misi',
                'title' => 'Visi & Misi',
                'excerpt' => 'Visi dan misi pelayanan Puskesmas Kamal.',
                'content' => '<h3>Visi</h3><p>Terwujudnya masyarakat Kecamatan Kamal yang sehat, mandiri, dan berkeadilan.</p><h3>Misi</h3><ol><li>Menyelenggarakan pelayanan kesehatan yang bermutu dan merata.</li><li>Meningkatkan upaya promotif dan preventif masyarakat.</li><li>Mengembangkan kemitraan dengan masyarakat dan lintas sektor.</li><li>Mewujudkan tata kelola puskesmas yang transparan dan akuntabel.</li></ol>',
            ],
            [
                'slug' => 'struktur-organisasi',
                'title' => 'Struktur Organisasi',
                'excerpt' => 'Susunan organisasi dan tata kerja Puskesmas Kamal.',
                'content' => '<p>Struktur organisasi Puskesmas Kamal terdiri atas Kepala Puskesmas, Kepala Sub Bagian Tata Usaha, serta penanggung jawab berbagai program dan layanan.</p><ul><li>Kepala Puskesmas</li><li>Sub Bagian Tata Usaha</li><li>Penanggung Jawab Poli Umum</li><li>Penanggung Jawab KIA dan Imunisasi</li><li>Penanggung Jawab Gizi</li><li>Penanggung Jawab Laboratorium</li></ul><p>Data nama pejabat struktur organisasi dapat diperbarui oleh petugas melalui panel administrasi.</p>',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page + ['status' => 'published', 'is_home' => false, 'thumbnail' => null],
            );
        }
    }
}
