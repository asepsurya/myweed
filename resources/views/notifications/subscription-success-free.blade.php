<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Invoice Langganan — {{ $plan->name }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Fallback styles untuk web view */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F5F3EF;
            color: #1B2A4A;
            margin: 0;
            padding: 2rem 1rem;
        }
    </style>
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #F5F3EF; color: #1B2A4A; margin: 0; padding: 2rem 1rem;">

    <div class="email-container" style="max-width: 560px; margin: 0 auto; background: #FFFFFF; border-radius: 20px; overflow: hidden; box-shadow: 0 16px 40px rgba(0,0,0,0.06);">
        
        <!-- Top Accent -->
        <div style="height: 4px; background: linear-gradient(90deg, #A68B4B, #C6A962, #E8D5A3, #C6A962, #A68B4B);"></div>
        
        <!-- Body -->
        <div class="email-body" style="padding: 2rem 2.25rem 2.5rem;">
            
            <!-- Logo Header -->
            <div style="text-align: center; margin-bottom: 2rem;">
                <img src="https://ruangundang.inopakinstitute.or.id/assets/logo-new.png" alt="RuangUndang Logo" style="max-width: 140px; height: auto; margin: 0 auto;">
            </div>

            <!-- Invoice Info -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 1.5rem;">
                <tr>
                    <td valign="top" style="font-size: 0.95rem;">
                        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.4rem; font-weight: 700; margin: 0; color: #1B2A4A;">Invoice Langganan</h1>
                        <p style="margin: 0.25rem 0 0 0; color: #5A6478;">Halo <strong style="color: #1B2A4A;">{{ $notifiable->name }}</strong>!</p>
                    </td>
                    <td valign="top" align="right" style="font-size: 0.85rem; color: #6B7280;">
                        <div><strong style="color: #1B2A4A;">No. Invoice</strong><br>{{ $invoiceNumber }}</div>
                        <div style="margin-top: 0.75rem;"><strong style="color: #1B2A4A;">Tanggal</strong><br>{{ $invoiceDate }}</div>
                    </td>
                </tr>
            </table>

            <!-- Details Table -->
            <table class="detail-table" width="100%" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 1rem 0;">
                <tr>
                    <td style="padding: 0.8rem 0; font-size: 0.95rem; border-bottom: 1px solid #E8E4DE; color: #6B7280; width: 40%;">Paket</td>
                    <td style="padding: 0.8rem 0; font-size: 0.95rem; border-bottom: 1px solid #E8E4DE; font-weight: 600; text-align: right; color: #1B2A4A;">{{ $plan->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 0.8rem 0; font-size: 0.95rem; border-bottom: 1px solid #E8E4DE; color: #6B7280; width: 40%;">Durasi</td>
                    <td style="padding: 0.8rem 0; font-size: 0.95rem; border-bottom: 1px solid #E8E4DE; font-weight: 600; text-align: right; color: #1B2A4A;">{{ $plan->duration }} hari</td>
                </tr>
                <tr>
                    <td style="padding: 0.8rem 0; font-size: 0.95rem; border-bottom: 1px solid #E8E4DE; color: #6B7280; width: 40%;">Harga</td>
                    <td style="padding: 0.8rem 0; font-size: 0.95rem; border-bottom: 1px solid #E8E4DE; text-align: right;">
                        <span style="display: inline-block; background: #10B981; color: #fff; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700;">GRATIS</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0.8rem 0; font-size: 0.95rem; color: #6B7280; width: 40%;">Status</td>
                    <td style="padding: 0.8rem 0; font-size: 0.95rem; text-align: right;">
                        <span style="display: inline-block; background: #10B981; color: #fff; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700;">ACTIVE</span>
                    </td>
                </tr>
            </table>

            <p style="margin: 1.5rem 0 0.5rem 0; color: #5A6478; line-height: 1.6; font-size: 0.9rem;">Invoice ini berfungsi sebagai bukti langganan Anda. Simpan invoice ini untuk keperluan referensi.</p>
            <p style="margin: 0.5rem 0 0 0; color: #5A6478; line-height: 1.6; font-size: 0.9rem;">Terima kasih telah mempercayai layanan kami.</p>
        </div>
        
        <!-- Footer -->
        <div style="padding: 1.5rem; background: #FAFAFA; border-top: 1px solid #E8E4DE; text-align: center; font-size: 0.8rem; color: #9CA3AF;">
            &copy; {{ date('Y') }} RuangUndang. Seluruh hak cipta dilindungi.
        </div>
    </div>
</body>
</html>