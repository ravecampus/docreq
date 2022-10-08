<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAddress extends Model
{
    use HasFactory;

    protected $table = 'book_address';
    protected $fillable = [
      
        'first_name',
        'middle_name',
        'last_name',
        'mobile_number',
        'street',
        'province',
        'city_or_municipality',
        'barangay',
        'deleted',
        'user_id',
    ];
}
