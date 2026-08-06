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

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Lato', 'sans-serif'],
                        cursive: ['Great Vibes', 'cursive']
                    },
                    colors: {
                        primary: '{{ $invitation->primary_color ?? '#c8a97e' }}'
                    }
                }
            }
        }
    </script>
    <style>
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
    </style>
</head>
<body class="bg-gray-300 flex justify-center font-sans">

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
            </div>
        </section>
        @endif

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
    </div>

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
            }
        });

        function addEmoji(emoji) {
            const textarea = document.querySelector('textarea[name="message"]');
            textarea.value += emoji;
            textarea.focus();
        }
    </script>
</body>
</html>
