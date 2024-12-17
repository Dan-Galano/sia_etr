<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUnify - All Organizations</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PSUnifylogo.png') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ auth()->check() && auth()->user()->type === 'organizer' ? route('organization.show', ['id' => optional(auth()->user()->schoolOrganizations()->first())->id]) : route('organizer-home') }}"
                        style="{{ request()->routeIs('organization.show') || request()->routeIs('organizer-home') ? 'border-bottom: 2px solid #ffaa00a9; color: #ff7b00;' : '' }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('organizer-home-all') }}"
                        style="{{ request()->routeIs('organizer-home-all') ? 'border-bottom: 2px solid #ffaa00a9; color: #ff7b00;' : '' }}">
                        All Organizations
                    </a>
                </li>
            </ul>

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
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <i class="fas fa-user"></i> &nbsp;&nbsp; Account Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            style="color: red;"><i class="fas fa-sign-out-alt"></i></i>&nbsp;&nbsp; Sign out</a>
                    </div>
                </li>
            </ul>
        </div>
        <div>
            Organization
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <!-- content dito -->



    <div class="container mt-5">
        <div class="row">


            @foreach ($organizations as $organizationN)
                @if ($organizationN->status == 'approved')
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('organization.show', $organizationN->id) }}" class="card-link">
                            <div class="card rounded shadow-sm">
                                <div class="card-img-overlay"></div>
                                <div class="card-content">
                                    <h5 class="card-title">{{ $organizationN->orgname }}</h5>
                                    <p class="card-text">{{ $organizationN->course }}</p>
                                </div>
                                <img src="{{ asset('cover-photos/' . $organizationN->coverphoto) }}"
                                    class="card-img-top" alt="Organization Cover Photo">
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach

        </div>
    </div>



    <!-- modal to create new org -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New School Organization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="organizationForm" method="POST" action="{{ route('organizations.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="orgname">Organization Name:</label>
                            <input type="text" class="form-control" id="orgname" name="orgname"
                                value="{{ old('orgname') }}" required>
                            @error('orgname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="course">Course:</label>
                            <select class="form-control" id="course" name="course" required>
                                <option value="Bachelor of Arts in English Language">Bachelor of Arts in English
                                    Language</option>
                                <option value="Bachelor of Early Childhood Education">Bachelor of Early
                                    Childhood
                                    Education</option>
                                <option value="Bachelor of Science in Information Technology">Bachelor of
                                    Science in
                                    Information Technology</option>
                                <option value="Bachelor of Science in Mathematics">Bachelor of Science in
                                    Mathematics</option>
                                <option value="Bachelor of Science in Architecture">Bachelor of Science in
                                    Architecture</option>
                                <option value="Bachelor of Science in Civil Engineering">Bachelor of Science in
                                    Civil Engineering</option>
                                <option value="Bachelor of Science in Computer Engineering">Bachelor of Science
                                    in
                                    Computer Engineering</option>
                                <option value="Bachelor of Science in Electrical Engineering">Bachelor of
                                    Science in
                                    Electrical Engineering</option>
                                <option value="Bachelor of Science in Mechanical Engineering">Bachelor of
                                    Science in
                                    Mechanical Engineering</option>
                                <option value="No Specific Program (Open to All)">No Specific Program (Open to
                                    All)
                                </option>
                            </select>
                            @error('course')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio:</label>
                            <textarea class="form-control" id="bio" name="bio" required>{{ old('bio') }}</textarea>
                            @error('bio')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="contact">Contact:</label>
                            <input type="text" class="form-control" id="contact" name="contact"
                                value="{{ old('contact') }}" required>
                            @error('contact')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="coverphoto">Cover Photo:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="coverphoto" name="coverphoto"
                                    accept="image/*" onchange="previewPhoto(event)" required>
                                <label class="custom-file-label" for="coverphoto">Choose Cover Photo</label>
                            </div>
                            <div class="text-center mt-2">
                                <img id="coverphoto-preview" class="img-fluid" src="#"
                                    style="display: none; max-width: 100%; max-height: 300px;">
                            </div>
                            @error('coverphoto')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- kapag walang school org dito sa else -->







    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        $(document).ready(function() {
            $("#createOrgBtn").click(function(e) {
                e.preventDefault();
                $("#myModal").modal("show");
            });
        });

        function previewCoverPhoto(event) {
            var preview = document.getElementById('coverphoto-preview');
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        document.getElementById('coverphoto').addEventListener('change', function() {
            previewCoverPhoto(event);
        });
    </script>

</body>

</html>
