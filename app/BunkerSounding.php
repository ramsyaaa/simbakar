<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class BunkerSounding extends Model
{
    protected $fillable = [
        'bunker_uuid',
        'meter',
        'centimeter',
        'milimeter',
        'volume',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
