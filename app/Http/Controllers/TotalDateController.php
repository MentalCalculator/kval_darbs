<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TotalDateController extends Controller
{
    public function totalcountdate(Request $request) {

        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');

        $user_id = Auth::id();

        $data1 = DB::table('pirkumi')->select('userid','created_at')->where('userid','=',$user_id)->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])->get();
        $data2 = DB::table('produkti')->select('userid','created_at')->where('userid','=',$user_id)->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])->get();
        $data3 = DB::table('produkti')->select(DB::raw('SUM(total) as total'))->where('userid','=',$user_id)->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])->first();

        $count1 = $data1->count();
        $count2 = $data2->count();
        $count3 = $data3 ? $data3->total ?? "0.00" : "0.00";

        $total = $count1 + $count2 + $count3;

        return view('Total', ['Count1' => $count1, 'Count2' => $count2, 'Count3' => $count3, 'Total' => $total]);
    }
}
