<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ShipAgent extends Model
{
    protected $fillable = [
        'load_type_uuid',
        'name',
        'address',
        'phone',
        'fax',
    ];

    public function loadType()
    {
        return $this->belongsTo(LoadType::class, "load_type_uuid", 'uuid');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
