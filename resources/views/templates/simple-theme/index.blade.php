<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} | Wedding Invitation</title>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} Wedding Invitation">
    <meta property="og:description" content="You are invited to the wedding of {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}. Click to see the details.">
    <meta property="og:image" content="{{ storage_url($invitation->gallery_cover) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} Wedding Invitation">
    <meta property="twitter:description" content="You are invited to the wedding of {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}. Click to see the details.">
    <meta property="twitter:image" content="{{ storage_url($invitation->gallery_cover) }}">

    <!-- Tailwind & Elegant Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Great+Vibes&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <!-- Fancybox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'serif'],
                        sans: ['Montserrat', 'sans-serif'],
                        cursive: ['"Great Vibes"', 'cursive']
                    },
                    colors: {
                        primary: '{{ $invitation->primary_color ?? '#c8a97e' }}'
                    }
                }
            }
        }
    </script>

    <style>
        body.lock-scroll {
            overflow: hidden;
            height: 100vh;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: 0.8s all;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        h2 {
            font-family: 'Great Vibes', cursive;
        }

        .masonry-gallery {
            column-count: 2;
            column-gap: 10px;
        }

        .masonry-item {
            break-inside: avoid;
            margin-bottom: 10px;
        }

        /* --- Desktop Layout --- */
        @media (min-width: 1024px) {
            body {
                background: #e5e5e5;
                height: 100vh;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .w-full.max-w-\[420px\] {
                max-width: 1000px !important;
                flex-direction: row !important;
                display: flex !important;
                height: 90vh;
                border-radius: 20px;
                overflow: hidden;
                border: 1px solid rgba(0, 0, 0, 0.1);
            }

            header {
                flex: 1.2;
                height: 100% !important;
                background-attachment: scroll;
            }

            .content-wrapper {
                flex: 1;
                height: 100%;
                overflow-y: auto;
                background: #fdfaf6;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .content-wrapper::-webkit-scrollbar {
                display: none;
            }
        }

        body {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        body::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-200 flex justify-center font-sans font-light tracking-wide">

    <div class="w-full max-w-[420px] min-h-screen bg-[#fdfaf6] relative overflow-hidden shadow-2xl">

        <!-- Hero Section -->
        <header class="relative h-screen flex items-center justify-center text-center">
            <div id="preview-hero-bg" class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ storage_url($invitation->gallery_cover) }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/40 to-black/70"></div>
            <div class="relative z-10 text-white px-6 space-y-5">
                <p class="text-xs tracking-[0.3rem] uppercase font-sans font-light">The Wedding Of</p>
                <h1 class="font-serif text-5xl md:text-6xl font-medium italic leading-tight">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h1>
                <p class="text-sm mt-4 tracking-wider font-light">Kepada Yth: {{ request('penerima') ?? 'Tamu Undangan' }}</p>
                <div class="mt-6 border-y border-white/30 py-3 inline-block px-8">
                    <p class="text-xl font-serif italic">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('d F Y') }}</p>
                </div>
                <div>
                    <button onclick="document.getElementById('mempelai').scrollIntoView({behavior:'smooth'})" class="mt-8 bg-primary/90 text-white px-10 py-3 rounded-sm text-xs font-sans font-medium tracking-[0.2rem] uppercase hover:bg-primary transition">Buka Undangan</button>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            <!-- Quote -->
            <section class="py-20 px-8 text-center bg-white border-b">
                <div class="fade-in max-w-lg mx-auto">
                    <i class="ti ti-quote text-5xl text-primary/20"></i>
                    <p class="italic text-gray-700 leading-loose mt-6 text-xl font-serif">"{{ $invitation->wedding_quote ?? 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri...' }}"</p>
                    <div class="mt-8 flex items-center justify-center gap-4">
                        <span class="h-px w-8 bg-primary/40"></span>
                        <p class="font-serif text-primary font-semibold text-sm tracking-[0.2rem] uppercase">{{ $invitation->quote_id ?? 'QS. Ar-Rum: 21' }}</p>
                        <span class="h-px w-8 bg-primary/40"></span>
                    </div>
                </div>
            </section>

            <!-- Mempelai -->
            <section id="mempelai" class="py-24 px-6 text-center space-y-16">
                <div class="fade-in">
                    <h2 class="text-6xl text-primary">Mempelai</h2>
                    <p class="text-xs text-gray-500 uppercase tracking-[0.3rem] mt-3 font-sans">The Happy Couple</p>
                </div>

                <div class="space-y-16">
                    <!-- Groom -->
                    <div class="fade-in">
                        <div class="relative inline-block">
                            <img loading="lazy" id="preview-foto-pria" src="{{ storage_url($invitation->foto_pria) }}" alt="Groom" class="w-56 h-72 object-cover rounded-full border-8 border-white shadow-2xl">
                            <div class="absolute -bottom-4 -right-4 bg-primary text-white p-3 rounded-full shadow-lg"><i class="ti ti-men text-xl"></i></div>
                        </div>
                        <h3 class="text-4xl font-serif mt-8 text-gray-800 italic font-medium">{{ $invitation->groom_name }}</h3>
                        <p class="text-sm text-gray-600 mt-3 font-serif uppercase tracking-widest">
                            {{ $invitation->groom_child_order_text ? 'Putra ' . $invitation->groom_child_order_text . ' dari' : 'Putra dari' }}<br>
                            Bpk. {{ $invitation->groom_father_name }} & Ibu {{ $invitation->groom_mother_name }}
                        </p>
                        <a href="https://instagram.com/{{ $invitation->groom_username_instagram }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-primary font-medium text-xs tracking-wider">
                            <i class="ti ti-brand-instagram"></i> {{ $invitation->groom_username_instagram }}
                        </a>
                    </div>

                    <div class="text-6xl font-cursive text-primary/40 fade-in">&</div>

                    <!-- Bride -->
                    <div class="fade-in">
                        <div class="relative inline-block">
                            <img loading="lazy" id="preview-foto-wanita" src="{{ storage_url($invitation->foto_wanita) }}" alt="Bride" class="w-56 h-72 object-cover rounded-full border-8 border-white shadow-2xl">
                            <div class="absolute -bottom-4 -left-4 bg-primary text-white p-3 rounded-full shadow-lg"><i class="ti ti-woman text-xl"></i></div>
                        </div>
                        <h3 class="text-4xl font-serif mt-8 text-gray-800 italic font-medium">{{ $invitation->bride_name }}</h3>
                        <p class="text-sm text-gray-600 mt-3 font-serif uppercase tracking-widest">
                            {{ $invitation->bride_child_order_text ? 'Putri ' . $invitation->bride_child_order_text . ' dari' : 'Putri dari' }}<br>
                            Bpk. {{ $invitation->bride_father_name }} & Ibu {{ $invitation->bride_mother_name }}
                        </p>
                        <a href="https://instagram.com/{{ $invitation->bride_username_instagram}}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-primary font-medium text-xs tracking-wider">
                            <i class="ti ti-brand-instagram"></i>{{ $invitation->bride_username_instagram}}
                        </a>
                    </div>
                </div>
            </section>

            <!-- Waktu & Tempat -->
            <section class="py-24 px-6 bg-[#f7f3ed] text-center space-y-12">
                <div class="fade-in">
                    <h2 class="text-6xl text-primary">Save The Date</h2>
                    <div class="w-16 h-px bg-primary/30 mx-auto mt-4"></div>
                </div>

                <div class="space-y-8 fade-in">
                    <!-- Akad -->
                    <div class="bg-white p-10 rounded-md shadow-sm border border-primary/10">
                        <h3 class="font-serif text-2xl text-primary italic font-medium">Akad Nikah</h3>
                        <div class="my-5 text-5xl font-serif font-medium text-gray-800">{{ $invitation->akad_time }}</div>
                        <div class="space-y-1 text-gray-600 italic">
                            <p class="font-serif text-lg">{{ $invitation->akad_location }}</p>
                            <p class="text-sm px-4 font-sans font-light tracking-wide">{{ $invitation->akad_address }}</p>
                        </div>
                        <a href="{{ $invitation->akad_maps }}" target="_blank" class="inline-block mt-6 bg-primary text-white px-8 py-2 rounded-full text-xs font-sans font-medium uppercase tracking-[0.2rem] shadow-md">Buka Lokasi</a>
                    </div>

                    <!-- Resepsi -->
                    <div class="bg-white p-10 rounded-md shadow-sm border border-primary/10">
                        <h3 class="font-serif text-2xl text-primary italic font-medium">Resepsi Pernikahan</h3>
                        <div class="my-5 text-5xl font-serif font-medium text-gray-800">{{ $invitation->resepsi_time }}</div>
                        <div class="space-y-1 text-gray-600 italic">
                            <p class="font-serif text-lg">{{ $invitation->resepsi_location }}</p>
                            <p class="text-sm px-4 font-sans font-light tracking-wide">{{ $invitation->resepsi_address }}</p>
                        </div>
                        <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="inline-block mt-6 bg-primary text-white px-8 py-2 rounded-full text-xs font-sans font-medium uppercase tracking-[0.2rem] shadow-md">Buka Lokasi</a>
                    </div>
                </div>
            </section>

            <!-- Countdown -->
            <section class="py-20 px-6 bg-primary text-white text-center">
                <div class="fade-in">
                    <p class="font-serif italic text-2xl opacity-80">Menghitung Hari Bahagia</p>
                    <div class="flex justify-center gap-8 mt-8" id="countdown">
                        <div class="text-center">
                            <div id="days" class="text-5xl font-serif font-medium">00</div>
                            <div class="text-[10px] uppercase tracking-[0.2rem] opacity-70 mt-1 font-sans">Hari</div>
                        </div>
                        <div class="text-center">
                            <div id="hours" class="text-5xl font-serif font-medium">00</div>
                            <div class="text-[10px] uppercase tracking-[0.2rem] opacity-70 mt-1 font-sans">Jam</div>
                        </div>
                        <div class="text-center">
                            <div id="minutes" class="text-5xl font-serif font-medium">00</div>
                            <div class="text-[10px] uppercase tracking-[0.2rem] opacity-70 mt-1 font-sans">Menit</div>
                        </div>
                        <div class="text-center">
                            <div id="seconds" class="text-5xl font-serif font-medium">00</div>
                            <div class="text-[10px] uppercase tracking-[0.2rem] opacity-70 mt-1 font-sans">Detik</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Love Story -->
            @if(($invitation->enable_love_story ?? true) && !empty($invitation->love_story))
                @php
                    $loveStories = is_array($invitation->love_story) ? $invitation->love_story : json_decode($invitation->love_story, true);
                @endphp
                @if(!empty($loveStories[0]['title']) || !empty($loveStories[0]['story']))
                    <section class="py-24 px-6 text-center" id="love-story">
                        <h2 class="text-6xl text-primary">Love Story</h2>
                        <div class="w-16 h-px bg-primary/30 mx-auto mt-4 mb-12"></div>
                        <div class="max-w-md mx-auto space-y-12 text-left">
                            @foreach($loveStories as $index => $story)
                                <div class="relative pl-8 border-l-2 border-primary/20">
                                    <div class="absolute -left-[9px] top-0 w-4 h-4 bg-primary rounded-full"></div>
                                    <h3 class="text-2xl font-serif text-gray-800 font-medium">{{ $story['title'] ?? '' }}</h3>
                                    <p class="text-gray-600 leading-relaxed mt-2 font-sans font-light">{{ $story['story'] ?? '' }}</p>
                                    @if(!empty($story['photo']))
                                        <img src="{{ storage_url($story['photo']) }}" alt="{{ $story['title'] ?? 'Story Photo' }}" loading="lazy" class="mt-4 max-h-[200px] object-cover rounded-md">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endif

            <!-- Video -->
            @if(($invitation->enable_video ?? true) && !empty($invitation->video_link))
                @php
                    preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->video_link, $ytVideoMatches);
                    $youtubeVideoId = $ytVideoMatches['id'] ?? '';
                @endphp
                @if($youtubeVideoId)
                    <section class="py-24 px-6 text-center bg-white" id="video">
                        <h2 class="text-6xl text-primary">Video Pernikahan</h2>
                        <div class="w-16 h-px bg-primary/30 mx-auto mt-4 mb-12"></div>
                        <div class="max-w-2xl mx-auto">
                            <div class="relative aspect-video rounded-md overflow-hidden bg-black/10 cursor-pointer" data-fancybox="video" data-src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeVideoId }}&controls=1&modestbranding=1&rel=0">
                                <img src="https://img.youtube.com/vi/{{ $youtubeVideoId }}/hqdefault.jpg" alt="Video Pernikahan" class="w-full h-full object-cover">
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                                    <i class="ti ti-player-play-filled text-white text-5xl p-5 bg-white/20 backdrop-blur-sm rounded-full"></i>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <section class="py-24 px-6 text-center bg-white" id="video">
                        <h2 class="text-6xl text-primary">Video Pernikahan</h2>
                        <div class="w-16 h-px bg-primary/30 mx-auto mt-4 mb-12"></div>
                        <div class="max-w-2xl mx-auto">
                            <video controls class="w-full rounded-md">
                                <source src="{{ storage_url($invitation->video_link) }}" type="video/mp4">
                            </video>
                        </div>
                    </section>
                @endif
            @endif

            <!-- Galeri -->
            @if(($invitation->enable_gallery ?? true) && $invitation->galleries->count())
                <section class="py-24 px-6 text-center space-y-10 bg-[#fdfaf6]">
                    <h2 class="text-6xl text-primary">Galeri Momen</h2>
                    <div class="w-16 h-px bg-primary/30 mx-auto mt-4 mb-10"></div>
                    <div class="masonry-gallery fade-in" id="gallery-container">
                        @foreach($invitation->galleries as $photo)
                            <a href="{{ storage_url($photo->image) }}" data-fancybox="gallery" class="masonry-item rounded-md overflow-hidden shadow-lg border-4 border-white">
                                <img loading="lazy" src="{{ storage_url($photo->image) }}" alt="Gallery" class="w-full object-cover">
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Gift -->
            @if($invitation->enable_gift == 1 && $invitation->gifts->count())
                <section class="py-24 px-6 text-center space-y-10 bg-[#f7f3ed]">
                    <h2 class="text-6xl text-primary">Wedding Gift</h2>
                    <div class="w-16 h-px bg-primary/30 mx-auto mt-4 mb-10"></div>
                    <div class="space-y-6 max-w-sm mx-auto">
                        @foreach($invitation->gifts as $gift)
                            <div class="bg-white p-8 rounded-md shadow-sm border border-primary/10 fade-in">
                                <h3 class="font-serif text-2xl text-primary italic font-medium">{{ $gift->bank }}</h3>
                                <div class="my-4 text-3xl font-serif font-medium text-gray-800 tracking-wider">{{ $gift->number }}</div>
                                <p class="text-sm text-gray-600 italic font-sans font-light">A/N: {{ $gift->name }}</p>
                                <button onclick="copyToClipboard('{{ $gift->number }}')" class="inline-block mt-6 bg-primary text-white px-8 py-2 rounded-full text-xs font-sans font-medium uppercase tracking-[0.2rem] shadow-md">Salin</button>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- RSVP -->
            @if($invitation->enable_rsvp == 1)
                <section class="py-24 px-8 bg-white space-y-10">
                    <div class="text-center">
                        <h2 class="text-6xl text-primary">Doa & Ucapan</h2>
                        <div class="w-16 h-px bg-primary/30 mx-auto mt-4 mb-10"></div>
                    </div>

                    <form id="rsvpForm" class="space-y-4 max-w-md mx-auto">
                        @csrf
                        <input type="text" name="name" class="w-full p-4 bg-gray-50 border-none rounded-sm focus:ring-2 focus:ring-primary/20 transition font-sans font-light tracking-wide" placeholder="Nama Anda" required>
                        <select name="attending" class="w-full p-4 bg-gray-50 border-none rounded-sm focus:ring-2 focus:ring-primary/20 transition font-sans font-light tracking-wide">
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

                        <textarea name="message" class="w-full p-4 bg-gray-50 border-none rounded-sm focus:ring-2 focus:ring-primary/20 transition font-sans font-light tracking-wide" rows="4" placeholder="Tulis doa atau ucapan manis untuk kedua mempelai..." required></textarea>
                        <button type="submit" id="rsvpButton" class="w-full bg-primary text-white py-4 rounded-sm font-sans font-medium tracking-[0.2rem] uppercase text-sm shadow-md hover:bg-primary/90 transition">Kirim Ucapan</button>
                    </form>

                    <div id="rsvpList" class="space-y-4 max-h-[400px] overflow-y-auto pt-4 scrollbar-hide max-w-md mx-auto"></div>
                </section>
            @endif

            <!-- Footer -->
            <footer class="py-20 bg-gray-900 text-white text-center">
                <h2 class="text-6xl text-primary">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h2>
                <div class="mt-12 flex justify-center gap-4 opacity-40">
                    <i class="ti ti-heart"></i>
                    <i class="ti ti-heart-filled text-primary"></i>
                    <i class="ti ti-heart"></i>
                </div>
                <p class="mt-8 text-sm opacity-60 leading-loose px-10 font-sans font-light tracking-wide">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.</p>
                <p class="text-[10px] mt-10 opacity-30 tracking-[0.3rem] uppercase font-sans">Wedding Invitation &copy; {{ date('Y') }}</p>
            </footer>
        </div>
    </div>

    <!-- Audio -->
    <x-music-player :invitation="$invitation" />

    <script>
        // Init Fancybox
        $('[data-fancybox]').fancybox({
            buttons: ["close"],
            wheel: false,
            transitionEffect: "slide",
        });

        // Scroll Animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // Countdown
        const weddingDate = new Date("{{ $invitation->wedding_date }}").getTime();
        const countdownTimer = setInterval(() => {
            const now = new Date().getTime();
            const distance = weddingDate - now;
            if (distance < 0) {
                clearInterval(countdownTimer);
                return;
            }
            document.getElementById("days").innerText = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            document.getElementById("hours").innerText = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            document.getElementById("minutes").innerText = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            document.getElementById("seconds").innerText = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }, 1000);

        // RSVP Logic
        const invId = "{{ $invitation->id }}";

        function loadRSVPs() {
            fetch(`/invitation/${invId}/rsvps`).then(res => res.json()).then(data => {
                document.getElementById('rsvpList').innerHTML = data.map(r => `
                    <div class="p-5 bg-gray-50 rounded-md border-l-2 border-primary shadow-sm">
                        <div class="flex justify-between items-start">
                            <p class="font-serif font-medium text-gray-800 text-2xl">${r.name}</p>
                            <span class="text-[10px] bg-white text-primary px-3 py-1 rounded-full border border-primary/20 font-sans font-medium uppercase tracking-[0.2rem] italic">${r.attending ? 'Hadir' : 'Absen'}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2 italic leading-relaxed font-sans font-light">"${r.message}"</p>
                    </div>
                `).join('');
            });
        }

        document.getElementById('rsvpForm').onsubmit = (e) => {
            e.preventDefault();
            const btn = document.getElementById('rsvpButton');
            btn.disabled = true;
            btn.innerText = 'Mengirim...';
            fetch(`/invitation/${invId}/rsvp`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
            }).then(() => {
                e.target.reset();
                loadRSVPs();
            }).finally(() => {
                btn.disabled = false;
                btn.innerText = 'Kirim Ucapan';
            });
        };

        loadRSVPs();

        // Live Preview Sync
        window.addEventListener('message', function(event) {
            if (event.data.type === 'syncImages') {
                const imgs = event.data.images;
                if (imgs.pria) {
                    const el = document.getElementById('preview-foto-pria');
                    if (el) el.src = imgs.pria;
                }
                if (imgs.wanita) {
                    const el = document.getElementById('preview-foto-wanita');
                    if (el) el.src = imgs.wanita;
                }
                if (imgs.cover) {
                    const el = document.getElementById('preview-hero-bg');
                    if (el) el.style.backgroundImage = `url('${imgs.cover}')`;
                }
                if (imgs.gallery && imgs.gallery.length > 0) {
                    const galleryContainer = document.getElementById('gallery-container');
                    if (galleryContainer) {
                        galleryContainer.innerHTML = imgs.gallery.map(src => `
                            <a href="${src}" data-fancybox="gallery" class="masonry-item rounded-md overflow-hidden shadow-lg border-4 border-white">
                                <img loading="lazy" src="${src}" alt="Gallery" class="w-full object-cover">
                            </a>
                        `).join('');
                    }
                }
            }
        });

        function addEmoji(emoji) {
            const textarea = document.querySelector('textarea[name="message"]');
            textarea.value += emoji;
            textarea.focus();
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Nomor rekening disalin!');
            });
        }
    </script>
</body>

</html>