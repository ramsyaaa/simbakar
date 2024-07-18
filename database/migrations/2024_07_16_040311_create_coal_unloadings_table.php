<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoalUnloadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coal_unloadings', function (Blueprint $table) {
            $table->id();
            $table->integer('analysis_loading_id')->nullable();
            $table->integer('analysis_unloading_id')->nullable();
            $table->integer('analysis_labor_id')->nullable();
            $table->integer('load_company_id')->nullable();
            $table->integer('dock_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('ship_id')->nullable();
            $table->integer('transporter_id')->nullable();
            $table->integer('origin_harbor_id')->nullable();
            $table->integer('destination_harbor_id')->nullable();
            $table->integer('agent_ship_id')->nullable();
            $table->bigInteger('bl')->nullable();
            $table->bigInteger('bw')->nullable();
            $table->string('unit')->nullable();
            $table->timestamp('loading_date')->nullable();
            $table->timestamp('arrived_date')->nullable();
            $table->timestamp('dock_ship_date')->nullable();
            $table->timestamp('unloading_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamp('departure_date')->nullable();
            $table->timestamp('receipt_date')->nullable();
            $table->text('note')->nullable();
            $table->integer('exchange_rate')->nullable();
            $table->string('tug_number')->nullable();
            $table->string('bpb_number')->nullable();
            $table->string('form_part_number')->nullable();
            $table->integer('rob')->nullable();
            $table->string('user_inspection')->nullable();
            $table->string('head_warehouse')->nullable();
            $table->string('kind_contract')->nullable();
            $table->string('captain')->nullable();
            $table->string('kwh_su1_start')->nullable();
            $table->string('kwh_su1_end')->nullable();
            $table->string('kwh_su2_start')->nullable();
            $table->string('kwh_su2_end')->nullable();
            $table->string('kwh_lighting_start')->nullable();
            $table->string('kwh_lighting_end')->nullable();
            $table->string('kwh_conveyor_start')->nullable();
            $table->string('kwh_conveyor_end')->nullable();
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
        Schema::dropIfExists('coal_unloadings');
    }
}
