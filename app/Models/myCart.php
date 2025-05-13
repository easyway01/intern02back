<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class myCart extends Model
{
    use HasFactory;
    
// myCart.php
protected $fillable = [
    'productID',
    'quantity',
    'userID',
    'dateAdd',  // ✅ 修正为正确拼写
    'orderID'
];

}
