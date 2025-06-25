<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'due_date', 'end_date', 'description', 'status'];

    public const STATUS_IMPLEMENTING = 'implementing';
    public const STATUS_DONE = 'done';

    protected $casts = [
    'due_date' => 'date:Y-m-d',
    'end_date' => 'date:Y-m-d',
];

}
