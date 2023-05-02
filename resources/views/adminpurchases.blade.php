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
        <form method="GET" action="{{route('adminpurchasesearchid')}}">
            <div class="input-group mb-3">
                <input type="text" name="search" value="{{ Session::get('adminpurchasesearchid', '') }}"
                       placeholder="Purchase ID"/>
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <form method="GET" action="{{route('adminpurchasesearchuserid')}}">
            <div class="input-group mb-3">
                <input type="text" name="search" value="{{ Session::get('adminpurchasesearchuserid', '') }}"
                       placeholder="Purchase User ID"/>
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <form method="GET" action="{{route('adminpurchasesdate')}}">
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
                        <input type="text" id="PurchaseInfo" value="Purchase ID:" readonly>
                        <input type="text" id="PurchaseData" value="{{ $purchase->id }}" readonly>
                        <input type="text" id="PurchaseDateInfo" value="Date:" readonly>
                        <input type="text" id="PurchaseDate" value="{{ $purchase->created_at }}" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" id="ProductsTitle" value="Products" readonly>
                    </div>
                    @foreach($data[$purchase->id] as $products)
                    <div class="input-group mb-3">
                        <input type="text" id="PName" value="{{$products->productname}}" readonly>
                        @if ($products->producttype == 'weight')
                            <input type="text" id="PPrice" value="{{$products->productprice}}€/KG" readonly>
                        @else
                            <input type="text" id="PPrice" value="{{$products->productprice}}€" readonly>
                        @endif
                        @if ($products->producttype == 'weight')
                            <input type="text" id="PAmount" value="{{$products->productamount}}KG" readonly>
                        @else
                            <input type="text" id="PAmount" value="{{$products->productamount}}" readonly>
                        @endif
                        <input type="text" id="PTotal" value="{{$products->total}}€" readonly>
                    </div>
                    @endforeach
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop4_{{$purchase->id}}" style="margin-bottom: 10px;">Delete Purchase</button>
                    <div class="modal fade" id="staticBackdrop4_{{$purchase->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-product-id="{{$purchase->id}}" aria-labelledby="staticBackdropLabel4" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel4">Do you want to delete
                                        Purchase?</h1>
                                </div>
                                <form method="POST" action="{{ route('removepurchase', ['id' => $purchase->id]) }}">
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
