<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Purchases;
use App\Models\UsedProducts;

class RemoveController extends Controller
{
    public function removepurchase($id)
    {
        // Find the purchase by ID
        $purchase = Purchases::find($id);

        // Delete the purchase and related products
        $purchase->delete();

        // Redirect to the desired page
        return redirect()->back();
    }

    public function removeproduct($id)
    {
        // Find the product by ID
        $product = Products::find($id);
        $usedproduct = UsedProducts::find($id);

        // Delete the product
        $product->delete();
        $usedproduct->delete();

        // Redirect to the desired page
        return redirect()->back();
    }
}
