<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUnify Chat - {{$organization->orgname}}</title>
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
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <!-- content ditooo -->

    <div class="container mt-5">
        <div class="row">

            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                       
                                <a href="javascript:history.back()" class="btn btn-warning"><i
                                        class="fas fa-arrow-left"></i>&nbsp; Back</a> <h6>{{ $organization->orgname }}</h>
                          
                    </div>
                    <div class="card-body">
                        <div class="message-wrapper">
                            @foreach($chats as $chat)
                                @if($chat->user_id === Auth::id())
                                    <div class="message user">
                                        <div class="message-content">
                                            <p class="message-text">{{ $chat->message }}</p>
                                            <span class="message-time">{{ $chat->created_at->format('d M Y h:i A') }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="message other-user">
                                        <img src="{{ asset('profile-imgs/' . $chat->user->photo) }}" alt="Profile Picture"
                                            class="profile-picture">
                                        <div class="message-content">
                                            <small class="text-muted">{{ $chat->user->firstname }}
                                                {{ $chat->user->lastname }}

                                                @if($chat->user->type == "organizer")
                                                    &#x2022; <span style="font-size: smaller; color: #0961E4;"> Admin</span>
                                                @endif

                                            </small>
                                            <p class="message-text">{{ $chat->message }}</p>
                                         <span class="message-time">{{ $chat->created_at->format('d M Y h:i A') }}</span>
                                        </div>
                                    </div>

                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('chat.send', ['org_id' => $organization->id]) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="message" class="form-control"
                                    placeholder="Type your message..." required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        
        window.addEventListener("load", function () {
            
            var messageWrapper = document.querySelector(".message-wrapper");
            
            messageWrapper.scrollTop = messageWrapper.scrollHeight;
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>