<?php

namespace App;

use App\Models\CoalContract;
use Illuminate\Database\Eloquent\Model;

class Preloadinng extends Model
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
