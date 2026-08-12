<x-app-layout>
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('dashboard.user') }}"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dokumentasi</li>
    @endsection

    <style>
        .doc-card {
            background: #ffffff;
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            transition: all 0.3s ease;
            height: 100%;
        }
        [data-bs-theme=dark] .doc-card {
            background: none;
        }
        .doc-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(27, 42, 74, 0.08);
            border-color: rgba(198, 169, 98, 0.4);
        }
        [data-bs-theme="dark"] .doc-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            border-color: var(--adminuiux-theme-1);
        }
        .doc-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .doc-step {
            background: #ffffff;
            border: 1px solid var(--bs-border-color);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            transition: all 0.2s ease;
        }
        [data-bs-theme=dark] .doc-step {
            background: none;
        }
        .doc-step:hover {
            box-shadow: 0 4px 15px rgba(27, 42, 74, 0.05);
        }
        .doc-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            flex-shrink: 0;
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Dokumentasi Penggunaan</h4>
            <p class="text-muted mb-0">Panduan lengkap penggunaan setiap fitur dan menu dalam sistem</p>
        </div>
    </div>

    <!-- User Menu Documentation -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-transparent border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Menu Pengguna (User Menu)</h5>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">User</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Pasangan Saya -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-danger-subtle text-danger">
                                    <i class="bi bi-heart"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Pasangan Saya</h6>
                                    <small class="text-muted">Data Pasangan</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Kelola data informasi pasangan pengantin, foto, dan detail pernikahan.</p>
                            <div class="doc-step mb-2">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Buat Data Pasangan</span>
                                </div>
                                <p class="small text-muted mb-0">Klik "Buat Undangan" dan isi nama, tanggal, lokasi akad dan resepsi.</p>
                            </div>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">2</div>
                                    <span class="small fw-medium">Kelola & Edit</span>
                                </div>
                                <p class="small text-muted mb-0">Edit data pasangan, upload foto, dan atur tema warna undangan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rencana Pernikahan -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-info-subtle text-info">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Rencana Pernikahan</h6>
                                    <small class="text-muted">Weeding Plan</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Buat dan kelola daftar tugas persiapan pernikahan dengan timeline yang terstruktur.</p>
                            <div class="doc-step mb-2">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-info text-white">1</div>
                                    <span class="small fw-medium">Tambah Tugas</span>
                                </div>
                                <p class="small text-muted mb-0">Buat tugas baru dengan nama, deskripsi, kategori, due date, dan prioritas.</p>
                            </div>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-info text-white">2</div>
                                    <span class="small fw-medium">Update Status</span>
                                </div>
                                <p class="small text-muted mb-0">Ubah status tugas menjadi Pending, In Progress, atau Completed.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Anggaran -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-success-subtle text-success">
                                    <i class="bi bi-calculator"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Anggaran</h6>
                                    <small class="text-muted">Budget</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Kelola anggaran pernikahan, kategori pengeluaran, dan tracking budget.</p>
                            <div class="doc-step mb-2">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-success text-white">1</div>
                                    <span class="small fw-medium">Set Total Anggaran</span>
                                </div>
                                <p class="small text-muted mb-0">Tentukan jumlah total anggaran pernikahan di dashboard.</p>
                            </div>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-success text-white">2</div>
                                    <span class="small fw-medium">Buat Kategori</span>
                                </div>
                                <p class="small text-muted mb-0">Buat kategori pengeluaran (Venue, Catering, Dokumentasi, dll) dengan alokasi budget.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabungan -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-warning-subtle text-warning">
                                    <i class="bi bi-piggy-bank"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Tabungan</h6>
                                    <small class="text-muted">Savings</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Buat target tabungan, catat kontribusi, dan pantau progres saving bersama pasangan.</p>
                            <div class="doc-step mb-2">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-warning text-dark">1</div>
                                    <span class="small fw-medium">Buat Target Tabungan</span>
                                </div>
                                <p class="small text-muted mb-0">Definisikan nama target, jumlah target, deadline, dan warna.</p>
                            </div>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-warning text-dark">2</div>
                                    <span class="small fw-medium">Catat Setoran</span>
                                </div>
                                <p class="small text-muted mb-0">Input pemasukan/ kontribusi ke dalam ledger setoran untuk setiap goal.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ikhtisar Keuangan -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-bar-chart-line"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Ikhtisar Keuangan</h6>
                                    <small class="text-muted">Financial Overview</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Lihat ringkasan gabungan anggaran, pengeluaran, tabungan, dan pembayaran vendor.</p>
                            <div class="doc-step mb-2">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Review Ringkasan</span>
                                </div>
                                <p class="small text-muted mb-0">Lihat total anggaran vs total terpakai vs total tabungan dalam satu tampilan.</p>
                            </div>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">2</div>
                                    <span class="small fw-medium">Monitor Status</span>
                                </div>
                                <p class="small text-muted mb-0">Pantau status pembayaran vendor dan progres tabungan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ucapan & Doa -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-secondary-subtle text-secondary">
                                    <i class="bi bi-clipboard-check"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Ucapan & Doa</h6>
                                    <small class="text-muted">RSVP & Wishes</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Kelola ucapan, doa, dan RSVP tamu undangan dalam satu tempat.</p>
                            <div class="doc-step mb-2">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-secondary text-white">1</div>
                                    <span class="small fw-medium">Lihat Ucapan</span>
                                </div>
                                <p class="small text-muted mb-0">Baca semua ucapan dan doa dari tamu yang hadir atau tidak hadir.</p>
                            </div>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-secondary text-white">2</div>
                                    <span class="small fw-medium">Kelola RSVP</span>
                                </div>
                                <p class="small text-muted mb-0">Pantau jumlah tamu yang akan hadir, tidak hadir, dan belum konfirmasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Menu Documentation -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-transparent border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Menu Administrator (Admin Menu)</h5>
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Admin</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Dashboard Admin -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-columns-gap"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Dashboard</h6>
                                    <small class="text-muted">Admin Dashboard</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Halaman utama admin untuk melihat statistik keseluruhan sistem.</p>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Lihat Statistik</span>
                                </div>
                                <p class="small text-muted mb-0">Monitor total undangan, pengguna, RSVP, dan aktivitas sistem.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Pasangan -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-gem"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Daftar Pasangan</h6>
                                    <small class="text-muted">Invitation Management</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Kelola semua data undangan pernikahan dari seluruh pengguna.</p>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Verifikasi & Edit</span>
                                </div>
                                <p class="small text-muted mb-0">Lihat, edit, atau hapus data undangan yang dibuat oleh pengguna.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Music Library -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-music-note-list"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Music Library</h6>
                                    <small class="text-muted">Musik Undangan</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Kelola perpustakaan musik yang tersedia untuk undangan digital.</p>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Upload & Edit Musik</span>
                                </div>
                                <p class="small text-muted mb-0">Upload file audio, atur judul, artis, dan status aktif/nonaktif.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Template Creator -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-stars"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Template Creator</h6>
                                    <small class="text-muted">Buat Template AI</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Buat template undangan baru menggunakan bantuan AI.</p>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Generate dengan AI</span>
                                </div>
                                <p class="small text-muted mb-0">Masukkan prompt untuk generate template undangan secara otomatis.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tema & Tampilan -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-palette"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Tema & Tampilan</h6>
                                    <small class="text-muted">Template Gallery</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Kelola gallery template undangan yang tersedia untuk pengguna.</p>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Upload Template</span>
                                </div>
                                <p class="small text-muted mb-0">Upload template baru, edit kategori, dan atur status premium/free.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paket & Harga -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-tags"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Paket & Harga</h6>
                                    <small class="text-muted">Subscription Plans</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Kelola paket langganan, harga, dan fitur yang tersedia.</p>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Atur Paket</span>
                                </div>
                                <p class="small text-muted mb-0">Buat paket Basic, Premium, atau custom dengan harga dan fitur masing-masing.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kupon Promo -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Kupon Promo</h6>
                                    <small class="text-muted">Coupons</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Kelola kupon diskon dan promosi untuk pengguna.</p>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Buat Kupon</span>
                                </div>
                                <p class="small text-muted mb-0">Buat kode kupon, atur diskon, minimal pembelian, dan masa berlaku.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promosi -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-megaphone"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Promosi</h6>
                                    <small class="text-muted">Promotions</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Kelola banner dan promosi yang ditampilkan di halaman depan.</p>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Atur Promosi</span>
                                </div>
                                <p class="small text-muted mb-0">Upload gambar promosi, atur link, dan jadwal tampil.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Pengguna -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Daftar Pengguna</h6>
                                    <small class="text-muted">User Management</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Kelola akun pengguna, role, dan status verifikasi.</p>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Manage User</span>
                                </div>
                                <p class="small text-muted mb-0">Lihat daftar user, ubah role, verifikasi email, atau hapus akun.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengaturan .env -->
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card m-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="doc-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-sliders"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Pengaturan .env</h6>
                                    <small class="text-muted">Environment Settings</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">Atur konfigurasi environment aplikasi seperti Midtrans, Mail, dll.</p>
                            <div class="doc-step">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="doc-badge bg-primary text-white">1</div>
                                    <span class="small fw-medium">Konfigurasi</span>
                                </div>
                                <p class="small text-muted mb-0">Ubah pengaturan .env langsung dari dashboard admin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Getting Started -->
    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-transparent border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Mulai Menggunakan</h5>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="doc-step h-100">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="doc-badge bg-primary text-white">1</div>
                            <h6 class="fw-bold mb-0">Buat Data Pasangan</h6>
                        </div>
                        <p class="small text-muted mb-0">Mulai dari menu "Pasangan Saya", isi data pengantin, pilih template undangan, dan atur tanggal pernikahan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="doc-step h-100">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="doc-badge bg-primary text-white">2</div>
                            <h6 class="fw-bold mb-0">Rencanakan & Budget</h6>
                        </div>
                        <p class="small text-muted mb-0">Gunakan menu "Rencana Pernikahan" untuk membuat checklist persiapan dan "Anggaran" untuk mengatur budget.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="doc-step h-100">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="doc-badge bg-primary text-white">3</div>
                            <h6 class="fw-bold mb-0">Tabung & Pantau</h6>
                        </div>
                        <p class="small text-muted mb-0">Buat target tabungan di menu "Tabungan", catat setoran, dan pantau progres di "Ikhtisar Keuangan".</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
