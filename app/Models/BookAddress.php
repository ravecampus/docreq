<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAddress extends Model
{
    use HasFactory;

    protected $table = 'book_address';
    protected $fillable = [
        'fullname',
        'mobile_number',
        'note',
        'street',
        'province',
        'city_or_municipality',
        'barangay',
        'deleted',
        'user_id',
    ];
}
