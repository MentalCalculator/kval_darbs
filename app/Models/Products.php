<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = ['$id','$userid','purchaseid','$productname','$productprice','$productamount','producttype','$total','$created_at','$updated_at'];
}
