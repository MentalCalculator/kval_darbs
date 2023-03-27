<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;

class TotalController extends Controller
{
    public function totalcount() {
        $user_id = Auth::id();

        $data1 = DB::table('pirkumi')->select('userid')->where('userid','=',$user_id)->get();
        $data2 = DB::table('produkti')->select('userid')->where('userid','=',$user_id)->get();
        $data3 = DB::table('produkti')->select(DB::raw('SUM(total) as total'))->where('userid','=',$user_id)->first();

        $count1 = $data1->count();
        $count2 = $data2->count();
        $count3 = $data3 ? $data3->total ?? "0.00" : "0.00";

        $total = $count1 + $count2 + $count3;

        return view('Total', ['Count1' => $count1, 'Count2' => $count2, 'Count3' => $count3, 'Total' => $total]);
    }
}
