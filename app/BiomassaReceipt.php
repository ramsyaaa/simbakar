<?php

namespace App;

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

    public function unloadingBiomassa()
    {
        return $this->hasMany(DetailUnloadingBiomassaReceipt::class, "biomassa_receipt_id", 'id');
    }
}
