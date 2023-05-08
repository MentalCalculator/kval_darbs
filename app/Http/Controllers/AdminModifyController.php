<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Purchases;
use App\Models\UsedProducts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AdminModifyController extends Controller
{
    public function adminremoveproduct($id)
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

    public function adminproductupdate(Request $request, $id)
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

    public function adminremovepurchase($id)
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

    public function adminmodifyuser(Request $request, $id)
    {
        $user = User::find($id);
        $name = $request->input('new_name');
        $email = $request->input('new_email');
        $password = $request->input('new_password');
        $passwordrepeat = $request->input('new_password_repeat');
        if ($name == null and $email == null and $password == null) {
            $request->validate([
                'new_name' => 'required',
                'new_email' => 'required',
                'new_password' => 'required',
            ]);
        }
        if ($name != Null) {
            $user->name = $name;
        }
        if ($email != Null) {
            $user->email = $email;
        }
        if ($password != Null) {
            if ($password == $passwordrepeat) {
                $user->password = $password;
            }
        }

        $user->save();
        return redirect()->back();
    }

    public function adminremoveuser($id)
    {
        $user = User::find($id);
        $products = Products::where('userid', $id)->get();
        foreach ($products as $product) {
            $product->delete();
        }

        // Delete all related used products for the purchase
        $usedproducts = UsedProducts::where('userid', $id)->get();
        foreach ($usedproducts as $usedproduct) {
            $usedproduct->delete();
        }
        $user->delete();
        return redirect()->back();
    }
}
