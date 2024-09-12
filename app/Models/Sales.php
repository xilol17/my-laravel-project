<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected $table = 'sales';

    public function user()
    {
        return $this->belongsTo(User::class); // A user has one admin account (for admins)
    }
}
