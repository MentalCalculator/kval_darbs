<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductDateController extends Controller
{
    public function productsdate(Request $request)
    {
        $user_id = Auth::id();
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');

        $usedproducts = DB::table('produkti')
            ->select('id', 'pirkumsid', 'created_at', 'nosaukums', 'cena', 'sveramais', 'sveramaistype', 'total')
            ->where('userid', '=', $user_id)
            ->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])
            ->get();
        foreach ($usedproducts as $product) {
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
        return view('Products',['products'=>$usedproducts]);
    }
}
