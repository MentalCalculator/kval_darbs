<?php

namespace App\Http\Controllers;

use Cassandra\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Purchases;
use App\Models\Products;
use App\Models\UsedProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PirkumiController extends Controller
{
    public function pirkums (Request $request)
    {

        $randomnumbers = random_int(1, 1000000000000);
        $nosaukums = $request->input('nosaukums');
        $cena = $request->input('cena');
        $sveramais = $request->input('sveramais');

        if (empty($sveramais) || is_null($sveramais)) {
            $sveramais = 1;
            $totalsum = $cena;
        } else {
            $totalsum = $cena * $sveramais;
        }

        if ($nosaukums == null or $cena == null) {
            $request->validate([
                'nosaukums' => 'required',
                'cena' => 'required',
                'sveramais' => 'required',
            ]);
        } else {
            $purchases = new Purchases;

            $purchases->id = $randomnumbers;
            $purchases->userid = Auth::id();
            $purchases->created_at = now();
            $purchases->updated_at = now();
            $purchases->save();

            $Products = new Products;

            $Products->id = $randomnumbers;
            $Products->userid = Auth::id();
            $Products->pirkumsid = $randomnumbers;
            $Products->nosaukums = $nosaukums;
            $Products->cena = $cena;
            $Products->sveramais = $sveramais;
            $Products->total = $totalsum;
            $Products->created_at = now();
            $Products->updated_at = now();
            $Products->save();

            $usedproducts = new UsedProducts();

            $usedproducts->id = $randomnumbers;
            $usedproducts->userid = Auth::id();
            $usedproducts->nosaukums = $nosaukums;
            $usedproducts->cena = $cena;
            $usedproducts->sveramais = $sveramais;
            $usedproducts->total = $totalsum;
            $usedproducts->created_at = now();
            $usedproducts->updated_at = now();
            $usedproducts->save();

            $user_id = Auth::id();
            $pirkumi = DB::table('pirkumi')
                ->select('id', 'created_at')
                ->where('userid', '=', $user_id)
                ->get();

            $data = [];
            foreach ($pirkumi as $p) {
                $pirkums_id = $p->id;
                $products = DB::table('produkti')
                    ->select('id', 'pirkumsid', 'created_at', 'nosaukums', 'cena', 'sveramais', 'total')
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

            return view('Home', compact('data', 'pirkumi'));
        }
    }

}
