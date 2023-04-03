@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 50px;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="summary-box">
                    <h1 style="text-align: center">All products you've bought!</h1>
                    </div>
                    <br><br>
                    <form method="GET" action="{{route('productssearch')}}">
                        <div class="container" style="height: 20px; width: 500px">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" placeholder="Product Name" required>
                                <button class="btn btn-primary" type="submit" style="margin-bottom: 10px">Search</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <form method="GET" action="{{route('productsdate')}}">
                        <div class="container" style="height: 50px; width: 500px">
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" id="startdate" name="startdate" required>
                                <input type="date" class="form-control" id="enddate" name="enddate" required>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <table style="padding-bottom: 100px;">
                        <thead>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Amount/Weight(KG)</th>
                        <th>Total</th>
                        </thead>
                        <div style="overflow: auto;">
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->productname }}</td>
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
                            </tr>
                        @endforeach
                        </tbody>
                      </div>
                    </table>
                </div>
@endsection
