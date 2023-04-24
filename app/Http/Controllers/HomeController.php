<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Logging in and entering the Purchases (Home) Page
    public function index()
    {
        $user_id = Auth::id();
        $purchases = DB::table('purchases')
            ->select('id','created_at')
            ->where('userid', '=', $user_id)
            ->get();

        $data = [];
        foreach ($purchases as $p) {
            $purchase_id = $p->id;
            $products = DB::table('products')
                ->select('id', 'purchaseid', 'productname', 'productprice', 'productamount', 'producttype', 'total', 'created_at')
                ->where('userid', '=', $user_id)
                ->where('purchaseid', '=', $purchase_id)
                ->get();
            foreach ($products as $product) {
                if (round($product->productamount) == $product->productamount) {
                    $product->productamount = number_format($product->productamount);
                } else {
                    $product->productamount = number_format($product->productamount, 3);
                }
            }
            $data[$purchase_id] = $products;
        }

        return view('Home', compact('data','purchases'));
    }
    // Purchases Page
    public function purchases()
    {
        $user_id = Auth::id();
        $purchases = DB::table('purchases')
            ->select('id','created_at')
            ->where('userid', '=', $user_id)
            ->get();

        $data = [];
        foreach ($purchases as $p) {
            $purchase_id = $p->id;
            $products = DB::table('products')
                ->select('id', 'purchaseid', 'productname', 'productprice', 'productamount', 'producttype', 'total', 'created_at')
                ->where('userid', '=', $user_id)
                ->where('purchaseid', '=', $purchase_id)
                ->get();
            foreach ($products as $product) {
                if (round($product->productamount) == $product->productamount) {
                    $product->productamount = number_format($product->productamount);
                } else {
                    $product->productamount = number_format($product->productamount, 3);
                }
            }
            $data[$purchase_id] = $products;
        }

        return view('Home', compact('data','purchases'));
    }
    // Products Page
    public function products()
    {
        $user_id = Auth::id();

        $usedproducts = DB::table('usedproducts')
            ->select('id', 'mainproductid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
            ->where('userid', '=', $user_id)
            ->get();

        $groupedProducts = $usedproducts->groupBy(function ($product) {
            return $product->productname . '-' . $product->producttype . '-' . $product->productprice;
        });

        foreach ($groupedProducts as $group => $products) {
            $totalSum = $products->sum(function ($product) {
                // Convert productamount to float before summing
                return floatval($product->productamount) * $product->productprice;
            });
            $totalAmount = $products->sum('productamount');
            $groupedProducts[$group]->totalSum = $totalSum;
            $groupedProducts[$group]->totalAmount = $totalAmount;
        }

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

        return view('Products', ['products' => $groupedProducts]);
    }
    // Total Page
    public function total()
    {
        $user_id = Auth::id();
        $data1 = DB::table('purchases')->select('userid')->where('userid','=',$user_id)->get();

        $products = DB::table('products')->select('userid','producttype','productamount')->where('userid','=',$user_id)->get();

        $totalWeight = 0;
        $totalCount = 0;
        foreach ($products as $product) {
            if ($product->producttype == 'weight') {
                $totalWeight += $product->productamount;
                $totalCount++;
            } else if ($product->producttype == 'amount') {
                $totalCount += $product->productamount;
            }
        }

        $data3 = DB::table('products')->select(DB::raw('SUM(total) as total'))->where('userid','=',$user_id)->first();

        $count1 = $data1->count();
        $count2 = $totalCount;
        $count3 = $data3 ? $data3->total ?? "0.00" : "0.00";

        $total = $count1 + $count2 + $count3;

        return view('Total', ['Count1' => $count1, 'Count2' => $count2, 'Count3' => $count3, 'Total' => $total]);
    }
    public function profile()
    {
        return view('Settings');
    }
}
