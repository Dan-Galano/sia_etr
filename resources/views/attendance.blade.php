<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance</title>
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
                            <span style="margin-right: 10px;">{{ $user->firstname }}</span>
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
                            <i class="fas fa-user"></i>&nbsp;&nbsp; Account Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            style="color: red;"><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp; Sign out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mt-3">
            <h1 class="mb-0">{{ $post->event_title }}</h1>
            <a href="{{ route('delete.event', ['org_id' => $orgId, 'event_id' => $post->id]) }}"
                class="btn btn-danger">Close Event</a>
        </div>
        <br>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="attendance-tab" href="#"
                    onclick="showContent('attendance')">Attendance</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="attendees-tab" href="#" onclick="showContent('attendees')">List of
                    Attendee</a>
            </li>
        </ul>

        <!-- Attendance Content -->
        <div id="attendance" class="content-tab mt-4">
            @if (session('success'))
                <div class="alert alert-success mt-4 text-center">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger mt-4 text-center">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('attendance.store', ['org_id' => $orgId, 'event_id' => $post->id]) }}"
                method="POST">
                @csrf
                <div class="form-group row justify-content-center mt-5">
                    <label for="studentId" class="col-sm-12 col-form-label text-center"
                        style="font-size: 2rem; font-weight: bold;">Student ID</label>
                    <div class="col-sm-8 mt-3">
                        <input type="text" id="studentId" name="studentId"
                            class="form-control border border-3 rounded-3 p-3" style="font-size: 1.5rem;"
                            placeholder="Ex. 21-UR-0001">
                    </div>
                    <div class="col-sm-8 mt-5 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary"
                            style="font-weight: bold; font-size: 20px;">Check In</button>
                    </div>
                </div>
            </form>
            <br><br>
            @if (session('totalAttendance'))
                <h3 class="text-right mt-4">Total Attendance: {{ session('totalAttendance') }}</h3>
            @endif
        </div>

        <!-- List of Attendees Content -->
        <div id="attendees" class="content-tab mt-4" style="display: none;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Logged at</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendees as $attendee)
                        <tr>
                            <td>{{ $attendee->student->studentid }}</td>
                            <td>{{ $attendee->student->firstname }}</td>
                            <td>{{ $attendee->student->middlename }}</td>
                            <td>{{ $attendee->student->lastname }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($attendee->student->created_at)->format('g:i a') }}
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No attendees logged in yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showContent(tab) {
            document.querySelectorAll('.content-tab').forEach(tabContent => tabContent.style.display = 'none');
            document.getElementById(tab).style.display = 'block';

            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            document.getElementById(`${tab}-tab`).classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            showContent('attendance');
        });
    </script>
</body>

</html>
