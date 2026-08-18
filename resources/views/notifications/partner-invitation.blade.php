<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RuangUndang - Undangan Kelola Bersama Pasangan</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Fallback styles untuk web view */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #F5F3EF;
            color: #1B2A4A;
            margin: 0;
            padding: 2rem 1rem;
        }

        .email-container {
            max-width: 560px;
            margin: 0 auto;
            background: #FFFFFF;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(0,0,0,0.06);
        }

        .btn-accept {
            display: inline-block;
            background: linear-gradient(135deg, #C6A962, #A68B4B) !important;
            color: #FFFFFF !important;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.85rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(198, 169, 98, 0.4);
            transition: all 0.2s ease;
        }

        /* Responsive button for mobile */
        @media screen and (max-width: 600px) {
            .btn-accept {
                display: block;
                width: 100%;
                text-align: center;
                box-sizing: border-box;
            }
            .email-body {
                padding: 2rem 1.5rem 2.5rem !important;
            }
            .email-header {
                padding: 2.5rem 1.5rem 0 !important;
            }
        }
    </style>
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #F5F3EF; color: #1B2A4A; margin: 0; padding: 2rem 1rem;">

    <div class="email-container">
        <!-- Top Accent -->
        <div style="height: 4px; background: linear-gradient(90deg, #A68B4B, #C6A962, #E8D5A3, #C6A962, #A68B4B);"></div>
        
        <!-- Header -->
        <div class="email-header" style="padding: 2.5rem 2.25rem 0; text-align: center;">
             <img src="https://ruangundang.inopakinstitute.or.id/assets/logo-new.png" alt="RuangUndang Logo" style="max-width: 160px; height: auto; margin: 0 auto;">
        </div>
        
        <!-- Body -->
        <div class="email-body" style="padding: 2rem 2.25rem 2.5rem; text-align: center;">
            <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.5rem; font-weight: 700; color: #1B2A4A; margin: 0 0 1rem 0;">
                Undangan Pasangan Pernikahan 💍
            </h1>
            
            <p style="font-size: 0.95rem; color: #5A6478; line-height: 1.6; margin: 0 0 1.5rem 0;">
                <strong style="color: #1B2A4A;">{{ $inviterName ?? 'Pasangan Anda' }}</strong> mengundang Anda sebagai pasangan untuk 
                {{ $canEdit ? 'mengedit dan mengelola bersama' : 'melihat' }} undangan pernikahan 
                <strong style="color: #1B2A4A;">{{ $invitationTitle ?? 'Pernikahan Kami' }}</strong>.
                @if($inviterPlan && !$inviterPlan->is_free)
                <br><span style="color: #0d6efd;"><i class="bi bi-star-fill me-1"></i>Sebagai pasangan, Anda akan mendapatkan akses ke paket <strong>{{ $inviterPlan->name }}</strong> yang sama dengan {{ $inviterName ?? 'pasangan Anda' }}!</span>
                @endif
            </p>

            <!-- Details Card -->
            <div style="background: #F9F8F5; border: 1px solid #E8E4DE; border-left: 4px solid #C6A962; border-radius: 12px; padding: 1.25rem; margin: 0 0 1.75rem 0; text-align: left;">
                <p style="margin: 0 0 0.75rem 0; font-weight: 600; color: #1B2A4A; font-size: 0.9rem;">DETAIL UNDANGAN</p>
                <p style="margin: 0 0 0.5rem 0; font-size: 0.9rem; color: #5A6478;">
                    <strong style="color: #1B2A4A; min-width: 80px; display: inline-block;">Pasangan:</strong> {{ $invitationTitle ?? '-' }}
                </p>
                <p style="margin: 0; font-size: 0.9rem; color: #5A6478;">
                    <strong style="color: #1B2A4A; min-width: 80px; display: inline-block;">Hak Akses:</strong> 
                    {{ $canEdit ? 'Bisa Mengedit & Mengelola Data' : 'Hanya Melihat' }}
                </p>
            </div>

            <!-- Call to Action Button -->
            <a href="{{ $acceptUrl }}" class="btn-accept" style="background: linear-gradient(135deg, #C6A962, #A68B4B); color: #FFFFFF; font-weight: 600; font-size: 1rem; padding: 0.85rem 2.5rem; border-radius: 50px; text-decoration: none; box-shadow: 0 4px 14px rgba(198, 169, 98, 0.4);">
                Terima Undangan Pasangan ✨
            </a>

            <!-- Fallback URL -->
            <p style="margin: 1.5rem 0 0 0; font-size: 0.8rem; color: #9CA3AF; line-height: 1.5;">
                Jika tombol di atas tidak dapat diklik, salin dan tempel tautan berikut ke peramban Anda:<br>
                <a href="{{ $acceptUrl }}" style="color: #C6A962; word-break: break-all; text-decoration: none;">{{ $acceptUrl }}</a>
            </p>
        </div>
        
        <!-- Footer -->
        <div style="padding: 1.5rem; background: #FAFAFA; border-top: 1px solid #E8E4DE; text-align: center; font-size: 0.8rem; color: #9CA3AF;">
            &copy; {{ date('Y') }} RuangUndang. Seluruh hak cipta dilindungi.
        </div>
    </div>
</body>
</html>