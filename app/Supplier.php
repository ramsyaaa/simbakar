<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Supplier extends Model
{
    protected $fillable = [
        'load_type_uuid',
        'name',
        'address',
        'phone',
        'fax',
        'mining_authorization',
        'mine_name',
        'mine_location',
        'producer',
        'acronym',
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
