<?php

namespace App\Models;

use App\Bunkers;
use Illuminate\Database\Eloquent\Model;

class BbmTransfer extends Model
{
    protected $guarded = ['id'];

    public function bunkerSource()
    {
        return $this->hasOne(Bunkers::class, 'id', 'bunker_source_id');
    }
    public function bunkerDestination()
    {
        return $this->hasOne(Bunkers::class, 'id', 'bunker_destination_id');
    }
    
}
