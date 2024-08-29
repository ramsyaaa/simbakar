<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyticAftersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytic_afters', function (Blueprint $table) {
            $table->id();
            $table->string('analysis_number')->nullable();
            $table->date('analysis_date')->nullable();
            $table->string('density')->nullable();
            $table->string('spesific_gravity')->nullable();
            $table->string('kinematic_viscosity')->nullable();
            $table->string('sulfur_content')->nullable();
            $table->string('flash_point')->nullable();
            $table->string('pour_point')->nullable();
            $table->string('carbon_residu')->nullable();
            $table->string('water_content')->nullable();
            $table->string('fame_content')->nullable();
            $table->string('ash_content')->nullable();
            $table->string('sediment_content')->nullable();
            $table->string('calorific_value')->nullable();
            $table->string('sodium')->nullable();
            $table->string('potassium')->nullable();
            $table->string('vanadium')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analytic_afters');
    }
}
