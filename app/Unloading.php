<?php

namespace App;

use App\Models\CoalUnloading;
use Illuminate\Database\Eloquent\Model;

class Unloading extends Model
{
    public $guarded = [];

    public function surveyor()
    {
        return $this->belongsTo(Surveyor::class, "surveyor_uuid", 'uuid');
    }

    public function coal_unloading(){
        return $this->belongsTo(CoalUnloading::class, "coal_unloading_id", 'id');
    }
}
