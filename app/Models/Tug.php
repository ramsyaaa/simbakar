<?php

namespace App\Models;

use App\Bunkers;
use App\BbmReceipt;
use Ramsey\Uuid\Uuid;
use App\PersonInCharge;
use App\BiomassaReceipt;
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

    public function biomassa()
    {
        return $this->hasOne(BiomassaReceipt::class, 'id', 'biomassa_receipt_id');
    }

    public function bunker()
    {
        return $this->hasOne(Bunkers::class, 'id', 'bunker_id');
    }
    public function manager()
    {
        return $this->hasOne(PersonInCharge::class, 'id', 'general_manager');
    }
    public function senior()
    {
        return $this->hasOne(PersonInCharge::class, 'id', 'senior_manager');
    }
    
}
