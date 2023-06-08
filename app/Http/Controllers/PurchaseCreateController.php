<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Purchases;
use App\Models\Products;
use App\Models\UsedProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseCreateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function purchasecreate(Request $request)
    {
        $randomnumbers = random_int(1, 1000000000000);
        $productnames = $request->input('productname');
        $productprices = $request->input('productprice');
        $productamounts = $request->input('productamount');
        $producttypes = $request->input('producttype');

            if (!empty($productnames)) {
                $purchases = new Purchases;
                $purchases->id = $randomnumbers;
                $purchases->userid = Auth::id();
                $purchases->created_at = Carbon::now()->tz(Auth::user()->timezone);
                $purchases->updated_at = Carbon::now()->tz(Auth::user()->timezone);
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
                    $products->created_at = Carbon::now()->tz(Auth::user()->timezone);
                    $products->updated_at = Carbon::now()->tz(Auth::user()->timezone);

                    $usedproducts = new UsedProducts();
                    $usedproducts->id = $randomnumberproduct;
                    $usedproducts->mainproductid = $randomnumberproduct;
                    $usedproducts->UsedPurchaseid = $randomnumbers;
                    $usedproducts->userid = Auth::id();
                    $usedproducts->productname = $productname;
                    $usedproducts->productprice = $productprice;
                    $usedproducts->productamount = $productamount;
                    $usedproducts->producttype = $producttype;
                    $usedproducts->total = $totalsum;
                    $usedproducts->created_at = Carbon::now()->tz(Auth::user()->timezone);
                    $usedproducts->updated_at = Carbon::now()->tz(Auth::user()->timezone);

                    $products->save();
                    $usedproducts->save();
                }
            }
            return redirect()->back();
    }
}
