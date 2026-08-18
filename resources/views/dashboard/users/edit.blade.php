<x-app-layout>
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0">Edit Pengguna</h4>
            <p class="text-muted mb-0 small">Perbarui informasi pengguna</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('user.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}" placeholder="Nama pengguna" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" placeholder="email@contoh.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. WhatsApp</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $user->phone) }}" placeholder="6281234567890">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Kosongkan jika tidak ingin mengubah">
                        <div class="form-text">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Ulangi password baru">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('user.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body">
            <h6 class="fw-semibold mb-3">Link Login Tanpa Password</h6>
            <p class="text-muted small mb-3">Buat link login untuk pengguna. Pengguna bisa langsung login tanpa username dan password. Link hanya bisa digunakan sekali dan berlaku selama 20 menit.</p>
            <button type="button" class="btn btn-outline-primary btn-sm" id="generateLinkBtn" data-user-id="{{ $user->id }}">
                <i class="bi bi-link-45deg me-1"></i> Generate Link Login
            </button>
            <div id="linkResult" class="mt-3" style="display: none;">
                <div class="input-group">
                    <input type="text" class="form-control" id="magicLinkInput" readonly>
                    <button class="btn btn-primary" type="button" id="copyLinkBtn">
                        <i class="bi bi-clipboard me-1"></i> Salin
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-semibold mb-1">Paket Langganan</h6>
                    <p class="text-muted small mb-0">Berikan atau ganti paket langganan untuk pengguna ini.</p>
                </div>
                @if($subscription && $subscription->end_date && $subscription->end_date->isFuture())
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                @elseif($subscription)
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Expired</span>
                @else
                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Belum Berlangganan</span>
                @endif
            </div>

            @if($currentPlan)
                <div class="alert alert-light border mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Paket Saat Ini:</strong> {{ $currentPlan->name }}
                            @if($currentPlan->is_free)
                                <span class="badge bg-success-subtle text-success ms-2">Gratis</span>
                            @else
                                <span class="text-muted small ms-2">Rp {{ number_format($currentPlan->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="text-end">
                            <small class="text-muted">
                                Berlaku sampai {{ $subscription->end_date->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.subscriptions.update-plan', $user) }}" method="POST">
                @csrf
                @method('POST')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pilih Paket</label>
                        <select name="subscription_plan_id" class="form-select" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $currentPlan && $currentPlan->id == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} - {{ $plan->is_free ? 'Gratis' : 'Rp ' . number_format($plan->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Durasi (Hari)</label>
                        <input type="number" name="duration" class="form-control" value="{{ $currentPlan->duration ?? 30 }}" min="1">
                        <div class="form-text">Jumlah hari langganan.</div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i> Berikan
                        </button>
                    </div>
                </div>
            </form>

            @if($subscription && $subscription->end_date && $subscription->end_date->isFuture())
                <form id="cancel-subscription-form-{{ $user->id }}" action="{{ route('admin.subscriptions.cancel', $user) }}" method="POST" class="mt-3">
                    @csrf
                    @method('POST')
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmCancelSubscription({{ $user->id }})">
                        <i class="bi bi-x-circle me-1"></i> Batalkan Langganan
                    </button>
                </form>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('generateLinkBtn').addEventListener('click', function () {
            const userId = this.dataset.userId;
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Generating...';

            fetch(`/users/${userId}/magic-link`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('magicLinkInput').value = data.url;
                document.getElementById('linkResult').style.display = 'block';
                btn.innerHTML = '<i class="bi bi-link-45deg me-1"></i> Generate Ulang Link';
                btn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = '<i class="bi bi-link-45deg me-1"></i> Generate Link Login';
                btn.disabled = false;
                alert('Gagal generate link.');
            });
        });

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

        function confirmCancelSubscription(userId) {
            Swal.fire({
                title: 'Batalkan langganan?',
                text: "Pengguna akan kehilangan akses ke fitur premium.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancel-subscription-form-' + userId).submit();
                }
            });
        }
    </script>
</x-app-layout>
