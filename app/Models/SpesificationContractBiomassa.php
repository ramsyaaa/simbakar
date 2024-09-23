<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class SpesificationContractBiomassa extends Model
{
    protected $guarded = ['id'];
    protected $table = 'spesification_contracts_biomassas';

    protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->uuid = Uuid::uuid4()->toString();
         });
     }
}
