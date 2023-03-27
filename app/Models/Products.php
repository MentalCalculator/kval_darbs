<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'produkti';
    protected $fillable = ['$id','$userid','pirkumsid','$nosaukums','$cena','$skaits','$total','$created_at','$updated_at'];
}
