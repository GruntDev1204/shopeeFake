<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
    use HasFactory;

    protected $table = 'Ware_houses';

    protected $fillable = [
        'codeProduct',
        'QuanTity',
        'TotalPrice',
    ];
}
