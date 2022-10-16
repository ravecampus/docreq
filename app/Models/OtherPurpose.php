<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPurpose extends Model
{
    use HasFactory;
    protected $table = 'other_purpose';
    protected $fillable = ['order_id', 'description'];
}
