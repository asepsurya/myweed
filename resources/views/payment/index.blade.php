<x-app-layout>
 <div class="card adminuiux-card">
    <div class="card-header">
        <div class="row g-2 align-items-center">

            <div class="col">
                <h6 class="mb-1">Aktivitas Transaksi</h6>
            </div>

            {{-- FILTER STATUS --}}
            <div class="col-auto">
                <select id="filterStatus" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
            </div>

            {{-- SEARCH --}}
            <div class="col-auto">
                <input type="text" id="searchOrder" class="form-control" placeholder="Cari Order ID">
            </div>

        </div>
    </div>

    <ul class="list-group list-group-flush">

        @forelse($payments as $payment)
        <li class="list-group-item transaction-item"
            data-status="{{ $payment->status }}"
            data-order="{{ strtolower($payment->order_id) }}">

            <div class="row align-items-center gx-3">

                <div class="col">
                    <p class="mb-1 fw-medium">
                        Order ID: <b>{{ $payment->order_id }}</b>
                    </p>
                    <p class="text-secondary small mb-0">
                        Paket: {{ $payment->subscriptionPlan->name ?? '-' }} |
                        {{ $payment->created_at->format('d M Y H:i') }}
                    </p>
                </div>

                <div class="col-auto">

                           Rp {{ number_format($payment->amount, 0, ',', '.') }}

                </div>
                <div class="col-auto">
                    <span class="badge
                        @if($payment->status==='paid') bg-success
                        @elseif($payment->status==='pending') bg-warning
                        @else bg-danger @endif
                    ">
                        {{ strtoupper($payment->status) }}
                    </span>
                </div>

                <div class="col-auto d-flex gap-2">
                    <a href=""
                       class="avatar avatar-40 rounded-circle border">
                        <i class="bi bi-eye"></i>
                    </a>

                    @if($payment->status === 'paid')
                    <a href=""
                       class="avatar avatar-40 rounded-circle border">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </a>
                    @endif
                </div>

            </div>
        </li>
        @empty
        <li class="list-group-item text-center text-muted">
            Belum ada transaksi
        </li>
        @endforelse

    </ul>
</div>
<script>
const statusFilter = document.getElementById('filterStatus');
const searchInput = document.getElementById('searchOrder');

function filterTransaction() {
    const status = statusFilter.value;
    const search = searchInput.value.toLowerCase();

    document.querySelectorAll('.transaction-item').forEach(item => {
        const matchStatus = !status || item.dataset.status === status;
        const matchSearch = item.dataset.order.includes(search);

        item.style.display = (matchStatus && matchSearch) ? '' : 'none';
    });
}

statusFilter.addEventListener('change', filterTransaction);
searchInput.addEventListener('keyup', filterTransaction);
</script>

</x-app-layout>

