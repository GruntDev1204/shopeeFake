<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $table = 'products';

    protected $fillable = [
        'cateGoryKey',
        'name',
        'price',
        'promotionalPrice',
        'describe',
        'DetailedDescribe',
        'codeProduct',

        'Rate',
        'total_ratings',
        'rating_count',

        'action',
    ];
}
