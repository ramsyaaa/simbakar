<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjusmentClausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjusment_clauses', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id')->nullable();
            $table->string('price_coal_will_text', 100)->nullable();
            $table->float('price_coal_will_number')->nullable();
            $table->string('price_coal_will_type_number', 100)->nullable();
            $table->string('for_will_text', 100)->nullable();
            $table->string('for_will_parameter', 100)->nullable();
            $table->float('for_will_number')->nullable();
            $table->string('for_will_type_number', 100)->nullable();
            $table->string('with_limit_text', 100)->nullable();
            $table->string('with_limit_number', 100)->nullable();
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
        Schema::dropIfExists('adjusment_clauses');
    }
}
