@extends('layouts.page')

@section('content')
    <!-- Page Header -->
    {{-- <section class="ev-page-hero">
        <div class="ev-page-hero-shape shape-1"></div>
        <div class="ev-page-hero-shape shape-2"></div>
        <div class="container ev-page-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                </ol>
            </nav>
            <h1>Pertanyaan Umum</h1>
            <p>Temukan jawaban untuk pertanyaan yang sering diajukan seputi layanan kami.</p>
        </div>
    </section> --}}

    <!-- FAQ Accordion Section -->
    <section class="ev-section-light">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="ev-section-subtitle">FAQ</span>
                <h2 class="ev-section-title">Pertanyaan yang Sering Diajukan</h2>
            </div>

            <div class="ev-faq-container">
                <div class="ev-faq-item reveal reveal-d1">
                    <button class="ev-faq-question" type="button">
                        <span>Apa itu undangan digital?</span>
                        <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                    </button>
                    <div class="ev-faq-answer">
                        <p>
                            Undangan digital adalah versi online dari undangan tradisional yang dapat dibagikan
                            melalui tautan via WhatsApp, email, atau media sosial. Lebih praktis, hemat biaya, dan
                            ramah lingkungan.
                        </p>
                    </div>
                </div>

                <div class="ev-faq-item reveal reveal-d2">
                    <button class="ev-faq-question" type="button">
                        <span>Apakah undangan bisa diedit setelah dipublish?</span>
                        <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                    </button>
                    <div class="ev-faq-answer">
                        <p>
                            Ya, Anda bisa mengedit data undangan kapan saja bahkan setelah dipublish. Perubahan akan
                            langsung terlihat oleh tamu yang membuka tautan undangan.
                        </p>
                    </div>
                </div>

                <div class="ev-faq-item reveal reveal-d3">
                    <button class="ev-faq-question" type="button">
                        <span>Berapa lama undangan aktif?</span>
                        <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                    </button>
                    <div class="ev-faq-answer">
                        <p>
                            Undangan akan aktif sesuai durasi paket yang Anda pilih. Setelah masa aktif berakhir,
                            undangan tidak bisa diakses lagi.
                        </p>
                    </div>
                </div>

                <div class="ev-faq-item reveal reveal-d4">
                    <button class="ev-faq-question" type="button">
                        <span>Apakah ada batasan jumlah tamu?</span>
                        <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                    </button>
                    <div class="ev-faq-answer">
                        <p>
                            Tidak ada batasan jumlah tamu. Anda bisa membagikan tautan undangan ke siapa saja tanpa batas.
                        </p>
                    </div>
                </div>

                <div class="ev-faq-item reveal">
                    <button class="ev-faq-question" type="button">
                        <span>Metode pembayaran apa saja yang diterima?</span>
                        <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                    </button>
                    <div class="ev-faq-answer">
                        <p>
                            Kami menerima transfer bank, e-wallet (GoPay, OVO, DANA), kartu kredit, dan QRIS.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="ev-section-alt">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="ev-section-subtitle">Butuh Bantuan Lebih?</span>
                <h2 class="ev-section-title">Hubungi Kami</h2>
                <p class="ev-section-desc">Tim support kami siap membantu Anda kapan saja.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 reveal reveal-d1">
                    <div class="ev-help-card">
                        <div class="ev-help-icon"><i class="bi bi-whatsapp"></i></div>
                        <h4>WhatsApp</h4>
                        <p>Chat langsung dengan tim support kami.</p>
                        <a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya."
                            target="_blank" rel="noopener noreferrer" class="ev-host-card-link">
                            +62 859-2343-1716
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d2">
                    <div class="ev-help-card">
                        <div class="ev-help-icon"><i class="bi bi-envelope"></i></div>
                        <h4>Email</h4>
                        <p>Kirim pertanyaan detail dan kami akan merespons cepat.</p>
                        <a href="mailto:official@ruangundang.my.id" class="ev-host-card-link">
                            official@ruangundang.my.id
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d3">
                    <div class="ev-help-card">
                        <div class="ev-help-icon"><i class="bi bi-whatsapp"></i></div>
                        <h4>Chat WhatsApp</h4>
                        <p>Klik ikon WhatsApp di pojok kanan bawah untuk memulai percakapan.</p>
                        <a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya."
                            target="_blank" rel="noopener noreferrer" class="ev-host-card-link">
                            Mulai Chat <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faqItems = document.querySelectorAll('.ev-faq-item');
            faqItems.forEach(item => {
                const questionBtn = item.querySelector('.ev-faq-question');
                if (questionBtn) {
                    questionBtn.addEventListener('click', () => {
                        const isOpen = item.classList.contains('is-open');
                        faqItems.forEach(i => i.classList.remove('is-open'));
                        if (!isOpen) {
                            item.classList.add('is-open');
                        }
                    });
                }
            });
        });
    </script>
@endpush