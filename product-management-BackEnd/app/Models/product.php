<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product-name',
        'quantity',
        'price',
        'quality',
        'expiration-date',
        'sales',
        'image'
    ];
    
}
