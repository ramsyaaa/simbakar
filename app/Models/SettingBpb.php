<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class SettingBpb extends Model
{
    protected $fillable = [
        'year',
        'last_bpb_coal',
        'last_bpb_solar',
        'last_bpb_residu',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
