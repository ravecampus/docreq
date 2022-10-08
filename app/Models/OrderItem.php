<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'item_id',
        'image',
        'item_name',
        'description',
        'quantity',
        'price',
        'note',
        // 'total',
        'status'
    ];

  
}
