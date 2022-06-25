<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
      protected $fillable = [
        'user_id',
        'section_id',
        'action',
    ];

      public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
}
