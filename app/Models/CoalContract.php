<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\SpesificationContractCoal;

class CoalContract extends Model
{
    protected $guarded = ['id'];

    public function spesifications()
    {
        return $this->hasMany(SpesificationContractCoal::class, "contract_id", 'id');
    }
    public function spesification()
    {
        return $this->hasOne(SpesificationContractCoal::class, "contract_id", 'id');
    }

    protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->uuid = Uuid::uuid4()->toString();
         });
     }
}
