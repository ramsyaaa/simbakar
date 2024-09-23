<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class AdendumSpesificationContractCoal extends Model
{
    protected $guarded = ['id'];
    protected $table = 'adendum_spesification_contract_coals';

    protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->uuid = Uuid::uuid4()->toString();
         });
     }
}
