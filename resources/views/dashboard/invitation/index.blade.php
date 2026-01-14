<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Aktivitas Undangan') }}
            </h2>

            <a href="{{ route('invitation.create') }}"
               class="btn-sm inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                + Buat Undangan
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="card adminuiux-card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6>Aktivitas Undangan Terbaru</h6>
                        </div>
                        <div class="col-auto px-0">
                            <a href="{{ route('invitation.index') }}" class="btn btn-sm btn-link">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('invitation.create') }}"
                               class="btn btn-sm btn-outline-theme">
                                <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- List Aktivitas -->
                <ul class="list-group list-group-flush border-top bg-none">

                    @foreach($invitations as $inv)
                        <li class="list-group-item">
                            <div class="row gx-3 align-items-center">

                                <div class="col">
                                    <p class="mb-1 fw-medium">
                                        {{ $inv->bride_name }} & {{ $inv->groom_name }}
                                    </p>
                                    <p class="text-secondary small">
                                        Tanggal Nikah: {{ $inv->wedding_date }}
                                    </p>
                                </div>

                                <div class="col-auto text-end">
                                    <h6 class="text-success">
                                        {{ $inv->guests_count ?? 0 }} Tamu
                                    </h6>
                                    <div class="badge badge-sm text-bg-primary">
                                        Aktif
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <a href="{{ route('invitation.edit', $inv) }}"
                                       class="avatar avatar-40 rounded-circle border border-theme-1 bg-theme-1-subtle text-theme-1 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-pencil h5"></i>
                                    </a>
                                </div>

                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</x-app-layout>
