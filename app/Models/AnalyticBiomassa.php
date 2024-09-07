<?php

namespace App\Models;

use App\Models\BiomassaContract;
use Illuminate\Database\Eloquent\Model;

class AnalyticBiomassa extends Model
{
    protected $guarded = ['id'];

    public function contract()
    {
        return $this->hasOne(BiomassaContract::class, 'id', 'contract_id');
    }
}
