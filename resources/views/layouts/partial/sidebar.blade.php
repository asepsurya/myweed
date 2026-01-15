    <div class="adminuiux-sidebar">
        <div class="adminuiux-sidebar-inner">
            <!-- Profile -->
            <div class="px-3 not-iconic mt-3">
                <div class="row">
                    <div class="col align-self-center ">
                        <h6 class="fw-medium">Main Menu</h6>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-link btn-square" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile" aria-expanded="false" role="button" aria-controls="usersidebarprofile">
                            <i data-feather="user"></i>
                        </a>
                    </div>
                </div>
                <div class="text-center collapse " id="usersidebarprofile">
                    <figure class="avatar avatar-100 rounded-circle coverimg my-3">
                        <img src="{{ asset('tempelate/logo_apps.png') }}" alt="">
                    </figure>
                    <h5 class="mb-1 fw-medium">Weeding Creative</h5>
                    <p class="small">The Investment UI Kit</p>
                </div>
            </div>

            <ul class="nav flex-column menu-active-line">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard')  }}" class="nav-link"  :active="request()->routeIs('dashboard')">
                        <i class="menu-icon bi bi-columns-gap"></i>
                        <span class="menu-name">Dashboard</span>
                    </a>
                </li>

                <!-- Data Pasangan -->
                <li class="nav-item">
                    <a href="{{ route('invitation.index') }}" class="nav-link " :active="request()->routeIs('invitation.index*')">
                        <i class="menu-icon bi bi-heart"></i>
                        <span class="menu-name">Data Pasangan</span>
                    </a>
                </li>

                <!-- Detail Acara -->
                <li class="nav-item">
                    <a href="acara.html" class="nav-link">
                        <i class="menu-icon bi bi-calendar-event"></i>
                        <span class="menu-name">Detail Acara</span>
                    </a>
                </li>

                <!-- Galeri -->
                <li class="nav-item">
                    <a href="galeri.html" class="nav-link">
                        <i class="menu-icon bi bi-images"></i>
                        <span class="menu-name">Galeri Foto</span>
                    </a>
                </li>

                <!-- Musik -->
                <li class="nav-item">
                    <a href="{{ route('music.index') }}" class="nav-link" :active="request()->routeIs('music.index')">
                        <i class="menu-icon bi bi-music-note-beamed"></i>
                        <span class="menu-name">Musik Undangan</span>
                    </a>
                </li>

                <!-- Lokasi -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="menu-icon bi bi-geo-alt"></i>
                        <span class="menu-name">Lokasi Acara</span>
                    </a>
                </li>

                <!-- RSVP -->
                <li class="nav-item">
                    <a href="rsvp.html" class="nav-link">
                        <i class="menu-icon bi bi-clipboard-check"></i>
                        <span class="menu-name">RSVP Tamu</span>
                    </a>
                </li>

                <!-- Ucapan -->
                <li class="nav-item">
                    <a href="{{ route('rsvp.index') }}" class="nav-link" :active="request()->routeIs('rsvp.index')">
                        <i class="menu-icon bi bi-chat-dots"></i>
                        <span class="menu-name">Ucapan & Doa</span>
                    </a>
                </li>

                <!-- Hadiah -->
                <li class="nav-item">
                    <a href="hadiah.html" class="nav-link">
                        <i class="menu-icon bi bi-gift"></i>
                        <span class="menu-name">Hadiah Digital</span>
                    </a>
                </li>

                <!-- Tema -->
                <li class="nav-item">
                    <a href="{{ route('tempelate.index') }}" class="nav-link" :active="request()->routeIs('tempelate.index')">
                        <i class="menu-icon bi bi-palette"></i>
                        <span class="menu-name">Tema & Tampilan</span>
                    </a>
                </li>

                <!-- Pengaturan -->
                <li class="nav-item">
                    <a href="pengaturan.html" class="nav-link">
                        <i class="menu-icon bi bi-gear"></i>
                        <span class="menu-name">Pengaturan</span>
                    </a>
                </li>

            </ul>

            <div class=" mt-auto "></div>
            {{-- <!-- quick links -->
            <div class="px-3 mb-3 not-iconic">
                <h6 class="mb-3 fw-medium">Quick Links</h6>
                <div class="card adminuiux-card">
                    <div class="card-body p-2">
                        <div class="row gx-2">
                            <div class="col-12 d-flex justify-content-between">
                                <a href="investment-search-mutual-funds.html" class="btn btn-square btn-link theme-red">
                                    <span class="position-relative">
                                        <i data-feather="heart"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success rounded-circle">
                                            <span class="visually-hidden">New alerts</span>
                                        </span>
                                    </span>
                                </a>
                                <a href="investment-schedule.html" class="btn btn-square btn-link">
                                    <span class="position-relative">
                                        <i data-feather="calendar"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning rounded-circle">
                                            <span class="visually-hidden">New alerts</span>
                                        </span>
                                    </span>
                                </a>
                                <a href="investment-inbox.html" class="btn btn-square btn-link">
                                    <i data-feather="inbox"></i>
                                </a>
                                <a href="investment-help-center.html" class="btn btn-square btn-link">
                                    <i data-feather="help-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- User account -->
            <ul class="nav flex-column menu-active-line">
                <!-- bottom sidebar menu -->
                <li class="nav-item">
                    <a href="investment-referral.html" class="nav-link">
                        <i class="menu-icon" data-feather="users"></i>
                        <span class="menu-name">Akun Saya</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="investment-settings.html" class="nav-link">
                        <i class="menu-icon" data-feather="settings"></i>
                        <span class="menu-name">Setelan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
