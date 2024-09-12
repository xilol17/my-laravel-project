<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UpdateHistory;
use Illuminate\Support\Facades\Auth;

class project extends Model
{
    use HasFactory;

    protected $table = 'project';

    public function sales() {

        return $this->belongsTo(Sales::class);
    }
    protected $guarded = [];

    public function views()
    {
        return $this->hasMany(ProjectView::class);
    }

    public function updateHistories()
    {
        return $this->hasMany(UpdateHistory::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function remarks(){
        return $this->hasMany(remark::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($project) {
            $original = $project->getOriginal();

            foreach ($project->getDirty() as $attribute => $newValue) {
                // Use null coalescing operator to handle missing keys
                $oldValue = $original[$attribute] ?? '';

                if ($oldValue != $newValue && $attribute != 'lastUpdateDate') {

                    if ($attribute == 'revenue'){
                        $title = 'Updated Revenue';
                    }elseif($attribute == 'winRate'){
                        $title = 'Updated Win Rate';
                    }elseif($attribute == 'SO'){
                        $title = 'Updated SO Number';
                    }elseif($attribute == 'visitDate'){
                        $title = 'Updated ASSC Visit Date';
                    }elseif($attribute == 'disStartDate'){
                        $title = 'Updated Discusstion Start Date';
                    }elseif($attribute == 'turnKey'){
                        $title = 'Updated Turn Key';
                    }elseif($attribute == 'status'){
                        $title = 'Updated Status';
                    }elseif($attribute == 'BDMPM'){
                        $title = 'Updated BDM/PM';
                    }elseif($attribute == 'region'){
                        $title = 'Updated Region';
                    }elseif($attribute == 'customerName'){
                        $title = 'Updated Customer Name';
                    }elseif($attribute == 'products' || $attribute == 'other_product'){
                        $title = 'Updated Products';
                    }elseif($attribute == 'SIname' || $attribute == 'other_product'){
                        $title = 'Updated SI Name';
                    }else{
                        //SI
                        $title = 'Updated SI';
                    }

                    \App\Models\UpdateHistory::create([
                        'project_id' => $project->id,
                        'user_id' => Auth::id(),
                        'attribute' => $attribute,
                        'title' => $title,
                        'update_type' => 'update',
                        'old_value' => $oldValue,
                        'new_value' => $newValue,
                    ]);
                }
            }
        });
    }

}
