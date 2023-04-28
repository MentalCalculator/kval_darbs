@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 50px;">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="summary-box">
        <h1 style="text-align: center">Your products</h1>
    </div>
    <br><br>
    <form method="GET" action="{{route('productssearch')}}">
        <div class="container" style="height: 60px; width: 500px">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" value="{{ Session::get('productsSearch', '') }}" placeholder="Product name" required/>
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>
    <form method="GET" action="{{route('productsdate')}}">
        <div class="container" style="height: 60px; width: 500px">
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
        <div style="overflow: auto">
            <tbody>
            @foreach($products as $group => $groupedProduct)
                <tr>
                    <td>{{ $groupedProduct[0]->productname }}</td>
                    <td>
                        @if($groupedProduct[0]->producttype == 'weight')
                            {{ $groupedProduct[0]->productprice }} €/KG
                        @else
                            {{ $groupedProduct[0]->productprice }}€
                        @endif
                    </td>
                    <td>
                        @if($groupedProduct[0]->producttype == 'weight')
                            {{ $groupedProduct->sum(function($product) { return $product->productamount; }) }} KG
                        @else
                            {{ $groupedProduct->sum(function($product) { return $product->productamount; }) }}
                        @endif
                    </td>
                    <td>{{ $groupedProduct->totalSum }}€</td>
                </tr>
            @endforeach
            </tbody>
        </div>
    </table>
</div>
@endsection
