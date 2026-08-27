<x-app-layout>
    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div class="">

                {{-- HEADER --}}
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div>
                        <h4 class="fw-bold mb-1">Status Pembayaran</h4>
                        <p class="text-muted mb-0">Ringkasan pembayaran langganan kamu</p>
                    </div>
                    <a href="{{ route('subscribe.page') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Berlangganan
                    </a>
                </div>

                {{-- SUMMARY CARDS --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Total Transaksi</p>
                                <h3 class="fw-bold mb-0">{{ $payments->count() }}</h3>
                                <p class="text-muted small mb-0 mt-2">Rp
                                    {{ number_format($payments->sum('amount'), 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Sudah Bayar</p>
                                <h3 class="fw-bold text-success mb-0">{{ $paidPayments->count() }}</h3>
                                <p class="text-muted small mb-0 mt-2">Rp {{ number_format($totalPaid, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                            <div class="card-body">
                                <p class="text-muted small mb-1">Belum Bayar</p>
                                <h3 class="fw-bold text-warning mb-0">{{ $unpaidPayments->count() }}</h3>
                                <p class="text-muted small mb-0 mt-2">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABS --}}
                <ul class="nav nav-pills mb-3 gap-2" id="paymentStatusTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="paid-tab" data-bs-toggle="pill" data-bs-target="#paid"
                            type="button" role="tab" aria-controls="paid" aria-selected="true">
                            <i class="bi bi-check-circle me-1"></i> Sudah Bayar
                            <span class="badge bg-success ms-1">{{ $paidPayments->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="unpaid-tab" data-bs-toggle="pill" data-bs-target="#unpaid"
                            type="button" role="tab" aria-controls="unpaid" aria-selected="false">
                            <i class="bi bi-clock-history me-1"></i> Belum Bayar
                            <span class="badge bg-warning text-dark ms-1">{{ $unpaidPayments->count() }}</span>
                        </button>
                    </li>
                    @if($canApprove && $pendingLocalPayments->count() > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="local-tab" data-bs-toggle="pill" data-bs-target="#local"
                                type="button" role="tab" aria-controls="local" aria-selected="false">
                                <i class="bi bi-qr-code me-1"></i> Perlu Verifikasi
                                <span class="badge bg-info ms-1">{{ $pendingLocalPayments->count() }}</span>
                            </button>
                        </li>
                    @endif
                </ul>

                <div class="tab-content" id="paymentStatusTabContent">

                    {{-- PAID TAB --}}
                    <div class="tab-pane fade show active" id="paid" role="tabpanel" aria-labelledby="paid-tab">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                @if($paidPayments->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Paket</th>
                                                    <th>Tanggal</th>
                                                    <th class="text-end">Jumlah</th>
                                                    <th class="text-center">Status</th>
                                                    <th>Metode</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($paidPayments as $payment)
                                                    <tr>
                                                        <td><span class="fw-semibold">{{ $payment->order_id }}</span></td>
                                                        <td>{{ $payment->subscriptionPlan->name ?? '-' }}</td>
                                                        <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                                        <td class="text-end">Rp
                                                            {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                                        <td class="text-center">
                                                            <span class="badge bg-success">PAID</span>
                                                        </td>
                                                        <td>{{ $payment->paymentMethodLabel() }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('payment.invoice', ['order_id' => $payment->order_id]) }}"
                                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                                <i class="bi bi-printer"></i> Invoice
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                        <p class="text-muted mb-0">Belum ada pembayaran yang berhasil</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- UNPAID TAB --}}
                    <div class="tab-pane fade" id="unpaid" role="tabpanel" aria-labelledby="unpaid-tab">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                @if($unpaidPayments->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Paket</th>
                                                    <th>Tanggal</th>
                                                    <th class="text-end">Jumlah</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($unpaidPayments as $payment)
                                                    <tr>
                                                        <td><span class="fw-semibold">{{ $payment->order_id }}</span></td>
                                                        <td>{{ $payment->subscriptionPlan->name ?? '-' }}</td>
                                                        <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                                        <td class="text-end">Rp
                                                            {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                                        <td class="text-center">
                                                            @if($payment->status === 'pending')
                                                                <span class="badge bg-warning text-dark">PENDING</span>
                                                            @else
                                                                <span class="badge bg-danger">FAILED</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('payment.invoice', ['order_id' => $payment->order_id]) }}"
                                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                                <i class="bi bi-printer"></i> Invoice
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="bi bi-check-circle fs-1 text-success d-block mb-2"></i>
                                        <p class="text-muted mb-0">Semua pembayaran sudah lunas</p>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>

                    {{-- LOCAL VERIFICATION TAB (ADMIN ONLY) --}}
                    @if($canApprove)
                    <div class="tab-pane fade" id="local" role="tabpanel" aria-labelledby="local-tab">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                @if($pendingLocalPayments->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Pengguna</th>
                                                    <th>Paket</th>
                                                    <th>Tanggal</th>
                                                    <th class="text-end">Jumlah</th>
                                                    <th class="text-center">Bukti</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pendingLocalPayments as $payment)
                                                    <tr>
                                                        <td><span class="fw-semibold">{{ $payment->order_id }}</span></td>
                                                        <td>{{ $payment->user->name ?? '-' }}<br>
                                                            <small class="text-muted">{{ $payment->user->email ?? '-' }}</small>
                                                        </td>
                                                        <td>{{ $payment->subscriptionPlan->name ?? '-' }}</td>
                                                        <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                                        <td class="text-end">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                                        <td class="text-center">
                                                            @if($payment->proof_image)
                                                                <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="d-inline-block">
                                                                    <img src="{{ asset('storage/' . $payment->proof_image) }}" alt="Bukti"
                                                                        style="max-width: 80px; max-height: 80px; object-fit: cover; border-radius: 0.375rem; border: 1px solid #e0e0e0;">
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bi bi-gear"></i> Aksi
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <form action="{{ route('payment.local.approve', $payment->order_id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="paid">
                                                                        <button type="submit" class="dropdown-item text-success"
                                                                            onclick="return confirm('Setujui pembayaran ini? Langganan pengguna akan langsung diaktifkan.')">
                                                                            <i class="bi bi-check-lg"></i> Setujui
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('payment.local.approve', $payment->order_id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="failed">
                                                                        <button type="submit" class="dropdown-item text-danger"
                                                                            onclick="return confirm('Tolak pembayaran ini?')">
                                                                            <i class="bi bi-x-lg"></i> Tolak
                                                                        </button>
                                                                    </form>
                                                                    <li><a class="dropdown-item" href="{{ route('payment.invoice', ['order_id' => $payment->order_id]) }}" target="_blank">
                                                                        <i class="bi bi-eye"></i> Lihat Invoice
                                                                    </a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="bi bi-check-circle fs-1 text-success d-block mb-2"></i>
                                        <p class="text-muted mb-0">Tidak ada pembayaran lokal yang butuh verifikasi.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</x-app-layout>