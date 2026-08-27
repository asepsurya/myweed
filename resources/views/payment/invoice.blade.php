<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $payment->order_id }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Menggunakan Roboto Mono agar terlihat seperti struk modern/profesional -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f1f3f5;
            font-family: 'Roboto Mono', monospace;
            padding: 2rem 1rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .struk-container {
            width: 100%;
            max-width: 400px;
            /* Tampilan di layar web tetap 400px */
            margin-bottom: 1.5rem;
        }

        .receipt-paper {
            background: #fff;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            color: #212529;
        }

        /* Efek pinggiran sobok di bagian bawah kertas */
        .receipt-paper::after {
            content: "";
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 20px;
            background: radial-gradient(circle at 10px -5px, transparent 10px, #fff 11px);
            background-size: 20px 20px;
            background-repeat: repeat-x;
        }

        .receipt-divider {
            border-top: 1px dashed #adb5bd;
            margin: 1rem 0;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .receipt-title {
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 1px;
        }

        .receipt-subtitle {
            font-size: 0.75rem;
            color: #6c757d;
            margin: 0;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .receipt-label {
            color: #495057;
        }

        .receipt-value {
            font-weight: 700;
            text-align: right;
            max-width: 60%;
            word-wrap: break-word;
        }

        .item-name {
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
        }

        .item-desc {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 0.2rem;
        }

        .total-row {
            font-size: 1.1rem;
            font-weight: 700;
            margin-top: 0.5rem;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: 1px solid;
        }

        .status-paid {
            color: #198754;
            border-color: #198754;
            background: #e6f4ea;
        }

        .status-pending {
            color: #664d03;
            border-color: #664d03;
            background: #fff3cd;
        }

        .status-failed {
            color: #842029;
            border-color: #842029;
            background: #f8d7da;
        }

        .btn-download {
            width: 100%;
            max-width: 400px;
            font-family: 'Roboto Mono', monospace;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.8rem;
            border-radius: 8px;
        }

        /* === KELAS BANTU UNTUK GENERATE PDF AGAR TANPA PADDING/MARGIN LUAR === */
        .is-generating-pdf {
            background: #fff !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .is-generating-pdf .struk-container {
            width: 80mm !important;
            /* Samakan dengan lebar kertas PDF */
            max-width: 80mm !important;
            margin: 0 !important;
        }

        .is-generating-pdf .receipt-paper {
            box-shadow: none !important;
            border-radius: 0 !important;
            padding: 1rem 1.5rem !important;
            /* Padding DALAM tetap ada supaya teks tidak nempel ke pinggir */
        }

        .is-generating-pdf .receipt-paper::after {
            display: none !important;
        }

        @media print {
            body {
                background: #fff !important;
                padding: 0 !important;
                justify-content: flex-start !important;
            }

            .no-print,
            .btn-download {
                display: none !important;
            }

            .struk-container {
                max-width: 100% !important;
                margin: 0 !important;
            }

            .receipt-paper {
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 0 0.5rem !important;
            }

            .receipt-paper::after {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="struk-container" id="strukContent">
        <div class="receipt-paper">

            {{-- HEADER STRUK --}}
            <div class="receipt-header">
                <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang" width="250">
                <p class="receipt-subtitle">Platform Undangan Digital</p>
                <p class="receipt-subtitle">admin@ruangundang.my.id</p>
            </div>

            <div class="receipt-divider"></div>

            {{-- INFO DASAR --}}
            <div class="receipt-row">
                <span class="receipt-label">No Invoice</span>
                <span class="receipt-value">{{ $payment->order_id }}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Tanggal</span>
                <span class="receipt-value">{{ $payment->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Pelanggan</span>
                <span class="receipt-value">{{ $payment->user->name ?? 'Customer' }}</span>
            </div>

            @php
                $statusClass = match ($payment->status) {
                    'paid' => 'status-paid',
                    'pending' => 'status-pending',
                    'failed' => 'status-failed',
                    default => 'status-pending'
                };
                $statusLabel = match ($payment->status) {
                    'paid' => 'LUNAS',
                    'pending' => 'PENDING',
                    'failed' => 'GAGAL',
                    default => strtoupper($payment->status)
                };
            @endphp

            <div class="receipt-row" style="align-items: center; margin-top: 0.5rem;">
                <span class="receipt-label">Status</span>
                <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
            </div>

            <div class="receipt-divider"></div>

            {{-- ITEM YANG DIBELI --}}
            <div class="item-name">Paket {{ $payment->subscriptionPlan->name ?? '-' }}</div>
            <div class="item-desc">Durasi: {{ $payment->subscriptionPlan->duration ?? 0 }} Hari</div>
            <div class="receipt-row">
                <span class="receipt-label">Harga Paket</span>
                <span class="receipt-value">Rp
                    {{ number_format($payment->subscriptionPlan->price ?? 0, 0, ',', '.') }}</span>
            </div>

            {{-- KUPON JIKA ADA --}}
            @if($payment->coupon)
                <div class="receipt-divider"></div>
                <div class="item-name">Kupon: {{ $payment->coupon->code }}</div>
                <div class="item-desc">
                    Diskon
                    {{ $payment->coupon->type === 'percentage' ? $payment->coupon->value . '%' : 'Rp ' . number_format($payment->coupon->value, 0, ',', '.') }}
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Potongan</span>
                    {{-- Perbaikan perhitungan diskon: Harga Awal - Total Dibayar --}}
                    <span class="receipt-value text-success">- Rp
                        {{ number_format(($payment->subscriptionPlan->price ?? 0) - $payment->amount, 0, ',', '.') }}</span>
                </div>
            @endif

            {{-- TOTAL --}}
            <div class="receipt-divider"></div>
            <div class="receipt-row total-row">
                <span>TOTAL</span>
                <span>Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>
            <div class="receipt-divider"></div>

            {{-- INFO PEMBAYARAN --}}
            <div class="receipt-row">
                <span class="receipt-label">Metode Bayar</span>
                <span class="receipt-value">
                    @if($payment->payment_gateway === 'local')
                        QRIS (Pembayaran Langsung)
                        @if($payment->proof_image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $payment->proof_image) }}" alt="Bukti" style="max-width: 100px; border-radius: 0.375rem;">
                            </div>
                        @endif
                    @else
                    @php
                        $method = match ($payment->payment_type) {
                            'credit_card' => 'Kartu Kredit',
                            'bank_transfer' => 'Transfer Bank',
                            'echannel' => 'Mandiri Bill',
                            'gopay' => 'GoPay',
                            'shopeepay' => 'ShopeePay',
                            'qris' => 'QRIS',
                            'bca_va' => 'BCA VA',
                            'bni_va' => 'BNI VA',
                            'bri_va' => 'BRI VA',
                            default => ucfirst(str_replace('_', ' ', $payment->payment_type ?? $payment->payment_gateway ?? 'Midtrans'))
                        };
                    @endphp
                    {{ $method }}
                    @endif
                </span>
            </div>
            @if($payment->gateway_transaction_id)
                <div class="receipt-row">
                    <span class="receipt-label">Ref ID</span>
                    <span class="receipt-value">{{ $payment->gateway_transaction_id }}</span>
                </div>
            @endif
            @if($payment->paid_at)
                <div class="receipt-row">
                    <span class="receipt-label">Dibayar Pada</span>
                    <span class="receipt-value">{{ $payment->paid_at->format('d/m/Y H:i') }}</span>
                </div>
            @endif

            <div class="receipt-divider"></div>

            {{-- FOOTER --}}
            <div class="text-center" style="margin-top: 1rem;">
                <p class="receipt-subtitle">* Invoice ini sah diproses oleh *</p>
                <p class="receipt-subtitle">sistem komputer RuangUndang.</p>
                <p class="receipt-title" style="font-size: 1rem; margin-top: 10px; letter-spacing: 2px;">Terima Kasih!
                </p>
            </div>

        </div>
    </div>

    {{-- TOMBOL DOWNLOAD --}}
    <div class="struk-container no-print">
        <button onclick="downloadStruk()" class="btn btn-dark btn-download">
            <i class="bi bi-download me-2"></i> Download Struk (PDF)
        </button>
    </div>

    {{-- SCRIPT HTML2PDF UNTUK GENERATE PDF --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadStruk() {
            const element = document.getElementById('strukContent');

            // 1. Tambahkan class untuk menghilangkan margin/shadow luar saat proses generate
            document.body.classList.add('is-generating-pdf');

            const opt = {
                margin: 0, // <-- UBAH JADI 0 SUPAYA TIDAK ADA MARGIN LUAR
                filename: 'Struk-' + '{{ $payment->order_id }}' + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff' },
                jsPDF: { unit: 'mm', format: [80, 200], orientation: 'portrait' }
            };

            // 2. Generate PDF
            html2pdf().set(opt).from(element).save().then(() => {
                // 3. Hapus class kembali setelah PDF selesai dibuat
                document.body.classList.remove('is-generating-pdf');
            });
        }
    </script>
</body>

</html>