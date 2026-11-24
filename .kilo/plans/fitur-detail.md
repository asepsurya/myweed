# Rencana — Detail Penjelasan Halaman /fitur

## Tujuan
Memperkaya 12 kartu fitur di halaman `/fitur` agar setiap fitur punya penjelasan 2–3 kalimat
ditambah 3–4 poin konkret. Tanpa perubahan rute, controller, database, atau struktur grid.

## File yang diubah
| File | Bagian | Perubahan |
|---|---|---|
| `resources/views/pages/fitur.blade.php` | baris 28–113 (grid `.row.g-4`) | Rewrite isi 12 kartu `.ev-feature-card` |
| `public/assets/css/page.css` | setelah `.ev-feature-card p` (~baris 403) | Style baru `.ev-feature-list` |

Tidak ada file lain. Tidak perlu migrasi, seeder, composer/npm, atau JS baru.

## Pola markup per kartu
```blade
<div class="col-lg-4 col-md-6 reveal reveal-d1">
    <div class="ev-feature-card">
        <div class="ev-feature-icon"><i class="bi bi-phone"></i></div>
        <h4>Desain Mobile First</h4>
        <p>Penjelasan 2–3 kalimat…</p>
        <ul class="ev-feature-list">
            <li><i class="bi bi-check2"></i> Poin singkat</li>
            <li><i class="bi bi-check2"></i> Poin singkat</li>
            <li><i class="bi bi-check2"></i> Poin singkat</li>
        </ul>
    </div>
</div>
```
- Pertahankan kelas `col-lg-4 col-md-6 reveal reveal-d*` yang ada (animasi & grid tidak berubah).
- Kartu boleh memiliki tinggi berbeda; `height: 100%` pada `.ev-feature-card` sudah menjaga kerapian.

## Konten 12 kartu (paragraf + poin)

1. **Desain Mobile First** — `bi-phone`
   - P: Undangan tampil rapi di semua ukuran layar, dari ponsel 360px hingga desktop, dengan tipografi elegan dan animasi halus. Tamu tidak perlu memasang aplikasi apa pun.
   - Poin: Responsif di semua perangkat · Ringan & cepat dibuka · Tanpa instal aplikasi · Animasi transisi halus

2. **Background Musik** — `bi-music-note-beamed`
   - P: Tambahkan lagu favorit sebagai musik latar dengan tiga sumber pilihan: Library musik bawaan, YouTube, atau unggah berkas sendiri. Tersedia cover lagu dan tombol putar/jeda di halaman undangan.
   - Poin: Library musik bawaan · Pilih dari YouTube · Unggah MP3 sendiri · Kontrol putar/jeda

3. **Google Maps Integrasi** — `bi-map`
   - P: Tautkan lokasi akad dan resepsi secara terpisah ke Google Maps. Tamu cukup satu klik untuk membuka rute perjalanan, lengkap dengan nama lokasi dan jam pelaksanaan.
   - Poin: Lokasi akad & resepsi terpisah · Tombol petunjuk arah · Jam pelaksanaan · Bisa diubah kapan saja

4. **Kirim Amplop Digital** — `bi-gift`
   - P: Tamu dapat mengirim tanda kasih secara digital melalui rekening bank, dompet digital, atau pemindaian QR. Daftar rekening tampil rapi di halaman undangan dan bisa Anda kelola sendiri.
   - Poin: Transfer bank · E-wallet · Scan QR · Daftar rekening bisa diatur

5. **RSVP & Hitung Tamu** — `bi-people`
   - P: Tamu mengonfirmasi kehadiran langsung dari undangan. Anda dapat menetapkan batas tanggal RSVP, melihat jumlah tamu yang hadir beserta pendamping, dan menerima notifikasi WhatsApp setiap ada konfirmasi baru.
   - Poin: Konfirmasi hadir + pendamping · Batas tanggal RSVP · Notifikasi WhatsApp · Rekap dari dashboard

6. **Galeri Foto & Video** — `bi-camera-reels`
   - P: Bagikan dokumentasi pra-pernikahan dalam galeri foto dengan cover khusus, serta sematkan video agar tamu bisa menonton langsung dari halaman undangan.
   - Poin: Galeri foto + cover · Video embed · Tampilan lightbox · Urutan foto bisa diatur

7. **Kamera Tamu & Galeri Foto** — `bi-camera-fill`
   - P: Tamu memindai QR untuk berfoto langsung dari browser dengan bingkai pilihan (Polaroid, Rustic, Minimal, atau tanpa bingkai). Foto otomatis masuk galeri undangan dan dilengkapi lightbox, pencarian nama, serta kuota 5 foto per perangkat.
   - Poin: Akses via QR tanpa aplikasi · 4 pilihan bingkai · Kuota 5 foto per perangkat · Tersimpan otomatis ke galeri

8. **Hitungan Mundur** — `bi-clock-history`
   - P: Hitung mundur berjalan otomatis menuju tanggal akad dan tampil di halaman sampul, sehingga tamu langsung tahu sisa waktu menuju hari bahagia.
   - Poin: Real-time hari/jam/menit/detik · Mengikuti tanggal acara · Tampil di sampul · Responsif

9. **Berbagi Momen Indah dan Ucapan** — `bi-chat-heart`
   - P: Tamu dapat menuliskan doa dan ucapan, sekaligus mengirim foto. Ucapan tampil di buku tamu digital dan bisa Anda pantau dari dashboard.
   - Poin: Ucapan & doa langsung tampil · Lampiran foto · Jumlah ucapan · Dikelola dari dashboard

10. **Love Stories** — `bi-heart`
    - P: Ceritakan perjalanan cinta Anda sebagai timeline — momen pertemuan, lamaran, hingga hari bahagia — dengan foto dan tanggal di setiap babak.
    - Poin: Timeline kisah cinta · Foto tiap momen · Judul & tanggal · Bisa diaktifkan/dinonaktifkan

11. **Live Streaming** — `bi-camera-video`
    - P: Sematkan tautan siaran langsung (YouTube) agar keluarga dan teman yang berhalangan hadir tetap dapat menyaksikan akad dan resepsi dari mana saja.
    - Poin: Tautan siaran langsung · Tayang di undangan · Bisa dibuka dari ponsel · Tanpa aplikasi tambahan

12. **Live Update** — `bi-arrow-repeat`
    - P: Setiap perubahan pada undangan langsung terlihat di editor tanpa perlu memuat ulang halaman, sehingga Anda dapat menyusun konten lebih cepat dan melihat hasilnya seketika.
    - Poin: Pratinjau langsung · Tanpa refresh · Hasil langsung terlihat · Cocok untuk penyuntingan cepat

Catatan copy:
- Seragamkan sapaan ke "Anda" (beberapa kartu lama memakai "kamu").
- Kartu 6 dan 7 dibedakan: kartu 6 = galeri & video dari pemilik, kartu 7 = unggahan tamu via QR.

## CSS yang ditambahkan
```css
/* ===== Feature Card Detail List ===== */
.ev-feature-list {
    list-style: none;
    margin: 1.25rem 0 0;
    padding: 1rem 0 0;
    border-top: 1px dashed var(--ev-border);
    text-align: left;
}

.ev-feature-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    font-size: 0.86rem;
    line-height: 1.55;
    color: var(--ev-text-secondary);
}

.ev-feature-list li:last-child {
    margin-bottom: 0;
}

.ev-feature-list i {
    flex-shrink: 0;
    margin-top: 0.15rem;
    font-size: 0.8rem;
    color: var(--ev-green);
}
```

## Verifikasi
1. `php artisan serve`, buka `http://localhost:8000/fitur`.
2. Cek lebar 1440px (3 kolom), 768px (2 kolom), 390px (1 kolom): kartu sejajar, daftar tidak overflow.
3. `php artisan view:clear` bila Blade terasa tidak ter-update.
4. Aset CSS otomatis cache-bust via `filemtime()` di `layouts/page.blade.php:31`.
5. Tidak ada test otomatis untuk view statis; validasi manual + `php artisan test` opsional sebagai regresi umum.

## Risiko & catatan akurasi
- **Live Streaming**: tidak ada kolom/implementasi khusus; fitur paket `streaming_video` memakai `video_link`. Copy ditulis netral ("tautan siaran langsung") tanpa klaim teknis.
- **Live Update**: rute `invitation.live-preview` (`TempelateController@liveUpdate`) adalah pratinjau editor, jadi copy diarahkan ke pratinjau editor — bukan pembaruan real-time untuk tamu.
- **Amplop digital**: model `Gift` menyimpan `bank`, `number`, `name`, `qr`; tidak ada bukti QRIS dinamis. Gunakan "scan QR", bukan klaim "QRIS".
- Halaman ini statis (tanpa query DB), sehingga tidak ada dampak performa atau N+1.