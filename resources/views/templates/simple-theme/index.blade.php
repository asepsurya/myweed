<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }} | The Wedding</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <!-- Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
=======
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} | Wedding Invitation</title>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} Wedding Invitation">
    <meta property="og:description" content="You are invited to the wedding of {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}. Click to see the details.">
    <meta property="og:image" content="{{ asset('storage/' . $invitation->gallery_cover) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} Wedding Invitation">
    <meta property="twitter:description" content="You are invited to the wedding of {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}. Click to see the details.">
    <meta property="twitter:image" content="{{ asset('storage/' . $invitation->gallery_cover) }}">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@600;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
<<<<<<< HEAD
                        serif: ['Playfair Display'],
                        sans: ['Lato']
                    },
                    colors: {
                        primary: '#c8a97e',
                        'outline-variant': '#c8c8c8',
                        'tertiary-fixed-dim': '#d4c5a0',
                        'surface-variant': '#f5f0e8',
                        'on-surface-variant': '#6b6b6b',
                        'headline-md': '#333333',
                        'on-surface': '#333333',
                        'surface': '#fdfaf6',
                        'surface-container-low': '#f0ebe3',
                        'surface-container-high': '#e8e4db',
=======
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Lato', 'sans-serif'],
                        cursive: ['Great Vibes', 'cursive']
                    },
                    colors: {
                        primary: '{{ $invitation->primary_color ?? '#c8a97e' }}'
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style>
<<<<<<< HEAD
        body {
            overflow: auto;
            min-height: 100vh;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
        }

        .animate-on-scroll.show {
            animation: fadeUp .9s ease-out forwards;
        }

        .youtube-player-container {
            position: absolute;
            left: -9999px;
            width: 2px;
            height: 2px;
            overflow: hidden;
        }

        h2 {
            font-family: 'Great Vibes', cursive;
            letter-spacing: 0.05em;
        }

        #toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 16px;
            position: fixed;
            z-index: 100;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            font-size: 14px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.5s, bottom 0.5s;
        }

        #toast.show {
            visibility: visible;
            opacity: 1;
            bottom: 50px;
        }
=======
        body.lock-scroll { overflow: hidden; height: 100vh; }
        .fade-in { opacity: 0; transform: translateY(30px); transition: 0.8s all; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }
        h2 { font-family: 'Great Vibes', cursive; }
        .masonry-gallery { column-count: 2; column-gap: 10px; }
        .masonry-item { break-inside: avoid; margin-bottom: 10px; }
        
        /* --- Desktop Layout --- */
        @media (min-width: 1024px) {
            body { background: #e5e5e5; height: 100vh; overflow: hidden; display: flex; align-items: center; justify-content: center; }
            .w-full.max-w-\[420px\] { max-width: 1000px !important; flex-direction: row !important; display: flex !important; height: 90vh; border-radius: 20px; overflow: hidden; border: 1px solid rgba(0,0,0,0.1); }
            header { flex: 1.2; height: 100% !important; background-attachment: scroll; }
            .content-wrapper { flex: 1; height: 100%; overflow-y: auto; background: #fdfaf6; scrollbar-width: none; -ms-overflow-style: none; }
            .content-wrapper::-webkit-scrollbar { display: none; }
        }
        
        body { scrollbar-width: none; -ms-overflow-style: none; }
        body::-webkit-scrollbar { display: none; }
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
    </style>
</head>
<body class="bg-gray-300 flex justify-center font-sans">

<<<<<<< HEAD
<body class="bg-gray-300 flex justify-center font-sans">

    <!-- Tombol Floating Music -->
    <button id="musicToggle" class="fixed bottom-6 right-6 bg-primary text-white p-3 rounded-full shadow-lg flex items-center justify-center z-50 hover:bg-primary/90 transition">
        <svg id="musicIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-6.518-3.759A1 1 0 007 8.32v7.36a1 1 0 001.234.97l6.518-1.885a1 1 0 00.75-.97v-1.87a1 1 0 00-.75-.97z" />
        </svg>
    </button>

    <!-- MOBILE WRAPPER -->
    <div class="w-full max-w-[420px] min-h-screen bg-[#fdfaf6] relative overflow-hidden shadow-2xl">

        <!-- ================= COVER ================= -->
        <section id="home" class="relative h-screen flex items-center justify-center text-center">
            <div class="absolute inset-0 bg-cover bg-center lazy-bg" style="background-image: url('{{ asset('storage/' . ($invitation->gallery_cover ?? 'default/cover.jpg')) }}')"></div>
            <div class="absolute inset-0 bg-black/50"></div>

            <div class="relative z-10 text-white px-6 space-y-4">
                <p class="text-sm tracking-widest uppercase">Undangan Pernikahan</p>
                <h1 class="font-serif text-5xl font-bold">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h1>
                <p class="text-sm">
                    Kepada Yth<br>
                    <span class="border-b border-white px-2 py-1 inline-block mt-2">
                        Bapak / Ibu / Saudara
                    </span>
                </p>
                <span class="mt-3">{{ request('to') ?? 'Keluarga Besar' }}</span>
                <p class="text-sm">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</p>

                <button id="openInvitation" class="bg-primary px-8 py-3 rounded-full text-sm font-semibold shadow-lg active:scale-95 transition">
                    <i class="ti ti-mail-opened text-lg"></i> Buka Undangan
                </button>
            </div>
        </section>

        <!-- ================= QUOTES ================= -->
        <section id="quote" class="py-16 px-6 text-center max-w-2xl mx-auto">
            <div class="animate-on-scroll">
                <h2 class="font-serif text-3xl text-primary mb-6">Quotes</h2>
                <span class="material-symbols-outlined text-outline-variant text-4xl mb-4 block">format_quote</span>
                <p class="text-gray-600 leading-relaxed mb-6 italic">
                    {!! nl2br(e(str_replace('(', "\n(", $invitation->wedding_quote))) !!}
                </p>
                <div class="w-16 h-[1px] bg-outline-variant mx-auto mt-8"></div>
            </div>
        </section>

        <!-- ================= CONTENT ================= -->
        <section id="content" class="space-y-14 py-12">
            @foreach ($invitation->template->sections as $section)
                @includeIf('templates.' . $invitation->template->slug . '.sections.' . $section)
            @endforeach
        </section>

        @php
            $loveStories = is_array($invitation->love_story)
                ? $invitation->love_story
                : json_decode($invitation->love_story, true);
        @endphp

        @if(!empty($loveStories[0]['title']) || !empty($loveStories[0]['story']))
        <section id="story2" class="py-16 px-6">
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-12 animate-on-scroll">
                    <p class="text-sm text-outline tracking-widest uppercase mb-2">Kisah Kami</p>
                    <h2 class="font-serif text-3xl text-primary">Love Story</h2>
                </div>
                <div class="relative pl-6 animate-on-scroll">
                    @foreach($loveStories as $index => $story)
                    <div class="{{ $index < count($loveStories) - 1 ? 'mb-8' : '' }} relative timeline-item {{ $index < count($loveStories) - 1 ? 'timeline-line' : '' }}">
                        <div class="absolute -left-6 top-1 w-6 h-6 rounded-full border-2 border-tertiary-fixed-dim bg-surface flex items-center justify-center z-10">
                            <div class="w-2 h-2 rounded-full bg-tertiary-fixed-dim"></div>
                        </div>
                        <h3 class="font-body-lg text-body-lg font-semibold text-primary mb-2">{{ $story['title'] }}</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">{{ $story['story'] }}</p>
                        @if($story['photo'])
                            <img src="{{ asset('storage/' . $story['photo']) }}" alt="{{ $story['title'] }}" loading="lazy" class="mt-3 rounded-lg max-h-[200px] object-cover w-full" />
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        @if($invitation->enable_gift == 1 && $invitation->gifts->count())
        <section id="gifts" class="py-16 px-6 bg-surface">
            <div class="max-w-xl mx-auto">
                <div class="text-center mb-12 animate-on-scroll">
                    <p class="text-sm text-outline tracking-widest uppercase mb-2">Beri Hadiah</p>
                    <h2 class="font-serif text-3xl text-primary">Wedding Gifts</h2>
                </div>
                <div class="space-y-4 animate-on-scroll">
                    @foreach($invitation->gifts as $gift)
                    <div class="bg-surface-variant/50 rounded-xl p-6 relative overflow-hidden">
                        <div class="absolute right-4 top-4 font-bold text-primary text-xl italic">{{ $gift->bank }}</div>
                        <p class="text-xs text-on-surface-variant uppercase mb-1">{{ $gift->name }}</p>
                        <p class="font-headline-md text-headline-md text-on-surface mb-4">{{ $gift->number }}</p>
                        <button onclick="copyText('{{ $gift->number }}')" class="inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-sm">content_copy</span> Salin
                        </button>
                    </div>
                    @endforeach
                </div>
=======
    <!-- Music Control -->
    <div id="musicBtn" class="fixed bottom-6 left-6 w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center shadow-2xl cursor-pointer z-50">▶</div>

    <div class="w-full max-w-[420px] min-h-screen bg-[#fdfaf6] relative overflow-hidden shadow-2xl">
        
        <!-- Hero Section -->
        <header class="relative h-screen flex items-center justify-center text-center">
            <div id="preview-hero-bg" class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $invitation->gallery_cover) }}')"></div>
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 text-white px-6 space-y-4">
                <p class="text-sm tracking-widest uppercase font-serif">The Wedding Of</p>
                <h1 class="font-serif text-5xl font-bold italic">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h1>
                <p class="text-sm mt-4">Kepada Yth: {{ request('to') ?? 'Tamu Undangan' }}</p>
                <div class="mt-6 border-y border-white/30 py-3">
                    <p class="text-lg font-serif italic">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('d F Y') }}</p>
                </div>
                <button onclick="document.getElementById('mempelai').scrollIntoView({behavior:'smooth'})" class="mt-8 bg-primary/90 text-white px-8 py-3 rounded-full text-sm font-bold tracking-widest uppercase hover:bg-primary transition">Buka Undangan</button>
            </div>
        </header>

        <div class="content-wrapper">
            <!-- Quote -->
        <section class="py-16 px-8 text-center bg-white border-b">
            <div class="fade-in">
                <i class="ti ti-quote text-4xl text-primary/30"></i>
                <p class="italic text-gray-600 leading-relaxed mt-4">"{{ $invitation->wedding_quote ?? 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri...' }}"</p>
                <p class="mt-4 font-serif text-primary font-bold text-sm">{{ $invitation->quote_id ?? 'QS. Ar-Rum: 21' }}</p>
            </div>
        </section>

        <!-- Mempelai -->
        <section id="mempelai" class="py-20 px-6 text-center space-y-16">
            <div class="fade-in">
                <h2 class="text-5xl text-primary italic">Mempelai</h2>
                <p class="text-sm text-gray-500 uppercase tracking-widest mt-2">The Happy Couple</p>
            </div>
            
            <div class="space-y-16">
                <!-- Groom -->
                <div class="fade-in">
                    <div class="relative inline-block">
                        <img id="preview-foto-pria" src="{{ asset('storage/' . $invitation->foto_pria) }}" alt="Groom" class="w-56 h-72 object-cover rounded-full border-8 border-white shadow-2xl">
                        <div class="absolute -bottom-4 -right-4 bg-primary text-white p-3 rounded-full shadow-lg"><i class="ti ti-men text-xl"></i></div>
                    </div>
                    <h3 class="text-3xl font-serif mt-8 text-gray-800 italic">{{ $invitation->groom_name }}</h3>
                    <p class="text-sm text-gray-600 mt-2 font-serif uppercase tracking-tighter">Putra dari Bpk. {{ $invitation->groom_father_name }} & Ibu {{ $invitation->groom_mother_name }}</p>
                    <a href="https://instagram.com/{{ $invitation->groom_instagram }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-primary font-bold text-xs"><i class="ti ti-brand-instagram"></i> @ {{ $invitation->groom_instagram }}</a>
                </div>

                <div class="text-6xl font-cursive text-primary/30 fade-in">&</div>

                <!-- Bride -->
                <div class="fade-in">
                    <div class="relative inline-block">
                        <img id="preview-foto-wanita" src="{{ asset('storage/' . $invitation->foto_wanita) }}" alt="Bride" class="w-56 h-72 object-cover rounded-full border-8 border-white shadow-2xl">
                        <div class="absolute -bottom-4 -left-4 bg-primary text-white p-3 rounded-full shadow-lg"><i class="ti ti-woman text-xl"></i></div>
                    </div>
                    <h3 class="text-3xl font-serif mt-8 text-gray-800 italic">{{ $invitation->bride_name }}</h3>
                    <p class="text-sm text-gray-600 mt-2 font-serif uppercase tracking-tighter">Putri dari Bpk. {{ $invitation->bride_father_name }} & Ibu {{ $invitation->bride_mother_name }}</p>
                    <a href="https://instagram.com/{{ $invitation->bride_instagram }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-primary font-bold text-xs"><i class="ti ti-brand-instagram"></i> @ {{ $invitation->bride_instagram }}</a>
                </div>
            </div>
        </section>

        <!-- Waktu & Tempat -->
        <section class="py-20 px-6 bg-[#f7f3ed] text-center space-y-12">
            <div class="fade-in">
                <h2 class="text-5xl text-primary italic">Save The Date</h2>
                <div class="w-16 h-0.5 bg-primary/30 mx-auto mt-4"></div>
            </div>
            
            <div class="space-y-8 fade-in">
                <!-- Akad -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-primary/10">
                    <h3 class="font-serif text-2xl text-primary italic">Akad Nikah</h3>
                    <div class="my-4 text-4xl font-bold text-gray-800">{{ $invitation->akad_time }}</div>
                    <div class="space-y-1 text-gray-600 italic">
                        <p class="font-bold">{{ $invitation->akad_location }}</p>
                        <p class="text-sm px-4">{{ $invitation->akad_address }}</p>
                    </div>
                    <a href="{{ $invitation->akad_maps }}" target="_blank" class="inline-block mt-6 bg-primary text-white px-6 py-2 rounded-full text-xs font-bold uppercase tracking-widest shadow-md">Buka Lokasi</a>
                </div>

                <!-- Resepsi -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-primary/10">
                    <h3 class="font-serif text-2xl text-primary italic">Resepsi Pernikahan</h3>
                    <div class="my-4 text-4xl font-bold text-gray-800">{{ $invitation->resepsi_time }}</div>
                    <div class="space-y-1 text-gray-600 italic">
                        <p class="font-bold">{{ $invitation->resepsi_location }}</p>
                        <p class="text-sm px-4">{{ $invitation->resepsi_address }}</p>
                    </div>
                    <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="inline-block mt-6 bg-primary text-white px-6 py-2 rounded-full text-xs font-bold uppercase tracking-widest shadow-md">Buka Lokasi</a>
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="py-16 px-6 bg-primary text-white text-center">
            <div class="fade-in">
                <p class="font-serif italic text-lg opacity-80">Menghitung Hari Bahagia</p>
                <div class="flex justify-center gap-4 mt-8" id="countdown">
                    <div class="text-center">
                        <div id="days" class="text-4xl font-bold">00</div>
                        <div class="text-[10px] uppercase tracking-widest opacity-70">Hari</div>
                    </div>
                    <div class="text-center">
                        <div id="hours" class="text-4xl font-bold">00</div>
                        <div class="text-[10px] uppercase tracking-widest opacity-70">Jam</div>
                    </div>
                    <div class="text-center">
                        <div id="minutes" class="text-4xl font-bold">00</div>
                        <div class="text-[10px] uppercase tracking-widest opacity-70">Menit</div>
                    </div>
                    <div class="text-center">
                        <div id="seconds" class="text-4xl font-bold">00</div>
                        <div class="text-[10px] uppercase tracking-widest opacity-70">Detik</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Galeri -->
        <section class="py-20 px-6 text-center space-y-10">
            <h2 class="text-5xl text-primary italic">Galeri Momen</h2>
            <div class="masonry-gallery fade-in" id="gallery-container">
                @foreach($invitation->galleries as $photo)
                <a href="{{ asset('storage/' . $photo->image) }}" data-fancybox="gallery" class="masonry-item rounded-2xl overflow-hidden shadow-lg border-4 border-white">
                    <img src="{{ asset('storage/' . $photo->image) }}" alt="Gallery" class="w-full object-cover">
                </a>
                @endforeach
            </div>
        </section>

        <!-- Gift -->
        @if($invitation->enable_gift == 1 && $invitation->gifts->count())
        <section class="py-20 px-6 text-center space-y-10 bg-[#f7f3ed]">
            <h2 class="text-5xl text-primary italic">Wedding Gift</h2>
            <div class="space-y-6">
                @foreach($invitation->gifts as $gift)
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-primary/10 fade-in">
                    <h3 class="font-serif text-2xl text-primary italic">{{ $gift->bank }}</h3>
                    <div class="my-4 text-3xl font-bold text-gray-800">{{ $gift->number }}</div>
                    <p class="text-sm text-gray-600 italic">A/N: {{ $gift->name }}</p>
                    <button onclick="copyToClipboard('{{ $gift->number }}')" class="inline-block mt-6 bg-primary text-white px-8 py-2 rounded-full text-xs font-bold uppercase tracking-widest shadow-md">Salin</button>
                </div>
                @endforeach
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
            </div>
        </section>
        @endif

<<<<<<< HEAD
        @if(!empty($invitation->video_link))
        @php
            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->video_link, $ytVideoMatches);
            $youtubeVideoId = $ytVideoMatches['id'] ?? '';
        @endphp
        @if($youtubeVideoId)
        <section id="video" class="py-16 px-6 bg-surface-container-low">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12 animate-on-scroll">
                    <p class="text-sm text-outline tracking-widest uppercase mb-2">Video</p>
                    <h2 class="font-serif text-3xl text-primary">Video Pernikahan</h2>
                </div>
                <div class="animate-on-scroll relative aspect-video rounded-xl overflow-hidden bg-surface-container-high cursor-pointer" data-fancybox="video" data-src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeVideoId }}&controls=1&modestbranding=1&rel=0">
                    <img src="https://img.youtube.com/vi/{{ $youtubeVideoId }}/hqdefault.jpg" alt="Video Pernikahan" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 flex items-center justify-center bg-primary/30">
                        <span class="material-symbols-outlined text-white text-6xl">play_circle</span>
                    </div>
                </div>
            </div>
        </section>
        @endif
        @endif

=======
        <!-- RSVP -->
        @if($invitation->enable_rsvp == 1)
        <section class="py-20 px-8 bg-white space-y-10">
            <div class="text-center">
                <h2 class="text-5xl text-primary italic">Doa & Ucapan</h2>
                <p class="text-sm text-gray-500 mt-2 uppercase tracking-widest">Share Your Blessings</p>
            </div>
            
            <form id="rsvpForm" class="space-y-4">
                @csrf
                <input type="text" name="name" class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition font-serif" placeholder="Nama Anda" required>
                <select name="attending" class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition font-serif">
                    <option value="1">Akan Hadir</option>
                    <option value="0">Berhalangan Hadir</option>
                </select>

                <div class="emoji-picker" style="margin-bottom: 10px; display: flex; gap: 10px; justify-content: center;">
                    <button type="button" onclick="addEmoji('🎉')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🎉</button>
                    <button type="button" onclick="addEmoji('❤️')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">❤️</button>
                    <button type="button" onclick="addEmoji('🥳')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🥳</button>
                    <button type="button" onclick="addEmoji('✨')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">✨</button>
                    <button type="button" onclick="addEmoji('🙏')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🙏</button>
                </div>

                <textarea name="message" class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition font-serif" rows="4" placeholder="Tulis doa atau ucapan manis untuk kedua mempelai..." required></textarea>
                <button type="submit" id="rsvpButton" class="w-full bg-primary text-white py-4 rounded-2xl font-bold shadow-xl hover:bg-primary/90 transition transform active:scale-95 uppercase tracking-widest text-sm">Kirim Ucapan</button>
            </form>

            <div id="rsvpList" class="space-y-4 max-h-[400px] overflow-y-auto pt-4 scrollbar-hide"></div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-16 bg-gray-900 text-white text-center">
            <h2 class="text-4xl italic text-primary">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h2>
            <p class="mt-6 text-sm opacity-60 leading-loose px-10">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.</p>
            <div class="mt-12 flex justify-center gap-4 opacity-40">
                <i class="ti ti-heart"></i>
                <i class="ti ti-heart-filled text-primary"></i>
                <i class="ti ti-heart"></i>
            </div>
            <p class="text-[10px] mt-10 opacity-30 tracking-[0.3em] uppercase">Wedding Invitation &copy; {{ date('Y') }}</p>
        </footer>
        </div>
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
    </div>
    <!-- End MOBILE WRAPPER -->

<<<<<<< HEAD
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

    <nav id="bottomNav" class="fixed bottom-0 left-0 right-0 z-50 flex justify-around items-center px-2 py-2 pb-4 bg-white/95 backdrop-blur-md border-t border-gray-100 shadow-[0_-2px_16px_0_rgba(200,169,126,0.1)]">
        @foreach($navItems as $item)
        <a class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-medium transition-all duration-200 px-3 py-1.5 rounded-xl {{ ($item['primary'] ?? false) ? 'bg-primary text-white shadow-md' : 'text-[#5a5a5a] hover:text-primary hover:bg-primary/5' }}" href="{{ $item['href'] }}">
            <span class="material-symbols-outlined" style="font-size: 20px;">{{ $item['icon'] }}</span>
            <span>{{ $item['label'] }}</span>
        </a>
        @endforeach
    </nav>

    <!-- Toast -->
    <div id="toast">Pesan terkirim dengan terima kasih.</div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            /* ---------- TOAST ---------- */
            function showToast(message) {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.className = 'show';
                setTimeout(() => { toast.className = ''; }, 3000);
            }

            /* ---------- OPEN INVITATION ---------- */
            const openBtn = document.getElementById('openInvitation');
            if (openBtn) {
                openBtn.addEventListener('click', () => {
                    const content = document.getElementById('content');
                    if (content) {
                        content.scrollIntoView({ behavior: 'smooth' });
                    }
                });
=======
    <!-- Audio -->
    @if($invitation->youtube_url)
        @php
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $invitation->youtube_url, $match)) {
                $videoId = $match[1];
            }
        @endphp
        @if(isset($videoId))
            <iframe id="ytIframe" width="0" height="0" src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $videoId }}" frameborder="0" allow="autoplay" style="display:none"></iframe>
        @endif
    @endif
    <audio id="bgMusic" loop>
        <source src="{{ $invitation->musicPreset ? asset('storage/'.$invitation->musicPreset->audio_url) : 'https://www.bensound.com/bensound-music/bensound-romantic.mp3' }}" type="audio/mpeg">
    </audio>

    <script>
        // Scroll Animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // Countdown
        const weddingDate = new Date("{{ $invitation->wedding_date }}").getTime();
        const countdownTimer = setInterval(() => {
            const now = new Date().getTime();
            const distance = weddingDate - now;
            if (distance < 0) { clearInterval(countdownTimer); return; }
            document.getElementById("days").innerText = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            document.getElementById("hours").innerText = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            document.getElementById("minutes").innerText = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            document.getElementById("seconds").innerText = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }, 1000);

        // Music Logic
        const bgMusic = document.getElementById('bgMusic');
        const musicBtn = document.getElementById('musicBtn');
        const ytIframe = document.getElementById('ytIframe');
        let hasInteracted = false;
        let isYoutube = {{ $invitation->youtube_url ? 'true' : 'false' }};

        window.copyToClipboard = (text) => {
            navigator.clipboard.writeText(text).then(() => {
                alert("Berhasil disalin!");
            });
        };

        function playMusic() {
            if (isYoutube && ytIframe) { ytIframe.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*'); }
            else if (bgMusic) { bgMusic.play().catch(e => console.log("Autoplay blocked")); }
            musicBtn.innerHTML = '⏸';
        }
        function pauseMusic() {
            if (isYoutube && ytIframe) { ytIframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*'); }
            else if (bgMusic) { bgMusic.pause(); }
            musicBtn.innerHTML = '▶';
        }
        window.addEventListener('scroll', () => { if (!hasInteracted) { playMusic(); hasInteracted = true; } }, { once: true });
        musicBtn.onclick = () => { if (musicBtn.innerHTML === '▶') playMusic(); else pauseMusic(); };

        // RSVP Logic
        const invId = "{{ $invitation->id }}";
        function loadRSVPs() {
            fetch(`/invitation/${invId}/rsvps`).then(res => res.json()).then(data => {
                document.getElementById('rsvpList').innerHTML = data.map(r => `
                    <div class="p-5 bg-gray-50 rounded-3xl border-l-8 border-primary shadow-sm">
                        <div class="flex justify-between items-start">
                            <p class="font-serif font-bold text-gray-800 text-lg">${r.name}</p>
                            <span class="text-[10px] bg-white text-primary px-3 py-1 rounded-full border border-primary/20 font-bold uppercase tracking-widest italic">${r.attending ? 'Hadir' : 'Absen'}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2 italic leading-relaxed font-serif">"${r.message}"</p>
                    </div>
                `).join('');
            });
        }
        document.getElementById('rsvpForm').onsubmit = (e) => {
            e.preventDefault();
            const btn = document.getElementById('rsvpButton');
            btn.disabled = true; btn.innerText = 'Mengirim...';
            fetch(`/invitation/${invId}/rsvp`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
            }).then(() => { e.target.reset(); loadRSVPs(); }).finally(() => { btn.disabled = false; btn.innerText = 'Kirim Ucapan'; });
        };
        loadRSVPs();

        // Live Preview Sync
        window.addEventListener('message', function(event) {
            if (event.data.type === 'syncImages') {
                const imgs = event.data.images;
                if (imgs.pria) {
                    const el = document.getElementById('preview-foto-pria');
                    if(el) el.src = imgs.pria;
                }
                if (imgs.wanita) {
                    const el = document.getElementById('preview-foto-wanita');
                    if(el) el.src = imgs.wanita;
                }
                if (imgs.cover) {
                    const el = document.getElementById('preview-hero-bg');
                    if(el) el.style.backgroundImage = `url('${imgs.cover}')`;
                }
                if (imgs.gallery && imgs.gallery.length > 0) {
                    const galleryContainer = document.getElementById('gallery-container');
                    if (galleryContainer) {
                        galleryContainer.innerHTML = imgs.gallery.map(src => `
                            <a href="${src}" data-fancybox="gallery" class="masonry-item rounded-2xl overflow-hidden shadow-lg border-4 border-white">
                                <img src="${src}" alt="Gallery" class="w-full object-cover">
                            </a>
                        `).join('');
                    }
                }
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
            }

<<<<<<< HEAD
            /* ---------- COUNTDOWN ---------- */
            const weddingDate = new Date('{{ \Carbon\Carbon::parse($invitation->wedding_date)->format("Y-m-d H:i:s") }}').getTime();
            function updateCountdown() {
                const now = new Date().getTime();
                const distance = weddingDate - now;
                if (distance < 0) {
                    const grid = document.getElementById('countdownGrid');
                    const passed = document.getElementById('countdownPassed');
                    if (grid) grid.classList.add('hidden');
                    if (passed) passed.classList.remove('hidden');
                    return;
                }
                const days = document.getElementById('days');
                const hours = document.getElementById('hours');
                const minutes = document.getElementById('minutes');
                const seconds = document.getElementById('seconds');
                if (days) days.textContent = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
                if (hours) hours.textContent = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                if (minutes) minutes.textContent = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                if (seconds) seconds.textContent = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
            }
            updateCountdown();
            setInterval(updateCountdown, 1000);

            /* ---------- SCROLL ANIMATIONS ---------- */
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

            /* ---------- RSVP FORM ---------- */
            const rsvpForm = document.getElementById('rsvpForm');
            if (rsvpForm) {
                rsvpForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = this;
                    const formData = new FormData(form);
                    const submitUrl = form.getAttribute('action');
                    const buttonText = document.getElementById('buttonText');
                    const buttonSpinner = document.getElementById('buttonSpinner');
                    const rsvpMessage = document.getElementById('rsvpMessage');
                    const rsvpButton = document.getElementById('rsvpButton');

                    if (!submitUrl) return;

                    if (buttonText) buttonText.textContent = 'Mengirim...';
                    if (buttonSpinner) buttonSpinner.classList.remove('hidden');
                    if (rsvpButton) rsvpButton.disabled = true;
                    if (rsvpMessage) rsvpMessage.classList.add('hidden');

                    fetch(submitUrl, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Gagal mengirim ucapan.');
                            }).catch(err => {
                                if (err.message && err.message !== 'Gagal mengirim ucapan.') throw err;
                                throw new Error('Gagal mengirim ucapan. Silakan coba lagi.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (rsvpMessage) {
                            rsvpMessage.textContent = 'Terima kasih! Ucapan Anda telah terkirim.';
                            rsvpMessage.style.color = '#22c55e';
                            rsvpMessage.classList.remove('hidden');
                        }
                        form.reset();
                        loadRsvpList();
                        showToast('Ucapan berhasil dikirim!');
                        setTimeout(() => { if (rsvpMessage) rsvpMessage.classList.add('hidden'); }, 5000);
                    })
                    .catch(err => {
                        if (rsvpMessage) {
                            rsvpMessage.textContent = err.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                            rsvpMessage.style.color = '#ef4444';
                            rsvpMessage.classList.remove('hidden');
                        }
                        setTimeout(() => { if (rsvpMessage) rsvpMessage.classList.add('hidden'); }, 5000);
                    })
                    .finally(() => {
                        if (buttonText) buttonText.textContent = 'Kirim Ucapan';
                        if (buttonSpinner) buttonSpinner.classList.add('hidden');
                        if (rsvpButton) rsvpButton.disabled = false;
                    });
                });
            }

            /* ---------- LOAD RSVP LIST ---------- */
            function loadRsvpList() {
                const rsvpList = document.getElementById('rsvpList');
                if (!rsvpList) return;
                const listUrl = rsvpList.getAttribute('data-url');
                if (!listUrl) return;

                fetch(listUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        rsvpList.innerHTML = data.map(item =>
                            '<div class="comment-item flex gap-3 bg-gray-50 p-3 rounded-lg mb-3">' +
                            '<div class="w-8 h-8 rounded-full bg-gray-200 flex-shrink-0 flex items-center justify-center">' +
                            '<span class="material-symbols-outlined text-gray-400" style="font-size:16px;">person</span>' +
                            '</div>' +
                            '<div class="flex-1 min-w-0">' +
                            '<p class="font-semibold text-sm text-primary mb-1">' + item.name + '</p>' +
                            '<p class="text-sm text-gray-600 leading-relaxed">' + item.message + '</p>' +
                            '<p class="text-xs text-gray-400 mt-1">' + timeAgo(item.created_at) + '</p>' +
                            '</div></div>'
                        ).join('');
                    } else {
                        rsvpList.innerHTML = '<p class="text-center text-gray-500 text-sm">Belum ada ucapan. Jadilah yang pertama!</p>';
                    }
                })
                .catch(err => console.error('Failed to load RSVP list:', err));
            }
            loadRsvpList();

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

            /* ---------- GALLERY LOAD MORE ---------- */
            window.loadMoreGallery = function() {
                const button = document.getElementById('loadMoreGallery');
                const text = document.getElementById('loadMoreText');
                const spinner = document.getElementById('loadMoreSpinner');
                if (!button) return;
                const visibleCount = document.querySelectorAll('#galleryGrid .gallery-item:not(.hidden)').length;
                const totalCount = document.querySelectorAll('#galleryGrid .gallery-item').length;
                if (visibleCount >= totalCount) return;
                if (text) text.textContent = 'Memuat...';
                if (spinner) spinner.classList.remove('hidden');
                button.disabled = true;
                setTimeout(() => {
                    const items = document.querySelectorAll('#galleryGrid .gallery-item.hidden');
                    let shown = 0;
                    items.forEach(item => {
                        if (shown < 6) { item.classList.remove('hidden'); shown++; }
                    });
                    if (text) text.textContent = visibleCount + shown >= totalCount ? 'Tampilkan Semua' : 'Lihat Lebih Banyak';
                    if (spinner) spinner.classList.add('hidden');
                    button.disabled = false;
                    if (visibleCount + shown >= totalCount) button.style.display = 'none';
                }, 300);
            };

            /* ---------- BOTTOM NAV ACTIVE SECTION ---------- */
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
                    link.classList.remove('bg-primary', 'text-white');
                    if (link.getAttribute('href') === '#' + currentSection) {
                        link.classList.add('bg-primary', 'text-white');
                    }
                });
            });

            /* ---------- SMOOTH SCROLL ---------- */
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const offset = 80;
                        const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                        window.scrollTo({ top, behavior: 'smooth' });
                    }
                });
            });

        });
=======
        function addEmoji(emoji) {
            const textarea = document.querySelector('textarea[name="message"]');
            textarea.value += emoji;
            textarea.focus();
        }
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
    </script>
</body>
<<<<<<< HEAD

</html>
=======
</html>
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
