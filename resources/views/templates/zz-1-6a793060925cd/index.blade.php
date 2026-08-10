<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->groom_name ?? 'Mempelai Pria' }} &amp; {{ $invitation->bride_name ?? 'Mempelai Wanita' }}</title>

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $invitation->groom_name ?? 'Mempelai Pria' }} &amp; {{ $invitation->bride_name ?? 'Mempelai Wanita' }}">
    <meta property="og:description" content="Undangan Pernikahan">
    <meta property="og:image" content="{{ asset('storage/' . ($invitation->gallery_cover ?? 'default/cover.jpg')) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $invitation->groom_name ?? 'Mempelai Pria' }} &amp; {{ $invitation->bride_name ?? 'Mempelai Wanita' }}">
    <meta name="twitter:description" content="Undangan Pernikahan">
    <meta name="twitter:image" content="{{ asset('storage/' . ($invitation->gallery_cover ?? 'default/cover.jpg')) }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;600&display=swap" rel="stylesheet">

    <!-- CDN Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tabler-icons@1.39.1/iconfont/tabler-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1B2A4A;
            --accent-color: #C6A962;
            --secondary-color: #2E8B57; /* emerald */
            --text-dark: #2C2C2C;
            --text-muted: #666666;
            --bg-color: #FAF9F6;
            --white: #FFFFFF;
            --border-color: rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family:'Lato',sans-serif;
            background:var(--bg-color);
            color:var(--text-dark);
            line-height:1.6;
        }
        a{color:var(--secondary-color);text-decoration:none;transition:var(--transition);}
        a:hover{color:var(--accent-color);}
        .container{max-width:414px;margin:auto;padding:0 1rem;}
        @media(min-width:1024px){
            .container{max-width:1024px;display:flex;flex-wrap:wrap;gap:2rem;}
        }
        .section-padding{padding:3rem 0;}
        .hero{
            position:relative;
            background-image:url('{{ asset('storage/' . ($invitation->gallery_cover ?? 'default/cover.jpg')) }}');
            background-size:cover;
            background-position:center;
            color:var(--white);
            text-align:center;
            padding:6rem 1rem;
        }
        .hero::after{
            content:"";
            position:absolute;
            inset:0;
            background:rgba(0,0,0,0.4);
        }
        .hero-content{
            position:relative;
            z-index:1;
        }
        .hero .serif-font{font-family:'Playfair Display',serif;}
        .hero .script-font{font-family:'Playfair Display',cursive;}
        .hero .btn-outline{
            border:2px solid var(--white);
            color:var(--white);
            padding:.75rem 1.5rem;
            margin-top:1.5rem;
            display:inline-block;
            transition:var(--transition);
        }
        .hero .btn-outline:hover{
            background:var(--accent-color);
            border-color:var(--accent-color);
        }
        .quote{font-style:italic;color:var(--secondary-color);text-align:center;margin:2rem 0;}
        .mempelai{display:flex;flex-direction:column;align-items:center;gap:2rem;}
        .mempelai .photo{width:150px;height:150px;border-radius:50%;overflow:hidden;border:4px solid var(--accent-color);}
        .mempelai .photo img{width:100%;height:100%;object-fit:cover;}
        .event{display:grid;gap:1.5rem;}
        .event-card{
            background:var(--white);
            border:1px solid var(--border-color);
            padding:1.5rem;
            border-radius:8px;
            transition:var(--transition);
        }
        .event-card:hover{box-shadow:0 4px 12px rgba(0,0,0,0.1);}
        .countdown{display:flex;justify-content:center;gap:1rem;font-size:1.2rem;color:var(--secondary-color);}
        .gallery{column-count:2;column-gap:1rem;}
        .masonry-item{break-inside:avoid;margin-bottom:1rem;}
        .gift-card{background:var(--white);border:1px solid var(--border-color);padding:1rem;border-radius:6px;margin-bottom:1rem;}
        .rsvp-form{background:var(--white);border:1px solid var(--border-color);padding:2rem;border-radius:8px;}
        .rsvp-form input,.rsvp-form textarea{
            width:100%;padding:.75rem;border:1px solid var(--border-color);border-radius:4px;margin-bottom:1rem;
        }
        .rsvp-form button{
            background:var(--secondary-color);color:var(--white);border:none;padding:.75rem 1.5rem;border-radius:4px;cursor:pointer;transition:var(--transition);
        }
        .rsvp-form button:hover{background:var(--accent-color);}
        .footer{text-align:center;padding:2rem 0;font-size:.9rem;color:var(--text-muted);}
        .fade-in{opacity:0;transform:translateY(20px);transition:var(--transition);}
        .visible{opacity:1;transform:none;}
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero fade-in" id="hero">
        <div class="hero-content container">
            <h1 class="serif-font" style="font-size:2.5rem;">
                {{ $invitation->groom_name ?? 'Mempelai Pria' }} &amp; {{ $invitation->bride_name ?? 'Mempelai Wanita' }}
            </h1>
            <p class="script-font" style="font-size:1.2rem;margin-top:.5rem;">
                {{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->isoFormat('D MMMM Y') }}
            </p>
            <a href="#detail" class="btn-outline">Buka Undangan</a>
        </div>
    </section>

    <!-- Quote / Doa -->
    @if(!empty($invitation->wedding_quote))
    <section class="quote fade-in" id="quote">
        <div class="container">
            <p>"{{ $invitation->wedding_quote }}"</p>
        </div>
    </section>
    @endif

    <!-- Mempelai Section -->
    <section class="mempelai section-padding fade-in" id="mempelai">
        <div class="container">
            <div class="photo">
                <img src="{{ asset('storage/' . ($invitation->foto_pria ?? 'default/groom.jpg')) }}" alt="Mempelai Pria">
            </div>
            <div class="photo">
                <img src="{{ asset('storage/' . ($invitation->foto_wanita ?? 'default/bride.jpg')) }}" alt="Mempelai Wanita">
            </div>
            <h2 class="serif-font" style="font-size:2rem;">
                {{ $invitation->groom_name ?? 'Mempelai Pria' }} &amp; {{ $invitation->bride_name ?? 'Mempelai Wanita' }}
            </h2>
            <p>
                <a href="https://instagram.com/{{ $invitation->groom_username_instagram ?? '' }}" target="_blank" class="ti ti-brand-instagram"></a>
                {{ $invitation->groom_instagram ?? '' }} &nbsp; | &nbsp;
                <a href="https://instagram.com/{{ $invitation->bride_username_instagram ?? '' }}" target="_blank" class="ti ti-brand-instagram"></a>
                {{ $invitation->bride_instagram ?? '' }}
            </p>
        </div>
    </section>

    <!-- Event Section -->
    <section class="event section-padding fade-in" id="event">
        <div class="container">
            <div class="event-card">
                <h3 class="serif-font">Akad Nikah</h3>
                <p><strong>Waktu:</strong> {{ $invitation->akad_time ?? '' }} - {{ $invitation->akad_time_end ?? '' }}</p>
                <p><strong>Tempat:</strong> {{ $invitation->akad_location ?? '' }}</p>
                <p><strong>Alamat:</strong> {{ $invitation->akad_address ?? '' }}</p>
                @if(!empty($invitation->akad_maps))
                <a href="{{ $invitation->akad_maps }}" target="_blank" class="ti ti-map-pin"></a>
                @endif
            </div>
            <div class="event-card">
                <h3 class="serif-font">Resepsi</h3>
                <p><strong>Waktu:</strong> {{ $invitation->resepsi_time ?? '' }} - {{ $invitation->resepsi_time_end ?? '' }}</p>
                <p><strong>Tempat:</strong> {{ $invitation->resepsi_location ?? '' }}</p>
                <p><strong>Alamat:</strong> {{ $invitation->resepsi_address ?? '' }}</p>
                @if(!empty($invitation->resepsi_maps))
                <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="ti ti-map-pin"></a>
                @endif
            </div>
        </div>
    </section>

    <!-- Countdown Section -->
    <section class="countdown section-padding fade-in" id="countdown">
        <div class="container">
            <div id="timer">
                <span id="days">00</span> Hari
                <span id="hours">00</span> Jam
                <span id="minutes">00</span> Menit
                <span id="seconds">00</span> Detik
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    @if($invitation->galleries->count())
    <section class="gallery section-padding fade-in" id="gallery">
        <div class="container">
            <div class="masonry-gallery">
                @foreach($invitation->galleries as $photo)
                <div class="masonry-item">
                    <a data-fancybox="gallery" href="{{ asset('storage/' . $photo->image) }}">
                        <img src="{{ asset('storage/' . $photo->image) }}" alt="Gallery Image" style="width:100%;border-radius:8px;">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Gift Section -->
    @if($invitation->enable_gift && $invitation->gifts->count())
    <section class="gift section-padding fade-in" id="gift">
        <div class="container">
            <h3 class="serif-font">Amplop Digital</h3>
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

    <!-- RSVP Section -->
    @if($invitation->enable_rsvp)
    <section class="rsvp section-padding fade-in" id="rsvp">
        <div class="container">
            <h3 class="serif-font">Konfirmasi Kehadiran</h3>
            <form action="{{ route('rsvp.store', $invitation->id) }}" method="POST" class="rsvp-form">
                @csrf
                <input type="text" name="name" placeholder="Nama Lengkap" required>
                <input type="number" name="attending" placeholder="Jumlah Kehadiran" min="1" required>
                <textarea name="message" rows="3" placeholder="Ucapan / Doa"></textarea>
                <button type="submit">Kirim</button>
            </form>
            <p style="margin-top:1rem;">
                <a href="{{ route('rsvp.list', $invitation->id) }}" class="ti ti-list"></a> Lihat Daftar Kehadiran
            </p>
        </div>
    </section>
    @endif

    <!-- Music Player -->
    @if(!empty($invitation->music_youtube_url))
    <section class="music section-padding fade-in" id="music">
        <div class="container" style="text-align:center;">
            <iframe width="100%" height="200" src="{{ $invitation->music_youtube_url }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </section>
    @endif

    <!-- Footer -->
    <footer class="footer fade-in" id="footer">
        <div class="container">
            <p>Terima kasih atas kehadiran dan doanya.</p>
            <p>&copy; {{ date('Y') }} {{ $invitation->groom_name ?? '' }} &amp; {{ $invitation->bride_name ?? '' }}</p>
        </div>
    </footer>

    <script>
        // Intersection Observer for fade-in
        const observer = new IntersectionObserver((entries)=> {
            entries.forEach(entry=>{
                if(entry.isIntersecting){
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        },{threshold:0.1});
        document.querySelectorAll('.fade-in').forEach(el=>observer.observe(el));

        // Countdown Timer
        const eventDate = new Date('{{ \Carbon\Carbon::parse($invitation->wedding_date)->format('Y-m-d') }}').getTime();
        const timer = setInterval(()=>{
            const now = new Date().getTime();
            const distance = eventDate - now;
            if(distance < 0){
                clearInterval(timer);
                document.getElementById('timer').innerHTML = "Acara Telah Dimulai";
                return;
            }
            const days = Math.floor(distance/(1000*60*60*24));
            const hours = Math.floor((distance%(1000*60*60*24))/(1000*60*60));
            const minutes = Math.floor((distance%(1000*60*60))/(1000*60));
            const seconds = Math.floor((distance% (1000*60))/1000);
            document.getElementById('days').innerText = days.toString().padStart(2,'0');
            document.getElementById('hours').innerText = hours.toString().padStart(2,'0');
            document.getElementById('minutes').innerText = minutes.toString().padStart(2,'0');
            document.getElementById('seconds').innerText = seconds.toString().padStart(2,'0');
        },1000);
    </script>
</body>
</html>