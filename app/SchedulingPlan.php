<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchedulingPlan extends Model
{
    public $guarded = [];

    public function ship(){
        return $this->belongsTo(Ship::class, "ship_id", 'id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, "supplier_id", 'id');
    }
}
