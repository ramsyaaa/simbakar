<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdendumSpesficationContractCoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adendum_spesfication_contract_coals', function (Blueprint $table) {
            $table->id();
            $table->integer('adendum_id')->nullable();
            $table->integer('contract_id')->nullable();
            $table->text('identification_spesification')->nullable();
            $table->integer('price')->nullable();
            $table->integer('exchange_rate')->nullable();
            $table->float('total_moisure_min')->nullable();
            $table->float('total_moisure_max')->nullable();
            $table->float('total_moisure_typical')->nullable();
            $table->float('air_dried_moisure_min')->nullable();
            $table->float('air_dried_moisure_max')->nullable();
            $table->float('air_dried_moisure_typical')->nullable();
            $table->float('ash_min')->nullable();
            $table->float('ash_max')->nullable();
            $table->float('ash_typical')->nullable();
            $table->float('volatile_matter_min')->nullable();
            $table->float('volatile_matter_max')->nullable();
            $table->float('volatile_matter_typical')->nullable();
            $table->float('fixed_carbon_min')->nullable();
            $table->float('fixed_carbon_max')->nullable();
            $table->float('fixed_carbon_typical')->nullable();
            $table->float('calorivic_value_min')->nullable();
            $table->float('calorivic_value_max')->nullable();
            $table->float('calorivic_value_typical')->nullable();
            $table->float('carbon_min')->nullable();
            $table->float('carbon_max')->nullable();
            $table->float('carbon_typical')->nullable();
            $table->float('nitrogen_min')->nullable();
            $table->float('nitrogen_max')->nullable();
            $table->float('nitrogen_typical')->nullable();
            $table->float('hydrogen_min')->nullable();
            $table->float('hydrogen_max')->nullable();
            $table->float('hydrogen_typical')->nullable();
            $table->float('oxygen_min')->nullable();
            $table->float('oxygen_max')->nullable();
            $table->float('oxygen_typical')->nullable();
            $table->float('initial_deformation_min')->nullable();
            $table->float('initial_deformation_max')->nullable();
            $table->float('initial_deformation_typical')->nullable();
            $table->float('softening_min')->nullable();
            $table->float('softening_max')->nullable();
            $table->float('softening_typical')->nullable();
            $table->float('hemispherical_min')->nullable();
            $table->float('hemispherical_max')->nullable();
            $table->float('hemispherical_typical')->nullable();
            $table->float('fluid_min')->nullable();
            $table->float('fluid_max')->nullable();
            $table->float('fluid_typical')->nullable();
            $table->float('sio2_min')->nullable();
            $table->float('sio2_max')->nullable();
            $table->float('sio2_typical')->nullable();
            $table->float('fe2o3_min')->nullable();
            $table->float('fe2o3_max')->nullable();
            $table->float('fe2o3_typical')->nullable();
            $table->float('mgo_min')->nullable();
            $table->float('mgo_max')->nullable();
            $table->float('mgo_typical')->nullable();
            $table->float('k2o_min')->nullable();
            $table->float('k2o_max')->nullable();
            $table->float('k2o_typical')->nullable();
            $table->float('so3_min')->nullable();
            $table->float('so3_max')->nullable();
            $table->float('so3_typical')->nullable();
            $table->float('mno4_min')->nullable();
            $table->float('mno4_max')->nullable();
            $table->float('mno4_typical')->nullable();
            $table->float('al2o3_min')->nullable();
            $table->float('al2o3_max')->nullable();
            $table->float('al2o3_typical')->nullable();
            $table->float('cao_min')->nullable();
            $table->float('cao_max')->nullable();
            $table->float('cao_typical')->nullable();
            $table->float('na2o_min')->nullable();
            $table->float('na2o_max')->nullable();
            $table->float('na2o_typical')->nullable();
            $table->float('tlo2_min')->nullable();
            $table->float('tlo2_max')->nullable();
            $table->float('tlo2_typical')->nullable();
            $table->float('p2o5_min')->nullable();
            $table->float('p2o5_max')->nullable();
            $table->float('p2o5_typical')->nullable();
            $table->float('butiran_70_min')->nullable();
            $table->float('butiran_70_max')->nullable();
            $table->float('butiran_70_typical')->nullable();
            $table->float('butiran_50_min')->nullable();
            $table->float('butiran_50_max')->nullable();
            $table->float('butiran_50_typical')->nullable();
            $table->float('butiran_32_50_min')->nullable();
            $table->float('butiran_32_50_max')->nullable();
            $table->float('butiran_32_50_typical')->nullable();
            $table->float('butiran_32_min')->nullable();
            $table->float('butiran_32_max')->nullable();
            $table->float('butiran_32_typical')->nullable();
            $table->float('butiran_238_min')->nullable();
            $table->float('butiran_238_max')->nullable();
            $table->float('butiran_238_typical')->nullable();
            $table->float('hgi_min')->nullable();
            $table->float('hgi_max')->nullable();
            $table->float('hgi_typical')->nullable();
            $table->string('stagging_potensial')->nullable();
            $table->string('fouling_potensial')->nullable();
            $table->string('stagging_index')->nullable();
            $table->string('fouling_index')->nullable();
            $table->uuid('uuid')->unique()->nullable();
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
        Schema::dropIfExists('adendum_spesfication_contract_coals');
    }
}
