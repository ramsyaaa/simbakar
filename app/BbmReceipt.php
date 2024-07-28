<?php

namespace App;

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

    public function dock()
    {
        return $this->belongsTo(Dock::class, "dock", 'uuid');
    }
}
