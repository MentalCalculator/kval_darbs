<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedProducts extends Model
{
    protected $table = 'UsedProducts';
    protected $fillable = ['$id','$userid','$nosaukums','$cena','$sveramais','sveramaistype','$created_at','$updated_at'];
}
