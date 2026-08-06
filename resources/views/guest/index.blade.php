<x-app-layout>
    @php
        $firstInvitation = $invitations->first();
        $themeColor = $firstInvitation->theme_color ?? '#FF6B81';
    @endphp

    <style>
        :root {
            --mobile-nav-active-color:
                {{ $themeColor }}
            ;
        }

        @media (max-width: 767.98px) {
            .list-group-item {
                padding: 14px 16px !important;
            }

            .list-group-item .dropdown-toggle {
                width: 44px;
                height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
            }

            .list-group-item .dropdown-toggle svg,
            .list-group-item .dropdown-toggle i {
                font-size: 1.2rem;
            }

            .list-group-item .btn {
                padding: 10px 14px;
                font-size: 0.9rem;
            }

            .list-group-item .d-md-flex.gap-2 .btn {
                width: 44px;
                height: 44px;
                padding: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        }

        @media (max-width: 575.98px) {
            .list-group-item {
                padding: 12px 14px !important;
            }

            .list-group-item .dropdown-toggle {
                width: 48px;
                height: 48px;
            }

            .list-group-item .d-md-flex.gap-2 .btn {
                width: 48px;
                height: 48px;
            }
        }

        .list-group-item {
            padding: 14px 16px !important;
        }

        .list-group-item .dropdown-toggle {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .list-group-item .dropdown-toggle svg,
        .list-group-item .dropdown-toggle i {
            font-size: 1.2rem;
        }

        .btn-sm {
            padding: 10px 14px;
            font-size: 0.9rem;
        }

        @media (max-width: 767.98px) {
            .w-md-100 {
                width: 100% !important;
            }
        }

        @media (max-width: 575.98px) {
            .list-group-item .dropdown-toggle {
                width: 48px;
                height: 48px;
            }
        }
    </style>

    <!-- TAB 1: Aktivitas Undangan -->
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <div class="py-10">
            <div class="container-fluid">

                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div>
                        <h4 class="mb-0">Aktivitas Undangan Terbaru</h4>
                        @php $status = auth()->user()->subscriptionStatus(); @endphp
                        @if($status == 'active')
                            <span class="badge bg-warning text-dark small mt-1">
                                <i class="bi bi-star-fill me-1"></i> Premium
                                @if(auth()->user()->isAdmin())
                                    (Admin Access)
                                @elseif(auth()->user()->subscription)
                                    (Aktif s/d: {{ auth()->user()->subscription->end_date->format('d M Y') }})
                                @endif
                            </span>
                        @else
                            <span class="badge bg-light text-dark border small mt-1">Free Plan (Limit 1 Undangan)</span>
                        @endif
                    </div>

                    <!-- Container tombol -->
                    <div class="w-md-100 d-flex justify-content-md-end">
                        @php
                            $user = auth()->user();
                            $canCreateMore = $user->isAdmin() || $user->isSubscribed() || $user->invitations->count() < 1;
                        @endphp

                        @if($canCreateMore)
                            <button type="button" class="btn btn-sm btn-outline-primary w-md-auto" data-bs-toggle="modal"
                                data-bs-target="#newInvitationModal">
                                <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                            </button>
                        @else
                            <button type="button" class="btn btn-sm btn-warning w-md-auto" data-bs-toggle="modal"
                                data-bs-target="#upgradeModal">
                                <i class="bi bi-star me-1"></i> Upgrade ke Premium
                            </button>
                        @endif
                    </div>
                </div>

                <form id="bulkDeleteForm" action="{{ route('invitation.bulk-delete') }}" method="POST">
                    @csrf

                    {{-- Pilihan Select All (Tampilkan jika ada data) --}}
                    @if($invitations->isNotEmpty())
                        <div class="mb-2 px-3 py-2 rounded d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label small fw-bold" for="selectAll">Pilih Semua</label>
                            </div>
                        </div>
                    @endif

                    <ul class="list-group">
                        @forelse ($invitations as $inv)
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">

                                                {{-- Info Kiri (Nama Pengantin) --}}
                                                <div class="d-flex align-items-center gap-3">



                                                    {{-- Checkbox --}}
                                                    <input type="checkbox" name="ids[]" value="{{ $inv->id }}"
                                                        class="form-check-input m-0 bulk-checkbox">
                                                    {{-- Cover --}}
                                                    @if($inv->gallery_cover)
                                                        <img src="{{ asset('storage/' . $inv->gallery_cover) }}"
                                                            class="rounded object-fit-cover flex-shrink-0" style="width: 48px; height: 48px;"
                                                            alt="Cover">
                                                    @else
                                                        <div class="rounded bg-light d-flex align-items-center justify-content-center flex-shrink-0"
                                                            style="width: 48px; height: 48px;">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    {{-- Info --}}
                                                    <div>
                                                        <h6 class="mb-0">
                                                            {{ $inv->groom_nickname ?? $inv->groom_name }}
                                                            &
                                                            {{ $inv->bride_nickname ?? $inv->bride_name }}
                                                        </h6>
                                                        <small class="text-muted">
                                                            {{ $inv->wedding_date
                            ? \Carbon\Carbon::parse($inv->wedding_date)->format('d M Y')
                            : 'Tanggal belum ditentukan' }}
                                                        </small>
                                                    </div>

                                                </div>

                                                {{-- Tombol Aksi Kanan --}}
                                                <div class="d-flex justify-content-end">

                                                    <!-- DESKTOP -->
                                                    <div class="d-none d-md-flex gap-2">
                                                        <a href="{{ route('invitation.show', $inv->slug) }}"
                                                            class="btn btn-outline-primary btn-sm" target="_blank" title="Lihat">
                                                            <i class="bi bi-eye"></i>
                                                        </a>

                                                        <a href="{{ route('invitation.edit', $inv) }}"
                                                            class="btn btn-outline-primary btn-sm" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>

                                                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#waModal{{ $inv->id }}" title="Bagikan WhatsApp">
                                                            <i class="bi bi-whatsapp"></i>
                                                        </button>

                                                        @if(!$inv->is_default)
                                                            <form action="{{ route('invitation.destroy', $inv) }}" method="POST"
                                                                class="d-inline"
                                                                onsubmit="return confirm('Hapus undangan ini? Data yang sudah dihapus tidak dapat dikembalikan.');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>

                                                    <!-- MOBILE -->
                                                    <div class="dropdown d-md-none">
                                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>

                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('invitation.show', $inv->slug) }}"
                                                                    target="_blank">
                                                                    <i class="bi bi-eye me-2"></i> Lihat
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('invitation.edit', $inv) }}">
                                                                    <i class="bi bi-pencil me-2"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-success" data-bs-toggle="modal"
                                                                    data-bs-target="#waModal{{ $inv->id }}">
                                                                    <i class="bi bi-whatsapp me-2"></i> Bagikan WhatsApp
                                                                </button>
                                                            </li>

                                                            @if(!$inv->is_default)
                                                                <li>
                                                                    <form action="{{ route('invitation.destroy', $inv) }}" method="POST"
                                                                        onsubmit="return confirm('Hapus undangan ini? Data yang sudah dihapus tidak dapat dikembalikan.');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger">
                                                                            <i class="bi bi-trash me-2"></i> Hapus
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>

                                                </div>
                                            </li>
                        @empty
                            <div class="card flex items-center justify-center min-h-[60vh] p-5">
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-gray-700">
                                        Belum ada undangan yang dibuat
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Mulai buat undangan pertamamu sekarang
                                    </p>

                                    <button type="button" class="btn btn-sm btn-outline-primary mt-3" data-bs-toggle="modal"
                                        data-bs-target="#newInvitationModal">
                                        + Buat Undangan
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </ul>
                </form>

            </div>
        </div>

        <!-- Modal: New Invitation -->
        <div class="modal fade" id="newInvitationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="quickCreateForm" action="{{ route('invitation.quick-create') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title mb-0">
                                <i class="bi bi-heart-heart me-2"></i>
                                Undangan Baru
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted small mb-3">Masukkan nama pengantin untuk memulai.</p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Mempelai Pria</label>
                                <input type="text" name="groom_name" class="form-control" placeholder="Nama lengkap"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Panggilan Pria</label>
                                <input type="text" name="groom_nickname" class="form-control"
                                    placeholder="Nama panggilan (opsional)">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Mempelai Wanita</label>
                                <input type="text" name="bride_name" class="form-control" placeholder="Nama lengkap"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Panggilan Wanita</label>
                                <input type="text" name="bride_nickname" class="form-control"
                                    placeholder="Nama panggilan (opsional)">
                            </div>

                            <div id="modal_error" class="alert alert-danger d-none"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="quickCreateBtn">
                                <i class="bi bi-plus-lg me-1"></i> Buat Undangan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Upgrade to Premium -->
        <div class="modal fade" id="upgradeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title"><i class="bi bi-star me-2"></i> Upgrade ke Premium</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda telah mencapai batas maksimal <strong>1 undangan</strong> untuk akun gratis.</p>
                        <p>Upgrade ke berlangganan premium untuk membuat undangan tanpa batas dan mengakses fitur
                            eksklusif lainnya.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Nanti</button>
                        <a href="{{ route('subscribe.page') }}" class="btn btn-warning">
                            <i class="bi bi-star me-1"></i> Lihat Paket Premium
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ulangi Modal WhatsApp untuk setiap data undangan yang ada --}}
        @foreach ($invitations as $inv)
            <div class="modal fade" id="waModal{{ $inv->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title"><i class="bi bi-whatsapp me-2"></i> Bagikan Undangan</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="recipientName{{ $inv->id }}"
                                    placeholder="Nama penerima">
                                <label for="recipientName{{ $inv->id }}">Nama Penerima</label>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control" id="waMessage{{ $inv->id }}" placeholder="Pesan undangan"
                                    style="height:200px">
                                                @include('dashboard.invitation.pesan')
                                                        </textarea>
                                <label for="waMessage{{ $inv->id }}">Pesan Undangan</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success"
                                onclick="shareWAWithRecipient('recipientName{{ $inv->id }}','waMessage{{ $inv->id }}')">
                                <i class="bi bi-whatsapp me-1"></i> Share via WhatsApp
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const quickCreateForm = document.getElementById('quickCreateForm');
                if (quickCreateForm) {
                    quickCreateForm.addEventListener('submit', async function (e) {
                        e.preventDefault();

                        const errorDiv = document.getElementById('modal_error');
                        errorDiv.classList.add('d-none');
                        errorDiv.innerHTML = '';

                        const formData = new FormData(this);

                        try {
                            const response = await fetch(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                },
                                body: formData,
                            });

                            const result = await response.json();

                            if (!response.ok) {
                                let errorMsg = result.message || 'Terjadi kesalahan.';
                                if (result.errors) {
                                    errorMsg += '<br><ul class="mb-0">' + Object.values(result.errors).map(function (e) { return '<li>' + e[0] + '</li>'; }).join('') + '</ul>';
                                }
                                errorDiv.innerHTML = errorMsg;
                                errorDiv.classList.remove('d-none');
                                return;
                            }

                            const modalEl = document.getElementById('newInvitationModal');
                            const modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: result.message || 'Undangan berhasil dibuat.',
                                confirmButtonColor: '#FF6B81',
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(function () {
                                window.location.href = '/home';
                            });

                        } catch (error) {
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat membuat undangan.',
                                confirmButtonColor: '#FF6B81',
                            });
                        }
                    });
                }
            });

            function shareWAWithRecipient(recipientId, messageId) {
                const recipient = document.getElementById(recipientId).value.trim();
                if (!recipient) {
                    alert('Silakan masukkan nama penerima!');
                    return;
                }

                let message = document.getElementById(messageId).value;
                message = message.replace(/\[nama\]/g, recipient);

                const waUrl = "https://wa.me/?text=" + encodeURIComponent(message);
                window.open(waUrl, '_blank');
            }
        </script>
    </div>
</x-app-layout>