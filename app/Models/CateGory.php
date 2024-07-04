<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateGory extends Model
{
    use HasFactory;

    protected $table = 'cate_gories';

    protected $fillable = [
        'name',
        'slug',
        'describe',
        'action',
    ];
}
