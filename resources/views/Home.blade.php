@extends('layouts.app')

@section('content')
<div class="containerWrapper">
    <div class="container1">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <br>
        <div class="summary-box" id="PurchasesSummary">
            <h1 style="text-align: center">Your purchases</h1>
        </div>
        <form method="GET" action="{{route('purchasessearch')}}">
            <div class="input-group mb-3">
                <input type="text" name="search" value="{{ Session::get('purchasesSearch', '') }}" placeholder="Product name" />
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <form method="GET" action="{{route('purchasesdate')}}">
            <div class="input-group mb-3">
                <input type="date" class="form-control" id="startdate" name="startdate" required>
                <input type="date" class="form-control" id="enddate" name="enddate" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
        <br>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="margin-bottom: 30px">
            Create Purchase
        </button>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 800px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Purchase</h1>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('purchasecreate')}}">
                            @csrf
                            <div id="product-input-group"></div>
                            <p>Weight/Amount is optional. It sets to 1 if left blank.</p>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="add-product-btn">Add Product</button>
                                <button type="submit" class="btn btn-success">Submit Purchase</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                    <div id="products">
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2_{{$products->id}}" data-product-id="{{$products->id}}">Modify</button>
                                <div class="modal fade" id="staticBackdrop2_{{$products->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel2">Modify Product</h1>
                                            </div>
                                            <div class="modal-body">
                                                <div class="input-group mb-3">
                                                    <input type="text" id="ProductsInfoTitle" value="Name:" readonly>
                                                    <input type="text" id="PName" value="{{$products->productname}}" readonly>
                                                    <input type="text" id="ProductsInfoTitle" value="Price:" readonly>
                                                    @if ($products->producttype == 'weight')
                                                        <input type="text" id="PPrice" value="{{$products->productprice}}€/KG" readonly>
                                                    @else
                                                        <input type="text" id="PPrice" value="{{$products->productprice}}€" readonly>
                                                    @endif
                                                    @if ($products->producttype == 'weight')
                                                        <input type="text" id="ProductsInfoTitle" value="Weight:" readonly>
                                                        <input type="text" id="PAmount" value="{{$products->productamount}}KG" readonly>
                                                    @else
                                                        <input type="text" id="ProductsInfoTitle" value="Amount:" readonly>
                                                        <input type="text" id="PAmount" value="{{$products->productamount}}" readonly>
                                                    @endif
                                                </div>
                                                <form method="POST" action="{{ route('productupdate', ['id' => $products->id]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Include product ID as hidden input field -->
                                                    <input type="hidden" name="product_id" value="{{$products->id}}">
                                                    <input type="text" class="form check" name="new_name" id="new_name" placeholder="New product name" minlength="3" maxlength="30" style="margin-top: 10px;">
                                                    <input type="number" class="form check" name="new_price" id="new_price" step="0.01" placeholder="New product price" maxlength="8" pattern="^\d+(\.\d{1,2})?$" style="margin-top: 10px;">
                                                    @if ($products->producttype == 'weight')
                                                        <input type="number" class="form check" name="new_amount" id="new_amount" step="0.001" placeholder="New product weight" maxlength="8" style="margin-top: 10px;">
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
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop3_{{$products->id}}" data-product-id="{{$products->id}}">Delete</button>
                                <div class="modal fade" id="staticBackdrop3_{{$products->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel3">Do you want to delete this product?</h1>
                                            </div>
                                            <form method="POST" action="{{ route('removeproduct', ['id' => $products->id]) }}">
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
                    <br>
                    <div class="input-group mb-3">
                        <input type="text" id="PTotalSum" value="Total:" readonly>
                        <input type="text" id="PTotalAmount" value="{{ $totalSums[$purchase->id] }}€" readonly>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop4_{{$purchase->id}}" style="margin-bottom: 10px;">Delete Purchase</button>
                    <div class="modal fade" id="staticBackdrop4_{{$purchase->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel4">Do you want to delete Purchase?</h1>
                                </div>
                                <form method="POST" action="{{ route('removepurchase', ['id' => $purchase->id]) }}">
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
@endsection
