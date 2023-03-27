@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 50px;">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <h1 style="text-align: center">Kopsavilkums!</h1>
        <div class="summary-box">
            <h2>Kopējais pirkumu skaits: <?php echo $Count1;?></h2>
        </div>
        <div class="summary-box">
            <h2>Kopējais produktu skaits: <?php echo $Count2;?></h2>
        </div>
        <div class="summary-box">
            <h2>Kopējā iztērētā summa: <?php echo $Count3;?>€</h2>
        </div>
    </div>
@endsection
