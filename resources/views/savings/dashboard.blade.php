<x-app-layout>
    <style>
        h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--bs-body-color);
        }

        .stat-icon-box, .quick-link-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .goal-card {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .goal-card:hover {
            transform: translateY(-3px);
        }

        .progress-ring {
            height: 10px;
            border-radius: 10px;
            overflow: hidden;
            background: var(--bs-tertiary-bg);
        }

        .progress-ring .fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--bs-tertiary-bg);
            color: var(--bs-secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1rem;
        }

        .fab-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(198, 169, 98, 0.4);
            z-index: 1040;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        @media (max-width: 576px) {
            .fab-btn {
                bottom: 80px; /* Agar tidak tertabrak bottom nav mobile */
                right: 20px;
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
            }
        }

        .contrib-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 0.7rem;
            padding: 0.3rem 0.6rem;
            border-radius: 8px;
        }

        .action-btn-circle {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 50% !important;
        }

        /* SLIDER STYLES (Stat & Quick Links) */
        .stat-slider, .quick-links-slider {
            width: 100%;
        }

        .stat-slider-track, .quick-links-track {
            display: flex;
            gap: 16px;
        }

        /* MOBILE SLIDER */
        @media (max-width: 767.98px) {
            .stat-slider, .quick-links-slider {
                overflow-x: auto;
                overflow-y: hidden;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                padding-bottom: 8px; /* Mencegah card terpotot */
            }

            .stat-slider::-webkit-scrollbar, .quick-links-slider::-webkit-scrollbar {
                display: none;
            }

            .stat-slider-track, .quick-links-track {
                width: max-content;
                flex-wrap: nowrap;
            }

            .stat-slide, .quick-link-item {
                width: 85vw; /* Lebih kecil agar next card terlihat (peek) */
                max-width: 320px;
                flex: 0 0 85vw;
                scroll-snap-align: start;
            }
        }

        /* TABLET & DESKTOP GRID */
        @media (min-width: 768px) {
            .stat-slider-track, .quick-links-track {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 20px;
            }

            .stat-slide, .quick-link-item {
                min-width: 0;
                width: 100%;
            }
        }
    </style>

    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Tabungan NIKAH</h4>
            <p class="text-muted mb-0">Kelola target tabungan dan kontribusi bersama pasangan</p>
            @if($partner)
                <div class="d-flex align-items-center gap-2 mt-3">
                    <figure class="avatar avatar-24 rounded-circle coverimg mb-0" style="background-image: url('{{ $partner->avatar ? asset('storage/' . $partner->avatar) : asset('assets/fav.png') }}');">
                        <img src="{{ $partner->avatar ? asset('storage/' . $partner->avatar) : asset('assets/fav.png') }}" alt="Avatar" style="display: none;">
                    </figure>
                    <span class="small text-muted">Bersama <strong>{{ $partner->name }}</strong> ({{ $partner->email }})</span>
                </div>
            @endif
        </div>
        <a href="{{ route('savings.goal.index') }}" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0">
            <i class="bi bi-list-ul me-1"></i> Lihat Semua Target
        </a>
    </div>

    <!-- Stat Cards Slider -->
    <div class="stat-slider mb-4">
        <div class="stat-slider-track">

            <div class="stat-slide">
                <div class="card adminuiux-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon-box bg-success-subtle text-success">
                            <i class="bi bi-piggy-bank"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">Rp {{ number_format($totalSaved, 0, ',', '.') }}</div>
                            <div class="text-muted small">Total Tertabung</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stat-slide">
                <div class="card adminuiux-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon-box bg-primary-subtle text-primary">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">Rp {{ number_format($totalTarget, 0, ',', '.') }}</div>
                            <div class="text-muted small">Total Target</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stat-slide">
                <div class="card adminuiux-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon-box bg-info-subtle text-info">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $overallProgress }}%</div>
                            <div class="text-muted small">Progres Keseluruhan</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stat-slide">
                <div class="card adminuiux-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon-box bg-warning-subtle text-warning">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">
                                {{ $nextAuto ? 'Rp ' . number_format($nextAuto['amount'], 0, ',', '.') : '-' }}
                            </div>
                            <div class="text-muted small">
                                @if($nextAuto)
                                    Next: {{ \Carbon\Carbon::parse($nextAuto['date'])->format('d M Y') }}
                                @else
                                    Tidak ada otomatis
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Goal Cards Grid -->
    <h5 class="fw-bold mb-3 mt-4">Target Tabungan</h5>
    <div class="row g-3 mb-4">
        @forelse($goals as $goal)
            @php $progress = $goal->progressPercent(); @endphp
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card adminuiux-card goal-card shadow-sm position-relative h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="pe-4"> <!-- Padding kanan agar tidak menabrak badge -->
                                <h6 class="fw-bold mb-0">{{ $goal->name }}</h6>
                                @if($goal->deadline)
                                    <small class="text-muted mt-1 d-block">
                                        <i class="bi bi-calendar me-1"></i>{{ $goal->deadline->format('d M Y') }}
                                        @if($goal->daysRemaining() < 0)
                                            <span class="text-danger">(Lewat {{ abs($goal->daysRemaining()) }} hari)</span>
                                        @endif
                                    </small>
                                @endif
                            </div>
                            <span class="badge align-items-center py-2 px-2"
                                style="background-color: {{ $goal->colour }}; color: #fff; border: none; font-size: 0.75rem;">
                                {{ $goal->currency == 'IDR' ? 'Rp ' : $goal->currency . ' ' }}{{ number_format($goal->target_amount, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Rp {{ number_format($goal->totalSaved(), 0, ',', '.') }}</small>
                                <small class="fw-bold" style="color: {{ $goal->colour }};">{{ $progress }}%</small>
                            </div>
                            <div class="progress-ring">
                                <div class="fill"
                                    style="width: {{ min(100, $progress) }}%; background: {{ $goal->colour }};"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                @if($goal->dailyRequired() > 0)
                                    Butuh <strong>Rp {{ number_format($goal->dailyRequired(), 0, ',', '.') }}</strong>/hari
                                @else
                                    🎉 Tercapai!
                                @endif
                            </small>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-success action-btn-circle" 
                                    title="Tambah Setoran" data-bs-toggle="modal" data-bs-target="#contributeModal"
                                    data-goal-id="{{ $goal->id }}" data-goal-name="{{ $goal->name }}">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                                <a href="{{ route('savings.goal.edit', $goal) }}"
                                    class="btn btn-sm btn-outline-secondary action-btn-circle" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($contributors->count() > 1)
                        <span class="contrib-badge bg-light text-dark border">
                            <i class="bi bi-people me-1"></i>{{ $contributors->count() }} mitra
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="empty-icon"><i class="bi bi-pig"></i></div>
                <p class="text-muted mb-0">Belum ada target tabungan.<br>Klik tombol + untuk membuat target pertama.</p>
            </div>
        @endforelse
    </div>

    <!-- Quick Links Slider -->
    <div class="quick-links-slider mb-5">
        <div class="quick-links-track">

            <!-- Ledger -->
            <div class="quick-link-item">
                <a href="{{ route('savings.contribution.index') }}" class="text-decoration-none">
                    <div class="card adminuiux-card shadow-sm h-100">
                        <div class="card-body d-flex align-items-center gap-3 p-3">
                            <div class="quick-link-icon bg-primary-subtle text-primary">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1 text-body">Ledger Setoran</h6>
                                <small class="text-muted">Riwayat semua kontribusi</small>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Proyeksi -->
            <div class="quick-link-item">
                <a href="{{ route('savings.projection') }}" class="text-decoration-none">
                    <div class="card adminuiux-card shadow-sm h-100">
                        <div class="card-body d-flex align-items-center gap-3 p-3">
                            <div class="quick-link-icon bg-info-subtle text-info">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1 text-body">Proyeksi</h6>
                                <small class="text-muted">Hitung tabungan harian</small>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Automasi -->
            <div class="quick-link-item">
                <a href="{{ route('savings.automation.index') }}" class="text-decoration-none">
                    <div class="card adminuiux-card shadow-sm h-100">
                        <div class="card-body d-flex align-items-center gap-3 p-3">
                            <div class="quick-link-icon bg-warning-subtle text-warning">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1 text-body">Automasi</h6>
                                <small class="text-muted">Atur tabungan rutin</small>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- Floating Action Button -->
    <button type="button" class="btn btn-primary fab-btn" data-bs-toggle="modal" data-bs-target="#contributeModal">
        <i class="bi bi-plus-lg"></i>
    </button>

    <!-- Contribution Modal -->
    <div class="modal fade" id="contributeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <form method="POST" action="{{ route('savings.contribution.store') }}">
                    @csrf
                    <input type="hidden" name="goal_id_for_select" id="goal_id_for_select">
                    <div class="modal-header bg-body-tertiary border-bottom">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="bi bi-pig-coin me-2"></i> Tambah Setoran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="savings_goal_id" class="form-label small fw-bold">Target Tabungan *</label>
                            <select name="savings_goal_id" id="savings_goal_id" class="form-select" required>
                                <option value="">Pilih Target</option>
                                @foreach($goals as $g)
                                    <option value="{{ $g->id }}">{{ $g->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="savings_contributor_id" class="form-label small fw-bold">Nama Kontributor *</label>
                            <select name="savings_contributor_id" id="savings_contributor_id" class="form-select" required>
                                @foreach($contributors as $c)
                                    <option value="{{ $c->id }}" {{ $c->id == $user->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label small fw-bold">Jumlah Setoran *</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="amount" id="amount" class="form-control text-end" required min="1" step="1000" placeholder="0">
                            </div>
                        </div>
                        <div class="mb-0">
                            <label for="method" class="form-label small fw-bold">Metode Pembayaran</label>
                            <select name="method" id="method" class="form-select">
                                <option value="transfer">Transfer Bank</option>
                                <option value="e-wallet">E-Wallet</option>
                                <option value="cash">Tunai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Setoran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('contributeModal').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return; // Cegah error jika modal dipanggil tanpa trigger (misal via FAB)

            const goalId = button.getAttribute('data-goal-id');
            const goalName = button.getAttribute('data-goal-name');

            const goalSelect = document.getElementById('savings_goal_id');
            if (goalId && goalSelect) {
                goalSelect.value = goalId;
            }
            document.getElementById('goal_id_for_select').value = goalId || '';
        });
    </script>
</x-app-layout>