<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedProducts extends Model
{
    use HasFactory;

    protected $table = 'usedproducts';
    protected $fillable = ['id','UsedPurchaseid','$mainproductid','$userid','$productname','$productprice','$productamount','producttype','$created_at','$updated_at'];
}
