<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;

class TypeShip extends Model
{
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

     public function role()
     {
         return $this->hasOne(Role::class, 'id', 'role_id');
     }
     
     protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->uuid = Uuid::uuid4()->toString();
         });
     }
}
