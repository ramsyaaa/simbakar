<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class TypeShip extends Model
{
    public $incrementing = false; // Non-incrementing primary key
     protected $keyType = 'string'; // Primary key type is string
     protected $primaryKey = 'uuid'; // Name of the UUID column

     protected $fillable = [
         'name',
     ];

     /**
      * The attributes that should be cast to native types.
      *
      * @var array
      */
     protected $casts = [
         'email_verified_at' => 'datetime',
     ];

     protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->uuid = Uuid::uuid4()->toString();
         });
     }
}
