@extends('layouts.adminapp')

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
                <h1 style="text-align: center">All users</h1>
            </div>
            <br>
            <form method="GET" action="{{route('adminusersearchid')}}">
                <div class="container" style="height: 50px; width: 500px">
                    <div class="input-group mb-3">
                        <input type="number" name="search" class="form-control" value="{{ Session::get('userSearch', '') }}" placeholder="User ID" required/>
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <br>
            <form method="GET" action="{{route('adminusersearchname')}}">
                <div class="container" style="height: 20px; width: 500px">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" value="{{ Session::get('userSearch', '') }}" placeholder="Username" required/>
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <br>
            <form method="GET" action="{{route('adminuserdate')}}">
                <div class="container" style="height: 50px; width: 500px">
                    <div class="input-group mb-3">
                        <input type="date" class="form-control" id="startdate" name="startdate" required>
                        <input type="date" class="form-control" id="enddate" name="enddate" required>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            <br>
            @foreach($users as $user)
                <div class="input-group mb-3">
                    <textarea id="UserID" rows="1" readonly>{{$user->id}}</textarea>
                    <textarea id="UserName" rows="1" readonly>{{$user->name}}</textarea>
                    <textarea id="UserEmail" rows="1" readonly>{{$user->email}}</textarea>
                    <textarea id="UserDate" rows="1" readonly>{{$user->created_at}}</textarea>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2_{{$user->id}}" data-product-id="{{$user->id}}">Modify</button>
                    <div class="modal fade" id="staticBackdrop2_{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel2">Modify User</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mb-3">
                                        <textarea id="UserEditID" rows="1" readonly>{{$user->id}}</textarea>
                                        <textarea id="UserEditName" rows="1" readonly>{{$user->name}}</textarea>
                                        <textarea id="UserEditEmail" rows="1" readonly>{{$user->email}}</textarea>
                                    </div>
                                    <form method="POST" action="{{ route('adminuserupdate', ['id' => $user->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <!-- Include product ID as hidden input field -->
                                        <input type="hidden" name="product_id" value="{{$user->id}}">
                                        <input type="text" class="form-control" name="new_name" id="new_name" placeholder="New user name" max="20" style="margin-top: 10px;">
                                        <input type="email" class="form-control" name="new_email" id="new_email" placeholder="New user e-mail" max="20" style="margin-top: 10px;">
                                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New user password" min="8" max="20" style="margin-top: 10px;">
                                        <input type="password" class="form-control" name="new_password_repeat" id="new_password_repeat" min="8" max="20" placeholder="Repeat password" style="margin-top: 10px;">
                                        <br>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Modify</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop3_{{$user->id}}" data-product-id="{{$user->id}}">Delete</button>
                    <div class="modal fade" id="staticBackdrop3_{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel3">Do you want to remove this user?</h1>
                                </div>
                                <form method="POST" action="{{ route('adminremoveuser', ['id' => $user->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">No</button>
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
