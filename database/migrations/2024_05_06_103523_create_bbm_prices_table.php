<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbmPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbm_prices', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->date('start_date')->nullable();
            $table->string('bbm_type')->nullable();
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
        Schema::dropIfExists('bbm_prices');
    }
}
