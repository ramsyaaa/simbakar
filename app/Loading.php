<?php

namespace App;

use App\Ship;
use App\Surveyor;
use App\Models\CoalContract;
use Illuminate\Database\Eloquent\Model;

class Loading extends Model
{
    public $guarded = [];

    public function contract()
    {
        return $this->belongsTo(CoalContract::class, "contract_uuid", 'uuid');
    }

    public function surveyor()
    {
        return $this->belongsTo(Surveyor::class, "surveyor_uuid", 'uuid');
    }
    
    public function ship()
    {
        return $this->belongsTo(Ship::class, "ship_uuid", 'uuid');
    }
}
