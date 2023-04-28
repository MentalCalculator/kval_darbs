<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminSearchController extends Controller
{
    public function adminpurchasesearchid(Request $request)
    {
        $search = $request->input('search');

        $purchases = DB::table('purchases')
            ->select('id','userid','created_at')
            ->where('id', 'LIKE', '%'.$search.'%')
            ->get();

        $data = [];
        foreach ($purchases as $p) {
            $purchase_id = $p->id;
            $products = DB::table('products')
                ->select('id', 'purchaseid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
                ->where('purchaseid', '=', $purchase_id)
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

        return view('adminpurchases', compact('data', 'purchases'));
    }

    public function adminpurchasesearchuserid(Request $request)
    {
        $search = $request->input('search');

        $purchases = DB::table('purchases')
            ->select('id','userid','created_at')
            ->where('userid', 'LIKE', '%'.$search.'%')
            ->get();

        $data = [];
        foreach ($purchases as $p) {
            $purchase_id = $p->id;
            $products = DB::table('products')
                ->select('id', 'purchaseid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
                ->where('purchaseid', '=', $purchase_id)
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

        return view('adminpurchases', compact('data', 'purchases'));
    }

    public function adminproductssearchname(Request $request)
    {
        $search = $request->input('search');

        $usedproducts = DB::table('usedproducts')
            ->select('userid','id', 'mainproductid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
            ->where('productname', 'LIKE', '%'. $search .'%')
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

    public function adminproductssearchuserid(Request $request)
    {
        $search = $request->input('search');

        $usedproducts = DB::table('usedproducts')
            ->select('userid','id', 'mainproductid', 'created_at', 'productname', 'productprice', 'productamount', 'producttype', 'total')
            ->where('userid', 'LIKE', '%'. $search .'%')
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

    public function adminusersearchID(Request $request)
    {
        $search = $request->input('search');

        $users = DB::table('users')
            ->select('id','name','email','password', 'created_at','is_admin')
            ->where('is_admin','=',false)
            ->where('id', 'LIKE', '%'. $search .'%')
            ->get();

        return view('adminusers', compact('users'));
    }
    public function adminusersearchname(Request $request)
    {
        $search = $request->input('search');

        $users = DB::table('users')
            ->select('id','name','email','password', 'created_at','is_admin')
            ->where('is_admin','=',false)
            ->where('name', 'LIKE', '%'. $search .'%')
            ->get();

        return view('adminusers', compact('users'));
    }
}
