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

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prata&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['Prata', 'serif'],
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        primary: '#D4AF37'
                    }
                }
            }
        }
    </script>
    <style>
        .fade-in { opacity: 0; transform: translateY(30px); transition: 1s all; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }
        .minimal-line { height: 1px; background: #D4AF37; width: 40px; margin: 15px auto; opacity: 0.5; }
        
        /* --- Desktop Layout --- */
        @media (min-width: 1024px) {
            body { background: #000; height: 100vh; overflow: hidden; display: flex; align-items: center; justify-content: center; }
            .w-full.max-w-\[420px\] { max-width: 1000px !important; flex-direction: row !important; display: flex !important; height: 90vh; border-radius: 20px; border: 1px solid rgba(212, 175, 55, 0.2); }
            header { flex: 1.2; height: 100% !important; border-right: 1px solid rgba(212, 175, 55, 0.1); }
            #content { flex: 1; height: 100%; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none; }
            #content::-webkit-scrollbar { display: none; }
        }
        
        body { scrollbar-width: none; -ms-overflow-style: none; }
        body::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-black text-[#D4AF37] font-sans flex justify-center">

    <div class="w-full max-w-[420px] min-h-screen bg-[#0F0F0F] relative overflow-hidden shadow-2xl border-x border-primary/20">
        
        <!-- Hero Section -->
        <header class="relative h-screen flex items-center justify-center text-center px-8">
            <div id="preview-hero-bg" class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ storage_url($invitation->gallery_cover) }}');"></div>
            <div class="relative z-10 space-y-6">
                <p class="text-xs tracking-[0.4em] uppercase font-light text-primary">Wedding Invitation</p>
                <h1 class="font-serif text-5xl tracking-widest text-primary">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h1>
                <div class="minimal-line"></div>
                <p class="text-sm font-light italic opacity-80">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</p>
                <div class="mt-4 text-xs tracking-widest opacity-60">
                    Kepada Yth:<br>
                    <span class="text-primary font-bold block mt-2 text-sm">{{ request('penerima') ?? 'Tamu Undangan' }}</span>
                </div>
                <button onclick="document.getElementById('content').scrollIntoView({behavior:'smooth'})" class="mt-10 border border-primary px-10 py-3 text-xs uppercase tracking-widest hover:bg-primary hover:text-black transition text-primary">Buka Undangan</button>
            </div>
        </header>

        <div id="content">
            
            <!-- Quote -->
            <section class="py-24 px-10 text-center border-b border-primary/10">
                <div class="fade-in">
                    <p class="font-serif text-lg leading-relaxed italic">"{!! nl2br(e($invitation->wedding_quote)) !!}"</p>
                    <div class="minimal-line"></div>
                    <p class="text-[10px] uppercase tracking-[0.2em] font-bold opacity-60">{{ $invitation->quote_id ?? '' }}</p>
                </div>
            </section>

            <!-- Mempelai -->
            <section class="py-24 px-8 text-center space-y-20">
                <div class="fade-in">
                    <h2 class="text-xs tracking-[0.5em] uppercase opacity-50 mb-4">The Couple</h2>
                    <h3 class="font-serif text-3xl">Mempelai</h3>
                </div>

                <div class="space-y-24">
                    <!-- Groom -->
                    <div class="fade-in">
                        <img loading="lazy" id="preview-foto-pria" src="{{ storage_url($invitation->foto_pria) }}" alt="Groom" class="w-full h-80 object-cover grayscale border border-primary/30 p-2">
                        <h4 class="font-serif text-2xl mt-8">{{ $invitation->groom_name }}</h4>
                        <p class="text-xs uppercase tracking-widest opacity-60">{{ $invitation->groom_child_order_text ? 'Putra ' . $invitation->groom_child_order_text . ' dari' : 'Putra dari' }} Bpk. {{ $invitation->groom_father_name }} & Ibu {{ $invitation->groom_mother_name }}</p>
                    </div>

                    <!-- Bride -->
                    <div class="fade-in">
                        <img loading="lazy" id="preview-foto-wanita" src="{{ storage_url($invitation->foto_wanita) }}" alt="Bride" class="w-full h-80 object-cover grayscale border border-primary/30 p-2">
                        <h4 class="font-serif text-2xl mt-8">{{ $invitation->bride_name }}</h4>
                        <p class="text-xs uppercase tracking-widest opacity-60">{{ $invitation->bride_child_order_text ? 'Putri ' . $invitation->bride_child_order_text . ' dari' : 'Putri dari' }} Bpk. {{ $invitation->bride_father_name }} & Ibu {{ $invitation->bride_mother_name }}</p>
                    </div>
                </div>
            </section>

            <!-- Waktu -->
            <section class="py-24 px-10 bg-black/40 text-center space-y-12">
                <div class="fade-in">
                    <h2 class="text-xs tracking-[0.5em] uppercase opacity-50 mb-4">Save The Date</h2>
                    <h3 class="font-serif text-3xl italic">Waktu & Tempat</h3>
                </div>

                <div class="grid grid-cols-1 gap-12 fade-in">
                    <div class="space-y-4">
                        <p class="text-[10px] uppercase tracking-[0.3em] font-bold text-primary">Akad Nikah</p>
                        <p class="font-serif text-xl italic">{{ $invitation->akad_time }} WIB</p>
                        <p class="text-xs font-light leading-loose opacity-60 uppercase tracking-widest">{{ $invitation->akad_location }}<br>{{ $invitation->akad_address }}</p>
                        <a href="{{ $invitation->akad_maps }}" target="_blank" class="inline-block text-[10px] uppercase tracking-widest border-b border-primary pb-1">View Location</a>
                    </div>
                    
                    <div class="w-10 h-px bg-primary mx-auto opacity-20"></div>

                    <div class="space-y-4">
                        <p class="text-[10px] uppercase tracking-[0.3em] font-bold text-primary">Resepsi</p>
                        <p class="font-serif text-xl italic">{{ $invitation->resepsi_time }} WIB</p>
                        <p class="text-xs font-light leading-loose opacity-60 uppercase tracking-widest">{{ $invitation->resepsi_location }}<br>{{ $invitation->resepsi_address }}</p>
                        <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="inline-block text-[10px] uppercase tracking-widest border-b border-primary pb-1">View Location</a>
                    </div>
                </div>
            </section>

            <!-- Countdown -->
            <section class="py-16 bg-primary text-black text-center">
                <div class="flex justify-center gap-10 fade-in">
                    <div class="text-center"><div id="days" class="font-serif text-3xl">00</div><p class="text-[8px] uppercase tracking-widest opacity-50 mt-2">Days</p></div>
                    <div class="text-center"><div id="hours" class="font-serif text-3xl">00</div><p class="text-[8px] uppercase tracking-widest opacity-50 mt-2">Hours</p></div>
                    <div class="text-center"><div id="minutes" class="font-serif text-3xl">00</div><p class="text-[8px] uppercase tracking-widest opacity-50 mt-2">Mins</p></div>
                    <div class="text-center"><div id="seconds" class="font-serif text-3xl">00</div><p class="text-[8px] uppercase tracking-widest opacity-50 mt-2">Secs</p></div>
                </div>
            </section>

            <!-- Galeri -->
            @if(($invitation->enable_gallery ?? true) && $invitation->galleries->count())
            <section class="py-24 px-6 text-center space-y-12">
                <h3 class="font-serif text-3xl">Galeri</h3>
                <div class="grid grid-cols-2 gap-4 fade-in" id="gallery-container">
                    @foreach($invitation->galleries as $photo)
                    <a href="{{ storage_url($photo->image) }}" data-fancybox="gallery">
                        <img loading="lazy" src="{{ storage_url($photo->image) }}" alt="Gallery" class="w-full border border-primary/20 p-1 grayscale hover:grayscale-0 transition duration-500">
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Gift -->
            @if($invitation->enable_gift == 1 && $invitation->gifts->count())
            <section class="py-24 px-8 text-center space-y-12">
                <h3 class="font-serif text-3xl">Wedding Gift</h3>
                <div class="grid grid-cols-1 gap-8 fade-in">
                    @foreach($invitation->gifts as $gift)
                    <div class="border border-primary/20 p-8 grayscale">
                        <h4 class="font-serif text-xl">{{ $gift->bank }}</h4>
                        <p class="text-2xl font-serif mt-4">{{ $gift->number }}</p>
                        <p class="text-xs uppercase tracking-widest opacity-60 mt-2">A/N: {{ $gift->name }}</p>
                        <button onclick="copyToClipboard('{{ $gift->number }}')" class="mt-6 border border-primary px-6 py-2 text-[10px] uppercase tracking-widest hover:bg-primary hover:text-black transition">Salin</button>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- RSVP -->
            @if($invitation->enable_rsvp == 1)
            <section class="py-24 px-10 bg-black border-t border-primary/10">
                <div class="text-center mb-12">
                    <h3 class="font-serif text-3xl italic">Ucapan</h3>
                    <div class="minimal-line"></div>
                </div>
                <form id="rsvpForm" class="space-y-6">
                    @csrf
                    <input type="text" name="name" class="w-full bg-transparent border-b border-primary/30 py-3 text-sm focus:border-primary outline-none transition uppercase tracking-widest" placeholder="Nama" required>
                    <select name="attending" class="w-full bg-transparent border-b border-primary/30 py-3 text-sm focus:border-primary outline-none transition uppercase tracking-widest">
                        <option value="1" class="bg-black">Hadir</option>
                        <option value="0" class="bg-black">Tidak Hadir</option>
                    </select>

                    <div class="emoji-picker" style="margin-bottom: 10px; display: flex; gap: 10px; justify-content: center;">
                        <button type="button" onclick="addEmoji('🎉')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🎉</button>
                        <button type="button" onclick="addEmoji('❤️')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">❤️</button>
                        <button type="button" onclick="addEmoji('🥳')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🥳</button>
                        <button type="button" onclick="addEmoji('✨')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">✨</button>
                        <button type="button" onclick="addEmoji('🙏')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🙏</button>
                    </div>

                    <textarea name="message" class="w-full bg-transparent border-b border-primary/30 py-3 text-sm focus:border-primary outline-none transition" rows="3" placeholder="Doa & Harapan" required></textarea>
                    <button type="submit" id="rsvpButton" class="w-full bg-primary text-black py-4 text-xs uppercase tracking-[0.3em] font-bold hover:bg-white transition">Kirim</button>
                </form>
                <div id="rsvpList" class="mt-16 space-y-10 max-h-96 overflow-y-auto"></div>
            </section>
            @endif

            <!-- Footer -->
            <footer class="py-24 bg-black/60 text-center border-t border-primary/10">
                <h2 class="font-serif text-3xl tracking-widest opacity-80">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h2>
                <div class="minimal-line"></div>
                <p class="text-[9px] uppercase tracking-[0.4em] opacity-40 mt-10">Undangan Digital &copy; {{ date('Y') }}</p>
            </footer>
        </div>
    </div>

    <x-music-player :invitation="$invitation" />

    <script>
        // Scroll
        const obs = new IntersectionObserver(es => es.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible') }), { threshold: 0.1 });
        document.querySelectorAll('.fade-in').forEach(el => obs.observe(el));

        // Countdown
        const wDate = new Date("{{ $invitation->wedding_date }}").getTime();
        setInterval(() => {
            const d = wDate - new Date().getTime();
            if (d < 0) return;
            document.getElementById("days").innerText = String(Math.floor(d / 864e5)).padStart(2, '0');
            document.getElementById("hours").innerText = String(Math.floor((d % 864e5) / 36e5)).padStart(2, '0');
            document.getElementById("minutes").innerText = String(Math.floor((d % 36e5) / 6e4)).padStart(2, '0');
            document.getElementById("seconds").innerText = String(Math.floor((d % 6e4) / 1e3)).padStart(2, '0');
        }, 1e3);

        // RSVP
        const id = "{{ $invitation->id }}";
        function load() {
            fetch(`/invitation/${id}/rsvps`).then(r => r.json()).then(ds => {
                document.getElementById('rsvpList').innerHTML = ds.map(d => `
                    <div class="text-center">
                        <p class="text-[10px] uppercase tracking-widest font-bold">${d.name} <span class="text-primary font-normal italic">${d.attending ? '/ Hadir' : '/ Absen'}</span></p>
                        <p class="text-xs opacity-60 mt-2 font-light leading-relaxed px-4 italic">"${d.message}"</p>
                    </div>
                `).join('<div class="minimal-line opacity-10"></div>');
            });
        }
        document.getElementById('rsvpForm').onsubmit = (e) => {
            e.preventDefault();
            const b = document.getElementById('rsvpButton'); b.disabled = true; b.innerText = 'WAIT...';
            fetch(`/invitation/${id}/rsvp`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
            }).then(() => { e.target.reset(); load(); }).finally(() => { b.disabled = false; b.innerText = 'SEND'; });
        };
        load();

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
                            <a href="${src}" data-fancybox="gallery">
                                <img loading="lazy" src="${src}" alt="Gallery" class="w-full border border-primary/20 p-1 grayscale hover:grayscale-0 transition duration-500">
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
</body>

</html>
