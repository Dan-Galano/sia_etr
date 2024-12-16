<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUnify - </title>
    <link rel="icon" type="image/png" href="{{ asset('images/PSUnifylogo.png') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orgdash.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
                        <a class="dropdown-item" href="#"><i class="fas fa-user"></i> &nbsp;&nbsp; Account Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            style="color: red;"><i class="fas fa-sign-out-alt"></i></i>&nbsp;&nbsp; Sign out</a>
                    </div>
                </li>
            </ul>
        </div>
        <div>
        @if(Auth::check() && Auth::user()->type === 'member')
            Student
        @else
            Organization
        @endif
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>







    <div class="container" style="margin-top: 120px;">
    @if(Auth::check() && Auth::user()->type === 'member')
        <a href="{{ route('member-home-all') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i>&nbsp; Back</a>
    @else
    <a href="{{ route('organizer-home-all') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i>&nbsp; Back</a>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('Edit Profile') }}</h2>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('profile.update', ['id' => $user->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

                            <div class="form-group row">
                                <label for="profile_photo"
                                    class="col-md-4 col-form-label text-md-right"></label>
                                <div class="col-md-6">
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('profile-imgs/' . $user->photo) }}"
                                            class="rounded-circle avatar" id="preview"
                                            style="width: 150px; height: 150px;" alt="Current Profile Picture"
                                            accept="image/*">
                                    </div>
                                    <input type="file"
                                        class="form-control-file @error('profile_photo') is-invalid @enderror"
                                        id="profile_photo" name="profile_photo">
                                    @error('profile_photo')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstname"
                                    class="col-md-4 col-form-label text-md-right">  @if(Auth::check() && Auth::user()->type === 'member') {{ __('First Name') }} @else {{ __("Organization's Name") }}  @endif</label>
                                <div class="col-md-6">
                                    <input id="firstname" type="text"
                                        class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                        value="{{ old('firstname', $user->firstname) }}" required
                                        autocomplete="firstname" autofocus>
                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <br> <br>
                                @if(Auth::check() && Auth::user()->type === 'member') 
                                <label for="middlename"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>
                                <div class="col-md-6">
                                    <input id="middlename" type="text"
                                        class="form-control @error('middlename') is-invalid @enderror" name="middlename"
                                        value="{{ old('middlename', $user->middlename) }}"
                                        autocomplete="middlename" autofocus>
                                    @error('middlename')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <br> <br>
                          
                                <label for="lastname"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                                <div class="col-md-6">
                                    <input id="lastname" type="text"
                                        class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                        value="{{ old('lastname', $user->lastname) }}" required autocomplete="lastname"
                                        autofocus>
                                    @error('lastname')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <br> <br>
                                <label for="studentid"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ID No.') }}</label>
                                <div class="col-md-6">
                                    <input id="studentid" type="text"
                                        class="form-control @error('studentid') is-invalid @enderror" name="studentid"
                                        value="{{ old('studentid', $user->studentid) }}" required
                                        autocomplete="studentid" autofocus>
                                    @error('studentid')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <br> <br>
                                @endif
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="text"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $user->email) }}" required autocomplete="email"
                                        autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary col-md-12">{{ __('Update Profile') }}</button>
                                </div>
                            </div>
                        </form>
<br>
                        <hr>
<br>
                       
                        <form method="POST" action="{{ route('profile.updatePassword') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="old-password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Old Password') }}</label>
                                <div class="col-md-6">
                                    <input id="old-password" type="password"
                                        class="form-control @error('old_password') is-invalid @enderror"
                                        name="old_password" required autocomplete="current-password">
                                    @error('old_password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary col-md-12">{{ __('Update Password') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>