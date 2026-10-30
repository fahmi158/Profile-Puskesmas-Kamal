<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::where('slug', 'like', 'demo-%')
            ->orWhere('title', 'like', '[DEMO]%')
            ->delete();

        $author = User::where('role', 'admin')->first() ?? User::first();

        $items = [
            [
                'category' => 'Artikel Kesehatan',
                'featured' => true,
                'title' => 'Mencuci Tangan dengan Sabun, Langkah Sederhana Penangkal Penyakit',
                'excerpt' => 'Mencuci tangan dengan sabun dan air mengalir terbukti mencegah penularan berbagai penyakit menular.',
                'content' => '<p>Mencuci tangan dengan sabun dan air mengalir merupakan salah satu cara paling sederhana dan murah untuk mencegah penularan penyakit. Menurut Kementerian Kesehatan Republik Indonesia, mencuci tangan dengan benar dapat menurunkan risiko diare hingga separuhnya dan mencegah sebagian besar penyakit saluran pernapasan.</p>'
                    .'<p>Lakukan pencucian tangan pada momen-momen penting: sebelum makan, sesudah menggunakan toilet, sesudah batuk atau bersin, sesudah menyentuh hewan, dan sesudah menangani sampah. Teknik yang dianjurkan meliputi gosok seluruh bagian tangan — telapak, punggung tangan, sela-sela jari, dan ujung kuri — selama kurang lebih 20 detik dengan sabun, lalu bilas dengan air mengalir.</p>'
                    .'<p>Jika sabun dan air tidak tersedia, hand sanitizer berbasis alkohol minimal 60 persen dapat digunakan sebagai pengganti sementara. Kebiasaan mencuci tangan yang baik perlu diterapkan di rumah, sekolah, dan tempat kerja agar manfaatnya dirasakan bersama.</p>',
            ],
            [
                'category' => 'Artikel Kesehatan',
                'featured' => false,
                'title' => 'Mengenali Gejala Demam Berdarah Dengue sejak Dini',
                'excerpt' => 'Demam berdarah dengue perlu diwaspadai karena dapat berkembang cepat. Kenali gejalanya agar penanganan tidak terlambat.',
                'content' => '<p>Demam berdarah dengue (DBD) adalah penyakit yang disebarkan nyamuk Aedes aegypti. Gejala awalnya menyerupai flu, yaitu demam tinggi mendadak, sakit kepala, nyeri otot dan sendi, serta mual. Yang perlu diwaspadai adalah tanda perdarahan seperti bintik merah pada kulit, mimisan, atau gusi berdarah, serta nyeri perut terus-menerus.</p>'
                    .'<p>Penanganan dini sangat menentukan. Segera periksakan diri ke fasilitas kesehatan bila demam tinggi tidak kunjung turun lebih dari dua-tiga hari, apalagi disertai tanda perdarahan. Selama masa pemulihan di rumah, perbanyak minum air putih dan istirahat.</p>'
                    .'<p>Pencegahan dimulai dari rumah: terapkan 3M Plus — menguras, menutup, dan mendaur ulang wadah penampungan air, serta menambahkan larvasida, memelihara ikan pemakan jentik, dan menggunakan kelambu atau kasa pada tempat tidur. Pengendalian jentik secara rutin terbukti menekan kejadian DBD di komunitas.</p>',
            ],
            [
                'category' => 'Artikel Kesehatan',
                'featured' => false,
                'title' => 'Imunisasi Dasar Lengkap: Perlindungan Pertama bagi Bayi',
                'excerpt' => 'Imunisasi dasar lengkap memberi perlindungan bagi bayi dari penyakit berbahaya sejak usia dini.',
                'content' => '<p>Imunisasi dasar lengkap adalah serangkaian vaksinasi yang diberikan kepada bayi usia 0–11 bulan untuk membentuk kekebalan tubuh terhadap penyakit berbahaya seperti tuberkulosis, hepatitis B, polio, difteri, tetanus, batuk rejan, campak, dan pneumokokus.</p>'
                    .'<p>Kementerian Kesehatan menegaskan bahwa imunisasi tetap dilaksanakan meski ada isu kekhawatiran efek samping. Vaksin yang digunakan di Indonesia telah melalui proses pengawasan ketat, dan manfaat jauh lebih besar dibanding risikonya. Orang tua disarankan membawa buku KIA setiap kali datang ke posyandu atau puskesmas agar cakupan imunisasi anak terpantau.</p>'
                    .'<p>Jika anak melewatkan jadwal imunisasi, segera konsultasikan dengan petugas kesehatan untuk menentukan langkah penyelisihan yang tepat. Jangan menunda, karena risiko tertular penyakit tetap ada selama perlindungan belum terbentuk.</p>',
            ],
            [
                'category' => 'Artikel Kesehatan',
                'featured' => false,
                'title' => 'Pencegahan Stunting Dimulai sejak 1000 Hari Pertama Kehidupan',
                'excerpt' => 'Stunting bisa dicegah dengan pemenuhan gizi sejak masa kehamilan hingga usia dua tahun anak.',
                'content' => '<p>Stunting adalah kondisi gagal tumbuh akibat kekurangan gizi kronis, ditandai dengan tinggi badan yang lebih rendah dibanding standar usia. Periode kritis pencegahannya adalah 1000 hari pertama kehidupan, yaitu sejak kehamilan hingga anak berusia dua tahun.</p>'
                    .'<p>Pencegahan stunting memerlukan sinergi beberapa hal: pemenuhan gizi ibu hamil, pemberian ASI eksklusif selama enam bulan, MP-ASI bergizi sejak usia enam bulan, imunisasi lengkap, pemantauan tumbuh kembang rutin di posyandu, serta akses air bersih dan sanitasi layak.</p>'
                    .'<p>Keluarga dan kader kesehatan memegang peran penting. Memeriksa kehamilan secara teratur, memastikan asupan bergizi seimbang, dan menjaga kebersihan lingkungan rumah adalah langkah nyata yang dapat dilakukan setiap hari untuk mencegah stunting.</p>',
            ],
            [
                'category' => 'Artikel Kesehatan',
                'featured' => false,
                'title' => 'Pengobatan Tuberkulosis Harus Tuntas Hingga Sembuh',
                'excerpt' => 'Pengobatan tuberkulosis memerlukan kepatuhan minum obat selama enam bulan agar benar-benar sembuh.',
                'content' => '<p>Tuberkulosis (TBC) adalah penyakit menular yang disebabkan kuman Mycobacterium tuberculosis dan umumnya menyerang paru-paru. Gejala utamanya berupa batuk berdahak lebih dari dua minggu, demam malam hari, berkeringat berlebihan, dan penurunan berat badan.</p>'
                    .'<p>Pengobatan TBC memerlukan konsumsi obat secara teratur selama enam bulan sesuai anjuran petugas kesehatan. Periode dua bulan pertama dikenal sebagai fase intensif, dilanjutkan dengan fase lanjutan. Pengobatan tersedia gratis di fasilitas kesehatan pemerintah.</p>'
                    .'<p>Yang sering menjadi kendala adalah kepatuhan pasien yang putus obat karena merasa sudah sembuh lebih awal. Padahal, berhenti minum obat sebelum waktunya dapat menyebabkan kuman menjadi resisten dan penyakit lebih sulit disembuhkan. Dukungan keluarga dan petugas kesehatan sangat penting agar pengobatan tuntas.</p>',
            ],
            [
                'category' => 'Artikel Kesehatan',
                'featured' => false,
                'title' => 'Menerapkan Perilaku Hidup Bersih dan Sehat di Rumah',
                'excerpt' => 'PHBS di rumah menurunkan risiko penyakit menular dan memperbaiki kualitas hidup keluarga.',
                'content' => '<p>Perilaku Hidup Bersih dan Sehat (PHBS) adalah kebiasaan sehari-hari yang dilakukan dengan cara yang bersih dan sehat untuk mencegah penyakit. Penerapannya di rumah mencakup mencuci tangan dengan sabun, menggunakan air bersih, mengolah makanan secara higienis, membuang sampah pada tempatnya, serta menjaga kebersihan kamar mandi dan toilet.</p>'
                    .'<p>Keluarga juga perlu memastikan tersedianya jamban sehat, penggunaan air sumur atau PDAM yang terlindungi, dan penerapan etika batuk serta bersin — menutup mulut dengan siku atau tisu, bukan tangan telanjang.</p>'
                    .'<p>PHBS bukan hanya tanggung jawab satu orang, melainkan kebiasaan bersama seluruh anggota keluarga. Konsistensi sederhana setiap hari terbukti menurunkan beban penyakit menular di lingkungan rumah tangga.</p>',
            ],
            [
                'category' => 'Artikel Kesehatan',
                'featured' => false,
                'title' => 'Menjaga Kesehatan Jantung dengan Pola Hidup Seimbang',
                'excerpt' => 'Penyakit jantung dapat dicegah dengan pola makan sehat, aktivitas fisik teratur, dan pengendalian faktor risiko.',
                'content' => '<p>Penyakit jantung dan pembuluh darah merupakan penyebab kematian terbesar di Indonesia. Faktor risikonya meliputi tekanan darah tinggi, kolesterol tinggi, gula darah tinggi, kelebihan berat badan, merokok, kurang aktivitas fisik, dan stres.</p>'
                    .'<p>Pencegahan dapat dimulai dari kebiasaan harian: mengurangi garam dan gula berlebih, memperbanyak sayur dan buah, memilih sumber lemak sehat, berolahraga minimal 30 menit sehari atau lima kali seminggu, tidak merokok, serta menjaga berat badan ideal.</p>'
                    .'<p>Pemeriksaan tekanan darah dan kolesterol secara berkala di layanan kesehatan membantu deteksi dini. Bila Anda memiliki riwayat keluarga dengan penyakit jantung, konsultasikan langkah pencegahan yang sesuai dengan tenaga kesehatan.</p>',
            ],
            [
                'category' => 'Artikel Kesehatan',
                'featured' => false,
                'title' => 'Manfaat Posyandu bagi Tumbuh Kembang Anak',
                'excerpt' => 'Posyandu memantau pertumbuhan anak, memberi imunisasi, dan menjadi pusat edukasi kesehatan keluarga.',
                'content' => '<p>Posyandu (Pos Pelayanan Terpadu) adalah layanan kesehatan berbasis masyarakat yang dikelola oleh kader kesehatan. Manfaatnya antara lain pemantauan pertumbuhan dan perkembangan anak, pelaksanaan imunisasi, penimbangan balita, konsultasi gizi, serta penyuluhan kesehatan bagi ibu dan keluarga.</p>'
                    .'<p>Ibu disarankan membawa anaknya ke posyandu secara rutin sesuai jadwal, membawa buku KIA, dan tidak ragu bertanya kepada kader tentang pola asuh, ASI, MP-ASI, atau tumbuh kembang anaknya.</p>'
                    .'<p>Keberhasilan program posyandu sangat bergantung pada partisipasi masyarakat. Semakin aktif warga memanfaatkan layanan ini, semakin besar peluang masalah kesehatan ditemukan sejak dini dan ditangani dengan tepat.</p>',
            ],
            [
                'category' => 'Berita',
                'featured' => false,
                'title' => 'Kenali Hipertensi, The Silent Killer',
                'excerpt' => 'Tekanan darah tinggi sering tanpa gejala namun berbahaya bila dibiarkan. Deteksi dini dan pengendalian adalah kuncinya.',
                'content' => '<p>Hipertensi atau tekanan darah tinggi disebut sebagai silent killer karena sering tidak menimbulkan gejala sama sekali meski merusak organ tubuh. Jika tidak dikendalikan, hipertensi dapat menyebabkan stroke, serangan jantung, gagal ginjal, dan kerusakan pembuluh darah.</p>'
                    .'<p>Cara mengetahui tekanan darah adalah dengan mengukurnya secara berkala di fasilitas kesehatan atau menggunakan tensimeter rumahan yang valid. Batas normal tekanan darah dewasa umumnya sekitar 120/80 mmHg, dan angka konsisten di atas 130/80 mmHg perlu mendapat perhatian tenaga kesehatan.</p>'
                    .'<p>Pengendalian hipertensi meliputi pembatasan garam, pola makan bergizi seimbang, aktivitas fisik teratur, pengelolaan stres, kebiasaan tidak merokok, serta kepatuhan minum obat bila sudah dianjurkan. Kontrol rutin ke puskesmas penting untuk memantau perkembangan kondisi.</p>',
            ],
            [
                'category' => 'Berita',
                'featured' => false,
                'title' => 'Lansia Sehat: Menjaga Kualitas Hidup di Usia Senja',
                'excerpt' => 'Pemeriksaan rutin, aktivitas fisik ringan, dan pola makan bergizi membantu lansia tetap sehat dan mandiri.',
                'content' => '<p>Perawatan kesehatan lansia bertujuan agar masa tua dapat dijalani dengan kualitas hidup yang baik dan tetap mandiri. Pemeriksaan kesehatan rutin membantu deteksi dini penyakit tidak menular seperti hipertensi, diabetes, dan gangguan fungsi tubuh.</p>'
                    .'<p>Lansia dianjurkan tetap bergerak aktif dengan aktivitas fisik yang sesuai kemampuan, seperti jalan pagi atau senam lansia, menjaga pola makan bergizi seimbang, memenuhi kebutuhan cairan, dan menjaga interaksi sosial agar kesehatan mental terjaga.</p>'
                    .'<p>Keluarga berperan besar dalam mendampingi lansia — membantu akses ke layanan kesehatan, memastikan kepatuhan minum obat, dan menciptakan lingkungan rumah yang aman agar terhindar dari jatuh dan risiko lainnya.</p>',
            ],
        ];

        $daysAgo = 30;

        foreach ($items as $item) {
            News::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'category' => $item['category'],
                    'thumbnail' => null,
                    'excerpt' => $item['excerpt'],
                    'content' => $item['content'],
                    'user_id' => $author?->id,
                    'is_featured' => $item['featured'],
                    'status' => 'published',
                    'published_at' => now()->subDays($daysAgo),
                ],
            );

            $daysAgo = max(0, $daysAgo - 3);
        }
    }
}
