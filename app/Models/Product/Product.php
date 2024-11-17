<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';


    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'exp_date',
        'category_id',
    ];

    public $timestamps = true;
}
