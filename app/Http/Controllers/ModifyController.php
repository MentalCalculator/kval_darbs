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
        $name = $request->input('new_name');
        $input1 = $request->input('new_price');
        $input2 = $request->input('new_amount');
        $currentprice = $product->productprice;
        $currentusedprice = $usedproduct->productprice;
        $currentamount = $product->productamount;
        $currentusedamount = $usedproduct->productamount;

        $price = str_replace(',', '.', $input1);
        $amount = str_replace(',', '.', $input2);

        if ($name == null and $price == null and $amount == null) {
            $request->validate([
                'new_name' => 'required',
                'new_price' => 'required',
                'new_amount' => 'required',
            ]);
        }
        if ($name == Null and $price == Null) {
            $product->productamount = $amount;
            $product->total = $currentprice * $amount;

            $usedproduct->productamount = $amount;
            $usedproduct->total = $currentusedprice * $amount;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } elseif ($price == Null and $amount == Null) {
            $product->productname = $name;

            $usedproduct->productname = $name;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } elseif ($name == Null and $amount == null) {
            $product->productprice = $price;
            $product->total = $price * $currentamount;

            $usedproduct->productprice = $price;
            $usedproduct->total = $price * $currentusedamount;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } elseif ($name == Null) {
            $product->productprice = $price;
            $product->productamount = $amount;
            $product->total = $price * $amount;

            $usedproduct->productprice = $price;
            $usedproduct->productamount = $amount;
            $usedproduct->total = $price * $amount;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } elseif ($price == Null) {
            $product->productname = $name;
            $product->productamount = $amount;
            $product->total = $currentprice * $amount;

            $usedproduct->productname = $name;
            $usedproduct->productamount = $amount;
            $usedproduct->total = $currentusedprice * $amount;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } elseif ($amount == Null) {
            $product->productname = $name;
            $product->productprice = $price;
            $product->total = $price * $currentamount;

            $usedproduct->productname = $name;
            $usedproduct->productprice = $price;
            $usedproduct->total = $price * $currentusedamount;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        } else {
            $product->productname = $name;
            $product->productprice = $price;
            $product->productamount = $amount;
            $product->total = $price * $amount;

            $usedproduct->productname = $name;
            $usedproduct->productprice = $price;
            $usedproduct->productamount = $amount;
            $usedproduct->total = $price * $amount;

            $product->save();
            $usedproduct->save();
            return redirect()->back();
        }
    }
}
