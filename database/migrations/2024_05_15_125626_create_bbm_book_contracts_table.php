<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbmBookContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbm_book_contracts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable;
            $table->string('order_number')->nullable();
            $table->date('order_date')->nullable();
            $table->integer('total')->nullable();
            $table->integer('alocation_month')->nullable();
            $table->integer('alocation_year')->nullable();
            $table->string('alocation_date')->nullable();
            $table->string('fleet_type')->nullable();
            $table->string('ship_uuid')->references('uuid')->on('ships')->nullable();
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
        Schema::dropIfExists('bbm_book_contracts');
    }
}
