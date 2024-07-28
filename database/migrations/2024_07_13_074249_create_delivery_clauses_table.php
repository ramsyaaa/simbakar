<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryClausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_clauses', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('month', 100)->nullable();
            $table->string('year', 100)->nullable();
            $table->integer('load')->nullable();
            $table->integer('rakor')->nullable();
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
        Schema::dropIfExists('delivery_clauses');
    }
}
