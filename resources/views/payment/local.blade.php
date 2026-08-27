<x-app-layout>
    <style>
        .qris-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .qris-code {
            width: 220px;
            height: 220px;
            object-fit: contain;
            border: 1px solid #e0e0e0;
            border-radius: 0.75rem;
            padding: 0.5rem;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .step {
            text-align: center;
        }

        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #0d6efd;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            margin: 0 auto 0.25rem;
        }

        .step.active .step-number {
            background: #0d6efd;
        }

        .step.inactive .step-number {
            background: #dee2e6;
            color: #6c757d;
        }

        .step-label {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .step-label.active {
            color: #0d6efd;
            font-weight: 600;
        }

        .proof-preview {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 1px solid #e0e0e0;
            margin-top: 0.5rem;
        }

        .upload-area {
            border: 2px dashed #ced4da;
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #fff;
        }

        .upload-area:hover {
            border-color: #0d6efd;
            background: #f8f9ff;
        }

        .upload-area.dragover {
            border-color: #0d6efd;
            background: #e7f1ff;
        }
    </style>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">

                        <!-- HEADER -->
                        <div class="text-center mb-4">
                            <i class="bi bi-qr-code fs-1 text-primary"></i>
                            <h4 class="fw-bold mb-1 mt-2">Pembayaran via QRIS</h4>
                            <p class="text-muted small mb-0">
                                Scan QRIS di bawah untuk menyelesaikan pembayaran
                            </p>
                        </div>

                        <!-- STEP INDICATOR -->
                        <div class="step-indicator">
                            <div class="step active">
                                <div class="step-number">1</div>
                                <div class="step-label active">Scan QRIS & Bayar</div>
                            </div>
                            <div class="step {{ $payment->proof_image ? 'active' : 'inactive' }}">
                                <div class="step-number">2</div>
                                <div class="step-label {{ $payment->proof_image ? 'active' : '' }}">Upload Bukti & Konfirmasi</div>
                            </div>
                        </div>

                        <!-- QRIS IMAGE -->
                        <div class="qris-container">
                            <img src="{{ asset('assets/qris.png') }}" alt="QRIS Code" class="qris-code">
                        </div>

                        <!-- PAYMENT INFO -->
                        <div class="border rounded-3 p-3 mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-semibold">Order ID</span>
                                <span class="fw-monospace">{{ $payment->order_id }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-semibold">Paket</span>
                                <span>{{ $payment->subscriptionPlan->name ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-semibold">Durasi</span>
                                <span>{{ $payment->subscriptionPlan->duration ?? 0 }} Hari</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total Bayar</span>
                                <span class="fw-bold text-primary">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        @if($payment->proof_image)
                            <!-- PROOF PREVIEW -->
                            <div class="text-center mb-4">
                                <label class="fw-semibold mb-2">Bukti Pembayaran</label>
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $payment->proof_image) }}" alt="Bukti Pembayaran"
                                        class="proof-preview">
                                </div>
                                <span class="badge bg-warning text-dark">
                                    Menunggu konfirmasi admin
                                </span>
                            </div>
                        @else
                            <!-- UPLOAD PROOF -->
                            <form id="confirmForm" method="POST" action="{{ route('payment.local.confirm') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $payment->order_id }}">

                                <div class="upload-area" id="uploadArea">
                                    <i class="bi bi-image fs-2 text-muted mb-2 d-block"></i>
                                    <span class="text-muted small d-block mb-0">
                                        Klik untuk upload bukti transfer
                                    </span>
                                    <input type="file" name="proof_image" id="proof_input" accept="image/*"
                                        style="display: none;">
                                </div>

                                <div id="previewContainer" class="text-center mt-3" style="display: none;">
                                    <img id="proofPreview" class="proof-preview" alt="Preview">
                                </div>

                                @error('proof_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                                <button type="submit" id="confirmBtn"
                                    class="btn btn-success w-100 rounded-3 py-2 mt-3" disabled>
                                    <i class="bi bi-upload"></i> Konfirmasi Pembayaran
                                </button>
                            </form>
                        @endif

                        <p class="text-center text-muted small mt-3 mb-0">
                            Pembayaran diproses dengan aman
                        </p>
                        <div class="text-center mt-2">
                            <a href="{{ route('payments.status') }}" class="btn btn-link btn-sm text-muted">
                                <i class="bi bi-arrow-left"></i> Kembali ke Status Pembayaran
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const uploadArea = document.getElementById('uploadArea');
            const proofInput = document.getElementById('proof_input');
            const previewContainer = document.getElementById('previewContainer');
            const proofPreview = document.getElementById('proofPreview');
            const confirmBtn = document.getElementById('confirmBtn');
            const confirmForm = document.getElementById('confirmForm');

            uploadArea.addEventListener('click', function () {
                proofInput.click();
            });

            uploadArea.addEventListener('dragover', function (e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function () {
                this.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function (e) {
                e.preventDefault();
                this.classList.remove('dragover');
                if (e.originalEvent.dataTransfer.files.length > 0) {
                    proofInput.files = e.originalEvent.dataTransfer.files;
                    handleFileSelect();
                }
            });

            proofInput.addEventListener('change', handleFileSelect);

            function handleFileSelect() {
                const file = proofInput.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar.');
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file maksimal 5MB.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    proofPreview.src = e.target.result;
                    previewContainer.style.display = 'block';
                    uploadArea.style.display = 'none';
                    confirmBtn.disabled = false;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
