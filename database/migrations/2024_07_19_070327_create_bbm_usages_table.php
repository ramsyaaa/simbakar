<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbmUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbm_usages', function (Blueprint $table) {
            $table->id();
            $table->string('bbm_use_for')->nullable();
            $table->string('unit_uuid')->nullable();
            $table->string('heavy_equipment_uuid')->nullable();
            $table->string('bunker_uuid')->nullable();
            $table->string('bbm_type')->nullable();
            $table->string('tug9_number')->nullable();
            $table->date('use_date')->nullable();
            $table->string('amount')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('bbm_usages');
    }
}
