<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileEditController extends Controller
{
    public function userchange(Request $request) {
        $user = User::findOrFail(Auth::id());
        $user->name = $request->input('new_username');
        $user->save();
        return redirect()->back();
    }

    public function emailchange(Request $request) {
        $user = User::findOrFail(Auth::id());
        $user->email = $request->input('new_email');
        $user->save();
        return redirect()->back();
    }

    public function passwordchange(Request $request) {
        $user = User::findOrFail(Auth::id());
        $user->password = bcrypt($request->input('new_password'));
        $user->save();
        return redirect()->back();
    }
}
