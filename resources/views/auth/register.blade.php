<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>

    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="css/register.css" type="text/css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Retrieve the user's time zone
            var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

            // Set the value of the hidden input field
            $('#timezone').val(userTimeZone);
        });
    </script>
</head>
<body>
<div class="container">
    <h2>Registration</h2>
    <form method="POST" autocomplete="on" action="{{ secure_url(route('register')) }}">
        @csrf
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" min="4" max="20" required placeholder="Username">
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" min="6" max="30" required placeholder="E-Mail">
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" min="8" max="20" placeholder="Password">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <input type="hidden" id="timezone" name="timezone">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" min="8" max="20" placeholder="Repeat Password">
        <div class="text-center">
            <button type="submit" class="btn btn-success">
                {{ __('Register') }}
            </button>
        </div>
        <br><br>
        @if (Route::has('login'))
            <div class="text-center">
                <h2>Are you registered?</h2>
                <a href="{{ route('login') }}" class="btn btn-primary text-center" style="align-self: center">Login</a>
            </div>
        @endif
    </form>
</div>
</body>
