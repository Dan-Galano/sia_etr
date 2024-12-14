<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUnify - Sign Up</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PSUnifylogo.png') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    <style>
        body {
            background-image: url('{{ asset('images/bgcover.png') }}');
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="signup-container">
    <form method="POST" action="{{ route('signup') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group text-center">
        <a href="{{route('landing')}}"><img src="{{ asset('images/psunifylogotext.png') }}" alt="Logo" height="80"></a> 
            <h3>Sign Up</h3>
        </div>
        <div class="form-group">
            <label for="type">Register as:</label>
            <select class="form-control" id="type" name="type" required onchange="updateLabel()">
                <option value="member" selected>Student</option>
                <option value="organizer">Organization</option>
            </select>
        </div>
        <div class="form-group">
            <label for="studentid" id="studentid-label">Student ID</label>
            <input type="text" class="form-control" id="studentid" name="studentid" value="{{ old('studentid') }}">
            @error('studentid')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="row">
            <div class="form-group col-4">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') }}" required>
                @error('firstname')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-4">
                <label for="middlename">Middle Name</label>
                <input type="text" class="form-control" id="middlename" name="middlename" value="{{ old('middlename') }}">
                @error('middlename')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-4">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                @error('lastname')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="photo">Profile Photo</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*" onchange="previewPhoto(event)">
                <label class="custom-file-label" for="photo">Choose Photo</label>
            </div>
            <div class="text-center">
                <img id="photo-preview" class="img ml-2 rounded-circle mx-auto" src="#" style="display: none; width: 200px; height: 200px; margin: 20px;">
            </div>
            @error('photo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
        </div>
        <div class="form-group text-center">
            <p>Already have an account? <a href="{{ route('signin') }}">Sign In</a></p>
        </div>
    </form>
    </div>

    <script>
        function updateLabel() {
            var userType = document.getElementById('type').value;
            var label = document.getElementById('studentid-label');
            label.textContent = userType === 'member' ? 'Student ID' : 'Student ID/Instructor ID';
        }

        function previewPhoto(event) {
            var preview = document.getElementById('photo-preview');
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>