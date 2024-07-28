<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BbmUsage extends Model
{
    public $guarded = [];
    public function unit()
    {
        return $this->belongsTo(Unit::class, "unit_uuid", 'uuid');
    }
    public function heavyEquipment()
    {
        return $this->belongsTo(HeavyEquipment::class, "heavy_equipment_uuid	", 'uuid');
    }
}
