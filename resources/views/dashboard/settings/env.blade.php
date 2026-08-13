<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold m-0" style="font-family: 'Plus Jakarta Sans', sans-serif; color: var(--bs-body-color);">
                <i class="bi bi-sliders me-2" style="color: var(--adminuiux-theme-1);"></i> Pengaturan File .env
            </h2>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-3">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> Area Sensitif
            </span>
        </div>
    </x-slot>

    <style>
        .settings-card {
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        [data-bs-theme="dark"] .settings-card {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .nav-pills .nav-link {
            color: var(--bs-secondary-color);
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 18px;
            transition: all 0.2s ease-in-out;
        }

        .nav-pills .nav-link.active {
            background-color: var(--adminuiux-theme-1, #0d6efd);
            color: #ffffff;
        }

        .nav-pills .nav-link:hover:not(.active) {
            background-color: var(--bs-tertiary-bg);
            color: var(--bs-body-color);
        }

        .input-group-text {
            background-color: var(--bs-tertiary-bg);
            border-color: var(--bs-border-color);
            color: var(--bs-secondary-color);
        }

        .form-control, .form-select {
            border-color: var(--bs-border-color);
            border-radius: 8px;
            padding: 10px 12px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--adminuiux-theme-1, #0d6efd);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--bs-body-color);
            border-bottom: 2px solid var(--bs-border-color);
            padding-bottom: 8px;
            margin-bottom: 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    <div class="container mt-4" style="padding-bottom: 120px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="bi bi-exclamation-octagon-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Terjadi kesalahan validasi:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card settings-card">
            <div class="card-body p-4">
                <div class="alert alert-warning border border-warning-subtle rounded-3 py-3 mb-4">
                    <div class="d-flex">
                        <div class="me-3 fs-3 text-warning">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <h6 class="alert-heading fw-bold mb-1">Perhatian Penting!</h6>
                            <p class="mb-0 small text-secondary">
                                Mengubah data konfigurasi di bawah ini akan memperbarui file sistem <code>.env</code> secara langsung. 
                                Kesalahan pengisian parameter database atau URL dapat menyebabkan aplikasi tidak dapat diakses atau error koneksi. 
                                Setelah Anda menyimpan perubahan, sistem akan otomatis membersihkan cache konfigurasi (<code>config:clear</code>).
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('settings.env.update') }}" method="POST" id="envForm">
                    @csrf

                    <!-- Navigation Tabs -->
                    <ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" id="envTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                                <i class="bi bi-cpu me-1"></i> Aplikasi & Database
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="mayar-tab" data-bs-toggle="pill" data-bs-target="#mayar" type="button" role="tab" aria-controls="mayar" aria-selected="false">
                                <i class="bi bi-wallet2 me-1"></i> Gateway Mayar
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="midtrans-tab" data-bs-toggle="pill" data-bs-target="#midtrans" type="button" role="tab" aria-controls="midtrans" aria-selected="false">
                                <i class="bi bi-credit-card me-1"></i> Gateway Midtrans
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="mail-tab" data-bs-toggle="pill" data-bs-target="#mail" type="button" role="tab" aria-controls="mail" aria-selected="false">
                                <i class="bi bi-envelope-at me-1"></i> SMTP Mailer
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="oauth-ai-tab" data-bs-toggle="pill" data-bs-target="#oauth-ai" type="button" role="tab" aria-controls="oauth-ai" aria-selected="false">
                                <i class="bi bi-google-play me-1"></i> OAuth & AI
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="storage-tab" data-bs-toggle="pill" data-bs-target="#storage" type="button" role="tab" aria-controls="storage" aria-selected="false">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Storage
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Contents -->
                    <div class="tab-content" id="envTabsContent">
                        
                        <!-- TAB 1: GENERAL & DATABASE -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h5 class="section-title"><i class="bi bi-gear-fill me-1 text-primary"></i> Konfigurasi Aplikasi</h5>
                                    
                                    <div class="mb-3">
                                        <label for="APP_NAME" class="form-label fw-semibold">Nama Aplikasi (APP_NAME)</label>
                                        <input type="text" name="APP_NAME" id="APP_NAME" class="form-control" value="{{ old('APP_NAME', $envData['APP_NAME'] ?? '') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="APP_ENV" class="form-label fw-semibold">Environment (APP_ENV)</label>
                                        <select name="APP_ENV" id="APP_ENV" class="form-select" required>
                                            <option value="local" {{ old('APP_ENV', $envData['APP_ENV'] ?? '') === 'local' ? 'selected' : '' }}>Local (Development)</option>
                                            <option value="staging" {{ old('APP_ENV', $envData['APP_ENV'] ?? '') === 'staging' ? 'selected' : '' }}>Staging</option>
                                            <option value="production" {{ old('APP_ENV', $envData['APP_ENV'] ?? '') === 'production' ? 'selected' : '' }}>Production</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="APP_DEBUG" class="form-label fw-semibold">Debug Mode (APP_DEBUG)</label>
                                        <select name="APP_DEBUG" id="APP_DEBUG" class="form-select" required>
                                            <option value="true" {{ old('APP_DEBUG', $envData['APP_DEBUG'] ?? '') === 'true' ? 'selected' : '' }}>True (Tampilkan Detail Error)</option>
                                            <option value="false" {{ old('APP_DEBUG', $envData['APP_DEBUG'] ?? '') === 'false' ? 'selected' : '' }}>False (Sembunyikan Error - Disarankan untuk Live)</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="APP_URL" class="form-label fw-semibold">URL Aplikasi (APP_URL)</label>
                                        <input type="url" name="APP_URL" id="APP_URL" class="form-control" value="{{ old('APP_URL', $envData['APP_URL'] ?? '') }}" required placeholder="https://domainanda.com">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h5 class="section-title"><i class="bi bi-database-fill me-1 text-success"></i> Konfigurasi Database</h5>
                                    
                                    <div class="mb-3">
                                        <label for="DB_HOST" class="form-label fw-semibold">Host Database (DB_HOST)</label>
                                        <input type="text" name="DB_HOST" id="DB_HOST" class="form-control" value="{{ old('DB_HOST', $envData['DB_HOST'] ?? '') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="DB_PORT" class="form-label fw-semibold">Port Database (DB_PORT)</label>
                                        <input type="number" name="DB_PORT" id="DB_PORT" class="form-control" value="{{ old('DB_PORT', $envData['DB_PORT'] ?? 3306) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="DB_DATABASE" class="form-label fw-semibold">Nama Database (DB_DATABASE)</label>
                                        <input type="text" name="DB_DATABASE" id="DB_DATABASE" class="form-control" value="{{ old('DB_DATABASE', $envData['DB_DATABASE'] ?? '') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="DB_USERNAME" class="form-label fw-semibold">Username DB (DB_USERNAME)</label>
                                        <input type="text" name="DB_USERNAME" id="DB_USERNAME" class="form-control" value="{{ old('DB_USERNAME', $envData['DB_USERNAME'] ?? '') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="DB_PASSWORD" class="form-label fw-semibold">Password DB (DB_PASSWORD)</label>
                                        <div class="input-group">
                                            <input type="password" name="DB_PASSWORD" id="DB_PASSWORD" class="form-control" value="{{ old('DB_PASSWORD', $envData['DB_PASSWORD'] ?? '') }}">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('DB_PASSWORD')">
                                                <i class="bi bi-eye" id="toggle-DB_PASSWORD-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: MAYAR -->
                        <div class="tab-pane fade" id="mayar" role="tabpanel" aria-labelledby="mayar-tab">
                            <h5 class="section-title"><i class="bi bi-wallet2 me-1 text-primary"></i> Pengaturan Gateway Pembayaran Mayar</h5>
                            <p class="text-muted small">Konfigurasi API Key Mayar untuk memproses invoice dan link pembayaran langganan.</p>
                            
                            <div class="mb-3 col-md-8">
                                <label for="MAYAR_BASE_URL" class="form-label fw-semibold">Mayar Base URL (MAYAR_BASE_URL)</label>
                                <input type="url" name="MAYAR_BASE_URL" id="MAYAR_BASE_URL" class="form-control" value="{{ old('MAYAR_BASE_URL', $envData['MAYAR_BASE_URL'] ?? 'https://api.mayar.id/hl/v2') }}" required>
                                <div class="form-text">Endpoint API default: <code>https://api.mayar.id/hl/v2</code></div>
                            </div>

                            <div class="mb-3 col-md-8">
                                <label for="MAYAR_API_KEY" class="form-label fw-semibold">Mayar API Key (MAYAR_API_KEY)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" name="MAYAR_API_KEY" id="MAYAR_API_KEY" class="form-control" value="{{ old('MAYAR_API_KEY', $envData['MAYAR_API_KEY'] ?? '') }}" placeholder="Masukkan API Key Mayar Anda">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('MAYAR_API_KEY')">
                                        <i class="bi bi-eye" id="toggle-MAYAR_API_KEY-icon"></i>
                                    </button>
                                </div>
                                <div class="form-text text-danger"><i class="bi bi-info-circle me-1"></i> API Key yang salah akan menyebabkan kegagalan pembuatan link transaksi pembayaran (Error 401).</div>
                            </div>
                        </div>

                        <!-- TAB 3: MIDTRANS -->
                        <div class="tab-pane fade" id="midtrans" role="tabpanel" aria-labelledby="midtrans-tab">
                            <h5 class="section-title"><i class="bi bi-credit-card me-1 text-success"></i> Pengaturan Gateway Pembayaran Midtrans</h5>
                            <p class="text-muted small">Konfigurasi API Key Midtrans (sebagai alternatif pembayaran atau backup).</p>

                            <div class="mb-3 col-md-8">
                                <label for="MIDTRANS_IS_PRODUCTION" class="form-label fw-semibold">Mode Midtrans (MIDTRANS_IS_PRODUCTION)</label>
                                <select name="MIDTRANS_IS_PRODUCTION" id="MIDTRANS_IS_PRODUCTION" class="form-select" required>
                                    <option value="false" {{ old('MIDTRANS_IS_PRODUCTION', $envData['MIDTRANS_IS_PRODUCTION'] ?? '') === 'false' ? 'selected' : '' }}>Sandbox / Testing (Lakukan Ujicoba Transaksi)</option>
                                    <option value="true" {{ old('MIDTRANS_IS_PRODUCTION', $envData['MIDTRANS_IS_PRODUCTION'] ?? '') === 'true' ? 'selected' : '' }}>Production (Menerima Uang Asli)</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-8">
                                <label for="MIDTRANS_CLIENT_KEY" class="form-label fw-semibold">Midtrans Client Key (MIDTRANS_CLIENT_KEY)</label>
                                <input type="text" name="MIDTRANS_CLIENT_KEY" id="MIDTRANS_CLIENT_KEY" class="form-control" value="{{ old('MIDTRANS_CLIENT_KEY', $envData['MIDTRANS_CLIENT_KEY'] ?? '') }}" placeholder="Mata Kunci Client (misal: SB-Mid-client-...)">
                            </div>

                            <div class="mb-3 col-md-8">
                                <label for="MIDTRANS_SERVER_KEY" class="form-label fw-semibold">Midtrans Server Key (MIDTRANS_SERVER_KEY)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" name="MIDTRANS_SERVER_KEY" id="MIDTRANS_SERVER_KEY" class="form-control" value="{{ old('MIDTRANS_SERVER_KEY', $envData['MIDTRANS_SERVER_KEY'] ?? '') }}" placeholder="Mata Kunci Server (misal: SB-Mid-server-...)">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('MIDTRANS_SERVER_KEY')">
                                        <i class="bi bi-eye" id="toggle-MIDTRANS_SERVER_KEY-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: MAIL -->
                        <div class="tab-pane fade" id="mail" role="tabpanel" aria-labelledby="mail-tab">
                            <h5 class="section-title"><i class="bi bi-envelope-at me-1 text-info"></i> Konfigurasi SMTP Email (Mail)</h5>
                            <p class="text-muted small">Konfigurasi mailer server SMTP untuk mengirim pesan verifikasi, rsvp, dan invoice ke pengguna.</p>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="MAIL_HOST" class="form-label fw-semibold">SMTP Host (MAIL_HOST)</label>
                                    <input type="text" name="MAIL_HOST" id="MAIL_HOST" class="form-control" value="{{ old('MAIL_HOST', $envData['MAIL_HOST'] ?? '') }}" placeholder="smtp.mailtrap.io atau smtp.gmail.com">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="MAIL_PORT" class="form-label fw-semibold">SMTP Port (MAIL_PORT)</label>
                                    <input type="number" name="MAIL_PORT" id="MAIL_PORT" class="form-control" value="{{ old('MAIL_PORT', $envData['MAIL_PORT'] ?? '') }}" placeholder="587 / 465">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="MAIL_USERNAME" class="form-label fw-semibold">Username SMTP (MAIL_USERNAME)</label>
                                    <input type="text" name="MAIL_USERNAME" id="MAIL_USERNAME" class="form-control" value="{{ old('MAIL_USERNAME', $envData['MAIL_USERNAME'] ?? '') }}" placeholder="alamat email atau api username">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="MAIL_PASSWORD" class="form-label fw-semibold">Password SMTP (MAIL_PASSWORD)</label>
                                    <div class="input-group">
                                        <input type="password" name="MAIL_PASSWORD" id="MAIL_PASSWORD" class="form-control" value="{{ old('MAIL_PASSWORD', $envData['MAIL_PASSWORD'] ?? '') }}">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('MAIL_PASSWORD')">
                                            <i class="bi bi-eye" id="toggle-MAIL_PASSWORD-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="MAIL_FROM_ADDRESS" class="form-label fw-semibold">Email Pengirim (MAIL_FROM_ADDRESS)</label>
                                    <input type="email" name="MAIL_FROM_ADDRESS" id="MAIL_FROM_ADDRESS" class="form-control" value="{{ old('MAIL_FROM_ADDRESS', $envData['MAIL_FROM_ADDRESS'] ?? '') }}" placeholder="noreply@domainanda.com">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="MAIL_FROM_NAME" class="form-label fw-semibold">Nama Pengirim (MAIL_FROM_NAME)</label>
                                    <input type="text" name="MAIL_FROM_NAME" id="MAIL_FROM_NAME" class="form-control" value="{{ old('MAIL_FROM_NAME', $envData['MAIL_FROM_NAME'] ?? '') }}" placeholder="Loventa Invitation Official">
                                </div>
                            </div>
                        </div>

                        <!-- TAB 5: OAUTH & AI -->
                        <div class="tab-pane fade" id="oauth-ai" role="tabpanel" aria-labelledby="oauth-ai-tab">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h5 class="section-title"><i class="bi bi-google me-1 text-danger"></i> Google OAuth Integration</h5>
                                    <p class="text-muted small">Konfigurasi masuk lewat Google (Sign in with Google).</p>

                                    <div class="mb-3">
                                        <label for="GOOGLE_CLIENT_ID" class="form-label fw-semibold">Google Client ID</label>
                                        <input type="text" name="GOOGLE_CLIENT_ID" id="GOOGLE_CLIENT_ID" class="form-control" value="{{ old('GOOGLE_CLIENT_ID', $envData['GOOGLE_CLIENT_ID'] ?? '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="GOOGLE_CLIENT_SECRET" class="form-label fw-semibold">Google Client Secret</label>
                                        <div class="input-group">
                                            <input type="password" name="GOOGLE_CLIENT_SECRET" id="GOOGLE_CLIENT_SECRET" class="form-control" value="{{ old('GOOGLE_CLIENT_SECRET', $envData['GOOGLE_CLIENT_SECRET'] ?? '') }}">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('GOOGLE_CLIENT_SECRET')">
                                                <i class="bi bi-eye" id="toggle-GOOGLE_CLIENT_SECRET-icon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="GOOGLE_REDIRECT_URI" class="form-label fw-semibold">Google Redirect URI</label>
                                        <input type="url" name="GOOGLE_REDIRECT_URI" id="GOOGLE_REDIRECT_URI" class="form-control" value="{{ old('GOOGLE_REDIRECT_URI', $envData['GOOGLE_REDIRECT_URI'] ?? '') }}" placeholder="http://localhost:8000/auth/google/callback">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h5 class="section-title"><i class="bi bi-stars me-1 text-warning"></i> Konfigurasi AI & Ollama Server</h5>
                                    <p class="text-muted small">Server AI untuk membantu pembuatan teks atau template undangan otomatis.</p>

                                    <div class="mb-3">
                                        <label for="AI_SERVER_URL" class="form-label fw-semibold">URL Server AI (AI_SERVER_URL)</label>
                                        <input type="url" name="AI_SERVER_URL" id="AI_SERVER_URL" class="form-control" value="{{ old('AI_SERVER_URL', $envData['AI_SERVER_URL'] ?? '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="AI_MODEL_PRIMARY" class="form-label fw-semibold">Model Utama (AI_MODEL_PRIMARY)</label>
                                        <input type="text" name="AI_MODEL_PRIMARY" id="AI_MODEL_PRIMARY" class="form-control" value="{{ old('AI_MODEL_PRIMARY', $envData['AI_MODEL_PRIMARY'] ?? '') }}" placeholder="misal: gpt-oss:120b-cloud">
                                    </div>

                                    <div class="mb-3">
                                        <label for="AI_MODEL_SECONDARY" class="form-label fw-semibold">Model Cadangan (AI_MODEL_SECONDARY)</label>
                                        <input type="text" name="AI_MODEL_SECONDARY" id="AI_MODEL_SECONDARY" class="form-control" value="{{ old('AI_MODEL_SECONDARY', $envData['AI_MODEL_SECONDARY'] ?? '') }}" placeholder="misal: llama3:latest">
                                    </div>

                                    <div class="mb-3">
                                        <label for="AI_API_KEY" class="form-label fw-semibold">AI API Key (AI_API_KEY)</label>
                                        <div class="input-group">
                                            <input type="password" name="AI_API_KEY" id="AI_API_KEY" class="form-control" value="{{ old('AI_API_KEY', $envData['AI_API_KEY'] ?? '') }}">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('AI_API_KEY')">
                                                <i class="bi bi-eye" id="toggle-AI_API_KEY-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 6: STORAGE -->
                        <div class="tab-pane fade" id="storage" role="tabpanel" aria-labelledby="storage-tab">
                            <h5 class="section-title"><i class="bi bi-cloud-arrow-up me-1 text-primary"></i> Konfigurasi Storage</h5>
                            <p class="text-muted small">Pilih driver penyimpanan untuk file gambar undangan. Local = server ini, R2 = Cloudflare R2.</p>

                            <div class="mb-3 col-md-8">
                                <label for="STORAGE_DRIVER" class="form-label fw-semibold">Driver Storage (STORAGE_DRIVER)</label>
                                <select name="STORAGE_DRIVER" id="STORAGE_DRIVER" class="form-select" required>
                                    <option value="local" {{ old('STORAGE_DRIVER', $envData['STORAGE_DRIVER'] ?? 'local') === 'local' ? 'selected' : '' }}>Local (Laravel Public Disk)</option>
                                    <option value="r2" {{ old('STORAGE_DRIVER', $envData['STORAGE_DRIVER'] ?? '') === 'r2' ? 'selected' : '' }}>Cloudflare R2</option>
                                </select>
                            </div>

                            <hr class="my-4">

                            <h5 class="section-title"><i class="bi bi-cloud me-1 text-warning"></i> Cloudflare R2</h5>
                            <p class="text-muted small">Isi kredensial R2 hanya jika memilih driver <strong>R2</strong>. Pastikan bucket dan API key sudah dibuat di dashboard Cloudflare.</p>

                            <div class="mb-3 col-md-8">
                                <label for="R2_ACCESS_KEY_ID" class="form-label fw-semibold">R2 Access Key ID (R2_ACCESS_KEY_ID)</label>
                                <input type="text" name="R2_ACCESS_KEY_ID" id="R2_ACCESS_KEY_ID" class="form-control" value="{{ old('R2_ACCESS_KEY_ID', $envData['R2_ACCESS_KEY_ID'] ?? '') }}" placeholder="Access Key ID R2">
                            </div>

                            <div class="mb-3 col-md-8">
                                <label for="R2_SECRET_ACCESS_KEY" class="form-label fw-semibold">R2 Secret Access Key (R2_SECRET_ACCESS_KEY)</label>
                                <div class="input-group">
                                    <input type="password" name="R2_SECRET_ACCESS_KEY" id="R2_SECRET_ACCESS_KEY" class="form-control" value="{{ old('R2_SECRET_ACCESS_KEY', $envData['R2_SECRET_ACCESS_KEY'] ?? '') }}" placeholder="Secret Access Key R2">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('R2_SECRET_ACCESS_KEY')">
                                        <i class="bi bi-eye" id="toggle-R2_SECRET_ACCESS_KEY-icon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3 col-md-8">
                                <label for="R2_REGION" class="form-label fw-semibold">R2 Region (R2_REGION)</label>
                                <input type="text" name="R2_REGION" id="R2_REGION" class="form-control" value="{{ old('R2_REGION', $envData['R2_REGION'] ?? 'auto') }}" placeholder="auto">
                                <div class="form-text">Gunakan <code>auto</code> untuk Cloudflare R2.</div>
                            </div>

                            <div class="mb-3 col-md-8">
                                <label for="R2_BUCKET" class="form-label fw-semibold">R2 Bucket Name (R2_BUCKET)</label>
                                <input type="text" name="R2_BUCKET" id="R2_BUCKET" class="form-control" value="{{ old('R2_BUCKET', $envData['R2_BUCKET'] ?? 'loventa-storage') }}" placeholder="loventa-storage">
                            </div>

                            <div class="mb-3 col-md-8">
                                <label for="R2_ENDPOINT" class="form-label fw-semibold">R2 Endpoint (R2_ENDPOINT)</label>
                                <input type="url" name="R2_ENDPOINT" id="R2_ENDPOINT" class="form-control" value="{{ old('R2_ENDPOINT', $envData['R2_ENDPOINT'] ?? 'https://s3.us-east-1.r2.cloudflarestorage.com') }}" placeholder="https://s3.us-east-1.r2.cloudflarestorage.com">
                            </div>

                            <div class="mb-3 col-md-8">
                                <label for="R2_URL" class="form-label fw-semibold">R2 URL (R2_URL)</label>
                                <input type="url" name="R2_URL" id="R2_URL" class="form-control" value="{{ old('R2_URL', $envData['R2_URL'] ?? 'https://cdn.inopakinstitute.or.id') }}" placeholder="https://cdn.inopakinstitute.or.id">
                            </div>

                            <div class="mb-3 col-md-8">
                                <label for="R2_PUBLIC_URL" class="form-label fw-semibold">R2 Public URL (R2_PUBLIC_URL)</label>
                                <input type="url" name="R2_PUBLIC_URL" id="R2_PUBLIC_URL" class="form-control" value="{{ old('R2_PUBLIC_URL', $envData['R2_PUBLIC_URL'] ?? 'https://cdn.inopakinstitute.or.id') }}" placeholder="https://cdn.inopakinstitute.or.id">
                                <div class="form-text">URL publik untuk akses file. Sama dengan R2_URL untuk public bucket.</div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-4">
                        <button type="reset" class="btn btn-outline-secondary rounded-3 px-4">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">
                            <i class="bi bi-check-circle me-1"></i> Simpan Konfigurasi .env
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- JS helper -->
    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById('toggle-' + fieldId + '-icon');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</x-app-layout>
