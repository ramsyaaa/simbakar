<?php

namespace App\Models;

use App\Supplier;
use Ramsey\Uuid\Uuid;
use App\Models\BiomassaSubSupplier;
use Illuminate\Database\Eloquent\Model;
use App\Models\SpesificationContractBiomassa;

class BiomassaContract extends Model
{
    protected $guarded = ['id'];

    public function spesifications()
    {
        return $this->hasMany(SpesificationContractBiomassa::class, "contract_id", 'id');
    }
    public function subs()
    {
        return $this->hasMany(BiomassaSubSupplier::class, "contract_id", 'id');
    }
    public function spesification()
    {
        return $this->hasOne(SpesificationContractBiomassa::class, "contract_id", 'id');
    }
    
    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
    
    protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->uuid = Uuid::uuid4()->toString();
         });
     }
}
