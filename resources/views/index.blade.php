<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyWeed - Platform Undangan Digital Premium & Modern</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0D0C22;
            --secondary: #6E6D7A;
            --accent: #EA4C89;
            --accent-hover: #F082AC;
            --bg-light: #F8F7F4;
            --white: #FFFFFF;
            --border: #E7E7E9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--primary);
            background-color: var(--white);
            margin: 0;
            padding: 0;
        }

        a { text-decoration: none; color: inherit; transition: all 0.3s ease; }

        /* Navbar */
        .navbar {
            padding: 1rem 0;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary) !important;
        }

        .nav-link {
            font-weight: 600;
            color: var(--secondary) !important;
            margin: 0 1rem;
            font-size: 0.9rem;
        }

        .nav-link:hover { color: var(--primary) !important; }

        .btn-pink {
            background: var(--accent);
            color: var(--white) !important;
            border-radius: 8px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .btn-pink:hover { background: var(--accent-hover); }

        /* Hero */
        .hero-section {
            padding: 120px 0 100px;
            text-align: center;
            background: linear-gradient(rgba(13, 12, 34, 0.7), rgba(13, 12, 34, 0.7)), url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=2069&auto=format&fit=crop') center/cover no-repeat;
            color: white;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.2rem;
            letter-spacing: -1px;
            color: white;
        }

        .hero-section p {
            font-size: 1.25rem;
            color: rgba(255,255,255,0.85);
            margin-bottom: 2.5rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Search Bar */
        .search-container {
            max-width: 600px;
            margin: 0 auto 2.5rem;
            position: relative;
        }

        .search-container input {
            width: 100%;
            padding: 1.2rem 1.5rem 1.2rem 3.5rem;
            border-radius: 50px;
            border: 1px solid transparent;
            background: var(--white);
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .search-container input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(234, 76, 137, 0.1);
        }

        .search-container i {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary);
            font-size: 1.1rem;
        }

        .search-container .btn-search {
            position: absolute;
            right: 8px;
            top: 8px;
            bottom: 8px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Tags */
        .tag-list {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tag-item {
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--secondary);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .tag-item.active, .tag-item:hover {
            background: var(--white);
            color: var(--primary);
            border-color: var(--primary);
        }

        /* Grid */
        .template-section {
            padding: 30px 0 80px;
        }

        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            padding: 20px;
        }

        .template-card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .template-img-container {
            aspect-ratio: 4/3;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            background: #eee;
        }

        .template-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .template-card:hover img {
            transform: scale(1.05);
        }

        .template-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            gap: 10px;
        }

        .template-card:hover .template-overlay {
            opacity: 1;
        }

        .template-footer {
            padding: 12px 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #ddd;
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 700;
        }

        .card-stats {
            display: flex;
            gap: 10px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--secondary);
        }

        .card-stats i { font-size: 0.85rem; }

        .badge-pro {
            background: #D4AF37;
            color: white;
            font-size: 0.65rem;
            padding: 1px 5px;
            border-radius: 3px;
            font-weight: 800;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border);
            padding: 80px 0 40px;
            background: var(--white);
        }

        .footer-logo { font-weight: 800; font-size: 1.5rem; margin-bottom: 1.5rem; display: block; }
        .footer-links { list-style: none; padding: 0; }
        .footer-links li { margin-bottom: 0.8rem; font-size: 0.9rem; color: var(--secondary); }
        .footer-links li a:hover { color: var(--accent); }

        /* Real Wedding Slider */
        .real-wedding-section {
            padding: 40px 0;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            overflow: hidden;
        }

        .real-wedding-title {
            text-align: center;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .wedding-slider {
            display: flex;
            gap: 40px;
            overflow-x: auto;
            padding: 10px 0 30px;
            scrollbar-width: none;
            -ms-overflow-style: none;
            justify-content: center;
        }

        .wedding-slider::-webkit-scrollbar { display: none; }

        .wedding-item {
            text-align: center;
            min-width: 120px;
            transition: transform 0.3s ease;
        }

        .wedding-item:hover { transform: translateY(-5px); }

        .couple-avatar-group {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
        }

        .couple-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid var(--white);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            object-fit: cover;
            position: absolute;
        }

        .avatar-1 { top: 0; left: 0; z-index: 2; }
        .avatar-2 { bottom: 0; right: 0; z-index: 1; border-color: var(--bg-light); }

        .couple-names {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2px;
            white-space: nowrap;
        }

        .wedding-date {
            font-size: 0.7rem;
            color: var(--secondary);
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">MyWeed<span>.</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#templates">Cari Tema</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Harga</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Bantuan</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard.user') }}" class="nav-link">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-pink">Mulai Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-section">
        <div class="container">
            <h1>Desain Undangan Digital Impian Anda</h1>
            <p>Platform undangan digital nomor #1 di Indonesia dengan koleksi tema paling eksklusif, modern, dan mudah digunakan untuk momen spesial Anda.</p>
            
            <form action="{{ route('landing') }}#templates" method="GET">
                <div class="search-container">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" placeholder="Cari gaya undangan... (contoh: Rustic, Modern, Islami)" value="{{ request('search') }}">
                    <button type="submit" class="btn-search">Cari</button>
                </div>
            </form>

            <div class="tag-list">
                <a href="{{ route('landing') }}#templates" class="tag-item {{ !request('category') || request('category') == 'All' ? 'active' : '' }}">Semua</a>
                @foreach($categories as $cat)
                <a href="{{ route('landing', ['category' => $cat['name']]) }}#templates" class="tag-item {{ request('category') == $cat['name'] ? 'active' : '' }}">{{ $cat['name'] }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Real Wedding Social Proof -->
    <section class="real-wedding-section">
        <div class="container">
            <h6 class="real-wedding-title">Telah Dipercaya 10.000+ Pasangan Bahagia</h6>
            <div class="wedding-slider">
                @foreach($invitations as $invitation)
                <a href="{{ route('invitation.detail', ['slug' => $invitation->slug]) }}" class="wedding-item">
                    <div class="couple-avatar-group">
                        <img src="{{ $invitation->foto_pria ? asset('storage/' . $invitation->foto_pria) : 'https://ui-avatars.com/api/?name='.urlencode($invitation->groom_name).'&background=E8B4B8&color=fff' }}" class="couple-avatar avatar-1" alt="">
                        <img src="{{ $invitation->foto_wanita ? asset('storage/' . $invitation->foto_wanita) : 'https://ui-avatars.com/api/?name='.urlencode($invitation->bride_name).'&background=1A1A1A&color=fff' }}" class="couple-avatar avatar-2" alt="">
                    </div>
                    <div class="couple-names">{{ $invitation->groom_nickname ?? $invitation->groom_name }} & {{ $invitation->bride_nickname ?? $invitation->bride_name }}</div>
                    <div class="wedding-date">{{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d M Y') }}</div>
                </a>
                @endforeach
                
                @if($invitations->count() < 5)
                    {{-- Dummy items if not enough real data --}}
                    @for($i = 0; $i < 5 - $invitations->count(); $i++)
                    <div class="wedding-item opacity-50">
                        <div class="couple-avatar-group">
                            <img src="https://i.pravatar.cc/150?u={{ $i }}" class="couple-avatar avatar-1" alt="">
                            <img src="https://i.pravatar.cc/150?u={{ $i+10 }}" class="couple-avatar avatar-2" alt="">
                        </div>
                        <div class="couple-names">Pasangan Baru & Pasangan</div>
                        <div class="wedding-date">Segera Datang</div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- Templates -->
    <section id="templates" class="template-section">
        <div class="container-fluid px-lg-5">
            <div class="template-grid">
                @foreach($templates as $template)
                <div class="template-card">
                    <div class="template-img-container">
                        <img src="{{ $template->thumbnail ? asset('storage/' . $template->thumbnail) : 'https://placehold.co/600x450?text=No+Thumbnail' }}" alt="{{ $template->name }}" loading="lazy">
                        <div class="template-overlay">
                            <a href="{{ route('template.demo', ['slug' => $template->slug]) }}" target="_blank" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">Pratinjau</a>
                            <a href="{{ route('invitation.create', ['template_id' => $template->id]) }}" class="btn btn-pink rounded-pill px-4 fw-bold shadow-sm">Gunakan</a>
                        </div>
                    </div>
                    <div class="template-footer">
                        <div class="user-info">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($template->name) }}&background=random" class="user-avatar" alt="">
                            <span class="user-name">{{ $template->name }}</span>
                            @if($loop->index % 4 == 0)
                                <span class="badge-pro">PREMIUM</span>
                            @endif
                        </div>
                        <div class="card-stats">
                            <span title="Dilihat"><i class="bi bi-eye"></i> {{ number_format($template->views_count) }}</span>
                            <span title="Suka" class="like-btn" data-id="{{ $template->id }}" style="cursor: pointer;">
                                <i class="bi bi-heart-fill text-danger"></i> 
                                <span class="likes-count">{{ number_format($template->likes_count) }}</span>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($templates->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search text-muted display-1 opacity-25"></i>
                    <h3 class="text-muted mt-3">Tema tidak ditemukan</h3>
                    <p>Coba gunakan kata kunci lain atau lihat semua tema.</p>
                    <a href="{{ route('landing') }}" class="btn btn-outline-dark mt-2 rounded-pill px-4">Lihat Semua Tema</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-3">
                    <a href="#" class="footer-logo">MyWeed<span>.</span></a>
                    <p class="text-secondary small">Solusi undangan digital premium untuk pernikahan, khitanan, aqiqah, dan berbagai momen spesial lainnya. Praktis, elegan, dan hemat biaya.</p>
                    <div class="d-flex gap-3 mt-4 text-secondary">
                        <i class="bi bi-instagram fs-5"></i>
                        <i class="bi bi-facebook fs-5"></i>
                        <i class="bi bi-twitter-x fs-5"></i>
                        <i class="bi bi-tiktok fs-5"></i>
                    </div>
                </div>
                <div class="col-6 col-lg-2 offset-lg-1">
                    <ul class="footer-links">
                        <li class="fw-bold text-dark mb-4">Layanan</li>
                        <li><a href="#">Undangan Pernikahan</a></li>
                        <li><a href="#">Undangan Digital</a></li>
                        <li><a href="#">Cetak Undangan</a></li>
                        <li><a href="#">Video Undangan</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <ul class="footer-links">
                        <li class="fw-bold text-dark mb-4">Tema Terpopuler</li>
                        <li><a href="#">Tema Modern</a></li>
                        <li><a href="#">Tema Rustic</a></li>
                        <li><a href="#">Tema Floral</a></li>
                        <li><a href="#">Tema Islami</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <ul class="footer-links">
                        <li class="fw-bold text-dark mb-4">Informasi</li>
                        <li><a href="#">Cara Pemesanan</a></li>
                        <li><a href="#">Pertanyaan (FAQ)</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <ul class="footer-links">
                        <li class="fw-bold text-dark mb-4">Kontak Kami</li>
                        <li><a href="#">Hubungi WhatsApp</a></li>
                        <li><a href="#">Email Support</a></li>
                        <li><a href="#">Alamat Kantor</a></li>
                        <li><a href="#">Kemitraan</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-5 pt-4 border-top text-center text-secondary small">
                <p>&copy; 2026 MyWeed Digital Invitation. Seluruh Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const countSpan = this.querySelector('.likes-count');
                const heartIcon = this.querySelector('i');

                // Simple debounce/anti-spam
                if (this.classList.contains('processing')) return;
                this.classList.add('processing');

                fetch(`/templates/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        countSpan.textContent = data.likes_count.toLocaleString();
                        heartIcon.classList.remove('bi-heart-fill');
                        heartIcon.classList.add('bi-heart');
                        setTimeout(() => {
                            heartIcon.classList.remove('bi-heart');
                            heartIcon.classList.add('bi-heart-fill');
                        }, 200);
                    }
                    this.classList.remove('processing');
                })
                .catch(err => {
                    console.error(err);
                    this.classList.remove('processing');
                });
            });
        });
    </script>
</body>
</html>
