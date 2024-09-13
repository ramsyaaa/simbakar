<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpesificationContractsBiomassasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spesification_contracts_biomassas', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id')->nullable();
            $table->text('identification_spesification')->nullable();
            $table->integer('price')->nullable();
            $table->integer('exchange_rate')->nullable();
            $table->float('total_moisure_min')->nullable();
            $table->float('total_moisure_max')->nullable();
            $table->float('total_moisure_typical')->nullable();
            $table->float('moisure_in_analysis_min')->nullable();
            $table->float('moisure_in_analysis_max')->nullable();
            $table->float('moisure_in_analysis_typical')->nullable();
            $table->float('calorivic_value_min')->nullable();
            $table->float('calorivic_value_max')->nullable();
            $table->float('calorivic_value_typical')->nullable();
            $table->float('size_distribution_min')->nullable();
            $table->float('size_distribution_max')->nullable();
            $table->float('size_distribution_typical')->nullable();
            $table->float('retained_5_min')->nullable();
            $table->float('retained_5_max')->nullable();
            $table->float('retained_5_typical')->nullable();
            $table->float('retained_238_min')->nullable();
            $table->float('retained_238_max')->nullable();
            $table->float('retained_238_typical')->nullable();
            $table->float('passing_238_min')->nullable();
            $table->float('passing_238_max')->nullable();
            $table->float('passing_238_typical')->nullable();
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
        Schema::dropIfExists('spesification_contracts_biomassas');
    }
}
