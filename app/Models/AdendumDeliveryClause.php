<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class AdendumDeliveryClause extends Model
{
    protected $guarded = ['id'];
    protected $table = 'adendum_delivery_clauses';

}
