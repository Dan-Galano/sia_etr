<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUnify - {{$orgname}}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PSUnifylogo.png') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orgdash.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .cover-photo {
            height: 300px;
            background: url('{{ asset('cover-photos/' . $coverphoto) }}') no-repeat center center;
            background-size: cover;
            position: relative;
            margin-top: 6rem;
            border-radius: 20px;
        }
    </style>
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
            <ul class="navbar-nav mr-auto">
                <!-- <li class="nav-item active">
                        <div class="text-center"><i class="fas fa-users-cog"></i>
                            &nbsp;Your Managed School Organizations</div>
                    </li> -->
                <!-- <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-calendar-alt"></i> &nbsp;Events</a>
                    </li> -->
                    @if($isMember)
                        <li class="nav-item">
                            <a class="nav-link btn btn-warning" style="color: black; font-weight: bolder;"  href="{{ route('chat.view', ['org_id' => $orgid]) }}" ><i class="fas fa-comments"></i>&nbsp; Chat</a>
                        </li>
                    @endif

            </ul>
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
    <div class="container mt-4">
        <div class="cover-photo">
             <a href="{{ route('organizer-home') }}" class="{{ strtolower($user->type) === 'organizer' ? 'btn btn-warning back-button' : 'btn btn-primary back-button' }}"><i class="fas fa-arrow-left"></i>&nbsp; Back</a>
     


            <div class="org-info">
                <div class="org-name">{{ $orgname}} 
                @php
    $isAdmin = false;
    $userType = null;

    if (Auth::check()) {
        $userId = Auth::id();

        $isAdmin = DB::table('school_organizations')
            ->where('id', $organization->id)
            ->where('admin_id', $userId)
            ->exists();

        $userType = DB::table('users')
            ->where('id', $userId)
            ->value('type');
    }
@endphp

@if (!$isMember && !$isAdmin && $userType === 'member')
    <span id="join-section">
        @php
            $isMember = \App\Models\OrganizationMember::where('organization_id', $orgid->id)
                ->where('member_id', Auth::id())
                ->exists();
        @endphp
        <a href="javascript:void(0);" onclick="toggleJoin({{ $orgid->id }})">
            <button id="join-button" class="btn btn-{{ $isMember ? 'secondary' : 'success' }}">
                {{ $isMember ? 'PENDING' : 'JOIN' }}
            </button>
        </a>
    </span>
@endif

                </div>
                <div class="org-type">{{$orgid->course}}</div>
            </div>
            
        </div>

        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab"
                    aria-controls="posts" aria-selected="true">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="events-tab" data-toggle="tab" href="#events" role="tab" aria-controls="events"
                    aria-selected="false">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about"
                    aria-selected="false">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="photos-tab" data-toggle="tab" href="#photos" role="tab" aria-controls="photos"
                    aria-selected="false">Photos</a>
            </li>
            @php
    $isMember = false;
    if (Auth::check()) {
        $userId = Auth::id();
        $isMember = DB::table('organization_members')
            ->where('organization_id', $organization->id)
            ->where('member_id', $userId)
            ->where('status', 'approved')
            ->exists();

        if (!$isMember) {
            $isAdmin = DB::table('school_organizations')
                ->where('id', $organization->id)
                ->where('admin_id', $userId)
                ->exists();
            $isMember = $isAdmin;
        }
    }
@endphp
            @if($isMember)
            <li class="nav-item">
                <a class="nav-link" id="members-tab" data-toggle="tab" href="#members" role="tab" aria-controls="members"
                    aria-selected="false">Members</a>
            </li>
            @endif

            @php
    $isAdmin = false;
    if (Auth::check()) {
        $userId = Auth::id();
       
            $isAdmin = DB::table('school_organizations')
                ->where('id', $organization->id)
                ->where('admin_id', $userId)
                ->exists();
        
    }
@endphp
            @if($isAdmin)
            <li class="nav-item">
                <a class="nav-link" id="reports-tab" data-toggle="tab" href="#reports" role="tab" aria-controls="reports"
                    aria-selected="false">Reports</a>
            </li>
            @endif
        </ul>





        <div class="tab-content mt-3" id="myTabContent">

        <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
        
<!-- reports table dito -->
<a href="{{ route('export.reports.pdf', $organization->id) }}" class="btn btn-danger mb-3">EXPORT TO PDF</a>
<a href="{{ route('export.reports.csv', $organization->id) }}" class="btn btn-success mb-3">EXPORT TO CSV</a>

        <table id="reportsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reported User's ID</th>
                    <th>Reported User's Name</th>
                    <th>Reporter's ID</th>
                    <th>Reporter's Name</th>
                    <th>Reasons</th>
                    <th>Other</th>
                    <th>Reported on</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                <tr>
                    <td>{{$report->id}}</td>
                <td>{{$report->reportedUser->studentid}}</td>
                <td>{{ $report->reportedUser->firstname }} {{ $report->reportedUser->middlename }} {{ $report->reportedUser->lastname }}</td>
                <td>{{$report->reporter->studentid}}</td>
                <td>{{ $report->reporter->firstname }} {{ $report->reporter->middlename }} {{ $report->reporter->lastname }}</td>
                <td>{{ $report->reasons }}</td>
        <td>{{ $report->other }}</td>
        <td>{{ $report->created_at }}</td>
                </tr>
                
                @endforeach
                
            </tbody>
        </table>
      
    </div>



            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">

                <!-- posts here---------------- -->
@php
    $isAdmin = false;
    $userType = null;

    if (Auth::check()) {
        $userId = Auth::id();

        $isAdmin = DB::table('school_organizations')
            ->where('id', $organization->id)
            ->where('admin_id', $userId)
            ->exists();

        // Retrieve the user type
        $userType = DB::table('users')
            ->where('id', $userId)
            ->value('type');
    }
@endphp
            @if($user->type == "organizer" && $isAdmin)
                <div class="container mt-4">
                    <div class="post-container">
                        <form action="{{ route('posts.store', $orgid) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="post-box">
                                <div class="d-flex align-items-start">
                                    <img src="{{ asset('cover-photos/' . $coverphoto) }}" class="avatar mr-2">
                                    <textarea name="content" class="form-control" rows="3" placeholder="Post new update..." required></textarea>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="taggedOrg_id">Tag Another Organization (Optional):</label>
                                    <select name="taggedOrg_id" id="taggedOrg_id" class="form-control">
                                        <option value="" selected>No Tag</option>
                                        @foreach($organizations as $organizationN)
                                            <option value="{{ $organizationN->id }}">{{ $organizationN->orgname }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="postcreate-actions mt-2 d-flex justify-content-between align-items-center">
                                    <div class="post-icons">
                                        <i class="fas fa-image"></i>
                                        <a href="#" data-toggle="modal" data-target="#addPhotoModal">Add Photos</a>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="privacy-radio mt-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="privacy" id="privateRadio" value="private" checked>
                                                <label class="form-check-label" for="privateRadio">Private</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="privacy" id="publicRadio" value="public">
                                                <label class="form-check-label" for="publicRadio">Public</label>
                                            </div>
                                        </div>
                                            <button type="submit" class="btn btn-primary">Post</button>
                                    </div>
                                </div>
                        </div>

                            <!-- Add Photo Modal -->
                            <div class="modal fade" id="addPhotoModal" tabindex="-1"
                                aria-labelledby="addPhotoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addPhotoModalLabel">Add Photos</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="file" name="photos[]" class="form-control" multiple>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Add this
                                                Photo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
@php
    $isMember = false;
    if (Auth::check()) {
        $userId = Auth::id();
        $isMember = DB::table('organization_members')
            ->where('organization_id', $organization->id)
            ->where('member_id', $userId)
            ->where('status', 'approved')
            ->exists();

        if (!$isMember) {
            $isAdmin = DB::table('school_organizations')
                ->where('id', $organization->id)
                ->where('admin_id', $userId)
                ->exists();
            $isMember = $isAdmin;
        }
    }
@endphp
                <div class="container mt-4">
                    @foreach($organization->posts as $post)
                        @if(Auth::check() && !$isMember && $post->privacy != 'Public')
                            @continue
                        @endif
                        @if($post->type == 'text')
                            <div class="post-container">
                                <div class="post-header d-flex justify-content-between align-items-center">
                                    <div class="post-header">
                                        <img src="{{ asset('cover-photos/' . $organization->coverphoto) }}"
                                            alt="Profile Picture">
                                        <div>
                                            {{-- <div class="page-name">{{ $organization->orgname }}</div> --}}
                                            @php
                                            // Fetch the tagged organization
                                            $taggedOrg = App\Models\SchoolOrganization::find($post->withTag);
                                        @endphp
                                        
                                        @if($post->withTag)
                                            @if($organization->id == $post->organization_id)
                                                <!-- Current organization is the primary organization (ORG A) -->
                                                <div class="page-name">{{ $organization->orgname }} <span>with</span> {{ $taggedOrg->orgname }}</div>

                                            @elseif($organization->id == $post->withTag)
                                                <!-- Current organization is the tagged organization (ORG B) -->
                                                <div class="page-name">{{ $organization->orgname }} with {{ $organization->orgname }}</div>
                                            @endif
                                        @else
                                            <div class="page-name">{{ $organization->orgname }}</div>
                                        @endif
                                            <div class="posted-date">{{ $post->created_at->format('F j, Y, g:i a') }} <span>・{{ $post->privacy }}</span></div>
                                        </div>
                                    </div>
                                    @if($user->type == "organizer")
                                    <div>
                                        <a href="#" class="btn btn-warning edit-post" data-toggle="modal" data-target="#editPostModal"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('post.delete', $post->id) }}" class="btn btn-danger delete-post" onclick="return confirm('Are you sure you want to delete this post?');"><i class="fas fa-trash"></i></a>
                                    </div>
                                    @endif
                                </div>
                                <div class="post-content">
                                    {{ $post->content }}
                                </div>
                                <div class="post-numbers">
                                    <div>{{ $post->reactions_count }} Likes</div>
                                    <div>{{ $post->comments_count }} Comments</div>
                                </div>
                                <div class="post-actions">
                                @php
    $userLiked = $post->reactions->contains('user_id', Auth::id());
@endphp

<form action="{{ route('posts.like', $post->id) }}" method="POST">
    @csrf
    <button type="submit" class="post-action-btn" style="color: {{ $userLiked ? 'blue' : 'black' }}">
        <i class="fas fa-thumbs-up"></i>&nbsp; Like
    </button>
</form>
<form action="{{ route('posts.comments', $post->id) }}" method="GET">
    <button type="submit" class="post-action-btn">
        <i class="fas fa-comment"></i>&nbsp; Comment
    </button>
</form>


                                </div>
                            </div>
                        @elseif($post->type == 'withphoto')
                            <div class="post-container">
                            <div class="post-header d-flex justify-content-between align-items-center">
                                    <div class="post-header">
                                        <img src="{{ asset('cover-photos/' . $organization->coverphoto) }}"
                                            alt="Profile Picture">
                                        <div>
                                            @php
                                            // Fetch the tagged organization
                                            $taggedOrg = App\Models\SchoolOrganization::find($post->withTag);
                                        @endphp
                                        
                                        @if($post->withTag)
                                            @if($organization->id == $post->organization_id)
                                                <!-- Current organization is the primary organization (ORG A) -->
                                                <div class="page-name">{{ $organization->orgname }} <span>with</span> {{ $taggedOrg->orgname }}</div>

                                            @elseif($organization->id == $post->withTag)
                                                <!-- Current organization is the tagged organization (ORG B) -->
                                                <div class="page-name">{{ $organization->orgname }} with {{ $organization->orgname }}</div>
                                            @endif
                                        @else
                                            <div class="page-name">{{ $organization->orgname }}</div>
                                        @endif
                                            <div class="posted-date">{{ $post->created_at->format('F j, Y, g:i a') }} <span>・{{ $post->privacy }}</span></div>
                                            
                                            
                                        </div>
                                    </div>
                                    
                                    @if($user->type == "organizer")
                                    <div>
                                        <a href="#" class="btn btn-warning edit-post" data-toggle="modal" data-target="#editPostModalWithPhoto" data-post-id="{{ $post->id }}" data-post-content="{{ $post->content }}" data-post-photos="{{ $post->photos }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('post.delete', $post->id) }}" class="btn btn-danger delete-post" onclick="return confirm('Are you sure you want to delete this post?');"><i class="fas fa-trash"></i></a>
                                    </div>
                                    @endif
                                </div>
                                <div class="post-content">
                                    {{ $post->content }}
                                </div>
                                <div class="row">
                                    @foreach($post->photos as $photo)
                                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('post-imgs/' . $photo->photo_filename) }}" class="img-fluid mb-4"
                                                alt="Photo" style="object-fit: contain; height: 200px; border-radius: 20px; padding: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="post-numbers">
                                    <div>{{ $post->reactions_count }} Likes</div>
                                    <div>{{ $post->comments_count }} Comments</div>
                                </div>
                                <div class="post-actions">
                                @php
    $userLiked = $post->reactions->contains('user_id', Auth::id());
@endphp

<form action="{{ route('posts.like', $post->id) }}" method="POST">
    @csrf
    <button type="submit" class="post-action-btn" style="color: {{ $userLiked ? 'blue' : 'black' }}">
        <i class="fas fa-thumbs-up"></i>&nbsp; Like
    </button>
</form>
<form action="{{ route('posts.comments', $post->id) }}" method="GET">
    <button type="submit" class="post-action-btn">
        <i class="fas fa-comment"></i>&nbsp; Comment
    </button>
</form>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>


             
            </div>

   <!-- ---------------- -->


            <!--event tabpanel -->
            <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab">
            @if($user->type == "organizer")
                <div class="container mt-4">
                    <div class="post-container">
                        <form action="{{ route('posts.store', $orgid) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="post-box">
                                <div class="d-flex align-items-start">
                                    <img src="{{ asset('cover-photos/' . $coverphoto) }}" class="avatar mr-2">
                                    <div class="col-md-11">
                                        <input type="text" class="form-control" name="event_title" placeholder="Write the event title here..." required><br>
                                    
                                    <textarea name="content" class="form-control" rows="3"
                                        placeholder="Tell us what's all about the event..." required></textarea>
                                    </div>
                                </div>
                                <div class="row mr-2 ml-2">
                                <div class="form-group mt-2 col-md-6">
                                    <label for="event_start_time">Event Start Time</label>
                                    <input type="datetime-local" name="event_start_time" class="form-control" required>
                                </div>
                                <div class="form-group mt-2 col-md-6">
                                    <label for="event_end_time">Event End Time</label>
                                    <input type="datetime-local" name="event_end_time" class="form-control" required>
                                </div>
                                </div>
                               
                                <div class="postcreate-actions mt-2">
                                    {{-- <div class="post-icons">
                                        <i class="fas fa-image"></i>
                                        <a href="#" data-toggle="modal" data-target="#addeventPhotoModal">Add Photos</a>
                                    </div> --}}
                                    <div class="privacy-radio mt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="privacy" id="privateRadio" value="private" checked>
                                            <label class="form-check-label" for="privateRadio">Private</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="privacy" id="publicRadio" value="public">
                                            <label class="form-check-label" for="publicRadio">Public</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Post</button>
                                </div>
                            </div>

                            <!-- Add Photo Modal -->
                            <div class="modal fade" id="addeventPhotoModal" tabindex="-1"
                                aria-labelledby="addeventPhotoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addeventPhotoModalLabel">Add Photos</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="file" name="photos[]" class="form-control" multiple>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Add this
                                                Photo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @php
    $isMember = false;
    if (Auth::check()) {
        $userId = Auth::id();
        $isMember = DB::table('organization_members')
            ->where('organization_id', $organization->id)
            ->where('member_id', $userId)
            ->where('status', 'approved')
            ->exists();

        if (!$isMember) {
            $isAdmin = DB::table('school_organizations')
                ->where('id', $organization->id)
                ->where('admin_id', $userId)
                ->exists();
            $isMember = $isAdmin;
        }
    }
@endphp
                <div class="container mt-4">
                    
                    @foreach($organization->posts as $post)
                    @if(Auth::check() && !$isMember && $post->privacy != 'Public')
                        @continue
                    @endif
                        @if($post->type == 'event')
                        <div class="post-container">
                        <div class="post-header d-flex justify-content-between align-items-center">
                                    <div class="post-header">
                                        <img src="{{ asset('cover-photos/' . $organization->coverphoto) }}"
                                            alt="Profile Picture">
                                        <div>
                                            <div class="page-name">{{ $organization->orgname }}</div>
                                            <div class="posted-date">{{ $post->created_at->format('F j, Y, g:i a') }} <span>・{{ $post->privacy }}</span></div>
                                        </div>
                                    </div>
                                    
                                    @if($user->type == "organizer")
                                    <div>
                                        <a href="#" class="btn btn-warning edit-post" data-toggle="modal" data-target="#editEventModal" data-post-id="{{ $post->id }}">
                                            <i class="fas fa-edit"></i> 
                                        </a>
                                        <a href="{{ route('post.delete', $post->id) }}" class="btn btn-danger delete-post" onclick="return confirm('Are you sure you want to delete this post?');"><i class="fas fa-trash"></i></a>
                                    </div>
                                    @endif
                                </div>
        <div class="post-content  mt-4 mb-4">
            <div class="mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt mr-2 text-primary"></i>Event Name: {{ $post->event_title }}
                </h5>
            </div>
            <div class="mb-3">
                <strong>About:</strong> {{ $post->content }}
            </div>
            <div class="mb-3">
                <strong><i class="fas fa-calendar-day mr-2 text-success"></i>Start Date:</strong> {{
                \Carbon\Carbon::parse($post->event_start_time)->format('F j, Y g:i A') }}
            </div>
            <div>
                <strong><i class="fas fa-calendar-times mr-2 text-danger"></i>End Date:</strong> {{
                \Carbon\Carbon::parse($post->event_end_time)->format('F j, Y g:i A') }}
            </div>
        </div>

        <div class="post-numbers">
            <div>{{ $post->reactions_count }} Likes</div>
            <div>{{ $post->comments_count }} Comments</div>
        </div>
        <div class="post-actions">
        @php
    $userLiked = $post->reactions->contains('user_id', Auth::id());
@endphp

<form action="{{ route('posts.like', $post->id) }}" method="POST">
    @csrf
    <button type="submit" class="post-action-btn" style="color: {{ $userLiked ? 'blue' : 'black' }}">
        <i class="fas fa-thumbs-up"></i>&nbsp; Like
    </button>
</form>
<form action="{{ route('posts.comments', $post->id) }}" method="GET">
    <button type="submit" class="post-action-btn">
        <i class="fas fa-comment"></i>&nbsp; Comment
    </button>
</form>
        </div>
    </div>
                        @elseif($post->type == 'eventwithphoto')
                        <div class="post-container">
                        <div class="post-header d-flex justify-content-between align-items-center">
                                    <div class="post-header">
                                        <img src="{{ asset('cover-photos/' . $organization->coverphoto) }}"
                                            alt="Profile Picture">
                                        <div>
                                            <div class="page-name">{{ $organization->orgname }}</div>
                                            <div class="posted-date">{{ $post->created_at->format('F j, Y, g:i a') }} <span>・{{ $post->privacy }}</span></div>
                                        </div>
                                    </div>
                                    
                                    @if($user->type == "organizer")
                                    <div>
                                      
                                        <a href="#" class="btn btn-warning edit-post" data-toggle="modal" data-target="#editEventWithPhotoModal" data-post-id="{{ $post->id }}">
                                            <i class="fas fa-edit"></i> 
                                        </a>
                                        <a href="{{ route('post.delete', $post->id) }}" class="btn btn-danger delete-post" onclick="return confirm('Are you sure you want to delete this post?');"><i class="fas fa-trash"></i></a>
                                    </div>
                                    @endif
                                </div>
        <div class="post-content  mt-4 mb-4">
            <div class="mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt mr-2 text-primary"></i>Event Name: {{ $post->event_title }}
                </h5>
            </div>
            <div class="mb-3">
                <strong>About:</strong> {{ $post->content }}
            </div>
            <div class="mb-3">
                <strong><i class="fas fa-calendar-day mr-2 text-success"></i>Start Date:</strong> {{
                \Carbon\Carbon::parse($post->event_start_time)->format('F j, Y g:i A') }}
            </div>
            <div>
                <strong><i class="fas fa-calendar-times mr-2 text-danger"></i>End Date:</strong> {{
                \Carbon\Carbon::parse($post->event_end_time)->format('F j, Y g:i A') }}
            </div>
        </div>
        <div class="row">
                                    @foreach($post->photos as $photo)
                                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('post-imgs/' . $photo->photo_filename) }}" class="img-fluid mb-4"
                                                alt="Photo" style="object-fit: contain; height: 200px; border-radius: 20px; padding: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                        </div>
                                    @endforeach
                                </div>

        <div class="post-numbers">
            <div>{{ $post->reactions_count }} Likes</div>
            <div>{{ $post->comments_count }} Comments</div>
        </div>
        <div class="post-actions">
        @php
    $userLiked = $post->reactions->contains('user_id', Auth::id());
@endphp

<form action="{{ route('posts.like', $post->id) }}" method="POST">
    @csrf
    <button type="submit" class="post-action-btn" style="color: {{ $userLiked ? 'blue' : 'black' }}">
        <i class="fas fa-thumbs-up"></i>&nbsp; Like
    </button>
</form>
<form action="{{ route('posts.comments', $post->id) }}" method="GET">
    <button type="submit" class="post-action-btn">
        <i class="fas fa-comment"></i>&nbsp; Comment
    </button>
</form>
        </div>
    </div>
                        @endif
                    @endforeach
                </div>


             
            </div>

            <!-- -------------------- -->





            <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
            <div class="container mt-5">
    <div class="card rounded-lg shadow p-4 mb-4">
        <div class="card-body">
        <ul class="list-unstyled mb-0">
    <li class="mb-2"><i class="fas fa-building mr-2"></i>Name: <b>{{ $organization->orgname }}</b> </li>
    <li class="mb-2"><i class="fas fa-book mr-2"></i>Course: <b>{{ $organization->course }}</b> </li>
    <li class="mb-2"><i class="fas fa-info-circle mr-2"></i>Bio: <b>{{ $organization->bio }}</b> </li>
    <li><i class="fas fa-phone mr-2"></i>

    <a href="tel:{{ $organization->contact }}">{{ $organization->contact }}</a>

    </li>
    <li class="mt-2">
        <i class="fab fa-facebook mr-2"></i>
        <a href="{{ $organization->facebook }}" target="_blank">Facebook</a>
    </li>
    <li class="mt-2">
        <i class="fab fa-instagram mr-2"></i>
        <a href="{{ $organization->instagram }}" target="_blank">Instagram</a>
    </li>
    <li class="mt-2">
        <i class="fab fa-twitter mr-2"></i>
        <a href="{{ $organization->twitter }}" target="_blank">Twitter</a>
    </li>
    <li class="mt-2">
        <i class="fab fa-tiktok mr-2"></i>
        <a href="{{ $organization->tiktok }}" target="_blank">TikTok</a>
    </li>
    <li class="mt-2">
        <i class="fab fa-youtube mr-2"></i>
        <a href="{{ $organization->youtube }}" target="_blank">YouTube</a>
    </li>
</ul>

        </div>
    </div>
</div>
        <br><br>
            </div>
            <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                <div class="row">
                    @foreach($photos as $photo)
                        @if(!$isMember && $photo->privacy != 'Public')
                            @continue
                        @endif
                        <div class="col-md-3 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('post-imgs/' . $photo->photo_filename) }}" class="img-fluid mb-4"
                                alt="Photo" style="object-fit: contain; height: 200px; border-radius: 20px; padding: 10px; background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        </div>
                    @endforeach
                </div>
                <br><br><br>
            </div>
            @if($isMember)
    <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
        <div class="container mt-5">
            @if($user->type == "organizer")                
                <table id="membersTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Student ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                            <tr>
                                <td>
                                    <img src="{{ asset('profile-imgs/' . $member->photo) }}" class="rounded-circle" width="50" height="50" alt="User Photo">
                                </td>
                                <td>{{ $member->studentid }}</td>
                                <td>{{ $member->firstname }} {{ $member->middlename }} {{ $member->lastname }}</td>
                                <td>{{ $member->email }}</td>
                                <td>
                                    <button class="{{ strtolower($member->status) === 'approved' ? 'btn btn-outline-success' : (strtolower($member->status) === 'rejected' ? 'btn btn-outline-danger' : 'btn btn-outline-secondary') }}">{{ $member->status }}</button>
                                </td>
                                <td>
                                    <form action="{{ route('organization.toggleMember', ['id' => $orgid->id, 'member_id' => $member->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-{{ $member->status === 'approved' ? 'danger' : 'success' }}">
                                            <i class="fas fa-toggle-{{ $member->status === 'approved' ? 'off' : 'on' }}"></i>
                                            {{ $member->status === 'approved' ? 'Disable access' : 'Enable access' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <table id="membersTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                            <tr>
                                <td>
                                    <img src="{{ asset('profile-imgs/' . $member->photo) }}" class="rounded-circle" width="50" height="50" alt="User Photo">
                                </td>
                                <td>{{ $member->firstname }} {{ $member->middlename }} {{ $member->lastname }}</td>
                                <td>{{ $member->email }}</td>
                                <td>
                                @if ($member->id != $user->id)
                                
                                <a href="#" class="report-btn" data-toggle="modal" data-target="#reportModal{{ $member->id }}">
        <button class="btn btn-danger">
            <i class="fas fa-flag"></i>
            &nbsp; Report
        </button>
    </a>
    <div class="modal fade" id="reportModal{{ $member->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalTitle">REPORT MEMBER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container-fluid bg-light p-3">
    <div class="row">
        <div class="col">
            <p >You are reporting:</p>
            <p>Full name: <span  class="font-weight-bold">{{ $member->firstname }} {{ $member->middlename }} {{ $member->lastname }}</span> </p>
            <p>Email: <a href="mailto:{{ $member->email }}">{{ $member->email }}</a> </p>
        </div>
    </div>
</div>
            <form action="{{route('reports.store')}}" method="POST">
                @csrf
                <input type="hidden" name="from_organization_id" value="{{$organization->id}}">
                <input type="hidden" name="reported_user_id" value="{{$member->id}}">
                <input type="hidden" name="reporter_id" value="{{ Auth::id() }}">

                <div class="modal-body">
               


    <br>
                    <p>Select one or more reasons why you want to report this user:</p>
                    <div class="form-check">
    <input class="form-check-input" type="checkbox" id="pretending" name="reasons[]" value="Pretending to be someone">
    <label class="form-check-label" for="pretending">Pretending to be someone</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="checkbox" id="fakename" name="reasons[]" value="Fake name">
    <label class="form-check-label" for="fakename">Fake name</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="checkbox" id="fakeaccount" name="reasons[]" value="Fake account">
    <label class="form-check-label" for="fakeaccount">Fake account</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="checkbox" id="inappropriate" name="reasons[]" value="Posting inappropriate things">
    <label class="form-check-label" for="inappropriate">Posting inappropriate things</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="checkbox" id="somethingelse" name="reasons[]" value="Something else">
    <label class="form-check-label" for="somethingelse">Something else</label>
</div>

<br>
                    <div class="form-group">
                        <label for="other">If something else, write here. (Optional)</label>
                        <textarea class="form-control" id="other" name="other"></textarea>
                    </div>

                    <div class="alert alert-primary" role="alert">
        <strong>Note:</strong> This report will be reviewed by the organization and does not mean that it will immediately remove the member from the student organization.
    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
                                @else
                                <small style="font-style: italic;">You</small>
                                @endif
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <br><br><br>
    </div>
@endif

        </div>
       


      @isset($post)
<div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('post.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="d-flex align-items-center ml-4">
        <div class="privacy-radio mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="privacy" id="privateRadio" value="private" checked>
                    <label class="form-check-label" for="privateRadio">Private</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="privacy" id="publicRadio" value="public">
                    <label class="form-check-label" for="publicRadio">Public</label>
                </div>
        </div></div>
        <div class="modal-body">
          <textarea name="content" class="form-control">{{ $post->content }}</textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>



<div class="modal fade" id="editPostModalWithPhoto" tabindex="-1" role="dialog" aria-labelledby="editPostModalWithPhotoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPostModalWithPhotoLabel">Edit Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('post.updateWithPhoto', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="d-flex align-items-center ml-4">
        <div class="privacy-radio mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="privacy" id="privateRadio" value="private" checked>
                    <label class="form-check-label" for="privateRadio">Private</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="privacy" id="publicRadio" value="public">
                    <label class="form-check-label" for="publicRadio">Public</label>
                </div>
        </div></div>
        <div class="modal-body">
          <textarea name="content" class="form-control">{{ $post->content }}</textarea>
          <div class="form-group">
            <label for="photos">Update Photos</label>
            <input type="file" name="photos[]" class="form-control-file" multiple>
          </div>
          <div class="current-photos">
            @foreach($post->photos as $photo)
              <div class="col-md-4">
                <img src="{{ asset('post-imgs/' . $photo->photo_filename) }}" class="img-fluid mb-4" alt="Photo">
              </div>
            @endforeach
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editEventForm" action="{{ route('events.update', $post->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-center ml-4">
        <div class="privacy-radio mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="privacy" id="privateRadio" value="private" checked>
                    <label class="form-check-label" for="privateRadio">Private</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="privacy" id="publicRadio" value="public">
                    <label class="form-check-label" for="publicRadio">Public</label>
                </div>
        </div></div>
                <div class="modal-body">
                <input type="hidden" name="post_id" id="post_id">

                    <div class="form-group">
                        <label for="event_title">Event Title</label>
                        <input type="text" class="form-control" id="event_title" name="event_title" value="{{ $post->event_title }}">
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="3">{{ $post->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d\TH:i', strtotime($post->event_start_time)) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d\TH:i', strtotime($post->event_end_time)) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Edit Event With Photo Modal -->
<div class="modal fade" id="editEventWithPhotoModal" tabindex="-1" role="dialog" aria-labelledby="editEventWithPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventWithPhotoModalLabel">Edit Event with Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editEventWithPhotoForm" action="{{ route('eventwithphoto.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-center ml-4">
        <div class="privacy-radio mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="privacy" id="privateRadio" value="private" checked>
                    <label class="form-check-label" for="privateRadio">Private</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="privacy" id="publicRadio" value="public">
                    <label class="form-check-label" for="publicRadio">Public</label>
                </div>
        </div></div>
                <div class="modal-body">
                    <input type="hidden" name="post_id" id="post_id">
                    <div class="form-group">
                        <label for="event_title">Event Title</label>
                        <input type="text" class="form-control" id="event_title" name="event_title" value="{{ $post->event_title }}">
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="3">{{ $post->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d\TH:i', strtotime($post->event_start_time)) }}">
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d\TH:i', strtotime($post->event_end_time)) }}">
                    </div>
                    <div class="form-group">
                        <label for="photos">Upload Photos</label>
                        <input type="file" class="form-control-file" id="photos" name="photos[]" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


    @endisset

   





    <script>
    var postId; 

    $(document).ready(function() {
        $('.edit-post').on('click', function(e) {
            e.preventDefault();
            postId = $(this).data('post-id'); 
            $('#editPostModal').modal('show'); 
        });

        $('#editPostModal').on('shown.bs.modal', function () {
            
            $.ajax({
                url: '/post/' + postId + '/edit',
                type: 'GET',
                success: function(data) {
                    $('#editPostModal .modal-content').html(data);
                }
            });
        });
    });
</script>



      

<script>
    $(document).ready(function() {
        $('.edit-post').on('click', function(e) {
            e.preventDefault();
            var postId = $(this).data('post-id');
            var postContent = $(this).data('post-content');
            var postPhotos = $(this).data('post-photos');
            
            
            $('#editPostModalWithPhoto form').attr('action', '/post/' + postId + '/updateWithPhoto');
            $('#editPostModalWithPhoto textarea[name="content"]').val(postContent);

            
            $('#editPostModalWithPhoto .current-photos').html('');

            
            $.each(postPhotos, function(index, photo) {
                var photoHtml = '<div class="col-md-4"><img src="/post-imgs/' + photo.photo_filename + '" class="img-fluid mb-4" alt="Photo"></div>';
                $('#editPostModalWithPhoto .current-photos').append(photoHtml);
            });

            $('#editPostModalWithPhoto').modal('show');
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.post-action-btn').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.postId;
            const likeButton = this;

            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.liked) {
                    likeButton.classList.add('liked');
                } else {
                    likeButton.classList.remove('liked');
                }
                likeButton.querySelector('.likes-count').textContent = data.likes_count;
            });
        });
    });
});

</script>


<script>
    function toggleJoin(orgId) {
        fetch(`/organization/${orgId}/toggleJoin`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            let joinButton = document.getElementById('join-button');
            if (data.status === 'joined') {
                joinButton.classList.remove('btn-success');
                joinButton.classList.add('btn-secondary');
                joinButton.textContent = 'PENDING';
            } else {
                joinButton.classList.remove('btn-secondary');
                joinButton.classList.add('btn-success');
                joinButton.textContent = 'JOIN';
            }
        });
    }
</script>

<script>
    $(document).ready(function () {
        $('.report-btn').click(function () {
            var fullname = $(this).data('fullname');
            $('#reportModalTitle').text('REPORT ' + fullname);
        });
    });
</script>


        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#membersTable').DataTable();
        $('#reportsTable').DataTable();
    });
</script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>