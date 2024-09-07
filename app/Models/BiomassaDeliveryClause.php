<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class BiomassaDeliveryClause extends Model
{
    protected $guarded = ['id'];
    protected $table = 'biomassa_delivery_clauses';

}
