<x-app-layout>
    <style>
        /* Cover Image & Profile Header */

        .overlay-gradiant {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.7));
        }

        /* Avatar Styles */
        .avatar-150 {
            width: 150px;
            height: 150px;
            border: 5px solid #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .avatar-28 {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;


        }

        .timeline {
            position: relative;
            padding-left: 20px;
            border-left: 4px solid;
            border-image: var(--primary-gradient) 1;
            margin-left: 10px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            opacity: 0;
            /* Hidden for animation */
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -29px;
            top: 5px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 4px solid #ff758c;
        }

        .timeline-item.appear {
            opacity: 1;
            transform: translateY(0);
        }

        .gallery-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .gallery-card:hover .gallery-img {
            transform: scale(1.05);
        }
    </style>



    <div class="container mt-4" id="main-content">

        <!-- 1. COVER & PROFILE HEADER -->
        <div class="card adminuiux-card mb-4 pt-5 position-relative">
            <figure class="coverimg start-0 top-0 w-100 h-100 z-index-0 position-absolute overlay-gradiant"
                style="background-image: url(&quot;assets/img/modern-ai-image/flamingo-3.jpg&quot;);">

                <img src="{{ asset('assets/img/modern-ai-image/flamingo-3.jpg') }}" class="mw-100" alt=""
                    style="display: none;">
            </figure>

            {{-- CARD BODY --}}
            <div class="card-body text-center text-white z-index-1 position-relative">

                {{-- AVATAR PASANGAN --}}
                <div class="d-flex justify-content-center gap-3 my-3 position-relative">

                    {{-- Mempelai Pria --}}
                    <figure class="avatar avatar-120 rounded-circle"
                        style="
                        background-image: url('{{ $invitation->foto_pria && file_exists(storage_path('app/public/' . $invitation->foto_pria)) ? asset('storage/' . $invitation->foto_pria) : 'https://picsum.photos/seed/groom/300/300' }}');
                        background-size: cover;
                        background-position: center;
                        background-color: #fff;
                    ">
                        <button class="btn btn-theme btn-sm position-absolute bottom-0 end-0"
                            onclick="showToast('Edit Foto Pria')">
                            <i class="bi bi-camera"></i>
                        </button>
                    </figure>

                    {{-- Mempelai Wanita --}}
                    <figure class="avatar avatar-120 rounded-circle"
                        style="
                        background-image: url('{{ $invitation->foto_wanita && file_exists(storage_path('app/public/' . $invitation->foto_wanita)) ? asset('storage/' . $invitation->foto_wanita) : 'https://picsum.photos/seed/bride/300/300' }}');
                        background-size: cover;
                        background-position: center;
                        background-color: #fff;
                    ">
                        <button class="btn btn-theme btn-sm position-absolute bottom-0 end-0"
                            onclick="showToast('Edit Foto Wanita')">
                            <i class="bi bi-camera"></i>
                        </button>
                    </figure>
                </div>

                {{-- NAMA PASANGAN --}}
                <h2 class="fw-bold display-6 mb-1">
                    {{ $invitation->groom_nickname ?? 'Romeo' }} & {{ $invitation->bride_nickname ?? 'Juliet' }}
                </h2>

                {{-- TANGGAL PERNIKAHAN --}}
                @if ($invitation->wedding_date)
                    <p class="opacity-75 mb-1">
                        {{ \Carbon\Carbon::parse($invitation->wedding_date)->isoFormat('dddd, D MMMM Y') }}
                    </p>
                @else
                    <p class="opacity-75 mb-1">Tanggal belum ditentukan</p>
                @endif

                {{-- BADGE --}}
                <span class="badge bg-white text-dark shadow-sm">Dashboard Undangan Digital</span>
            </div>

        </div>

        {{-- CSS tambahan --}}
        <style>
            .avatar button {
                transform: translate(50%, 50%);
            }
        </style>


        <!-- 2. MAIN CONTENT ROW -->
        <div class="row">
            <!-- SIDEBAR NAVIGATION -->
            <div class="col-12 col-md-4 col-lg-4 col-xl-3">
                <div class="position-sticky">
                    <div class="card adminuiux-card mb-4">
                        <div class="card-body">
                            <p class="small text-uppercase text-muted fw-bold mb-2">Menu Navigasi</p>
                            <ul class="nav nav-pills adminuiux-nav-pills flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#section-profile" onclick="setActive(this)">
                                        <div class="avatar avatar-28 icon"><i class="bi bi-heart-fill fs-5"></i></div>
                                        <div class="col">
                                            <p class="h6 mb-0">Pasangan</p>
                                            <p class="small opacity-75">Data Mempelai</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#section-events" onclick="setActive(this)">
                                        <div class="avatar avatar-28 icon"><i class="bi bi-calendar-event fs-4"></i>
                                        </div>
                                        <div class="col">
                                            <p class="h6 mb-0">Acara</p>
                                            <p class="small opacity-75">Timeline & Lokasi</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#section-gallery" onclick="setActive(this)">
                                        <div class="avatar avatar-28 icon"><i class="bi bi-images fs-4"></i></div>
                                        <div class="col">
                                            <p class="h6 mb-0">Galeri</p>
                                            <p class="small opacity-75">Foto Prewedding</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#section-story" onclick="setActive(this)">
                                        <div class="avatar avatar-28 icon"><i class="bi bi-bookmark-star fs-4"></i>
                                        </div>
                                        <div class="col">
                                            <p class="h6 mb-0">Cerita</p>
                                            <p class="small opacity-75">Love Story & Quote</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('invitation.edit', $invitation->id) }}">
                                        <div class="avatar avatar-28 icon"><i class="bi bi-pencil-square fs-4"></i>
                                        </div>
                                        <div class="col">
                                            <p class="h6 mb-0">Edit Data</p>
                                            <p class="small opacity-75">Ubah Informasi</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>

                            <hr class="my-3">

                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-outline-danger btn-sm" >
                                    <i class="bi bi-printer"></i> Cetak Undangan
                                </a>
                                <button class="btn btn-theme btn-sm"
                                    onclick="copyLink('{{ route('invitation.show', $invitation->slug) }}')">
                                    <i class="bi bi-whatsapp"></i> Bagikan Link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT CONTENT AREA -->
            <div class="col">

                <!-- SECTION: PASANGAN (Couple) -->
                <div id="section-profile" class="card adminuiux-card overflow-hidden mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="mb-0 fw-bold text-uppercase text-muted">Mempelai</h6>

                        </div>

                        <div class="row g-4">
                            <!-- Groom Card (Data dari Kode 2) -->
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm hover-card border-0" style="border-radius: 15px;">
                                    <div style="background: linear-gradient(135deg,#a1c4fd,#c2e9fb); padding:30px;"
                                        class="text-center position-relative">
                                        <i
                                            class="bi bi-gender-male position-absolute top-0 end-0 m-3 text-white fs-4 opacity-50"></i>
                                        <img src="{{ $invitation->foto_pria ? asset('storage/' . $invitation->foto_pria) : 'https://picsum.photos/seed/groom/200/200' }}"
                                            class="rounded-circle mb-3 shadow-lg" width="120" height="120"
                                            style="object-fit:cover; border:4px solid #fff;">
                                        <h5 class="fw-bold text-dark">{{ $invitation->groom_name ?? 'Nama Pria' }}
                                        </h5>
                                        <p class="text-black small mb-0">
                                            Putra dari Bpk. {{ $invitation->groom_father_name ?? '-' }} & Ibu
                                            {{ $invitation->groom_mother_name ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="card-body text-center ">
                                        <small class="text-uppercase fw-bold ">Panggilan</small>
                                        <h6 class="text-primary">{{ $invitation->groom_nickname ?? '-' }}</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Bride Card (Data dari Kode 2) -->
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm hover-card border-0" style="border-radius: 15px;">
                                    <div style="background: linear-gradient(135deg,#ff9a9e,#fad0c4); padding:30px;"
                                        class="text-center position-relative">
                                        <i
                                            class="bi bi-gender-female position-absolute top-0 end-0 m-3 text-white fs-4 opacity-50"></i>
                                        <img src="{{ $invitation->foto_wanita ? asset('storage/' . $invitation->foto_wanita) : 'https://picsum.photos/seed/bride/200/200' }}"
                                            class="rounded-circle mb-3 shadow-lg" width="120" height="120"
                                            style="object-fit:cover; border:4px solid #fff;">
                                        <h5 class="fw-bold text-white">{{ $invitation->bride_name ?? 'Nama Wanita' }}
                                        </h5>
                                        <p class="text-light small mb-0">
                                            Putri dari Bpk. {{ $invitation->bride_father_name ?? '-' }} & Ibu
                                            {{ $invitation->bride_mother_name ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="card-body text-center ">
                                        <small class="text-uppercase fw-bold text-muted">Panggilan</small>
                                        <h6 class="text-danger">{{ $invitation->bride_nickname ?? '-' }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION: ACARA (Timeline) -->
                <div id="section-events" class="card adminuiux-card overflow-hidden mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="mb-0 fw-bold text-uppercase text-muted">Rangkaian Acara</h6>

                        </div>

                        <div class="timeline">
                            <!-- Akad (Data dari Kode 2) -->
                            @if ($invitation->akad_location)
                                <div class="timeline-item p-3 rounded shadow-sm border">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-bold text-primary">Akad Nikah</h5>
                                        <span
                                            class="badge bg-light text-dark border">{{ $invitation->akad_time ?? '--:--' }}
                                            WIB</span>
                                    </div>
                                    <p class="mb-1 text-muted"><i class="bi bi-geo-alt-fill text-danger"></i>
                                        {{ $invitation->akad_location }}</p>
                                    <p class="small text-secondary mb-2">Prosesi sakral pengikatan janji suci kedua
                                        mempelai.</p>
                                    @if ($invitation->akad_maps)
                                        <a href="{{ $invitation->akad_maps }}" target="_blank"
                                            class="btn btn-sm btn-outline-danger w-100 hover-card">
                                            <i class="bi bi-map"></i> Lihat Lokasi di Google Maps
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <!-- Resepsi (Data dari Kode 2) -->
                            @if ($invitation->resepsi_location)
                                <div class="timeline-item p-3 rounded  shadow-sm border">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-bold text-danger">Resepsi</h5>
                                        <span
                                            class="badge bg-light text-dark border">{{ $invitation->resepsi_time ?? '--:--' }}
                                            WIB</span>
                                    </div>
                                    <p class="mb-1 text-muted"><i class="bi bi-geo-alt-fill text-danger"></i>
                                        {{ $invitation->resepsi_location }}</p>
                                    <p class="small text-secondary mb-2">Ramah tamah dengan keluarga dan kerabat
                                        terdekat.</p>
                                    @if ($invitation->resepsi_maps)
                                        <div class="d-grid">
                                            <a href="{{ $invitation->resepsi_maps }}" target="_blank"
                                                class="btn btn-sm btn-outline-danger hover-card">
                                                <i class="bi bi-map"></i> Lihat Lokasi di Google Maps
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- SECTION: GALERI -->
                <div id="section-gallery" class="card adminuiux-card overflow-hidden mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="mb-0 fw-bold text-uppercase text-muted">Galeri Foto</h6>

                        </div>

                        {{-- Menampilkan galeri jika ada relasi $galleries --}}
                        <div class="row g-3">
                            @if (isset($galleries) && $galleries->count())
                                @foreach ($galleries as $gallery)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <a href="{{ asset('storage/' . $gallery->image) }}"
                                            class="glightbox gallery-card">
                                            <img src="{{ asset('storage/' . $gallery->image) }}"
                                                class="gallery-img shadow-sm" alt="Gallery Photo">
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center text-muted w-100">Belum ada foto galeri.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card adminiux-card mb-3">
                    <div class="card-header">
                        <h4 class="fw-bold  text-danger"><i class="bi bi-heart-fill"></i> Kisah Cinta Kami
                                </h4>
                    </div>
                    <div class="card-body">
                        <style>
                            .love-story-img {
                                max-height: 280px;
                                object-fit: cover;
                            }

                            #loveStoryCarousel {
                                padding: 10px;
                            }

                            .carousel-control-prev-icon,
                            .carousel-control-next-icon {
                                filter: invert(1);
                            }

                        </style>


                        @if (!empty($invitation->love_story))
                        <div id="loveStoryCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
                            <div class="carousel-inner">

                                @foreach ($invitation->love_story as $index => $story)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="row align-items-center g-4 justify-content-center">

                                        {{-- FOTO --}}
                                        @if (!empty($story['photo']))
                                        <div class="col-md-5 text-center">
                                            <img src="{{ asset('storage/'.$story['photo']) }}" class="img-fluid rounded-4 shadow-sm love-story-img" alt="{{ $story['title'] ?? 'Love Story' }}">
                                        </div>
                                        @endif

                                        {{-- CERITA --}}
                                        <div class="col-md-7">
                                            @if (!empty($story['title']))
                                            <h5 class="fw-bold text-danger mb-2">{{ $story['title'] }}</h5>
                                            @endif

                                            @if (!empty($story['story']))
                                            <p class="text-secondary fst-italic mb-0">
                                                {!! nl2br(e($story['story'])) !!}
                                            </p>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                @endforeach

                            </div>

                            {{-- NAV --}}
                            <button class="carousel-control-prev" type="button" data-bs-target="#loveStoryCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#loveStoryCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                        @else
                        <p class="text-secondary fst-italic mb-4">
                            Belum ada cerita cinta yang ditambahkan.
                        </p>
                        @endif
                    </div>
                </div>

                <!-- SECTION: LOVE STORY -->
                <div id="section-story" class="card adminuiux-card overflow-hidden mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="mb-0 fw-bold text-uppercase text-muted">Quote</h6>

                        </div>

                        <!-- Love Story Text (Data dari Kode 2) -->
                        <div class="bg-light p-4 rounded-3 border border-danger border-opacity-10 position-relative overflow-hidden"
                            id="love-story-trigger">
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                style="background: radial-gradient(circle at top right, rgba(255,117,140,0.1), transparent); z-index:0;">
                            </div>

                            <div class="position-relative z-1 text-center">

                                {{-- Wedding Quote (Data dari Kode 2) --}}
                                @if ($invitation->wedding_quote)
                                    <div class="card shadow-sm border-0 mx-auto" style="max-width: 500px;">
                                        <div class="card-body">
                                            <i class="bi bi-quote fs-1 text-danger opacity-25 d-block mb-2"></i>
                                            <h5 class="fw-bold text-dark fst-italic">
                                                "{{ $invitation->wedding_quote }}"
                                            </h5>
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <button class="btn btn-sm btn-outline-danger" onclick="triggerConfetti()">
                                        <i class="bi bi-stars"></i> Rayakan Momen Ini
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Video Link (Data dari Kode 2) --}}
               {{-- Video Link (YouTube) --}}
@if ($invitation->video_link)
    @php
        // Ambil ID video dari URL YouTube
        preg_match("/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([^\?&\/]+)/", $invitation->video_link, $matches);
        $youtubeId = $matches[1] ?? null;
        $embedUrl = $youtubeId ? "https://www.youtube.com/embed/" . $youtubeId : null;
    @endphp

    @if ($embedUrl)
        <div class="card adminuiux-card overflow-hidden mb-4">
            <div class="card-body text-center">
                <h6 class="mb-3 fw-bold">Video Pernikahan</h6>
                <div class="ratio ratio-16x9 mx-auto" style="max-width: 600px;">
                    <iframe src="{{ $embedUrl }}" title="YouTube video" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-danger">Link video tidak valid.</p>
    @endif
@endif


            </div>
        </div>
    </div>


    <script>
        // --- 3. Animations (Timeline) ---
        const faders = document.querySelectorAll('.timeline-item');

        const appearOnScroll = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('appear');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });

        faders.forEach(fader => appearOnScroll.observe(fader));

        // --- 4. Confetti Logic ---
        function triggerConfetti() {
            var duration = 3 * 1000;
            var animationEnd = Date.now() + duration;
            var defaults = {
                startVelocity: 30,
                spread: 360,
                ticks: 60,
                zIndex: 0
            };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function() {
                var timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                var particleCount = 50 * (timeLeft / duration);

                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: randomInRange(0.1, 0.3),
                        y: Math.random() - 0.2
                    }
                }));
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: randomInRange(0.7, 0.9),
                        y: Math.random() - 0.2
                    }
                }));
            }, 250);

            showToast(
                'Selamat untuk {{ $invitation->groom_name ?? 'Mempelai' }} & {{ $invitation->bride_name ?? 'Mempelai' }}!'
                );
        }

        // Trigger confetti automatically when scrolling to story
        const loveStorySection = document.getElementById('love-story-trigger');
        let confettiTriggered = false;

        if (loveStorySection) {
            const confettiObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !confettiTriggered) {
                        confettiTriggered = true;
                        setTimeout(() => triggerConfetti(), 500);
                    }
                });
            }, {
                threshold: 0.5
            });
            confettiObserver.observe(loveStorySection);
        }





        // CSS Animation for Toast
        const styleSheet = document.createElement("style");
        styleSheet.innerText = `
        @keyframes fadeInUp {
            from { opacity: 0; transform: translate(-50%, 20px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
        .custom-toast { min-width: 250px; }
    `;
        document.head.appendChild(styleSheet);
    </script>
    <script>
    // GLightbox
    GLightbox({ selector: '.glightbox', openEffect: 'zoom', closeEffect: 'fade' });

    // Timeline appear
    document.querySelectorAll('.timeline-item').forEach(item => {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) { entry.target.classList.add('appear'); obs.unobserve(entry.target); }
            });
        }, { threshold: 0.2 });
        observer.observe(item);
    });

    // Toast
    function showToast(message){
        const t = document.createElement('div');
        t.className='custom-toast position-fixed bottom-0 start-50 translate-middle-x m-3 p-3 bg-dark text-white rounded shadow-lg';
        t.innerHTML = `<div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>${message}</span></div>`;
        document.body.appendChild(t);
        setTimeout(()=>{ t.style.opacity=0; setTimeout(()=>t.remove(),500); },3000);
    }

    function copyLink(url){ navigator.clipboard.writeText(url).then(()=>showToast('Link berhasil disalin!'),()=>showToast('Gagal menyalin')); }

    // Confetti
    function triggerConfetti(){
        const duration=3000; const animationEnd=Date.now()+duration;
        const defaults={startVelocity:30,spread:360,ticks:60,zIndex:0};
        const interval=setInterval(function(){
            const timeLeft=animationEnd-Date.now(); if(timeLeft<=0){return clearInterval(interval);}
            const particleCount=50*(timeLeft/duration);
            confetti({...defaults,particleCount,origin:{x:0.1+Math.random()*0.2,y:Math.random()-0.2}});
            confetti({...defaults,particleCount,origin:{x:0.7+Math.random()*0.2,y:Math.random()-0.2}});
        },250);
        showToast('Selamat untuk {{ $invitation->groom_name ?? 'Mempelai' }} & {{ $invitation->bride_name ?? 'Mempelai' }}!');
    }

    // Music toggle
    let isPlaying=false; const musicBtn=document.getElementById('musicBtn'), musicIcon=document.getElementById('musicIcon');
    function toggleMusic(){
        const bgMusic=document.getElementById('bgMusic'); if(!bgMusic) return;
        if(isPlaying){ bgMusic.pause(); musicBtn.classList.remove('playing'); musicIcon.classList.replace('bi-pause-fill','bi-music-note-beamed'); }
        else{ bgMusic.play(); musicBtn.classList.add('playing'); musicIcon.classList.replace('bi-music-note-beamed','bi-pause-fill'); }
        isPlaying=!isPlaying;
    }
</script>
</x-app-layout>
