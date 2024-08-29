<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalyticBefore extends Model
{
    // Tentukan nama tabel yang digunakan model ini
    protected $table = 'analytic_befores';

    // Jika tabel tidak memiliki kolom 'created_at' dan 'updated_at', tambahkan ini:
    public $timestamps = false;

    // Tambahkan properti fillable atau guarded sesuai kebutuhan
    protected $fillable = [
        'analysis_number',
        'analysis_date',
        'density',
        'spesific_gravity',
        'kinematic_viscosity',
        'sulfur_content',
        'flash_point',
        'pour_point',
        'carbon_residu',
        'water_content',
        'fame_content',
        'ash_content',
        'sediment_content',
        'calorific_value',
        'sodium',
        'potassium',
        'vanadium',
    ];
}
