<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Logging In Entering the Purchases (Home) Page
    public function index()
    {
        $user_id = Auth::id();
        $pirkumi = DB::table('pirkumi')
            ->select('id','created_at')
            ->where('userid', '=', $user_id)
            ->get();

        $data = [];
        foreach ($pirkumi as $p) {
            $pirkums_id = $p->id;
            $products = DB::table('produkti')
                ->select('id', 'pirkumsid', 'nosaukums', 'cena', 'sveramais', 'sveramaistype', 'total', 'created_at')
                ->where('userid', '=', $user_id)
                ->where('pirkumsid', '=', $pirkums_id)
                ->get();
            foreach ($products as $product) {
                if (round($product->sveramais) == $product->sveramais) {
                    $product->sveramais = number_format($product->sveramais);
                } else {
                    $product->sveramais = number_format($product->sveramais, 3);
                }
            }
            $data[$pirkums_id] = $products;
        }

        return view('Home', compact('data','pirkumi'));
    }
    // Purchases Page
    public function purchases()
    {
        $user_id = Auth::id();
        $pirkumi = DB::table('pirkumi')
            ->select('id','created_at')
            ->where('userid', '=', $user_id)
            ->get();

        $data = [];
        foreach ($pirkumi as $p) {
            $pirkums_id = $p->id;
            $products = DB::table('produkti')
                ->select('id', 'pirkumsid', 'nosaukums', 'cena', 'sveramais', 'sveramaistype', 'total', 'created_at')
                ->where('userid', '=', $user_id)
                ->where('pirkumsid', '=', $pirkums_id)
                ->get();
            foreach ($products as $product) {
                if (round($product->sveramais) == $product->sveramais) {
                    $product->sveramais = number_format($product->sveramais);
                } else {
                    $product->sveramais = number_format($product->sveramais, 3);
                }
            }
            $data[$pirkums_id] = $products;
        }

        return view('Home', compact('data','pirkumi'));
    }


    // Total Page
    public function total()
    {
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
    public function profile()
    {
        return view('Settings');
    }
}
