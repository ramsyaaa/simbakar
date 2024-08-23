<?php

namespace App;

use App\Surveyor;
use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    public $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, "supplier_uuid", 'uuid');
    }

    public function ship()
    {
        return $this->belongsTo(Ship::class, "ship_uuid", 'uuid');
    }
    
    public function surveyor()
    {
        return $this->belongsTo(Surveyor::class, "surveyor_uuid", 'uuid');
    }
}
