  <!-- standard header -->
    <header class="adminuiux-header">
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">

                <!-- main sidebar toggle -->
                <button class="btn btn-link btn-square sidebar-toggler" type="button" onclick="initSidebar()">
                    <i class="sidebar-svg" data-feather="menu"></i>
                </button>

                <!-- logo -->
                <a class="navbar-brand" href="/">
                    <img data-bs-img="light" src="{{ asset('tempelate/logo_apps.png') }}" alt="">
                    <img data-bs-img="dark" src="{{ asset('tempelate/logo_apps.png') }}" alt="">
                    <div class="">
                        <span class="h4">Weeding <b>Creative</b></span>
                        <p class="company-tagline">Digital Wedding Invitation Solutions</p>
                    </div>
                </a>

                <!-- navigation inline -->
                <div class="collapse navbar-collapse right-in-device justify-content-center" id="header-navbar">
                    @role('admin')
                <ul class="navbar-nav mx-lg-3 mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="{{ route('tempelate.index') }}" :active="request()->routeIs('tempelate.index')">
                                <i class="menu-icon bi bi-palette me-2"></i> Tempelate Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="{{ route('music.index') }}" :active="request()->routeIs('music.index')">
                                <i class="menu-icon bi bi-music-note-beamed me-2"></i>  Music
                            </a>
                        </li>
                    </ul>
                    @endrole

                </div>


                <!-- right icons button -->
                <div class="ms-auto">
                    <!-- global search toggle -->
                    <button class="btn btn-link btn-square btn-icon btn-link-header" type="button" onclick="openSearch()">
                        <i data-feather="search"></i>
                    </button>

                    <!-- dark mode -->
                    <button class="btn btn-link btn-square btnsunmoon btn-link-header" id="btn-layout-modes-dark-page">
                        <i class="sun mx-auto" data-feather="sun"></i>
                        <i class="moon mx-auto" data-feather="moon"></i>
                    </button>

                    <!-- application list dropdown -->
                    <div class="dropdown d-none d-sm-inline-block">
                        <button class="btn btn-link btn-square btn-icon btn-link-header dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i data-feather="grid"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end width-300 pt-0 px-0">
    <div class="bg-theme-1-space rounded py-3 mb-2 dropdown-dontclose text-center">
        <p class="mb-0">Undangan Online</p>
        <p class="opacity-50 small">Kelola undangan dengan cepat</p>
    </div>

    <div class="px-2">
        <div class="row g-0 text-center mb-2">

            <!-- Dashboard -->
            <div class="col-4">
                <a class="dropdown-item square-item" href="dashboard.html">
                    <div class="avatar avatar-40 rounded mb-2">
                        <i class="bi bi-columns-gap fs-4 mx-0"></i>
                    </div>
                    <p class="mb-0">Dashboard</p>
                    <p class="fs-12 opacity-50 mb-2">Ringkasan</p>
                </a>
            </div>

            <!-- Pasangan -->
            <div class="col-4">
                <a class="dropdown-item square-item" href="pasangan.html">
                    <div class="avatar avatar-40 rounded mb-2">
                        <i class="bi bi-heart fs-4 mx-0"></i>
                    </div>
                    <p class="mb-0">Pasangan</p>
                    <p class="fs-12 opacity-50 mb-2">Profil</p>
                </a>
            </div>

            <!-- Acara -->
            <div class="col-4">
                <a class="dropdown-item square-item" href="acara.html">
                    <div class="avatar avatar-40 rounded mb-2">
                        <i class="bi bi-calendar-event fs-4 mx-0"></i>
                    </div>
                    <p class="mb-0">Acara</p>
                    <p class="fs-12 opacity-50 mb-2">Jadwal</p>
                </a>
            </div>

            <!-- Galeri -->
            <div class="col-4">
                <a class="dropdown-item square-item" href="galeri.html">
                    <div class="avatar avatar-40 rounded mb-2">
                        <i class="bi bi-images fs-4 mx-0"></i>
                    </div>
                    <p class="mb-0">Galeri</p>
                    <p class="fs-12 opacity-50 mb-2">Foto</p>
                </a>
            </div>

            <!-- Musik -->
            <div class="col-4">
                <a class="dropdown-item square-item" href="musik.html">
                    <div class="avatar avatar-40 rounded mb-2">
                        <i class="bi bi-music-note-beamed fs-4 mx-0"></i>
                    </div>
                    <p class="mb-0">Musik</p>
                    <p class="fs-12 opacity-50 mb-2">Audio</p>
                </a>
            </div>

            <!-- RSVP -->
            <div class="col-4">
                <a class="dropdown-item square-item" href="rsvp.html">
                    <div class="avatar avatar-40 rounded mb-2">
                        <i class="bi bi-clipboard-check fs-4 mx-0"></i>
                    </div>
                    <p class="mb-0">RSVP</p>
                    <p class="fs-12 opacity-50 mb-2">Tamu</p>
                </a>
            </div>

        </div>
    </div>

    <div class="text-center">
        <a class="btn btn-link text-center" href="pengaturan.html">
            Pengaturan Lengkap
            <i class="bi bi-arrow-right fs-14"></i>
        </a>
    </div>
</div>

                    </div>

                    {{-- <!-- language dropdown -->
                    <div class="dropdown d-none d-sm-inline-block">
                        <button class="btn btn-link btn-square btn-icon btn-link-header dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="bi bi-translate"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item active" data-value="EN">EN - English</a></li>
                            <li><a class="dropdown-item" data-value="FR">FR - French</a></li>
                            <li><a class="dropdown-item" data-value="CH">CH - Chinese</a></li>
                            <li><a class="dropdown-item" data-value="HI">HI - Hindi</a></li>
                        </ul>
                    </div> --}}

                    <!-- notification dropdown -->
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-link btn-square btn-icon btn-link-header dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i data-feather="bell"></i>
                            <span class="position-absolute top-0 end-0 badge rounded-pill bg-danger p-1">
                                <small>9+</small>
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end notification-dd sm-mi-95px">
                            <li>
                                <a class="dropdown-item p-2" href="#">
                                    <div class="row gx-3">
                                        <div class="col-auto">
                                            <figure class="avatar avatar-40 rounded-circle bg-pink">
                                                <i class="bi bi-gift text-white"></i>
                                            </figure>
                                        </div>
                                        <div class="col">
                                            <p class="mb-2 small">Congratulation! Your property <span class="fw-bold">#H10215</span> has reached 1000 views.</p>
                                            <span class="row">
                                                <span class="col"><span class="badge badge-light rounded-pill text-bg-warning small">Directory</span></span>
                                                <span class="col-auto small opacity-75">1:00 am</span>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item p-2" href="#">
                                    <div class="row gx-3">
                                        <div class="col-auto">
                                            <figure class="avatar avatar-40 rounded-circle bg-success">
                                                <i class="bi bi-patch-check text-white"></i>
                                            </figure>
                                        </div>
                                        <div class="col">
                                            <p class="mb-2 small">Your property <span class="fw-bold">#H10215</span> is published and live now.</p>
                                            <span class="row">
                                                <span class="col"><span class="badge badge-light rounded-pill text-bg-primary small">System</span></span>
                                                <span class="col-auto small opacity-75">1:00 am</span>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item p-2" href="#">
                                    <div class="row gx-3">
                                        <div class="col-auto">
                                            <figure class="avatar avatar-40 rounded-circle bg-info">
                                                <i class="bi bi-clipboard-check text-white"></i>
                                            </figure>
                                        </div>
                                        <div class="col">
                                            <p class="mb-2 small">User <span class="fw-bold">Rahana</span> has updated <span class="fw-bold">#H10215</span> property.</p>
                                            <span class="row">
                                                <span class="col"><span class="badge badge-light rounded-pill text-bg-success small">team</span></span>
                                                <span class="col-auto small opacity-75">1:00 am</span>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-item p-2">
                                    <div class="row gx-3">
                                        <div class="col-auto">
                                            <figure class="avatar avatar-40 rounded-circle bg-warning ">
                                                <i class="bi bi-bell text-white"></i>
                                            </figure>
                                        </div>
                                        <div class="col">
                                            <p class="mb-2 small">Your subscription going to expire soon. Please <a href="profile-subscription.html">upgrade</a> to get service interrupt free.</p>
                                            <p class="opacity-75 small">4 days ago</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="text-center">
                                <button class="btn btn-link text-center" onclick="notifcationAll()">
                                    View all <i class="bi bi-arrow-right fs-14"></i>
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- profile dropdown -->
                    <div class="dropdown d-inline-block">
                        <a class="dropdown-toggle btn btn-link btn-square btn-link-header style-none no-caret px-0" id="userprofiledd" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                            <div class="row gx-0 d-inline-flex">
                                <div class="col-auto align-self-center">
                                    <figure class="avatar avatar-28 rounded-circle coverimg align-middle">
                                        <img src="assets/img/modern-ai-image/user-6.jpg" alt="" id="userphotoonboarding2">
                                    </figure>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end width-300 pt-0 px-0 sm-mi-45px" aria-labelledby="userprofiledd">
                            <div class="bg-theme-1-space rounded py-3 mb-2 dropdown-dontclose">
                                <div class="row gx-0">
                                    <div class="col-auto px-3">
                                        <figure class="avatar avatar-50 rounded-circle coverimg align-middle">
                                            <img src="assets/img/modern-ai-image/user-6.jpg" alt="">
                                        </figure>
                                    </div>
                                    <div class="col align-self-center ">
                                        <p class="mb-1"><span>{{ auth()->user()->name }}</span></p>
                                        <p><small class="opacity-50">{{ auth()->user()->email }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2">
                                <div><a class="dropdown-item" href="investment-myprofile.html"><i data-feather="user" class="avatar avatar-18 me-1"></i>Tentang Saya</a>
                                </div>
                                <div>
                                    <a class="dropdown-item" href="investment-dashboard.html">
                                        <div class="row g-0">
                                            <div class="col align-self-center"><i data-feather="layout" class="avatar avatar-18 me-1"></i>
                                                Dashboard Saya
                                            </div>
                                           
                                        </div>
                                    </a>
                                </div>
                             
                                <div>
                                    <a class="dropdown-item" href="investment-mysubscription.html">
                                        <div class="row">
                                            <div class="col"><i data-feather="gift" class="avatar avatar-18 me-1"></i> Subscription</div>
                                            <div class="col-auto">
                                                <p class="small text-success">Upgrade</p>
                                            </div>
                                            <div class="col-auto"><span class="arrow bi bi-chevron-right"></span></div>
                                        </div>
                                    </a>
                                </div>
                                
                                <div>
                                    <a class="dropdown-item" href="investment-settings.html">
                                        <i data-feather="settings" class="avatar avatar-18 me-1"></i> Setelan Akun
                                    </a>
                                </div>
                                <div>

                                   <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                        @csrf
                                    </form>

                                    <a href="#"
                                    class="dropdown-item theme-red"
                                    onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                        <i data-feather="power" class="avatar avatar-18 me-1"></i> Keluar
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        feather.replace()
                    </script>
                    <!-- navigation inline toggler for small screen-->
                    <button class="navbar-toggler btn btn-link btn-link-header btn-square btn-icon collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#header-navbar" aria-controls="header-navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <i data-feather="more-vertical" class="openbtn"></i>
                        <i data-feather="x" class="closebtn"></i>
                    </button>
                </div>
            </div>
        </nav>

        <!-- search global wrap -->
        <div class="adminuiux-search-full">
            <div class="row gx-2 align-items-center">
                <div class="col-auto">
                    <!-- close global search toggle -->
                    <button class="btn btn-link btn-square " type="button" onclick="closeSearch()">
                        <i data-feather="arrow-left"></i>
                    </button>
                </div>
                <div class="col">
                    <input class="form-control pe-0 border-0" type="search" placeholder="Type something here...">
                </div>
                <div class="col-auto">

                    <!-- filter dropdown -->
                    <div class="dropdown input-group-text border-0 p-0">
                        <button class="dropdown-toggle btn btn-link btn-square no-caret" type="button" id="searchfilter2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i data-feather="sliders"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end dropdown-dontclose width-300">
                            <ul class="nav adminuiux-nav" id="searchtab2" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="searchall-tab2" data-bs-toggle="tab" data-bs-target="#searchall2" type="button" role="tab" aria-controls="searchall2" aria-selected="true">All</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="searchorders-tab2" data-bs-toggle="tab" data-bs-target="#searchorders2" type="button" role="tab" aria-controls="searchorders2" aria-selected="false" tabindex="-1">Orders</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="searchcontacts-tab2" data-bs-toggle="tab" data-bs-target="#searchcontacts2" type="button" role="tab" aria-controls="searchcontacts2" aria-selected="false" tabindex="-1">Contacts</button>
                                </li>
                            </ul>
                            <div class="tab-content py-3" id="searchtabContent">
                                <div class="tab-pane fade active show" id="searchall2" role="tabpanel" aria-labelledby="searchall-tab2">
                                    <ul class="list-group adminuiux-list-group list-group-flush bg-none show">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Search apps</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch1">
                                                        <label class="form-check-label" for="searchswitch1"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Include Pages</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch2" checked="">
                                                        <label class="form-check-label" for="searchswitch2"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Internet resource</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch3" checked="">
                                                        <label class="form-check-label" for="searchswitch3"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">News and Blogs</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch4">
                                                        <label class="form-check-label" for="searchswitch4"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="searchorders2" role="tabpanel" aria-labelledby="searchorders-tab2">
                                    <ul class="list-group adminuiux-list-group list-group-flush bg-none show">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Show order ID</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch5">
                                                        <label class="form-check-label" for="searchswitch5"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">International Order</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch6" checked="">
                                                        <label class="form-check-label" for="searchswitch6"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Taxable Product</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch7" checked="">
                                                        <label class="form-check-label" for="searchswitch7"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Published Product</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch8">
                                                        <label class="form-check-label" for="searchswitch8"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="searchcontacts2" role="tabpanel" aria-labelledby="searchcontacts-tab2">
                                    <ul class="list-group adminuiux-list-group list-group-flush bg-none show">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Have email ID</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch9">
                                                        <label class="form-check-label" for="searchswitch9"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Have phone number</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch10" checked="">
                                                        <label class="form-check-label" for="searchswitch10"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Photo available</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch11" checked="">
                                                        <label class="form-check-label" for="searchswitch11"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Referral</div>
                                                <div class="col-auto">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="searchswitch12">
                                                        <label class="form-check-label" for="searchswitch12"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col"><button class="btn btn-link">Reset</button></div>
                                    <div class="col-auto">
                                        <button class="btn btn-theme">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
