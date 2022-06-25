<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'name_ar'
    ];

     public function roles()
    {
        return $this->hasMany(Role::class, 'id', 'section_id');
    }
}

