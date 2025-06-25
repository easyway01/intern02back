<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'due_date',
        'end_date',
        'description',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
        'end_date' => 'date',
    ];
}

