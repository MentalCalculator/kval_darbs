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
                ->select('id', 'pirkumsid', 'nosaukums', 'cena', 'sveramais', 'total', 'created_at')
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
    public function pirkumi()
    {
        return view('purchases');
    }
    public function total()
    {
        return view('Total');
    }
    public function profile()
    {
        return view('Profile');
    }
}
