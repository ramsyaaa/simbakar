<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaborsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labors', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_uuid')->nunllable();
            $table->string('ship_uuid')->nunllable();
            $table->string('analysis_number')->nullable();
            $table->date('analysis_date')->nullable();
            $table->datetime('start_unloading')->nullable();
            $table->datetime('end_unloading')->nullable();
            $table->string('moisture_total')->nullable();
            $table->string('ash')->nullable();
            $table->string('fixed_carbon')->nullable();
            $table->string('calorivic_value')->nullable();
            $table->string('air_dried_moisture')->nullable();
            $table->string('volatile_matter')->nullable();
            $table->string('total_sulfur')->nullable();
            $table->string('carbon')->nullable();
            $table->string('nitrogen')->nullable();
            $table->string('hydrogen')->nullable();
            $table->string('oxygen')->nullable();
            $table->string('initial_deformation')->nullable();
            $table->string('hemispherical')->nullable();
            $table->string('softening')->nullable();
            $table->string('fluid')->nullable();
            $table->string('sio2')->nullable();
            $table->string('fe2o3')->nullable();
            $table->string('mgo')->nullable();
            $table->string('k2o')->nullable();
            $table->string('so3')->nullable();
            $table->string('mn3o4')->nullable();
            $table->string('al2o3')->nullable();
            $table->string('cao')->nullable();
            $table->string('na2o')->nullable();
            $table->string('tlo2')->nullable();
            $table->string('p2o5')->nullable();
            $table->string('butiran_70')->nullable();
            $table->string('butiran_50')->nullable();
            $table->string('butiran_32')->nullable();
            $table->string('butiran_32_50')->nullable();
            $table->string('butiran_238')->nullable();
            $table->string('hgi')->nullable();
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
        Schema::dropIfExists('labors');
    }
}
