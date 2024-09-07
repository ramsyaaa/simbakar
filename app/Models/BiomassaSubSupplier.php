<?php

namespace App\Models;

use App\Supplier;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class BiomassaSubSupplier extends Model
{
    protected $guarded = ['id'];
    protected $table = 'biomassa_sub_suppliers';

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

}
