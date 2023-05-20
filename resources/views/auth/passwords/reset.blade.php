<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            background-color: #2d3748;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            width: 400px;
            height: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            display: flex;
            text-align: center;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container input[type="text"],
        .container input[type="email"],
        .container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            background-color: rgb(194, 194, 194);
        }

        .container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #2196F3;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        button {
            display: inline-block;

        }
    </style>

</head>
<body>
<div class="container">
    <h2>Create New Password</h2>
    <br>
    <form method="POST" autocomplete="off" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input class="form-control" value="{{ $email ?? old('email') }}" readonly placeholder="Your E-Mail">
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <br>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="New password">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm password">
        <br>
        <button type="submit" class="btn btn-primary">
            {{ __('Reset Password') }}
        </button>
    </form>
</div>
</body>
