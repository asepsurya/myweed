<x-app-layout>

    <div class="card adminuiux-card mt-4 mb-0">
        <div class="card-body">
            
            <!-- Header -->
            <div class="row mb-3 align-items-center">
                <div class="col">
                    <h6 class="fw-medium mb-0">Daftar Pengguna</h6>
                </div>
                <div class="col-auto">
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Pengguna
                    </a>
                </div>
            </div>

            <!-- Table -->
            <table id="dataTable" class="dataTable table w-100 nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th data-breakpoints="xs sm">User Name</th>
                        <th data-breakpoints="xs sm md">Contact info</th>
                        <th data-breakpoints="xs sm">Role</th>
                        <th class="all">Schedule</th>
                        <th data-breakpoints="xs sm">Status</th>
                        <th class="all">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $no++ }}</td>

                            <td>
                                <div class="row align-items-center flex-nowrap">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-40 mb-0 coverimg rounded-circle">
                                            <img src="{{ asset('tempelate/user_default.jpg') }}" alt="Avatar">
                                        </figure>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="mb-0 fw-medium">{{ $user->name }}</p>
                                        <p class="text-secondary small mb-0">
                                            Registered {{ $user->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <p class="mb-0">{{ $user->email }}</p>
                                @if($user->phone)
                                    <p class="mb-0 text-muted small">{{ $user->phone }}</p>
                                @endif
                            </td>

                            <td>
                                <span class="badge rounded-pill text-bg-primary">
                                    {{ $user->role ?? 'User' }}
                                </span>
                            </td>

                            <td>
                                <p class="mb-0">
                                    {{ $user->created_at->format('d M Y') }}
                                </p>
                            </td>

                            <td>
                                <span class="badge rounded-pill text-bg-success">
                                    Active
                                </span>
                            </td>

                            <td>
                                <div class="dropdown d-inline-block">
                                    <a class="btn btn-link no-caret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                       
                                            <li>
                                                <button type="button" class="dropdown-item wa-share-trigger" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-phone="{{ $user->phone }}">
                                                    <i class="bi bi-whatsapp me-2"></i> Kirim WhatsApp
                                                </button>
                                            </li>
                                        <li>
                                            <button type="button" class="dropdown-item qr-trigger" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                <i class="bi bi-qr-code me-2"></i> Generate QR Code
                                            </button>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.edit', $user) }}">
                                                <i class="bi bi-pencil-square me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item magic-link-trigger" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                <i class="bi bi-link-45deg me-2"></i> Link Login
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