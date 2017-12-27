<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kronoxSession extends Model
{
    protected $fillable = [
        'MdhUsername', 
        'JSESSIONID',
    ];
}
