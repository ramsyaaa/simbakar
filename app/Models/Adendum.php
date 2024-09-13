<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Models\UnitPenalty;
use Illuminate\Database\Eloquent\Model;

class Adendum extends Model
{
    protected $guarded = ['id'];
    protected $table = 'adendums';

}
