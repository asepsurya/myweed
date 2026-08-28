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
                    <li class="breadcrumb-item active" aria-current="page">Kebijakan Privasi</li>
                </ol>
            </nav>
            <h1>Kebijakan Privasi</h1>
            <p>Kebijakan privasi dan perlindungan data pengguna layanan RuangUndang.</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="content-body reveal">
                        <h3>1. Informasi yang Kami Kumpulkan</h3>
                        <p>Kami mengumpulkan informasi yang Anda berikan saat mendaftar dan menggunakan layanan kami, termasuk nama, email, nomor telepon, dan data undangan yang Anda buat.</p>

                        <h3>2. Penggunaan Informasi</h3>
                        <p>Informasi yang kami kumpulkan digunakan untuk menyediakan dan meningkatkan layanan, memproses transaksi, mengirimkan notifikasi, dan memberikan dukungan pelanggan.</p>

                        <h3>3. Keamanan Data</h3>
                        <p>Kami menerapkan langkah-langkah keamanan yang tepat untuk melindungi informasi pribadi Anda dari akses, pengubahan, atau penghapusan yang tidak sah.</p>

                        <h3>4. Berbagi Informasi</h3>
                        <p>Kami tidak menjual, memperdagangkan, atau memindahkan informasi pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, kecuali diwajibkan oleh hukum.</p>

                        <h3>5. Hak Pengguna</h3>
                        <p>Anda berhak mengakses, mengoreksi, atau menghapus data pribadi Anda kapan saja melalui pengaturan akun atau dengan menghubungi kami.</p>

                        <h3>6. Kontak</h3>
                        <p>Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi kami di <a href="mailto:official@ruangundang.my.id">official@ruangundang.my.id</a> atau WhatsApp <a href="https://wa.me/6285923431716" target="_blank" rel="noopener noreferrer">+62 859-2343-1716</a>.</p>
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
