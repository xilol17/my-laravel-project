<?php

// app/Models/Attachment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(project::class);
    }
}
