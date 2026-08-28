<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
            overflow: hidden; /* Mencegah scrollbar di luar frame (parent) */
            background-color: #0b0c10;
        }

        body {
            color: #d4af37;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            flex-direction: column;
        }

        /* Desktop & Tablet: Centered wrapper */
        .preview-wrapper {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: radial-gradient(circle at center, #030821ff 0%, #0b0c10 100%);
            overflow: hidden;
        }

        /* Device wrapper for scaling */
        .preview-device {
            position: absolute;
            top: 50%;
            left: 50%;
            transform-origin: center center;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        /* Phone frame */
        .preview-window {
            background: #fff;
            overflow: hidden;
            position: relative;
            width: 375px;
            height: 750px;
            border-radius: 3rem;
            border: 10px solid #2a2a2c;
            outline: 1px solid rgba(212, 175, 55, 0.3);
            display: flex;
            flex-direction: column;
        }

        /* Notch */
        .preview-notch {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 95px;
            height: 22px;
            background: #2a2a2c;
            border-radius: 1rem;
            z-index: 30;
        }

        /* Wrapper untuk iFrame agar scrollbar bisa dihide sempurna */
        .iframe-container {
            flex: 1;
            width: 100%;
            overflow: hidden;
            position: relative;
            border-radius: 0 0 2.5rem 2.5rem;
        }

        /* iFrame */
        .mobile-iframe {
            width: 100%;
            height: 100%;
            border: none;
            background-color: #fff;
            display: block;
        }

        /* =============================================
           FLOATING ACTION BUTTONS (POJOK KIRI BAWAH - DESKTOP)
        ============================================= */
        .action-bar {
            position: fixed;
            bottom: 20px;
            left: 20px; /* Posisi kiri bawah di Desktop */
            display: flex;
            gap: 8px;
            z-index: 100;
            background: rgba(20, 20, 25, 0.6); /* Glassmorphism gelap elegan */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 6px;
            border-radius: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }

        .action-btn {
            text-decoration: none;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 12px;
            padding: 8px 16px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.3s ease;
            cursor: pointer;
            white-space: nowrap;
            letter-spacing: 0.5px;
        }

        .btn-back {
            color: #e0e0e0;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn-use {
            background: rgba(255, 255, 255, 0.95);
            color: #121212;
            border: 1px solid transparent;
        }

        .btn-use:hover {
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        /* =============================================
           MOBILE VIEW: Fullscreen tanpa frame & Tombol Center Bawah
        ============================================= */
        @media (max-width: 767.98px) {
            .preview-wrapper {
                padding: 0;
                background: #fff;
            }

            .preview-device {
                position: relative;
                top: 0;
                left: 0;
                transform: none !important;
                box-shadow: none;
            }

            .preview-window {
                width: 100vw;
                height: 100vh;
                height: 100dvh;
                border-radius: 0;
                border: none;
                outline: none;
            }

            .preview-notch {
                display: none;
            }

            .iframe-container {
                border-radius: 0;
            }

            /* Posisi tombol berubah menjadi TENGAH BAWAH di Mobile */
            .action-bar {
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
            }
        }
    </style>
</head>

<body>
    <!-- Desktop & Tablet: Wrapper dengan Device Frame -->
    <main class="preview-wrapper">
        <div class="preview-device">
            <div class="preview-window">
                <div class="preview-notch"></div>

                <!-- Container untuk menyembunyikan scrollbar -->
                <div class="iframe-container">
                    <!-- iFrame menampilkan preview template -->
                    <iframe class="mobile-iframe"
                            src="{{ url('/templates/' . $slug . '/' . $id) }}"
                            title="Template Preview"
                            scrolling="yes">
                    </iframe>
                </div>
            </div>
        </div>
    </main>

    <!-- Floating Action Buttons -->
    <div class="action-bar">
        <a href="javascript:history.back()" class="action-btn btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
            </svg>
            Kembali
        </a>
        <a href="{{ url('/dashboard') }}?template_id={{ $id }}" class="action-btn btn-use">
            Gunakan
        </a>
    </div>

    <script>
        function scalePreviewDevice() {
            const device = document.querySelector('.preview-device');
            if (!device) return;

            if (window.innerWidth <= 767.98) {
                device.style.transform = 'none';
                device.style.top = '0';
                device.style.left = '0';
                return;
            }

            // Kembalikan ke posisi tengah saat di Desktop
            device.style.top = '50%';
            device.style.left = '50%';

            // Lebar = 375px + 20px (border kiri kanan) = 395px
            // Tinggi = 750px + 20px (border atas bawah) = 770px
            const frameWidth = 395;
            const frameHeight = 770;
            const padding = 40; // Jarak aman dari tepi browser

            const availableWidth = window.innerWidth - padding;
            const availableHeight = window.innerHeight - padding;

            const scale = Math.min(availableWidth / frameWidth, availableHeight / frameHeight, 1);
            device.style.transform = 'translate(-50%, -50%) scale(' + scale + ')';
        }

        // Fungsi untuk menghilangkan scrollbar di dalam iframe (tapi tetap bisa di-scroll)
        function hideIframeScrollbar() {
            const iframe = document.querySelector('.mobile-iframe');
            if (!iframe) return;

            iframe.onload = function() {
                try {
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    const style = iframeDoc.createElement('style');
                    style.innerHTML = `
                        html, body {
                            overflow-y: auto !important;
                            -webkit-overflow-scrolling: touch !important;
                            -ms-overflow-style: none !important;
                            scrollbar-width: none !important;
                        }
                        ::-webkit-scrollbar {
                            display: none !important;
                        }
                    `;
                    iframeDoc.head.appendChild(style);
                } catch(e) {
                    console.warn("Tidak bisa mengubah CSS iframe (kemungkinan masalah Cross-Origin):", e);
                }
            };
        }

        window.addEventListener('resize', scalePreviewDevice);
        window.addEventListener('orientationchange', function () {
            setTimeout(scalePreviewDevice, 100);
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            scalePreviewDevice();
            hideIframeScrollbar();
        });
    </script>

</body>

</html>