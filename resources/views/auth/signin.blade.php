<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUnify - Sign In</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PSUnifylogo.png') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
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
    <div class="signin-container">
        <form method="POST" action="{{ route('signin') }}">
            @csrf
            <div class="form-group text-center">
               <a href="{{route('landing')}}"><img src="{{ asset('images/psunifylogotext.png') }}" alt="Logo" height="80"></a> 
                <h3>Sign In</h3>
            </div>
            @if($errors->has('message'))
    <div class="alert alert-danger">{{ $errors->first('message') }}</div>
@endif

            <div class="form-group">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email Address">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div> 
            <div class="form-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <div class="form-group text-center">
                <p>Don't have an account? <a href="{{ route('signup') }}">Sign Up</a></p>
            </div>
        </form>
    </div>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif
</body>
</html>
