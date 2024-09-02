<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBiomassaReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_biomassa_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biomassa_receipt_id')->nullable();
            $table->string('supplier_uuid')->nullable();
            $table->string('volume')->nullable();
            $table->string('number_of_shipper')->nullable();
            $table->date("date_shipment")->nullable();
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
        Schema::dropIfExists('detail_biomassa_receipts');
    }
}
