<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DockEquipmentList extends Model
{
    protected $fillable = [
        'dock_equipment_uuid',
        'dock_uuid'
    ];
}
