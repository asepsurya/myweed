<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title ?? 'Undangan Pernikahan' }}</title>
    <meta name="description" content="{{ $invitation->description ?? '' }}">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $invitation->title ?? '' }}">
    <meta property="og:description" content="{{ $invitation->description ?? '' }}">
    <meta property="og:image" content="{{ $invitation->og_image ? asset('storage/'.$invitation->og_image) : '' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $invitation->title ?? '' }}">
    <meta name="twitter:description" content="{{ $invitation->description ?? '' }}">
    <meta name="twitter:image" content="{{ $invitation->og_image ? asset('storage/'.$invitation->og_image) : '' }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;600&display=swap" rel="stylesheet">

    <!-- Fancybox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.umd.js"></script>

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <!-- jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        :root{
            --primary-color:#1B2A4A;
            --secondary-color:#C6A962;
            --accent-color:#A8E6CF; /* mint pastel */
            --text-dark:#2C2C2C;
            --text-muted:#666666;
            --bg-color:#F9FAFB;
            --white:#FFFFFF;
            --border-color:rgba(0,0,0,0.1);
            --transition:all 0.3s ease;
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family:'Lato',sans-serif;
            background:var(--bg-color);
            color:var(--text-dark);
            line-height:1.6;
        }
        a{color:var(--secondary-color);text-decoration:none;transition:var(--transition);}
        a:hover{color:var(--primary-color);}
        .container{width:90%;max-width:1200px;margin:auto;padding:20px;}
        .hero{
            background:url('{{ $invitation->hero_image ? asset('storage/'.$invitation->hero_image) : '' }}') center/cover no-repeat;
            color:var(--white);
            text-align:center;
            padding:120px 20px;
            position:relative;
        }
        .hero::after{
            content:"";
            position:absolute;
            inset:0;
            background:rgba(0,0,0,0.4);
        }
        .hero .content{
            position:relative;
            z-index:1;
        }
        .hero h1{
            font-family:'Playfair Display',serif;
            font-size:3rem;
            margin-bottom:10px;
        }
        .hero .date{
            font-size:1.2rem;
            margin-bottom:20px;
        }
        .hero .btn{
            display:inline-block;
            background:var(--secondary-color);
            color:var(--white);
            padding:12px 30px;
            border-radius:30px;
            font-weight:600;
            transition:var(--transition);
        }
        .hero .btn:hover{background:var(--primary-color);}
        .section{padding:60px 0;}
        .section-title{
            text-align:center;
            font-family:'Playfair Display',serif;
            font-size:2.2rem;
            margin-bottom:40px;
            color:var(--primary-color);
        }
        .quote{
            font-style:italic;
            text-align:center;
            font-size:1.2rem;
            color:var(--text-muted);
        }
        .mempelai{
            display:flex;
            flex-wrap:wrap;
            justify-content:center;
            gap:40px;
        }
        .mempelai .card{
            background:var(--white);
            border:1px solid var(--border-color);
            border-radius:12px;
            padding:20px;
            width:280px;
            text-align:center;
            box-shadow:0 4px 6px rgba(0,0,0,0.05);
        }
        .mempelai .card img{
            width:100%;
            height:auto;
            border-radius:8px;
            margin-bottom:15px;
        }
        .mempelai .name{font-size:1.5rem;font-weight:600;color:var(--primary-color);}
        .mempelai .parents{font-size:.9rem;color:var(--text-muted);}
        .event .grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
            gap:30px;
        }
        .event .card{
            background:var(--white);
            border:1px solid var(--border-color);
            border-radius:12px;
            padding:25px;
            text-align:center;
            box-shadow:0 4px 6px rgba(0,0,0,0.05);
        }
        .event .card h3{
            font-family:'Playfair Display',serif;
            color:var(--secondary-color);
            margin-bottom:10px;
        }
        .countdown{
            text-align:center;
            font-family:'Playfair Display',serif;
            color:var(--primary-color);
        }
        .countdown .time{
            display:flex;
            justify-content:center;
            gap:20px;
            font-size:1.5rem;
            margin-top:20px;
        }
        .countdown .time div{
            background:var(--white);
            padding:15px 20px;
            border-radius:8px;
            min-width:80px;
        }
        .masonry-gallery{
            column-count:1;
            column-gap:15px;
        }
        @media(min-width:600px){.masonry-gallery{column-count:2;}}
        @media(min-width:900px){.masonry-gallery{column-count:3;}}
        .masonry-item{
            break-inside:avoid;
            margin-bottom:15px;
            border-radius:8px;
            overflow:hidden;
        }
        .gift, .rsvp{
            background:var(--white);
            border:1px solid var(--border-color);
            border-radius:12px;
            padding:30px;
            text-align:center;
            box-shadow:0 4px 6px rgba(0,0,0,0.05);
        }
        .footer{
            text-align:center;
            font-size:.9rem;
            color:var(--text-muted);
            padding:20px 0;
        }
        .fade-in{opacity:0;transform:translateY(20px);transition:var(--transition);}
        .fade-in.visible{opacity:1;transform:none;}
        .pattern{
            position:absolute;
            width:150px;
            height:150px;
            background:linear-gradient(45deg,var(--accent-color)33%,transparent 33%);
            opacity:0.2;
            z-index:0;
        }
        .pattern.top-left{top:-30px;left:-30px;transform:rotate(45deg);}
        .pattern.bottom-right{bottom:-30px;right:-30px;transform:rotate(-45deg);}
        /* Music Player */
        .music-player{
            position:fixed;
            bottom:20px;
            right:20px;
            background:var(--white);
            border:1px solid var(--border-color);
            border-radius:30px;
            padding:10px 15px;
            display:flex;
            align-items:center;
            gap:10px;
            box-shadow:0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero fade-in">
        <div class="pattern top-left"></div>
        <div class="pattern bottom-right"></div>
        <div class="content container">
            <h1>{{ $invitation->bride_name ?? 'Nama Mempelai' }} &amp; {{ $invitation->groom_name ?? 'Nama Mempelai' }}</h1>
            <p class="date">{{ \Carbon\Carbon::parse($invitation->event_date)->locale('id')->isoFormat('D MMMM Y') }} | {{ $invitation->event_time ?? 'Waktu Acara' }}</p>
            <a href="#event" class="btn">Lihat Detail Acara</a>
        </div>
    </section>

    <!-- Quote / Doa -->
    @if(!empty($invitation->wedding_quote))
    <section class="section fade-in">
        <div class="container">
            <p class="quote">{{ $invitation->wedding_quote }}</p>
        </div>
    </section>
    @endif

    <!-- Mempelai Section -->
    <section class="section fade-in">
        <div class="container">
            <h2 class="section-title">Mempelai</h2>
            <div class="mempelai">
                <div class="card">
                    @if($invitation->bride_photo)
                    <img src="{{ asset('storage/'.$invitation->bride_photo) }}" alt="Foto {{ $invitation->bride_name }}">
                    @endif
                    <p class="name">{{ $invitation->bride_name ?? 'Nama Mempelai Wanita' }}</p>
                    <p class="parents">{{ $invitation->bride_child_order_text ? 'Putri ' . $invitation->bride_child_order_text . ' dari' : 'Putri dari' }} {{ $invitation->bride_father ?? 'Ayah' }} &amp; {{ $invitation->bride_mother ?? 'Ibu' }}</p>
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ $invitation->bride_instagram }}" target="_blank"><i class="ti ti-brand-instagram"></i> @{{ $invitation->bride_instagram }}</a>
                    @endif
                </div>
                <div class="card">
                    @if($invitation->groom_photo)
                    <img src="{{ asset('storage/'.$invitation->groom_photo) }}" alt="Foto {{ $invitation->groom_name }}">
                    @endif
                    <p class="name">{{ $invitation->groom_name ?? 'Nama Mempelai Pria' }}</p>
                    <p class="parents">{{ $invitation->groom_child_order_text ? 'Putra ' . $invitation->groom_child_order_text . ' dari' : 'Putra dari' }} {{ $invitation->groom_father ?? 'Ayah' }} &amp; {{ $invitation->groom_mother ?? 'Ibu' }}</p>
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ $invitation->groom_instagram }}" target="_blank"><i class="ti ti-brand-instagram"></i> @{{ $invitation->groom_instagram }}</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Event Section -->
    <section id="event" class="section fade-in">
        <div class="container">
            <h2 class="section-title">Acara</h2>
            <div class="event grid">
                <div class="card">
                    <h3>Akad Nikah</h3>
                    <p><i class="ti ti-calendar"></i> {{ \Carbon\Carbon::parse($invitation->akad_date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                    <p><i class="ti ti-clock"></i> {{ $invitation->akad_time ?? 'Waktu' }}</p>
                    <p><i class="ti ti-map-pin"></i> {{ $invitation->akad_location ?? 'Lokasi' }}</p>
                    @if($invitation->akad_map_link)
                    <a href="{{ $invitation->akad_map_link }}" target="_blank" class="btn">Lihat di Maps</a>
                    @endif
                </div>
                <div class="card">
                    <h3>Resepsi</h3>
                    <p><i class="ti ti-calendar"></i> {{ \Carbon\Carbon::parse($invitation->reception_date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                    <p><i class="ti ti-clock"></i> {{ $invitation->reception_time ?? 'Waktu' }}</p>
                    <p><i class="ti ti-map-pin"></i> {{ $invitation->reception_location ?? 'Lokasi' }}</p>
                    @if($invitation->reception_map_link)
                    <a href="{{ $invitation->reception_map_link }}" target="_blank" class="btn">Lihat di Maps</a>
                    @endif
                </div>
            </div>
            @if($invitation->dress_code)
            <div class="card" style="margin-top:30px;">
                <h3>Dress Code</h3>
                <p>{{ $invitation->dress_code }}</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Countdown Section -->
    <section class="section fade-in">
        <div class="container">
            <h2 class="section-title">Hitung Mundur</h2>
            <div class="countdown" id="countdown">
                <div class="time">
                    <div><span id="days">00</span><br>Hari</div>
                    <div><span id="hours">00</span><br>Jam</div>
                    <div><span id="minutes">00</span><br>Menit</div>
                    <div><span id="seconds">00</span><br>Detik</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    @if(!empty($invitation->galleries) && $invitation->galleries->count())
    <section class="section fade-in">
        <div class="container">
            <h2 class="section-title">Galeri</h2>
            <div class="masonry-gallery">
                @foreach($invitation->galleries as $gallery)
                <a href="{{ asset('storage/'.$gallery->path) }}" data-fancybox="gallery" class="masonry-item">
                    <img src="{{ asset('storage/'.$gallery->path) }}" alt="Gallery Image" style="width:100%;display:block;">
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Gift / Amplop Section -->
    @if($invitation->enable_gift)
    <section class="section fade-in">
        <div class="container">
            <h2 class="section-title">Kirim Amplop</h2>
            <div class="gift">
                @if($invitation->gift_bank_name && $invitation->gift_account_number)
                <p>Bank: {{ $invitation->gift_bank_name }}</p>
                <p>No. Rek: {{ $invitation->gift_account_number }}</p>
                <p>Atas Nama: {{ $invitation->gift_account_name }}</p>
                @endif
                @if($invitation->gift_qr_code)
                <img src="{{ asset('storage/'.$invitation->gift_qr_code) }}" alt="QR Code Amplop" style="max-width:200px;margin-top:15px;">
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- RSVP Section -->
    @if($invitation->enable_rsvp)
    <section class="section fade-in">
        <div class="container">
            <h2 class="section-title">RSVP</h2>
            <div class="rsvp">
                @if($invitation->rsvp_phone)
                <p>Konfirmasi ke: <a href="tel:{{ $invitation->rsvp_phone }}">{{ $invitation->rsvp_phone }}</a></p>
                @endif
                @if($invitation->rsvp_qr_code)
                <img src="{{ asset('storage/'.$invitation->rsvp_qr_code) }}" alt="QR Code RSVP" style="max-width:180px;margin-top:15px;">
                @endif
                @if($invitation->rsvp_form_url)
                <p><a href="{{ $invitation->rsvp_form_url }}" target="_blank" class="btn">Isi Formulir RSVP</a></p>
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ $invitation->title ?? 'Undangan Pernikahan' }}. All rights reserved.</p>
        </div>
    </footer>

    @if($invitation->music_url)
    <!-- Music Player -->
    <div class="music-player">
        <audio id="bg-music" src="{{ asset('storage/'.$invitation->music_url) }}" loop autoplay></audio>
        <button id="music-toggle" class="btn"><i class="ti ti-player-play"></i></button>
        <span>Musik Latar</span>
    </div>
    @endif

    <script>
        // Fade-in on scroll
        const observer = new IntersectionObserver((entries)=>{
            entries.forEach(entry=>{
                if(entry.isIntersecting){
                    entry.target.classList.add('visible');
                }
            });
        },{threshold:0.1});
        document.querySelectorAll('.fade-in').forEach(el=>observer.observe(el));

        // Countdown
        const targetDate = new Date("{{ $invitation->event_date ?? now()->addDays(30) }} {{ $invitation->event_time ?? '00:00' }}").getTime();
        const countdownFn = setInterval(()=>{
            const now = new Date().getTime();
            const distance = targetDate - now;
            if(distance<0){clearInterval(countdownFn);return;}
            const days = Math.floor(distance/(1000*60*60*24));
            const hours = Math.floor((distance%(1000*60*60*24))/(1000*60*60));
            const minutes = Math.floor((distance%(1000*60*60))/(1000*60));
            const seconds = Math.floor((distance%(1000*60))/1000);
            document.getElementById('days').innerText = String(days).padStart(2,'0');
            document.getElementById('hours').innerText = String(hours).padStart(2,'0');
            document.getElementById('minutes').innerText = String(minutes).padStart(2,'0');
            document.getElementById('seconds').innerText = String(seconds).padStart(2,'0');
        },1000);

        // Music Player
        @if($invitation->music_url)
        const music = document.getElementById('bg-music');
        const toggleBtn = document.getElementById('music-toggle');
        let playing = false;
        music.play().then(() => {
            playing = true;
            toggleBtn.innerHTML = '<i class="ti ti-player-pause"></i>';
        }).catch(() => {
            const playOnInteraction = () => {
                music.play();
                playing = true;
                toggleBtn.innerHTML = '<i class="ti ti-player-pause"></i>';
                document.removeEventListener('click', playOnInteraction);
                document.removeEventListener('touchstart', playOnInteraction);
            };
            document.addEventListener('click', playOnInteraction, { once: true });
            document.addEventListener('touchstart', playOnInteraction, { once: true });
        });
        toggleBtn.addEventListener('click',()=>{
            if(playing){
                music.pause();
                toggleBtn.innerHTML = '<i class="ti ti-player-play"></i>';
            }else{
                music.play();
                toggleBtn.innerHTML = '<i class="ti ti-player-pause"></i>';
            }
            playing = !playing;
        });
        @endif
    </script>
</body>
</html>