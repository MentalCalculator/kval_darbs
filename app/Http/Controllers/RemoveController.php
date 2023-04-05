<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Purchases;
use App\Models\UsedProducts;

class RemoveController extends Controller
{
    public function removeData($id)
    {

        // Delete the purchase from the database
        DB::table('purchases')->where('id', $id)->delete();

        // Redirect back to the homepage
        return redirect()->route('home');
    }
}
