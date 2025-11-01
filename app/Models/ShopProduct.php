<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'is_active',
    ];
}
