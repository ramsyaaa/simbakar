<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipUnloaderPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_unloader_prices', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->date('start_date')->nullable();
            $table->integer('price')->nullable();
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
        Schema::dropIfExists('ship_unloader_prices');
    }
}
