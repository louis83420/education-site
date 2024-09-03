<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 允許批量賦值的字段
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];
}
