<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyticBiomassasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytic_biomassas', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id')->nullable();
            $table->integer('sub_supplier_id')->nullable();
            $table->string('analysis_number')->nullable();
            $table->date('analysis_date')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->bigInteger('tonage')->nullable();
            $table->float('total_moisure')->nullable();
            $table->float('moisure_in_analysis')->nullable();
            $table->float('calorivic_value')->nullable();
            $table->float('size_distribution')->nullable();
            $table->float('retained_5')->nullable();
            $table->float('retained_238')->nullable();
            $table->float('passing_238')->nullable();
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
        Schema::dropIfExists('analytic_biomassas');
    }
}
