<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPurpose extends Model
{
    use HasFactory;

    protected $table = 'item_purpose';
    protected $fillable = ['pupose_id', 'item_id'];
}
