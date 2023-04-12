<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function purchasessearch(Request $request)
    {
        $inputname = $request->input('search');

        $user_id = Auth::id();
        $purchases = DB::table('purchases')
            ->select('id','created_at')
            ->where('userid', '=', $user_id)
            ->whereExists(function ($query) use ($user_id, $inputname) {
                $query->select(DB::raw(1))
                    ->from('products')
                    ->where('userid', '=', $user_id)
                    ->where('products.purchaseid', '=', DB::raw('purchases.id'))
                    ->where('products.productname', 'like', '%' . $inputname . '%');
            })
            ->get();

        $data = [];
        foreach ($purchases as $p) {
            $purchase_id = $p->id;
            $products = DB::table('products')
                ->select('id', 'purchaseid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
                ->where('userid', '=', $user_id)
                ->where('purchaseid', '=', $purchase_id)
                ->where('productname','=', $inputname)
                ->get();
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
        }

        return view('Home', compact('data', 'purchases'));
    }

    public function productssearch(Request $request)
    {
        $search = $request->input('search');

        $user_id = Auth::id();
        $usedproducts = DB::table('usedproducts')
            ->select('mainid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
            ->where('userid', '=', $user_id)
            ->where('productname', '=', $search)
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
        return view('Products',['products'=>$usedproducts]);
    }
}
