<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelAdjusmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_adjusments', function (Blueprint $table) {
            $table->id();
            $table->string('type_fuel')->nullable();
            $table->date('usage_date')->nullable();
            $table->bigInteger('usage_amount')->nullable();
            $table->string('ba_number')->nullable();
            $table->string('type_adjusment')->nullable();
            $table->text('note')->nullable();
            $table->date('tug_in_date')->nullable();
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
        Schema::dropIfExists('fuel_adjusments');
    }
}
