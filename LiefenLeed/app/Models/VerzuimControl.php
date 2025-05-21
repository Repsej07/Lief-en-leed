<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerzuimControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'planned_date',
        'status',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// Add this to app/Models/User.php
// Inside the User class, add:
/*
    public function medicalChecks()
    {
        return $this->hasMany(MedicalCheck::class);
    }
*/