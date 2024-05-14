<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class YearStartData extends Model
{
    protected $fillable = [
        'setting_bpb_uuid',
        'type',
        'planning',
        'actual',
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
