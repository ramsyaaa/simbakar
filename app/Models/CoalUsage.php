<?php

namespace App\Models;

use App\Unit;
use Illuminate\Database\Eloquent\Model;

class CoalUsage extends Model
{
    protected $guarded = ['id'];

    public function unit()
    {
        return $this->hasOne(Unit::class, "id", 'unit_id');
    }

}
