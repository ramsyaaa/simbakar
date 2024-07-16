<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class PenaltyClause extends Model
{
    protected $guarded = ['id'];
    protected $table = 'refusal_penalty_clauses';

}
