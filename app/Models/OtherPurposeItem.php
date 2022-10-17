<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPurposeItem extends Model
{
    use HasFactory;
    protected $table = 'other_purpose_item';
    protected $fillable = ['order_id', 'item_id'];
}
