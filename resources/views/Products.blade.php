@extends('layouts.app')

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
            @foreach($products as $group => $groupedProduct)
                <div class="input-group mb-3">
                    <input type="text" id="PName" value="{{ $groupedProduct[0]->productname }}">
                    @if($groupedProduct[0]->producttype == 'weight')
                        <input type="text" id="PPrice" value="{{ $groupedProduct[0]->productprice }} €/KG">
                    @else
                        <input type="text" id="PPrice" value="{{ $groupedProduct[0]->productprice }} €">
                    @endif
                    @if($groupedProduct[0]->producttype == 'weight')
                        <input type="text" id="PAmount" value="{{ $groupedProduct->sum(function($product) { return $product->productamount; }) }} KG">
                    @else
                        <input type="text" id="PAmount" value="{{ $groupedProduct->sum(function($product) { return $product->productamount; }) }}">
                    @endif
                    <input type="text" id="PTotal" value="{{ $groupedProduct->totalSum }} €">
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
