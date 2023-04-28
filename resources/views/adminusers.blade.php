@extends('layouts.adminapp')

@section('content')
<div class="container" style="margin-top: 50px; overflow: auto">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="summary-box" style="margin-top: 10px">
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
                    <input type="name" name="search" class="form-control" value="{{ Session::get('userSearch', '') }}" placeholder="Username" required/>
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
        <table>
            <thead>
            <th>User ID</th>
            <th>Username</th>
            <th>E-Mail</th>
            <th>Creation Date</th>
            <th></th>
            <th></th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2_{{$user->id}}" data-product-id="{{$user->id}}">Modify</button>
                            <div class="modal fade" id="staticBackdrop2_{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel2">Modify User</h1>
                                        </div>
                                    <div class="modal-body">
                                        <table>
                                            <tbody>
                                            <thead>
                                            <th>User ID</th>
                                            <th>Username</th>
                                            <th>E-Mail</th>
                                            </thead>
                                            <tr>
                                                <td>{{$user->id}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <form method="POST" action="{{ route('adminuserupdate', ['id' => $user->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <!-- Include product ID as hidden input field -->
                                            <input type="hidden" name="product_id" value="{{$user->id}}">
                                            <input type="text" class="form check" name="new_name" id="new_name" placeholder="New user name" style="margin-top: 10px;">
                                            <input type="email" class="form check" name="new_email" id="new_email" placeholder="New user e-mail" style="margin-top: 10px;">
                                            <input type="password" class="form check" name="new_password" id="new_password" placeholder="New user password" style="margin-top: 10px;">
                                            <input type="password" class="form check" name="new_password_repeat" id="new_password_repeat" placeholder="Repeat password" style="margin-top: 10px;">
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
                    </td>
                    <td>
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
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
