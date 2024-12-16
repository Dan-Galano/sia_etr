<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validate</title>

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


    <div class="container mt-5">
        <div class="row">
            @foreach ($organization as $org)
                @php
                    $fileExtension = pathinfo($filename->doc_filename, PATHINFO_EXTENSION);
                @endphp
                <div class="col-md-12 mb-4">
                    <!-- Organization Card -->
                    <div class="card shadow-sm border-light rounded">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h1 class="card-title text-primary">Organization Validation {{ $org->id }}</h1>
                                <button class="btn btn-success validate-btn"
                                    data-org-id="{{ $org->id }}">Validate</button>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <h5 class="card-subtitle text-muted">Name</h5>
                                <p class="card-text">{{ $org->orgname }}</p>
                            </div>
                            <div class="mb-3">
                                <h5 class="card-subtitle text-muted">Course</h5>
                                <p class="card-text">{{ $org->course }}</p>
                            </div>
                            <div class="mb-3">
                                <h5 class="card-subtitle text-muted">Bio</h5>
                                <p class="card-text">{{ $org->bio }}</p>
                            </div>

                            <!-- Document Display -->
                            <div class="mt-4">
                                @if ($fileExtension === 'pdf')
                                    <!-- Display PDF -->
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <embed
                                            src="{{ asset('storage/organization_documents/' . basename($filename->doc_filename)) }}"
                                            type="application/pdf" class="embed-responsive-item">
                                    </div>
                                @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                                    <!-- Display Image -->
                                    <img src="{{ asset('storage/organization_documents/' . basename($filename->doc_filename)) }}"
                                        alt="Uploaded Image" class="img-fluid rounded shadow-sm">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    <script>
        // Handle validate button click
        document.querySelectorAll('.validate-btn').forEach(button => {
            button.addEventListener('click', function() {
                const orgId = this.getAttribute('data-org-id');

                // Show SweetAlert2 confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to approve this organization?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make AJAX request to update the organization status
                        fetch(`/update-status/${orgId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for security
                                },
                                body: JSON.stringify({
                                    status: 'approved'
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Check if update was successful
                                if (data.success) {
                                    Swal.fire(
                                        'Approved!',
                                        'The organization has been approved.',
                                        'success'
                                    ).then(() => {
                                        // Optionally, redirect to a specific route
                                        window.location.href =
                                            '/admin'; // Replace with the actual route
                                    });
                                    // Optionally, reload the page or update the status in the UI
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Something went wrong. Please try again. asdasd',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong. Please try again.',
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
