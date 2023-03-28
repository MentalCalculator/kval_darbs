<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>

    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="css/LogZone.css" type="text/css" rel="stylesheet">

</head>
<body>
<div class="container">
                <h2>Reģistrēšanās</h2>
                    <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Lietotājvārds">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="E-Pasts">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Parole">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Atkārtot Paroli">
                                <div class="text-center">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Reģistrēties') }}
                                </button>
                                </div>
                                <br><br>
                                @if (Route::has('login'))
                                <div class="text-center">
                                <h2>Esiet jau reģistrēts?</h2>
                                <a href="{{ route('login') }}" class="btn btn-primary text-center" style="align-self: center">Pieslēgšanās</a>
                                </div>
                                @endif
                    </form>
         </div>
</body>
