<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class myOrder extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'orderDate',
        'paymentStatus',
        'userID',
        'amount'
    ];
}
