<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdendumRefusalPenaltyClausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adendum_refusal_penalty_clauses', function (Blueprint $table) {
            $table->id();
            $table->integer('adendum_id')->nullable();
            $table->integer('contract_id')->nullable();
            $table->string('penalty_will_get_if_sign', 100)->nullable();
            $table->string('penalty_will_get_if_parameter', 100)->nullable();
            $table->float('penalty_will_get_if_number')->nullable();
            $table->string('penalty_price_type_number', 100)->nullable();
            $table->float('penalty_price_number')->nullable();
            $table->integer('unit_penalty_id')->nullable();
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
        Schema::dropIfExists('adendum_refusal_penalty_clauses');
    }
}
