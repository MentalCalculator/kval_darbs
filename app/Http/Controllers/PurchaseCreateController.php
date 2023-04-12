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
        $productnames = $request->input('productname');
        $productprices = $request->input('productprice');
        $productamounts = $request->input('productamount');
        $producttypes = $request->input('producttype');

        $purchases = new Purchases;
        $purchases->id = $randomnumbers;
        $purchases->userid = Auth::id();
        $purchases->created_at = now();
        $purchases->updated_at = now();
        $purchases->save();


        foreach ($productnames as $key => $productname) {
            $randomnumberproduct = random_int(1, 1000000000000);
            $productprice = $productprices[$key];
            $productamount = $productamounts[$key] ?? 1;
            $producttype = $producttypes[$key];

            $totalsum = $productprice * $productamount;

            $products = new Products;
            $products->id = $randomnumberproduct;
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
            $usedproducts->productid = $randomnumberproduct;
            $usedproducts->mainid = $products->id;
            $usedproducts->userid = Auth::id();
            $usedproducts->productname = $productname;
            $usedproducts->productprice = $productprice;
            $usedproducts->productamount = $productamount;
            $usedproducts->producttype = $producttype;
            $usedproducts->total = $totalsum;
            $usedproducts->created_at = now();
            $usedproducts->updated_at = now();

            $usedproducts->save();
            $products->save();
        }
        return redirect()->back();
    }
}
