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
            <br>
            <form method="GET" autocomplete="on" action="{{ secure_url(route('productssearch')) }}">
                <div class="container" style="height: 60px; width: 500px">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" maxlength="50" value="{{ Session::get('productsSearch', '') }}" placeholder="Product name" required/>
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <form method="GET" autocomplete="on" action="{{ secure_url(route('productsdate')) }}">
                <div class="container" style="height: 60px; width: 500px">
                    <div class="input-group mb-3">
                        <input type="date" class="form-control" id="startdate" name="startdate" required>
                        <input type="date" class="form-control" id="enddate" name="enddate" required>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            <br>
            @foreach($products as $group => $groupedProduct)
                <div class="input-group mb-3">
                    <textarea id="ProductName" rows="1" style="overflow-wrap: break-word; resize: none; vertical-align: middle;" autofocus readonly>{{ $groupedProduct[0]->productname }}</textarea>
                    @if($groupedProduct[0]->producttype == 'weight')
                        <textarea type="text" id="ProductPrice" rows="1" readonly>{{ $groupedProduct[0]->productprice }} €/KG</textarea>
                    @else
                        <textarea type="text" id="ProductPrice" rows="1" readonly>{{ $groupedProduct[0]->productprice }} €</textarea>
                    @endif
                    @if($groupedProduct[0]->producttype == 'weight')
                        <textarea type="text" id="ProductAmount" rows="1" readonly>{{ $groupedProduct->sum(function($product) { return $product->productamount; }) }} KG</textarea>
                    @else
                        <textarea type="text" id="ProductAmount" rows="1" readonly>{{ $groupedProduct->sum(function($product) { return $product->productamount; }) }}</textarea>
                    @endif
                    <textarea type="text" id="ProductTotalProductSum" rows="1" readonly>{{ $groupedProduct->totalSum }} €</textarea>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
