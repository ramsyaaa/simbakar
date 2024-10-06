<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Models\UnitPenalty;
use App\Models\CoalContract;
use App\Models\AdendumCoalContract;
use App\Models\AdendumPenaltyClause;
use App\Models\AdendumDeliveryClause;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdendumSpesificationContractCoal;

class Adendum extends Model
{
    protected $guarded = ['id'];
    protected $table = 'adendums';

    public function contract()
    {
        return $this->hasOne(CoalContract::class, "id", 'contract_id');
    }

    public function contractAdendum()
    {
        return $this->belongsTo(AdendumCoalContract::class, "id", 'adendum_id');
    }

    public function penalties()
    {
        return $this->hasMany(AdendumPenaltyClause::class, "adendum_id", 'id');
    }

    public function deliveries()
    {
        return $this->hasMany(AdendumDeliveryClause::class, "adendum_id", 'id');
    }

    public function spesifications()
    {
        return $this->hasMany(AdendumSpesificationContractCoal::class, "adendum_id", 'id');
    }
    public function spesification()
    {
        return $this->hasOne(AdendumSpesificationContractCoal::class, "id", 'adendum_id');
    }


}
