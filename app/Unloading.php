<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unloading extends Model
{
    public $guarded = [];

    public function surveyor()
    {
        return $this->belongsTo(Surveyor::class, "surveyor_uuid", 'uuid');
    }

    public function ship()
    {
        return $this->belongsTo(Ship::class, "ship_uuid", 'uuid');
    }
}
