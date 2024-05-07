<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class ShipUnloaderPrice extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->uuid = Uuid::uuid4()->toString();
         });
     }
}
