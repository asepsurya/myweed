<x-app-layout>

    <div class="card adminuiux-card mt-4 mb-0">
        <div class="card-body">
            <div class="row mb-3">
                        <div class="col align-self-center">
                            <h6 class="fw-medium">Daftar Pengguna</h6>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-link btn-square" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </a>
                        </div>
                    </div>
            <table id="dataTable" class="dataTable table w-100 nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th data-breakpoints="xs sm">User Name</th>
                        <th data-breakpoints="xs sm md">Contact info</th>
                        <th data-breakpoints="xs sm">Role</th>
                        <th class="all">Schedule</th>
                        <th data-breakpoints="xs sm">Status</th>
                        <th class="all">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no =1;
                    @endphp
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $no++ }}</td>

                        <td>
                            <div class="row align-items-center flex-nowrap">
                                <div class="col-auto">
                                    <figure class="avatar avatar-40 mb-0 coverimg rounded-circle">
                                        <img src="{{ asset('tempelate/user_default.jpg') }}" alt="Avatar">
                                    </figure>
                                </div>
                                <div class="col ps-0">
                                    <p class="mb-0 fw-medium">{{ $user->name }}</p>
                                    <p class="text-secondary small">
                                        Registered {{ $user->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td>
                            <p class="mb-0">{{ $user->email }}</p>

                        </td>

                        <td>
                            <span class="badge rounded-pill text-bg-primary">
                                {{ $user->role ?? 'User' }}
                            </span>
                        </td>

                        <td>
                            <p class="mb-0">
                                {{ $user->created_at->format('d M Y') }}
                            </p>
                        </td>

                        <td>
                            <span class="badge rounded-pill text-bg-success">
                                Active
                            </span>
                        </td>

                        <td>
                            <a href="" class="btn btn-square btn-link" data-bs-toggle="tooltip" title="View">
                                <i class="bi bi-eye"></i>
                            </a>

                            <div class="dropdown d-inline-block">
                                <a class="btn btn-link no-caret" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="">
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item theme-red">
                                                Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</x-app-layout>

