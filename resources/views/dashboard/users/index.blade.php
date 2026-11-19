<x-app-layout>
    <div class="container-fluid py-3 py-md-4">
        {{-- Page Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="mb-1 fw-bold" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <i class="bi bi-people-fill me-2" style="color: #C6A962;"></i> Manajemen Pengguna
                </h4>
                <p class="text-muted small mb-0">Kelola akun pengguna, peran akses, dan tautan login mandiri (Magic Link)</p>
            </div>
            <a href="{{ route('user.create') }}" class="btn text-white btn-sm px-3 py-2 fw-semibold rounded-3 shadow-sm"
               style="background: linear-gradient(135deg, #C6A962, #A68B4B); border: none;">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna
            </a>
        </div>

        {{-- Mini Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4">
                <div class="card border-0 rounded-4 shadow-sm h-100 p-3" style="background-color: var(--bs-card-bg, #FFFFFF);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                             style="width: 44px; height: 44px; background: rgba(198, 169, 98, 0.15); color: #C6A962;">
                            <i class="bi bi-people fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Pengguna</div>
                            <div class="fs-5 fw-bold">{{ $users->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card border-0 rounded-4 shadow-sm h-100 p-3" style="background-color: var(--bs-card-bg, #FFFFFF);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                             style="width: 44px; height: 44px; background: rgba(27, 42, 74, 0.1); color: #1B2A4A;">
                            <i class="bi bi-shield-check fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Administrator</div>
                            <div class="fs-5 fw-bold">{{ $users->filter(fn($u) => $u->hasRole('admin'))->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 rounded-4 shadow-sm h-100 p-3" style="background-color: var(--bs-card-bg, #FFFFFF);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                             style="width: 44px; height: 44px; background: rgba(25, 135, 84, 0.12); color: #198754;">
                            <i class="bi bi-person-check fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Member Terdaftar</div>
                            <div class="fs-5 fw-bold">{{ $users->filter(fn($u) => !$u->hasRole('admin'))->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Table --}}
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden" style="background-color: var(--bs-card-bg, #FFFFFF);">
            <div class="card-body p-3 p-md-4">
                <div class="table-responsive">
                    <table id="dataTable" class="dataTable table align-middle w-100 nowrap">
                        <thead>
                            <tr class="text-uppercase small text-muted" style="border-bottom: 2px solid rgba(27, 42, 74, 0.08);">
                                <th style="width: 50px;">No</th>
                                <th data-breakpoints="xs sm">Nama Pengguna</th>
                                <th data-breakpoints="xs sm md">Kontak & Email</th>
                                <th data-breakpoints="xs sm">Peran (Role)</th>
                                <th class="all">Terdaftar</th>
                                <th data-breakpoints="xs sm">Status</th>
                                <th class="all text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-muted small">{{ $no++ }}</td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                                 style="width: 38px; height: 38px; background: {{ $user->hasRole('admin') ? '#1B2A4A' : '#C6A962' }}; font-size: 0.85rem;">
                                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    {{ $user->created_at ? $user->created_at->diffForHumans() : '' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div>{{ $user->email }}</div>
                                        @if($user->phone)
                                            <small class="text-muted d-flex align-items-center gap-1" style="font-size: 0.78rem;">
                                                <i class="bi bi-telephone text-success"></i> {{ $user->phone }}
                                            </small>
                                        @endif
                                    </td>

                                    <td>
                                        @if($user->hasRole('admin'))
                                            <span class="badge rounded-pill px-2 py-1" style="background: rgba(27, 42, 74, 0.12); color: #1B2A4A; border: 1px solid rgba(27, 42, 74, 0.2);">
                                                <i class="bi bi-shield-lock-fill me-1"></i> Admin
                                            </span>
                                        @else
                                            <span class="badge rounded-pill px-2 py-1" style="background: rgba(198, 169, 98, 0.15); color: #A68B4B; border: 1px solid rgba(198, 169, 98, 0.3);">
                                                <i class="bi bi-person me-1"></i> User
                                            </span>
                                        @endif
                                    </td>

                                    <td class="small text-muted">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="bi bi-check-circle me-1"></i> Aktif
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm btn-light rounded-circle p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                                                <li>
                                                    <button type="button" class="dropdown-item py-2 wa-share-trigger" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-phone="{{ $user->phone }}">
                                                        <i class="bi bi-whatsapp text-success me-2"></i> Kirim WhatsApp
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item py-2 qr-trigger" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                        <i class="bi bi-qr-code text-primary me-2"></i> Generate QR Code
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item py-2" href="{{ route('user.edit', $user) }}">
                                                        <i class="bi bi-pencil-square text-warning me-2"></i> Edit Akun
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item py-2 magic-link-trigger" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                        <i class="bi bi-link-45deg text-info me-2"></i> Link Login (Magic)
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Magic Link Modal -->
    <div class="modal fade" id="magicLinkModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Link Login - <span id="magicLinkUserName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Bagikan link ini kepada pengguna. Link hanya bisa digunakan sekali untuk login dan berlaku selama 20 menit.</p>
                    <div class="input-group">
                        <input type="text" class="form-control" id="magicLinkInput" readonly>
                        <button class="btn btn-primary" type="button" id="copyLinkBtn">
                            <i class="bi bi-clipboard me-1"></i> Salin
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Share Modal -->
    <div class="modal fade" id="waShareModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kirim via WhatsApp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Kirim pesan berikut ke pengguna melalui WhatsApp. Link hanya bisa digunakan sekali untuk login dan berlaku selama 20 menit.</p>
                    <textarea class="form-control" id="waMessage" rows="6" readonly></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" target="_blank" rel="noopener" class="btn btn-success" id="waOpenBtn">
                        <i class="bi bi-whatsapp me-1"></i> Buka WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">QR Code Link Login - <span id="qrUserName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="text-muted small mb-3">Scan QR code untuk login. Link hanya bisa digunakan sekali dan berlaku selama 20 menit.</p>
                    <div class="qr-wrapper position-relative d-inline-block">
                        <img id="qrImage" src="" alt="QR Code" class="img-fluid border rounded">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="downloadQrBtn" disabled>
                        <i class="bi bi-download me-1"></i> Download QR
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .qr-wrapper {
            position: relative;
            display: inline-block;
            line-height: 0;
        }
    </style>

    <script>
        function generateMagicLink(userId, callback) {
            fetch(`/users/${userId}/magic-link`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => callback(data.url))
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal generate link.');
            });
        }

        function bindWaShareTrigger(trigger) {
            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                const userId = this.dataset.userId;
                const userName = this.dataset.userName;
                const phone = this.dataset.userPhone;
                const modal = new bootstrap.Modal(document.getElementById('waShareModal'));
                const textarea = document.getElementById('waMessage');
                const openBtn = document.getElementById('waOpenBtn');

                textarea.value = 'Generating...';
                openBtn.style.display = 'none';
                openBtn.removeAttribute('href');
                modal.show();

                generateMagicLink(userId, function(url) {
                    const message = `Halo ${userName},\n\nBerikut adalah link login untuk akun Anda:\n${url}\n\nLink hanya bisa digunakan sekali untuk login dan berlaku selama 20 menit.\n\nCara login:\n1. Buka link di atas menggunakan browser (Chrome, Safari, dll)\n2. Anda akan otomatis masuk ke akun\n3. Simpan halaman atau buka bookmark untuk login berikutnya`;
                    textarea.value = message;
                    openBtn.href = `https://wa.me/${phone.replace(/[^0-9]/g, '')}?text=${encodeURIComponent(message)}`;
                    openBtn.style.display = 'inline-flex';
                });
            });
        }

        function bindQrTrigger(trigger) {
            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                const userId = this.dataset.userId;
                const userName = this.dataset.userName;
                const modal = new bootstrap.Modal(document.getElementById('qrModal'));
                const qrImage = document.getElementById('qrImage');
                const userNameSpan = document.getElementById('qrUserName');
                const downloadBtn = document.getElementById('downloadQrBtn');

                userNameSpan.textContent = userName;
                qrImage.src = '';
                downloadBtn.disabled = true;
                modal.show();

                generateMagicLink(userId, function(url) {
                    const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=${encodeURIComponent(url)}`;
                    qrImage.src = qrUrl;
                    downloadBtn.onclick = function () {
                        downloadQr(qrUrl, `qr-login-${userName.replace(/\s+/g, '-').toLowerCase()}.png`);
                    };
                    downloadBtn.disabled = false;
                });
            });
        }

        function bindMagicLinkTrigger(trigger) {
            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                const userId = this.dataset.userId;
                const userName = this.dataset.userName;
                const modal = new bootstrap.Modal(document.getElementById('magicLinkModal'));
                const input = document.getElementById('magicLinkInput');
                const userNameSpan = document.getElementById('magicLinkUserName');

                userNameSpan.textContent = userName;
                input.value = 'Generating...';
                modal.show();

                generateMagicLink(userId, function(url) {
                    input.value = url;
                });
            });
        }

        document.querySelectorAll('.wa-share-trigger').forEach(bindWaShareTrigger);
        document.querySelectorAll('.qr-trigger').forEach(bindQrTrigger);
        document.querySelectorAll('.magic-link-trigger').forEach(bindMagicLinkTrigger);

        function downloadQr(url, filename) {
            const qr = new Image();
            qr.crossOrigin = 'anonymous';

            qr.onload = function () {
                const padding = 60;
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = qr.width + padding * 2;
                canvas.height = qr.height + padding * 2;

                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(qr, padding, padding);

                triggerDownload(canvas, filename);
            };

            qr.onerror = function () {
                alert('Gagal load QR code untuk download.');
            };

            qr.src = url;

            function triggerDownload(canvas, filename) {
                canvas.toBlob(function (blob) {
                    const blobUrl = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = blobUrl;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(blobUrl);
                }, 'image/png');
            }
        }

        document.getElementById('copyLinkBtn').addEventListener('click', function () {
            const input = document.getElementById('magicLinkInput');
            input.select();
            document.execCommand('copy');
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check me-1"></i> Tersalin';
            setTimeout(() => {
                this.innerHTML = originalText;
            }, 2000);
        });
    </script>
</x-app-layout>