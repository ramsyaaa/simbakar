<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefusalPenaltyClausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refusal_penalty_clauses', function (Blueprint $table) {
            $table->id();
            $table->string('penalty_will_get_if_sign', 100)->nullable();
            $table->string('penalty_will_get_if_parameter', 100)->nullable();
            $table->float('penalty_will_get_if_number')->nullable();
            $table->string('penalty_price_type_number', 100)->nullable();
            $table->float('penalty_price_number')->nullable();
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
        Schema::dropIfExists('refusal_penalty_clauses');
    }
}
