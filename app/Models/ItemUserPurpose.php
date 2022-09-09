<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemUserPurpose extends Model
{
    use HasFactory;
    protected $table = 'item_user_purpose';
    protected $fillable = ['purpose_id', 'item_id', 'user_id'];
}
