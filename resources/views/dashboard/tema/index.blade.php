<x-app-layout>

    <style>
        .tema-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .tema-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .tema-card .card-img-top {
            height: 180px;
            object-fit: cover;
            background-color: #f3f4f6;
        }

        .tema-card .card-body {
            padding: 1rem;
        }

        .tema-card .btn-gunakan {
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.5rem 1.25rem;
        }

        .premium-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 2;
        }
    </style>

    <div class="container-fluid py-4" style="padding-bottom: 100px">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-1">Pilih Tema Undangan</h4>
                <p class="text-muted mb-0">Pilih template yang sesuai dengan momen spesial Anda</p>
            </div>
        </div>

        <div class="row g-3 g-md-4">
            @forelse ($templates as $template)
                @php
                    $canAccess = auth()->user()->hasFeature('all_themes') || $template->slug === 'simple-theme';
                @endphp
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card tema-card h-100 shadow-sm {{ !$canAccess ? 'opacity-75' : '' }}">
                        @if($template->is_premium)
                            <span class="badge bg-warning premium-badge">Premium</span>
                        @endif
                        @if(!$canAccess)
                            <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 2;">
                                <i class="bi bi-lock-fill fs-2 text-white shadow-lg"></i>
                            </div>
                        @endif
                        @php
                            $thumbSrc = template_thumbnail_url($template);
                        @endphp
                        <img src="{{ $thumbSrc ?: 'https://placehold.co/600x450?text=No+Thumbnail' }}" 
                             loading="lazy"
                             width="600"
                             height="450"
                             class="card-img-top" 
                             alt="{{ $template->name }}">
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-semibold mb-2 text-truncate">{{ $template->name }}</h6>
                            <p class="text-muted small mb-3 text-truncate">{{ $template->category->name ?? 'Template' }}</p>
                            @if($canAccess)
                            <button type="button" 
                                    class="btn btn-primary btn-gunakan mt-auto w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#createInvitationModal"
                                    data-template-id="{{ $template->id }}"
                                    data-template-name="{{ $template->name }}">
                                <i class="bi bi-check-circle me-1"></i> Gunakan
                            </button>
                            @else
                            <button type="button" 
                                    class="btn btn-secondary btn-gunakan mt-auto w-100" 
                                    onclick="showTemplateLockAlert()">
                                <i class="bi bi-lock me-1"></i> Tertutup
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                    <h6 class="text-muted">Belum ada template tersedia</h6>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $templates->links() }}
        </div>
    </div>

    <!-- Modal: Create Invitation with Couple Names -->
    <div class="modal fade" id="createInvitationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
                <form id="quickCreateForm" action="{{ route('invitation.quick-create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="template_id" id="modal_template_id" value="">
                    
                    <div class="modal-header text-center" style="background-color: #053B2D; color: #D4AF37; border-bottom: 3px solid #D4AF37; padding: 20px;">
                        <h5 class="modal-title w-100 fw-bold" style="font-family: 'Cinzel', serif; letter-spacing: 1px;">
                            <i class="bi bi-suit-heart-fill me-2" style="color: #D4AF37;"></i> Bangun Mimpimu
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup" style="opacity: 0.8;"></button>
                    </div>

                    <div class="modal-body p-4 p-md-5" style="background-color: #F7FDF9;">
                        <p class="text-muted small text-center mb-4" style="font-style: italic;">Template: <strong id="selectedTemplateName" class="text-dark"></strong></p>

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

    <script>
        function showTemplateLockAlert() {
            Swal.fire({
                title: 'Template Tertutup 🔒',
                text: 'Template ini hanya tersedia untuk pengguna dengan paket berbayar. Upgrade sekarang untuk mengakses semua tema!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d9488',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Upgrade Sekarang',
                cancelButtonText: 'Mungkin Nanti'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('subscribe.page') }}";
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const createModal = document.getElementById('createInvitationModal');
            const templateIdInput = document.getElementById('modal_template_id');
            const templateNameSpan = document.getElementById('selectedTemplateName');
            const quickCreateForm = document.getElementById('quickCreateForm');
            const errorDiv = document.getElementById('modal_error');

            // When modal is shown, set the template ID from the clicked button
            createModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const templateId = button.getAttribute('data-template-id');
                const templateName = button.getAttribute('data-template-name');
                
                templateIdInput.value = templateId;
                templateNameSpan.textContent = templateName;
                errorDiv.classList.add('d-none');
                errorDiv.innerHTML = '';
            });

            // Handle form submission
            if (quickCreateForm) {
                quickCreateForm.addEventListener('submit', async function (e) {
                    e.preventDefault();
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
                                errorMsg += '<br><ul class="mb-0">' + Object.values(result.errors).map(function (err) { return '<li>' + err[0] + '</li>'; }).join('') + '</ul>';
                            }
                            errorDiv.innerHTML = errorMsg;
                            errorDiv.classList.remove('d-none');
                            return;
                        }

                        const modalEl = document.getElementById('createInvitationModal');
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
                            if (result.redirect_url) {
                                window.location.href = result.redirect_url;
                            } else if (result.invitation && result.invitation.id) {
                                window.location.href = '/invitation/' + result.invitation.id + '/edit';
                            } else {
                                window.location.href = '/home';
                            }
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
    </script>

</x-app-layout>
