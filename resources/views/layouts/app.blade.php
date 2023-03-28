<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts and styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/app.css">

    <!-- Scripts -->
    <script src="js/popup.js" rel="stylesheet" ></script>

</head>
<body>
        <div id="app">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto mx-5">
                    <li style="margin-left: 50px">
                        <a class="nav-link text-light btn" href="{{ route('pirkumi')}}">{{__('Pirkumi')}}</a>
                    </li>
                    <li style="margin-left: 10px">
                        <a class="nav-link text-light btn" href="{{ route('productsinfo')}}">{{__('Produkti')}}</a>
                    </li>
                    <li style="margin-left: 10px">
                        <a class="nav-link text-light btn" href="{{ route('totalcount')}}">{{__('Kopsavilkums')}}</a>
                    </li>
                </ul>
                <!-- Middle Of Navbar -->
                <ul class="navbar-nav mx-auto col-2">
                    <h6 class="text-light" style="margin-top: 10px">Budžeta uzskaites sistēma</h6>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto mx-5">
                        <div class="dropdown">
                            <a style="margin-right: 50px" class="btn btn-dark btn-outline-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('profils') }}">Iestatījumi</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Atslēgties') }}
                                </a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                </ul>
            </nav>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
</body>
</html>
