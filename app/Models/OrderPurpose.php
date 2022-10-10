<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPurpose extends Model
{
    use HasFactory;

    protected $table = 'order_purpose';
    protected $fillable = ['user_id', 'purpose_id', 'order_id'];
}
