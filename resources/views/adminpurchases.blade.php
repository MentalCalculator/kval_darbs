@extends('layouts.adminapp')

@section('content')
<div class="containerWrapper">
    <div class="container1">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <br>
        <div class="summary-box" style="margin-bottom: 50px">
            <h1 style="text-align: center">All purchases</h1>
        </div>
        <form method="GET" autocomplete="on" action="{{ route('adminpurchasesearchid') }}">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" maxlength="20" value="{{ Session::get('adminpurchasesearchid', '') }}"
                       placeholder="Purchase ID"/>
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <form method="GET" autocomplete="on" action="{{ route('adminpurchasesearchuserid') }}">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" maxlength="20" value="{{ Session::get('adminpurchasesearchuserid', '') }}"
                       placeholder="User ID"/>
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <form method="GET" autocomplete="on" action="{{ route('adminpurchasesdate') }}">
            <div class="input-group mb-3">
                <input type="date" class="form-control" id="startdate" name="startdate" required>
                <input type="date" class="form-control" id="enddate" name="enddate" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
        <br>
    </div>
    <div class="container2">
        <div id="power">
                @foreach($purchases as $purchase)
                <div id="zone">
                    <div class="input-group mb-3">
                        <textarea type="text" id="PurchaseUserIDTitle" rows="1" readonly>User ID:</textarea>
                        <textarea type="text" id="PurchaseUserID" rows="1" readonly>{{ $purchase->userid }}</textarea>
                        <textarea type="text" id="PurchaseIDTitle" rows="1" readonly>Purchase ID:</textarea>
                        <textarea type="text" id="PurchaseID" rows="1" readonly>{{ $purchase->id }}</textarea>
                        <textarea type="text" id="PurchaseDateTitle" rows="1" readonly>Date:</textarea>
                        <textarea type="text" id="PurchaseDate" rows="1" readonly>{{ $purchase->created_at }}</textarea>
                    </div>
                    <div class="input-group mb-3">
                        <textarea type="text" id="ProductsTitle" rows="1" readonly>Products</textarea>
                    </div>
                    <div id="products">
                        @foreach($data[$purchase->id] as $products)
                            <div class="input-group mb-3">
                                <textarea readonly id="PurchaseName" rows="1" autofocus>{{ $products->productname }}</textarea>
                                @if ($products->producttype == 'weight')
                                    <textarea  type="text" id="PurchasePrice" rows="1" readonly>{{$products->productprice}}€/KG</textarea>
                                @else
                                    <textarea  type="text" id="PurchasePrice" rows="1" readonly>{{$products->productprice}}€</textarea>
                                @endif
                                @if ($products->producttype == 'weight')
                                    <textarea  type="text" id="PurchaseAmount" rows="1" readonly>{{$products->productamount}}KG</textarea>
                                @else
                                    <textarea  type="text" id="PurchaseAmount" rows="1" readonly>{{$products->productamount}}</textarea>
                                @endif
                                <textarea  type="text" id="PurchaseTotalProductSum" rows="1" readonly>{{$products->total}}€</textarea>
                            </div>
                        @endforeach
                    </div>
                    <br>
                    <div class="input-group mb-3">
                        <textarea type="text" id="PurchaseTotalSumTitle" rows="1" readonly>Total:</textarea>
                        <textarea type="text" id="PurchaseTotalSum" rows="1" readonly>{{ $totalSums[$purchase->id] }}€</textarea>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop4_{{$purchase->id}}" style="margin-bottom: 10px;">Delete Purchase</button>
                    <div class="modal fade" id="staticBackdrop4_{{$purchase->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-product-id="{{$purchase->id}}" aria-labelledby="staticBackdropLabel4" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel4">Do you want to delete
                                        Purchase?</h1>
                                </div>
                                <form method="POST" autocomplete="on" action="{{ route('adminremovepurchase', ['id' => $purchase->id]) }}">
                                    @csrf
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">No
                                        </button>
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
@endsection
