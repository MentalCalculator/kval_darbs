<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <title>TomsKD</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts and styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <style>
        body {
            background-color: #2d3748;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* semi-transparent black */
            z-index: 1000; /* set the z-index to be higher than any other element on the page */
            display: none; /* hide the overlay by default */
        }
        table {
            border-collapse: collapse;
            width: 70%;
            align-items: center;
        }
        th, td {
            text-align: center;
            padding: 4px;
        }
        th {
            background-color: #d0d0d0;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }

        .container {
            background-color: #ffffff;
            width: 1000px;
            height: 700px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .containerWrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }
        .container1 {
            background-color: #ffffff;
            width: 30%;
            height: 700px;
            border-bottom-left-radius: 10px;
            border-top-left-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .container2 {
            padding-top: 30px;
            padding-bottom: 30px;
            background-color: #ffffff;
            width: 50%;
            height: 700px;
            border-bottom-right-radius: 10px;
            border-top-right-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .container3 {
            background-color: #ffffff;
            width: 80%;
            height: 700px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        #power {
            border-radius: 10px;
            background-color: #ffffff;
            width: 90%;
            box-shadow: 0 0 10px rgb(58, 128, 252);
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: auto;
        }
        #power2 {
            border-radius: 10px;
            background-color: #ffffff;
            width: 100%;
            height: 100%;
            box-shadow: 0 0 10px rgb(58, 128, 252);
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: auto;
        }
        #zone {
            padding-top: 20px;
            padding-bottom: 10px;
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgb(58, 128, 252);
        }
        #products {
            max-width: 700px;
            max-height: 200px;
            display: flex;
            padding-top: 15px;
            border-radius: 20px;
            flex-direction: column;
            align-items: center;
            overflow: auto;
            box-shadow: 0 0 10px rgb(58, 128, 252);
        }
        .container h2 {
            display: inline-block;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .container h3 {
            font-size: 30px;
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"] {
            width: 200px;
            border: none;
            border-radius: 5px;
            background-color: rgba(215, 215, 215, 0.65);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Product Title */
        textarea[id="ProductsTitle"] {
            background-color: rgba(148, 151, 255, 0.65);
            width: 15%;
            height: auto;
            text-align: center;
            justify-content: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
            font-weight: bold;
        }

        /* Purchase Info Data Style */
        textarea[id="PurchaseIDTitle"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 15%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
            font-weight: bold;
        }
        textarea[id="PurchaseID"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 17%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }
        textarea[id="PurchaseDateTitle"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 10%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
            font-weight: bold;
        }
        textarea[id="PurchaseDate"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 20%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }


        /* Purchase Info Data Style */
        textarea[id="PurchaseName"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 30%;
            text-align: center;
            border: 1px solid black;
            word-wrap: break-word;
            resize: none;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        textarea[id="PurchasePrice"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 15%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }
        textarea[id="PurchaseAmount"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 15%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }
        textarea[id="PurchaseTotalProductSum"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 15%;
            text-align: center;
            font-weight: bold;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }

        /* Total Purchase Data Style */
        textarea[id="PurchaseTotalSumTitle"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 10%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
            font-weight: bold;
        }
        textarea[id="PurchaseTotalSum"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 15%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
            font-weight: bold;
        }

        /* Products Info */
        textarea[id="ProductName"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 30%;
            text-align: center;
            border: 1px solid black;
            overflow-block: auto;
            resize: none;
        }
        textarea[id="ProductPrice"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 20%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }
        textarea[id="ProductAmount"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 15%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }
        textarea[id="ProductTotalProductSum"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 20%;
            text-align: center;
            font-weight: bold;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }
        /* Product Edit Info */
        textarea[id="ProductEditName"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 40%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }
        textarea[id="ProductEditPrice"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 25%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }
        textarea[id="ProductEditAmount"] {
            background-color: rgba(215, 215, 215, 0.65);
            width: 20%;
            text-align: center;
            border: 1px solid black;
            overflow-wrap: break-word;
            resize: none;
        }

        /* Other Style Fixes */
        .input-group {
            justify-content: center
        }
        button {
            display: inline-block;
        }
        form input {
            display: block;
            margin: 0 auto;
        }
        buttons-container {
            display: flex;
            justify-content: center;
        }
        .summary-box {
            background-color: #ffffff;
            width: 60%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgb(58, 128, 252);
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            padding: 20px;
            margin-bottom: 10px;
        }
        .summary-box h2 {
            margin: 0;
            font-size: 24px;
            text-align: center;
        }
        .summary-box[id="PurchasesSummary"] {
            background-color: #ffffff;
            width: 60%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgb(58, 128, 252);
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .summary-box[id="ProductsSummary"] {
            background-color: #ffffff;
            width: 60%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgb(58, 128, 252);
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            padding: 20px;
            margin-bottom: 10px;
        }
    </style>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $('#add-product-btn').click(function() {
                var newInputGroup = $('<div class="input-group mb-3">' +
                    '<input type="text" class="form-control" placeholder="Name" name="productname[]" minlength="3" maxlength="50" required>' +
                    '<input type="number" class="form-control" placeholder="Price" name="productprice[]" step="0.01" min="0" max="99999999.99" required>' +
                    '<select class="form-select form-select-sm" aria-label=".form-select-sm example" name="producttype[]" required>' +
                    '<option value="amount">Amount</option>' +
                    '<option value="weight">Weight</option>' +
                    '</select>' +
                    '<input type="number" class="form-control" placeholder="Number*" name="productamount[]" min="0" max="99999999">' +
                    '<button class="btn btn-danger" type="button" onclick="$(this).parent().remove()">X</button></div>').clone();

                newInputGroup.find('input').val('');

                // Add an event listener to the select input
                newInputGroup.find('select[name="producttype[]"]').on('change', function() {
                    var selectedOption = $(this).val();
                    var productAmountInput = $(this).closest('.input-group').find('input[name="productamount[]"]');

                    if (selectedOption === 'amount') {
                        productAmountInput.attr('max', '99999999');
                        productAmountInput.attr('step', '1');
                        newInputGroup.find('input[name="productamount[]"]').attr('placeholder', 'Number*');
                    } else if (selectedOption === 'weight') {
                        productAmountInput.attr('max', '99999999.999');
                        productAmountInput.attr('step', '0.001');
                        newInputGroup.find('input[name="productamount[]"]').attr('placeholder', 'Number*');
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
                    <li style="margin-left: 10px">
                        <a class="nav-link text-light btn" href="{{ url('home', [], true) }}">{{__('Purchases')}}</a>
                    </li>
                    <li style="margin-left: 10px">
                        <a class="nav-link text-light btn" href="{{ url('products', [], true) }}">{{__('Products')}}</a>
                    </li>
                    <li style="margin-left: 10px">
                        <a class="nav-link text-light btn" href="{{ url('total', [], true) }}">{{__('Total')}}</a>
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
                                    <a class="dropdown-item" href="{{ url('adminpurchases', [], true) }}">Admin Panel</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('profile') }}">Settings</a>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </div>
                            <form id="logout-form" action="{{ url('logout', [], true) }}" method="POST" class="d-none">
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
