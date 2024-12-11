<?php

namespace App;

use App\Models\TypeShip;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Ship extends Model
{
    protected $fillable = [
        'type_ship_uuid',
        'load_type_uuid',
        'name',
        'year_created',
        'flag',
        'grt',
        'dwt',
        'loa',
        'status',
        'acronym'
    ];

    public function typeShip()
    {
        return $this->belongsTo(TypeShip::class, "type_ship_uuid", 'uuid');
    }

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
