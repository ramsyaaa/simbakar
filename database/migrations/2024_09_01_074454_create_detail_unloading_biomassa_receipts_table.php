<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailUnloadingBiomassaReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_unloading_biomassa_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biomassa_receipt_id')->nullable();
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->date("date_unloading")->nullable();
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
        Schema::dropIfExists('detail_unloading_biomassa_receipts');
    }
}
