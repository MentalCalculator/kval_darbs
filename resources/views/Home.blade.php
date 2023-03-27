@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 50px">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
                <br>
            <h1 style="text-align: center">Jūsu veiktie pirkumi!</h1>
            <br>
            <button class="btn btn-success" onclick="showPopupBox1()">Pievienojiet Pirkumu</button>
            <div id="popup-box1">
                <form method="POST" action="{{route('pirkums')}}">
                    @csrf
                    <br>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="nosaukums" id="nosaukums" placeholder="Produkta Nosaukums">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="cena" id="cena" placeholder="Cena Par Vienību">
                    <div class="buttons-container" style="text-align: center">
                        <button type="submit" class="btn btn-success">
                            {{ __('Pievienot') }}
                        </button>
                        <button type="button" class="btn btn-danger" onclick="hidePopupBox1()">Atcelt</button>
                    </div>
                    <br>
                    <h6 style="text-align: center">Skaits/Svars paliks 1, ja nav ievadīta vērtība.</h6>
                    <input type="text" name="sveramais" id="sveramais" placeholder="Skaits/Svars">
                </form>
            </div>
            <br>
                <div id="power">
                @foreach ($data as $pirkums_id => $products)
                    @if (!empty($products))
                            <div class="container" id="zone">
                            <br>
                            <h2>Pirkuma ID: {{ $pirkums_id }}</h2>
                            <h2>Pirkuma datums: {{ $pirkumi->where('id', $pirkums_id)->first()->created_at }}</h2>
                                <table style="margin: auto">
                                    <thead>
                                    <th>Produkta Nosaukums</th>
                                    <th>Produkta Cena</th>
                                    <th>Produkta Skaits/Svars(KG)</th>
                                    <th>Kopā</th>
                                    <th></th>
                                    </thead>
                                    @foreach ($products as $product)
                                    <tbody>
                                    <tr><td>{{ $product->nosaukums }}</td>
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
                                        <td><button class="btn btn-primary" onclick="showPopupBox2()">Rediģēšana</button>
                                                <div id="popup-box2">
                                                    @if ($product->id == $product->id)
                                                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <br>
                                                        <input type="text" name="new_nosaukums" placeholder="Jauns nosaukums">
                                                        <input type="text" name="new_cena" placeholder="Jauna cena">
                                                        <input type="text" name="new_sveramais" placeholder="Jauns skaits/svars">
                                                        <div class="buttons-container" style="text-align: center">
                                                            <button type="submit" class="btn btn-success">Rediģēt</button>
                                                            <button type="button" class="btn btn-danger" onclick="hidePopupBox2()">Atcelt</button>
                                                        </div>
                                                    </form>
                                                    @endif
                                                </div>
                                        </td></tr>
                                    </tbody>
                                </table>
                                <br>
                            <button type="submit" class="btn btn-danger" onclick="showPopupBox6()">Dzēst</button>
                            <div id="popup-box6">
                                <form action="{{ route('remove', $product->pirkumsid) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                    <br>
                                <h3>Vai vēlaties dzēst?</h3>
                                    <div class="buttons-container" style="text-align: center">
                                       <button type="submit" class="btn btn-danger">Jā</button>
                                       <button type="button" class="btn btn-success" onclick="hidePopupBox6()">Nē</button>
                                    </div>
                                </form>
                            </div>
                            <br>
                        </div>
                        @endforeach
                    @endif
                @endforeach
          </div>
         <br>
    </div>
@endsection
