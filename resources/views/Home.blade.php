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
            <h1 style="text-align: center">Your purchases!</h1>
        </div>
        <form method="GET" action="{{route('purchasessearch')}}">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Nosaukums" required>
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
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Purchase</h1>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('purchasecreate')}}">
                            @csrf
                            <table class="table" id="products-table" style="overflow: auto">
                                <thead id="table-header">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price per unit or KG</th>
                                    <th>Type</th>
                                    <th>Amount/Weight*</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary" id="add-product-btn">Add Product</button>
                            <button type="submit" class="btn btn-success">Submit Purchase</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container2">
        <div id="power">
            @foreach($purchases as $purchase)
                <h2>Purchase ID: {{ $purchase->id }}</h2>
                <h2>Purchase Date: {{ $purchase->created_at }}</h2>
                <table>
                    <thead>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Amount</th>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($data[$purchase->id] as $products)
                        <tr>
                            <td>{{$products->productname}}</td>
                            <td>{{$products->productprice}}€</td>
                            @if ($products->producttype == 'weight')
                                <td>{{$products->productamount}}KG</td>
                            @else
                                <td>{{$products->productamount}}</td>
                            @endif
                            <td>{{$products->total}}€</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Modify</button>
                                <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel2">Modify</h1>
                                            </div>
                                            <div class="modal-body">
                                                <table>
                                                    <thead>
                                                        <th>Product Name</th>
                                                        <th>Product Price</th>
                                                        <th>Product Amount</th>
                                                    </thead>
                                                    </tbody>
                                                    <form method="PUT" route="{{'productsupdate'}}">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Modify</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">Delete</button>
                                <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel3">Do you want to delete this product?</h1>
                                            </div>
                                            <form method="DELETE" route="{{'remove'}}">
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
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop4">Delete Purchase</button>
                <div class="modal fade" id="staticBackdrop4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel4">Do you want to delete Purchase?</h1>
                            </div>
                            <form method="DELETE" route="{{'remove'}}">
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
</div>
@endsection
