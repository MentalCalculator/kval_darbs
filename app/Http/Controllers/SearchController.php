<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function purchasessearch(Request $request)
    {
        $search = $request->input('search');

        $user_id = Auth::id();
        $purchases = DB::table('purchases')
            ->select('id','created_at')
            ->where('userid', '=', $user_id)
            ->whereExists(function ($query) use ($user_id, $search) {
                $query->select(DB::raw(1))
                    ->from('products')
                    ->where('userid', '=', $user_id)
                    ->where('products.purchaseid', '=', DB::raw('purchases.id'))
                    ->where('products.productname', 'like', '%' . $search . '%');
            })
            ->get();

        $data = [];
        $totalSums = [];
        foreach ($purchases as $p) {
            $purchase_id = $p->id;
            $products = DB::table('products')
                ->select('id', 'purchaseid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
                ->where('userid', '=', $user_id)
                ->where('purchaseid', '=', $purchase_id)
                ->where('productname', 'like', '%' . $search . '%')
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

    public function productssearch(Request $request)
    {
        $search = $request->input('search');

        $user_id = Auth::id();

        $usedproducts = DB::table('usedproducts')
            ->select('id', 'mainproductid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
            ->where('userid', '=', $user_id)
            ->where('productname','like', '%' . $search . '%')
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
}
