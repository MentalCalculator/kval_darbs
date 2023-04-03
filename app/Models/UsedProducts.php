<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedProducts extends Model
{
    protected $table = 'usedproducts';
    protected $fillable = ['$id','$userid','$productname','$productprice','$productamount','producttype','$created_at','$updated_at'];
}
