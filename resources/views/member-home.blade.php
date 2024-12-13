<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUnify - Joined Organizations</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PSUnifylogo.png') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/memberhome.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white justify-items-center">
        <a class="navbar-brand" href="#"><img src="{{ asset('images/PSUnifylogo.png') }}" alt="Logo" width="50"></a>
        <a class="navbar-brand" href="#"><img src="{{ asset('images/PSUnify.png') }}" alt="Logo" height="30"></a>
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
                <a class="nav-link active" href="#" style="border-bottom: 2px solid #ffaa00a9;color: #ff7b00">Joined Organizations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('member-home-all')}}">All Organizations</a>
            </li>
        </ul>
            <ul class="navbar-nav ml-auto">
               
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if($user)
                            <span style=" margin-right: 10px;">{{ $user->firstname }} </span>
                            @if(Auth::check() && Auth::user()->photo)
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
            Student
        </div>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>




    
    @if($hasMembership)


        <div class="container mt-5">
            <div class="row">
                <!-- <div class="col-lg-4 col-md-6 mb-4">
                    <a href="#" class="card-link" id="createOrgBtn">
                        <div class="card rounded shadow-sm">
                            <div class="card-content">
                                <i class="fas fa-plus" style="font-size:80px;"></i>
                                <h6 class="card-createnew">JOIN A NEW SCHOOL ORGANIZATION</h6>
                            </div>
                        </div>
                    </a>

                </div> -->

                @foreach($organizationsM as $organizationN)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('organization.show', $organizationN->id) }}" class="card-link">
                            <div class="card rounded shadow-sm">
                                <div class="card-img-overlay"></div>
                                <div class="card-content">
                                    <h5 class="card-title">{{ $organizationN->orgname }}</h5>
                                    <p class="card-text">{{ $organizationN->course }}</p>
                                </div>
                                <img src="{{ asset('cover-photos/' . $organizationN->coverphoto) }}" class="card-img-top"
                                    alt="Organization Cover Photo">
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>


        <!-- modal to join new org -->


        <!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Join a New School Organization</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="organizationForm" method="POST" action="{{ route('membership.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <select class="form-control" id="schoolorg" name="schoolorg" required>
                                    <option value="" disabled selected>Select Organization</option>
                                    @foreach($organizationsNotMembers as $organizationsNotMember)
                                        <option value="{{ $organizationsNotMember->id }}">{{ $organizationsNotMember->orgname }}</option>
                                    @endforeach
                                </select>
                                @error('schoolorg')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="alert alert-info" role="alert">
                                <strong>Note:</strong> You need to wait for approval by the school organization admin. Once
                                approved, you'll be able to view the organization's page.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Join</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
        <!-- kapag walang school org dito sa else -->
    @else


        <div class="container mt-5">


            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="#" class="card-link" id="createOrgBtn">
                            <div class="card rounded shadow-sm">
                                <div class="card-content">
                                    <i class="fas fa-plus" style="font-size:80px;"></i>
                                    <h6 class="card-createnew">JOIN A NEW SCHOOL ORGANIZATION</h6>
                                </div>
                            </div>
                        </a>

                        <!-- ditokana -->


                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Join a New School Organization</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="organizationForm" method="POST" action="{{ route('membership.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <select class="form-control" id="schoolorg" name="schoolorg" required>
                                                    <option value="" disabled selected>Select Organization</option>
                                                    @foreach($organizations as $organization)
                                                        <option value="{{ $organization->id }}">{{ $organization->orgname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('schoolorg')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="alert alert-info" role="alert">
                                                <strong>Note:</strong> You need to wait for approval by the school
                                                organization admin. Once approved, you'll be able to view the organization's
                                                page.
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Join</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
    @endif










            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
            <script>
                $(document).ready(function () {
                    $("#createOrgBtn").click(function (e) {
                        e.preventDefault(); 
                        $("#myModal").modal("show");
                    });
                });

                function previewCoverPhoto(event) {
                    var preview = document.getElementById('coverphoto-preview');
                    var file = event.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function () {
                        preview.src = reader.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }

                document.getElementById('coverphoto').addEventListener('change', function () {
                    previewCoverPhoto(event);
                });
            </script>

</body>

</html>