<?php

namespace App\Models;

use App\Dock;
use App\Ship;
use App\Supplier;
use App\LoadingCompany;
use Illuminate\Database\Eloquent\Model;

class CoalUnloading extends Model
{
    protected $guarded = ['id'];

    public function ship()
    {
        return $this->hasOne(Ship::class, 'id', 'ship_id');
    }

    public function company()
    {
        return $this->hasOne(LoadingCompany::class, 'id', 'load_company_id');
    }

    public function dock()
    {
        return $this->hasOne(Dock::class, 'id', 'dock_id');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

}
