<?php

namespace App\Models;

use App\Bunkers;
use App\BbmReceipt;
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

    public function bbm()
    {
        return $this->hasOne(BbmReceipt::class, 'id', 'bbm_receipt_id');
    }
    public function bunker()
    {
        return $this->hasOne(Bunkers::class, 'id', 'bunker_id');
    }
    
}
