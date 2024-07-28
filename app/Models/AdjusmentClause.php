<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class AdjusmentClause extends Model
{
    protected $guarded = ['id'];
    protected $table = 'adjusment_clauses';

}
