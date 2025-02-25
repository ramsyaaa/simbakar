<?php

namespace App;

use App\Models\HeadWarehouse;
use App\Models\UserInspection;
use App\Models\BbmBookContract;
use App\Models\AnalyticBiomassa;
use Illuminate\Database\Eloquent\Model;

class BiomassaReceipt extends Model
{
    public $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, "main_supplier_uuid", 'uuid');
    }

    public function detailReceipt()
    {
        return $this->hasMany(DetailBiomassaReceipt::class, "biomassa_receipt_id", 'id');
    }

    public function analysis(){
        return $this->hasMany(AnalyticBiomassa::class, "biomassa_receipt_id", 'id');
    }
    public function unloadingBiomassa()
    {
        return $this->hasMany(DetailUnloadingBiomassaReceipt::class, "biomassa_receipt_id", 'id');
    }

  
}
