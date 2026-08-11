<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusantara Royal Wedding Preview</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Montserrat:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #0b0c10;
            color: #d4af37;
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Top Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 24px;
            background-color: #0d0e12;
            border-bottom: 1px solid rgba(212, 175, 55, 0.15);
            z-index: 10;
        }

        .nav-back {
            color: #a0a0a0;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s;
        }

        .nav-back:hover {
            color: #d4af37;
        }

        .nav-title {
            font-family: 'Cinzel', serif;
            letter-spacing: 2px;
            font-weight: 600;
            color: #e5c158;
            font-size: 14px;
        }

        .btn-pakai {
            background-color: #d4af37;
            color: #0b0c10;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: opacity 0.3s;
            text-decoration: none;
        }

        .btn-pakai:hover {
            opacity: 0.9;
        }

        /* Main Container */
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
        }

        /* Mobile Frame Mockup */
        .mobile-frame {
            width: 360px;
            height: 680px;
            background-color: #000;
            border: 3px solid rgba(212, 175, 55, 0.4);
            border-radius: 40px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.9), 0 0 15px rgba(212, 175, 55, 0.15);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Notch HP (Kamera Depan Opsional) */
        .mobile-notch {
            width: 120px;
            height: 18px;
            background-color: #0d0e12;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            z-index: 5;
        }

        /* Frame iFrame */
        .mobile-iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 36px;
        }

        /* Floating Chat CS Button */
        .chat-cs {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #25d366;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 10;
        }

        .chat-cs:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <!-- Top Navigation Bar -->
    <header class="navbar">
        <a href="javascript:history.back()" class="nav-back">&lt; Kembali</a>
        <div class="nav-title">NUSANTARA ROYAL WEDDING</div>
        <a href="{{ route('dashboard.user') }}?template_id={{ $id }}" class="btn-pakai">
            <span>♡</span> PAKAI UNDANGAN
        </a>
    </header>

    <!-- Main View Area dengan Frame Mobile & iFrame -->
    <main class="main-container">
        <div class="mobile-frame">
            <div class="mobile-notch"></div>

            <!-- iFrame menampilkan preview template -->
            <iframe class="mobile-iframe"
                    src="{{ url('/templates/' . $slug . '/' . $id) }}"
                    title="Mobile Invitation Preview">
            </iframe>
        </div>
    </main>

    <!-- Floating Chat CS Button -->
    <a href="#" class="chat-cs">
        <span>💬</span> Chat CS
    </a>

</body>

</html>
