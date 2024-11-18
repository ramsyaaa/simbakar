<?php

namespace App\Models;

use App\Ship;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class BbmBookContract extends Model
{
    protected $guarded = ['id'];
    

    public function ship()
    {
        return $this->hasOne(Ship::class, 'uuid', 'ship_uuid');
    }

    public function type_ship()
    {
        return $this->hasOne(TypeShip::class, 'uuid', 'type_ship_uuid');
    }

    protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->uuid = Uuid::uuid4()->toString();
         });
     }
}
