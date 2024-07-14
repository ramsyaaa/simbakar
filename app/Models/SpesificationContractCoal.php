<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SpesificationContractCoal extends Model
{
    protected $guarded =['id'];

    protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->uuid = Uuid::uuid4()->toString();
         });
     }
}
