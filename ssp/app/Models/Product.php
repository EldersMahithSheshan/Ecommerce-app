<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait

class Product extends Model
{
    use HasFactory, SoftDeletes; // Use SoftDeletes trait

    protected $fillable = [
        'title',
        'price',
        'product_code',
        'description',
        'category',
        'quantity',
        'location',    // Add location
        'attributes',  // Add attributes
    ];

    protected $casts = [
        'attributes' => 'array', // Cast attributes to an array for easy access
    ];
}
