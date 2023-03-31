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
            <br><br>
                <form method="GET" action="{{route('purchasessearch')}}">
                    <div class="container" style="height: 20px; width: 500px">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Nosaukums" required>
                            <button class="btn btn-primary" type="submit" style="margin-bottom: 10px">Meklēt</button>
                        </div>
                    </div>
                </form>
                <br>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Izveido pirkumu
                </button>
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Izveidojiet pirkumu</h1>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{route('purchasecreate')}}">
                                    @csrf
                                    <input type="text" class="form-control" name="nosaukums" id="nosaukums" placeholder="Produkta Nosaukums" maxlength="100" required>
                                    <input type="number" class="form-control @error('name') is-invalid @enderror" name="cena" step="0.01" id="cena" placeholder="Cena Par Vienību" required>
                                    @error('nosaukums')
                                    <span class="invalid-feedback" role="alert" style="text-align: center;">
                                    <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                    <div class="text-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sveramaistype" id="Skaits" value="Skaits" pattern="\d+" onclick="changeStep(1)", required>
                                            <label class="form-check-label" for="Skaits">
                                                Skaits
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sveramaistype" id="Svars" value="Svars" onclick="changeStep(0.001)" required style="color: #4a5568">
                                            <label class="form-check-label" for="Svars">
                                                Svars
                                            </label>
                                            <div class="invalid-feedback">Izvēlieties tipu!</div>
                                        </div>
                                    </div>
                                    <input type="number" class="form-control @error('name') is-invalid @enderror" name="sveramais" id="sveramais" oninput="preventDecimal(event)" placeholder="Skaits/Svars*" >
                                    <h6 style="text-align: center">Skaits/Svars paliks 1, ja nav ievadīta vērtība.</h6>
                                    <br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Pievienot') }}
                                </button>
                                <button type="button" class="btn btn-danger" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Atcelt</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div id="power">
                @foreach ($data as $pirkums_id => $products)
                    @if (!empty($products))
                        @foreach ($products as $product)
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
                                    <tbody>
                                    <tr><td>{{ $product->nosaukums }}</td>
                                            <td>
                                                @if($product->sveramaistype == 'Svars')
                                                {{ $product->cena }}€/KG
                                                @else
                                                {{ $product->cena }}€
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->sveramaistype == 'Svars')
                                                    {{ $product->sveramais }} KG
                                                @else
                                                    {{ $product->sveramais }}
                                                @endif
                                            </td>
                                        <td>{{ $product->total }}€</td>
                                        <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">
                                                Rediģēt
                                            </button>
                                            <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel" style="text-align: center;">Rediģēt produktu</h1>
                                                        </div>
                                                        <div class="modal-body">
                                                        @if ($product->id == $product->id)
                                                        <form action="{{ route('productsupdate', $product->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <br>
                                                        <table style="margin: auto">
                                                        <thead>
                                                        <th>Produkta Nosaukums</th>
                                                        <th>Produkta Cena</th>
                                                        <th>Produkta Skaits/Svars(KG)</th>
                                                        </thead>
                                                        <tbody>
                                                        <tr style="background-color: #bdcfe7"><td>{{ $product->nosaukums }}</td>
                                                                <td>
                                                                    @if($product->sveramaistype == 'Svars')
                                                                        {{ $product->cena }}€/KG
                                                                    @else
                                                                        {{ $product->cena }}€
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($product->sveramaistype == 'Svars')
                                                                        {{ $product->sveramais }} KG
                                                                    @else
                                                                        {{ $product->sveramais }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        </table>
                                                        <br>
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="new_nosaukums" maxlength="20" placeholder="Jauns nosaukums">
                                                        <input type="number" class="form-control @error('name') is-invalid @enderror" name="new_cena" step="0.01" placeholder="Jauna cena">
                                                        @if($product->sveramaistype == 'Svars')
                                                        <input type="number" class="form-control @error('name') is-invalid @enderror" name="new_sveramais" step="0.001" placeholder="Jauns svars">
                                                        @else
                                                        <input type="number" class="form-control @error('name') is-invalid @enderror" name="new_sveramais" step="1" placeholder="Jauns skaits">
                                                        @endif
                                                        <br>
                                                        <div class="modal-footer">
                                                          <button type="submit" class="btn btn-success">Rediģēt</button>
                                                          <button type="button" class="btn btn-danger" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Atcelt</button>
                                                        </div>
                                                </form>
                                            @endif
                                        </td></tr>
                                    </tbody>
                                </table>
                                <br>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">
                                    Dzēst
                                </button>
                                <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                            <form action="{{ route('remove', $product->pirkumsid) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <br>
                                            <h3>Vai vēlaties dzēst?</h3>
                                            <div class="buttons-container" style="text-align: center">
                                            <button type="submit" class="btn btn-danger">Jā</button>
                                            <button type="button" class="btn btn-success" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Nē</button>
                                             </div>
                                            </form>
                                            </div>
                                         </div>
                                    </div>
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
