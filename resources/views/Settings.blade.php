@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 50px;">
    <div class="summary-box" id="popup3">
    <h1 class="text-danger" style="">Profils</h1>
    </div>
        <br><br><br>
        <div class="summary-box">
            <h2> Lietotājvārds: {{ Auth::user()->name }} <button class="btn btn-primary" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop4">Rediģēt</button></h2>
            <div class="modal fade" id="staticBackdrop4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="{{ route('userchange') }}" method="POST">
                                <br>
                                @csrf
                                <input type="text"class="form-control @error('name') is-invalid @enderror" name="new_username" placeholder="Jauns nosaukums" required>
                                <div class="buttons-container" style="text-align: center">
                                    <button class="btn btn-success">Mainīt lietotājvārdu!</button>
                                    <button type="button" class="btn btn-danger" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Atcelt</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="summary-box">
        <h2>E-Pasts: {{ Auth::user()->email }} <button class="btn btn-primary" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop5">Rediģēt</button></h2>
            <div class="modal fade" id="staticBackdrop5" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="{{ route('emailchange') }}" method="POST">
                                <br>
                                @csrf
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="new_email" placeholder="Jauns e-pasts" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert" style="text-align: center;">
                                <strong>Trūkst @ zīmes!</strong>
                                </span>
                                @enderror
                                <div class="buttons-container" style="text-align: center">
                                    <button class="btn btn-success">Mainīt e-pastu</button>
                                    <button type="button" class="btn btn-danger" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Atcelt</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="summary-box">
           <h2>Parole: .............. <button class="btn btn-primary" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop6">Rediģēt</button></h2>
            <div class="modal fade" id="staticBackdrop6" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="{{ route('passwordchange') }}" method="POST">
                                @csrf
                                <br>
                                <div class="form-group">
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new_password" placeholder="Jauna parole" required>
                                    @error('new_password')
                                    <span class="invalid-feedback" role="alert" style="text-align: center;">
                                    <strong>Paroles neatkārtojās!</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" id="new_password_confirmation" placeholder="Atkārtot jauno paroli" required>
                                    @error('new_password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="buttons-container" style="text-align: center">
                                    <button type="submit" class="btn btn-success">Mainīt Paroli</button>
                                    <button type="button" class="btn btn-danger" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Atcelt</button>
                                </div>
                            </form>
                       </div>
                    </div>
                </div>
          </div>
    </div>
@endsection
