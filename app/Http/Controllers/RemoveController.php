<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Purchases;
use App\Models\UsedProducts;

class RemoveController extends Controller
{
    public function removeData($id)
    {
        $record = Purchases::find($id);
        $record2 = Products::find($id);
        $record3 = UsedProducts::find($id);

        $record->delete();
        $record2->delete();
        $record3->delete();

        return redirect()->back();
    }
}
