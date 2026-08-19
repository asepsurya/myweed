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

                </div>

            </div>
        </div>
    </div>
</x-app-layout>