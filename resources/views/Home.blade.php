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
        <div class="summary-box" style="margin-bottom: 50px">
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Create Purchase
        </button>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 500px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Purchase</h1>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('purchasecreate')}}">
                            @csrf
                            <table class="table" id="products-table" style="max-height: 200px; overflow-y: auto;">
                                <thead id="table-header">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Amount/Weight*</th>
                                    <th> </th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary" id="add-product-btn">Add Product</button>
                            <button type="submit" class="btn btn-success">Submit Purchase</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container2">
        <div id="power">
            @foreach($purchases as $purchase)
                <h2 style="margin-top: 10px;">Purchase ID: {{ $purchase->id }}</h2>
                <h2>Purchase Date: {{ $purchase->created_at }}</h2>
                <table>
                    <thead>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Amount/Weight(KG)</th>
                        <th>Total</th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($data[$purchase->id] as $products)
                            <td>{{$products->productname}}</td>
                            <td>{{$products->productprice}}€</td>
                            @if ($products->producttype == 'weight')
                                <td>{{$products->productamount}}KG</td>
                            @else
                                <td>{{$products->productamount}}</td>
                            @endif
                            <td>{{$products->total}}€</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2_{{$products->id}}" data-product-id="{{$products->id}}">Modify</button>
                                <div class="modal fade" id="staticBackdrop2_{{$products->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel2">Modify</h1>
                                            </div>
                                            <div class="modal-body">
                                                <table>
                                                    <tbody>
                                                    <thead>
                                                    <th>Product Name</th>
                                                    <th>Product Price</th>
                                                    <th>Product Amount</th>
                                                    </thead>
                                                    <tr>
                                                        <td>{{$products->productname}}</td>
                                                        <td>{{$products->productprice}}€</td>
                                                        @if ($products->producttype == 'weight')
                                                            <td>{{$products->productamount}}KG</td>
                                                        @else
                                                            <td>{{$products->productamount}}</td>
                                                        @endif
                                                    </tr>
                                                    </tbody>
                                                    </table>
                                                <form method="POST" action="{{ route('productupdate', ['id' => $products->id]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Include product ID as hidden input field -->
                                                    <input type="hidden" name="product_id" value="{{$products->id}}">
                                                    <input type="text" class="form check" name="new_name" id="new_name" placeholder="New product name" style="margin-top: 10px;">
                                                    <input type="text" class="form check" name="new_price" id="new_price" step="0.01" placeholder="New product price" style="margin-top: 10px;">
                                                    @if ($products->producttype == 'weight')
                                                        <input type="number" class="form check" name="new_amount" id="new_amount" step="1" placeholder="New product weight" style="margin-top: 10px;">
                                                    @else
                                                        <input type="number" class="form check" name="new_amount" id="new_amount" step="0.001" placeholder="New product amount" style="margin-top: 10px; margin-bottom: 10px">
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
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop4" style="margin-bottom: 10px;">Delete Purchase</button>
                <div class="modal fade" id="staticBackdrop4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4" aria-hidden="true">
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
            @endforeach
        </div>
    </div>
</div>
@endsection
