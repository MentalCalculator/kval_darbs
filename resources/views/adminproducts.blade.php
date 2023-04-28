@extends('layouts.adminapp')

@section('content')
<div class="container" style="margin-top: 50px;">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="summary-box">
        <h1 style="text-align: center">All products</h1>
    </div>
    <br><br>
    <form method="GET" action="{{route('adminproductssearchname')}}">
        <div class="container" style="height: 20px; width: 500px">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" value="{{ Session::get('productsSearch', '') }}" placeholder="Product name" required/>
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>
    <br><br>
    <form method="GET" action="{{route('adminproductssearchuserid')}}">
        <div class="container" style="height: 20px; width: 500px">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" value="{{ Session::get('productsSearch', '') }}" placeholder="Product user ID" required/>
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>
    <br><br>
    <form method="GET" action="{{route('adminproductsdate')}}">
        <div class="container" style="height: 20px; width: 500px">
            <div class="input-group mb-3">
                <input type="date" class="form-control" id="startdate" name="startdate" required>
                <input type="date" class="form-control" id="enddate" name="enddate" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <br>
    <div style="overflow: auto">
        <table style="padding-bottom: 100px;">
        <thead>
            <th>Created By</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Type</th>
            <th>Product Amount/Weight(KG)</th>
            <th>Total</th>
            <th>Creation Date</th>
            <th></th>
            <th></th>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>User ID: {{ $product->userid }}</td>
                    <td>{{ $product->productname }}</td>
                    <td>
                        @if($product->producttype == 'weight')
                            {{ $product->productprice }}€/KG
                        @else
                            {{ $product->productprice }}€
                        @endif
                    </td>
                    <td>{{ $product->producttype }}</td>
                    <td>
                        @if($product->producttype == 'weight')
                            {{ $product->productamount }} KG
                        @else
                            {{ $product->productamount }}
                        @endif
                    </td>
                    <td>{{ $product->total }}€</td>
                    <td>{{ $product->created_at }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop4_{{$product->id}}" data-product-id="{{$product->id}}">Modify</button>
                        <div class="modal fade" id="staticBackdrop4_{{$product->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel4">Modify product</h1>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('adminproductupdate', ['id' => $product->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <table>
                                                <tbody>
                                                <thead>
                                                    <th>Product Name</th>
                                                    <th>Product Price</th>
                                                    <th>Product Amount</th>
                                                </thead>
                                                <tr>
                                                    <td>{{$product->productname}}</td>
                                                    @if ($product->producttype == 'weight')
                                                        <td>{{$product->productprice}}€/KG</td>
                                                    @else
                                                        <td>{{$product->productprice}}€</td>
                                                    @endif
                                                    @if ($product->producttype == 'weight')
                                                        <td>{{$product->productamount}}KG</td>
                                                    @else
                                                        <td>{{$product->productamount}}</td>
                                                    @endif
                                                </tr>
                                                </tbody>
                                            </table>
                                            <input type="text" class="form check" name="new_name" id="new_name" placeholder="New product name" minlength="3" maxlength="30" style="margin-top: 10px;">
                                            <input type="number" class="form check" name="new_price" id="new_price" step="0.01" placeholder="New product price" max="99999999.99" style="margin-top: 10px;">
                                            @if ($product->producttype == 'weight')
                                                <input type="number" class="form check" name="new_amount" id="new_amount" step="0.001" placeholder="New product weight" maxlength="12" style="margin-top: 10px;">
                                            @else
                                                <input type="number" class="form check" name="new_amount" id="new_amount" step="1" placeholder="New product amount" maxlength="8" style="margin-top: 10px; margin-bottom: 10px">
                                            @endif
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Modify</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop3_{{$product->id}}" data-product-id="{{$product->id}}">Delete</button>
                        <div class="modal fade" id="staticBackdrop3_{{$product->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel3">Do you want to delete this product?</h1>
                                    </div>
                                    <form method="POST" action="{{ route('adminremoveproduct', ['id' => $product->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-danger">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
