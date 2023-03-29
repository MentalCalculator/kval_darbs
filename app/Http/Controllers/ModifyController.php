<?php

namespace App\Http\Controllers;

use App\Models\UsedProducts;
use Illuminate\Http\Request;
use App\Models\Products;

class ModifyController extends Controller
{
    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $usedproduct = UsedProducts::findOrFail($id);
        $nosaukums = $request->input('new_nosaukums');
        $input1 = $request->input('new_cena');
        $input2 = $request->input('new_sveramais');
        $currentcena = $product->cena;
        $currentusedcena = $usedproduct->cena;
        $currentsveramais = $product->sveramais;
        $currentusedsveramais = $usedproduct->sveramais;

        $cena = str_replace(',', '.', $input1);
        $sveramais = str_replace(',', '.', $input2);

        if ($nosaukums == null and $cena == null and $sveramais == null) {
            $request->validate([
                'new_nosaukums' => 'required',
                'new_cena' => 'required',
                'new_sveramais' => 'required',
            ]);
        }
        if ($nosaukums == Null and $cena == Null) {
            $product->sveramais = $sveramais;
            $product->total = $currentcena * $sveramais;

            $usedproduct->sveramais = $sveramais;
            $usedproduct->total = $currentusedcena * $sveramais;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } elseif ($cena == Null and $sveramais == Null) {
            $product->nosaukums = $nosaukums;

            $usedproduct->nosaukums = $nosaukums;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } elseif ($nosaukums == Null and $sveramais == null) {
            $product->cena = $cena;
            $product->total = $cena * $currentsveramais;

            $usedproduct->cena = $cena;
            $usedproduct->total = $cena * $currentusedsveramais;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } elseif ($nosaukums == Null) {
            $product->cena = $cena;
            $product->sveramais = $sveramais;
            $product->total = $cena * $sveramais;

            $usedproduct->cena = $cena;
            $usedproduct->sveramais = $sveramais;
            $usedproduct->total = $cena * $sveramais;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } elseif ($cena == Null) {
            $product->nosaukums = $nosaukums;
            $product->sveramais = $sveramais;
            $product->total = $currentcena * $sveramais;

            $usedproduct->nosaukums = $nosaukums;
            $usedproduct->sveramais = $sveramais;
            $usedproduct->total = $currentusedcena * $sveramais;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } elseif ($sveramais == Null) {
            $product->nosaukums = $nosaukums;
            $product->cena = $cena;
            $product->total = $cena * $currentsveramais;

            $usedproduct->nosaukums = $nosaukums;
            $usedproduct->cena = $cena;
            $usedproduct->total = $cena * $currentusedsveramais;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } else {
            $product->nosaukums = $nosaukums;
            $product->cena = $cena;
            $product->sveramais = $sveramais;
            $product->total = $cena * $sveramais;

            $usedproduct->nosaukums = $nosaukums;
            $usedproduct->cena = $cena;
            $usedproduct->sveramais = $sveramais;
            $usedproduct->total = $cena * $sveramais;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        }
    }
}
