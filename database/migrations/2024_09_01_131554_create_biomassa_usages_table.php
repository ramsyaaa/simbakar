<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiomassaUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biomassa_usages', function (Blueprint $table) {
            $table->id();
            $table->string('tug_9_number')->nullable();
            $table->date('usage_date')->nullable();
            $table->string('amount_use')->nullable();
            $table->foreignId('unit_id')->nullable();
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
        Schema::dropIfExists('biomassa_usages');
    }
}
