<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $fillable = [
        'codeInvoices',
        'totalPay',
        'relityPay',
        'status',
        'is_done',
    ];
}
