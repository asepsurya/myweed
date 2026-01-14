<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Wedding Dashboard') }}
            </h2>

            <a href="{{ route('invitation.create') }}" class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                + Buat Undangan
            </a>
        </div>
    </x-slot>

    <div class="container mt-4" id="main-content">
        {{--
        <!-- ALERT -->
        <div class="alert alert-info alert-dismissible fade show">
            <strong>Lengkapi Data!</strong>
            Silakan lengkapi detail undangan agar bisa dibagikan ke tamu.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div> --}}

        <div class="row">

            <!-- Total Undangan -->
            <div class="col-6 col-md-6 col-lg-3">
                <div class="card adminuiux-card mb-4">
                    <div class="card-body">
                        <div class="avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded mb-3">
                            <i class="bi bi-envelope-heart h4"></i>
                        </div>
                        <h4 class="fw-medium">{{ $totalInvitations ?? 3 }}</h4>
                        <p class="text-secondary">Total Undangan</p>
                    </div>
                </div>
            </div>

            <!-- Total Tamu -->
            <div class="col-6 col-md-6 col-lg-3">
                <div class="card adminuiux-card mb-4 theme-teal">
                    <div class="card-body">
                        <div class="avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded mb-3">
                            <i class="bi bi-people h4"></i>
                        </div>
                        <h4 class="fw-medium">{{ $totalGuests ?? 120 }}</h4>
                        <p class="text-secondary">Total Tamu</p>
                    </div>
                </div>
            </div>

            <!-- RSVP Hadir -->
            <div class="col-6 col-md-6 col-lg-3">
                <div class="card adminuiux-card mb-4 theme-orange">
                    <div class="card-body">
                        <div class="avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded mb-3">
                            <i class="bi bi-check-circle h4"></i>
                        </div>
                        <h4 class="fw-medium">{{ $rsvpYes ?? 75 }}</h4>
                        <p class="text-secondary">RSVP Hadir</p>
                    </div>
                </div>
            </div>

            <!-- RSVP Tidak Hadir -->
            <div class="col-6 col-md-6 col-lg-3">
                <div class="card adminuiux-card mb-4 theme-purple">
                    <div class="card-body">
                        <div class="avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded mb-33">
                            <i class="bi bi-x-circle h4"></i>
                        </div>
                        <h4 class="fw-medium">{{ $rsvpNo ?? 20 }}</h4>
                        <p class="text-secondary">Tidak Hadir</p>
                    </div>
                </div>
            </div>
            <!-- LIST UNDANGAN -->
            <div class="col-12 col-lg-8 mb-4">
                <div class="card adminuiux-card">
                    <div class="card-header">
                        <h6>Daftar Undangan</h6>
                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach($invitations as $inv)
                        <li class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <p class="fw-medium mb-1">
                                        {{ $inv->bride_name }} & {{ $inv->groom_name }}
                                    </p>
                                    <p class="text-secondary small">
                                        {{ $inv->wedding_date }}
                                    </p>
                                </div>

                                <div class="col-auto">
                                    <a href="{{ url($inv->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        Preview
                                    </a>
                                </div>

                                <div class="col-auto">
                                    <a href="{{ route('invitation.edit', $inv) }}" class="btn btn-sm btn-outline-success">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- RSVP TRANSACTION -->
            <div class="col-12 col-lg-4 mb-4">
                <div class="card adminuiux-card">
                    <div class="card-header">
                        <h6>Aktivitas RSVP</h6>
                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach($recentRsvps as $rsvp)
                        <li class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <p class="fw-medium mb-1">{{ $rsvp->guest_name }}</p>
                                    <p class="text-secondary small">
                                        {{ $rsvp->invitation->bride_name }} & {{ $rsvp->invitation->groom_name }}
                                    </p>
                                </div>

                                <div class="col-auto">
                                    @if($rsvp->status == 'hadir')
                                    <span class="badge bg-success">Hadir</span>
                                    @else
                                    <span class="badge bg-danger">Tidak Hadir</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
