@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 50px;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="summary-box">
                    <h1 style="text-align: center">Visi pirktie produkti!</h1>
                    </div>
                    <br>
                    <table style="padding-bottom: 100px;">
                        <thead>
                        <th>Produkta Nosaukums</th>
                        <th>Produkta Cena</th>
                        <th>Produkta Skaits/Svars(KG)</th>
                        <th>Kopā</th>
                        </thead>
                        <div style="overflow: auto;">
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->nosaukums }}</td>
                                <td>@if($product->sveramais != 1)
                                        @if(fmod($product->sveramais, 1) != 0)
                                            {{ $product->cena }}€/KG
                                        @else
                                            {{ $product->cena }}€
                                        @endif
                                    @endif</td>
                                <td>@if($product->sveramais != 1)
                                        @if(fmod($product->sveramais, 1) != 0)
                                            {{ $product->sveramais }} KG
                                        @else
                                            {{ $product->sveramais }}
                                        @endif
                                    @endif</td>
                                <td>{{ $product->total }}€</td>
                            </tr>
                        @endforeach
                        </tbody>
                      </div>
                    </table>
                </div>
@endsection
