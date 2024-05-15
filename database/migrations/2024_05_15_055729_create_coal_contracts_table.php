<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoalContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coal_contracts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable;
            $table->string('supplier_uuid')->references('uuid')->on('suppliers')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('name');
            $table->date('number_contract')->nullable();
            $table->string('type_contract')->nullable();
            $table->integer('total_volume')->nullable();
            $table->decimal('price',20,2)->nullable();
            $table->date('contact_start_date')->nullable();
            $table->date('contact_end_date')->nullable();
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
        Schema::dropIfExists('coal_contracts');
    }
}
