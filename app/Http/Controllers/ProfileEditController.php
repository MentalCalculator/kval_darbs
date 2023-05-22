<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileEditController extends Controller
{
    public function userchange(Request $request) {
        $user = User::findOrFail(Auth::id());
        $user->name = $request->input('new_username');
        $user->updated_at = Carbon::now()->tz(Auth::user()->timezone);
        $user->save();
        return redirect()->back();
    }

    public function emailchange(Request $request) {
        $user = User::findOrFail(Auth::id());
        $user->email = $request->input('new_email');
        $user->updated_at = Carbon::now()->tz(Auth::user()->timezone);
        $user->save();
        return redirect()->back();
    }

    public function passwordchange(Request $request) {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'new_password' => ['required', 'confirmed'],
        ]);

        $user->password = bcrypt($request->input('new_password'));
        $user->updated_at = Carbon::now()->tz(Auth::user()->timezone);
        $user->save();

        return redirect()->back();
    }
}
