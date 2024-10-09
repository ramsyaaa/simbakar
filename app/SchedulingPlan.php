<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchedulingPlan extends Model
{
    public $guarded = [];

    public function ship(){
        return $this->belongsTo(Ship::class, "ship_id", 'id');
    }
}
