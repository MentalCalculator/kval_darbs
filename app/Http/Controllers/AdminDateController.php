<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDateController extends Controller
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

    public function adminpurchasesdate(Request $request)
    {
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');

        $purchases = DB::table('purchases')
            ->select('id','userid', 'created_at')
            ->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])
            ->get();

        $data = [];
        $totalSums = [];
        foreach ($purchases as $p) {
            $purchase_id = $p->id;
            $products = DB::table('products')
                ->select('id', 'purchaseid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
                ->where('purchaseid', '=', $purchase_id)
                ->get();
            $totalSum = $products->sum('total');
            $totalSum = number_format($totalSum, 2);
            foreach ($products as $product) {
                if ($product->producttype == 'amount') {
                    $product->productamount = number_format($product->productamount);
                } elseif ($product->producttype == 'weight') {
                    if (round($product->productamount) == $product->productamount) {
                        $product->productamount = number_format($product->productamount);
                    } else {
                        $product->productamount = number_format($product->productamount, 3);
                    }
                }
            }

            $data[$purchase_id] = $products;
            $totalSums[$purchase_id] = $totalSum;
        }

        return view('adminpurchases', compact('data', 'purchases', 'totalSums'));
    }

    public function adminproductsdate(Request $request)
    {
        // Identifies the Date input.
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');

        // Calls data from the tables.
        $usedproducts = DB::table('products')
            ->select('id','userid', 'purchaseid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
            ->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])
            ->get();

        foreach ($usedproducts as $product) {
            if ($product->producttype == 'amount') {
                $product->productamount = number_format($product->productamount);
            } elseif ($product->producttype == 'weight') {
                if (round($product->productamount) == $product->productamount) {
                    $product->productamount = number_format($product->productamount);
                } else {
                    $product->productamount = number_format($product->productamount, 3);
                }
            }
        }

        return view('adminproducts', ['products' => $usedproducts]);
    }

    public function adminuserdate(Request $request) {

        // Identifies the Date input.
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');

        $users = DB::table('users')
            ->select('id','name','email','password', 'created_at','is_admin')
            ->where('is_admin','=',false)
            ->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])
            ->get();

        return view('adminusers', compact('users'));
    }
}
