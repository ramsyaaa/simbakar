<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class DeliveryClause extends Model
{
    protected $guarded = ['id'];
    protected $table = 'delivery_clauses';

}
