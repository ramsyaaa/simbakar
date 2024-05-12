<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class HeavyEquipment extends Model
{
    protected $fillable = [
        'uuid',
        'heavy_equipment_type_uuid',
        'name',
    ];

    public function heavyEquipmentType()
    {
        return $this->belongsTo(HeavyEquipmentType::class, "heavy_equipment_type_uuid", 'uuid');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
