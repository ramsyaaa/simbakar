<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdendumSpesificationContractCoal;

class AdendumCoalContract extends Model
{
    protected $guarded = ['id'];

    public function spesifications()
    {
        return $this->hasMany(AdendumSpesificationContractCoal::class, "adendum_id", 'id');
    }
    public function spesification()
    {
        return $this->hasOne(AdendumSpesificationContractCoal::class, "adendum_id", 'id');
    }

    protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->uuid = Uuid::uuid4()->toString();
         });
     }
}
