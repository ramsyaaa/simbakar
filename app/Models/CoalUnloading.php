<?php

namespace App\Models;

use App\Dock;
use App\Ship;
use App\Labor;
use App\Harbor;
use App\Loading;
use App\Supplier;
use App\ShipAgent;
use App\Unloading;
use App\LoadingCompany;
use App\Models\Adendum;
use App\Models\CoalContract;
use App\Models\HeadWarehouse;
use App\Models\UserInspection;
use Illuminate\Database\Eloquent\Model;

class CoalUnloading extends Model
{
    protected $guarded = ['id'];

    public function loading()
    {
        return $this->hasOne(Loading::class, 'id', 'analysis_loading_id');
    }
    public function unloading()
    {
        return $this->hasOne(Unloading::class, 'id', 'analysis_unloading_id');
    }
    public function labor()
    {
        return $this->hasOne(Labor::class, 'id', 'analysis_labor_id');
    }
    public function ship()
    {
        return $this->hasOne(Ship::class, 'id', 'ship_id');
    }

    public function contract()
    {
        return $this->hasOne(CoalContract::class, 'id', 'contract_id');
    }

    public function company()
    {
        return $this->hasOne(LoadingCompany::class, 'id', 'load_company_id');
    }
    public function agent()
    {
        return $this->hasOne(ShipAgent::class, 'id', 'agent_ship_id');
    }

    public function dock()
    {
        return $this->hasOne(Dock::class, 'id', 'dock_id');
    }

    public function originHarbor()
    {
        return $this->hasOne(Harbor::class, 'id', 'origin_harbor_id');
    }

    public function destinationHarbor()
    {
        return $this->hasOne(Harbor::class, 'id', 'destination_harbor_id');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function adendums()
    {
        return $this->hasMany(Adendum::class, "id", 'contract_id');
    }

}
