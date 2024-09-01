<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BiomassaUsage extends Model
{
    protected $guarded = ['id'];

    public function unit()
    {
        return $this->hasOne(Unit::class, "id", 'unit_id');
    }
}
