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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $('#add-product-btn').click(function() {
                var newInputGroup = $('<div class="input-group mb-3">' +
                    '<input type="text" class="form-control" placeholder="Product Name" name="productname[]" minlength="3" maxlength="30" required>' +
                    '<input type="number" class="form-control" placeholder="Product Price" name="productprice[]" step="0.01" max="99999999.99">' +
                    '<select class="form-select form-select-sm" aria-label=".form-select-sm example" name="producttype[]" required>' +
                    '<option value="amount">Amount</option>' +
                    '<option value="weight">Weight</option>' +
                    '</select>' +
                    '<input type="number" class="form-control" placeholder="Product Amount*" name="productamount[]" max="99999999">' +
                    '<button class="btn btn-danger" type="button" onclick="$(this).parent().remove()">X</button></div>').clone();

                newInputGroup.find('input').val('');

                // Add an event listener to the select input
                newInputGroup.find('select[name="producttype[]"]').on('change', function() {
                    var selectedOption = $(this).val();
                    var productAmountInput = $(this).closest('.input-group').find('input[name="productamount[]"]');

                    if (selectedOption === 'amount') {
                        productAmountInput.attr('step', '1');
                        productAmountInput.attr('max', '99999999');
                        newInputGroup.find('input[name="productamount[]"]').attr('placeholder', 'Product Amount');
                    } else if (selectedOption === 'weight') {
                        productAmountInput.attr('step', '0.001');
                        productAmountInput.attr('max', '99999999.999');
                        newInputGroup.find('input[name="productamount[]"]').attr('placeholder', 'Product Weight');
                    }
                });

                $('#product-input-group').after(newInputGroup);
            });
        });
    </script>
</head>
<body>
        <div id="app">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto mx-5">
                    <li style="margin-left: 50px">
                        <a class="nav-link text-light btn" href="{{ route('home')}}">{{__('Purchases')}}</a>
                    </li>
                    <li style="margin-left: 10px">
                        <a class="nav-link text-light btn" href="{{ route('productsinfo')}}">{{__('Products')}}</a>
                    </li>
                    <li style="margin-left: 10px">
                        <a class="nav-link text-light btn" href="{{ route('total')}}">{{__('Total')}}</a>
                    </li>
                </ul>
                <!-- Middle Of Navbar -->
                <ul class="navbar-nav mx-auto col-2">
                    <h6 class="text-light" style="margin-top: 10px">Budžeta uzskaites sistēma</h6>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto mx-5">
                    @if(Auth::user()->is_admin)
                        <li style="margin-left: 10px">
                            <a class="nav-link text-light btn">Admin User</a>
                        </li>
                    @endif
                    <div class="btn-group">
                        <div class="dropdown">
                            <button type="button" class="btn btn-dark-outline dropdown-toggle text-light" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-dark dropdown-menu-lg-end">
                                @if(Auth::user()->is_admin)
                                    <a class="dropdown-item" href="{{ route('adminpurchases') }}">Admin Panel</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('profile') }}">Settings</a>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </ul>
            </nav>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
</body>
</html>
