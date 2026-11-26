{{-- Modal: Share Invitation (samakan dengan rute /home) --}}
<div class="modal fade" id="shareModalDynamic" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">

            {{-- HEADER --}}
            <div class="modal-header px-4 py-3" style="background: linear-gradient(135deg, #1B2A4A 0%, #2A3F6A 100%); border-bottom: 2px solid #C6A962; color: #fff;">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" id="toggleBukuTamu" title="Buka/Tutup Buku Tamu">
                        <i class="bi bi-people me-1"></i> Buku Tamu
                    </button>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-share text-gold"></i>
                            <span>Bagikan Undangan Digital</span>
                        </h5>
                        <small class="text-white-50" style="font-size: 0.78rem;">Pilih tamu atau kirim pesan undangan instan ke kerabat</small>
                    </div>
                </div>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body p-0">
                <div class="d-flex position-relative" style="min-height: 440px;">

                    {{-- SIDEBAR: BUKU TAMU --}}
                    <div class="bg-light border-end position-absolute h-100 shadow-sm" id="bukuTamuSidebar"
                        style="width: 320px; left: -340px; transition: left 0.3s ease; z-index: 10; overflow-y: auto;">
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-people-fill text-gold"></i> Kontak Tersimpan
                                    <span class="badge bg-success rounded-pill" id="guestCountBadge">0</span>
                                </h6>
                                <button type="button" class="btn btn-sm btn-light border rounded-circle" id="closeBukuTamu" style="width: 28px; height: 28px; padding: 0;">
                                    <i class="bi bi-x-lg small"></i>
                                </button>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllGuests">
                                    <label class="form-check-label small fw-semibold" for="selectAllGuests">Pilih Semua</label>
                                </div>
                                <a href="{{ route('invitation.import-kontak') }}" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-0.5" title="Import Kontak">
                                    <i class="bi bi-plus-lg me-1"></i>Tambah
                                </a>
                            </div>

                            {{-- LIST TAMU --}}
                            <div class="list-group rounded-3 shadow-none border" id="savedGuestsList" style="max-height: 320px; overflow-y: auto;"></div>
                            <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">Centang kontak, lalu kirim ke semua tamu terpilih sekaligus.</small>
                            <button type="button" class="btn btn-success w-100 mt-2 rounded-3" id="bulkSendBtn" style="display: none;">
                                <i class="bi bi-whatsapp me-1"></i> Kirim ke <span id="bulkSendCount">0</span> Tamu Terpilih
                            </button>
                        </div>
                    </div>

                    {{-- KONTEN UTAMA --}}
                    <div class="flex-grow-1 p-4" id="mainContent">
                        {{-- NAMA PENERIMA --}}
                        <div class="mb-4">
                            <label for="recipientNameDynamic" class="form-label fw-bold small text-uppercase" style="letter-spacing: 0.5px;">
                                Nama Penerima / Keluarga <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" id="recipientNameDynamic" placeholder="Masukkan nama tamu (misal: Bpk. Bambang & Keluarga)" required>
                                <button type="button" class="btn btn-outline-secondary" id="pickContactBtn" title="Pilih dari kontak HP">
                                    <i class="bi bi-person-lines-fill me-1"></i> Kontak HP
                                </button>
                            </div>
                            <div id="contactUnsupported" class="form-text text-muted small mt-1" style="display: none;">
                                <i class="bi bi-info-circle me-1"></i>Fitur buku kontak didukung pada perangkat Android Chrome.
                            </div>
                        </div>

                        {{-- PESAN UNDANGAN --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="shareMessageDynamic" class="form-label fw-bold small text-uppercase mb-0" style="letter-spacing: 0.5px;">
                                    Teks Pesan Undangan
                                </label>
                                <small class="text-muted">Kode <code class="text-gold">[nama]</code> otomatis disesuaikan</small>
                            </div>
                            <textarea class="form-control rounded-3" id="shareMessageDynamic" placeholder="Pesan undangan..." rows="7" style="font-size: 0.9rem; line-height: 1.5;"></textarea>
                        </div>

                        {{-- TOMBOL SHARE --}}
                        <div>
                            <label class="form-label fw-bold small text-uppercase mb-2" style="letter-spacing: 0.5px;">Kirim Lewat Platform:</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="share-channel-btn btn btn-success" onclick="shareToWhatsApp()">
                                    <i class="bi bi-whatsapp fs-6"></i> WhatsApp
                                </button>
                                <button type="button" class="share-channel-btn btn btn-primary" onclick="shareToFacebook()">
                                    <i class="bi bi-facebook fs-6"></i> Facebook
                                </button>
                                <button type="button" class="share-channel-btn btn btn-dark" onclick="shareToTwitter()">
                                    <i class="bi bi-twitter-x fs-6"></i> Twitter (X)
                                </button>
                                <button type="button" class="share-channel-btn btn btn-info text-white" onclick="shareToTelegram()">
                                    <i class="bi bi-telegram fs-6"></i> Telegram
                                </button>
                                <button type="button" class="share-channel-btn btn btn-secondary" onclick="shareViaEmail()">
                                    <i class="bi bi-envelope fs-6"></i> Email
                                </button>
                                <button type="button" class="share-channel-btn btn btn-outline-dark" onclick="copyInvitationLink()">
                                    <i class="bi bi-link-45deg fs-6"></i> Salin Tautan
                                </button>
                            </div>
                        </div>

                    </div>{{-- /main-content --}}

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer px-4 py-3 d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    <i class="bi bi-shield-check text-success me-1"></i> Data kontak diproses aman di peramban Anda.
                </div>
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>