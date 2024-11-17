<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'name',
        'price',
        'qty',
        'image',
        'pro_id',
        'user_id',
        'subtotal',
    ];

    public $timestamps = true;
}
