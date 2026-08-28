@extends('layouts.page')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-shape shape-1"></div>
        <div class="page-header-shape shape-2"></div>
        <div class="container page-header-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Syarat & Ketentuan</li>
                </ol>
            </nav>
            <h1>Syarat & Ketentuan</h1>
            <p>Syarat dan ketentuan penggunaan layanan undangan digital RuangUndang.</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="content-body reveal">
                        <h3>1. Penerimaan Syarat</h3>
                        <p>Dengan mengakses dan menggunakan layanan RuangUndang, Anda menyetujui untuk terikat oleh syarat dan ketentuan ini. Jika Anda tidak setuju, jangan menggunakan layanan kami.</p>

                        <h3>2. Layanan</h3>
                        <p>RuangUndang menyediakan platform untuk membuat dan membagikan undangan digital. Layanan tersedia dalam beberapa paket dengan fitur yang berbeda.</p>

                        <h3>3. Akun Pengguna</h3>
                        <p>Anda bertanggung jawab menjaga kerahasiaan akun dan kata sandi Anda. Aktivitas yang terjadi di bawah akun Anda adalah tanggung jawab Anda.</p>

                        <h3>4. Konten Pengguna</h3>
                        <p>Anda mempertahankan hak atas konten yang Anda unggah. Dengan mengunggah konten, Anda memberikan kami lisensi untuk menampilkan konten tersebut dalam layanan.</p>

                        <h3>5. Pembatalan & Pengembalian</h3>
                        <p>Pembatalan langganan dapat dilakukan kapan saja. Pengembalian dana hanya berlaku dalam 7 hari setelah pembayaran jika layanan belum digunakan.</p>

                        <h3>6. Perubahan Syarat</h3>
                        <p>Kami berhak mengubah syarat dan ketentuan ini kapan saja. Perubahan akan efektif setelah diposting di website.</p>

                        <h3>7. Kontak</h3>
                        <p>Untuk pertanyaan lebih lanjut, hubungi kami di <a href="mailto:official@ruangundang.my.id">official@ruangundang.my.id</a> atau WhatsApp <a href="https://wa.me/6285923431716" target="_blank" rel="noopener noreferrer">+62 859-2343-1716</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .content-body h3 { color: var(--navy); font-size: 1.3rem; margin-top: 2rem; margin-bottom: 0.75rem; }
        .content-body p { color: var(--text-secondary); line-height: 1.8; margin-bottom: 1rem; }
        .content-body a { color: var(--gold-dark); font-weight: 600; }
    </style>
@endsection
