<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'slug' => 'poli-umum',
                'name' => 'Poli Umum',
                'description' => '<p>Pelayanan pemeriksaan, pengobatan, dan konseling kesehatan untuk pasien umum.</p>',
                'requirements' => '<ul><li>Kartu identitas (KTP/KIA)</li><li>Kartu BPJS Kesehatan (bila ada)</li></ul>',
                'schedule' => 'Senin - Sabtu, 07.00 - 14.00',
                'location' => 'Poli Umum',
                'icon' => 'user',
                'featured' => true,
            ],
            [
                'slug' => 'ugd-24-jam',
                'name' => 'UGD 24 Jam',
                'description' => '<p>Pelayanan gawat darurat 24 jam setiap hari untuk penanganan kasus kegawatdaruratan.</p>',
                'requirements' => '<ul><li>Datang langsung ke UGD</li></ul>',
                'schedule' => '24 Jam, Setiap Hari',
                'location' => 'UGD',
                'icon' => 'bolt',
                'featured' => true,
            ],
            [
                'slug' => 'poli-gigi-dan-mulut',
                'name' => 'Poli Gigi dan Mulut',
                'description' => '<p>Pelayanan kesehatan gigi dan mulut, pemeriksaan, penambalan, pencabutan, dan tindakan perawatan gigi lainnya.</p>',
                'requirements' => '<ul><li>Kartu identitas (KTP/KIA)</li><li>Kartu BPJS Kesehatan (bila ada)</li></ul>',
                'schedule' => 'Senin - Sabtu, 07.00 - 14.00',
                'location' => 'Poli Gigi dan Mulut',
                'icon' => 'face-smile',
                'featured' => true,
            ],
            [
                'slug' => 'poli-kia-kb',
                'name' => 'Poli KIA & KB',
                'description' => '<p>Pelayanan kesehatan ibu hamil, ibu nifas, bayi, balita, remaja, dan pelayanan keluarga berencana.</p>',
                'requirements' => '<ul><li>Buku KIA</li><li>Kartu identitas</li><li>Kartu BPJS Kesehatan (bila ada)</li></ul>',
                'schedule' => 'Senin - Sabtu, 07.00 - 14.00',
                'location' => 'Poli KIA & KB',
                'icon' => 'heart',
                'featured' => true,
            ],
            [
                'slug' => 'laboratorium',
                'name' => 'Laboratorium',
                'description' => '<p>Pelayanan pemeriksaan penunjang laboratorium untuk mendukung diagnosis dan pengobatan.</p>',
                'requirements' => '<ul><li>Surat pengantar/pemeriksaan dari poli perujuk</li><li>Kartu identitas</li><li>Kartu BPJS Kesehatan (bila ada)</li></ul>',
                'schedule' => 'Senin - Sabtu, 07.00 - 14.00',
                'location' => 'Laboratorium',
                'icon' => 'beaker',
                'featured' => true,
            ],
            [
                'slug' => 'rawat-inap',
                'name' => 'Rawat Inap',
                'description' => '<p>Pelayanan perawatan pasien yang membutuhkan observasi atau rawat inap di Puskesmas.</p>',
                'requirements' => '<ul><li>Kartu identitas (KTP/KIA)</li><li>Kartu BPJS Kesehatan (bila ada)</li></ul>',
                'schedule' => '24 Jam (sesuai kebutuhan)',
                'location' => 'Rawat Inap',
                'icon' => 'home-modern',
                'featured' => false,
            ],
            [
                'slug' => 'poli-tb-kusta',
                'name' => 'Poli TB & Kusta',
                'description' => '<p>Pelayanan penemuan, diagnosis, pengobatan, dan pemantauan pasien TB dan Kusta.</p>',
                'requirements' => '<ul><li>Kartu identitas</li><li>Kartu BPJS Kesehatan (bila ada)</li></ul>',
                'schedule' => 'Sesuai jadwal poli',
                'location' => 'Poli TB & Kusta',
                'icon' => 'shield-exclamation',
                'featured' => false,
            ],
            [
                'slug' => 'farmasi',
                'name' => 'Farmasi',
                'description' => '<p>Pelayanan penebusan obat, informasi obat, dan konseling penggunaan obat.</p>',
                'requirements' => '<ul><li>Resep dari poli</li><li>Kartu identitas (bila diperlukan)</li></ul>',
                'schedule' => 'Senin - Sabtu, 07.00 - 14.00',
                'location' => 'Farmasi',
                'icon' => 'plus-circle',
                'featured' => false,
            ],
            [
                'slug' => 'persalinan',
                'name' => 'Persalinan',
                'description' => '<p>Pelayanan persalinan normal dan pertolongan persalinan oleh tenaga kesehatan yang kompeten.</p>',
                'requirements' => '<ul><li>Buku KIA</li><li>Kartu identitas</li><li>Kartu BPJS Kesehatan (bila ada)</li></ul>',
                'schedule' => '24 Jam (sesuai kebutuhan)',
                'location' => 'Ruang Persalinan',
                'icon' => 'heart',
                'featured' => false,
            ],
            [
                'slug' => 'neonatus',
                'name' => 'Neonatus',
                'description' => '<p>Pelayanan perawatan bayi baru lahir, pemantauan, dan penanganan dini masalah neonatus.</p>',
                'requirements' => '<ul><li>Buku KIA</li><li>Kartu identitas orang tua</li></ul>',
                'schedule' => '24 Jam (sesuai kebutuhan)',
                'location' => 'Ruang Neonatus',
                'icon' => 'sparkles',
                'featured' => false,
            ],
            [
                'slug' => 'konseling',
                'name' => 'Konseling',
                'description' => '<p>Pelayanan konseling kesehatan, edukasi, dan kunjungan sehat sesuai kebutuhan.</p>',
                'requirements' => '<ul><li>Kartu identitas (KTP/KIA)</li></ul>',
                'schedule' => 'Senin - Sabtu, 07.00 - 14.00',
                'location' => 'Ruang Konseling',
                'icon' => 'chat-bubble-left-right',
                'featured' => false,
            ],
            [
                'slug' => 'home-visit',
                'name' => 'Home Visit',
                'description' => '<p>Pelayanan kunjungan rumah (home visit) bagi pasien yang tidak bisa berobat ke Puskesmas.</p>',
                'requirements' => '<ul><li>Permohonan/rujukan dari poli atau petugas</li></ul>',
                'schedule' => 'Sesuai jadwal petugas',
                'location' => 'Kunjungan Rumah',
                'icon' => 'truck',
                'featured' => false,
            ],
            [
                'slug' => 'catin',
                'name' => 'CATIN',
                'description' => '<p>Pelayanan kesehatan bagi Calon Pengantin (CATIN) meliputi pemeriksaan dan konseling pra nikah.</p>',
                'requirements' => '<ul><li>Kartu identitas</li><li>Formulir CATIN (jika ada)</li></ul>',
                'schedule' => 'Sesuai jadwal',
                'location' => 'Poli KIA & KB',
                'icon' => 'user-group',
                'featured' => false,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service + ['status' => 'published'],
            );
        }
    }
}
