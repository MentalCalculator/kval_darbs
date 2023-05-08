<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AdminController extends Controller
{
    public function purchasedashboard()
    {
            $purchases = DB::table('purchases')
                ->select('id','userid', 'created_at')
                ->get();
            $data = [];
            $totalSums = [];
            foreach ($purchases as $p) {
                $purchase_id = $p->id;
                $products = DB::table('products')
                    ->select('id', 'purchaseid', 'productname', 'productprice', 'productamount', 'producttype', 'total', 'created_at')
                    ->where('purchaseid', '=', $purchase_id)
                    ->get();
                $totalSum = $products->sum('total');
                $totalSum = number_format($totalSum, 2);
                foreach ($products as $product) {
                    if (round($product->productamount) == $product->productamount) {
                        $product->productamount = number_format($product->productamount);
                    } else {
                        $product->productamount = number_format($product->productamount, 3);
                    }
                }
                $data[$purchase_id] = $products;
                $totalSums[$purchase_id] = $totalSum;
            }
            return view('adminpurchases', compact('data', 'purchases', 'totalSums'));
    }

    public function productdashboard()
    {
        $usedproducts = DB::table('usedproducts')
            ->select('userid','id', 'mainproductid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
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

    public function userdashboard()
    {
        $users = DB::table('users')
            ->select('id','name','email','password', 'created_at','is_admin')
            ->where('is_admin','=',false)
            ->where('id','!=',Auth::id())
            ->get();

        return view('adminusers', compact('users'));
    }
}
