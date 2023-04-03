<?php

namespace App\Http\Controllers;

use App\Models\Purchases;
use App\Models\Products;
use App\Models\UsedProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseCreateController extends Controller
{
    public function purchasecreate (Request $request)
    {
        $randomnumbers = random_int(1, 1000000000000);
        $productname = $request->input('productname');
        $productprice = $request->input('productprice');
        $productamount = $request->input('productamount');

        $request->validate(['productname' => 'required|max:100',], ['productname.required' => 'Please fill in this field',]);

        if ($productamount == null) {
            $productamount = 1;
        }

        if(isset($_POST['producttype'])) {
            $producttype = $_POST['producttype'];
        }

        $totalsum = $productprice * $productamount;

            $purchases = new Purchases;

            $purchases->id = $randomnumbers;
            $purchases->userid = Auth::id();
            $purchases->created_at = now();
            $purchases->updated_at = now();

            $products = new Products;

            $products->id = $randomnumbers;
            $products->userid = Auth::id();
            $products->purchaseid = $purchases->id;
            $products->productname = $productname;
            $products->productprice = $productprice;
            $products->productamount = $productamount;
            $products->producttype = $producttype;
            $products->total = $totalsum;
            $products->created_at = now();
            $products->updated_at = now();

            $usedproducts = new UsedProducts();

            $usedproducts->id = $products->id;
            $usedproducts->userid = Auth::id();
            $usedproducts->productname = $productname;
            $usedproducts->productprice = $productprice;
            $usedproducts->productamount = $productamount;
            $usedproducts->producttype = $producttype;
            $usedproducts->total = $totalsum;
            $usedproducts->created_at = now();
            $usedproducts->updated_at = now();

            $usedproducts->save();
            $purchases->save();
            $products->save();

            return redirect()->back();
    }
}
