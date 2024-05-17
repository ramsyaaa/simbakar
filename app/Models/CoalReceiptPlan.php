<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CoalReceiptPlan extends Model
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
    ];

    public function settingBpb()
    {
        return $this->belongsTo(SettingBpb::class, "setting_bpb_uuid", 'uuid');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
