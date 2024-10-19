<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'quantity'];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];
}
