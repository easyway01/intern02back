<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 可填写的字段
    protected $fillable = ['name', 'description', 'image', 'category_id'];
}

