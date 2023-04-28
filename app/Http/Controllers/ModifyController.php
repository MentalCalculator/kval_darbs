<?php

namespace App\Http\Controllers;

use App\Models\Purchases;
use App\Models\UsedProducts;
use Illuminate\Http\Request;
use App\Models\Products;

class ModifyController extends Controller
{
    public function productupdate(Request $request, $id)
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
        if ($name != Null) {
            $product->productname = $name;

            $usedproduct->productname = $name;
        }
        if ($price != Null) {
            $product->productprice = $price;
            $currentprice = $price;

            $usedproduct->productprice = $price;
            $currentusedprice = $price;
        }
        if ($amount != Null) {
            $product->productamount = $amount;
            $currentamount = $amount;

            $usedproduct->productamount = $amount;
            $currentusedamount = $amount;
        }

        $product->total = $currentprice * $currentamount;
        $usedproduct->total = $currentusedprice * $currentusedamount;
        $product->save();
        $usedproduct->save();
        return redirect()->back();
    }

    public function removepurchase($id)
    {
        $purchase = Purchases::find($id);

        if ($purchase) {
            // Delete all related products for the purchase
            $products = Products::where('purchaseid', $id)->get();
            foreach ($products as $product) {
                $product->delete();
            }

            // Delete all related used products for the purchase
            $usedproducts = UsedProducts::where('UsedPurchaseid', $id)->get();
            foreach ($usedproducts as $usedproduct) {
                $usedproduct->delete();
            }

            $purchase->delete();

            return redirect()->back();
        } else {
            // Handle case when purchase is not found
            return redirect()->back()->with('error', 'Purchase not found');
        }
    }
    public function removeproduct($id)
    {
        $product = Products::find($id);

        if ($product) {
            $purchaseId = $product->purchaseid;

            // Delete the product
            $product->delete();

            // Check if the purchase has any other products
            $remainingProducts = Products::where('purchaseid', $purchaseId)->count();
            if ($remainingProducts === 0) {
                // If no other products exist for the purchase, delete the purchase as well
                $purchase = Purchases::find($purchaseId);
                if ($purchase) {
                    $purchase->delete();
                }
            }

            // Delete the associated used product
            $usedproduct = UsedProducts::find($id);
            if ($usedproduct) {
                $usedproduct->delete();
            }

            return redirect()->back();
        } else {
            // Handle case when product is not found
            return redirect()->back()->with('error', 'Product not found');
        }
    }
}
