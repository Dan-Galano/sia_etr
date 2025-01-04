<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PSUnifylogo.png') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orgdash.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white justify-items-center">
        <a class="navbar-brand" href="#"><img src="{{ asset('images/PSUnifylogo.png') }}" alt="Logo"
                width="50"></a>
        <a class="navbar-brand" href="#"><img src="{{ asset('images/PSUnify.png') }}" alt="Logo"
                height="30"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @php
                $user = session('user');
            @endphp
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if ($user)
                            <span style=" margin-right: 10px;">{{ $user->firstname }} </span>
                            @if (Auth::check() && Auth::user()->photo)
                                <img src="{{ asset('profile-imgs/' . Auth::user()->photo) }}" alt="Profile Picture"
                                    class="rounded-circle" style="width: 30px; height: 30px;">
                            @else
                                <img src="{{ asset('profile-imgs/defaultpfp.png') }}" alt="Profile Picture"
                                    class="rounded-circle" style="width: 30px; height: 30px;">
                            @endif
                        @else
                            User not logged in
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            style="color: red;"><i class="fas fa-sign-out-alt"></i></i>&nbsp;&nbsp; Sign out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="container mt-5">
        <h1>Organization List</h1>
        <br><br>

        <!-- Tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ $tab === 'not-validated' ? 'active' : '' }}"
                    href="{{ route('organizations.not-validated') }}">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab === 'validated' ? 'active' : '' }}"
                    href="{{ route('organizations.validated') }}">Validated</a>
            </li>
        </ul>


        <!-- Tab Content -->
        <div class="tab-content" id="organization-tabs-content">
            @if ($tab === 'not-validated')
                <div class="tab-pane fade show active" id="not-validated" role="tabpanel"
                    aria-labelledby="not-validated-tab">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Organization Name</th>
                                <th scope="col">Program</th>
                                <th scope="col">Bio</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($organizations as $organization)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <img src="{{ asset('cover-photos/' . $organization->coverphoto) }}"
                                            alt="Cover Photo"
                                            style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                    </td>
                                    <td>{{ $organization->orgname }}</td>
                                    <td>{{ $organization->course }}</td>
                                    <td>{{ $organization->bio }}</td>
                                    <td>{{ $organization->contact }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('organizations.validation', ['orgId' => $organization->id]) }}"
                                            class="btn btn-primary mr-2">Validate</a>
                                        <button class="btn btn-danger delete-btn ms-2"
                                            data-id="{{ $organization->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No not validated organizations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="tab-pane fade show active" id="validated" role="tabpanel"
                    aria-labelledby="validated-tab">
                    <div style="display: flex; justify-content: flex-end;">
                        <button type="button" class="btn btn-danger" id="setAllReaccredButton">Disable all</button>
                    </div>



                    <table class="table table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Organization Name</th>
                                <th scope="col">Program</th>
                                <th scope="col">Bio</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($organizations as $organization)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <img src="{{ asset('cover-photos/' . $organization->coverphoto) }}"
                                            alt="Cover Photo"
                                            style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                    </td>
                                    <td>{{ $organization->orgname }}</td>
                                    <td>{{ $organization->course }}</td>
                                    <td>{{ $organization->bio }}</td>
                                    <td>{{ $organization->contact }}</td>
                                    <td class="d-flex gap-2">
                                        <!-- <button class="btn btn-danger delete-btn ms-2"
                                            data-id="{{ $organization->id }}">
                                            Delete
                                        </button> -->
                                        <form
                                            action="{{ route('admin.toggleOrganization', ['organization_id' => $organization->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="btn btn-{{ $organization->status === 'approved' ? 'success' : 'dark' }}">
                                                <i
                                                    class="fas fa-toggle-{{ $organization->status === 'approved' ? 'off' : 'on' }}"></i>
                                                {{ $organization->status === 'approved' ? 'Active' : 'Disabled' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No validated organizations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>


        <script>
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const orgId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/delete-organization/${orgId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            'Deleted!',
                                            data.message,
                                            'success'
                                        ).then(() => {
                                            // Reload or redirect after deletion
                                            window.location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            data.message,
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    Swal.fire(
                                        'Error!',
                                        'An unexpected error occurred.',
                                        'error'
                                    );
                                    console.error('Error:', error);
                                });
                        }
                    });
                });
            });

            // DISABLING ALL ORG
            document.getElementById('setAllReaccredButton').addEventListener('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will set all organizations to 'reaccred'.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, set all!',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form if confirmed
                        const form = document.createElement('form');
                        form.action = "{{ route('organization.setAllReaccred') }}";
                        form.method = 'POST';
                        form.innerHTML = '@csrf';
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });

        </script>


        <!-- Not Validated Tab -->
        {{-- <div class="tab-pane fade" id="not-validated" role="tabpanel" aria-labelledby="not-validated-tab">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> --}}


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
