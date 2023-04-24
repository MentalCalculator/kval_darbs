<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Purchases;
use App\Models\UsedProducts;

class RemoveController extends Controller
{
    public function removepurchase($id)
    {
        $purchase = Purchases::find($id);

        if ($purchase) {
            // Delete all related products for the purchase
            $products = Products::where('purchaseid', $id)->get();
            foreach ($products as $product) {
                $product->delete();
            }

            // Delete all related used products for the purchase
            $usedproducts = UsedProducts::where('UsedPurchaseid', $id)->get();
            foreach ($usedproducts as $usedproduct) {
                $usedproduct->delete();
            }

            $purchase->delete();

            return redirect()->back();
        } else {
            // Handle case when purchase is not found
            return redirect()->back()->with('error', 'Purchase not found');
        }
    }
    public function removeproduct($id)
    {
        $product = Products::find($id);

        if ($product) {
            $purchaseId = $product->purchaseid;

            // Delete the product
            $product->delete();

            // Check if the purchase has any other products
            $remainingProducts = Products::where('purchaseid', $purchaseId)->count();
            if ($remainingProducts === 0) {
                // If no other products exist for the purchase, delete the purchase as well
                $purchase = Purchases::find($purchaseId);
                if ($purchase) {
                    $purchase->delete();
                }
            }

            // Delete the associated used product
            $usedproduct = UsedProducts::find($id);
            if ($usedproduct) {
                $usedproduct->delete();
            }

            return redirect()->back();
        } else {
            // Handle case when product is not found
            return redirect()->back()->with('error', 'Product not found');
        }
    }

}
