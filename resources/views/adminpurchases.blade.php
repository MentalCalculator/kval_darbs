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
                    <h2 style="margin-top: 10px;">User ID: {{ $purchase->userid }}</h2>
                    <h2>Purchase ID: {{ $purchase->id }}</h2>
                    <h2>Purchase Date: {{ $purchase->created_at }}</h2>
                    <table>
                        <thead>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Amount/Weight(KG)</th>
                        <th>Total</th>
                        </thead>
                        <tbody>
                        <tr>
                            @foreach($data[$purchase->id] as $products)
                                <td>{{$products->productname}}</td>
                                @if ($products->producttype == 'weight')
                                    <td>{{$products->productprice}}€/KG</td>
                                @else
                                    <td>{{$products->productprice}}€</td>
                                @endif
                                @if ($products->producttype == 'weight')
                                    <td>{{$products->productamount}}KG</td>
                                @else
                                    <td>{{$products->productamount}}</td>
                                @endif
                                <td>{{$products->total}}€</td>
                        </tr>
                        </tbody>
                        @endforeach
                    </table>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop4_{{$purchase->id}}" style="margin-bottom: 10px;">Delete Purchase
                    </button>
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
                @endforeach
            </div>
        </div>
    </div>
@endsection
