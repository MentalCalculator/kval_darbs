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
                <form method="GET" action="{{ url('adminproductssearchname', [], true) }}">
                    <div class="container" style="height: 20px; width: 500px">
                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" maxlength="50" value="{{ Session::get('productsSearch', '') }}" placeholder="Product name" required/>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <br><br>
                <form method="GET" action="{{ url('adminproductssearchuserid', [], true) }}">
                    <div class="container" style="height: 20px; width: 500px">
                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" maxlength="20" value="{{ Session::get('productsSearch', '') }}" placeholder="Product user ID" required/>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <br><br>
                <form method="GET" action="{{ url('adminproductsdate', [], true) }}">
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
                        <textarea id="ProductUserID" rows="1" readonly>User ID: {{ $product->userid }}</textarea>
                        <textarea id="ProductName" rows="1" autofocus readonly>{{ $product->productname }}</textarea>
                        @if($product->producttype == 'weight')
                            <textarea id="ProductPrice" rows="1" readonly>{{ $product->productprice }}€/KG</textarea>
                        @else
                            <textarea id="ProductPrice" rows="1" readonly>{{ $product->productprice }}€</textarea>
                        @endif
                        <textarea id="ProductType" rows="1" readonly>{{ $product->producttype }}</textarea>
                        @if($product->producttype == 'weight')
                            <textarea id="ProductAmount" rows="1" readonly>{{ $product->productamount }} KG</textarea>
                            @else
                            <textarea id="ProductAmount" rows="1" readonly>{{ $product->productamount }}</textarea>
                        @endif
                        <textarea id="ProductTotalProductSum" rows="1" readonly>{{ $product->total }}€</textarea>
                        <textarea id="ProductDate" rows="1" readonly>{{ $product->created_at }}</textarea>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop4_{{$product->id}}" data-product-id="{{$product->id}}">Modify</button>
                        <div class="modal fade" id="staticBackdrop4_{{$product->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel4">Modify product</h1>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ url('adminproductupdate', ['id' => $product->id], true) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group mb-3">
                                                <textarea id="ProductEditName" rows="1" readonly>{{$product->productname}}</textarea>
                                                @if ($product->producttype == 'weight')
                                                    <textarea id="ProductEditPrice" rows="1" readonly>{{$product->productprice}}€/KG</textarea>
                                                @else
                                                    <textarea id="ProductEditPrice" rows="1" readonly>{{$product->productprice}}€</textarea>
                                                @endif
                                                @if ($product->producttype == 'weight')
                                                    <textarea id="ProductEditAmount" rows="1" readonly>{{$product->productamount}}KG</textarea>
                                                @else
                                                    <textarea id="ProductEditAmount" rows="1" readonly>{{$product->productamount}}</textarea>
                                                @endif
                                            </div>
                                            <input type="text" class="form-control" minlength="3" maxlength="50" name="new_name" id="new_name" placeholder="New product name" style="margin-top: 10px;">
                                            <input type="number" class="form-control" name="new_price" id="new_price" step="0.01" placeholder="New product price" max="99999999.99" style="margin-top: 10px;">
                                            @if ($product->producttype == 'weight')
                                                <input type="number" class="form-control" name="new_amount" id="new_amount" step="0.001" max="99999999.999" placeholder="New product weight" style="margin-top: 10px;">
                                            @else
                                                <input type="number" class="form-control" name="new_amount" id="new_amount" step="1" max="99999999" placeholder="New product amount" maxlength="8" style="margin-top: 10px; margin-bottom: 10px">
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
                                    <form method="POST" action="{{ url('adminremoveproduct', ['id' => $product->id], true) }}">
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
