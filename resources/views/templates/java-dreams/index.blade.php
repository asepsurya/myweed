<!DOCTYPE html>
<html class="dark" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }} | The Wedding</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "error": "#ffb4ab",
                        "on-secondary-fixed": "#241a00",
                        "inverse-on-surface": "#51221c",
                        "secondary": "#e9c349",
                        "on-tertiary-fixed": "#1d1d03",
                        "tertiary-container": "#aead85",
                        "primary-fixed": "#ffdad4",
                        "surface-variant": "#562720",
                        "surface-container-lowest": "#240301",
                        "inverse-surface": "#ffdad4",
                        "outline": "#a98984",
                        "on-tertiary-container": "#414121",
                        "secondary-container": "#af8d11",
                        "tertiary-fixed-dim": "#cac99f",
                        "on-background": "#ffdad4",
                        "on-primary-fixed-variant": "#8f0f07",
                        "on-tertiary-fixed-variant": "#484828",
                        "surface-container-highest": "#562720",
                        "background": "#2b0604",
                        "primary-container": "#800000",
                        "tertiary-fixed": "#e6e5b9",
                        "error-container": "#93000a",
                        "surface-container-low": "#360e09",
                        "on-primary": "#690000",
                        "on-secondary": "#3c2f00",
                        "secondary-fixed": "#ffe088",
                        "on-error": "#690005",
                        "surface-bright": "#5c2b24",
                        "on-primary-fixed": "#410000",
                        "surface-container-high": "#491c16",
                        "surface": "#2b0604",
                        "secondary-fixed-dim": "#e9c349",
                        "on-secondary-container": "#342800",
                        "inverse-primary": "#b22b1d",
                        "surface-dim": "#2b0604",
                        "on-surface-variant": "#e2bfb9",
                        "on-error-container": "#ffdad6",
                        "on-secondary-fixed-variant": "#574500",
                        "primary": "#ffb4a8",
                        "on-surface": "#ffdad4",
                        "surface-tint": "#ffb4a8",
                        "surface-container": "#3b120d",
                        "on-tertiary": "#323214",
                        "tertiary": "#cac99f",
                        "primary-fixed-dim": "#ffb4a8",
                        "on-primary-container": "#ff8371",
                        "outline-variant": "#5a413d"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "section-padding-desktop": "120px",
                        "unit": "8px",
                        "margin-edge": "32px",
                        "container-max-width": "1200px",
                        "section-padding-mobile": "64px"
                    },
                    "fontFamily": {
                        "body-md": ["Manrope"],
                        "display-lg-mobile": ["Playfair Display"],
                        "display-lg": ["Playfair Display"],
                        "body-lg": ["Manrope"],
                        "headline-lg": ["Playfair Display"],
                        "label-sm": ["Manrope"],
                        "headline-md": ["Playfair Display"]
                    },
                    "fontSize": {
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "display-lg-mobile": ["40px", { "lineHeight": "48px", "fontWeight": "700" }],
                        "display-lg": ["56px", { "lineHeight": "64px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "600" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.1em", "fontWeight": "600" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "500" }]
                    }
                }
            }
        }
    </script>

    <style>
        body {
            min-height: max(884px, 100dvh);
        }

        .lace-overlay {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23e9c349' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        .scalloped-edge {
            mask-image: url("data:image/svg+xml,%3Csvg width='10' height='10' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='5' cy='5' r='5' fill='black'/%3E%3C/svg%3E");
            mask-size: 20px 20px;
            mask-repeat: repeat-x;
            mask-position: bottom;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Animations */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }

        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out both; }
        .animate-fade-in { animation: fadeIn 0.6s ease-out both; }
        .animate-scale-in { animation: scaleIn 0.6s ease-out both; }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-bounce-slow { animation: bounce 2s ease-in-out infinite; }
        .animate-fade-in-down { animation: fadeInDown 0.6s ease-out both; }

        .animate-item-1 { animation-delay: 0.1s; }
        .animate-item-2 { animation-delay: 0.2s; }
        .animate-item-3 { animation-delay: 0.3s; }
        .animate-item-4 { animation-delay: 0.4s; }
        .animate-item-5 { animation-delay: 0.5s; }
        .animate-item-6 { animation-delay: 0.6s; }

        .hover-scale { transition: transform 0.2s ease; }
        .hover-scale:hover { transform: scale(1.05); }

        .fade-in { opacity: 0; transform: translateY(30px); transition: opacity 1s ease-out, transform 1s ease-out; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        /* Toast */
        #toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 16px;
            position: fixed;
            z-index: 10000;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            font-size: 14px;
            border-radius: 8px;
            opacity: 0;
            transition: opacity 0.5s, bottom 0.5s;
        }
        #toast.show { visibility: visible; opacity: 1; bottom: 50px; }

        /* Scrollbar RSVP */
        .rsvp-list::-webkit-scrollbar { width: 4px; }
        .rsvp-list::-webkit-scrollbar-thumb { background-color: #a98984; border-radius: 4px; }
    </style>
</head>

<body class="bg-background text-on-background font-body-md overflow-x-hidden min-h-screen pb-24 md:pb-0">

    <!-- Top Navigation (Desktop Only) -->
    <header class="hidden md:flex justify-between items-center w-full px-margin-edge py-4 bg-background/80 backdrop-blur-md top-0 z-50 fixed shadow-lg animate-fade-in-down">
        <div class="flex items-center gap-4">
            <span class="material-symbols-outlined text-secondary">menu</span>
            <span class="font-headline-md text-headline-md italic text-primary">Our Wedding</span>
        </div>
        <nav class="flex gap-8">
            <a class="font-label-sm text-label-sm text-secondary hover:text-secondary transition-colors" href="#home">Home</a>
            <a class="font-label-sm text-label-sm text-on-surface hover:text-secondary transition-colors" href="#profiles">Story</a>
            <a class="font-label-sm text-label-sm text-on-surface hover:text-secondary transition-colors" href="#events">Events</a>
            <a class="font-label-sm text-label-sm text-on-surface hover:text-secondary transition-colors" href="#gallery">Gallery</a>
            <a class="font-label-sm text-label-sm text-on-surface hover:text-secondary transition-colors" href="#rsvp">RSVP</a>
        </nav>
    </header>

    <!-- Main Content Canvas -->
    <main class="relative w-full max-w-container-max-width mx-auto flex flex-col items-center">
        
        <!-- Background Decor -->
        <div class="fixed inset-0 pointer-events-none z-[-1] lace-overlay opacity-30"></div>

        <!-- Section 1: Hero -->
        <section class="relative w-full min-h-screen flex flex-col items-center justify-center px-margin-edge py-section-padding-mobile text-center animate-fade-in" id="home">
            <div class="relative w-full max-w-md aspect-[3/4] mb-8 z-10 animate-scale-in animate-item-1">
                <div class="absolute inset-0 bg-surface-container rounded-t-full rounded-b-3xl border-2 border-secondary/30 transform -rotate-2 animate-float"></div>
                <div class="absolute inset-0 bg-surface-variant rounded-t-full rounded-b-3xl transform rotate-1 overflow-hidden shadow-2xl">
                    <img class="w-full h-full object-cover opacity-90 mix-blend-luminosity"
                        src="{{ storage_url_with_fallback($invitation->gallery_cover, asset('default/cover.jpg')) }}" 
                        alt="Wedding Cover" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent opacity-80"></div>
                </div>
                <div class="absolute -top-12 -left-8 w-32 h-32 bg-secondary-container/20 rounded-full blur-2xl animate-float animate-item-1"></div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-primary-container/30 rounded-full blur-3xl animate-float animate-item-2"></div>
            </div>
            
            <h1 class="font-display-lg-mobile text-secondary mb-4 drop-shadow-md z-10 animate-fade-in-up animate-item-2" style="font-size: 50px;">
                {{ $invitation->groom_nickname ?? 'Groom' }} &amp; {{ $invitation->bride_nickname ?? 'Bride' }}
            </h1>
            
            <p class="font-label-sm text-label-sm text-on-surface-variant tracking-widest uppercase mb-12 z-10 animate-fade-in-up animate-item-3">
                We Are Getting Married
            </p>
            
            <div class="w-1 px-8 py-4 bg-surface-container-high rounded-full z-10 border border-secondary/20 animate-bounce-slow animate-item-4">
                <span class="flex items-center justify-center material-symbols-outlined text-secondary">arrow_downward</span>
            </div>
        </section>

        <!-- Section 2: Quote -->
        <section class="w-full py-section-padding-mobile px-margin-edge relative flex justify-center items-center animate-fade-in-up animate-item-1">
            <div class="absolute inset-0 bg-surface-container-low opacity-80 z-0"></div>
            <div class="relative z-10 max-w-2xl text-center p-8 bg-surface-variant/50 backdrop-blur-sm rounded-xl border border-secondary/20 shadow-xl animate-scale-in animate-item-2">
                <span class="material-symbols-outlined text-secondary text-4xl mb-4 block animate-float">format_quote</span>
                <p class="font-body-md text-on-surface-variant italic leading-relaxed mb-6">
                    "{{ $invitation->wedding_quote ?? 'And of His signs is that He created for you from yourselves mates that you may find tranquility in them; and He placed between you affection and mercy. Indeed in that are signs for a people who give think.' }}"
                </p>
                <span class="font-label-sm text-secondary tracking-widest">{{ $invitation->quote_id ?? '(QS. Ar-Rum: 21)' }}</span>
            </div>
        </section>

        <!-- Section 3: Profiles -->
        <section class="w-full py-section-padding-mobile px-margin-edge flex flex-col items-center gap-16 relative animate-fade-in-up animate-item-1" id="profiles">
            <h2 class="font-headline-lg text-secondary mb-8 text-center z-10 animate-item-2" style="font-size: 50px;">The Couple</h2>
            <div class="flex flex-col md:flex-row gap-16 w-full max-w-4xl z-10">
                <!-- Groom -->
                <div class="flex-1 flex flex-col items-center text-center animate-fade-in-up animate-item-3">
                    <div class="w-48 h-64 mb-6 rounded-t-full border-4 border-surface-container shadow-2xl relative overflow-hidden hover-scale">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                        <img class="w-full h-full object-cover relative z-0"
                            src="{{ storage_url_with_fallback($invitation->foto_pria, asset('default/groom.jpg')) }}" 
                            alt="{{ $invitation->groom_name ?? 'Groom' }}" loading="lazy">
                    </div>
                    <h3 class="font-headline-md text-on-background mb-2">{{ $invitation->groom_name }}</h3>
                    <p class="font-body-md text-on-surface-variant mb-4">{{ $invitation->groom_child_order_text ? 'Putra ' . $invitation->groom_child_order_text . ' dari' : 'Putra dari' }} Bpk. {{ $invitation->groom_father_name }} &amp; Ibu {{ $invitation->groom_mother_name }}</p>
                    @if($invitation->groom_instagram)
                    <a class="font-label-sm text-secondary hover:text-primary hover-scale transition-colors flex items-center gap-2"
                        href="https://instagram.com/{{ $invitation->groom_instagram }}" target="_blank">
                        <span class="material-symbols-outlined text-sm">link</span> @{{ $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>
                
                <!-- Divider -->
                <div class="hidden md:flex flex-col items-center justify-center opacity-50 animate-float">
                    <span class="font-display-lg text-secondary italic px-4">&amp;</span>
                </div>
                
                <!-- Bride -->
                <div class="flex-1 flex flex-col items-center text-center animate-fade-in-up animate-item-4">
                    <div class="w-48 h-64 mb-6 rounded-t-full border-4 border-surface-container shadow-2xl relative overflow-hidden hover-scale">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                        <img class="w-full h-full object-cover relative z-0"
                            src="{{ storage_url_with_fallback($invitation->foto_wanita, asset('default/bride.jpg')) }}" 
                            alt="{{ $invitation->bride_name ?? 'Bride' }}" loading="lazy">
                    </div>
                    <h3 class="font-headline-md text-on-background mb-2">{{ $invitation->bride_name }}</h3>
                    <p class="font-body-md text-on-surface-variant mb-4">{{ $invitation->bride_child_order_text ? 'Putri ' . $invitation->bride_child_order_text . ' dari' : 'Putri dari' }} Bpk. {{ $invitation->bride_father_name }} &amp; Ibu {{ $invitation->bride_mother_name }}</p>
                    @if($invitation->bride_instagram)
                    <a class="font-label-sm text-secondary hover:text-primary hover-scale transition-colors flex items-center gap-2"
                        href="https://instagram.com/{{ $invitation->bride_instagram }}" target="_blank">
                        <span class="material-symbols-outlined text-sm">link</span> @{{ $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- Section 4: Events -->
        <section class="w-full py-section-padding-mobile px-margin-edge flex flex-col items-center bg-surface-container-low relative animate-fade-in-up animate-item-1" id="events">
            <div class="absolute top-0 w-full h-12 scalloped-edge bg-background z-10"></div>
            <h2 class="font-headline-lg text-secondary mb-12 text-center mt-8 animate-item-2" style="font-size: 50px;">Wedding Events</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl">
                <!-- Event 1: Akad -->
                <div class="bg-surface-variant rounded-xl p-8 border border-outline-variant/30 flex flex-col items-center text-center shadow-lg relative overflow-hidden hover-scale animate-fade-in-up animate-item-3">
                    <div class="absolute -right-10 -top-10 text-9xl text-surface-container-high opacity-20 pointer-events-none material-symbols-outlined">favorite</div>
                    <h3 class="font-headline-md text-on-background mb-4">Akad Nikah</h3>
                    <div class="flex items-center gap-2 mb-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-secondary text-sm">calendar_today</span>
                        <p class="font-body-md">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="flex items-center gap-2 mb-6 text-on-surface-variant">
                        <span class="material-symbols-outlined text-secondary text-sm">schedule</span>
                        <p class="font-body-md">{{ $invitation->akad_time }} - {{ $invitation->akad_time_end ?? 'Finish' }}</p>
                    </div>
                    <div class="flex items-start gap-2 mb-8 text-on-surface-variant">
                        <span class="material-symbols-outlined text-secondary text-sm mt-1">location_on</span>
                        <p class="font-body-md text-left">{{ $invitation->akad_location }}<br />{{ $invitation->akad_address }}</p>
                    </div>
                    @if($invitation->akad_maps)
                    <button onclick="window.open('{{ $invitation->akad_maps }}', '_blank')"
                        class="mt-auto px-6 py-2 rounded-full border border-secondary text-secondary font-label-sm hover:bg-secondary/10 hover-scale transition-colors">
                        Lihat Lokasi
                    </button>
                    @endif
                </div>
                
                <!-- Event 2: Reception -->
                <div class="bg-surface-variant rounded-xl p-8 border border-outline-variant/30 flex flex-col items-center text-center shadow-lg relative overflow-hidden hover-scale animate-fade-in-up animate-item-4">
                    <div class="absolute -left-10 -bottom-10 text-9xl text-surface-container-high opacity-20 pointer-events-none material-symbols-outlined">celebration</div>
                    <h3 class="font-headline-md text-on-background mb-4">Wedding Reception</h3>
                    <div class="flex items-center gap-2 mb-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-secondary text-sm">calendar_today</span>
                        <p class="font-body-md">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="flex items-center gap-2 mb-6 text-on-surface-variant">
                        <span class="material-symbols-outlined text-secondary text-sm">schedule</span>
                        <p class="font-body-md">{{ $invitation->resepsi_time }} - {{ $invitation->resepsi_time_end ?? 'Finish' }}</p>
                    </div>
                    <div class="flex items-start gap-2 mb-8 text-on-surface-variant">
                        <span class="material-symbols-outlined text-secondary text-sm mt-1">location_on</span>
                        <p class="font-body-md text-left">{{ $invitation->resepsi_location }}<br />{{ $invitation->resepsi_address }}</p>
                    </div>
                    @if($invitation->resepsi_maps)
                    <button onclick="window.open('{{ $invitation->resepsi_maps }}', '_blank')"
                        class="mt-auto px-6 py-2 rounded-full border border-secondary text-secondary font-label-sm hover:bg-secondary/10 hover-scale transition-colors">
                        Lihat Lokasi
                    </button>
                    @endif
                </div>
            </div>
            <div class="absolute bottom-0 w-full h-12 scalloped-edge bg-background z-10 rotate-180"></div>
        </section>

        <!-- Countdown Section -->
        <section class="w-full py-section-padding-mobile px-margin-edge flex flex-col items-center bg-surface-container-low relative animate-fade-in-up animate-item-1" id="countdown">
            <div class="absolute top-0 w-full h-12 scalloped-edge bg-background z-10"></div>
            <h2 class="font-headline-lg text-secondary mb-12 text-center mt-8 animate-item-2" style="font-size: 50px;">Menuju Bahagia</h2>
            <div id="countdownGrid" class="grid grid-cols-4 gap-4 max-w-md mx-auto mb-4">
                <div class="text-center">
                    <p id="days" class="font-headline-lg text-headline-lg">00</p>
                    <p class="font-label-sm text-label-sm uppercase tracking-wider opacity-70">Hari</p>
                </div>
                <div class="text-center">
                    <p id="hours" class="font-headline-lg text-headline-lg">00</p>
                    <p class="font-label-sm text-label-sm uppercase tracking-wider opacity-70">Jam</p>
                </div>
                <div class="text-center">
                    <p id="minutes" class="font-headline-lg text-headline-lg">00</p>
                    <p class="font-label-sm text-label-sm uppercase tracking-wider opacity-70">Menit</p>
                </div>
                <div class="text-center">
                    <p id="seconds" class="font-headline-lg text-headline-lg">00</p>
                    <p class="font-label-sm text-label-sm uppercase tracking-wider opacity-70">Detik</p>
                </div>
            </div>
            <div id="countdownPassed" class="mb-4 hidden">
                <p class="font-headline-md text-headline-md">Acara Telah Dimulai</p>
            </div>
            <div class="absolute bottom-0 w-full h-12 scalloped-edge bg-background z-10 rotate-180"></div>
        </section>

        <!-- Gallery Section -->
        <section class="w-full py-section-padding-mobile px-margin-edge flex flex-col items-center animate-fade-in-up animate-item-1" id="gallery">
            <h2 class="font-headline-lg text-secondary mb-12 text-center animate-item-2" style="font-size: 50px;">Galeri Momen</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 w-full max-w-4xl">
                @if(($invitation->enable_gallery ?? true) && $invitation->galleries->count())@foreach($invitation->galleries as $index => $photo)
                <div class="gallery-item {{ $index >= 6 ? 'hidden' : '' }} hover-scale animate-fade-in-up animate-item-{{ ($index % 6) + 1 }}">
                    <div class="{{ $index === 2 ? 'aspect-[4/3] rounded-xl overflow-hidden md:col-span-2' : ($index % 2 === 0 ? 'aspect-[3/4] rounded-xl overflow-hidden' : 'aspect-square rounded-xl overflow-hidden') }}">
                        <a href="{{ storage_url($photo->image) }}" data-fancybox="gallery" data-caption="Wedding Moment">
                            <img loading="lazy" src="{{ storage_url($photo->image) }}" alt="Wedding Moment" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" />
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @if($invitation->galleries->count() > 6)
            <div class="text-center mt-8">
                <button id="loadMoreGallery" class="px-6 py-2 rounded-full border border-secondary text-secondary font-label-sm hover:bg-secondary/10 transition-colors" onclick="loadMoreGallery()">
                    <span id="loadMoreText">Lihat Lebih Banyak</span>
                </button>
            </div>
            @endif
        </section>

        <!-- Wedding Gifts Section -->
        @if($invitation->enable_gift == 1 && $invitation->gifts->count())
        <section class="w-full py-section-padding-mobile px-margin-edge flex flex-col items-center bg-surface-container-low animate-fade-in-up animate-item-1" id="gifts">
            <h2 class="font-headline-lg text-secondary mb-12 text-center animate-item-2" style="font-size: 50px;">Wedding Gifts</h2>
            <div class="w-full max-w-2xl space-y-6">
                @foreach($invitation->gifts as $gift)
                <div class="bg-surface p-6 rounded-xl border border-outline-variant/20 animate-fade-in-up animate-item-3">
                    <h3 class="font-headline-md text-secondary mb-2">{{ $gift->bank }}</h3>
                    <p class="font-body-lg text-on-background font-bold mb-1">{{ $gift->number }}</p>
                    <p class="font-body-md text-on-surface-variant mb-4">A/N: {{ $gift->name }}</p>
                    <button onclick="copyText('{{ $gift->number }}')" class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-secondary text-secondary font-label-sm hover:bg-secondary/10 transition-colors">
                        <span class="material-symbols-outlined text-sm">content_copy</span> Salin
                    </button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Section 5: RSVP & Form -->
        <section class="w-full py-section-padding-mobile px-margin-edge flex flex-col items-center animate-fade-in-up animate-item-1" id="rsvp">
            @if($invitation->rsvp_deadline)
            <div class="text-center mb-4">
                <p class="font-label-sm text-label-sm text-on-surface-variant">
                    <span class="material-symbols-outlined text-sm align-middle">calendar_today</span>
                    Batas RSVP: {{ \Carbon\Carbon::parse($invitation->rsvp_deadline)->format('d/m/Y') }}
                </p>
            </div>
            @endif
            @if($invitation->rsvp_message)
            <div class="text-center mb-6">
                <p class="font-body-md text-body-md text-on-surface-variant italic">"{{ $invitation->rsvp_message }}"</p>
            </div>
            @endif
            
            <div class="w-full max-w-md bg-surface border border-outline-variant/20 rounded-xl p-6 shadow-md animate-scale-in animate-item-3 mb-8">
                <h3 class="font-headline-md text-secondary mb-6 text-center animate-item-4" style="font-size: 50px;">Ucapan &amp; Doa</h3>
                <form id="rsvpForm" action="{{ route('rsvp.store', $invitation) }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input name="name" class="bg-surface-container-low border-b border-outline-variant focus:border-secondary text-on-surface font-body-md py-2 px-3 focus:ring-0 focus:outline-none w-full transition-colors" placeholder="Nama Lengkap" type="text" required />
                    <select name="attending" class="bg-surface-container-low border-b border-outline-variant focus:border-secondary text-on-surface font-body-md py-2 px-3 focus:ring-0 focus:outline-none w-full transition-colors" required>
                        <option value="1">Hadir</option>
                        <option value="2">Tidak Hadir</option>
                        <option value="3">Masih Ragu</option>
                    </select>
                    <textarea name="message" class="bg-surface-container-low border-b border-outline-variant focus:border-secondary text-on-surface font-body-md py-2 px-3 rounded-lg focus:ring-0 focus:outline-none w-full resize-none transition-colors" placeholder="Tulis doa &amp; ucapan..." rows="4" required></textarea>
                    <button id="rsvpButton" class="w-full py-3 bg-secondary text-on-secondary rounded-lg font-label-sm font-bold hover:opacity-90 hover-scale transition-opacity flex justify-center items-center gap-2" type="submit">
                        <span id="buttonText">Kirim Ucapan</span>
                    </button>
                </form>
                <div id="rsvpMessage" class="text-center mt-4 text-sm font-bold hidden"></div>
            </div>
            
            <div class="w-full max-w-2xl bg-surface p-6 rounded-xl border border-outline-variant/20 animate-fade-in-up">
                <h3 class="font-body-lg text-secondary font-semibold mb-4 text-center">Tinggalkan kami doa terbaik untuk momen bahagia kami</h3>
                <div id="rsvpList" class="rsvp-list space-y-4 max-h-[400px] overflow-y-auto pr-2" data-url="{{ route('rsvp.list', $invitation) }}">
                    <!-- List loaded via JS -->
                </div>
                <p class="font-label-sm text-label-sm text-outline mt-4 text-center">({{ $invitation->rsvps->count() }} Ucapan)</p>
            </div>
            
            @if($invitation->rsvp_whatsapp)
            <div class="text-center mt-6">
                <a href="https://wa.me/{{ $invitation->rsvp_whatsapp }}?text=Halo,%20saya%20ingin%20konfirmasi%20RSVP%20untuk%20undangan%20pernikahan." target="_blank" class="inline-flex items-center gap-2 bg-[#22c55e] text-white px-6 py-3 rounded-full font-label-sm hover:bg-[#16a34a] transition-colors">
                    <span class="material-symbols-outlined" style="font-size:18px;">chat</span> Konfirmasi via WhatsApp
                </a>
            </div>
            @endif
        </section>

        <!-- Footer Thank You -->
        <div class="mt-16 text-center animate-fade-in-up animate-item-5">
            <h2 class="font-display-lg text-secondary mb-2">Thank You</h2>
            <p class="font-headline-md text-on-background italic">{{ $invitation->groom_nickname }} &amp; {{ $invitation->bride_nickname }}</p>
        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    <nav id="bottomNav" class="fixed bottom-4 left-0 w-full flex justify-around items-center px-4 py-3 bg-surface-container-high rounded-full border border-outline-variant/30 shadow-lg md:hidden z-50 max-w-2xl mx-auto animate-fade-in-up">
        <a class="nav-link flex flex-col items-center justify-center bg-secondary-container text-on-secondary-container rounded-full px-3 py-1.5 scale-90 transition-transform duration-200 animate-item-1" href="#home">
            <span class="material-symbols-outlined">home</span>
            <span class="font-label-sm text-[10px] mt-1">Home</span>
        </a>
        <a class="nav-link flex flex-col items-center justify-center text-on-surface-variant px-3 py-1.5 opacity-70 hover:opacity-100 transition-opacity rounded-full duration-200 animate-item-2" href="#profiles">
            <span class="material-symbols-outlined">favorite</span>
            <span class="font-label-sm text-[10px] mt-1">Story</span>
        </a>
        <a class="nav-link flex flex-col items-center justify-center text-on-surface-variant px-3 py-1.5 opacity-70 hover:opacity-100 transition-opacity rounded-full duration-200 animate-item-3" href="#events">
            <span class="material-symbols-outlined text-secondary">directions</span>
            <span class="font-label-sm text-[10px] mt-1">Events</span>
        </a>
        <a class="nav-link flex flex-col items-center justify-center text-on-surface-variant px-3 py-1.5 opacity-70 hover:opacity-100 transition-opacity rounded-full duration-200 animate-item-4" href="#gallery">
            <span class="material-symbols-outlined">photo_library</span>
            <span class="font-label-sm text-[10px] mt-1">Gallery</span>
        </a>
        <a class="nav-link flex flex-col items-center justify-center text-on-surface-variant px-3 py-1.5 opacity-70 hover:opacity-100 transition-opacity rounded-full duration-200 animate-item-5" href="#rsvp">
            <span class="material-symbols-outlined text-secondary">mail</span>
            <span class="font-label-sm text-[10px] mt-1">RSVP</span>
        </a>
    </nav>

    <!-- Toast Notification -->
    <div id="toast">Pesan terkirim dengan terima kasih.</div>

    <x-music-player :invitation="$invitation" />


    <script>
    document.addEventListener('DOMContentLoaded', () => {

        /* ---------- 1. TOAST & COPY ---------- */
        function showToast(message) {
            const toast = document.getElementById('toast');
            if (!toast) return;
            toast.textContent = message;
            toast.className = 'show';
            setTimeout(() => { toast.className = toast.className.replace('show', ''); }, 3000);
        }

        window.copyText = function(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast("Nomor rekening berhasil disalin!");
            }).catch(() => {
                const ta = document.createElement('textarea');
                ta.value = text;
                ta.style.position = 'fixed';
                ta.style.left = '-9999px';
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showToast("Nomor rekening berhasil disalin!");
            });
        };

        /* ---------- 2. TIME AGO ---------- */
        function timeAgo(dateString) {
            const now = new Date();
            const date = new Date(dateString);
            const seconds = Math.floor((now - date) / 1000);
            if (seconds < 60) return 'Baru saja';
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return minutes + ' menit yang lalu';
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return hours + ' jam yang lalu';
            const days = Math.floor(hours / 24);
            if (days < 30) return days + ' hari yang lalu';
            const months = Math.floor(days / 30);
            if (months < 12) return months + ' bulan yang lalu';
            return Math.floor(months / 12) + ' tahun yang lalu';
        }

        /* ---------- 3. COUNTDOWN ---------- */
        const weddingDate = new Date('{{ \Carbon\Carbon::parse($invitation->wedding_date)->format("Y-m-d H:i:s") }}').getTime();
        const countdownGrid = document.getElementById('countdownGrid');
        const countdownPassed = document.getElementById('countdownPassed');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = weddingDate - now;
            if (distance < 0) {
                if (countdownGrid) countdownGrid.classList.add('hidden');
                if (countdownPassed) countdownPassed.classList.remove('hidden');
                return;
            }

            const d = document.getElementById('days');
            const h = document.getElementById('hours');
            const m = document.getElementById('minutes');
            const s = document.getElementById('seconds');

            if (d) d.textContent = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            if (h) h.textContent = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            if (m) m.textContent = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            if (s) s.textContent = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }
        updateCountdown();
        setInterval(updateCountdown, 1000);

        /* ---------- 4. SCROLL ANIMATIONS ---------- */
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-in, .timeline-item, .gift-card, .animate-fade-in-up').forEach(el => observer.observe(el));

        /* ---------- 5. RSVP FORM ---------- */
        const rsvpForm = document.getElementById('rsvpForm');
        const rsvpButton = document.getElementById('rsvpButton');
        const buttonText = document.getElementById('buttonText');
        const rsvpMessage = document.getElementById('rsvpMessage');

        if (rsvpForm) {
            rsvpForm.addEventListener('submit', function(e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);
                var submitUrl = form.getAttribute('action');

                if (!submitUrl) {
                    showToast('URL form tidak ditemukan.');
                    return;
                }

                buttonText.textContent = 'Mengirim...';
                rsvpButton.disabled = true;
                rsvpMessage.classList.add('hidden');

                fetch(submitUrl, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(response) {
                    if (!response.ok) {
                        return response.json().then(function(data) {
                            throw new Error(data.message || 'Gagal mengirim ucapan.');
                        }).catch(function(err) {
                            if (err.message && err.message !== 'Gagal mengirim ucapan.') throw err;
                            throw new Error('Gagal mengirim ucapan. Silakan coba lagi.');
                        });
                    }
                    return response.json();
                })
                .then(function(data) {
                    rsvpMessage.textContent = 'Terima kasih! Ucapan Anda telah terkirim.';
                    rsvpMessage.style.color = '#22c55e';
                    rsvpMessage.classList.remove('hidden');
                    form.reset();
                    loadRsvpList();
                    showToast('Ucapan berhasil dikirim!');
                    setTimeout(function() { rsvpMessage.classList.add('hidden'); }, 5000);
                })
                .catch(function(err) {
                    rsvpMessage.textContent = err.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                    rsvpMessage.style.color = '#ef4444';
                    rsvpMessage.classList.remove('hidden');
                    setTimeout(function() { rsvpMessage.classList.add('hidden'); }, 5000);
                })
                .finally(function() {
                    buttonText.textContent = 'Kirim Ucapan';
                    rsvpButton.disabled = false;
                });
            });
        }

        /* ---------- 6. LOAD RSVP LIST ---------- */
        function loadRsvpList() {
            var rsvpList = document.getElementById('rsvpList');
            if (!rsvpList) return;
            var listUrl = rsvpList.getAttribute('data-url');
            if (!listUrl) return;

            fetch(listUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data && data.length > 0) {
                    rsvpList.innerHTML = data.map(function(item) {
                        return '<div class="comment-item flex gap-3 mb-4 pb-4 border-b border-outline-variant/30 last:border-0 last:mb-0 last:pb-0">'
                            + '<div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center flex-shrink-0">'
                            + '<span class="material-symbols-outlined text-outline-variant" style="font-size:20px;">person</span>'
                            + '</div>'
                            + '<div class="flex-1 min-w-0">'
                            + '<p class="font-body-md text-body-md font-semibold text-primary mb-1">' + item.name + '</p>'
                            + '<p class="font-body-md text-body-md text-on-surface-variant text-sm leading-relaxed">' + item.message + '</p>'
                            + '<p class="font-label-sm text-label-sm text-outline mt-1">' + timeAgo(item.created_at) + '</p>'
                            + '</div>'
                            + '</div>';
                    }).join('');
                } else {
                    rsvpList.innerHTML = '<p class="font-body-md text-body-md text-on-surface-variant text-center mb-2">Belum ada ucapan. Jadilah yang pertama!</p>';
                }
            })
            .catch(function(err) { console.error('Failed to load RSVP list:', err); });
        }
        loadRsvpList();

        /* ---------- 7. GALLERY LOAD MORE ---------- */
        window.loadMoreGallery = function() {
            var button = document.getElementById('loadMoreGallery');
            var text = document.getElementById('loadMoreText');
            if (!button) return;
            var visibleCount = document.querySelectorAll('#gallery .gallery-item:not(.hidden)').length;
            var totalCount = document.querySelectorAll('#gallery .gallery-item').length;
            if (visibleCount >= totalCount) return;
            text.textContent = 'Memuat...';
            button.disabled = true;
            setTimeout(function() {
                var items = document.querySelectorAll('#gallery .gallery-item.hidden');
                var shown = 0;
                items.forEach(function(item) {
                    if (shown < 6) {
                        item.classList.remove('hidden');
                        shown++;
                    }
                });
                text.textContent = visibleCount + shown >= totalCount ? 'Tampilkan Semua' : 'Lihat Lebih Banyak';
                button.disabled = false;
                if (visibleCount + shown >= totalCount) {
                    button.style.display = 'none';
                }
            }, 300);
        };

        /* ---------- 8. SMOOTH SCROLL & BOTTOM NAV ACTIVE ---------- */
        const navLinks = document.querySelectorAll('.nav-link');
        
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    var offset = 80;
                    var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                }
            });
        });

        // ScrollSpy for Bottom Nav
        const sections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                if (window.scrollY >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('bg-secondary-container', 'text-on-secondary-container', 'scale-90');
                link.classList.add('opacity-70');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('bg-secondary-container', 'text-on-secondary-container', 'scale-90');
                    link.classList.remove('opacity-70');
                }
            });
        });

    });

    @if(($invitation->enable_love_story ?? true) && !empty($invitation->love_story))
    @php
        $loveStories = is_array($invitation->love_story) ? $invitation->love_story : json_decode($invitation->love_story, true);
    @endphp
    @if(!empty($loveStories[0]['title']) || !empty($loveStories[0]['story']))
    <section class="py-stack-lg px-margin-mobile bg-surface-container-low" id="love-story">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-12 fade-in">
                <p class="font-label-sm text-label-sm text-outline tracking-widest uppercase mb-2">Kisah Kami</p>
                <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Love Story</h2>
            </div>
            <div class="relative pl-6 fade-in">
                @foreach($loveStories as $index => $story)
                <div class="timeline-item {{ $index < count($loveStories) - 1 ? 'mb-8' : '' }} relative {{ $index < count($loveStories) - 1 ? 'timeline-line' : '' }}">
                    <div class="absolute -left-6 top-1 w-6 h-6 rounded-full border-2 border-tertiary-fixed-dim bg-surface flex items-center justify-center z-10">
                        <div class="w-2 h-2 rounded-full bg-tertiary-fixed-dim"></div>
                    </div>
                    <h3 class="font-body-lg text-body-lg font-semibold text-primary mb-2">{{ $story['title'] ?? '' }}</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">{{ $story['story'] ?? '' }}</p>
                    @if(!empty($story['photo']))
                    <img src="{{ storage_url($story['photo']) }}" alt="{{ $story['title'] ?? 'Story Photo' }}" loading="lazy" class="mt-3 rounded-lg max-h-[200px] object-cover w-full" />
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    @endif

    @if(($invitation->enable_video ?? true) && !empty($invitation->video_link))
    @php
        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->video_link, $ytVideoMatches);
        $youtubeVideoId = $ytVideoMatches['id'] ?? '';
    @endphp
    @if($youtubeVideoId)
    <section class="py-stack-lg px-margin-mobile bg-surface" id="video">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12 fade-in">
                <p class="font-label-sm text-label-sm text-outline tracking-widest uppercase mb-2">Video</p>
                <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Video Pernikahan</h2>
            </div>
            <div class="fade-in relative aspect-video rounded-xl overflow-hidden bg-surface-container-high cursor-pointer" data-fancybox="video" data-src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeVideoId }}&controls=1&modestbranding=1&rel=0">
                <img loading="lazy" src="https://img.youtube.com/vi/{{ $youtubeVideoId }}/hqdefault.jpg" alt="Video Pernikahan" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center justify-center bg-primary/30">
                    <span class="material-symbols-outlined text-white text-6xl">play_circle</span>
                </div>
            </div>
        </div>
    </section>
    @else
    <section class="py-stack-lg px-margin-mobile bg-surface" id="video">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12 fade-in">
                <p class="font-label-sm text-label-sm text-outline tracking-widest uppercase mb-2">Video</p>
                <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Video Pernikahan</h2>
            </div>
            <div class="fade-in">
                <video controls class="w-full rounded-xl" poster="{{ storage_url_with_fallback($invitation->gallery_cover, asset('default/cover.jpg')) }}">
                    <source src="{{ storage_url($invitation->video_link) }}" type="video/mp4">
                </video>
            </div>
        </div>
    </section>
    @endif
    @endif
</script>
</body>

</html>