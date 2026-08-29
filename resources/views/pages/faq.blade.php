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
                    <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                </ol>
            </nav>
            <h1>Pertanyaan Umum</h1>
            <p>Temukan jawaban untuk pertanyaan yang sering diajukan seputar layanan kami.</p>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section class="content-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">FAQ</span>
                <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion reveal" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Apa itu undangan digital?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Undangan digital adalah versi online dari undangan tradisional yang dapat dibagikan melalui tautan via WhatsApp, email, atau media sosial. Lebih praktis, hemat biaya, dan ramah lingkungan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Apakah undangan bisa diedit setelah dipublish?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, Anda bisa mengedit data undangan kapan saja bahkan setelah dipublish. Perubahan akan langsung terlihat oleh tamu yang membuka tautan undangan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Berapa lama undangan aktif?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Undangan akan aktif sesuai durasi paket yang Anda pilih. Setelah masa aktif berakhir, undangan tidak bisa diakses lagi.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Apakah ada batasan jumlah tamu?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Tidak ada batasan jumlah tamu. Anda bisa membagikan tautan undangan ke siapa saja tanpa batas.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Metode pembayaran apa saja yang diterima?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Kami menerima transfer bank, e-wallet (GoPay, OVO, DANA), kartu kredit, dan QRIS.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="content-section alt">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Butuh Bantuan Lebih?</span>
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-desc">Tim support kami siap membantu Anda kapan saja.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.1s;">
                    <div class="contact-card">
                        <div class="contact-icon"><i class="bi bi-whatsapp"></i></div>
                        <h5>WhatsApp</h5>
                        <p><a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya." target="_blank" rel="noopener noreferrer">+62 859-2343-1716</a></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.2s;">
                    <div class="contact-card">
                        <div class="contact-icon"><i class="bi bi-envelope"></i></div>
                        <h5>Email</h5>
                        <p><a href="mailto:official@ruangundang.my.id">official@ruangundang.my.id</a></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.3s;">
                    <div class="contact-card">
                        <div class="contact-icon"><i class="bi bi-whatsapp"></i></div>
                        <h5>Chat WhatsApp</h5>
                        <p><a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya." target="_blank" rel="noopener noreferrer">Klik ikon di pojok kanan bawah</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .accordion-item { border: 1px solid var(--border); border-radius: var(--radius); margin-bottom: 1rem; overflow: hidden; }
        .accordion-button { font-weight: 600; color: var(--navy); padding: 1.25rem 1.5rem; }
        .accordion-button:not(.collapsed) { background: var(--bg-alt); color: var(--navy); box-shadow: none; }
        .accordion-button:focus { box-shadow: none; border-color: var(--border); }
        .accordion-body { color: var(--text-secondary); line-height: 1.7; padding: 0 1.5rem 1.25rem; }
        .contact-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2rem; text-align: center; height: 100%; transition: all 0.3s ease; }
        .contact-card:hover { transform: translateY(-5px); border-color: var(--gold-light); box-shadow: 0 15px 40px rgba(27, 42, 74, 0.08); }
        .contact-icon { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05)); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.5rem; color: var(--gold-dark); }
        .contact-card h5 { color: var(--navy); margin-bottom: 0.5rem; }
        .contact-card p { margin: 0; }
        .contact-card a { color: var(--gold-dark); font-weight: 600; }
    </style>
@endsection
