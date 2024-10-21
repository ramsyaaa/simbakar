<?php

namespace App;

use App\Models\AnalyticBiomassa;
use Illuminate\Database\Eloquent\Model;

class DetailBiomassaReceipt extends Model
{
    public $guarded = [];

    public function analysis()
    {
        return $this->hasOne(AnalyticBiomassa::class, 'sub_supplier_id', 'id');
    }
}
