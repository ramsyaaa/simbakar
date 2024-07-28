<?php

namespace App;

use App\Models\CoalContract;
use Illuminate\Database\Eloquent\Model;

class Preloadinng extends Model
{
    public $guarded = [];

    public function contract()
    {
        return $this->belongsTo(CoalContract::class, "contract_uuid", 'uuid');
    }
}
