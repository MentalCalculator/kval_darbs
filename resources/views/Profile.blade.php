@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 50px;">
    <h1 class="text-danger" style="">Profils</h1>
        <br><br><br>
        <div class="summary-box">
        <h2>Lietotājvārds: {{ Auth::user()->name }} <button class="btn btn-primary" onclick="showPopupBox3()">Mainīt</button></h2>
        <div id="popup-box3">
        <form action="{{ route('userchange') }}" method="POST">
            <br>
            @csrf
            <input type="text"class="form-control @error('name') is-invalid @enderror" name="new_username" placeholder="Jauns nosaukums" required>
            <div class="buttons-container" style="text-align: center">
            <button class="btn btn-success">Mainīt lietotājvārdu</button>
            <button type="button" class="btn btn-danger" onclick="hidePopupBox3()">Atcelt</button>
            </div>
        </form>
        </div>
        </div>
        <div class="summary-box">
        <h2>E-Pasts: {{ Auth::user()->email }} <button class="btn btn-primary" onclick="showPopupBox4()">Mainīt</button></h2>
        <div id="popup-box4">
        <form action="{{ route('emailchange') }}" method="POST">
            <br>
            @csrf
            <input type="email" class="form-control @error('name') is-invalid @enderror" name="new_email" placeholder="Jauns e-pasts" required>
            <div class="buttons-container" style="text-align: center">
            <button class="btn btn-success">Mainīt e-pastu</button>
            <button type="button" class="btn btn-danger" onclick="hidePopupBox4()">Atcelt</button>
            </div>
        </form>
        </div>
        </div>
        <div class="summary-box">
        <h2>Parole: .............. <button class="btn btn-primary" onclick="showPopupBox5()">Mainīt</button></h2>
        <div id="popup-box5">
        <form action="{{ route('passwordchange') }}" method="POST">
            <br>
            @csrf
            <input type="password" class="form-control @error('name') is-invalid @enderror" name="new_password" placeholder="Jauna parole" required>
            <div class="buttons-container" style="text-align: center">
            <button class="btn btn-success">Mainīt Paroli</button>
            <button type="button" class="btn btn-danger" onclick="hidePopupBox5()">Atcelt</button>
            </div>
        </form>
        </div>
        </div>
    </div>
@endsection
