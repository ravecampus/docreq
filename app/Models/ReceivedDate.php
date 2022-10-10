<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedDate extends Model
{
    use HasFactory;
    protected $table = 'received_date';
    protected $fillable = ['received_by', 'order_id'];
}
