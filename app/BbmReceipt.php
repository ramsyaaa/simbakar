<?php

namespace App;

use App\ShipAgent;
use Illuminate\Database\Eloquent\Model;

class BbmReceipt extends Model
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
    
    public function shipAgent()
    {
        return $this->belongsTo(ShipAgent::class, "ship_agent_uuid", 'uuid');
    }

    public function dockName()
    {
        return $this->belongsTo(Dock::class, "dock", 'uuid');
    }
}
