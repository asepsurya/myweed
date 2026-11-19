<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Seed 5 artikel blog bertema pernikahan.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => '7 Tips Persiapan Pernikahan agar Hari H Berjalan Lancar',
                'type' => 'panduan',
                'excerpt' => 'Persiapan pernikahan memang melelahkan, tapi dengan panduan yang tepat semuanya bisa terasa lebih ringan. Simak tujuh tips andalan dari para wedding planner.',
                'content' => <<<'HTML'
<p>Pernikahan adalah momen sekali seumur hidup, jadi wajar kalau persiapannya terasa menegangkan. Kabar baiknya, dengan rencana yang matang, hari H bisa berjalan jauh lebih tenang dan menyenangkan.</p>

<h2>1. Tentukan tanggal dan anggaran sejak awal</h2>
<p>Kunci utama persiapan pernikahan adalah menentukan tanggal besar dan anggaran sejak dini. Keduanya menjadi acuan untuk semua keputusan berikutnya, mulai dari pemilihan venue sampai jumlah tamu.</p>

<h2>2. Susun daftar tamu secara realistis</h2>
<p>Banyak pasangan mengalami kelebihan anggaran karena daftar tamu membengkak. Tetapkan batas wajar dan komunikasikan dengan keluarga sejak awal agar tidak ada revisi mendadak.</p>

<blockquote>Menentukan daftar tamu lebih awal membantu mengunci harga katering dan jumlah kursi di venue.</blockquote>

<h2>3. Pesan vendor jauh hari</h2>
<p>Wedding organizer, fotografer, dan katering favorit biasanya penuh pada musim kawin. Lakukan survei minimal enam bulan sebelum hari H, lalu kunci dengan kontrak resmi.</p>

<h2>4. Siapkan dana cadangan</h2>
<p>Sisihkan sekitar 10 sampai 15 persen dari total anggaran sebagai dana darurat. Selalu ada pengeluaran tak terduga, entah itu tambahan dekorasi atau perubahan jumlah tamu.</p>

<h2>5. Manfaatkan bantuan keluarga dan sahabat</h2>
<p>Tidak semua hal harus dikerjakan sendiri. Delegasikan tugas seperti pengurusan kue, transportasi, atau pendampingan tamu kepada orang terdekat yang tepercaya.</p>

<ul>
    <li>Tentukan satu orang sebagai koordinator di hari H.</li>
    <li>Buat grup komunikasi khusus untuk keluarga inti.</li>
    <li>Bagikan jadwal lengkap ke semua pihak minimal seminggu sebelumnya.</li>
</ul>

<h2>6. Lakukan gladi bersih</h2>
<p>Gladi bersih membantu semua orang tahu posisi dan urutan acara. Jangan lewatkan sesi ini, terutama jika ada prosesi adat dengan tata cara khusus.</p>

<h2>7. Nikmati prosesnya</h2>
<p>Persiapan yang panjang bisa membuat lelah. Sempatkan waktu untuk quality time bersama pasangan agar kalian tetap menikmati perjalanan menuju hari bahagia.</p>
HTML,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Tren Dekorasi Pernikahan 2026 yang Estetik dan Instagramable',
                'type' => 'inspirasi',
                'excerpt' => 'Dari nuansa earthy tone sampai instalasi bunga gantung, ini deretan tren dekorasi pernikahan 2026 yang siap bikin pestamu terlihat mahal di feed.',
                'content' => <<<'HTML'
<p>Dekorasi pernikahan terus berkembang setiap tahun. Tahun 2026, trennya bergerak ke arah yang lebih natural, hangat, dan personal. Berikut beberapa gaya yang paling banyak dicari calon pengantin.</p>

<h2>Nuansa earthy tone dan material alami</h2>
<p>Warna tanah seperti terracotta, sage green, dan krem kembali mendominasi. Material kayu, rotan, dan linen dipadukan agar suasana terasa hangat dan tidak kaku.</p>

<h2>Instalasi bunga gantung</h2>
<p>Bunga yang digantung di atas meja atau area akad menciptakan kesan megah tanpa memenuhi ruangan. Pilihan ini juga ramah untuk venue dengan ceiling tinggi.</p>

<blockquote>Kombinasi bunga segar lokal dengan dedaunan kering memberi tekstur yang unik dan tetap fotogenik.</blockquote>

<h2>Pencahayaan hangat</h2>
<p>Lampu string, lilin, dan uplighting dengan warna warm white jauh lebih disukai dibanding lampu putih terang. Hasilnya, foto pun terlihat lebih hangat dan romantis.</p>

<h2>Personal touch lewat galeri foto</h2>
<p>Tampilkan perjalanan cinta kalian lewat susunan foto hitam putih atau timeline sederhana di area sambutan tamu. Sentuhan personal seperti ini paling sering jadi sorotan tamu.</p>

<h2>Less is more</h2>
<p>Dekorasi berlebihan justru membuat ruangan terasa penuh dan pengunjung kurang nyaman. Pilih satu titik fokus utama, lalu biarkan sisanya bernapas.</p>
HTML,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Cara Menyusun Anggaran Pernikahan Biar Nggak Boncos',
                'type' => 'panduan',
                'excerpt' => 'Anggaran pernikahan sering membengkak tanpa disadari. Pelajari cara membagi pos pengeluaran dengan proporsi yang sehat dan realistis.',
                'content' => <<<'HTML'
<p>Salah satu penyebab utama stres menjelang pernikahan adalah pengeluaran yang tidak terkendali. Menyusun anggaran dengan proporsi yang tepat membantu kalian tetap tenang dan fokus.</p>

<h2>Mulai dari total kemampuan, bukan keinginan</h2>
<p>Hitung dana yang benar-benar tersedia, termasuk tabungan dan kontribusi keluarga. Angka inilah yang menjadi pagu mutlak, bukan daftar keinginan.</p>

<h2>Bagi anggaran ke dalam pos-pos berikut</h2>
<ul>
    <li><strong>Venue dan katering:</strong> 40 sampai 50 persen, biasanya pos terbesar.</li>
    <li><strong>Dokumentasi:</strong> 10 sampai 15 persen untuk foto dan video.</li>
    <li><strong>Dekorasi:</strong> 10 sampai 15 persen.</li>
    <li><strong>Busana dan rias pengantin:</strong> 10 persen.</li>
    <li><strong>Undangan dan souvenir:</strong> 5 persen.</li>
    <li><strong>Dana cadangan:</strong> 10 persen.</li>
</ul>

<blockquote>Pos dokumentasi sebaiknya tidak dipangkas terlalu jauh, karena inilah satu-satunya bukti yang tersisa setelah acara selesai.</blockquote>

<h2>Catat setiap pengeluaran</h2>
<p>Buat satu dokumen sederhana berisi rencana anggaran dan realisasi. Dengan begitu kalian langsung tahu pos mana yang mulai membengkak.</p>

<h2>Hindari keputusan impulsif</h2>
<p>Diskon dan promo sering membuat pasangan membeli hal yang tidak diperlukan. Beri jeda sehari sebelum menambah item baru ke daftar.</p>

<h2>Evaluasi rutin</h2>
<p>Lakukan evaluasi anggaran setiap dua minggu. Jika satu pos sudah melebihi pagu, kompensasi dari pos lain yang masih longgar.</p>
HTML,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Inspirasi Palet Warna Pernikahan Elegan untuk Musim Kemarau',
                'type' => 'inspirasi',
                'excerpt' => 'Pernikahan di musim kemarau punya pesona tersendiri. Coba lima palet warna ini yang terlihat elegan dan menyegarkan di bawah matahari.',
                'content' => <<<'HTML'
<p>Musim kemarau adalah waktu favorit untuk menggelar pernikahan outdoor. Agar tampilan tetap elegan dan tidak terkesan panas, pemilihan warna perlu diperhatikan.</p>

<h2>1. Sage green dan ivory</h2>
<p>Kombinasi hijau lembut dan putih gading memberi kesan segar sekaligus kalem. Palet ini cocok untuk tema garden wedding maupun semi outdoor.</p>

<h2>2. Terracotta dan dusty pink</h2>
<p>Warna bumi yang hangat dipadukan dengan pink lembut menghasilkan nuansa romantis namun tetap dewasa. Cocok untuk dekorasi berbahan kayu dan rotan.</p>

<h2>3. Soft blue dan silver</h2>
<p>Palet biru muda dengan aksen perak memberi kesan sejuk dan modern. Pilihan ini sering dipakai untuk pernikahan dengan tema pantai.</p>

<blockquote>Untuk tema outdoor, pilih bahan kain yang tidak mudah kusut agar dekorasi tetap rapi sepanjang acara.</blockquote>

<h2>4. Butter yellow dan warm white</h2>
<p>Kuning lembut yang sedang naik daun memberi kesan ceria tanpa terlihat mencolok. Padukan dengan bunga putih untuk menyeimbangkan.</p>

<h2>5. Mocca dan cream</h2>
<p>Nuansa cokelat susu dan krem terlihat mewah namun tetap hangat. Palet ini sangat cocok untuk resepsi malam dengan pencahayaan hangat.</p>

<h2>Tips penerapan</h2>
<ul>
    <li>Gunakan satu warna dominan dan satu warna aksen saja.</li>
    <li>Teruskan palet ke undangan, busana, dan dekorasi agar terlihat menyatu.</li>
    <li>Hindari lebih dari tiga warna utama agar tidak terkesan ramai.</li>
</ul>
HTML,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Checklist Persiapan Pernikahan 6 Bulan Sebelum Hari H',
                'type' => 'panduan',
                'excerpt' => 'Rasa bingung harus mengerjakan apa lebih dulu? Pakai checklist enam bulan ini sebagai peta jalan persiapan pernikahanmu.',
                'content' => <<<'HTML'
<p>Banyak pasangan kewalahan karena tidak tahu harus memulai dari mana. Checklist berurutan seperti ini membuat persiapan terasa jauh lebih terkelola.</p>

<h2>Enam bulan sebelum hari H</h2>
<ul>
    <li>Tentukan tanggal dan anggaran utama.</li>
    <li>Susun daftar tamu sementara.</li>
    <li>Pesan venue dan wedding organizer.</li>
    <li>Mulai survei katering dan dokumentasi.</li>
</ul>

<h2>Empat bulan sebelum hari H</h2>
<ul>
    <li>Kunci vendor dekorasi dan kue pengantin.</li>
    <li>Pilih tema serta palet warna.</li>
    <li>Pesan busana pengantin dan keluarga inti.</li>
    <li>Siapkan desain undangan digital.</li>
</ul>

<blockquote>Jangan menunda pemesanan venue jika tanggal sudah pasti, karena inilah vendor yang paling cepat penuh.</blockquote>

<h2>Dua bulan sebelum hari H</h2>
<ul>
    <li>Kirim undangan ke seluruh tamu.</li>
    <li>Konfirmasi jumlah tamu untuk katering.</li>
    <li>Finalisasi susunan acara dan urutan prosesi.</li>
    <li>Lakukan fitting busana terakhir.</li>
</ul>

<h2>Satu bulan sebelum hari H</h2>
<ul>
    <li>Gladi bersih bersama keluarga dan vendor.</li>
    <li>Siapkan kado dan seserahan.</li>
    <li>Pastikan semua pembayaran vendor sesuai jadwal.</li>
    <li>Siapkan kebutuhan dupa, kursi, dan perlengkapan prosesi.</li>
</ul>

<h2>Satu minggu sebelum hari H</h2>
<ul>
    <li>Konfirmasi ulang ke seluruh vendor.</li>
    <li>Siapkan kebutuhan pengantin dan keluarga.</li>
    <li>Istirahat cukup dan jaga kesehatan.</li>
    <li>Siapkan dana cadangan untuk kebutuhan mendadak.</li>
</ul>

<h2>Hari H</h2>
<p>Serahkan koordinasi teknis kepada satu orang tepercaya, lalu nikmati momen bersama pasangan dan keluarga. Semua persiapan sudah selesai, waktunya bahagia.</p>
HTML,
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['slug' => Str::slug($blog['title'])],
                $blog
            );
        }
    }
}