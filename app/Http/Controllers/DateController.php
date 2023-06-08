<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DateController extends Controller
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

    public function purchasesdate(Request $request)
    {
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');

        $user_id = Auth::id();
        $purchases = DB::table('purchases')
            ->select('id', 'created_at')
            ->where('userid', '=', $user_id)
            ->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])
            ->get();

        $data = [];
        $totalSums = [];
        foreach ($purchases as $p) {
            $purchase_id = $p->id;
            $products = DB::table('products')
                ->select('id', 'purchaseid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
                ->where('userid', '=', $user_id)
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

        return view('Home', compact('data', 'purchases', 'totalSums'));
    }

    public function productsdate(Request $request)
    {
        // Identifies the Date input.
        $user_id = Auth::id();
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');

        // Calls data from the tables.
        $usedproducts = DB::table('products')
            ->select('id', 'purchaseid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
            ->where('userid', '=', $user_id)
            ->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])
            ->get();

        $groupedProducts = $usedproducts->groupBy(function($product) {
            return $product->productname . '-' . $product->producttype . '-' . $product->productprice;
        });

        foreach ($groupedProducts as $group => $products) {
            $totalSum = $products->sum(function($product) {
                // Convert productamount to float before summing
                return floatval($product->productamount) * $product->productprice;
            });
            $totalAmount = $products->sum('productamount');
            $groupedProducts[$group]->totalSum = number_format($totalSum,2);
            $groupedProducts[$group]->totalAmount = $totalAmount;
        }

        foreach ($usedproducts as $product) {
            $totalSum = number_format($totalSum,2);
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

    public function totalcountdate(Request $request) {

        // Identifies the Date input.
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');

        $user_id = Auth::id();

        $data1 = DB::table('purchases')->select('userid','created_at')->where('userid','=',$user_id)->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])->get();
        $products = DB::table('products')->select('userid','producttype','productamount','created_at')->where('userid','=',$user_id)->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])->get();

        // Mathematically counts the equations.
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

        $data3 = DB::table('products')->select(DB::raw('SUM(total) as total'))->where('userid','=',$user_id)->whereBetween('created_at', [$startdate . ' 00:00:00', $enddate . ' 23:59:59'])->first();

        $count1 = $data1->count();
        $count2 = $totalCount;
        $count3 = $data3 ? $data3->total ?? "0.00" : "0.00";

        $total = $count1 + $count2 + $count3;

        // Sends out the data to the view (page).
        return view('Total', ['Count1' => $count1, 'Count2' => $count2, 'Count3' => $count3, 'Total' => $total]);
    }
}
