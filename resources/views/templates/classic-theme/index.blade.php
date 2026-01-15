<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Pernikahan | Asep & Siti</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- di <head> -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['Playfair Display']
                        , sans: ['Lato']
                    }
                    , colors: {
                        primary: '#c8a97e'
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

    </style>
    <style>
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

        h2 {
            font-family: 'Great Vibes', cursive;
            letter-spacing: 0.05em;
        }

    </style>
</head>

<body class="bg-gray-300 flex justify-center font-sans lock-scroll">

    <!-- MUSIC -->

    <!-- Tombol Floating -->
    <button id="musicToggle" class="fixed bottom-6 right-6 bg-primary text-white p-3 rounded-full shadow-lg flex items-center justify-center z-50 hover:bg-primary/90 transition">
        <!-- Icon default: play -->
        <svg id="musicIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-6.518-3.759A1 1 0 007 8.32v7.36a1 1 0 001.234.97l6.518-1.885a1 1 0 00.75-.97v-1.87a1 1 0 00-.75-.97z" />
        </svg>
    </button>

    <!-- MOBILE WRAPPER -->
    <div class="w-full max-w-[420px] min-h-screen bg-[#fdfaf6] relative overflow-hidden shadow-2xl">

        <!-- ================= COVER ================= -->
        <section id="cover" class="relative h-screen flex items-center justify-center text-center">
            <div class="absolute inset-0 bg-cover bg-center lazy-bg" style="background-image: url('{{ asset('storage/' . $invitation->gallery_cover) }}')">

            </div>
            <div class="absolute inset-0 bg-black/50"></div>

            <div class="relative z-10 text-white px-6 space-y-4">
                <p class="text-sm tracking-widest uppercase">Undangan Pernikahan</p>
                <h1 class="font-serif text-5xl font-bold">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}
                </h1>
                <p class="text-sm">
                    Kepada Yth<br>
                    <span class="border-b border-white px-2 py-1 inline-block mt-2">
                        Bapak / Ibu / Saudara
                    </span>

                </p>
                <span class="mt-3">{{  request('to') ?? 'Keluarga Besar' }}</span>
                <p class="text-sm">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}
                </p>

                <button id="openInvitation" class="bg-primary px-8 py-3 rounded-full text-sm font-semibold shadow-lg active:scale-95 transition">
                    <i class="ti ti-mail-opened text-lg"></i> Buka Undangan
                </button>
            </div>
        </section>

        <!-- ================= CONTENT ================= -->
        <section id="content" class="space-y-14 py-12 ">

            @foreach ($invitation->template->sections as $section)
            @includeIf('templates.' . $invitation->template->slug . '.sections.' . $section)
            @endforeach


        </section>
    </div>

    <script>
        // Lazy load background image
        document.addEventListener("DOMContentLoaded", function() {
            const lazyBackgrounds = document.querySelectorAll('.lazy-bg');

            if ("IntersectionObserver" in window) {
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const div = entry.target;
                            const bg = div.dataset.bg;
                            if (bg) {
                                div.style.backgroundImage = `url('${bg}')`;
                                div.classList.remove('lazy-bg');
                                observer.unobserve(div);
                            }
                        }
                    });
                });

                lazyBackgrounds.forEach(div => observer.observe(div));
            } else {
                // fallback jika browser tidak support IntersectionObserver
                lazyBackgrounds.forEach(div => {
                    const bg = div.dataset.bg;
                    div.style.backgroundImage = `url('${bg}')`;
                });
            }
        });

    </script>

</body>

</html>
