@extends('layouts.adminapp')

@section('content')
<div class="containerWrapper">
    <div class="container3">
        <div id="power2">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="summary-box" id="ProductsSummary">
                <h1 style="text-align: center">All products</h1>
            </div>
                <br>
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
                @foreach($products as $product)
                    <div class="input-group mb-3">
                        <input type="text" id="PID" value="User ID: {{ $product->userid }}" readonly>
                        <input type="text" id="PName" value="{{ $product->productname }}" readonly>
                        @if($product->producttype == 'weight')
                            <input type="text" id="PPrice" value="{{ $product->productprice }}€/KG" readonly>
                        @else
                            <input type="text" id="PPrice" value="{{ $product->productprice }}€" readonly>
                        @endif
                        <input type="text" id="PType" value="{{ $product->producttype }}" readonly>
                        @if($product->producttype == 'weight')
                            <input type="text" id="PAmount" value="{{ $product->productamount }} KG" readonly>
                            @else
                            <input type="text" id="PAmount" value="{{ $product->productamount }}" readonly>
                        @endif
                        <input type="text" id="PTotal" value="{{ $product->total }}€" readonly>
                        <input type="text" id="PCreated" value="{{ $product->created_at }}" readonly>
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
                                            <div class="input-group mb-3">
                                                <input type="text" id="ProductsInfoTitle" value="Name:" readonly>
                                                <input type="text" id="PName" value="{{$product->productname}}" readonly>
                                                <input type="text" id="ProductsInfoTitle" value="Price:" readonly>
                                                @if ($product->producttype == 'weight')
                                                    <input type="text" id="PPrice" value="{{$product->productprice}}€/KG" readonly>
                                                @else
                                                    <input type="text" id="PPrice" value="{{$product->productprice}}€" readonly>
                                                @endif
                                                @if ($product->producttype == 'weight')
                                                    <input type="text" id="ProductsInfoTitle" value="Weight:" readonly>
                                                    <input type="text" id="PAmount" value="{{$product->productamount}}KG" readonly>
                                                @else
                                                    <input type="text" id="ProductsInfoTitle" value="Amount:" readonly>
                                                    <input type="text" id="PAmount" value="{{$product->productamount}}" readonly>
                                                @endif
                                            </div>
                                            <input type="text" class="form check" name="new_name" id="new_name" placeholder="New product name" minlength="3" maxlength="50" style="margin-top: 10px;">
                                            <input type="number" class="form check" name="new_price" id="new_price" step="0.01" placeholder="New product price" max="99999999.99" style="margin-top: 10px;">
                                            @if ($product->producttype == 'weight')
                                                <input type="number" class="form check" name="new_amount" id="new_amount" step="0.001" placeholder="New product weight" maxlength="12" style="margin-top: 10px;">
                                            @else
                                                <input type="number" class="form check" name="new_amount" id="new_amount" step="1" placeholder="New product amount" maxlength="8" style="margin-top: 10px; margin-bottom: 10px">
                                            @endif
                                            <br>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Modify</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
