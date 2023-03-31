<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Purchases;
use App\Models\Products;
use App\Models\UsedProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class PirkumiCreateController extends Controller
{
    public function purchasecreate (Request $request)
    {
        $randomnumbers = random_int(1, 1000000000000);
        $nosaukums = $request->input('nosaukums');
        $cena = $request->input('cena');
        $sveramais = $request->input('sveramais');

        $request->validate(['nosaukums' => 'required|max:100',], ['nosaukums.required' => 'Please fill in this field',]);

        if ($sveramais == null) {
            $sveramais = 1;
        }

        if(isset($_POST['sveramaistype'])) {
            $sveramaistype = $_POST['sveramaistype'];
        }

        $totalsum = $cena * $sveramais;

            $purchases = new Purchases;

            $purchases->id = $randomnumbers;
            $purchases->userid = Auth::id();
            $purchases->created_at = now();
            $purchases->updated_at = now();

            $Products = new Products;

            $Products->id = $randomnumbers;
            $Products->userid = Auth::id();
            $Products->pirkumsid = $purchases->id;
            $Products->nosaukums = $nosaukums;
            $Products->cena = $cena;
            $Products->sveramais = $sveramais;
            $Products->sveramaistype = $sveramaistype;
            $Products->total = $totalsum;
            $Products->created_at = now();
            $Products->updated_at = now();

            $usedproducts = new UsedProducts();

            $usedproducts->id = $Products->id;
            $usedproducts->userid = Auth::id();
            $usedproducts->nosaukums = $nosaukums;
            $usedproducts->cena = $cena;
            $usedproducts->sveramais = $sveramais;
            $usedproducts->sveramaistype = $sveramaistype;
            $usedproducts->total = $totalsum;
            $usedproducts->created_at = now();
            $usedproducts->updated_at = now();

            $usedproducts->save();
            $purchases->save();
            $Products->save();

            return redirect()->back();
    }
}
