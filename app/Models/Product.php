<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'category_id', 'product_name', 'description', 'price', 'small_quantity', 'medium_quantity', 'large_quantity', 'xlarge_quantity', 'xxlarge_quantity', 'xxxlarge_quantity', 'photo', 'visable_time', 'stauts', 'size_type'];
    protected $table = 'products';
    protected $casts = [
        'photo' => 'array',
    ];
}
