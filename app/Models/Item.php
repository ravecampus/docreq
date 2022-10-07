<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    
    protected $table = 'items';
    protected $fillable = [
        'item_name', 
        'description',
        'request_limit', 
        'price',
        'note',
        'category_id'
    ];

    public function purpose(){
        return $this->hasMany(ItemPurpose::class, 'item_id', 'id')->orderBy('created_at', 'asc');
    }
}
