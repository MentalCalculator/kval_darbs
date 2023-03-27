<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    use HasFactory;

    protected $table = 'pirkumi';
    protected $fillable = ['$id','$userid','$created_at','$updated_at'];
}
