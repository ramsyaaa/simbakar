<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ElectricityProduction extends Model
{
    protected $fillable = [
        'setting_bpb_uuid',
        'planning_january',
        'planning_february',
        'planning_march',
        'planning_april',
        'planning_may',
        'planning_june',
        'planning_july',
        'planning_august',
        'planning_september',
        'planning_october',
        'planning_november',
        'planning_december',
        'actual_january',
        'actual_february',
        'actual_march',
        'actual_april',
        'actual_may',
        'actual_june',
        'actual_july',
        'actual_august',
        'actual_september',
        'actual_october',
        'actual_november',
        'actual_december',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
