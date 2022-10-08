<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";
    protected $fillable = [
        'user_id',
        'full_name',
        'mobile_number',
        'delivery_address',
        'trucking_number',
        'delivery_fee',
        'total',
        'grand_total',
        'delivery_option',
        // 'other_info',
        'status'
    ];

    public function client()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }


    public function order_items(){
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function purpose(){
        return $this->hasMany(ItemUserPurpose::class, 'order_id', 'id');
    }

    
}
