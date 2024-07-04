<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transports extends Model
{
    use HasFactory;

    protected $table = 'Transports';

    protected $fillable = [
        'Name',
        'UnitCode',
        'price',
        'PerCentPrice',
        'deliveryTime',
        'Rate',
        'total_ratings',
        'rating_count',
        'AvatarPhoto',
    ];
}
