<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gebeurtenissen extends Model
{
    protected $table = 'gebeurtenissen';
    protected $fillable = [
        'id',
        'type',

    ];

    
}
