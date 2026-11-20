<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Kamera Foto Tamu</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --safe-top: env(safe-area-inset-top, 0px);
            --safe-bottom: env(safe-area-inset-bottom, 0px);
        }

        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        html,
        body {
            font-family: 'Inter', sans-serif;
            background-color: #000000;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100dvh;
            overflow: hidden;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        /* Padding Safe Area untuk Ponsel Berponi (Notch / Dynamic Island) */
        .safe-pt {
            padding-top: max(14px, var(--safe-top));
        }

        .safe-pb {
            padding-bottom: max(16px, var(--safe-bottom));
        }

        /* Efek animasi flash saat jepret */
        @keyframes cameraFlash {
            0% {
                opacity: 0.95;
            }

            100% {
                opacity: 0;
            }
        }

        .animate-flash {
            animation: cameraFlash 0.35s ease-out forwards;
        }

        /* Animasi pulse halus pada bingkai panduan */
        @keyframes guidePulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.012);
            }
        }

        .guide-box-pulse {
            animation: guidePulse 3s infinite ease-in-out;
        }

        /* Mirror otomatis saat menggunakan kamera depan */
        .video-mirror {
            transform: scaleX(-1);
        }

        /* Sembunyikan scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* ===== Bingkai Foto (Frame) ===== */
        #guide-frame {
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        /* Area foto transparan (dipakai untuk crop) */
        .photo-window {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }

        /* Overlay bingkai dekoratif (SVG) */
        .frame-svg {
            display: none;
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        #guide-frame.frame-rustic .frame-svg,
        #guide-frame.frame-minimal .frame-svg {
            display: block;
        }

        /* Caption polaroid (nama + brand) */
        .photo-caption {
            display: none;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 64px;
            background: #ffffff;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 0 14px;
            border-radius: 0 0 4px 4px;
        }

        .photo-caption .couple {
            font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
            font-weight: 700;
            color: #1B2A4A;
            font-size: 15px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .photo-caption .brand {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.03em;
            color: #A68B4B;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* Polaroid (default): bingkai putih + caption */
        #guide-frame.frame-polaroid {
            border: 16px solid #ffffff;
            border-bottom-width: 0;
            border-radius: 8px;
            background: transparent;
            box-shadow: 0 12px 34px rgba(0, 0, 0, 0.4);
        }

        #guide-frame.frame-polaroid .photo-window {
            bottom: 64px;
        }

        #guide-frame.frame-polaroid .photo-caption {
            display: flex;
        }

        #guide-frame.frame-hidden {
            opacity: 0;
        }

        /* ===== Focus Ring (Tap to Focus) ===== */
        #focus-ring {
            position: absolute;
            width: 68px;
            height: 68px;
            margin-left: -34px;
            margin-top: -34px;
            border: 2px solid #f5b82e;
            border-radius: 10px;
            z-index: 25;
            pointer-events: none;
            opacity: 0;
            transform: scale(1.5);
            transition: opacity 0.18s ease, transform 0.18s ease;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.25);
        }

        #focus-ring.focus-active {
            opacity: 1;
            transform: scale(1);
        }

        /* ===== Frame Selector Chips ===== */
        .frame-chip {
            white-space: nowrap;
            padding: 0.4rem 0.95rem;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            color: rgb(212 212 216);
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(0, 0, 0, 0.35);
            transition: all 0.2s ease;
        }

        .frame-chip.active {
            background: #f5b82e;
            color: #000;
            border-color: #f5b82e;
        }

        /* ===== Bottom Sheet Gallery (dark) ===== */
        .sheet-tab {
            padding: 0.4rem 0.9rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #e4e4e7;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
        }

        .sheet-tab.active {
            background: #c6a962;
            color: #1b2a4a;
        }

        .sheet-del {
            position: absolute;
            top: 0.35rem;
            right: 0.35rem;
            width: 1.6rem;
            height: 1.6rem;
            border-radius: 9999px;
            background: rgba(220, 38, 38, 0.92);
            color: #fff;
            font-size: 1.1rem;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            z-index: 5;
        }
    </style>
</head>

<body class="bg-black text-white flex items-center justify-center w-full h-[100dvh] overflow-hidden">

    <!-- Container Utama: 100% Layar Penuh di Mobile (100dvh), Bingkai Rapi di Layar Besar -->
    <div id="app-container"
        class="relative w-full h-[100dvh] md:w-[412px] md:h-[860px] md:max-h-[95dvh] bg-black md:rounded-[36px] md:border-[4px] md:border-zinc-800 md:shadow-2xl overflow-hidden flex flex-col justify-between">

        <!-- Flash Overlay Effect saat Jepret -->
        <div id="flash-overlay" class="pointer-events-none absolute inset-0 bg-white opacity-0 z-50"></div>

        <!-- ========================================================= -->
        <!-- 1. TOP BAR CONTROLS (Transparan/Gelap Halus) -->
        <!-- ========================================================= -->
        <header
            class="relative z-30 flex items-center justify-between px-5 safe-pt pb-3 bg-gradient-to-b from-black/90 via-black/65 to-transparent">
            <!-- Tombol Lampu Kilat (Flash / Torch) -->
            <button id="btn-flash" type="button" aria-label="Lampu Kilat"
                class="p-3 rounded-full hover:bg-white/15 active:scale-90 transition flex items-center justify-center relative">
                <!-- Icon Flash Off (Default) -->
                <svg id="icon-flash-off" class="w-6 h-6 text-white/90" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" opacity="0.45" />
                    <line x1="2" y1="2" x2="22" y2="22" />
                </svg>
                <!-- Icon Flash On -->
                <svg id="icon-flash-on" class="w-6 h-6 hidden text-[#F5B82E]" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                </svg>
                <span id="flash-dot" class="hidden absolute top-2 right-2 w-2 h-2 rounded-full bg-[#F5B82E]"></span>
            </button>

            <!-- Tombol Rasio Aspek (3:4 / Full) -->
            <button id="btn-aspect" type="button" aria-label="Rasio Aspek"
                class="px-3 py-1.5 rounded-md border border-white/75 bg-black/30 backdrop-blur-sm text-xs font-bold tracking-wider hover:bg-white/15 active:scale-95 transition">
                <span id="aspect-label">3:4</span>
            </button>

            <!-- Tombol Grid 3x3 (Garis Bantu) -->
            <button id="btn-grid" type="button" aria-label="Garis Bantu Grid"
                class="p-3 rounded-full hover:bg-white/15 active:scale-90 transition text-white/90"
                title="Garis Bantu 3x3">
                <svg id="icon-grid" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="3" y1="9" x2="21" y2="9"></line>
                    <line x1="3" y1="15" x2="21" y2="15"></line>
                    <line x1="9" y1="3" x2="9" y2="21"></line>
                    <line x1="15" y1="3" x2="15" y2="21"></line>
                </svg>
            </button>

            <!-- Tombol Bantuan (?) -->
            <button id="btn-help" type="button" aria-label="Bantuan Memotret"
                class="p-3 rounded-full hover:bg-white/15 active:scale-90 transition text-white/90">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </button>

            @if($invitation ?? null)
            <!-- Tombol Galeri (buka bottom sheet) -->
            <button id="btn-open-gallery" type="button" aria-label="Galeri" title="Galeri"
                class="p-3 rounded-full hover:bg-white/15 active:scale-90 transition text-white/90">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
            </button>
            @endif
        </header>

        <!-- ========================================================= -->
        <!-- 2. CAMERA VIEWFINDER & BINGKAI PANDUAN TIKET / HTM -->
        <!-- ========================================================= -->
        <main id="viewfinder-wrapper"
            class="relative flex-1 w-full flex items-center justify-center overflow-hidden bg-black">

            <!-- Area Viewfinder Aktif (Dapat berubah rasio 3:4 atau Full) -->
            <div id="viewfinder-box"
                class="relative w-full h-full flex items-center justify-center overflow-hidden transition-all duration-300">

                <!-- Video Stream Kamera Asli HP (WebRTC) -->
                <video id="camera-video" autoplay playsinline muted
                    class="absolute inset-0 w-full h-full object-cover hidden"></video>

                <!-- Indikator Fokus (Tap to Focus) -->
                <div id="focus-ring"></div>

                <!-- Fallback Simulasi Elegan (Jika Kamera Tidak Tersedia / Izin Ditolak) -->
                <div id="camera-fallback"
                    class="absolute inset-0 w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-stone-900 via-neutral-900 to-zinc-950 p-4">
                    <div class="absolute inset-0 opacity-35"
                        style="background-image: radial-gradient(circle at 50% 45%, #786a5e 0%, #292524 65%, #09090b 100%);">
                    </div>

                    <!-- Tombol Aktifkan Kamera Manual -->
                    <div class="relative z-30 mt-52 flex flex-col items-center text-center space-y-2">
                        <p id="camera-error-msg"
                            class="text-[11px] text-zinc-300 bg-black/60 backdrop-blur-md px-3 py-1 rounded-full border border-white/10">
                            Kamera belum aktif atau izin diperlukan
                        </p>
                        <button id="btn-enable-camera" type="button"
                            class="px-4 py-2 rounded-full bg-[#F5B82E] hover:bg-amber-400 active:scale-95 transition text-xs font-bold text-black shadow-lg flex items-center gap-1.5">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2">
                                <path
                                    d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                </path>
                                <circle cx="12" cy="13" r="4"></circle>
                            </svg>
                            Aktifkan Kamera
                        </button>
                    </div>
                </div>

                <!-- Garis Bantu Grid 3x3 Opsional -->
                <div id="grid-overlay"
                    class="hidden pointer-events-none absolute inset-0 grid grid-cols-3 grid-rows-3 z-10">
                    <div class="border-r border-b border-white/25"></div>
                    <div class="border-r border-b border-white/25"></div>
                    <div class="border-b border-white/25"></div>
                    <div class="border-r border-b border-white/25"></div>
                    <div class="border-r border-b border-white/25"></div>
                    <div class="border-b border-white/25"></div>
                    <div class="border-r border-white/25"></div>
                    <div class="border-r border-white/25"></div>
                    <div></div>
                </div>

                <!-- Masking Gelap Halus di Luar Bingkai Panduan -->
                <div id="viewfinder-dim" class="pointer-events-none absolute inset-0 bg-black/30 z-10 opacity-0"></div>

                <!-- BINGKAI FOTO (Polaroid / Wedding) -->
                <div id="guide-frame"
                    class="frame-polaroid relative z-20 w-[84%] max-w-[340px] aspect-[3/4]">

                    <!-- Area Foto Transparan (tempat kamera terlihat) -->
                    <div id="photo-window" class="photo-window"></div>

                    <!-- Overlay bingkai dekoratif (Rustic / Minimal) -->
                    <img id="frame-svg" class="frame-svg" alt="" />

                    <!-- Caption Polaroid: Nama Mempelai + Brand -->
                    <div class="photo-caption">
                        <span class="couple">{{ $invitation ? trim(($invitation->groom_nickname ?: $invitation->groom_name ?: 'Groom').' & '.($invitation->bride_nickname ?: $invitation->bride_name ?: 'Bride')) : 'Nama Mempelai' }}</span>
                        <span class="brand">RuangUndang</span>
                    </div>
                </div>

                <!-- Masker Rasio 3:4 (Aktif saat mode 3:4 dipilih agar rasio viewfinder berubah nyata) -->
                <div id="aspect-mask-top"
                    class="pointer-events-none absolute top-0 left-0 right-0 h-[6%] bg-black/85 z-20 transition-all duration-300">
                </div>
                <div id="aspect-mask-bottom"
                    class="pointer-events-none absolute bottom-0 left-0 right-0 h-[6%] bg-black/85 z-20 transition-all duration-300">
                </div>
            </div>
        </main>

        <!-- ========================================================= -->
        <!-- 3. BOTTOM CONTROLS (Mode Selector & Shutter Bar) -->
        <!-- ========================================================= -->
        <footer class="relative z-30 bg-black pt-3 safe-pb flex flex-col justify-end">

            <!-- Pemilih Bingkai Foto (Frame) -->
            <div class="flex items-center justify-center gap-2 mb-4 px-4 overflow-x-auto no-scrollbar">
                <div id="frame-selector" class="flex items-center gap-2">
                    <button type="button" data-frame="polaroid"
                        class="frame-chip frame-btn active">Polaroid</button>
                    <button type="button" data-frame="rustic" class="frame-chip frame-btn">Rustic</button>
                    <button type="button" data-frame="minimal" class="frame-chip frame-btn">Minimal</button>
                    <button type="button" data-frame="none" class="frame-chip frame-btn">Tanpa Frame</button>
                </div>
            </div>

            <!-- Kuota Foto per Perangkat -->
            <div class="text-center mb-2">
                <span id="quota-badge"
                    class="inline-block text-[11px] font-semibold text-white/75 bg-white/10 px-3 py-1 rounded-full">
                    0 / 5 foto
                </span>
            </div>

            <!-- Baris Tombol Utama: Galeri - Shutter - Flip Kamera -->
            <div class="flex items-center justify-around px-6 mb-1">

                <!-- Tombol Galeri (Kiri) + Thumbnail Foto Terakhir -->
                <label for="gallery-input"
                    class="w-13 h-13 w-[52px] h-[52px] rounded-full bg-zinc-800/90 hover:bg-zinc-700 active:scale-90 transition flex items-center justify-center cursor-pointer border border-white/15 overflow-hidden relative shadow-md"
                    title="Unggah dari Galeri">
                    <img id="last-thumb" src="" alt="Foto Terakhir" class="hidden w-full h-full object-cover">
                    <svg id="gallery-icon" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    <input id="gallery-input" type="file" accept="image/*" class="hidden">
                </label>

                <!-- Tombol Rana / Shutter Putih Besar dengan Cincin Luar Kuning/Oranye (Tengah) -->
                <button id="btn-shutter" type="button" aria-label="Ambil Foto"
                    class="group relative w-[76px] h-[76px] rounded-full flex items-center justify-center p-[4px] border-[3.5px] border-[#F5B82E] bg-black/50 active:scale-90 transition-transform duration-150 shadow-xl">
                    <span class="w-full h-full rounded-full bg-white group-hover:bg-zinc-100 transition-colors"></span>
                </button>

                <!-- Tombol Flip / Ganti Kamera Depan-Belakang (Kanan) -->
                <button id="btn-switch-cam" type="button" aria-label="Ganti Kamera Depan atau Belakang"
                    class="w-[52px] h-[52px] rounded-full bg-zinc-800/90 hover:bg-zinc-700 active:scale-90 transition flex items-center justify-center border border-white/15 text-white shadow-md">
                    <svg id="switch-icon" class="w-6 h-6 transition-transform duration-300" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                        <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                        <path d="M16 16h5v5" />
                    </svg>
                </button>
            </div>
        </footer>

        <!-- ========================================================= -->
        <!-- MODAL PRATINJAU HASIL FOTO TIKET / HTM -->
        <!-- ========================================================= -->
        <div id="preview-modal" class="hidden absolute inset-0 z-40 bg-black flex flex-col justify-between">
            <!-- Header Modal Preview -->
            <div class="flex items-center justify-between px-5 safe-pt pb-3 bg-zinc-950 border-b border-white/10">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#F5B82E]"></span>
                    <span class="text-sm font-bold text-white">Hasil Foto</span>
                </div>
                <span id="preview-mode-badge"
                    class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-[#F5B82E]/15 text-[#F5B82E] border border-[#F5B82E]/30">
                    FOTO HTM
                </span>
            </div>

            <!-- Area Gambar Hasil + Toggle Crop Area Tiket -->
            <div
                class="relative flex-1 flex flex-col items-center justify-center p-4 bg-zinc-950 overflow-hidden gap-3">
                <div class="relative flex-1 w-full flex items-center justify-center overflow-hidden">
                    <img id="captured-image" src="" alt="Pratinjau Foto HTM"
                        class="max-w-full max-h-full rounded-2xl border border-white/15 shadow-2xl object-contain">
                </div>

                <!-- Pilihan Mode Simpan: Potong Sesuai Bingkai atau Penuh -->
                <div class="flex items-center bg-zinc-900 p-1 rounded-xl border border-white/10 text-xs">
                    <button id="btn-crop-frame" type="button"
                        class="px-3.5 py-1.5 rounded-lg font-semibold bg-[#F5B82E] text-black transition">
                        Potong Area
                    </button>
                    <button id="btn-crop-full" type="button"
                        class="px-3.5 py-1.5 rounded-lg font-medium text-zinc-400 hover:text-white transition">
                        Foto Penuh
                    </button>
                </div>
            </div>

            <!-- Tombol Aksi Bawah Preview -->
            <div class="px-5 pt-3 safe-pb bg-zinc-950 border-t border-white/10 flex items-center justify-between gap-3">
                <button id="btn-retake" type="button"
                    class="flex-1 py-3.5 px-4 rounded-2xl bg-zinc-800 hover:bg-zinc-700 active:scale-95 transition text-sm font-semibold text-white flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                    </svg>
                    Foto Ulang
                </button>
                <button id="btn-save" type="button"
                    class="flex-1 py-3.5 px-4 rounded-2xl bg-[#F5B82E] hover:bg-amber-400 active:scale-95 transition text-sm font-bold text-black flex items-center justify-center gap-2 shadow-lg shadow-amber-500/20">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Gunakan / Unduh
                </button>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- MODAL BANTUAN & TIPS MEMOTRET TIKET -->
        <!-- ========================================================= -->
        <div id="help-modal"
            class="hidden absolute inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-end sm:items-center justify-center p-4">
            <div class="w-full bg-zinc-900 border border-white/15 rounded-3xl p-5 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-white/10 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#F5B82E]"></span>
                        <h3 class="text-base font-bold text-white">Tips Memotret</h3>
                    </div>
                    <button id="btn-close-help" type="button"
                        class="p-1.5 rounded-full hover:bg-white/10 text-zinc-400 hover:text-white">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <div class="space-y-3 text-xs text-zinc-300 leading-relaxed">
                    <div class="flex items-start gap-2.5">
                        <span class="px-2 py-0.5 rounded bg-[#F5B82E]/20 text-[#F5B82E] font-bold">1</span>
                        <p>Ketuk layar pada wajah untuk <strong class="text-white">fokus</strong>, lalu susun pose
                            di dalam bingkai agar wajah terlihat jelas.</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="px-2 py-0.5 rounded bg-[#F5B82E]/20 text-[#F5B82E] font-bold">2</span>
                        <p>Pastikan pencahayaan cukup. Gunakan ikon <strong class="text-[#F5B82E]">Petir
                                (Flash)</strong> di pojok kiri atas jika memotret di tempat gelap.</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="px-2 py-0.5 rounded bg-[#F5B82E]/20 text-[#F5B82E] font-bold">3</span>
                        <p>Pilih bingkai sesuai selera (Elegan, Rustic, Minimal) atau <strong class="text-[#F5B82E]">Tanpa Frame</strong> untuk foto full.</p>
                    </div>
                </div>

                <button id="btn-ok-help" type="button"
                    class="w-full py-3 rounded-2xl bg-[#F5B82E] hover:bg-amber-400 text-xs font-bold text-black transition">
                    Siap Memotret
                </button>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- BOTTOM SHEET GALERI (Tamu / Pengantin)                    -->
        <!-- ========================================================= -->
        <div id="gallery-sheet" class="hidden absolute inset-0 z-40">
            <div id="gallery-sheet-backdrop" class="absolute inset-0 bg-black/60"></div>
            <div id="gallery-sheet-panel"
                class="absolute bottom-0 left-0 right-0 bg-zinc-900 rounded-t-3xl max-h-[82%] flex flex-col translate-y-full shadow-2xl"
                style="transition: transform 0.3s ease;">
                <div class="flex items-center justify-between px-5 py-4 border-b border-white/10 flex-shrink-0">
                    <h3 class="font-bold text-white">Galeri</h3>
                    <button id="gallery-sheet-close" type="button" aria-label="Tutup"
                        class="p-2 rounded-full hover:bg-white/10 text-white">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="flex gap-2 px-4 py-3 flex-shrink-0">
                    <button type="button" data-tab="guest" class="sheet-tab active">Galeri Tamu</button>
                    <button type="button" data-tab="couple" class="sheet-tab">Galeri Pengantin</button>
                </div>
                <div id="sheet-grid" class="overflow-y-auto px-4 pb-6 grid grid-cols-3 gap-2 content-start"></div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- LIGHTBOX GALERI (dari bottom sheet) -->
        <!-- ========================================================= -->
        <div id="sheet-lightbox" class="hidden absolute inset-0 z-50 bg-black/95 flex flex-col">
            <div class="flex items-center justify-between gap-3 px-4 py-3 flex-shrink-0">
                <span id="sheet-lb-caption" class="text-white text-sm font-medium truncate"></span>
                <button id="sheet-lb-close" type="button" aria-label="Tutup"
                    class="p-2 rounded-full hover:bg-white/10 text-white flex-shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="flex-1 relative flex items-center justify-center p-3 overflow-hidden">
                <button id="sheet-lb-prev" type="button" aria-label="Sebelumnya"
                    class="absolute left-2 z-10 w-10 h-10 rounded-full bg-white/15 text-white text-2xl flex items-center justify-center active:scale-90">&#10094;</button>
                <img id="sheet-lb-img" src="" alt="Foto" class="max-w-full max-h-full object-contain rounded-lg">
                <button id="sheet-lb-next" type="button" aria-label="Berikutnya"
                    class="absolute right-2 z-10 w-10 h-10 rounded-full bg-white/15 text-white text-2xl flex items-center justify-center active:scale-90">&#10095;</button>
            </div>
        </div>

        <!-- Toast Notifikasi Singkat -->
        <div id="toast"
            class="pointer-events-none opacity-0 transition-opacity duration-300 absolute top-20 left-1/2 -translate-x-1/2 z-50 px-4 py-2 rounded-full bg-zinc-900/95 border border-[#F5B82E]/40 text-xs font-semibold text-[#F5B82E] shadow-xl whitespace-nowrap">
            Notifikasi
        </div>

        <!-- Canvas Tersembunyi untuk Pemrosesan Gambar -->
        <canvas id="capture-canvas" class="hidden"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Data undangan tujuan penyimpanan foto (galeri pengantin)
            const eventId = @js($invitation->id ?? '');
            const eventSlug = @js($invitation->slug ?? '');
            const coupleName = @js($invitation
                ? trim(($invitation->groom_nickname ?: $invitation->groom_name ?: '').' & '.($invitation->bride_nickname ?: $invitation->bride_name ?: ''))
                : '');

            // Referensi Elemen Utama
            const video = document.getElementById('camera-video');
            const fallback = document.getElementById('camera-fallback');
            const cameraErrorMsg = document.getElementById('camera-error-msg');
            const btnEnableCamera = document.getElementById('btn-enable-camera');
            const canvas = document.getElementById('capture-canvas');
            const flashOverlay = document.getElementById('flash-overlay');

            // Kontrol Atas
            const btnFlash = document.getElementById('btn-flash');
            const iconFlashOff = document.getElementById('icon-flash-off');
            const iconFlashOn = document.getElementById('icon-flash-on');
            const flashDot = document.getElementById('flash-dot');
            const btnAspect = document.getElementById('btn-aspect');
            const aspectLabel = document.getElementById('aspect-label');
            const aspectMaskTop = document.getElementById('aspect-mask-top');
            const aspectMaskBottom = document.getElementById('aspect-mask-bottom');
            const btnGrid = document.getElementById('btn-grid');
            const gridOverlay = document.getElementById('grid-overlay');
            const btnHelp = document.getElementById('btn-help');

            // Mode & Bingkai
            const frameBtns = document.querySelectorAll('.frame-btn');
            const guideFrame = document.getElementById('guide-frame');
            const photoWindow = document.getElementById('photo-window');
            const frameSvgImg = document.getElementById('frame-svg');
            const viewfinderBox = document.getElementById('viewfinder-box');
            const focusRing = document.getElementById('focus-ring');

            // Kontrol Bawah
            const btnShutter = document.getElementById('btn-shutter');
            const btnSwitchCam = document.getElementById('btn-switch-cam');
            const switchIcon = document.getElementById('switch-icon');
            const galleryInput = document.getElementById('gallery-input');
            const lastThumb = document.getElementById('last-thumb');
            const galleryIcon = document.getElementById('gallery-icon');

            // Modal Preview & Crop
            const previewModal = document.getElementById('preview-modal');
            const capturedImage = document.getElementById('captured-image');
            const previewModeBadge = document.getElementById('preview-mode-badge');
            const btnCropFrame = document.getElementById('btn-crop-frame');
            const btnCropFull = document.getElementById('btn-crop-full');
            const btnRetake = document.getElementById('btn-retake');
            const btnSave = document.getElementById('btn-save');

            // Modal Bantuan
            const helpModal = document.getElementById('help-modal');
            const btnCloseHelp = document.getElementById('btn-close-help');
            const btnOkHelp = document.getElementById('btn-ok-help');

            // State Aplikasi
            let currentStream = null;
            let facingMode = 'environment'; // Prioritas kamera belakang HP
            let isFlashOn = false;
            let isFullAspect = false; // Default 3:4
            let isGridOn = false;
            let currentFrame = 'polaroid';
            let frameEnabled = true;
            let isCameraActive = false;

            // Kuota foto per perangkat
            const PHOTO_LIMIT = 5;
            let myPhotoCount = 0;

            // Penyimpanan Data Gambar (Versi Terpotong & Versi Penuh)
            let croppedDataUrl = '';
            let fullDataUrl = '';
            let useCroppedVersion = true;

            // ===== Bingkai Dekoratif SVG (Rustic & Minimal) =====
            const FRAMES_SVG = {
                rustic: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 800"><rect x="12" y="12" width="576" height="776" rx="16" fill="none" stroke="#8B6F47" stroke-width="5"/><rect x="26" y="26" width="548" height="748" rx="10" fill="none" stroke="#D6C4A0" stroke-width="2"/><g stroke="#7A8B5A" stroke-width="3" fill="none" stroke-linecap="round"><path d="M26 96 C 52 74, 62 48, 96 26"/><path d="M46 74 C 42 62, 34 56, 24 54"/><path d="M64 54 C 66 44, 60 36, 50 32"/><path d="M574 96 C 548 74, 538 48, 504 26"/><path d="M554 74 C 558 62, 566 56, 576 54"/><path d="M536 54 C 534 44, 540 36, 550 32"/><path d="M26 704 C 52 726, 62 752, 96 774"/><path d="M46 726 C 42 738, 34 744, 24 746"/><path d="M574 704 C 548 726, 538 752, 504 774"/><path d="M554 726 C 558 738, 566 744, 576 746"/></g><g fill="#B5654A"><circle cx="42" cy="60" r="4"/><circle cx="58" cy="44" r="4"/><circle cx="558" cy="60" r="4"/><circle cx="542" cy="44" r="4"/><circle cx="42" cy="740" r="4"/><circle cx="558" cy="740" r="4"/></g></svg>',
                minimal: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 800"><rect x="14" y="14" width="572" height="772" rx="10" fill="none" stroke="#C6A962" stroke-width="4"/><rect x="28" y="28" width="544" height="744" rx="6" fill="none" stroke="#E8D5A3" stroke-width="2"/><g fill="#C6A962"><path d="M14 2 L26 14 L14 26 L2 14 Z"/><path d="M586 2 L598 14 L586 26 L574 14 Z"/><path d="M14 774 L26 786 L14 798 L2 786 Z"/><path d="M586 774 L598 786 L586 798 L574 786 Z"/><path d="M300 2 L312 14 L300 26 L288 14 Z"/></g></svg>'
            };
            let frameSvgImage = null;

            function svgDataUrl(svg) {
                return 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svg);
            }

            function loadFrameSvg(svg) {
                if (!svg) {
                    frameSvgImage = null;
                    return;
                }
                const img = new Image();
                img.onload = () => { frameSvgImage = img; };
                img.onerror = () => { frameSvgImage = null; };
                img.src = svgDataUrl(svg);
            }

            // Fungsi Menampilkan Toast
            function showToast(msg) {
                const toast = document.getElementById('toast');
                toast.textContent = msg;
                toast.classList.remove('opacity-0');
                clearTimeout(toast._timer);
                toast._timer = setTimeout(() => {
                    toast.classList.add('opacity-0');
                }, 2200);
            }

            // Format tanggal ISO -> "20 Nov 2026"
            function formatDate(iso) {
                if (!iso) return '';
                const d = new Date(iso);
                if (isNaN(d.getTime())) return '';
                return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            }

            // ID perangkat untuk kepemilikan foto
            function getDeviceId() {
                let id = localStorage.getItem('guest_device_id');
                if (!id) {
                    id = 'guest_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                    localStorage.setItem('guest_device_id', id);
                }
                return id;
            }

            // Badge kuota foto
            const quotaBadge = document.getElementById('quota-badge');
            function updateQuotaBadge() {
                if (!quotaBadge) return;
                quotaBadge.textContent = myPhotoCount + ' / ' + PHOTO_LIMIT + ' foto';
                if (myPhotoCount >= PHOTO_LIMIT) {
                    quotaBadge.classList.add('text-red-300');
                    quotaBadge.classList.remove('text-white/75');
                } else {
                    quotaBadge.classList.remove('text-red-300');
                    quotaBadge.classList.add('text-white/75');
                }
            }
            updateQuotaBadge();

            // =========================================================
            // 1. INISIALISASI KAMERA ASLI HP (WebRTC getUserMedia)
            // =========================================================
            async function startCamera(preferredFacing = 'environment') {
                // Hentikan stream sebelumnya jika ada
                if (currentStream) {
                    currentStream.getTracks().forEach(track => track.stop());
                    currentStream = null;
                }

                // Reset status flash saat ganti kamera
                isFlashOn = false;
                iconFlashOn.classList.add('hidden');
                iconFlashOff.classList.remove('hidden');
                flashDot.classList.add('hidden');

                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    isCameraActive = false;
                    cameraErrorMsg.textContent = 'Browser tidak mendukung akses kamera langsung (Gunakan HTTPS)';
                    return;
                }

                try {
                    const constraints = {
                        video: {
                            facingMode: { ideal: preferredFacing },
                            width: { ideal: 1920 },
                            height: { ideal: 1080 }
                        },
                        audio: false
                    };

                    currentStream = await navigator.mediaDevices.getUserMedia(constraints);
                    video.srcObject = currentStream;

                    // Terapkan efek cermin hanya jika kamera depan
                    if (preferredFacing === 'user') {
                        video.classList.add('video-mirror');
                    } else {
                        video.classList.remove('video-mirror');
                    }

                    await video.play();
                    video.classList.remove('hidden');
                    fallback.classList.add('hidden');
                    isCameraActive = true;
                } catch (err) {
                    // Fallback jika kamera belakang tidak ada (misal di laptop), coba kamera default apa saja
                    if (preferredFacing === 'environment') {
                        try {
                            currentStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
                            video.srcObject = currentStream;
                            video.classList.remove('video-mirror');
                            await video.play();
                            video.classList.remove('hidden');
                            fallback.classList.add('hidden');
                            isCameraActive = true;
                            return;
                        } catch (fallbackErr) {
                            handleCameraUnavailable(fallbackErr);
                        }
                    } else {
                        handleCameraUnavailable(err);
                    }
                }
            }

            function handleCameraUnavailable(error) {
                isCameraActive = false;
                video.classList.add('hidden');
                fallback.classList.remove('hidden');
                if (error && (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError')) {
                    cameraErrorMsg.textContent = 'Izin kamera ditolak. Ketuk tombol di bawah untuk mengizinkan.';
                } else {
                    cameraErrorMsg.textContent = 'Mode Simulasi (Kamera tidak terdeteksi)';
                }
            }

            // Otomatis minta izin kamera saat dibuka
            startCamera(facingMode);

            // Tombol manual aktifkan kamera
            btnEnableCamera.addEventListener('click', () => {
                startCamera(facingMode);
            });

            // =========================================================
            // 2. KONTROL ATAS (Flash, Rasio Aspek, Grid, Bantuan)
            // =========================================================
            btnFlash.addEventListener('click', async () => {
                isFlashOn = !isFlashOn;

                if (isFlashOn) {
                    iconFlashOff.classList.add('hidden');
                    iconFlashOn.classList.remove('hidden');
                    flashDot.classList.remove('hidden');
                } else {
                    iconFlashOn.classList.add('hidden');
                    iconFlashOff.classList.remove('hidden');
                    flashDot.classList.add('hidden');
                }

                // Kontrol Torch nyata pada perangkat mobile jika didukung
                if (currentStream) {
                    const track = currentStream.getVideoTracks()[0];
                    if (track && typeof track.getCapabilities === 'function') {
                        const capabilities = track.getCapabilities();
                        if (capabilities.torch) {
                            try {
                                await track.applyConstraints({
                                    advanced: [{ torch: isFlashOn }]
                                });
                                showToast(isFlashOn ? 'Lampu Kilat: NYALA' : 'Lampu Kilat: MATI');
                                return;
                            } catch (e) {
                                // Lanjut ke notifikasi fallback
                            }
                        }
                    }
                }
                showToast(isFlashOn ? 'Lampu Kilat Layar: AKTIF' : 'Lampu Kilat: NONAKTIF');
            });

            // Toggle Rasio Aspek (3:4 <-> Full)
            btnAspect.addEventListener('click', () => {
                isFullAspect = !isFullAspect;
                if (isFullAspect) {
                    aspectLabel.textContent = 'Full';
                    aspectMaskTop.classList.add('opacity-0');
                    aspectMaskBottom.classList.add('opacity-0');
                    showToast('Rasio Viewfinder: Full');
                } else {
                    aspectLabel.textContent = '3:4';
                    aspectMaskTop.classList.remove('opacity-0');
                    aspectMaskBottom.classList.remove('opacity-0');
                    showToast('Rasio Viewfinder: 3:4');
                }
            });

            // Toggle Grid 3x3
            btnGrid.addEventListener('click', () => {
                isGridOn = !isGridOn;
                if (isGridOn) {
                    gridOverlay.classList.remove('hidden');
                    btnGrid.classList.add('text-[#F5B82E]');
                    btnGrid.classList.remove('text-white/90');
                    showToast('Garis Bantu Grid: AKTIF');
                } else {
                    gridOverlay.classList.add('hidden');
                    btnGrid.classList.remove('text-[#F5B82E]');
                    btnGrid.classList.add('text-white/90');
                    showToast('Garis Bantu Grid: NONAKTIF');
                }
            });

            // Modal Bantuan (?)
            btnHelp.addEventListener('click', () => helpModal.classList.remove('hidden'));
            btnCloseHelp.addEventListener('click', () => helpModal.classList.add('hidden'));
            btnOkHelp.addEventListener('click', () => helpModal.classList.add('hidden'));

            // =========================================================
            // 3. PEMILIH BINGKAI FOTO (Elegan | Rustic | Minimal | Tanpa Frame)
            // =========================================================
            function applyFrame(frame) {
                currentFrame = frame;
                frameBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-frame') === frame));

                if (frame === 'none') {
                    frameEnabled = false;
                    guideFrame.classList.add('frame-hidden');
                    return;
                }

                frameEnabled = true;
                guideFrame.classList.remove('frame-hidden');
                guideFrame.classList.remove('frame-polaroid', 'frame-rustic', 'frame-minimal');
                guideFrame.classList.add('frame-' + frame);

                if (frame === 'rustic' || frame === 'minimal') {
                    const svg = FRAMES_SVG[frame];
                    frameSvgImg.src = svgDataUrl(svg);
                    loadFrameSvg(svg);
                } else {
                    frameSvgImage = null;
                }
            }

            frameBtns.forEach(btn => {
                btn.addEventListener('click', () => applyFrame(btn.getAttribute('data-frame')));
            });
            applyFrame('polaroid');

            // =========================================================
            // 4. TAP TO FOCUS (Ketuk layar untuk fokus)
            // =========================================================
            function showFocusRing(clientX, clientY) {
                const rect = viewfinderBox.getBoundingClientRect();
                focusRing.style.left = (clientX - rect.left) + 'px';
                focusRing.style.top = (clientY - rect.top) + 'px';
                focusRing.classList.add('focus-active');
                clearTimeout(focusRing._timer);
                focusRing._timer = setTimeout(() => focusRing.classList.remove('focus-active'), 1200);
            }

            async function tryFocus(clientX, clientY) {
                if (!currentStream) return;
                const track = currentStream.getVideoTracks()[0];
                if (!track || typeof track.getCapabilities !== 'function') return;

                const caps = track.getCapabilities();
                const rect = viewfinderBox.getBoundingClientRect();
                const x = Math.min(1, Math.max(0, (clientX - rect.left) / rect.width));
                const y = Math.min(1, Math.max(0, (clientY - rect.top) / rect.height));

                try {
                    if (caps.focusMode && caps.focusMode.includes('manual') && caps.pointsOfInterest) {
                        await track.applyConstraints({
                            advanced: [{ focusMode: 'manual', pointsOfInterest: [{ x, y }] }]
                        });
                    } else if (caps.focusMode && caps.focusMode.includes('single-shot')) {
                        await track.applyConstraints({ advanced: [{ focusMode: 'single-shot' }] });
                    } else if (caps.focusMode && caps.focusMode.includes('continuous')) {
                        await track.applyConstraints({ advanced: [{ focusMode: 'continuous' }] });
                    }
                } catch (e) {
                    // Fokus manual tidak didukung perangkat — abaikan
                }
            }

            viewfinderBox.addEventListener('pointerdown', (e) => {
                if (!isCameraActive) return;
                showFocusRing(e.clientX, e.clientY);
                tryFocus(e.clientX, e.clientY);
            });

            // =========================================================
            // 4. FLIP KAMERA DEPAN / BELAKANG
            // =========================================================
            btnSwitchCam.addEventListener('click', () => {
                facingMode = facingMode === 'environment' ? 'user' : 'environment';
                switchIcon.classList.toggle('rotate-180');
                showToast(facingMode === 'environment' ? 'Kamera Belakang' : 'Kamera Depan');
                startCamera(facingMode);
            });

            // =========================================================
            // 5. PENGAMBILAN FOTO (SHUTTER) & PEMOTONGAN PRESISI BINGKAI
            // =========================================================
            // Gabungkan overlay SVG dekoratif ke foto
            function composeWithSvg(sourceCanvas, svgImage) {
                const w = sourceCanvas.width;
                const h = sourceCanvas.height;
                const out = document.createElement('canvas');
                out.width = w;
                out.height = h;
                const octx = out.getContext('2d');
                octx.drawImage(sourceCanvas, 0, 0);
                if (svgImage) {
                    octx.drawImage(svgImage, 0, 0, w, h);
                }
                return out.toDataURL('image/jpeg', 0.94);
            }

            // Gabungkan foto ke dalam bingkai Polaroid (putih + nama mempelai + RuangUndang)
            function composePolaroid(sourceCanvas) {
                const pw = sourceCanvas.width;
                const ph = sourceCanvas.height;
                const border = Math.round(pw * 0.06);
                const captionH = Math.round(ph * 0.16);
                const outW = pw + border * 2;
                const outH = ph + border + captionH;

                const out = document.createElement('canvas');
                out.width = outW;
                out.height = outH;
                const octx = out.getContext('2d');

                // Latar putih
                octx.fillStyle = '#ffffff';
                octx.fillRect(0, 0, outW, outH);

                // Foto di tengah
                octx.drawImage(sourceCanvas, border, border, pw, ph);

                // Caption bawah
                const captionY = border + ph + (captionH / 2);
                const pad = border;

                // Nama mempelai (kiri)
                octx.fillStyle = '#1B2A4A';
                octx.textBaseline = 'middle';
                octx.textAlign = 'left';
                const nameSize = Math.round(pw * 0.075);
                octx.font = '700 ' + nameSize + 'px Georgia, "Times New Roman", serif';
                octx.fillText(coupleName || 'Nama Mempelai', pad, captionY, pw * 0.62);

                // Brand RuangUndang (kanan)
                octx.fillStyle = '#A68B4B';
                octx.textAlign = 'right';
                const brandSize = Math.round(pw * 0.045);
                octx.font = '700 ' + brandSize + 'px Arial, sans-serif';
                octx.fillText('RuangUndang', outW - pad, captionY);

                return out.toDataURL('image/jpeg', 0.92);
            }

            btnShutter.addEventListener('click', () => {
                if (myPhotoCount >= PHOTO_LIMIT) {
                    showToast('Kuota foto penuh (' + PHOTO_LIMIT + '/' + PHOTO_LIMIT + ') per perangkat.');
                    return;
                }

                // Efek kilatan shutter
                flashOverlay.classList.remove('animate-flash');
                void flashOverlay.offsetWidth;
                flashOverlay.classList.add('animate-flash');

                const ctx = canvas.getContext('2d');

                if (isCameraActive && video.videoWidth > 0 && video.videoHeight > 0) {
                    const vw = video.videoWidth;
                    const vh = video.videoHeight;

                    // 1) Simpan Versi Foto Penuh
                    canvas.width = vw;
                    canvas.height = vh;
                    ctx.save();
                    if (facingMode === 'user') {
                        ctx.translate(vw, 0);
                        ctx.scale(-1, 1);
                    }
                    ctx.drawImage(video, 0, 0, vw, vh);
                    ctx.restore();
                    fullDataUrl = canvas.toDataURL('image/jpeg', 0.92);

                    // 2) Hitung Koordinat Crop Presisi (object-cover mapping)
                    const boxRect = viewfinderBox.getBoundingClientRect();
                    const guideRect = frameEnabled ? photoWindow.getBoundingClientRect() : boxRect;

                    const videoRatio = vw / vh;
                    const boxRatio = boxRect.width / boxRect.height;

                    let renderW, renderH, offsetX, offsetY;
                    if (videoRatio > boxRatio) {
                        renderH = boxRect.height;
                        renderW = boxRect.height * videoRatio;
                        offsetX = (renderW - boxRect.width) / 2;
                        offsetY = 0;
                    } else {
                        renderW = boxRect.width;
                        renderH = boxRect.width / videoRatio;
                        offsetX = 0;
                        offsetY = (renderH - boxRect.height) / 2;
                    }

                    const scaleX = vw / renderW;
                    const scaleY = vh / renderH;

                    const relLeft = (guideRect.left - boxRect.left) + offsetX;
                    const relTop = (guideRect.top - boxRect.top) + offsetY;

                    const cropX = Math.max(0, relLeft * scaleX);
                    const cropY = Math.max(0, relTop * scaleY);
                    const cropW = Math.min(vw - cropX, guideRect.width * scaleX);
                    const cropH = Math.min(vh - cropY, guideRect.height * scaleY);

                    canvas.width = Math.round(cropW);
                    canvas.height = Math.round(cropH);
                    ctx.save();
                    if (facingMode === 'user') {
                        ctx.translate(canvas.width, 0);
                        ctx.scale(-1, 1);
                        const mirroredCropX = vw - cropX - cropW;
                        ctx.drawImage(video, mirroredCropX, cropY, cropW, cropH, 0, 0, canvas.width, canvas.height);
                    } else {
                        ctx.drawImage(video, cropX, cropY, cropW, cropH, 0, 0, canvas.width, canvas.height);
                    }
                    ctx.restore();
                    croppedDataUrl = canvas.toDataURL('image/jpeg', 0.94);

                    // Gabungkan bingkai ke foto sesuai frame aktif
                    if (frameEnabled && (currentFrame === 'rustic' || currentFrame === 'minimal')) {
                        if (frameSvgImage) {
                            const composed = composeWithSvg(canvas, frameSvgImage);
                            fullDataUrl = composed;
                            croppedDataUrl = composed;
                        }
                    } else if (frameEnabled && currentFrame === 'polaroid') {
                        const framed = composePolaroid(canvas);
                        fullDataUrl = framed;
                        croppedDataUrl = framed;
                    }

                } else {
                    // Fallback jika kamera tidak aktif: gambar placeholder netral
                    canvas.width = 900;
                    canvas.height = 1200;

                    const gradient = ctx.createLinearGradient(0, 0, 900, 1200);
                    gradient.addColorStop(0, '#292524');
                    gradient.addColorStop(1, '#09090b');
                    ctx.fillStyle = gradient;
                    ctx.fillRect(0, 0, 900, 1200);

                    ctx.fillStyle = '#E8D5A3';
                    ctx.font = 'bold 40px Inter, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillText('Foto Tamu', 450, 580);

                    ctx.fillStyle = '#a8a29e';
                    ctx.font = '22px Inter, sans-serif';
                    ctx.fillText('Kamera tidak tersedia', 450, 625);
                    ctx.textAlign = 'start';

                    croppedDataUrl = canvas.toDataURL('image/jpeg', 0.92);
                    fullDataUrl = croppedDataUrl;
                }

                // Tampilkan modal preview (Default: foto penuh, karena foto tamu diambil utuh)
                useCroppedVersion = false;
                updateCropToggleUI();
                previewModeBadge.textContent = 'FOTO TAMU';
                previewModal.classList.remove('hidden');
            });

            // =========================================================
            // 6. KONTROL MODAL PRATINJAU (Crop/Penuh, Foto Ulang, Unduh)
            // =========================================================
            function updateCropToggleUI() {
                if (useCroppedVersion) {
                    btnCropFrame.className = 'px-3.5 py-1.5 rounded-lg font-bold bg-[#F5B82E] text-black transition';
                    btnCropFull.className = 'px-3.5 py-1.5 rounded-lg font-medium text-zinc-400 hover:text-white transition';
                    capturedImage.src = croppedDataUrl;
                } else {
                    btnCropFull.className = 'px-3.5 py-1.5 rounded-lg font-bold bg-[#F5B82E] text-black transition';
                    btnCropFrame.className = 'px-3.5 py-1.5 rounded-lg font-medium text-zinc-400 hover:text-white transition';
                    capturedImage.src = fullDataUrl;
                }
            }

            btnCropFrame.addEventListener('click', () => {
                useCroppedVersion = true;
                updateCropToggleUI();
            });

            btnCropFull.addEventListener('click', () => {
                useCroppedVersion = false;
                updateCropToggleUI();
            });

            btnRetake.addEventListener('click', () => {
                previewModal.classList.add('hidden');
            });

            btnSave.addEventListener('click', () => {
                const finalSrc = useCroppedVersion ? croppedDataUrl : fullDataUrl;

                // Perbarui thumbnail di tombol galeri kiri bawah
                lastThumb.src = finalSrc;
                lastThumb.classList.remove('hidden');
                galleryIcon.classList.add('hidden');

                // Unduh file JPG ke penyimpanan perangkat HP
                const link = document.createElement('a');
                link.href = finalSrc;
                link.download = `Foto-Tamu-${Date.now()}.jpg`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                previewModal.classList.add('hidden');

                // Jika halaman dibuka tanpa undangan, cukup simpan lokal
                if (!eventId || !eventSlug) {
                    showToast('Foto berhasil diunduh ke perangkat.');
                    return;
                }

                // Simpan ke galeri tamu
                const deviceId = getDeviceId();

                let guestName = localStorage.getItem('guest_name') || '';
                if (!guestName) {
                    const input = prompt('Masukkan nama Anda (opsional):', '');
                    guestName = (input && input.trim()) ? input.trim() : 'Tamu';
                    if (guestName !== 'Tamu') {
                        localStorage.setItem('guest_name', guestName);
                    }
                }

                showToast('Menyimpan foto ke galeri...');

                fetch('/api/guest-photos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        event_id: eventId,
                        guest_name: guestName,
                        device_id: deviceId,
                        image: finalSrc
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Foto berhasil disimpan ke galeri ' + (coupleName || 'pengantin') + '!');

                            // Perbarui kuota
                            if (typeof data.remaining === 'number') {
                                myPhotoCount = Math.max(0, PHOTO_LIMIT - data.remaining);
                            } else {
                                myPhotoCount = Math.min(PHOTO_LIMIT, myPhotoCount + 1);
                            }
                            updateQuotaBadge();

                            // Langsung tambahkan ke galeri tamu (bottom sheet) tanpa refresh
                            if (data.photo) {
                                SHEET_DATA.guest.unshift({
                                    id: data.photo.id,
                                    image_url: data.photo.image_url || data.url || '',
                                    guest_name: data.photo.guest_name || guestName || 'Tamu',
                                    created_at: data.photo.created_at ? formatDate(data.photo.created_at) : '',
                                    can_delete: true
                                });
                                if (typeof renderSheet === 'function' && !gallerySheet.classList.contains('hidden')) {
                                    renderSheet(currentSheetTab);
                                }
                            }
                        } else {
                            showToast('Gagal menyimpan: ' + (data.message || 'Terjadi kesalahan'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Terjadi kesalahan saat mengunggah foto');
                    });
            });

            // =========================================================
            // 7. UNGGAH DARI GALERI HP
            // =========================================================
            galleryInput.addEventListener('change', (e) => {
                if (myPhotoCount >= PHOTO_LIMIT) {
                    showToast('Kuota foto penuh (' + PHOTO_LIMIT + '/' + PHOTO_LIMIT + ') per perangkat.');
                    e.target.value = '';
                    return;
                }
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (ev) => {
                    croppedDataUrl = ev.target.result;
                    fullDataUrl = ev.target.result;
                    useCroppedVersion = false;
                    updateCropToggleUI();
                    previewModeBadge.textContent = 'GALERI';
                    previewModal.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
                galleryInput.value = ''; // reset input agar bisa pilih file sama
            });

            // =========================================================
            // 8. BOTTOM SHEET GALERI (Tamu / Pengantin) + LIGHTBOX
            // =========================================================
            const gallerySheet = document.getElementById('gallery-sheet');
            const gallerySheetPanel = document.getElementById('gallery-sheet-panel');
            const sheetGrid = document.getElementById('sheet-grid');
            const sheetLb = document.getElementById('sheet-lightbox');
            const sheetLbImg = document.getElementById('sheet-lb-img');
            const sheetLbCaption = document.getElementById('sheet-lb-caption');
            const SHEET_DATA = {
                guest: @js($guestPhotos ?? []),
                couple: @js($galleries ?? [])
            };
            let currentSheetTab = 'guest';
            let sheetLbItems = [];
            let sheetLbIndex = 0;

            function escSheet(str) {
                return String(str == null ? '' : str).replace(/[&<>"']/g, function (c) {
                    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
                });
            }

            function sheetCaption(p) {
                const parts = [];
                if (p.guest_name && p.guest_name !== 'Foto') parts.push(p.guest_name);
                if (p.created_at) parts.push(p.created_at);
                return parts.join(' · ') || 'Foto';
            }

            function renderSheet(tab) {
                currentSheetTab = tab;
                document.querySelectorAll('.sheet-tab').forEach(function (b) {
                    b.classList.toggle('active', b.getAttribute('data-tab') === tab);
                });

                const items = SHEET_DATA[tab] || [];
                sheetLbItems = items;
                if (!items.length) {
                    sheetGrid.innerHTML = '<p class="col-span-full text-center text-sm text-gray-400 py-10">Belum ada foto</p>';
                    return;
                }

                sheetGrid.innerHTML = items.map(function (p, i) {
                    const cap = sheetCaption(p);
                    const canDelete = tab === 'guest' && p.can_delete === true;
                    return '' +
                        '<div class="relative">' +
                            '<a href="' + escSheet(p.image_url) + '" data-idx="' + i + '" title="' + escSheet(cap) + '" class="block rounded-lg overflow-hidden bg-zinc-800 shadow-sm">' +
                                '<img src="' + escSheet(p.image_url) + '" alt="' + escSheet(cap) + '" class="w-full h-full object-cover" style="aspect-ratio:1/1;" loading="lazy">' +
                            '</a>' +
                            (canDelete ? '<button type="button" class="sheet-del" data-del="' + escSheet(p.id) + '" aria-label="Hapus foto">&times;</button>' : '') +
                        '</div>';
                }).join('');
            }

            function openSheetLightbox(index) {
                if (!sheetLbItems.length) return;
                sheetLbIndex = (index + sheetLbItems.length) % sheetLbItems.length;
                const p = sheetLbItems[sheetLbIndex];
                sheetLbImg.src = p.image_url;
                sheetLbCaption.textContent = sheetCaption(p);
                sheetLb.classList.remove('hidden');
            }

            function closeSheetLightbox() {
                sheetLb.classList.add('hidden');
                sheetLbImg.src = '';
            }

            function stepSheetLightbox(delta) {
                if (sheetLb.classList.contains('hidden')) return;
                openSheetLightbox(sheetLbIndex + delta);
            }

            function openGallerySheet() {
                renderSheet(currentSheetTab);
                gallerySheet.classList.remove('hidden');
                requestAnimationFrame(function () {
                    gallerySheetPanel.classList.remove('translate-y-full');
                });
            }

            function closeGallerySheet() {
                gallerySheetPanel.classList.add('translate-y-full');
                setTimeout(function () { gallerySheet.classList.add('hidden'); }, 300);
            }

            const btnOpenGallery = document.getElementById('btn-open-gallery');
            if (btnOpenGallery) btnOpenGallery.addEventListener('click', openGallerySheet);
            document.getElementById('gallery-sheet-close').addEventListener('click', closeGallerySheet);
            document.getElementById('gallery-sheet-backdrop').addEventListener('click', closeGallerySheet);
            document.querySelectorAll('.sheet-tab').forEach(function (b) {
                b.addEventListener('click', function () { renderSheet(b.getAttribute('data-tab')); });
            });

            // Klik foto di sheet -> buka lightbox; klik hapus -> hapus foto
            sheetGrid.addEventListener('click', function (e) {
                const del = e.target.closest('[data-del]');
                if (del) {
                    e.preventDefault();
                    e.stopPropagation();
                    deleteSheetPhoto(del.getAttribute('data-del'));
                    return;
                }
                const a = e.target.closest('a[data-idx]');
                if (!a) return;
                e.preventDefault();
                openSheetLightbox(parseInt(a.getAttribute('data-idx'), 10) || 0);
            });

            function deleteSheetPhoto(id) {
                if (!confirm('Hapus foto ini?')) return;
                fetch('/api/guest-photos/' + encodeURIComponent(id), {
                    method: 'DELETE',
                    headers: {
                        'X-Device-Id': getDeviceId(),
                        'Accept': 'application/json'
                    }
                })
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (data.success) {
                            SHEET_DATA.guest = SHEET_DATA.guest.filter(function (p) {
                                return String(p.id) !== String(id);
                            });
                            if (myPhotoCount > 0) myPhotoCount--;
                            updateQuotaBadge();
                            renderSheet(currentSheetTab);
                            showToast('Foto dihapus.');
                        } else {
                            showToast(data.message || 'Gagal menghapus foto.');
                        }
                    })
                    .catch(function () { showToast('Gagal menghapus foto.'); });
            }

            document.getElementById('sheet-lb-close').addEventListener('click', closeSheetLightbox);
            document.getElementById('sheet-lb-prev').addEventListener('click', function (e) { e.stopPropagation(); stepSheetLightbox(-1); });
            document.getElementById('sheet-lb-next').addEventListener('click', function (e) { e.stopPropagation(); stepSheetLightbox(1); });

            document.addEventListener('keydown', function (e) {
                if (sheetLb.classList.contains('hidden')) return;
                if (e.key === 'Escape') closeSheetLightbox();
                else if (e.key === 'ArrowLeft') stepSheetLightbox(-1);
                else if (e.key === 'ArrowRight') stepSheetLightbox(1);
            });

            // Ambil galeri tamu + status can_delete sesuai device
            if (eventSlug) {
                fetch('/api/guest-photos/' + encodeURIComponent(eventSlug), {
                    headers: {
                        'X-Secret-Token': 'guest-photos-secret-2026',
                        'X-Device-Id': getDeviceId(),
                        'Accept': 'application/json'
                    }
                })
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (data.success && Array.isArray(data.data)) {
                            SHEET_DATA.guest = data.data;
                            if (typeof data.my_count === 'number') myPhotoCount = data.my_count;
                            updateQuotaBadge();
                            if (!gallerySheet.classList.contains('hidden')) {
                                renderSheet(currentSheetTab);
                            }
                        }
                    })
                    .catch(function () { });
            }
        });
    </script>
</body>

</html>