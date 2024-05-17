<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DockInspectionParameterList extends Model
{
    protected $fillable = [
        'dock_inspection_parameter_uuid',
        'dock_uuid'
    ];
}
