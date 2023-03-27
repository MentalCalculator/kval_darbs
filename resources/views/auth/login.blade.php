<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>

    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        /* Styles for the page container */
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
            background-color: #f1f1f1;
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
            margin-right: 10px;
        }
    </style>

</head>
<body>
<div class="container">
            <h2>Pieslēgšanās</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-Pasts">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Parole">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="text-center">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Pieslēgties') }}
                                </button>
                                <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-danger" href="{{ route('password.request') }}">
                                        {{ __('Aizmirsāt paroli?') }}
                                    </a>
                                </div>
                                @endif -->
                                <br><br>
                                @if (Route::has('register'))
                                    <div class="text-center">
                                    <h2>Neesiet reģistrēts?</h2>
                                    <a href="{{ route('register') }}" class="btn btn-primary">Reģistrēšanās</a>
                                    </div>
                                @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
