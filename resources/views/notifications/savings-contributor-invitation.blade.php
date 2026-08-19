<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Undangan Kontributor Tabungan</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; background-color: #f7f5f2; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e5e5e5; }
        .header { background-color: #C6A962; padding: 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; font-weight: 700; }
        .body { padding: 30px; color: #333333; }
        .body p { line-height: 1.7; margin-bottom: 16px; }
        .btn { display: inline-block; padding: 14px 28px; background-color: #C6A962; color: #ffffff; text-decoration: none; border-radius: 10px; font-weight: 600; margin-top: 10px; }
        .footer { padding: 20px 30px; text-align: center; color: #888888; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💌 Undangan Menjadi Kontributor Tabungan</h1>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $contributorName }}</strong>,</p>
            <p><strong>{{ $inviterName }}</strong> mengundang Anda untuk menjadi kontributor tabungan pernikahan mereka di RuangUndang.my.id.</p>
            <p>Sebagai kontributor, Anda dapat membantu mengumpulkan tabungan dan melihat perkembangan target tabungan mereka.</p>
            <p style="text-align: center;">
                <a href="{{ $acceptUrl }}" class="btn">Terima Undangan</a>
            </p>
            <p>Jika tombol di atas tidak berfungsi, salin dan buka link berikut di browser:</p>
            <p style="word-break: break-all; color: #C6A962;">{{ $acceptUrl }}</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} RuangUndang.my.id. All rights reserved.
        </div>
    </div>
</body>
</html>
