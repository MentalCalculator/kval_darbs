@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 50px;">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="summary-box">
        <h1 style="text-align: center">Total!</h1>
    </div>
        <br>
    <form method="GET" action="{{route('totaldate')}}">
        <div class="container" style="height: 50px; width: 500px">
            <div class="input-group mb-3">
                <input type="date" class="form-control" id="startdate" name="startdate" required>
                <input type="date" class="form-control" id="enddate" name="enddate" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <div class="summary-box">
        <h2>Total purchases count: <?php echo $Count1;?></h2>
    </div>
    <div class="summary-box">
        <h2>Total product count: <?php echo $Count2;?></h2>
    </div>
    <div class="summary-box">
        <h2>Total cost: <?php echo $Count3;?>€</h2>
    </div>
</div>
@endsection
