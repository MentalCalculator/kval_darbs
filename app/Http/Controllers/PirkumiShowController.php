<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PirkumiShowController extends Controller
{
    public function products(Request $request)
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
                ->select('id', 'pirkumsid', 'created_at', 'nosaukums', 'cena', 'sveramais', 'sveramaistype', 'total')
                ->where('userid', '=', $user_id)
                ->where('pirkumsid', '=', $pirkums_id)
                ->get();
            foreach ($products as $product) {
                if ($product->sveramaistype == 'Skaits') {
                    $product->sveramais = number_format($product->sveramais);
                } elseif ($product->sveramaistype == 'Svars') {
                    if (round($product->sveramais) == $product->sveramais) {
                        $product->sveramais = number_format($product->sveramais);
                    } else {
                        $product->sveramais = number_format($product->sveramais, 3);
                    }
                }
            }
            $data[$pirkums_id] = $products;
        }

        return view('Home', compact('data','pirkumi'));

    }
}
