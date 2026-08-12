<x-app-layout>
    <style>
        h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--bs-body-color);
        }

        .stat-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .progress-budget {
            height: 10px;
            border-radius: 10px;
            overflow: hidden;
            background: var(--bs-tertiary-bg);
        }

        .progress-budget .track {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--bs-tertiary-bg);
            color: var(--bs-secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }
    </style>

    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Anggaran Pernikahan</h4>
            <p class="text-muted mb-0">Kelola anggaran, pengeluaran, dan jadwal pembayaran vendor</p>
        </div>
        @if($invitations->count() > 1)
            <form method="GET" class="d-flex gap-2">
                <select name="invitation_id" class="form-select filter-pill" onchange="this.form.submit()"
                    style="max-width: 220px;">
                    @foreach($invitations as $inv)
                        <option value="{{ $inv->id }}" {{ $inv->id == $activeInvitationId ? 'selected' : '' }}>
                            {{ $inv->groom_name }} & {{ $inv->bride_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        @endif
    </div>

    <!-- Budget Header Card -->
    <div class="card adminuiux-card shadow-sm mb-4">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('budget.update', $budget) }}" method="POST" class="row g-3 align-items-end">
                @csrf
                @method('PUT')
                <div class="col-12">
                    <h5 class="fw-bold mb-3" style="color: var(--adminuiux-theme-2);">
                        <i class="bi bi-wallet2 me-2"></i> Total Anggaran
                    </h5>
                </div>
                <div class="col-12">
                    <label for="title" class="form-label">Judul Anggaran</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $budget->title ?? 'Anggaran Pernikahan') }}"
                        placeholder="Masukkan judul anggaran">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="total_amount" class="form-label">Jumlah Total</label>
                    <input type="text" id="total_amount" name="total_amount"
                        class="form-control @error('total_amount') is-invalid @enderror"
                        value="{{ old('total_amount', number_format($budget->total_amount, 0, ',', '.')) }}"
                        placeholder="Rp 0">
                    @error('total_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="currency" class="form-label">Mata Uang</label>
                    <select name="currency" id="currency" class="form-select">
                        <option value="IDR" {{ $budget->currency == 'IDR' ? 'selected' : '' }}>IDR (Rupiah)</option>
                        <option value="USD" {{ $budget->currency == 'USD' ? 'selected' : '' }}>USD (Dolar)</option>
                        <option value="MYR" {{ $budget->currency == 'MYR' ? 'selected' : '' }}>MYR (Ringgit)</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card adminuiux-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-primary-subtle text-primary">
                        <i class="bi bi-currency-exchange"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($budget->total_amount, 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Anggaran</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card adminuiux-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-danger-subtle text-danger">
                        <i class="bi bi-receipt-cutoff"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($totalSpent, 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Terpakai</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card adminuiux-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-success-subtle text-success">
                        <i class="bi bi-lock"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($totalRemaining, 0, ',', '.') }}</div>
                        <div class="text-muted small">Tersisa</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card adminuiux-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-info-subtle text-info">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ $budget->usagePercent() }}%</div>
                        <div class="text-muted small">Terpakai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($overdueCount > 0)
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
            <div>
                <strong>{{ $overdueCount }} pembayaran</strong> vendor sudah melewati batas waktu!
                <a href="{{ route('budget.payment.index') }}" class="alert-link text-danger">Lihat detail</a>
            </div>
        </div>
    @endif

    <!-- Category Progress -->
    <div class="card adminuiux-card shadow-sm mb-4">
        <div class="card-header bg-transparent border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Kategori Anggaran</h5>
                <a href="{{ route('budget.category.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil-square me-1"></i> Kelola Kategori
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @forelse($categories as $cat)
                <div class="p-3 p-md-4 border-bottom">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge" style="background-color: {{ $cat['colour'] }}; color: #fff; border: none;">
                                {{ $cat['name'] }}
                            </span>
                            @if($cat['is_over_budget'])
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                    <i class="bi bi-exclamation-circle me-1"></i> Over Budget
                                </span>
                            @endif
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">{{ number_format($cat['spent'], 0, ',', '.') }} /
                                {{ number_format($cat['allocated'], 0, ',', '.') }}
                            </div>
                            <small class="text-muted">
                                {{ $cat['remaining'] > 0 ? 'Tersisa ' . number_format($cat['remaining'], 0, ',', '.') : 'Over ' . number_format(abs($cat['remaining']), 0, ',', '.') }}
                            </small>
                        </div>
                    </div>
                    <div class="progress-budget">
                        <div class="track"
                            style="width: {{ min(100, $cat['usage_percent']) }}%; background: {{ $cat['colour'] }};"></div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center">
                    <div class="empty-icon"><i class="bi bi-emoji-frown"></i></div>
                    <p class="text-muted mb-0">Belum ada kategori anggaran.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <a href="{{ route('budget.category.index') }}" class="text-decoration-none">
                <div class="card adminuiux-card shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon-box bg-primary-subtle text-primary mx-auto">
                            <i class="bi bi-tag-fill"></i>
                        </div>
                        <h6 class="fw-bold mt-2 mb-0">Kelola Kategori</h6>
                        <small class="text-muted">Alokasikan anggaran per kategori</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('budget.expense.index') }}" class="text-decoration-none">
                <div class="card adminuiux-card shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon-box bg-warning-subtle text-warning mx-auto">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <h6 class="fw-bold mt-2 mb-0">Catat Pengeluaran</h6>
                        <small class="text-muted">Rekam setiap pengeluaran</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('budget.payment.index') }}" class="text-decoration-none">
                <div class="card adminuiux-card shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon-box bg-info-subtle text-info mx-auto">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h6 class="fw-bold mt-2 mb-0">Jadwalkan Pembayaran</h6>
                        <small class="text-muted">Atur jadwal bayar vendor</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formatted = document.getElementById('total_amount');
            if (formatted) {
                formatted.addEventListener('input', function () {
                    let value = this.value.replace(/\D/g, '');
                    if (value) {
                        this.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(parseInt(value, 10));
                    } else {
                        this.value = ''; // Kosongkan jika tidak ada angka
                    }
                });

                formatted.addEventListener('blur', function () {
                    let value = this.value.replace(/[^\d]/g, '');
                    if (value) {
                        this.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(parseInt(value, 10));
                    }
                });

                const budgetForm = formatted.closest('form');
                if (budgetForm) {
                    budgetForm.addEventListener('submit', function () {
                        let raw = formatted.value.replace(/[^\d]/g, '');
                        formatted.value = raw || '0'; // Pastikan mengirim angka murni
                    });
                }
            }
        });
    </script>
</x-app-layout>