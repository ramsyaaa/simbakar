<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoalUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coal_usages', function (Blueprint $table) {
            $table->id();
            $table->string('tug_9_number')->nullable();
            $table->date('usage_date')->nullable();
            $table->bigInteger('amount_use')->nullable();
            $table->integer('unit_id')->nullable();
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
        Schema::dropIfExists('coal_usages');
    }
}
