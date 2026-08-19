@auth
<div class="adminuiux-sidebar">
    <div class="adminuiux-sidebar-inner">
        <!-- Profile -->
        <div class="px-3 not-iconic mt-3">
            <div class="row">
                <div class="col align-self-center">
                    <h6 class="fw-medium">Menu Saya</h6>
                </div>
                <div class="col-auto">
                    <a class="btn btn-link btn-square" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile"
                        aria-expanded="false" role="button" aria-controls="usersidebarprofile">
                        <i data-feather="user"></i>
                    </a>
                </div>
            </div>
            <div class="text-center collapse" id="usersidebarprofile">
                <figure class="avatar avatar-100 rounded-circle coverimg my-3">
                    <img src="{{ asset('assets/fav.png') }}" alt="Logo RuangUndang.id">
                </figure>
                <h5 class="mb-1 fw-medium">RuangUndang.id</h5>
                <p class="small text-muted">Make your moment unforgettable</p>
            </div>
        </div>

        <ul class="nav flex-column menu-active-line">
            @role('admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Dashboard">
                    <i class="menu-icon bi bi-columns-gap me-2"></i>
                    <span class="menu-name">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('invitation.index') ? 'active' : '' }}"
                    href="{{ route('invitation.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Daftar Pasangan">
                    <i class="menu-icon bi bi-gem me-2"></i>
                    <span class="menu-name">Daftar Pasangan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('music.index') ? 'active' : '' }}"
                    href="{{ route('music.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Music Library">
                    <i class="menu-icon bi bi-music-note-list me-2"></i>
                    <span class="menu-name">Music Library</span>
                </a>
            </li>
            @endrole

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard.user') ? 'active' : '' }}"
                    href="{{ route('dashboard.user') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Pasangan Saya">
                    <i class="menu-icon bi bi-heart me-2"></i>
                    <span class="menu-name">Pasangan Saya</span>
                </a>
            </li>

            @if(auth()->user()->hasFeature('budget_management'))
            <?php 
                $isWeddingPlannerActive = request()->routeIs(['weeding-plan.*', 'budget.*', 'savings.*', 'financial-overview.*']);
                $isBudgetActive = request()->routeIs('budget.*');
                $isSavingsActive = request()->routeIs('savings.*');
            ?>
            <li class="nav-item">
                <a href="{{ route('weeding-plan.index') }}" class="nav-link " data-bs-toggle="collapse" data-bs-target="#financeMenu"
                    aria-expanded="{{ $isWeddingPlannerActive ? 'true' : 'false' }}" aria-controls="financeMenu"
                    role="button">
                    <i class="menu-icon bi bi-folder me-2"></i>
                    <span class="menu-name">Wedding Planner</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <div class="collapse ps-3 {{ $isWeddingPlannerActive ? 'show' : '' }}" id="financeMenu">
                    <a href="{{ route('weeding-plan.index') }}"
                        class="nav-link ps-4 {{ request()->routeIs('weeding-plan.*') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-calendar-check me-2"></i>
                        <span class="menu-name">Rencana</span>
                    </a>

                    <a href="{{ route('budget.dashboard') }}" class="nav-link ps-4" data-bs-toggle="collapse" data-bs-target="#budgetMenu"
                        aria-expanded="{{ $isBudgetActive ? 'true' : 'false' }}" aria-controls="budgetMenu"
                        role="button">
                        <i class="menu-icon bi bi-calculator me-2"></i>
                        <span class="menu-name">Anggaran</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse ps-4 {{ $isBudgetActive ? 'show' : '' }}" id="budgetMenu">
                        <a href="{{ route('budget.dashboard') }}"
                            class="nav-link ps-3 {{ request()->routeIs('budget.dashboard') ? 'active' : '' }}">
                            <span class="menu-name">Ringkasan</span>
                        </a>
                        <a href="{{ route('budget.category.index') }}"
                            class="nav-link ps-3 {{ request()->routeIs('budget.category.*') ? 'active' : '' }}">
                            <span class="menu-name">Kategori</span>
                        </a>
                        <a href="{{ route('budget.expense.index') }}"
                            class="nav-link ps-3 {{ request()->routeIs('budget.expense.*') ? 'active' : '' }}">
                            <span class="menu-name">Pengeluaran</span>
                        </a>
                        <a href="{{ route('budget.payment.index') }}"
                            class="nav-link ps-3 {{ request()->routeIs('budget.payment.*') ? 'active' : '' }}">
                            <span class="menu-name">Pembayaran</span>
                        </a>
                    </div>

                    <a href="{{ route('savings.dashboard') }}" class="nav-link ps-4" data-bs-toggle="collapse" data-bs-target="#savingsMenu"
                        aria-expanded="{{ $isSavingsActive ? 'true' : 'false' }}" aria-controls="savingsMenu"
                        role="button">
                        <i class="menu-icon bi bi-piggy-bank me-2"></i>
                        <span class="menu-name">Tabungan</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse ps-4 {{ $isSavingsActive ? 'show' : '' }}" id="savingsMenu">
                        <a href="{{ route('savings.dashboard') }}"
                            class="nav-link ps-3 {{ request()->routeIs('savings.dashboard') ? 'active' : '' }}">
                            <span class="menu-name">Ringkasan</span>
                        </a>
                        <a href="{{ route('savings.goal.index') }}"
                            class="nav-link ps-3 {{ request()->routeIs('savings.goal.*') ? 'active' : '' }}">
                            <span class="menu-name">Target Tabungan</span>
                        </a>
                        <a href="{{ route('savings.contributor.index') }}"
                            class="nav-link ps-3 {{ request()->routeIs('savings.contributor.*') ? 'active' : '' }}">
                            <span class="menu-name">Kontributor</span>
                        </a>
                        <a href="{{ route('savings.contribution.index') }}"
                            class="nav-link ps-3 {{ request()->routeIs('savings.contribution.*') ? 'active' : '' }}">
                            <span class="menu-name">Ledger Setoran</span>
                        </a>
                        <a href="{{ route('savings.projection') }}"
                            class="nav-link ps-3 {{ request()->routeIs('savings.projection') ? 'active' : '' }}">
                            <span class="menu-name">Proyeksi</span>
                        </a>
                        <a href="{{ route('savings.automation.index') }}"
                            class="nav-link ps-3 {{ request()->routeIs('savings.automation.*') ? 'active' : '' }}">
                            <span class="menu-name">Otomatisasi</span>
                        </a>
                    </div>

                    <a href="{{ route('financial-overview.index') }}"
                        class="nav-link ps-4 {{ request()->routeIs('financial-overview.*') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-bar-chart-line me-2"></i>
                        <span class="menu-name">Ikhtisar Keuangan</span>
                    </a>
                </div>
            </li>
            @endif

            @php
                $isPaymentActive = request()->routeIs(['payments.status', 'payments.index']);
            @endphp
            <li class="nav-item">
                <a class="nav-link " data-bs-toggle="collapse" data-bs-target="#paymentMenu"
                    aria-expanded="{{ $isPaymentActive ? 'true' : 'false' }}" aria-controls="paymentMenu"
                    role="button">
                    <i class="menu-icon bi bi-credit-card me-2"></i>
                    <span class="menu-name">Pembayaran</span>
                    @if(isset($pendingPaymentCount) && $pendingPaymentCount > 0)
                        <span class="badge bg-warning text-dark ms-auto">{{ $pendingPaymentCount }}</span>
                    @endif
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <div class="collapse ps-3 {{ $isPaymentActive ? 'show' : '' }}" id="paymentMenu">
                    <a href="{{ route('payments.status') }}"
                        class="nav-link ps-4 {{ request()->routeIs('payments.status') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-check-circle me-2"></i>
                        <span class="menu-name">Status Pembayaran</span>
                    </a>
                    <a href="{{ route('payments.index') }}"
                        class="nav-link ps-4 {{ request()->routeIs('payments.index') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-list-ul me-2"></i>
                        <span class="menu-name">Riwayat Transaksi</span>
                    </a>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('rsvp.index') ? 'active' : '' }}"
                    href="{{ route('rsvp.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Ucapan & Doa">
                    <i class="menu-icon bi bi-clipboard-check me-2"></i>
                    <span class="menu-name">Ucapan & Doa</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('documentation.index') ? 'active' : '' }}"
                    href="{{ route('documentation.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Dokumentasi">
                    <i class="menu-icon bi bi-book me-2"></i>
                    <span class="menu-name">Dokumentasi</span>
                </a>
            </li>

            @role('admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('subscription-plans.index') ? 'active' : '' }}"
                    href="{{ route('subscription-plans.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Paket & Harga">
                    <i class="menu-icon bi bi-tags me-2"></i>
                    <span class="menu-name">Paket & Harga</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('coupons.index') ? 'active' : '' }}"
                    href="{{ route('coupons.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Kupon Promo">
                    <i class="menu-icon bi bi-ticket-perforated me-2"></i>
                    <span class="menu-name">Kupon Promo</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('promotions.index') ? 'active' : '' }}"
                    href="{{ route('promotions.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Promosi">
                    <i class="menu-icon bi bi-megaphone me-2"></i>
                    <span class="menu-name">Promosi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}"
                    href="{{ route('user.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Daftar Pengguna">
                    <i class="menu-icon bi bi-people me-2"></i>
                    <span class="menu-name">Daftar Pengguna</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings.env') ? 'active' : '' }}"
                    href="{{ route('settings.env') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Pengaturan .env">
                    <i class="menu-icon bi bi-sliders me-2"></i>
                    <span class="menu-name">Pengaturan .env</span>
                </a>
            </li>
            @endrole
        </ul>
    </div>
</div>
@endauth

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi Tooltip Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Inisialisasi Feather Icons (jika digunakan)
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endpush