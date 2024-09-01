<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiomassaReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biomassa_receipts', function (Blueprint $table) {
            $table->id();

            $table->string('bpb_number')->nullable();
            $table->string('faktur_number')->nullable();
            $table->string('note')->nullable();
            $table->string('main_supplier_uuid')->nullable();
            $table->string('tug3_number')->nullable();
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
        Schema::dropIfExists('biomassa_receipts');
    }
}
