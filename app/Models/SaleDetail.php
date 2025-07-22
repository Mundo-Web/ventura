<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_image',
        'product_name',
        'product_color',
        'checkin',
        'checkout',
        'extras',
        'quantity',
        'price',
        'cantidad_personas',
        'extra_personas',
    ];
}
