<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'admin';
    public function project()
    {
        return $this->belongsTo(project::class);
    }
}
