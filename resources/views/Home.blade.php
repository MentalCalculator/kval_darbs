@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 50px">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
                <br>
            <div class="summary-box">
            <h1 style="text-align: center">Your purchases!</h1>
            </div>
            <br><br>
                <form method="GET" action="{{route('purchasessearch')}}">
                    <div class="container" style="height: 20px; width: 500px">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Nosaukums" required>
                            <button class="btn btn-primary" type="submit" style="margin-bottom: 10px">Search</button>
                        </div>
                    </div>
                </form>
                <br>
                <form method="GET" action="{{route('purchasesdate')}}">
                    <div class="container" style="height: 50px; width: 500px">
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" id="startdate" name="startdate" required>
                            <input type="date" class="form-control" id="enddate" name="enddate" required>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Create Purchase
                </button>
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Purchase</h1>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{route('purchasecreate')}}">
                                    @csrf
                                    <input type="text" class="form-control" name="productname" id="productname" placeholder="Product name" maxlength="100" required>
                                    <input type="number" class="form-control @error('name') is-invalid @enderror" name="productprice" step="0.01" id="productprice" placeholder="Price per unit" required>
                                    @error('nosaukums')
                                    <span class="invalid-feedback" role="alert" style="text-align: center;">
                                    <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                    <div class="text-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="producttype" id="amount" value="amount" pattern="\d+" onclick="changeStep(1)" required>
                                            <label class="form-check-label" for="skaits">
                                                Amount
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="producttype" id="weight" value="weight" onclick="changeStep(0.001)" required style="color: #4a5568">
                                            <label class="form-check-label" for="svars">
                                                Weight
                                            </label>
                                            <div class="invalid-feedback">Izvēlieties tipu!</div>
                                        </div>
                                    </div>
                                    <input type="number" class="form-control @error('name') is-invalid @enderror" name="productamount" id="productamount" oninput="preventDecimal(event)" placeholder="Amount/Weight*">
                                    <h6 style="text-align: center">Skaits/Svars paliks 1, ja nav ievadīta vērtība.</h6>
                                    <br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Pievienot') }}
                                </button>
                                <button type="button" class="btn btn-danger" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Atcelt</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div id="power">
                @foreach ($data as $purchases_id => $products)
                    @if (!empty($products))
                        @foreach ($products as $product)
                         <div class="container" id="zone">
                            <br>
                            <h2>Purchase ID: {{ $purchases_id }}</h2>
                            <h2>Purchase date: {{ $purchases->where('id', $purchases_id)->first()->created_at }}</h2>
                                <table style="margin: auto">
                                    <thead>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Product Amount/Weight(KG)</th>
                                    <th>Total</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    <tr><td>{{ $product->productname }}</td>
                                            <td>
                                                @if($product->producttype == 'weight')
                                                {{ $product->productprice }}€/KG
                                                @else
                                                {{ $product->productprice }}€
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->producttype == 'weight')
                                                    {{ $product->productamount }} KG
                                                @else
                                                    {{ $product->productamount }}
                                                @endif
                                            </td>
                                        <td>{{ $product->total }}€</td>
                                        <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">
                                                Modify
                                            </button>
                                            <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel" style="text-align: center;">Modify Product</h1>
                                                        </div>
                                                        <div class="modal-body">
                                                        @if ($product->id == $product->id)
                                                        <form action="{{ route('productsupdate', $product->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <br>
                                                        <table style="margin: auto">
                                                        <thead>
                                                        <th>Product Name</th>
                                                        <th>Product Price</th>
                                                        <th>Product Amount/Weight(KG)</th>
                                                        </thead>
                                                        <tbody>
                                                        <tr style="background-color: #bdcfe7"><td>{{ $product->productname }}</td>
                                                                <td>
                                                                    @if($product->producttype == 'weight')
                                                                        {{ $product->productprice }}€/KG
                                                                    @else
                                                                        {{ $product->productprice }}€
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($product->producttype == 'weight')
                                                                        {{ $product->productamount }} KG
                                                                    @else
                                                                        {{ $product->productamount }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        </table>
                                                        <br>
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="new_name" maxlength="20" placeholder="New name">
                                                        <input type="number" class="form-control @error('name') is-invalid @enderror" name="new_price" step="0.01" placeholder="New price">
                                                        @if($product->producttype == 'Svars')
                                                        <input type="number" class="form-control @error('name') is-invalid @enderror" name="new_amount" step="0.001" placeholder="New weight">
                                                        @else
                                                        <input type="number" class="form-control @error('name') is-invalid @enderror" name="new_amount" step="1" placeholder="New amount">
                                                        @endif
                                                        <br>
                                                        <div class="modal-footer">
                                                          <button type="submit" class="btn btn-success">Modify</button>
                                                          <button type="button" class="btn btn-danger" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                        </div>
                                                </form>
                                            @endif
                                        </td></tr>
                                    </tbody>
                                </table>
                                <br>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">
                                    Delete
                                </button>
                                <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                            <form action="{{ route('remove', $product->purchaseid) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <h4>Do you want to delete this purchase?</h4>
                                                <table style="margin: auto">
                                                    <thead>
                                                    <th>Product Name</th>
                                                    <th>Product Price</th>
                                                    <th>Product Amount/Weight(KG)</th>
                                                    </thead>
                                                    <tbody>
                                                    <tr style="background-color: #bdcfe7"><td>{{ $product->productname }}</td>
                                                        <td>
                                                            @if($product->producttype == 'weight')
                                                                {{ $product->productprice }}€/KG
                                                            @else
                                                                {{ $product->productprice }}€
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($product->producttype == 'weight')
                                                                {{ $product->productamount }} KG
                                                            @else
                                                                {{ $product->productamount }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                            <div class="buttons-container" style="text-align: center">
                                            <button type="submit" class="btn btn-danger">Yes</button>
                                            <button type="button" class="btn btn-success" class="btn-close" data-bs-dismiss="modal" aria-label="Close">No</button>
                                             </div>
                                            </form>
                                            </div>
                                         </div>
                                    </div>
                                </div>
                              <br>
                            </div>
                        @endforeach
                    @endif
                @endforeach
         </div>
         <br>
    </div>
@endsection
