<x-app-layout>
    <div class="container-fluid py-3 py-md-4">
        {{-- Header Profil --}}
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pengaturan Akun & Profil</h4>
                <p class="text-muted small mb-0">Kelola identitas, alamat email, dan keamanan akun RuangUndang Anda</p>
            </div>
        </div>

        {{-- Flash Status Message --}}
        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div>Profil Anda berhasil diperbarui.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div>Kata sandi Anda berhasil diperbarui.</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Kartu 1: Informasi Profil --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 rounded-4 shadow-sm h-100" style="background-color: var(--bs-card-bg, #FFFFFF);">
                    <div class="card-header bg-transparent py-3 px-4 border-bottom d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 text-white"
                             style="width: 36px; height: 36px; background: linear-gradient(135deg, #C6A962, #A68B4B);">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <h5 class="mb-0 fw-bold fs-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">Informasi Akun</h5>
                    </div>
                    <div class="card-body p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Kartu 2: Keamanan Kata Sandi --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 rounded-4 shadow-sm h-100" style="background-color: var(--bs-card-bg, #FFFFFF);">
                    <div class="card-header bg-transparent py-3 px-4 border-bottom d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 text-white"
                             style="width: 36px; height: 36px; background: linear-gradient(135deg, #1B2A4A, #243B68);">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h5 class="mb-0 fw-bold fs-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">Perbarui Kata Sandi</h5>
                    </div>
                    <div class="card-body p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Kartu 3: Hapus Akun (Khusus Admin) --}}
            @role('admin')
            <div class="col-12">
                <div class="card border-danger border-opacity-25 rounded-4 shadow-sm" style="background-color: var(--bs-card-bg, #FFFFFF);">
                    <div class="card-header bg-danger-subtle text-danger py-3 px-4 border-bottom d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <h5 class="mb-0 fw-bold fs-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">Zona Bahaya</h5>
                    </div>
                    <div class="card-body p-4">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
            @endrole
        </div>
    </div>
</x-app-layout>