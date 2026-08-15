<x-app-layout>
    @php
        $firstInvitation = $invitations->first();
        $themeColor = $firstInvitation->theme_color ?? '#FF6B81';
    @endphp

    <style>
        :root {
            --mobile-nav-active-color: {{ $themeColor }};
        }

        .list-group-item {
            padding: 14px 16px;
            transition: background-color 0.2s ease;
        }

        .info-text {
            min-width: 0; /* Penting agar flexbox text-truncate berfungsi */
        }

        .info-text h6 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        /* Ukuran Touch Target yang Nyaman untuk Mobile */
        @media (max-width: 767.98px) {
            .list-group-item {
                padding: 12px 14px;
            }
            .w-md-100 {
                width: 100% !important;
            }
            .btn-icon-mobile {
                width: 44px;
                height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                font-size: 1.1rem;
            }
            .dropdown-toggle.btn-icon-mobile {
                border-radius: 50%;
            }
        }

        @media (max-width: 575.98px) {
            .btn-icon-mobile {
                width: 40px;
                height: 40px;
            }
        }
    </style>

    <!-- TAB 1: Aktivitas Undangan -->
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <div class="py-10">
            <div class="container-fluid">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div>
                        <h4 class="mb-1">Aktivitas Undangan Terbaru</h4>
                        @php $status = auth()->user()->subscriptionStatus(); @endphp
                        @if($status == 'active')
                            <span class="badge bg-warning text-dark small">
                                <i class="bi bi-star-fill me-1"></i> Premium
                                @if(auth()->user()->isAdmin())
                                    (Admin Access)
                                @elseif(auth()->user()->subscription)
                                    (Aktif s/d: {{ auth()->user()->subscription->end_date->format('d M Y') }})
                                @endif
                            </span>
                        @else
                            <span class="badge bg-light text-dark border small">Free Plan (Limit 1 Undangan)</span>
                        @endif
                    </div>

                    <div class="w-md-100 d-flex justify-content-md-end">
                        @php
                            $user = auth()->user();
                            $canCreateMore = $user->isAdmin() || $user->isSubscribed() || $user->invitations->count() < 1;
                        @endphp

                        @if($canCreateMore)
                            <button type="button" class="btn btn-sm btn-outline-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#newInvitationModal">
                                <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                            </button>
                        @else
                            <button type="button" class="btn btn-sm btn-warning w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#upgradeModal">
                                <i class="bi bi-star me-1"></i> Upgrade ke Premium
                            </button>
                        @endif
                    </div>
                </div>

                <form id="bulkDeleteForm" action="{{ route('invitation.bulk-delete') }}" method="POST">
                    @csrf

                    @if($invitations->isNotEmpty())
                        <div class="mb-2 px-2 py-2 rounded d-flex align-items-center bg-light border">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label small fw-bold" for="selectAll">Pilih Semua</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Hapus undangan yang dipilih?')">
                            <i class="bi bi-trash me-1"></i> Hapus yang Dipilih
                        </button>
                    @endif

                    <ul class="list-group">
                        @forelse ($invitations as $inv)
                            <li class="list-group-item d-flex align-items-center gap-3">
                                <!-- Checkbox -->
                                <input type="checkbox" name="ids[]" value="{{ $inv->id }}" class="form-check-input flex-shrink-0 m-0 bulk-checkbox">

                                <!-- Cover -->
                                <div class="flex-shrink-0">
                                    @if($inv->gallery_cover)
                                        <img src="{{ storage_url_with_fallback($inv->gallery_cover, null, $inv->updated_at->timestamp) }}" class="rounded object-fit-cover" style="width: 48px; height: 48px;" alt="Cover">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="flex-grow-1 info-text">
                                    <h6 class="mb-0 fw-bold text-dark">
                                        {{ $inv->groom_nickname ?? $inv->groom_name }} & {{ $inv->bride_nickname ?? $inv->bride_name }}
                                    </h6>
                                    <small class="text-muted d-block text-truncate">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $inv->wedding_date ? \Carbon\Carbon::parse($inv->wedding_date)->format('d M Y') : 'Tanggal belum ditentukan' }}
                                    </small>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex-shrink-0 d-flex align-items-center gap-2">
                                    <!-- Desktop -->
                                    <div class="d-none d-md-flex gap-2">
                                        <a href="{{ route('invitation.show', $inv->slug) }}" class="btn btn-outline-primary btn-sm" target="_blank" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('invitation.edit', $inv) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if(auth()->user()->isPaidSubscribed())
                                             <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#shareModalDynamic" data-id="{{ $inv->public_id }}" title="Bagikan Undangan">
                                                <i class="bi bi-share"></i>
                                            </button>
                                        @endif

                                        @if(!$inv->is_default)
                                            <form action="{{ route('invitation.destroy', $inv) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus undangan ini? Data yang sudah dihapus tidak dapat dikembalikan.');">
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
    <button class="btn btn-outline-secondary btn-icon-mobile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-three-dots-vertical"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="{{ route('invitation.show', $inv->slug) }}" target="_blank">
                <i class="bi bi-eye me-2"></i> Lihat
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('invitation.edit', $inv) }}">
                <i class="bi bi-pencil me-2"></i> Edit
            </a>
        </li>
        <li>
            @if(auth()->user()->isPaidSubscribed())
                 <button type="button" class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#shareModalDynamic" data-id="{{ $inv->public_id }}">
                    <i class="bi bi-share me-2"></i> Bagikan Undangan
                </button>
            @endif
        </li>
        @if(!$inv->is_default)
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('invitation.destroy', $inv) }}" method="POST" onsubmit="return confirm('Hapus undangan ini? Data yang sudah dihapus tidak dapat dikembalikan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger w-100 text-start">
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
                            <li class="list-group-item text-center py-5 border-0">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                <h6 class="text-dark">Belum ada undangan yang dibuat</h6>
                                <p class="text-muted small mb-3">Mulai buat undangan pertamamu sekarang</p>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newInvitationModal">
                                    <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                                </button>
                            </li>
                        @endforelse
                    </ul>
                </form>

            </div>
        </div>

        <!-- Hidden Divs untuk Menyimpan Template Pesan WhatsApp (Mencegah DOM bloat) -->
        @foreach ($invitations as $inv)
             <div id="wa-message-{{ $inv->public_id }}" class="d-none">
                @include('dashboard.invitation.pesan')
            </div>
        @endforeach

        <!-- Modal: New Invitation -->
        <div class="modal fade" id="newInvitationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
                    <form id="quickCreateForm" action="{{ route('invitation.quick-create') }}" method="POST">
                        @csrf
                        
                        <div class="modal-header text-center" style="background-color: #053B2D; color: #D4AF37; border-bottom: 3px solid #D4AF37; padding: 20px;">
                            <h5 class="modal-title w-100 fw-bold" style="font-family: 'Cinzel', serif; letter-spacing: 1px;">
                                <i class="bi bi-suit-heart-fill me-2" style="color: #D4AF37;"></i> Bangun Mimpimu
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup" style="opacity: 0.8;"></button>
                        </div>

                        <div class="modal-body p-4 p-md-5" style="background-color: #F7FDF9;">
                            <p class="text-muted small text-center mb-4" style="font-style: italic;">Mulai perjalanan indah Anda dengan mengisi data berikut.</p>

                            <div class="mb-4">
                                <h6 class="text-uppercase mb-3 d-flex align-items-center" style="color: #053B2D; font-weight: 700; letter-spacing: 1px; font-size: 0.85rem;">
                                    <i class="bi bi-gender-male me-2" style="font-size: 1.2rem; color: #10B981;"></i> Mempelai Pria
                                </h6>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-white border-end-0" style="border-color: #d1ede1; border-radius: 10px 0 0 10px;">
                                        <i class="bi bi-person" style="color: #10B981;"></i>
                                    </span>
                                    <input type="text" name="groom_name" class="form-control border-start-0 py-2" placeholder="Nama lengkap" required style="border-color: #d1ede1; border-radius: 0 10px 10px 0;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-color: #d1ede1; border-radius: 10px 0 0 10px;">
                                        <i class="bi bi-person-badge" style="color: #10B981;"></i>
                                    </span>
                                    <input type="text" name="groom_nickname" class="form-control border-start-0 py-2" placeholder="Nama panggilan (opsional)" style="border-color: #d1ede1; border-radius: 0 10px 10px 0;">
                                </div>
                            </div>

                            <div class="text-center my-3">
                                <div style="display: inline-block; background: #F7FDF9; padding: 0 15px; margin-top: -25px; position: relative; z-index: 2;">
                                    <i class="bi bi-suit-heart-fill" style="color: #D4AF37; font-size: 1.4rem;"></i>
                                </div>
                                <hr style="margin-top: -12px; border-color: #D4AF37; opacity: 0.3;">
                            </div>

                            <div class="mb-3">
                                <h6 class="text-uppercase mb-3 d-flex align-items-center" style="color: #053B2D; font-weight: 700; letter-spacing: 1px; font-size: 0.85rem;">
                                    <i class="bi bi-gender-female me-2" style="font-size: 1.2rem; color: #10B981;"></i> Mempelai Wanita
                                </h6>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-white border-end-0" style="border-color: #d1ede1; border-radius: 10px 0 0 10px;">
                                        <i class="bi bi-person" style="color: #10B981;"></i>
                                    </span>
                                    <input type="text" name="bride_name" class="form-control border-start-0 py-2" placeholder="Nama lengkap" required style="border-color: #d1ede1; border-radius: 0 10px 10px 0;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-color: #d1ede1; border-radius: 10px 0 0 10px;">
                                        <i class="bi bi-person-badge" style="color: #10B981;"></i>
                                    </span>
                                    <input type="text" name="bride_nickname" class="form-control border-start-0 py-2" placeholder="Nama panggilan (opsional)" style="border-color: #d1ede1; border-radius: 0 10px 10px 0;">
                                </div>
                            </div>

                            <div id="modal_error" class="alert alert-danger d-none mt-3" style="border-radius: 10px;"></div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between align-items-center" style="background-color: #F7FDF9; border-top: none; padding: 0 2rem 2rem 2rem;">
                            <button type="button" class="btn btn-link text-decoration-none text-muted" data-bs-dismiss="modal" style="font-weight: 600;">
                                Batal
                            </button>
                            <button type="submit" class="btn px-4 py-2 fw-bold shadow-sm" id="quickCreateBtn" style="background-color: #053B2D; color: #D4AF37; border-radius: 50px; letter-spacing: 1px; font-size: 0.9rem;">
                                <i class="bi bi-stars me-1"></i> Buat Undangan
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
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda telah mencapai batas maksimal <strong>1 undangan</strong> untuk akun gratis.</p>
                        <p>Upgrade ke berlangganan premium untuk membuat undangan tanpa batas dan mengakses fitur eksklusif lainnya.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Nanti</button>
                        <a href="{{ route('subscribe.page') }}" class="btn btn-warning text-white">
                            <i class="bi bi-star me-1"></i> Lihat Paket Premium
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: Share Invitation -->
        @if(auth()->user()->isPaidSubscribed())
        <div class="modal fade" id="shareModalDynamic" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-share me-2"></i> Bagikan Undangan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="recipientNameDynamic" placeholder="Nama penerima">
                            <label for="recipientNameDynamic">Nama Penerima</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="shareMessageDynamic" placeholder="Pesan undangan" style="height: 180px"></textarea>
                            <label for="shareMessageDynamic">Pesan Undangan</label>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button type="button" class="btn btn-success" onclick="shareToWhatsApp()">
                                <i class="bi bi-whatsapp me-1"></i> WhatsApp
                            </button>
                            <button type="button" class="btn btn-primary" onclick="shareToFacebook()">
                                <i class="bi bi-facebook me-1"></i> Facebook
                            </button>
                            <button type="button" class="btn btn-info text-white" onclick="shareToTwitter()">
                                <i class="bi bi-twitter-x me-1"></i> Twitter
                            </button>
                            <button type="button" class="btn btn-primary" onclick="shareToTelegram()">
                                <i class="bi bi-telegram me-1"></i> Telegram
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="shareViaEmail()">
                                <i class="bi bi-envelope me-1"></i> Email
                            </button>
                            <button type="button" class="btn btn-outline-dark" onclick="copyInvitationLink()">
                                <i class="bi bi-link-45deg me-1"></i> Salin Tautan
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Handle Quick Create Form
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

                // Handle Dynamic Share Modal
                const shareModal = document.getElementById('shareModalDynamic');
                if (shareModal) {
                    shareModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const invId = button.getAttribute('data-id');
                        const messageDiv = document.getElementById('wa-message-' + invId);
                        
                        const messageInput = document.getElementById('shareMessageDynamic');
                        const recipientInput = document.getElementById('recipientNameDynamic');
                        
                        if (messageDiv) {
                            messageInput.value = messageDiv.textContent.trim();
                        }
                        recipientInput.value = '';
                    });
                }

                // Handle Select All Checkbox
                const selectAll = document.getElementById('selectAll');
                if(selectAll) {
                    selectAll.addEventListener('change', function() {
                        document.querySelectorAll('.bulk-checkbox').forEach(cb => {
                            cb.checked = this.checked;
                        });
                    });
                }
            });

            function getShareData() {
                const recipient = document.getElementById('recipientNameDynamic').value.trim();
                let message = document.getElementById('shareMessageDynamic').value;
                message = message.replace(/\[nama\]/g, recipient || '');
                return { recipient, message };
            }

            function getInvitationUrl() {
                const invitation = @json($invitations->first());
                if (invitation && invitation.slug) {
                    return @json(url('/')) + '/' + invitation.slug;
                }
                return window.location.href;
            }

            function shareToWhatsApp() {
                const { message } = getShareData();
                const url = "https://wa.me/?text=" + encodeURIComponent(message);
                window.open(url, '_blank');
            }

            function shareToFacebook() {
                const { message } = getShareData();
                const url = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(getInvitationUrl());
                window.open(url, '_blank');
            }

            function shareToTwitter() {
                const { message } = getShareData();
                const url = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(message) + "&url=" + encodeURIComponent(getInvitationUrl());
                window.open(url, '_blank');
            }

            function shareToTelegram() {
                const { message } = getShareData();
                const url = "https://t.me/share/url?url=" + encodeURIComponent(getInvitationUrl()) + "&text=" + encodeURIComponent(message);
                window.open(url, '_blank');
            }

            function shareViaEmail() {
                const { recipient, message } = getShareData();
                const subject = "Undangan Pernikahan";
                const body = message;
                const url = "mailto:?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
                window.location.href = url;
            }

            function copyInvitationLink() {
                const url = getInvitationUrl();
                navigator.clipboard.writeText(url).then(function () {
                    alert('Tautan undangan berhasil disalin!');
                }).catch(function () {
                    alert('Gagal menyalin tautan.');
                });
            }
        </script>
    </div>
</x-app-layout>