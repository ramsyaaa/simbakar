<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Models\UnitPenalty;
use Illuminate\Database\Eloquent\Model;

class BiomassaAdjusmentClause extends Model
{
    protected $guarded = ['id'];
    protected $table = 'biomassa_adjusment_clauses';


    public function unit()
    {
        return $this->hasOne(UnitPenalty::class, "id", 'unit_penalty_id');
    }
}
