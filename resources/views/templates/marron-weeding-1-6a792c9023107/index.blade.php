<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title ?? 'Undangan Pernikahan' }}</title>

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $invitation->title ?? 'Undangan Pernikahan' }}">
    <meta property="og:description" content="{{ $invitation->description ?? '' }}">
    <meta property="og:image" content="{{ storage_url($invitation->gallery_cover, $invitation->updated_at->timestamp) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $invitation->title ?? 'Undangan Pernikahan' }}">
    <meta name="twitter:description" content="{{ $invitation->description ?? '' }}">
    <meta name="twitter:image" content="{{ storage_url($invitation->gallery_cover, $invitation->updated_at->timestamp) }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;600&display=swap" rel="stylesheet">

    <!-- CDN Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons-web@2.23.0/iconfont/tabler-icons.min.js"></script>

    <style>
        :root {
            --primary-color: #800000;            /* maroon */
            --accent-color: #C6A962;            /* gold */
            --secondary-color: #F5F5F5;         /* light neutral */
            --text-dark: #2C2C2C;
            --text-muted: #666666;
            --bg-color: #FAF9F6;
            --white: #FFFFFF;
            --border-color: rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
            --font-serif: 'Playfair Display', serif;
            --font-sans: 'Lato', sans-serif;
        }

        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family: var(--font-sans);
            background: var(--bg-color);
            color: var(--text-dark);
            line-height:1.6;
        }
        a{color:var(--accent-color);text-decoration:none;transition:var(--transition);}
        a:hover{color:var(--primary-color);}
        .section-padding{padding:2rem 1rem;}
        .container{max-width:414px;margin:0 auto;}
        .hero{
            position:relative;
            height:100vh;
            background:url('{{ storage_url($invitation->gallery_cover, $invitation->updated_at->timestamp) }}') center/cover no-repeat;
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            color:var(--white);
        }
        .hero::before{
            content:"";
            position:absolute;
            inset:0;
            background:rgba(128,0,0,0.85);
            background-image:url('data:image/svg+xml;charset=UTF-8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2210%22 height=%2210%22><path d=%22M0 0L10 10M10 0L0 10%22 stroke=%22%23C6A962%22 stroke-width=%222%22/></svg>');
            background-size:20px 20px;
        }
        .hero-content{
            position:relative;
            z-index:2;
        }
        .hero h1{
            font-family:var(--font-serif);
            font-size:2.5rem;
            color:var(--accent-color);
            margin-bottom:0.5rem;
        }
        .hero p{
            font-size:1rem;
            color:var(--white);
        }
        .btn{
            display:inline-block;
            padding:0.75rem 1.5rem;
            border:2px solid var(--accent-color);
            color:var(--accent-color);
            background:transparent;
            border-radius:4px;
            font-weight:600;
            transition:var(--transition);
            cursor:pointer;
        }
        .btn:hover{
            background:var(--accent-color);
            color:var(--white);
        }
        .fade-in{opacity:0;transform:translateY(20px);transition:var(--transition);}
        .visible{opacity:1;transform:none;}
        .quote{
            background:var(--primary-color);
            color:var(--white);
            text-align:center;
            font-style:italic;
        }
        .quote p{font-size:1.2rem;padding:1rem;}
        .mempelai{
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:1rem;
        }
        .mempelai img{width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid var(--accent-color);}
        .mempelai h2{
            font-family:var(--font-serif);
            color:var(--primary-color);
            font-size:1.5rem;
        }
        .mempelai .parents{font-size:0.9rem;color:var(--text-muted);}
        .event{
            display:grid;
            gap:1rem;
        }
        .event-card{
            background:var(--secondary-color);
            border-left:4px solid var(--accent-color);
            padding:1rem;
            border-radius:4px;
        }
        .event-card h3{
            font-family:var(--font-serif);
            color:var(--primary-color);
            margin-bottom:0.5rem;
        }
        .countdown{
            text-align:center;
            background:var(--primary-color);
            color:var(--white);
            padding:2rem 0;
        }
        .countdown h2{font-family:var(--font-serif);margin-bottom:1rem;}
        .countdown .time{display:flex;justify-content:center;gap:1rem;font-size:1.2rem;}
        .gallery{
            column-count:2;
            column-gap:0.5rem;
        }
        .gallery img{
            width:100%;
            margin-bottom:0.5rem;
            border-radius:4px;
            transition:var(--transition);
        }
        .gallery img:hover{transform:scale(1.03);}
        .gift-card{
            background:var(--secondary-color);
            border:1px solid var(--border-color);
            padding:1rem;
            border-radius:4px;
            margin-bottom:1rem;
        }
        .rsvp-form{
            background:var(--secondary-color);
            padding:1.5rem;
            border-radius:4px;
            border:2px solid var(--accent-color);
        }
        .rsvp-form input,
        .rsvp-form textarea{
            width:100%;
            padding:0.5rem;
            margin-top:0.5rem;
            border:1px solid var(--border-color);
            border-radius:4px;
            font-family:var(--font-sans);
        }
        .footer{
            text-align:center;
            font-size:0.8rem;
            color:var(--text-muted);
            padding:1rem 0;
        }
        /* A5 Print Layout */
        @media print{
            body{background:var(--white);}
            .hero{height:auto;min-height:210mm;max-height:210mm;page-break-after:always;}
            .inner-page{page-break-after:always;}
        }
    </style>
</head>
<body>

    <!-- Hero / Sampul Depan -->
    <section class="hero fade-in" id="hero">
        <div class="hero-content">
            <h1 class="serif-font">{{ $invitation->nama_pria }} &amp; {{ $invitation->nama_wanita }}</h1>
            <p class="hero-subtitle">Together Forever</p>
            <a href="#open-invitation" class="btn btn-outline">Buka Undangan</a>
        </div>
    </section>

    <!-- Quote / Doa -->
    <section class="quote section-padding fade-in" id="quote">
        <p>"{{ $invitation->wedding_quote ?? 'Semoga pernikahan ini menjadi berkah bagi kita semua.' }}"</p>
    </section>

    <!-- Mempelai -->
    <section class="mempelai section-padding fade-in" id="mempelai">
        <div class="container">
            <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                <div class="text-center">
                    <img src="{{ storage_url($invitation->foto_pria) }}" alt="Foto Pria">
                    <h2 class="serif-font">{{ $invitation->nama_pria }}</h2>
                    <p class="parents">{{ $invitation->ortu_pria ?? '' }}</p>
                </div>
                <div class="text-center">
                    <img src="{{ storage_url($invitation->foto_wanita) }}" alt="Foto Wanita">
                    <h2 class="serif-font">{{ $invitation->nama_wanita }}</h2>
                    <p class="parents">{{ $invitation->ortu_wanita ?? '' }}</p>
                </div>
            </div>
            @if(isset($invitation->instagram_pria) || isset($invitation->instagram_wanita))
            <div class="flex justify-center gap-4 mt-4">
                @if(isset($invitation->instagram_pria))
                <a href="https://instagram.com/{{ $invitation->instagram_pria }}" target="_blank" class="icon ti ti-brand-instagram" style="color:var(--accent-color);font-size:1.5rem;"></a>
                @endif
                @if(isset($invitation->instagram_wanita))
                <a href="https://instagram.com/{{ $invitation->instagram_wanita }}" target="_blank" class="icon ti ti-brand-instagram" style="color:var(--accent-color);font-size:1.5rem;"></a>
                @endif
            </div>
            @endif
        </div>
    </section>

    <!-- Event -->
    <section class="event section-padding fade-in" id="event">
        <div class="container">
            <div class="event-card">
                <h3><i class="ti ti-calendar-event" style="color:var(--accent-color);"></i> Akad Nikah</h3>
                <p><strong>Hari & Tanggal:</strong> {{ \Carbon\Carbon::parse($invitation->tanggal_akad)->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($invitation->waktu_akad)->format('H:i') }} WIB</p>
                <p><strong>Lokasi:</strong> {{ $invitation->lokasi_akad }}</p>
            </div>
            <div class="event-card">
                <h3><i class="ti ti-restaurant" style="color:var(--accent-color);"></i> Resepsi</h3>
                <p><strong>Hari & Tanggal:</strong> {{ \Carbon\Carbon::parse($invitation->tanggal_resepsi)->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($invitation->waktu_resepsi)->format('H:i') }} WIB</p>
                <p><strong>Lokasi:</strong> {{ $invitation->lokasi_resepsi }}</p>
                @if(isset($invitation->maps_link))
                <a href="{{ $invitation->maps_link }}" target="_blank" class="btn btn-outline mt-2">Lihat Peta</a>
                @endif
            </div>
        </div>
    </section>

    <!-- Countdown -->
    <section class="countdown fade-in" id="countdown">
        <h2 class="serif-font">Menunggu Hari Bahagia</h2>
        <div class="time" id="timer">
            <div><span id="days">00</span><br>Hari</div>
            <div><span id="hours">00</span><br>Jam</div>
            <div><span id="minutes">00</span><br>Menit</div>
            <div><span id="seconds">00</span><br>Detik</div>
        </div>
    </section>

    <!-- Gallery -->
    @if($invitation->galleries->count())
    <section class="gallery section-padding fade-in" id="gallery">
        <div class="container masonry-gallery">
            @if(($invitation->enable_gallery ?? true) && $invitation->galleries->count())@foreach($invitation->galleries as $photo)
                <a href="{{ storage_url($photo->image) }}" data-fancybox="gallery">
                    <img src="{{ storage_url($photo->image) }}" alt="Gallery Image" class="masonry-item">
                </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Gift / Amplop -->
    @if(isset($invitation->enable_gift) && $invitation->enable_gift && $invitation->gifts->count())
    <section class="section-padding fade-in" id="gift">
        <div class="container">
            <h2 class="serif-font text-center mb-4">Amplop Digital</h2>
            @foreach($invitation->gifts as $gift)
            <div class="gift-card">
                <p><strong>Bank:</strong> {{ $gift->bank }}</p>
                <p><strong>No. Rekening:</strong> {{ $gift->number }}</p>
                <p><strong>Atas Nama:</strong> {{ $gift->name }}</p>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- RSVP -->
    @if(isset($invitation->enable_rsvp) && $invitation->enable_rsvp)
    <section class="section-padding fade-in" id="rsvp">
        <div class="container">
            <h2 class="serif-font text-center mb-4">RSVP</h2>
            <form action="" method="POST" class="rsvp-form">
                @csrf
                <label>Nama Tamu</label>
                <input type="text" name="nama" required>
                <label>Jumlah Kehadiran</label>
                <input type="number" name="jumlah" min="1" required>
                <label>Kontak (WhatsApp)</label>
                <input type="tel" name="kontak" required>
                <button type="submit" class="btn mt-3">Kirim</button>
            </form>
        </div>
    </section>
    @endif

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} {{ $invitation->title ?? 'Undangan Pernikahan' }}. All rights reserved.</p>
    </footer>

    <!-- Music Player -->
    @if(isset($invitation->music_url) && $invitation->music_url)
    <audio id="bg-music" src="{{ $invitation->music_url }}" loop autoplay></audio>
    <button id="music-toggle" class="btn btn-outline" style="position:fixed;bottom:20px;right:20px;">Music</button>
    @endif

    <script>
        // Intersection Observer for scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        },{threshold:0.1});
        document.querySelectorAll('.fade-in').forEach(el=>observer.observe(el));

        // Countdown Timer
        const eventDate = new Date('{{ $invitation->tanggal_akad ?? $invitation->tanggal_resepsi }}').getTime();
        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = eventDate - now;
            if(distance < 0){
                clearInterval(timer);
                document.getElementById('timer').innerHTML = 'Acara Telah Dimulai';
                return;
            }
            const days = Math.floor(distance/(1000*60*60*24));
            const hours = Math.floor((distance%(1000*60*60*24))/(1000*60*60));
            const minutes = Math.floor((distance%(1000*60*60))/(1000*60));
            const seconds = Math.floor((distance%(1000*60))/1000);
            document.getElementById('days').innerText = days.toString().padStart(2,'0');
            document.getElementById('hours').innerText = hours.toString().padStart(2,'0');
            document.getElementById('minutes').innerText = minutes.toString().padStart(2,'0');
            document.getElementById('seconds').innerText = seconds.toString().padStart(2,'0');
        },1000);

        // Auto play background music
        const bgMusic = document.getElementById('bg-music');
        const musicBtn = document.getElementById('music-toggle');
        if (bgMusic && musicBtn) {
            bgMusic.play().then(() => {
                musicBtn.textContent = 'Pause Music';
            }).catch(() => {
                const playOnInteraction = () => {
                    bgMusic.play();
                    musicBtn.textContent = 'Pause Music';
                    document.removeEventListener('click', playOnInteraction);
                    document.removeEventListener('touchstart', playOnInteraction);
                };
                document.addEventListener('click', playOnInteraction, { once: true });
                document.addEventListener('touchstart', playOnInteraction, { once: true });
            });
        }

        // Music Player Toggle
        if(musicBtn && bgMusic){
            musicBtn.addEventListener('click',()=> {
                if(bgMusic.paused){
                    bgMusic.play();
                    musicBtn.textContent = 'Pause Music';
                } else {
                    bgMusic.pause();
                    musicBtn.textContent = 'Play Music';
                }
            });
        }
    </script>

    @if(($invitation->enable_love_story ?? true) && !empty($invitation->love_story))
    @php
        $loveStories = is_array($invitation->love_story) ? $invitation->love_story : json_decode($invitation->love_story, true);
    @endphp
    @if(!empty($loveStories[0]['title']) || !empty($loveStories[0]['story']))
    <section class="py-16 px-6 text-center fade-in" id="love-story">
        <h2 class="text-4xl font-serif text-primary italic mb-4">Love Story</h2>
        <div class="max-w-2xl mx-auto space-y-8">
            @foreach($loveStories as $index => $story)
            <div class="{{ $index < count($loveStories) - 1 ? 'pb-8 border-b border-gray-200' : '' }}">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $story['title'] ?? '' }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $story['story'] ?? '' }}</p>
                @if(!empty($story['photo']))
                <img src="{{ storage_url($story['photo']) }}" alt="{{ $story['title'] ?? 'Story Photo' }}" loading="lazy" class="mt-3 max-h-[200px] object-cover rounded-lg mx-auto">
                @endif
            </div>
            @endforeach
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
    <section class="py-16 px-6 text-center fade-in" id="video">
        <h2 class="text-4xl font-serif text-primary italic mb-4">Video Pernikahan</h2>
        <div class="max-w-2xl mx-auto">
            <div class="relative aspect-video rounded-xl overflow-hidden bg-black/10 cursor-pointer" data-fancybox="video" data-src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeVideoId }}&controls=1&modestbranding=1&rel=0">
                <img src="https://img.youtube.com/vi/{{ $youtubeVideoId }}/hqdefault.jpg" alt="Video Pernikahan" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center justify-center bg-primary/30">
                    <span class="material-symbols-outlined text-white text-5xl">play_circle</span>
                </div>
            </div>
        </div>
    </section>
    @else
    <section class="py-16 px-6 text-center fade-in" id="video">
        <h2 class="text-4xl font-serif text-primary italic mb-4">Video Pernikahan</h2>
        <div class="max-w-2xl mx-auto">
            <video controls class="w-full rounded-xl">
                <source src="{{ storage_url($invitation->video_link) }}" type="video/mp4">
            </video>
        </div>
    </section>
    @endif
    @endif
</script>

</body>

</html>

