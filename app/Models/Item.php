<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s' ,
    'updated_at' => 'datetime:Y-m-d H:i:s' 
    ];
    use HasFactory;
}
