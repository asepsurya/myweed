<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm text-center" style="border-radius: 1rem;">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <div class="avatar avatar-80 rounded-circle bg-success-subtle text-success mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2.5rem;">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>

                        <h3 class="fw-bold mb-3" style="color: var(--navy);">Undangan Sudah Diterima</h3>

                        <p class="text-muted mb-4">
                            Undangan pasangan ini telah Anda terima sebelumnya. Anda sudah dapat mengakses undangan ini dan berkolaborasi dengan pasangan Anda.
                        </p>

                        @if($invitation)
                            <div class="card bg-light border-0 mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-1">{{ $invitation->groom_nickname ?? $invitation->groom_name }} & {{ $invitation->bride_nickname ?? $invitation->bride_name }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $invitation->wedding_date ? \Carbon\Carbon::parse($invitation->wedding_date)->format('d M Y') : 'Tanggal belum ditentukan' }}
                                    </small>
                                    <div class="mt-2">
                                        @if($invitation->partner_can_edit)
                                            <span class="badge bg-success-subtle text-success">Akses: Bisa Mengedit</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning">Akses: Hanya Melihat</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            <a href="{{ route('dashboard.user') }}" class="btn btn-gold">
                                <i class="bi bi-grid-1x2-fill me-2"></i> Ke Dashboard
                            </a>
                            @if($invitation)
                                <a href="{{ route('invitation.show', $invitation->slug) }}" class="btn btn-outline-navy" target="_blank">
                                    <i class="bi bi-eye me-2"></i> Lihat Undangan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
