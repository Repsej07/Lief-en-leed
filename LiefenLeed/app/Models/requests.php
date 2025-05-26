<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\type;

class requests extends Model
{
    protected $table = 'requests';
    protected $fillable = [
       'type',
       'Medewerker',
        'name',
        'approved',
        'created_by',
        'comments',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(gebeurtenissen::class);
    }
}
