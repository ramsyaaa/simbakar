<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Models\CoalUnloading;
use Illuminate\Database\Eloquent\Model;

class Tug extends Model
{
    protected $guarded = ['id'];

    public function coal()
    {
        return $this->hasOne(CoalUnloading::class, 'id', 'coal_unloading_id');
    }
    
}
