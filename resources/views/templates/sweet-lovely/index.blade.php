<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }} | The Wedding</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600&amp;family=Playfair+Display:wght@500;600;700&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-surface": "#231435",
                        "error": "#ba1a1a",
                        "secondary-fixed-dim": "#add461",
                        "on-error-container": "#93000a",
                        "surface-container-high": "#f2e2ff",
                        "inverse-primary": "#ffb1c1",
                        "background": "#fff7ff",
                        "error-container": "#ffdad6",
                        "secondary-fixed": "#c8f17a",
                        "tertiary": "#412f00",
                        "outline-variant": "#dcbfc4",
                        "surface": "#fff7ff",
                        "on-primary": "#ffffff",
                        "surface-bright": "#fff7ff",
                        "tertiary-container": "#5d4400",
                        "on-error": "#ffffff",
                        "on-tertiary-container": "#e5ae24",
                        "inverse-surface": "#39294b",
                        "secondary": "#496800",
                        "inverse-on-surface": "#f9edff",
                        "tertiary-fixed": "#ffdf9f",
                        "on-secondary": "#ffffff",
                        "surface-dim": "#e7d2fd",
                        "surface-container": "#f7e9ff",
                        "on-background": "#231435",
                        "primary-container": "#881d41",
                        "secondary-container": "#c8f17a",
                        "surface-container-highest": "#eedbff",
                        "tertiary-fixed-dim": "#f6be35",
                        "on-surface-variant": "#564145",
                        "on-primary-fixed": "#3f0017",
                        "on-tertiary": "#ffffff",
                        "on-primary-fixed-variant": "#861b40",
                        "surface-tint": "#a63557",
                        "on-secondary-fixed-variant": "#364e00",
                        "on-secondary-container": "#4e6e00",
                        "primary-fixed-dim": "#ffb1c1",
                        "on-secondary-fixed": "#131f00",
                        "primary": "#68002b",
                        "surface-container-lowest": "#ffffff",
                        "primary-fixed": "#ffd9df",
                        "outline": "#897175",
                        "on-tertiary-fixed-variant": "#5c4300",
                        "surface-variant": "#eedbff",
                        "on-primary-container": "#ff9ab0",
                        "surface-container-low": "#fbf0ff",
                        "on-tertiary-fixed": "#261a00"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "unit": "8px",
                        "stack-md": "48px",
                        "margin-mobile": "20px",
                        "container-max-width": "1200px",
                        "stack-lg": "80px",
                        "gutter": "24px",
                        "stack-sm": "24px",
                        "margin-desktop": "64px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Playfair Display"],
                        "headline-lg-mobile": ["Playfair Display"],
                        "display-lg": ["Playfair Display"],
                        "body-md": ["Be Vietnam Pro"],
                        "label-sm": ["Be Vietnam Pro"],
                        "body-lg": ["Be Vietnam Pro"],
                        "display-lg-mobile": ["Playfair Display"],
                        "label-lg": ["Be Vietnam Pro"],
                        "headline-md": ["Playfair Display"]
                    },
                    "fontSize": {
                        "headline-lg": ["40px", { "lineHeight": "1.2", "fontWeight": "600" }],
                        "headline-lg-mobile": ["32px", { "lineHeight": "1.2", "fontWeight": "600" }],
                        "display-lg": ["64px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-md": ["16px", { "lineHeight": "1.5", "fontWeight": "400" }],
                        "label-sm": ["12px", { "lineHeight": "1.2", "fontWeight": "500" }],
                        "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "display-lg-mobile": ["48px", { "lineHeight": "1.1", "fontWeight": "700" }],
                        "label-lg": ["14px", { "lineHeight": "1.2", "letterSpacing": "0.1em", "fontWeight": "600" }],
                        "headline-md": ["28px", { "lineHeight": "1.3", "fontWeight": "500" }]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .timeline-line::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 24px;
            bottom: -24px;
            width: 2px;
            background-color: theme('colors.outline-variant');
            transform: scaleY(0); /* Start hidden */
            transform-origin: top;
            transition: transform 0.8s ease-out;
        }

        .timeline-item.visible .timeline-line::before {
            transform: scaleY(1); /* Draw line when visible */
        }

        .timeline-item:last-child .timeline-line::before {
            display: none;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1s ease-out, transform 1s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== TAMBAHAN ANIMASI ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-stagger {
            opacity: 0;
            animation: fadeInUp 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }
        .delay-100 { animation-delay: 0.2s; }
        .delay-200 { animation-delay: 0.4s; }
        .delay-300 { animation-delay: 0.6s; }
        .delay-400 { animation-delay: 0.8s; }
        .delay-500 { animation-delay: 1.0s; }

        @keyframes pulseScale {
            0% { transform: scale(1); color: #ffffff; }
            50% { transform: scale(1.2); color: #add461; } /* secondary-fixed-dim */
            100% { transform: scale(1); color: #ffffff; }
        }

        .countdown-num {
            display: inline-block;
            transition: transform 0.3s ease;
        }
        .countdown-num.pulse {
            animation: pulseScale 0.5s ease;
        }

        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        .float-anim {
            animation: floatY 4s ease-in-out infinite;
        }

        .gift-card {
            opacity: 0;
            transform: translateX(-40px);
            transition: all 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .gift-card:nth-child(even) {
            transform: translateX(40px);
        }
        .gift-card.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .hover-zoom {
            transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .hover-zoom:hover {
            transform: scale(1.03);
        }

        .event-card {
            transition: all 0.4s ease;
        }
        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(104, 0, 43, 0.15);
        }
        /* ============================= */

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

        #toast.show {
            visibility: visible;
            opacity: 1;
            bottom: 50px;
        }

        .rsvp-list::-webkit-scrollbar {
            width: 4px;
        }

        .rsvp-list::-webkit-scrollbar-thumb {
            background-color: #ddd;
            border-radius: 4px;
        }

        .comment-item {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="bg-background text-on-surface font-body-md antialiased overflow-x-hidden">

    <!-- Top Navigation (Desktop) -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-surface/80 dark:bg-surface-dim/80 backdrop-blur-md border-b border-outline-variant/30">
        <div class="hidden md:flex items-center justify-between px-margin-desktop h-16 max-w-container-max-width mx-auto">
            <div class="flex items-center gap-unit cursor-pointer">
                <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim" data-icon="local_florist">local_florist</span>
                <span class="font-headline-md text-headline-md text-primary dark:text-primary-fixed-dim tracking-tight">{{ $invitation->groom_nickname }} &amp; {{ $invitation->bride_nickname }}</span>
            </div>
            <nav class="flex gap-gutter">
                <a class="font-label-lg text-label-lg text-primary font-bold hover:text-primary-container transition-colors" href="#home">Home</a>
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary-container transition-colors" href="#mempelai">Mempelai</a>
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary-container transition-colors" href="#events">Events</a>
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary-container transition-colors" href="#gallery">Gallery</a>
                <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-primary-container transition-colors" href="#rsvp">RSVP</a>
            </nav>
        </div>
    </header>

    @php
        $navItems = [];
        $navItems[] = ['id' => 'home', 'icon' => 'favorite', 'label' => 'Home', 'href' => '#home', 'primary' => true];
        if ($invitation->love_story) {
            $navItems[] = ['id' => 'story2', 'icon' => 'auto_stories', 'label' => 'Story', 'href' => '#story2'];
        }
        $navItems[] = ['id' => 'events', 'icon' => 'event', 'label' => 'Events', 'href' => '#events'];
        if ($invitation->enable_gift == 1 && $invitation->gifts->count()) {
            $navItems[] = ['id' => 'gifts', 'icon' => 'card_giftcard', 'label' => 'Gifts', 'href' => '#gifts'];
        }
        if ($invitation->enable_rsvp == 1) {
            $navItems[] = ['id' => 'rsvp', 'icon' => 'mail', 'label' => 'RSVP', 'href' => '#rsvp'];
        }
        if (!empty($invitation->video_link)) {
            $navItems[] = ['id' => 'video', 'icon' => 'play_circle', 'label' => 'Video', 'href' => '#video'];
        }
    @endphp
    <nav id="bottomNav" class="fixed bottom-0 left-0 right-0 z-50 flex justify-around items-center px-4 py-3 pb-6 md:hidden bg-surface-container-lowest dark:bg-surface-dim rounded-t-full shadow-[0_-4px_20px_0_rgba(104,0,43,0.05)] shadow-md">
        @foreach($navItems as $item)
        <a class="flex flex-col items-center justify-center {{ ($item['primary'] ?? false) ? 'bg-primary-container text-white rounded-full px-4 py-1' : 'text-on-surface-variant hover:bg-surface-container-high transition-all active:scale-90 duration-200 p-2 rounded-full' }}" href="{{ $item['href'] }}">
            <span class="material-symbols-outlined" data-icon="{{ $item['icon'] }}">{{ $item['icon'] }}</span>
            <span class="font-label-sm text-label-sm">{{ $item['label'] }}</span>
        </a>
        @endforeach
    </nav>

    <main class="w-full mx-auto">

        <!-- Hero Section -->
        <section class="h-screen flex flex-col items-center text-center relative overflow-hidden text-on-primary px-margin-mobile" id="home">
            <div class="absolute inset-0 z-[-1] bg-[url('{{ '/storage/' . ($invitation->gallery_cover ?? 'default/cover.jpg') }}')] bg-cover bg-center">
                <div class="absolute inset-0 bg-primary/40 backdrop-blur-sm"></div>
            </div>
            <div class="flex-1 flex flex-col items-center justify-center mt-20">
                <p class="hero-stagger delay-100 font-label-lg text-label-lg tracking-widest uppercase mb-4">The Wedding Of</p>
                <h1 class="hero-stagger delay-200 font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg mb-8 font-headline-lg">{{ $invitation->groom_nickname }} &amp; {{ $invitation->bride_nickname }}</h1>
                <p class="hero-stagger delay-300 font-body-md text-body-md mb-2">Kepada Yth.</p>
                <p class="hero-stagger delay-300 font-body-lg text-body-lg font-bold mb-6">Bapak / Ibu / Saudara</p>
                <div class="hero-stagger delay-400 border border-on-primary/30 rounded-lg p-4 backdrop-blur-md bg-surface/10 mb-8 inline-block min-w-[280px]">
                    <p class="font-body-md text-body-md mb-2">{{ request('penerima') ?? 'Keluarga Besar' }}</p>
                    <p class="font-headline-md text-headline-md italic font-headline-md">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
                <br />
                <button id="reminderBtn" class="hero-stagger delay-500 bg-surface text-primary px-6 py-2 rounded-full font-label-lg text-label-lg font-semibold inline-flex items-center gap-2 hover:bg-surface-variant transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-sm">calendar_today</span> Setel Pengingat
                </button>
            </div>
            <div class="pb-24 pt-8 flex flex-col items-center animate-bounce opacity-70 cursor-pointer" onclick="document.getElementById('quote').scrollIntoView({behavior:'smooth'})">
                <span class="font-label-sm text-label-sm tracking-widest uppercase mb-2">Scroll</span>
                <div class="w-[1px] h-8 bg-on-primary"></div>
            </div>
        </section>

        <!-- Quotes Section -->
        <section class="py-stack-lg px-margin-mobile text-center max-w-2xl mx-auto" id="quote">
            <div class="fade-in">
                <h2 class="font-headline-md text-headline-md text-primary mb-6">Quotes</h2>
                <span class="material-symbols-outlined text-outline-variant text-4xl mb-4 block">format_quote</span>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-6 italic">
                    {!! nl2br(e(str_replace('(', "\n(", $invitation->wedding_quote))) !!}
                </p>
                <div class="w-16 h-[1px] bg-outline-variant mx-auto mt-8"></div>
            </div>
        </section>

        <!-- Mempelai Section -->
        <section class="py-stack-lg px-margin-mobile bg-surface-container-low" id="mempelai">
            <div class="max-w-container-max-width mx-auto">
                <div class="text-center mb-stack-md fade-in">
                    <p class="font-label-sm text-label-sm text-outline tracking-widest uppercase mb-2">The Bride &amp; Groom</p>
                    <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Mempelai</h2>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-center gap-stack-md fade-in">
                    <!-- Groom -->
                    <div class="text-center flex flex-col items-center">
                        <div class="w-48 h-64 md:w-64 md:h-80 border-4 border-outline-variant/30 p-2 mb-6 hover-zoom overflow-hidden">
                            <img alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ '/storage/' . ($invitation->foto_pria ?? 'default/groom.jpg') }}" loading="lazy" />
                        </div>
                        <h3 class="font-headline-md text-headline-md text-primary mb-2">{{ $invitation->groom_name }}</h3>
                        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-4 max-w-[200px]">{{ $invitation->groom_child_order_text ? 'Putra ' . $invitation->groom_child_order_text . ' dari' : 'Putra dari' }} Bpk. {{ $invitation->groom_father_name }} &amp; Ibu {{ $invitation->groom_mother_name }}</p>
                        @if($invitation->groom_instagram)
                        <a class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary text-sm" href="{{ $invitation->groom_instagram }}" target="_blank">
                            <svg aria-hidden="true" class="w-4 h-4" fill="currentColor" viewbox="0 0 24 24">
                                <path clip-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" fill-rule="evenodd"></path>
                            </svg>
                            Instagram
                        </a>
                        @endif
                    </div>
                    <div class="float-anim font-headline-lg text-headline-lg text-tertiary-fixed-dim hidden md:block">&amp;</div>
                    <div class="float-anim font-headline-lg text-headline-lg text-tertiary-fixed-dim md:hidden my-4">&amp;</div>
                    <!-- Bride -->
                    <div class="text-center flex flex-col items-center">
                        <div class="w-48 h-64 md:w-64 md:h-80 border-4 border-outline-variant/30 p-2 mb-6 hover-zoom overflow-hidden">
                            <img alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ '/storage/' . ($invitation->foto_wanita ?? 'default/bride.jpg') }}" loading="lazy" />
                        </div>
                        <h3 class="font-headline-md text-headline-md text-primary mb-2">{{ $invitation->bride_name }}</h3>
                        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-4 max-w-[200px]">{{ $invitation->bride_child_order_text ? 'Putri ' . $invitation->bride_child_order_text . ' dari' : 'Putri dari' }} Bpk. {{ $invitation->bride_father_name }} &amp; Ibu {{ $invitation->bride_mother_name }}</p>
                        @if($invitation->bride_instagram)
                        <a class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary text-sm" href="{{ $invitation->bride_instagram }}" target="_blank">
                            <svg aria-hidden="true" class="w-4 h-4" fill="currentColor" viewbox="0 0 24 24">
                                <path clip-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" fill-rule="evenodd"></path>
                            </svg>
                            Instagram
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Waktu & Tempat Section -->
        <section class="py-stack-lg px-margin-mobile text-center" id="events">
            <div class="fade-in">
                <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary mb-12">Waktu &amp; Tempat</h2>
                <div class="max-w-4xl mx-auto flex flex-col md:flex-row gap-8 justify-center">
                    <!-- Akad Nikah -->
                    <div class="event-card bg-surface border border-outline-variant/30 rounded-xl p-8 flex-1 shadow-sm">
                        <h3 class="font-label-lg text-label-lg text-primary tracking-widest uppercase mb-4">Akad Nikah</h3>
                        <p class="font-headline-md text-headline-md text-tertiary-fixed-dim mb-4">{{ $invitation->akad_time }} - {{ $invitation->akad_time_end }}</p>
                        <p class="font-body-md text-body-md font-semibold text-on-surface mb-1">{{ $invitation->akad_location }}</p>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-6">{{ $invitation->akad_address }}</p>
                        @if($invitation->akad_maps)
                        <a href="{{ $invitation->akad_maps }}" target="_blank" class="border border-primary text-primary px-6 py-2 rounded-full font-label-sm text-label-sm uppercase tracking-wider hover:bg-primary/5 transition-colors inline-block">Lihat Peta</a>
                        @endif
                    </div>
                    <!-- Reception -->
                    <div class="event-card bg-surface border border-outline-variant/30 rounded-xl p-8 flex-1 shadow-sm">
                        <h3 class="font-label-lg text-label-lg text-primary tracking-widest uppercase mb-4">Wedding Reception</h3>
                        <p class="font-headline-md text-headline-md text-tertiary-fixed-dim mb-4">{{ $invitation->resepsi_time }} - {{ $invitation->resepsi_time_end }}</p>
                        <p class="font-body-md text-body-md font-semibold text-on-surface mb-1">{{ $invitation->resepsi_location }}</p>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-6">{{ $invitation->resepsi_address }}</p>
                        @if($invitation->resepsi_maps)
                        <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="border border-primary text-primary px-6 py-2 rounded-full font-label-sm text-label-sm uppercase tracking-wider hover:bg-primary/5 transition-colors inline-block">Lihat Peta</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Countdown Section -->
        <section class="bg-primary text-white py-stack-md px-margin-mobile text-center">
            <div class="fade-in">
                <p class="font-label-sm text-label-sm tracking-widest uppercase mb-2 opacity-80">Counting Down</p>
                <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-6">Menuju Bahagia</h2>
                <div id="countdownGrid" class="grid grid-cols-4 gap-4 max-w-md mx-auto mb-4">
                    <div class="text-center">
                        <p id="days" class="countdown-num font-headline-lg text-headline-lg">00</p>
                        <p class="font-label-sm text-label-sm uppercase tracking-wider opacity-70">Hari</p>
                    </div>
                    <div class="text-center">
                        <p id="hours" class="countdown-num font-headline-lg text-headline-lg">00</p>
                        <p class="font-label-sm text-label-sm uppercase tracking-wider opacity-70">Jam</p>
                    </div>
                    <div class="text-center">
                        <p id="minutes" class="countdown-num font-headline-lg text-headline-lg">00</p>
                        <p class="font-label-sm text-label-sm uppercase tracking-wider opacity-70">Menit</p>
                    </div>
                    <div class="text-center">
                        <p id="seconds" class="countdown-num font-headline-lg text-headline-lg">00</p>
                        <p class="font-label-sm text-label-sm uppercase tracking-wider opacity-70">Detik</p>
                    </div>
                </div>
                <div id="countdownPassed" class="mb-4 hidden">
                    <p class="font-headline-md text-headline-md">Acara Telah Dimulai</p>
                </div>
                <p class="font-body-md text-body-md opacity-80">Terima kasih atas doa restu Anda</p>
            </div>
        </section>

        <!-- Love Story Section -->
        @php
            $loveStories = is_array($invitation->love_story)
                ? $invitation->love_story
                : json_decode($invitation->love_story, true);
        @endphp
        @if(!empty($loveStories[0]['title']) || !empty($loveStories[0]['story']))
        <section class="py-stack-lg px-margin-mobile" id="story2">
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
                        <h3 class="font-body-lg text-body-lg font-semibold text-primary mb-2">{{ $story['title'] }}</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">{{ $story['story'] }}</p>
                        @if($story['photo'])
                        <img src="{{ '/storage/' . $story['photo'] }}" alt="{{ $story['title'] }}" loading="lazy" class="mt-3 rounded-lg max-h-[200px] object-cover w-full" />
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Gallery Section -->
        <section class="py-stack-lg px-margin-mobile bg-surface-container-low" id="gallery">
            <div class="max-w-container-max-width mx-auto">
                <div class="text-center mb-12 fade-in">
                    <p class="font-label-sm text-label-sm text-outline tracking-widest uppercase mb-2">Moments</p>
                    <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Galeri</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 fade-in" id="galleryGrid">
                    @forelse($invitation->galleries as $index => $photo)
                    <div class="gallery-item {{ $index >= 6 ? 'hidden' : '' }} hover-zoom" data-gallery-index="{{ $index }}">
                        <div class="{{ $index === 2 ? 'aspect-[4/3] rounded-lg overflow-hidden md:col-span-2' : ($index % 2 === 0 ? 'aspect-[3/4] rounded-lg overflow-hidden' : 'aspect-square rounded-lg overflow-hidden') }}">
                            <a href="{{ '/storage/' . $photo->image }}" data-fancybox="gallery" data-caption="Wedding Moment">
                                <img alt="Wedding Moment" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ '/storage/' . $photo->image }}" loading="lazy" />
                            </a>
                        </div>
                    </div>
                    @empty
                    <p class="text-center col-span-full font-body-md text-body-md text-on-surface-variant">Belum ada foto galeri.</p>
                    @endforelse
                </div>
                @if($invitation->galleries->count() > 6)
                <div class="text-center mt-8 fade-in">
                    <button id="loadMoreGallery" class="border border-primary text-primary px-6 py-2 rounded-full font-label-sm text-label-sm uppercase tracking-wider hover:bg-primary/5 transition-colors" onclick="loadMoreGallery()">
                        <span id="loadMoreText">Lihat Lebih Banyak</span>
                        <svg id="loadMoreSpinner" class="animate-spin hidden inline-block ml-2" style="width:18px;height:18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </button>
                </div>
                @endif
            </div>
        </section>

        <!-- Wedding Gifts Section -->
        @if($invitation->enable_gift == 1 && $invitation->gifts->count())
        <section class="py-stack-lg px-margin-mobile bg-surface" id="gifts">
            <div class="max-w-xl mx-auto">
                <div class="text-center mb-12 fade-in">
                    <p class="font-label-sm text-label-sm text-outline tracking-widest uppercase mb-2">Beri Hadiah</p>
                    <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Wedding Gifts</h2>
                </div>
                <div class="space-y-4">
                    @foreach($invitation->gifts as $gift)
                    <div class="gift-card bg-surface-variant/50 rounded-xl p-6 relative overflow-hidden">
                        <div class="absolute right-4 top-4 font-bold text-primary text-xl italic">{{ $gift->bank }}</div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase mb-1">{{ $gift->name }}</p>
                        <p class="font-headline-md text-headline-md text-on-surface mb-4">{{ $gift->number }}</p>
                        <button onclick="copyText('{{ $gift->number }}')" class="inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-sm">content_copy</span> Salin
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP Section -->
        @if($invitation->enable_rsvp == 1)
        <section class="py-3 px-margin-mobile bg-surface-container-low" id="rsvp">
            <div class="max-w-xl mx-auto">
                <div class="text-center mb-12 fade-in">
                    <p class="font-label-sm text-label-sm text-outline tracking-widest uppercase mb-2">RSVP</p>
                    <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Ucapan</h2>
                </div>

                @if($invitation->rsvp_deadline)
                <div class="text-center mb-4 fade-in">
                    <p class="font-label-sm text-label-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-sm align-middle">calendar_today</span>
                        Batas RSVP: {{ \Carbon\Carbon::parse($invitation->rsvp_deadline)->format('d/m/Y') }}
                    </p>
                </div>
                @endif

                @if($invitation->rsvp_message)
                <div class="text-center mb-6 fade-in">
                    <p class="font-body-md text-body-md text-on-surface-variant italic">"{{ $invitation->rsvp_message }}"</p>
                </div>
                @endif

                <div class="bg-surface p-6 md:p-8 rounded-xl shadow-sm border border-outline-variant/30 mb-8 fade-in">
                    <form id="rsvpForm" action="{{ route('rsvp.store', $invitation) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <input name="name" class="w-full rounded-md border border-outline-variant/50 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 bg-surface px-4 py-3" placeholder="Nama Lengkap" type="text" required />
                        </div>
                        <div>
                            <select name="attending" class="w-full rounded-md border border-outline-variant/50 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 bg-surface text-on-surface-variant px-4 py-3" required>
                                <option value="1">Hadir</option>
                                <option value="2">Tidak Hadir</option>
                                <option value="3">Masih Ragu</option>
                            </select>
                        </div>
                        <div>
                            <textarea name="message" class="w-full rounded-md border border-outline-variant/50 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 bg-surface px-4 py-3" placeholder="Tulis doa &amp; ucapan..." rows="4" required></textarea>
                        </div>
                        <button id="rsvpButton" class="w-full border border-primary text-primary px-6 py-3 rounded-md font-label-sm text-label-sm uppercase tracking-wider hover:bg-primary/5 transition-colors" type="submit">
                            <span id="buttonText">Kirim Ucapan</span>
                            <svg id="buttonSpinner" class="animate-spin hidden inline-block ml-2" style="width:18px;height:18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Status Message -->
                <div id="rsvpMessage" class="text-center mb-4 text-sm font-bold hidden"></div>

                <!-- RSVP List -->
                <div class="text-center bg-surface p-6 rounded-xl shadow-sm border border-outline-variant/30 fade-in">
                    <h3 class="font-body-lg text-body-lg text-primary font-semibold mb-4">Tinggalkan kami doa terbaik untuk momen bahagia kami</h3>
                    <div id="rsvpList" class="rsvp-list text-left max-h-[400px] overflow-y-auto" data-url="{{ route('rsvp.list', $invitation) }}">
                        <!-- List loaded via JS -->
                    </div>
                    <p class="font-label-sm text-label-sm text-outline mt-4">({{ $invitation->rsvps->count() }} Ucapan)</p>
                </div>

                @if($invitation->rsvp_whatsapp)
                <div class="text-center mt-6 fade-in">
                    <a href="https://wa.me/{{ $invitation->rsvp_whatsapp }}?text=Halo,%20saya%20ingin%20konfirmasi%20RSVP%20untuk%20undangan%20pernikahan." target="_blank" class="inline-flex items-center gap-2 bg-[#22c55e] text-white px-6 py-3 rounded-full font-label-sm text-label-sm hover:bg-[#16a34a] transition-colors">
                        <span class="material-symbols-outlined" style="font-size:18px;">chat</span> Konfirmasi via WhatsApp
                    </a>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- Video Section -->
        @if(!empty($invitation->video_link))
        @php
            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->video_link, $ytVideoMatches);
            $youtubeVideoId = $ytVideoMatches['id'] ?? '';
        @endphp
        @if($youtubeVideoId)
        <section class="py-stack-lg px-margin-mobile bg-surface-container-low" id="video">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12 fade-in">
                    <p class="font-label-sm text-label-sm text-outline tracking-widest uppercase mb-2">Video</p>
                    <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Video Pernikahan</h2>
                </div>
                <div class="fade-in relative aspect-video rounded-xl overflow-hidden bg-surface-container-high cursor-pointer" data-fancybox="video" data-src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?enablejsapi=1&amp;autoplay=1&amp;loop=1&amp;playlist={{ $youtubeVideoId }}&amp;controls=1&amp;modestbranding=1&amp;rel=0">
                    <img loading="lazy" src="https://img.youtube.com/vi/{{ $youtubeVideoId }}/hqdefault.jpg" alt="Video Pernikahan" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 flex items-center justify-center bg-primary/30">
                        <span class="material-symbols-outlined text-white text-6xl">play_circle</span>
                    </div>
                </div>
            </div>
        </section>
        @endif
        @endif

        <!-- Footer -->
        <footer class="bg-primary text-white py-12 px-margin-mobile text-center pb-28 md:pb-12">
            <h2 class="font-headline-md text-headline-md mb-4 font-headline-lg">{{ $invitation->groom_nickname }} &amp; {{ $invitation->bride_nickname }}</h2>
            <p class="font-body-md text-body-md mb-6 max-w-md mx-auto opacity-90">
                Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.
            </p>
            <p class="font-label-sm text-label-sm opacity-70">&copy; {{ date('Y') }} Elegant Wedding Invitation</p>
        </footer>
    </main>

    <!-- Toast -->
    <div id="toast">Pesan terkirim dengan terima kasih.</div>

    <x-music-player :invitation="$invitation" />

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        /* ---------- 1. TOAST & COPY ---------- */
         function showToast(message) {
             const toast = document.getElementById('toast');
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
                countdownGrid.classList.add('hidden');
                countdownPassed.classList.remove('hidden');
                return;
            }
            
            const d = document.getElementById('days');
            const h = document.getElementById('hours');
            const m = document.getElementById('minutes');
            const s = document.getElementById('seconds');

            const newD = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            const newH = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            const newM = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            const newS = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');

            if (d.textContent !== newD) { d.textContent = newD; d.classList.add('pulse'); setTimeout(() => d.classList.remove('pulse'), 500); }
            if (h.textContent !== newH) { h.textContent = newH; h.classList.add('pulse'); setTimeout(() => h.classList.remove('pulse'), 500); }
            if (m.textContent !== newM) { m.textContent = newM; m.classList.add('pulse'); setTimeout(() => m.classList.remove('pulse'), 500); }
            if (s.textContent !== newS) { s.textContent = newS; s.classList.add('pulse'); setTimeout(() => s.classList.remove('pulse'), 500); }
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
        
        // Target multiple classes for animation
        document.querySelectorAll('.fade-in, .timeline-item, .gift-card').forEach(el => observer.observe(el));

        /* ---------- 4b. BOTTOM NAV HIDE/SHOW ---------- */
        const bottomNav = document.getElementById('bottomNav');
        const heroSection = document.getElementById('home');
        if (bottomNav && heroSection) {
            let lastScrollY = window.scrollY;
            window.addEventListener('scroll', () => {
                const heroRect = heroSection.getBoundingClientRect();
                if (heroRect.bottom > 0) {
                    bottomNav.style.transform = 'translateY(100%)';
                    bottomNav.style.transition = 'transform 0.3s ease';
                } else {
                    bottomNav.style.transform = 'translateY(0)';
                }
                lastScrollY = window.scrollY;
            });
        }

        /* ---------- 4c. BOTTOM NAV ACTIVE SECTION ---------- */
        const bottomNavLinks = document.querySelectorAll('#bottomNav a[href^="#"]');
        const sections = [];
        bottomNavLinks.forEach(link => {
            const targetId = link.getAttribute('href').substring(1);
            const target = document.getElementById(targetId);
            if (target) sections.push({ id: targetId, element: target, link: link });
        });
        window.addEventListener('scroll', () => {
            let currentSection = '';
            sections.forEach(s => {
                const rect = s.element.getBoundingClientRect();
                if (rect.top <= window.innerHeight / 2) {
                    currentSection = s.id;
                }
            });
            bottomNavLinks.forEach(link => {
                link.classList.remove('bg-primary-container', 'text-white', 'rounded-full', 'px-4', 'py-1');
                if (link.getAttribute('href') === '#' + currentSection) {
                    link.classList.add('bg-primary-container', 'text-white', 'rounded-full', 'px-4', 'py-1');
                }
            });
        });

        /* ---------- 5. REMINDER BUTTON ---------- */
        const reminderBtn = document.getElementById('reminderBtn');
        if (reminderBtn) {
            if (localStorage.getItem('weddingReminder')) {
                reminderBtn.style.display = 'none';
            }
            reminderBtn.addEventListener('click', () => {
                const startDate = '{{ \Carbon\Carbon::parse($invitation->wedding_date)->format("Ymd\\THis") }}';
                const endDate = '{{ \Carbon\Carbon::parse($invitation->wedding_date)->addHours(5)->format("Ymd\\THis") }}';
                const gcalUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=Pernikahan+{{ urlencode($invitation->groom_nickname . " & " . $invitation->bride_nickname) }}&dates=' + startDate + '/' + endDate + '&details=Undangan+pernikahan&location={{ urlencode($invitation->resepsi_location ?? "") }}';
                window.open(gcalUrl, '_blank');
                showToast('Membuka Google Calendar...');
            });
        }

        /* ---------- 6. RSVP FORM ---------- */
        const rsvpForm = document.getElementById('rsvpForm');
        const rsvpButton = document.getElementById('rsvpButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');
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
                buttonSpinner.classList.remove('hidden');
                rsvpButton.disabled = true;
                rsvpMessage.classList.add('hidden');

                fetch(submitUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
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
                    buttonSpinner.classList.add('hidden');
                    rsvpButton.disabled = false;
                });
            });
        }

        /* ---------- 7. LOAD RSVP LIST ---------- */
        function loadRsvpList() {
            var rsvpList = document.getElementById('rsvpList');
            if (!rsvpList) return;

            var listUrl = rsvpList.getAttribute('data-url');
            if (!listUrl) return;

            fetch(listUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
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
                    rsvpList.innerHTML = '<p class="font-body-md text-body-md text-on-surface-variant text-center mb-2">Belum ada ucapan. Jadilah yang pertama!</p><span class="material-symbols-outlined text-primary block text-center mb-2">favorite</span>';
                }
            })
            .catch(function(err) { console.error('Failed to load RSVP list:', err); });
        }
        loadRsvpList();

        /* ---------- 8. SMOOTH SCROLL ---------- */
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

        /* ---------- GALLERY LOAD MORE ---------- */
        window.loadMoreGallery = function() {
            var button = document.getElementById('loadMoreGallery');
            var text = document.getElementById('loadMoreText');
            var spinner = document.getElementById('loadMoreSpinner');
            if (!button) return;
            var visibleCount = document.querySelectorAll('#galleryGrid .gallery-item:not(.hidden)').length;
            var totalCount = document.querySelectorAll('#galleryGrid .gallery-item').length;
            if (visibleCount >= totalCount) return;
            text.textContent = 'Memuat...';
            spinner.classList.remove('hidden');
            button.disabled = true;
            setTimeout(function() {
                var items = document.querySelectorAll('#galleryGrid .gallery-item.hidden');
                var shown = 0;
                items.forEach(function(item) {
                    if (shown < 6) {
                        item.classList.remove('hidden');
                        shown++;
                    }
                });
                text.textContent = visibleCount + shown >= totalCount ? 'Tampilkan Semua' : 'Lihat Lebih Banyak';
                spinner.classList.add('hidden');
                button.disabled = false;
                if (visibleCount + shown >= totalCount) {
                    button.style.display = 'none';
                }
            }, 300);
        };

    });
    </script>
</body>

</html>